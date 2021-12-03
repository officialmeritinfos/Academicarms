<?php
defined('BASEPATH') OR exit('Access denied');

class Grades extends CI_Controller
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
	public function index($page='admin/grades')
	{
		$adminid=$this->session->userdata('adminid');
		$adminsess=$this->session->userdata('Session');
		$general_settings=$this->Web_model->general_settings();
		$data['admin']=$this->Admin_model->Admin_details($adminid,$adminsess);
		$data['general_settings']=$general_settings;
		$data['Site_name']=$general_settings->row()->Site_name;
		$data['pagename']='Grades';
		$data['grades']=$this->Admin_model->get_grade();
		$this->load->view('admin/templates/homeheader',$data);
		$this->load->view('admin/templates/sidemenu',$data);
		$this->load->view('admin/templates/topmenu',$data);
		$this->load->view($page,$data);
	}
	public function Create_grade()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('name', 'Grade Name', 'trim|required');
        $this->form_validation->set_rules('status', 'Status', 'trim|required|numeric');
		$this->form_validation->set_rules('minscore', 'Minimum Score', 'trim|required|numeric');
		$this->form_validation->set_rules('maxscore', 'Maximum Score', 'trim|required|numeric');
		$this->form_validation->set_rules('gradepoint', 'Grade Point', 'trim|numeric');
		$this->form_validation->set_rules('comment', 'Comment', 'trim|required');
		if ($this->form_validation->run() == TRUE)
        {
        	$name=html_escape($this->input->post('name'));
        	$minscore=html_escape($this->input->post('minscore'));
        	$maxscore=html_escape($this->input->post('maxscore'));
        	$gradepoint=html_escape($this->input->post('gradepoint'));
        	$comments=html_escape($this->input->post('comment'));
        	$status=html_escape($this->input->post('status'));
        	//check if session already exists
        	$grade_exists=$this->db->select('*')->from('Grade')->where('Name',$name)->get();
        	if ($grade_exists->num_rows() >0) 
        	{
        		$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Grade Already Exists.</span></div>");
	        	redirect($page);	
        	}
        	else
        	{
        		//passing form data into array for database insertion
	        	$grade_data = array('Name' =>$name,'Status'=>$status,'Min_Score'=>$minscore,'Max_Score'=>$maxscore,'Comment'=>$comments,'Grade_point'=>$gradepoint);
	        	$add=$this->Admin_model->create_grade($grade_data);
	        	if ($add==TRUE) 
	        	{
	        		$this->session->set_flashdata('message', "<div class=\"alert alert-success alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Grade Successfully Created</span></div>");
	        		redirect($page);
	        	}
	        	else
	        	{
	        		$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Something Went Wrong. Please Try Again.</span></div>");
	        		redirect($page);
	        	}
	        }
        }
        else
        {
        	$errors=validation_errors();
        	$this->session->set_flashdata('message', "<div class=\"alert alert-warning alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>$errors</span></div>");
        	redirect($page);
        }
	}
	public function Edit()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('name', 'Semester Name', 'trim|required');
        $this->form_validation->set_rules('status', 'Status', 'trim|required|numeric');
        $this->form_validation->set_rules('id','Semester Id','trim|required|numeric');
        $this->form_validation->set_rules('minscore', 'Minimum Score', 'trim|required|numeric');
		$this->form_validation->set_rules('maxscore', 'Maximum Score', 'trim|required|numeric');
		$this->form_validation->set_rules('gradepoint', 'Grade Point', 'trim|numeric');
		$this->form_validation->set_rules('comment', 'Comment', 'trim|required');
		if ($this->form_validation->run() == TRUE)
        {
        	$name=html_escape($this->input->post('name'));
        	$status=html_escape($this->input->post('status'));
        	$minscore=html_escape($this->input->post('minscore'));
        	$maxscore=html_escape($this->input->post('maxscore'));
        	$gradepoint=html_escape($this->input->post('gradepoint'));
        	$comments=html_escape($this->input->post('comment'));
        	$id=html_escape($this->input->post('id'));
        	//check if class already exists
        	$grade_exists=$this->db->select('*')->from('Grade')->where('Name',$name)->where('Grade_id!=',$id)->get();
        	if ($grade_exists->num_rows() >0) 
        	{
        		$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Grade Already Exists.</span></div>");
	        	redirect($page);	
        	}
        	else
        	{
	        	//passing form data into array for database insertion
	        	$grade_data = array('Name' =>$name,'Status'=>$status,'Min_Score'=>$minscore,'Max_Score'=>$maxscore,'Comment'=>$comments,'Grade_point'=>$gradepoint);
	        	$update=$this->Admin_model->update_grade($grade_data,$id);
	        	if ($update==TRUE) 
	        	{
	        		$this->session->set_flashdata('message', "<div class=\"alert alert-success alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Grade Successfully Updated</span></div>");
	        		redirect($page);
	        	}
	        	else
	        	{
	        		$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Something Went Wrong. Please Try Again.</span></div>");
	        		redirect($page);
	        	}
	        }
        }
        else
        {
        	$errors=validation_errors();
        	$this->session->set_flashdata('message', "<div class=\"alert alert-warning alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>$errors</span></div>");
        	redirect($page);
        }
	}
	//get grade details through ajax request
	public function get_grade_id($id)
	{
		$result = $this->db->select("*")
                           ->from("Grade")
                           ->where("Grade_id",$id)
                           ->get()->result();
       echo json_encode($result);
	}
	//delete class
	public function Delete()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
        $this->form_validation->set_rules('id','Grade Id','trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {

        	$id=html_escape($this->input->post('id'));
        	$delete=$this->db->where('Grade_id',$id)->delete('Grade');
        	if ($delete==TRUE) 
	        {
	        	$this->session->set_flashdata('message', "<div class=\"alert alert-success alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Grade Successfully Deleted</span></div>");
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
	//truncating data
	public function truncate()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
        $this->form_validation->set_rules('id','Grade Id','trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {

        	$id=html_escape($this->input->post('id'));
        	$delete=$this->db->truncate('Grade');
        	if ($delete==TRUE) 
	        {
	        	$this->session->set_flashdata('message', "<div class=\"alert alert-success alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Table Successfully truncated</span></div>");
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
}