<link href="<?php echo skin_url(); ?>/css/page/image-upload.css" rel="stylesheet">
<link href="<?php echo skin_url(); ?>/css/cropper.css" rel="stylesheet">
<link href="<?php echo skin_url(); ?>/css/cropper.min.css" rel="stylesheet">
<link href="<?php echo skin_url(); ?>/css/upload.css" rel="stylesheet">
<script src="<?php echo skin_url(); ?>/js/cropper.js"></script>
<script src="<?php echo skin_url(); ?>/js/cropper.min.js"></script>
<!--<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">-->
<script src="<?php echo skin_url(); ?>/js/jquery-ui.js"></script>
<script src="<?php echo skin_url() ?>/js/jquery.Jcrop.min.js"></script>
<script src="<?php echo skin_url(); ?>/js/upload-photos.js"></script>
<div id="wrapper">
   <form action="<?php echo base_url('/profile/upload_images/'.$project_id .'/'. $category_id.'/'); ?>" method="POST" enctype="multipart/form-data" id="upload-form">
      <div id="section-cropper" class="container box-public box-lg relative">
         <div class="box-bg-gray">
            <div class="top full-page">
               <div class="top-upload box-padding-page">
                  <div class="row">
                     <div class="col-md-12">
                        <h1 class="text-sm-center">You are in Image Upload mode... <span>Drag and Drop Image or</span><span class="upload-box-button"><button type="button" class="btn btn-custom btn-white" id="file-upload">Browse</button></span></h1>
                        <p class="text-sm-center">Uploaded images should be Hi Resolution images (1000 pixels wide or more)</p>
                     </div>
                  </div>
               </div>
            </div>
            <div class="section section-1 text-center">
               <div class="relative">
                  <div class="custom-loading"><img width="64" src="<?php echo skin_url(); ?>/images/loading.gif"></div>
                  <div class="wrap-cropper relative">
                     <img class="image-cropper" src="<?php echo skin_url(); ?>/images/image-upload.png">
                  </div>
                  <div class="action-image">
                     <ul class="list-inline">
                        <li><button type="button" class="btn btn-custom btn-white" data-method="crop">Crop</button></li>
                        <li><button type="button" class="btn btn-custom btn-white" data-method="rotate" data-option="90" title="Rotate 90 degrees">Rotate</button></li>
                        <li><button type="button" class="btn btn-custom btn-white" data-method="undo">Undo</button></li>
                        <li><button type="button" class="btn btn-custom btn-white" data-method="redo">Redo</button></li>
                        <li><button type="button" class="btn btn-custom btn-white" data-method="clear">Delete</button></li>
                     </ul>
                  </div>
               </div>
            </div>
            <div class="box-padding-page">
               <div class="box-bg-white box-ball">
                  <div class="row">
                     <div class="col-md-4">
                        <p>Is this an image of a:</p>
                     </div>
                     <div class="col-md-8">
                        <?php $image_category=explode(',', @$photo['image_category']); ?>
                        <ul class="list-inline custom required-group">
                           <li>
                              <div class="checkbox check-yelow checkbox-circle">
                                 <input <?php if(in_array('Project',$image_category)){echo 'checked';} ?> type="radio" name="project_image" id="project_image" value="Project">
                                 <label for="project_image">
                                 Project
                                 </label>
                              </div>
                           </li>
                           <li><label>or</label></li>
                           <li>
                              <div class="checkbox check-yelow checkbox-circle">
                                 <input <?php if(in_array('Product',$image_category)){echo 'checked';} ?> type="radio" name="project_image" id="product_image" value="Product">
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


               <div class="box-bg-white box-ball">
                  <div class="row">
                     <div class="col-md-4">
                        <p>Do you offer this product as:</p>
                     </div>
                     <div class="col-md-8">
                        <ul class="list-inline custom required-group">
                           <li style="padding-left:0;padding-right:0;">
                              <div class="checkbox check-yelow checkbox-circle">
                                 <input type="radio" <?php if(@$photo['offer_product']=='Full Custom') { echo 'checked'; } ?> name="offer_product" id="full_custom" value="Full Custom">
                                 <label for="full_custom">Full Custom</label>
                              </div>
                           </li>
                           <li><label>or</label></li>
                           <li style="padding-left:0;padding-right:0;">
                              <div class="checkbox check-yelow checkbox-circle">
                                 <input type="radio" <?php if(@$photo['offer_product']=='Semi-custom') { echo 'checked'; } ?> name="offer_product" id="semi_custom" value="Semi-custom">
                                 <label for="semi_custom">Semi-custom</label>
                              </div>
                           </li>
                           <li><label>or</label></li>
                           <li style="padding-left:0;padding-right:0;">
                              <div class="checkbox check-yelow checkbox-circle">
                                 <input type="radio" <?php if(@$photo['offer_product']=='Non-custom') { echo 'checked'; }?> name="offer_product" id="non_custom" value="Non-custom">
                                 <label for="non_custom">Non-custom</label>
                              </div>
                           </li>
                        </ul>
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
                            <div class="col-sm-7">
                              <p>Maximum units at this price:</p>
                            </div>
                            <div class="col-sm-5">
                               <input type="number" value="<?php echo @$photo['maximum_price']; ?>" minlength="1" class="form-control" name="max_unit_price" id="max_unit_price">
                            </div>
                          </div>
                    </div>
                  </div><!--end row-->

                  <div class="row">
                    <div class="col-sm-12 custom">
                        <div class="checkbox check-yelow checkbox-circle">
                           <input <?php if(@$photo['sample_pricing']=='Sample Apply'){ echo 'checked'; } ?> type="checkbox" name="sample_apply" id="sample_apply" value="Sample Apply">
                           <label for="sample_apply"> or "Sample pricing does not apply"</label>
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
                  $indoor=$outdoor='';
                  $locally=$nationally=$internationally='';
                  $style='';
                  $style_value='';
                  $categorys='';
                  $categorys_value='';
                  $location='';
                  $location_value='';
                  $comma='';
                  $comma_value='';
                  if(isset($category) && count($category)>0){
                      foreach ($category as $key => $value) {
                         if($value['category_id']==1){
                              $indoor='checked';
                         }
                         if($value['category_id']==2){
                             $outdoor='checked';
                         }
                         if($value['category_id']==260){
                             $locally='checked';
                         }
                         if($value['category_id']==259){
                             $nationally='checked';
                         }
                         if($value['category_id']==262){
                            $internationally ='checked';
                         }
                         if($value['first_child_category']==3){
                             $style.='<p class="item" data-id="'.$value['category_id'].'"><span class="text_inser"><span class="text-name">'.$value['title'].'</span><span class="token-x"><a href="#">x</a></span></span></p>'; 
                             $style_value.=$value['category_id'].',';
                         }
                         if($value['first_child_category']==9 || $value['first_child_category']==192){
                             $categorys.='<p class="item" data-id="'.$value['category_id'].'"><span class="text_inser"><span class="text-name">'.$value['title'].'</span><span class="token-x"><a href="#">x</a></span></span></p>'; 
                             $categorys_value.=$value['category_id'].',';
                         }
                         if($value['first_child_category']==215){
                             $location.='<p class="item" data-id="'.$value['category_id'].'"><span class="text_inser"><span class="text-name">'.$value['title'].'</span><span class="token-x"><a href="#">x</a></span></span></p>'; 
                             $location_value.=$value['category_id'].',';
                         }
                         if($value['first_child_category']==263){
                             $comma.='<p class="item" data-id="'.$value['category_id'].'"><span class="text_inser"><span class="text-name">'.$value['title'].'</span><span class="token-x"><a href="#">x</a></span></span></p>'; 
                             $comma_value.=$value['category_id'].',';
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
                                 <input <?php echo $indoor;  ?> type="radio" name="location_check" id="indoor" value="1|346">
                                 <label for="indoor">
                                    Indoor
                                 </label>
                              </div>
                           </li>
                           <li><label>or</label></li>
                           <li>
                              <div class="checkbox check-yelow checkbox-circle">
                                 <input type="radio" <?php echo $outdoor;  ?> name="location_check" id="outdoor" value="2|346">
                                 <label for="outdoor">
                                    Outdoor
                                 </label>
                              </div>
                           </li>
                           <li><label>or</label></li>
                           <li>
                              <div class="checkbox check-yelow checkbox-circle">
                                 <input type="radio" <?php if($outdoor!='' && $indoor!=''){echo $indoor; } ?> name="location_check" id="both" value="1|346,2|346">
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
                           <input type="hidden" value="<?php echo $style_value;  ?>" class="form-control required-custom" name="style" id="style">
                           <div class="wrap-custom-input relative">
                              <div class="custom-input-complete">
                                 <?php echo $style;  ?>
                                 <input autocomplete="off" type="text" name="style_other"  onkeyup="get_category_children(this,'3');">
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
                           <input type="hidden" value="<?php echo $categorys_value;  ?>" class="form-control" name="category" id="category">
                           <div class="wrap-custom-input relative">
                              <div class="custom-input-complete">
                                 <?php echo $categorys;  ?>
                                 <input autocomplete="off" type="text" name="category_other"  onkeyup="get_category_children(this,'9,192');">
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
                           <input type="hidden" value="<?php echo $location_value;  ?>" class="form-control required-custom" name="location" id="location">
                           <div class="wrap-custom-input relative">
                              <div class="custom-input-complete">
                                 <?php echo $location;  ?>
                                 <input autocomplete="off" type="text" name="location_other"  onkeyup="get_category_children(this,'215');">
                              </div>
                              <div class="custom-auto-complete">
                                 <ul>
                                 </ul>
                              </div>
                           </div>
                        </div>
                     </div>

                     <?php
                        $keyw='';
                        $keyw_value='';
                        if(isset($keywords) && count($keywords)>0){
                            foreach ($keywords as $key => $value) {
                               $keyw.='<p class="item" data-id="'.$value['keyword_id'].'"><span class="text_inser"><span class="text-name">'.$value['title'].'</span><span class="token-x"><a href="#">x</a></span></span></p>';
                               $keyw_value.=$value['keyword_id'].',';
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
                              <input autocomplete="off" type="text" name="keywords_other"  onkeyup="get_keywords(this);">
                           </div>
                           <div class="custom-auto-complete">
                              <ul>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div><!--end row-->
               </div><!--end box-->

               <?php if(isset($project_id) && isset($category_id) && $project_id!=null && $category_id!=null && is_numeric($category_id) && is_numeric($project_id) ): ?>
                  <div class="box-bg-white box-ball">
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
               <?php endif;?>
                  <div class="box-bg-white box-ball">
                  <div class="row">
                     <div class="col-md-12">
                        <p>Is your product or service available..:</p>
                     </div>
                     <div class="col-md-12 form-group">
                        <ul class="list-inline custom required-group">
                           <li>
                              <div class="checkbox check-yelow checkbox-circle">
                                 <input <?php echo $locally;  ?> type="radio" name="source" id="locally" value="260|258">
                                 <label for="locally">
                                    Locally
                                 </label>
                              </div>
                           </li>
                           <li><label>or</label></li>
                           <li>
                              <div class="checkbox check-yelow checkbox-circle">
                                 <input <?php echo $nationally;  ?> type="radio" name="source" id="nationally" value="259|258">
                                 <label for="nationally">
                                    Nationally
                                 </label>
                              </div>
                           </li>
                           <li><label>or</label></li>
                           <li>
                              <div class="checkbox check-yelow checkbox-circle">
                                 <input <?php echo $internationally;  ?> type="radio" name="source" id="internationally" value="262|258">
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
                        <input value="<?php echo $comma_value;  ?>"   type="hidden" class="form-control required-custom" name="compliance" id="compliance">
                        <div class="wrap-custom-input relative">
                           <div class="custom-input-complete input-textarea">
                              <?php echo $comma;  ?>
                              <input autocomplete="off" type="text" name="compliance_other"  onkeyup="get_category_children(this,'263');">
                           </div>
                           <div class="custom-auto-complete">
                              <ul>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div><!--end row-->
               </div><!--end box-->

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
                        <input type="file" id="ImageUploader_image" name="file_upload" style="display:none;" accept="image/*" onchange="readURL(this);">
                        <input type="hidden" name="point_tag" id="point-tag" value="">
                        <input type="hidden" name="crop_data" id="cropper-data" value="">
                        <a href="<?php echo base_url(); ?>profile/myphoto" class="btn btn-custom btn-default">Cancel</a>
                        <input type="submit" class="btn btn-custom btn-primary" name="submit" value="Save/Post">
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
   </form>
</div>

<style type="text/css">
   .wrap-cropper.active{
      width: auto !important;
      height: auto !important;
      background: none !important;
      display: inline-block !important;
   }
</style>