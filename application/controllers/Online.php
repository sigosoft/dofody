<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
class Online extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->library('session');
			$this->load->helper('url');
			$this->load->model('Common');
	}
	public function update_time()
	{
		$sess = $this->session->userdata('dof_user');
		$id = $sess['user_id'];
		date_default_timezone_set('Asia/Kolkata');
		$time = date('Y-m-d H:i:s');
		$this->Common->update('user',$id,'online_users',array('last_update' => $time));
	}
	public function updateOnlineStatus()
	{
	    $id = $_POST['user_id'];
	    date_default_timezone_set('Asia/Kolkata');
		$time = date('Y-m-d H:i:s');
		$this->Common->update('user',$id,'online_users',array('last_update' => $time));
	}
}
?>
