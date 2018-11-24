<!DOCTYPE html>
<html>
  <head>
    <?php include('includes.php'); ?>
    <link href="<?=base_url()?>plugins/bootstrap-timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
        <link href="<?=base_url()?>plugins/clockpicker/css/bootstrap-clockpicker.min.css" rel="stylesheet">
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
                  <h4 class="page-title float-left">Manage clinic</h4>
                  <ol class="breadcrumb float-right">
                    <button type="button" class="btn btn-gradient btn-rounded waves-light waves-effect w-md" id="change">Manage</button>
                  </ol>
                  <div class="clearfix"></div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
                <div class="card-box table-responsive">
                  <div class="row">
                    <div class="col-md-12">
                      <p style="font-size:18px;">When can you consult online?</p>
                    </div>
                  </div>
                  <div class="row">
                    <?php foreach ($days as $day) { ?>
                      <div class="col-md-2">
                        <div class="card" style="width: 100%;">
                          <div class="card-body">
                            <h5 class="card-title text-center"><?=$day?></h5>
                          </div>
                        </div>
                      </div>
                    <?php } ?>
                  </div>
                  <div class="row" style="margin-top:10px;">
                    <div class="col-md-12">
                      <p style="font-size:18px;">Time schedule</p>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3">
                      <div class="card" style="width: 100%;">
                        <div class="card-body">
                          <h5 class="card-title text-center">From</h5>
                          <h4 class="text-center"><?=$cli->from_time?></h4>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="card" style="width: 100%;">
                        <div class="card-body">
                          <h5 class="card-title text-center">To</h5>
                          <h4 class="text-center"><?=$cli->to_time?></h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
          </div>
        </div>
      </div>
      <?php include('footer.php');?>
    </div>
    <div id="edit-clinic" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <h2 class="text-uppercase text-center m-b-30">
              <span><h4>Edit online clinic</h4></span>
            </h2>
            <form class="form-horizontal" action="<?php echo site_url('doctor/register_clinic');?>" method="post">
              <div class="form-group m-b-25">
                <p>When can tou consult online ?</p>
                <div class="row">
                  <div class="col-3">
                    <label><input type="checkbox" name="check_list[]" value="Monday" <?php if(isset($Monday)){ ?>checked<?php } ?>> Monday</label>
                  </div>
                  <div class="col-3">
                    <label><input type="checkbox" name="check_list[]" value="Tuesday" <?php if(isset($Tuesday)){ ?>checked<?php } ?>> Tuesday</label>
                  </div>
                  <div class="col-3">
                    <label><input type="checkbox" name="check_list[]" value="Wednesday" <?php if(isset($Wednesday)){ ?>checked<?php } ?>> Wednesday</label>
                  </div>
                  <div class="col-3">
                    <label><input type="checkbox" name="check_list[]" value="Thursday" <?php if(isset($Thursday)){ ?>checked<?php } ?>> Thursday</label>
                  </div>
                  <div class="col-3">
                    <label><input type="checkbox" name="check_list[]" value="Friday" <?php if(isset($Friday)){ ?>checked<?php } ?>> Friday</label>
                  </div>
                  <div class="col-3">
                    <label><input type="checkbox" name="check_list[]" value="Saturday" <?php if(isset($Saturday)){ ?>checked<?php } ?>> Saturday</label>
                  </div>
                  <div class="col-3">
                    <label><input type="checkbox" name="check_list[]" value="Sunday" <?php if(isset($Sunday)){ ?>checked<?php } ?>> Sunday</label>
                  </div>
                </div>
                <p>AT WHAT TIME?</p>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                                        <label>From</label>
                                        <div class="input-group">
                                            <input id="timepicker" type="text" name="time_from" class="form-control" <?php if(isset($cli)){ ?>value="<?=$cli->from_time?>"<?php } ?>>
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="mdi mdi-clock"></i></span>
                                            </div>
                                        </div><!-- input-group -->
                                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                                        <label>To</label>
                                        <div class="input-group">
                                            <input id="timepickerTo" name="time_to" type="text" class="form-control" <?php if(isset($cli)){ ?>value="<?=$cli->to_time?>"<?php } ?>>
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="mdi mdi-clock"></i></span>
                                            </div>
                                        </div><!-- input-group -->
                                    </div>
                  </div>
                </div>
              </div>

              <div class="form-group account-btn text-center m-t-10">
                <div class="col-12">
                  <button type="reset" class="btn w-lg btn-rounded btn-light waves-effect m-l-5" data-dismiss="modal">Back</button>
                  <button class="btn w-lg btn-rounded btn-primary waves-effect waves-light" type="submit">Update</button>
                </div>
              </div>
            </form>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div>
  </body>
  <?php include('scripts.php'); ?>
  <script src="<?=base_url()?>plugins/bootstrap-timepicker/bootstrap-timepicker.js"></script>
  <script src="<?=base_url()?>plugins/clockpicker/js/bootstrap-clockpicker.min.js"></script>
  <script src="<?=base_url()?>assets/pages/jquery.form-pickers.init.js"></script>
  <script>
    $('#change').on('click',function(){
      $('#edit-clinic').modal('show');
    });
  </script>
</html>
