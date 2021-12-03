<?php
defined('BASEPATH') OR exit('Access denied');

class Positions extends CI_Controller
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
	public function index($page='teachers/positions')
	{
		$teacherid=$this->session->userdata('teacherid');
		$teachersess=$this->session->userdata('Teacher_Session');
		$general_settings=$this->Web_model->general_settings();
		$teacher=$this->Teacher_model->Teacher_details($teacherid,$teachersess);
		$data['teacher']=$teacher;
		$data['general_settings']=$general_settings;
		$data['Site_name']=$general_settings->row()->Site_name;
		$data['pagename']='Positions';
		$data['positions']=$this->Teacher_model->get_position($teacher->row()->Class);
		$data['sessions']=$this->Teacher_model->get_session();
		$data['terms']=$this->Teacher_model->get_semester();
		$data['classes']=$this->Teacher_model->get_classes($teacher->row()->Class);
		$this->load->view('teachers/templates/homeheader',$data);
		$this->load->view('teachers/templates/sidemenu',$data);
		$this->load->view('teachers/templates/topmenu',$data);
		$this->load->view($page,$data);
	}
	public function Create_position()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('class', 'Class', 'trim|required|numeric');
        $this->form_validation->set_rules('student', 'Student', 'trim|required|numeric');
        $this->form_validation->set_rules('result_type', 'Result Type', 'trim|required|numeric');
		$this->form_validation->set_rules('session', 'Session', 'trim|required|numeric');
		$this->form_validation->set_rules('term', 'Semester', 'trim|required|numeric');
		$this->form_validation->set_rules('position', 'Position', 'trim|required');
		$this->form_validation->set_rules('teachercom', 'Teacher Comment', 'trim');
		$this->form_validation->set_rules('principalcom', 'Principal Comment', 'trim');
		$this->form_validation->set_rules('headteachercom', 'Head Teacher', 'trim');
		if ($this->form_validation->run() == TRUE)
        {
        	$class=html_escape($this->input->post('class'));        	
        	$student=html_escape($this->input->post('student'));
        	$session=html_escape($this->input->post('session'));
        	$term=html_escape($this->input->post('term'));
        	$result_typ=html_escape($this->input->post('result_type'));
        	$position=html_escape($this->input->post('position'));
        	$teachercom=html_escape($this->input->post('teachercom'));
        	$headteachercom=html_escape($this->input->post('headteachercom'));
        	$principalcom=html_escape($this->input->post('principalcom'));
	        //check if position has been added for student
	        $position_added=$this->db->select('*')->from('Position')->where('Student',$student)->where('Result_type',$result_typ)->where('Class',$class)->where('Term',$term)->where('Session',$session)->get(); 
	        $results_declared=$this->db->select('*')->from('Result')->where('Student',$student)->where('Class',$class)->where('Semester',$term)->where('Session',$session)->get();
	        if ($position_added->num_rows() >0) 
	        {
	        	$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Position had been assigned to student already</span></div>");
		        redirect($page);
	        }
	        elseif ($results_declared->num_rows() <1) 
	        {
	        	$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>You need to declare results first for the student for the selected Academic Session and Semester/Term before proceeding</span></div>");
		        redirect($page);
	        }
	        	//passing form data into array for database insertion
		    $position_data = array('Result_type'=>$result_typ,'Student'=>$student,'Position'=>$position,'Class'=>$class,'Session'=>$session,'Term'=>$term,'Teacher_comment'=>$teachercom,'Headteacher_comment'=>$headteachercom,'Principal_comment'=>$principalcom);

	        $added=$this->Admin_model->add_position($position_data);
		    if ($added==TRUE) 
		    {
		       	$this->session->set_flashdata('message', "<div class=\"alert alert-success alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Position Successfully Assigned</span></div>");
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
	public function edit()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('class', 'Class', 'trim|required|numeric');
		$this->form_validation->set_rules('id', 'Position Id', 'trim|required|numeric');
        $this->form_validation->set_rules('student', 'Student', 'trim|required|numeric');
        $this->form_validation->set_rules('result_type', 'Result Type', 'trim|required|numeric');
		$this->form_validation->set_rules('session', 'Session', 'trim|required|numeric');
		$this->form_validation->set_rules('term', 'Semester', 'trim|required|numeric');
		$this->form_validation->set_rules('position', 'Position', 'trim|required');
		$this->form_validation->set_rules('teachercom', 'Teacher Comment', 'trim');
		$this->form_validation->set_rules('principalcom', 'Principal Comment', 'trim');
		$this->form_validation->set_rules('headteachercom', 'Head Teacher', 'trim');
		if ($this->form_validation->run() == TRUE)
        {
        	$class=html_escape($this->input->post('class'));
        	$id=html_escape($this->input->post('id'));        	
        	$student=html_escape($this->input->post('student'));
        	$session=html_escape($this->input->post('session'));
        	$term=html_escape($this->input->post('term'));
        	$result_typ=html_escape($this->input->post('result_type'));
        	$position=html_escape($this->input->post('position'));
        	$teachercom=html_escape($this->input->post('teachercom'));
        	$headteachercom=html_escape($this->input->post('headteachercom'));
        	$principalcom=html_escape($this->input->post('principalcom'));
	        //check if position has been added for student
	        $position_added=$this->db->select('*')->from('Position')->where('Student',$student)->where('Result_type',$result_typ)->where('Class',$class)->where('Term',$term)->where('Session',$session)->where('Position_id !=',$id)->get(); 
	        $results_declared=$this->db->select('*')->from('Result')->where('Student',$student)->where('Class',$class)->where('Semester',$term)->where('Session',$session)->get();
	        if ($position_added->num_rows() >0) 
	        {
	        	$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Position had been assigned to student already</span></div>");
		        redirect($page);
	        }
	        elseif ($results_declared->num_rows() <1) 
	        {
	        	$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>You need to declare results first for the student for the selected Academic Session and Semester/Term before proceeding</span></div>");
		        redirect($page);
	        }
	        	//passing form data into array for database insertion
		    $position_data = array('Result_type'=>$result_typ,'Position'=>$position,'Session'=>$session,'Term'=>$term,'Teacher_comment'=>$teachercom,'Headteacher_comment'=>$headteachercom,'Principal_comment'=>$principalcom);

	        $update=$this->Admin_model->update_position($position_data,$id);
		    if ($update==TRUE) 
		    {
		       	$this->session->set_flashdata('message', "<div class=\"alert alert-success alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Position Successfully Updated</span></div>");
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
	//get class students details through ajax request
	public function get_class_students($id)
	{
		$result = $this->db->select("*")
                           ->from("Student")
                           ->where("Class",$id)
                           ->get()->result();
       echo json_encode($result);
	}
	//get positiondetails through ajax request
	public function get_position_id($id)
	{
		$result = $this->db->select("*")
                           ->from("Position")
                           ->where("Position_id",$id)
                           ->get()->result();
       echo json_encode($result);
	}
	//delete position
	public function Delete()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
        $this->form_validation->set_rules('id','Result Id','trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {

        	$id=html_escape($this->input->post('id'));
        	$delete=$this->db->where('Position_id',$id)->delete('Position');
        	if ($delete==TRUE) 
	        {
	        	$this->session->set_flashdata('message', "<div class=\"alert alert-success alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Result Successfully Deleted</span></div>");
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
        $this->form_validation->set_rules('id','Position Id','trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {

        	$id=html_escape($this->input->post('id'));
        	$delete=$this->db->truncate('Position');
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
	public function view_position_semester($id=null)
	{
		$id=html_escape($id);
		$page='teachers/view_position_semester';
		$teacherid=$this->session->userdata('teacherid');
		$teachersess=$this->session->userdata('Teacher_Session');
		$general_settings=$this->Web_model->general_settings();
		$teacher=$this->Teacher_model->Teacher_details($teacherid,$teachersess);
		$data['teacher']=$teacher;
		$term_result_exists=$this->Teacher_model->get_position_session($id,$teacher->row()->Class);
		if ($term_result_exists->num_rows() <1) 
	    {
	        $this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Position not found.</span></div>");
		    redirect('teachers/positions');	
	    }
		$data['general_settings']=$general_settings;
		$data['Site_name']=$general_settings->row()->Site_name;
		$data['pagename']='Results';
		$data['positions']=$this->Teacher_model->get_position_session($id,$teacher->row()->Class);
		$data['sessions']=$this->Admin_model->get_session();
		$data['terms']=$this->Admin_model->get_semester();
		$data['classes']=$this->Teacher_model->get_classes($teacher->row()->Class);
		$this->load->view('teachers/templates/homeheader',$data);
		$this->load->view('teachers/templates/sidemenu',$data);
		$this->load->view('teachers/templates/topmenu',$data);
		$this->load->view($page,$data);
	}
	public function view_position_class($id=null)
	{
		$sess=$this->uri->segment(4);
		$terms=$this->uri->segment(5);
		$sess=html_escape($sess);
		$terms=html_escape($terms);
		$page='teachers/view_position_class';
		$teacherid=$this->session->userdata('teacherid');
		$teachersess=$this->session->userdata('Teacher_Session');
		$general_settings=$this->Web_model->general_settings();
		$teacher=$this->Teacher_model->Teacher_details($teacherid,$teachersess);
		$data['teacher']=$teacher;
		$class_result_exists=$this->Teacher_model->get_position_term($sess,$terms,$teacher->row()->Class);
		if ($class_result_exists->num_rows() <1) 
	    {
	        $this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>No Student has been assigned a osition in this class.</span></div>");
		    redirect('teachers/positions');
	    }
		$data['general_settings']=$general_settings;
		$data['Site_name']=$general_settings->row()->Site_name;
		$data['pagename']='Position';
		$data['positions']=$this->Teacher_model->get_position_term($sess,$terms,$teacher->row()->Class);
		$data['sessions']=$this->Admin_model->get_session();
		$data['terms']=$this->Admin_model->get_semester();
		$data['classes']=$this->Teacher_model->get_classes($teacher->row()->Class);
		$this->load->view('teachers/templates/homeheader',$data);
		$this->load->view('teachers/templates/sidemenu',$data);
		$this->load->view('teachers/templates/topmenu',$data);
		$this->load->view($page,$data);
	}
	public function view_position_students($id=null)
	{
		$sess=$this->uri->segment(4);
		$terms=$this->uri->segment(5);
		$classs=$this->uri->segment(6);
		$sess=html_escape($sess);
		$terms=html_escape($terms);
		$classs=html_escape($classs);
		$page='teachers/view_position_students';
		$teacherid=$this->session->userdata('teacherid');
		$teachersess=$this->session->userdata('Teacher_Session');
		$general_settings=$this->Web_model->general_settings();
		$teacher=$this->Teacher_model->Teacher_details($teacherid,$teachersess);
		$data['teacher']=$teacher;
		$students_result_exists=$this->Teacher_model->get_position_class($sess,$terms,$teacher->row()->Class);
		if ($students_result_exists->num_rows() <1) 
	    {
	        $this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>No student has been assigned a position in this class.</span></div>");
		    redirect('teachers/positions');	
	    }
		$data['general_settings']=$general_settings;
		$data['Site_name']=$general_settings->row()->Site_name;
		$data['pagename']='Position';
		$data['positions']=$this->Teacher_model->get_position_class($sess,$terms,$classs);
		$data['sessions']=$this->Admin_model->get_session();
		$data['terms']=$this->Admin_model->get_semester();
		$data['classes']=$this->Teacher_model->get_classes($teacher->row()->Class);
		$this->load->view('teachers/templates/homeheader',$data);
		$this->load->view('teachers/templates/sidemenu',$data);
		$this->load->view('teachers/templates/topmenu',$data);
		$this->load->view($page,$data);
	}
	public function view_position_type($id=null)
	{
		$sess=$this->uri->segment(4);
		$terms=$this->uri->segment(5);
		$classs=$this->uri->segment(6);
		$student=$this->uri->segment(7);
		$sess=html_escape($sess);
		$terms=html_escape($terms);
		$classs=html_escape($classs);
		$student=html_escape($student);
		$page='teachers/view_position_type';
		$teacherid=$this->session->userdata('teacherid');
		$teachersess=$this->session->userdata('Teacher_Session');
		$general_settings=$this->Web_model->general_settings();
		$teacher=$this->Teacher_model->Teacher_details($teacherid,$teachersess);
		$data['teacher']=$teacher;
		$general_settings=$this->Web_model->general_settings();
		$students_result_exists=$this->Teacher_model->get_position_student($sess,$terms,$teacher->row()->Class,$student);
		if ($students_result_exists->num_rows() <1) 
	    {
	        $this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>No student has been assigned a position in this class.</span></div>");
		    redirect('teachers/positions');	
	    }
		$data['general_settings']=$general_settings;
		$data['Site_name']=$general_settings->row()->Site_name;
		$data['pagename']='Position';
		$data['positions']=$this->Teacher_model->get_position_student($sess,$terms,$teacher->row()->Class,$student);
		$data['sessions']=$this->Admin_model->get_session();
		$data['terms']=$this->Admin_model->get_semester();
		$data['classes']=$this->Teacher_model->get_classes($teacher->row()->Class);
		$this->load->view('teachers/templates/homeheader',$data);
		$this->load->view('teachers/templates/sidemenu',$data);
		$this->load->view('teachers/templates/topmenu',$data);
		$this->load->view($page,$data);
	}
	public function view_position_type_student($id=null)
	{
		$sess=$this->uri->segment(4);
		$terms=$this->uri->segment(5);
		$classs=$this->uri->segment(6);
		$student=$this->uri->segment(7);
		$type=$this->uri->segment(8);
		$sess=html_escape($sess);
		$terms=html_escape($terms);
		$classs=html_escape($classs);
		$student=html_escape($student);
		$type=html_escape($type);
		$page='teachers/view_position_type_student';
		$teacherid=$this->session->userdata('teacherid');
		$teachersess=$this->session->userdata('Teacher_Session');
		$general_settings=$this->Web_model->general_settings();
		$teacher=$this->Teacher_model->Teacher_details($teacherid,$teachersess);
		$data['teacher']=$teacher;
		$general_settings=$this->Web_model->general_settings();
		$students_result_exists=$this->Teacher_model->get_position_student_type($sess,$terms,$teacher->row()->Class,$student,$type);
		if ($students_result_exists->num_rows() <1) 
	    {
	        $this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>No student has been assigned a position with this result type</span></div>");
		    redirect('teachers/positions');	
	    }
		$data['general_settings']=$general_settings;
		$data['Site_name']=$general_settings->row()->Site_name;
		$data['pagename']='Position';
		$data['positions']=$this->Teacher_model->get_position_student_type($sess,$terms,$teacher->row()->Class,$student,$type);
		$data['sessions']=$this->Admin_model->get_session();
		$data['terms']=$this->Admin_model->get_semester();
		$data['classes']=$this->Teacher_model->get_classes($teacher->row()->Class);
		$this->load->view('teachers/templates/homeheader',$data);
		$this->load->view('teachers/templates/sidemenu',$data);
		$this->load->view('teachers/templates/topmenu',$data);
		$this->load->view($page,$data);
	}
}