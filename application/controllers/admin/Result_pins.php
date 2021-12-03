<?php
defined('BASEPATH') OR exit('Access denied');

class Result_pins extends CI_Controller
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
	public function index($page='admin/result_pins')
	{
		$adminid=$this->session->userdata('adminid');
		$adminsess=$this->session->userdata('Session');
		$general_settings=$this->Web_model->general_settings();
		$data['admin']=$this->Admin_model->Admin_details($adminid,$adminsess);
		$data['general_settings']=$general_settings;
		$data['Site_name']=$general_settings->row()->Site_name;
		$data['pagename']='Result Pin';
		$data['pins']=$this->Admin_model->get_result_pins();
		$this->load->view('admin/templates/homeheader',$data);
		$this->load->view('admin/templates/sidemenu',$data);
		$this->load->view('admin/templates/topmenu',$data);
		$this->load->view($page,$data);
	}
	public function Create()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('num_add', 'Number of Pin To Generate', 'trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {
        	$num_add=html_escape($this->input->post('num_add')); 
	        
	        //passing form data into array for database insertion
		    for ($i=0; $i <$num_add ; $i++) 
		    { 
		    	//getting length of pin and serial number
		    	$pin_length=$general_settings->row()->Resultpin_length;
		    	$serial_length=$general_settings->row()->Serialpin_length;
		    	//getting pin and serial combination
		    	$pin_char = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		    	$serial_char='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		    	//shuffling
                $pin= substr(str_shuffle($pin_char), 0,$pin_length);
                $serialnum= substr(str_shuffle($serial_char), 0, $serial_length);

                $type_data = array('Pin_number'=>$pin,'Serial_number'=>$serialnum, 'Status'=>1);
                $added=$this->Admin_model->create_result_pin($type_data);
		    }
		    if ($added==TRUE) 
		    {
		       	$this->session->set_flashdata('message', "<div class=\"alert alert-success alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Result Pin and Serial Number Successfully Generated</span></div>");
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
	//get result type details through ajax request
	public function get_result_type_id($id)
	{
		$result = $this->db->select("*")
                           ->from("Result_type")
                           ->where("Type_id",$id)
                           ->get()->result();
       echo json_encode($result);
	}
	//delete position
	public function Delete()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
        $this->form_validation->set_rules('id','Result Pin Id','trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {

        	$id=html_escape($this->input->post('id'));
        	$delete=$this->db->where('Pin_id',$id)->delete('Result_pins');
        	if ($delete==TRUE) 
	        {
	        	$this->session->set_flashdata('message', "<div class=\"alert alert-success alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Result Pin Successfully Deleted</span></div>");
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
        $this->form_validation->set_rules('id','Result_Pin Id','trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {

        	$id=html_escape($this->input->post('id'));
        	$delete=$this->db->truncate('Result_pins');
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