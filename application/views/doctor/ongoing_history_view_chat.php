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
                    <button type="button" class="btn btn-gradient btn-rounded waves-light waves-effect w-md">Goto chat</button>
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
                  <div class="">
                    <div class="row">
                      <div class="col-6">
                        <div class="card" style="width: 100%;height:14rem">
                          <div class="card-body">
                            <h5 class="card-title text-center">Message sent</h5>
                            <h1 style="text-align:center;padding-top:40px;"><?=$sent?></h1>
                          </div>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="card" style="width: 100%;height:14rem">
                          <div class="card-body">
                            <h5 class="card-title text-center">Message recieved</h5>
                            <h1 style="text-align:center;padding-top:40px;"><?=$recieved?></h1>
                          </div>
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
    <div class="modal fade" id="prescription" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">PRESCRIPTION</h4>
          </div>
          <div class="modal-body">
            <form action="<?=site_url('doctor/addChatPrescription')?>" method="post">
              <input type="hidden" name="request_id" value="<?=$details->req_id?>">
              <div class="form-group m-b-25">
                  <label for="select">Provisional diagonosis</label>
                  <textarea name="pro_diagonosis" class="form-control" rows="4" cols="80"></textarea>
              </div>
              <table id="pres_table" style="width:100%">
                <tr>
                  <td style="text-align : center;">Medicine</td>
                  <td style="text-align : center;">Usage</td>
                  <td style="text-align : center;">Day</td>
                  <td></td>
                </tr>
                <tr>
                  <td><input type="text" class="form-control" placeholder="Eg : Paracetamol" name="medicine[]" required></td>
                  <td><input type="text" class="form-control" placeholder="Eg : 1-1-1" name="usage[]" required></td>
                  <td><input type="text" class="form-control" placeholder="Eg : 5 days" name="days[]" required></td>
                  <td><a class="btn btn-link" onclick="deleteRow(this);"><i style="font-size:25px; color:red;" class="fa fa-minus-circle"></i></a></td>
                </tr>
              </table>
              <div class="text-center">
                <button type="button" class="btn btn-link" onclick="addRow()"><i style="font-size:25px;" class="fa fa-plus-circle"></i></button>
              </div>
            </div>
            <div class="modal-footer">
              <button class="btn w-md btn-rounded btn-primary waves-effect waves-light" type="submit">Add</button>
              <button type="button" class="btn w-md btn-rounded btn-primary waves-effect waves-light" data-dismiss="modal">Close</button>
            </div>

          </form>
        </div>

      </div>
    </div>
  </body>
  <?php include('scripts.php'); ?>
  <script>
  function addRow()
  {
    var col1 = "<tr><td><input type='text' class='form-control' placeholder='Eg : Paracetamol' name='medicine[]' required></td>";
    var col2 = "<td><input type='text' class='form-control' placeholder='Eg : 1-1-1' name='usage[]' required></td>";
    var col3 = "<td><input type='text' class='form-control' placeholder='Eg : 5 days' name='days[]' required></td>";
    var col4 = "<td><a class='btn btn-link' onclick='deleteRow(this);'><i style='font-size:25px; color:red;' class='fa fa-minus-circle'></i></a></td></tr>";
    var row = col1 + col2 + col3 + col4;
    $('#pres_table').append(row);
  }
  function deleteRow(row)
  {
    $(row).closest('tr').remove();
  }
  function prescription()
  {
    $('#prescription').modal('show');
  }
  </script>
</html>
