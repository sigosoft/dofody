<?php

class M_login extends CI_Model
{
  function __construct()
  {
    $this->load->database();
  }
  function get_user_details($data)
  {
    if(is_numeric($data['email']))
    {
        $data['mobile'] = $data['email'];
        unset($data['email']);
    }
    $result = $this->db->get_where('dofody_users',$data)->row();
    return $result;
  }
  function getImage($id)
  {
    $this->db->select('document');
    $this->db->from('doctor_profile');
    $this->db->where('doctor_id',$id);
    $res = $this->db->get();
    return $res;
  }
  function getPatientImage($id)
  {
    $this->db->select('profile_photo');
    $this->db->from('patients_details');
    $this->db->where('p_user_id',$id);
    $this->db->limit(1,0);
    $result=$this->db->get();
    return $result;
  }
}

?>
