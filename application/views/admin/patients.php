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
                  <h4 class="page-title float-left">Manage patients</h4>
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
                        <table id="datatable" class="table table-bordered">
                          <thead>
                              <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th></th>
                              </tr>
                            </thead>
                          <tbody>
                            <?php
                              $i=1;
                              foreach ($patients as $q) {
                                if ($q->user_status == 1) {
                                  $status = 'Enabled';
                                  $msg = 'disable';
                                }
                                else {
                                  $status = 'Disabled';
                                  $msg = 'enable';
                                }
                            ?>
                            <tr>
                              <td><?php echo $i;?></td>
                              <td><?php echo $q->name;?></td>
                              <td><?php echo $q->mobile;?></td>
                              <td><?php echo $q->email;?></td>
                              <td><?=$status?></td>
                              <td><button class="btn btn-flat btn-default" type="button" onclick="window.location='<?php echo site_url("admin/manage_patient/".$q->user_id."/".$q->user_status);?>'">Click to <?=$msg?></button></td>
                              <!--<td><button class="btn btn-link" onclick="window.location='<?php echo site_url("admin/doc_single/".$q->user_id);?>'"><i class="fa fa-eye" style="font-size: 20px;"></i></button></td>-->
                            </tr>
                            <?php
                            $i++;
                              }
                            ?>
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
</html>
