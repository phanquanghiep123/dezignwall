<link rel="stylesheet" type="text/css" href="<?php echo skin_url(); ?>/css/jquery.Jcrop.css">

<link rel="stylesheet" type="text/css" href="<?php echo skin_url(); ?>/css/jquery.Jcrop.min.css">
<script src="<?php echo skin_url() ?>/js/jquery.Jcrop.js"></script>
<script src="<?php echo skin_url() ?>/js/jquery.Jcrop.min.js"></script>
<script src="<?php echo skin_url() ?>/js/profile-edit.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="<?php echo skin_url(); ?>/js/jquery-ui.js"></script>
<style type="text/css">
    .impromation-project .logo-company img {
        width: 60px;
        height: 60px;
        margin-top: 10px;
    }
    
    .impromation {
        padding-bottom: 10px;
        padding-top: 10px;
    }
    
    .banner-box .banner.collapse-banner {
        background: url('') !important;
    }
</style>
<section class="section banner-box">
    <div class="relative">
        <?php
        $user_info = $this->session->userdata('user_info');
        $src = skin_url() . '/images/image-upload1.png';
        $temp = $src;
        $allow_edit = (isset($member) && isset($user_info) && $user_info['id'] == $member['id']) ? true : false;
        if (isset($member['banner']) && !empty($member['banner']) && file_exists('.' . $member['banner'])) {
            $src = $member['banner'];
        }
        if ($temp == $src):
            ?>
            <div class="banner image-banner text-center">
                <img style="height:200px;margin-top: 100px;" src="<?php echo $src; ?>">
            </div>
            <?php else: ?>
            <div class="banner image-banner" style="background:url('<?php echo $src; ?>') no-repeat center center; background-size: cover;">&nbsp;
                <image class="photo-detail none-element" src="<?php echo base_url($src); ?>" />
            </div>
            <?php endif; ?>
            <?php if ($allow_edit) : ?>
            <div class="profile-edit-photo banner-custom">
                <div class="profile-action-edit">
                    <a class="text-white" href="#" onclick="$('#ImageUploader_image2').click();return false;"><i class="fa fa-3 fa-pencil"></i> <small>  Edit Background</small></a>
                </div>
            </div>
            <?php endif; ?>

            <div class="impromation-project" style="display:block;">
                <div class="container relative">
                    <?php
                $src = skin_url() . '/images/logo-company.png';
                if (isset($member['logo']) && $member['logo'] != null && !empty($member['logo']) && file_exists('.' . $member['logo'])) {
                    $src = base_url($member['logo']);
                }
                ?>
                        <div class="logo-company profile-image relative">
                            <img src="<?php echo $src; ?>">
                        </div>
                        <div class="impromation">
                            <?php
                    $business_description = explode(',', @$company_info['business_description']);
                    $business_result = '';
                    if (isset($business_description) && count($business_description) > 0) {
                        foreach ($business_description as $key => $value) {
                            $business_result .= $value;
                            if (isset($business_description[$key + 1]) && trim($business_description[$key + 1]) != null && $key < count($business_description) - 1) {
                                $business_result .= ',';
                            }
                        }
                    }
                    ?>
                                <h5><strong><?php echo @$member['company_name']; ?></strong></h5>
                                <p><span style="text-transform: capitalize;"><?php echo @$company_info['business_type']; ?></span>
                                    <?php
                        if ($business_result != '') {
                            echo '| ';
                            echo $business_result;
                        }
                        ?>
                                </p>
                        </div>

                </div>
            </div>
    </div>
