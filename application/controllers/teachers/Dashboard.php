<?php
defined('BASEPATH') OR exit('Access denied');

class Dashboard extends CI_Controller
{
	
	function __construct($page='teachers/login')
	{
		parent::__construct();
		if (!$this->session->userdata('Teacher_Session')) 
		{
			//not logged in; using system generated session id against brute force login
        	$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\">
                                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
                                    <span>Access Denied. Please Login to access page.</span>
                                     </div>");
            redirect($page);
		}
	}
	public function index($page='teachers/dashboard')
	{
		$teacherid=$this->session->userdata('teacherid');
		$teachersess=$this->session->userdata('Teacher_Session');
		$general_settings=$this->Web_model->general_settings();
		$teacher=$this->Teacher_model->Teacher_details($teacherid,$teachersess);
		$data['teacher']=$teacher;
		$data['general_settings']=$general_settings;
		$data['Site_name']=$general_settings->row()->Site_name;
		$data['pagename']='Teacher\'s Dashboard';
		$data['Results']=$this->db->select('*')->from('Result')->where('Class',$teacher->row()->Class)->group_by('Student')->get();
		$data['Subjects']=$this->db->select('*')->from('Subject_combination')->where('Class',$teacher->row()->Class)->get();
		$data['Students']=$this->db->select('*')->from('Student')->where('Class',$teacher->row()->Class)->get();
		$this->load->view('teachers/templates/homeheader',$data);
		$this->load->view('teachers/templates/sidemenu',$data);
		$this->load->view('teachers/templates/topmenu',$data);
		$this->load->view($page,$data);
		$this->load->view('teachers/templates/homefooter',$data);
	}
}