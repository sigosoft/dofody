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
          width: 80%;
        }
        .textarea-profile{
          border : 0;
          outline : 0;
          border-bottom: 1px dotted black;
          font-weight : normal;
          width : 80%;
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
                  <h4 class="page-title float-left">Add profile</h4>
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
                      <div class="col-7">
                        <form action="<?=site_url('patient/register_family_member')?>" method="post" enctype="multipart/form-data" onsubmit="return check();">
                        <p class="p-profile">Name &nbsp; <input type="text" class="input-profile" name="patient_name" required></p>
                        <p class="p-profile">Gender<div class="form-group">
                          <label class="radio-inline"><input type="radio" name="gender" value="m" checked="checked">  Male</label>
                          <label class="radio-inline"><input type="radio" name="gender" value="f">  Female</label>
                          <label class="radio-inline"><input type="radio" name="gender" value="o">  Others</label>
                        </div></p>
                        <p class="p-profile">Date of birth &nbsp; <input type="text" class="input-profile" name="dob" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask required></p>
                        <p class="p-profile">City &nbsp; <input type="text" class="input-profile" name="city" id="user_input_autocomplete_address" placeholder="Your location" required></p>
                        <p class="p-profile">Phone number &nbsp; <input type="text" name="patient_mobile" class="input-profile" id="mobile" name="mobile" maxlength="10" onblur="check_phone(this)" required></p>
                        <div id="phone-msg" style="color:red; display:none;"></div>
                        <p class="p-profile">Email address &nbsp; <input type="text" name="patient_email" id="email" class="input-profile" onblur="check_email(this);"></p>
                        <div id="email-msg" style="color:red; display:none;"></div>
                        <p class="p-profile">Height &nbsp; <input type="text" name="height" id="patientHeight" class="input-profile" placeholder="In centimetre" required></p>
                        <div id="height_err" style="color:red;"></div>
                        <p class="p-profile">Weight &nbsp; <input type="text" name="weight" id="patientWeight" class="input-profile" placeholder="In kilogram" required></p>
                        <div id="weight_err" style="color:red;"></div>
                        <p class="p-profile">Past medical conditions &nbsp; </p>
                        <p class="p-profile"><textarea class="textarea-profile" rows="3" cols="50" name="past_medical"></textarea></p>
                        <p class="p-profile">History of Surgeries/Allergies &nbsp; <textarea class="textarea-profile" rows="3" cols="50" name="history_surgery" required></textarea></p>
                        <p class="p-profile">Medicines taken now &nbsp; </p>
                        <p class="p-profile"><textarea class="textarea-profile" rows="3" cols="50" name="medicines_now"></textarea></p>
                        <button type="submit" class="btn btn-flat btn-primary">Save profile</button>


                      </div>
                      <div class="col-5">
                        <div class="" style="height:200px;width:200px;border:1px solid black;">
                          <img src="" id="profile-pic" width="200px" height="200px" alt="Please choose an image">
                        </div>
                        <p class="p-profile">Attach your photo <input type="file" class="input-profile" id="txtimage" name="txtimage" onchange="preview_image(event)"></p>

                      </div>
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
  function check()
  {
    var height = $('#patientHeight').val();
    var weight = $('#patientWeight').val();
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
