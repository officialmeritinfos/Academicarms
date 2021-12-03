<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

	//checking if email exists
	public function email_real($email)
	{
		return $this->db->select('*')->from('Sysadmin')->where('Email',$email)->get();
	}
	//getting loggedin admin
	public function Admin_details($id,$sess)
	{
		return $this->db->select('*')->from('Sysadmin')->where('admin_id',$id)->where('AdminSess',$sess)->get();
	}
	//getting classes
	public function get_classes()
	{
		return $this->db->select('*')->from('Classes')->order_by('Name','ASC')->get();
	}
	//for creating class
	public function create_class($data)
	{
		return $this->db->insert('Classes',$data);
	}
	//for creating session
	public function create_session($data)
	{
		return $this->db->insert('Session',$data);
	}
	//for creating semester
	public function create_semester($data)
	{
		return $this->db->insert('Semester',$data);
	}
	//for creating position
	public function add_position($data)
	{
		return $this->db->insert('Position',$data);
	}
	//for updating class
	public function update_class($data,$id)
	{
		return $this->db->set($data)->where('Class_id',$id)->update('Classes');
	}
	//for updating result
	public function update_result($data,$id)
	{
		return $this->db->set($data)->where('Result_id',$id)->update('Result');
	}
	//for updating grade
	public function update_grade($data,$id)
	{
		return $this->db->set($data)->where('Grade_id',$id)->update('Grade');
	}
	//getting teachers
	public function get_teacher()
	{
		return $this->db->select('*')->from('Teacher')->order_by('Name','ASC')->get();
	}
	//getting result type
	public function get_result_type()
	{
		return $this->db->select('*')->from('Result_type')->order_by('Name','ASC')->get();
	}
	//for creating teacher
	public function create_teacher($data)
	{
		return $this->db->insert('Teacher',$data);
	}
	//for creating admin
	public function create_admin($data)
	{
		return $this->db->insert('Sysadmin',$data);
	}
	//for creating grade
	public function create_grade($data)
	{
		return $this->db->insert('Grade',$data);
	}
	//for creating result type
	public function create_result_type($data)
	{
		return $this->db->insert('Result_type',$data);
	}
	//getting result pins
	public function get_result_pins()
	{
		return $this->db->select('*')->from('Result_Pins')->order_by('Pin_id','ASC')->get();
	}
	//getting system administrator
	public function get_admin($admin)
	{
		return $this->db->select('*')->from('Sysadmin')->where('Admin_type!=',1) ->where('admin_id!=',$admin)->get();
	}
	//for creating result pins
	public function create_result_pin($data)
	{
		return $this->db->insert('Result_pins',$data);
	}
	//for creating subject
	public function create_subject($data)
	{
		return $this->db->insert('Subject',$data);
	}
	//for creating teacher batch
	public function create_teacher_batch($data)
	{
		return $this->db->insert('Teacher',$data);
	}
	//for creating subject batch
	public function create_subject_batch($data)
	{
		return $this->db->insert('Subject',$data);
	}
	//for creating subject combination batch
	public function create_subjectcom_batch($data)
	{
		return $this->db->insert('Subject_combination',$data);
	}
	//for updating teacher
	public function update_teacher($data,$id)
	{
		return $this->db->set($data)->where('Teacher_id',$id)->update('Teacher');
	}
	//for updating admin
	public function update_admin($data,$id)
	{
		return $this->db->set($data)->where('admin_id',$id)->update('Sysadmin');
	}
	//for updating subjects
	public function update_subject($data,$id)
	{
		return $this->db->set($data)->where('Subject_id',$id)->update('Subject');
	}
	//for updating positions
	public function update_position($data,$id)
	{
		return $this->db->set($data)->where('Position_id',$id)->update('Position');
	}
	//for updating Academic Sessions
	public function update_session($data,$id)
	{
		return $this->db->set($data)->where('Session_id',$id)->update('Session');
	}
	//for updating Academic Semester
	public function update_semester($data,$id)
	{
		return $this->db->set($data)->where('Semester_id',$id)->update('Semester');
	}
	//for updating Result Type
	public function update_result_type($data,$id)
	{
		return $this->db->set($data)->where('Type_id',$id)->update('Result_type');
	}
	//getting Subjects
	public function get_subject()
	{
		return $this->db->select('*')->from('Subject')->order_by('Subject_id','ASC')->get();
	}
	//getting Subject combination
	public function get_subject_combination($class)
	{
		return $this->db->select('*')->from('Subject_combination')->where('Class',$class)->get();
	}
	//getting students from all class
	public function get_students_all()
	{
		return $this->db->select('*')->from('Student')->get();
	}
	//getting sessions
	public function get_session()
	{
		return $this->db->select('*')->from('Session')->get();
	}
	//getting semester
	public function get_semester()
	{
		return $this->db->select('*')->from('Semester')->get();
	}
	//getting grades
	public function get_grade()
	{
		return $this->db->select('*')->from('Grade')->get();
	}
	//getting result
	public function get_result()
	{
		return $this->db->select('*')->from('Result')->group_by('Session')->get();
	}
	//getting result
	public function get_result_session($id)
	{
		return $this->db->select('*')->from('Result')->where('Session',$id)->group_by('Semester')->get();

	}
	//getting result
	public function get_result_term($sess,$term)
	{
		return $this->db->select('*')->from('Result')->where('Session',$sess)->where('Semester',$term)->group_by('Class')->get();

	}
	//getting result
	public function get_result_class($sess,$term,$class)
	{
		return $this->db->select('*')->from('Result')->where('Session',$sess)->where('Semester',$term)->where('Class',$class)->group_by('Student')->get();

	}
	//getting result
	public function get_result_student($sess,$term,$class,$stud)
	{
		return $this->db->select('*')->from('Result')->where('Session',$sess)->where('Semester',$term)->where('Class',$class)->where('Student',$stud)->group_by('Subject')->get();

	}
	//getting students for selected class
	public function get_students($class)
	{
		return $this->db->select('*')->from('Student')->where('Class',$class) ->get();
	}
	//for creating students
	public function create_student($data)
	{
		return $this->db->insert('Student',$data);
	}
	//for creating result
	public function create_result($data)
	{
		return $this->db->insert('Result',$data);
	}
	//getting positions
	public function get_position()
	{
		return $this->db->select('*')->from('Position')->group_by('Session')->get();
	}
	//getting position
	public function get_position_session($id)
	{
		return $this->db->select('*')->from('Position')->where('Session',$id)->group_by('Term')->get();
	}
	//getting position
	public function get_position_term($sess,$term)
	{
		return $this->db->select('*')->from('Position')->where('Session',$sess)->where('Term',$term)->group_by('Class')->get();
	}
	//getting position
	public function get_position_class($sess,$term,$class)
	{
		return $this->db->select('*')->from('Position')->where('Session',$sess)->where('Term',$term)->where('Class',$class)->group_by('Student')->get();
	}
	//getting position
	public function get_position_student($sess,$term,$class,$stud)
	{
		return $this->db->select('*')->from('Position')->where('Session',$sess)->where('Term',$term)->where('Class',$class)->where('Student',$stud)->group_by('Result_type')->get();
	}
	//getting position
	public function get_position_student_type($sess,$term,$class,$stud,$type)
	{
		return $this->db->select('*')->from('Position')->where('Session',$sess)->where('Term',$term)->where('Class',$class)->where('Student',$stud)->where('Result_type',$type)->get();

	}
	//for updating site settings
	public function update_site($data)
	{
		return $this->db->set($data)->where('id',1)->update('general_settings');
	}
	//for updating admin profile
	public function update_admin_profile($data,$id)
	{
		return $this->db->set($data)->where('admin_id',$id)->update('Sysadmin');
	}
}