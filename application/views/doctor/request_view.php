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
                  <h4 class="page-title float-left">Consult now</h4>
                  <ol class="breadcrumb float-right">

                  </ol>
                  <div class="clearfix"></div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
                <div class="card-box table-responsive">
                  <table class="table">
                    <thead>
                        <tr>
                          <th>Date</th>
                          <th>Time</th>
                          <th>Photo</th>
                          <th>Name</th>
                          <th>Age</th>
                          <th>Location</th>
                          <th>Problem</th>
                          <th>Type</th>
                        </tr>
                      </thead>
                    <tbody>
                      <?php $i=1; foreach($req as $r){
                        $dateOfBirth = $r->dob;
                        $today = date("Y-m-d");
                        $diff = date_diff(date_create($dateOfBirth), date_create($today));
                        $age = $diff->format('%y');
                        if ( $r->profile_photo == 'nil') {
                          $image = "Image not uploaded";
                        }
                        else {
                          $image = "<img src='".base_url() . $r->profile_photo."' height='100px' width='100px' style='border-radius:50px;'> ";
                        }
                        ?>
                      <tr>
                          <td><?php echo date('d F', strtotime($r->date)); ?></td>
                          <td><?=$r->time?></td>
                          <td><a href="<?=site_url('doctor/patient_detail_view/'.$r->req_id)?>"><?=$image?></a></td>
                          <td><a href="<?=site_url('doctor/patient_detail_view/'.$r->req_id)?>"><?php echo $r->patient_name; ?></a></td>
                          <td><?=$age?></td>
                          <td><?php echo $r->city; ?></td>
                          <td><?php echo $r->present_problem; ?></td>
                          <!--<td><?php if( $r->request_type=='quick' ){ echo '<b>'.strtoupper($r->request_type).'</b>'; } else { echo $r->request_type; } ?></td>-->
                          <td><?=$r->type_consult?></td>
                      </tr>
                      <?php $i++;  } ?>
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
