<?php
defined('BASEPATH') OR exit('Access denied');

class Classes extends CI_Controller
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
	public function index($page='admin/classes')
	{
		$adminid=$this->session->userdata('adminid');
		$adminsess=$this->session->userdata('Session');
		$general_settings=$this->Web_model->general_settings();
		$data['admin']=$this->Admin_model->Admin_details($adminid,$adminsess);
		$data['general_settings']=$general_settings;
		$data['Site_name']=$general_settings->row()->Site_name;
		$data['pagename']='Classes';
		$data['classes']=$this->Admin_model->get_classes();
		$this->load->view('admin/templates/homeheader',$data);
		$this->load->view('admin/templates/sidemenu',$data);
		$this->load->view('admin/templates/topmenu',$data);
		$this->load->view($page,$data);
	}
	public function Create_class()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('name', 'Class Name', 'trim|required');
        $this->form_validation->set_rules('status', 'Status', 'trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {
        	$name=html_escape($this->input->post('name'));
        	$status=html_escape($this->input->post('status'));
        	//check if class already exists
        	$class_exists=$this->db->select('*')->from('Classes')->where('Name',$name)->get();
        	if ($class_exists->num_rows() >0) 
        	{
        		$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Class Already Exists.</span></div>");
	        	redirect($page);	
        	}
        	else
        	{
        		$class_ref=$general_settings->row()->Site_shortname."-".rand(100000000000,99999999999999999999);
	        	//passing form data into array for database insertion
	        	$class_data = array('Name' =>$name,'Status'=>$status,'ClassRef'=>$class_ref);
	        	$add=$this->Admin_model->create_class($class_data);
	        	if ($add==TRUE) 
	        	{
	        		$this->session->set_flashdata('message', "<div class=\"alert alert-success alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Class Successfully Created</span></div>");
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
	public function Edit_class()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('name', 'Class Name', 'trim|required');
        $this->form_validation->set_rules('status', 'Status', 'trim|required|numeric');
        $this->form_validation->set_rules('class_id','Class Id','trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {
        	$name=html_escape($this->input->post('name'));
        	$status=html_escape($this->input->post('status'));
        	$class_id=html_escape($this->input->post('class_id'));
        	//check if class already exists
        	$class_exists=$this->db->select('*')->from('Classes')->where('Name',$name)->where('Class_id!=',$class_id)->get();
        	if ($class_exists->num_rows() >0) 
        	{
        		$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Class Already Exists.</span></div>");
	        	redirect($page);	
        	}
        	else
        	{
	        	//passing form data into array for database insertion
	        	$class_data = array('Name' =>$name,'Status'=>$status);
	        	$update=$this->Admin_model->update_class($class_data,$class_id);
	        	if ($update==TRUE) 
	        	{
	        		$this->session->set_flashdata('message', "<div class=\"alert alert-success alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Class Successfully Updated</span></div>");
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
	//get class details through ajax request
	public function get_class_id($id)
	{
		$result = $this->db->select("*")
                           ->from("Classes")
                           ->where("Class_id",$id)
                           ->get()->result();
       echo json_encode($result);
	}
	//delete class
	public function Delete()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
        $this->form_validation->set_rules('class_id','Class Id','trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {

        	$class_id=html_escape($this->input->post('class_id'));
        	$delete=$this->db->where('Class_id',$class_id)->delete('Classes');
        	if ($delete==TRUE) 
	        {
	        	$this->session->set_flashdata('message', "<div class=\"alert alert-success alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Class Successfully Deleted</span></div>");
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
        $this->form_validation->set_rules('id','Class Id','trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {

        	$class_id=html_escape($this->input->post('class_id'));
        	$delete=$this->db->truncate('Classes');
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