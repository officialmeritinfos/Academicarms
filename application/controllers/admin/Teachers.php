<?php
defined('BASEPATH') OR exit('Access denied');

class Teachers extends CI_Controller
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
	public function index($page='admin/teachers')
	{
		$adminid=$this->session->userdata('adminid');
		$adminsess=$this->session->userdata('Session');
		$general_settings=$this->Web_model->general_settings();
		$data['admin']=$this->Admin_model->Admin_details($adminid,$adminsess);
		$data['general_settings']=$general_settings;
		$data['Site_name']=$general_settings->row()->Site_name;
		$data['pagename']='Teachers';
		$data['teachers']=$this->Admin_model->get_teacher();
		$data['classes']=$this->Admin_model->get_classes();
		$this->load->view('admin/templates/homeheader',$data);
		$this->load->view('admin/templates/sidemenu',$data);
		$this->load->view('admin/templates/topmenu',$data);
		$this->load->view($page,$data);
		$this->load->view('admin/templates/teacher_footer',$data);
	}
	public function Create_teacher()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('name', 'Teacher Name', 'trim|required|alpha_numeric_spaces');
		$this->form_validation->set_rules('email', 'Teacher Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('class', 'Class', 'trim|required|numeric');
        $this->form_validation->set_rules('status', 'Status', 'trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {
        	$name=html_escape($this->input->post('name'));
        	$email=html_escape($this->input->post('email'));
        	$class=html_escape($this->input->post('class'));
        	$status=html_escape($this->input->post('status'));
        	//check if class already exists
        	$email_exists=$this->db->select('*')->from('Teacher')->where('Email',$email)->get();
        	$class_exists=$this->db->select('*')->from('Classes')->where('Class_id',$class)->get();
        	$teacher_already_assigned=$this->db->select('*')->from('Teacher')->where('Class',$class)->get();
        	if ($email_exists->num_rows() >0) 
        	{
        		$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Email Already Exists.</span></div>");
	        	redirect($page);	
        	}
        	elseif ($class_exists->num_rows()<1) 
        	{
        		$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Class Does Not Exist.</span></div>");
	        	redirect($page);
        	}
        	elseif ($teacher_already_assigned->num_rows()>0) 
        	{
        		$teach_class_exist=$teacher_already_assigned->row()->Email;
        		$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>A teacher has been assigned to this class already. If You want to assign this teacher to this class remove the teacher with email: $teach_class_exist from the class.</span></div>");
	        	redirect($page);
        	}
        	else
        	{
        		$password=$general_settings->row()->Default_password;
        		$class_name=$class_exists->row()->Name;
	        	//passing form data into array for database insertion
	        	$teacher_data = array('Name' =>$name,'Status'=>$status,'Class'=>$class,'Password'=>password_hash($password, PASSWORD_BCRYPT),'Email'=>$email,'ClassName'=>$class_name);
	        	$add=$this->Admin_model->create_teacher($teacher_data);
	        	if ($add==TRUE) 
	        	{
	        		$this->session->set_flashdata('message', "<div class=\"alert alert-success alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Teacher Successfully Created</span></div>");
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
	public function Create_teacher_batch()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('email[]', 'Teacher Email', 'trim|required|valid_emails');
		if ($this->form_validation->run() == TRUE)
        {
        	$emails=html_escape($this->input->post('email'));
        	$x=0;
        	$input_number_email=count($emails);
        	foreach ($emails as $email)
			{
				for ($i=0; $i <$input_number_email ; $i++) 
		        	{ 
			        	$password=$general_settings->row()->Default_password;
						$teacher_data = array('Status'=>1,'Password'=>password_hash($password, PASSWORD_BCRYPT),'Email'=>$email);	
		        	}
		        $add=$this->Admin_model->create_teacher_batch($teacher_data);
	        }
			if ($add==TRUE) 
			{
				$this->session->set_flashdata('message', "<div class=\"alert alert-success alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Teacher Successfully Created</span></div>");
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
	public function Edit_teacher()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('name', 'Teacher Name', 'trim|required|alpha_numeric_spaces');
		$this->form_validation->set_rules('email','Email','trim|valid_email|required');
        $this->form_validation->set_rules('status', 'Status', 'trim|required|numeric');
        $this->form_validation->set_rules('class','Class','trim|required|numeric');
        $this->form_validation->set_rules('teacher_id','Teacher','trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {
        	$name=html_escape($this->input->post('name'));
        	$email=html_escape($this->input->post('email'));
        	$class=html_escape($this->input->post('class'));
        	$status=html_escape($this->input->post('status'));
        	$teacher_id=html_escape($this->input->post('teacher_id'));
        	//check if class already exists
        	$email_exists=$this->db->select('*')->from('Teacher')->where('Email',$email)->where('Teacher_id!=',$teacher_id)->get();
        	$class_exists=$this->db->select('*')->from('Classes')->where('Class_id',$class)->get();
        	$teacher_already_assigned=$this->db->select('*')->from('Teacher')->where('Class',$class)->where('Teacher_id!=',$teacher_id)->get();
        	if ($email_exists->num_rows() >0) 
        	{
        		$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Email Already Exists.</span></div>");
	        	redirect($page);	
        	}
        	elseif ($class_exists->num_rows()<1) 
        	{
        		$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Class Does Not Exist.</span></div>");
	        	redirect($page);
        	}
        	elseif ($teacher_already_assigned->num_rows()>0) 
        	{
        		$teach_class_exist=$teacher_already_assigned->row()->Email;
        		$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>A teacher has been assigned to this class already. If You want to assign this teacher to this class remove the teacher with email: $teach_class_exist from the class.</span></div>");
	        	redirect($page);
        	}
        	else
        	{
        		$password=$general_settings->row()->Default_password;
        		$class_name=$class_exists->row()->Name;
	        	//passing form data into array for database insertion
	        	$teacher_data = array('Name' =>$name,'Status'=>$status,'Class'=>$class,'Password'=>password_hash($password, PASSWORD_BCRYPT),'Email'=>$email,'ClassName'=>$class_name);
	        	$add=$this->Admin_model->update_teacher($teacher_data,$teacher_id);
	        	if ($add==TRUE) 
	        	{
	        		$this->session->set_flashdata('message', "<div class=\"alert alert-success alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Teacher Successfully Created</span></div>");
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
	public function get_teacher_id($id)
	{
		$result = $this->db->select("*")
                           ->from("Teacher")
                           ->where("Teacher_id",$id)
                           ->get()->result();
       echo json_encode($result);
	}
	//remove a teacher from a class
	public function Remove_class()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
        $this->form_validation->set_rules('teacher_id','Teacher Id','trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {

        	$teacher_id=html_escape($this->input->post('teacher_id'));
        	$remove=$this->db->set('Class','')->where('Teacher_id',$teacher_id)->update('Teacher');
        	if ($remove==TRUE) 
	        {
	        	$this->session->set_flashdata('message', "<div class=\"alert alert-success alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Teacher Successfully removed from class</span></div>");
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
	//delete teacher
	public function Delete()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
        $this->form_validation->set_rules('teacher_id','Teacher Id','trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {

        	$teacher_id=html_escape($this->input->post('teacher_id'));
        	$delete=$this->db->where('teacher_id',$teacher_id)->delete('Teacher');
        	if ($delete==TRUE) 
	        {
	        	$this->session->set_flashdata('message', "<div class=\"alert alert-success alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Teacher Successfully Deleted</span></div>");
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

        	$delete=$this->db->truncate('Teacher');
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