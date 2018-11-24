<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Twilio\Jwt\ClientToken;
use Twilio\Twiml;
class Login extends CI_Controller {
    public $TWILIO_ACCOUNT_SID = 'ACfbaf9873ed4f23cf8bf9fa5f7ee06381';
	public $TWILIO_AUTH_TOKEN = '87b04c7e27138e7140e7879dfd6c68c1';
	public $TWILIO_TWIML_APP_SID = 'AP1996ce744d1be77486f6af7b1d3fd36d';
	public function __construct()
	{
			parent::__construct();
			$this->load->library('session');
			$this->load->helper('url');
			$this->load->model('M_login');
			$this->load->model('Common');
	}
	public function index()
	{
		$this->load->view('login/login');
	}
	public function check()
	{
		if (isset($_POST['email']) && isset($_POST['password'])) {
			$data = $this->input->post();
			$token = $data['token'];
			unset($data['token']);
			$data['password'] = md5($data['password']);
			$user = $this->M_login->get_user_details($data);
			if ($user) {
				if ($user->user_status == '2') {
					$this->session->set_flashdata('message', 'Temporarily unavailable..!');
					redirect('login');
				}
				elseif($user->user_status == '3')
				{
				    $this->session->set_flashdata('message', 'Invalid username or password');
						redirect('doctor-login');
				}
				else {
					$profile = $this->M_login->getPatientImage($user->user_id);
					if ($profile->num_rows() > 0) {
						$image = $profile->row();
						$img = base_url() . $image->profile_photo;
					}
					else {
						$img = base_url() . "uploads/profile/user.png";
					}
					$type = $user->user_type;
					if ($type == '3') {
						$dof_user=array(
								'user' => $user->name,
								'user_type' => 3,
								'user_id' => $user->user_id,
								'profile' => $img
							);
						if(isset($token)){
						    $array = [
						      'firebase_id' => $token,
						      'type' => 'web',
						      'user_id' => $user->user_id
						    ];
						}
						else
						{
						  $array = [
						      'firebase_id' => 'nil',
						      'type' => 'web',
						      'user_id' => $user->user_id
						    ];  
						}
						$check = $this->Common->get_details('device_ids',array('user_id' => $user->user_id));
						if($check->num_rows() > 0)
						{
						    $this->Common->update('user_id',$user->user_id,'device_ids',$array);
						}
						else
						{
						    $this->Common->insert('device_ids',$array);
						}
						$dof_user['token'] = $this->pToken($user->user_id);
						$this->session->set_userdata('dof_user',$dof_user);
						redirect('patient/dashboard');
					}
					else {
						$this->session->set_flashdata('message', 'Invalid username or password');
						redirect('login');
					}
				}
			}
			else {
				$this->session->set_flashdata('message', 'Invalid username or password');
				redirect('login');
			}
		}
		else {
			redirect('login');
		}
	}
	public function logout($param=0)
	{
		$this->session->unset_userdata('dof_user');
		redirect('login');
	}
	public function pToken($id)
	{
		$identity = 'user'.$id;
		$capability = new ClientToken($this->TWILIO_ACCOUNT_SID, $this->TWILIO_AUTH_TOKEN,86400);
		$capability->allowClientOutgoing($this->TWILIO_TWIML_APP_SID);
		$capability->allowClientIncoming($identity);
		$token = $capability->generateToken();
		$data = json_encode($token);
		return $data;
	}
	public function test123()
	{
	    $data = [
	      'email' => $this->input->post('email'),  
	      'password' => md5($this->input->post('password'))
	    ];
	    
	    $user = $this->M_login->get_user_details($data);
	    print_r($user);
	    echo "ok";
	}
}
