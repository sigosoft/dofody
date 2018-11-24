<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
use Twilio\Jwt\ClientToken;
use Twilio\Twiml;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VoiceGrant;
class Audio extends CI_Controller {
	public $TWILIO_ACCOUNT_SID = 'ACfbaf9873ed4f23cf8bf9fa5f7ee06381';
	public $TWILIO_AUTH_TOKEN = '87b04c7e27138e7140e7879dfd6c68c1';
	public $TWILIO_TWIML_APP_SID = 'AP1996ce744d1be77486f6af7b1d3fd36d';
	public $TWILIO_CALLER_ID = '+12406211055';
	public function __construct()
	{
			parent::__construct();
			$this->load->library('session');
			$this->load->helper('url');
			$this->load->model('Common');
	}
	public function randomUsername($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
	}
	public function voice()
	{
		$response = new Twiml;
		// get the phone number from the page request parameters, if given
		if (isset($_REQUEST['To']) && strlen($_REQUEST['To']) > 0) {
		    $from = $_REQUEST['From'];
		    $number = htmlspecialchars($_REQUEST['To']);
		    $dial = $response->dial(array('callerId' => $from));

		    // wrap the phone number or client name in the appropriate TwiML verb
		    // by checking if the number given has only digits and format symbols
		    if (preg_match("/^[\d\+\-\(\) ]+$/", $number)) {
		        $dial->number($number);
		    } else {
		        $dial->client($number);
		    }
		} else {
		    $response->say("Thanks for calling!");
		}

		header('Content-Type: text/xml');
		echo $response;
	}
	public function dToken($req)
	{
		$identity = $req;
		$capability = new ClientToken($this->TWILIO_ACCOUNT_SID, $this->TWILIO_AUTH_TOKEN);
		$capability->allowClientOutgoing($this->TWILIO_TWIML_APP_SID);
		$capability->allowClientIncoming($identity);
		$token = $capability->generateToken();
		$data = json_encode($token);
		return $data;
	}
	
	public function consult($param,$req)
	{
		$sess = $this->session->userdata('dof_user');
		$user = $sess['user_id'];

		$request = $this->Common->get_details('requests',array('patient_id' => $param , 'req_id' => $req , 'doctor_id' => $user));
		if ($request->num_rows() > 0) {
			$data['token'] = $this->dToken($req);
			$data['pat'] = $this->Common->get_details('patients_details',array('patient_id' => $param))->row();
			$data['request'] = $req;
			$data['p_user'] = $request->row()->p_user_id;
			$this->load->view('doctor/audio_consultation',$data);
		}
		else {
			redirect('doctor/consult_now');
		}
	}
	
	
	//-----------------------------------ANDROID AUDIO CALL --------------//
	
	public function generateTokenD()
	{
	    $id = $_GET['identity'];
	    $identity = $id;
	    $ACCOUNT_SID = 'ACfbaf9873ed4f23cf8bf9fa5f7ee06381';
        $API_KEY = 'SK808f723b9832bfab2c7db19a5fe0e1b1';
        $API_KEY_SECRET = 'gDhHZuJECneOKPz2zLn80wxwVrYvFbTF';
        $PUSH_CREDENTIAL_SID = 'CR6b69209dc0b1006785c506382071be57';
        $APP_SID = 'AP947ddb5162a94e328a65af1a00460058';
        
        $token = new AccessToken($ACCOUNT_SID, 
                         $API_KEY, 
                         $API_KEY_SECRET, 
                         86300, 
                         $identity
        );
        // Grant access to Audio
        $grant = new VoiceGrant();
        $grant->setOutgoingApplicationSid($APP_SID);
        $grant->setPushCredentialSid($PUSH_CREDENTIAL_SID);
        $token->addGrant($grant);
        echo $token->toJWT();
	}
	public function generateTokenP()
	{
	    $id = $_GET['identity'];
	    $identity = 'user'.$id;
	    $ACCOUNT_SID = 'ACfbaf9873ed4f23cf8bf9fa5f7ee06381';
        $API_KEY = 'SK808f723b9832bfab2c7db19a5fe0e1b1';
        $API_KEY_SECRET = 'gDhHZuJECneOKPz2zLn80wxwVrYvFbTF';
        $PUSH_CREDENTIAL_SID = 'CR6b69209dc0b1006785c506382071be57';
        $APP_SID = 'AP947ddb5162a94e328a65af1a00460058';
        
        $token = new AccessToken($ACCOUNT_SID, 
                         $API_KEY, 
                         $API_KEY_SECRET, 
                         86300, 
                         $identity
        );
        // Grant access to Audio
        $grant = new VoiceGrant();
        $grant->setOutgoingApplicationSid($APP_SID);
        $grant->setPushCredentialSid($PUSH_CREDENTIAL_SID);
        $token->addGrant($grant);
        echo $token->toJWT();
	}
	public function androidVoice()
	{
	    $to = $_POST["to"];
	    $from = $_POST['from'];
	    $callerId = 'client:doctor';
        $callerNumber = '+12406211055';
        $response = new Twilio\Twiml();
        $dial = $response->dial(
            array(
               'callerId' => $from
            ));
          $dial->client($to);
          print $response;
	}
}
?>
