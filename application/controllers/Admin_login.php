<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_login extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->helper('url');
			$this->load->library('session');
			$this->load->model('M_login');
	}
	public function index()
	{
		$this->load->view('login/admin_login');
	}
	public function check()
	{
		if (isset($_POST['email']) && isset($_POST['password'])) {
			$data = $this->input->post();
			$data['password'] = md5($data['password']);
			$user = $this->M_login->get_user_details($data);
			if ($user) {
				if ($user->user_status == '2') {
					$this->session->set_flashdata('message', 'Temporarily unavailable..!');
					redirect('admin_login');
				}
				else {
					$type = $user->user_type;
					if ($type == '1') {
						$dof_user=array(
								'user' => $user->name,
								'user_type' => 1,
								'user_id' => $user->user_id
							);
						$this->session->set_userdata('dof_user',$dof_user);
						redirect('admin');
					}
					else {
						$this->session->set_flashdata('message', 'Invalid username or password');
						redirect('admin-login');
					}
				}
			}
			else {
				$this->session->set_flashdata('message', 'Invalid username or password');
				redirect('admin-login');
			}
		}
		else {
			redirect('admin-login');
		}
	}
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('admin-login');
	}
}

?>
