<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Doctor extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->library('session');
			$this->load->helper('url');
			$this->load->model('Common');
			$this->load->model('M_doctor');
			$ret = is_login();
			if ($ret != 'doctor') {
				redirect('login/login');
			}
	}
	public function index()
	{
		/*date_default_timezone_set('Asia/Kolkata');
		$sess = $this->session->userdata('dof_user');
		$user = $sess['user_id'];
		$requests = $this->M_doctor->getRequestsForCheck($user);
		foreach ($requests as $request) {
			$current = date('Y-m-d H:i:s');
			$start = $request->start_time;
			$consult = new DateTime($start);
			$today = new DateTime($current);
			$interval = $today->diff($consult)->format('%d');
			if ($interval != 0) {
				if ($request->type_consult == 'video') {
					if ($interval >= 1) {
						$this->Common->update('req_id',$request->req_id,'requests',array('status' => 'disabled'));
						$this->Common->delete('calls',array('request_id' => $request->req_id));
					}
				}
				elseif ($request->type_consult == 'audio') {
					if ($interval >= 3) {
						$this->Common->update('req_id',$request->req_id,'requests',array('status' => 'disabled'));
						$this->Common->delete('calls',array('request_id' => $request->req_id));
					}
				}
				elseif ($request->type_consult == 'chat') {
					if ($interval >= 7) {
						$this->Common->update('req_id',$request->req_id,'requests',array('status' => 'disabled'));
						$this->Common->delete('calls',array('request_id' => $request->req_id));
					}
				}
			}
		}*/
		redirect('doctor/profile');
	}
	public function dashboard()
	{
		$this->load->view('doctor/dashboard');
	}
	public function profiles()
	{
		$sess = $this->session->userdata('dof_user');
		$id = $sess['user_id'];
		$data['doc'] = $this->Common->get_details('dofody_users',array('user_id'=>$id))->row();
		$data['identity'] = $this->Common->get_details('doctor_identity',array('doctor_id'=>$id))->row();
		$data['degree'] = $this->Common->get_details('doctor_degree',array('doctor_id'=>$id))->result();
		$data['reg'] = $this->Common->get_details('doctor_reg',array('doctor_id'=>$id))->result();
		$data['bank'] = $this->Common->get_details('doctor_accounts',array('doctor_id'=>$id))->row();
		$data['sign'] = $this->Common->get_details('doctor_signature',array('doctor_id' => $id))->row();
		$this->load->view('doctor/timeline',$data);
	}
	public function requests()
	{
		$sess = $this->session->userdata('dof_user');
		$id = $sess['user_id'];
		$data['req'] = $this->M_doctor->get_requests($id);
		$this->load->view('doctor/requests',$data);
	}
	public function delete_request()
	{
		$id = $this->input->post('record_id');
		$this->Common->delete('video_status',array('patient_id'=>$id));
		redirect('doctor/requests');
	}
	public function clinic($param=0)
	{
		$sess = $this->session->userdata('dof_user');
		$id = $sess['user_id'];
		$data = $this->Common->get_details('doctor_clinic',array('doctor_id' => $id));
		if ($data->num_rows() > 0) {
			$val['cli'] = $cli = $data->row();
			$array = explode(', ',$cli->days);
			foreach ($array as $arr) {
				$val[$arr] = 1;
			}
			$this->load->view('doctor/clinic',$val);
		}
		else {
			$this->load->view('doctor/clinic');
		}
	}
	public function register_clinic()
	{
		$sess = $this->session->userdata('dof_user');
		$id = $sess['user_id'];
		$data = $this->input->post();
		if ($data['bt'] == 1) {
			$ch = implode(", ", $data['check_list']);
			$clinic_details = array(
				'days' => $ch,
				'from_time' => $data['time_from'],
				'to_time' => $data['time_to'],
				'doctor_id' => $id
			);
			if($this->Common->insert('doctor_clinic',$clinic_details))
			{
				redirect('doctor/clinic');
			}
		}
		else {
			$ch = implode(", ", $data['check_list']);
			$clinic_details = array(
				'days' => $ch,
				'from_time' => $data['time_from'],
				'to_time' => $data['time_to'],
				'doctor_id' => $id
			);
			if($this->Common->update('doctor_id',$id,'doctor_clinic',$clinic_details))
			{
				redirect('doctor/clinic');
			}
		}
	}
	public function fee($param=0)
	{
		$sess = $this->session->userdata('dof_user');
		$id = $sess['user_id'];
		$data = $this->Common->get_details('doctor_fee',array('doctor_id' => $id));
		if ($data->num_rows() > 0) {
			$val['fee'] = $data->row();
			$this->load->view('doctor/fee',$val);
		}
		else {
			$this->load->view('doctor/fee');
		}
	}
	public function doctor_fee()
	{
		$sess = $this->session->userdata('dof_user');
		$id = $sess['user_id'];
		$data=$this->input->post();
		$data['doctor_id'] = $id;
		if ($data['bt'] == 1) {
			unset($data['bt']);
			if ($this->Common->insert('doctor_fee',$data)) {
				redirect('doctor/fee');
			}
		}
		else {
			unset($data['bt']);
			if ($this->Common->update('doctor_id',$id,'doctor_fee',$data)) {
				redirect('doctor/fee');
			}
		}
	}
	public function savePrescription()
	{
		$sess = $this->session->userdata('dof_user');
		$id = $sess['user_id'];

		$medicine = $_POST['medicine'];
		$usage = $_POST['usage'];
		$days = $_POST['days'];
		$patient_id = $_POST['patient'];
		$user = $_POST['user'];
		$prescription_table = array('patient_id' => $patient_id , 'user_id' => $user , 'doctor_id' => $id , 'add_date' => date('Y-m-d') );
		$id = $this->Common->insert('dofody_pres_table',$prescription_table);
		$count = count($medicine);
		$i=0;
		while ($i < $count) {
			$arr = array(
				'medicine' => $medicine[$i],
				'usages' => $usage[$i],
				'days' => $days[$i],
				'pres_table_id' => $id
			);
			$this->Common->insert('dofody_prescriptions',$arr);
			$i++;
		}
	}
	public function chat_requests()
	{
		$sess = $this->session->userdata('dof_user');
		$id = $sess['user_id'];
		$data['req'] = $this->M_doctor->get_chat_requests($id);
		$this->load->view('doctor/chat_requests',$data);
	}
	public function view_chat_request($chat_id,$p_id)
	{
		$sess = $this->session->userdata('dof_user');
		$id = $sess['user_id'];

		$data['pat'] = $this->Common->get_details('patients_details',array('patient_id' => $p_id))->row();
		$data['req'] = $this->Common->get_details('chat_requests',array('chat_id' => $chat_id))->row();
		$data['doc'] = $this->Common->get_details('dofody_users',array('user_id' => $id))->row();
		$this->load->view('doctor/view_chat_request',$data);
	}
	public function profile()
	{
		$sess = $this->session->userdata('dof_user');
		$id = $sess['user_id'];
		$this->load->model('M_admin');

		$data['doc'] = $this->Common->get_details('dofody_users',array('user_id'=>$id))->row();
		$data['identity'] = $this->Common->get_details('doctor_identity',array('doctor_id'=>$id))->row();
		$data['stream'] = $this->M_admin->get_stream($id);
		$data['special'] = $this->M_admin->get_special($id);
		$data['sub'] = $this->M_admin->get_sub($id);
		$data['reg'] = $this->Common->get_details('doctor_reg',array('doctor_id'=>$id))->result();
		$data['bank'] = $this->Common->get_details('doctor_accounts',array('doctor_id'=>$id))->row();
		$data['sign'] = $this->Common->get_details('doctor_signature',array('doctor_id' => $id))->row();
		$photo = $this->Common->get_details('doctor_profile',array('doctor_id' => $id));
		if ($photo->num_rows() > 0) {
			$data['photo'] = $photo->row();
		}
		else {
			$data['photo'] = '';
		}
		$this->load->view('doctor/timeline',$data);
	}
	public function myAccount()
	{
		$sess = $this->session->userdata('dof_user');
		$user = $sess['user_id'];
		$data['details'] = $this->Common->get_details('dofody_users',array('user_id'=>$user))->row();
		$this->load->view('doctor/my_account',$data);
	}
	public function general_name_change()
	{
		$sess = $this->session->userdata('dof_user');
		$user = $sess['user_id'];
		$data = $this->input->post();
		$this->Common->update('user_id',$user,'dofody_users',$data);
		redirect('doctor/myAccount');
	}

	public function generalChangePassword()
	{
		$sess = $this->session->userdata('dof_user');
		$user = $sess['user_id'];
		$data = $this->input->post();
		$data['password'] = md5($data['password']);
		$this->Common->update('user_id',$user,'dofody_users',$data);
		redirect('doctor/myAccount');
	}
	public function generalPasswordChange()
	{
		$sess = $this->session->userdata('dof_user');
		$user_id = $sess['user_id'];

		$user = $this->Common->get_details('dofody_users',array('user_id' => $user_id))->row();
		$current = md5($_POST['cur_pass']);
		$new = md5($_POST['pass']);
		if ($user->password == $current) {
			echo true;
		}
		else {
			echo false;
		}
		//echo $current.'  '.$new;
	}
	public function consult_now()
	{
		$sess = $this->session->userdata('dof_user');
		$user = $sess['user_id'];

		$data['req'] = $this->M_doctor->get_all_requests($user);
		$this->load->view('doctor/request_view',$data);
	}
	public function patient_detail_view($param=0)
	{
		$sess = $this->session->userdata('dof_user');
		$user = $sess['user_id'];

		$request = $this->Common->get_details('requests',array('doctor_id' => $user , 'req_id' => $param));
		if ($request->num_rows() > 0) {
			$patient = $request->row()->patient_id;
			$data['info'] = $this->Common->get_details('patients_details',array('patient_id' => $patient))->row();
			$data['records'] = $this->Common->get_details('medical_records',array('patient_id' => $patient))->result();
			$data['req'] = $request->row();
			$this->load->view('doctor/patient_detail_view',$data);
		}
		else {
			$this->load->view('doctor/consult');
		}
	}
	public function delete_requests()
	{
		$data = $this->input->post();
		print_r($data);
	}
	public function start_consultation()
	{
		$type = $this->input->post('type');
		$patient = $this->input->post('patient');
		$req = $this->input->post('req');
		echo $type;
		echo $patient;
		if ($type == 'audio') {
			redirect('doctor/audio_consultation/'.$patient.'/'.$req);
		}
		elseif ($type == 'video') {
			redirect('video/talk_to_patient/'.$patient.'/'.$req);
		}
	}
	public function audio_consultation($param,$req)
	{
		$sess = $this->session->userdata('dof_user');
		$user = $sess['user_id'];

		$request = $this->Common->get_details('requests',array('patient_id' => $param , 'req_id' => $req , 'doctor_id' => $user));
		if ($request->num_rows() > 0) {
			$data['pat'] = $this->Common->get_details('patients_details',array('patient_id' => $param))->row();
			$data['request'] = $req;
			$arr = $this->Common->get_details('calls',array('request_id' => $req))->num_rows();
			if ($arr != 0) {
				$this->Common->update('request_id',$req,'calls',array('doctor_status' => 'away'));
			}
			$this->load->view('doctor/audio_consultation',$data);
		}
		else {
			redirect('doctor/consult_now');
		}
		//echo $param.'---'.$req;
	}
	public function video_consultation($param,$req)
	{
		$sess = $this->session->userdata('dof_user');
		$user = $sess['user_id'];

		$request = $this->Common->get_details('requests',array('patient_id' => $param , 'req_id' => $req , 'doctor_id' => $user));
		if ($request->num_rows() > 0) {
			$arr = $request->row();
			$data['request'] = $req;
			$data['details'] = $arr;
			$this->load->view('doctor/video_consultation',$data);
		}
		else {
			redirect('doctor/consult_now');
		}
	}
	public function chats()
	{
		$sess = $this->session->userdata('dof_user');
		$user = $sess['user_id'];

		$data['chats'] = $this->M_doctor->getChatDetails($user);
		$this->load->view('doctor/chats',$data);
	}

	public function send_message()
	{
		$data = array(
			'message' => $_POST['message'],
			'attach' => 'text',
			'user' => '0',
			'request_id' => $_POST['request'],
			'status' => '0'
		);
		$this->Common->insert('messages',$data);
	}
	public function getMessages()
	{
		$sess = $this->session->userdata('dof_user');
		$user = $sess['user_id'];
		$data = array();
		$req = $this->M_doctor->getRequests($user);
		foreach ($req as $r) {
			$key = $r->req_id;
			$data[$key] = $this->M_doctor->getMessages($r->req_id);
			$this->M_doctor->updateMessageStatus($r->req_id);
		}
		echo json_encode($data);
	}
	public function checkMessages()
	{
		$sess = $this->session->userdata('dof_user');
		$user = $sess['user_id'];
		$data = array();
		$req = $this->M_doctor->getRequests($user);
		foreach ($req as $r) {
			$key = $r->req_id;
			$data[$key] = $this->M_doctor->getNewMessages($r->req_id);
			$this->M_doctor->updateMessageStatus($r->req_id);
		}
		echo json_encode($data);
	}
	public function uploadProfilePhoto()
	{
		$photo = $_POST['photo'];
		$image = substr($photo, strpos($photo, ",") + 1);
		$sess = $this->session->userdata('dof_user');
		$user = $sess['user_id'];

		$type = 'insert';
		$profile = $this->Common->get_details('doctor_profile',array('doctor_id' => $user));
		if ($profile->num_rows() > 0) {
			$row = $profile->row();
			unlink(FCPATH . $row->document);
			$type = 'update';
		}

		$url = FCPATH.'uploads/profile/';
		$rand='doctor'.date('Ymd').mt_rand(1001,9999);
		$userpath = $url.$rand.'.png';
		$path = "uploads/profile/".$rand.'.png';
		file_put_contents($userpath,base64_decode($image));
		if ($type == 'insert') {
			$array = array(
				'document' => $path,
				'doctor_id' => $user
			);
			$this->Common->insert('doctor_profile',$array);
		}
		else {
			$this->Common->update('doctor_id',$user,'doctor_profile',array('document' => $path));
		}
		redirect('doctor/profile');
	}
	public function ongoing_history()
	{
		$sess = $this->session->userdata('dof_user');
		$user = $sess['user_id'];
		$data['requests'] = $this->M_doctor->getOnGoingHistory($user);
		$this->load->view('doctor/ongoing_history',$data);
	}
	public function completed_history()
	{
		$sess = $this->session->userdata('dof_user');
		$user = $sess['user_id'];
		$data['requests'] = $this->M_doctor->getCompletedHistory($user);
		$this->load->view('doctor/completed_history',$data);
	}
	public function ongoing_history_view($param)
	{
		$sess = $this->session->userdata('dof_user');
		$user = $sess['user_id'];

		$result = $this->Common->get_details('requests',array('doctor_id' => $user,'req_id' => $param));
		if ($result->num_rows() > 0) {
			$details = $this->M_doctor->getRequestDetails($param);
			if ($details->dob != '0000-00-00') {
				date_default_timezone_set('Asia/Kolkata');
				$today = date('Y-m-d');
				$dob = $details->dob;
				$start = new DateTime($dob);
				$end = new DateTime($today);
				$interval = $end->diff($start)->format('%y');
				$details->age = $interval;
			}
			else {
				$details->age = 'Not given';
			}
			$data['details'] = $details;
			if ($details->type_consult != 'chat') {
				$data['history'] = $this->Common->get_details('history',array('request_id' => $param))->result();
				$this->load->view('doctor/ongoing_history_view',$data);
			}
			else {
				$data['sent'] = $this->Common->get_details('messages',array('request_id' => $param,'user' => '0'))->num_rows();
				$data['recieved'] = $this->Common->get_details('messages',array('request_id' => $param,'user' => '1'))->num_rows();
				$this->load->view('doctor/ongoing_history_view_chat',$data);
			}
		}
		else {
			redirect('doctor/ongoing_history');
		}
		//echo $param;
	}
	public function completed_history_view($param)
	{
		$sess = $this->session->userdata('dof_user');
		$user = $sess['user_id'];

		$result = $this->Common->get_details('requests',array('doctor_id' => $user,'req_id' => $param));
		if ($result->num_rows() > 0) {
			$details = $this->M_doctor->getRequestDetails($param);
			if ($details->dob != '0000-00-00') {
				date_default_timezone_set('Asia/Kolkata');
				$today = date('Y-m-d');
				$dob = $details->dob;
				$start = new DateTime($dob);
				$end = new DateTime($today);
				$interval = $end->diff($start)->format('%y');
				$details->age = $interval;
			}
			else {
				$details->age = 'Not given';
			}
			$data['details'] = $details;
			if ($details->type_consult != 'chat') {
				$data['history'] = $this->Common->get_details('history',array('request_id' => $param))->result();
				$this->load->view('doctor/completed_history_view',$data);
			}
			else {
				$data['sent'] = $this->Common->get_details('messages',array('request_id' => $param,'user' => '0'))->num_rows();
				$data['recieved'] = $this->Common->get_details('messages',array('request_id' => $param,'user' => '1'))->num_rows();
				$this->load->view('doctor/completed_history_view_chat',$data);
			}
		}
		else {
			redirect('doctor/completed_history');
		}
	}
	public function sendNotification()
	{
		$SERVER_API_KEY = "AIzaSyCkxpi7KkKhNuvkBV0l6up6ci_r3FeD09A";
		$token = ['dNC0hcXqV_s:APA91bGuoGEgZ4NND8jI2Iu3zig9nJxTgPHU_2B4tW1jz9vJ-xAdxPZMVHj-v99PpfPaxo30B5MFdQXPYPm5FZnmbO2y0f57T3lmwHSq-JXH0tWjv1q3qw7pcEdi4cvR5fQoGcKZ2wR_'];
		$header = [
			'Authorization: key='. $SERVER_API_KEY,
			'Content-Type: Application/json'
		];
		$msg = [
			'title' => 'Testing notification',
			'body' => 'testing notification body',
			'icon' => '',
			'image' => '',
			'request' => 2
		];
		$payload = [
			'registration_ids' => $token,
			'data' => $msg
		];
		$url = 'https://fcm.googleapis.com/fcm/send';

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => json_encode($payload),
		  CURLOPT_HTTPHEADER => $header,
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		  echo $response;
		}
	}
}
