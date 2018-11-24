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
                      <img src="<?=base_url()?>assets/images/logo_sm.png" alt="user" class="rounded-circle"> <span class="ml-1"><?=$user['user']?><i class="mdi mdi-chevron-down"></i> </span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                      <!-- item-->
                      <div class="dropdown-item noti-title">
                          <h6 class="text-overflow m-0">Welcome !</h6>
                      </div>

                      <a href="#" class="dropdown-item notify-item">
                          <i class="fi-lock"></i> <span>Lock Screen</span>
                      </a>

                      <!-- item-->
                      <a href="<?=site_url('admin-login/logout')?>" class="dropdown-item notify-item">
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
                      <a href="<?=site_url('admin')?>">
                          <i class="fa fa-dashboard"></i><span> Dashboard </span>
                      </a>
                  </li>
                  <li>
                      <a href="#"><i class="fa fa-navicon"></i> <span> Qualification </span> <span class="menu-arrow"></span></a>
                      <ul class="nav-second-level" aria-expanded="false">
                          <li><a href="<?=site_url('admin/streams')?>">Degree</a></li>
                          <li><a href="<?=site_url('admin/special')?>">Specialization</a></li>
                      </ul>
                  </li>
                  <li>
                      <a href="<?=site_url('admin/quick_fee')?>">
                          <i class="fa fa-flash"></i><span> Quick consult fee </span>
                      </a>
                  </li>
                  <li>
                      <a href="<?=site_url('admin/quick_consultations')?>">
                          <i class="fa fa-envelope"></i><span> Quick consultations </span>
                      </a>
                  </li>
                  <li>
                      <a href="<?=site_url('admin/addTimeToRequest')?>">
                          <i class="fa fa-archive"></i><span> New requests </span>
                      </a>
                  </li>
                  <li>
                      <a href="<?=site_url('admin/doctors')?>">
                          <i class="fa fa-stethoscope"></i><span> Manage doctors </span>
                      </a>
                  </li>
                  <li>
                      <a href="<?=site_url('admin/patients')?>">
                          <i class="fa fa-user"></i><span> Manage patients </span>
                      </a>
                  </li>
                  <li>
                      <a href="#"><i class="fa fa-history"></i> <span> History </span> <span class="menu-arrow"></span></a>
                      <ul class="nav-second-level" aria-expanded="false">
                          <li><a href="<?=site_url('admin/ongoing_history')?>">Ongoing consultations</a></li>
                          <li><a href="<?=site_url('admin/completed_history')?>">Completed consultations</a></li>
                      </ul>
                  </li>
                  <li>
                      <a href="#"><i class="fa fa-trash"></i> <span> Deleted accounts </span> <span class="menu-arrow"></span></a>
                      <ul class="nav-second-level" aria-expanded="false">
                          <li><a href="<?=site_url('admin/delete_requests')?>">Delete requests</a></li>
                          <li><a href="<?=site_url('admin/deleted_accounts')?>">Deleted accounts</a></li>
                      </ul>
                  </li>
              </ul>

          </div>
          <!-- Sidebar -->
          <div class="clearfix"></div>

      </div>
      <!-- Sidebar -left -->

  </div>
  <!-- Left Sidebar End -->
