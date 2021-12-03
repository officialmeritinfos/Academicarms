<?php
defined('BASEPATH') OR exit('Access denied');

class Subjects extends CI_Controller
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
	public function index($page='admin/subjects')
	{
		$adminid=$this->session->userdata('adminid');
		$adminsess=$this->session->userdata('Session');
		$general_settings=$this->Web_model->general_settings();
		$data['admin']=$this->Admin_model->Admin_details($adminid,$adminsess);
		$data['general_settings']=$general_settings;
		$data['Site_name']=$general_settings->row()->Site_name;
		$data['pagename']='Subjects';
		$data['subjects']=$this->Admin_model->get_subject();
		$data['classes']=$this->Admin_model->get_classes();
		$this->load->view('admin/templates/homeheader',$data);
		$this->load->view('admin/templates/sidemenu',$data);
		$this->load->view('admin/templates/topmenu',$data);
		$this->load->view($page,$data);
		$this->load->view('admin/templates/subject_footer',$data);
	}
	public function Create()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('name', 'Subject Title', 'trim|required|alpha_numeric_spaces');
		$this->form_validation->set_rules('subcode', 'Subject Code', 'trim');
		$this->form_validation->set_rules('unitload', 'Unit Load', 'trim|numeric');
        $this->form_validation->set_rules('status', 'Status', 'trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {
        	$name=html_escape($this->input->post('name'));
        	$subcode=html_escape($this->input->post('subcode'));
        	$unitload=html_escape($this->input->post('unitload'));
        	$status=html_escape($this->input->post('status'));
        	//check if class already exists
        	$subject_exists=$this->db->select('*')->from('Subject')->where('Subject_name',$name)->get();
        	$subcode_exists=$this->db->select('*')->from('Subject')->where('Subject_code',$subcode)->get();
        	if ($subject_exists->num_rows() >0) 
        	{
        		$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Subject Already Exists.</span></div>");
	        	redirect($page);	
        	}
        	elseif ($subcode_exists->num_rows()>0) 
        	{
        		$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Subject Code Already Exists. Please use a unique subject code</span></div>");
	        	redirect($page);
        	}
        	else
        	{
        		
	        	//passing form data into array for database insertion
	        	$subject_data = array('Subject_name' =>$name,'Status'=>$status,'Subject_code'=>$subcode,'Unit_load'=>$unitload);
	        	$add=$this->Admin_model->create_subject($subject_data);
	        	if ($add==TRUE) 
	        	{
	        		$this->session->set_flashdata('message', "<div class=\"alert alert-success alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Subject Successfully Created</span></div>");
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
	public function Create_batch()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('name[]', 'Subject Name', 'trim|required|alpha_numeric_spaces');
		$this->form_validation->set_rules('subcode[]', 'Subject Code', 'trim|required|alpha_numeric_spaces');
		$this->form_validation->set_rules('unitload[]', 'Unit Load', 'trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {
        	$sujectss=array();
        	$name=html_escape($this->input->post('name'));
        	$subcode=html_escape($this->input->post('subcode'));
        	$unitload=html_escape($this->input->post('unitload'));
        	for ($i=0; $i <count($name) ; $i++) 
        	{ 
        		$subcodes=$subcode[$i];
        		$names=$name[$i];
        		$subject_exists=$this->db->select('*')->from('Subject')->where('Subject_name',$names)->get();
        		$subcode_exists=$this->db->select('*')->from('Subject')->where('Subject_code',$subcodes)->get();
        		if ($subject_exists->num_rows() >0) 
        		{
	        		$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Subject Already Exists.</span></div>");
		        	redirect($page);	
	        	}
	        	elseif ($subcode_exists->num_rows()>0) 
	        	{
	        		$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Subject Code Already Exists. Please use a unique subject code</span></div>");
		        	redirect($page);
	        	}
	        	else
	        	{
	        		$data_array = array('Subject_name' =>$names,'Subject_code'=>$subcodes,'Status'=>1,'Unit_load'=>$unitload[$i]);
	        		$add=$this->Admin_model->create_subject_batch($data_array);
	        	}
        	}
        	if ($add==True) 
        		{
        			$this->session->set_flashdata('message', "<div class=\"alert alert-success alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Subjects Successfully Added</span></div>");
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
	public function Edit()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('name', 'Subject Title', 'trim|required|alpha_numeric_spaces');
		$this->form_validation->set_rules('subcode', 'Subject Code', 'trim');
		$this->form_validation->set_rules('unitload', 'Unit Load', 'trim|numeric');
        $this->form_validation->set_rules('status', 'Status', 'trim|required|numeric');
        $this->form_validation->set_rules('id', 'Subject Id', 'trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {
        	$name=html_escape($this->input->post('name'));
        	$subcode=html_escape($this->input->post('subcode'));
        	$unitload=html_escape($this->input->post('unitload'));
        	$status=html_escape($this->input->post('status'));
        	$subjectid=html_escape($this->input->post('id'));
        	//check if class already exists
        	$subject_exists=$this->db->select('*')->from('Subject')->where('Subject_name',$name)->where('Subject_id!=',$subjectid)->get();
        	$subcode_exists=$this->db->select('*')->from('Subject')->where('Subject_code',$subcode)->where('Subject_id!=',$subjectid)->get();
        	if ($subject_exists->num_rows() >0) 
        	{
        		$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Subject Already Exists.</span></div>");
	        	redirect($page);	
        	}
        	elseif ($subcode_exists->num_rows()>0) 
        	{
        		$teach_class_exist=$teacher_already_assigned->row()->Email;
        		$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Subject Code Already Exists. Please use a unique subject code</span></div>");
	        	redirect($page);
        	}
        	else
        	{
        		
	        	//passing form data into array for database insertion
	        	$subject_data = array('Subject_name' =>$name,'Status'=>$status,'Subject_code'=>$subcode,'Unit_load'=>$unitload);
	        	$update=$this->Admin_model->update_subject($subject_data,$subjectid);
	        	if ($update==TRUE) 
	        	{
	        		$this->session->set_flashdata('message', "<div class=\"alert alert-success alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Subject Successfully Created</span></div>");
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
	//get subject details through ajax request
	public function get_subject_id($id)
	{
		$result = $this->db->select("*")
                           ->from("Subject")
                           ->where("Subject_id",$id)
                           ->get()->result();
       echo json_encode($result);
	}
	//delete
	public function Delete()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
        $this->form_validation->set_rules('id','Subject Id','trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {

        	$subject_id=html_escape($this->input->post('id'));
        	$delete=$this->db->where('Subject_id',$subject_id)->delete('Subject');
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
	//truncating data
	public function truncate()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
        $this->form_validation->set_rules('id','Subject Id','trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {

        	$delete=$this->db->truncate('Subject');
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