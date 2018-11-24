<!DOCTYPE html>
<html>
<head>
  <?php $user_data = $this->session->userdata('data'); ?>
  <meta charset="utf-8" />
  <title>Dofody</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <meta content="#" name="description" />
  <meta content="Sigosoft" name="author" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />

  <!-- App favicon -->
  <link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>assets/images/logo_sm.png">

  <!-- App css -->
  <link href="<?=base_url()?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="<?=base_url()?>assets/css/icons.css" rel="stylesheet" type="text/css" />
  <link href="<?=base_url()?>assets/css/style.css" rel="stylesheet" type="text/css" />

  <script src="<?=base_url()?>assets/js/modernizr.min.js"></script>

</head>
    <body class="bg-accpunt-pages">
        <!-- HOME -->
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">

                        <div class="wrapper-page">

                            <div class="account-pages">
                                <div class="account-box">
                                    <div class="account-logo-box">
                                        <h2 class="text-uppercase text-center">
                                            <a href="index-2.html" class="text-success">
                                                <span><img src="<?=base_url()?>assets/images/logo-blue.png" alt="" height="40"></span>
                                            </a>
                                        </h2>
                                        <h6 class="text-uppercase text-center font-bold mt-4">Degree certificate</h6>
                                    </div>
                                    <div class="account-content scroll">
                                        <form action="<?php echo site_url('register_doctor/degree_cert');?>" method="post" enctype="multipart/form-data"  onsubmit="return check()">

                                            <div class="form-group row m-b-20">
                                                <div class="col-12">
                                                  <label></label>
                                                  <select class="form-control selectpicker" id="stream" name="stream" onchange="get_special(this);" required>
                                                    <option value="">--Select--</option>
                                                    <?php foreach ($stream as $str) { ?>
                                                      <option value="<?=$str->stream_id?>"><?=$str->stream_name?></option>
                                                    <?php } ?>
                                                  </select>
                                                </div>
                                            </div>
                                            <div class="form-group row text-center m-t-10">
                                                <div class="col-12">
                                                  <input type="text" class="form-control bttn-radius" placeholder="College" name="college_deg" required>
                                                </div>
                                            </div>
                                            <div class="form-group row text-center m-t-10">
                                                <div class="col-12">
                                                  <input type="text" class="form-control bttn-radius" placeholder="University" name="university_deg" required>
                                                </div>
                                            </div>
                                            <div class="form-group row text-center m-t-10">
                                                <div class="col-12">
                                                  <input type="text" class="form-control bttn-radius" placeholder="Year of passing" name="mark_deg" required>
                                                </div>
                                            </div>
                                            <div class="form-group row text-center m-t-10">
                                                <div class="col-12">
                                                    <input type="file" class="form-control bttn-radius" name="grad_file" id="grad_file" onchange="preview_image(this)" required>
                                                </div>
                                            </div>
                                            <div id="degree-image"><img class="img-fluid" id="output_g" height="340px;" width="350px;"/></div>
                                            <div id="sp_view" style="display:none;">
                                                  <div id="more_special"></div>
                                                  <div id="display_less">
                                                    <p><a href="#" onclick="return attach_special();">ATTACH POST GRADUATION</a></p>
                                                  </div>
                                            </div>
                                            <div class="form-group row text-center m-t-10">
                                                <div class="col-12">
                                                    <button class="btn btn-block btn-gradient waves-effect waves-light" type="submit">Submit</button>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- end card-box-->


                        </div>
                        <!-- end wrapper -->

                    </div>
                </div>
            </div>
        </section>
        <!-- END HOME -->


        <!-- jQuery  -->
        <script src="<?=base_url()?>assets/js/jquery.min.js"></script>
        <script src="<?=base_url()?>assets/js/popper.min.js"></script>
        <script src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
        <script src="<?=base_url()?>assets/js/waves.js"></script>
        <script src="<?=base_url()?>assets/js/jquery.slimscroll.js"></script>

        <!-- App js -->
        <script src="<?=base_url()?>assets/js/jquery.core.js"></script>
        <script src="<?=base_url()?>assets/js/jquery.app.js"></script>
        <script>
          var num=0;
          var num1=100;

          function empty_div(val)
          {
            file_id = 'file'+val;
            document.getElementById(file_id).innerHTML = "";
          }
          function display_more()
          {
            $("#display_more").css("display", "block");
            $("#display_less").css("display", "none");
          }
          function preview_image(id)
          {
            var id = id.id;
            var x = document.getElementById(id);
            var size = x.files[0].size;
            if (size > 5000000) {
              alert('Please select an image with size less than 5 mb.');
              document.getElementById(id).value = "";
            }
            else {
              var val = x.files[0].type;
              var type = val.substr(val.indexOf("/") + 1);
              s_type = ['jpeg','jpg','png','pdf'];
              var flag = 0;
              for (var i = 0; i < s_type.length; i++) {
                if (s_type[i] == type) {
                  flag = flag + 1;
                }
              }
              if (flag == 0) {
                alert('This file format is not supported.');
                document.getElementById(id).value = "";
              }
              else {
                if (type != 'pdf') {
                  $('#degree-image').css('display','block');
                  var reader = new FileReader();
                  reader.onload = function()
                  {
                    if (id == 'grad_file') {
                      var output = document.getElementById('output_g');
                    }
                    else if (id == 'pg_file') {
                      var output = document.getElementById('output_pg');
                    }
                    else{
                    	var img_id = 'img' + id.substr(1);
                    	var output = document.getElementById(img_id);
                    }

                   output.src = reader.result;
                  }
                  reader.readAsDataURL(x.files[0]);
                }
                else {
                  $('#degree-image').css('display','none');
                }
              }

            }
          }

        </script>
        <script type="text/javascript">
        function check()
        {
          $('#load').show();
          $('#submit_button').prop('disabled', true);
          return true;
        }
        function get_special(sel)
        {
          $("#sp_view").css("display", "block");
          var str_id = sel.value;
          $.ajax({
            method: "POST",
            url: "<?php echo site_url('register/get_special_by_stream');?>",
            data : { str_id : str_id },
            dataType : "text",
            success : function( data ){
                  var obj = JSON.parse( data );

                  var options ="<option value=''>---Select--</option>";
                  for (var i = 0; i < obj.length; i++) {
                    options = options+"<option value='"+obj[i]['special_id']+"'>"+obj[i]['special_name']+"</option>";
                  }
                  var content = options;
                  document.getElementById('select_special').innerHTML=content;
                }
              });
        }
        function attach_special()
        {
          var str_id = $("#stream option:selected").val();
          id = 'file'+num;
          bt = id+'bt';
          file_id = 'f'+num;
          img_id = 'img'+num;

          $.ajax({
            method: "POST",
            url: "<?php echo site_url('register/get_special_by_stream');?>",
            data : { str_id : str_id },
            dataType : "text",
            success : function( data ){
                  var obj = JSON.parse( data );
                  var start = "<div id='"+id+"'><a class='btn btn-link pull-right' onclick='empty_div("+num+")'><i class='fa fa-close'></i></a><div class='clearfix'></div>"
                  var form = "<div class='row'><div class='col-12'><div class='form-group'><select class='form-control' name='special_id[]' required>"
                  var options ="<option value=''>---Select--</option>";
                  for (var i = 0; i < obj.length; i++) {
                    options = options+"<option value='"+obj[i]['special_id']+"'>"+obj[i]['special_name']+"</option>";
                  }
                  var photo = "<div class='col-12'><div class='form-group'><input type='file' class='form-control' name='special_file[]' id="+file_id+" onchange='preview_image(this)' required></div><img class='img-fluid' id='"+img_id+"' height='340px;' width='350px;' style='padding-top:20px;'/></div></div>";
                  var sel_end = "</select></div></div>";
                  var college = "<div class='col-12'><div class='form-group'><input type='text' class='form-control' placeholder='College' name='special_college[]' required></div></div>";
                  var perf = "<div class='col-12'><div class='form-group'><input type='text' class='form-control' placeholder='Year of passing' name='special_perf[]' required></div></div>";
                  var university = "<div class='col-12'><div class='form-group'><input type='text' class='form-control' placeholder='University' name='special_univer[]' required></div></div>";
                  var content =start + form + options + sel_end + college + university + perf + photo +"</div>";
                  $("#more_special").append(content);
                  num = num + 1;
                }
              });
              return false;
        }
        function attach_sub()
        {
          var str_id = $("#stream option:selected").val();
          id = 'file'+num1;
          bt = id+'bt';
          file_id = 'f'+num1;
          img_id = 'img'+num1;

          $.ajax({
            method: "POST",
            url: "<?php echo site_url('register/get_sub_special_by_stream');?>",
            data : { str_id : str_id },
            dataType : "text",
            success : function( data ){
                  var obj = JSON.parse( data );
                  var start = "<div id='"+id+"'><a class='btn btn-link pull-right' onclick='empty_div("+num1+")'><i class='fa fa-close'></i></a><div class='clearfix'></div><p>SUB SPECIALIZATION</p>"
                  var form = "<div class='row'><div class='col-xs-6'><div class='form-group'><select class='form-control' name='sub_id[]'>"
                  var options ="<option value=''>---Select---</option>";
                  for (var i = 0; i < obj.length; i++) {
                    options = options+"<option value='"+obj[i]['sub_id']+"'>"+obj[i]['sub_name']+"</option>";
                  }
                  var sel_end = "</select></div></div>";
                  var college = "<div class='col-xs-6'><div class='form-group has-feedback'><input type='text' class='form-control bttn-radius' placeholder='College' name='sub_college[]' required><span class='fa fa-university form-control-feedback'></span></div></div>";
                  var perf = "<div class='col-xs-6'><div class='form-group has-feedback'><input type='text' class='form-control bttn-radius' placeholder='Performance' name='sub_perf[]' required><span class='fa fa-percent form-control-feedback'></span></div></div>";
                  var university = "<div class='col-xs-6'><div class='form-group has-feedback'><input type='text' class='form-control bttn-radius' placeholder='University' name='sub_univer[]' required><span class='fa fa-user form-control-feedback'></span></div></div>";
                  var photo = "<div class='col-xs-12'><div class='form-group has-feedback'><input type='file' class='form-control bttn-radius' name='sub_file[]' id="+file_id+" onchange='preview_image(this)' required><span class='fa fa-file form-control-feedback'></span></div><img class='img-responsive' id='"+img_id+"' height='340px;' width='350px;' /></div></div>";
                  var content =start + form + options + sel_end + college + university + perf + photo +"</div></div>";
                  $("#more_sub_special").append(content);
                  num1 = num1 + 1;
                }
              });

        }
        </script>
    </body>
</html>
