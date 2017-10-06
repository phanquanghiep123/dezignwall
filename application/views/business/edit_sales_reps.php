<link rel="stylesheet" type="text/css" href="<?php echo skin_url("css/page/business.css")?>">
<script src="<?php echo skin_url() ?>/js/profile-edit.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="<?php echo skin_url(); ?>/js/jquery-ui.js"></script>
<div class="business-text-messenger"><h1>You are in Edit Profile mode...Put your best foot forward!</h1></div>
<?php
        $user_info = $this->session->userdata('user_info');
        $allow_edit = (isset($member) && isset($user_info) && $user_info['id'] == $member['id']) ? true : false;
        $data = null;
        if ($allow_edit) {
            $data['menu_banner'] = array(
                array('href' => base_url('business/edit_rep_info'), 'title' => 'Edit profile', 'class' => ''),
                array('href' => base_url('business/view_profile'), 'title' => 'View profile', 'class' => ''),
                array('href' => base_url('profile/conversations'), 'title' => 'Your conversations', 'class' => '')
            );
        }
        $data["not_report"] = true;
        $this->load->view("include/banner.php", $data);
    ?>
<section class="section box-wapper-show-image">
    <div class="container">
        <?php if(isset($sales_reps) && count($sales_reps)>0):?>
        <div class="row form-rep-info-add">
            <?php foreach ($sales_reps as $key => $value) : ?>
            <div class="col-sm-6 rep-item">
                <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                    <div class="panel panel-default relative">
                        <div class="custom-loading"><img width="48" src="<?php echo skin_url(); ?>/images/loading.gif"></div>
                        <div class="panel-header">
                            <a class="panel-action cancel" href="#" style="display:none;"><i class="fa fa-times"></i></a>
                            <div class="row custom">
                                <div class="col-sm-4">
                                    <h3 class="remove-margin-top"><strong>Local Rep:</strong></h3>
                                </div>
                                <div class="col-sm-8">
                                    <div class="checkbox check-yelow checkbox-circle" style="margin-top: -8px;">
                                        <?php 
                                              $public = "";
                                              if(isset($value["is_public"]) && $value["is_public"] == 1){
                                                  $public= "checked";
                                              }
                                            ?>
                                        <input id="public-<?php echo $key; ?>" name="public-default" type="checkbox" value="1" <?php echo $public;?> disabled>
                                        <label for="public-<?php echo $key; ?>">Display on public profile</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="height:10px;"></div>
                        <input type="hidden" class="not-remove disabled" name="id" value="<?php echo @$value['id']; ?>">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">First name:</label>
                            <div class="col-sm-8">
                                <p class="edit-profile"><input type="text" value="<?php echo @$value['first_name']; ?>" class="form-control remove required" placeholder="First name" name="first_name"></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label">Last name:</label>
                            <div class="col-sm-8">
                                <p class="edit-profile"><input type="text" value="<?php echo @$value['last_name']; ?>" class="form-control remove required" placeholder="Last name" name="last_name"></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label">Job title:</label>
                            <div class="col-sm-8">
                                <p class="edit-profile"><input type="text" value="<?php echo @$value['job_title']; ?>" class="form-control remove required" placeholder="Job title" name="job_title"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Toll free:</label>
                            <div class="col-sm-8">
                                <p class="edit-profile"><input type="text" value="<?php echo @$value['number_800']; ?>" class="form-control format-phone" placeholder="Toll Free" name="number_800"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Local phone:</label>
                            <div class="col-sm-8">
                                <p class="edit-profile"><input type="text" value="<?php echo @$value['main_business_ph']; ?>" class="form-control remove format-phone" placeholder="Local phone" name="main_business_ph"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Cell phone:</label>
                            <div class="col-sm-8">
                                <p class="edit-profile"><input type="text" value="<?php echo @$value['cellphone']; ?>" class="form-control bg-input format-phone" placeholder="Cell phone" name="cellphone"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Email:</label>
                            <div class="col-sm-8">
                                <p class="edit-profile"><input type="text" value="<?php echo @$value['contact_email']; ?>" class="form-control disabled format-email required" placeholder="Email" name="" disabled></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Website:</label>
                            <div class="col-sm-8">
                                <p class="edit-profile"><input type="text" value="<?php echo @$value['web_address']; ?>" class="form-control remove format-url" placeholder="Website" name="web_address"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Address:</label>
                            <div class="col-sm-8">
                                <p class="edit-profile"><input type="text" value="<?php echo @$value['main_address']; ?>" class="form-control remove" placeholder="Address" name="main_address"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">City:</label>
                            <div class="col-sm-8">
                                <p class="edit-profile"><input type="text" value="<?php echo @$value['city']; ?>" class="form-control remove" placeholder="City" name="city"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">State:</label>
                            <div class="col-sm-8">
                                <p class="edit-profile"><input type="text" value="<?php echo @$value['state']; ?>" class="form-control remove" placeholder="State" name="state"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Zip code:</label>
                            <div class="col-sm-8">
                                <p class="edit-profile"><input type="text" value="<?php echo @$value['zip_code']; ?>" class="form-control remove" placeholder="Zip code" name="zip_code"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Country:</label>
                            <div class="col-sm-8">
                                <p class="edit-profile"><select class="form-control" name="country" style="max-width:100%;">
                                        <?php foreach ($this->config->item('country') as $key1 => $value1) :?>
                                            <option <?php if($key1==@$value['country']){echo 'selected="selected"';} ?> value="<?php echo $key1; ?>"><?php echo $value1; ?></option>
                                        <?php endforeach; ?>
                                     </select></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Service area:</label>
                            <div class="col-sm-8">
                                <p class="edit-profile"><input type="text" id="keyword-tag" value="<?php echo @$value['service_area']; ?>" class="form-control" placeholder="Service area" name="service_area"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="media row">
                                    <div class="col-md-4">
                                        <div class="profile-image relative">
                                            <?php 
                                                $images = ( isset($value['avatar']) && $value['avatar'] != "" && file_exists(FCPATH . $value['avatar']) ) ? base_url($value['avatar']) : skin_url("/images/avatar-full.png");
                                            ?>
                                            <img class="media-object avatar-full" src="<?php echo $images; ?>" alt="..." width="162" height="162">
                                            <div class="profile-edit-photo custom-avatar">
                                                <div class="profile-action-edit">
                                                    <a class="text-white" href="#" onclick="$('#ImageUploader').click();return false;"><i class="fa fa-camera"></i> <small>  Change Image</small></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h3>Upload a profile picture!</h3>
                                        <p style="line-height: 1.5;">Your profile picture will be viewed by the commercial design community, worldwide. Be sure to use a photo that best supports your companies public profile image.</p>
                                    </div>
                                </div>
                            </div>
                            <input type="file" name="logo_user" class="none" id="logo_user" accept="image/*">
                        </div>
                        <h2>Personal login password</h2>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Password:</label>
                                <div class="col-sm-8">
                                    <div class="edit-profile relative"><input type="password" id="password" value="<?php echo @$value['pwd']; ?>" class="form-control bg-input required" placeholder="XXXXXX" name="password"><div id="show_hidden"><img src="<?php echo base_url("skins/images/View-Icon.png");?>"></div></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Confirm Password:</label>
                                <div class="col-sm-8">
                                    <div class="edit-profile relative"><input type="password" id="password-confirm" data-math="#password" value="<?php echo @$value['pwd']; ?>" class="form-control bg-input required" placeholder="XXXXXX" name="confirm_password"><div id="show_hidden"><img src="<?php echo base_url("skins/images/View-Icon.png");?>"></div></div>
                                </div>
                            </div>
                        <div class="form-group">
                            <div class="col-sm-12  text-right">
                                <div class="space-20"></div>
                                <a class="btn btn-gray clear-button-sr">Clear</a>
                                <button class="btn btn-primary">Save/Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <?php endforeach; ?>
        </div>
        <!--end row-->
        <?php endif;?>
    </div>
