<!DOCTYPE html>
<html>
  <head>
    <?php include('includes.php'); ?>
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
                              <button type="button" onclick="window.location='<?php echo site_url("admin/activate_user/".$doc->user_id.'/'.$doc->user_status);?>'" class="btn btn-gradient btn-rounded waves-light waves-effect w-md float-right" name="button"><?php if($doc->user_status=='1'){ echo "Deactivate"; } else { echo "Activate"; } ?></button>
                              <button type="button" class="btn btn-gradient btn-rounded waves-light waves-effect w-md float-right"  data-toggle="modal" data-target="#about-doctor" style="margin-right:10px;">Write about doctor</button>
                              <div class="clearfix"></div>
                          </div>
                      </div>
                  </div>
                  <!-- end row -->

                      </div><!-- /.modal -->


                  <div class="row">
                      <div class="col-5">
                          <div class="card-box table-responsive">
                            <h4 class="m-t-0 header-title">Contact details</h4>
                            <div class="row">
                              <div class="col-md-5">
                                <img class="identity-img img-fluid" src="<?=$profile_pic?>" alt="User profile picture" width="100%">
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

                      <div class="col-5">
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
                        </div>
                      </div>
                      <div class="col-2">
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

                      <div class="col-5">
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
                      <div class="col-5">
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
                      <div class="col-2">
                        <div class="card-box table-responsive">
                          <h4 class="m-t-0 header-title">Signature</h4>
                          <a href="#"><img id="<?php $id='id'.$i; echo $id; ?>" onclick="return test(this);" src="<?php echo base_url() . $sign->signature; ?>" height="150px" width="100%"></a>
                        </div>
                      </div>

                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="card-box table-responsive">
                              <h4 class="m-t-0 header-title">Consultation details</h4>
                              <div class="row">
                                <div class="col-md-12">
                                  <table class="table">
                                    <tr>
                                      <td>Consult days</td>
                                      <td><?=$days->days?></td>
                                    </tr>
                                    <tr>
                                      <td>From time</td>
                                      <td><?=$days->from_time?></td>
                                    </tr>
                                    <tr>
                                      <td>To time</td>
                                      <td><?=$days->to_time?></td>
                                    </tr>
                                    <tr>
                                      <td>Video fee</td>
                                      <td><?=$fee->video_fee?></td>
                                    </tr>
                                    <tr>
                                      <td>Audio fee</td>
                                      <td><?=$fee->audio_fee?></td>
                                    </tr>
                                    <tr>
                                      <td>Chat fee</td>
                                      <td><?=$fee->chat_fee?></td>
                                    </tr>
                                  </table>
                                </div>
                              </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card-box table-responsive">
                              <h4 class="m-t-0 header-title">Consultations in last 30 days</h4>
                              <div class="row">
                                <table class="table">
                                  <tr>
                                    <td>Audio call</td>
                                    <td><?=$count['audio']?></td>
                                  </tr>
                                  <tr>
                                    <td>Video call</td>
                                    <td><?=$count['video']?></td>
                                  </tr>
                                  <tr>
                                    <td>Chats</td>
                                    <td><?=$count['chat']?></td>
                                  </tr>
                                </table>
                              </div>
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
  <div id="about-doctor" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <h2 class="text-uppercase text-center m-b-30">
            <span><h4>Write about <span style="color:#5d6dc3"><?php echo $doc->name; ?></span></h4></span>
          </h2>
          <form class="form-horizontal" action="<?php echo site_url('admin/addAbout');?>" method="post">
            <div class="form-group m-b-25">
              <input type="hidden" name="doctor_id" value="<?=$doc->user_id?>">
              <div class="col-12">
                <label for="select">About doctor</label>
                <textarea name="about" rows="5" cols="80" class="form-control"><?php if (isset($about)){ echo $about->about; } ?></textarea>
              </div>
            </div>
            <div class="form-group account-btn text-center m-t-10">
              <div class="col-12">
                <button type="reset" class="btn w-lg btn-rounded btn-light waves-effect m-l-5" data-dismiss="modal">Back</button>
                <?php if (isset($about)) { ?>
                  <button class="btn w-lg btn-rounded btn-primary waves-effect waves-light" type="submit">Edit</button>
                <?php }
                      else { ?>
                        <button class="btn w-lg btn-rounded btn-primary waves-effect waves-light" type="submit">Add</button>
                      <?php }
                 ?>
              </div>
            </div>
          </form>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div>
  </body>
  <?php include('scripts.php'); ?>
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
  </script>
</html>
