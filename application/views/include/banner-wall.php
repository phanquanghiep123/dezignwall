<link rel="stylesheet" type="text/css" href="<?php echo skin_url(); ?>/css/jquery.Jcrop.css">
<link rel="stylesheet" type="text/css" href="<?php echo skin_url(); ?>/css/jquery.Jcrop.min.css">
<script src="<?php echo skin_url() ?>/js/jquery.Jcrop.js"></script>
<script src="<?php echo skin_url() ?>/js/jquery.Jcrop.min.js"></script>
<script src="<?php echo skin_url() ?>/js/profile-edit.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="<?php echo skin_url(); ?>/js/jquery-ui.js"></script>
<style type="text/css">
    .impromation-project .logo-company img{
        width: 60px;
        height: 60px;
        margin-top: 10px;
    }
    .impromation{
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
        $user_sr_info = $this->session->userdata('user_sr_info');
        $src = skin_url() . '/images/image-upload1.png';
        $temp = $src;
        $allow_edit = (isset($member) && isset($user_info) && $user_info['id'] == $member['id']) ? true : false;
        if(isset($user_sr_info)){
            $allow_edit = false;
        }
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
                <image class="photo-detail none-element" src ="<?php echo base_url($src); ?>"/>
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
                <div class="impromation-project-dropdown">
                    <!--<div class="dropdown-impromation relative">
                        <?php if (isset($menu_banner)) : ?>
                            <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>
                            <ul class="dropdown-impromation-menu" id="deziwall">
                                <?php if($view_profile):?>
                                <li><a href="#" class="not-report" data-reporting="company" id="share-social" data-title ="<?php echo @$member['company_name']; ?>" data-type ="profile" data-id ="<?php echo $member["id"]; ?>">Share Profile</a></li>
                                <?php endif?>
                                <?php foreach ($menu_banner as $key => $item_banner) : ?>
                                    <?php if($item_banner != null):?>
                                    <li><a id="<?php echo @$item_banner["id"];?>" data-id ="<?php echo @$item_banner["data-id"];?>" href="<?php echo $item_banner['href']; ?>" class="<?php echo $item_banner['class']; ?>"><?php echo $item_banner['title']; ?></a></li>
                                    <?php endif;?>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>
                            <ul class="dropdown-impromation-menu">
                                <li><a href="#" class="not-report" data-reporting="company" id="share-social" data-title ="<?php echo @$member['company_name']; ?>" data-type ="profile" data-id ="<?php echo $member["id"]; ?>">Share Profile</a></li>
                                <?php if(!@$not_report):?>
                                <li><a href="#" class="not-report" data-reporting="company" id="report-image" data-title ="<?php echo @$member['company_name']; ?>" data-type ="member" data-id ="<?php echo $member["id"]; ?>">Report Profile</a></li>
                                <?php endif;?>
                            </ul> 
                        <?php endif; ?>
                    </div>-->
                </div>
                <?php
                $src = skin_url() . '/images/logo-company.png';
                if (isset($member['logo']) && $member['logo'] != null && !empty($member['logo']) && file_exists('.' . $member['logo'])) {
                    $src = base_url($member['logo']);
                }
                ?>
                <div class="logo-company profile-image relative">
                    <img  src="<?php echo $src; ?>">
                    <?php if ($allow_edit) : ?>
                        <?php if(!isset($not_edit_logo)):?>
                        <div class="profile-edit-photo custom-logo">
                            <div class="profile-action-edit">
                                <a class="text-white" href="#" onclick="$('#imageCropperlogo-modal #ImageUploader_image1').click();return false;"><i class="fa fa-camera"></i></a>
                            </div>
                        </div>
                    <?php endif;?>
                    <?php endif; ?>
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
                    <p><span style="text-transform: capitalize;"><?php echo @$company_info['business_type']; ?></span> <?php
                        if ($business_result != '') {
                            echo '| ';
                            echo $business_result;
                        }
                        ?></p>
                </div> 

            </div>
        </div>
        <div class="banner-button-share">
            <?php if(isset($show_reports) && $show_reports):?>
            <a class="btn btn-gray" href="<?php echo @$download_url;?>" download>Download Contacts</a>
            <button class="btn btn-gray clear-button" data-title="<?php echo @$member['company_name']; ?>" onclick="document.location.href='<?php echo base_url() ?>profile/your_reports';" data-type="profile" data-id="<?php echo $member["id"]; ?>">Reports</button>
            <?php endif;?>
            <?php if(@$view_profile):?>
            <button class="btn share_click" data-toggle="modal" data-target="#share-modal" data-title ="<?php echo @$member['company_name']; ?>" data-type ="profile" data-id ="<?php echo $member["id"]; ?>">Share Profile</button>
            <?php endif;?>
        </div>
    </div>
</section>

<?php if ($allow_edit) : ?>
    <!--model bootstrap avatar-->
    <div class="modal fade" id="imageCropper-modal" tabindex="-1" role="dialog" aria-labelledby="modal-label" style="display: none;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="<?php echo base_url('profile/save_media'); ?>" enctype="multipart/form-data" id="crop-avatar">
                    <div class="modal-header box-cyan text-white">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="modal-label">Crop Avatar</h4>
                    </div>
                    <div class="modal-body" style="position: relative;">
                        <div id="loading-custom" class="custom-loading"><img width="48" src="<?php echo skin_url(); ?>/images/loading.gif"></div>
                        <input type="hidden" class="hidden" id="choose" name="choose" value="avatar">
                        <input type="hidden" class="hidden" id="x" name="x">
                        <input type="hidden" class="hidden" id="y" name="y">
                        <input type="hidden" class="hidden" id="w" name="w">
                        <input type="hidden" class="hidden" id="h" name="h">
                        <input type="hidden" class="hidden" value="" name="image_w" id="image_w">
                        <input type="hidden" class="hidden" value="" name="image_h" id="image_h">
                        <input style="display:none;" accept="image/*" onchange="readURL(this);" name="fileupload" id="ImageUploader_image" type="file">
                        <img id="uploadPreview" src="" style="display:none; max-width:100%;">
                    </div>
                    <div class="modal-footer text-right">
                        <button class="btn btn-gray" class="close" data-dismiss="modal" aria-label="Close">Cancel</button>
                        <input id="btnSaveView2" disabled="disabled" class="btn btn-primary" type="submit" name="yt2" value="Save and View">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--model bootstrap logo-->
    <div class="modal fade" id="imageCropperlogo-modal" tabindex="-1" role="dialog" aria-labelledby="modal-label" style="display: none;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="<?php echo base_url('/profile/save_media'); ?>" enctype="multipart/form-data" id="crop-logo">
                    <div class="modal-header box-cyan text-white">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="modal-label">Crop Logo</h4>
                    </div>
                    <div class="modal-body" style="position: relative;">
                        <div id="loading-custom" class="custom-loading"><img width="48" src="<?php echo skin_url(); ?>/images/loading.gif"></div>
                        <input type="hidden" class="hidden" id="choose" name="choose" value="logo">
                        <input type="hidden" class="hidden" id="x" name="x">
                        <input type="hidden" class="hidden" id="y" name="y">
                        <input type="hidden" class="hidden" id="w" name="w">
                        <input type="hidden" class="hidden" id="h" name="h">
                        <input type="hidden" class="hidden" value="" name="image_w" id="image_w">
                        <input type="hidden" class="hidden" value="" name="image_h" id="image_h">
                        <input style="display:none;" accept="image/*" onchange="readURL1(this);" name="fileupload" id="ImageUploader_image1" type="file">
                        <img id="uploadPreview" src="" style="display:none; max-width:100%;">
                    </div>
                    <div class="modal-footer text-right">
                        <button class="btn btn-gray" class="close" data-dismiss="modal" aria-label="Close">Cancel</button>
                        <input id="btnSaveView2" disabled="disabled" class="btn btn-primary" type="submit" name="yt2" value="Save and View">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--model bootstrap banner-->
    <div class="modal fade" id="imageCropperbanner-modal" tabindex="-1" role="dialog" aria-labelledby="modal-label" style="display: none;">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <?php $url_save_media = ( isset($change_media) ) ? $change_media : base_url('/profile/save_media') ;?>
                <form method="POST" action="<?php echo $url_save_media; ?>" enctype="multipart/form-data" id="crop-banner">
                    <div class="modal-header box-cyan text-white">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="modal-label">Crop Banner</h4>
                    </div>
                    <div class="modal-body" style="position: relative;">
                        <div id="loading-custom" class="custom-loading"><img width="48" src="<?php echo skin_url(); ?>/images/loading.gif"></div>
                        <input type="hidden" class="hidden" id="choose" name="choose" value="banner">
                        <input type="hidden" class="hidden" id="x" name="x">
                        <input type="hidden" class="hidden" id="y" name="y">
                        <input type="hidden" class="hidden" id="w" name="w">
                        <input type="hidden" class="hidden" id="h" name="h">
                        <input type="hidden" class="hidden" value="" name="image_w" id="image_w">
                        <input type="hidden" class="hidden" value="" name="image_h" id="image_h">
                        <input style="display:none;" accept="image/*" onchange="readURL2(this);" name="fileupload" id="ImageUploader_image2" type="file">
                        <img id="uploadPreview" src="" style="display:none; max-width:100%;">
                    </div>
                    <div class="modal-footer text-right">
                        <button class="btn btn-gray" class="close" data-dismiss="modal" aria-label="Close">Cancel</button>
                        <input id="btnSaveView2" disabled="disabled" class="btn btn-primary" type="submit" name="yt2" value="Save and View">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <style type="text/css">
        .edit-profile{display: none;}
        .profile-image:hover .profile-edit-photo{display: block;}
        .profile-edit-photo{display: none;position: absolute;text-align: center;z-index: 99;top: 50%;left:0;width: 100%;}
        .profile-edit-photo .profile-action-edit{width: 100%;height: 100%;display: table;table-layout: fixed;}
        .profile-edit-photo .profile-action-edit a{padding: 5px 10px;float: none;font-size: 16px;color:#fff;background: rgba(0,0,0,0.65);}
        .jcrop-keymgr{opacity: 0 !important;}
        .impromation-project .logo-company{z-index: 99;}
        .image-banner:hover + .banner-custom,
        .banner-custom:hover{display: block;}
        .btn-file {position: relative;overflow: hidden;}
        .btn-file input[type=file] {position: absolute;top: 0;right: 0;min-width: 100%;min-height: 100%;font-size: 100px;text-align: right;filter: alpha(opacity=0);opacity: 0;outline: none;background: white;cursor: inherit;display: block;}
        .delete-image-certifications{position: absolute;top: 0;right: 15px;color: red !important;font-size: 13px;}

        /*Logo*/
        .profile-edit-photo.custom-logo{
            top: 0;
            left: 0;
            width: 60px;
            height: 60px;
            background: rgba(0,0,0,0.65);
            margin-top: 10px;
            border-radius: 50%;
        }
        .profile-edit-photo.custom-avatar{
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.65);
            border-radius: 50%;
        }
        .profile-edit-photo.custom-logo a,
        .profile-edit-photo.custom-avatar a{
            display: table-cell;
            vertical-align: middle;
            background: none;
            color: #fff;
        }
        .share_click{
        	border: 1px solid #378c8c;
        }
        @media screen and ( max-width: 768px ){
            .impromation h5 strong{font-size: 12px;}
            .impromation p span,.impromation p {font-size: 10px;}
            .impromation-project .logo-company img{width: 40px ;height:40px; margin-top: 0}
            .profile-edit-photo.custom-logo{width: 40px ;height:40px; margin-top: 0}
            .impromation {
                padding-bottom: 0px;
                padding-top: 0px;
            }
            body .btn {
                padding: 5px;
                font-size: 15px;
            }
            body .btn#btn-add-more{
                padding: 3px;
                font-size: 17px;
                padding: 5px 10px;
            }
        }
    </style>
