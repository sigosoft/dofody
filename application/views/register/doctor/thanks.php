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
                                        <h6 class="text-uppercase text-center font-bold mt-4" style="font-size:20px;">Thank you</h6>
                                    </div>
                                    <div class="account-content">
                                            <div class="form-group row text-center m-t-10">
                                                <div class="col-12">
                                                    <p style="font-size:17px;">Thank you for uploading your documents . You will be notified after successful verification process shortly.</p>
                                                </div>
                                            </div>
                                            <div class="form-group row text-center m-t-10">
                                                <div class="col-12">
                                                    <a href="<?=site_url('dofody')?>"><p style="font-size:14px;">Back to site</p></a>
                                                </div>
                                            </div>
                                            <div class="form-group row text-center m-t-10">
                                                <div class="col-12">

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
        </script>
    </body>
</html>
