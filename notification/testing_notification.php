<?php
        $firebase_id = $_POST['token'];
        $request = $_POST['request_id'];
        $regId = $firebase_id;
        // Enabling error reporting
        error_reporting(-1);
        ini_set('display_errors', 'On');

        require_once __DIR__ . '/firebase.php';
        require_once __DIR__ . '/push.php';

        $firebase = new Firebase();
        $push = new Push();

        // optional payload
        $payload = array();
        $payload['request_id'] = $request;
        $payload['status'] = 'video';

        // notification title
        //$title = isset($_GET['title']) ? $_GET['title'] : '';
        
        $title = $request;
        $message = 'message';
        
        // notification message
        //$message = isset($_GET['message']) ? $_GET['message'] : '';
        
        // push type - single user / topic
        $push_type = isset($_GET['push_type']) ? $_GET['push_type'] : '';
        
        // whether to include to image or not
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

        // switch ($id) {
        //     case '9847005200':
        //     //Wonderfull
        //     $keys_new = 'AAAA8aniIpg:APA91bFfc7dm1oG3BZPZ6AuTGQPLKEIdXldgwzFxLglCJQ9l1x7oOmirkZEV3PpBfLZ0FGLw6RcZTopt_wGYHupQhaqrcr3V3FkQc9UA_ZriUt_Tf6WBc_zWU0Gjn3oRthYbmv8w6HYz';
        //         echo "1";
        //         break;

        //         case '9447871585':
        //         //GrandHouse
        //     $keys_new = 'AAAAxBlYcf0:APA91bGM7DcggY3nguq9TeU0t_wQDvUn1iUWMeDYLu33UUDyduWhqRtvcHOKgE4xBGSRUe22vAc-rCg6u6DL6hxSKhoCiLonCq9Ev6HjtIg7JdHCcHPwRQfPMF1xEXAVAfOSxIiiBk2W';
        //         echo "1";
        //         break;

        //         case '04954015047':
        //         //CalicutSilks
        //     $keys_new = 'AAAADcI5Tjg:APA91bGN7jJlf0Z-UjZz39moJuKa_GX95Zz4fK5ljYk4YpjLJ8K-8bNQKF5MNyvoJc42qAfHkiAl5Zxv5l-ZzMDXhZJ1LZtt7y1xzp_7kxisZQh8NpNBUi5Lly_-CZmIptydjqb4tWsm';
        //         echo "1";
        //         break;

        //         case '9895926193':
        //         //Mehndi
        //     $keys_new = 'AAAA8sdLHGU:APA91bGx96ZkchWc0HtfDLqEg_lSY0I_S4Et2Hl7sv4U1prJV8qNkSgrTJmKfE-lQ-SHvFLfQ_cIuXYwIKCkgMRKQv9G_Kl5ZeRT0w1M7epSdY5oLsxCiV4QI1qMdKitJJTr9obZ5LpY';
        //         echo "1";
        //         break;

        //         case '04962663224':
        //         //CSCB
        //     $keys_new = 'AAAAvniIlGA:APA91bETGVVAEFLf9MK4-Afh39NTDUIi9_0wUCE5UE-Tg6pf4KxPa9VSHvzz5ptoUlo529ELz1SPbE1j8vCC9buDnprBKLM6BUmOmzvjxMLEwHHaxWJ5b98Od5K_KJvm_JEE5ju7dfU7';
        //         echo "1";
        //         break;
            
        //     default:
        //         echo "0";
        //         break;
        // }
        
        // $json = $push->getPush();
        // $response = $firebase->sendToTopic('global', $json,$keys_new);

        $json = $push->getPush();
            //$regId = isset($_GET['regId']) ? $_GET['regId'] : '';
            $response = $firebase->send($regId, $json);
        

        /*if ($push_type == 'topic') {
            $json = $push->getPush();
            $response = $firebase->sendToTopic('global', $json);
        } else if ($push_type == 'individual') {
            
            $json = $push->getPush();
            $regId = isset($_GET['regId']) ? $_GET['regId'] : '';
            $response = $firebase->send($regId, $json);
        }*/
?>