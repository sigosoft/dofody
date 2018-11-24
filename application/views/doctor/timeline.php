<!DOCTYPE html>
<html>
  <head>
    <?php include('includes.php'); ?>
    <link rel="stylesheet" href="<?=base_url()?>plugins/image-crop/croppie.css">
  </head>
  <body>
    <div id="wrapper">
      <?php include('sidebar.php');?>
      <div class="content-page">
          <!-- Start content -->
          <div class="content">
              <div class="container-fluid">

                  <div class="row">
                      <div class="col-12">
                          <div class="page-title-box">
                              <h4 class="page-title float-left">Profile</h4>
                              <div class="clearfix"></div>
                          </div>
                      </div>
                  </div>
                  <!-- end row -->

                      </div><!-- /.modal -->


                  <div class="row">
                      <div class="col-md-5">
                          <div class="card-box table-responsive">
                            <h4 class="m-t-0 header-title">Contact details</h4>
                            <div class="row">
                              <div class="col-md-5">
                                <img class="identity-img img-fluid" src="<?=$user['profile']?>" alt="User profile picture" width="100%">
                                <button type="button" class="btn btn-link" id="change-button"> change picture</button>
                              </div>
                              <div class="col-md-7">
                                <h4 class="profile-username text-center"><?php echo $doc->name; ?></h4>
                                <p class="text-muted text-center"><?php echo $doc->mobile; ?></p>
                                <p class="text-muted text-center"><?php echo $doc->email; ?></p>
                                <p class="text-muted text-center"><?php echo $doc->place; ?></p>
                              </div>
                            </div>
                          </div>
                      </div>

                      <div class="col-md-5">
                        <div class="card-box table-responsive">
                          <h4 class="m-t-0 header-title">Bank Details</h4>
                          <div class="row">
                            <div class="col-md-5">
                              <?php $i=1; if ($bank->format == 'pdf') { ?>
                                <a href="<?=base_url() . $bank->doc_account?>" target="_blank"><img id="imageresource" src="<?=base_url()?>uploads/pdf.png" height="150px" width="100%"></a>
                              <?php }
                              else { ?>
                                <a href="#"><img id="<?php $id='id'.$i; echo $id; ?>" onclick="return test(this);" src="<?php echo base_url() . $bank->doc_account;?>" class="identity-img" width="100%" height="150px"></a>
                              <?php $i++; } ?>
                            </div>
                            <div class="col-md-7">
                              <p class="text-muted">Bank Name : <?=strtoupper($bank->acc_bank)?></p>
                              <p class="text-muted">Name : <?=strtoupper($bank->acc_holder)?></p>
                              <p class="text-muted">Account No. : <?=$bank->acc_number?></p>
                              <p class="text-muted">IFSC Code : <?=$bank->acc_ifsc?></p>
                            </div>
                          </div>
                          <div class="row" >
                            <div class="col-md-12">
                              <a href="<?=site_url('doctor/edit_bank_details')?>" class="pull-right">Edit</a>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-2">
                          <div class="card-box table-responsive">
                              <h4 class="m-t-0 header-title"><span></span><span><?php echo $identity->type_of_id; ?></span></h4>
                              <?php if ($identity->format == 'pdf') { ?>
                                <a href="<?=base_url() . $identity->identity?>" target="_blank"><img id="imageresource" src="<?=base_url()?>uploads/pdf.png" width="100%" height="150px"></a>
                              <?php }
                              else { ?>
                                <a href="#"><img id="<?php $id='id'.$i; echo $id; ?>" onclick="return test(this);" src="<?php echo base_url() . $identity->identity; ?>" class="identity-img" width="100%" height="150px"></a>
                              <?php } $i++; ?>
                          </div>
                      </div>
                  <!-- </div>
                  <div class="row"> -->

                      <div class="col-md-5">
                          <div class="card-box table-responsive">
                            <h4 class="m-t-0 header-title">Degree</h4>

                            <div class="row">
                              <div class="col-md-5">
                                <?php if ($stream->format == 'pdf') { ?>
                                  <a href="<?=base_url() . $stream->doc_degree?>" target="_blank"><img id="imageresource" src="<?=base_url()?>uploads/pdf.png" height="120px" width="120px"></a>
                                <?php }
                                else { ?>
                                  <a href="#"><img id="stream" onclick="return test(this);"  src="<?php echo base_url() . $stream->doc_degree;?>" width="100%" height="150px"></a>
                                <?php } ?>
                              </div>
                              <div class="col-md-7">
                                <p class="text-muted">Degree : <?php echo strtoupper($stream->stream_name); ?></p>
                                <p class="text-muted">College : <?php echo strtoupper($stream->college); ?></p>
                                <p class="text-muted">Year : <?php echo $stream->pass_year; ?></p>
                                <p class="text-muted">University : <?php echo $stream->university; ?></p>
                              </div>
                            </div>
                            <hr>
                            <h4 class="m-t-0 header-title">Specilizations</h4>
                            <?php $id='id'; foreach ($special as $sp) { ?>
                            <div class="row">
                              <div class="col-md-5">
                                <?php if ($sp->format == 'pdf') { ?>
                                  <a href="<?=base_url() . $sp->doc_degree?>" target="_blank"><img id="imageresource" src="<?=base_url()?>uploads/pdf.png" height="150px" width="100%"></a>
                                <?php }
                                else { ?>
                                  <a href="#"><img id="<?=$id.$i?>" onclick="return test(this);"  src="<?php echo base_url() . $sp->doc_degree;?>" height="150px" width="100%"></a>
                                <?php } ?>
                              </div>
                              <div class="col-md-7">
                                <p class="text-muted">Degree : <?php echo strtoupper($sp->special_name); ?></p>
                                <p class="text-muted">College : <?php echo strtoupper($sp->college); ?></p>
                                <p class="text-muted">Year : <?php echo $sp->pass_year; ?></p>
                                <p class="text-muted">University : <?php echo $sp->university; ?></p>
                              </div>
                            </div>
                          <?php $i++; } ?>
                          </div>
                      </div>
                      <div class="col-md-5">
                          <div class="card-box table-responsive">
                            <h4 class="m-t-0 header-title">Registration</h4>
                            <?php foreach ($reg as $re) {
                              $id = 'id'.$i;
                             ?>
                            <div class="row">
                              <div class="col-md-5">
                                <?php if ($re->format == 'pdf') { ?>
                                  <a href="<?=base_url() . $re->doc_reg?>" target="_blank"><img id="imageresource" src="<?=base_url()?>uploads/pdf.png" height="150px" width="100%"></a>
                                <?php }
                                else { ?>
                                  <a href="#"><img id="<?=$id?>" onclick="return test(this);"  src="<?php echo base_url() . $re->doc_reg;?>" height="150px" width="100%"></a>
                                <?php } ?>
                              </div>
                              <div class="col-md-7">
                                <p class="text-muted">Registration No. : <?=$re->reg_number?></p>
                                <p class="text-muted">Coucil of Registration : <?=$re->reg_council?></p>
                              </div>
                            </div>
                          <?php $i++; } ?>
                          </div>
                        </div>
                      <div class="col-md-2">
                        <div class="card-box table-responsive">
                          <h4 class="m-t-0 header-title">Signature</h4>
                          <a href="#"><img id="<?php $id='id'.$i; echo $id; ?>" onclick="return test(this);" src="<?php echo base_url() . $sign->signature; ?>" height="150px" width="100%"></a>
                        </div>
                      </div>
                    </div>


              </div> <!-- container -->

          </div>
      <?php include('footer.php');?>
    </div>
    <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <h4 class="modal-title" id="myModalLabel">Image preview</h4>
        </div>
        <div class="modal-body">
          <img src="" id="imagepreview" class="img-fluid" >
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="change-image" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Update your profile picture</h4>
      </div>
      <div class="modal-body">

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
        <div id="submit-button" style="display:none">
          <form action="<?=site_url('doctor/uploadProfilePhoto')?>" method="post">
            <textarea id="profile-ph" name="photo" rows="8" cols="80" style="display:none"></textarea>
            <button type="submit" id="submit_button" class="btn btn-primary">Upload</button>
          </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
  </body>
  <?php include('scripts.php'); ?>
  <script src="<?=base_url()?>plugins/image-crop/croppie.js"></script>
  <script>
  $uploadCrop = $('#upload-demo').croppie({
      enableExif: true,
      viewport: {
          width: 200,
          height: 200,
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
      $('#profile-ph').val(resp);
    });
  });
  </script>
  <script>
  function test(obj)
  {
    var id = obj.id;
    var src = document.getElementById(id).src;
    //alert(src);
    $('#imagepreview').attr('src', src);
    $('#imagemodal').modal('show');
    return false;
  }
  $('#change-button').on('click',function(){
    $('#change-image').modal('show');
  });
  </script>
</html>
