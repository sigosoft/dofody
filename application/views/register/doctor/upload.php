<!DOCTYPE html>
<html>
<head>
  <?php $data = $this->session->userdata('data');
    $identity = $this->session->userdata('identity');
    $graduation = $this->session->userdata('graduation');
    $registration = $this->session->userdata('registration');
    $bank_details = $this->session->userdata('bank_details');
    $signature = $this->session->userdata('signature');
    $status = 0;
    if (isset($identity) && isset($graduation) && isset($registration) && isset($bank_details) && isset($signature)) {
      $status = 1;
    }
  ?>
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
  <style>
    .color-grey{
      color:#666;
    }
  </style>
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
                                        <h6 class="text-uppercase text-center font-bold mt-4">Upload your documents</h6>
                                    </div>
                                    <div class="account-content scroll">
                                      <div class="form-group row m-b-20">
                                          <div class="col-12">
                                            <i style="font-size:30px;padding-right:10px; <?php if(isset($identity)){ ?>color:#3c8dbc;<?php } ?>" class="fa fa-check-circle-o"></i>
                                            <span class="text-uppercase font-bold mt-4" style="font-size:20px;"><a class="color-grey" href="<?php echo site_url('register-doctor/identity-upload');?>">Photo identity</a></span>
                                          </div>
                                      </div>
                                      <div class="form-group row m-b-20">
                                          <div class="col-12">
                                            <i style="font-size:30px;padding-right:10px;<?php if(isset($graduation)){ ?>color:#3c8dbc;<?php } ?>" class="fa fa-check-circle-o"></i>
                                          <span class="text-uppercase font-bold mt-4" style="font-size:20px;"><a class="color-grey" href="<?php echo site_url('register-doctor/degree-certificate');?>">Degree certificate</a></span>
                                          </div>
                                      </div>
                                      <div class="form-group row m-b-20">
                                          <div class="col-12">
                                            <i style="font-size:30px;padding-right:10px;<?php if(isset($registration)){ ?>color:#3c8dbc;<?php } ?>" class="fa fa-check-circle-o"></i>
                                          <span class="text-uppercase font-bold mt-4" style="font-size:20px;"><a class="color-grey" href="<?php echo site_url('register-doctor/registration-certificate');?>">Registration certificate</a></span>
                                          </div>
                                      </div>
                                      <div class="form-group row m-b-20">
                                          <div class="col-12">
                                            <i style="font-size:30px;padding-right:10px;<?php if(isset($bank_details)){ ?>color:#3c8dbc;<?php } ?>" class="fa fa-check-circle-o"></i>
                                          <span class="text-uppercase font-bold mt-4" style="font-size:20px;"><a class="color-grey" href="<?php echo site_url('register-doctor/bank-details');?>">Bank account</a></span>
                                          </div>
                                      </div>
                                      <div class="form-group row m-b-20">
                                          <div class="col-12">
                                            <i style="font-size:30px;padding-right:10px;<?php if(isset($signature)){ ?>color:#3c8dbc;<?php } ?>" class="fa fa-check-circle-o"></i>
                                          <span class="text-uppercase font-bold mt-4" style="font-size:20px;"><a class="color-grey" href="<?php echo site_url('register-doctor/signature');?>">Signature</a></span>
                                          </div>
                                      </div>
                                      <div class="form-group row text-center m-t-10">
                                          <div class="col-12">
                                              <button type="submit" class="btn btn-block btn-gradient waves-effect waves-light" <?php if ($status == 0): ?>disabled<?php endif; ?> onclick="window.location='<?php echo site_url("register_doctor/register_user");?>'">SUBMIT</button>
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
