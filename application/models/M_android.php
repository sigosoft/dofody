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
    $this->db->where('requests.doctor_id',$id);
    $this->db->where('requests.status','enabled');
    $this->db->order_by('requests.req_id','desc');
    $res = $this->db->get();
    return $res->result();
  }
  function getChatRequestByDoctorId($id)
  {
    $this->db->select('requests.req_id,requests.present_problem,patients_details.patient_id,patients_details.patient_name,patients_details.dob,patients_details.profile_photo');
    $this->db->from('requests');
    $this->db->join('patients_details','patients_details.patient_id=requests.patient_id');
    $this->db->where('requests.doctor_id',$id);
    $this->db->where('requests.status','enabled');
    $this->db->where('type_consult','chat');
    $this->db->order_by('requests.req_id','desc');
    $res = $this->db->get();
    return $res->result();
  }
  function getRequestById($request)
  {
    $this->db->select('requests.req_id,requests.present_problem,requests.since_when,requests.type_consult,requests.date,requests.time,patients_details.patient_name,patients_details.profile_photo,patients_details.patient_id,patients_details.p_user_id,,patients_details.city');
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
    $this->db->where('user_id',$id);
    $this->db->where('med_title !=','Electronic medical record');
    $result = $this->db->get();
    return $result->result();
  }
  function getPatientId($id)
  {
    $this->db->select('p_user_id');
    $this->db->from('requests');
    $this->db->where('req_id',$id);
    $result = $this->db->get();
    return $result->row()->p_user_id;
  }
  function getPastMedical($id)
  {
    $this->db->select('patient_name,past_medical');
    $this->db->from('patients_details');
    $this->db->where('patient_id',$id);
    $result = $this->db->get();
    return $result->row();
  }
  function getListOfDoctors()
  {
    $this->db->select('dofody_users.user_id,dofody_users.name,dofody_users.place,doctor_fee.audio_fee,doctor_fee.video_fee,doctor_fee.chat_fee,doctor_profile.document');
    $this->db->from('dofody_users');
    $this->db->where('dofody_users.user_type','2');
    $this->db->join('doctor_fee','doctor_fee.doctor_id=dofody_users.user_id');
    $this->db->join('doctor_profile','doctor_profile.doctor_id=dofody_users.user_id','left outer');
    $result=$this->db->get();
    return $result->result();
  }
  function getRecordsPatientById($id)
  {
    $this->db->select('*');
    $this->db->from('medical_records');
    $this->db->where('patient_id',$id);
    $this->db->order_by("med_id", "desc");
    $res = $this->db->get();
    return $res->result();
  }
  function getLastInserted($id)
  {
    $this->db->select('history_id');
    $this->db->from('history');
    $this->db->where('request_id',$id);
    $this->db->order_by("history_id", "desc");
    $this->db->limit(1);
    return $this->db->get()->row()->history_id;
  }
  function getHistoryPatient($id)
  {
    $this->db->select('patients_details.patient_name,patients_details.profile_photo,requests.req_id,requests.present_problem,requests.type_consult,requests.status');
    $this->db->from('requests');
    $this->db->join('patients_details','patients_details.patient_id=requests.patient_id');
    $this->db->where('requests.p_user_id',$id);
    $this->db->order_by("requests.req_id", "asc");
    $result=$this->db->get();
    return $result->result();
  }
  function getHistoryDoctor($id)
  {
    $this->db->select('patients_details.patient_name,patients_details.profile_photo,requests.req_id,requests.present_problem,requests.type_consult,requests.status');
    $this->db->from('requests');
    $this->db->join('patients_details','patients_details.patient_id=requests.patient_id');
    $this->db->where('requests.doctor_id',$id);
    $this->db->order_by("requests.req_id", "asc");
    $result=$this->db->get();
    return $result->result();
  }
  function getRequestDetails($param)
  {
    $this->db->select('patients_details.patient_name,patients_details.profile_photo,patients_details.height,patients_details.weight,patients_details.dob,patients_details.gender,requests.req_id,requests.present_problem,requests.since_when,requests.type_consult');
    $this->db->from('requests');
    $this->db->join('patients_details','patients_details.patient_id=requests.patient_id');
    $this->db->where('requests.req_id',$param);
    $result=$this->db->get();
    return $result->row();
  }
  function getChatRequestsDoctor($doctor)
  {
    $this->db->select('patients_details.patient_name,patients_details.profile_photo,requests.present_problem,requests.req_id');
    $this->db->from('patients_details');
    $this->db->join('requests','patients_details.patient_id=requests.patient_id');
    $this->db->where('requests.doctor_id',$doctor);
    $this->db->where('requests.type_consult','chat');
    $result=$this->db->get();
    return $result->result();
  }
  function getChatRequestsPatient($patient)
  {
    $this->db->select('requests.req_id,requests.present_problem,dofody_users.name,doctor_profile.document');
    $this->db->from('requests');
    $this->db->join('dofody_users','dofody_users.user_id=requests.doctor_id');
    $this->db->join('doctor_profile','doctor_profile.doctor_id=requests.doctor_id','left outer');
    $this->db->where('requests.p_user_id',$patient);
    $this->db->where('requests.type_consult','chat');
    $result=$this->db->get();
    return $result->result();
  }
  function getMessages($request,$user)
  {
    $this->db->select('message,date,time');
    $this->db->from('messages');
    $this->db->where('user',$user);
    $this->db->where('status','0');
    $this->db->where('request_id',$request);
    return $this->db->get();
  }
  function updateMessageStatusD($request)
  {
    $this->db->where('request_id', $request);
    $this->db->where('status', '0');
    $this->db->where('user', '1');
    $this->db->update('messages', array('status' => '1'));
  }
  function updateMessageStatusP($request)
  {
    $this->db->where('request_id', $request);
    $this->db->where('status', '0');
    $this->db->where('user', '0');
    $this->db->update('messages', array('status' => '1'));
  }
  function getFirebaseIdD($req)
  {
    $this->db->select('requests.doctor_id,device_ids.firebase_id,device_ids.type');
    $this->db->from('requests');
    $this->db->join('device_ids','device_ids.user_id=requests.doctor_id');
    $this->db->where('requests.req_id',$req);
    return $this->db->get()->row();
  }
  function getFirebaseIdP($req)
  {
    $this->db->select('requests.p_user_id,device_ids.firebase_id,device_ids.type');
    $this->db->from('requests');
    $this->db->join('device_ids','device_ids.user_id=requests.p_user_id');
    $this->db->where('requests.req_id',$req);
    return $this->db->get()->row();
  }
  function getFeeByDoctorId($doctor,$type)
  {
      $this->db->select('*');
      $this->db->from('doctor_fee');
      $this->db->where('doctor_id',$doctor);
      $result = $this->db->get()->row();
      if($type == 'audio')
      {
          return $result->audio_fee;
      }
      elseif($type == 'video')
      {
          return $result->video_fee;
      }
      else
      {
          return $result->chat_fee;
      }
  }
  function getRequestsForCheck($id)
  {
    $this->db->select('req_id,type_consult,start_time');
    $this->db->from('requests');
    $this->db->where('doctor_id',$id);
    $this->db->where('status','enabled');
    $result=$this->db->get();
    return $result->result();
  }
  function getRequestIds($doctor)
  {
    $this->db->select('req_id');
    $this->db->from('requests');
    $this->db->where('doctor_id',$doctor);
    return $this->db->get()->result();
  }
  function checkHistoryExists($req)
  {
    $this->db->select('history_id');
    $this->db->from('history');
    $this->db->where('request_id',$req);
    $this->db->where('type','call');
    $this->db->limit(1);
    $result = $this->db->get();
    if($result->num_rows() > 0)
    {
        return true;
    }
    else
    {
        return false;
    }
  }
  function getFees($doctor)
  {
    $this->db->select('fee');
    $this->db->from('transactions');
    $this->db->where('doctor_id',$doctor);
    return $this->db->get()->result();
  }
  function getAllPrescriptionsOfPatients($patient_id)
  {
    $this->db->select('prescriptions.prescription_id,prescriptions.request_id,prescriptions.pro_diagonosis');
    $this->db->from('prescriptions');
    $this->db->join('requests','requests.req_id=prescriptions.request_id');
    $this->db->where('requests.patient_id',$patient_id);
    $result=$this->db->get();
    return $result->result();
  }
  function getDoctorNameByRequestId($request_id)
  {
      $this->db->select('dofody_users.name');
      $this->db->from('requests');
      $this->db->join('dofody_users','requests.doctor_id=dofody_users.user_id');
      $this->db->where('requests.req_id',$request_id);
      return $this->db->get()->row()->name;
  }
  function getLastRequestByPatientId($p_user_id)
  {
     $this->db->select('requests.req_id,requests.present_problem,requests.since_when,requests.past_medical,requests.type_consult');
     $this->db->from('requests');
     $this->db->where('status_time','1');
     $this->db->where('status','enabled');
     $this->db->where('p_user_id',$p_user_id);
     $this->db->order_by('req_id','desc');
     return $this->db->get()->result(); 
  }
}

?>
