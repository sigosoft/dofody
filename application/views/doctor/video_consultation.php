<!DOCTYPE html>
<html>
  <head>
    <?php include('includes.php'); ?>
    <style>
      .remote{
        min-height : 400px;
        border:1px solid black;
      }
      .local{
          margin-top:20px;
      }
      div#local video {
          max-width: 100%;
          max-height: 100%;
          border: none;
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
                  <h4 class="page-title float-left">Video consultation</h4>
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
                  <div class="row">
                    <div class="col-md-12">
                      <div class="col-md-4">
                        <div class="remote" id="remote">

                        </div>
                      </div>
                      <div class="col-md-4">
                          <div class="local" id="local"></div>
                      </div>
                    </div>
                    <div class="col-md-12" style="margin-top : 20px;">
                      <div class="col-md-4 col-md-push-4 text-center">
                        <p id="duration" style="display:none;"></p>
                        <div id="join-div">
                            <button type="button" class="btn btn-gradient btn-rounded waves-light waves-effect w-md" id="join-room">Call</button>
                        </div>
                        <!--<button type="button" id="leave-room" class="btn btn-danger">Disconnect</button>-->
                        <p style="display:none;color:green;font-size:18px;"id="calling">Calling...</p>
                          <div class="text-center" id="incall" style="display:none;">
                            <div id="show_time" style="font-size:18px;font-weight:bold"></div>
                            <p><button type="button" class="btn btn-link" id="leave-room"><i class="fa fa-phone-square" style="font-size:50px;color:red;"></i></button></p>
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
  <script src="//media.twiliocdn.com/sdk/js/video/v1/twilio-video.min.js"></script>
  <script>
    var activeRoom;
    var previewTracks;
    var identity;
    var roomName;
    var timer = new Timer();
    function attachTracks(tracks, container) {
      tracks.forEach(function(track) {
        container.appendChild(track.attach());
      });
    }

    function attachParticipantTracks(participant, container) {
      var tracks = Array.from(participant.tracks.values());
      attachTracks(tracks, container);
    }

    function detachTracks(tracks) {
      tracks.forEach(function(track) {
        track.detach().forEach(function(detachedElement) {
          detachedElement.remove();
        });
      });
    }

    function detachParticipantTracks(participant) {
      var tracks = Array.from(participant.tracks.values());
      detachTracks(tracks);
    }
    identity = '<?=$identity?>';
    request = '<?=$request?>';
    user_id = '<?=$p_user?>';
    $('#join-room').on('click',function(){
      $.ajax({
        method: "POST",
        url: "<?php echo site_url('doctor/sendNotification');?>",
        data : { request : request , user_id : user_id }
      });
      $("#duration").css("display", "none");
      $("#join-room").css("display", "none");
      $("#calling").css("display", "block");
      $.ajax({
          method: "POST",
          url: "<?php echo site_url('doctor/addHistory');?>",
          dataType : "json",
          data : { request : request },
          success : function( data ){
            if(data){
                 roomName = "<?=$roomName?>";
                  var connectOptions = {
                    name: roomName,
                    logLevel: 'debug'
                  };
                  Twilio.Video.connect("<?=$token?>", connectOptions).then(roomJoined, function(error) {
                    log('Could not connect to Twilio: ' + error.message);
                  });
            }
          }
        });
     
      
      
      //---------------------//
      var localTracksPromise = previewTracks
      ? Promise.resolve(previewTracks)
      : Twilio.Video.createLocalTracks();

    localTracksPromise.then(function(tracks) {
      window.previewTracks = previewTracks = tracks;
      var previewContainer = document.getElementById('local');
      if (!previewContainer.querySelector('video')) {
        attachTracks(tracks, previewContainer);
      }
    }, function(error) {
      console.error('Unable to access local media', error);
      log('Unable to access Camera and Microphone');
    });
    //-------------------------//
      
      
    });
    $('#leave-room').on('click',function(){
        $('#incall').css("display","none");
          $('#join-room').css("display","block");
          $('#duration').css("display","block");
          timer.pause();
          var time = timer.getTimeValues().toString();
          $('#duration').text(time);
          $.ajax({
                method: "POST",
                url: "<?php echo site_url('doctor/updateTime');?>",
                data : { request_id : request , timer : time }
            });
          timer.reset();
          timer.stop();
      activeRoom.disconnect();
    });

    function roomJoined(room) {
      window.room = activeRoom = room;
      room.participants.forEach(function(participant) {
        var previewContainer = document.getElementById('remote');
        attachParticipantTracks(participant, previewContainer);
      });
      room.on('participantConnected', function(participant) {
          $('#calling').css("display","none");
          timer.start();
          $('#incall').css("display","block");
          timer.addEventListener('secondsUpdated', function (e) {
            $('#show_time').html(timer.getTimeValues().toString());
          });
      });
      room.on('trackAdded', function(track, participant) {
        var previewContainer = document.getElementById('remote');
        attachTracks([track], previewContainer);
      });
      room.on('trackRemoved', function(track, participant) {
        detachTracks([track]);
      });
      room.on('participantDisconnected', function(participant) {
          detachParticipantTracks(participant);
          $('#incall').css("display","none");
          $('#join-room').css("display","block");
          $('#duration').css("display","block");
          timer.pause();
          var time = timer.getTimeValues().toString();
          $('#duration').text(time);
          $.ajax({
                method: "POST",
                url: "<?php echo site_url('doctor/updateTime');?>",
                data : { request_id : request , timer : time }
            });
          timer.reset();
          timer.stop();
      });
      room.on('disconnected', function() {
        if (previewTracks) {
          previewTracks.forEach(function(track) {
            track.stop();
          });
        }
        detachParticipantTracks(room.localParticipant);
        room.participants.forEach(detachParticipantTracks);
        activeRoom = null;
      });
    }
    function leaveRoomIfJoined() {
      if (activeRoom) {
        activeRoom.disconnect();
      }
    }
  </script>
</html>
