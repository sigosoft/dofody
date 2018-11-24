<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Register_doctor extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->helper('url');
			$this->load->library('session');
			$this->load->model('Common');
	}
	public function index()
	{
		$this->load->view('register/doctor/register');
	}
	function get_session()
	{
		$user_data = $this->session->userdata('data');
		return $user_data;
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
			redirect('register_doctor/verify_phone');
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
	public function verify_phone()
	{
		$this->load->view('register/doctor/verify_phone');
	}
	public function verify_otp()
	{
		if (isset($_POST['otp'])) {
			$otp = $this->input->post('otp');
			$user_data = $this->session->userdata('data');
			if ( $user_data['otp'] == $otp ) {
				redirect('register-doctor/upload');
			}
			else {
				redirect('register-doctor/verify-phone');
			}
		}
		else {
			redirect('register-doctor/verify-phone');
		}
	}
	public function upload()
	{
		$this->load->view('register/doctor/upload');
	}
	public function identity_upload()
	{
		$this->load->view('register/doctor/photo_id');
	}
	public function photo_upload()
	{
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
				redirect('register-doctor/upload');
			}
	}
	public function degree_certificate()
	{
		$data['stream'] = $this->Common->get_details('stream',array())->result();
		$this->load->view('register/doctor/graduate_file',$data);
	}
	public function degree_cert()
	{
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
			redirect('register-doctor/upload');

	}
	public function registration_certificate()
	{
		$this->load->view('register/doctor/reg_file');
	}
	public function reg_cert()
	{
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
			redirect('register-doctor/upload');
	}
	public function bank_details()
	{
		$this->load->view('register/doctor/bank_account');
	}
	public function bank_det()
	{
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
				redirect('register-doctor/upload');
			}
	}
	public function signature()
	{
		$this->load->view('register/doctor/signature');
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
		redirect('register-doctor/upload');
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
		$fee = $this->Common->get_details('quick_fee',array('fee_id' => 1))->row();
		$this->Common->insert('doctor_fee',array('audio_fee' => $fee->audio_fee , 'video_fee' => $fee->video_fee , 'chat_fee' => $fee->chat_fee , 'doctor_id' => $id));
		$this->session->sess_destroy();
		redirect('register-doctor/registration-complete');
	}
	public function registration_complete()
	{
		$this->load->view('register/doctor/thanks');
	}
}

?>
