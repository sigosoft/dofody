  <div class="topbar">
      <!-- LOGO -->
      <div class="topbar-left">
          <a href="index.html" class="logo">
            <span>
              <img src="<?=base_url()?>assets/images/logo.png" alt="" height="26">
            </span>
            <i>
              <img src="<?=base_url()?>assets/images/logo_sm.png" alt="" height="30">
            </i>
          </a>
      </div>

      <nav class="navbar-custom">
          <ul class="list-unstyled topbar-right-menu float-right mb-0">
              <li class="dropdown notification-list">
                  <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button"
                     aria-haspopup="false" aria-expanded="false">
                      <img src="<?=$user['profile']?>" alt="user" class="rounded-circle"> <span class="ml-1"><?=$user['user']?><i class="mdi mdi-chevron-down"></i> </span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                      <!-- item-->
                      <div class="dropdown-item noti-title">
                          <h6 class="text-overflow m-0">Welcome !</h6>
                      </div>

                      <a href="<?=site_url('doctor/myAccount')?>" class="dropdown-item notify-item">
                          <i class="fi-lock"></i> <span>Settings</span>
                      </a>

                      <!-- item-->
                      <a href="<?=site_url('doctor-login/logout')?>" class="dropdown-item notify-item">
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
              <li class="hide-phone app-search">
                  <form role="search" class="">
                      <input type="text" placeholder="Search..." class="form-control">
                      <a href="#"><i class="fa fa-search"></i></a>
                  </form>
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
                      <a href="<?=site_url('doctor/profile')?>">
                          <i class="fa fa-dashboard"></i><span> Profile </span>
                      </a>
                  </li>
                  <li>
                      <a href="<?=site_url('doctor/consult')?>">
                          <i class="fa fa-stethoscope"></i><span> Consult now </span>
                      </a>
                  </li>
                  <li>
                      <a href="#"><i class="fa fa-navicon"></i> <span> Online clinic </span> <span class="menu-arrow"></span></a>
                      <ul class="nav-second-level" aria-expanded="false">
                          <li><a href="<?=site_url('doctor/clinic')?>">Manage clinic</a></li>
                          <li><a href="<?=site_url('doctor/fee')?>">Manage fee</a></li>
                      </ul>
                  </li>
                  <li>
                      <a href="<?=site_url('doctor/chats')?>">
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
