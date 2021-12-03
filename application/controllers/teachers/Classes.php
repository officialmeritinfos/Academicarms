<?php
defined('BASEPATH') OR exit('Access denied');

class Classes extends CI_Controller
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
	public function index($page='teachers/classes')
	{
		$teacherid=$this->session->userdata('teacherid');
		$teachersess=$this->session->userdata('Teacher_Session');
		$general_settings=$this->Web_model->general_settings();
		$data['teacher']=$this->Teacher_model->Teacher_details($teacherid,$teachersess);
		$data['general_settings']=$general_settings;
		$data['Site_name']=$general_settings->row()->Site_name;
		$data['pagename']='Classes';
		$data['classes']=$this->Admin_model->get_classes();
		$this->load->view('teachers/templates/homeheader',$data);
		$this->load->view('teachers/templates/sidemenu',$data);
		$this->load->view('teachers/templates/topmenu',$data);
		$this->load->view($page,$data);
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
}