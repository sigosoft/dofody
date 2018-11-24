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
                                        <h6 class="text-uppercase text-center font-bold mt-4">Registration certificate</h6>
                                    </div>
                                    <div class="account-content scroll">
                                        <form action="<?php echo site_url('register_doctor/reg_cert') ?>" method="post" enctype="multipart/form-data" onsubmit="return check();">

                                            <div class="form-group row m-b-20">
                                                <div class="col-12">
                                                    <input type="text" class="form-control bttn-radius" name="reg_number[]" id="reg_number" placeholder="Register number" required>
                                                </div>
                                            </div>
                                            <div class="form-group row m-b-20">
                                                <div class="col-12">
                                                    <input type="text" class="form-control bttn-radius" name="council[]" id="council" placeholder="Council of registration" required>
                                                </div>
                                            </div>
                                            <div class="form-group row m-b-20">
                                                <div class="col-12">
                                                    <input type="file" class="form-control bttn-radius" name="reg[]" id="reg" onchange="preview_image(this)" required>
                                                </div>
                                            </div>
                                            <img class="img-fluid" id="output_first" height="340px;" width="350px;"/>
                                            <hr>
                                            <div class="clearfix"></div>
                                            <div class="form-group has-feedback" id="more_file">

                                            </div>
                                            <a href="#" onclick="return load_more();"><p>ATTACH MORE REGISTRATION CERTIFICATES</p></a>

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
        <script>
          var num=0;
          function load_more()
          {
            id = 'file'+num;
            bt = id+'bt';
            file_id = 'f'+num;
            img_id = 'img'+num;
            var div_start = "<div id='"+id+"'><div class='row'><div class='col-12'><a href='#' class='btn btn-link pull-right' onclick='empty_div("+num+")'><i class='fa fa-close'></i></a></div></div><div class='row'>";
            var div_end = "</div></div>";
            var reg_number = "<div class='col-12'><div class='form-group has-feedback'><input type='text' class='form-control bttn-radius' name='reg_number[]'  placeholder='Register number' required></div></div>";
            var reg_council = "<div class='col-12'><div class='form-group has-feedback'><input type='text' class='form-control bttn-radius' name='council[]'  placeholder='Council of registration' required></div></div>";
            var file = "<div class='col-12'><div class='form-group has-feedback'><input type='file' name='reg[]' class='form-control bttn-radius' id="+file_id+" onchange='preview_image(this)'></div></div>";
            var image = "<div class='col-12'><img class='img-fluid' id='"+img_id+"' height='340px' width='350px'/></div>";

            var div = div_start + reg_number + reg_council + file + image + div_end ;
            $("#more_file").append(div);
            //alert(id);
            //alert(div);
            num = num+1;
            return false;
          }
          function empty_div(val)
          {
            file_id = 'file'+val;
            document.getElementById(file_id).innerHTML = "";
          }
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
                  var reader = new FileReader();
                  reader.onload = function()
                  {
                    if (id == 'reg') {
                      var output = document.getElementById('output_first');
                    }
                    else
                    {
                    	var img_id = 'img' + id.substr(1);
                    	var output = document.getElementById(img_id);
                    }

                   output.src = reader.result;
                  }
                  reader.readAsDataURL(x.files[0]);
                }
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
