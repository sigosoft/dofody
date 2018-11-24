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
                  <h4 class="page-title float-left">General settings</h4>
                  <ol class="breadcrumb float-right">
                  </ol>
                  <div class="clearfix"></div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
                <div class="card-box table-responsive">
                  <form action="<?=site_url('doctor/general_name_change')?>" method="post">
                  <div id="general-name-edit" style="display : none; background-color :#FCFCFC ;">
                    <div class="container">
                      <div class="row">
                        <div class="col-md-4 order-first order-md-4">
                          <label>Name</label>
                          <div class="form-group">
                            <input type="text" class="form-control" name="name" value="<?=$details->name?>">
                          </div>
                          <button type="submit" class="btn btn-gradient btn-rounded waves-light waves-effect w-sm pull-right">Save</button>
                          <a href="#" onclick="return changeName(1)" class="btn btn-gradient btn-rounded waves-light waves-effect w-sm pull-right" style="margin-right : 5px;">Cancel</a>
                        </div>
                      </div>
                    </div>

                  </div>
                  </form>
                  <div id="general-name">
                  <div class="row">

                      <div class="col-md-4 col-xs-4">
                        <p style="font-weight : bold;font-size : 14px;">Name </p>
                      </div>
                      <div class="col-md-4 col-xs-4">
                        <p style="font-size : 14px; color : #209AE0;"><?=$details->name?></p>
                      </div>
                      <div class="col-md-4 col-xs-4">
                        <p><a href="#" onclick="return changeName(0)">Edit</a></p>
                      </div>
                    </div>
                  </div>
                  <div class="clearfix">

                  </div>
                  <hr style="margin-top:3px;margin-bottom:7px;">
                  <div id="general-email">
                    <div class="row">
                      <div class="col-md-4">
                        <p style="font-weight : bold;font-size : 14px;">Email </p>
                      </div>
                      <div class="col-md-4">
                        <p style="font-size : 14px; color : #209AE0;"><?=$details->email?></p>
                      </div>
                      <div class="col-md-4">
                        <p><a href="#" onclick="return changeEmail(0)">Edit</a></p>
                      </div>
                    </div>
                  </div>
                  <form action="<?=site_url('doctor/general_name_change')?>" method="post" onsubmit="return checkEmailFormat();">
                  <div id="general-email-edit" style="display : none;background-color :#FCFCFC ;">
                    <div class="container">
                      <div class="row">
                        <div class="col-md-4 col-md-push-4">
                          <label>Email</label>


                          <div class="form-group">
                            <input type="text" class="form-control" name="email" id="email" value="<?=$details->email?>" required>
                          </div>
                          <div id="em_err" style="display : none;color : red;"></div>
                          <button type="submit" class="btn btn-gradient btn-rounded waves-light waves-effect w-sm pull-right">Save</button>
                          <a href="#" onclick="return changeEmail(1)" class="btn btn-gradient btn-rounded waves-light waves-effect w-sm pull-right" style="margin-right : 5px;">Cancel</a>
                        </div>

                      </div>
                    </div>
                  </div>
                  </form>
                  <hr style="margin-top:3px;margin-bottom:7px;">
                  <div id="general-phone">
                    <div class="row">
                      <div class="col-md-4">
                        <p style="font-weight : bold;font-size : 14px;">Contact </p>
                      </div>
                      <div class="col-md-4">
                        <p style="font-size : 14px;color : #209AE0;"><?=$details->mobile?></p>
                      </div>
                      <div class="col-md-4">
                        <p><a href="#" onclick="return changePhone(0)">Edit</a></p>
                      </div>
                    </div>
                  </div>
                <form action="<?=site_url('doctor/general_name_change')?>" method="post" onsubmit="return checkOtp();">
                  <div id="general-phone-edit" style="display : none; background-color :#F2F3F3 ;">
                    <div class="row">
                      <div class="col-md-4 col-md-push-4">
                        <label>Mobile</label>
                        <div class="form-group">
                          <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Enter your number" maxlength="10">
                        </div>
                        <div id="ph_err" style="display:none; color:red;"></div>
                        <div id="otpLoading"><center><img src="<?php echo base_url();?>dist/img/loading3.gif" alt="processing..." style="display:none; height:20px; width:auto;" id="load" /></center></div>
                        <div id="otpButton">
                          <a id="getOtp" class="btn btn-gradient btn-rounded waves-light waves-effect w-sm pull-right">Get OTP</a>
                          <a id="cancelOtp" href="#" onclick="return changePhone(1)" class="btn btn-gradient btn-rounded waves-light waves-effect w-sm pull-right" style="margin-right : 5px;">Cancel</a>
                        </div>
                        <div id="otpSave" style="display:none;">
                          <div class="form-group">
                            <input type="text" class="form-control" id="otpUser" placeholder="Enter OTP">
                          </div>
                          <div id="otpError" style="display : none;color : red;">Wrong or Expired OTP</div>
                          <button type="submit" class="btn btn-gradient btn-rounded waves-light waves-effect w-sm pull-right">Save</button>
                          <a href="#" onclick="return changePhone(1)" class="btn btn-gradient btn-rounded waves-light waves-effect w-sm pull-right" style="margin-right : 5px;">Cancel</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
                <hr style="margin-top:3px;margin-bottom:7px;">

                <div id="general-hometown">
                  <div class="row">
                    <div class="col-md-4">
                      <p style="font-weight : bold;font-size : 14px;">Hometown</p>
                    </div>
                    <div class="col-md-4">
                      <p style="font-size : 14px;color : #209AE0;"><?=$details->place?></p>
                    </div>
                    <div class="col-md-4">
                      <p><a href="#" onclick="return changePlace(0)">Edit</a></p>
                    </div>
                  </div>
                </div>
                <form action="<?=site_url('doctor/general_name_change')?>" method="post">
                <div id="general-hometown-edit" style="display : none; background-color :#F2F3F3 ;">
                  <div class="row">


                    <div class="col-md-4 col-md-push-4">
                      <label>Hometown</label>
                      <div class="form-group">
                        <input type="text" class="form-control" id="user_input_autocomplete_address" name="place" value="<?=$details->place?>">
                      </div>
                      <button type="submit" class="btn btn-gradient btn-rounded waves-light waves-effect w-sm pull-right">Save</button>
                      <a href="#" onclick="return changePlace(1)" class="btn btn-gradient btn-rounded waves-light waves-effect w-sm pull-right" style="margin-right : 5px;">Cancel</a>
                    </div>


                  </div>
                </div>
                </form>
                <div class="clearfix"></div>
                <hr style="margin-top:3px;margin-bottom:7px;">

                <!-- Change password -->
                <div id="general-password">
                  <div class="row">
                    <div class="col-md-4">
                      <p style="font-weight : bold;font-size : 14px;">Change your password</p>
                    </div>
                    <div class="col-md-4 col-md-push-4">
                      <p><a href="#" onclick="return changePassword(0)">Change</a></p>
                    </div>
                  </div>
                </div>

                  <div id="general-password-edit" style="display : none; background-color :#F2F3F3 ; padding-top : 5px;">
                    <div class="container">
                      <div class="row">
                        <div class="col-md-4 col-md-push-4">
                            <label>Current password</label>
                            <div class="form-group">
                              <input type="text" class="form-control" name="current_pass" id="current_pass" required>
                            </div>
                            <label>New password</label>
                            <div class="form-group">
                              <input type="text" class="form-control" name="password" id="ps1" required>
                            </div>
                            <label>Confirm password</label>
                            <div class="form-group">
                              <input type="text" class="form-control" id="ps2" required>
                            </div>
                            <div id="passError" style="display : none;color : red;">Password mismatch..!</div>
                            <button type="button" class="btn btn-gradient btn-rounded waves-light waves-effect w-sm pull-right" onclick="check_password();">Save</button>
                            <a href="#" onclick="return changePassword(1)" class="btn btn-gradient btn-rounded waves-light waves-effect w-sm pull-right" style="margin-right : 5px;">Cancel</a>

                        </div>
                      </div>
                    </div>
                  </div>

                <div class="clearfix"></div>
                <hr style="margin-top:3px;margin-bottom:7px;">

                <!-- DELETE ACCOUNT AND WIPE ALL DATA -->
                <div id="delete-account">
                  <div class="row">
                    <div class="col-md-4">
                      <p style="font-weight : bold;font-size : 14px;">Delete account and wipe all data</p>
                    </div>
                    <div class="col-md-4 col-md-push-4">
                      <p><a href="#" onclick="return changeDelete(0)">Delete</a></p>
                    </div>
                  </div>
                </div>
                <div id="delete-account-edit" style="display : none; background-color :#F2F3F3 ; padding-top : 5px;">
                  <form action="<?=site_url('doctor/delete_req')?>" method="post">
                  <div class="row">
                    <div class="col-md-4 col-md-push-4">
                        <label>Enter your password</label>
                        <div class="form-group">
                          <input type="password" class="form-control" name="password" id="delete_pass" required>
                        </div>
                        <div class="form-group">
                          <label>Reason for deleting</label>
                          <textarea name="reason" class="form-control" rows="3"></textarea>
                        </div>
                        <div id="p_error" style="display : none;color : red;">Incorrect password</div>
                        <button type="submit" class="btn btn-gradient btn-rounded waves-light waves-effect w-sm pull-right" >Confirm delete</button>
                        <a href="#" onclick="return changeDelete(1)" class="btn btn-gradient btn-rounded waves-light waves-effect w-sm pull-right" style="margin-right : 5px;">Cancel</a>

                    </div>
                  </div>
                  </form>
                </div>
                <div class="clearfix"></div>
                <hr style="margin-top:3px;margin-bottom:7px;">

                </div>
            </div>
          </div>
        </div>
      </div>
      <?php include('footer.php');?>
    </div>
    <div class="modal fade" id="change_pass" role="dialog">
      <div class="modal-dialog modal-sm">

        <!-- Modal content-->
        <div class="modal-content">

          <div class="modal-body">
            <p>Are you sure?</p>
            <form action="<?=site_url("doctor/generalChangePassword");?>" method="post">
                <input type="hidden" name="password" id="passkey">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-gradient btn-rounded waves-light waves-effect w-sm pull-right" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-gradient btn-rounded waves-light waves-effect w-sm pull-right">Change password</button>
          </div>
        </form>
        </div>

      </div>
    </div>
  </body>
  <?php include('scripts.php'); ?>
  <script type="text/javascript" src="<?=base_url().'assets/js/autocomplete.js'?>"></script>
  <script>
  var otp='';
    function changeName(param)
    {
      if (param == 0) {
        $('#general-name').css('display','none');
        $('#general-name-edit').css('display','block');

        $('#general-hometown').css('display','block');
        $('#general-hometown-edit').css('display','none');
        $('#general-email').css('display','block');
        $('#general-email-edit').css('display','none');
        $('#general-phone').css('display','block');
        $('#general-phone-edit').css('display','none');
        $('#general-password').css('display','block');
        $('#general-password-edit').css('display','none');
        $('#delete-account').css('display','block');
        $('#delete-account-edit').css('display','none');
      }
      else {
        $('#general-name').css('display','block');
        $('#general-name-edit').css('display','none');
      }
      return false;
    }
    function changeEmail(param)
    {
      if (param == 0) {
        $('#general-email').css('display','none');
        $('#general-email-edit').css('display','block');

        $('#general-hometown').css('display','block');
        $('#general-hometown-edit').css('display','none');
        $('#general-name').css('display','block');
        $('#general-name-edit').css('display','none');
        $('#general-phone').css('display','block');
        $('#general-phone-edit').css('display','none');
        $('#general-password').css('display','block');
        $('#general-password-edit').css('display','none');
        $('#delete-account').css('display','block');
        $('#delete-account-edit').css('display','none');
      }
      else {
        $('#general-email').css('display','block');
        $('#general-email-edit').css('display','none');
      }
      return false;
    }
    function changePhone(param)
    {
      if (param == 0) {
        $('#general-phone').css('display','none');
        $('#general-phone-edit').css('display','block');

        $('#general-hometown').css('display','block');
        $('#general-hometown-edit').css('display','none');
        $('#general-email').css('display','block');
        $('#general-email-edit').css('display','none');
        $('#general-name').css('display','block');
        $('#general-name-edit').css('display','none');
        $('#general-password').css('display','block');
        $('#general-password-edit').css('display','none');
        $('#delete-account').css('display','block');
        $('#delete-account-edit').css('display','none');
      }
      else {
        $('#mobile').val("");
        $('#mobile').attr('readonly', false);
        $('#general-phone').css('display','block');
        $('#general-phone-edit').css('display','none');
      }
      return false;
    }
    function changePlace(param)
    {
      if (param == 0) {
        $('#general-hometown').css('display','none');
        $('#general-hometown-edit').css('display','block');

        $('#general-name').css('display','block');
        $('#general-name-edit').css('display','none');
        $('#general-email').css('display','block');
        $('#general-email-edit').css('display','none');
        $('#general-phone').css('display','block');
        $('#general-phone-edit').css('display','none');
        $('#general-password').css('display','block');
        $('#general-password-edit').css('display','none');
        $('#delete-account').css('display','block');
        $('#delete-account-edit').css('display','none');
      }
      else {
        $('#general-hometown').css('display','block');
        $('#general-hometown-edit').css('display','none');
      }
      return false;
    }
    function changePassword(param)
    {
      if (param == 0) {
        $('#general-password').css('display','none');
        $('#general-password-edit').css('display','block');

        $('#general-hometown').css('display','block');
        $('#general-hometown-edit').css('display','none');
        $('#general-name').css('display','block');
        $('#general-name-edit').css('display','none');
        $('#general-email').css('display','block');
        $('#general-email-edit').css('display','none');
        $('#general-phone').css('display','block');
        $('#general-phone-edit').css('display','none');
        $('#delete-account').css('display','block');
        $('#delete-account-edit').css('display','none');
      }
      else {
        $('#general-password').css('display','block');
        $('#general-password-edit').css('display','none');
      }
      return false;
    }
    function changeDelete(param)
    {
      if (param == 0) {
        $('#delete-account').css('display','none');
        $('#delete-account-edit').css('display','block');

        $('#general-password').css('display','block');
        $('#general-password-edit').css('display','none');
        $('#general-hometown').css('display','block');
        $('#general-hometown-edit').css('display','none');
        $('#general-name').css('display','block');
        $('#general-name-edit').css('display','none');
        $('#general-email').css('display','block');
        $('#general-email-edit').css('display','none');
        $('#general-phone').css('display','block');
        $('#general-phone-edit').css('display','none');
      }
      else {
        $('#delete-account').css('display','block');
        $('#delete-account-edit').css('display','none');
      }
      return false;
    }
    function checkEmailFormat()
    {
      var email = $('#email').val();
      if (email == '') {
        return false;
      }
      else {
          if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email))
          {
            $('#em_err').css('display','none');
            return true;
          }
          else {
            $('#em_err').css('display','block');
            $('#em_err').text('Invalid Email adrress');
            return false;
          }
      }
    }
    $('#getOtp').click(function(){
      var mobile = $('#mobile').val();
      var len = mobile.length;
      if (mobile == '') {
        $('#ph_err').css('display','block');
        $('#ph_err').text('Invalid Mobile number');
      }
      else {
        if (len != 10) {
          $('#ph_err').css('display','block');
          $('#ph_err').text('Invalid Mobile number');
        }
        else {
          if (isNaN(mobile)) {
            $('#ph_err').css('display','block');
            $('#ph_err').text('Invalid Mobile number');
          }
          else {
            $('#mobile').attr('readonly', true);
            $('#load').show();
            $('#getOtp').attr('disabled', true);
            $('#cancelOtp').attr('disabled', true);
            $.ajax({
              method: "POST",
              url: "<?php echo site_url('doctor/generalMobileChange');?>",
              dataType : "text",
              data : { mobile : mobile },
              success : function( data ){
                  if (data == '1') {
                    $('#ph_err').css('display','block');
                    $('#ph_err').text('Mobile number already registered..!');

                    $('#getOtp').attr('disabled', false);
                    $('#cancelOtp').attr('disabled', false);
                    $('#mobile').attr('readonly', false);
                  }
                  else if( data == 'failed'){
                    $('#ph_err').css('display','block');
                    $('#ph_err').text('We are experiencing some problem , Please try agian later.');
                    $('#mobile').attr('readonly', false);
                  }
                  else {
                    otp = data;
                    alert(otp);
                    $('#otpLoading').css('display','none');
                    $('#otpButton').css('display','none');
                    $('#otpSave').css('display','block');

                  }
                }
              });
            }
        }
      }
    });
    function checkOtp()
    {
      var userOtp = $('#otpUser').val();
      if (otp == userOtp) {
        $('#otpError').css('display','none');
        return true;
      }
      else {
        $('#otpError').css('display','block');
        return false;
      }
    }
    function check_password()
    {
      var pass1 = $('#ps1').val();
      var pass2 = $('#ps2').val();
      if (pass1 == pass2) {
        var cur_pass = $('#current_pass').val();
        $('#passError').css('display','none');
        $.ajax({
          method: "POST",
          url: "<?php echo site_url('doctor/generalPasswordChange');?>",
          dataType : "text",
          data : { cur_pass : cur_pass , pass : pass1 },
          success : function( data ){
              if (data) {
                $('#passkey').val(pass1);
                $('#change_pass').modal('show');
              }
              else {
                $('#passError').css('display','block');
                $('#passError').text('Please try again later..!');
              }
            }
          });
      }
      else {
        $('#passError').css('display','block');
        $('#passError').text('Password mismatch..!');
      }
    }
    function confirmDelete()
    {
        var cur_pass = $('#delete_pass').val();
        $('#passError').css('display','none');
        $.ajax({
          method: "POST",
          url: "<?php echo site_url('doctor/generalPasswordChange');?>",
          dataType : "text",
          data : { cur_pass : cur_pass },
          success : function( data ){
              if (data) {
                alert('ok');
              }
              else {
                alert('password error');
              }
            }
          });
          //alert(cur_pass);
    }
  </script>
</html>
