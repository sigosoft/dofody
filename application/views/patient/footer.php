<footer class="footer">
    © Copyright 2018 - www.dofody.com
</footer>
<div class="modal fade" id="audio-call" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" style="display:none;" id="close-button"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <img class="text-center img-fluid" style="margin:auto;" src="<?=base_url()?>assets/images/logo-blue.png" width="100px">
        </div>
        <div class="modal-body text-center">
          <img src="" height="200px" id="doc-image" style="border-radius:100px;margin-botoom:20px;" alt="test-image">
          <h4 id="doc_name">Aithin EP</h4>
          <p style="margin-bottom:0px;" id="doc_degree">MBBS</p>
          <p style="padding-top:0px;" id="doc_special">Oral pathology , ENT</p>
          <p id="call-button"><button type="button" class="btn btn-link" id="call-accept"><i class="fa fa-phone-square" style="font-size:50px;color:green;"></i></button><button type="button" class="btn btn-link" id="call-reject"><i class="fa fa-phone-square" style="font-size:50px;color:red;"></i></button></p>
          <div class="text-center" id="incall" style="display:none;">
            <div id="show_time" style="font-size:18px;font-weight:bold"></div>
            <p><button type="button" class="btn btn-link" id="disconnect"><i class="fa fa-phone-square" style="font-size:50px;color:red;"></i></button></p>
          </div>
          <div class="text-center" id="call-ended" style="display:none;">
            <p style="margin-bottom:0px;font-size:18px;font-weight:bold;" id="duration"></p>
            <p style="font-size:18px;margin-botton:3px;">Call ended</p>
          </div>
          <div class="text-center" id="call-rejected" style="display:none;">
            <p style="font-size:18px;margin-botton:3px;">Call rejected</p>
          </div>
        </div>
        <div class="modal-footer">
          <div class="container text-center">
            <p>www.dofody.com</p>
          </div>
        </div>
      </div>
    </div>
  </div>