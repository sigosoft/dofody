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
				redirect('doctor-login');
			}
	}
	public function index()
	{
		date_default_timezone_set('Asia/Kolkata');
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
					}
				}
				elseif ($request->type_consult == 'audio') {
					if ($interval >= 3) {
						$this->Common->update('req_id',$request->req_id,'requests',array('status' => 'disabled'));
					}
				}
				elseif ($request->type_consult == 'chat') {
					if ($interval >= 7) {
						$this->Common->update('req_id',$request->req_id,'requests',array('status' => 'disabled'));
					}
				}
			}
		}
		redirect('doctor/dashboard');
	}
	public function dashboard()
	{
	    $sess = $this->session->userdata('dof_user');
		$doctor_id = $sess['user_id'];
		$data['count_pending'] = $this->getPendingRequestsCount($doctor_id);
		$array = $this->getConsultationDetails($doctor_id);
		$data['earnings'] = $array['earning'];
		$data['count_consultations'] = $array['number'];
		$data['blogs'] = $this->getBlogPosts();
		$data['messages'] = $this->getLatestMessages($doctor_id);
		$data['transactions'] = $this->getLastTransactions($doctor_id);
		$this->load->view('doctor/dashboard',$data);
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
			$val['days'] = $array;
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
			$info = $this->Common->get_details('patients_details',array('patient_id' => $patient))->row();
			if($info->dob != '0000-00-00')
			{
			    $info->dob = date("d/m/Y", strtotime($info->dob));
			}
			else
			{
			    $info->dob = '';
			}
			$data['info'] = $info;
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
		//echo $type;
		//echo $patient;
		if ($type == 'audio') {
			redirect('audio/consult/'.$patient.'/'.$req);
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
			'user' => '0',
			'request_id' => $_POST['request'],
			'status' => '0',
			'date' => date('d/m/Y'),
			'time' => date('h:i a')
		);
		$this->Common->insert('messages',$data);
		$res = $this->M_doctor->getFirebaseId($data['request_id']);
		$SERVER_API_KEY = "AIzaSyAwhY1F4XKWgtY63JosZL2lGp3MEK6hhPQ";
		if($res->type == 'android')
		{
		    $url = "https://dofody.com/notification/message.php";
    	    $pass = [
    	        'token' => $res->firebase_id,
    	        'request_id' => $data['request'],
    	        'message' => $data['message'],
    	        'user' => '0',
    	        'timestamp' => date('d/m/Y H:i:s a'),
    	        'date' => date('d/m/Y'),
    	        'time' => date('h:i a')
    	        ];
    	    $handle = curl_init($url);
            curl_setopt($handle, CURLOPT_POST, true);
            curl_setopt($handle, CURLOPT_POSTFIELDS, $pass);
            $response = curl_exec($handle);
            $err = curl_error($handle);
    
    		curl_close($handle);
    
    		if ($err) {
    		  echo "cURL Error #:" . $err;
    		} else {
    		  echo $response;
    		}
		}
		else
		{
		    $msg = [
    			'title' => 'Testing notification',
    			'body' => 'testing notification body',
    			'icon' => '',
    			'image' => '',
    			'type' => 'chat',
    			'request' => $data['request_id'],
    			'message' => $data['message'],
    			'date' => date('d/m/y'),
    			'time' => date('h:i a')
    		];
		}
    		$token = [$res->firebase_id];
    		$header = [
    			'Authorization: key='. $SERVER_API_KEY,
    			'Content-Type: Application/json'
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
		$val = $this->M_doctor->getOnGoingHistory($user);
		$i = 0;
		$his = array();
		foreach ($val as $dat) {
			$num = $this->Common->get_details('history',array('request_id' => $dat->req_id))->num_rows();
			if ($num > 1) {
				$his[$i] = $dat;
				$i++;
			}
		}
		$data['requests'] = $his;
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
				$history = $this->Common->get_details('history',array('request_id' => $param,'type' => 'call'))->result();
				foreach($history as $his)
				{
				    $his->date = date("d/m/Y", strtotime($his->date));
				}
				$data['history'] = $history;
				$this->load->view('doctor/ongoing_history_view',$data);
			}
			else {
				$data['sent'] = $this->Common->get_details('messages',array('request_id' => $param,'user' => '0'))->num_rows();
				$data['recieved'] = $this->Common->get_details('messages',array('request_id' => $param,'user' => '1'))->num_rows();
				$data['prescriptions'] = $this->Common->get_details('prescriptions',array('request_id' => $param))->result();
				$this->load->view('doctor/ongoing_history_view_chat',$data);
			}
		}
		else {
			redirect('doctor/ongoing_history');
		}
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
				$history = $this->Common->get_details('history',array('request_id' => $param, 'type' => 'call'))->result();
				foreach($history as $his)
				{
				    $his->date = date("d/m/Y", strtotime($his->date));
				}
				$data['history'] = $history;
				$this->load->view('doctor/completed_history_view',$data);
			}
			else {
				$data['sent'] = $this->Common->get_details('messages',array('request_id' => $param,'user' => '0'))->num_rows();
				$data['recieved'] = $this->Common->get_details('messages',array('request_id' => $param,'user' => '1'))->num_rows();
				$data['prescriptions'] = $this->Common->get_details('prescriptions',array('request_id' => $param))->result();
				$this->load->view('doctor/completed_history_view_chat',$data);
			}
		}
		else {
			redirect('doctor/completed_history');
		}
	}
	public function sendNotification()
	{
		$request = $_POST['request'];
		$user_id = $_POST['user_id'];
		$res = $this->Common->get_details('device_ids',array('user_id' => $user_id))->row();
		/*$SERVER_API_KEY = "AIzaSyAwhY1F4XKWgtY63JosZL2lGp3MEK6hhPQ";
		$token = [$val->firebase_id];
		$header = [
			'Authorization: key='. $SERVER_API_KEY,
			'Content-Type: Application/json'
		];
		$msg = [
			'title' => 'Testing notification',
			'body' => 'testing notification body',
			'icon' => '',
			'image' => '',
			'request' => $request
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
		}*/
		if($res->type == 'android')
	    {
	        $url = "https://dofody.com/notification/testing_notification.php";
    	    $data = [
    	        'token' => $res->firebase_id,
    	        'request_id' => $request
    	        ];
    	    $handle = curl_init($url);
            curl_setopt($handle, CURLOPT_POST, true);
            curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
            $response = curl_exec($handle);
            $err = curl_error($handle);
    
    		curl_close($handle);
    
    		if ($err) {
    		  echo "cURL Error #:" . $err;
    		} else {
    		  echo $response;
    		}
	    }
	    else
	    {
	        $SERVER_API_KEY = "AIzaSyAwhY1F4XKWgtY63JosZL2lGp3MEK6hhPQ";
    		$token = [$res->firebase_id];
    		$header = [
    			'Authorization: key='. $SERVER_API_KEY,
    			'Content-Type: Application/json'
    		];
    		$msg = [
    			'title' => 'Testing notification',
    			'body' => 'testing notification body',
    			'icon' => '',
    			'image' => '',
    			'type' => 'call',
    			'request' => $request
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
	public function addHistory()
	{
		$data = [
			'date' => date('Y-m-d'),
			'time' => date('H:i:s'),
			'type' => 'missed call'
		];
		$data['request_id'] = $_POST['request'];
		$this->Common->insert('history',$data);
		print_r(json_encode(true));
	}
	public function updateTime()
	{
		$id = $_POST['request_id'];
		$duration = $_POST['timer'];
		$hid = $this->M_doctor->getLastInserted($id);
		$arr = ['duration' => $duration];
		if ($this->Common->update('history_id',$hid,'history',$arr)) {
			print_r(json_encode(true));
		}
	}
	public function addPrescription()
	{
		$data = $this->input->post();
		$date = date('Y-m-d');
		extract($data);
		$i = 0;
		$prescription = ['pro_diagonosis' => $pro_diagonosis , 'date' => $date , 'request_id' => $request_id];
		$id = $this->Common->insert('prescriptions',$prescription);
		foreach ($medicine as $med) {
			$array = [];
			$array = ['medicine' => $med, 'usages' => $usage[$i], 'days' => $days[$i], 'prescription_id' => $id ];
			$this->Common->insert('medicines',$array);
			$i++;
		}
		if (isset($cmp)) {
			redirect('doctor/completed_history');
		}
		redirect('doctor/ongoing_history');
	}
	public function editPrescription()
	{
		$data = $this->input->post();
		extract($data);
		$this->Common->delete('medicines',array('prescription_id' => $pres_id));
		$date = date('Y-m-d');
		$prescription = ['pro_diagonosis' => $pro_diagonosis , 'date' => $date];
		$this->Common->update('prescription_id',$pres_id,'prescriptions',$prescription);
		$i = 0;
		foreach ($medicine as $med) {
			$array = [];
			$array = ['medicine' => $med, 'usages' => $usage[$i], 'days' => $days[$i], 'prescription_id' => $pres_id ];
			$this->Common->insert('medicines',$array);
			$i++;
		}
		if (isset($cmp)) {
			redirect('doctor/completed_history');
		}
		redirect('doctor/ongoing_history');
	}
	public function view_prescription($req,$pres_id)
	{
		$sess = $this->session->userdata('dof_user');
		$user = $sess['user_id'];

		$data = $this->Common->get_Details('requests',array('req_id' => $req , 'doctor_id' => $user));
		if ($data->num_rows() > 0) {
			$doctor = $data->row()->doctor_id;
			$doc = $this->M_doctor->getDoctorName($doctor);
			$doc->stream = $this->M_doctor->get_stream($doctor)->stream_name;
			$special = $this->M_doctor->get_special($doctor);
			$specialization = '';
			foreach ($special as $key) {
				$specialization = $specialization.$key['special_name'].',';
			}
			$doc->special = rtrim($specialization,',');
			$p_id = $data->row()->patient_id;
			$history = $this->M_doctor->getHistoryDetails($pres_id);
			$history->date = date("d/m/Y", strtotime($history->date));
			$patient = $this->M_doctor->getPatientDetails($p_id);

			if ($patient->gender == 'm') {
				$patient->gender = 'Male';
			}
			elseif ($patient->gender == 'f') {
				$patient->gender = 'Female';
			}
			else {
				$patient->gender = 'Other';
			}
			if ($patient->dob != '0000-00-00') {
				$today = date('Y-m-d');
				$dob = $patient->dob;
				$start = new DateTime($dob);
				$end = new DateTime($today);
				$interval = $end->diff($start)->format('%y');
				$patient->age = $interval;
			}
			else {
				$patient->age = 'Not given';
			}
			$medicines = $this->Common->get_details('medicines',array('prescription_id' =>$history->prescription_id ))->result();
			$data = [
								'doctor' => $doc,
								'patient' => $patient,
								'history' => $history,
								'medicines' => $medicines
							];
			$this->load->view('doctor/prescription',$data);
		}
		else {
			redirect('doctor/ongoing_history_view/'.$request_id);
		}
	}
	public function addChatPrescription()
	{
		$data = $this->input->post();
		$date = date('Y-m-d');
		extract($data);
		$i = 0;
		$prescription = ['pro_diagonosis' => $pro_diagonosis , 'date' => $date , 'request_id' => $request_id];
		$id = $this->Common->insert('prescriptions',$prescription);
		foreach ($medicine as $med) {
			$array = [];
			$array = ['medicine' => $med, 'usages' => $usage[$i], 'days' => $days[$i], 'prescription_id' => $id ];
			$this->Common->insert('medicines',$array);
			$i++;
		}
		redirect('doctor/ongoing_history_view/'.$request_id);
	}
	public function viewChatPrescription($req,$pres_id)
	{
		$sess = $this->session->userdata('dof_user');
		$user = $sess['user_id'];

		$data = $this->Common->get_Details('requests',array('req_id' => $req , 'doctor_id' => $user));
		if ($data->num_rows() > 0) {
			$doctor = $data->row()->doctor_id;
			$doc = $this->M_doctor->getDoctorName($doctor);
			$doc->stream = $this->M_doctor->get_stream($doctor)->stream_name;
			$special = $this->M_doctor->get_special($doctor);
			$specialization = '';
			foreach ($special as $key) {
				$specialization = $specialization.$key['special_name'].',';
			}
			$doc->special = rtrim($specialization,',');
			$p_id = $data->row()->patient_id;
			$history = $this->M_doctor->getHistoryDetailsChat($pres_id);
			$patient = $this->M_doctor->getPatientDetails($p_id);

			if ($patient->gender == 'm') {
				$patient->gender = 'Male';
			}
			elseif ($patient->gender == 'f') {
				$patient->gender = 'Female';
			}
			else {
				$patient->gender = 'Other';
			}
			if ($patient->dob != '0000-00-00') {
				$today = date('Y-m-d');
				$dob = $patient->dob;
				$start = new DateTime($dob);
				$end = new DateTime($today);
				$interval = $end->diff($start)->format('%y');
				$patient->age = $interval;
			}
			else {
				$patient->age = 'Not given';
			}
			$medicines = $this->Common->get_details('medicines',array('prescription_id' =>$history->prescription_id ))->result();
			$data = [
								'doctor' => $doc,
								'patient' => $patient,
								'history' => $history,
								'medicines' => $medicines
							];
			$this->load->view('doctor/prescription',$data);
		}
	}
	public function edit_bank_details()
	{
		$sess = $this->session->userdata('dof_user');
		$user = $sess['user_id'];

		$data['bank'] = $this->Common->get_details('doctor_accounts',array('doctor_id' => $user))->row();
		$this->load->view('doctor/edit_bank',$data);
	}
	public function edit_bank()
	{
		$sess = $this->session->userdata('dof_user');
		$user = $sess['user_id'];
		$array = $this->input->post();

		$bank = $_FILES['bank'];
		if ($bank['name'] == '') {
			'No image selected';
		}
		else {
			$tar = "uploads/doc_bank/";
			$rand=date('Ymd').mt_rand(1001,9999);
			$tar_file = $tar . $rand . basename($bank['name']);
			if(move_uploaded_file($bank["tmp_name"], $tar_file))
			{
				$array['doc_account'] = $tar_file;
			}
		}
		if($this->Common->update('doctor_id',$user,'doctor_accounts',$array))
		{
			redirect('doctor');
		}
		else {
			redirect('doctor');
		}
	}
	public function getPrescription()
	{
		$id = $_POST['prescription_id'];
		$head = "<tr><td style='text-align : center;'>Medicine</td><td style='text-align : center;'>Usage</td><td style='text-align : center;'>Day</td><td></td></tr>";
		$body = '';
		$data = $this->Common->get_details('medicines',array('prescription_id' => $id))->result();
		foreach ($data as $key) {
			$body =$body."<tr>
			  <td><input type='text' class='form-control' placeholder='Eg : Paracetamol' name='medicine[]' value='".$key->medicine."' required></td>
			  <td><input type='text' class='form-control' placeholder='Eg : 1-1-1' name='usage[]' value='".$key->usages."' required></td>
			  <td><input type='text' class='form-control' placeholder='Eg : 5 days' name='days[]' value='".$key->days."' required></td>
			  <td><a class='btn btn-link' onclick='deleteRowEdit(this);'><i style='font-size:25px; color:red;' class='fa fa-minus-circle'></i></a></td>
			</tr>";
		}
		$final = $head.$body;
		$return['table'] = $final;
		$return['provisional'] = $this->Common->get_details('prescriptions',array('prescription_id' => $id))->row()->pro_diagonosis;
		print_r(json_encode($return));
	}
	public function delete_req()
	{
		$sess = $this->session->userdata('dof_user');
		$user = $sess['user_id'];
		$data = $this->input->post();
		$pass = md5($data['password']);
		unset($data['password']);
		$data['user_id'] = $user;
		$data['status'] = 'request';
		$check = $this->Common->get_details('dofody_users',array('user_id' => $user , 'password' => $pass))->num_rows();
		if ($check > 0) {
			$submit = $this->Common->get_details('deleted_accounts',array('user_id' => $user))->num_rows();
			if ($submit > 0) {
				$this->session->set_flashdata('message', 'Your request was already submited');
			}
			else {
				if ($this->Common->insert('deleted_accounts',$data)) {
					$this->session->set_flashdata('message', 'Your request was submited');
				}
				else {
					$this->session->set_flashdata('message', 'Failed to send the rquests');
				}
			}
		}
		else {
			$this->session->set_flashdata('message', 'Invalid password');
		}
		redirect('doctor/myAccount');
	}
	
	public function getPendingRequestsCount($doctor_id)
	{
	    $count = 0;
	    $date = date('Y-m-d', strtotime('-7 days'));
	    $requests = $this->Common->get_details('requests',array('doctor_id' => $doctor_id , 'date>=' => $date))->result();
	    foreach($requests as $request)
	    {
	        $flag = false;
	        $check = $this->Common->get_details('history',array('request_id' => $request->req_id));
	        if($check->num_rows() > 0)
	        {
	            $his = $check->result();
	            foreach($his as $h)
	            {
	                if($h->type == 'call')
	                {
	                    $flag = true;
	                    break;
	                }
	            }
	        }
	        if($flag)
	        {
	            $count = $count + 1;
	        }
	    }
	    return $count;
	}

	public function getConsultationDetails($doctor)
	{
	    $i=0;
	    $data = $this->M_doctor->getRequestIds($doctor);
	    foreach($data as $req)
	    {
	        if($this->M_doctor->checkHistoryExists($req->req_id))
	        {
	            $i++;
	        }
	    }
	    $return['number'] = $i;
	    $sum = 0;
	    $fees = $this->M_doctor->getFees($doctor);
	    foreach($fees as $fee)
	    {
	        $sum = $sum + $fee->fee;
	    }
	    $return['earning'] = $sum;
	    return $return;
	}
	public function getBlogPosts()
	{
		$this->load->model('Blog_model');
		$posts = $this->Blog_model->getBlogDetails();
		$base_url = "https://dofody.com/blog/";
		foreach($posts as $post)
		{
		    $post->post_link = $base_url . $post->post_name;
		    //$post->image = $this->Blog_model->getAttachedFiles($post->ID);
		    $post->image = base_url() . "assets/images/logo_sm.png";
				$date = explode(" ",$post->post_date);
				$new_date = date("d/m/Y",strtotime($date[0]));
				$post->date = $new_date;
		}
		return $posts;
	}
	public function getLatestMessages($doctor)
	{
		$requests = $this->M_doctor->getRequestsByDoctorId($doctor);
		foreach ($requests as $request) {
			$message = $this->M_doctor->getLastSendMessage($request->req_id);
			if ($message) {
				$request->message = $message['message'];
				$request->date = $message['date'];
				$request->time = $message['time'];
			}
			else {
				$request->message = "No messages recieved yet from ".$request->patient_name."";
				$request->date = "";
				$request->time = "";
			}
		}
		return $requests;
	}
	public function getLastTransactions($doctor_id)
	{
		$trans = $this->M_doctor->getLastTransactions($doctor_id);
		foreach ($trans as $tran) {
			$tran->date = date("d/m/Y",strtotime($tran->date));
			$tran->message = $tran->patient_name . " has paid you ". $tran->fee . " for " . $tran->type_consult . " consultation";
		}
		return $trans;
	}
}
