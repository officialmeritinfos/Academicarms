<?php
defined('BASEPATH') OR exit('Access denied');

class Results extends CI_Controller
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
	public function index($page='teachers/results')
	{
		$teacherid=$this->session->userdata('teacherid');
		$teachersess=$this->session->userdata('Teacher_Session');
		$general_settings=$this->Web_model->general_settings();
		$teacher=$this->Teacher_model->Teacher_details($teacherid,$teachersess);
		$data['teacher']=$teacher;
		$data['general_settings']=$general_settings;
		$data['Site_name']=$general_settings->row()->Site_name;
		$data['pagename']='Results';
		$data['results']=$this->Teacher_model->get_result($teacher->row()->Class);
		$data['sessions']=$this->Teacher_model->get_session();
		$data['terms']=$this->Teacher_model->get_semester();
		$data['classes']=$this->Teacher_model->get_classes($teacher->row()->Class);
		$this->load->view('teachers/templates/homeheader',$data);
		$this->load->view('teachers/templates/sidemenu',$data);
		$this->load->view('teachers/templates/topmenu',$data);
		$this->load->view($page,$data);
	}
	public function Create()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('name[]', 'Subject Id', 'trim|required|numeric');
        $this->form_validation->set_rules('status', 'Status', 'trim|required|numeric');
		$this->form_validation->set_rules('class', 'Class', 'trim|required|numeric');
		$this->form_validation->set_rules('examscore[]', 'Exam Score', 'trim|required|numeric');
		$this->form_validation->set_rules('testscore[]', 'Test Score', 'trim|numeric');
		$this->form_validation->set_rules('student', 'Student', 'trim|required|numeric');
		$this->form_validation->set_rules('session', 'Session', 'trim|required');
		$this->form_validation->set_rules('term', 'Semester', 'trim|required');
		if ($this->form_validation->run() == TRUE)
        {
        	$sujectss=array();
        	$name=html_escape($this->input->post('name'));
        	$class=html_escape($this->input->post('class'));
        	$examscore=html_escape($this->input->post('examscore'));
        	$testscore=html_escape($this->input->post('testscore'));
        	$student=html_escape($this->input->post('student'));
        	$status=html_escape($this->input->post('status'));
        	$sess=html_escape($this->input->post('session'));
        	$terms=html_escape($this->input->post('term'));
        	for ($i=0; $i <count($name) ; $i++) 
        	{ 
	        	//check if score already exists
	        	$exam_exists=$this->db->select('*')->from('Result')->where('Student',$student)->where('Subject',$name[$i])->where('Session',$sess)->where('Semester',$terms)->get();
	        	if ($exam_exists->num_rows() >0) 
	        	{
	        		$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Result Already Exists.</span></div>");
		        	redirect($page);	
	        	}
	        	else
	        	{
	        		$total_score=$examscore[$i]+$testscore[$i];//total score{Summation of exam score and test score}
	        		$grade=$this->db->select('*')->from('Grade')->where('Min_Score <=',$total_score)->where('Max_Score >=',$total_score)->get(); //getting grade
	        		$grades=$grade->row()->Name;
	        		$sub=$this->db->select('*')->from('Subject')->where('Subject_id',$name[$i])->get();
	        		$unit_load=$sub->row()->Unit_load;
	        		$unit_point=$unit_load*$grade->row()->Grade_point;
	        		if ($total_score >100) 
	        		{
	        			$this->session->set_flashdata('message', "<div class=\"alert alert-success alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Total Score cannot be more than 100%</span></div>");
		        		redirect($page);
	        		}
	        		//passing form data into array for database insertion
		        	$result_data = array('Session' =>$sess,'Status'=>$status,'Exam_score'=>$examscore[$i],'Test_score'=>$testscore[$i],'Class'=>$class,'Subject'=>$name[$i],'Semester'=>$terms,'Total_score'=>$total_score,'Student'=>$student,'Grade'=>$grades,'Gradepoint'=>$grade->row()->Grade_point,'Grade_id'=>$grade->row()->Grade_id,'Unit_load'=>$unit_load,'Unit_point'=>$unit_point);

	        		$add=$this->Admin_model->create_result($result_data);
		        }
	        }
		    if ($add==TRUE) 
		    {
		       	$this->session->set_flashdata('message', "<div class=\"alert alert-success alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Result Successfully Created</span></div>");
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
	public function Edit()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('id', 'Result Id', 'trim|required|numeric');
        $this->form_validation->set_rules('status', 'Status', 'trim|required|numeric');
		$this->form_validation->set_rules('examscore', 'Exam Score', 'trim|required|numeric');
		$this->form_validation->set_rules('testscore', 'Test Score', 'trim|numeric');
		$this->form_validation->set_rules('subid', 'Subject Id', 'trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {
        	$resultid=html_escape($this->input->post('id'));        	
        	$examscore=html_escape($this->input->post('examscore'));
        	$testscore=html_escape($this->input->post('testscore'));
        	$subid=html_escape($this->input->post('subid'));
        	$status=html_escape($this->input->post('status'));
	        	
	        $total_score=$examscore+$testscore;//total score{Summation of exam score and test score}
	        $grade=$this->db->select('*')->from('Grade')->where('Min_Score <=',$total_score)->where('Max_Score >=',$total_score)->get(); //getting grade
	        $grades=$grade->row()->Name;
	        $sub=$this->db->select('*')->from('Subject')->where('Subject_id',$subid)->get();
	        $unit_load=$sub->row()->Unit_load;
	        $unit_point=$unit_load*$grade->row()->Grade_point;
	        if ($total_score >100) 
	        {
	        	$this->session->set_flashdata('message', "<div class=\"alert alert-success alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Total Score cannot be more than 100%</span></div>");
		        redirect($page);
	        }
	        	//passing form data into array for database insertion
		    $result_data = array('Status'=>$status,'Exam_score'=>$examscore,'Test_score'=>$testscore,'Subject'=>$subid,'Total_score'=>$total_score,'Grade'=>$grades,'Gradepoint'=>$grade->row()->Grade_point,'Grade_id'=>$grade->row()->Grade_id,'Unit_load'=>$unit_load,'Unit_point'=>$unit_point);

	        $updated=$this->Admin_model->update_result($result_data,$resultid);
		    if ($updated==TRUE) 
		    {
		       	$this->session->set_flashdata('message', "<div class=\"alert alert-success alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Result Successfully Updated</span></div>");
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
	//get class subjects details through ajax request
	public function get_class_subject($id)
	{
		$result = $this->db->select("*")
                           ->from("Subject_combination")
                           ->join("Subject",'Subject.Subject_id=Subject_combination.Subject')
                           ->where("Class",$id)
                           ->get()->result();
       echo json_encode($result);
	}

	//delete result
	public function Delete()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
        $this->form_validation->set_rules('id','Result Id','trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {

        	$id=html_escape($this->input->post('id'));
        	$delete=$this->db->where('Result_id',$id)->delete('Result');
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
	public function view_result_term($id=null)
	{
		$id=html_escape($id);
		$page='teachers/view_result_term';
		$teacherid=$this->session->userdata('teacherid');
		$teachersess=$this->session->userdata('Teacher_Session');
		$general_settings=$this->Web_model->general_settings();
		$teacher=$this->Teacher_model->Teacher_details($teacherid,$teachersess);
		$general_settings=$this->Web_model->general_settings();
		$term_result_exists=$this->Teacher_model->get_result_session($id,$teacher->row()->Class);
		if ($term_result_exists->num_rows() <1) 
	    {
	        $this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Semester or Term Result Not Published Yet.</span></div>");
		    redirect('admin/results');	
	    }
		$data['teacher']=$teacher;
		$data['general_settings']=$general_settings;
		$data['Site_name']=$general_settings->row()->Site_name;
		$data['pagename']='Results';
		$data['results']=$this->Teacher_model->get_result_session($id,$teacher->row()->Class);
		$data['sessions']=$this->Teacher_model->get_session();
		$data['terms']=$this->Teacher_model->get_semester();
		$data['classes']=$this->Admin_model->get_classes();
		$this->load->view('teachers/templates/homeheader',$data);
		$this->load->view('teachers/templates/sidemenu',$data);
		$this->load->view('teachers/templates/topmenu',$data);
		$this->load->view($page,$data);
	}
	public function view_result_class($id=null)
	{
		$sess=$this->uri->segment(4);
		$terms=$this->uri->segment(5);
		$sess=html_escape($sess);
		$terms=html_escape($terms);
		$page='teachers/view_result_class';
		$teacherid=$this->session->userdata('teacherid');
		$teachersess=$this->session->userdata('Teacher_Session');
		$general_settings=$this->Web_model->general_settings();
		$teacher=$this->Teacher_model->Teacher_details($teacherid,$teachersess);
		$class_result_exists=$this->Admin_model->get_result_term($sess,$terms,$teacher->row()->Class);
		if ($class_result_exists->num_rows() <1) 
	    {
	        $this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Class Result Not Published Yet.</span></div>");
		    redirect('admin/results');
	    }
		$data['teacher']=$teacher;
		$data['general_settings']=$general_settings;
		$data['Site_name']=$general_settings->row()->Site_name;
		$data['pagename']='Results';
		$data['results']=$this->Teacher_model->get_result_term($sess,$terms,$teacher->row()->Class);
		$data['sessions']=$this->Teacher_model->get_session();
		$data['terms']=$this->Teacher_model->get_semester();
		$data['classes']=$this->Admin_model->get_classes();
		$this->load->view('teachers/templates/homeheader',$data);
		$this->load->view('teachers/templates/sidemenu',$data);
		$this->load->view('teachers/templates/topmenu',$data);
		$this->load->view($page,$data);
	}
	public function view_result_students($id=null)
	{
		$sess=$this->uri->segment(4);
		$terms=$this->uri->segment(5);
		$classs=$this->uri->segment(6);
		$sess=html_escape($sess);
		$terms=html_escape($terms);
		$classs=html_escape($classs);
		$page='teachers/view_result_students';
		$teacherid=$this->session->userdata('teacherid');
		$teachersess=$this->session->userdata('Teacher_Session');
		$general_settings=$this->Web_model->general_settings();
		$teacher=$this->Teacher_model->Teacher_details($teacherid,$teachersess);
		$students_result_exists=$this->Admin_model->get_result_class($sess,$terms,$teacher->row()->Class);
		if ($students_result_exists->num_rows() <1) 
	    {
	        $this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Students Result Not Published Yet.</span></div>");
		    redirect('admin/results');	
	    }
		$data['teacher']=$teacher;
		$data['general_settings']=$general_settings;
		$data['Site_name']=$general_settings->row()->Site_name;
		$data['pagename']='Results';
		$data['results']=$this->Teacher_model->get_result_class($sess,$terms,$teacher->row()->Class);
		$data['sessions']=$this->Teacher_model->get_session();
		$data['terms']=$this->Teacher_model->get_semester();
		$data['classes']=$this->Admin_model->get_classes();
		$this->load->view('teachers/templates/homeheader',$data);
		$this->load->view('teachers/templates/sidemenu',$data);
		$this->load->view('teachers/templates/topmenu',$data);
		$this->load->view($page,$data);
	}
	public function view_student_result($id=null)
	{
		$sess=$this->uri->segment(4);
		$terms=$this->uri->segment(5);
		$classs=$this->uri->segment(6);
		$stud=$this->uri->segment(7);
		$sess=html_escape($sess);
		$terms=html_escape($terms);
		$classs=html_escape($classs);
		$stud=html_escape($stud);
		$page='teachers/view_student_result';
		$teacherid=$this->session->userdata('teacherid');
		$teachersess=$this->session->userdata('Teacher_Session');
		$general_settings=$this->Web_model->general_settings();
		$teacher=$this->Teacher_model->Teacher_details($teacherid,$teachersess);
		$students_result_exists=$this->Teacher_model->get_result_student($sess,$terms,$teacher->row()->Class,$stud);
		if ($students_result_exists->num_rows() <1) 
	    {
	        $this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Student Result Not Published Yet.</span></div>");
		    redirect('admin/results');	
	    }
		$data['teacher']=$teacher;
		$data['general_settings']=$general_settings;
		$data['Site_name']=$general_settings->row()->Site_name;
		$data['pagename']='Results';
		$data['results']=$this->Teacher_model->get_result_student($sess,$terms,$classs,$stud);
		$data['sessions']=$this->Teacher_model->get_session();
		$data['terms']=$this->Teacher_model->get_semester();
		$data['classes']=$this->Admin_model->get_classes();
		$this->load->view('teachers/templates/homeheader',$data);
		$this->load->view('teachers/templates/sidemenu',$data);
		$this->load->view('teachers/templates/topmenu',$data);
		$this->load->view($page,$data);
	}
	//get student result details details through ajax request for editing
	public function get_student_result($id)
	{
		$result = $this->db->select("*")
                           ->from("Result")
                           ->join("Subject",'Subject.Subject_id=Result.Subject')
                           ->where("Result_id",$id)
                           ->get()->result();
       echo json_encode($result);
	}
}