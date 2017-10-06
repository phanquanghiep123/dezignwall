<link href="<?php echo skin_url(); ?>/css/page/image-upload.css" rel="stylesheet">

<link href="<?php echo skin_url(); ?>/css/upload.css" rel="stylesheet">

<div id="wrapper">

   <form action="<?php echo base_url('profile/send_request_quote'); ?>" method="POST" enctype="multipart/form-data" id="request-form">

      <div id="section-cropper" class="box-public box-lg relative">

         <div class="box-bg-gray">

            <div class="top full-page">

               <div class="top-upload box-padding-page">
               	<div class="container">
                  <div class="row">

                     <div class="col-md-12">

                        <h1 class="text-sm-center">You are in Quote Request mode...</h1>

                     </div>

                  </div>
                </div>
               </div>

            </div>

            <div class="section section-1 text-center">

               <div class="relative container">

                  <div class="wrap-cropper active relative" style="display: inline-block;">

                     <?php

                        $size_new = @getimagesize('.'.@$photo['path_file']);

                    ?>

                     <img class="image-cropper" data-w="<?php echo @$size_new[0]; ?>" data-h="<?php echo @$size_new[1]; ?>" src="<?php echo base_url(@$photo['path_file']); ?>">

                     <input type="hidden" value="<?php echo @$photo['photo_id']; ?>" id="photo_id" name="photo_id">

                     <input type="hidden" value="<?php echo @$tag['id']; ?>" id="tag_id" name="tag_id">

                  </div>

               </div>

            </div>

            <div class="container">

               <div class="box-bg-white box-ball custom">

                  <div class="row">

                     <div class="col-sm-12">

                          <div class="row">

                             <div class="col-sm-4">

                                <p>This product is available in:</p>

                             </div>

                             <div class="col-sm-8">

                                 <p><strong><?php echo @$tag['product_in']; ?></strong></p>

                             </div>

                          </div><!--end row-->

                          <?php if(isset($photo['sample_pricing']) && $photo['sample_pricing']!=null): ?>

                                <p>Sample pricing does not apply</p>

                          <?php else: ?>

                                <div class="row">

                                   <div class="col-sm-4">

                                      <p>The single unit price is:</p>

                                   </div>

                                   <div class="col-sm-8">

                                       <p><strong>$<?php echo @$tag['one_off']; ?></strong></p>

                                   </div>

                                </div><!--end row-->



                                <div class="row">

                                   <div class="col-sm-4">

                                      <p>The max sample quantity is:</p>

                                   </div>

                                   <div class="col-sm-8">

                                       <p><strong><?php echo @$tag['max_qty']; ?></strong></p>

                                   </div>

                                </div><!--end row-->

                          <?php endif; ?>

                          <p class="text-request small">Note: Quantites beyond the max sample quantity require a request for quote from this vendor.</p>

                     </div>

                  </div>

               </div><!--end box-->





               <div class="box-bg-white box-ball">

                  <div class="row">

                     <div class="col-sm-12">

                        <p class="text-request">Please provide some basic information for your quote</p>

                        <div class="row">

                            <div class="col-sm-6">

                                <p>What country will this be installed in?</p>

                            </div>

                            <div class="col-sm-6">

                                <input type="text" name="country_installed" class="form-control required">

                            </div>

                        </div><!--end row-->

                        <div class="row">

                            <div class="col-sm-6">

                                <p>What is your role within the quote process?</p>

                            </div>

                            <div class="col-sm-6">

                                <input type="text" name="quote_process" class="form-control required">

                            </div>

                        </div><!--end row-->



                        <div class="row">

                            <div class="col-sm-6">

                                <div class="row">

                                    <div class="col-sm-7">

                                        <p>Sample quantity?</p>

                                    </div>

                                    <div class="col-sm-5">

                                        <input type="text" name="sample_quantity" class="form-control required">

                                    </div>

                                </div><!--end row-->

                            </div>

                            <div class="col-sm-6">

                                <div class="row">

                                    <div class="col-sm-7">

                                        <p>Production quantity?</p>

                                    </div>

                                    <div class="col-sm-5">

                                        <input name="product_quantity" type="text" class="form-control required">

                                    </div>

                                </div><!--end row-->

                            </div>

                        </div><!--end row-->



                        <div class="row">

                            <div class="col-sm-6">

                                <div class="row">

                                    <div class="col-sm-7">

                                        <p>Est. sample delivery date:</p>

                                    </div>

                                    <div class="col-sm-5">

                                        <input type="text" name="sample_date" class="form-control required">

                                    </div>

                                </div><!--end row-->

                            </div>

                            <div class="col-sm-6">

                                <div class="row">

                                    <div class="col-sm-7">

                                        <p>Est. production delivery date:</p>

                                    </div>

                                    <div class="col-sm-5">

                                        <input type="text" name="product_date" class="form-control required">

                                    </div>

                                </div><!--end row-->

                            </div>

                        </div><!--end row-->





                     </div>

                  </div><!--end row-->

               </div><!--end box-->





               <div class="box-bg-white box-ball">

                  <p class="text-request">Please provide some requirements details for your quote</p>

                  <div class="row">

                     <div class="col-sm-5">

                        <p>Will this product be primarily installed:</p>

                     </div>

                     <div class="col-sm-7">

                        <ul class="list-inline custom required-group">

                           <li>

                              <div class="checkbox check-yelow checkbox-circle">

                                 <input type="radio"  name="location_check" id="indoor" value="Indoor">

                                 <label for="indoor">

                                    Indoor

                                 </label>

                              </div>

                           </li>

                           <li><label>or</label></li>

                           <li>

                              <div class="checkbox check-yelow checkbox-circle">

                                 <input type="radio" name="location_check" id="outdoor" value="Outdoor">

                                 <label for="outdoor">

                                    Outdoor

                                 </label>

                              </div>

                           </li>

                           <li><label>or</label></li>

                           <li>

                              <div class="checkbox check-yelow checkbox-circle">

                                 <input type="radio" name="location_check" id="both" value="Both">

                                 <label for="both">

                                    Both

                                 </label>

                              </div>

                           </li>

                        </ul>

                     </div>

                  </div><!--end row-->

                  <p class="text-request">Please provide any dimension requirements</p>

                  <div class="row">

                     <div class="col-sm-4">

                         <div class="row">

                             <div class="col-sm-4">

                               <p class="text-size-18">Height:</p>

                             </div>

                             <div class="col-sm-8">

                               <input type="text" name="height" class="form-control required">

                             </div>

                         </div>

                     </div>

                     <div class="col-sm-4">

                          <div class="row">

                               <div class="col-sm-4">

                                 <p class="text-size-18">Width:</p>

                               </div>

                               <div class="col-sm-8">

                                 <input type="text" name="width" class="form-control required">

                               </div>

                          </div>

                     </div>

                     <div class="col-sm-4">

                          <div class="row">

                               <div class="col-sm-4">

                                 <p class="text-size-18">Projection:</p>

                               </div>

                               <div class="col-sm-8">

                                 <input type="text" name="projection" class="form-control required">

                               </div>

                          </div>

                     </div>

                  </div><!--end row-->

                  <div class="row">

                     <div class="col-sm-4">

                         <div class="row">

                             <div class="col-sm-4">

                               <p class="text-size-18">Depth:</p>

                             </div>

                             <div class="col-sm-8">

                               <input type="text" class="form-control required" name="depth">

                             </div>

                         </div>

                     </div>

                     <div class="col-sm-4">

                          <div class="row">

                               <div class="col-sm-4">

                                 <p class="text-size-18">SqFt:</p>

                               </div>

                               <div class="col-sm-8">

                                 <input type="text" class="form-control required" name="sqft">

                               </div>

                          </div>

                     </div>

                     <div class="col-sm-4">

                          <div class="row">

                               <div class="col-sm-4">

                                 <p class="text-size-18">Diameter:</p>

                               </div>

                               <div class="col-sm-8">

                                 <input type="text" class="form-control required" name="diameter">

                               </div>

                          </div>

                     </div>

                  </div><!--end row-->

                  <p>Comments:

                  <textarea class="form-control" maxlength="300" name="comments" rows="4" cols="10"></textarea></p>

               </div><!--end box-->



               <div class="box-bg-white box-ball">

                  <p class="text-request">What's the best way to reach you?</p>

                  <div class="row">

                    <div class="col-sm-6">

                        <div class="row">

                            <div class="col-sm-2">

                                <p>Email:</p>

                            </div>

                            <div class="col-sm-10">

                                <input type="email" name="email" class="form-control required">

                            </div>

                        </div>

                    </div>

                  </div><!--end row-->

                  <div class="row">

                    <div class="col-sm-6">

                        <div class="row">

                            <div class="col-sm-2">

                                <p>Phone:</p>

                            </div>

                            <div class="col-sm-10">

                                <input type="text" name="phone" class="form-control required">

                            </div>

                        </div>

                    </div>

                    <div class="col-sm-6">

                        <ul class="list-inline custom required-group">

                           <li>

                              <div class="checkbox check-yelow checkbox-circle">

                                 <input type="radio" name="reach_check" id="work" value="Work">

                                 <label for="work">

                                    Work

                                 </label>

                              </div>

                           </li>

                           <li>

                              <div class="checkbox check-yelow checkbox-circle">

                                 <input type="radio" name="reach_check" id="cell" value="Cell">

                                 <label for="cell">

                                    Cell

                                 </label>

                              </div>

                           </li>

                           <li>

                              <div class="checkbox check-yelow checkbox-circle">

                                 <input type="radio" name="reach_check" id="home" value="Home">

                                 <label for="home">

                                    Home

                                 </label>

                              </div>

                           </li>

                        </ul>

                    </div>

                  </div><!--end row-->

                  <div class="row">

                    <div class="col-sm-6">

                        <div class="row">

                            <div class="col-sm-2">

                                <p>From:</p>

                            </div>

                            <div class="col-sm-4">

                                <input type="text" name="from" class="form-control required">

                            </div>

                            <div class="col-sm-2">

                                <p>To:</p>

                            </div>

                             <div class="col-sm-4">

                                <input type="text" name="to" class="form-control required">

                            </div>

                        </div>

                    </div>

                    <div class="col-sm-6">

                      <div class="row">

                        <div class="col-sm-5">

                           <ul class="list-inline custom required-group">

                             <li>

                                <div class="checkbox check-yelow checkbox-circle">

                                   <input type="radio" name="time_check" id="am" value="AM">

                                   <label for="am">

                                      AM

                                   </label>

                                </div>

                             </li>

                             <li>

                                <div class="checkbox check-yelow checkbox-circle">

                                   <input type="radio" name="time_check" id="pm" value="PM">

                                   <label for="pm">

                                      PM

                                   </label>

                                </div>

                             </li>

                          </ul>

                        </div>

                        <div class="col-sm-7">

                           <div class="row">

                              <div class="col-sm-4">

                                  <p>Country:</p>

                              </div>

                              <div class="col-sm-8">

                                  <input type="text" name="country" class="form-control required">

                              </div>

                           </div>

                        </div>

                      </div>

                       

                    </div>

                  </div><!--end row-->

               </div>



               <div class="row">

                  <div class="col-md-6 custom">

                     <div class="checkbox check-yelow checkbox-circle small">

                        <input type="checkbox" name="save_multiple" id="check-susses-upload" value="save">

                        <label for="check-susses-upload">

                           Send a copy of the request to yourself

                        </label>

                     </div>

                  </div>

                  <div class="col-md-6 text-right">

                     <div class="action-save">

                        <input type="hidden" name="point_tag" id="point-tag" value='<?php echo json_encode(array('0'=>@$tag)); ?>'>

                        <a href="<?php echo base_url(); ?>photos/<?php echo @$photo['photo_id']; ?>/<?php echo gen_slug(@$photo['name']); ?>" class="btn btn-lg btn-custom btn-default">Cancel</a>

                        <input type="submit" class="btn btn-lg btn-custom btn-primary"  name="submit" value="Send Now">

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

