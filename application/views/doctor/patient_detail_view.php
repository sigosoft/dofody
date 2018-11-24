<!DOCTYPE html>
<html>
  <head>
    <?php include('includes.php'); ?>
    <style>
        .p-profile{
          font-size : 17px;
          font-weight : bold;
        }
        .input-profile {
          border : 0;
          outline : 0;
          border-bottom: 1px dotted black;
          font-weight : normal;
          width: 80%;
        }
        .textarea-profile{
          border : 0;
          outline : 0;
          border-bottom: 1px dotted black;
          font-weight : normal;
          width : 80%;
        }
    </style>
  </head>
  <body>
    <div id="wrapper">
      <?php include('sidebar.php');?>
      <div class="content-page">
        <div class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                <div class="page-title-box">
                  <h4 class="page-title float-left">Patients details</h4>
                  <ol class="breadcrumb float-right">

                  </ol>
                  <div class="clearfix"></div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
                <div class="card-box">
                  <div class="row">
                    <div class="col-12">
                      <h5>Personal details</h5>
                      <hr>
                    </div>
                    <div class="col-8">
                      <p class="p-profile">Name &nbsp; <input type="text" class="input-profile" value="<?=$info->patient_name?>" readonly></p>
                      <p class="p-profile">Gender<div class="form-group">
                        <label class="radio-inline"><input type="radio" <?php if($info->gender == 'm'){ ?> checked="checked" <?php } ?>>  Male</label>
                        <label class="radio-inline"><input type="radio" <?php if($info->gender == 'f'){ ?> checked="checked" <?php } ?>>  Female</label>
                        <label class="radio-inline"><input type="radio" <?php if($info->gender == 'o'){ ?> checked="checked" <?php } ?>>  Others</label>
                      </div></p>
                      <p class="p-profile">Date of birth &nbsp; <input type="text" class="input-profile" value="<?=$info->dob?>" readonly></p>
                      <p class="p-profile">City &nbsp; <input type="text" class="input-profile" value="<?=$info->city?>" readonly></p>
                      <p class="p-profile">Phone number &nbsp; <input type="text" name="patient_mobile" class="input-profile" value="<?=$info->patient_mobile?>" readonly></p>
                      <p class="p-profile">Email address &nbsp; <input type="text" class="input-profile" value="<?=$info->patient_email?>" readonly></p>
                      <p class="p-profile">Height &nbsp; <input type="text" class="input-profile" value="<?=$info->height?>" readonly></p>
                      <p class="p-profile">Weight &nbsp; <input type="text" class="input-profile" value="<?=$info->weight?>" readonly></p>
                      <p class="p-profile">Past medical conditions &nbsp; </p>
                      <p class="p-profile"><textarea class="textarea-profile" rows="3" cols="50" name="past_medical" readonly><?=$info->past_medical?></textarea></p>
                      <p class="p-profile">History of surgeries &nbsp; <input type="text" class="input-profile" name="history_surgery" value="<?=$info->history_surgery?>" readonly></p>
                      <p class="p-profile">Medicines taken now &nbsp; </p>
                      <p class="p-profile"><textarea class="textarea-profile" rows="3" cols="50" name="medicines_now" readonly><?=$info->medicines_now?></textarea></p>

                    </div>
                    <div class="col-md-4">
                      <?php
                        if ( $info->profile_photo == 'nil') {
                          $image = "Photo not uploaded";
                        }
                        else {
                          $image = "<img src='".base_url() . $info->profile_photo."' height='300px' width='300px'>";
                        }
                        echo $image;
                      ?>
                      <!--<img src="<?=base_url().$info->profile_photo?>" height="300px" width="300px">-->
                    </div>
                    <div class="col-12 table-responsive">
                      <hr>
                        <h5>Medical records</h5>
                      <hr>
                      <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                              <th>No.</th>
                              <th>Title</th>
                              <th>Notes</th>
                              <th>Record</th>
                            </tr>
                          </thead>
                        <tbody>
                          <?php $i=1; foreach ($records as $rec){ ?>
                            <tr>
                              <td><?=$i?></td>
                              <td><?=$rec->med_title?></td>
                              <td><?=$rec->med_notes?></td>
                              <td>
                                <?php if ($rec->med_title == 'Electronic medical record') { ?>

                                      <a class="btn btn-link" href="<?=base_url().$rec->med_document?>" target="_blank"><i class="fa fa-file"></i></a>

                                <?php }
                                  else { ?>
                                      <button class="btn btn-link" data-toggle="modal" data-target="#image" onclick="image('<?=base_url().$rec->med_document?>')"><i class="fa fa-file"></i></button>
                                <?php  } ?>
                              </td>
                            </tr>
                          <?php $i++;  } ?>
                        </tbody>
                      </table>
                    </div>
                    <div class="col-12">
                      <hr>
                      <h5>Other details</h5>
                      <hr>
                      <div class="row">
                        <div class="col-6 form-group">
                          <p class="p-profile">presenting complaints &nbsp; <input type="text" style="width:100%;" class="input-profile" value="<?=$req->present_problem?>" readonly></p>
                        </div>
                        <div class="col-6 form-group">
                          <p class="p-profile">Since when &nbsp; <input type="text" style="width:100%;" class="input-profile" value="<?=$req->since_when?>" readonly></p>
                        </div>
                        <div class="col-6 form-group">
                          <p class="p-profile">Requested time &nbsp; <input type="text" style="width:100%;" class="input-profile" value="<?php echo date('d F', strtotime($req->date))." - ".$req->time;?>" readonly></p>
                        </div>
                        <div class="col-6 form-group">
                          <p class="p-profile">Type of consultation &nbsp; <input type="text" style="width:100%;" class="input-profile" value="<?=$req->type_consult?>" readonly></p>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <form action="<?=site_url('doctor/start_consultation')?>" method="post">
                        <input type="hidden" name="req" value="<?=$req->req_id?>">
                        <input type="hidden" name="type" value="<?=$req->type_consult?>">
                        <input type="hidden" name="patient" value="<?=$req->patient_id?>">
                        <button type="submit" class="btn btn-gradient btn-rounded waves-light waves-effect w-md pull-right">Start consultation</button>
                      </form>
                    </div>
                  </div>
                </div>
            </div>
          </div>
        </div>
      </div>
      <?php include('footer.php');?>
    </div>
    <div class="modal fade" id="image" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <h4 class="modal-title" id="myModalLabel">Record</h4>
        </div>
        <div class="modal-body">
          <img src="" id="record_image" class="img-fluid" >
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
    </div>
  </body>
  <?php include('scripts.php'); ?>
  <script>
  function image(doc)
  {
    $('#image').on('show.bs.modal', function (e) {
      $('#record_image').attr('src', doc);
    });
  }
  </script>
</html>
