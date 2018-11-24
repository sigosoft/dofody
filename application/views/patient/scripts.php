<script src="<?=base_url()?>assets/js/jquery.min.js"></script>
<script src="<?=base_url()?>assets/js/popper.min.js"></script>
<script src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
<script src="<?=base_url()?>assets/js/metisMenu.min.js"></script>
<script src="<?=base_url()?>assets/js/waves.js"></script>
<script src="<?=base_url()?>assets/js/jquery.slimscroll.js"></script>
<script src="<?=base_url()?>assets/js/jquery.core.js"></script>
<script src="<?=base_url()?>assets/js/jquery.app.js"></script>
<script type="text/javascript" src="<?=base_url()?>plugins/timer/easytimer.js"></script>
<script src="<?=base_url()?>plugins/sweet-alert/sweetalert.js"></script>
<link rel="manifest" href="<?=base_url()?>manifest.json">
<script src="https://www.gstatic.com/firebasejs/5.5.7/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.5.7/firebase-messaging.js"></script>
<script type="text/javascript" src="https://media.twiliocdn.com/sdk/js/client/v1.3/twilio.min.js"></script>
<script>
  /*var config = {
    apiKey: "AIzaSyC4kyORLuill-AJ7C0cIpaGYBJhLsCFTA4",
    authDomain: "dofodys.firebaseapp.com",
    databaseURL: "https://dofodys.firebaseio.com",
    projectId: "dofodys",
    storageBucket: "dofodys.appspot.com",
    messagingSenderId: "388763301424"
  };
  firebase.initializeApp(config);*/
  firebase.initializeApp({
    'messagingSenderId': '388763301424'
  });

  const messaging = firebase.messaging();
  messaging.onMessage(function(payload){
        console.log('Message arrived..!', payload.data );
        if(payload.data.type == 'call')
        {
            swal({
                title: "Doctor is calling",
                text: "You will not be able to recover this imaginary file!",
                type: "success",
                showCancelButton: true,
                allowOutsideClick: true,
                
                confirmButtonClass: "btn-success",
                confirmButtonText: "Connect doctor",
                cancelButtonText: "Disconnect",
                closeOnConfirm: false,
                closeOnCancel: false
              },
              function(isConfirm) {
                if (isConfirm) {
                  var url;
                  url = "<?=site_url('video/talk_to_doctor/')?>";
                  url = url + payload.data.request ;
                  window.location.href = url;
                  swal.close();
                } else {
                  swal.close();
                }
              });
        }
      });
</script>
<script>
  var timer = new Timer();
  var request_id;
  Twilio.Device.setup('<?=json_decode($token,TRUE)?>');
  Twilio.Device.error(function (error) {
    console.log('Twilio.Device Error: ' + error.message);
  });
  Twilio.Device.ready(function (device) {
    console.log('Twilio.Device Ready!');
  });
  Twilio.Device.connect(function (conn) {
    console.log('Successfully established call!');
  });

  Twilio.Device.disconnect(function (conn) {
    var time = timer.getTimeValues().toString();
    $.ajax({
            method: "POST",
            url: "<?php echo site_url('patient/updateTime');?>",
            data : { request_id : request_id , time : time }
        });
  });
  Twilio.Device.incoming(function (conn) {
      console.log('This is testing');
      request_id = conn.parameters.From;
      console.log(request_id);
      $.ajax({
        method: "POST",
        url: "<?php echo site_url('patient/getCallingDoctor');?>",
        dataType : "json",
        data : { request_id : request_id },
        success: function(obj){
          $('#doc-image').attr("src",obj.document);
          $('#doc_name').text(obj.name);
          $('#doc_degree').text(obj.stream);
          $('#doc_special').text(obj.special);
          $('#audio-call').modal('show');
        }
      });
      $('#call-accept').on('click',function(){
        $.ajax({
            method: "POST",
            url: "<?php echo site_url('patient/updateHistory');?>",
            data : { request_id : request_id }
        });
        conn.accept()
        $('#call-button').css("display","none");
        timer.start()
        $('#incall').css("display","block");
        timer.addEventListener('secondsUpdated', function (e) {
            $('#show_time').html(timer.getTimeValues().toString());
        });
      });
      $('#call-reject').on('click',function(){
        conn.reject();
        $('#incall').css("display","none");
        $('#call-button').css("display","none");
        $('#call-rejected').css("display","block");
        $('#close-button').css("display","block");
      });
      $('#disconnect').on('click',function(){
        Twilio.Device.disconnectAll();
        timer.pause();
        $('#incall').css("display","none");
        $('#call-ended').css("display","block");
        $('#duration').text(timer.getTimeValues().toString());
        $('#close-button').css("display","block");
      });
  });
</script>
