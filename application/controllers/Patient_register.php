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
		redirect('patient-register/verify');
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
	public function change_phone()
	{
		$phone = $_POST['ph'];
		$otp = $this->generate_otp();
		$user_data = $this->session->userdata('data');
		$user_data['otp'] = $otp;
		$user_data['mobile'] = $phone;
		$this->session->set_userdata('data',$user_data);
		if ($this->send_otp($phone,$otp)) {
			$msg = "Mobile number changed , OTP has been sent to ".$phone;
		}
		else {
			$msg = "Failed to sent OTP";
		}
		$this->session->set_flashdata('message', $msg);
		print_r(json_encode(true));
	}
	public function resend_otp()
	{
		$otp = $this->generate_otp();
		$user_data = $this->session->userdata('data');
		$user_data['otp'] = $otp;
		$this->session->set_userdata('data',$user_data);
		if ($this->send_otp($user_data['mobile'],$otp)) {
			$msg = "New OTP has been sent to ".$user_data['mobile'];
		}
		else {
			$msg = "Failed to sent OTP";
		}
		$this->session->set_flashdata('message', $msg);
		echo json_encode(true);
	}
	public function change_password()
	{
		$this->load->view('register/patient/change_pass');
	}
	public function forgot_the_password()
	{
		$mobile = $_POST['mobile'];
		$num = $this->Common->get_details('dofody_users',array('mobile' => $mobile))->num_rows();
		if ($num > 0) {
			$otp = $this->generate_otp();
			if ($this->send_otp($mobile,$otp)) {
				echo $otp;
			}
			else {
				echo "2";
			}
		}
		else {
			echo "1";
		}
	}
	public function forgot_password_change()
	{
		$pass = $this->input->post('password');
		$mobile = $this->input->post('mobile');
		$data['password'] = md5($pass);
		if ($this->Common->update('mobile',$mobile,'dofody_users',$data)) {
			redirect('login');
		}
	}
}

?>
