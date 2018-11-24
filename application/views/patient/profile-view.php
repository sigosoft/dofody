<!DOCTYPE html>
<html>
  <head>
    <?php include('includes.php'); ?>
    <style>
        .p-profile{
          font-size : 17px;
          font-weight : bold;
        }
        .input-profile {
          border : 0;
          outline : 0;
          border-bottom: 1px dotted black;
          font-weight : normal;
          width: 70%;
        }
        .textarea-profile{
          border : 0;
          outline : 0;
          border-bottom: 1px dotted black;
          font-weight : normal;
          width : 70%;
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
                  <h4 class="page-title float-left">Profile</h4>
                  <ol class="breadcrumb float-right">

                  </ol>
                  <div class="clearfix"></div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
                <div class="card-box">
                  <div class="form-group m-b-25">
                    <form action="<?=site_url('patient/select_profile')?>" method="post">
                    <div class="row">
                      <div class="col-md-5">
                        <select class="form-control" name="member">
                          <?php foreach ($members as $mem) { ?>
                            <option value="<?=$mem->patient_id?>"><?=$mem->patient_name?></option>
                          <?php } ?>
                        </select>
                      </div>
                      <div class="col-md-2">
                        <button type="submit" class="btn btn-flat btn-primary">View</button>
                      </div>
                    </div>
                  </form>
                  </div>

                  <div class="row">
                    <?php if ($param == 0) {
                      foreach ($members as $key) {
                          $member = $key;
                          break;
                      }
                    } ?>
                    <div class="col-md-7">

                    <form action="<?=site_url('patient/update_profile')?>" method="post" enctype="multipart/form-data" onsubmit="return check();">

                      <input type="hidden" name="patient_id" value="<?=$member->patient_id?>">

                      <p class="p-profile">Name &nbsp; <input type="text" class="input-profile" name="patient_name" id="name" value="<?=$member->patient_name?>" readonly required> <a href="#" id="name1" onclick="return make_editable(this)">Edit</a></p>
                      <p class="p-profile">Gender<div class="form-group">
                        <label class="radio-inline"><input type="radio" name="gender" value="m" <?php if($member->gender == 'm'){?> checked="checked" <?php } ?>>  Male</label>
                        <label class="radio-inline"><input type="radio" name="gender" value="f" <?php if($member->gender == 'f'){?> checked="checked" <?php } ?>>  Female</label>
                        <label class="radio-inline"><input type="radio" name="gender" value="o" <?php if($member->gender == 'o'){?> checked="checked" <?php } ?>>  Others</label>
                      </div></p>
                      
                      <?php if ($member->dob != '') { ?>
                        <p class="p-profile">Date of birth &nbsp; <input type="text" class="input-profile" name="dob" id="dob" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask value="<?=$member->dob?>" readonly> <a href="#" id="dob1" onclick="return make_editable(this)">Edit</a></p>
                      <?php } else { ?>
                        <p class="p-profile">Date of birth &nbsp; <input type="text" class="input-profile" name="dob" id="dob" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask value="<?=$member->dob?>"></p>
                      <?php } ?>
                        <p class="p-profile">City &nbsp; <input type="text" class="input-profile" name="city" id="user_input_autocomplete_address" placeholder="Your location" value="<?=$member->city?>" readonly required> <a href="#" id="user_input_autocomplete_address1" onclick="return make_editable(this)">Edit</a></p>
                        <!--<p class="p-profile">Phone number &nbsp; <input type="text" class="input-profile" name="patient_mobile" id="phone" value="<?=$member->patient_mobile?>" maxlength="10" onblur="check_phone(this)" required readonly> <a href="#" id="phone1" onclick="return make_editable(this)">Edit</a></p>
                        <div id="phone-msg" style="color:red; display:none;"></div>
                        <p class="p-profile">Email address &nbsp; <input type="text" class="input-profile" name="patient_email" id="email" value="<?=$member->patient_email?>" onblur="check_email(this);" readonly> <a href="#" id="email1" onclick="return make_editable(this)">Edit</a></p>
                        <div id="email-msg" style="color:red; display:none;"></div>-->
                      <?php if ($member->height != '') { ?>
                        <p class="p-profile">Height &nbsp; <input type="text" class="input-profile" name="height" id="height" value="<?=$member->height?>" readonly> <a href="#" id="height1" onclick="return make_editable(this)">Edit</a></p>
                        <div id="height_err" style="color:red;"></div>
                      <?php } else { ?>
                        <p class="p-profile">Height &nbsp; <input type="text" class="input-profile" name="height" id="height"></p>
                        <div id="height_err" style="color:red;"></div>
                      <?php } ?>

                      <?php if ($member->weight != '') { ?>
                        <p class="p-profile">Weight &nbsp; <input type="text" class="input-profile" name="weight" id="weight" value="<?=$member->weight?>" readonly> <a href="#" id="weight1" onclick="return make_editable(this)">Edit</a></p>
                        <div id="weight_err" style="color:red;"></div>
                      <?php } else { ?>
                        <p class="p-profile">Weight &nbsp; <input type="text" class="input-profile" name="weight" id="weight"></p>
                        <div id="weight_err" style="color:red;"></div>
                      <?php } ?>

                      <?php if ($member->past_medical != '') { ?>
                        <p class="p-profile">Past medical conditions &nbsp; </p>
                        <p class="p-profile"><textarea class="textarea-profile" name="past_medical" id="past_medical" rows="3" cols="50" readonly><?=$member->past_medical?></textarea><a href="#" id="past_medical1" onclick="return make_editable(this)">Edit</a></p>
                      <?php } else { ?>
                        <p class="p-profile">Past medical conditions &nbsp; </p>
                        <p class="p-profile"><textarea class="textarea-profile" name="past_medical" id="past_medical" rows="3" cols="50"></textarea></p>
                      <?php } ?>

                      <?php if ($member->history_surgery != '') { ?>
                        <p class="p-profile">History of surgeries &nbsp; <input type="text" class="input-profile" name="history_surgery" id="history_surgery" value="<?=$member->history_surgery?>" readonly> <a href="#" id="history_surgery1" onclick="return make_editable(this)">Edit</a></p>
                      <?php } else { ?>
                        <p class="p-profile">History of surgeries &nbsp; <input type="text" class="input-profile" name="history_surgery" id="history_surgery"></p>
                      <?php } ?>
                      <?php if ($member->medicines_now != '') { ?>
                        <p class="p-profile">Medicines taken now &nbsp; </p>
                        <p class="p-profile"><textarea class="textarea-profile" id="medicines_now" name="medicines_now" rows="3" cols="50" readonly><?=$member->medicines_now?></textarea><a href="#" id="medicines_now1" onclick="return make_editable(this)">Edit</a></p>
                      <?php } else { ?>
                        <p class="p-profile">Medicines taken now &nbsp; </p>
                        <p class="p-profile"><textarea class="textarea-profile" id="medicines_now" name="medicines_now" rows="3" cols="50"></textarea></p>
                      <?php } ?>




                    </div>
                    <div class="col-md-5">
                      <?php if ($member->profile_photo != 'nil') { ?>
                        <div id="profile-pic-div">
                          <img id="profile-pic" src="<?=base_url().$member->profile_photo?>" height="300" width="300">
                        </div>
                      <?php } ?>
                      <p class="p-profile">Change your photo <input type="file" class="input-profile" id="txtimage" name="txtimage" onchange="preview_image(event)"></p>

                    </div>
                    <button type="submit" class="btn btn-flat btn-primary">Update profile</button>
                    </form>
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
  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&amp;key=AIzaSyBBT9bze33SU8Vwdr_iPrDJZYxpQpGHY2k"></script>
  <script type="text/javascript" src="<?=base_url().'assets/js/autocomplete.js'?>"></script>
  <script src="<?php echo base_url();?>plugins/input-mask/jquery.inputmask.js"></script>
  <script src="<?php echo base_url();?>plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
  <script src="<?php echo base_url();?>plugins/input-mask/jquery.inputmask.extensions.js"></script>
  <script>
  
  $(function () {

    $('#datemask').inputmask('dd-mm-yyyy', { 'placeholder': 'dd-mm-yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

  });
  
  function preview_image(event)
  {
    var file = $("#txtimage")[0].files[0];
    if (file.size > 1000000) {
      alert('Please select an image with size < 1 mb.');
      document.getElementById("txtimage").value = "";
    }
    else {
      var val = file.type;
      var type = val.substr(val.indexOf("/") + 1);
      s_type = ['jpeg','jpg','png'];
      var flag = 0;
      for (var i = 0; i < s_type.length; i++) {
        if (s_type[i] == type) {
          flag = flag + 1;
        }
      }
      if (flag == 0) {
        alert('This file format is not supported.');
        document.getElementById("txtimage").value = "";
      }
      else {
        $("#profile-pic-div").css("display", "block");
          var reader = new FileReader();
          reader.onload = function()
          {
           var output = document.getElementById('profile-pic');
           output.src = reader.result;
          }
          reader.readAsDataURL(event.target.files[0]);
      }
    }
  }
  function make_editable(th)
  {
    var a_id = th.id;
    input_id = a_id.slice(0, -1);
    document.getElementById(input_id).removeAttribute('readonly');
    document.getElementById(input_id).focus();
    return false;
  }
  function check_email(em)
  {
    var email = $(em).val();
    if (email != '') {
      if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email))
      {
        $.ajax({
          method: "POST",
          url: "<?php echo site_url('patient/validate_email_address');?>",
          dataType : "text",
          data : { email : email },
          success : function( data ){
              if ( data == 'success' ) {
                $("#email-msg").css("display", "none");
                $("#email-msg").text('');
              }
              else {
                $("#email-msg").css("display", "block");
                $("#email-msg").text('Email already registered..!');
              }
            }
          });
      }
      else {
        $("#email-msg").css("display", "block");
        $("#email-msg").text('Invalid Email address');
      }
    }
  }
  function check_phone(mob)
  {
    var phone = $(mob).val();
    var len = phone.length;
    if (len != 10 && len !='') {
      $("#phone-msg").css("display", "block");
      $("#phone-msg").text('Invalid mobile number');
    }
    if (len == 10) {
      if (isNaN(phone)) {
        $("#phone-msg").css("display", "block");
        $("#phone-msg").text('Must be number');
      }
      else {
        $.ajax({
          method: "POST",
          url: "<?php echo site_url('patient/validate_mobile_number');?>",
          dataType : "text",
          data : { phone : phone },
          success : function( data ){
              if ( data == 'success' ) {
                $("#phone-msg").css("display", "none");
                $("#phone-msg").text('');
              }
              else {
                $("#phone-msg").css("display", "block");
                $("#phone-msg").text('Phone number already registered..!');
              }
            }
          });
      }
    }
  }
  function check()
  {
    var height = $('#height').val();
    var weight = $('#weight').val();
    if (isNaN(height)) {
      $('#height_err').text('Enter height in centimeter');
      return false;
    }
    if(isNaN(weight)) {
      $('#height_err').text('');
      $('#weight_err').text('Enter weight in kilogram');
      return false;
    }
    if (!isNaN(height) && !isNaN(weight)) {
      $('#height_err').text('');
      $('#weight_err').text('');
      if (height >220) {
        $('#height_err').text('Limit exceeded , please enter heigth less than 220cm');
        return false;
      }
      if (weight > 250) {
        $('#weight_err').text('Limit exceeded , please enter weight less than 250kg');
        return false;
      }
      return true;
    }
  }
  </script>
</html>