<script type="text/javascript">

  $(document).ready(function(){

      $("#request-form").submit(function() {

          var bool = true;

          var first_focus = null;

          $('.required-group').each(function() {

              if ($(this).find('input[type="radio"]:checked').length > 0) {

                  $(this).find('input[type="radio"]').removeClass('border-error');

              } else {

                  $(this).find('input[type="radio"]').addClass('border-error');

                  bool = false;

              }

          });



          $('input.required,textarea.required').each(function() {

              var value = $.trim($(this).val());

              if (value == null || value == '') {

                  $(this).addClass('border-error');

                  bool = false;

                  if (first_focus == null) {

                      first_focus = $(this);

                  }

              } else {

                  $(this).removeClass('border-error');

              }

          });

          if (bool == false) {

              messenger_box("Request Quote Form", 'Please fill in all required fields.');

          } else {

              var current=$(this);

              var data_form=$(this).serialize();

              current.find('.loading-fixed').show();

              $.ajax({

                  url: base_url+'/profile/send_request_quote',

                  type: 'POST',

                  data: data_form,

                  dataType:'json',

                  success: function(reponse) {

                      console.log(reponse);

                      if(reponse['status']=='success'){

                         messenger_box("Request Quote Form", 'Send Request Quote successfully.');

                         setTimeout(function(){

                            window.location.href="<?php echo base_url(); ?>photos/<?php echo @$photo['photo_id']; ?>/<?php echo urldecode(@$photo['name']); ?>.html";

                         },1000);

                      }

                  },

                  complete: function() {

                      current.find('.loading-fixed').hide();

                  },

                  error:function(data){

                      messenger_box("Request Quote Form", 'Send Request Quote error.');

                      console.log(data);

                  }

              });

          }

          return false;

      });

  });

  $(window).load(function(){

        var wrap_w=$('.wrap-cropper').width();

        var wrap_h=$('.wrap-cropper').height();

        var image_w=parseInt($(".wrap-cropper .image-cropper").attr('data-w'));

        var image_h=parseInt($(".wrap-cropper .image-cropper").attr('data-h'));

        var center_w=(wrap_w-image_w)/2;

        var center_h=(wrap_h-image_h)/2;

        var tag=$.parseJSON($("#point-tag").val());

        if(tag.length>0){

            var point='';

            for(var i=0;i<tag.length;i++){

                point+='<div id="point" data-on="on" data-rol="tag-'+i+'" class="point-'+i+' ui-draggable ui-draggable-handle" style="top: '+(parseFloat(tag[i]['top'])+center_h)+'px; left: '+(parseFloat(tag[i]['left'])+center_w)+'px;"><a><span id="lbImageTags"><i class="newImageTagIcon animate"></i></span></a></div>';

            }

            $('.wrap-cropper').append(point);

        }

  });

</script>

<style type="text/css">

   .wrap-cropper.active{

      width: 100% !important;

      height: auto !important;

      background: none !important;

      display: inline-block !important;

   }

   .top-upload{

      padding-top: 10px;

      padding-bottom: 10px;

   }

   .box-ball p{

      font-size: 19px;

   }

   .box-ball.custom p{

      margin-bottom: 0;

      line-height: 30px;

   }

   .text-request.small{

      font-size: 15px !important;

      color: #37a7a7;

   }

   .text-request{

      color: #37a7a7;

   }

   .box-ball p.text-size-18{

      font-size: 18px;

   }

   .box-ball{

      padding-bottom: 15px;

   }

   .list-inline.custom{

      margin-top: -10px;

   }

   .box-ball li label{

      font-size: 20px;

   }

</style>