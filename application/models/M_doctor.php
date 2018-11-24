<?php

class M_doctor extends CI_Model
{
  function __construct()
  {
    $this->load->database();
  }
  function get_requests($id)
  {
    $this->db->select('video_status.room_name,patients_details.*');
    $this->db->from('video_status');
    $this->db->join('patients_details','patients_details.patient_id=video_status.patient_id');
    $this->db->where('video_status.doctor_id',$id);
    $result=$this->db->get();
    return $result->result();
  }
  function get_chat_requests($id)
  {
    $this->db->select('chat_requests.chat_id,chat_requests.chat_status,chat_requests.patient_id,patients_details.patient_name,patients_details.patient_name,patients_details.gender');
    $this->db->from('chat_requests');
    $this->db->join('patients_details','patients_details.patient_id=chat_requests.patient_id');
    $this->db->where('chat_requests.doctor_id',$id);
    $result=$this->db->get();
    return $result->result();
  }
  function get_all_requests($user)
  {
    $this->db->select('patients_details.patient_name,patients_details.dob,patients_details.city,patients_details.profile_photo,requests.*');
    $this->db->from('requests');
    $this->db->join('patients_details','patients_details.patient_id=requests.patient_id');
    $this->db->where('requests.doctor_id',$user);
    $this->db->where('requests.status','enabled');
    $this->db->order_by("requests.req_id", "desc");
    $result=$this->db->get();
    return $result->result();
  }
  function getChatDetails($user)
  {
    $this->db->select('patients_details.patient_name,patients_details.profile_photo,requests.present_problem,requests.req_id');
    $this->db->from('patients_details');
    $this->db->join('requests','patients_details.patient_id=requests.patient_id');
    $this->db->where('requests.doctor_id',$user);
    $this->db->where('requests.type_consult','chat');
    $result=$this->db->get();
    return $result->result();
  }
  function getChatIds($user)
  {
    $this->db->select('requests.req_id');
    $this->db->from('requests');
    $this->db->where('doctor_id',$user);
    $this->db->where('type_consult','chat');
    $result=$this->db->get();
    return $result->result_array();
  }
  function getRequests($user)
  {
    $this->db->select('req_id');
    $this->db->from('requests');
    $this->db->where('doctor_id',$user);
    $this->db->where('type_consult','chat');
    $result=$this->db->get();
    return $result->result();
  }
  function getMessages($request)
  {
    $this->db->select('message,user,date,time');
    $this->db->from('messages');
    $this->db->where('request_id',$request);
    $result=$this->db->get();
    return $result->result_array();
  }
  function updateMessageStatus($request)
  {
    $this->db->where('request_id', $request);
    $this->db->where('status !=', '1');
    $this->db->where('user', '1');
    $this->db->update('messages', array('status' => '1'));
  }
  function getNewMessages($request)
  {
    $this->db->select('message,attach,user');
    $this->db->from('messages');
    $this->db->where('request_id',$request);
    $this->db->where('status','0');
    $this->db->where('user','1');
    $result=$this->db->get();
    return $result->result_array();
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
  function getOnGoingHistory($id)
  {
    $this->db->select('patients_details.patient_name,patients_details.profile_photo,requests.req_id,requests.present_problem,requests.type_consult,prescriptions.prescription_id');
    $this->db->from('requests');
    $this->db->join('patients_details','patients_details.patient_id=requests.patient_id');
    $this->db->join('prescriptions','prescriptions.request_id=requests.req_id','left outer');
    $this->db->where('requests.doctor_id',$id);
    $this->db->where('requests.status','enabled');
    $this->db->order_by("requests.req_id", "desc");
    $result=$this->db->get();
    return $result->result();
  }
  function getCompletedHistory($id)
  {
    $this->db->select('patients_details.patient_name,patients_details.profile_photo,requests.req_id,requests.present_problem,requests.type_consult,requests.status,prescriptions.prescription_id');
    $this->db->from('requests');
    $this->db->join('patients_details','patients_details.patient_id=requests.patient_id');
    $this->db->join('prescriptions','prescriptions.request_id=requests.req_id','left outer');
    $this->db->where('requests.doctor_id',$id);
    $this->db->where('requests.status','disabled');
    $this->db->order_by("requests.req_id", "desc");
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
  function getLastInserted($id)
  {
    $this->db->select('history_id');
    $this->db->from('history');
    $this->db->where('request_id',$id);
    $this->db->order_by("history_id", "desc");
    $this->db->limit(1);
    return $this->db->get()->row()->history_id;
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
    return $result->result_array();
  }
  function getDoctorName($doctor)
  {
    $this->db->select('dofody_users.name,dofody_users.place,doctor_signature.signature');
    $this->db->from('dofody_users');
    $this->db->join('doctor_signature','dofody_users.user_id=doctor_signature.doctor_id');
    $this->db->where('user_id',$doctor);
    return $this->db->get()->row();
  }
  function getHistoryDetails($pid)
  {
    $this->db->select('*');
    $this->db->from('prescriptions');
    $this->db->where('prescription_id',$pid);
    return $this->db->get()->row();
  }
  function getPatientDetails($p_id)
  {
    $this->db->select('patient_name,gender,dob');
    $this->db->from('patients_details');
    $this->db->where('patient_id',$p_id);
    return $this->db->get()->row();
  }
  function getHistoryDetailsChat($pres_id)
  {
    $this->db->select('*');
    $this->db->from('prescriptions');
    $this->db->where('prescription_id',$pres_id);
    return $this->db->get()->row();
  }
  function getFirebaseId($req)
  {
    $this->db->select('requests.doctor_id,device_ids.firebase_id,device_ids.type');
    $this->db->from('requests');
    $this->db->join('device_ids','device_ids.user_id=requests.p_user_id');
    $this->db->where('requests.req_id',$req);
    return $this->db->get()->row();
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
  function getRequestsByDoctorId($doctor)
  {
    $this->db->select('requests.req_id,patients_details.patient_name,patients_details.profile_photo');
    $this->db->from('requests');
    $this->db->join('patients_details','patients_details.patient_id=requests.patient_id');
    $this->db->where('requests.doctor_id',$doctor);
    $this->db->where('requests.type_consult','chat');
    $this->db->where('requests.status','enabled');
    $requests = $this->db->get()->result();

    foreach ($requests as $request) {
      if ($request->profile_photo == 'nil') {
        $request->profile_photo = "uploads/profile/user.png";
      }
    }
    return $requests;
  }
  function getLastSendMessage($request_id)
  {
    $this->db->select('message,date,time');
    $this->db->from('messages');
    $this->db->where('request_id',$request_id);
    $this->db->where('user','0');
    $this->db->order_by('message_id','desc');
    $this->db->limit(1);
    $message = $this->db->get();

    if ($message->num_rows() > 0) {
      $array = [
        'message' => $message->row()->message,
        'date' => $message->row()->date,
        'time' => $message->row()->time
      ];
      return $array;
    }
    else {
      return false;
    }
  }
  function getLastTransactions($doctor_id)
  {
    $this->db->select('transactions.fee,patients_details.patient_name,requests.type_consult,requests.date');
    $this->db->from('transactions');
    $this->db->join('requests','transactions.request_id=requests.req_id');
    $this->db->join('patients_details','patients_details.patient_id=requests.patient_id');
    $this->db->where('requests.doctor_id',$doctor_id);
    $this->db->order_by('transactions.trans_id','desc');
    $this->db->limit(10);
    return $this->db->get()->result();
  }
}

?>
