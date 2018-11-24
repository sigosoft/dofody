<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Patient extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->library('session');
			$this->load->helper('url');
			$this->load->model('Common');
			$this->load->model('M_patient');
			$ret = is_login();
			if ($ret != 'patient') {
				redirect('login/login');
			}
	}
	public function index()
	{
		$this->load->view('patient/dashboard');
	}
	public function dashboard()
	{
		$this->load->view('patient/dashboard');
	}
	public function members($param=0,$param1=0)
	{
		if ($param == 0) {
			$sess = $this->session->userdata('dof_user');
			$id = $sess['user_id'];
			$data['patients'] = $this->Common->get_details('patients_details',array('p_user_id'=>$id))->result();
			$this->load->view('patient/members',$data);
		}
		elseif ($param == 1) {
			$this->load->view('patient/add_member');
		}
		elseif ($param == 2) {
			$sess = $this->session->userdata('dof_user');
			$user = $sess['user_id'];
			$num = $this->Common->get_details('patients_details',array('patient_id'=>$param1 , 'p_user_id'=>$user))->num_rows();
			if ($num == 0) {
				redirect('patient/members/0');
			}
			else {
				$data['patient'] = $this->Common->get_details('patients_details',array('patient_id'=>$param1))->row();
				$this->load->view('patient/edit_member',$data);
			}
		}
		else {
			redirect('patient/members/0');
		}
	}

	public function add_members()
	{
		$data = $this->input->post();
		extract($data);
		$date = str_replace('/', '-', $dob);
		$data['dob'] = date("Y-m-d", strtotime($date) );
		$sess = $this->session->userdata('dof_user');
		$data['p_user_id'] = $sess['user_id'];
		$id = $this->Common->insert('patients_details',$data);
		if ($id) {
			redirect('patient/members/0');
		}
	}
	public function edit_member()
	{
		$data = $this->input->post();
		extract($data);
		$date = str_replace('/', '-', $dob);
		$data['dob'] = date("Y-m-d", strtotime($date) );
		$sess = $this->session->userdata('dof_user');
		$data['p_user_id'] = $sess['user_id'];

		unset($data['id']);
		$id = $this->Common->update('patient_id',$id,'patients_details',$data);
		if ($id) {
			redirect('patient/members/0');
		}
	}
	public function delete_member()
	{
		$id = $this->input->post('member_id');
		$bool = $this->Common->delete('patients_details',array('patient_id'=>$id));
		if ($bool) {
			redirect('patient/members/0');
		}
	}
	public function medical_records($param=0)
	{
		$sess = $this->session->userdata('dof_user');
		$user = $sess['user_id'];
		$data['records'] = $this->M_patient->get_patient_details(0,$user);
		/*if ($param == 0) {
			$data['records'] = $this->M_patient->get_patient_details(0,$user);
		}
		else {
			$data['records'] = $this->M_patient->get_patient_details($param,$user);
		}*/
		$data['stat'] = $param;
		$data['patients'] = $this->Common->get_details('patients_details',array('p_user_id'=>$user))->result();
 		$this->load->view('patient/medical_records',$data);
	}
	public function select_patient()
	{
		$id = $this->input->post('patient_id');
		redirect('patient/medical_records/'.$id);
	}
	public function add_record($param=0)
	{
		$sess = $this->session->userdata('dof_user');
		$user = $sess['user_id'];
		if ($param == 0) {
			$data['patients'] = $this->Common->get_details('patients_details',array('p_user_id'=>$user))->result();
			$this->load->view('patient/add_medical_record',$data);
		}
		elseif ($param == 1) {
			if (isset($_POST['patient_id'])) {
				$data = $this->input->post();
				$data['user_id'] = $user;
				$file = $_FILES['rec_file'];
				$tar = "uploads/med_records/";
				$rand=date('Ymd').mt_rand(1001,9999);
				$tar_file = $tar . $rand . basename($file['name']);
				if(move_uploaded_file($file["tmp_name"], $tar_file))
				{
					$data['med_document'] = $tar_file;
				}
				$this->Common->insert('medical_records',$data);
				redirect('patient/medical_records/'.$data['patient_id']);
				}
			else {
				redirect('patient/medical_records/0');
			}
		}
	}
	public function getRecordById()
	{
		$id = $_POST['med_id'];
		$data = $this->Common->get_details('medical_records',array('med_id' => $id))->row();
		print_r(json_encode($data));
	}
	public function edit_record()
	{
		$data = $this->input->post();
		$file = $_FILES['rec_file'];
		if($file['name'] != '')
		{
			$tar = "uploads/med_records/";
			$rand=date('Ymd').mt_rand(1001,9999);
			$tar_file = $tar . $rand . basename($file['name']);
			if(move_uploaded_file($file["tmp_name"], $tar_file))
			{
				$data['med_document'] = $tar_file;
			}
		}
		$this->Common->update('med_id',$data['med_id'],'medical_records',$data);
		redirect('patient/medical_records');
	}
	public function edit_medical_record($param1=0,$param2=0)
	{
		if ($param1==0) {
			$sess = $this->session->userdata('dof_user');
			$user = $sess['user_id'];
			$num = $this->Common->get_details('medical_records',array('med_id'=>$param2 , 'user_id'=>$user))->num_rows();
			if ($num>0) {
				$data['patients'] = $this->Common->get_details('patients_details',array('p_user_id'=>$user))->result();
				$data['record'] = $this->Common->get_details('medical_records',array('med_id' => $param2))->row();
				$this->load->view('patient/edit_medical_record',$data);
			}
			else {
				redirect('patient/medical_records');
			}

		}
		elseif ($param1==1) {
			if (isset($_POST['patient_id'])) {
				$data = $this->input->post();
				$file = $_FILES['rec_file'];
				if($file['name'] != '')
				{
					$tar = "uploads/med_records/";
					$rand=date('Ymd').mt_rand(1001,9999);
					$tar_file = $tar . $rand . basename($file['name']);
					if(move_uploaded_file($file["tmp_name"], $tar_file))
					{
						$data['med_document'] = $tar_file;
					}
				}
				$this->Common->update('med_id',$param2,'medical_records',$data);
				redirect('patient/medical_records/'.$data['patient_id']);
			}
			else {
				redirect('patient/medical_records');
			}
		}
		else {
			redirect('patient/medical_records');
		}
	}
	public function delete_medical_record()
	{
		if (isset($_POST['record_id'])) {
			$id = $this->input->post('record_id');
			$doc = $this->input->post('document');
			if ($this->Common->delete('medical_records',array('med_id'=>$id))) {
				unlink($doc);
				redirect('patient/medical_records');
			}
		}
	}
	public function prescriptions($param=0)
	{
		$sess = $this->session->userdata('dof_user');
		$user = $sess['user_id'];
		if ($param == 0) {
			$data['pres'] = $this->M_patient->get_patient_prescriptions(0,$user);
		}
		else {
			$data['pres'] = $this->M_patient->get_patient_prescriptions($param,$user);
		}
		$data['stat'] = $param;
		$data['patients'] = $this->Common->get_details('patients_details',array('p_user_id'=>$user))->result();
 		$this->load->view('patient/prescriptions',$data);
	}
	public function add_prescription($param=0)
	{
		$sess = $this->session->userdata('dof_user');
		$user = $sess['user_id'];
		if ($param == 0) {
			$data['patients'] = $this->Common->get_details('patients_details',array('p_user_id'=>$user))->result();
			$this->load->view('patient/add_prescription',$data);
		}
		if ($param == 1) {
			if (isset($_POST['patient_id'])) {
				$sess = $this->session->userdata('dof_user');
				$user = $sess['user_id'];
				$data = $this->input->post();
				$data['user_id'] = $user;
				//print_r($data);
				$file = $_FILES['rec_file'];
				$tar = "uploads/doc_prescriptions/";
				$rand=date('Ymd').mt_rand(1001,9999);
				$tar_file = $tar . $rand . basename($file['name']);
				if(move_uploaded_file($file["tmp_name"], $tar_file))
				{
					$data['pres_document'] = $tar_file;
				}
				$id = $this->Common->insert('prescriptions',$data);
				if ($id) {
					redirect('patient/prescriptions/'.$data['patient_id']);
				}

			}
			else {
				redirect('patient/prescriptions');
			}
		}
	}
	public function select_prescription()
	{
		$id = $this->input->post('patient_id');
		redirect('patient/prescriptions/'.$id);
	}
	public function edit_prescription($param1=0,$param2=0)
	{
		if ($param1==0) {
			$sess = $this->session->userdata('dof_user');
			$user = $sess['user_id'];
			$num = $this->Common->get_details('prescriptions',array('pres_id'=>$param2 , 'user_id'=>$user))->num_rows();
			if ($num>0) {
				$data['patients'] = $this->Common->get_details('patients_details',array('p_user_id'=>$user))->result();
				$data['pres'] = $this->Common->get_details('prescriptions',array('pres_id' => $param2))->row();
				$this->load->view('patient/edit_prescription',$data);
			}
			else {
				redirect('patient/prescriptions');
			}
		}
		elseif ($param1==1) {
			if (isset($_POST['patient_id'])) {
				$data = $this->input->post();
				$file = $_FILES['rec_file'];
				if ($file['name'] != '') {
					$tar = "uploads/doc_prescriptions/";
					$rand=date('Ymd').mt_rand(1001,9999);
					$tar_file = $tar . $rand . basename($file['name']);
					if(move_uploaded_file($file["tmp_name"], $tar_file))
					{
						$data['pres_document'] = $tar_file;
					}

				}
				$this->Common->update('pres_id',$param2,'prescriptions',$data);
				redirect('patient/prescriptions/'.$data['patient_id']);
			}
			else {
				redirect('patient/prescriptions');
			}
		}
		else {
			redirect('patient/prescriptions');
		}
	}
	public function consult()
	{
		$sess = $this->session->userdata('dof_user');
		$user = $sess['user_id'];
		$data['memb'] = $this->Common->get_details('patients_details',array('p_user_id' => $user))->result();
		$data['doc'] = $this->Common->get_details('dofody_users',array('user_type' => 2))->result();
		$this->load->view('patient/consult',$data);
	}
	public function dof_prescriptions($param = 0)
	{
		$sess = $this->session->userdata('dof_user');
		$user = $sess['user_id'];
		$data['prescr'] = $this->M_patient->get_prescriptions($user,$param);

		$data['stat'] = $param;
		$data['patients'] = $this->Common->get_details('patients_details',array('p_user_id'=>$user))->result();
		$this->load->view('patient/dof_prescriptions',$data);
		//print_r($data['prescr']);
	}
	public function select_dofody_prescription()
	{
		$pid = $this->input->post('patient_id');
		redirect('patient/dof_prescriptions/'.$pid);
	}
	public function pres_view($doc=0,$patient=0,$pres=0)
	{
		//echo $doc.' -- '.$patient.' -- '.$pres;
		$dt = $this->Common->get_details('dofody_pres_table',array('dof_pres_id'=>$pres , 'patient_id' => $patient , 'doctor_id' => $doc));
		if ($dt->num_rows() > 0) {
			$data['prescription'] = $this->Common->get_details('dofody_prescriptions',array('pres_table_id' => $pres))->result();
			$data['pat'] = $this->Common->get_details('patients_details',array('patient_id' => $patient))->row();
			$data['consult'] = $dt->row();
			$this->load->view('patient/pres_view',$data);
		}
		else {
			redirect('patient/dof_prescriptions');
		}
	}
	public function pres_print($param=0)
	{
		$sess = $this->session->userdata('dof_user');
		$user = $sess['user_id'];
		$data = $this->Common->get_details('dofody_pres_table',array('dof_pres_id'=>$param , 'user_id' => $user));
		if ($data->num_rows() > 0) {
			$p = $data->row();
			$pres = $this->Common->get_details('dofody_prescriptions',array('pres_table_id' => $p->dof_pres_id))->result();
			$pat = $this->Common->get_details('patients_details',array('patient_id' => $p->patient_id))->row();
			switch ($pat->gender) {
				case 'm': $gend = 'Male'; break;
				case 'f': $gend = 'Female'; break;
				case 'o': $gend = 'Others'; break;
			}
			$dateOfBirth = $pat->dob;
			$today = date("Y-m-d");
			$diff = date_diff(date_create($dateOfBirth), date_create($today));
			$age = $diff->format('%y');
			$tr = "";
			foreach ($pres as $pre) {
				$tr = $tr."<tr><td>".$pre->medicine."</td><td>".$pre->usages."</td><td>".$pre->days."</td></tr>";
			}
			$doctor = $this->get_doctor_details($p->doctor_id);
			$head = "<head><style>body{ padding : 40px; } .main{ padding : 30px; border : 1px solid black; } .para{ margin-bottom : 0px; margin-top : 3px; font-size : 20px; }
					.pat-para{ font-size : 18px; margin-bottom : 3px; margin-top : 3px; } .table-div{ padding : 50px; }</style></head>";
			$doc = "<div class='doc-description'>
				<p class='para' style=''>".$doctor['doctor_name']."</p>
				<p class='para'>".$doctor['stream']."</p>";
				if (isset($doctor['special'])) {
					$doc = $doc."<p class='para'>".$doctor['special']."</p>";
				}
				if (isset($doctor['sub'])) {
					$doc = $doc."<p class='para'>".$doctor['sub']."</p>";
				}
				$doc_l = "<p class='para'>".$doctor['doctor_phone']."</p><hr></div>";
			$doc = $doc.$doc_l;
			$patient = "<div class=''>
				<p class='pat-para'>Name of patient : ".$pat->patient_name."</p>
				<p class='pat-para'>Gender : ".$gend."</p>
				<p class='pat-para'>Age : ".$age."</p>
				<p class='pat-para'>Date of consultation : ".$p->add_date."</p>
				<p></p>
			</div>";
			$html = "<!DOCTYPE html>
			<html>".$head."
			  <body>
			    <div class='main'>".$doc.$patient."
			      <div class='table-div'>
			        <table style='width:100%'>
			          <tr>
			            <td><u>MEDICINE</u></td>
			            <td><u>USAGE</u></td>
			            <td><u>DURATION</u></td>
			          </tr>".$tr."
			        </table>
			      </div>
			    </div>
			  </body>
			</html>";
			$document_name = $pat->patient_name . rand(1000,10000).'.pdf';
			$this->load->library('pdf');
	 		$dompdf = new Dompdf\Dompdf();
	 		// Set Font Style
	 		$dompdf->set_option('defaultFont', 'Courier');
	 		$dompdf->loadHtml($html);
	 		// To Setup the paper size and orientation
	 		$dompdf->setPaper('A4', 'landscape');
	 		// Render the HTML as PDF
	 		$dompdf->render();
	 		// Get the generated PDF file contents
	 		$pdf = $dompdf->output();
	 		// Output the generated PDF to Browser
	 		//$dompdf->stream("My.pdf");
	 		$dompdf->stream($document_name,array('Attachment'=>1));
		}
		else {
			redirect('patient/dof_prescriptions');
		}

	}
	public function print_prescription($param=0)
	{
		$sess = $this->session->userdata('dof_user');
		$user = $sess['user_id'];
		$dat = $this->Common->get_details('dofody_pres_table',array('dof_pres_id'=>$param , 'user_id' => $user));
		if ($dat->num_rows() > 0) {
			$data['consult'] = $p = $dat->row();
			$data['pres'] = $this->Common->get_details('dofody_prescriptions',array('pres_table_id' => $p->dof_pres_id))->result();
			$data['patient'] = $this->Common->get_details('patients_details',array('patient_id' => $p->patient_id))->row();
			$data['doctor'] = $this->get_doctor_details($p->doctor_id);
			$this->load->view('patient/pres_print',$data);
		}
		else {
			redirect('patient/dof_prescriptions');
		}
	}
	public function get_doctor_details($doc)
	{
		$array = array();
		$user = $this->Common->get_details('dofody_users',array('user_id' => $doc))->row();
		$degree = $this->Common->get_details('doctor_degree',array('doctor_id' => $doc))->result();
		$array['doctor_name'] = $user->name;
		$array['doctor_phone'] = $user->mobile;
		foreach ($degree as $deg) {
			switch ($deg->degree_type) {
				case 'stream': $str = $this->Common->get_details('stream',array('stream_id' => $deg->degree_name))->row();
											 $array['stream'] = $str->stream_name;
											 break;
			  case 'spec': $str = $this->Common->get_details('specialization',array('special_id' => $deg->degree_name))->row();
											 $array['special'] = $str->special_name;
											 break;
				case 'sub': $str = $this->Common->get_details('sub_specialization',array('sub_id' => $deg->degree_name))->row();
											 $array['sub'] = $str->sub_name;
											 break;
			}
		}
		return $array;
	}
	public function chat_request()
	{
		$sess = $this->session->userdata('dof_user');
		$user = $sess['user_id'];
		$data['memb'] = $this->Common->get_details('patients_details',array('p_user_id' => $user))->result();
		$data['doc'] = $this->Common->get_details('dofody_users',array('user_type' => 2))->result();
		$this->load->view('patient/chat_request',$data);
	}
	public function send_chat_request()
	{
		$data = $this->input->post();
		$data['channel_name'] = $this->get_channel_name($data['patient_id'],$data['doctor_id']);
		$data['chat_status'] = 'request';
		$this->Common->insert('chat_requests',$data);
		redirect('patient/current_chats');
	}
	public function get_channel_name($pa,$do)
	{
		$pat = $this->Common->get_details('patients_details',array('patient_id' => $pa))->row();
		$doc = $this->Common->get_details('dofody_users',array('user_id' => $do))->row();
		$channel = $pat->patient_name.'-'.$doc->name;
		return $channel;
	}
	public function current_chats()
	{
		$this->load->view('patient/current_chats');
	}
	public function profile($param = 0)
	{
		$sess = $this->session->userdata('dof_user');
		$user = $sess['user_id'];
		$data['members']  = $this->Common->get_details('patients_details',array('p_user_id' => $user))->result();
		if ($param != 0) {
			$res  = $this->Common->get_details('patients_details',array('patient_id' => $param , 'p_user_id' => $user));
			if ($res->num_rows() > 0) {
				$data['member'] = $res->row();
			}
			else {
				redirect('patient/profile');
			}
		}
		$data['param'] = $param;
		$this->load->view('patient/profile-view',$data);
	}
	public function validate_mobile_number()
	{
		$mobile = $_POST['phone'];
		$num = $this->Common->get_details('patients_details',array('patient_mobile' => $mobile))->num_rows();
		if ($num == 0) {
			echo "success";
		}
		else {
			echo "failed";
		}
	}
	public function validate_email_address()
	{
		$email = $_POST['email'];
		$num = $this->Common->get_details('patients_details',array('patient_email' => $email))->num_rows();
		if ($num == 0) {
			echo "success";
		}
		else {
			echo "failed";
		}
	}
	public function register_family_member()
	{
		$sess = $this->session->userdata('dof_user');
		$user = $sess['user_id'];

		$data = $this->input->post();
		$dob = $data['dob'];
		$data['dob'] = date("Y-m-d", strtotime($dob) );
		$data['p_user_id'] = $user;
		if (isset($_FILES['txtimage'])) {
			$file = $_FILES['txtimage'];
			$tar = "uploads/profile/";
			$rand=date('Ymd').mt_rand(1001,9999);
			$tar_file = $tar . $rand . basename($file['name']);
			if(move_uploaded_file($file["tmp_name"], $tar_file))
			{
				$data['profile_photo'] = $tar_file;
			}
			else {
				$data['profile_photo'] = 'nil';
			}
		}
		if ($this->Common->insert('patients_details',$data)) {
			redirect('patient/profile');
		}
		//print_r($data);
	}
	public function add_profile()
	{
		$this->load->view('patient/add_profile');
	}
	public function select_profile()
	{
		$id = $this->input->post('member');
		redirect('patient/profile/'.$id);
	}
	public function update_profile()
	{
		$sess = $this->session->userdata('dof_user');
		$user = $sess['user_id'];

		$data = $this->input->post();
		$patient_id = $data['patient_id'];
		unset($data['patient_id']);
		$dob = $data['dob'];
		$data['dob'] = date("Y-m-d", strtotime($dob) );
		$data['p_user_id'] = $user;
		$file = $_FILES['txtimage'];
		if ($file['name'] != '') {
			$tar = "uploads/profile/";
			$rand=date('Ymd').mt_rand(1001,9999);
			$tar_file = $tar . $rand . basename($file['name']);
			if(move_uploaded_file($file["tmp_name"], $tar_file))
			{
				$data['profile_photo'] = $tar_file;
			}
			else {
				$data['profile_photo'] = 'nil';
			}
		}
		if ($this->Common->update('patient_id',$patient_id,'patients_details',$data)) {
			redirect('patient/profile/'.$patient_id);
		}
	}
	public function record_gallery()
	{
		$sess = $this->session->userdata('dof_user');
		$user = $sess['user_id'];
		$data['record'] = $this->Common->get_details('medical_records',array('user_id' => $user , 'med_title !=' => 'Electronic medical record'))->result();
		$this->load->view('patient/record_gallery',$data);
	}
	public function myAccount()
	{
		$sess = $this->session->userdata('dof_user');
		$user = $sess['user_id'];
		$data['details'] = $this->Common->get_details('dofody_users',array('user_id'=>$user))->row();
		$this->load->view('patient/my_account',$data);
	}
	public function general_name_change()
	{
		$sess = $this->session->userdata('dof_user');
		$user = $sess['user_id'];
		$data = $this->input->post();
		$this->Common->update('user_id',$user,'dofody_users',$data);
		redirect('patient/myAccount');
	}

	public function generalChangePassword()
	{
		$sess = $this->session->userdata('dof_user');
		$user = $sess['user_id'];
		$data = $this->input->post();
		$data['password'] = md5($data['password']);
		$this->Common->update('user_id',$user,'dofody_users',$data);
		redirect('patient/myAccount');
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
		$data['memb'] = $this->Common->get_details('patients_details',array('p_user_id' => $user))->result();
		$data['quick'] = $this->Common->get_details('quick_fee',array('fee_id' => 1))->row();
		$data['doc'] = $this->Common->get_details('dofody_users',array('user_type' => 2))->result();
		$this->load->view('patient/consult_now',$data);
	}
	public function add_m_record()
	{
		$sess = $this->session->userdata('dof_user');
		$user = $sess['user_id'];

		$data = $_POST;
		$data['patient_id'] = $data['patient'];
		$data['user_id'] = $user;
		unset($data['patient']);
		$file = $_FILES['rec_file'];
		$file = $_FILES['rec_file'];
		$tar = "uploads/med_records/";
		$rand=date('Ymd').mt_rand(1001,9999);
		$tar_file = $tar . $rand . basename($file['name']);
		if(move_uploaded_file($file["tmp_name"], $tar_file))
		{
			$data['med_document'] = $tar_file;
		}
		if($this->Common->insert('medical_records',$data))
		{
			echo "success";
		}
	}
	public function get_online_doctors()
	{
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
	public function get_patient_past_medical()
	{
		$id = $_POST['id'];
		$data = $this->M_patient->get_patient_past_medical($id);
		print_r($data->past_medical);
	}
	public function connect_doctors()
	{
		date_default_timezone_set('Asia/Kolkata');
		$sess = $this->session->userdata('dof_user');
		$user = $sess['user_id'];

		$data = $this->input->post();
		$data['date'] = date('Y-m-d');
		$data['time'] = date('h:i A');
		$data['p_user_id'] = $user;
		$data['start_time'] = date('Y-m-d H:i:s');
		if ($data['doctor_id'] == 'quick') {
			$data['request_type'] = 'quick';
		}
		if ($req_id = $this->Common->insert('requests',$data)) {
			if ($data['type_consult'] == 'video') {
				$array = [
					'request_id' => $req_id,
					'room' => $this->create_room()
				];
				$this->Common->insert('rooms',$array);
			}
			redirect('patient');
		}
	}
	public function create_room($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
	}
	public function patients_requests()
	{
		$sess = $this->session->userdata('dof_user');
		$user = $sess['user_id'];

		$data['req'] = $this->M_patient->get_requests($user);
		$this->load->view('patient/request_view',$data);
	}
	public function delete_requests()
	{
		echo "This functionality is not acivated";
	}
	public function check_call()
	{
		$sess = $this->session->userdata('dof_user');
		$user = $sess['user_id'];
		$data=array(
			'stat' => 0
		);
		$req = $this->Common->get_details('calls',array('patient_user' => $user , 'doctor_status' => 'line' , 'patient_notification' => '0'));
		if ($req->num_rows() > 0) {
			$val = $req->row();
			$update = array(
				'patient_notification' => '1'
			);
			$this->Common->update('call_id',$val->call_id,'calls',$update);
			$data['call_id'] = $val->call_id;
			$data['stat'] = 1;
			$data['typ'] = $val->call_type;
		}

		echo json_encode($data);
	}
	public function audio_consultation($param=0)
	{
		$sess = $this->session->userdata('dof_user');
		$user = $sess['user_id'];

		$call = $this->Common->get_details('calls',array('patient_user' => $user , 'call_id' => $param));
		if ($call->num_rows() > 0) {
			$det = $call->row();
			$data['doc_img'] = base_url() . "dist/img/doc.jpeg";
			$data['doctor'] = $this->Common->get_details('dofody_users',array('user_id' => $det->doctor_id))->row();
			$data['call'] = $det;
			$this->load->view('patient/audio_consultation',$data);
		}
		else {
			redirect('patient/consult_now');
		}
	}
	public function get_details_of_a_doctor()
	{
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
		$thead = "<tr><th>Doctor</th><th>Stream</th><th>Specialization</th><th>Fee</th></tr>";
		$tbody = "<tr><td>".$doctor->name."</td><td>".$stream->stream_name."</td><td>".$spec."</td>";
		$fee = "<td>Audio : ".$fee->audio_fee."<br>Video : ".$fee->video_fee."<br>Chat : ".$fee->chat_fee."</td></tr>";
		$table = $thead . $tbody . $fee;
		$array['table'] = $table;
		echo json_encode($array);

	}
	public function get_key()
	{
		$sess = $this->session->userdata('dof_user');
		$user = $sess['user_id'];
		//$email = $this->M_patient->get_user_email($user);
		$details = $this->Common->get_details('dofody_users',array('user_id' => $user))->row();
		 /*$array = array(
			 'key' => 'rzp_test_fYh2Uh6bIM20Rl',
			 'prefill' => array('email' => $details->email , 'name' => $details->name),
			 'image' => base_url().'dist/img/logo.png',
			 'name' => 'Dofody.com',
			 'description' => 'Description about dofody',
			 'notes' => array('address' => 'Address here'),
			 'theme' => array('color' => '#3c8dbc')
		 );*/
		 $array = array(
			 'key' => 'rzp_test_fYh2Uh6bIM20Rl',
			 'name' => $details->name,
			 'email' => $details->email
		 );
		echo json_encode($array);
	}
	public function chats()
	{
		$sess = $this->session->userdata('dof_user');
		$user = $sess['user_id'];

		$data['chats'] = $this->M_patient->getChatDetails($user);
		$this->load->view('patient/chats',$data);
	}
	public function send_message()
	{
		$data = array(
			'message' => $_POST['message'],
			'attach' => 'text',
			'user' => '1',
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
		$req = $this->M_patient->getRequests($user);
		foreach ($req as $r) {
			$key = $r->req_id;
			$data[$key] = $this->M_patient->getMessages($r->req_id);
			$this->M_patient->updateMessageStatus($r->req_id);
		}
		echo json_encode($data);
	}
	public function checkMessages()
	{
		$sess = $this->session->userdata('dof_user');
		$user = $sess['user_id'];
		$data = array();
		$req = $this->M_patient->getRequests($user);
		foreach ($req as $r) {
			$key = $r->req_id;
			$data[$key] = $this->M_patient->getNewMessages($r->req_id);
			$this->M_patient->updateMessageStatus($r->req_id);
		}
		echo json_encode($data);
	}
	public function test123()
	{
		$array = array(
			'Monday','Sunday','Tuesday','Thursday','Friday','Saturday'
		);
		//$data = json_encode($array);
		//print_r($data);
		//$test = "[{'product_name':'Quil Egg','quantity':'2','total_price':'60.0','product_id':102,'packet_size':'','unit_price':'30.0'}]";
		//$check = json_decode($test);
		//echo "</br>";
		//print_r( json_decode(  , TRUE) );
		$array1 = array(
			'name' => 'aithin',
			'place' => 'palazhi',
			'phone' => 8714501270
		);
		$data = json_encode($array1);
		echo $data;
		echo "</br>";
		print_r(json_decode($data , TRUE));
	}
	public function test12()
	{
		/*$sess = $this->session->userdata('dof_user');
		$user = $sess['user_id'];
		$data = $this->M_patient->test($user);
		print_r($data);*/
		$timestamp = date('Y-m-d h:i:s');
		echo $date;
	}
}
