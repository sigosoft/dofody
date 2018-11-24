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
    </head>
    <body>
        <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    	<!-- Header Area Start -->
		<header class="header-area fixed">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-2 col-sm-4 col-xs-6">
                        <div class="logo">
                            <a href="<?=site_url('dofody')?>"><img src="<?=base_url()?>site/img/logo.png" alt="Dofody" width="150"></a>
                        </div>
                    </div>
                    <div class="col-md-10 hidden-sm hidden-xs">
                        <div class="main-menu text-center">
                            <nav class="pull-right">
                                <ul>
                                    <!--<li class="active"><a href="<?=site_url('dofody')?>">Home</a></li>-->
                                    <li><a href="#">Consult now</a></li>
                                    <li><a href="#">Ask a Doctor</a></li>
                                    <!--<li><a href="<?=site_url('contact_us')?>">Contact us</a></li>-->
                                    <li><a href="#">Login</a></li>
                                    <li><a href="#"><img src="<?=base_url()?>site/img/play-store.png" width="100"></a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="col-md-12">
                       <div class="mobile-menu  hidden-lg hidden-md">
                            <nav>
                                <ul>
                                    <!--<li class="active"><a href="<?=site_url('dofody')?>">Home</a></li>-->
                                    <li><a href="#">Consult now</a></li>
                                    <li><a href="#">Ask a Doctor</a></li>
                                    <!--<li><a href="<?=site_url('contact_us')?>">Contact us</a></li>-->
                                    <li><a href="#">Login</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
		</header>
		<!-- Header Area End -->
		<!-- Banner Area Start -->
		<div id="banner" class="banner-area bg-blue bg-1 fix">
		    <div class="container-fluid">
                <div class="banner-image-wrapper">
                    <div class="banner-image">
                        <div class="banner-image-cell">
                            <img src="<?=base_url()?>site/img/banner/2.png" alt="">
                        </div>
                    </div>
                </div>
                <div class="banner-text">
                    <div class="text-content-wrapper">
                        <div class="text-content">
                            <h1 class="title1">Welcome to Dofody!</h1>
                            <p>Use your phone or computer and connect face to face with a Doctor, anytime, anywhere! It works just like a normal consultation, where your Doctor takes the history, may perform examinations, order investigations and prescribe.</p>
                            <div class="banner-button">
                                <a class="default-btn button" href="<?=site_url('dofody/select')?>">Consult now</a>
                                <a class="default-btn button" href="<?=site_url('login')?>">Ask a Doctor</a>
                            </div>
                        </div>
                    </div>
                </div>
		    </div>
		</div>
		<!-- Banner Area End -->
		<!-- feature Area Start -->
	<!-- 	<div id="feature" class="service-area bg-2">
		    <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="single-service-container">
                            <div class="single-service-item">
                                <div class="service-icon">
                                    <div class="service-icon-cell">
                                        <img src="img/icon/voip.png" alt="">
                                    </div>
                                </div>
                                <div class="service-text">
                                    <span>Business</span>
                                    <span>VOIP</span>
                                </div>
                            </div>
                            <div class="single-service-item">
                                <div class="service-icon">
                                    <div class="service-icon-cell">
                                        <img src="img/icon/pbx.png" alt="">
                                    </div>
                                </div>
                                <div class="service-text">
                                    <span>Hosted</span>
                                    <span>PBX</span>
                                </div>
                            </div>
                            <div class="single-service-item">
                                <div class="service-icon">
                                    <div class="service-icon-cell">
                                        <img src="img/icon/sip.png" alt="">
                                    </div>
                                </div>
                                <div class="service-text">
                                    <span>Traking</span>
                                    <span>SIP</span>
                                </div>
                            </div>
                            <div class="single-service-item">
                                <div class="service-icon">
                                    <div class="service-icon-cell">
                                        <img src="img/icon/clock.png" alt="">
                                    </div>
                                </div>
                                <div class="service-text">
                                    <span>Call</span>
                                    <span>Center</span>
                                </div>
                            </div>
                            <div class="single-service-item">
                                <div class="service-icon">
                                    <div class="service-icon-cell">
                                        <img src="img/icon/resi.png" alt="">
                                    </div>
                                </div>
                                <div class="service-text">
                                    <span>Residential</span>
                                    <span>VOIP</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                </div> -->
                <div id="Savetime" class=" bg-2">
		    <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="savetime">
                            <h2>Save time & money with Dofody</h2>