</section>
<div class="modal fade" id="imageCropper-modal" tabindex="-1" role="dialog" aria-labelledby="modal-label" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="#" enctype="multipart/form-data" id="crop-avatar-business">
                <div class="modal-header box-cyan text-white">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="modal-label">Crop Avatar</h4>
                </div>
                <div class="modal-body" style="position: relative;">
                    <div id="loading-custom" class="custom-loading"><img width="48" src="<?php echo base_url();?>/skins/images/loading.gif"></div>
                    <input type="hidden" class="hidden" id="choose" name="choose" value="avatar">
                    <input type="hidden" class="hidden" id="x" name="x">
                    <input type="hidden" class="hidden" id="y" name="y">
                    <input type="hidden" class="hidden" id="w" name="w">
                    <input type="hidden" class="hidden" id="h" name="h">
                    <input type="hidden" class="hidden" value="" name="image_w" id="image_w">
                    <input type="hidden" class="hidden" value="" name="image_h" id="image_h">
                    <input style="display:none;" accept="image/*" name="fileupload" id="ImageUploader" type="file">
                    <img id="uploadPreview" src="" style="display:none; max-width:100%;">
                </div>
                <div class="modal-footer text-right">
                    <button class="btn btn-gray" class="close" data-dismiss="modal" aria-label="Close">Cancel</button>
                    <input id="btnSaveView2" class="btn btn-primary" type="submit" name="yt2" value="Save and View">
                </div>
            </form>
        </div>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="<?php echo skin_url(); ?>/css/jquery.tagit.css">
<link rel="stylesheet" type="text/css" href="<?php echo skin_url(); ?>/css/tagit.ui-zendesk.css">
<script src="<?php echo skin_url(); ?>/js/tag-it.min.js"></script>
<script src="<?php echo skin_url(); ?>/js/business.js"></script>
<style type="text/css"> 
.edit-profile{display: block;}
@media screen and (max-width: 768px){
    #imageCropper-modal .modal-dialog{
        width: 640px; max-width: 100%;
        margin: 0 auto;
    }
}  
@media screen and (max-width: 640px){
    #imageCropper-modal .modal-dialog{
        width: 540px; max-width: 100%;
        margin: 0 auto;
    }
}  
@media screen and (max-width: 540px){
    #imageCropper-modal .modal-dialog{
        width: 320px; max-width: 100%;
        margin: 0 auto;
    }
}

</style>