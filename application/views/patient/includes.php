  <?php 
    $user = $this->session->userdata('dof_user'); 
    $token = $user['token'];
    $identity = 'user'.$user['user_id'];
  ?>
  <meta charset="utf-8" />
  <title>Dofody</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <meta content="#" name="description" />
  <meta content="Sigosoft" name="author" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />

  <!-- App favicon -->
  <link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>site/img/favicon.png">

  <link href="<?=base_url()?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="<?=base_url()?>assets/css/icons.css" rel="stylesheet" type="text/css" />
  <link href="<?=base_url()?>assets/css/metismenu.min.css" rel="stylesheet" type="text/css" />
  <link href="<?=base_url()?>assets/css/style.css" rel="stylesheet" type="text/css" />
  <link href="<?=base_url()?>plugins/sweet-alert/sweetalert.css" rel="stylesheet" type="text/css" />
  <script src="<?=base_url()?>assets/js/modernizr.min.js"></script>
