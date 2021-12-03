<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {

	public function index()
	{
		$userdata = array('Session',
						'adminid'
						 );
		$this->session->unset_userdata($userdata);//destroying sessions
		$this->session->set_flashdata('message', "<div class=\"alert alert-success alert-dismissable\">
                                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
                                    <span>You have successfully signed out</span>
                               		 </div>");
		redirect('admin/login');
	}

}