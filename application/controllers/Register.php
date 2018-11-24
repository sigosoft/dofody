<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
class Register extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->library('session');
			$this->load->helper('url');
			$this->load->model('Common');
	}
	public function index()
	{
		$this->load->view('register/start');
	}
	public function login($param=0)
	{
		if ($param == 0) {
			$this->load->view('register/login');
		}
		else {
			$this->load->view('register/login_patient');
		}
	}
	public function register($param=0)
	{
		if ($param == 0) {
			$this->load->view('register/register');
		}
		else {
			$this->load->view('register/register_patient');
		}

	}
	public function reg()
	{
		$dt = $this->input->post();
		$otp = $this->generate_otp();
		$user_data = array(
			'name' => $dt['txt_name'],
			'mobile' => $dt['txt_phone'],
			'email' => $dt['txt_email'],
			'place' => $dt['txt_city'],
			'password' => md5($dt['txt_pass']),
			'user_type' => 2,
			'user_status' => 2,
			'add_date' => date('Y-m-d'),
			'otp' => $otp
		);
		$this->session->set_userdata('data',$user_data);
		if ($this->send_otp($user_data['mobile'],$otp)) {
			redirect('register/verify_phone');
		}
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
			redirect('register/verify_patient');
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
	function get_session()
	{
		$user_data = $this->session->userdata('data');
		return $user_data;
	}
	function set_session($data)
	{
		$this->session->set_userdata('data',$data);
		return true;
	}
	public function verify_phone($param=0)
	{
		if ($param==0) {
			$this->load->view('register/verify_phone');
		}
		elseif ($param == 1) {
			redirect('register/upload');
		}
	}
	public function verify_patient($param=0)
	{
		if ($param==0) {
			$this->load->view('register/verify_patient');
		}
		elseif ($param == 1) {
			$data = $this->session->userdata('data');
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
			redirect('register/login/1');
		}
	}
	public function resend_otp()
	{
		$otp = $this->generate_otp();
		$user_data = $this->session->userdata('data');
		$user_data['otp'] = $otp;
		$this->session->set_userdata('data',$user_data);
		$array = array(
			'otp' => $otp,
			'phone' => $user_data['mobile']
		);
		$this->send_otp($user_data['mobile'],$otp);
		echo json_encode($array);
	}
	public function change_phone($param=0)
	{
		if ($param==0) {
			$this->load->view('register/change_phone');
		}
		elseif ($param==1) {
			$phone = $this->input->post('txt_phone');
			$otp = $this->generate_otp();
			$user_data = $this->session->userdata('data');
 			$user_data['otp'] = $otp;
			$user_data['mobile'] = $phone;
			$this->session->set_userdata('data',$user_data);
			$this->send_otp($phone,$otp);
			redirect('register/verify_phone');
		}
	}
	public function change_phone_patient($param=0)
	{
		if ($param==0) {
			$this->load->view('register/change_phone_patient');
		}
		elseif ($param==1) {
			$phone = $this->input->post('txt_phone');
			$otp = $this->generate_otp();
			$user_data = $this->session->userdata('data');
 			$user_data['otp'] = $otp;
			$user_data['mobile'] = $phone;
			$this->session->set_userdata('data',$user_data);
			$this->send_otp($phone,$otp);
			redirect('register/verify_patient');
		}
	}
	public function upload()
	{
		$this->load->view('register/upload');
	}
	public function photo_upload($param=0)
	{
		if ($param==0) {
			$this->load->view('register/photo_id');
		}
		elseif ($param==1) {
			$type_id = $this->input->post('identity');
			$format = $this->input->post('format');
			$file=$_FILES['txtimage'];
			$tar = "uploads/doc_id/";
			$rand=date('Ymd').mt_rand(1001,9999);
			$tar_file = $tar . $rand . basename($file['name']);
			if(move_uploaded_file($file["tmp_name"], $tar_file))
			{
				$identity=array(
					'type_of_id' => $type_id,
					'identity' => $tar_file,
					'format' => $format
				);
				$this->session->set_userdata('identity',$identity);
				redirect('register/upload');
			}

		}
	}
	public function get_special_by_stream()
	{
		$stream = $_POST['str_id'];
		$data = $this->Common->get_details('specialization',array('stream_id' => $stream))->result();
		echo json_encode($data);
	}
	public function get_sub_special_by_stream()
	{
		$stream = $_POST['str_id'];
		$data = $this->Common->get_details('sub_specialization',array('stream_id' => $stream))->result();
		echo json_encode($data);
	}

	public function degree_cert($param=0)
	{
		if ($param==0) {
			$data['stream'] = $this->Common->get_details('stream',array())->result();
			$this->load->view('register/graduate_file',$data);
		}
		elseif ($param==1) {
			$data = $this->input->post();
			extract($data);
			$gradu = array();
			$graduation = $_FILES['grad_file'];
			$tar = "uploads/doc_degree/";
			$rand=date('Ymd').mt_rand(1001,9999);
			$tar_file = $tar . $rand . basename($graduation['name']);
			if(move_uploaded_file($graduation["tmp_name"], $tar_file))
			{
				if ( $graduation["type"] == 'application/pdf') {
					$type = 'pdf';
				}
				else {
					$type = 'image';
				}
				$arr = array(
					'degree_type' => 'stream',
					'degree_name' => $stream,
					'college' => $college_deg,
					'pass_year' => $mark_deg,
					'university' => $university_deg,
					'doc_degree' => $tar_file,
					'format' => $type
				);
				array_push($gradu,$arr);
			}

			if (isset( $_FILES['special_file']) ) {
				$sp = $_FILES['special_file'];
				$i=0;
				$count = count($sp['name']);
				while($i < $count)
				{
					$tar = "uploads/doc_degree/";
					$rand=date('Ymd').mt_rand(1001,9999);
					$tar_file = $tar . $rand . basename($sp['name'][$i]);
					if(move_uploaded_file($sp['tmp_name'][$i], $tar_file))
					{
						if ( $sp["type"][$i] == 'application/pdf') {
							$type = 'pdf';
						}
						else {
							$type = 'image';
						}
						$arr = array(
							'degree_type' => 'spec',
							'degree_name' => $special_id[$i],
							'college' => $special_college[$i],
							'pass_year' => $special_perf[$i],
							'university' => $special_univer[$i],
							'doc_degree' => $tar_file,
							'format' => $type
						);
						array_push($gradu,$arr);
					}
					$i++;
				}
			}

			$this->session->set_userdata('graduation',$gradu);
			redirect('register/upload');

		}
	}
	public function reg_cert($param=0)
	{
		if ($param==0) {
			$this->load->view('register/reg_file');
		}
		elseif ($param==1) {
			$registration = array();
			$data = $this->input->post();
			extract($data);
			$reg = $_FILES['reg'];
			$i = 0;
			$count = count($reg_number);

			while($i < $count)
			{
				$tar = "uploads/doc_reg/";
				$rand=date('Ymd').mt_rand(1001,9999);
				$tar_file = $tar . $rand . basename($reg['name'][$i]);
				if(move_uploaded_file($reg["tmp_name"][$i], $tar_file))
				{
					if ( $reg["type"][$i] == 'application/pdf') {
						$type = 'pdf';
					}
					else {
						$type = 'image';
					}
					$input=array(
						'reg_number' => $reg_number[$i],
						'reg_council' => $council[$i],
						'doc_reg' => $tar_file,
						'format' => $type
					);
					array_push($registration,$input);
				}
				$i++;
			}
			$this->session->set_userdata('registration',$registration);
			redirect('register/upload');

		}
	}
	public function bank_details($param=0)
	{
		if ($param==0) {
			$this->load->view('register/bank_account');
		}
		elseif ($param==1) {
			$data = $this->input->post();
			extract($data);
			$type = $this->input->post('type_bank');
			$sess = $this->get_session();
			$bank = $_FILES['bank'];
			$tar = "uploads/doc_bank/";
			$rand=date('Ymd').mt_rand(1001,9999);
			$tar_file = $tar . $rand . basename($bank['name']);
			if(move_uploaded_file($bank["tmp_name"], $tar_file))
			{
				$arr = array(
					'acc_bank' => $name,
					'acc_holder' => $holder,
					'acc_number' => $number,
					'acc_ifsc' => $ifsc,
					'document_type' => $type,
					'doc_account' => $tar_file,
					'format' => $format
				);
				$this->session->set_userdata('bank_details',$arr);
				redirect('register/upload');
			}
		}
	}
	public function register_user()
	{
		$data = $this->session->userdata('data');
	  $identity = $this->session->userdata('identity');
	  $graduation = $this->session->userdata('graduation');
	  $registration = $this->session->userdata('registration');
	  $bank_details = $this->session->userdata('bank_details');
		$signature = $this->session->userdata('signature');
		unset($data['otp']);
		$id = $this->Common->insert('dofody_users',$data);
		$time = date('Y-m-d H:i:s');
		$this->Common->insert('online_users',array('user' => $id , 'last_update' => $time , 'type' => '2'));
		//$online_status = $this->Common->insert('online_users');
		$identity['doctor_id'] = $id;
		$this->Common->insert('doctor_identity',$identity);

		foreach ($graduation as $degree) {
			$degree['doctor_id'] = $id;
			$this->Common->insert('doctor_degree',$degree);
		}

		foreach ($registration as $reg) {
			$reg['doctor_id'] = $id;
			$this->Common->insert('doctor_reg',$reg);
		}

		$bank_details['doctor_id'] = $id;
		$this->Common->insert('doctor_accounts',$bank_details);
		$signature['doctor_id'] = $id;
		$this->Common->insert('doctor_signature',$signature);
		$this->session->sess_destroy();
		redirect('register/show_register_success');
	}
	function show_register_success()
	{
		$this->load->view('register/thanks');
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
	public function clinic()
	{
		/*$data = array(
			'doctor_id' => $param1,
			'security_key' => $param2
		);*/
		// SEND DATA TO THE VIEW
		$this->load->view('register/setup_clinic');
	}
	public function register_clinic()
	{
		$data = $this->input->post();
		$doc = 12;
		$ch = implode(", ", $data['check_list']);
		$clinic_details = array(
			'days' => $ch,
			'from_time' => $data['time_from'],
			'to_time' => $data['time_to'],
			'doctor_id' => $doc
		);
		$this->session->set_userdata('doc',$doc);
		if($this->Common->insert('doctor_clinic',$clinic_details))
		{
			redirect('register/doctor_fee');
		}
	}
	public function doctor_fee($param=0)
	{
		if ($param==0) {
			$this->load->view('register/doctor_fee');
		}
		elseif($param==1) {
			$data = $this->input->post();
			extract($data);
			$fee = array(
				'video_fee' => $video,
				'audio_fee' => $audio,
				'chat_fee' => $chat
			);
			$doc = $this->session->userdata('doc');
			if($this->Common->update('doctor_id',$doc,'doctor_clinic',$fee))
			{
				redirect('register/register_complete');
			}
		}

	}
	public function register_complete()
	{
		$this->load->view('register/register_complete');
	}
	public function destroy_session()
	{
		$this->session->sess_destroy();
		echo 'ok';
	}
	public function generalMobileChange()
	{
		$mobile = $_POST['mobile'];
		$num = $this->Common->get_details('dofody_users',array('mobile' => $mobile))->num_rows();
		if ($num > 0) {
			echo "1";
		}
		else {
			$otp = $this->generate_otp();
			if ($this->send_otp($mobile,$otp)) {
				echo $otp;
			}
			else {
				echo "failed";
			}
		}
	}
	public function forgot_password()
	{
		$this->load->view('register/forgot_password');
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
		$data = $this->input->post();
		extract($data);
		unset($data['mobile']);
		$data['password'] = md5($password);
		if ($this->Common->update('mobile',$mobile,'dofody_users',$data)) {
			redirect('register');
		}
	}
	public function signature()
	{
		$this->load->view('register/signature');
	}
	public function doctors_signature()
	{
		$data = $this->input->post();
		extract($data);
		$sig = substr($signature, strpos($signature, ",") + 1);

		$url = FCPATH.'uploads/signature/';
		$rand='signature'.date('Ymd').mt_rand(1001,9999);
		$userpath = $url.$rand.'.png';
		$path = "uploads/signature/".$rand.'.png';
		file_put_contents($userpath,base64_decode($sig));
		unset($signature);
		$signature = array(
			'signature' => $path
		);
		$this->session->set_userdata('signature',$signature);
		redirect('register/upload');
	}
}
