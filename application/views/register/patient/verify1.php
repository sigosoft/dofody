<!DOCTYPE html>
<html>
<head>
  <?php $user_data = $this->session->userdata('data'); print_r($user_data); ?>
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
                                        <h6 class="text-uppercase text-center font-bold mt-4">Verify phone number</h6>
                                    </div>
                                    <div class="account-content scroll">
                                        <form class="form-horizontal" action="<?=site_url('patient_register/register_patient')?>" method="post" id="register-form">

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
                                                <button class="btn btn-block btn-gradient waves-effect waves-light" type="button">Change number</button>
                                            </div>
                                        </div>
                                        <!--<div class="row m-t-50">
                                            <div class="col-sm-12 text-center">
                                                <p class="text-muted">Already have an account?  <a href="<?=site_url('login')?>" class="text-dark m-l-5"><b>Sign In</b></a></p>
                                            </div>-->
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
        </script>
    </body>
</html>
