<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>Login</title>
  <meta name="Name here" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <meta content="#" name="description" />
  <meta content="Connectiya" name="author" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />

  <!-- App favicon -->
  <link rel="shortcut icon" href="assets/images/favicon.ico">

  <!-- App css -->
  <link href="<?=base_url()?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="<?=base_url()?>assets/css/icons.css" rel="stylesheet" type="text/css" />
  <link href="<?=base_url()?>assets/css/style.css" rel="stylesheet" type="text/css" />

  <script src="<?=base_url()?>assets/js/modernizr.min.js"></script>

    </head>


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
                                        <h6 class="text-uppercase text-center font-bold mt-4">Register</h6>
                                    </div>
                                    <div class="account-content scroll">
                                        <form class="form-horizontal" action="<?=site_url('patient_register/reg_patient')?>" method="post" autocomplete="off" id="register-form">

                                            <div class="form-group row m-b-20">
                                                <div class="col-12">
                                                    <input class="form-control" type="text" name="txt_name" required="" placeholder="Full name">
                                                </div>
                                            </div>

                                            <div class="form-group row m-b-20">
                                                <div class="col-12">
                                                    <input class="form-control" type="text" id="phone" name="txt_phone" required="" placeholder="Phone number" maxlength="10">
                                                </div>
                                            </div>
                                            <div class="form-group" id="ph_reg" style="color:red;display:none;"></div>
                                            <div class="form-group row m-b-20">
                                                <div class="col-12">
                                                    <input class="form-control" type="text" name="txt_city" required="" placeholder="City" id="user_input_autocomplete_address">
                                                </div>
                                            </div>
                                            <div class="form-group row m-b-20">
                                                <div class="col-12">
                                                    <input class="form-control" type="email" id="email" name="txt_email" required="" placeholder="Email address" autocomplete="nope">
                                                </div>
                                            </div>
                                            <div id="email_er" class="form-group has-feedback" style="color:red;display:none;"></div>
                                            <div class="form-group row m-b-20">
                                                <div class="col-12">
                                                    <input class="form-control" type="password" required="" id="password" name="txt_pass" placeholder="Enter your password">
                                                </div>
                                            </div>

                                            <div class="form-group row text-center m-t-10">
                                                <div class="col-12">
                                                    <button class="btn btn-block btn-gradient waves-effect waves-light" type="submit">Register</button>
                                                </div>
                                            </div>

                                        </form>

                                        <div class="row m-t-50">
                                            <div class="col-sm-12 text-center">
                                                <p class="text-muted">Already have an account?  <a href="<?=site_url('login')?>" class="text-dark m-l-5"><b>Login</b></a></p>
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

        <!-- App js -->
        <script src="<?=base_url()?>assets/js/jquery.core.js"></script>
        <script src="<?=base_url()?>assets/js/jquery.app.js"></script>
        
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&amp;key=AIzaSyBBT9bze33SU8Vwdr_iPrDJZYxpQpGHY2k"></script>
        <script type="text/javascript" src="<?=base_url().'assets/js/autocomplete.js'?>"></script>
        <script>
          $('#phone').on('blur',function(){
            var ph = $('#phone').val();
            var n = ph.length;
            msg = '';
            if (ph != '') {
              if (isNaN(ph) || n!=10) {
                msg = 'Invalid phone number';
                $("#ph_reg").css("display", "block");
                $("#ph_reg").text(msg);
              }
              else {
                $.ajax({
                  method: "POST",
                  url: "<?php echo site_url('patient_register/validate_phone');?>",
                  dataType : "text",
                  data : { ph : ph },
                  success : function( data ){
                      if ( data == '0' ) {
                        msg = 'Mobile number already registered';
                        $("#ph_reg").css("display", "block");
                        $("#ph_reg").text(msg);
                      }
                      else {
                        $("#ph_reg").css("display", "none");
                        $("#ph_reg").text('');
                      }
                    }
                  });
              }
            }
          });
          $('#email').on('blur',function(){
            var email = $('#email').val();
            if (email != '') {
              if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email))
              {
                $.ajax({
                  method: "POST",
                  url: "<?php echo site_url('patient_register/validate_email');?>",
                  dataType : "text",
                  data : { email : email },
                  success : function( data ){
                      if ( data == '0' ) {
                        msg = 'Email already registered';
                        $("#email_er").css("display", "block");
                        $("#email_er").text(msg);
                      }
                      else {
                        $("#email_er").css("display", "none");
                        $("#email_er").text('');
                      }
                    }
                  });
              }
              else {
                msg = 'You have entered an invalid email address!';
                $("#email_er").css("display", "block");
                $("#email_er").text(msg);
              }
            }
            else {
              $("#email_er").css("display", "none");
            }
          });
          $('#register-form').on('submit',function(){
            var ph_msg = $('#ph_reg').html();
            var email_msg = $('#email_er').html();
            if (ph_msg != '') {
              alert(ph_msg);
              return false;
            }
            if (email_msg != '') {
              alert(email_msg);
              return false;
            }
            $('#load').show();
            $('#submit_button').prop('disabled', true);
            return true;
          });
        </script>
    </body>
</html>
