<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Refund extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->helper('url');
			$this->load->library('session');
			$this->load->model('Common');
	}
	public function sendRefundRequest()
	{
		$type = $this->input->post('type');
		$array = [
			'reason' => $this->input->post('reason'),
			'amount' => $this->input->post('amount'),
			'user_id' => $this->input->post('user_id'),
			'request_date' => $this->input->post('date'),
			'type' => $type
		];
		if ($type != 'quick') {
			$array['doctor_name'] = $this->input->post('doctor_name');
		}
		$this->Common->insert('refund',$array);
		$return = [
		  'message' => 'success'  
		];
		print_r(json_encode($return));
	}
	public function verify()
	{
	    $res = $this->post_captcha($_POST['g-recaptcha-response']);
	    if($res['success']){

	        $to = 'info@dofody.com';
            $subject = $_POST['subject'];;
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['mobile'];;
            $message = $_POST['message'];;

            $url = 'https://api.elasticemail.com/v2/email/send';

            try{
                    $post = array('from' => $email,
            		'fromName' => $name,
            		'apikey' => 'ee2ca87b-8458-4e88-8943-a9edf55ad92f',
            		'subject' => $subject,
            		'to' => $to,
            		'bodyHtml' => '
            		<h4>'.$message.'</h4></br>
            		<h5>From: '.$name.'</h5>
            		<h5>Phone: '.$phone.'</h5>
            		',
            		'bodyText' => 'Text Body',
            		'isTransactional' => false);

            		$ch = curl_init();
            		curl_setopt_array($ch, array(
                        CURLOPT_URL => $url,
            			CURLOPT_POST => true,
            			CURLOPT_POSTFIELDS => $post,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_HEADER => false,
            			CURLOPT_SSL_VERIFYPEER => true
                    ));

                    $result=curl_exec ($ch);
                    curl_close ($ch);

                    //echo $result;
                    $this->session->set_flashdata('message', 'Thank you, your message has been sent successfully');
				    redirect('contact-us');
            }
            catch(Exception $ex){
            	echo $ex->getMessage();
            }
	    }
	    else
	    {
	        echo 'Captcha ignored';
	    }
	}
	function sendMail()
	{

	}

}

?>
