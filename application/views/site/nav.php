<?php $user = $this->session->userdata('dof_user');
?>
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
                                    <li><a href="<?=site_url('login')?>">Consult now</a></li>
                                    <li><a href="#">Ask a Doctor</a></li>
                                    <!--<li><a href="<?=site_url('contact_us')?>">Contact us</a></li>-->
                                    <li><a href="http://dofody.com/blog/">Blog</a></li>
                                    <li><a href="<?=site_url('dofody/select')?>">Login</a></li>
                                    <li><a href="<?=site_url('dofody/register')?>">Register</a></li>
                                    <?php
                                        if(isset($user)){ ?>
                                    <li class="dropdown notification-list">
                  <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button"
                     aria-haspopup="false" aria-expanded="false">
                      <img src="<?=$user['profile']?>" alt="user" class="rounded-circle"> <span class="ml-1"><?=$user['user']?> <i class="mdi mdi-chevron-down"></i> </span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                      <!-- item-->

                      <a href="<?=site_url('redir/route/'.$user['user_id'])?>" class="dropdown-item notify-item black">
                          <i class="fi-lock"></i> <span>My profile</span>
                      </a>

                  </div>
              </li>
                                    <?php }else { ?>
                                    <li><a href="#"><img src="<?=base_url()?>site/img/play-store.png" width="100"></a></li>
                                    <?php } ?>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="col-md-12">
                       <div class="mobile-menu  hidden-lg hidden-md">
                            <nav>
                                <ul>
                                    <!--<li class="active"><a href="<?=site_url('dofody')?>">Home</a></li>-->
                                    <li><a href="<?=site_url('login')?>">Consult now</a></li>
                                    <li><a href="#">Ask a Doctor</a></li>
                                    <!--<li><a href="<?=site_url('contact_us')?>">Contact us</a></li>-->
                                    <li><a href="<?=site_url('dofody/select')?>">Login</a></li>
                                    <li><a href="#"><img src="<?=base_url()?>site/img/play-store.png" width="100"></a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
		</header>