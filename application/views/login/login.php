<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8" />
        <title>Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta content="#" name="description" />
        <meta content="Sigosoft" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <link rel="manifest" href="<?=base_url()?>manifest.json">
        <!-- App favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>site/img/favicon.png">

        <!-- App css -->
        <link href="<?=base_url()?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url()?>assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url()?>assets/css/style.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url()?>plugins/sweet-alert/sweetalert.css" rel="stylesheet" type="text/css" />
        <script src="<?=base_url()?>assets/js/modernizr.min.js"></script>
        <script src="<?=base_url()?>assets/js/firebase/firebase-app.js"></script>
        <script src="<?=base_url()?>assets/js/firebase/firebase-messaging.js"></script>
    </head>
    <?php $message = $this->session->flashdata('message'); ?>

    <body class="bg-accpunt-pages">

        <!-- HOME -->
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">

                        <div class="wrapper-page">

                            <div class="account-pages">
                                <div class="account-box">
                                    <div class="account-logo-box">
                                        <h2 class="text-uppercase text-center">
                                            <a href="index-2.html" class="text-success">
                                                <span><img src="<?=base_url()?>assets/images/logo-blue.png" alt="" height="40"></span>
                                            </a>
                                        </h2>
                                        <h6 class="text-uppercase text-center font-bold mt-4">user login</h6>
                                    </div>
                                    <div class="account-content">
                                        <form class="form-horizontal" method="post" action="<?=site_url('login/check')?>">

                                            <div class="form-group m-b-20 row">
                                                <div class="col-12">
                                                    <label for="emailaddress">Email / Mobile number</label>
                                                    <input class="form-control" type="text" name="email" required="" placeholder="Email/Mobile number">
                                                </div>
                                            </div>

                                            <div class="form-group row m-b-20">
                                                <div class="col-12">
                                                    <a href="<?=site_url('register-patient/change-password')?>" class="text-muted pull-right"><small>Forgot your password?</small></a>
                                                    <label for="password">Password</label>
                                                    <input class="form-control" type="password" required="" name="password" placeholder="Enter your password">
                                                </div>
                                            </div>
                                            <textarea id="token" class="form-control" style="display:none" name="token"></textarea>
                                            <?php if(isset($message)){ ?>
                                            <div class="form-group row m-b-20 text-center">
                                                <div class="col-12">
                                                  <label for="password" style="color:red;"><?php if (isset($message)){ echo $message; } ?></label>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <div class="form-group row text-center m-t-10">
                                                <div class="col-12">
                                                    <button class="btn btn-block btn-gradient waves-effect waves-light" type="submit">Sign In</button>
                                                </div>
                                            </div>
                                            
                                        </form>

                                        <div class="row m-t-50">
                                            <div class="col-sm-12 text-center">
                                                <p class="text-muted">Don't have an account? <a href="<?=site_url('patient-register')?>" class="text-dark m-l-5"><b>Register</b></a></p>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- end card-box-->


                        </div>
                        <!-- end wrapper -->

                    </div>
                </div>
            </div>
        </section>
        <!-- END HOME -->


        <!-- jQuery  -->
        <script src="<?=base_url()?>assets/js/jquery.min.js"></script>
        <script src="<?=base_url()?>assets/js/popper.min.js"></script>
        <script src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
        <script src="<?=base_url()?>assets/js/waves.js"></script>
        <script src="<?=base_url()?>assets/js/jquery.slimscroll.js"></script>
        <script src="<?=base_url()?>plugins/sweet-alert/sweetalert.js"></script>

        <!-- App js -->
        <script src="<?=base_url()?>assets/js/jquery.core.js"></script>
        <script src="<?=base_url()?>assets/js/jquery.app.js"></script>
        <script>
      var config = {
        apiKey: "AIzaSyC4kyORLuill-AJ7C0cIpaGYBJhLsCFTA4",
        authDomain: "dofodys.firebaseapp.com",
        databaseURL: "https://dofodys.firebaseio.com",
        projectId: "dofodys",
        storageBucket: "dofodys.appspot.com",
        messagingSenderId: "388763301424"
      };
      firebase.initializeApp(config);

      const messaging = firebase.messaging();

      messaging.usePublicVapidKey("BN3YeNZzqowr4zQy3ExvFS62-dSdAPMmSMuCvlcPwBVbZLbmzJ-Z-pmoM27AvZXYWf874inbqCxW_AACNVXnRmk");

      messaging.requestPermission().then(function() {
        console.log('Notification permission granted.');
        getRegToken();
      }).catch(function(err) {
        console.log('Unable to get permission to notify.', err);
        swal("Please allow notification to get calls from doctors");
        permission();
      });

      function getRegToken(argument)
      {
        messaging.getToken().then(function(currentToken) {
        if (currentToken) {
          $('#token').val(currentToken);
        } else {
          console.log('No Instance ID token available. Request permission to generate one.');
          setTokenSentToServer(false);
        }
        }).catch(function(err) {
          console.log('An error occurred while retrieving token. ', err);
          //showToken('Error retrieving Instance ID token. ', err);
          //setTokenSentToServer(false);
        });
      }

      function isTokenSentToServer() {
        return window.localStorage.getItem('sentToServer') === '1';
      }

      function setTokenSentToServer(sent) {
        window.localStorage.setItem('sentToServer', sent ? '1' : '0');
      }
      function permission()
      {
         messaging.requestPermission(); 
      }
    </script>
    </body>
</html>
