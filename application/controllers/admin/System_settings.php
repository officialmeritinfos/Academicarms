<?php
defined('BASEPATH') OR exit('Access denied');

class System_settings extends CI_Controller
{
	
	function __construct($page='admin/login')
	{
		parent::__construct();
		if (!$this->session->userdata('Session')) 
		{
			//not logged in; using system generated session id against brute force login
        	$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\">
                                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
                                    <span>Access Denied. Please Login to access page.</span>
                                     </div>");
            redirect($page);
		}
	}
	public function index($page='admin/system_settings')
	{
		$adminid=$this->session->userdata('adminid');
		$adminsess=$this->session->userdata('Session');
		$general_settings=$this->Web_model->general_settings();
		$data['admin']=$this->Admin_model->Admin_details($adminid,$adminsess);
		$data['general_settings']=$general_settings;
		$data['Site_name']=$general_settings->row()->Site_name;
		$data['pagename']='System Settings';
		$data['admins']=$this->Admin_model->get_admin($adminid);
		$this->load->view('admin/templates/homeheader',$data);
		$this->load->view('admin/templates/sidemenu',$data);
		$this->load->view('admin/templates/topmenu',$data);
		$this->load->view($page,$data);
	}
	public function Site_settings()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('site_name', 'Site Name', 'trim|required|alpha_numeric_spaces');
		$this->form_validation->set_rules('site_shortname', 'Site Short Name', 'trim|required|alpha_numeric_spaces');
		$this->form_validation->set_rules('site_tag', 'Site Tag', 'trim|required');
		$this->form_validation->set_rules('site_email', 'Site Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('footer_text', 'Footer Text', 'trim|required');
		if ($this->form_validation->run() == TRUE)
        {
        	$name=html_escape($this->input->post('site_name'));
        	$email=html_escape($this->input->post('site_email'));
        	$shortname=html_escape($this->input->post('site_shortname'));
        	$tags=html_escape($this->input->post('site_tag'));
        	$footer=$this->input->post('footer_text'); 
	        
	        //passing form data into array for database insertion
		    	
                $site_data = array('Site_name'=>$name,'Site_email'=>$email,'Site_shortname'=>$shortname,'Site_tag'=>$tags,'footer_text'=>$footer);
                $added=$this->Admin_model->update_site($site_data);
			    if ($added==TRUE) 
			    {
			       	$this->session->set_flashdata('message', "<div class=\"alert alert-success alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Site Details Successfully Updated.</span></div>");
			        redirect($page);
			    }
			    else
			    {
			    	$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Something Went Wrong. Please Try Again.</span></div>");
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
	public function General_settings()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('default_password', 'Default Password', 'trim|required');
		$this->form_validation->set_rules('resultpin', 'Result Pin Length', 'trim|required|numeric');
		$this->form_validation->set_rules('serialnumber', 'Serial Number Length', 'trim|required|numeric');
		$this->form_validation->set_rules('pinusage', 'Result Pin Usage Limit', 'trim|required|numeric');
		$this->form_validation->set_rules('teacher_student', 'Teacher Can Add Student', 'trim|required|numeric');
		$this->form_validation->set_rules('teacher_result', 'Teacher Can Add Result', 'trim|required|numeric');
		$this->form_validation->set_rules('result_type', 'Result Type', 'trim|required|numeric');
		$this->form_validation->set_rules('check_result', 'Check Result Without Logining', 'trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {
        	$default=html_escape($this->input->post('default_password'));
        	$resultpin=html_escape($this->input->post('resultpin'));
        	$serialnumber=html_escape($this->input->post('serialnumber'));
        	$pinusage=html_escape($this->input->post('pinusage'));
        	$teachstu=html_escape($this->input->post('teacher_student'));
        	$teachre=html_escape($this->input->post('teacher_result'));
        	$retype=$this->input->post('result_type'); 
        	$checkre=$this->input->post('check_result'); 
	        
	        //passing form data into array for database insertion
		    	
                $site_data = array('Default_password'=>$default,'Resultpin_length'=>$resultpin,'Serialpin_length'=>$serialnumber,'Pin_usage'=>$pinusage,'Teacher_add_students'=>$teachstu,'Teacher_add_result'=>$teachre,'Result_type'=>$retype,'Check_result_nologin'=>$checkre);
                $added=$this->Admin_model->update_site($site_data);
			    if ($added==TRUE) 
			    {
			       	$this->session->set_flashdata('message', "<div class=\"alert alert-success alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Site Details Successfully Updated.</span></div>");
			        redirect($page);
			    }
			    else
			    {
			    	$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Something Went Wrong. Please Try Again.</span></div>");
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
	public function logo($page='admin/system_settings')
	{
		$adminid=$this->session->userdata('adminid');	
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
        //Configuring Image Path
        $paths='./assets/dashboard/images/logo/';
        $config['upload_path']          = $paths;
        $config['allowed_types']        = 'gif|jpg|png|jpeg';
        $config['max_size']             = '5000';
        $config['encrypt_name']         = TRUE;


                $this->upload->initialize($config);
                $uploads=$this->upload->do_upload('logo');
                $imagename=$this->upload->data('file_name');

                if (!$uploads) 
                {
                    $error=$this->upload->display_errors();
                    $this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\">
                                        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
                                        <span>$error</span>
                                    </div>");
                    redirect($page);
                }
                else
                {
            		$dat_insert = array(
            							'Site_logo'        =>$imagename
            							);
            		$data=html_escape($dat_insert);
                    $this->db->set($data)->where('id',1)->update('general_settings');
                    $this->session->set_flashdata('message', "<div class=\"alert alert-success alert-dismissable\">
                                        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
                                        <span>Logo Successfully updated. </span>
                                    </div>");
                    redirect($page);
                }
	}
}