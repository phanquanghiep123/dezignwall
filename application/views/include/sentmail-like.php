<div class="modal fade popup" id="sentmail-like" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><div class="logo"><div class="logo-site"></div></div></h4>
      </div>
      <div class="modal-body">
        <h3 class="title_box">Send a Message</h3>
        <div>
          <p class="title-input">To member:</p>
          <p><input type="text" id="full-name" class="form-control" data-valid="true"/></p>
          <p><input type="hidden" id="email" name ="email" id="email" class="form-control" data-valid="true"/></p>
          <p  class="title-input">Subject:</p>
          <p><input type="text" name="subject" id="subject" class="form-control" data-valid="true"/></p>
          <p>Message:</p>
          <p><textarea id="message" class="form-control" name="message" data-valid="true">Take a look at this great space that I found on Dezignwall, and let me know what you think.</textarea></p>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id ="sendmail">Send</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->