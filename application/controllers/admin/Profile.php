<?php
defined('BASEPATH') OR exit('Access denied');

class Profile extends CI_Controller
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
	public function index($page='admin/profile')
	{
		$adminid=$this->session->userdata('adminid');
		$adminsess=$this->session->userdata('Session');
		$general_settings=$this->Web_model->general_settings();
		$data['admin']=$this->Admin_model->Admin_details($adminid,$adminsess);
		$data['general_settings']=$general_settings;
		$data['Site_name']=$general_settings->row()->Site_name;
		$data['pagename']='Profile Settings';
		$this->load->view('admin/templates/homeheader',$data);
		$this->load->view('admin/templates/sidemenu',$data);
		$this->load->view('admin/templates/topmenu',$data);
		$this->load->view($page,$data);
	}
	public function Admin_settings()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$adminid=$this->session->userdata('adminid');
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('name', ' Name', 'trim|required|alpha_numeric_spaces');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		if ($this->form_validation->run() == TRUE)
        {
        	$name=html_escape($this->input->post('name'));
        	$email=html_escape($this->input->post('email')); 
	        
	        //check if selected email is in use by another admin
	        $admin_exist=$this->db->select('*')->from('Sysadmin')->where('Email',$email)->where('admin_id!=',$adminid)->get();
	        if ($admin_exist->num_rows()>0) 
	        {
	        	$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Email is alread been used by another. Try another email.</span></div>");
			    redirect($page);
	        }
	        else
	        {
	        //passing form data into array for database insertion
		    	
                $site_data = array('Name'=>$name,'Email'=>$email);
                $added=$this->Admin_model->update_admin_profile($site_data,$adminid);
			    if ($added==TRUE) 
			    {
			       	$this->session->set_flashdata('message', "<div class=\"alert alert-success alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Details Successfully Updated.</span></div>");
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
	public function Login_settings()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$adminid=$this->session->userdata('adminid');
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('old_password', 'Old Password', 'trim|required');
		$this->form_validation->set_rules('new_password', 'New Password', 'trim|required');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[new_password]');
		if ($this->form_validation->run() == TRUE)
        {
        	$old_password=html_escape($this->input->post('old_password')); 
        	$new_password=html_escape($this->input->post('new_password')); 
        	$confirm_password=html_escape($this->input->post('confirm_password')); 
	        
	        $admin=$this->db->select('*')->from('Sysadmin')->where('admin_id',$adminid)->get();
	        if ($admin->num_rows()<0) 
	        {
	        	$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>You dont have clearance to perform this operation.</span></div>");
			    redirect('admin/logout');
	        }
	        else
	        {
	        	$hashed=password_verify($old_password, $admin->row()->Password);
	        	if ($hashed==TRUE) 
	        	{
		        	//passing form data into array for database insertion
	                $data = array('Password'=>password_hash($new_password, PASSWORD_BCRYPT));
	                $added=$this->Admin_model->update_admin_profile($data,$adminid);
				    if ($added==TRUE) 
				    {
				       	$this->session->set_flashdata('message', "<div class=\"alert alert-success alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Login Details Successfully Updated.</span></div>");
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
					$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Your Old Password is wrong.</span></div>");
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
}