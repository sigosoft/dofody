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
                  <h4 class="page-title float-left">Record gallery</h4>
                  <ol class="breadcrumb float-right">
                  </ol>
                  <div class="clearfix"></div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
                <div class="card-box">
                  <div class="container">

                    <div class="row text-center text-lg-left">
                      <?php $i=1; foreach ($records as $record) { ?>
                        <div class="col-lg-3 col-md-4 col-xs-6">
                          <a href="#" class="d-block mb-4 h-100">
                            <img class="img-fluid img-thumbnail" id="<?php echo 'image'.$i; ?>" src="<?=base_url().$record->med_document?>" alt="record missing" onclick="showImage(this)">
                          </a>
                        </div>
                      <?php $i++; } ?>
                    </div>

                </div>
                </div>
            </div>
          </div>
        </div>
      </div>
      <?php include('footer.php');?>
    </div>
    <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <h4 class="modal-title" id="myModalLabel">Record</h4>
        </div>
        <div class="modal-body">
          <img src="" id="modal-image" class="img-fluid" >
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  </body>
  <?php include('scripts.php'); ?>
  <script>
      function showImage(param)
      {
        var modalImg = document.getElementById("modal-image");
        modalImg.src = param.src;
        $('#imagemodal').modal('show');
      }
</script>
</html>
