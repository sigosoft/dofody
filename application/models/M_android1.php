<?php

class M_android extends CI_Model
{
  function __construct()
  {
    $this->load->database();
  }
	function getStreams()
  {
    $this->db->select('stream_id,stream_name');
    $this->db->from('stream');
    $res = $this->db->get();
    return $res->result();
  }
  function getSpecial()
  {
    $this->db->select('special_id,special_name,stream_id');
    $this->db->from('specialization');
    $res = $this->db->get();
    return $res->result();
  }
  function getSpecialById($stream_id)
  {
    $this->db->select('special_id,special_name');
    $this->db->from('specialization');
    $this->db->where('stream_id',$stream_id);
    $res = $this->db->get();
    return $res->result();
  }
  function getRequestByDoctorId($id)
  {
    $this->db->select('requests.req_id,requests.present_problem,patients_details.patient_id,patients_details.patient_name,patients_details.dob,patients_details.profile_photo');
    $this->db->from('requests');
    $this->db->join('patients_details','patients_details.patient_id=requests.patient_id');
    $this->db->where('doctor_id',$id);
    $res = $this->db->get();
    return $res->result();
  }
  function getRequestById($request)
  {
    $this->db->select('requests.req_id,requests.present_problem,requests.since_when,patients_details.patient_name,patients_details.profile_photo,patients_details.patient_id,patients_details.p_user_id');
    $this->db->from('requests');
    $this->db->join('patients_details','patients_details.patient_id=requests.patient_id');
    $this->db->where('req_id',$request);
    return $this->db->get()->row();
  }
  function getDoctorsList()
  {
    $this->db->select('dofody_users.user_id,dofody_users.name,dofody_users.place,doctor_fee.audio_fee,doctor_fee.video_fee,doctor_fee.chat_fee,online_users.last_update,doctor_profile.document');
    $this->db->from('dofody_users');
    $this->db->where('dofody_users.user_type','2');
    $this->db->join('doctor_fee','doctor_fee.doctor_id=dofody_users.user_id');
    $this->db->join('online_users','online_users.user=dofody_users.user_id');
    $this->db->join('doctor_profile','doctor_profile.doctor_id=dofody_users.user_id','left outer');
    $this->db->order_by("online_users.last_update", "desc");
    $result=$this->db->get();
    return $result->result();
  }
  function get_stream($doctor)
  {
    $cond = array('doctor_degree.doctor_id' => $doctor , 'doctor_degree.degree_type' => 'stream');
    $this->db->select('stream.stream_name');
    $this->db->from('doctor_degree');
    $this->db->join('stream','doctor_degree.degree_name=stream.stream_id');
    $this->db->where($cond);
    $result=$this->db->get();
    return $result->row();
  }
  function get_special($doctor)
  {
    $cond = array('doctor_degree.doctor_id' => $doctor , 'doctor_degree.degree_type' => 'spec');
    $this->db->select('specialization.special_name');
    $this->db->from('doctor_degree');
    $this->db->join('specialization','doctor_degree.degree_name=specialization.special_id');
    $this->db->where($cond);
    $result=$this->db->get();
    return $result->result();
  }
  function getFamilyMembers($id)
  {
    $this->db->select('patients_details.patient_id,patients_details.patient_name,patients_details.city,patients_details.profile_photo');
    $this->db->from('patients_details');
    $this->db->where('p_user_id',$id);
    $result=$this->db->get();
    return $result->result();
  }
  function getParentDetail($id)
	{
    $this->db->select('*');
    $this->db->from('patients_details');
    $this->db->where('p_user_id',$id);
    $result = $this->db->get();
    return $result->row();
	}
  function getMemberNames($id)
  {
    $this->db->select('patient_id,patient_name');
    $this->db->from('patients_details');
    $this->db->where('p_user_id',$id);
    $result = $this->db->get();
    return $result->result();
  }
  function getImageFiles($id)
  {
    $this->db->select('med_document,patient_id');
    $this->db->from('medical_records');
    $this->db->where('p_user_id',$id);
    $result = $this->db->get();
    return $result->result();
  }
}

?>
