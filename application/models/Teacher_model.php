<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teacher_model extends CI_Model {

	//checking if email exists
	public function email_real($email)
	{
		return $this->db->select('*')->from('Teacher')->where('Email',$email)->get();
	}
	//getting loggedin teacher
	public function Teacher_details($id,$sess)
	{
		return $this->db->select('*')->from('Teacher')->where('Teacher_id',$id)->where('TeacherSess',$sess)->get();
	}
	//getting classes
	public function get_classes($teacherclass)
	{
		return $this->db->select('*')->from('Classes')->where('Class_id',$teacherclass)->order_by('Name','ASC')->get();
	}
	//for updating result
	public function update_result($data,$id)
	{
		return $this->db->set($data)->where('Result_id',$id)->update('Result');
	}
	//getting result type
	public function get_result_type()
	{
		return $this->db->select('*')->from('Result_type')->order_by('Name','ASC')->get();
	}
	//for updating positions
	public function update_position($data,$id)
	{
		return $this->db->set($data)->where('Position_id',$id)->update('Position');
	}
	//getting Subjects
	public function get_subject($class)
	{
		return $this->db->select('*')->from('Subject_combination')->join('Subject','Subject.Subject_id=Subject_combination.Subject')->where('Class',$class)->order_by('Subject_id','ASC')->get();
	}
	//getting students in class
	public function get_students_class($class)
	{
		return $this->db->select('*')->from('Student')->where('Class',$class) ->get();
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
	//getting result
	public function get_result($class)
	{
		return $this->db->select('*')->from('Result')->where('Class',$class)->group_by('Session')->get();
	}
	//getting result
	public function get_result_session($id,$class)
	{
		return $this->db->select('*')->from('Result')->where('Session',$id)->where('Class',$class)->group_by('Semester')->get();

	}
	//getting result
	public function get_result_term($sess,$term,$class)
	{
		return $this->db->select('*')->from('Result')->where('Session',$sess)->where('Semester',$term)->where('Class',$class)->group_by('Class')->get();

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
	public function get_position($class)
	{
		return $this->db->select('*')->from('Position')->where('Class',$class)->group_by('Session')->get();
	}
	//getting position
	public function get_position_session($id,$class)
	{
		return $this->db->select('*')->from('Position')->where('Session',$id)->where('Class',$class)->group_by('Term')->get();
	}
	//getting position
	public function get_position_term($sess,$term,$class)
	{
		return $this->db->select('*')->from('Position')->where('Session',$sess)->where('Term',$term)->where('Class',$class)->group_by('Class')->get();
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
}