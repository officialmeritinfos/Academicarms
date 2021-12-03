<?php
defined('BASEPATH') OR exit('Access denied');

class Terms extends CI_Controller
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
	public function index($page='admin/terms')
	{
		$adminid=$this->session->userdata('adminid');
		$adminsess=$this->session->userdata('Session');
		$general_settings=$this->Web_model->general_settings();
		$data['admin']=$this->Admin_model->Admin_details($adminid,$adminsess);
		$data['general_settings']=$general_settings;
		$data['Site_name']=$general_settings->row()->Site_name;
		$data['pagename']='Academic Semesters';
		$data['semesters']=$this->Admin_model->get_semester();
		$this->load->view('admin/templates/homeheader',$data);
		$this->load->view('admin/templates/sidemenu',$data);
		$this->load->view('admin/templates/topmenu',$data);
		$this->load->view($page,$data);
	}
	public function Create_semester()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('name', 'Semester Name', 'trim|required');
        $this->form_validation->set_rules('status', 'Status', 'trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {
        	$name=html_escape($this->input->post('name'));
        	$status=html_escape($this->input->post('status'));
        	//check if session already exists
        	$semester_exists=$this->db->select('*')->from('Semester')->where('Name',$name)->get();
        	if ($semester_exists->num_rows() >0) 
        	{
        		$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Semester Already Exists.</span></div>");
	        	redirect($page);	
        	}
        	else
        	{
        		//passing form data into array for database insertion
	        	$semester_data = array('Name' =>$name,'Status'=>$status);
	        	$add=$this->Admin_model->create_semester($semester_data);
	        	if ($add==TRUE) 
	        	{
	        		$this->session->set_flashdata('message', "<div class=\"alert alert-success alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Semester Successfully Created</span></div>");
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
		if ($this->form_validation->run() == TRUE)
        {
        	$name=html_escape($this->input->post('name'));
        	$status=html_escape($this->input->post('status'));
        	$id=html_escape($this->input->post('id'));
        	//check if class already exists
        	$semester_exists=$this->db->select('*')->from('Semester')->where('Name',$name)->where('Semester_id!=',$id)->get();
        	if ($semester_exists->num_rows() >0) 
        	{
        		$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Semester Already Exists.</span></div>");
	        	redirect($page);	
        	}
        	else
        	{
	        	//passing form data into array for database insertion
	        	$semester_data = array('Name' =>$name,'Status'=>$status);
	        	$update=$this->Admin_model->update_semester($semester_data,$id);
	        	if ($update==TRUE) 
	        	{
	        		$this->session->set_flashdata('message', "<div class=\"alert alert-success alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Semester Successfully Updated</span></div>");
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
	//get semester details through ajax request
	public function get_semester_id($id)
	{
		$result = $this->db->select("*")
                           ->from("Semester")
                           ->where("Semester_id",$id)
                           ->get()->result();
       echo json_encode($result);
	}
	//delete class
	public function Delete()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
        $this->form_validation->set_rules('id','Semester Id','trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {

        	$id=html_escape($this->input->post('id'));
        	$delete=$this->db->where('Semester_id',$id)->delete('Semester');
        	if ($delete==TRUE) 
	        {
	        	$this->session->set_flashdata('message', "<div class=\"alert alert-success alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Session Successfully Deleted</span></div>");
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
        $this->form_validation->set_rules('id','Semester Id','trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {

        	$id=html_escape($this->input->post('id'));
        	$delete=$this->db->truncate('Semester');
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