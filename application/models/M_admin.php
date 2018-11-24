<?php

class M_admin extends CI_Model
{
  function __construct()
  {
    $this->load->database();
  }
	function get_doctors($data)
  {
    $result = $this->db->get_where('dofody_users',$data)->row();
    return $result;
  }
  function get_stream($doc)
  {
    $this->db->select('stream.stream_name,doctor_degree.*');
    $this->db->from('doctor_degree');
    $this->db->join('stream','stream.stream_id=doctor_degree.degree_name');
    $this->db->where('doctor_degree.doctor_id',$doc);
    $this->db->where('doctor_degree.degree_type','stream');
    $result=$this->db->get();
    return $result->row();
  }
  function get_special($doc)
  {
    $this->db->select('specialization.special_name,doctor_degree.*');
    $this->db->from('doctor_degree');
    $this->db->join('specialization','specialization.special_id=doctor_degree.degree_name');
    $this->db->where('doctor_degree.doctor_id',$doc);
    $this->db->where('doctor_degree.degree_type','spec');
    $result=$this->db->get();
    return $result->result();
  }
  function get_sub($doc)
  {
    $this->db->select('sub_specialization.sub_name,doctor_degree.*');
    $this->db->from('doctor_degree');
    $this->db->join('sub_specialization','sub_specialization.sub_id=doctor_degree.degree_name');
    $this->db->where('doctor_degree.doctor_id',$doc);
    $this->db->where('doctor_degree.degree_type','sub');
    $result=$this->db->get();
    return $result->result();
  }
  function getQuickRequests()
  {
    $this->db->select('patients_details.patient_name,patients_details.dob,patients_details.city,patients_details.profile_photo,requests.*');
    $this->db->from('patients_details');
    $this->db->join('requests','patients_details.patient_id=requests.patient_id');
    $this->db->where('requests.doctor_id','quick');
    $result=$this->db->get();
    return $result->result();
  }
  function getOnGoingHistory()
  {
    $this->db->select('patients_details.patient_name,patients_details.profile_photo,requests.req_id,requests.present_problem,requests.type_consult,dofody_users.name,requests.date,requests.time');
    $this->db->from('requests');
    $this->db->join('patients_details','patients_details.patient_id=requests.patient_id');
    $this->db->join('dofody_users','dofody_users.user_id=requests.doctor_id');
    $this->db->where('requests.status','enabled');
    $this->db->order_by("requests.req_id", "desc");
    $result=$this->db->get();
    return $result->result();
  }
  function getCompletedHistory()
  {
    $this->db->select('patients_details.patient_name,patients_details.profile_photo,requests.req_id,requests.present_problem,requests.type_consult,dofody_users.name,requests.date,requests.time');
    $this->db->from('requests');
    $this->db->join('patients_details','patients_details.patient_id=requests.patient_id');
    $this->db->join('dofody_users','dofody_users.user_id=requests.doctor_id');
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
  function getConsultType($req)
  {
    $this->db->select('requests.type_consult');
    $this->db->from('requests');
    $this->db->where('requests.req_id',$req);
    return $this->db->get()->row()->type_consult;
  }
  function delete_requests($status)
  {
    $this->db->select('deleted_accounts.*,dofody_users.*');
    $this->db->from('deleted_accounts');
    $this->db->join('dofody_users','deleted_accounts.user_id=dofody_users.user_id');
    $this->db->where('deleted_accounts.status',$status);
    $result=$this->db->get();
    return $result->result();
  }
  function getRequestsInRange($doctor)
  {
    $end = date('Y-m-d');
		$start = date('Y-m-d', strtotime($end.' - 29 days'));

    $this->db->select('req_id,type_consult');
    $this->db->from('requests');
    $this->db->where('date >',$start);
    $this->db->where('date <=',$end);
    $this->db->where('doctor_id',$doctor);
    $checks = $this->db->get()->result();

    $audio = 0;
		$video = 0;
		$chat = 0;
		foreach ($checks as $check) {
			if ($check->type_consult == 'audio') {
				$audio = $audio + 1;
			}
			elseif ($check->type_consult == 'video') {
				$video = $video + 1;
			}
			else
			{
				$chat = $chat + 1;
			}
		}
    $result = [
      'chat' => $chat,
      'video' => $video,
      'audio' => $audio
    ];
    return $result;
  }
  function getNewRequests()
  {
      $this->db->select('requests.*,dofody_users.name,patients_details.patient_name,dofody_users.mobile');
      $this->db->from('requests');
      $this->db->join('dofody_users','requests.doctor_id=dofody_users.user_id');
      $this->db->join('patients_details','requests.patient_id=patients_details.patient_id');
      $this->db->where('requests.status_time','0');
      $result=$this->db->get();
      return $result->result();
  }
}

?>
