<section class="section your_reports">
    <div class="relative">
        <div class="container">
            <h2 class="title-page">Your reports</h2>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default relative not-border">
                        <div class="content-your-reports">
                            <div class="row">
                                <div class="col-md-3">
                                    <h3 class="title">Profile Clicks</h3>
                                    <div class="box-left-your-reports">
                                        <div class="row">
                                            <div class="col-xs-4">
                                                <img src="<?php echo skin_url("images/microste-icon.png");?>">
                                            </div> 
                                            <div class="col-xs-8">
                                                <h1 class="number-click"><?php echo @$number_view_profile;?></h1>
                                                <p class="number-click-week">Clicks in the last 30 days</p>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="box-right-your-reports" data-type = "profile">
                                        <div class="row">
                                            <div class="col-xs-9 col-md-7"></div>
                                            <div class="col-xs-2 col-md-1 relative text-center box-click">
                                                <p class="icon">Clicks</p>
                                                <div class="box-sort-by">
                                                    <h4>Sort by:</h4>
                                                    <div class="list-chose" data-colum="clicks">
                                                        <ul class="list-item">
                                                            <li><a href="#" data-order="newest">Newest</a></li>
                                                            <li><a href="#" data-order="oldest">Oldest</a></li>
                                                            <li><a href="#" data-order="most-shared">Most shared</a></li>
                                                            <li><a href="#" data-order="least-shared">Least shared</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-1 text-center relative box-email">
                                                <img class="icon" src="<?php echo skin_url("images/email1.png");?>">
                                                <div class="box-sort-by">
                                                    <h4>Sort by:</h4>
                                                    <div class="list-chose" data-colum="email">
                                                        <ul class="list-item">
                                                            <li><a href="#" data-order="newest">Newest</a></li>
                                                            <li><a href="#" data-order="oldest">Oldest</a></li>
                                                            <li><a href="#" data-order="most-shared">Most shared</a></li>
                                                            <li><a href="#" data-order="least-shared">Least shared</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class="col-xs-1 text-center relative box-facebook xs-none">
                                                <img class="icon" src="<?php echo skin_url("images/facebook.png");?>">
                                                <div class="box-sort-by">
                                                    <h4>Sort by:</h4>
                                                    <div class="list-chose" data-colum="facebook">
                                                        <ul class="list-item">
                                                            <li><a href="#" data-order="newest">Newest</a></li>
                                                            <li><a href="#" data-order="oldest">Oldest</a></li>
                                                            <li><a href="#" data-order="most-shared">Most shared</a></li>
                                                            <li><a href="#" data-order="least-shared">Least shared</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-1 text-center relative box-twitter xs-none">
                                                <img class="icon" src="<?php echo skin_url("images/twitter.png");?>">
                                                <div class="box-sort-by">
                                                    <h4>Sort by:</h4>
                                                    <div class="list-chose" data-colum="twitter">
                                                        <ul class="list-item">
                                                            <li><a href="#" data-order="newest">Newest</a></li>
                                                            <li><a href="#" data-order="oldest">Oldest</a></li>
                                                            <li><a href="#" data-order="most-shared">Most shared</a></li>
                                                            <li><a href="#" data-order="least-shared">Least shared</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-1 text-center relative box-in xs-none">
                                                <img class="icon" src="<?php echo skin_url("images/in.png");?>">
                                                <div class="box-sort-by">
                                                    <h4>Sort by:</h4>
                                                    <div class="list-chose" data-colum="linkedin">
                                                        <ul class="list-item">
                                                            <li><a href="#" data-order="newest">Newest</a></li>
                                                            <li><a href="#" data-order="oldest">Oldest</a></li>
                                                            <li><a href="#" data-order="most-shared">Most shared</a></li>
                                                            <li><a href="#" data-order="least-shared">Least shared</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="list-items">
                                        <?php if(isset($items_user) && is_array($items_user)){ ?>
                                        <?php $all = 0 ;?>    
                                        <?php foreach ($items_user as $key => $value) {?>  
                                            <?php if($key === "all"){
                                                $all = $value;
                                            }else{ ?>
                                                <?php 
                                                    $timestamp = strtotime($value["created_at"]);
                                                    $logo = ($value['avatar'] != "" && file_exists(FCPATH . $value['avatar'])) ? base_url($value['avatar']) : base_url("skins/images/avatar-full.png"); 
                                                ?>                                    
                                                <div class="row items">
                                                    <div class="col-xs-9 col-md-7">
                                                        <div class="row">
                                                        	<div id="reports-email" data-email ="<?php echo $value["work_email"];?>">
                                                            	<div class="col-xs-2 text-center"><div class="logo-user"><img src="<?php echo $logo;?>"></div></div>
                                                            	<div class="col-xs-10"><p><?php echo $value["first_name"]. " ".$value["last_name"] ;?> | <?php echo $value["company_name"] ;?> - <?php echo  date('F j \a\t h:i A', $timestamp);?></p></div>
                                                        	</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-2 col-md-1 text-center">
                                                        <p><?php echo ($value["number_proflie"] != null) ? $value["number_proflie"] : 0 ;?></p>
                                                    </div>
                                                    <div class="col-xs-1 text-center">
                                                        <p><?php echo ($value["number_email"] != null) ? $value["number_email"] : 0 ;?></p>
                                                    </div>
                                                    <div class="col-xs-1 text-center xs-none">
                                                        <p><?php echo ($value["number_facebook"] != null) ? $value["number_facebook"] : 0 ;?></p>
                                                    </div>
                                                    <div class="col-xs-1 text-center xs-none">
                                                        <p><?php echo ($value["number_twitter"] != null) ? $value["number_twitter"] : 0 ;?></p>
                                                    </div>
                                                    <div class="col-xs-1 text-center xs-none">
                                                        <p><?php echo ($value["number_linkedin"] != null) ? $value["number_linkedin"] : 0 ;?></p>
                                                    </div> 
                                                </div>
                                            <?php }?>
                                        <?php } ?> 
                                        <?php } ?>
                                        </div>
                                        <input type="hidden" id="order_set" name="">
                                        <?php if($all > 3):?><p class="text-right" id="more-your-reports"><a href="#">MORE</a></p><?php endif?>
                                    </div> 
                                </div>
                            </div>   
                        </div>
                    </div>
                    <div class="panel panel-default relative not-border">
                        <div class="content-your-reports">
                            <div class="row">
                                <div class="col-md-3">
                                    <h3 class="title">URL Clicks</h3>
                                    <div class="box-left-your-reports">
                                        <div class="row">
                                            <div class="col-xs-4">
                                                <img src="<?php echo skin_url("images/global-logo-teal.png");?>">
                                            </div> 
                                            <div class="col-xs-8">
                                                <h1 class="number-click"><?php echo @$number_view_photo;?></h1>
                                                <p class="number-click-week">Clicks in the last 30 days</p>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="box-right-your-reports" data-type = "photo-blog-view">
                                        <div class="row">
                                            <div class="col-xs-9 col-md-7"></div>
                                            <div class="col-xs-2 col-md-1 relative text-center box-click">
                                                <p class="icon">Clicks</p>
                                                <div class="box-sort-by">
                                                    <h4>Sort by:</h4>
                                                    <div class="list-chose" data-colum="clicks">
                                                        <ul class="list-item">
                                                            <li><a href="#" data-order="newest">Newest</a></li>
                                                            <li><a href="#" data-order="oldest">Oldest</a></li>
                                                            <li><a href="#" data-order="most-shared">Most shared</a></li>
                                                            <li><a href="#" data-order="least-shared">Least shared</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="list-items">
                                        <?php if(isset($items_photo_click) && is_array($items_photo_click)){ ?>
                                        <?php foreach ($items_photo_click as $key => $value) {?>    
                                            <?php if($key === "all"){
                                                $all = $value;
                                            }else{ ?>
                                            <?php $timestamp = strtotime($value["created_at"]);
                                                $logo = ($value['avatar'] != "" && file_exists(FCPATH . $value['avatar'])) ? base_url($value['avatar']) : base_url("skins/images/avatar-full.png"); 
                                            ?>
                                            <div class="row items">
                                                <div class="col-xs-9 col-md-7">
                                                    <div class="row">
                                                        <div id="reports-email" data-email ="<?php echo $value["work_email"];?>">
                                                            <div class="col-xs-2 text-center"><div class="logo-user"><img src="<?php echo $logo;?>"></div></div>
                                                            <div class="col-xs-10"><p><?php echo $value["first_name"]. " ".$value["last_name"] ;?> | <?php echo $value["company_name"] ;?> - <?php echo  date('F j \a\t h:i A', $timestamp);?></p></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-2 col-md-1 text-center">
                                                    <p><?php echo $value['number_proflie'];?></p>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        <?php } ?> 
                                        <?php } ?>  
                                        </div>
                                        <input type="hidden" id="order_set" name="">
                                        <?php if($all > 3):?><p class="text-right" id="more-your-reports"><a href="#">MORE</a></p><?php endif?>
                                    </div> 
                                </div>
                            </div>   
                        </div>
                    </div>
                    <h5 class="title-page-1">Sort by: Newest  Oldest  Most viewed  Least viewed  Most shared  Least shared</h5>
                    <div id="reports-photo-box">
                        <div class="box-items-reports-photo">
                            <?php if(isset($data_photo_share) && is_array($data_photo_share)){?>
                            <?php foreach ($data_photo_share as $key => $value) {?>
                            <div class="content-your-reports" data-id="<?php echo $value["reference_id"];?>">
                                <div class="row">
                                    <div class="col-md-3 col-3-cutoms">
                                        <div class="box-left-your-reports">
                                            <div class="img-share" style="background-image: url(<?php echo base_url($value["path_file"]);?>);"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-9 col-9-cutoms">
                                        <div class="panel panel-default relative not-border">
                                            <div class="box-right-your-reports" data-type = "photo-blog">
                                                <div class="row">
                                                    <div class="col-xs-9 col-md-7"></div>
                                                    <div class="col-xs-2 col-md-1 relative text-center box-click">
                                                        <p class="icon">Clicks</p>
                                                        <div class="box-sort-by">
                                                            <h4>Sort by:</h4>
                                                            <div class="list-chose" data-colum="clicks">
                                                                <ul class="list-item">
                                                                    <li><a href="#" data-order="newest">Newest</a></li>
                                                                    <li><a href="#" data-order="oldest">Oldest</a></li>
                                                                    <li><a href="#" data-order="most-shared">Most shared</a></li>
                                                                    <li><a href="#" data-order="least-shared">Least shared</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-1 text-center relative box-email">
                                                        <img class="icon" src="<?php echo skin_url("images/email1.png");?>">
                                                        <div class="box-sort-by">
                                                            <h4>Sort by:</h4>
                                                            <div class="list-chose" data-colum="email">
                                                                <ul class="list-item">
                                                                    <li><a href="#" data-order="newest">Newest</a></li>
                                                                    <li><a href="#" data-order="oldest">Oldest</a></li>
                                                                    <li><a href="#" data-order="most-shared">Most shared</a></li>
                                                                    <li><a href="#" data-order="least-shared">Least shared</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div> 
                                                    <div class="col-xs-1 text-center relative box-facebook xs-none">
                                                        <img class="icon" src="<?php echo skin_url("images/facebook.png");?>">
                                                        <div class="box-sort-by">
                                                            <h4>Sort by:</h4>
                                                            <div class="list-chose" data-colum="facebook">
                                                                <ul class="list-item">
                                                                    <li><a href="#" data-order="newest">Newest</a></li>
                                                                    <li><a href="#" data-order="oldest">Oldest</a></li>
                                                                    <li><a href="#" data-order="most-shared">Most shared</a></li>
                                                                    <li><a href="#" data-order="least-shared">Least shared</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-1 text-center relative box-twitter xs-none">
                                                        <img class="icon" src="<?php echo skin_url("images/twitter.png");?>">
                                                        <div class="box-sort-by">
                                                            <h4>Sort by:</h4>
                                                            <div class="list-chose" data-colum="twitter">
                                                                <ul class="list-item">
                                                                    <li><a href="#" data-order="newest">Newest</a></li>
                                                                    <li><a href="#" data-order="oldest">Oldest</a></li>
                                                                    <li><a href="#" data-order="most-shared">Most shared</a></li>
                                                                    <li><a href="#" data-order="least-shared">Least shared</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-1 text-center relative box-in xs-none">
                                                        <img class="icon" src="<?php echo skin_url("images/in.png");?>">
                                                        <div class="box-sort-by">
                                                            <h4>Sort by:</h4>
                                                            <div class="list-chose" data-colum="linkedin">
                                                                <ul class="list-item">
                                                                    <li><a href="#" data-order="newest">Newest</a></li>
                                                                    <li><a href="#" data-order="oldest">Oldest</a></li>
                                                                    <li><a href="#" data-order="most-shared">Most shared</a></li>
                                                                    <li><a href="#" data-order="least-shared">Least shared</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="list-items">
                                                <?php if (isset($value["items"])) {?>
                                                    <?php foreach ($value["items"] as $key_items => $value_items) { ?>
                                                    <?php $timestamp = strtotime($value_items["created_at"]);
                                                        $logo = ($value_items['avatar'] != "" && file_exists(FCPATH . $value_items['avatar'])) ? base_url($value_items['avatar']) : base_url("skins/images/avatar-full.png"); 
                                                    ?>                          
                                                    <div class="row items">
                                                        <div class="col-xs-9 col-md-7">
                                                            <div class="row">
                                                            	<div id="reports-email" data-email ="<?php echo $value_items["work_email"];?>">
                                                                	<div class="col-xs-2 text-center"><div class="logo-user"><img src="<?php echo $logo;?>"></div></div>
                                                                	<div class="col-xs-10"><p><?php echo $value_items["first_name"]. " ".$value_items["last_name"] ;?> | <?php echo $value_items["company_name"] ;?> - <?php echo  date('F j \a\t h:i A', $timestamp);?></p></div>
                                                            	</div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-2 col-md-1 text-center">
                                                            <p><?php echo ($value_items["number_proflie"] != null) ? $value_items["number_proflie"] : 0 ;?></p>
                                                        </div>
                                                        <div class="col-xs-1 text-center">
                                                            <p><?php echo ($value_items["number_email"] != null) ? $value_items["number_email"] : 0 ;?></p>
                                                        </div>
                                                        <div class="col-xs-1 text-center xs-none">
                                                            <p><?php echo ($value_items["number_facebook"] != null) ? $value_items["number_facebook"] : 0 ;?></p>
                                                        </div>
                                                        <div class="col-xs-1 text-center xs-none">
                                                            <p><?php echo ($value_items["number_twitter"] != null) ? $value_items["number_twitter"] : 0 ;?></p>
                                                        </div>
                                                        <div class="col-xs-1 text-center xs-none">
                                                            <p><?php echo ($value_items["number_linkedin"] != null) ? $value_items["number_linkedin"] : 0 ;?></p>
                                                        </div> 
                                                    </div>
                                                    <?php }?>
                                                <?php }?>    
                                                </div>
                                                <input type="hidden" id="order_set" name="">
                                               <?php if($value["all"] > 3):?> <p class="text-right" id="more-your-reports"><a href="#">MORE</a></p><?php endif;?>
                                            </div> 
                                        </div>
                                    </div>   
                                </div>
                            </div>
                            <?php }?>
                            <?php } ?>
                        </div>
                        <div class="loadding text-center" style="display: none;"><img style="width:60px;" src="<?php echo skin_url('images/loadding.GIF');?>"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade popup" id="sent_image_reports" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><div class="logo"><div class="logo-site"></div></div></h4>
      </div>
      <div class="modal-body">
        <h3 class="title_box">Send a Message</h3>
        <div>
          <p class="title-input">To (enter recipient emails, separated by commas):</p>
          <p><input type="email" name ="email" id="email" class="form-control" data-valid="true"/></p>
          <p  class="title-input">Subject:</p>
          <p><input type="text" name="subject" id="subject" class="form-control" data-valid="true"/></p>
          <p>Message:</p>
          <p><textarea id="message" class="form-control" name="message" data-valid="true">Take a look at this great space that I found on Dezignwall, and let me know what you think.</textarea></p>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id ="sendmail-reports">Send</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php if(isset($total_photo)):?>
<script>
    var reports_total = "<?php echo $total_photo;?>";
    $(document).on("click","#list-items #reports-email",function(){
        var email = $(this).data("email");
        $("#sent_image_reports #email").val(email);
        $('#sent_image_reports').modal();
        return false;
    });
    $(document).on("click","#sent_image_reports #sendmail-reports",function(event){
       var check_form = valid_form($(this).parents("#sent_image_reports"), "warning", true);
        if (check_form == true) {
            var email = $("#sent_image_reports #email").val();
            var subject = $("#sent_image_reports #subject").val();
            var message = $("#sent_image_reports #message").val();
            $.ajax({
                url: base_url + 'home/sent_reports',
                type: 'post',
                data: {
                    'email': email,
                    'subject': subject,
                    'message': message
                },
                success: function (data) {
                    console.log(data);
                    if (data.trim() == 'success') {
                        $('#sent_image').modal('hide');
                        messenger_box("Message", "Email sent successfully.");

                    } else {
                        $('#sent_image').modal('hide');
                        messenger_box("Message", "Email sent unsuccessful.");
                    }
                },
                error: function () {
                    $('#sent_image').modal('hide');
                    messenger_box("Message", "Email sent unsuccessful.");
                }
            });
        }
        return false;
    });
    
</script>
<?php endif;?>
<link rel="stylesheet" type="text/css" href="<?php echo skin_url("css/page/your_reports.css");?>">
<script type="text/javascript" src ="<?php echo skin_url("js/your_reports.js");?>"></script>

