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
                  <h4 class="page-title float-left">Manage fee</h4>
                  <ol class="breadcrumb float-right">
                    <button type="button" class="btn btn-gradient btn-rounded waves-light waves-effect w-md" id="change">Change fee</button>
                  </ol>
                  <div class="clearfix"></div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
                <div class="card-box">
                  <div class="row">
                    <div class="col-4">
                      <div class="card" style="width: 18rem;height:14rem">
                        <div class="card-body">
                          <h5 class="card-title text-center">VIDEO CALL CHARGES</h5>
                          <h1 style="text-align:center;padding-top:40px;"><i class="fa fa-rupee"><?=$fee->video_fee?></i></h1>
                        </div>
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="card" style="width: 18rem;height:14rem">
                        <div class="card-body">
                          <h5 class="card-title text-center">AUDIO CALL CHARGES</h5>
                          <h1 style="text-align:center;padding-top:40px;"><i class="fa fa-rupee"><?=$fee->audio_fee?></i></h1>
                        </div>
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="card" style="width: 18rem;height:14rem">
                        <div class="card-body">
                          <h5 class="card-title text-center">CHAT CHARGES</h5>
                          <h1 style="text-align:center;padding-top:40px;"><i class="fa fa-rupee"><?=$fee->chat_fee?></i></h1>
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
    <div id="change-quick" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <h2 class="text-uppercase text-center m-b-30">
              <span><h4>Change fee</h4></span>
            </h2>
            <form class="form-horizontal" action="<?php echo site_url('doctor/doctor_fee');?>" onsubmit="return check_type();" method="post">
              <div class="form-group m-b-25">
                <div class="col-12">
                  <label for="select">Video call</label>
                  <input type="text" class="form-control" name="video_fee" id="video" value="<?=$fee->video_fee?>">
                </div>
              </div>
              <div class="form-group m-b-25">
                <div class="col-12">
                  <label for="select">Audio fee</label>
                  <input type="text" class="form-control" name="audio_fee" id="audio" value="<?=$fee->audio_fee?>">
                </div>
              </div>
              <div class="form-group m-b-25">
                <div class="col-12">
                  <label for="select">Chat fee</label>
                  <input type="text" class="form-control" name="chat_fee" id="chat" value="<?=$fee->chat_fee?>">
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
  </body>
  <?php include('scripts.php'); ?>
  <script>
    $('#change').on('click',function(){
      /*$.ajax({
          method: "POST",
          url: "<?php echo site_url('admin/getQuickFee');?>",
          dataType : "json",
          success : function( data ){
            $('#video_fee').val(data.video_fee);
            $('#chat_fee').val(data.chat_fee);
            $('#audio_fee').val(data.audio_fee);
            $('#change-quick').modal('show');
          }
        });*/
        $('#change-quick').modal('show');
    });
    function check_type()
    {
      var video = $('#video').val();
      var audio = $('#audio').val();
      var chat = $('#chat').val();
      if (isNaN(video) || isNaN(audio) || isNaN(chat)) {
        alert('Enter fee in numbers');
        return false;
      }
      else
      {
          return confirm('Confirm fee change?');
      }
    }
  </script>
</html>