<?php endif; ?>

<script type="text/javascript">
    $(function () {
        $(document).on("click", ".impromation-project .glyphicon-menu-up", function () {
            $(this).parents(".impromation-project").find(".dropdown-impromation-menu").toggleClass("block");
            return false;
        });

        $(".dropdown-impromation-menu .invite_member").click(function () {
            $("#add_tems").trigger("click");
        });

        // Get cookie to show or hide banner
        var show_banner = getCookie("show_banner");
        if (show_banner != "") {
            $('.banner-box .banner').addClass('collapse-banner');
            $('.show_hide_background').html('Show background');
            $('.dropdown-impromation > span.glyphicon').addClass('glyphicon-menu-up').removeClass('glyphicon-menu-down');
        }

        $('.edit_background').click(function () {
            $('#ImageUploader_image2').click();
            return false;
        });

        $('.show_hide_background').click(function () {
            $(this).parents(".impromation-project").find(".dropdown-impromation-menu").removeClass("block");
            if ($('.banner-box .banner').hasClass('collapse-banner')) {
                $('.show_hide_background').html('Hide background');
                $('.banner-box .banner').removeClass('collapse-banner');
                $('.dropdown-impromation > span.glyphicon').removeClass('glyphicon-menu-up').addClass('glyphicon-menu-down');
                setCookie("show_banner", "", -1);
            } else {
                $('.show_hide_background').html('Show background');
                $('.banner-box .banner').addClass('collapse-banner');
                $('.dropdown-impromation > span.glyphicon').removeClass('glyphicon-menu-down').addClass('glyphicon-menu-up');
                setCookie("show_banner", "yes", 7);
            }
        });

        function setCookie(cname, cvalue, exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            var expires = "expires=" + d.toUTCString();
            document.cookie = cname + "=" + cvalue + "; " + expires;
        }

        function getCookie(cname) {
            var name = cname + "=";
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ')
                    c = c.substring(1);
                if (c.indexOf(name) == 0)
                    return c.substring(name.length, c.length);
            }
            return "";
        }
    });
    $(document).ready(function(){

        if(screen.width < 768){

            var height = (screen.width/1366) * 300;
            $(".banner-box .banner").css("height",height+"px");
        }
        console.log(height);
        

    });
</script>