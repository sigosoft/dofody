<!DOCTYPE html>
<html>
  <head>
    <?php include('includes.php'); ?>
    <style>
    #history {
        font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }
    #history td, #history th {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }
    #history tr:nth-child(even){background-color: #f2f2f2;}
    #history tr:hover {background-color: #ddd;}
      #history th {
          padding-top: 12px;
          padding-bottom: 12px;
          text-align: center;
          background-color: #fff;
          color: black;
      }
      .para-history{
        margin: 0px;
      }
      .no-data{
        text-align : center;
        font-size:18px;
        color:#3c86d8;
        margin-top:5px;
        border:1px solid #3c86d8;
        padding-top:10px;
        padding-bottom:10px;
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
                  <h4 class="page-title float-left">Consultation history - <?=$details->patient_name?></h4>
                  <ol class="breadcrumb float-right">

                  </ol>
                  <div class="clearfix"></div>
                </div>
              </div>
            </div>
          </div>
          <?php
            if ($details->profile_photo == 'nil') {
              $details->profile_photo = "uploads/profile/user.png";
            }
            if ($details->gender == 'm') {
              $details->gender = 'Male';
            }
            elseif ($details->gender == 'f') {
              $details->gender = 'Female';
            }
            elseif ($details->gender == 'o') {
              $details->gender = 'Others';
            }
            $age='';
           ?>
          <div class="row">
            <div class="col-12">
                <div class="card-box table-responsive">
                  <table style="margin-bottom:20px;" class="table">
                    <thead>
                      <tr>
                        <td>Profile photo</td>
                        <td>Name</td>
                        <td>Gender</td>
                        <td>Age</td>
                        <td>Height</td>
                        <td>Weight</td>
                        <td>Problem</td>
                        <td>Since</td>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><img src="<?=base_url().$details->profile_photo?>" width="80px" height="80px" style="border-radius : 40px;"></td>
                        <td><?=$details->patient_name?></td>
                        <td><?=$details->gender?></td>
                        <td><?=$details->age?></td>
                        <td><?=$details->height?></td>
                        <td><?=$details->weight?></td>
                        <td><?=$details->present_problem?></td>
                        <td><?=$details->since_when?></td>
                      </tr>
                    </tbody>
                    <tfoot>
                      <tr>
                        <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                      </tr>
                    </tfoot>
                  </table>
                  <table id="history" class="table">
                    <thead>
                      <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Call status</th>
                        <th>Duration</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $i=0; foreach ($history as $h) { ?>
                        <tr>
                          <td><?=$h->date?></td>
                          <td><?=$h->time?></td>
                          <td><?=$h->type?></td>
                          <td><?=$h->duration?></td>
                        </tr>
                      <?php $i++; } ?>
                    </tbody>
                  </table>
                  <?php if ($i == 0) { ?>
                    <div class="no-data">
                      Table empty
                    </div>
                  <?php } ?>
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
