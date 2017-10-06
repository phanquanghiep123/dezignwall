<link rel="stylesheet" type="text/css" href="<?php echo base_url("skins/css/page/profile.css");?>">
<section class="section your_reports">
    <div class="relative">
        <div class="container">
            <h2 class="title-page">Company reports</h2>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default relative not-border">
                        <div class="content-your-reports">
                            <div class="row">
                                <div class="col-md-3">
                                    <h3 class="title">Company Clicks</h3>
                                    <div class="box-left-your-reports">
                                        <div class="row">
                                            <div class="col-xs-4">
                                                <img src="<?php echo skin_url("images/microste-icon.png");?>">
                                            </div> 
                                            <div class="col-xs-8">
                                                <h1 class="number-click"><?php echo @$number_view_profile;?></h1>
                                                <p class="number-click-week">Clicks in the last month</p>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="box-right-your-reports" data-type = "profile">
                                        <div class="row">
                                            <div class="col-xs-9 col-md-7"></div>
                                            <div class="col-xs-3 col-md-5">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-xs-4 relative text-center box-click">
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
                                                            <div class="col-xs-4 relative text-center box-follow">
                                                                <p class="icon">Follow</p>
                                                                <div class="box-sort-by">
                                                                    <h4>Sort by:</h4>
                                                                    <div class="list-chose" data-colum="follow">
                                                                        <ul class="list-item">
                                                                            <li><a href="#" data-order="newest">Newest</a></li>
                                                                            <li><a href="#" data-order="oldest">Oldest</a></li>
                                                                            <li><a href="#" data-order="most-shared">Most shared</a></li>
                                                                            <li><a href="#" data-order="least-shared">Least shared</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-4 relative text-center box-favorite">
                                                                <p class="icon">Favorite</p>
                                                                <div class="box-sort-by">
                                                                    <h4>Sort by:</h4>
                                                                    <div class="list-chose" data-colum="favorite">
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
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-xs-3 text-center relative box-email">
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
                                                            <div class="col-xs-3 text-center relative box-facebook xs-none">
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
                                                            <div class="col-xs-3 text-center relative box-twitter xs-none">
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
                                                            <div class="col-xs-3 text-center relative box-in xs-none">
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
                                                                <div class="col-lg-2 text-center"><div class="logo-user"><img src="<?php echo $logo;?>"></div></div>
                                                                <div class="col-lg-6">
                                                                    <p><?php echo $value["first_name"]. " ".$value["last_name"] ;?> | <?php echo $value["company_name"] ;?></p>
                                                                    <p><?php echo  date('F j \a\t h:i A', $timestamp);?></p>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <ul class="list-inline action-img">
                                                                        <li><a href="javascript:;"><img src="<?php echo skin_url("icon/icon-user.png");?>"></a></li>
                                                                        <li><a href="javascript:;"><img src="<?php echo skin_url("/icon/icon-message.png");?>"></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-3 col-md-5 show-number" >
                                                        <div class="row">
                                                            <div class="col-xs-6">
                                                                <div class="row">
                                                                    <div class="col-xs-4 text-center">
                                                                        <p><?php echo ($value["number_proflie"] != null) ? $value["number_proflie"] : 0 ;?></p>
                                                                    </div>
                                                                    <div class="col-xs-4 text-center">
                                                                        <p><?php echo ($value["number_follow"] != null) ? $value["number_proflie"] : 0 ;?></p>
                                                                    </div>
                                                                    <div class="col-xs-4 text-center">
                                                                        <p><?php echo ($value["number_favorite"] != null) ? $value["number_proflie"] : 0 ;?></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-6">
                                                                <div class="row">
                                                                    <div class="col-xs-3 text-center">
                                                                        <p><?php echo ($value["number_email"] != null) ? $value["number_email"] : 0 ;?></p>
                                                                    </div>
                                                                    <div class="col-xs-3 text-center xs-none">
                                                                        <p><?php echo ($value["number_facebook"] != null) ? $value["number_facebook"] : 0 ;?></p>
                                                                    </div>
                                                                    <div class="col-xs-3 text-center xs-none">
                                                                        <p><?php echo ($value["number_twitter"] != null) ? $value["number_twitter"] : 0 ;?></p>
                                                                    </div>
                                                                    <div class="col-xs-3 text-center xs-none">
                                                                        <p><?php echo ($value["number_linkedin"] != null) ? $value["number_linkedin"] : 0 ;?></p>
                                                                    </div> 
                                                                </div>
                                                            </div>
                                                        </div>
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
                                                <p class="number-click-week">Clicks in the last month</p>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="box-right-your-reports" data-type = "photo-blog-view">
                                        <div class="row">
                                            <div class="col-xs-9 col-md-7"></div>
                                            <div class="col-xs-3 col-md-5">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-md-4 relative text-center box-click">
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
                                                            <div class="col-lg-2 text-center"><div class="logo-user"><img src="<?php echo $logo;?>"></div></div>
                                                            <div class="col-lg-6">
                                                                <p><?php echo $value["first_name"]. " ".$value["last_name"] ;?> | <?php echo $value["company_name"] ;?></p>
                                                                <p><?php echo  date('F j \a\t h:i A', $timestamp);?></p>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <ul class="list-inline action-img">
                                                                    <li><a href="javascript:;"><img src="<?php echo skin_url("icon/icon-user.png");?>"></a></li>
                                                                    <li><a href="javascript:;"><img src="<?php echo skin_url("/icon/icon-message.png");?>"></a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-3 col-md-5 show-number">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-xs-4 text-center">
                                                                    <p><?php echo $value['number_proflie'];?></p>
                                                                </div>
                                                            </div> 
                                                        </div>
                                                        <div class="col-md-6"></div>
                                                    </div>
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
                    <h5 class="title-page-1">Sort by: Date View</h5>
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
                                                    <div class="col-xs-12">
                                                        <?php  $tracking = @$value["tracking"];?>
                                                        <?php $photo = @$value["photo"];?>
                                                        <h3 style="margin-top: 0"><span class="number_view_photo"><?php echo (@$tracking != null) ? $tracking["qty_view"] : 0; ?></span><span style="font-size: 30px;"> Image Views</span></h3>
                                                        <h3><?php echo @$photo["name"];?><?php echo @$photo["title"];?></h3>
                                                     </div>
                                                    <div class="col-xs-9 col-md-7"></div>
                                                    <div class="col-xs-3 col-md-5 show-number">
                                                        <div class="row">
                                                            <div class="col-md-7">
                                                                <div class="row">
                                                                    <div class="col-xs-2 col-md-2 relative text-center box-click">
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
                                                                    <div class="col-xs-2 col-md-2 relative text-center box-click">
                                                                        <img class="icon" src="<?php echo skin_url("images/heart.png");?>">
                                                                        <div class="box-sort-by">
                                                                            <h4>Sort by:</h4>
                                                                            <div class="list-chose" data-colum="like">
                                                                                <ul class="list-item">
                                                                                    <li><a href="#" data-order="newest">Newest</a></li>
                                                                                    <li><a href="#" data-order="oldest">Oldest</a></li>
                                                                                    <li><a href="#" data-order="most-shared">Most shared</a></li>
                                                                                    <li><a href="#" data-order="least-shared">Least shared</a></li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xs-2 col-md-2 relative text-center box-click">
                                                                        <img class="icon" src="<?php echo skin_url("images/pushpin-myphoto.png");?>">
                                                                        <div class="box-sort-by">
                                                                            <h4>Sort by:</h4>
                                                                            <div class="list-chose" data-colum="pin">
                                                                                <ul class="list-item">
                                                                                    <li><a href="#" data-order="newest">Newest</a></li>
                                                                                    <li><a href="#" data-order="oldest">Oldest</a></li>
                                                                                    <li><a href="#" data-order="most-shared">Most shared</a></li>
                                                                                    <li><a href="#" data-order="least-shared">Least shared</a></li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xs-2 col-md-2 relative text-center box-jpg">
                                                                        <p class="icon">JPG</p>
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
                                                                    <div class="col-xs-2 col-md-2 relative text-center box-click">
                                                                        <p class="icon">PDF</p>
                                                                        <div class="box-sort-by">
                                                                            <h4>Sort by:</h4>
                                                                            <div class="list-chose" data-colum="pdf">
                                                                                <ul class="list-item">
                                                                                    <li><a href="#" data-order="newest">Newest</a></li>
                                                                                    <li><a href="#" data-order="oldest">Oldest</a></li>
                                                                                    <li><a href="#" data-order="most-shared">Most shared</a></li>
                                                                                    <li><a href="#" data-order="least-shared">Least shared</a></li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xs-2 col-md-2 relative text-center box-click">
                                                                        <p class="icon">RQF</p>
                                                                        <div class="box-sort-by">
                                                                            <h4>Sort by:</h4>
                                                                            <div class="list-chose" data-colum="rqf">
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
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="row"> 
                                                                    <div class="col-xs-3 text-center relative box-email">
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
                                                                    <div class="col-xs-3 text-center relative box-facebook xs-none">
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
                                                                    <div class="col-xs-3 text-center relative box-twitter xs-none">
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
                                                                    <div class="col-xs-3 text-center relative box-in xs-none">
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
                                                                    <div class="col-lg-2 text-center"><div class="logo-user"><img src="<?php echo $logo;?>"></div></div>
                                                                    <div class="col-lg-6">
                                                                        <p><?php echo $value_items["first_name"]. " ".$value_items["last_name"] ;?> | <?php echo $value_items["company_name"] ;?></p>
                                                                        <p><?php echo  date('F j \a\t h:i A', $timestamp);?></p>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <ul class="list-inline action-img">
                                                                            <li><a href="javascript:;"><img src="<?php echo skin_url("icon/icon-user.png");?>"></a></li>
                                                                            <li><a href="javascript:;"><img src="<?php echo skin_url("/icon/icon-message.png");?>"></a></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-3 col-md-5 show-number">
                                                            <div class="row">
                                                                <div class="col-md-7">
                                                                    <div class="row">
                                                                        <div class="col-xs-2 col-md-2 text-center">
                                                                            <p><?php echo ($value_items["number_proflie"] != null) ? $value_items["number_proflie"] : 0 ;?></p>
                                                                        </div>
                                                                        <div class="col-xs-2 col-md-2 text-center">
                                                                            <p><?php echo ($value_items["number_like"] != null) ? $value_items["number_like"] : 0 ;?></p>
                                                                        </div>
                                                                        <div class="col-xs-2 col-md-2 text-center">
                                                                            <p><?php echo ($value_items["number_pin"] != null) ? $value_items["number_pin"] : 0 ;?></p>
                                                                        </div>
                                                                        <div class="col-xs-2 col-md-2 text-center">
                                                                            <p><?php echo ($value_items["number_jpg"] != null) ? $value_items["number_jpg"] : 0 ;?></p>
                                                                        </div>
                                                                        <div class="col-xs-2 col-md-2 text-center">
                                                                            <p><?php echo ($value_items["number_pdf"] != null) ? $value_items["number_pdf"] : 0 ;?></p>
                                                                        </div>
                                                                        <div class="col-xs-2 col-md-2 text-center">
                                                                            <p><?php echo ($value_items["number_rfq"] != null) ? $value_items["number_rfq"] : 0 ;?></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <div class="row">
                                                                        <div class="col-md-3 text-center">
                                                                            <p><?php echo ($value_items["number_email"] != null) ? $value_items["number_email"] : 0 ;?></p>
                                                                        </div>
                                                                        <div class="col-md-3 text-center xs-none">
                                                                            <p><?php echo ($value_items["number_facebook"] != null) ? $value_items["number_facebook"] : 0 ;?></p>
                                                                        </div>
                                                                        <div class="col-md-3 text-center xs-none">
                                                                            <p><?php echo ($value_items["number_twitter"] != null) ? $value_items["number_twitter"] : 0 ;?></p>
                                                                        </div>
                                                                        <div class="col-md-3 text-center xs-none">
                                                                            <p><?php echo ($value_items["number_linkedin"] != null) ? $value_items["number_linkedin"] : 0 ;?></p>
                                                                        </div> 
                                                                    </div>
                                                                </div>
                                                            </div>
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
 
