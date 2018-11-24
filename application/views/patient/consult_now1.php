<!DOCTYPE html>
<html>
  <head>
    <?php include('includes.php'); ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/bootstrap-select/css/bootstrap-select.min.css">
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
                  <h4 class="page-title float-left">Consult now</h4>
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
                  <div class="row">
                    <div class="col-md-3">

                    </div>
                    <div class="col-md-6">
                      <form id="consult_form" action="<?=site_url('patient/connect_doctors')?>" method="post">
                      <div class="form-group m-b-25">
                        <div class="col-12">
                          <label for="select">Choose user</label>
                          <select class="form-control" name="patient_id" id="patient_id" required>
                            <option value="">--- Select patient ---</option>
                            <?php foreach ($memb as $pat) { ?>
                              <option value="<?=$pat->patient_id?>" name="<?=$pat->patient_name?>"><?=$pat->patient_name?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group m-b-25">
                        <div class="col-12">
                          <label for="select">Present health problem</label>
                          <input type="text" class="form-control" name="present_problem" required>
                        </div>
                      </div>
                      <div class="form-group m-b-25">
                        <div class="col-12">
                          <label for="select">Since when</label>
                          <input type="text" class="form-control" name="since_when" required>
                        </div>
                      </div>
                      <div class="form-group m-b-25">
                        <div class="col-12">
                          <label for="select">Relevent past medical conditions</label>
                          <textarea class="form-control" rows="4" id="past_medical" name="past_medical" required></textarea>
                        </div>
                      </div>
                      <div class="form-group m-b-25">
                        <div class="col-12">
                          <a href="#" class="btn btn-outline-primary btn-rounded waves-light waves-effect w-md btn-block" onclick="upload_docs();">Upload medical records</a>
                        </div>
                        <div id="upSuccess" style="display : none;color : green;">Record added..!</div>
                      </div>
                      <div class="form-group m-b-25" style="padding-left:30px;">
                        <div class="radio radio-info form-check-inline">
                            <input type="radio" id="video" value="video" name="type_consult" onclick="service(this)" required>
                            <label for="inlineRadio1"> Video </label>
                        </div>
                        <div class="radio radio-info form-check-inline">
                            <input type="radio" id="audio" value="audio" name="type_consult" onclick="service(this)" required>
                            <label for="inlineRadio2"> Audio </label>
                        </div>
                        <div class="radio radio-info form-check-inline">
                            <input type="radio" id="chat" value="chat" name="type_consult" onclick="service(this)" required>
                            <label for="inlineRadio2"> Chat </label>
                        </div>
                      </div>
                      <input type="hidden" id="type_consult" name="type_consult">
                      <div class="form-group m-b-25" id="select_doctor_div" style="display:none;">
                        <div class="col-12 text-center">
                          <a href="#" class="btn btn-outline-primary btn-rounded waves-light waves-effect w-md" onclick="return choose_doctor();" id="btn-choose-doctor">Choose doctor</a>
                          <a href="#" class="btn btn-outline-primary btn-rounded waves-light waves-effect w-md" onclick="return quick_consult();" id="btn-quick-consult">Quick consult</a>
                        </div>
                      </div>
                      <div class="form-group m-b-25" id="pay_online_div" style="display:none;">
                        <table class="table" id="selected_doctor_details">

                        </table>
                        <div class="text-center" style="margin-top : 10px;" id="payment-options">
                          <button type="button" class="btn btn-outline-primary btn-rounded waves-light waves-effect w-md" id="select_doctor_div_button">Choose another doctor</button>
                          <button type="button" class="btn btn-outline-primary btn-rounded waves-light waves-effect w-md" id="pay_online_button">Pay online</button>
                        </div>
                      </div>
                      <input type="hidden" name="doctor_id" id="type_consult_select">
                      <input type="hidden" name="payment_id" id="payment_id">
                      <div id="docError" style="display : none; color : red;font-size:18px;" class="text-center">
                        Please select a doctor
                      </div>
                      <div id="paymentError" style="display : none; color : red; font-size:18px;" class="text-center">
                        Payment not completed.
                      </div>
                      <div id="paymentSuccess" style="display : none; color : green; font-size:18px;" class="text-center">
                        Thank you , your payment was received.
                      </div>
                      <div class="form-group" id="consult-now-button">
                        <button class="btn btn-gradient waves-light waves-effect w-md pull-right" type="submit">Send request</button>
                      </div>
                    </form>
                    </div>
                  </div>
                </div>
            </div>
          </div>
        </div>
      </div>
      <?php include('footer.php');?>
    </div>
    <!-- MODAL UPLOAD DOCUMENTS -->
    <div class="modal fade" id="upload_docs" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Upload medical records</h4>
          </div>
          <div class="modal-body">
            <form id="medicalRecord" method="post" enctype="multipart/form-data">

              <div class="form-group">
                <label>Select patient</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-user"></i>
                  </div>
                    <input type="text" class="form-control" id="patient_name" readonly>
                    <input type="hidden" id="patient" name="patient">
                </div>
              </div>

              <div class="form-group">
                <label>Choose record type</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-font"></i>
                  </div>
                  <select class="form-control selectpicker" id="report" name="med_title">
                      <option value="Prescription">Prescription</option>
                      <option value="Lab tests">Lab tests</option>
                      <option value="Scan reports">Scan reports</option>
                      <option value="Electronic medical record">Electronic medical record</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label>Notes</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-comments"></i>
                  </div>
                  <textarea class="form-control" rows="4" id="notes" name="med_notes" required></textarea>
                </div>
              </div>
              <div class="form-group">
                <label>Attach record</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-font"></i>
                  </div>
                  <input type="file" class="form-control" id="rec_file" name="rec_file" onchange="preview_image(this)" required>
                </div>
              </div>

              <img class="img-responsive" id="output_image" style="padding-bottom:10px;"/>

          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary pull-right" style="margin-left : 5px;">ADD</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
          </form>
        </div>

      </div>
    </div>

    <div class="modal fade" id="choose_doctor" role="dialog">
      <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" style="text-align : center;">CHOOSE DOCTOR</h4>
          </div>
          <div class="modal-body">
            <table id="online_doctors">

            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>

    <div class="modal fade" id="quick_consult" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" style="text-align : center;">QUICK CONSULT</h4>
          </div>
          <div class="modal-body">
            <table>
              <tr>
                <th rowspan="2">Services</th>
                <th>Video call</th>
                <th>Audio call</th>
                <th>Chat</th>
              </tr>
              <tr>
                <td><i class="fa fa-rupee"></i></td>
                <td><i class="fa fa-rupee"></i></td>
                <td><i class="fa fa-rupee"></i></td>
              </tr>
              <tr>
                <td><b>Fees</b></td>
                <td><?=$quick->video_fee?></td>
                <td><?=$quick->audio_fee?></td>
                <td><?=$quick->chat_fee?></td>
              </tr>

            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="accept-button">Accept</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>
  </body>
  <?php include('scripts.php'); ?>
  <script src="<?php echo base_url(); ?>plugins/bootstrap-select/js/bootstrap-select.js"></script>
  <script src="<?php echo base_url();?>plugins/iCheck/icheck.min.js"></script>
  <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
  <script>
    var audio;
    var video;
    var chat;
    function upload_docs()
    {
      var id = $('#patient_id').val();
      var name = $('#patient_id').find('option:selected').attr("name");
      $('#patient_name').val(name);
      $('#patient').val(id);

      $('#upload_docs').modal('show');
      return false;
    }

    $("form#medicalRecord").submit(function(e) {
      e.preventDefault();
      var formData = new FormData(this);

      $.ajax({
          url: "<?=site_url('patient/add_m_record')?>",
          type: 'POST',
          data: formData,
          success: function (data) {
              $('#notes').val('');
              $('#rec_file').val('');
              var output = document.getElementById('output_image');
              output.src = '';
              $('#upSuccess').css('display','block');
              $('#upload_docs').modal('hide');
          },
          processData: false,
          cache: false,
          contentType: false
        });
    });

    function preview_image(id)
    {
      var id = id.id;
      var x = document.getElementById(id);
      var val = x.files[0].type;
      var type = val.substr(val.indexOf("/") + 1);

      var report = $('#report').val();
      if (report == 'Electronic medical record') {
        if (type != 'pdf') {
          alert('Please upload a pdf document..!');
          document.getElementById(id).value = "";
        }
      }
      else{
        var size = x.files[0].size;
        if (size > 1000000) {
          alert('Please select an image with size less than 1 mb.');
          document.getElementById(id).value = "";
        }
        else {
          s_type = ['jpeg','jpg','png'];
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
              var reader = new FileReader();
              reader.onload = function()
              {
               var output = document.getElementById('output_image');
               output.src = reader.result;
              }
              reader.readAsDataURL(x.files[0]);
            }
          }

        }
      }
    }
    function choose_doctor()
    {
      $.ajax({
          url: "<?=site_url('patient/get_online_doctors')?>",
          type: 'POST',
          success: function (data) {
              //getElementById('online_doctors').innerHtml(data);
              $('#online_doctors').html(data);
              //alert(data);
          }
        });
      $('#choose_doctor').modal('show');
      return false;
    }
    function quick_consult()
    {
      $('#quick_consult').modal('show');
      return false;
    }
    $("#accept-button").click(function(){
      $('#quick_consult').modal('hide');
      $('#type_consult_select').val('quick');
      $('#docError').css('display','none');
      audio = '<?=$quick->audio_fee?>';
      video = '<?=$quick->video_fee?>';
      chat = '<?=$quick->chat_fee?>';
      var thead = "<tr><th rowspan='2'>Services</th><th>Video call</th><th>Audio call</th><th>Chat</th></tr>";
      var tbody = "<tr><td><i class='fa fa-rupee'></i></td><td><i class='fa fa-rupee'></i></td><td><i class='fa fa-rupee'></i></td></tr>";
      var value = "<tr><td><b>Fees</b></td><td><?=$quick->video_fee?></td><td><?=$quick->audio_fee?></td><td><?=$quick->chat_fee?></td></tr>";
      var table = thead + tbody + value;
      $('#selected_doctor_details').html(table);
      $('#select_doctor_div').css('display','none');
      $('#pay_online_div').css('display','block');
    });
    function doctor_selected(id)
    {
      $('#choose_doctor').modal('hide');
      /*$('#btn-quick-consult').css({'background-color': '#ddd' , 'color' : 'black'});
      $('#btn-choose-doctor').css({'background-color': '#5cb85c' , 'color' : 'white'});*/
      $('#type_consult_select').val(id);
      $('#docError').css('display','none');

      $.ajax({
          url: "<?=site_url('patient/get_details_of_a_doctor')?>",
          type: 'POST',
          data: { id : id },
          success: function (data) {
            var array = JSON.parse(data);
            //alert(array.table);
            audio = array.audio;
            video = array.video;
            chat = array.chat;
            $('#selected_doctor_details').html(array.table);
            $('#select_doctor_div').css('display','none');
            $('#pay_online_div').css('display','block');
          }
        });
    }
    $('#select_doctor_div_button').on('click',function(){
      $('#select_doctor_div').css('display','block');
      $('#pay_online_div').css('display','none');
    });
    $('#pay_online_button').on('click',function(){
      var type = $('input[name=type_consult]:checked').val();
      $.ajax({
          url: "<?=site_url('patient/get_key')?>",
          success: function (data) {
            var amount;
            if (type == 'audio') {
                amount = audio*100;
            }
            else if (type == 'video') {
              amount = video*100;
            }
            else if (type == 'chat') {
              amount = chat*100;
            }
            var array = JSON.parse(data);
            var options = {
                "key": array.key,
                "amount": amount, // 2000 paise = INR 20
                "name": "Dofody.com",
                "description": "Doctor for everybody",
                "image": "<?=base_url().'dist/img/favicon.png'?>",
                "handler": function (response){
                    //alert(response.razorpay_payment_id);
                    $('#payment_id').val(response.razorpay_payment_id);
                    $('#payment-options').css("display","none");
                    $('#paymentSuccess').css("display","block");
                    $('#consult-now-button').css("display","block");
                    console.log(response);
                },
                "prefill": {
                    "name": array.name,
                    "email": array.email
                },
                "notes": {
                    "address": "Hello World"
                },
                "theme": {
                    "color": "#3c8dbc"
                }
            };

            var rzp1 = new Razorpay(options);
            rzp1.open();
          }
        });

    });
    $('#patient_id').on('change', function (e) {
      var id = $(this).val();
      $.ajax({
          url: "<?=site_url('patient/get_patient_past_medical')?>",
          type: 'POST',
          data: { id : id },
          success: function (data) {
            $('#past_medical').val(data);
          }
        });
    });
    $("form#consult_form").submit(function(e) {
      var doc = $('#type_consult_select').val();
      if (doc == '') {
        $('#docError').css('display','block');
        return false;
      }
      else {
        var payment = $('#payment_id').val();
        if (payment == '') {
          $('#paymentError').css('display','block');
          return false;
        }
        else {
            return true;
        }
      }
    });
    function service(service)
    {
      var sid = service.id;
      $('#type_consult').val(sid);
      $('#select_doctor_div').css('display','block');
      $("#video").attr('disabled', true);
      $("#audio").attr('disabled', true);
      $("#chat").attr('disabled', true);
    }
  </script>
</html>
