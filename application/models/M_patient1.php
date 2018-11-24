<?php

class M_patient extends CI_Model
{
  function __construct()
  {
    $this->load->database();
  }
	function get_patient_details($patient,$user_id)
  {
    $this->db->select('patients_details.patient_name,medical_records.*');
    $this->db->from('patients_details');
    $this->db->join('medical_records','patients_details.patient_id=medical_records.patient_id');
    if ($patient != 0) {
      $this->db->where('medical_records.patient_id',$patient);
    }
    $this->db->where('medical_records.user_id',$user_id);
    $this->db->order_by("medical_records.med_id", "desc");
    $result=$this->db->get();
    return $result->result();
  }
  function get_patient_prescriptions($patient=0,$user_id)
  {
    $this->db->select('patients_details.patient_name,prescriptions.*');
    $this->db->from('patients_details');
    $this->db->join('prescriptions','patients_details.patient_id=prescriptions.patient_id');
    if ($patient != 0) {
      $this->db->where('prescriptions.patient_id',$patient);
    }
    $this->db->where('prescriptions.user_id',$user_id);
    $this->db->order_by("prescriptions.pres_id", "desc");
    $result=$this->db->get();
    return $result->result();
  }
  function get_prescriptions($user,$param)
  {
    $this->db->select('patients_details.patient_name,dofody_users.name,dofody_pres_table.*');
    $this->db->from('dofody_pres_table');
    $this->db->join('patients_details','patients_details.patient_id=dofody_pres_table.patient_id');
    $this->db->join('dofody_users','dofody_users.user_id=dofody_pres_table.doctor_id');
    if ($param != 0) {
      $this->db->where('dofody_pres_table.patient_id',$param);
    }
    $this->db->where('dofody_pres_table.user_id',$user);
    $this->db->order_by("dofody_pres_table.dof_pres_id", "desc");
    $result=$this->db->get();
    return $result->result();
  }
  function get_online_doctors()
  {
    $this->db->select('dofody_users.user_id,dofody_users.name,doctor_fee.audio_fee,doctor_fee.video_fee,doctor_fee.chat_fee,online_users.last_update');
    $this->db->from('dofody_users');
    $this->db->join('doctor_fee','doctor_fee.doctor_id=dofody_users.user_id');
    $this->db->join('online_users','online_users.user=dofody_users.user_id');
    $this->db->where('dofody_users.user_type','2');
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
  function get_patient_past_medical($id)
  {
    $cond = array( 'patient_id' => $id );
    $this->db->select('patients_details.past_medical');
    $this->db->from('patients_details');
    $this->db->where($cond);
    $result = $this->db->get();
    return $result->row();
  }
  function get_requests($user)
  {
    //$cond = array('doctor_degree.doctor_id' => $doctor , 'doctor_degree.degree_type' => 'spec');
    $this->db->select('patients_details.patient_name,requests.*,dofody_users.name');
    $this->db->from('patients_details');
    $this->db->join('requests','patients_details.patient_id=requests.patient_id');
    $this->db->join('dofody_users','dofody_users.user_id=requests.doctor_id');
    $this->db->where('requests.p_user_id',$user);
    $result=$this->db->get();
    return $result->result();
  }
  function get_doctor_name($doctor)
  {
    $cond = array( 'user_id' => $doctor );
    $this->db->select('dofody_users.name');
    $this->db->from('dofody_users');
    $this->db->where($cond);
    $result = $this->db->get();
    return $result->row();
  }
  function get_user_email($id)
  {
    $cond = array( 'user_id' => $id );
    $this->db->select('dofody_users.email');
    $this->db->from('dofody_users');
    $this->db->where($cond);
    $result = $this->db->get();
    return $result->row();
  }
  function getChatDetails($user)
  {
    $this->db->select('requests.req_id,requests.present_problem,dofody_users.name,patients_details.patient_name');
    $this->db->from('requests');
    $this->db->join('dofody_users','dofody_users.user_id=requests.doctor_id');
    $this->db->join('patients_details','patients_details.patient_id=requests.patient_id');
    $this->db->where('requests.p_user_id',$user);
    $this->db->where('requests.type_consult','chat');
    $result=$this->db->get();
    return $result->result();
  }
  function getRequests($user)
  {
    $this->db->select('req_id');
    $this->db->from('requests');
    $this->db->where('p_user_id',$user);
    $this->db->where('type_consult','chat');
    $result=$this->db->get();
    return $result->result();
  }
  function getMessages($request)
  {
    $this->db->select('message,attach,user');
    $this->db->from('messages');
    $this->db->where('request_id',$request);
    $result=$this->db->get();
    return $result->result_array();
  }
  function updateMessageStatus($request)
  {
    $this->db->where('request_id', $request);
    $this->db->where('status !=', '1');
    $this->db->where('user', '0');
    $this->db->update('messages', array('status' => '1'));
  }
  function getNewMessages($request)
  {
    $this->db->select('message,attach,user');
    $this->db->from('messages');
    $this->db->where('request_id',$request);
    $this->db->where('status','0');
    $this->db->where('user','0');
    $result=$this->db->get();
    return $result->result_array();
  }
  function test($id)
  {
    $this->db->select('profile_photo');
    $this->db->from('patients_details');
    $this->db->where('p_user_id',$id);
    $this->db->limit(1,0);
    $result=$this->db->get();
    return $result->result_array();
  }
}

?>