<p>Did you know that 70% of medical ailments can be treated with telehealth technology? Save your precious time and your hard earned money by consulting qualified Doctors online. No need to rush to the hospital through the busy traffic and then wait another 45 minutes just to see a Doctor!</p>
                        </div>
                    </div>
                </div>
                </div>
                </div>
                <div class="service-section">
                	<div class="container-fluid">
                    <div class="row">
                    	<div class="col-md-6 pl-0">
                    		<img src="<?=base_url()?>site/img/d.jpg" class="img-responsive">
                    	</div>
                        <div class="col-md-6">
                            <div class="service-container">
                                <h2>Why Use Dofody</h2>
                                <div class="service-column">
                                    <div class="service-item">
                                        <h3>Only quality Doctors </h3>
                                        <p>Doctors are selected after a strict verification process</p>
                                    </div>
                                    <div class="service-item">
                                        <h3>Consult a Doctor 24/7</h3>
                                        <p>High grade fever at 2AM? We’re here to help!</p>
                                    </div>
                                    <div class="service-item">
                                        <h3>Quality healthcare guarantee</h3>
                                        <p>Our Doctors are continuously learning and so you’re `assured a 100% satisfactory consultation</p>
                                    </div>
                                    <div class="service-item">
                                        <h3>Money-back guarantee</h3>
                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                    </div>
                                    <div class="service-item">
                                        <h3>Create free medical reports</h3>
                                        <p>Upload any prescription, scan or lab report and w’ll store it as your secure electronic medical record
Accessible only to you</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
		    </div>
		</div>
		</div>
		<!-- feature Area End -->

<section class="chat bg-1 bg-blue mt-100">
       <div class="container">
        	<div class="row">
        		<div class="col-md-6 pt-100">
        			<h2 class="color-white">Chat, Call or Video call with a Doctor</h2>
					<p class="color-white">You can securely chat, audio call or video call with a Doctor and send them your old prescriptions, lab or imaging reports within the same window. Register now & get your first chat or call consultation absolutely free!</p>
					<a href="#" class="default-btn button white">Register now</a>
        		</div>
				<div class="col-md-6">
				<img src="<?=base_url()?>site/img/e.png" class="img-responsive">
				</div>
				</div>
		   </div>
</section>
 <section class="chat">
	 <div class="container">
		   <div class="row">
			   <div class="col-md-6">
				<img src="<?=base_url()?>site/img/f.jpg" class="img-responsive">
				</div>
        		<div class="col-md-6 pt-100">
                            <h2>Hello Doctors!</h2>
                            <p>Dofody is short for “Doctors For Everybody”. Join us and become a part of the revolutionary technology that is taking healthcare to new heights in India and help millions to lead a healthy life! </p>
                            <a href="#" class="default-btn button">Learn more</a>
              </div>
        	</div>
        </div>
   </section>

   <div class="Download bg-1 bg-blue">
     <div class="container">
       <div class="row text-center">
       	<div class="col-md-1"></div>
       	<div class="col-md-10">
		<h2>Download the Dofody App</h2>
		<p>All you need is an internet connection and a smartphone! The Dofody app has an innovative core technology that connects you to the best doctor online within a few minutes</p>
		<a href="#"><img src="<?=base_url()?>site/img/play-store.png" class="img-responsive" width="180"></a>
		</div>

		<div class="col-md-1"></div>
		</div>
		    </div>
				</div>



<div class="footer-widget-area footer-area pb-60">
            <div class="container">
                <div class="row">
					<div class="col-md-4">
                        <div class="single-footer-widget">
                            <div class="footer-title">
                                <h2>Support</h2>
                            </div>
                            <div class="footer-content">
                                <ul class="footer-widget-list">
                                    <li><a href="#">About dofody</a></li>                                     
                                    <li><a href="#">Contact us</a></li>                                     
                                    <li><a href="#">Terms of use</a></li>                                     
                                    <li><a href="#">Privacy policy</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="single-footer-widget">
                            <div class="footer-title">
                                <h2>Contact</h2>
								<p>For any customer related service</p>
                            </div>
                            <div class="footer-content">
                                <div class="contact-info">
                                    <h4 class="c-content">Phone :	</h4>
                                    <span>+91 81 00 77 11 99</span>
                                </div>
                                <div class="contact-info">
                                    <h4 class="c-content">E-mail :	</h4>
                                    <span>info@dofody.com</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="single-footer-widget">
                            <div class="footer-title">
                                <h2>Follow Us</h2>
                            </div>
                            <div class="footer-content footer-icon">
                                <ul class="footer-widget-list list-inline">
                                    <li><a href="#"><i class="fab fa-facebook"></i></a></li>
                                    <li><a href="#"><i class="fab fa-twitter-square"></i></a></li>
                                    <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                                    <li><a href="#"><i class="fab fa-youtube-square"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer Widget Area End -->

        <!-- Footer Area Start -->
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
        <!-- Footer Area End -->
        <!-- Login Register Start -->
        <div id="quickview-login">
            <div class="modal fade" id="productModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-close"></i></span></button>
                        </div>
                        <div class="modal-body">
                            <div class="header-tab-menu">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#login" aria-controls="login" role="tab" data-toggle="tab">login</a></li>
                                    <li role="presentation"><a href="#register" aria-controls="register" role="tab" data-toggle="tab">Sign Up</a></li>
                                </ul>
                            </div>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="login">
                                    <div class="login-form-container">
                                        <span>Please login using account detail bellow.</span>
                                        <form action="#" method="post">
                                            <input type="text" name="user-name" placeholder="Username">
                                            <input type="password" name="user-password" placeholder="Password">
                                            <div class="button-box">
                                                <div class="login-toggle-btn">
                                                    <input type="checkbox" id="remember">
                                                    <label for="remember">Remember me</label>
                                                    <a href="#">Forgot Password?</a>
                                                </div>
                                                <button type="submit" class="default-btn floatright">Login</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="register">
                                    <div class="register-form">
                                        <span>Please sign up using account detail bellow.</span>
                                        <form action="#" method="post">
                                            <input type="text" name="user-name" placeholder="Username">
                                            <input type="password" name="user-password" placeholder="Password">
                                            <input type="email" name="user-email" placeholder="Email">
                                            <div class="button-box">
                                                <button type="submit" class="default-btn floatright">Register</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
						</div>
					</div>
				</div>
			</div>
        </div>
        <!-- Login Register End -->

		<!-- All js here -->
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
        <!-- google map api -->
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD_qDiT4MyM7IxaGPbQyLnMjVUsJck02N0"></script>
        <script src="<?=base_url()?>site/js/map.js"></script>
        <script src="<?=base_url()?>site/js/main.js"></script>
    </body>
</html>
