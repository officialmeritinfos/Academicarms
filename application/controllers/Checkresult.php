<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkresult extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index($page='checkresult')
	{
		$general_settings=$this->Web_model->general_settings();
		$classes=$this->db->select('*')->from('Classes')->where('Status',1)->get();
		$sessions=$this->db->select('*')->from('Session')->where('Status',1)->get();
		$terms=$this->db->select('*')->from('Semester')->where('Status',1)->get();
		$result_type=$this->db->select('*')->from('Result_type')->where('Status',1)->get();
		$data['general_settings']=$general_settings;
		$data['Site_name']=$general_settings->row()->Site_name;
		$data['pagename']='Result Checking Page';
		$data['sessions']=$sessions;
		$data['semesters']=$terms;
		$data['classes']=$classes;
		$data['result_types']=$result_type;
		$this->load->view($page,$data);
	}
	public function Check_result()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('pin', 'Pin Number', 'trim|required|alpha_numeric');
        $this->form_validation->set_rules('serial', 'Serial Code', 'trim|required|alpha_numeric');
        $this->form_validation->set_rules('class', 'Class', 'trim|required|numeric');
        $this->form_validation->set_rules('session', 'Academic Session', 'trim|required|numeric');
        $this->form_validation->set_rules('semester', 'Semester/Term', 'trim|required|numeric');
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('result_typ', 'Result Type', 'trim|numeric');
		if ($this->form_validation->run() == TRUE)
        {
        	$pin_usage=$general_settings->row()->Pin_usage;
        	$serial=html_escape($this->input->post('serial'));
        	$pin=html_escape($this->input->post('pin'));
        	$class=html_escape($this->input->post('class'));
        	$session=html_escape($this->input->post('session'));
        	$semester=html_escape($this->input->post('semester'));
        	$username=html_escape($this->input->post('username'));
        	$result_typ=html_escape($this->input->post('result_typ'));
        	$pin_exists=$this->Web_model->pin_exist($pin);//check if pin exists
        	if ($pin_exists->num_rows() >0) 
        	{
        		$pin_serial_exists=$this->Web_model->serial_pin_exist($pin,$serial);
        		if ($pin_serial_exists->num_rows() >0) 
        		{
        			$pin_id=$pin_serial_exists->row()->Pin_id;
        			$pin_in_use=$this->Web_model->Pin_use($pin_id);
        			//check if pin has been used above the system usage
        			if ($pin_in_use->num_rows()==$pin_usage) 
        			{
        				$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span> This Pin can only be used for a maximum of $pin_usage times.</span></div>");
		        		redirect($page);
        			}
        			else
        			{   
        				$student_exist=$this->Web_model->Student($username);//checking if student exists
        				//checking if student details is true
        				if ($student_exist->num_rows()>0) 
        				{
        					$student_id=$student_exist->row()->Student_id;
        					//Limiting the usage to a single user for a class,an academic session, and a semester/term
        					if ($pin_in_use->num_rows()>0 && $pin_in_use->row()->Student !=$student_id) 
        					{
        						$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Pin has been used by another student.</span></div>");
		        				redirect($page);        					
		        			}
		        			elseif ($pin_in_use->num_rows()>0 && $pin_in_use->row()->Class !=$class) 
		        			{
		        				$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Pin has been used for another Class.</span></div>");
		        				redirect($page); 
		        			}
		        			elseif ($pin_in_use->num_rows()>0 && $pin_in_use->row()->Session !=$session) 
		        			{
		        				$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Pin has been used for another Academic Session.</span></div>");
		        				redirect($page); 
		        			}
		        			elseif ($pin_in_use->num_rows()>0 && $pin_in_use->row()->Term !=$semester) 
		        			{
		        				$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Pin has been used for another Semester/Term.</span></div>");
		        				redirect($page); 
		        			}
		        			else
		        			{
		        				//When all authentication has reulted to true
		        				$result_published=$this->Web_model->result_published($student_id,$class,$semester,$session);
		        				//check if result has been published
		        				if ($result_published->num_rows() >0) 
		        				{
		        					$result_session_data = array('Class'=>$class,'Student'=>$student_id,'Aca_Session'=>$session,'Semester'=>$semester,'Set'=>TRUE,'Result_typ'=>$result_typ);
		        					$result_session=$this->session->set_userdata($result_session_data);
		        					if ($this->session->has_userdata('Set')) 
		        					{
		        						$update_pin_data  = array('Pin_id' =>$pin_id,'Student'=>$student_id,'Class'=>$class,'Term'=>$semester,'Session'=>$session );
		        						$update_pin_usage=$this->Web_model->update_pin_usage($update_pin_data);//insert pin usage record
		        						if ($update_pin_usage==TRUE) 
		        						{
		        							//get pin usage number of rows after each insertion and updating pin status
		        							$pin_usage_now=$this->db->select('*')->from('Pin_usage')->where('Pin_id',$pin_id)->get();
		        							if ($pin_usage_now->num_rows()< $pin_usage) 
		        							{
		        								$pin_status=2;
		        							}
		        							else
		        							{
		        								$pin_status=3;
		        							}
		        							//update pin status
		        							$pin_stat_update=$this->db->set('Status',$pin_status)->where('Pin_id',$pin_id)->update('Result_pins');
		        							//take to result viewing page
		        							if ($pin_stat_update==TRUE) 
		        							{
		        								redirect('checkresult/result_page');
		        							}
		        						}

		        					}
		        				}
		        				else
		        				{
		        					$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Your Result has not been published. Check Back in few days or Contact your School Administrator.</span></div>");
		        					redirect($page);
		        				}
		        			}
        				}
        				else
        				{
        					$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Username is Invalid.</span></div>");
		        			redirect($page);
        				}
        			}
        		}
        		else
	        	{
		        	$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Combination of Pin and Serial Number is invalid.</span></div>");
		        	redirect($page);
	        	}
        	}
        	else
        	{
	        	$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>The Result Pin entered is invalid.</span></div>");
	        	redirect($page);
        	}
        }
        else
        {
        	$errors=validation_errors();
        	$this->session->set_flashdata('message', "<div class=\"alert alert-warning alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>$errors</span></div>");
        	redirect($page);
        }
	}
	public function result_page($page='check_result')
	{
		if (!$this->session->has_userdata('Set')) 
		{
			$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Please use a valid pin and serial number to check result</span></div>");
		    redirect('checkresult'); 
		}

		$general_settings=$this->Web_model->general_settings();
		$class=$this->session->userdata('Class');
		$result_typ=$this->session->userdata('Result_typ');
		$session=$this->session->userdata('Aca_Session');
		$semester=$this->session->userdata('Semester');
		$student=$this->session->userdata('Student');
		$result=$this->Web_model->results_published($student,$class,$semester,$session);
		$position=$this->Web_model->position_published($student,$class,$semester,$session,$result_typ);
		$data['general_settings']=$general_settings;
		$data['Site_name']=$general_settings->row()->Site_name;
		$data['pagename']='Result Page';
		$data['sresults']=$result;
		$data['position']=$position;
		$data['class']=$this->db->select('*')->from('Classes')->where('Class_id',$class)->get();
		$data['session']=$this->db->select('*')->from('Session')->where('Session_id',$session)->get();
		$data['semester']=$this->db->select('*')->from('Semester')->where('Semester_id',$semester)->get();
		$data['teacher']=$this->db->select('*')->from('Teacher')->where('Class',$class)->get();
		$data['student']=$this->db->select('*')->from('Student')->where('Student_id',$class)->get();
		$this->load->view($page,$data);
	}
}
