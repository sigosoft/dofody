<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
class Patient_register extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->helper('url');
			$this->load->library('session');
			$this->load->model('Common');
	}
	public function index()
	{
		$this->load->view('register/patient/register');
	}
	public function reg_patient()
	{
		$dt = $this->input->post();
		$otp = $this->generate_otp();
		$user_data = array(
			'name' => $dt['txt_name'],
			'mobile' => $dt['txt_phone'],
			'email' => $dt['txt_email'],
			'place' => $dt['txt_city'],
			'password' => md5($dt['txt_pass']),
			'user_type' => 3,
			'user_status' => 1,
			'add_date' => date('Y-m-d'),
			'otp' => $otp
		);
		extract($user_data);
		$this->session->set_userdata('data',$user_data);
		if ($this->send_otp($mobile,$otp)) {
			redirect('patient-register/verify');
		}
	}
	function generate_otp()
	{
		$rand = rand(11111,99999);
		return $rand;
	}
	function send_otp($number,$otp)
	{
		$resp = file_get_contents("http://sms2.sigosoft.com/pushsms.php?username=DOFODY&api_password=0f41e1kgicw6vvw70&sender=DOFODY&to=".$number."&message=Your%20Dofody%20verification%20code%20is%20:%20".$otp.".&priority=11");
		return $resp;
	}
	public function validate_phone()
	{
		$phone = $_POST['ph'];
		$data = array('mobile' => $phone);
		$num = $this->Common->get_details('dofody_users',$data)->num_rows();
		if ($num > 0) {
			echo '0';
		}
		else {
			echo '1';
		}
	}
	public function validate_email()
	{
		$email = $_POST['email'];
		$data = array('email' => $email);
		$num = $this->Common->get_details('dofody_users',$data)->num_rows();
		if ($num > 0) {
			echo '0';
		}
		else {
			echo '1';
		}
	}
	public function verify()
	{
		$this->load->view('register/patient/verify');
	}
	public function register_patient()
	{
		$data = $this->session->userdata('data');
		if ($data['otp'] != $_POST['otp']) {
			redirect('patient-register/verify');
		}
		unset($data['otp']);
		$user_id = $this->Common->insert('dofody_users',$data);
		$patient = array(
			'patient_name' => $data['name'],
			'city' => $data['place'],
			'patient_mobile' => $data['mobile'],
			'patient_email' => $data['email'],
			'profile_photo' => 'nil',
			'p_user_id' => $user_id
		);
		$this->Common->insert('patients_details',$patient);
		$time = date('Y-m-d H:i:s');
		$online_values = array('user' => $user_id , 'last_update' => $time , 'type' => '3');
		$this->Common->insert('online_users',$online_values);
		$this->session->sess_destroy();
		redirect('login');
	}
}

?>
