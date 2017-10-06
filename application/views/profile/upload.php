<link href="<?php echo skin_url(); ?>/css/page/image-upload.css" rel="stylesheet">
<!--<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">-->
<link href="<?php echo skin_url(); ?>/css/upload.css" rel="stylesheet">
<script src="<?php echo skin_url(); ?>/js/jquery-ui.js"></script>
<script src="<?php echo skin_url() ?>/js/jquery.Jcrop.min.js"></script>
<script src="<?php echo skin_url(); ?>/js/upload-photos.js"></script>
<script src="<?php echo skin_url() ?>/js/jquery.Jcrop.js"></script>
<script src="<?php echo skin_url() ?>/js/jquery.Jcrop.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo skin_url(); ?>/css/jquery.Jcrop.css">
<link rel="stylesheet" type="text/css" href="<?php echo skin_url(); ?>/css/jquery.Jcrop.min.css">
<script src="<?php echo skin_url() ?>/js/js-xlsx/shim.js"></script>
<script src="<?php echo skin_url() ?>/js/js-xlsx/jszip.js"></script>
<script src="<?php echo skin_url() ?>/js/js-xlsx/xlsx.js"></script>
<script src="<?php echo skin_url() ?>/js/js-xlsx/dist/ods.js"></script>
<style type="text/css">
    #file-upload{background-color: rgba(0, 0, 0, 0.67); color: #fff;}
    #section-cropper .autoCropArea{margin:0 auto; max-width: 100%;}
    .box-button-upload{
        position: absolute;
        top: 37%;
        left: 41%;
        width: 240px;
    }
    @media screen and ( max-width: 768px ){
        .box-button-upload{
            left: 0;
            right: 0;
            width: 100%;
        }
        .action-image ul {
            text-align: right !important;
        }
    }
    .action-image button{background-color: transparent; float: right; border: none; width: auto; min-width: inherit;}
    .cropper-crop{display: none;}
    .cropper-crop-box{display: none;}
    .action-image button.multi-album {
        background-color: #37a7a7;
        border-color: #000;
    }
    .list-show-album li{display: inline-block;;list-style: none;}
    .list-show-album li img{width: 100px;height: 100px;}
    .list-show-album li{margin: 10px ;}
    .list-show-album{width: 100%; text-align: center;}
    .product_dimensions {display: inline-block;}
    .product_dimensions li span {margin-right: 10px;}
    .product_dimensions li:first-child{padding-left: 0;}
    .product_dimensions li{display: inline-block; list-style: none;margin-left: 20px;}
    .product_dimensions li input{ width: 125px; display: inline-block;}
    .product_dimensions{padding-left: 0;margin-left: 0}
    .box-button-mutil-view{display: block;}
    .add-a-story p {line-height: 1.5; font-size: 14px;}
    .add-a-story .combination{padding-left: 15px;}
    .add-a-story .combination li p{margin-bottom: 0;line-height: 1}
    .add-a-story .add-story {
        border: 3px solid #37a7a7;
        border-radius: 5px; 
        font-size: 16px;
        position: absolute;
        right: 10px;
        bottom: 13px;
    }
    @media screen and (max-width: 768px){
        .add-a-story .add-story{position: static;}
    	.box-button-mutil-view{display: none !important;}
        .product_dimensions li input{width:  100%; display:  block;}
        .product_dimensions{width: 100%;}
        .product_dimensions li{width:  100%; display:  block; padding-left: 0;margin-left: 0;margin-bottom: 10px;}
        .product_dimensions li span{width:  100%; display:  block; margin-bottom: 10px;}
    }
 
    .profile-edit-photo{display: none;position: absolute;text-align: center;z-index: 99;top: 50%;left:0;width: 100%;}
    .article-content a {color: #37a7a7 ; }
    .none{display: none !important; visibility: hidden !important; opacity: 0 !important;height: 0 !important;width: 0 !important;}
    .border-error{

        border: 1px solid red !important;

    }

    .action-comments{

        position: absolute;

        z-index: 100;

        top: 0;

        right: 30px

    }

    .default-hidden{

        display: none;

    }

    .block{

        display: block !important;

    }
    .loadding-upload-content{
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.15);
        position: absolute;
        right: 0;
        top: 0;
        left: 0;
        bottom: 0;
        display: none;
        cursor: wait
    }
    .loadding-upload-content img{
        width: 30px;
        height: 30px;
        vertical-align: middle;
        color: #fff;
        font-size: 20px;
    }
    body ul#keyword-tag{
        height: 150px;
        border-radius: 0;
    } 
    .list-photos {
        border: 1px solid #ccc;
        border-top: none;
        padding: 10px;
        min-height: 232px;
        width: 100%;
        margin-bottom: 20px;
    }
    #insert-link-box{
        background: #000;
        position: absolute;
        color: #fff;
        padding: 5px;
        top: 0;
        border-radius: 5px;
        left: 0;
    }
    #insert-link-box a{color: #fff;}
    #insert-link-box:before{
        content: "";
        display: block;
        width: 0;
        height: 0;
        margin-left: -35px;
        border-left: 0px solid transparent;
        border-right: 71px solid transparent;
        border-bottom: 22px solid #000;
        position: absolute;
        bottom: 100%;
        left: 41%;

    }
    #insert-link-box input{background:#000; border: none; margin: 0 10px;}
    @media (min-width: 768px) {

        .sm-remove-padding-left{

            padding-left: 0 !important;

        }

        .sm-remove-padding-right{

            padding-right: 0 !important;

        }

    }

    .profile-edit-photo .profile-action-edit{width: 100%;height: 100%;display: table;table-layout: fixed;}

    .profile-edit-photo .profile-action-edit a{padding: 5px 10px;float: none;font-size: 16px;color:#fff;background: rgba(0,0,0,0.65);}

    .jcrop-keymgr{opacity: 0 !important;}

    .impromation-project .logo-company{z-index: 99;}

    .image-banner:hover + .banner-custom,
    .banner-custom:hover{display: block;}
    .content a{
        color: #37a7a7;
    }
   

   

    #bx-pager{

        margin-top: 10px;

    }

    .slider-image{

        background-size: cover;

        background-repeat: no-repeat;

        width: 100%;

        height: 300px;

    }

    .slider-content{

        background: #fff;

    }

    .slider-top .bx-wrapper .bx-controls-direction a {

        width: 35px;

        height: 95px;

        background-position: 0 0;

        top: 42%;

        background-size: 100%;

    }
    .panel.social-profile{padding-bottom: 7px;}
    .social-profile h3{

        margin-bottom: 3px;

        margin-top: 0;

        font-size: 32px;

        color: #7F7F7F;

    }

    .social-profile hr{

        margin-bottom: 10px;

        margin-top: 10px;

        border-top: 2px solid;

    }

    #share-blog-modal #photo-share{

        border: 1px solid #f5f5f5;

    }

    .impromation-project input::-webkit-input-placeholder {

       color: #fff;

       font-size: 22px;

    }



    .impromation-project input:-moz-placeholder { /* Firefox 18- */

       color: #fff;

       font-size: 22px;

    }



    .impromation-project input::-moz-placeholder {  /* Firefox 19+ */

       color: #fff;

       font-size: 22px; 

    }



    .impromation-project input:-ms-input-placeholder {  

       color: #fff;

       font-size: 22px;  

    }
    .impromation-project {
        display: block;
        position: absolute;
        left: 0;
        text-align: right;
    }

    .impromation-project .glyphicon-menu-down {
        color: #fff;
        font-size: 20px;
        cursor: pointer;
        display: inline-block;
        padding: 5px 15px 10px 10px;
        position: relative;
        z-index: 10;
    }
    #view-more-comment{color: #7f7f7f;}
    #view-more-comment span{font-size: 16px; margin-right: 7px;}
    .impromation-project .dropdown-impromation-menu {
        position: absolute;
        right: 15px;
        top: 100%;
        z-index: 101;
        background-color: rgba(255, 255, 255, 0.81);
        padding: 5px 20px 5px 5px;
        list-style: none;
        border-radius: 5px;
        text-align: left;
        display: none;
    }

    .impromation-project .title-blog {
        text-align: left;
        
    }
    .banner-box .banner{
        height: 450px !important;
        width: 100%!important;
        background-position: center;
        background-size: contain;
        background-repeat: no-repeat;
    }
    .impromation-project .title-blog h1{margin: 5px 0px 5px;padding: 0px;}

    .dropdown-impromation-menu a {
        color: #212121;
        font-size: 12px;
    }
    .comment-wrap{
        max-height: 400px;
        overflow-x: hidden;
        overflow-y: auto;
    }
    @media (min-width: 768px) {

        .sm-remove-padding{

            padding: 0 !important;

        }

        .avatar-slider{

            margin-right: 0;

            padding-right: 0;

        }

        .profile-slider{

            margin-left: -20px;

            padding-left: 0;

        }

    }
