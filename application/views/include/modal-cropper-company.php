<link rel="stylesheet" type="text/css" href="<?php echo skin_url("/css/jquery.Jcrop.css");?>">
<link rel="stylesheet" type="text/css" href="<?php echo skin_url("/css/jquery.Jcrop.min.css");?>">
<link rel="stylesheet" href="<?php echo skin_url("js/cropper-master/examples/crop-avatar/css/main.css");?>">
<div class="modal fade" id="avatar-modal-company" aria-hidden="true" aria-labelledby="avatar-modal-company-label" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form class="avatar-form" action="<?php echo base_url("company/update_media")?>" enctype="multipart/form-data" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="avatar-modal-label">Change Avatar</h4>
        </div>
        <div class="modal-body">
          <div class="avatar-body">
            <!-- Upload image and data -->
            <div class="avatar-upload">
              <input type="hidden" class="avatar-src" name="avatar_src">
              <input type="hidden" class="avatar-data" name="avatar_data">
              <input type="file" class="avatar-input none" id="avatarInput" name="avatar_file" accept="image/*">
            </div>
            <!-- Crop and preview -->
            <div class="row">
              <div class="col-md-12">
                <div class="avatar-wrapper"></div>
              </div>
            </div>
            <div class="row avatar-btns">
              <div class="col-md-12 text-right">
                <canvas class="none" id="create_img" width="200" height="100"></canvas>
                <input type="hidden" id="colum_change" name="colum_change">
                <input type="hidden" id="string_img" name="string_img">
                <button class="btn btn-gray" data-dismiss="modal" aria-label="Close">Cancel</button>
                <button type="submit" class="btn btn-primary avatar-save">Save and View</button>
              </div>
            </div>
          </div>
        </div>
        <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
      </form>
    </div>
  </div>
</div><!-- /.modal -->
<script src="<?php echo skin_url("/js/jquery.Jcrop.js");?>"></script>
<script src="<?php echo skin_url("/js/jquery.Jcrop.min.js");?>"></script>
<script src="<?php echo skin_url("js/cropper-master/examples/crop-avatar/js/main-company.js");?>"></script>
<style type="text/css">

</style>