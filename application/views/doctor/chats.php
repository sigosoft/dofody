<?php $sess = $this->session->userdata('dof_user'); ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
<!DOCTYPE html>
<html>
<head>

  <meta charset='UTF-8'>
  <meta name="robots" content="noindex">
  <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700,300' rel='stylesheet' type='text/css'>
  <link rel='stylesheet prefetch' href='<?=base_url()?>assets/chat/reset.min.css'>
  <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.min.css'>
  <link rel="stylesheet" href="<?=base_url()?>assets/chat/chat.css">
</head>
<body>
<div id="frame">
	<div id="sidepanel">
		<div id="profile">
			<div class="wrap">
				<img id="profile-img" src="<?=$sess['profile']?>" class="online" alt="" />
				<p><?=$sess['user']?></p>
			</div>
		</div>
		<div id="search">
			<label for=""><i class="fa fa-search" aria-hidden="true"></i></label>
			<input type="text" placeholder="Search contacts..." />
		</div>
		<div id="contacts">
			<ul>
        <?php
          $i = 1;
          foreach ($chats as $chat) { ?>
            <li class="contact <?php if($i == 1){ $start = $chat->req_id; ?>active<?php } ?>" id="user<?=$chat->req_id?>">
    					<div class="wrap">
    						<span class="contact-status"></span>
                <?php if($chat->profile_photo == 'nil'){ ?>
                  <img src="<?=base_url()?>uploads/profile/user.png" alt="" />
                <?php }
                else { ?>
                  <img src="<?=base_url().$chat->profile_photo?>" alt="" />
                  <?php $image = base_url().$chat->profile_photo ?>
                <?php } ?>
    						<div class="meta">
    							<p class="name"><?=$chat->patient_name?></p>
    							<p class="preview"><?=$chat->present_problem?></p>
    						</div>
    					</div>
    				</li>
        <?php $i++;  }
        ?>

			</ul>
		</div>
	</div>
	<div class="content">
		<div class="contact-profile">
			<img id="user-image" src="">
			<p id="user-name"></p>
			<div class="social-media" style="padding-right : 20px;">
				<a href="<?=site_url('doctor/consult')?>"><p><img src="<?=base_url()?>dist/img/favicon.png" alt="Favicons"><span style="font-size:18px">Dofody.com</span></p></a>
			</div>
		</div>
		<div class="messages" id="message-div">
      <?php foreach ($chats as $chat) { ?>
        <ul id="ul-<?=$chat->req_id?>" class="message-ul"></ul>
      <?php } ?>
		</div>
		<div class="message-input">
			<div class="wrap">
			<input type="text" placeholder="Write your message..." />
			<i class="fa fa-paperclip attachment" aria-hidden="true"></i>
			<button class="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
			</div>
		</div>
	</div>
</div>
<script src='https://code.jquery.com/jquery-2.2.4.min.js'></script>
<script src="https://www.gstatic.com/firebasejs/5.5.7/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.5.7/firebase-messaging.js"></script>
<script >
var request;
$(".messages").animate({ scrollTop: $(document).height() + 10000 }, "fast");
$(function() {
  request = '<?=$start?>';
  ul_id = 'ul-'+request;
  $('ul[id^="ul-"]').hide();
  document.getElementById( ul_id ).style.display = 'block';
  var id = 'user'+request;
  var chat  = document.getElementById(id);
  var myimg = chat.getElementsByTagName('img')[0];
  var mysrc = myimg.src;

  var name = chat.getElementsByClassName('name')[0].innerHTML;
  document.getElementById('user-name').innerHTML = name;
  document.getElementById('user-image').src= mysrc;
  var i;
  var list;
  $.ajax({
      url: "<?=site_url('doctor/getMessages')?>",
      success: function (data) {
        var obj = JSON.parse(data);
        for (var key in obj) {
          var ele = obj[key];
          var ul_id = 'ul-'+key;
          var ul = document.getElementById(ul_id);
          for( i = 0; i < ele.length ; i++  )
          {
            if ( ele[i].user == '1' ) {
              list = $('<li class="replies"><p>' + ele[i].message + '<br><span class="li-span-message">' + ele[i].date + ' ' + ele[i].time +'</span></p></li>');
            }
            else {
              list = $('<li class="sent"><p>' + ele[i].message + '<br><span class="li-span-message">' + ele[i].date + ' ' + ele[i].time +'</span></p></li>');
            }
            list.appendTo(ul);
          }
        }
      }
    });
});
$("#profile-img").click(function() {
	$("#status-options").toggleClass("active");
});

