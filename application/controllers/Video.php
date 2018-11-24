<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Twilio\Rest\Client;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VideoGrant;
class Video extends CI_Controller {

	public function __construct()
	{
			parent::__construct();
			$this->load->library('session');
			$this->load->helper('url');
			$this->load->model('Common');
	}
	public function talk_to_patient($param,$req)
	{
		$sess = $this->session->userdata('dof_user');
		$user = $sess['user_id'];

		$request = $this->Common->get_details('requests',array('patient_id' => $param , 'req_id' => $req , 'doctor_id' => $user));
		if ($request->num_rows() > 0) {
			$arr = $request->row();
			$data = $this->doctorToken($req);
			$data['p_user'] = $arr->p_user_id;
			$data['request'] = $req;
			$this->load->view('doctor/video_consultation',$data);
		}
		else {
			redirect('doctor/consult_now');
		}
	}

	public function twilio()
	{
		$this->load->view('admin/twilio');
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

	public function token_doctor($req)
	{
		$twilioAccountSid = 'ACfbaf9873ed4f23cf8bf9fa5f7ee06381';
	  $twilioApiKey = 'SKbc9713b7de2ee9645c98590de25455d8';
	  $twilioApiSecret = 'FlaXADsQgNnXe4zdZjqXQR3v06BhBgHI';

		$arr = $this->Common->get_details('requests',array('req_id' => $req))->row();

		$call = $this->Common->get_details('calls',array('request_id' => $req));
		if ($call->num_rows() > 0) {
			$data = array(
				'doctor_status' => 'away',
				'patient_notification' => '0'
			);
			$this->Common->update('request_id',$req,'calls',$data);
			$result = $call->row();
			$roomName = $result->room_name;
		}
		else {
			$data = array(
				'request_id' => $arr->req_id,
				'patient_id' => $arr->patient_id,
				'doctor_id' => $arr->doctor_id,
				'patient_user' => $arr->p_user_id,
				'patient_device_id' => 'patient',
				'doctor_device_id' => 'doctor',
				'doctor_status' => 'away',
				'patient_status' => 'away',
				'call_type' => 'video',
				'room_name' => $this->create_room()
			);
			$this->Common->insert('calls',$data);
			$roomName = $data['room_name'];
		}
		$identity = 'doctor';
		$token = new AccessToken($twilioAccountSid, $twilioApiKey, $twilioApiSecret, 3600, $identity);

		$videoGrant = new VideoGrant();
		$videoGrant->setRoom($roomName);

		$token->addGrant($videoGrant);

		$return = array(
			'token' => $token,
			'roomName' => $roomName,
      'identity' => $identity
		);
		return $return;

	}

  public function token_patient($call_id)
	{
		// Required for all Twilio access tokens
		$twilioAccountSid = 'ACfbaf9873ed4f23cf8bf9fa5f7ee06381';
		$twilioApiKey = 'SKbc9713b7de2ee9645c98590de25455d8';
		$twilioApiSecret = 'FlaXADsQgNnXe4zdZjqXQR3v06BhBgHI';

		// A unique identifier for this user
		$identity = "patient";
		$call = $this->Common->get_details('calls',array('call_id' => $call_id))->row();
		// The specific Room we'll allow the user to access
		$roomName = $call->room_name;

		// Create access token, which we will serialize and send to the client
		$token = new AccessToken($twilioAccountSid, $twilioApiKey, $twilioApiSecret, 3600, $identity);

		// Create Video grant
		$videoGrant = new VideoGrant();
		$videoGrant->setRoom($roomName);

		// Add grant to token
		$token->addGrant($videoGrant);
		$data = array(
			'token' => $token,
			'roomName' => $roomName,
      'identity' => $identity
		);
		return $data;
	}

	public function change_status_doctor()
	{
		$request = $_POST['request'];
		$array = array(
			'doctor_status' => 'away',
			'patient_status' => 'away',
			'patient_notification' => '0'
		);
		$this->Common->update('request_id',$request,'calls',$array);
	}
	public function doctor_active()
	{
		$request = $_POST['request'];
		$array = array(
			'doctor_status' => 'line',
			'patient_notification' => '0'
		);
		$this->Common->update('request_id',$request,'calls',$array);
		echo json_encode($request);
	}

	public function talk_to_doctor($param)
	{
		$sess = $this->session->userdata('dof_user');
		$user = $sess['user_id'];

		$data = $this->patientToken($param);
		$data['req'] = $param;
		$this->load->view('patient/video_consultation',$data);

	}
	public function doctorToken($req)
	{
		$twilioAccountSid = 'ACfbaf9873ed4f23cf8bf9fa5f7ee06381';
		$twilioApiKey = 'SKbc9713b7de2ee9645c98590de25455d8';
		$twilioApiSecret = 'FlaXADsQgNnXe4zdZjqXQR3v06BhBgHI';

		$identity = "doctor";
		$room = $this->Common->get_details('rooms',array('request_id' => $req))->row();
		$roomName = $room->room;

		$token = new AccessToken($twilioAccountSid, $twilioApiKey, $twilioApiSecret, 7200, $identity);

		$videoGrant = new VideoGrant();
		$videoGrant->setRoom($roomName);

		$token->addGrant($videoGrant);
		$data = array(
			'token' => $token,
			'roomName' => $roomName,
      'identity' => $identity
		);
		return $data;
	}
	public function patientToken($req)
	{
		$twilioAccountSid = 'ACfbaf9873ed4f23cf8bf9fa5f7ee06381';
		$twilioApiKey = 'SKbc9713b7de2ee9645c98590de25455d8';
		$twilioApiSecret = 'FlaXADsQgNnXe4zdZjqXQR3v06BhBgHI';

		$identity = "patient";
		$room = $this->Common->get_details('rooms',array('request_id' => $req))->row();
		$roomName = $room->room;

		$token = new AccessToken($twilioAccountSid, $twilioApiKey, $twilioApiSecret, 7200, $identity);

		$videoGrant = new VideoGrant();
		$videoGrant->setRoom($roomName);

		$token->addGrant($videoGrant);
		$data = array(
			'tok' => $token,
			'roomName' => $roomName,
      'identity' => $identity
		);
		return $data;
	}
	public function doctor()
	{
		$data = $this->doctorToken();
		$this->load->view('doctor/video',$data);
	}
	public function patient()
	{
		$data = $this->patientToken();
		$this->load->view('patient/video',$data);
	}
}

?>
