<?php
  function pr($data)
  {
    echo "<pre>";
	  print_r($data);
	  echo "</pre>";
	  die();
  }
  function is_login()
  {
    $ci =& get_instance();
	  $ci->load->library('session');
	  $user = $ci->session->userdata('dof_user');
    if (isset($user)) {
      if ($user['user_type'] == 1) {
        return 'admin';
      }
      elseif ($user['user_type'] == 2) {
        return 'doctor';
      }
      elseif ($user['user_type'] == 3) {
        return 'patient';
      }
    }
    else {
      return false;
    }
  }
  function get_session()
  {
    $ci =& get_instance();
	  $ci->load->library('session');
	  $user = $ci->session->userdata('dof_user');
    return $user;
  }
 ?>
