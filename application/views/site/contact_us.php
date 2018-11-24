<!doctype html>
<html class="no-js" lang="en">
<head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Dofody || Home</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Favicon Icon -->
        <link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>site/img/favicon.png">

		<!-- Google Fonts -->
		<link href="https://fonts.googleapis.com/css?family=Poppins:400,600" rel="stylesheet">

		<!-- all css here -->
        <link rel="stylesheet" href="<?=base_url()?>site/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
        <link rel="stylesheet" href="<?=base_url()?>site/css/animate.css">
        <link rel="stylesheet" href="<?=base_url()?>site/css/owl.carousel.css">
        <link rel="stylesheet" href="<?=base_url()?>site/css/slick.css">
        <link rel="stylesheet" href="<?=base_url()?>site/css/meanmenu.min.css">
        <link rel="stylesheet" href="<?=base_url()?>site/style.css">
        <link rel="stylesheet" href="<?=base_url()?>site/css/responsive.css">
        <script src="<?=base_url()?>site/js/vendor/modernizr-2.8.3.min.js"></script>
        <script src='https://www.google.com/recaptcha/api.js'></script>
    </head>
    <body>
        <?php $message = $this->session->flashdata('message'); ?>
        <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    	<!-- Header Area Start -->
		<?php include('nav.php');?>
		<!-- Header Area End -->

		<!-- breadcrumbs end -->
    <section class="breadcrumbs-area pt-200 pb-140 bg-1 bg-blue fix">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="breadcrumbs">
                            <h2 class="page-title">CONTACT US</h2>
                            <ul>
                                <li>
                                    <a class="active" href="#">Home</a>
                                </li>
                                <li>CONTACT US</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
		<!-- breadcrumbs end -->
		<div id="contact" class="contact-area bg-light pt-50">
            <div class="container">
                <div class="section-title text-center">
                    <h2>get in touch</h2>
                    <p>Call or E-mail us for any enquiries</p>
                </div>
                <div class="row">
                    <div class="col-md-offset-2 col-md-8 text-center">
                        <div class="contact-from">
                            <form action="<?=site_url('contact_us/verify')?>" method="post" onsubmit="return check()">
                                <input name="name" type="text" placeholder="Full name" required>
                                <input name="email" id="email" type="email" placeholder="Email address" required>
                                <div id="email-msg" style="display:none;text-align:left !important;color:red;padding-bottom:10px;"></div>
                                <input name="mobile" id="mobile" type="text" placeholder="Mobile number" required>
                                <div id="phone-msg" style="display:none;text-align:left !important;color:red;padding-bottom:10px;"></div>
                                <input name="subject" type="text" placeholder="Subject" required>
                                <textarea name="message" rows="5" placeholder="Your message" required></textarea>
                                <div class="g-recaptcha" data-sitekey="6LfmNmgUAAAAACHN0ntyh98naaaT3QLhrpvnTdt3"></div>
                                <input class="submit" type="submit" value="SUBMIT">
                            </form>
                            <p class="form-messege" style="padding-top:10px;color:green;"><?php if(isset($message)){ echo $message; }?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<?php include('footer.php');?>
        <div class="footer-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="footer-text">
                            <span class="block">Copyright&copy; 2018 <a href="#">dofody</a>. All rights reserved.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <script src="<?=base_url()?>site/js/vendor/jquery-1.12.4.min.js"></script>
        <script src="<?=base_url()?>site/js/bootstrap.min.js"></script>
        <script src="<?=base_url()?>site/js/jquery.nav.js"></script>
        <script src="<?=base_url()?>site/js/slick.min.js"></script>
        <script src="<?=base_url()?>site/js/owl.carousel.min.js"></script>
        <script src="<?=base_url()?>site/js/ajax-mail.js"></script>
        <script src="<?=base_url()?>site/js/jquery.ajaxchimp.min.js"></script>
        <script src="<?=base_url()?>site/js/wow.min.js"></script>
        <script src="<?=base_url()?>site/js/counterup.js"></script>
        <script src="<?=base_url()?>site/js/jquery.meanmenu.js"></script>
        <script src="<?=base_url()?>site/js/plugins.js"></script>
        <script src="<?=base_url()?>site/js/main.js"></script>
        <script>
            function check()
            {
                var email = $('#email').val();
                if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email))
                {
                    $("#email-msg").css("display", "none");
                    var mobile = $('#mobile').val();
                    var len = mobile.length;
                    if (len != 10 && len !='') {
                      $("#phone-msg").css("display", "block");
                      $("#phone-msg").text('Invalid mobile number');
                      return false;
                    }
                    if (len == 10) {
                      if (isNaN(phone)) {
                        $("#phone-msg").css("display", "block");
                        $("#phone-msg").text('Must be number');
                        return false;
                      }
                      else {
                        $("#phone-msg").css("display", "none");
                        return true;
                      }
                    }
                }
                else {
                  $("#email-msg").css("display", "block");
                  $("#email-msg").text('Invalid Email address');
                  return false;
               }
            }
        </script>
    </body>
</html>