$(".expand-button").click(function() {
  $("#profile").toggleClass("expanded");
	$("#contacts").toggleClass("expanded");
});

$("#status-options ul li").click(function() {
	$("#profile-img").removeClass();
	$("#status-online").removeClass("active");
	$("#status-away").removeClass("active");
	$("#status-busy").removeClass("active");
	$("#status-offline").removeClass("active");
	$(this).addClass("active");

	if($("#status-online").hasClass("active")) {
		$("#profile-img").addClass("online");
	} else if ($("#status-away").hasClass("active")) {
		$("#profile-img").addClass("away");
	} else if ($("#status-busy").hasClass("active")) {
		$("#profile-img").addClass("busy");
	} else if ($("#status-offline").hasClass("active")) {
		$("#profile-img").addClass("offline");
	} else {
		$("#profile-img").removeClass();
	};

	$("#status-options").removeClass("active");
});

function newMessage() {
	message = $(".message-input input").val();
	if($.trim(message) == '') {
		return false;
	}
  $.ajax({
      url: "<?=site_url('doctor/send_message')?>",
      type: 'POST',
      data : { request : request , message : message },
      success: function (data) {
          //$('#online_doctors').html(data);
      }
    });
	date = "<?php echo date('d/m/Y');?>";
	time = "<?php echo date('h:i a');?>";
    var list = $('<li class="sent"><p>' + message + '<br><span class="li-span-message">' + date + ' ' + time +'</span></p></li>');
    var ul_id = 'ul-'+request;
    var ul = document.getElementById(ul_id);
    list.appendTo(ul);
	$('.message-input input').val(null);
	$('.contact.active .preview').html('<span>You: </span>' + message);

	$(".messages").animate({ scrollTop: $(document).height() + 10000 }, "fast");

};

$('.submit').click(function() {
  newMessage();
});

$(window).on('keydown', function(e) {
  if (e.which == 13) {
    newMessage();
    return false;
  }
});
$("#contacts ul li").click(function() {
  var id = $(this).attr('id');
  var active = $('.active').attr('id');
  element = document.getElementById(active);
  element.classList.remove("active");
  var image = document.getElementById(id);
  image.classList.add("active");
  var myimg = image.getElementsByTagName('img')[0];
  var mysrc = myimg.src;

  var name = image.getElementsByClassName('name')[0].innerHTML;
  document.getElementById('user-name').innerHTML = name;
  document.getElementById('user-image').src= mysrc;

  request = id.substring(4);
  ul_id = 'ul-'+request;
  $('ul[id^="ul-"]').hide();
  document.getElementById( ul_id ).style.display = 'block';
  $(".messages").animate({ scrollTop: $(document).height() + 10000 }, "slow");
});

/*var checkMessages = function(){
  $.ajax({
      url: "<?=site_url('doctor/checkMessages')?>",
      success: function (data) {
        var obj = JSON.parse(data);
        for (var key in obj) {
          var ele = obj[key];
          var ul_id = 'ul-'+key;
          var ul = document.getElementById(ul_id);
          for( i = 0; i < ele.length ; i++  )
          {
            if ( ele[i].user == '1' ) {
              list = $('<li class="replies"><p>' + ele[i].message + '</p></li>');
            }
            else {
              list = $('<li class="sent"><p>' + ele[i].message + '</p></li>');
            }
            list.appendTo(ul);
            $(".messages").animate({ scrollTop: $(document).height() + 10000 }, "fast");
          }

        }
        setTimeout(checkMessages,2000);
      }
    });
}
setTimeout(checkMessages,5000);*/
</script>
<script>
  var config = {
    apiKey: "AIzaSyC4kyORLuill-AJ7C0cIpaGYBJhLsCFTA4",
    authDomain: "dofodys.firebaseapp.com",
    databaseURL: "https://dofodys.firebaseio.com",
    projectId: "dofodys",
    storageBucket: "dofodys.appspot.com",
    messagingSenderId: "388763301424"
  };
  firebase.initializeApp(config);

  const messaging = firebase.messaging();
  messaging.onMessage(function(payload){
        if(payload.data.type == 'chat')
        {
            var ul_id = 'ul-'+payload.data.request;
            var ul = document.getElementById(ul_id);
            list = $('<li class="replies"><p>' + payload.data.message + '<br><span class="li-span-message">' + payload.data.date + ' ' + payload.data.time +'</span></p></li>');
            list.appendTo(ul);
            $(".messages").animate({ scrollTop: $(document).height() + 10000 }, "fast");
        }
      });
</script>
</body>
</html>