</style>
<div id="wrapper">
    <form action="<?php echo base_url('/profile/upload_images/' . $project_id . '/' . $category_id . '/'); ?>" method="POST" enctype="multipart/form-data" id="upload-form">
        <div id="section-cropper" class="box-public box-lg relative">
            <div class="box-bg-gray">
                <div class="top full-page">
                    <div class="top-upload box-padding-page">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 ">
                                    <h1 class="text-sm-center">You are in Image Upload mode... <span>Drag and Drop Image or</span></h1>
                                    <p class="text-sm-center">Uploaded images should be Hi Resolution images (1000 pixels wide or more)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="section section-upload text-center ">
                    <div class="container">
                        <div class="relative">
                            <div class="custom-loading"><img width="64" src="<?php echo skin_url(); ?>/images/loading.gif"></div>
                            <div class="wrap-cropper relative">
                                <div class="autoCropArea">
                                    <img class="image-cropper" src="<?php echo skin_url(); ?>/images/image-upload1.png">
                                    <input type="hidden" value="null" id="photo_id" name="photo_id">
                                    <input type="hidden" value="null" id="file_name" name="file_name">
                                    <div class="box-button-upload">
                                        <h1><span class="upload-box-button"><?php if ((!isset($is_update_profile) && !$is_update_profile) || true) : ?><button type="button" style="font-size: 23px;" class="btn btn-custom" id="file-upload">Browse for image</button><?php endif; ?></span></h1>
                                        <?php if(!@$wall):?><p style="color:#37a7a7;font-size:12px;">To batch upload <a id="upload-batch" href="#" style="font-size:12px;"><strong>Click Here</strong></a></p><?php endif;?>
                                    </div>
                                </div>
                                <div class="docs-data">
                                    <input type="hidden" class="form-control" id="dataX" placeholder="x">
                                    <input type="hidden" class="form-control" id="dataY" placeholder="y">
                                    <input type="hidden" class="form-control" id="dataWidth" placeholder="width">
                                    <input type="hidden" class="form-control" id="dataHeight" placeholder="height">
                                    <input type="hidden" class="form-control" id="dataRotate" placeholder="rotate">
                                    <input type="hidden" class="form-control" id="dataScaleX" placeholder="scaleX">
                                    <input type="hidden" class="form-control" id="dataScaleY" placeholder="scaleY">
                                </div>
                            </div>
                            <div class="action-image">
                                <ul class="list-inline text-right">
                                    <li class="box-button-mutil-view"><button type="button" class="multi-album btn btn-primary"><img style="margin-right: 10px; width: 28px; margin-bottom: 2px;" src="<?php echo base_url("/skins/images/more-view-white.png");?>"/>Upload Multiples Views</button></li>
                                    <li><button disabled href="#" type="button"  data-method="rotate" data-option="90" title="Rotate 90 degrees"><img src="<?php echo skin_url("images/back.png")?>"></button></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="box-bg-white box-ball box-button-mutil-view">
                         <div class="row">
                             <div class="col-md-12">
                                <input class="none" id="multiple-file-input" type="file" name="album[]" multiple="" accept='image/*' max-uploads = "12" >
                                <div class="logo-album-upload"><p class="text-center"><img style="margin-right: 15px;margin-top: -5px;" src="<?php echo base_url('skins/images/more-view.png')?>">These images will be searchable in your multiple views menu</p></div>
                                <ul class="list-show-album"></ul>
                             </div>
                         </div>
                    </div>
                    <?php if(!@$wall):?><div class="box-bg-white box-ball catalog-box">
                        <div class="row">
                            <div class="col-md-12"><p>Apply image to a catalog</p></div>
                            <div class="col-md-4">
                                <p style="float:left;text-align: right;line-height: 1;">Existing Catalogs:<br>
                                    <span class="text-right" style="font-size:13px; color:#2c9595">Select one only</span>
                                </p> 
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <ul class="list-inline custom">
                                    <?php if(@$manufacturers != "" && is_array($manufacturers)):?>
                                    <?php 
                                    $i = 0;
                                    $catalog = $this->input->get("catalog");
                                    foreach($manufacturers AS $value):?>
                                        <?php $check = "";
                                            if(@$catalog == $value["id"]){
                                                $check = "checked";
                                            }
                                        ?>
                                        <li>
                                            <div class="checkbox check-yelow checkbox-circle">
                                                <input type="radio" name="manufacturers" id="manufacturers-<?php echo $value["id"]?>" value="<?php echo $value["id"]?>" <?php echo $check;?>>
                                                <label for="manufacturers-<?php echo $value["id"]?>">
                                                    <img src="<?php echo base_url($value["logo"]);?>">
                                                </label>
                                            </div>
                                        </li>
                                    <?php endforeach;?>
                                    
                                   <?php endif?>
                                    </ul>
                                </div>
                                <p class="text-right" style="font-size:13px;">To create a new catalog, click here: <span id="add-new-catalog">NEW CATALOG</span></p>
                            </div>
                        </div>
                    </div><?php endif;?>
                    <div class="box-bg-white box-ball">
                        <div class="row">
                            <div class="col-md-4">
                                <p>Is this an image of a:</p>
                            </div>
                            <div class="col-md-8">
                                <ul class="list-inline custom required-group">
                                    <li>
                                        <div class="checkbox check-yelow checkbox-circle">
                                            <input <?php //if(in_array('Project',$image_category)){echo 'checked';}  ?> type="radio" name="project_image" id="project_image" value="Project">
                                            <label for="project_image">
                                                Project
                                            </label>
                                        </div>
                                    </li>
                                    <li><label>or</label></li>
                                    <li>
                                        <div class="checkbox check-yelow checkbox-circle">
                                            <input <?php //if(in_array('Product',$image_category)){echo 'checked';}  ?> type="radio" name="project_image" id="product_image" value="Product">
                                            <label for="product_image">
                                                Product
                                            </label>
                                        </div>
                                        <p class="tag-image"><a href="#">Tag your product by draging the pricetag icon</a></p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div><!--end box-->


                    <div class="box-bg-white box-ball section-product">
                        <div class="row">
                            <div class="col-md-3">
                                <p>Do you offer this product as:</p>
                            </div>
                            <div class="col-md-5">
                                <ul class="list-inline custom">
                                    <li style="padding-left:0;padding-right:0;">
                                        <div class="checkbox check-yelow checkbox-circle">
                                            <input type="radio" <?php //if(@$photo['offer_product']=='Full Custom') { echo 'checked'; }  ?> name="offer_product" id="full_custom" value="Full Custom">
                                            <label for="full_custom">Full Custom</label>
                                        </div>
                                    </li>
                                    <li><label>or</label></li>
                                    <li style="padding-left:0;padding-right:0;">
                                        <div class="checkbox check-yelow checkbox-circle">
                                            <input type="radio" <?php //if(@$photo['offer_product']=='Semi-custom') { echo 'checked'; }  ?> name="offer_product" id="semi_custom" value="Semi-custom">
                                            <label for="semi_custom">Semi-custom</label>
                                        </div>
                                    </li>
                                    <li><label>or</label></li>
                                    <li style="padding-left:0;padding-right:0;">
                                        <div class="checkbox check-yelow checkbox-circle">
                                            <input type="radio" <?php //if(@$photo['offer_product']=='Non-custom') { echo 'checked'; } ?> name="offer_product" id="non_custom" value="Non-custom">
                                            <label for="non_custom">Non-custom</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <p>Item number:</p>
                                    </div>
                                    <div class="col-sm-7">
                                        <input type="text" value="" class="form-control" name="number_code" id="number_code">
                                    </div>
                                </div>
                            </div>
                        </div><!--end row-->

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <p>Single Unit Price:</p>
                                    </div>
                                    <div class="col-sm-7">
                                        <input type="number" value="<?php echo @$photo['unit_price']; ?>" minlength="1" class="form-control" name="unit_price" id="unit_price">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <p>Maximum units at this price:</p>
                                    </div>
                                    <div class="col-sm-7">
                                        <input type="number" value="<?php echo @$photo['maximum_price']; ?>" minlength="1" class="form-control" name="max_unit_price" id="max_unit_price">
                                    </div>
                                </div>
                            </div>
                        </div><!--end row-->
                        <div class="row">
                            <div class="col-sm-12 custom">
                                <div class="checkbox check-yelow checkbox-circle">
                                    <input <?php if (@$photo['sample_pricing'] == 'Sample Apply') {
                                    echo 'checked';
                                } ?> type="checkbox" name="sample_apply" id="sample_apply" value="Sample Apply">
                                    <label for="sample_apply"> or "Sample pricing does not apply"</label>
                                </div>
                            </div>
                        </div><!--end row-->
                    </div><!--end box-->

                    <div class="box-bg-white box-ball section-product">
                        <div class="row">
                            <div class="col-md-12">
                                <p>Product dimensions:</p>
                            </div>
                        </div><!--end row-->

                        <div class="row">
                            <div class="col-md-12">
                                <ul class="product_dimensions">
                                    <li><span>Height:</span><input type="text" class="form-control" name="height"></li>
                                    <li><span>Width:</span><input type="text" class="form-control" name="width"></li>
                                    <li><span>Depth/Projection:</span><input type="number" class="form-control" name="depth_projection"></li>
                                    <li><span>Weight(in lbs.):</span><input type="text" class="form-control" name="weight-in"></li>
                                    <li><span>Weight(in kg.):</span><input type="text" class="form-control" name="weight-kg"></li>
                                </ul>
                            </div>
                        </div><!--end row-->
                        <div class="row">
                            <div class="col-sm-12 custom">
                                <div class="checkbox check-yelow checkbox-circle">
                                    <input <?php if (@$photo['dimensions_apply'] == 'Dimensions Apply') {
                                    echo 'checked';
                                } ?> type="checkbox" name="dimensions_apply" id="dimensions_apply" value="Dimensions Apply">
                                    <label for="dimensions_apply"> Product dimensions do not apply</label>
                                </div>
                            </div>
                        </div><!--end row-->
                    </div><!--end box-->
                    <div class="box-bg-white box-ball">
                        <div class="row">
                            <div class="form-group">
                                <label  class="col-sm-5 control-label">Give this image a title:</label>
                                <div class="col-sm-7">
                                    <input type="text" value="<?php echo @$photo['name']; ?>" class="required form-control" name="product_type" id="product_type">
                                </div>
                            </div>
                        </div><!--end row-->

                        <div class="row">
                            <div class="form-group">
                                <label class="col-sm-5 control-label">Give the photographer credit:</label>
                                <div class="col-sm-7">
                                    <input type="text" value="<?php echo @$photo['photo_credit']; ?>" class="form-control" name="photo_credit" id="photo_credit">
                                </div>
                            </div>
                        </div><!--end row-->
                    </div><!--end box-->
                    <?php
                    //category
                    $indoor = $outdoor = '';
                    $locally = $nationally = $internationally = '';
                    $style = '';
                    $style_value = '';
                    $categorys = '';
                    $categorys_value = '';
                    $location = '';
                    $location_value = '';
                    $comma = '';
                    $comma_value = '';
                    if (isset($category) && count($category) > 0) {
                        foreach ($category as $key => $value) {
                            if ($value['category_id'] == 1) {
                                $indoor = 'checked';
                            }
                            if ($value['category_id'] == 2) {
                                $outdoor = 'checked';
                            }
                            if ($value['category_id'] == 260) {
                                $locally = 'checked';
                            }
                            if ($value['category_id'] == 259) {
                                $nationally = 'checked';
                            }
                            if ($value['category_id'] == 262) {
                                $internationally = 'checked';
                            }
                            if ($value['first_child_category'] == 3) {
                                $style.='<p class="item" data-id="' . $value['category_id'] . '"><span class="text_inser"><span class="text-name">' . $value['title'] . '</span><span class="token-x"><a href="#">x</a></span></span></p>';
                                $style_value.=$value['category_id'] . ',';
                            }
                            if ($value['first_child_category'] == 9 || $value['first_child_category'] == 192) {
                                $categorys.='<p class="item" data-id="' . $value['category_id'] . '"><span class="text_inser"><span class="text-name">' . $value['title'] . '</span><span class="token-x"><a href="#">x</a></span></span></p>';
                                $categorys_value.=$value['category_id'] . ',';
                            }
                            if ($value['first_child_category'] == 215) {
                                $location.='<p class="item" data-id="' . $value['category_id'] . '"><span class="text_inser"><span class="text-name">' . $value['title'] . '</span><span class="token-x"><a href="#">x</a></span></span></p>';
                                $location_value.=$value['category_id'] . ',';
                            }
                            if ($value['first_child_category'] == 263) {
                                $comma.='<p class="item" data-id="' . $value['category_id'] . '"><span class="text_inser"><span class="text-name">' . $value['title'] . '</span><span class="token-x"><a href="#">x</a></span></span></p>';
                                $comma_value.=$value['category_id'] . ',';
                            }
                        }
                    }
                    ?>
                    <div class="box-bg-white box-ball">
                        <div class="row">
                            <div class="col-md-4">
                                <p>Is this an image for:</p>
                            </div>
                            <div class="col-md-8">
                                <ul class="list-inline custom required-group">
                                    <li>
                                        <div class="checkbox check-yelow checkbox-circle">
                                            <input <?php echo $indoor; ?> type="radio" name="location_check" id="indoor" value="1|346">
                                            <label for="indoor">
                                                Indoor
                                            </label>
                                        </div>
                                    </li>
                                    <li><label>or</label></li>
                                    <li>
                                        <div class="checkbox check-yelow checkbox-circle">
                                            <input type="radio" <?php echo $outdoor; ?> name="location_check" id="outdoor" value="2|346">
                                            <label for="outdoor">
                                                Outdoor
                                            </label>
                                        </div>
                                    </li>
                                    <li><label>or</label></li>
                                    <li>
                                        <div class="checkbox check-yelow checkbox-circle">
                                            <input type="radio" <?php if ($outdoor != '' && $indoor != '') { echo $indoor;} ?> name="location_check" id="both" value="1|346,2|346">
                                            <label for="both">
                                                Both
                                            </label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-6 control-label">What “style” best describes this image:</label>
                                <div class="col-sm-6">
                                    <input type="hidden" value="<?php echo $style_value; ?>" class="form-control required-custom" name="style" id="style">
                                    <div class="wrap-custom-input relative">
                                        <div class="custom-input-complete">
                                            <?php echo $style; ?>
                                            <input autocomplete="off" type="text" name="style_other"  onkeyup="get_category_children(this, '3',event.keyCode);">
                                        </div>
                                        <div class="custom-auto-complete">
                                            <ul>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-6 control-label">What “category” best describes this image:</label>
                                <div class="col-sm-6">
                                    <input type="hidden" value="<?php echo $categorys_value; ?>" class="form-control" name="category" id="category">
                                    <div class="wrap-custom-input relative">
                                        <div class="custom-input-complete">
                                            <?php echo $categorys; ?>
                                            <input autocomplete="off" type="text" name="category_other"  onkeyup="get_category_children(this,'9,192',event.keyCode);">
                                        </div>
                                        <div class="custom-auto-complete">
                                            <ul>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-6 control-label">What “location” best describes this image:</label>
                                <div class="col-sm-6">
                                    <input type="hidden" value="<?php echo $location_value; ?>" class="form-control required-custom" name="location" id="location">
                                    <div class="wrap-custom-input relative">
                                        <div class="custom-input-complete">
                                            <?php echo $location; ?>
                                            <input autocomplete="off" type="text" name="location_other"  onkeyup="get_category_children(this, '215',event.keyCode);">
                                        </div>
                                        <div class="custom-auto-complete">
                                            <ul>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 form-group">
                                <p>Image description (144 character to promote and sell your product or service):</p>
                                <textarea class="auto-height" name="description" class="form-control" id="description" cols="2" maxlength="144"></textarea>
                            </div>
                            <?php
                            $keyw = '';
                            $keyw_value = '';
                            if (isset($keywords) && count($keywords) > 0) {
                                foreach ($keywords as $key => $value) {
                                    $keyw.='<p class="item" data-id="' . $value['keyword_id'] . '"><span class="text_inser"><span class="text-name">' . $value['title'] . '</span><span class="token-x"><a href="#">x</a></span></span></p>';
                                    $keyw_value.=$value['keyword_id'] . ',';
                                }
                            }
                            ?>
                            <div class="col-md-12 form-group">
                                <p>Use keywords to describe this image (seperate words with a comma):</p>
                                <!--<textarea class="required" name="keywords" id="keywords"></textarea>-->
                                <input value="<?php echo @$keyw_value; ?>"  type="hidden" class="form-control required-custom" name="keywords" id="keywords">
                                <div class="wrap-custom-input relative">
                                    <div class="custom-input-complete input-textarea">
                                        <?php echo @$keyw; ?>
                                        <input autocomplete="off" type="text" name="keywords_other"  onkeyup="get_keywords(this,event.keyCode);">
                                    </div>
                                    <div class="custom-auto-complete">
                                        <ul>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div><!--end row-->
                    </div><!--end box-->

                    <?php if (isset($project_id) && isset($category_id) && $project_id != null && $category_id != null && is_numeric($category_id) && is_numeric($project_id)): ?>
                        <div class="box-bg-white box-ball section-products">
                            <div class="row">
                                <div class="col-md-12"><p>Product Info</p></div>
                                <div class="col-md-12 form-group">
                                    <div class="row">
                                        <div class="col-sm-7">
                                            <div class="row form-group">
                                                <div class="col-sm-4 sm-text-right"> 
                                                    <label>Product Name: </label> 
                                                </div>
                                                <div class="col-sm-8">
                                                    <input  type="text" value="" class="form-control required"  name="product[product_name]"  id="product-name">
                                                </div> 
                                            </div> 
                                            <div class="row form-group">
                                                <div class="col-sm-4 sm-text-right">
                                                    <label>Product No: </label> 
                                                </div> 
                                                <div class="col-sm-8"> 
                                                    <input type="number" value="" class="form-control product-no required" name="product[product_no]"  class="" id="product-no">
                                                </div>
                                            </div>
                                            <div class="row form-group"> 
                                                <div class="col-sm-4 sm-text-right"> 
                                                    <label>Price: </label> 
                                                </div>
                                                <div class="col-sm-8">
                                                    <input type="number" value="" class="form-control" name="product[price]" min="1" id="price" step="0.01">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-sm-4 sm-text-right"> 
                                                    <label>Qty: </label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <input type="number" value="" class="form-control" name="product[qty]" class="qty" id="qty">
                                                </div> 
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-sm-4 sm-text-right">
                                                    <label>FOB: </label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <input type="text" value="" class="form-control" name="product[fob]" class="fob" id="fob">
                                                </div> 
                                            </div> 
                                        </div> 
                                        <div class="col-sm-5">
                                            <div class="form-group">
                                                <label>Product Notes: </label> 
                                                <textarea style="height:200px;"  name="product[product_notes]" cols="40" rows="10" class="product-notes"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!--end row-->
                        </div><!--end box-->
                    <?php endif; ?>
                    <div class="box-bg-white box-ball">
                        <div class="row">
                            <div class="col-md-12">
                                <p>Is your product or service available..:</p>
                            </div>
                            <div class="col-md-12 form-group">
                                <ul class="list-inline custom required-group">
                                    <li>
                                        <div class="checkbox check-yelow checkbox-circle">
                                            <input <?php echo $locally; ?> type="radio" name="source" id="locally" value="260|258">
                                            <label for="locally">
                                                Locally
                                            </label>
                                        </div>
                                    </li>
                                    <li><label>or</label></li>
                                    <li>
                                        <div class="checkbox check-yelow checkbox-circle">
                                            <input <?php echo $nationally; ?> type="radio" name="source" id="nationally" value="259|258">
                                            <label for="nationally">
                                                Nationally
                                            </label>
                                        </div>
                                    </li>
                                    <li><label>or</label></li>
                                    <li>
                                        <div class="checkbox check-yelow checkbox-circle">
                                            <input <?php echo $internationally; ?> type="radio" name="source" id="internationally" value="262|258">
                                            <label for="internationally">
                                                Internationally
                                            </label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div><!--end row-->
                    </div><!--end box-->

                    <div class="box-bg-white box-ball">
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <p>List any certifications (seperate words with a comma):</p>
                                <!--<textarea name="compliance" style="display:none;"></textarea>-->
                                <input value="<?php echo $comma_value; ?>"   type="hidden" class="form-control required-custom" name="compliance" id="compliance">
                                <div class="wrap-custom-input relative">
                                    <div class="custom-input-complete input-textarea">
                                        <?php echo $comma; ?>
                                        <input autocomplete="off" type="text" name="compliance_other"  onkeyup="get_category_children(this, '263',event.keyCode);">
                                    </div>
                                    <div class="custom-auto-complete">
                                        <ul>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div><!--end row-->
                    </div><!--end box-->
                    <div class="box-bg-white box-ball add-a-story">
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p>Add a Story (Optional)</p>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <img src="<?php echo skin_url("images/story-icon.png")?>"/>
                                            </div>
                                            <div class="col-md-9">    
                                                <p>Add up to 6-Slides to tell a story about your product or project. <br>Stories allow your clients to get to know your brand, your story,<br> and the behind the scenes info that helps them make decisions.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <p>Pick any combination of the following to tell your story:</p>
                                        <ul class="combination">
                                            <li><p>Add a Profile Slide - Highlight a client, designer, team member, etc.</p></li>
                                            <li><p>Add an Editorial Slide - Provide a brief editorial to tell your story.</p></li>
                                            <li><p>Add a Private Image/Video Slide - Share some behind the scense visuals.</p></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-12" style="position:static">
                                        <a href="#" class="btn btn-lg add-story">Add a Story</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 custom">
                            <div class="checkbox check-yelow checkbox-circle small">
                                <input type="checkbox" name="save_multiple" id="check-susses-upload" value="save">
                                <label for="check-susses-upload">
                                    Click here to save settings for multiple image uploads
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6 text-right">
                            <div class="action-save">
                                <input type="hidden" value="" name="story" id="story-id">
                                <input type="hidden" name="w_box" id="w_box">
                                <input type="hidden" name="h_box" id="h_box">
                                <input type="hidden" name="point_tag" id="point-tag" value="">
                                <input type="hidden" name="cropper_data" id="cropper-data" value="">
                                <?php $cancel_url = (is_numeric($project_id) && is_numeric($category_id)) ? base_url("designwalls/index/{$project_id}/{$category_id}/") : base_url("profile/myphoto"); ?>
                                <a href="<?php echo $cancel_url; ?>" id="btn-delete-photo" class="btn btn-lg btn-custom btn-default">Cancel</a>
                                <?php if ((!isset($is_update_profile) && !$is_update_profile) || true) : ?><input type="submit" class="btn btn-lg btn-custom btn-primary" name="submit" value="Save/Post"><?php endif; ?>
                                <div class="loading-fixed">
                                    <div class="text-center custom-loading-fixed">
                                        <img width="84" src="<?php echo skin_url(); ?>/images/loading.gif">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!--end row-->
                </div>
            </div>
        </div>
       <!-- <input type="file" name="xlfile" id="xlf" />
        <pre id="out"></pre>-->
    </form>
