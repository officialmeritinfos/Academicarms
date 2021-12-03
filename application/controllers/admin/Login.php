<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct($page='admin/login')
	{
		parent::__construct();
		if ($this->session->userdata('Session')) 
		{
			//if already logged in
        	$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\">
                                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
                                    <span>You are already logged in.</span>
                                     </div>");
            redirect('admin/dashboard');
		}
	}
	public function index($page='admin/login')
	{
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        //if form is submitted
        if ($this->form_validation->run() == TRUE)
        {
            if (isset($_SERVER['HTTP_REFERER'])) {
                $pages=$_SERVER['HTTP_REFERER'];
            }
            else
            {
                $pages=$page;
            }
        	//escape special characters
        	$email= html_escape($this->input->post('email'));
        	$password= html_escape($this->input->post('password'));
        	//checking if email exists and getting the admin details
        	$email_exists=$this->Admin_model->email_real($email);
        	if ($email_exists->num_rows() > 0) 
        	{
        		$hashed=password_verify($password, $email_exists->row()->Password);
        		if ($hashed==true) 
        		{
        			$session=sha1(time());
        			$session_data = array('adminid' =>$email_exists->row()->admin_id,'Session'=>$session);
        			if ($email_exists->row()->Status ==3) 
        			{
        				$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\">
                                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
                                    <span>You have been banned from this system.</span>
                                     </div>");
                		redirect($page);
        			}
        			else
        			{
        				$data = $this->security->xss_clean($session_data);//sanitizing against xss
                        $datam=html_escape($data);//excaping all string
                        $set_admin=$this->db->Set('AdminSess',$session)->where('admin_id',$email_exists->row()->admin_id)->Update('Sysadmin');
                        if ($set_admin) 
                        {
                        	$loggedin=$this->session->set_userdata($datam);
	                        $this->session->set_flashdata('message', "<div class=\"alert alert-success alert-dismissable\">
	                                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
	                                    <span>Your Session has successfully started.</span>
	                                     </div>");
	                		redirect($pages,'refresh');
	                	}
	                	else
	                	{
	                		$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\">
                                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
                                    <span>Something went wrong. Please contact our suport center if issue persists.</span>
                                     </div>");
                			redirect($page);
	                	}
        			}

        		}
        		else
        		{
        			$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\">
                                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
                                    <span>Email and Password Combination is wrong</span>
                                     </div>");
                	redirect($page);
        		}
        	}
        	else
        	{
        		//if email does not exist
        		$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\">
                                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
                                    <span>Email Does Not Exist</span>
                                     </div>");
                redirect($page);
        	}
        }
		$data['general_settings']=$general_settings;
		$data['Site_name']=$general_settings->row()->Site_name;
		$data['pagename']='Login Page';
		$this->load->view($page,$data);
	}
	public function recoverpassword($page='admin/login')
    {
        $general_settings=$this->Web_model->general_settings();
        $webmail=$general_settings->row()->Site_email;
        $site_title=$general_settings->row()->Site_name;
        //Set Form Validation Rules
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        if ($this->form_validation->run() == TRUE)
        {
            $email=html_escape($this->input->post('email'));
            $email_exists=$this->Admin_model->email_real($email);
            if ($email_exists->num_rows()>0) 
            {
                $admin_id=$email_exists->row()->admin_id;
                $admin_name=$email_exists->row()->Name;
                $code_char='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
                //shuffling
                $code= substr(str_shuffle($code_char), 0,10);
                $code_hashed=sha1($code);
                $msg="Dear $admin_name, Your Password Reset Code is $code. Best Regards, $site_title";
                $recover_session=array('adminemail' =>$email,'Set'=>TRUE);
                $data_update = array('EmailCode' =>$code,'Email_code'=>$code_hashed );
                $data_updates=$this->db->set($data_update)->where('admin_id',$admin_id)->update('Sysadmin');
                if ($data_updates) 
                {
                    $recoversession=$this->session->set_userdata($recover_session);
                    //sending email
                    $sent=$this->email->from($webmail, $site_title)->to($email)->subject('Password Reset Request')->message($msg)->send();
                    if ($this->session->has_userdata('Set')) 
                    {
                        //if session is set
                        $this->session->set_flashdata('message', "<div class=\"alert alert-success alert-dismissable\">
                                            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
                                            <span>Your Recovery code has been sent to your email. Copy and paste it below to reset your Password.</span>
                                             </div>");
                        redirect('admin/login/verify_code');
                    }
                }
                else
                {
                    //if update failed
                    $this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\">
                                        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
                                        <span>Something Went Wrong</span>
                                         </div>");
                    redirect($page);
                }
            }
            else
            {
                //if email does not exist
                $this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\">
                                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
                                    <span>Email Does Not Exist</span>
                                     </div>");
                redirect($page);
            }
        }
        $data['general_settings']=$general_settings;
        $data['Site_name']=$general_settings->row()->Site_name;
        $data['pagename']='Recover Password';
        $this->load->view($page,$data);
    }
    public function verify_code($page='admin/verify_code')
    {
        if (!$this->session->has_userdata('Set')) 
        {
             //if session not started
            $this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>You do not have access to this page.</span></div>");
            redirect('admin/login');
        }
        $general_settings=$this->Web_model->general_settings();
        //Set Form Validation Rules
        $this->form_validation->set_rules('code', 'Code', 'trim|required');
        if ($this->form_validation->run() == TRUE)
        {
            $admin_email=$this->session->userdata('adminemail');
            $code=html_escape($this->input->post('code'));
            $sub_code=sha1($code);
            $code_exists=$this->db->select('*')->from('Sysadmin')->where('Email_code',$sub_code)->get();
            if ($code_exists->num_rows()>0) 
            {
                $data_update = array('Email_code' =>'','EmailCode'=>'');
                $data_updates=$this->db->set($data_update)->where('admin_id',$code_exists->row()->admin_id)->update('Sysadmin');
                if ($data_updates) 
                {
                    $adminsess = array('adm_id' =>$code_exists->row()->admin_id,'Sets'=>TRUE);
                    $admin_sess=$this->session->set_userdata($adminsess);
                    if ($this->session->has_userdata('Sets')) 
                    {
                        //if session is set
                        $this->session->set_flashdata('message', "<div class=\"alert alert-success alert-dismissable\">
                                            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
                                            <span>Email Successfully Verified. Resest Your Password Below.</span>
                                             </div>");
                        redirect('admin/login/reset_password');
                    }
                }
                else
                {
                //if update did not work
                $this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Your Code Is wrong.</span></div>");
                redirect('admin/login/verify_code'); 
                }
            }
            else
            {
                //if Code is wrong
                $this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Your Code Is wrong.</span></div>");
                redirect('admin/login/verify_code'); 
            }
        }
        $data['general_settings']=$general_settings;
        $data['Site_name']=$general_settings->row()->Site_name;
        $data['pagename']='Verify Email';
        $this->load->view($page,$data);
    }
    public function reset_password($page='admin/reset_password')
    {
        if (!$this->session->has_userdata('Sets')) 
        {
             //if session not started
            $this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>You do not have access to this page.</span></div>");
            redirect('admin/login');
        }
        $general_settings=$this->Web_model->general_settings();
        //Set Form Validation Rules
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]|min_length[8]');
        if ($this->form_validation->run() == TRUE)
        {
            $admin_id=$this->session->userdata('adm_id');
            $password=html_escape($this->input->post('password'));
            $data_updates=$this->db->set('Password',password_hash($password, PASSWORD_BCRYPT))->where('admin_id',$admin_id)->update('Sysadmin');
            if ($data_updates) 
            {
                    //if session is set
                    $this->session->set_flashdata('message', "<div class=\"alert alert-success alert-dismissable\">
                                            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
                                            <span>Password Updated. Login to conitnue.</span>
                                             </div>");
                    redirect('admin/login');
            }
            else
            {
                //if update did not work
                $this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>We could not reset your password. Contact Admin for help.</span></div>");
                redirect('admin/login/reset_password');  
            }
        }
        $data['general_settings']=$general_settings;
        $data['Site_name']=$general_settings->row()->Site_name;
        $data['pagename']='Reset Password';
        $this->load->view($page,$data);
    }
}
