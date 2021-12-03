<?php
defined('BASEPATH') OR exit('Access denied');

class Subjects_combination extends CI_Controller
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
	public function index($page='admin/subjects_combination')
	{
		$adminid=$this->session->userdata('adminid');
		$adminsess=$this->session->userdata('Session');
		$general_settings=$this->Web_model->general_settings();
		$data['admin']=$this->Admin_model->Admin_details($adminid,$adminsess);
		$data['general_settings']=$general_settings;
		$data['Site_name']=$general_settings->row()->Site_name;
		$data['pagename']='Subject Combination';
		$data['subjects_com']=$this->db->select('*')->from('Subject_combination')->group_by('Class')->get();
		$data['classes']=$this->Admin_model->get_classes();
		$data['subjects']=$this->Admin_model->get_subject();
		$this->load->view('admin/templates/homeheader',$data);
		$this->load->view('admin/templates/sidemenu',$data);
		$this->load->view('admin/templates/topmenu',$data);
		$this->load->view($page,$data);
		$this->load->view('admin/templates/combination_footer',$data);
	}
	public function Create_batch()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('class', 'Class', 'trim|required|numeric');
		$this->form_validation->set_rules('subject[]', 'Subject', 'trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {
        	$sujectss=array();
        	$class=html_escape($this->input->post('class'));
        	$sub=html_escape($this->input->post('subject'));
        	for ($i=0; $i <count($sub) ; $i++) 
        	{
        		$class=$class;
        		$subjects=$sub[$i];
        		$subject_exists=$this->db->select('*')->from('Subject_combination')->where('Subject',$subjects)->where('Class',$class)->get();
        		if ($subject_exists->num_rows() >0) 
        		{
	        		$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Subject Already Added to class.</span></div>");
		        	redirect($page);	
	        	}
	        	else
	        	{
	        		$data_array = array('Subject' =>$subjects,'Class'=>$class,'Status'=>1);
	        		$add=$this->Admin_model->create_subjectcom_batch($data_array);
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
	//truncating data
	public function truncate()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
        $this->form_validation->set_rules('id','Subject Id','trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {

        	$delete=$this->db->truncate('Subject_combination');
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
	public function view_combinations($id=null)
	{
		$page='admin/view_combinations';
		$adminid=$this->session->userdata('adminid');
		$adminsess=$this->session->userdata('Session');
		$general_settings=$this->Web_model->general_settings();
		$comb_exists=$this->Admin_model->get_subject_combination($id);
		if ($comb_exists->num_rows()<1) 
		{
			$this->session->set_flashdata('message', "<div class=\"alert alert-warning alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Page does not exist or you lack clearance to view it.</span></div>");
        	redirect('admin/subjects_combination');
		}
		$data['classid']=$id;
		$data['admin']=$this->Admin_model->Admin_details($adminid,$adminsess);
		$data['general_settings']=$general_settings;
		$data['Site_name']=$general_settings->row()->Site_name;
		$data['pagename']='Subject Combination';
		$data['subjects']=$this->Admin_model->get_subject();
		$data['subjects_com']=$this->Admin_model->get_subject_combination($id);
		$data['classes']=$this->Admin_model->get_classes();
		$this->load->view('admin/templates/homeheader',$data);
		$this->load->view('admin/templates/sidemenu',$data);
		$this->load->view('admin/templates/topmenu',$data);
		$this->load->view($page,$data);
		$this->load->view('admin/templates/view_combinations_footer',$data);
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

        	$com_id=html_escape($this->input->post('id'));
        	$delete=$this->db->where('Combination_id',$com_id)->delete('Subject_combination');
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