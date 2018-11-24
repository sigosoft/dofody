<?php
        $firebase_id = $_POST['token'];
        $message = $_POST['message'];
        $regId = $firebase_id;
        error_reporting(-1);
        ini_set('display_errors', 'On');

        require_once __DIR__ . '/firebase.php';
        require_once __DIR__ . '/push.php';

        $firebase = new Firebase();
        $push = new Push();

        $payload = array();
        $payload['message'] = "Request";
        $payload['status'] = 'notification';
        
    
        $push_type = isset($_GET['push_type']) ? $_GET['push_type'] : '';
        
        $include_image = isset($_GET['include_image']) ? TRUE : TRUE;


        $push->setTitle("NEW REQUEST");
        $push->setMessage($message);
        if ($include_image) {
            $push->setImage('http://api.androidhive.info/images/minion.jpg');
        } else {
            $push->setImage('');
        }
        $push->setIsBackground(FALSE);
        $push->setPayload($payload);


        $json = '';
        $response = '';

        $json = $push->getPush();
        $response = $firebase->send($regId, $json);
?>