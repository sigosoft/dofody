<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Twilio\Rest\Client;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VideoGrant;
class Android extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->helper('url');
			$this->load->model('M_login');
			$this->load->model('M_android');
			$this->load->model('Common');
	}
	public function token()
	{
		// Required for all Twilio access tokens
		$twilioAccountSid = 'ACfbaf9873ed4f23cf8bf9fa5f7ee06381';
		$twilioApiKey = 'SKbc9713b7de2ee9645c98590de25455d8';
		$twilioApiSecret = 'FlaXADsQgNnXe4zdZjqXQR3v06BhBgHI';

		// A unique identifier for this user
		$identity = $this->create_room();
		// The specific Room we'll allow the user to access
		$roomName = 'sigosoft';

		// Create access token, which we will serialize and send to the client
		$token = new AccessToken($twilioAccountSid, $twilioApiKey, $twilioApiSecret, 3600, $identity);

		// Create Video grant
		$videoGrant = new VideoGrant();
		$videoGrant->setRoom($roomName);

		// Add grant to token
		$token->addGrant($videoGrant);
		$data = array(
			'token' => $token->toJWT(),
			'roomName' => $roomName,
      'identity' => $identity
		);
		echo json_encode($data);
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
           
        public function generate_token()
	{
                  $roomName = $_POST['roomName'];
		// Required for all Twilio access tokens
		$twilioAccountSid = 'ACfbaf9873ed4f23cf8bf9fa5f7ee06381';
		$twilioApiKey = 'SKbc9713b7de2ee9645c98590de25455d8';
		$twilioApiSecret = 'FlaXADsQgNnXe4zdZjqXQR3v06BhBgHI';

		// A unique identifier for this user
		$identity = $this->create_room();
		// The specific Room we'll allow the user to access
		//$roomName = 'sigosoft';

		// Create access token, which we will serialize and send to the client
		$token = new AccessToken($twilioAccountSid, $twilioApiKey, $twilioApiSecret, 3600, $identity);

		// Create Video grant
		$videoGrant = new VideoGrant();
		$videoGrant->setRoom($roomName);

		// Add grant to token
		$token->addGrant($videoGrant);
		$data = array(
			'token' => $token->toJWT(),
			'roomName' => $roomName,
                        'identity' => $identity
		);
		echo json_encode($data);
                
	}
	public function login()
	{
		if (isset($_POST['emailAddress']) && isset($_POST['password'])) {
			$data['email'] = $_POST['emailAddress'];
			$data['password'] = md5($_POST['password']);
			$user = $this->M_login->get_user_details($data);
			if ($user) {
				if ($user->user_status == '2') {
					$return['status'] = 'Account blocked';
				}
				elseif($user->user_status == '3')
				{
				    $return['message'] = 'failed';
				}
				else {
					$type = $user->user_type;
					switch ($type) {
						case 1:
									$return=array(
											'status' => 'success',
											'user_type' => 'admin',
											'user_id' => $user->user_id,
											'name' => $user->name
										);
									break;
						case 2:
									$return=array(
											'status' => 'success',
											'user_type' => 'doctor',
											'user_id' => $user->user_id,
											'name' => $user->name
										);
									$array = [
						                'firebase_id' => $_POST['token'],
						                'type'        => 'android'
						                ];
						            $this->Common->update('user_id',$user->user_id,'device_ids',$array);
									break;
					  case 3:
					                $array = [
						                'firebase_id' => $_POST['token'],
						                'type'        => 'android'
						                ];
						            $this->Common->update('user_id',$user->user_id,'device_ids',$array);
									$return=array(
											'status' => 'success',
											'user_type' => 'patient',
											'user_id' => $user->user_id,
											'name' => $user->name
										);
									break;
						default:
										echo 'Error';
										break;
					}
				}
			}
			else {
				$return['message'] = 'failed';
			}
			print_r(json_encode($return));
		}
	}
	//------------------------------FUNCTION ADD USER ---------------------------------//
	
    public function registerUser()
	{
	    $return = array();
		$data = $this->input->post();
		extract($data);
		unset($data['token']);
		$num_m = $this->Common->get_details('dofody_users',array('mobile' => $mobile))->num_rows();
		$num_e = $this->Common->get_details('dofody_users',array('email' => $email))->num_rows();
		if($num_m == 0 && $num_e == 0)
		{
		    date_default_timezone_set('Asia/Kolkata');
		    $current = date('Y-m-d H:i:s');
		    $array = array('last_update' => $current);
		    $data['password'] = md5($password);
    		if($user_type == '2')
    		{
    		    $data['user_status'] = 2;
    		    $array['type'] = '2';
    		}
    		elseif($user_type == '3')
    		{
    		    $data['user_status'] = 1;
    		    $array['type'] = '3';
    		}
    		$date = date('Y-m-d');
    		$data['add_date'] = $date;
    		$id = $this->Common->insert('dofody_users',$data);
		    $array['user'] = $id;
		    $this->Common->insert('online_users',$array);
		    if($user_type == '3')
    		{
    		    extract($data);
    		    $patient = [
    		        'patient_name' => $name,
    		        'city' => $place,
    		        'patient_mobile' => $mobile,
    		        'patient_email' => $email,
    		        'p_user_id' => $id
    		        ];
    		    $this->Common->insert('patients_details',$patient);
    		    $device = [
		            'firebase_id' => $token,
		            'user_id'     => $id,
		            'type'        => 'android'
		        ];
		        $this->Common->insert('device_ids',$device);
    		}
    		elseif($user_type == '2')
    		{
    		    $device = [
		            'firebase_id' => $token,
		            'user_id'     => $id,
		            'type'        => 'android'
		        ];
		        $this->Common->insert('device_ids',$device);
    		}
    		$return['user_type'] = $user_type;
    		$return['user_id'] = $id;
    		$return['name'] = $name;
    		$return['status'] = 'success';
    		$return['message'] = 'Registered';
    		
		}
		elseif($num_m != 0)
		{
		    
		    $return['status'] = 'failed';
		    $return['message'] = 'Mobile number already registered..!';
		        
		}
		elseif($num_e != 0)
		{
		    $return['status'] = 'failed';
		    $return['message'] = 'Email address already registered..!';
		        
		}
		print_r(json_encode($return));
		
	}
	public function upload()
	{
	    
        /*$file_path = "uploads/";
         
        $file_path = $file_path . basename( $_FILES['uploaded_file']['name']);
        if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $file_path) ){
            echo "success";
        } 
        else{
            echo "fail";
        }*/
        $file=$_FILES['uploaded_file'];
		$tar = "uploads/";
		$rand=date('Ymd').mt_rand(1001,9999);
		$tar_file = $tar . $rand . basename($file['name']);
		if(move_uploaded_file($file["tmp_name"], $tar_file))
		{
			echo "success";
		}
		else
		{
		    echo "failed";
		}
	}
	public function add_doctor_fee()
	{
		$data = $this->input->post();
		if ($this->Common->insert('doctor_fee',$data)) {
			$ret = array(
				'status' => 'success'
			);
		}
		else {
			$ret = array(
				'status' => 'failed'
			);
		}
		print_r(json_encode($ret));
	}
	public function phoneChange()
	{
	    $phone = $_POST['mobile'];
	    $user = $_POST['doctor_id'];
	    $this->Common->update('user_id',$user,'dofody_users',array('mobile' => $phone));
	    $data = array(
	        'status' => 'success'
	        );
	    echo json_encode($data);
	}
	public function uploadIdentity()
	{
		$type = $_POST['type'];
		$file = $_POST['image'];
		$format = $_POST['format'];
		$doctor_id = $_POST['doctor_id'];
		$url = FCPATH.'uploads/doc_id/';
		$rand='identity'.date('Ymd').mt_rand(1001,9999);
		$userpath = $url.$rand.'.png';
		$path = "uploads/doc_id/".$rand.'.png';
		file_put_contents($userpath,base64_decode($file));
		$array = array(
			'type_of_id' => $type,
			'identity' => $path,
			'format' => $format,
			'doctor_id' => $doctor_id
		);
		if ($this->Common->insert('doctor_identity',$array)) {
			$return = array(
				'msg' => 'success'
			);
		}
		else {
			$return = array(
				'msg' => 'failed'
			);
		}
		echo json_encode($return);
	}
	public function uploadBank()
	{
		$holder = $_POST['holder_name'];
		$bank = $_POST['bank_name'];
		$ifsc = $_POST['ifsc'];
		$account_number = $_POST['account_number'];
		$document_type = $_POST['document_type'];
		$doctor = $_POST['doctor_id'];
		$format = $_POST['format'];

		$file = $_POST['document'];
		$url = FCPATH.'uploads/doc_bank/';
		$rand='bank'.date('Ymd').mt_rand(1001,9999);
		$userpath = $url.$rand.'.png';
		$path = "uploads/doc_bank/".$rand.'.png';
		file_put_contents($userpath,base64_decode($file));
		$array = array(
			'acc_bank' => $bank,
			'acc_holder' => $holder,
			'acc_number' => $account_number,
			'acc_ifsc' => $ifsc,
			'document_type' => $document_type,
			'doc_account' => $path,
			'format' => $format,
			'doctor_id' => $doctor
		);
		if ($this->Common->insert('doctor_accounts',$array)) {
			$return = array(
				'msg' => 'success'
			);
		}
		else {
			$return = array(
				'msg' => 'failed'
			);
		}
		echo json_encode($return);
	}
	public function getStreams()
	{
		$stream = $this->M_android->getStreams();
		print_r(json_encode($stream));
	}
	public function getSpecial()
	{
	    $stream_id = $_POST['stream_id'];
	    $special = $this->M_android->getSpecialById($stream_id);
	    print_r(json_encode($special));
	}
	public function uploadDegree()
	{
		$data = array(
			'degree_type' => $_POST['degree_type'],
			'degree_name' => $_POST['stream_id'],
			'college' => $_POST['college'],
			'pass_year' => $_POST['pass_year'],
			'university' => $_POST['university'],
			'format' => $_POST['format'],
			'doctor_id' => $_POST['doctor_id'],
		);

		$file = $_POST['document'];
		$url = FCPATH.'uploads/doc_degree/';
		$rand='degree'.date('Ymd').mt_rand(1001,9999);
		$userpath = $url.$rand.'.png';
		$path = "uploads/doc_degree/".$rand.'.png';
		file_put_contents($userpath,base64_decode($file));
		$data['doc_degree'] = $path;
		if ($this->Common->insert('doctor_degree',$data)) {
			$return = array(
				'msg' => 'success'
			);
		}
		else {
			$return = array(
				'msg' => 'failed'
			);
		}
		echo json_encode($return);
	}
	public function uploadReg()
	{
		$data = array(
			'reg_number' => $_POST['reg_number'],
			'reg_council' => $_POST['reg_council'],
			'format' => $_POST['format'],
			'doctor_id' => $_POST['doctor_id']
		);

		$file = $_POST['document'];
		$url = FCPATH.'uploads/doc_reg/';
		$rand='reg'.date('Ymd').mt_rand(1001,9999);
		$userpath = $url.$rand.'.png';
		$path = "uploads/doc_reg/".$rand.'.png';
		file_put_contents($userpath,base64_decode($file));
		$data['doc_reg'] = $path;
		if ($this->Common->insert('doctor_reg',$data)) {
			$return = array(
				'msg' => 'success'
			);
		}
		else {
			$return = array(
				'msg' => 'failed'
			);
		}
		echo json_encode($return);
	}
	public function doctorFee()
	{
		$data = array(
			'audio_fee' => $_POST['audio'],
			'video_fee' => $_POST['video'],
			'chat_fee' => $_POST['chat'],
			'doctor_id' => $_POST['doctor_id']
		);
		if( $this->Common->insert('doctor_fee',$data) )
		{
			$return = array(
				'msg' => 'success'
			);
		}
		else {
			$return = array(
				'msg' => 'failed'
			);
		}
		echo json_encode($return);
	}
	public function onlineClinic()
	{
		$array = array(
			'from_time' => $_POST['from'],
			'to_time' => $_POST['to'],
			'doctor_id' => $_POST['doctor_id']
		);
		$days = json_decode($_POST['days'],TRUE);
		$ch = implode(", ", $days);
		$array['days'] = $ch;

        if($this->Common->insert('doctor_clinic',$array))
        {
            $return = array(
                'msg' => 'success'
                );
        }
        else
        {
            $return = array(
                'msg' => 'failed'
                );
        }
        echo json_encode($return);
	}
	public function getRequestByDoctorId()
	{
	    $id = $_POST['doctor_id'];
	    $data = $this->M_android->getRequestByDoctorId($id);
	    print_r(json_encode($data));
	}
	public function getChatRequestByDoctorId()
	{
	    $id = $_POST['doctor_id'];
	    $data = $this->M_android->getChatRequestByDoctorId($id);
	    print_r(json_encode($data));
	}
	public function getRequestById()
	{
		$id = $_POST['request_id'];
		date_default_timezone_set('Asia/Kolkata');
		$current = strtotime(date('Y-m-d H:i:s'));
		$request = $this->M_android->getRequestById($id);
		$status = $this->Common->get_details('online_users',array('user' => $request->p_user_id))->row();
		$last_logged = strtotime($status->last_update);
		$active = round(abs($current - $last_logged) / 60,0);
		if ($active < 3) {
			$online = 'Online';
		}
		elseif ($active >= 3 && $active < 60) {
			$online = "Active ".$active." minutes ago";
		}
		elseif ($active >= 60 && $active < 1440) {
			$hour = floor($active/60);
			$online = "Active ".$hour." hour ago";
		}
		elseif($active >= 1440) {
			list($dat) = explode(' ', $status->last_update);
			$online = "Last seen : ".$dat;
		}
		$request->status = $online;
		print_r(json_encode($request));
	}
	public function getDoctorsList()
	{
		date_default_timezone_set('Asia/Kolkata');
		$current = strtotime(date('Y-m-d H:i:s'));
		$data = $this->M_android->getDoctorsList();
		foreach ($data as $det) {
			$str = $this->M_android->get_stream($det->user_id);
			$det->stream = $str->stream_name;
			$last_logged = strtotime($det->last_update);
			$active = round(abs($current - $last_logged) / 60,0);
			$special = $this->M_android->get_special($det->user_id);
			$string = '';
			foreach ($special as $sp) {
				$string = $string . $sp->special_name . ' ,';
			}
			$det->special=rtrim($string," ,");
			if ($active < 3) {
				$online = 'Online';
			}
			elseif ($active >= 3 && $active < 60) {
				$online = "Active ".$active." minutes ago";
			}
			elseif ($active >= 60 && $active < 1440) {
				$hour = floor($active/60);
				$online = "Active ".$hour." hour ago";
			}
			elseif($active >= 1440) {
				list($dat) = explode(' ', $det->last_update);
				$online = "Last seen : ".$dat;
			}
			$det->status = $online;
		}
		print_r(json_encode($data));
	}
	public function addMember()
	{
		$data = $this->input->post();
		if( $data['photo'] != '')
		{
		    $file = $data['photo'];
    		$url = FCPATH.'uploads/profile/';
    		$rand='profile'.date('Ymd').mt_rand(1001,9999);
    		$userpath = $url.$rand.'.png';
    		$path = "uploads/profile/".$rand.'.png';
    		file_put_contents($userpath,base64_decode($file));
    		$data['profile_photo'] = $path;    
		}
		else
		    $data['profile_photo'] = 'nil';
		
		unset($data['photo']);
		if($this->Common->insert('patients_details',$data))
		{
			$return = array(
				'msg' => 'success'
			);
		}
		else {
			$return = array(
				'msg' => 'failed'
			);
		}
		print_r(json_encode($return));
	}
	public function editMember()
	{
	    $data = $this->input->post();
	    $patient_id = $data['patient_id'];
	    $user_id = $data['user_id'];
		if( $data['photo'] != '')
		{
		    $file = $data['photo'];
    		$url = FCPATH.'uploads/profile/';
    		$rand='profile'.date('Ymd').mt_rand(1001,9999);
    		$userpath = $url.$rand.'.png';
    		$path = "uploads/profile/".$rand.'.png';
    		file_put_contents($userpath,base64_decode($file));
    		$data['profile_photo'] = $path;    
		}
		$array = [
		    'name' => $data['patient_name'],
		    'place' => $data['city'],
		    'mobile' => $data['patient_mobile'],
		    'email' => $data['patient_email']
		    ];
		unset($data['photo']);
		unset($data['patient_id']);
		unset($data['user_id']);
		$this->Common->update('user_id',$user_id,'dofody_users',$array);
		if($this->Common->update('patient_id',$patient_id,'patients_details',$data))
		{
			$return = array(
				'msg' => 'success'
			);
		}
		else {
			$return = array(
				'msg' => 'failed'
			);
		}
		print_r(json_encode($return));
	}
	public function editFamilyMember()
	{
	    $data = $this->input->post();
	    $patient_id = $data['patient_id'];
		if( $data['photo'] != '')
		{
		    $file = $data['photo'];
    		$url = FCPATH.'uploads/profile/';
    		$rand='profile'.date('Ymd').mt_rand(1001,9999);
    		$userpath = $url.$rand.'.png';
    		$path = "uploads/profile/".$rand.'.png';
    		file_put_contents($userpath,base64_decode($file));
    		$data['profile_photo'] = $path;    
		}
		
		unset($data['photo']);
		unset($data['patient_id']);
		if($this->Common->update('patient_id',$patient_id,'patients_details',$data))
		{
			$return = array(
				'msg' => 'success'
			);
		}
		else {
			$return = array(
				'msg' => 'failed'
			);
		}
		print_r(json_encode($return));
	}
	public function getFamilyMembers()
	{
		$id = $_POST['user_id'];
		$data = $this->M_android->getFamilyMembers($id);
		print_r(json_encode($data));
	}
	public function getMemberDetails()
	{
		$id = $_POST['patient_id'];
		$data = $this->Common->get_details('patients_details',array('patient_id' => $id))->row();
		print_r(json_encode($data));
	}
	public function getParentDetail()
	{
		$id = $_POST['user_id'];
		$data = $this->M_android->getParentDetail($id);
		print_r(json_encode($data));
	}
	/*public function uploadTest()
	{
	    echo '<pre>';
        print_r($_FILES);
        echo '</pre>';
        
        // DISPLAY POST DATA JUST TO CHECK IF THE STRING DATA EXIST
        echo '<pre>';
        print_r($_POST);
        echo '</pre>';
        
        $file_path = base_url() . "uploads/test/";
        $file_path = $file_path . basename( $_FILES['file']['name']);
        
        if(move_uploaded_file($_FILES['file']['tmp_name'], $file_path)) {
            echo "file saved success";
        } else{
           echo "failed to save file";
        }
	}*/
	public function uploadTest1()
	{
        $url = FCPATH.'uploads/test/';
        if(isset($_POST['name']) and isset($_FILES['pdf']['name'])){
         $file_path = $url . basename( $_FILES['pdf']['name']);
         if(move_uploaded_file($_FILES['pdf']['tmp_name'], $file_path)) {
            echo "file saved success";
         } else{
           echo "failed to save file";
         }   
        }
	}
	public function getMemberNames()
	{
		$id = $_POST['user_id'];
		$data = $this->M_android->getMemberNames($id);
		print_r(json_encode($data));
	}
	public function uploadTest()
	{
	    $file = $_FILES['document'];
		$file_path = "uploads/med_records/" . basename( $file['name']);
		$url = FCPATH . $file_path;
	    if(move_uploaded_file($file['tmp_name'], $url)) {
	      $data['med_document'] = $file_path;
	    } else{
	      $data['med_document'] = 'nil';
	    } 
	    print_r(json_encode($data));
	}
	public function addMedicalRecord()
	{
		$title = $_POST['title'];
		$data = [
			'med_title'  => $title,
			'med_notes'  => $_POST['notes'],
			'patient_id' => $_POST['patient_id'],
			'user_id'    => $_POST['user_id']
		];
		if ($title == 'Electronic medical record') {
			$file = $_FILES['document'];
			$file_path = "uploads/med_records/" . basename( $file['name']);
			$url = FCPATH . $file_path;
	    if(move_uploaded_file($file['tmp_name'], $url)) {
	      $data['med_document'] = $file_path;
	    } else{
	      $data['med_document'] = 'nil';
	    }
		}
		else {
			$file = $_POST['document'];
			$url = FCPATH.'uploads/test/';
			$rand='test'.date('Ymd').mt_rand(1001,9999);
			$userpath = $url.$rand.'.png';
			$path = "uploads/test/".$rand.'.png';
			file_put_contents($userpath,base64_decode($file));
			$data['med_document'] = $path;
		}
		if ($this->Common->insert('medical_records',$data)) {
			$return = ['msg' => 'success'];
		}
		else {
			$return = ['msg' => 'failed'];
		}
		print_r(json_encode($return));
	}
	public function getImageFiles()
	{
		$user_id = $_POST['user_id'];
		$data = $this->M_android->getImageFiles($user_id);
		print_r(json_encode($data));
	}
	public function addRecords()
	{
		$title = $_POST['title'];
		$data = [
			'med_title'  => $title,
			'med_notes'  => $_POST['notes'],
			'patient_id' => $_POST['patient_id'],
			'user_id'    => $_POST['user_id']
		];

		$file = $_POST['document'];
		$url = FCPATH.'uploads/med_records/';
		$rand='record'.date('Ymd').mt_rand(1001,9999);
		$userpath = $url.$rand.'.png';
		$path = "uploads/med_records/".$rand.'.png';
		file_put_contents($userpath,base64_decode($file));
		$data['med_document'] = $path;

		if ($this->Common->insert('medical_records',$data)) {
			$return = ['msg' => 'success'];
		}
		else {
			$return = ['msg' => 'failed'];
		}
		print_r(json_encode($return));
	}
	public function addEMR()
	{
		$title = $_POST['title'];
		$data = [
			'med_title'  => $title,
			'med_notes'  => $_POST['notes'],
			'patient_id' => $_POST['patient_id'],
			'user_id'    => $_POST['user_id']
		];
		$file = $_FILES['document'];
		$file_path = "uploads/med_records/" . basename( $file['name']);
		$url = FCPATH . $file_path;
	    if(move_uploaded_file($file['tmp_name'], $url)) {
	      $data['med_document'] = $file_path;
	    } else{
	      $data['med_document'] = 'nil';
	    }
		if ($this->Common->insert('medical_records',$data)) {
			$return = ['msg' => 'success'];
		}
		else {
			$return = ['msg' => 'failed'];
		}
		print_r(json_encode($return));
	}
	public function getRecordsById()
	{
	    $id = $_POST['user_id'];
	    $data = $this->Common->get_details('medical_records',array('user_id' => $id))->result();
	    print_r(json_encode($data));
	}
	public function send()
	{
	    $id = $_POST['user_id'];
	    $res = $this->Common->get_details('device_ids',array('user_id' => $id))->row();
	    if($res->type == 'android')
	    {
	        $url = "https://dofody.com/notification/testing_notification.php";
    	    $data = [
    	        'token' => $res->firebase_id,
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
    		}
	    }
	}
	public function getDoctorFee()
	{
	    $id = $_POST['doctor_id'];
	    $data = $this->Common->get_details('doctor_fee',array('doctor_id' => $id))->row();
	    echo json_encode($data);
	}
	public function getDoctorConsult()
	{
	    $id = $_POST['doctor_id'];
	    $data = $this->Common->get_details('doctor_clinic',array('doctor_id' => $id))->row();
	    $string = $data->days;
	    $array = explode(', ',$string);
	    $data->day = $array;
	    echo json_encode($data);
	}
	public function updateFee()
	{
	    $data = $this->input->post();
	    if($this->Common->update('doctor_id',$data['doctor_id'],'doctor_fee',$data))
	    {
	        $return = ['msg' => 'success'];
	    }
	    else
	    {
	        $return = ['msg' => 'failed'];
	    }
	    print_r(json_encode($return));
	}
	public function updateClinic()
	{
	    $array = array(
			'from_time' => $_POST['from'],
			'to_time' => $_POST['to'],
			'doctor_id' => $_POST['doctor_id']
		);
		$days = json_decode($_POST['days'],TRUE);
		$ch = implode(", ", $days);
		$array['days'] = $ch;

        if($this->Common->update('doctor_id',$array['doctor_id'],'doctor_clinic',$array))
        {
            $return = ['msg' => 'success'];
        }
        else
        {
            $return = ['msg' => 'failed'];
        }
        echo json_encode($return);
	}
	public function getRoomName()
	{
	    $request = $_POST['request_id'];
	    $data = $this->Common->get_details('rooms',array('request_id' => $request))->row();
	    print_r(json_encode($data));
	}
	public function sendNotification()
	{
	    $request = $_POST['request_id'];
	    $patient = $this->M_android->getPatientId($request);
	    $res = $this->Common->get_details('device_ids',array('user_id' => $patient))->row();
	    /*$url = "https://sigosoft.com/demo/notification/testing_notification.php";
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
    			'request' => $request,
    			'type' => 'call'
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
	public function getPastMedical()
	{
	    $patient = $_POST['patient_id'];
	    $data = $this->M_android->getPastMedical($patient);
	    print_r(json_encode($data));
	}
	public function getQuickFee()
	{
	    $data = $this->Common->get_details('quick_fee',array('fee_id' => 1))->row();
	    print_r(json_encode($data));
	}
	public function getListOfDoctors()
	{
		$data = $this->M_android->getListOfDoctors();
		foreach ($data as $det) {
			$str = $this->M_android->get_stream($det->user_id);
			$det->stream = $str->stream_name;
			$special = $this->M_android->get_special($det->user_id);
			$string = '';
			foreach ($special as $sp) {
				$string = $string . $sp->special_name . ' ,';
			}
			$det->special=rtrim($string," ,");
		}
		print_r(json_encode($data));
	}
	public function addRequest()
	{
	    date_default_timezone_set('Asia/Kolkata');
	    $data = $this->input->post();
	    $data['date'] = date('Y-m-d');
	    $data['time'] = date('H:i:s');
	    $data['start_time'] = date('Y-m-d H:i:s');
	    $data['status_time'] = '0';
	    $id = $this->Common->insert('requests',$data);
	    $fee = $this->M_android->getFeeByDoctorId($data['doctor_id'],$data['type_consult']);
	    $trans = [
	      'request_id' => $id,
	      'doctor_id' => $data['doctor_id'],
	      'fee' => $fee,
	      'date' => date('Y-m-d')
	    ];
	    $this->Common->insert('transactions',$trans);
	    if($id)
	    {
	        $room = $this->create_room();
	        $array = ['request_id' => $id, 'room' => $room];
	        $this->Common->insert('rooms',$array);
	        $ret = ['msg' => 'success'];
	    }
	    else
	    {
	        $ret = ['msg' => 'failed'];
	    }
	    $patient_name = $this->Common->get_details('patients_details',array('patient_id' => $data['patient_id']))->row()->patient_name;
	    $message = $patient_name . " Having " . $data["present_problem"] . " is waiting for your consultation";
	    $this->notification($data['doctor_id'],$message);
	    print_r(json_encode($ret));
	}
	public function notification($id,$message)
    {
        $res = $this->Common->get_details('device_ids',array('user_id' => $id))->row();
        
        if($res->type == 'android')
	    {
	        $url = "https://dofody.com/notification/request.php";
    	    $data = [
    	        'token' => $res->firebase_id,
    	        'message' => $message
    	        ];
    	    $handle = curl_init($url);
            curl_setopt($handle, CURLOPT_POST, true);
            curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
            $response = curl_exec($handle);
            $err = curl_error($handle);
    		curl_close($handle);
	    }
	    return true;
    }
	public function getRecordsPatientById()
	{
	    $id = $_POST['patient_id'];
	    $data = $this->M_android->getRecordsPatientById($id);
	    print_r(json_encode($data));
	}
	public function deleteFamilyMembers()
	{
	    $id = $_POST['patient_id'];
	    if($this->Common->delete('patients_details',array('patient_id' => $id)))
	    {
	        $arr = ['msg' => 'success'];
	    }
	    else
	    {
	        $arr = ['msg' => 'failed'];
	    }
	    print_r(json_encode($arr));
	}
	public function uploadSignature()
	{
	    $id = $_POST['doctor_id'];
	    $file = $_POST['image'];
		$url = FCPATH.'uploads/signature/';
		$rand='signature'.date('Ymd').mt_rand(1001,9999);
		$userpath = $url.$rand.'.png';
		$path = "uploads/signature/".$rand.'.png';
		file_put_contents($userpath,base64_decode($file));
		$array = array(
			'signature' => $path,
			'doctor_id' => $id
		);
		if ($this->Common->insert('doctor_signature',$array)) {
			$return = array(
				'msg' => 'success'
			);
		}
		else {
			$return = array(
				'msg' => 'failed'
			);
		}
		echo json_encode($return);
	}
	public function addHistory()
	{
	    date_default_timezone_set('Asia/Kolkata');
		$data = [
			'date' => date('Y-m-d'),
			'time' => date('H:i:s'),
			'type' => 'missed call'
		];
		$data['request_id'] = $_POST['request_id'];
		$this->Common->insert('history',$data);
		print_r(json_encode(true));
	}
	public function updateTime()
	{
		$id = $_POST['request_id'];
		$hid = $this->M_android->getLastInserted($id);
		$time = $_POST['timer'];
		$arr = explode(":",$time);
		$t = '';
		foreach ($arr as $key) {
			if(strlen($key) == 1)
			{
				$t = $t.'0'.$key.':';
			}
			else {
				$t = $t.$key.':';
			}
		}
		$t = rtrim($t,":");
		$arr = ['duration' => $t];
		if ($this->Common->update('history_id',$hid,'history',$arr)) {
			print_r(json_encode(true));
		}
	}
	public function updateHistory()
	{
		$id = $_POST['request_id'];
		$hid = $this->M_android->getLastInserted($id);
		$arr = ['type' => 'call'];
		if ($this->Common->update('history_id',$hid,'history',$arr)) {
			print_r(json_encode(true));
		}
	}
	public function getHistoryPatient()
	{
		$user = $_POST['user_id'];
		$data = $this->M_android->getHistoryPatient($user);
		echo json_encode($data);
	}
	public function getHistoryDoctor()
	{
		$user = $_POST['user_id'];
		$data = $this->M_android->getHistoryDoctor($user);
		echo json_encode($data);
	}
	public function requestDetailView()
	{
		$user = $_POST['user_id'];
		$param = $_POST['request_id'];

		$result = $this->Common->get_details('requests',array('p_user_id' => $user,'req_id' => $param));
		if ($result->num_rows() > 0) {
			$details = $this->M_android->getRequestDetails($param);
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
			}
			else {
				$data['sent'] = $this->Common->get_details('messages',array('request_id' => $param,'user' => '1'))->num_rows();
				$data['recieved'] = $this->Common->get_details('messages',array('request_id' => $param,'user' => '0'))->num_rows();
			}
			$pres = $this->Common->get_details('prescriptions',array('request_id' => $param));
			if($pres->num_rows() > 0)
			{
			    $data['prescription'] = 'yes';
			    $data['pres_details'] = $pres->row();
			}
			else
			{
			    $data['prescription'] = 'no';
			}
		}
		else {
			$data['message'] = 'failed';
		}
		print_r(json_encode($data));
	}
	public function requestDetailViewDoctor()
	{
		$user = $_POST['doctor_id'];
		$param = $_POST['request_id'];

		$result = $this->Common->get_details('requests',array('doctor_id' => $user,'req_id' => $param));
		if ($result->num_rows() > 0) {
			$details = $this->M_android->getRequestDetails($param);
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
			}
			else {
				$data['sent'] = $this->Common->get_details('messages',array('request_id' => $param,'user' => '0'))->num_rows();
				$data['recieved'] = $this->Common->get_details('messages',array('request_id' => $param,'user' => '1'))->num_rows();
			}
			
			$pres = $this->Common->get_details('prescriptions',array('request_id' => $param));
			if($pres->num_rows() > 0)
			{
			    $data['prescription'] = 'yes';
			    $data['pres_details'] = $pres->row();
			}
			else
			{
			    $data['prescription'] = 'no';
			}
		}
		else {
			$data['message'] = 'failed';
		}
		print_r(json_encode($data));
	}
	function getMessages()
	{
		$request = $_POST['request_id'];
		$status = [
		    'status' => '1'
		    ];
		$messages = $this->Common->get_details('messages',array('request_id' => $request))->result();
		foreach($messages as $message)
		{
		    $message->timestamp = date("d/m/Y H:i:s a");
		}
		//$this->Common->update('request_id',$request,'messages',$status);
		print_r(json_encode($messages));
	}
	
	function sendMessageDoctor()
	{
	    $request_id = $_POST['request_id'];
	    $msg = $_POST['message'];
	    $message = [
	      'message' => $msg,
	      'request_id' => $request_id,
	      'user' => '0',
	      'status' => '0',
	      'date' => date('d/m/Y'),
		  'time' => date('h:i a')
	    ];
	    $this->Common->insert('messages',$message);
	    $res = $this->M_android->getFirebaseIdP($request_id);
		$SERVER_API_KEY = "AIzaSyAwhY1F4XKWgtY63JosZL2lGp3MEK6hhPQ";
		if($res->type == 'android')
		{
		    $url = "https://dofody.com/notification/message.php";
    	    $pass = [
    	        'token' => $res->firebase_id,
    	        'request_id' => $request_id,
    	        'message' => $msg,
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
		}
		else
		{
		    $msg = [
    			'title' => 'Testing notification',
    			'body' => 'testing notification body',
    			'icon' => '',
    			'image' => '',
    			'type' => 'chat',
    			'request' => $request_id,
    			'message' => $msg,
    			'date' => date('d/m/y'),
    			'time' => date('h:i a')
    		];
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
    		$return = [
    		    'message' => 'success'    
    		];
	    print_r(json_encode($return));
	}
	function sendMessagePatient()
	{
	    $request_id = $_POST['request_id'];
	    $msgs = $_POST['message'];
	    $message = [
	      'message' => $msgs,
	      'request_id' => $request_id,
	      'user' => '1',
	      'status' => '0',
	      'date' => date('d/m/Y'),
		  'time' => date('h:i a')
	    ];
	    $this->Common->insert('messages',$message);
	    $res = $this->M_android->getFirebaseIdD($request_id);
		$SERVER_API_KEY = "AIzaSyAwhY1F4XKWgtY63JosZL2lGp3MEK6hhPQ";
		if($res->type == 'android')
		{
		    $url = "https://dofody.com/notification/message.php";
    	    $pass = [
    	        'token' => $res->firebase_id,
    	        'request_id' => $request_id,
    	        'message' => $msgs,
    	        'user' => '1',
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
		}
		else
		{
		    $msg = [
    			'title' => 'Testing notification',
    			'body' => 'testing notification body',
    			'icon' => '',
    			'image' => '',
    			'type' => 'chat',
    			'request' => $request_id,
    			'message' => $msgs,
    			'date' => date('d/m/y'),
    			'time' => date('h:i a')
    		];
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
    		
    		$return = [
    		    'message' => 'success'    
    		];
	    print_r(json_encode($return));
	}
	public function getChatRequestsDoctor()
	{
		$doctor = $_POST['doctor_id'];
		$data = $this->M_android->getChatRequestsDoctor($doctor);
		print_r(json_encode($data));
	}
	public function getChatRequestsPatient()
	{
		$patient = $_POST['patient_id'];
		$data = $this->M_android->getChatRequestsPatient($patient);
		print_r(json_encode($data));
	}
	public function getMessagesDoctor()
	{
	    $request = $_POST['request_id'];
	    $data = $this->M_android->getMessages($request,'1');
	    if($data->num_rows() > 0)
	    {
	        $return = [
	            'status' => 'yes',
	            'data' => $data->result()
	            ];
	        $this->M_android->updateMessageStatusD($request);
	    }
	    else
	    {
	        $return = ['status' => 'no'];
	    }
	    print_r(json_encode($return));
	}
	public function getMessagesPatient()
	{
	    $request = $_POST['request_id'];
	    $data = $this->M_android->getMessages($request,'0');
	    if($data->num_rows() > 0)
	    {
	        $return = [
	            'status' => 'yes',
	            'data' => $data->result()
	            ];
	        $this->M_android->updateMessageStatusP($request);
	    }
	    else
	    {
	        $return = ['status' => 'no'];
	    }
	    print_r(json_encode($return));
	}
	public function addPrescription()
	{
		$data = $this->input->post();
		$date = date('Y-m-d');
		extract($data);
		$i = 0;
		$prescription = ['pro_diagonosis' => $pro_diagonosis , 'date' => $date , 'request_id' => $request_id];
		$id = $this->Common->insert('prescriptions',$prescription);
		$medicine = json_decode($medicines,TRUE);
		foreach ($medicine as $med) {
		    $med['prescription_id'] = $id;
		    $test = [
		        'medicine' => $med['medicine'],
		        'usages' => $med['usages'],
		        'days' => $med['days'],
		        'prescription_id' => $id
		        ];
			$this->Common->insert('medicines',$test);
		}
		$return = [
		  'message' => 'success'  
		];
		print_r(json_encode($return));
	}
	public function view_prescription($req,$pres_id,$user)
	{
	    $this->load->model('M_doctor');
	    /*$req = $_POST['request_id'];
	    $pres_id = $_POST['prescription_id'];
	    $user = $_POST['doctor_id'];*/
		

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
			$return = [
			    'message' => 'failed'
			    ];
			    print_r(json_encode($return));
		}
	}
	public function getPrescriptionById()
	{
	    $pres = $_POST['prescription_id'];
	    $data = [
	        'details' => $this->Common->get_details('prescriptions',array('prescription_id' => $pres))->row(),
	        'medicines' => $this->Common->get_details('medicines',array('prescription_id' => $pres))->result()
	        ];
	    print_r(json_encode($data));
	}
	public function editPrescription()
	{
		$data = $this->input->post();
		$pres_id = $data['prescription_id'];
		unset($data['prescription_id']);
		extract($data);
		$this->Common->delete('medicines',array('prescription_id' => $pres_id));
		$date = date('Y-m-d');
		$prescription = ['pro_diagonosis' => $pro_diagonosis , 'date' => $date];
		$this->Common->update('prescription_id',$pres_id,'prescriptions',$prescription);
		$medicine = json_decode($medicines,TRUE);
		foreach ($medicine as $med) {
		    $medi = [
		        'medicine' => $med['medicine'],
		        'usages' => $med['usages'],
		        'days' => $med['days'],
		        'prescription_id' => $pres_id
		        ];
			$this->Common->insert('medicines',$medi);
		}
		$return = [
		  'message' => 'success'  
		];
		print_r(json_encode($return));
	}
	public function updateFirebaseId()
	{
	    $user_id = $_POST['user_id'];
	    $device = [
	      'firebase_id' => $_POST['firebase_id'],
	      'type' => 'android'
	    ];
	    if($this->Common->update('user_id',$user_id,'device_ids',$device))
	    {
	        $return = [
	           'message' => 'success' 
	        ];
	    }
	    else
	    {
	        $return = [
	           'message' => 'failed' 
	        ];
	    }
	    print_r(json_encode($return));
	}
	public function updateRequestDoctor()
	{
	    date_default_timezone_set('Asia/Kolkata');
		$user = $_POST['doctor_id'];
		$requests = $this->M_android->getRequestsForCheck($user);
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
		$return = [
		  'message' => 'success'  
		];
		print_r(json_encode($return));
	}
	public function getConsultationDetails()
	{
	    $doctor = $_POST['doctor_id'];
	    $i=0;
	    $data = $this->M_android->getRequestIds($doctor);
	    foreach($data as $req)
	    {
	        if($this->M_android->checkHistoryExists($req->req_id))
	        {
	            $i++;
	        }
	    }
	    $return['number'] = $i;
	    $sum = 0;
	    $fees = $this->M_android->getFees($doctor);
	    foreach($fees as $fee)
	    {
	        $sum = $sum + $fee->fee;
	    }
	    $return['earning'] = $sum;
	    print_r(json_encode($return));
	}
	public function checkUsernamePassword()
	{
	    $email = $_POST['email'];
	    $mobile = $_POST['mobile'];
	    $m = $this->Common->get_details('dofody_users',array('mobile' => $mobile))->num_rows();
	    $e = $this->Common->get_details('dofody_users',array('email' => $email))->num_rows();
	    $return['message'] = 'success';
	    if($m > 0)
	    {
	        $return['message'] = 'failed';
	        $return['mobile'] = 'true';
	    }
	    else
	    {
	        $return['mobile'] = 'false';
	    }
	    if($e > 0)
	    {
	        $return['message'] = 'failed';
	        $return['email'] = 'true';
	    }
	    else
	    {
	        $return['email'] = 'false';
	    }
	    print_r(json_encode($return));
	}
	public function updateOnlineStatus()
	{
	    $id = $_POST['user_id'];
	    date_default_timezone_set('Asia/Kolkata');
		$time = date('Y-m-d H:i:s');
		$this->Common->update('user',$id,'online_users',array('last_update' => $time));
		$return = [
		  'message' => 'success'  
		];
		print_r(json_encode($return));
	}
	public function getFamilyMemberNumbers()
	{
	    $user_id = $_POST['user_id'];
	    $number = $this->Common->get_details('patients_details',array('p_user_id'=>$user_id))->num_rows();
	    $family_count = $number - 1;
	    $return = [
	      'message' => 'success',
	      'number' => $family_count
	    ];
	    print_r(json_encode($return));
	}
	public function getPendingRequestsCount()
	{
	    $count = 0;
	    $date = date('Y-m-d', strtotime('-7 days'));
	    $doctor_id = $_POST['doctor_id'];
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
	    $return = [
	      'message' => 'success',
	      'count' => $count
	    ];
	    print_r(json_encode($return));
	}
	public function getPatientDetails()
	{
		$patient_id = $_POST['patient_id'];
		$records = $this->Common->get_details('medical_records',array('patient_id' => $patient_id))->result();
		$prescriptions = $this->M_android->getAllPrescriptionsOfPatients($patient_id);
		$patient_details = $this->Common->get_details('patients_details',array('patient_id' => $patient_id))->row();
		$return = [
		  'message' => 'success',
		  'records' => $records,
		  'prescriptions' => $prescriptions,
		  'patient_details' => $patient_details
		];
		print_r(json_encode($return));
	}
	public function test1234()
	{
	    $this->load->model('M_login');
	    $data = [
	      'email' => $this->input->post('mobile'),  
	      'password' => md5($this->input->post('mobile'))
	    ];
	    
	    $user = $this->M_login->get_user_details($data);
	    print_r($user);
	}
	public function refer()
	{
	    $array = [
	      'name' => $this->input->post('name'),
	      'mobile' => $this->input->post('mobile'),
	      'email' => $this->input->post('email'),
	      'user_id' => $this->input->post('user_id'),
	      'type' => $this->input->post('type')
	    ];
	    $mStatus = true;
	    $eStatus = true;
	    $flag = true;
	    $mobile = [
	      'mobile' => $array['mobile']  
	    ];
	    $mCheck = $this->Common->get_details('refer',$mobile);
	    if($mCheck->num_rows() > 0)
	    {
	        $flag = false;
	        $mStatus = false;
	    }
	    $email = [
	       'email' => $array['email'] 
	    ];
	    $eCheck = $this->Common->get_details('refer',$email);
	    if($eCheck->num_rows() > 0)
	    {
	        $flag = false;
	        $eStatus = false;
	    }
	    if($flag)
	    {
	        if($this->Common->insert('refer',$array))
    	    {
    	        $return = [
    	          'message' => 'success'  
    	        ];
    	    }
    	    else
    	    {
    	        $return = [
    	          'message' => 'success'  
    	        ];
    	    }
	    }
	    else
	    {
	        $return = [
    	       'message' => 'failed'  
    	    ];
	    }
	    $return['mobile'] = $mStatus;
	    $return['email'] = $eStatus;
	    print_r(json_encode($return));
	}
	public function getDoctorName()
	{
	    $request_id = $_POST['request_id'];
	    $name = $this->M_android->getDoctorNameByRequestId($request_id);
	    $return = [
	      'message' => 'success',
	      'name' => $name
	    ];
	    print_r(json_encode($return));
	}
	public function getLatestMessagesDoctor()
	{
	    $this->load->model('M_doctor');
	    $doctor = $_POST['doctor_id'];
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
		$return = [
		  'message' => 'success',
		  'data' => $requests
		];
		print_r(json_encode($return));
	}
	public function getLatestMessagesPatients()
	{
	    $this->load->model('M_patient');
	    $patient_id = $this->input->post('patient_id');
		$requests = $this->M_patient->getRequestsByPatientId($patient_id);
		foreach ($requests as $request) {
			$message = $this->M_patient->getLastSendMessage($request->req_id);
			if ($message) {
				$request->message = $message;
			}
			else {
				$request->message = "No messages recieved yet from ".$request->name."";
			}
		}
		$return = [
		  'message' => 'success',
		  'data' => $requests
		];
		print_r(json_encode($return));
	}
	public function getConsultingHours()
	{
	    $p_user_id = $_POST['user_id'];
	    $requests = $this->M_android->getLastRequestByPatientId($p_user_id);
	    $result = [];
	    foreach($requests as $request)
	    {
	        if($request->type_consult != 'chat')
	        {
	            $check = $this->Common->get_details('history',array('request_id' => $request->req_id , 'type' => 'call'))->num_rows();
	            if($check == 0)
	            {
	                $time1 = date("Y-m-d H:i:s");
        	        $time2 = $this->Common->get_details('request_time',array('request_id' => $request->req_id))->row()->time;
        	        $hourdiff = round((strtotime($time2) - strtotime($time1))/3600, 1);
        	        $request->hourdiff = $hourdiff;
	                $result[] = $request;
	            }
	        }
	        else
	        {
	            $check = $this->Common->get_details('messages',array('request_id' => $request->req_id , 'user' => '1'))->num_rows();
	            if($check == 0)
	            {
	                $time1 = date("Y-m-d H:i:s");
        	        $time2 = $this->Common->get_details('request_time',array('request_id' => $request->req_id))->row()->time;
        	        $hourdiff = round((strtotime($time2) - strtotime($time1))/3600, 1);
        	        $request->hourdiff = $hourdiff;
	                $result[] = $request;
	            }
	        }
	    }
	    $return = [
	      'message' => 'success',
	      'data' => $result
	    ];
	    print_r(json_encode($return));
	}
}

?>