</section>
<section class="section box-wapper-show-image">
    <div class="container">
        <?php if(isset($sales_reps) && count($sales_reps)>0):?>
        <div class="row form-rep-info-add">
            <?php foreach ($sales_reps as $key => $value) : ?>
            <div class="col-sm-6 rep-item">
                <form class="form-horizontal" action="" method="post">
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
                        <input type="hidden" name="id" value="<?php echo @$value['id']; ?>">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">First name:</label>
                            <div class="col-sm-8">
                                <p class="edit-profile"><input type="text" value="<?php echo @$value['first_name']; ?>" class="form-control required" placeholder="First name" name="first_name"></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label">Last name:</label>
                            <div class="col-sm-8">
                                <p class="edit-profile"><input type="text" value="<?php echo @$value['last_name']; ?>" class="form-control required" placeholder="Last name" name="last_name"></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label">Job title:</label>
                            <div class="col-sm-8">
                                <p class="edit-profile"><input type="text" value="<?php echo @$value['job_title']; ?>" class="form-control required" placeholder="Job title" name="job_title"></p>
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
                                <p class="edit-profile"><input type="text" value="<?php echo @$value['main_business_ph']; ?>" class="form-control format-phone" placeholder="Local phone" name="main_business_ph"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Cell phone:</label>
                            <div class="col-sm-8">
                                <p class="edit-profile"><input type="text" value="<?php echo @$value['cellphone']; ?>" class="form-control format-phone" placeholder="Cell phone" name="cellphone"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Email:</label>
                            <div class="col-sm-8">
                                <p class="edit-profile"><input style="border: 1px solid #000;padding: 0px 10px;" type="text" value="<?php echo @$value['contact_email']; ?>" class="form-control format-email" placeholder="Email" name="" disabled></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Website:</label>
                            <div class="col-sm-8">
                                <p class="edit-profile"><input type="text" value="<?php echo @$value['web_address']; ?>" class="form-control format-url" placeholder="Website" name="web_address"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Address:</label>
                            <div class="col-sm-8">
                                <p class="edit-profile"><input type="text" value="<?php echo @$value['main_address']; ?>" class="form-control" placeholder="Address" name="main_address"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">City:</label>
                            <div class="col-sm-8">
                                <p class="edit-profile"><input type="text" value="<?php echo @$value['city']; ?>" class="form-control required" placeholder="City" name="city"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">State:</label>
                            <div class="col-sm-8">
                                <p class="edit-profile"><input type="text" value="<?php echo @$value['state']; ?>" class="form-control" placeholder="State" name="state"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Zip code:</label>
                            <div class="col-sm-8">
                                <p class="edit-profile"><input type="text" value="<?php echo @$value['zip_code']; ?>" class="form-control" placeholder="Zip code" name="zip_code"></p>
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
                                <p class="edit-profile"><input type="text" id="keyword-tag" value="<?php echo @$value['service_area']; ?>" class="form-control required" placeholder="Service area" name="service_area"></p>
                            </div>
                        </div>
                        <h2>Personal login password</h2>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Password:</label>
                                <div class="col-sm-8">
                                    <p class="edit-profile"><input type="password" id="password" value="<?php echo @$value['pwd']; ?>" class="form-control bg-input required" placeholder="XXXXXX" name="password"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Confirm Password:</label>
                                <div class="col-sm-8">
                                    <p class="edit-profile"><input type="password" id="password-confirm" data-math="#password" value="<?php echo @$value['pwd']; ?>" class="form-control bg-input required" placeholder="XXXXXX" name="confirm_password"></p>
                                </div>
                            </div>
                        <div class="form-group">
                            <div class="col-sm-12  text-right">
                                <div class="space-20"></div>
                                <a class="btn btn-gray clear-button">Clear</a>
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

<style type="text/css">
    .form-group {
        margin-bottom: 0;
    }
    
    .rep-item:first-child .panel-action {
        display: none;
    }
    
    .panel-header .panel-action {
        top: -12px;
        right: -5px;
        font-size: 15px;
        z-index: 100;
    }
    
    .edit-profile {
        display: block;
    }
    body ul.tagit {
        border-color: #000;
        border-radius: 0;
        padding: 0;
        max-height: 35.5px
    }
    
    body ul.tagit li {
        font-size: 17px;
    }
</style>
<link rel="stylesheet" type="text/css" href="<?php echo skin_url(); ?>/css/jquery.tagit.css">
<link rel="stylesheet" type="text/css" href="<?php echo skin_url(); ?>/css/tagit.ui-zendesk.css">
<script src="<?php echo skin_url(); ?>/js/tag-it.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $.each($("form #keyword-tag"), function() {
            var _this_new = $(this);
            $(this).tagit({
                allowSpaces: true,
                fieldName: "keyword[]",
                autocomplete: {
                    delay: 0,
                    minLength: 1
                },
                tagSource: function(request, response) {
                    name_not_show = _this_new.val();
                    $.ajax({
                        url: base_url + "profile/get_services",
                        type: "post",
                        data: {
                            slug: request.term,
                            list_id: name_not_show
                        },
                        dataType: "json",
                        success: function(data) {
                            console.log(name_not_show);
                            if (data["status"] == "success") {
                                response($.map(data["reponse"], function(item) {
                                    console.log(item);
                                    return {
                                        label: item.title,
                                        value: item.title,
                                    }
                                }));
                            }

                        }
                    });
                }
            });
        });
        $(document).on('click', '.rep-item .clear-button', function() {
            $(this).parents('form').find('input').val('');
            $(this).parents('form').find('textarea').val('');
            return false;
        });
        var reset_click = 0;
        $(document).on('submit', '.rep-item form', function() {
            var bool = true;
            $(this).find('input,textarea').each(function() {
                if ($(this).hasClass('required')) {
                    var value = $(this).val();
                    if (value == null || $.trim(value) == '') {
                        $(this).addClass("warning");
                        bool = false;
                    } else {
                        $(this).removeClass("warning");
                    }
                }
            });
            if($(this).find("#keyword-tag").val() == ""){
                $(this).find("ul.tagit").addClass("warning");
                bool = false;
            }else{
                $(this).find("ul.tagit").removeClass("warning");
            }
            if (bool == false) {
                messenger_box("Edit Reps", 'Please fill in all required fields marked with an asterisk.');
            } else {
                bool = bool && valid_all_format($(this), false);
            }

            if (bool == false) {
                return bool;
            }
            var parent = $(this).parents('.rep-item');
            var data_form = $(this).serialize();
            parent.find('.custom-loading').show();
            if (reset_click == 0) {
                reset_click = 1;
                $.ajax({
                    url: base_url + '/profile/save_sales_reps_private',
                    type: 'POST',
                    data: data_form,
                    dataType: 'json',
                    success: function(reponse) {
                        console.log(reponse);
                        if (reponse['status'] == 'success') {
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        }
                        reset_click = 0;
                    },
                    complete: function() {
                        parent.find('.custom-loading').hide();
                    },
                    error: function(data) {
                        console.log(data['responseText']);
                        reset_click = 0;
                    }
                });
            }
            return false;
        });
    });
</script>