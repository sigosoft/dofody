<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8" />
        <title>Dofody</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta content="#" name="description" />
        <meta content="Sigosoft" name="author" />
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
        <section class="dp">
            <div class="container">
                <div class="row">
                    <div class="col-sm-4 offset-2">
						<img src="<?=base_url()?>assets/images/d.png" class="img-fluid">
						<a href="<?=site_url('doctor-login')?>"><button type="button" class="btn btn-light btn-rounded waves-effect w-md"> Doctor Login </button></a>
					</div>
					<div class="col-sm-4">
						<img src="<?=base_url()?>assets/images/p.png" class="img-fluid">
						<a href="<?=site_url('login')?>"><button type="button" class="btn btn-light btn-rounded waves-effect w-md"> User Login </button></a>
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
