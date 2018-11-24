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
  <script src="<?=base_url()?>assets/js/jquery.min.js"></script>
  <script src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
  <script src="<?=base_url()?>plugins/image-crop/croppie.js"></script>
  <link rel="stylesheet" href="<?=base_url()?>plugins/image-crop/croppie.css">
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
                                        <h6 class="text-uppercase text-center font-bold mt-4">signature</h6>
                                        <p class="text-center">Put your signature in a white paper and upload it</p>
                                    </div>
                                    <div class="account-content scroll">
                                        <form action="<?=site_url('register_doctor/doctors_signature')?>" enctype="multipart/form-data" method="post">
                                            <div class="form-group row m-b-20">
                                                <div class="col-12">
                                                  <label>Choose document</label>
                                                    <input type="file" class="form-control bttn-radius" placeholder="Password" name="txtimage" id="upload" required>
                                                </div>
                                            </div>
                                            <div class="upload-div" style="display:none;">
                                              <div id="upload-demo"></div>
                                              <div class="col-12 text-center">
                                                <a href="#" class="btn btn-primary btn-flat" style="border-radius : 5px;" id="crop-button">Crop</a>
                                              </div>
                                            </div>
                                            <div class="upload-result text-center" id="upload-result" style="display : none; margin-bottom:10px;">

                                            </div>
                                            <input type="hidden" name="signature" id="sig" >
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

        <script src="<?=base_url()?>assets/js/popper.min.js"></script>
        <script src="<?=base_url()?>assets/js/waves.js"></script>
        <script src="<?=base_url()?>assets/js/jquery.slimscroll.js"></script>

        <!-- App js -->
        <script src="<?=base_url()?>assets/js/jquery.core.js"></script>
        <script src="<?=base_url()?>assets/js/jquery.app.js"></script>
        <script type="text/javascript">
        $uploadCrop = $('#upload-demo').croppie({
            enableExif: true,
            viewport: {
                width: 200,
                height: 80,
                type: 'rectangle'
            },
            boundary: {
                width: 300,
                height: 300
            }
        });


        $('#upload').on('change', function () {
          var file = $("#upload")[0].files[0];
          var val = file.type;
          var type = val.substr(val.indexOf("/") + 1);
          if (type == 'png' || type == 'jpg' || type == 'jpeg') {
            $(".upload-div").css("display", "block");
            $("#submit-button").css("display", "none");
          	var reader = new FileReader();
              reader.onload = function (e) {
              	$uploadCrop.croppie('bind', {
              		url: e.target.result
              	}).then(function(){
              		console.log('jQuery bind complete');
              	});

              }
              reader.readAsDataURL(this.files[0]);
          }
          else {
            alert('This file format is not supported.');
            document.getElementById("upload").value = "";
          }
        });


        $('#crop-button').on('click', function (ev) {
        	$uploadCrop.croppie('result', {
        		type: 'canvas',
        		size: 'viewport'
        	}).then(function (resp) {
            html = '<img src="' + resp + '" />';
            $("#upload-result").html(html);
            $("#upload-result").css("display", "block");
            $(".upload-div").css("display", "none");
            $("#submit-button").css("display", "block");
            $('#sig').val(resp);
        	});
        });
        </script>
    </body>
</html>
