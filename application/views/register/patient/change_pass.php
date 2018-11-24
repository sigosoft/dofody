<!DOCTYPE html>
<html>
<head>
  <?php $user_data = $this->session->userdata('data'); ?>
  <meta charset="utf-8" />
  <title>Dofody</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <meta content="#" name="description" />
  <meta content="Sigosoft" name="author" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />

  <!-- App favicon -->
  <link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>assets/images/logo_sm.png">

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
                                            <a href="<?=site_url('dofody')?>" class="text-success">
                                                <span><img src="<?=base_url()?>assets/images/logo-blue.png" alt="" height="40"></span>
                                            </a>
                                        </h2>
                                        <h6 class="text-uppercase text-center font-bold mt-4" style="font-size:20px;">Change your password</h6>
                                    </div>
                                    <div class="account-content">
                                            <div class="form-group row text-center m-t-10">
                                                <div class="col-12">
                                                    <p style="font-size:17px;">Choose a strong password and dont't reuse it for other accounts.</p>
                                                </div>
                                            </div>
                                            <div class="form-group row m-b-20">
                                                <div class="col-12">
                                                  <label>Mobile number</label>
                                                    <input class="form-control" type="text" id="phone" name="txt_phone" required="" placeholder="Enter your registered mobile number" maxlength="10">
                                                </div>
                                            </div>
                                            <p id="ph_err" style="color:red;"></p>
                                            <div class="form-group row text-center m-t-10" id="mobile-submit">
                                                <div class="col-12">
                                                    <button class="btn btn-block btn-gradient waves-effect waves-light" type="button" id="phone_check">Get OTP</button>
                                                </div>
                                            </div>
                                            <div id="otp-div" style="display:none;">
                                              <div class="form-group row m-b-20">
                                                  <div class="col-12">
                                                      <input class="form-control" type="text" id="otp" required="" placeholder="Enter OTP" maxlength="10">
                                                  </div>
                                              </div>
                                              <p id="otp_err" style="color:red;"></p>
                                              <div class="form-group row text-center m-t-10">
                                                  <div class="col-12">
                                                      <button class="btn btn-block btn-gradient waves-effect waves-light" type="button" id="otp_check">Submit</button>
                                                  </div>
                                              </div>
                                            </div>
                                            <div id="change-pass" style="display:none;">
                                              <form action="<?=site_url('patient_register/forgot_password_change')?>" method="post" onsubmit="return check_pass();">

                                                <div class="form-group row m-b-20">
                                                    <div class="col-12">
                                                        <input class="form-control" type="text" id="pass1" name="password" required="" placeholder="Enter password" maxlength="10">
                                                    </div>
                                                </div>
                                                <input type="hidden" name="mobile" id="mobileNumber">
                                                <div class="form-group row m-b-20">
                                                    <div class="col-12">
                                                        <input class="form-control" type="text" id="pass2" required="" placeholder="Confirm password" maxlength="10">
                                                    </div>
                                                </div>
                                                <p id="pass_err" style="color:red;"></p>
                                                <div class="form-group row text-center m-t-10">
                                                    <div class="col-12">
                                                        <button class="btn btn-block btn-gradient waves-effect waves-light" type="submit">Submit</button>
                                                    </div>
                                                </div>

                                              </form>
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
        <script>
        var otp;
        $("#phone_check").on('click',function(){
          var mobile = $('#phone').val();
          var len = mobile.length;
          if (mobile == '') {
            $('#ph_err').text('Invalid Mobile number');
          }
          else {
            if (len != 10) {
              $('#ph_err').text('Invalid Mobile number');
            }
            else {
              if (isNaN(mobile)) {
                $('#ph_err').text('Invalid Mobile number');
              }
              else {
                $.ajax({
                  method: "POST",
                  url: "<?php echo site_url('patient_register/forgot_the_password');?>",
                  dataType : "text",
                  data : { mobile : mobile },
                  success : function( data ){
                    if (data == '1') {
                      $('#ph_err').text('Mobile number not registered..!');
                    }
                    else if (data == '2') {
                      $('#ph_err').text('We are experiencing some problem , Please try agian later.');
                    }
                    else {
                      $('#phone').attr('readonly', true);
                      $('#mobile-submit').css('display','none');
                      $('#otp-div').css('display','block');
                      $('#mobileNumber').val(mobile);
                      otp = data;
                    }
                    }
                  });
                }
            }
          }
        });
        $('#otp_check').on('click',function(){
          var user_otp = $('#otp').val();
          if (user_otp == otp) {
            $('#otp-div').css('display','none');
            $('#change-pass').css('display','block');
          }
          else {
            $('#otp_err').text('Invalid or expired OTP');
          }
        });
        function check_pass()
        {
          var pass1 = $('#pass1').val();
          var pass2 = $('#pass2').val();
          if (pass1 == pass2) {
            return true;
          }
          else {
            $('#pass_err').text('Password mismatch');
            return false;
          }
        }
        </script>
    </body>
</html>
