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
                  <h4 class="page-title float-left">Members</h4>
                  <ol class="breadcrumb float-right">
                    <button type="button" class="btn btn-gradient btn-rounded waves-light waves-effect w-md" onclick="window.location='<?php echo site_url("patient/add-member")?>'">Add member</button>
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
                          <th>Name</th>
                          <th>Gender</th>
                          <th>DOB</th>
                          <th>Height</th>
                          <th>Weight</th>
                          <th>Profile</th>
                          <th>Delete</th>
                        </tr>
                      </thead>
                    <tbody>
                      <?php foreach ($patients as $p) {
                        $g = $p->gender;
                        if ($g == 'm') {
                          $gender = "Male";
                        }
                        elseif ($g == 'f') {
                          $gender = "Female";
                        }
                        else {
                          $gender = "Others";
                        }
                      ?>
                      <!-- onclick="window.location='<?php echo site_url("patient/delete_member/".$p->patient_id);?>'" -->
                      <tr>
                          <td><?php echo $p->patient_name; ?></td>
                          <td><?php echo $gender; ?></td>
                          <td><?php echo $p->dob; ?></td>
                          <td><?php echo $p->height; ?></td>
                          <td><?php echo $p->weight; ?></td>
                          <td><button class="btn btn-link" onclick="window.location='<?php echo site_url("patient/profile/".$p->patient_id);?>'"><i class="fa fa-user"></i></button></td>
                          <td><button class="btn btn-link" data-toggle="modal" data-target="#delete" onclick="check('<?=$p->patient_id?>')"><i class="fa fa-trash"></i></button></td>
                      </tr>
                      <?php } ?>
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
