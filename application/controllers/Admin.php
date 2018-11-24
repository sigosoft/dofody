<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->library('session');
			$this->load->helper('url');
			$this->load->model('Common');
			$this->load->model('M_admin');
			$ret = is_login();
			if ($ret != 'admin') {
				redirect('admin-login');
			}
	}
	public function index()
	{
		$data['doc'] = $this->Common->get_details('dofody_users',array('user_type' => 2))->num_rows();
		$data['pat'] = $this->Common->get_details('dofody_users',array('user_type' => 3))->num_rows();
		$this->load->view('admin/dashboard',$data);
	}
	public function doctors()
	{
		$cond = array('user_type' =>2);
		$data['doc'] = $this->Common->get_details('dofody_users',$cond)->result();
		$this->load->view('admin/doctors',$data);
	}
	public function doc_single($id)
	{
		$this->load->model('M_admin');
        $data['about'] = $this->Common->get_details('about_doctor',array('doctor_id'=>$id))->row();
		$data['doc'] = $this->Common->get_details('dofody_users',array('user_id'=>$id))->row();
		$data['days'] = $this->Common->get_details('doctor_clinic',array('doctor_id' => $id))->row();
		$data['fee'] = $this->Common->get_details('doctor_fee',array('doctor_id' => $id))->row();
		$data['count'] = $checks = $this->M_admin->getRequestsInRange($id);
		$profile = $this->Common->get_details('doctor_profile',array('doctor_id'=>$id));
		if ($profile->num_rows() != 0) {
			$data['profile_pic'] = base_url() . $profile->row()->document;
		}
		else {
			$data['profile_pic'] = base_url()."dist/img/doc.jpeg";
		}
		$data['identity'] = $this->Common->get_details('doctor_identity',array('doctor_id'=>$id))->row();
		$data['stream'] = $this->M_admin->get_stream($id);
		$data['special'] = $this->M_admin->get_special($id);
		$data['sub'] = $this->M_admin->get_sub($id);
		$data['reg'] = $this->Common->get_details('doctor_reg',array('doctor_id'=>$id))->result();
		$data['bank'] = $this->Common->get_details('doctor_accounts',array('doctor_id'=>$id))->row();
		$data['sign'] = $this->Common->get_details('doctor_signature',array('doctor_id' => $id))->row();
		$this->load->view('admin/timeline',$data);
	}
	public function activate_user($id,$status)
	{
		if ($status == 1) {
			$data = array('user_status' => '2');
		}
		else {
			$data = array('user_status' => '1');
		}
		if ($this->Common->update('user_id',$id,'dofody_users',$data)) {
			redirect('admin/doctors');
		}
	}
	public function del_user($id)
	{
		echo $id;
	}
	public function streams()
	{
		$data['stream'] = $this->Common->get_star('stream','','','stream_id','desc')->result();
		$this->load->view('admin/streams',$data);
	}
	public function add_stream()
	{
		$data = $this->input->post();
		$id = $this->Common->insert('stream',$data);
		if ($id) {
			redirect('admin/streams');
		}
	}
	public function getStreamById()
	{
		$id = $_POST['stream'];
		$data = $this->Common->get_details('stream',array('stream_id' => $id))->row();
		print_r(json_encode($data));
	}
	public function edit_stream()
	{
		$data = $this->input->post();
		$stream = $data['stream_id'];
		$this->Common->update('stream_id',$stream,'stream',$data);
		redirect('admin/streams');
	}
	public function special($param=0)
	{
		if ($param == 0) {
			$data['stream'] = $this->Common->get_star('stream','','','stream_name','desc')->result();
			$this->load->view('admin/special',$data);
		}
		else {
			$data['special'] = $this->Common->get_details('stream',array('stream_id' => $param))->row();
			$data['specialization'] = $this->Common->get_star('specialization','stream_id',$param,'special_name','asc')->result();
			$data['stream'] = $this->Common->get_star('stream','','','stream_name','desc')->result();
			$this->load->view('admin/special',$data);
		}
	}
	public function select_special()
	{
		$stream = $this->input->post('stream');
		redirect('admin/special/'.$stream);
	}
	public function add_special()
	{
		$special = $this->input->post();
		$id = $this->Common->insert('specialization',$special);
		if ($id) {
			redirect('admin/special/'.$special['stream_id']);
		}
	}
	public function getSpecialById()
	{
		$id = $_POST['special'];
		$data = $this->Common->get_details('specialization',array('special_id' => $id))->row();
		print_r(json_encode($data));
	}
	public function edit_special()
	{
		$data = $this->input->post();
		$stream_id = $data['stream_id'];
		$this->Common->update('special_id',$data['special_id'],'specialization',$data);
		redirect('admin/special/'.$stream_id);
	}
	public function getQuickFee()
	{
		$data = $this->Common->get_details('quick_fee',array('fee_id' => 1))->row();
		print_r(json_encode($data));
	}
	public function updateQuickFee()
	{
		$data = $this->input->post();
		$this->Common->update('fee_id',1,'quick_fee',$data);
		redirect('admin/quick_fee');
	}
	public function sub_special($param=0)
	{
		if ($param == 0) {
			$data['special'] = $this->Common->get_star('specialization','','','special_name','asc')->result();
			$this->load->view('admin/sub_special',$data);
		}
		else {
			/*$data['special'] = $this->Common->get_details('stream',array('stream_id' => $param))->row();
			$data['specialization'] = $this->Common->get_star('specialization','stream_id',$param,'special_name','asc')->result();
			$data['stream'] = $this->Common->get_star('stream','','','stream_name','asc')->result();*/
			$data['special'] = $this->Common->get_star('specialization','','','special_name','asc')->result();
			$data['selected'] = $this->Common->get_details('specialization',array('special_id' => $param))->row();
			$data['sub'] = $this->Common->get_star('sub_specialization','special_id',$param,'sub_name','asc')->result();
			$this->load->view('admin/sub_special',$data);
		}
	}
	public function select_sub_special()
	{
		$special = $this->input->post('specialization');
		redirect('admin/sub_special/'.$special);
	}
	public function add_sub_special()
	{
		$data = $this->input->post();
		extract($data);
		$stream = $this->Common->get_details('specialization',array('special_id' => $special_id))->row();
		$data['stream_id'] = $stream->stream_id;
		$id = $this->Common->insert('sub_specialization',$data);
		if ($id) {
			redirect('admin/sub_special/'.$special_id);
		}
	}
	public function edit_sub_special($param1=0,$param2=0)
	{
		if ($param1 == 0) {
			$sp = $data['sub'] = $this->Common->get_details('sub_specialization',array('sub_id' => $param2))->row();
			$data['special'] = $this->Common->get_details('specialization',array('special_id' => $sp->special_id))->row();
			$this->load->view('admin/edit_sub',$data);
		}
		elseif ($param1 == 1) {
			$data = $this->input->post();
			$sp_id = $data['special_id'];
			$this->Common->update('sub_id',$param2,'sub_specialization',$data);
			redirect('admin/sub_special/'.$sp_id);
		}
		else {
			redirect('admin/sub_special/0');
		}
	}
	public function patients()
	{
		$data['patients'] = $this->Common->get_details('dofody_users',array('user_type' => 3))->result();
		$this->load->view('admin/patients',$data);
	}
	public function manage_patient($id,$status)
	{
		if ($status == 1) {
			$data['user_status'] = 2;
		}
		elseif ($status == 2) {
			$data['user_status'] = 1;
		}
		$this->Common->update('user_id',$id,'dofody_users',$data);
		redirect('admin/patients');
	}
	public function test()
	{
		$this->load->model('M_admin');
		print_r($this->M_admin->get_sub(16));
	}
	public function quick_fee()
	{
		$fee = $this->Common->get_details('quick_fee',array('fee_id' => 1));
		if ($fee->num_rows() > 0) {
			$data['fee'] = $fee->row();
			$this->load->view('admin/quick_fee',$data);
		}
		else {
			$this->load->view('admin/quick_fee');
		}
	}
	public function add_quick_fee()
	{
		$data = $this->input->post();
		extract($data);
		unset($data['bt']);
		if ($bt == 1) {
			$this->Common->insert('quick_fee',$data);
		}
		elseif ($bt==2) {
			$this->Common->update('fee_id',1,'quick_fee',$data);
		}
		redirect('admin/quick_fee');
	}
	public function quick_consultations()
	{
		$data['req'] = $this->M_admin->getQuickRequests();
		$this->load->view('admin/request_view',$data);
	}
	public function patient_detail_view($param=0)
	{
		$request = $this->Common->get_details('requests',array( 'req_id' => $param , 'doctor_id' => 'quick'));
		if ($request->num_rows() > 0) {
			$patient = $request->row()->patient_id;
			$data['info'] = $this->Common->get_details('patients_details',array('patient_id' => $patient))->row();
			$data['records'] = $this->Common->get_details('medical_records',array('patient_id' => $patient))->result();
			$data['req'] = $request->row();
			$this->load->view('admin/patient_detail_view',$data);
		}
		else {
			$this->load->view('admin/quick_consultations');
		}
	}
	public function get_online_doctors()
	{
		$this->load->model('M_patient');
		$thead = "<tr><th>Name</th><th>Stream</th><th>Specializations</th><th>Login status</th><th>Fee</th><th>Choose</th></tr>";
		$tbody = '';
		date_default_timezone_set('Asia/Kolkata');
		$current = date('Y-m-d H:i:s');
		$to_time = strtotime($current);
		$online = $this->M_patient->get_online_doctors();
		foreach ($online as $det) {
			$str = $this->M_patient->get_stream($det->user_id);
			$det->stream = $str->stream_name;
			$from_time = strtotime($det->last_update);
			$det->last_logged_in = round(abs($to_time - $from_time) / 60,0);
			$special = $this->M_patient->get_special($det->user_id);
			$string = '';
			foreach ($special as $sp) {
				$string = $string . $sp->special_name . ' ,';
			}
			$det->special=rtrim($string," ,");
			$tbody = $tbody . "<tr><td>".$det->name."</td><td>".$det->stream."</td><td>".$det->special;
			if ($det->last_logged_in <= 1) {
				$tbody = $tbody . "<td><i class='fa fa-check' style='color : green;'></i>&nbsp;online</td>";
			}
			elseif ($det->last_logged_in < 60 && $det->last_logged_in > 1) {
				$tbody = $tbody . "<td>Active ".$det->last_logged_in." minutes ago</td>";
			}
			elseif ($det->last_logged_in < 1440 && $det->last_logged_in > 60) {
				$hr = floor($det->last_logged_in/60);
				$tbody = $tbody . "<td>Active ".$hr." hour ago</td>";
			}
			elseif($det->last_logged_in > 1440) {
				list($dat) = explode(' ', $det->last_update);
				$tbody = $tbody . "<td>Last seen : ".$dat;
			}
			$tbody = $tbody . "<td>Audio : ".$det->audio_fee."<br>Video : ".$det->video_fee."<br>Chat : ".$det->chat_fee."</td>";
			$tbody = $tbody . "<td><button class='btn btn-default' onclick='doctor_selected(".$det->user_id.")'>Select</button></td></tr>";
		}
		$table = $thead . $tbody;
		echo $table;
	}
	public function get_details_of_a_doctor()
	{
		$this->load->model('M_patient');
		$id = $_POST['id'];
		$doctor = $this->M_patient->get_doctor_name($id);
		$degree = $this->Common->get_details('doctor_degree',array('doctor_id' => $id , 'degree_type' => 'stream'))->row();
		$stream = $this->M_patient->get_stream($id);
		$special = $this->M_patient->get_special($id);
		$string = '';
		foreach ($special as $sp) {
			$string = $string . $sp->special_name . ' ,';
		}
		$spec=rtrim($string," ,");
		$fee = $this->Common->get_details('doctor_fee',array('doctor_id' => $id))->row();
		$array = array(
			'name' => $doctor->name,
			'stream' => $stream->stream_name,
			'special' => $spec,
			'audio' => $fee->audio_fee,
			'video' => $fee->video_fee,
			'chat' => $fee->chat_fee
		);
		$thead = "<tr><th>Doctor</th><th>Stream</th><th>Specialization</th></tr>";
		$tbody = "<tr><td>".$doctor->name."</td><td>".$stream->stream_name."</td><td>".$spec."</td></tr>";
		//$fee = "<td>Audio : ".$fee->audio_fee."<br>Video : ".$fee->video_fee."<br>Chat : ".$fee->chat_fee."</td></tr>";
		$table = $thead . $tbody;
		$array['table'] = $table;
		echo json_encode($array);

	}
	public function assign_doctor()
	{
		if (isset($_POST['doctor_id']) && isset($_POST['request_id'])) {
			$doctor_id = $_POST['doctor_id'];
			$request_id = $_POST['request_id'];

			$trans = [
				'doctor_id' => $doctor_id,
				'request_id' => $request_id,
				'date' => date('Y-m-d')
			];
			$fee = $this->Common->get_Details('doctor_fee',array('doctor_id' => $doctor_id))->row();
			$type = $this->M_admin->getConsultType($request_id);
			if ($type == 'video') {
				$trans['fee'] = $fee->video_fee;
			}
			elseif ($type == 'audio') {
				$trans['fee'] = $fee->audio_fee;
			}
			else {
				$trans['fee'] = $fee->chat_fee;
			}
			$this->Common->insert('transactions',$trans);
			$this->Common->update('req_id',$request_id,'requests',array('doctor_id' => $doctor_id));
			redirect('admin/quick_consultations');
		}
	}
	public function addAbout()
	{
		$data = $this->input->post();
		$num = $this->Common->get_details('about_doctor',array('doctor_id'=>$data['doctor_id']))->num_rows();
		if ($num > 0) {
			$this->Common->update('doctor_id',$data['doctor_id'],'about_doctor',$data);
		}
		else {
			$this->Common->insert('about_doctor',$data);
		}
		redirect("admin/doc_single/".$data['doctor_id']);
	}
	
	// ---------- History -------------------- //
	public function ongoing_history()
	{
		$data['requests'] = $this->M_admin->getOnGoingHistory();
		$this->load->view('admin/ongoing_history',$data);
	}
	public function completed_history()
	{
		$data['requests'] = $this->M_admin->getCompletedHistory();
		$this->load->view('admin/completed_history',$data);
	}

	public function ongoing_history_view($param)
	{
		$result = $this->Common->get_details('requests',array('req_id' => $param));
		if ($result->num_rows() > 0) {
			$details = $this->M_admin->getRequestDetails($param);
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
				$this->load->view('admin/ongoing_history_view',$data);
			}
			else {
				$data['sent'] = $this->Common->get_details('messages',array('request_id' => $param,'user' => '1'))->num_rows();
				$data['recieved'] = $this->Common->get_details('messages',array('request_id' => $param,'user' => '0'))->num_rows();
				$this->load->view('admin/ongoing_history_view_chat',$data);
			}
		}
		else {
			redirect('patient/ongoing_history');
		}
	}
	public function completed_history_view($param)
	{
		$result = $this->Common->get_details('requests',array('req_id' => $param));
		if ($result->num_rows() > 0) {
			$details = $this->M_admin->getRequestDetails($param);
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
				$data['history'] = $this->Common->get_details('history',array('request_id' => $param, 'type' => 'call'))->result();
				$this->load->view('admin/completed_history_view',$data);
			}
			else {
				$data['sent'] = $this->Common->get_details('messages',array('request_id' => $param,'user' => '1'))->num_rows();
				$data['recieved'] = $this->Common->get_details('messages',array('request_id' => $param,'user' => '0'))->num_rows();
				$this->load->view('admin/completed_history_view_chat',$data);
			}
		}
		else {
			redirect('admin/completed_history');
		}
	}
	public function delete_requests()
	{
		$status = 'request';
		$data['requests'] = $this->M_admin->delete_requests($status);
		$this->load->view('admin/delete_requests',$data);
	}
	public function deleted_accounts()
	{
		$status = 'deleted';
		$data['requests'] = $this->M_admin->delete_requests($status);
		$this->load->view('admin/deleted_accounts',$data);
	}
	function deleteAccount($id)
	{
		$status1 = [
			'user_status' => '3'
		];
		$status2 = [
			'status' => 'deleted'
			];
		$this->Common->update('user_id',$id,'dofody_users',$status1);
		$this->Common->update('user_id',$id,'deleted_accounts',$status2);
		redirect('admin/delete_requests');
	}
	public function addTimeToRequest()
	{
	    $data['requests'] = $this->M_admin->getNewRequests();
	    $this->load->view('admin/newRequests',$data);
	}
	public function addTimeRequest()
	{
	    $date = $this->input->post('date');
	    $time = $this->input->post('time');
	    $request_id = $this->input->post('request_id');
	    $timestamp = $date . " " .$this->changeTimeFormat($time);
	    $array = [
	      'time' => $timestamp,
	      'request_id' => $request_id
	    ];
	    $status = ['status_time' => '1'];
	    $this->Common->update('req_id',$request_id,'requests',$status);
	    
	    $this->Common->insert('request_time',$array);
	    redirect('admin/addTimeToRequest');
	}
	function changeTimeFormat($time)
	{
	    $array = explode(" ",$time);
	    $arr = explode(":",$array[0]);
		$t = '';
		if($array[1] == 'PM')
		{
		    $arr[0] = $arr[0] + 12;
		}
		foreach ($arr as $key) {
			if(strlen($key) == 1)
			{
				$t = $t.'0'.$key.':';
			}
			else {
				$t = $t.$key.':';
			}
		}
		$t = $t . "00";
		return $t;
	}
}