</div>

<!--model bootstrap logo-->
<div class="modal fade" id="imageCropper-modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="modal-label"   style="display: none;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="POST" action="<?php echo base_url('profile/save_image_photo/' . $project_id . '/' . $category_id . '/'); ?>" enctype="multipart/form-data" id="cropimage">
                <div class="modal-header box-cyan text-white">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="modal-label">Crop Image</h4>
                </div>
                <div class="modal-body" style="position: relative;">
                    <div id="loading-custom" class="custom-loading"><img width="48" src="<?php echo skin_url(); ?>/images/loading.gif"></div>
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
<?php $this->load->view("include/modal_choose_story"); ?>
<?php $this->load->view("include/modal-album-chosse"); ?>
<?php $this->load->view("include/share"); ?>
<?php $this->load->view("include/add-catalog"); ?>
<?php $this->load->view("include/modal-batch-upload"); ?>
<?php if (isset($is_update_profile) && $is_update_profile) : ?>
<?php $this->load->view("include/message_upload"); ?>
<?php endif; ?>
<?php $this->load->view("include/crop-logo-catalog")?>
<div class="modal fade popup" id="upload-batch-success" tabindex="-1" role="dialog" >
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Congrats!</h4>
      </div>
      <div class="modal-body"> 
            <h3 class="text-center" style=" margin-bottom: 0; ">Catalog uploaded successfully!</h3>
            <div class="text-center">
                <a  href="<?php echo base_url("profile")?>" style=" font-size: 21px; margin: 20px;" class="btn btn-default">Your profile</a>
                <a  href="<?php echo base_url("profile/edit")?>" style=" font-size: 21px; margin: 20px;" class="btn btn-primary" id="sent-report">Proof catalog</a>
            </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>
