<?php
defined('BASEPATH') OR exit('Access denied');

class Students extends CI_Controller
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
	public function index($page='admin/students')
	{
		$adminid=$this->session->userdata('adminid');
		$adminsess=$this->session->userdata('Session');
		$general_settings=$this->Web_model->general_settings();
		$data['admin']=$this->Admin_model->Admin_details($adminid,$adminsess);
		$data['general_settings']=$general_settings;
		$data['Site_name']=$general_settings->row()->Site_name;
		$data['pagename']='Students';
		$data['studentss']=$this->Admin_model->get_students_all();
		$data['students']=$this->db->select('*')->from('Student')->group_by('Class')->get();
		$data['classes']=$this->Admin_model->get_classes();
		$this->load->view('admin/templates/homeheader',$data);
		$this->load->view('admin/templates/sidemenu',$data);
		$this->load->view('admin/templates/topmenu',$data);
		$this->load->view($page,$data);
		$this->load->view('admin/templates/students_footer',$data);
	}
	public function Create()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('class', 'Class', 'trim|required|numeric');
		$this->form_validation->set_rules('name', 'Student\'s Name', 'trim|required|alpha_numeric_spaces');
		$this->form_validation->set_rules('email', 'Student\'s Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Student\'s Password', 'trim|alpha_numeric_spaces');
		$this->form_validation->set_rules('username', 'Student\'s Reg.Number', 'trim|alpha_numeric_spaces');
		if ($this->form_validation->run() == TRUE)
        {
        	$class=html_escape($this->input->post('class'));
        	$name=html_escape($this->input->post('name'));
        	$email=html_escape($this->input->post('email'));
        	$password=html_escape($this->input->post('password'));
        	$username=html_escape($this->input->post('username'));
        	$student_exists=$this->db->select('*')->from('Student')->where('Email',$email)->or_where('Reg_no',$username)->where('Class',$class)->get();
        	if ($student_exists->num_rows() >0) 
        	{
	        	$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Student Already Added to class.</span></div>");
		        redirect($page);	
	        }
	        else
	        {
	        	if (empty($password)) 
	        	{
	        		$password=$general_settings->row()->Default_password;
	        		$update_pass=2;
	        	}
	        	else
	        	{
	        		$password=$password;
	        		$update_pass=1;
	        	}
	        	if (empty($username)) 
	        	{
	        		$username=$general_settings->row()->Site_shortname."/".date('Y')."/".rand(10000000,999999999);
	        	}
	        	else
	        	{
	        		$username=$username;
	        	}
	        	$data_array = array('Name' =>$name,'Class'=>$class,'Status'=>1,'Email'=>$email,'Reg_no'=>$username,'Password'=>password_hash($password, PASSWORD_BCRYPT),'Updated_Password'=>$update_pass);
	        	$add=$this->Admin_model->create_student($data_array);
	        }
        	if ($add==True) 
        	{
        			$this->session->set_flashdata('message', "<div class=\"alert alert-success alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Student Successfully Added</span></div>");
        			redirect($page);
        	}
        	else
        	{
        		$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Something went wrong</span></div>");
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
	public function Create_batch()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('class', 'Class', 'trim|required|numeric');
		$this->form_validation->set_rules('name[]', 'Student\'s Name', 'trim|required|alpha_numeric_spaces');
		$this->form_validation->set_rules('email[]', 'Student\'s Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('username[]', 'Student\'s Reg.Number', 'trim|alpha_numeric_spaces|required');
		if ($this->form_validation->run() == TRUE)
        {
        	$students=array();
        	$class=html_escape($this->input->post('class'));
        	$name=html_escape($this->input->post('name'));
        	$email=html_escape($this->input->post('email'));
        	$username=html_escape($this->input->post('username'));
        	for ($i=0; $i <count($name) ; $i++) 
        	{

        		$class=$class;
        		$email=$email;
        		$names=$name;
        		$username=$username;
        		$student_exists=$this->db->select('*')->from('Student')->where('Email',$email[$i])->where('Class',$class)->get();
        		$username_exists=$this->db->select('*')->from('Student')->where('Reg_no',$username[$i])->where('Class',$class)->get();
        		if ($student_exists->num_rows() >0) 
        		{
	        		$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Student with Email Already Added to class.</span></div>");
		        	redirect($page);	
	        	}
	        	elseif ($username_exists->num_rows() >0) 
        		{
	        		$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Student with Username Already Added to class.</span></div>");
		        	redirect($page);	
	        	}
	        	else
	        	{
	        		$password=$general_settings->row()->Default_password;
		        	$update_pass=2;
		        	
		        	$data_array = array('Name' =>$names[$i],'Class'=>$class,'Status'=>1,'Email'=>$email[$i],'Reg_no'=>$username[$i],'Password'=>password_hash($password, PASSWORD_BCRYPT),'Updated_Password'=>$update_pass);
		        	$add=$this->Admin_model->create_student($data_array);
	        	}
        	}
        	if ($add==True) 
        	{
        		$this->session->set_flashdata('message', "<div class=\"alert alert-success alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Students Successfully Added</span></div>");
        		redirect($page);
        	}
        	else
        	{
        		$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Something went wrong</span></div>");
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
	public function Promote_demote()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('class', 'Class', 'trim|required|numeric');
		$this->form_validation->set_rules('name[]', 'Student\'s Name', 'trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {
        	$students=array();
        	$class=html_escape($this->input->post('class'));
        	$name=html_escape($this->input->post('name'));
        	for ($i=0; $i <count($name) ; $i++) 
        	{

        		$class=$class;
        		$names=$name;
        		
		        	$data_array = array('Class'=>$class);
		        	$updated=$this->db->set($data_array)->where('Student_id',$names[$i])->update('Student');
        	}
        	if ($updated==True) 
        	{
        		$this->session->set_flashdata('message', "<div class=\"alert alert-success alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Students Successfully Promoted</span></div>");
        		redirect($page);
        	}
        	else
        	{
        		$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Something went wrong</span></div>");
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
        $this->form_validation->set_rules('id','Subject Id','trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {

        	$delete=$this->db->truncate('Student');
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
	public function view_students($id=null)
	{
		$page='admin/view_students';
		$adminid=$this->session->userdata('adminid');
		$adminsess=$this->session->userdata('Session');
		$general_settings=$this->Web_model->general_settings();
		$students_exists=$this->Admin_model->get_students($id);
		if ($students_exists->num_rows()<1) 
		{
			$this->session->set_flashdata('message', "<div class=\"alert alert-warning alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Page does not exist or you lack clearance to view it.</span></div>");
        	redirect('admin/students');
		}
		$data['classid']=$id;
		$data['admin']=$this->Admin_model->Admin_details($adminid,$adminsess);
		$data['general_settings']=$general_settings;
		$data['Site_name']=$general_settings->row()->Site_name;
		$data['pagename']='Students';
		$data['students']=$this->Admin_model->get_students($id);
		$data['classes']=$this->Admin_model->get_classes();
		$this->load->view('admin/templates/homeheader',$data);
		$this->load->view('admin/templates/sidemenu',$data);
		$this->load->view('admin/templates/topmenu',$data);
		$this->load->view($page,$data);
		$this->load->view('admin/templates/view_students_footer',$data);
	}
	//delete
	public function Delete()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
        $this->form_validation->set_rules('id','Combination Id','trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {

        	$stu_id=html_escape($this->input->post('id'));
        	$delete=$this->db->where('Student_id',$stu_id)->delete('Student');
        	if ($delete==TRUE) 
	        {
	        	$this->session->set_flashdata('message', "<div class=\"alert alert-success alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Successfully Deleted</span></div>");
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