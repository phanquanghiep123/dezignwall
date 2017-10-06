<link href="<?php echo skin_url(); ?>/css/page/image-upload.css" rel="stylesheet">
<link href="<?php echo skin_url(); ?>/css/cropper.css" rel="stylesheet">
<link href="<?php echo skin_url(); ?>/css/cropper.min.css" rel="stylesheet">
<link href="<?php echo skin_url(); ?>/css/upload.css" rel="stylesheet">
<script src="<?php echo skin_url(); ?>/js/cropper.js"></script>
<script src="<?php echo skin_url(); ?>/js/cropper.min.js"></script>
<!--<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">-->
<script src="<?php echo skin_url() ?>/js/jquery.Jcrop.min.js"></script>
<script src="<?php echo skin_url(); ?>/js/upload-photos.js"></script>
<script src="<?php echo skin_url() ?>/js/js-xlsx/shim.js"></script>
<script src="<?php echo skin_url() ?>/js/js-xlsx/jszip.js"></script>
<script src="<?php echo skin_url() ?>/js/js-xlsx/xlsx.js"></script>
<script src="<?php echo skin_url() ?>/js/js-xlsx/dist/ods.js"></script>
<style type="text/css">
    #edit-form .box-padding-page{padding: 0px 10px;}
    .wrap-cropper{
        display: inline-block;
        padding: 0;
        border:none;
        background: none;
        margin-bottom: 0;
    }
    .section.section-1{
        text-align: center;
    }
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
        .product_dimensions li input{width:  100%; display:  block;}
        .product_dimensions{width: 100%;}
        .product_dimensions li{width:  100%; display:  block; padding-left: 0;margin-left: 0;margin-bottom: 10px;}
        .product_dimensions li span{width:  100%; display:  block; margin-bottom: 10px;}
    }
