<!DOCTYPE html>
<html>
  <head>
    <?php include('includes.php'); ?>
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
                  <h4 class="page-title float-left">Completed consultations</h4>
                  <ol class="breadcrumb float-right">
                    <!--<button type="button" class="btn btn-gradient btn-rounded waves-light waves-effect w-md">Add user</button>-->
                  </ol>
                  <div class="clearfix"></div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
                <div class="card-box table-responsive">
                  <table id="example2" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                          <th>No.</th>
                          <th>Photo</th>
                          <th>Patient name</th>
                          <th>Problem</th>
                          <th>Type</th>
                          <th>View</th>
                          <th>prescription</th>
                        </tr>
                      </thead>
                    <tbody>
                      <?php $i=1; foreach ($requests as $request) {
                        if ($request->profile_photo == 'nil') {
                          $request->profile_photo = "uploads/profile/user.png";
                        }
                      ?>
                        <tr>
                          <td><?=$i?></td>
                          <td><img src="<?=base_url().$request->profile_photo?>" height="60px" width="60px" style="border-radius:30px;"></td>
                          <td><?=$request->patient_name?></td>
                          <td><?=$request->present_problem?></td>
                          <td><?=$request->type_consult?></td>
                          <td><button type="button" class="btn btn-rounded btn-primary waves-effect waves-light" onclick="window.location='<?=site_url("patient/completed_history_view/".$request->req_id)?>'">View</button></td>
                          <?php if (isset($request->prescription_id)) { ?>
                            <td><a href="<?=site_url('MakePdf/pdf/'.$request->req_id.'/'.$request->prescription_id)?>" class="btn btn-rounded btn-primary waves-effect waves-light" target="_blank">Download</a></td>
                          <?php } else { ?>
                            <td>No prescription</td>
                          <?php } ?>
                        </tr>
                      <?php $i++; } ?>
                    </tbody>
                  </table>
                </div>
            </div>
          </div>
        </div>
      </div>
      <?php include('footer.php');?>
    </div>
  </body>
  <?php include('scripts.php'); ?>
</html>
