<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Redir extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->helper('url');
			$this->load->model('Common');
	}
	public function route($id)
	{
		$user = $this->Common->get_details('dofody_users',array('user_id' => $id))->row();
		if ($user->user_type == '2') {
			redirect('doctor');
		}
		elseif($user->user_type == '3') {
			redirect('patient/profile');
		}
	}

}

?>
