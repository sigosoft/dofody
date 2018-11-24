<!DOCTYPE html>
<html>
    <head>
        <?php include('includes.php'); ?>
    </head>
    <body>
        <div id="wrapper">
            <?php include 'sidebar.php';?>
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <h4 class="page-title float-left">Dashboard</h4>

                                    <ol class="breadcrumb float-right">
                                        <li class="breadcrumb-item"><a href="#">Dofody</a></li>
                                        <li class="breadcrumb-item active">Dashboard</li>
                                    </ol>

                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->


                        <div class="row">
                          <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                              <div class="card-box tilebox-one">
                                  <i class="fi-star float-right"></i>
                                  <h6 class="text-muted text-uppercase mb-3">Total consultations</h6>
                                  <h4 class="mb-3"><span data-plugin="counterup"><?=$total?></span></h4>
                              </div>
                          </div>

                            <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                                <div class="card-box tilebox-one">
                                    <i class="fi-heart float-right"></i>
                                    <h6 class="text-muted text-uppercase mb-3">Ongoing consultations</h6>
                                    <h4 class="mb-3" data-plugin="counterup"><?=$ongoing?></h4>
                                </div>
                            </div>

                            <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                                <div class="card-box tilebox-one">
                                    <i class="fi-flag float-right"></i>
                                    <h6 class="text-muted text-uppercase mb-3">Latest prescription</h6>
                                    <a href="<?=base_url() . $prescription?>" class="btn btn-link" target="_blank">DOWNLOAD</a>
                                </div>
                            </div>

                            <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                                <div class="card-box tilebox-one">
                                    <i class="fi-star float-right"></i>
                                    <h6 class="text-muted text-uppercase mb-3">Family<br> members</h6>
                                    <h4 class="mb-3" data-plugin="counterup"><?=$members?></h4>
                                </div>
                            </div>
                        </div>



                        <!-- end row -->

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="card-box">
                                    <h4 class="header-title mb-4">Messages</h4>

                                    <div class="inbox-widget slimscroll" style="max-height: 370px;min-height:300px;">
                                      <?php foreach ($messages as $message) { ?>
                                        <a href="#">
                                            <div class="inbox-item">
                                                <div class="inbox-item-img"><img src="<?=base_url() . $message->profile_photo?>" class="rounded-circle bx-shadow-lg" height="40px" alt=""></div>
                                                <p class="inbox-item-author"><?=$message->name?></p>
                                                <p class="inbox-item-text"><?=$message->message?></p>
                                                <p class="inbox-item-date">13:40 PM</p>
                                            </div>
                                        </a>
                                      <?php } ?>
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card-box">
                                    <h4 class="header-title mb-4">Blogs</h4>

                                    <div class="comment-list slimscroll" style="max-height: 370px;">
                                      <?php foreach ($blogs as $blog) { ?>
                                        <a target="_blank" href="<?=$blog->post_link?>">
                                            <div class="comment-box-item">
                                                <div class="badge badge-pill badge-success">Published by : <?=$blog->user_login?></div>
                                                <p class="commnet-item-date"><?=$blog->date?></p>
                                                <h6 class="commnet-item-msg"><?=$blog->post_title?></h6>
                                            </div>
                                        </a>
                                      <?php } ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="card-box">
                                    <h4 class="header-title mb-4">Last Transactions</h4>

                                    <ul class="list-unstyled transaction-list slimscroll mb-0" style="max-height: 370px;">
                                      <?php foreach ($transactions as $trans) { ?>
                                        <li>
                                            <span class=""><?=$trans->date?></span>
                                            <span class="pull-right text-danger tran-price">-₹<?=$trans->fee?></span>
                                            <p><?=$trans->message?></p>
                                            <span class="clearfix"></span>
                                        </li>
                                      <?php } ?>
                                    </ul>

                                </div>
                            </div>

                        </div>


                    </div> <!-- container -->

                </div> <!-- content -->
                <?php include 'footer.php'; ?>
            </div>
        </div>
        <?php include 'scripts.php';?>
        <script src="<?=base_url()?>assets/pages/jquery.dashboard.init.js"></script>
    </body>
</html>
