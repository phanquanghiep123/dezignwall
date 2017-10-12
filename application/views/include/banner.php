<link rel="stylesheet" type="text/css" href="<?php echo skin_url(); ?>/css/jquery.Jcrop.css">
<link rel="stylesheet" type="text/css" href="<?php echo skin_url(); ?>/css/jquery.Jcrop.min.css">
<script src="<?php echo skin_url() ?>/js/jquery.Jcrop.js"></script>
<script src="<?php echo skin_url() ?>/js/jquery.Jcrop.min.js"></script>
<script src="<?php echo skin_url() ?>/js/profile-edit.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="<?php echo skin_url(); ?>/js/jquery-ui.js"></script>
<style type="text/css">
    #box-banner .impromation-project .logo-company img{
        width: 60px;
        height: 60px;
        margin-top: 10px;
    }
    #box-banner .impromation{
        padding-bottom: 10px;
        padding-top: 10px;
    }
    #box-banner .banner.collapse-banner {
        background: url('') !important;
    }
</style>
<section class="section banner-box" id="box-banner" >
    <div id="crop-avatar-company">
        <div class="relative">
            <?php 
                $banners = skin_url("/images/image-upload1.png");
                $logos   = skin_url("/images/logo-company.png");
                if(@$logo != null) $logos       = base_url($logo);
                if(@$banner != null) $banners   = base_url($banner);
            ?>
            <div class="banner image-banner text-center">
                <img id="bannershow" class="none" style="display: none !important;" src="<?php echo $banners ;?>">
                <div class="show-banner" style="background-image: url('<?php echo $banners;?>');"> </div>
            </div>
            <?php if(@$action == "edit"):?>
            <div class="profile-edit-photo banner-custom">
                <div class="profile-action-edit">
                    <a class="avatar-view text-white" data-type="banner" href="javascript:;" data-img="<?php echo $banner ;?>"><i class="fa fa-3 fa-pencil"></i> <small>  Edit Background</small></a>
                </div>
            </div>
            <?php endif;?>
            <div class="impromation-project" style="display:block;">
                <div class="container relative">
                    <div class="impromation-project-dropdown">
                        <?php if(@$action == "view"):?>
                        <div class="dropdown-impromation relative">
                            <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>
                            <ul class="dropdown-impromation-menu" id="deziwall">
                                <li><a href="#" class="not-report" data-reporting="company" id="share-social" data-title="Decor Components, Inc" data-type="profile" data-id="<?php echo @$id?>">Share Profile</a></li>
                                <li><a href="#" class="not-report" data-reporting="company" id="report-image" data-title="Decor Components, Inc" data-type="member" data-id="<?php echo @$id?>">Report Profile</a></li>
                            </ul>
                        </div>
                        <?php endif;?>
                    </div>
                    <div class="logo-company profile-image relative">
                        <img id="avatarshow" class="media-object avatar-full" src="<?php echo $logos; ?>">
                        <?php if(@$action == "edit"):?>
                            <div class="profile-edit-photo custom-logo">
                                <div class="profile-action-edit">
                                    <a class="avatar-view text-white" data-type="logo" href="javascript:;" data-img ="<?php echo $logos; ?>"><i class="fa fa-camera"></i></a>
                                </div>
                            </div>
                        <?php endif?>
                    </div>
                    <div class="impromation">
                        <h5><strong><?php echo @$company_name;?></strong></h5>
                        <p><span style="text-transform: capitalize;"><?php echo @$business_type;?></span>  <?php echo (@$business_description != null && trim($business_description) != "") ? "| ".$business_description : ""?> </p>
                    </div>
                </div>
            </div>
            <div class="action-company">
                <ul class="list-inline">
                    <?php
                        $disabled = "disabled";
                        if($activer_user == true){
                            $disabled = "";
                        }
                    ?>
                    <?php if(@$is_owner != false):?>
                        <?php if(@$is_follow):?>
                            <li><button <?php echo $disabled ;?> id="follow-company" title="Un following this company" data-id="<?php echo @$company_id?>" class="btn btn-gray">Unfollow</button></li>
                        <?php else:?>
                            <li><button <?php echo $disabled ;?> id="follow-company" title="Following this company" data-id="<?php echo @$company_id?>" class="btn btn-gray">Follow</button></li>
                        <?php endif;?>
                        <?php if(@$is_favorite):?>
                            <li><button <?php echo $disabled ;?> id="favorite-company" title="Un favorite this company" data-id="<?php echo @$company_id?>" class="btn btn-gray">Unfavorite</button></li>
                        <?php else:?>
                            <li><button <?php echo $disabled ;?> id="favorite-company" title="Favorite this company" data-id="<?php echo @$company_id?>" class="btn btn-white btn-border-yellow">Favorite</button></li>
                        <?php endif;?>
                    <?php endif;?>
                    <li><button class="btn btn-primary share_click" data-toggle="modal" data-target="#share-modal" data-title="Decor Components, Inc" data-type="profile" data-id="<?php echo @$company_id;?>">Share Profile</button></li>
                </ul>
            </div>

        </div>
        <?php if(@$action == "edit"):?>
        <?php $this->load->view("include/modal-cropper-company");?>
        <?php endif;?>
    </div>
</section>
<style type="text/css">
    .btn-white{background-color: #fff; color: #000;}
    .btn-border-yellow{border-color: #ff9900;}
    .action-company{position: absolute; right: 10px; bottom: 10px;}
    #box-banner .show-banner{background-size:cover;background-position: center;width: 100%;height: 300px;background-repeat: no-repeat;background-color: #f1f1f1;}
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
   body .avatar-view{
        display:inherit; 
        margin: auto; 
        height: auto;
        width: auto;
   }
</style>
<script type="text/javascript">
    $("#follow-company").click(function(){
        if (check_login() == false){
            return false;
        }
        var company_id = $(this).attr("data-id");
        var _this = $(this);
        $.ajax({
            url      : base_url + "company/follow",
            type     : "post",
            dataType : "json",
            data     : { id : company_id },
            success  :function (data){
                console.log(data);
                if(data["status"] == "success"){
                    if(data["response"] == "add"){
                        _this.attr("title","Un following this company");
                        _this.text("Unfollow");  
                    }else{
                        _this.attr("title","Following this company");
                        _this.text("Follow");
                    }
                }
            },
            error :function (){
                alert("Error!");
            }
        });
        return false;
    });
    $("#favorite-company").click(function(){
        if (check_login() == false){
            return false;
        }
        var company_id = $(this).attr("data-id");
        var _this = $(this);
        $.ajax({
            url      : base_url + "company/favorite",
            type     : "post",
            dataType : "json",
            data     : { id : company_id },
            success  :function (data){
                console.log(data);
                if(data["status"] == "success"){
                    if(data["response"] == "add"){
                        _this.attr("title","Un favorite this company");
                        _this.text("Unfavorite");  
                    }else{
                        _this.attr("title","Favorite this company");
                        _this.text("Favorite");
                    }
                }
            },
            error :function (){
                alert("Error!");
            }
        });
        return false;
    });
</script>