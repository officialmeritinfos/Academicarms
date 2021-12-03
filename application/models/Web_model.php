<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Web_model extends CI_Model {
	//general system settings
	public function general_settings()
	{
		return $this->db->select('*')->from('general_settings')->where('id',1)->get();
	}
	//check if pin number exists
	public function pin_exist($pin)
	{
		return $this->db->select('*')->from('Result_pins')->where('Pin_number',$pin)->get();
	}
	//check if serial number and pin matches
	public function serial_pin_exist($pin,$serial)
	{
		return $this->db->select('*')->from('Result_pins')->where('Pin_number',$pin)->where('Serial_number',$serial)->get();
	}
	//get pin usage details
	public function Pin_use($pin)
	{
		return $this->db->select('*')->from('Pin_usage')->where('Pin_id',$pin)->get();
	}
	//getting student value
	public function Student($username)
	{
		return $this->db->select('*')->from('Student')->where('Reg_no',$username)->get();
	}
	//getting published results
	public function result_published($student_id,$class,$semester,$session)
	{
		return $this->db->select('*')->from('Result')->where('Student',$student_id)->where('Class',$class)->where('Session',$session)->where('Semester',$semester)->where('Status',1)->get();
	}
	//getting published positions
	public function position_published($student_id,$class,$semester,$session,$result_type)
	{
		return $this->db->select('*')->from('Position')->where('Student',$student_id)->where('Class',$class)->where('Session',$session)->where('Term',$semester)->where('Result_type',$result_type)->get();
	}
	//update in usage
	public function update_pin_usage($data)
	{
		return $this->db->insert('Pin_usage',$data);
	}
	//getting student result
	public function results_published($student_id,$class,$semester,$session)
	{
		return $this->db->select('*')->from('Result')->join('Subject','Subject.Subject_id=Result.Subject')->join('Classes','Classes.Class_id=Result.Class')->join('Student','Student.Student_id=Result.Student')->join('Semester','Semester.Semester_id=Result.Semester')->join('Session','Session.Session_id=Result.Session')->where('Result.Student',$student_id)->where('Result.Class',$class)->where('Result.Session',$session)->where('Result.Semester',$semester)->where('Result.Status',1)->get();
	}
}