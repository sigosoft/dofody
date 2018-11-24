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
                  <h4 class="page-title float-left">Edit account details</h4>
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
                      <form action="<?php echo site_url('doctor/edit_bank')?>" method="post" enctype="multipart/form-data" onsubmit="return check();">

                          <div class="form-group row m-b-20">
                              <div class="col-12">
                                  <input type="text" class="form-control bttn-radius" name="acc_bank" id="name" value="<?=$bank->acc_bank?>" required>
                              </div>
                          </div>
                          <div class="form-group row m-b-20">
                              <div class="col-12">
                                  <input type="text" class="form-control bttn-radius" name="acc_holder" id="holder" value="<?=$bank->acc_holder?>" placeholder="Name of account holder" required>
                              </div>
                          </div>
                          <div class="form-group row m-b-20">
                              <div class="col-12">
                                  <input type="text" class="form-control bttn-radius" name="acc_number" id="number" value="<?=$bank->acc_number?>" placeholder="Account number" required>
                              </div>
                          </div>
                          <div class="form-group row m-b-20">
                              <div class="col-12">
                                  <input type="text" class="form-control bttn-radius" name="acc_ifsc" id="ifsc" value="<?=$bank->acc_ifsc?>" placeholder="IFSC code" required>
                              </div>
                          </div>
                          <div class="form-group row m-b-20">
                              <div class="col-12">
                                <select class="form-control bttn-radius selectpicker" id="sel1" name="document_type">
                                  <option <?php if ($bank->document_type == 'Cheque') { echo "selected"; } ?> value="Cheque">Cancelled cheque</option>
                                  <option <?php if ($bank->document_type == 'Passbook') { echo "selected"; } ?> value="Passbook">Front page of passbook</option>
                                  <option <?php if ($bank->document_type == 'statement') { echo "selected"; } ?> value="statement">Bank statement</option>
                                </select>
                              </div>
                          </div>
                          <input type="hidden" name="format" id="format" value="<?=$bank->format?>">
                          <div class="form-group row m-b-20">
                              <div class="col-12">
                                  <input type="file" class="form-control bttn-radius" name="bank" id="bank" onchange="preview_image(this)">
                              </div>
                          </div>
                          <div id="bank-image" ><img class="img-fluid" id="output_image" height="340px;" width="100%;" src="<?=base_url().$bank->doc_account?>" style="padding-top:5px;padding-bottom:5px;"/></div>
                          <div class="form-group row text-center m-t-10">
                              <div class="col-12">
                                  <button class="btn btn-gradient btn-rounded waves-light waves-effect w-md pull-right" type="submit">Submit</button>
                              </div>
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
  </body>
  <?php include('scripts.php'); ?>
  <script type='text/javascript'>
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
          $('#bank-image').css('display','block');
          var reader = new FileReader();
          reader.onload = function()
          {
           var output = document.getElementById('output_image');
           output.src = reader.result;
          }
          reader.readAsDataURL(x.files[0]);
        }
        else {
          $('#bank-image').css('display','none');
        }
        $('#format').val(type);
      }

    }
  }
  </script>
</html>
