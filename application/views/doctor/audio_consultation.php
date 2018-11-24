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
                  <h4 class="page-title float-left">Audio consultation</h4>
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
                  <div class="row">
                    <div class="col-md-3">

                    </div>
                    <div class="col-md-6">
                      <div class="card" style="width: 100%;height:auto">
                        <div class="card-body text-center">
                          <img src="<?=base_url() . $pat->profile_photo?>" height="200px" width="200px" style="border-radius:50%">
                          <p style="font-size:25px;margin-bottom:3px;padding-top:10px;"><?=$pat->patient_name?></p>
                          <p style="font-size:16px;"><?=$pat->patient_email?></p>
                          <p id="duration" style="display:none;"></p>
                          <div id="call-div" style="display:none;">
                              <button type="button" class="btn btn-gradient btn-rounded waves-light waves-effect w-md" id="call">Call</button>
                          </div>
                          <p style="display:none;color:green;font-size:18px;"id="calling">Calling</p>
                          <div class="text-center" id="incall" style="display:none;">
                            <div id="show_time" style="font-size:18px;font-weight:bold"></div>
                            <p><button type="button" class="btn btn-link" id="disconnect"><i class="fa fa-phone-square" style="font-size:50px;color:red;"></i></button></p>
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
  </body>
  <?php include('scripts.php'); ?>
  <script type="text/javascript" src="<?=base_url()?>plugins/timer/easytimer.js"></script>
  <script type="text/javascript" src="https://media.twiliocdn.com/sdk/js/client/v1.3/twilio.min.js"></script>
  <script>
    var timer = new Timer();
    var doctor_device = '<?=$request?>';
    var patient_device = 'user'+'<?=$p_user;?>';
    Twilio.Device.setup('<?=json_decode($token,TRUE)?>');

    Twilio.Device.ready(function (device) {
      $("#call-div").css("display", "block");
      console.log('Twilio.Device Ready!');
    });
    Twilio.Device.connect(function (conn) {
      console.log('Successfully established call!');
      $('#calling').css("display","none");
      timer.start();
      $('#incall').css("display","block");
      timer.addEventListener('secondsUpdated', function (e) {
        $('#show_time').html(timer.getTimeValues().toString());
      });
    });

    Twilio.Device.disconnect(function (conn) {
      $('#incall').css("display","none");
      $('#call-div').css("display","block");
      $('#duration').css("display","block");
      timer.pause();
      var time = timer.getTimeValues().toString();
      $('#duration').text(time);
      $.ajax({
            method: "POST",
            url: "<?php echo site_url('doctor/updateTime');?>",
            data : { request_id : doctor_device , timer : time }
        });
      timer.reset();
      timer.stop();
      console.log('Call ended.');
    });
    $('#call').on('click',function(){
      $("#duration").css("display", "none");
      $("#call-div").css("display", "none");
      $("#calling").css("display", "block");
      $.ajax({
          method: "POST",
          url: "<?php echo site_url('doctor/addHistory');?>",
          dataType : "json",
          data : { request : doctor_device },
          success : function( data ){
            if(data){
                var params = {
                    To: patient_device,
                    From: doctor_device
                };
              Twilio.Device.connect(params);
            }
          }
        });
      
    });
    $('#disconnect').on('click',function(){
        Twilio.Device.disconnectAll();
      console.log('Disconnected');
    });
  </script>
</html>
