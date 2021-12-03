<?php
defined('BASEPATH') OR exit('Access denied');

class Dashboard extends CI_Controller
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
	public function index($page='admin/dashboard')
	{
		$adminid=$this->session->userdata('adminid');
		$adminsess=$this->session->userdata('Session');
		$general_settings=$this->Web_model->general_settings();
		$data['admin']=$this->Admin_model->Admin_details($adminid,$adminsess);
		$data['general_settings']=$general_settings;
		$data['Site_name']=$general_settings->row()->Site_name;
		$data['pagename']='Admin Dashboard';
		$data['Results_published']=$this->db->select('*')->from('Result')->where('Status',1)->group_by('Student')->get();
		$data['Results_unpublished']=$this->db->select('*')->from('Result')->where('Status!=',1)->group_by('Student')->get();
		$data['Subjects']=$this->db->select('*')->from('Subject')->get();
		$data['Students']=$this->db->select('*')->from('Student')->get();
		$data['Classes']=$this->db->select('*')->from('Classes')->get();
		$data['Teachers']=$this->db->select('*')->from('Teacher')->get();
		$data['Result_pin_unused']=$this->db->select('*')->from('Result_pins')->where('Status',1)->get();
		$data['Result_pin_used']=$this->db->select('*')->from('Result_pins')->where('Status!=',1) ->get();
		$this->load->view('admin/templates/homeheader',$data);
		$this->load->view('admin/templates/sidemenu',$data);
		$this->load->view('admin/templates/topmenu',$data);
		$this->load->view($page,$data);
		$this->load->view('admin/templates/homefooter',$data);
	}
}