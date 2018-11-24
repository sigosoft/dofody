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
                  <h4 class="page-title float-left">Ongoing consultations</h4>
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
                          <th>Patient name</th>
                          <th>Photo</th>
                          <th>Problem</th>
                          <th>Type</th>
                          <th>History</th>
                          <th>Prescription</th>
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
                          <td><?=$request->patient_name?></td>
                          <td><img src="<?=base_url().$request->profile_photo?>" height="60px" width="60px" style="border-radius:30px;"></td>
                          <td><?=$request->present_problem?></td>
                          <td><?=$request->type_consult?></td>
                          <td><button type="button" class="btn btn-rounded btn-primary waves-effect waves-light" onclick="window.location='<?=site_url("doctor/ongoing_history_view/".$request->req_id)?>'">View</button></td>
                          <?php if (isset($request->prescription_id)) { ?>
                            <td><a href="<?=site_url('doctor/view_prescription/'.$request->req_id.'/'.$request->prescription_id)?>" class="btn btn-rounded btn-primary waves-effect waves-light" target="_blank">View</a><button type="button" class="btn btn-rounded btn-primary waves-effect waves-light" onclick="editPrescription('<?=$request->prescription_id?>')">Edit</button></td>
                          <?php } else { ?>
                            <td><button type="button" class="btn btn-rounded btn-primary waves-effect waves-light" onclick="prescription('<?=$request->req_id?>')">Add</button></td>
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
    <div class="modal fade" id="prescription" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">PRESCRIPTION</h4>
          </div>
          <div class="modal-body">
            <form action="<?=site_url('doctor/addPrescription')?>" method="post">
              <input type="hidden" id="request_id" name="request_id">
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
    <div class="modal fade" id="editPrescription" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">EDIT PRESCRIPTION</h4>
          </div>
          <div class="modal-body">
            <form action="<?=site_url('doctor/editPrescription')?>" method="post">
              <input type="hidden" id="pres_id" name="pres_id">
              <div class="form-group m-b-25">
                  <label for="select">Provisional diagonosis</label>
                  <textarea name="pro_diagonosis" id="pro_diagonosis" class="form-control" rows="4" cols="80"></textarea>
              </div>
              <table id="pres_table_edit" style="width:100%">

              </table>
              <div class="text-center">
                <button type="button" class="btn btn-link" onclick="addRowEdit()"><i style="font-size:25px;" class="fa fa-plus-circle"></i></button>
              </div>
            </div>
            <div class="modal-footer">
              <button class="btn w-md btn-rounded btn-primary waves-effect waves-light" type="submit">Save</button>
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
    function prescription(h_id)
    {
      $('#request_id').val(h_id);
      $('#prescription').modal('show');
    }

    function addRowEdit()
    {
      var col1 = "<tr><td><input type='text' class='form-control' placeholder='Eg : Paracetamol' name='medicine[]' required></td>";
      var col2 = "<td><input type='text' class='form-control' placeholder='Eg : 1-1-1' name='usage[]' required></td>";
      var col3 = "<td><input type='text' class='form-control' placeholder='Eg : 5 days' name='days[]' required></td>";
      var col4 = "<td><a class='btn btn-link' onclick='deleteRow(this);'><i style='font-size:25px; color:red;' class='fa fa-minus-circle'></i></a></td></tr>";
      var row = col1 + col2 + col3 + col4;
      $('#pres_table_edit').append(row);
    }
    function deleteRowEdit(row)
    {
      $(row).closest('tr').remove();
    }
    function editPrescription(h_id)
    {
      $.ajax({
        method: "POST",
        url: "<?php echo site_url('doctor/getPrescription');?>",
        data : { prescription_id : h_id },
        dataType : "json",
        success : function( data ){
          $('#pres_id').val(h_id);
          $('#pres_table_edit').html(data.table);
          $('#pro_diagonosis').html(data.provisional);
          $('#editPrescription').modal('show');
        }
      });
    }
  </script>
</html>
