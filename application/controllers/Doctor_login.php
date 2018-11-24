<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Doctor_login extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->helper('url');
			$this->load->library('session');
			$this->load->model('M_login');
			$this->load->model('Common');
	}
	public function index()
	{
		$this->load->view('login/doctor_login');
	}
	public function check()
	{
		if (isset($_POST['email']) && isset($_POST['password'])) {
			$data = $this->input->post();
			$token = $data['token'];
			unset($data['token']);
			$data['password'] = md5($data['password']);
			$user = $this->M_login->get_user_details($data);
			if ($user) {
				if ($user->user_status == '2') {
					$this->session->set_flashdata('message', 'Temporarily unavailable..!');
					redirect('doctor_login');
				}
				elseif($user->user_status == '3')
				{
				    $this->session->set_flashdata('message', 'Invalid username or password');
						redirect('doctor-login');
				}
				else {
					$type = $user->user_type;
					if ($type == '2') {
						$profile = $this->M_login->getImage($user->user_id);
						if ($profile->num_rows() > 0) {
							$img = base_url() . $profile->row()->document;
						}
						else {
							$img = base_url().'uploads/profile/doctor.jpeg';
						}
						$dof_user=array(
								'user' => $user->name,
								'user_type' => 2,
								'user_id' => $user->user_id,
								'profile' => $img
							);
						if(isset($token)){
						    $array = [
						      'firebase_id' => $token,
						      'type' => 'web',
						      'user_id' => $user->user_id
						    ];
						}
						else
						{
						  $array = [
						      'firebase_id' => 'nil',
						      'type' => 'web',
						      'user_id' => $user->user_id
						    ];  
						}
						$check = $this->Common->get_details('device_ids',array('user_id' => $user->user_id));
						if($check->num_rows() > 0)
						{
						    $this->Common->update('user_id',$user->user_id,'device_ids',$array);
						}
						else
						{
						    $this->Common->insert('device_ids',$array);
						}
						$this->session->set_userdata('dof_user',$dof_user);
						redirect('doctor');
					}
					else {
						$this->session->set_flashdata('message', 'Invalid username or password');
						redirect('doctor-login');
					}
				}
			}
			else {
				$this->session->set_flashdata('message', 'Invalid username or password');
				redirect('doctor-login');
			}
		}
		else {
			redirect('doctor-login');
		}
	}
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('doctor-login');
	}
}

?>
