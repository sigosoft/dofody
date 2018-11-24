<!DOCTYPE html>
<html>
  <head>
    <?php include('includes.php'); ?>
    <link rel="stylesheet" href="<?=base_url()?>plugins/bootstrap-select/css/bootstrap-select.min.css" />
    <link href="<?=base_url()?>plugins/bootstrap-timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
    <link href="<?=base_url()?>plugins/clockpicker/css/bootstrap-clockpicker.min.css" rel="stylesheet">
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
                  <h4 class="page-title float-left">NEW REQUESTS</h4>
                  <ol class="breadcrumb float-right">
                    <button type="button" class="btn btn-gradient btn-rounded waves-light waves-effect w-md" data-toggle="modal" data-target="#setup-hotdeal">TEST</button>
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
                     <th>Problem</th>
                     <th>Consultation</th>
                     <th>Patient</th>
                     <th>Doctor</th>
                     <th>Doctor mobile</th>
                     <th>Add time</th>
                   </tr>
                   </thead>
                   <tbody>
                     <?php foreach($requests as $request){ ?>
                     <tr>
                        <td><?=$request->present_problem?></td>
                        <td><?=$request->type_consult?></td>
                        <td><?=$request->patient_name?></td>
                        <td><?=$request->name?></td>
                        <td><?=$request->mobile?></td>
                        <td><button class="btn btn-link"><i class="fa fa-search" onclick="show('<?=$request->req_id?>')"></i></button></td>
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
    <div id="show" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
             <div class="modal-dialog">
                 <div class="modal-content">

                     <div class="modal-body">
                         <h2 class="text-uppercase text-center m-b-30">
                             <span><h4>ASSIGN TIME</h4></span>
                         </h2>
                         
                         <form class="form-horizontal" action="<?=site_url('admin/addTimeRequest')?>" method="post">
                             
                             <div class="form-group m-b-25">
                                 <div class="col-12">
                                     <label for="select">Date</label>
                                     <input type="date" name="date" class="form-control" required>
                                 </div>
                             </div>

                             <div class="form-group m-b-25">
                                 <div class="col-12">
                                     <label for="select">Time</label>
                                     <input type="text" name="time" id="timepicker" class="form-control" required>
                                 </div>
                             </div>
                             <input type="hidden" id="request_id" name="request_id">
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
  </body>
  <?php include 'scripts.php'; ?>
  <script src="<?=base_url()?>plugins/bootstrap-select/js/bootstrap-select.js"></script>
  <script src="<?=base_url()?>plugins/bootstrap-timepicker/bootstrap-timepicker.js"></script>
  <script src="<?=base_url()?>plugins/clockpicker/js/bootstrap-clockpicker.min.js"></script>
  <script src="<?=base_url()?>assets/pages/jquery.form-pickers.init.js"></script>
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
    function show(id)
    {
        $('#request_id').val(id);
        $('#show').modal('show');
    }
  </script>
</html>
