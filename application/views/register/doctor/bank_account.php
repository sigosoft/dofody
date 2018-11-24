<!DOCTYPE html>
<html>
<head>
  <?php $user_data = $this->session->userdata('data'); ?>
  <meta charset="utf-8" />
  <title>Dofody</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <meta content="#" name="description" />
  <meta content="Sigosoft" name="author" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />

  <!-- App favicon -->
  <link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>assets/images/logo_sm.png">

  <!-- App css -->
  <link href="<?=base_url()?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="<?=base_url()?>assets/css/icons.css" rel="stylesheet" type="text/css" />
  <link href="<?=base_url()?>assets/css/style.css" rel="stylesheet" type="text/css" />

  <script src="<?=base_url()?>assets/js/modernizr.min.js"></script>

</head>
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
                                        <h6 class="text-uppercase text-center font-bold mt-4">Bank account details</h6>
                                        <p class="text-center">Kindly furnish any bank account details to which your earnings will be credicted.</p>
                                    </div>
                                    <div class="account-content scroll">
                                        <form action="<?php echo site_url('register_doctor/bank_det')?>" method="post" enctype="multipart/form-data" onsubmit="return check();">

                                            <div class="form-group row m-b-20">
                                                <div class="col-12">
                                                    <input type="text" class="form-control bttn-radius" name="name" id="name" placeholder="Bank name" required>
                                                </div>
                                            </div>
                                            <div class="form-group row m-b-20">
                                                <div class="col-12">
                                                    <input type="text" class="form-control bttn-radius" name="holder" id="holder" placeholder="Name of account holder" required>
                                                </div>
                                            </div>

                                            <div class="form-group row m-b-20">
                                                <div class="col-12">
                                                    <input type="text" class="form-control bttn-radius" name="number" id="number" placeholder="Account number" required>
                                                </div>
                                            </div>
                                            <div class="form-group row m-b-20">
                                                <div class="col-12">
                                                    <input type="text" class="form-control bttn-radius" name="ifsc" id="ifsc" placeholder="IFSC code" required>
                                                </div>
                                            </div>
                                            <div class="form-group row m-b-20">
                                                <div class="col-12">
                                                  <select class="form-control bttn-radius selectpicker" id="sel1" name="type_bank">
                                                    <option value="Cheque">Cancelled cheque</option>
                                                    <option value="Passbook">Front page of passbook</option>
                                                    <option value="statement">Bank statement</option>
                                                  </select>
                                                </div>
                                            </div>
                                            <input type="hidden" name="format" id="format">
                                            <div class="form-group row m-b-20">
                                                <div class="col-12">
                                                    <input type="file" class="form-control bttn-radius" name="bank" id="bank" onchange="preview_image(this)" required>
                                                </div>
                                            </div>
                                            <div id="bank-image"><img class="img-fluid" id="output_image" height="340px;" width="350px;" style="padding-top:5px;"/></div>
                                            <div class="form-group row text-center m-t-10">
                                                <div class="col-12">
                                                    <button class="btn btn-block btn-gradient waves-effect waves-light" type="submit">Submit</button>
                                                </div>
                                            </div>

                                        </form>

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
        <script type='text/javascript'>
        function preview_image(id)
        {
          var id = id.id;
          var x = document.getElementById(id);
          var size = x.files[0].size;
          if (size > 5000000) {
            alert('Please select an image with size less than 5 mb.');
            document.getElementById(id).value = "";
          }
          else {
            var val = x.files[0].type;
            var type = val.substr(val.indexOf("/") + 1);
            s_type = ['jpeg','jpg','png','pdf'];
            var flag = 0;
            for (var i = 0; i < s_type.length; i++) {
              if (s_type[i] == type) {
                flag = flag + 1;
              }
            }
            if (flag == 0) {
              alert('This file format is not supported.');
              document.getElementById(id).value = "";
            }
            else {
              if (type != 'pdf') {
                $('#bank-image').css('display','block');
                var reader = new FileReader();
                reader.onload = function()
                {
                 var output = document.getElementById('output_image');
                 output.src = reader.result;
                }
                reader.readAsDataURL(x.files[0]);
              }
              else {
                $('#bank-image').css('display','none');
              }
              $('#format').val(type);
            }

          }
        }
        function check()
        {
          $('#load').show();
          $('#submit_button').prop('disabled', true);
          return true;
        }
        </script>
    </body>
</html>
