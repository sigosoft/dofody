<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Contact_us extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->helper('url');
			$this->load->library('session');
	}
	public function index()
	{
		$this->load->view('site/contact_us');
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
	public function post_captcha($user_response) {
        $fields_string = '';
        $fields = array(
            'secret' => '6LfmNmgUAAAAAFJJ_y9bS26H3sN4_OB4614Ut82P',
            'response' => $user_response
        );
        foreach($fields as $key=>$value)
        $fields_string .= $key . '=' . $value . '&';
        $fields_string = rtrim($fields_string, '&');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);

        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result, true);
    }
    public function test()
    {
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'xxx',
            'smtp_pass' => 'xxx',
            'mailtype'  => 'html', 
            'charset'   => 'iso-8859-1'
        );
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('aithinep@gmail.com', 'Your Name');
        $this->email->to('info@dofody.com');
        $this->email->subject('Email Test');
        $this->email->message('Testing the email class.');
        
        $result = $this->email->send();
        var_dump($result);
    }
    public function test1()
    {
        $to = "info@dofody.com" ;
        $subject = "This is testing";
        $email = "aithinep@gmail.com" ;
        $message = "test message" ;
        $header = "From: info@dofody.com\r\n"; 
        $header.= "MIME-Version: 1.0\r\n"; 
        $header.= "Content-Type: text/plain; charset=iso-8859-1\r\n"; 
        $header.= "X-Priority: 1\r\n";
        $header.= "X-Mailer: PHP/" . phpversion();
        $sent = mail($to, $subject, $message,$header);
        if($sent)
        {
            echo "ok";
        }
        else
        {
            echo "failed";
        }
    }
    public function test2()
    {
        
        ini_set('SMTP','smtp.zoho.com');
        ini_set('smtp_port',465);
        ini_set('sendmail_from', 'admin@dofody.com');
        
        //define the receiver of the email
        $to = 'info@dofody.com';
        //define the subject of the email
        $subject = 'Test for title'; 
        //define the message to be sent. Each line should be separated with \n
        $message = 'Message to send'; 
        
        //define the headers we want passed. Note that they are separated with \r\n
        $headers = 'From: admin@dofody.com\r\nReply-To: admin@dofody.com';
        
        //send the email
        $mail_sent = mail($to, $subject, $message, $headers);
        mail($to, $subject, $message, $headers);
        
        //if the message is sent successfully print "Mail sent correctly". Otherwise print "Mail failed" 
        echo $mail_sent ? "Mail sent" : "Mail failed";
    }
    function test4()
    {
        $to      = 'info@dofody.com';
        $subject = 'the subject';
        $message = 'hello';
        $headers = 'From: info@dofody.com' . "\r\n" .
            'Reply-To: info@dofody.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
        
        mail($to, $subject, $message, $headers);

    }
}

?>