</style>
<div id="wrapper" class="structural-block">
    <form action="<?php echo base_url('/profile/save_edit_photo/'); ?>" method="POST" enctype="multipart/form-data" id="edit-form">
        <div id="section-cropper" class="container box-public box-lg relative">
            <div class="box-bg-gray">
                <div class="section section-1">
                    <div class="relative">
                        <div class="custom-loading"><img width="64" src="<?php echo skin_url(); ?>/images/loading.gif"></div>
                        <div class="wrap-cropper relative text-center">
                            <?php
                                $size_new = getimagesize(base_url(@$photo['path_file']));
                            ?>
                            <img data-w="<?php echo $size_new[0]; ?>" data-h="<?php echo $size_new[1]; ?>" class="image-cropper" src="<?php echo base_url(@$photo['path_file']); ?>">
                        </div>
                        <?php /* 
                        <?php if(strpos(base_url(@$photo['path_file']),base_url()) !== false ):?>
                            <?php if(true == false):?>
                            <div class="action-image">
                                <ul class="list-inline">
                                    <li><button type="button" class="btn btn-custom btn-white" data-method="crop">Crop</button></li>
                                    <li><button type="button" class="btn btn-custom btn-white" data-method="rotate" data-option="90" title="Rotate 90 degrees">Rotate</button></li>
                                    <li><button type="button" class="btn btn-custom btn-white" data-method="undo">Undo</button></li>
                                    <li><button type="button" class="btn btn-custom btn-white" data-method="redo">Redo</button></li>
                                    <li><button  type="button" class="btn btn-custom btn-white" data-method="clear">Delete</button></li>
                                </ul>
                        </div>
                        <?endif;?>
                        <?endif;?>
                        */ ?>
                    </div>
                </div>
                <div class="box-padding-page">
                    <div class="box-bg-white box-ball catalog-box">
                        <div class="row">
                            <div class="col-md-12"><p>Apply image to a catalog</p></div>
                            <div class="col-md-4">
                                <p style="float:left;text-align: right;line-height: 1;">Existing Catalogs:<br>
                                    <span class="text-right" style="font-size:13px; color:#2c9595">Select one only</span>
                                </p> 
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <ul class="list-inline custom required-group">
                                    <?php if(@$manufacturers != "" && is_array($manufacturers)):?>
                                    
                                    <?php 
                                    $i = 0;
                                    foreach($manufacturers AS $value):
                                        $checked = "";
                                        if(@$photo['manufacture'] == $value["id"]){$checked = "checked";}
                                        ?>
                                        <li>
                                            <div class="checkbox check-yelow checkbox-circle">
                                                <input <?php echo $checked;?> type="radio" name="manufacturers" id="manufacturers-<?php echo $value["id"]?>" value="<?php echo $value["id"]?>">
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
                    </div>
                    <div class="box-bg-white box-ball">
                        <div class="row">
                            <div class="col-md-4"><p>Is this an image of a:</p></div>
                            <div class="col-md-8">
                                <ul class="list-inline custom required-group">
                                    <?php $image_category = explode(',', @$photo['image_category']); ?>
                                    <li>
                                        <div class="checkbox check-yelow checkbox-circle">
                                            <input <?php
                                            if (in_array('Project', $image_category)) {
                                                echo 'checked';
                                            }
                                            ?> type="radio" name="project_image" id="project_image" value="Project">
                                            <label for="project_image">
                                                Project
                                            </label>
                                        </div>
                                    </li>
                                    <li><label>or</label></li>
                                    <li>
                                        <div class="checkbox check-yelow checkbox-circle">
                                            <input <?php
                                            if (in_array('Product', $image_category)) {
                                                echo 'checked';
                                            }
                                            ?> type="radio" name="project_image" id="product_image" value="Product">
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

                    <div class="box-bg-white box-ball section-product" style="<?php
                        if (in_array('Product', $image_category)) {
                            echo 'display:block;';
                        }
                        ?>">
                        <div class="row">
                            <div class="col-md-3">
                                <p>Do you offer this product as:</p>
                            </div>
                            <div class="col-md-5">
                                <ul class="list-inline custom">
                                    <li style="padding-left:0;padding-right:0;">
                                        <div class="checkbox check-yelow checkbox-circle">
                                            <input type="radio" <?php if(@$photo['offer_product']=='Full Custom') { echo 'checked'; }  ?> name="offer_product" id="full_custom" value="Full Custom">
                                            <label for="full_custom">Full Custom</label>
                                        </div>
                                    </li>
                                    <li><label>or</label></li>
                                    <li style="padding-left:0;padding-right:0;">
                                        <div class="checkbox check-yelow checkbox-circle">
                                            <input type="radio" <?php if(@$photo['offer_product']=='Semi-custom') { echo 'checked'; }  ?> name="offer_product" id="semi_custom" value="Semi-custom">
                                            <label for="semi_custom">Semi-custom</label>
                                        </div>
                                    </li>
                                    <li><label>or</label></li>
                                    <li style="padding-left:0;padding-right:0;">
                                        <div class="checkbox check-yelow checkbox-circle">
                                            <input type="radio" <?php if(@$photo['offer_product']=='Non-custom') { echo 'checked'; } ?> name="offer_product" id="non_custom" value="Non-custom">
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
                                        <input type="text" value="<?php echo @$photo['number_item'];?>" class="form-control" name="number_code" id="number_code">
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
                                        <input type="number" value="<?php echo @$photo['maximum_price']; ?>" class="form-control <?php
                                               if (in_array('Product', $image_category) && @$photo['sample_pricing'] != 'Sample Apply') {
                                                   echo 'required-number';
                                               }
                                                   ?>" name="max_unit_price" id="max_unit_price">
                                    </div>
                                </div>
                            </div>
                        </div><!--end row-->
                        <div class="row">
                            <div class="col-sm-12 custom">
                                <div class="checkbox check-yelow checkbox-circle">
                                    <input type="checkbox" <?php
                                               if (@$photo['sample_pricing'] == 'Sample Apply') {
                                                   echo 'checked';
                                               }
                                                   ?> name="sample_apply" id="sample_apply" value="Sample Apply">
                                    <label for="sample_apply"> or "Sample pricing does not apply"</label>
                                </div>
                            </div>
                        </div><!--end row-->
                    </div><!--end box-->
                    <div class="box-bg-white box-ball section-product" style="<?php
                        if (in_array('Product', $image_category)) {
                            echo 'display:block;';
                        }
                        ?>">
                        <div class="row">
                            <div class="col-md-12">
                                <p>Product dimensions:</p>
                            </div>
                        </div><!--end row-->

                        <div class="row">
                            <div class="col-md-12">
                                <ul class="product_dimensions">
                                    <li><span>Height:</span><input type="number" value="<?php echo @$photo['height']?>" class="form-control <?php if (trim(@$photo['height']) != '' && @$photo['height'] != null) { echo 'required-number';} ?>" name="height"></li>
                                    <li><span>Width:</span><input type="number" value="<?php echo @$photo['width']?>" class="form-control <?php if (trim(@$photo['height']) != '' && @$photo['height'] != null) { echo 'required-number';} ?>" name="width"></li>
                                    <li><span>Depth/Projection:</span><input type="number" class="form-control <?php if (trim(@$photo['height']) != '' && @$photo['height'] != null) { echo 'required-number';} ?>" value="<?php echo @$photo['depth_proj']?>" name="depth_projection"></li>
                                    <li><span>Weight(in lbs.):</span><input type="text" class="form-control" value="<?php echo @$photo['weight_lbs']?>" name="weight-in"></li>
                                    <li><span>Weight(in kg.):</span><input type="text" class="form-control" value="<?php echo @$photo['weight_kg']?>" name="weight-kg"></li>
                                </ul>
                            </div>
                        </div><!--end row-->
                        <div class="row">
                            <div class="col-sm-12 custom">
                                <div class="checkbox check-yelow checkbox-circle">
                                    <input <?php if (trim(@$photo['height']) == '' && @$photo['height'] == null) {
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
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label class="col-sm-5 control-label">Give the photographer credit:</label>
                                <div class="col-sm-7">
                                    <input type="text" value="<?php echo @$photo['photo_credit']; ?>" class="form-control" name="photo_credit" id="photo_credit">
                                </div>
                            </div>
                        </div>
                    </div>
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
                            <div class="col-md-4"><p>Is this an image for:</p></div>
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
                                            <input <?php echo $outdoor; ?> type="radio" name="location_check" id="outdoor" value="2|346">
                                            <label for="outdoor">
                                                Outdoor
                                            </label>
                                        </div>
                                    </li>
                                    <li><label>or</label></li>
                                    <li>
                                        <div class="checkbox check-yelow checkbox-circle">
                                            <input type="radio" <?php
                                                   if ($outdoor != '' && $indoor != '') {
                                                       echo $indoor;
                                                   }
                    ?> name="location_check" id="both" value="1|346,2|346">
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
                                            <input autocomplete="off" type="text" name="category_other"  onkeyup="get_category_children(this, '9,192',event.keyCode);">
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
                                <textarea name="description" class="form-control auto-height" id="description" cols="2" maxlength="144"><?php echo @$photo['description']?></textarea>
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
                                <input value="<?php echo $keyw_value; ?>"  type="hidden" class="form-control required-custom" name="keywords" id="keywords">
                                <div class="wrap-custom-input relative">
                                    <div class="custom-input-complete input-textarea">
<?php echo $keyw; ?>
                                        <input autocomplete="off" type="text" name="keywords_other"  onkeyup="get_keywords(this,event.keyCode);">
                                    </div>
                                    <div class="custom-auto-complete">
                                        <ul>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
<?php if (@$photo['type'] == 4): ?>
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
                                                    <input type="text" value="<?php echo @$product_info['product_name']; ?>" class="form-control required"  name="product[product_name]" id="product-name">
                                                </div> 
                                            </div> 
                                            <div class="row form-group">
                                                <div class="col-sm-4 sm-text-right">
                                                    <label>Product No: </label> 
                                                </div> 
                                                <div class="col-sm-8"> 
                                                    <input type="number" value="<?php echo @$product_info['product_no']; ?>" class="form-control required" name="product[product_no]" class="product-no" id="product-no">
                                                </div>
                                            </div>
                                            <div class="row form-group"> 
                                                <div class="col-sm-4 sm-text-right"> 
                                                    <label>Price: </label> 
                                                </div>
                                                <div class="col-sm-8">
                                                    <input type="number" value="<?php echo @$product_info['price']; ?>" class="form-control" name="product[price]" id="price">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-sm-4 sm-text-right"> 
                                                    <label>Qty: </label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <input type="number" value="<?php echo @$product_info['qty']; ?>" class="form-control" name="product[qty]" class="qty" id="qty">
                                                </div> 
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-sm-4 sm-text-right">
                                                    <label>FOB: </label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <input type="hidden" name="product[category_id]" value="<?php echo @$c_id; ?>">
                                                    <input type="text" value="<?php echo @$product_info['fob']; ?>" class="form-control" name="product[fob]" class="fob" id="fob">
                                                </div> 
                                            </div> 
                                        </div> 
                                        <div class="col-sm-5">
                                            <div class="form-group">
                                                <label>Product Notes: </label> 
                                                <textarea style="height:200px;"  name="product[product_notes]" cols="40" rows="10" class="product-notes"><?php echo @$product_info['product_note']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
<?php endif; ?>
                    <div class="box-bg-white box-ball">
                        <div class="row">
                            <div class="col-md-12"><p>Is your product or service available..:</p></div>
                            <div class="col-md-12 form-group">
                                <ul class="list-inline custom required-group">
                                    <li>
                                        <div class="checkbox check-yelow checkbox-circle">
                                            <input <?php echo $locally; ?> type="radio"  name="source" id="locally" value="260|258">
                                            <label for="locally">
                                                Locally
                                            </label>
                                        </div>
                                    </li>
                                    <li><label>or</label></li>
                                    <li>
                                        <div  class="checkbox check-yelow checkbox-circle">
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
                        </div>
                    </div>
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
                        </div>
                    </div>
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
                        </div>
                        <div class="col-md-6 text-right">
                            <div class="action-save">
                                <input type="hidden" value="<?php echo @$story_id; ?>" name="story" id="story-id">
                                <input type="hidden" name="point_tag" id="point-tag" value='<?php echo json_encode(@$point); ?>'>
                                <input type="hidden" name="crop_data" id="cropper-data" value="">
                                <input type="hidden" name="photo_id" id="photo_id" value="<?php echo @$photo['photo_id']; ?>">
                                <input type="hidden" name="w_box" id="w_box">
                                <input type="hidden" name="h_box" id="h_box">
<?php
$url = base_url('profile/myphoto');
//if()
?>
                                <a href="<?php echo $url; ?>" class="btn btn-custom btn-default">Cancel</a>
                                <?php if ((!isset($is_update_profile) && !$is_update_profile) || true) : ?><input type="submit" class="btn btn-custom btn-primary" name="submit" value="Save/Post"><?php endif; ?>
                                <div class="loading-fixed">
                                    <div class="text-center custom-loading-fixed">
                                        <img width="84" src="<?php echo skin_url(); ?>/images/loading.gif">
                                    </div>
                                </div>
                            </div>	
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<?php $this->load->view("include/modal_choose_story"); ?>
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
                <a  href="<?php echo base_url("profile/edit")?>" style=" font-size: 21px; margin: 20px;" class="btn btn-primary" id="sent-report">Proot catalog</a>
            </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>
<?php if (isset($_GET['show_popup'])) : ?>
<script>
    $(document).ready(function () {
        $("#share-modal #photo-share").attr("src", $('.wrap-cropper .image-cropper').attr('src'));
        $("#share-modal #url-share-photo").val('<?php echo @$url_photo_public; ?>');
        url_share_social = '<?php echo @$url_photo_public; ?>';
        $('#share-modal').modal('show');
    });
</script>
<?php endif; ?>
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