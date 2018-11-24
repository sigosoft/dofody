<!DOCTYPE html>
<html>
  <head>
    <?php include('includes.php'); ?>
    <link href="<?=base_url()?>plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url()?>plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url()?>plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
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
                  <h4 class="page-title float-left">Medical records</h4>
                  <ol class="breadcrumb float-right">
                    <button type="button" class="btn btn-gradient btn-rounded waves-light waves-effect w-md"  data-toggle="modal" data-target="#add-record">Add record</button>
                  </ol>
                  <div class="clearfix"></div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
                <div class="card-box table-responsive">
                  <table id="datatable" class="table table-bordered">
                    <thead>
                        <tr>
                          <th>No.</th>
                          <th>Patient</th>
                          <th>Title</th>
                          <th>Notes</th>
                          <th>Record</th>
                          <th>Edit</th>
                          <th>Delete</th>
                        </tr>
                      </thead>
                    <tbody>
                      <?php $i=1; foreach ($records as $rec){ ?>
                        <tr>
                          <td><?=$i?></td>
                          <td><?=$rec->patient_name?></td>
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
                          <td><button class="btn btn-link" onclick="edit_record('<?=$rec->med_id?>')"><i class="fa fa-pencil"></i></button></td>
                          <td><button class="btn btn-link" data-toggle="modal" data-target="#delete" onclick="del('<?=$rec->med_id?>','<?=$rec->med_document?>')"><i style="color:red;" class="fa fa-trash"></i></button></td>
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
    <div class="modal fade" id="delete" role="dialog">
      <div class="modal-dialog modal-sm">

        <!-- Modal content-->
        <div class="modal-content">

          <div class="modal-body">
            <p>Are you sure?</p>
            <form action="<?=site_url("patient/delete_medical_record");?>" method="post">
                <input type="hidden" name="record_id" id="record_id">
                <input type="hidden" name="document" id="document">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-default">delete</button>
          </div>
        </form>
        </div>

      </div>
    </div>

    <!-- IMAGE PREVIEW -->
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

    <!-- ADD MEDICAL RECORD -->
    <div id="add-record" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <h2 class="text-uppercase text-center m-b-30">
              <span><h4>Add record</h4></span>
            </h2>
            <form action="<?php echo site_url('patient/add_record/1');?>" method="post" enctype="multipart/form-data">
              <div class="form-group m-b-25">
                <div class="col-12">
                  <label for="select">Select member</label>
                  <select class="form-control selectpicker" name="patient_id">
                    <?php foreach ($patients as $pat) { ?>
                      <option value="<?=$pat->patient_id?>"><?=$pat->patient_name?></option>
                    <? } ?>
                  </select>
                </div>
              </div>
              <div class="form-group m-b-25">
                <div class="col-12">
                  <label for="select">Record type</label>
                  <select class="form-control selectpicker" name="med_title">
                      <option value="Prescription">Prescription</option>
                      <option value="Lab test">Lab tests</option>
                      <option value="Scan report">Scan reports</option>
                      <option value="Electronic medical record">Electronic medical record</option>
                  </select>
                </div>
              </div>
              <div class="form-group m-b-25">
                <div class="col-12">
                  <label for="select">Note</label>
                  <textarea class="form-control" rows="4" id="notes" name="med_notes" required></textarea>
                </div>
              </div>
              <div class="form-group m-b-25">
                <div class="col-12">
                  <label for="select">Note</label>
                  <input type="file" class="form-control" id="rec_file" name="rec_file" onchange="preview_image(this,0)" required>
                </div>
              </div>
              <img class="img-fluid" id="output_image" style="padding-bottom:10px;"/>
              <div class="form-group account-btn text-center m-t-10">
                <div class="col-12">
                  <button type="reset" class="btn w-lg btn-rounded btn-light waves-effect m-l-5" data-dismiss="modal">Back</button>
                  <button class="btn w-lg btn-rounded btn-primary waves-effect waves-light" type="submit">Add</button>
                </div>
              </div>
            </form>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div>

    <!-- EDIT MEDICAL RECORDS -->
    <div id="edit-record" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <h2 class="text-uppercase text-center m-b-30">
              <span><h4>Edit record</h4></span>
            </h2>
            <form action="<?php echo site_url('patient/edit_record');?>" method="post" enctype="multipart/form-data">
              <input type="hidden" name="med_id" id="med_id">
              <div class="form-group m-b-25">
                <div class="col-12">
                  <label for="select">Select member</label>
                  <select class="form-control selectpicker" name="patient_id" id="patient_id">
                    <?php foreach ($patients as $pat) { ?>
                      <option value="<?=$pat->patient_id?>"><?=$pat->patient_name?></option>
                    <? } ?>
                  </select>
                </div>
              </div>
              <div class="form-group m-b-25">
                <div class="col-12">
                  <label for="select">Record type</label>
                  <select class="form-control selectpicker" name="med_title" id="med_title">
                      <option value="Prescription">Prescription</option>
                      <option value="Lab test">Lab tests</option>
                      <option value="Scan report">Scan reports</option>
                      <option value="Electronic medical record">Electronic medical record</option>
                  </select>
                </div>
              </div>
              <div class="form-group m-b-25">
                <div class="col-12">
                  <label for="select">Note</label>
                  <textarea class="form-control" rows="4" name="med_notes" id="med_notes" required></textarea>
                </div>
              </div>
              <div class="form-group m-b-25">
                <div class="col-12">
                  <label for="select">Change image</label>
                  <input type="file" class="form-control" id="record_file" name="rec_file" onchange="preview_image(this,1)">
                </div>
              </div>
              <img class="img-fluid" id="output_image1" style="padding-bottom:10px;"/>
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
  <script src="<?=base_url()?>plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?=base_url()?>plugins/datatables/dataTables.bootstrap4.min.js"></script>
  <!-- Buttons examples -->
  <script src="<?=base_url()?>plugins/datatables/dataTables.buttons.min.js"></script>
  <script src="<?=base_url()?>plugins/datatables/buttons.bootstrap4.min.js"></script>
  <script src="<?=base_url()?>plugins/datatables/vfs_fonts.js"></script>
  <script src="<?=base_url()?>plugins/datatables/buttons.html5.min.js"></script>
  <!-- Responsive examples -->
  <script src="<?=base_url()?>plugins/datatables/dataTables.responsive.min.js"></script>
  <script src="<?=base_url()?>plugins/datatables/responsive.bootstrap4.min.js"></script>

  <script type="text/javascript">
      $(document).ready(function() {
          $('#datatable').DataTable();

          //Buttons examples
          var table = $('#datatable-buttons').DataTable({
              lengthChange: false,
              buttons: ['copy', 'excel', 'pdf']
          });

          table.buttons().container()
                  .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
      } );

  </script>
  <script>
    function del(id,doc)
    {
      $('#delete').on('show.bs.modal', function (e) {
           $(this).find('#record_id').val(id);
           $(this).find('#document').val(doc);
      });
    }
    function image(doc)
    {
      $('#image').on('show.bs.modal', function (e) {
        $('#record_image').attr('src', doc);
      });
    }
  </script>
  <script>
  function preview_image(id,check)
  {
    var id = id.id;
    var x = document.getElementById(id);
    var val = x.files[0].type;
    var type = val.substr(val.indexOf("/") + 1);

    var report = $('#report').val();
    if (report == 'Electronic medical record') {
      if (type != 'pdf') {
        alert('Please upload a pdf document..!');
        document.getElementById(id).value = "";
      }
    }
    else{
      var size = x.files[0].size;
      if (size > 1000000) {
        alert('Please select an image with size less than 1 mb.');
        document.getElementById(id).value = "";
      }
      else {
        s_type = ['jpeg','jpg','png'];
        var flag = 0;
        for (var i = 0; i < s_type.length; i++) {
          if (s_type[i] == type) {
            flag = flag + 1;
          }
        }
        if (flag == 0) {
          alert('This file format is not supported.');
          document.getElementById(id).value = "";
        }
        else {
          if (type != 'pdf') {
            var reader = new FileReader();
            reader.onload = function()
            {

              if (check == 0) {
                  var output = document.getElementById('output_image');
              }
              else {
                var output = document.getElementById('output_image1');
              }
             output.src = reader.result;
            }
            reader.readAsDataURL(x.files[0]);
          }
        }

      }
    }
  }
  function edit_record(med_id)
  {
    $.ajax({
        method: "POST",
        url: "<?php echo site_url('patient/getRecordById');?>",
        dataType : "json",
        data : { med_id : med_id },
        success : function( data ){
          $('#patient_id').val(data.patient_id);
          $('#med_title').val(data.med_title);
          var url = '<?=base_url()?>' + data.med_document;
          $('#med_notes').val(data.med_notes);
          $('#med_id').val(data.med_id);
          $("#output_image1").attr("src",url);
          $('#edit-record').modal('show');
        }
      });
  }
  </script>
</html>
