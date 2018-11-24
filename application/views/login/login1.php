<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8" />
        <title>Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
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
                                                    <label for="emailaddress">Email address</label>
                                                    <input class="form-control" type="text" name="email" required="" placeholder="Enter your username">
                                                </div>
                                            </div>

                                            <div class="form-group row m-b-20">
                                                <div class="col-12">
                                                    <a href="page-recoverpw.html" class="text-muted pull-right"><small>Forgot your password?</small></a>
                                                    <label for="password">Password</label>
                                                    <input class="form-control" type="password" required="" name="password" placeholder="Enter your password">
                                                </div>
                                            </div>

                                            <div class="form-group row m-b-20 text-center">
                                                <div class="col-12">
                                                  <label for="password" style="color:red;"><?php if (isset($message)){ echo $message; } ?></label>
                                                </div>
                                            </div>

                                            <div class="form-group row text-center m-t-10">
                                                <div class="col-12">
                                                    <button class="btn btn-block btn-gradient waves-effect waves-light" type="submit">Sign In</button>
                                                </div>
                                            </div>

                                        </form>

                                        <div class="row m-t-50">
                                            <div class="col-sm-12 text-center">
                                                <p class="text-muted">Don't have an account? <a href="<?=site_url('patient-register')?>" class="text-dark m-l-5"><b>Sign Up</b></a></p>
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

    </body>
</html>
