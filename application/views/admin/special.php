<!DOCTYPE html>
<html>
  <head>
    <?php include('includes.php'); ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/bootstrap-select/css/bootstrap-select.min.css">
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
                  <h4 class="page-title float-left">Manage specializations</h4>
                  <ol class="breadcrumb float-right">
                    <button type="button" class="btn btn-gradient btn-rounded waves-light waves-effect w-md"  data-toggle="modal" data-target="#add-record">Add specialization</button>
                  </ol>
                  <div class="clearfix"></div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
                <div class="card-box table-responsive">
                  <form action="<?php echo site_url('admin/select_special');?>" method="post">
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <select class="form-control selectpicker" id="sel1" name="stream">
                            <?php foreach ($stream as $str) { ?>
                              <option <?php if(isset($special)){ if( $str->stream_id == $special->stream_id ) { ?> selected <?php } } ?> value="<?=$str->stream_id?>"><?=$str->stream_name?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-1">
                        <button type="submit" class="btn btn-gradient btn-rounded waves-light waves-effect w-md">SELECT</button>
                      </div>
                    </div>
                  </form>
                  <?php if (isset($special)) { ?>
                  <div class="col-md-12">
                    <div class="table-responsive">
                          <table class="table">
                            <thead>
                                <tr>
                                  <th>No.</th>
                                  <th>Specialization</th>
                                  <th>Description</th>
                                  <th>Edit</th>
                                </tr>
                              </thead>
                            <tbody>
                              <?php $i=1; foreach ($specialization as $sp){ ?>
                                <tr>
                                  <td><?=$i?></td>
                                  <td><?=$sp->special_name?></td>
                                  <td><?=$sp->special_desc?></td>
                                  <td><i class="fa fa-wrench" onclick="edit('<?=$sp->special_id?>')"></i></td>
                                </tr>
                              <?php $i++;  } ?>
                            </tbody>
                          </table>
                        </div>
                  </div>

                  <?php } ?>
                </div>
            </div>
          </div>
        </div>
      </div>
      <?php include('footer.php');?>
    </div>
    <div id="add-record" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <h2 class="text-uppercase text-center m-b-30">
              <span><h4>Add specialization</h4></span>
            </h2>
            <form class="form-horizontal" action="<?php echo site_url('admin/add_special');?>" method="post">
              <div class="form-group m-b-25">
                <div class="col-12">
                  <label for="select">Degree</label>
                  <select class="form-control selectpicker" name="stream_id">
                    <?php foreach ($stream as $str) { ?>
                      <option value="<?=$str->stream_id?>"><?=$str->stream_name?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group m-b-25">
                <div class="col-12">
                  <label for="select">Specialization</label>
                  <input type="text" class="form-control" name="special_name">
                </div>
              </div>
              <div class="form-group m-b-25">
                <div class="col-12">
                  <label for="select">Description</label>
                  <textarea name="special_desc" rows="3" cols="80" class="form-control"></textarea>
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
              <span><h4>Add specialization</h4></span>
            </h2>
            <form class="form-horizontal" action="<?php echo site_url('admin/edit_special');?>" method="post">
              <div class="form-group m-b-25">
                <input type="hidden" name="special_id" id="special_id">
                <div class="col-12">
                  <label for="select">Degree</label>
                  <select class="form-control" name="stream_id" id="stream_id">
                    <?php foreach ($stream as $str) { ?>
                      <option value="<?=$str->stream_id?>"><?=$str->stream_name?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group m-b-25">
                <div class="col-12">
                  <label for="select">Specialization</label>
                  <input type="text" class="form-control" name="special_name" id="special_name">
                </div>
              </div>
              <div class="form-group m-b-25">
                <div class="col-12">
                  <label for="select">Description</label>
                  <textarea name="special_desc" rows="3" cols="80" class="form-control" id="special_desc"></textarea>
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
    <?php include('scripts.php'); ?>
  </body>
  <script src="<?=base_url()?>plugins/bootstrap-select/js/bootstrap-select.js"></script>
  <script>
    function edit(special)
    {
      $.ajax({
          method: "POST",
          url: "<?php echo site_url('admin/getSpecialById');?>",
          dataType : "json",
          data : { special : special },
          success : function( data ){
            $('#special_id').val(data.special_id);
            $('#stream_id').val(data.stream_id);
            $('#special_name').val(data.special_name);
            $('#special_desc').val(data.special_desc);
            $('#edit-record').modal('show');
          }
        });
    }
  </script>
</html>