<script type="text/javascript">
    var reset_click = 0;
    $(document).on("click",".your_reports .relative .icon",function(){
        $(".your_reports .relative").not($(this).parents(".open")).removeClass("open");
        if($(this).parent().hasClass("open") == true){
            $(this).parent().removeClass("open");
        }else{
            $(this).parent().addClass("open");
        }
    });
    $(document).on("click",".list-chose .list-item li a",function(){
        var loadding = "<p class='loadding-reports' style='width: 100%;text-align: center;height: 10px;position: absolute;left: 0;bottom: 15px;'><img style='height:20px;' src='"+base_url+"skins/images/loadding.GIF'/></p>";
        var new_this = $(this);
        var box_select = $(this).parents(".box-right-your-reports").find("#list-items");
        var data_order = $(this).data("order");
        var data_type = $(this).parents(".box-right-your-reports").data("type");
        var post_id   = $(this).parents(".content-your-reports").data("id");
        var data_colum = $(this).parents(".list-chose").data("colum");
        var limit_box = $(this).parents(".box-right-your-reports").find("#list-items").find(".items").length;
        if(reset_click == 0){
            $(this).parents(".box-right-your-reports").append(loadding);
            reset_click++;
            $.ajax({
                url : base_url + "company/order_reports",
                type:"post",
                dataType: "json",
                data:{
                    "data_order" : data_order,
                    "data_type"  : data_type,
                    "post_id"    : post_id,
                    "data_colum" : data_colum,
                    "limit_box"  : limit_box
                },
                success:function(data){
                    if(data["success"] == "success"){       
                        box_select.html(data["reponse"]);
                        new_this.parents(".box-right-your-reports").find("#order_set").val(data["orderby"]);
                    }else{
                        alert("error");
                    }
                    reset_click = 0;
                    new_this.parents(".box-right-your-reports").find(".loadding-reports").remove();
                },error:function(){
                    reset_click = 0;
                    new_this.parents(".box-right-your-reports").find(".loadding-reports").remove();
                }
            });
        }
        return false;
    });
    $(document).on("click","#more-your-reports a",function(){
        var loadding = "<p class='loadding-reports' style='width: 100%;text-align: center;height: 10px;position: absolute;left: 0;bottom: 15px;'> <img style='height: 20px;' src='"+base_url+"skins/images/loadding.GIF'/></p>";
        var data_type = $(this).parents(".box-right-your-reports").data("type");
        var data =  $(this).parents(".box-right-your-reports").find("#order_set").val();
        var limit_box = $(this).parents(".box-right-your-reports").find("#list-items").find(".items").length;
        var new_this = $(this);
        var box_select = $(this).parents(".box-right-your-reports").find("#list-items");
        var post_id   = $(this).parents(".content-your-reports").data("id");
        if(reset_click == 0){
            $(this).parents(".box-right-your-reports").append(loadding);
            reset_click++;
            $.ajax({
                url : base_url + "company/more_reports",
                type:"post",
                dataType: "json",
                data:{
                    "data" : data,
                    "data_type"  : data_type,
                    "limit_box"  : limit_box,
                    "post_id"    : post_id

                },
                success:function(data){
                    new_this.parents(".box-right-your-reports").find(".loadding-reports").remove();
                    if(data["success"] == "success"){       
                        box_select.append(data["reponse"]);
                        if(data["hidden_more"] == "true"){
                            new_this.parents("#more-your-reports").remove();
                        }
                    }else{
                        alert("error");
                    }
                    reset_click = 0;
                    
                },error:function(){
                    reset_click = 0;
                    new_this.parents(".box-right-your-reports").find(".loadding-reports").remove();
                }
            });
        }
        return false;
    });
    var reset_paging = 0;
    var item_total = 5;
    var number_scroll = 0;
    var next_page = 0;
    $(document).ready(function(){
        get_number_scroll();
        $(window).scroll(function () {
            if( number_scroll > 1 && reset_paging == 0 && ($(window).scrollTop() + $(window).height() + 100) >= $(document).height() ){
                reset_paging ++ ;
                number_scroll--;
                next_page++
                get_items();
            }
        });
    });
    function get_number_scroll(){
        number_scroll = Math.ceil(reports_total/item_total);
    }
    function get_items(){
        $("#reports-photo-box .loadding").show();
        $.ajax({
            url:base_url+"company/paging_reports",
            type:"post",
            dataType:"json",
            data:{"next_page":next_page,"item_total": item_total},
            success:function(data){
                if(data["success"] == "success"){       
                    $("#reports-photo-box .box-items-reports-photo").append(data["reponse"]);
                }else{
                    alert("error");
                }
                reset_paging = 0;
                $("#reports-photo-box .loadding").hide();
            },
            error:function(){
                reset_paging = 0;
                $("#reports-photo-box .loadding").hide();
            }
        });
    }
</script>

