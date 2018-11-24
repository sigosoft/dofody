<?php
        $firebase_id = $_POST['token'];
        $request = $_POST['request_id'];
        $message = $_POST['message'];
        $user = $_POST['user'];
        $time = $_POST['timestamp'];
        $date = $_POST['date'];
        $tim = $_POST['time'];
        $regId = $firebase_id;
        error_reporting(-1);
        ini_set('display_errors', 'On');

        require_once __DIR__ . '/firebase.php';
        require_once __DIR__ . '/push.php';

        $firebase = new Firebase();
        $push = new Push();

        $payload = array();
        $payload['request_id'] = $request;
        $payload['message'] = $message;
        $payload['user'] = $user;
        $payload['timestamp'] = $time;
        $payload['date'] = $date;
        $payload['time'] = $tim;
        $payload['status'] = 'chat';

        
        $title = $request;
        
    
        $push_type = isset($_GET['push_type']) ? $_GET['push_type'] : '';
        
        $include_image = isset($_GET['include_image']) ? TRUE : TRUE;


        $push->setTitle($request);
        $push->setMessage("message");
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