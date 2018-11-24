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
                                            <a href="index-2.html" class="text-success">
                                                <span><img src="<?=base_url()?>assets/images/logo-blue.png" alt="" height="40"></span>
                                            </a>
                                        </h2>
                                        <h6 class="text-uppercase text-center font-bold mt-4">Verify phone number</h6>
                                    </div>
                                    <div class="account-content">
                                        <form action="<?php echo site_url('register_doctor/verify_otp'); ?>" method="post" id="register-form">

                                            <div class="form-group row m-b-20">
                                                <div class="col-12">
                                                  <label>Enter your OTP</label>
                                                    <input class="form-control" type="text" name="otp" id="otp" required placeholder="OTP">
                                                </div>
                                            </div>
                                            <div id="wrong_otp" style="color:red; display:none; text-align:center; margin-bottom:10px;" >
                                              Wrong or expired OTP. Please re-enter.
                                            </div>

                                            <div class="form-group row text-center m-t-10">
                                                <div class="col-12">
                                                    <button class="btn btn-block btn-gradient waves-effect waves-light" type="submit">Submit</button>
                                                </div>
                                            </div>

                                        </form>

                                        <div class="form-group row text-center m-t-10">
                                            <div class="col-12">
                                                <button class="btn btn-block btn-gradient waves-effect waves-light" type="button">Resend OTP</button>
                                            </div>
                                        </div>
                                        <div class="form-group row text-center m-t-10">
                                            <div class="col-12">
                                                <button class="btn btn-block btn-gradient waves-effect waves-light" type="button" data-toggle="modal" data-target="#change-phone-number">Change number</button>
                                            </div>
                                        </div>
                                        <div class="row m-t-50">
                                            <div class="col-sm-12 text-center">
                                                <p class="text-muted">Already have an account?  <a href="<?=site_url('doctor-login')?>" class="text-dark m-l-5"><b>Sign In</b></a></p>
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
        <div class="modal fade" id="change-phone-number" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <h4 class="modal-title" id="myModalLabel">Record</h4>
            </div>
            <div class="modal-body">
              <form action="<?php echo site_url('register_doctor/change_phone'); ?>" method="post" id="form-change-phone">
                <div class="form-group row m-b-20">
                    <div class="col-12">
                      <label>Enter your mobile number</label>
                        <input class="form-control" type="text" name="ph" id="ph" required placeholder="Mobile number" maxlength="10">
                    </div>
                </div>
                <div id="ph_reg" class="text-center" style="color:red;display:none;margin-bottom:5px;"></div>
                <div class="form-group row text-center m-t-10">
                    <div class="col-12">
                        <button class="btn btn-block btn-gradient waves-effect waves-light" type="submit">Change number</button>
                    </div>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
        </div>
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
          $('#register-form').on('submit',function(){
            var otp = $('#otp').val();
            if ( otp == '<?=$user_data['otp']?>') {
              $("#wrong_otp").css("display", "none");
              return true;
            }
            else {
              $("#wrong_otp").css("display", "block");
              return false;
            }
            return false;
          });
          function resend_otp()
          {
            $.ajax({
              method: "POST",
              url: "<?php echo site_url('register/resend_otp');?>",
              dataType : "text",
              success : function( data ){
                    var obj = JSON.parse( data );
                    var msg = "New OTP has been sent to "+obj['phone'];
                    $("#otp_send").text(msg);
                    $("#otp_send").css("display", "block");
                    $("#otp_s").val( obj['otp'] );
                  }
                });
          }
          $('#form-change-phone').on('submit',function(){
            var ph = $('#ph').val();
            var n = ph.length;
            msg = '';
            if (ph != '') {
              if (isNaN(ph) || n!=10) {
                msg = 'Invalid phone number';
                $("#ph_reg").css("display", "block");
                $("#ph_reg").text(msg);
                return false;
              }
              else {
                var a = function(callback)
                {
                    $.ajax({
                      method: "POST",
                      url: "<?php echo site_url('patient_register/validate_phone');?>",
                      async : false,
                      dataType : "text",
                      data : { ph : ph },
                      success: callback
                        });
                };
                var ret = a(function(data) {
                  if ( data == '0' ) {
                    msg = 'Mobile number already registered';
                    $("#ph_reg").css("display", "block");
                    $("#ph_reg").text(msg);
                    return false;
                  }
                  else {
                    $("#ph_reg").css("display", "none");
                    $("#ph_reg").text('');
                    return true;
                  }
                });
                return false;

              }
            }
          });
        </script>
    </body>
</html>
