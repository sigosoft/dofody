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
                  <h4 class="page-title float-left">Manage Degree</h4>
                  <ol class="breadcrumb float-right">
                    <button type="button" class="btn btn-gradient btn-rounded waves-light waves-effect w-md"  data-toggle="modal" data-target="#add-record">Add Degree</button>
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
                          <th>Degree</th>
                          <th>Description</th>
                          <th>Edit</th>
                        </tr>
                      </thead>
                    <tbody>
                      <?php foreach ($stream as $str){ ?>
                        <tr>
                          <td><?=$str->stream_name?></td>
                          <td><?=$str->stream_desc?></td>
                          <td><i class="fa fa-wrench" onclick="edit('<?=$str->stream_id?>')"></i></td>
                        </tr>
                      <?php  } ?>
                    </tbody>
                  </table>
                </div>
            </div>
          </div>
        </div>
      </div>
      <div id="add-record" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-body">
              <h2 class="text-uppercase text-center m-b-30">
                <span><h4>Add degree</h4></span>
              </h2>
              <form class="form-horizontal" action="<?php echo site_url('admin/add_stream');?>" method="post">
                <div class="form-group m-b-25">
                  <div class="col-12">
                    <label for="select">Degree</label>
                    <input type="text" class="form-control" name="stream_name">
                  </div>
                </div>
                <div class="form-group m-b-25">
                  <div class="col-12">
                    <label for="select">Degree</label>
                    <textarea name="stream_desc" rows="3" cols="80" class="form-control"></textarea>
                  </div>
                </div>
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
      <div id="edit-record" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-body">
              <h2 class="text-uppercase text-center m-b-30">
                <span><h4>Add degree</h4></span>
              </h2>
              <form class="form-horizontal" action="<?php echo site_url('admin/edit_stream');?>" method="post">
                <div class="form-group m-b-25">
                  <div class="col-12">
                    <label for="select">Degree</label>
                    <input type="hidden" name="stream_id" id="stream_id">
                    <input type="text" class="form-control" name="stream_name" id="stream_name">
                  </div>
                </div>
                <div class="form-group m-b-25">
                  <div class="col-12">
                    <label for="select">Degree</label>
                    <textarea name="stream_desc" rows="6" cols="80" class="form-control" id="stream_desc"></textarea>
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
      <?php include('footer.php');?>
    </div>
  </body>
  <?php include('scripts.php'); ?>
  <script>
    function edit(stream)
    {
      $.ajax({
          method: "POST",
          url: "<?php echo site_url('admin/getStreamById');?>",
          dataType : "json",
          data : { stream : stream },
          success : function( data ){
            $('#stream_id').val(data.stream_id);
            $('#stream_name').val(data.stream_name);
            $('#stream_desc').val(data.stream_desc);
            $('#edit-record').modal('show');
          }
        });
    }
  </script>
</html>
