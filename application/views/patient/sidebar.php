  <div class="topbar">
      <!-- LOGO -->
      <div class="topbar-left">
          <a href="<?=site_url('dofody');?>" class="logo">
            <span>
              <img src="<?=base_url()?>assets/images/logo.png" alt="" height="26">
            </span>
            <i>
              <img src="<?=base_url()?>assets/images/logo_sm.png" alt="" height="30">
            </i>
          </a>
      </div>

      <nav class="navbar-custom main-menu">
          <ul class="list-unstyled topbar-right-menu float-right mb-0">
              <span class="hidden-xxs">
                            <li><a href="<?=site_url('dofody');?>">Home</a></li>
                           <li><a href="#">Ask a doctor</a></li>
                           <li><a target="_blank" href="http://dofody.com/blog">Blog</a></li>
                        </span>
              <li class="dropdown notification-list">
                  <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button"
                     aria-haspopup="false" aria-expanded="false">
                      <img src="<?=$user['profile']?>" alt="user" class="rounded-circle"> <span class="ml-1 white"><?=$user['user']?> <i class="mdi mdi-chevron-down"></i> </span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                      <!-- item-->
                      <a href="<?=site_url('patient/myAccount')?>" class="dropdown-item notify-item black">
                          <i class="fi-lock"></i> <span>Settings</span>
                      </a>

                      <!-- item-->
                      <a href="<?=site_url('login/logout')?>" class="dropdown-item notify-item black">
                          <i class="fi-power"></i> <span>Logout</span>
                      </a>

                  </div>
              </li>
          </ul>

          <ul class="list-inline menu-left mb-0">
              <li class="float-left">
                  <button class="button-menu-mobile open-left waves-light waves-effect">
                      <i class="dripicons-menu"></i>
                  </button>
              </li>
          </ul>

      </nav>

  </div>
  <!-- Top Bar End -->


  <!-- ========== Left Sidebar Start ========== -->
  <div class="left side-menu">
      <div class="slimscroll-menu" id="remove-scroll">

          <!--- Sidemenu -->
          <div id="sidebar-menu">
              <!-- Left Menu Start -->
              <ul class="metismenu" id="side-menu">
                  <li class="menu-title">Navigation</li>
                  <li>
                      <a href="<?=site_url('patient/dashboard')?>">
                          <i class="fa fa-home"></i><span> Dashboard </span>
                      </a>
                  </li>
                  <li>
                      <a href="<?=site_url('patient/profile')?>">
                          <i class="fa fa-dashboard"></i><span> Profile </span>
                      </a>
                  </li>
                  <li>
                      <a href="#"><i class="fa fa-navicon"></i> <span> Medical records </span> <span class="menu-arrow"></span></a>
                      <ul class="nav-second-level" aria-expanded="false">
                          <li><a href="<?=site_url('patient/medical-records')?>">Records</a></li>
                          <li><a href="<?=site_url('patient/record-gallery')?>">Gallery</a></li>
                      </ul>
                  </li>
                  <li>
                      <a href="<?=site_url('patient/members')?>">
                          <i class="fa fa-user"></i><span> Members </span>
                      </a>
                  </li>
                  <li>
                      <a href="<?=site_url('patient/consult')?>">
                          <i class="fa fa-stethoscope"></i><span> Consult now </span>
                      </a>
                  </li>
                  <li>
                      <a href="#"><i class="fa fa-history"></i> <span> History </span> <span class="menu-arrow"></span></a>
                      <ul class="nav-second-level" aria-expanded="false">
                          <li><a href="<?=site_url('patient/ongoing_history')?>">Ongoing consultations</a></li>
                          <li><a href="<?=site_url('patient/completed_history')?>">Completed consultations</a></li>
                      </ul>
                  </li>
                  <li>
                      <a href="<?=site_url('patient/chats')?>">
                          <i class="fa fa-comments"></i><span> Chats </span>
                      </a>
                  </li>
              </ul>

          </div>
          <!-- Sidebar -->
          <div class="clearfix"></div>

      </div>
      <!-- Sidebar -left -->

  </div>
  <!-- Left Sidebar End -->