<script>
    $("#sample_apply").click(function () {
        if ($(this).is(":checked")) {
            $("#max_unit_price").val('');
            $("#unit_price").val('');
            $("#max_unit_price").removeClass('required-number');
            $("#unit_price").removeClass('required-number');
        } else {
            $("#max_unit_price").addClass('required-number');
            $("#unit_price").addClass('required-number');
        }
        return;
    });

    $("#max_unit_price").blur(function () {
        var max_price = $.trim($(this).val());
        var unit_price = $.trim($("#unit_price").val());
        if (max_price != '' && unit_price != '' && !isNaN(max_price) && !isNaN(unit_price)) {
            $("#sample_apply").prop('checked', false);
        }
    });

    $("#unit_price").click(function () {
        var unit_price = $.trim($(this).val());
        var max_price = $.trim($("#max_unit_price").val());
        if (max_price != '' && unit_price != '' && !isNaN(max_price) && !isNaN(unit_price)) {
            $("#sample_apply").prop('checked', false);
        }
    });
    $("#manufacture").autocomplete({
        source: function( request, response ) {
            $.ajax({
              url: base_url + "profile/get_manufacture",
              type:"post",
              dataType: "json",
              data: {
                "manufacture": request.term
              },
              success: function( data ) {
                response(data);
              }
            });
        }
    });
    $(document).on("click","#batch_upload_file #lable-upload",function(e){
        e.stopPropagation() ;
        $("#batch_upload_file #file-logo").trigger("click");
        return false;
    });
    $(document).on("click","#modal_add_catalog #lable-upload",function(e){
        e.stopPropagation() ;
        $("#modal_add_catalog #file-logo").trigger("click");
        return false;
    });
    $(document).on("click","#upload-batch",function(){
        $("#batch_upload_file").modal();
        return false;
    });
    $(document).on("change","#batch_upload_file #file-logo[type=file]",function(){
        reader_file($("#batch_upload_file"),$(this)[0],$("#batch_upload_file #lable-upload img"),false);
    });
    $(document).on("change","#modal_add_catalog #file-logo[type=file]",function(){
        reader_file($("#modal_add_catalog"),$(this)[0],$("#modal_add_catalog #lable-upload img"),true);
    });

</script>