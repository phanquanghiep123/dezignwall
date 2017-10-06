<!DOCTYPE html>
<!-- saved from url=(0014)about:internet -->
<html lang="en" prefix="og: http://ogp.me/ns#">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta http-equiv="X-UA-Compatible" content="IE=9">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta content="<?php echo isset($description_page) ? $description_page : "Discover commercial products, inspiring architectural, exterior, interior design walls and design trends posted by design professionals." ?>" name="description"/>
        <link rel="manifest" href="manifest.json">
        <meta name="application-name" content="Dezignwall">
        <?php if(isset($data_share)){echo $data_share;}?>
        <link rel="shortcut icon" href="<?php echo skin_url('/images/favicon.ico') ?>">
        <title><?php echo isset($title_page) ? $title_page ." | DezignWall - Discover inspiring architectural exterior interior product design walls!" : "Find and share commercial products and inspiration" ?> </title>
        <?php
            $data["type_photo"]    = @$type_photo;
            $data["keyword"]       = @$keyword;
            $data["all_category"]  = @$all_category;
            $data["id_photo_show"] = @$id_photo_show;
        ?>
        <?php $this->load->view("include/head.php", $data); ?>
    </head>
    <body>
        <div id="header" class="structural-block ">
            <div class="top mobile-static">
                <div class="container box-public relative mobile-static">
                    <div class="row relative mobile-static">
                        <div class="col-xs-1 col-sm-2 col-md-2 col-lg-2">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 text-sm-left mobile-no-padding text-md-center col-brand">
                                    <div class="logo" title="<?php echo isset($title_page) ? $title_page : "Discover inspiring design walls posted by professional exterior architectural interior designers!" ?> | DezignWall - Discover commercial products, inspiring design walls, and design trends posted by architectural exterior interior design professionals"><a href="<?php echo base_url('?rf=gh-logo'); ?>"><div class="logo-site"></div></a></div>
                                </div>
                            </div>
                        </div>
                        <?php 
                            $user = $this->session->userdata('user_info');
                            $column = "3";
                            $h_sr = "";
                            $column_re = "6";
                            $column_img = "4";
                            $colum_search ="6";
                            $column_profile = "6";
                            if (!$this->session->userdata('user_sr_info') && $this->session->userdata('user_info') && true && @$user["is_blog"] == "no") {
                                $h_sr = '<a class="btn-upload" href="'.base_url("profile/edit?share").'"><img src="'.skin_url('images/Business.png').'"></a>';
                                $column = "2";
                                $column_re = "7";
                                $column_img = "6";
                                $colum_search = "6";
                                $column_profile = "6";
                            }
                            elseif(!@$is_login){
                                $colum_search = "7";
                                $h_sr = '<a onclick="return check_login();" name="share" class="btn-upload" href="#"><img src="'.skin_url('images/Business.png').'"></a>';
                                $column = "2";
                                $column_re = "5";
                                $column_img = "5";
                                $colum_search ="7";
                                $column_profile = "5";

                            }
                            if($h_sr == "" || !@$is_login){
                                $colum_search ="6";
                                $column_profile = "6";
                            }else{
                                 $colum_search = "6";
                                $column_profile = "6";
                            }
                        ?>  
                        <div class="menu-destop-new">
                            <div class="col-lg-3 col-md-3">
                                <div class="box-menu menu-category">
                                    <ul class="menu-category parents list-inline">
                                    <?php
                                        $CI = & get_instance();
                                        $CI->load->model('Menu_model');
                                        $menu = $CI->Menu_model->get_list_menu_group(1);
                                        echo $CI->Menu_model->build_menu(0, $menu, 'menu-category parents list-inline');
                                    ?>
                                    </ul>
                                </div> 
                            </div>
                            <div class="col-xs-10 col-sm-10 col-md-7 col-lg-7 text-right mobile-static">
                                <div class="row mobile-static">
                                    <div class="seach-home mobile-seach relative col-xs-2 col-sm-2 col-md-2 mobile-no-padding">
                                        <button class="seach-sumit text-right" id="seach-sumit"><img src="<?php echo skin_url(); ?>/images/icon-seach.png"></button>
                                    </div>
                                    <div class="col-xs-<?php echo $column;?> col-sm-6 col-md-7 col-lg-6 static col-search">
                                        <div class="seach-mobile-box-refine-search">
                                            <?php 
                                                $data['class_control'] = @$class_control;
                                                $this->load->view("include/header-seach", $data['class_control']);
                                            ?>  
                                        </div>
                                    </div>
                                    <div class="col-xs-<?php echo $column;?> col-md-12 mobile">
                                        <a href="#" class="mobile control-menu-mobile text-right">
                                            <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>
                                        </a>
                                    </div>
                                    <div class="col-xs-7 col-sm-4 col-md-5 col-lg-6 right mobile-no-padding col-user">
                                       <?php 
                                        $images_logo_upload = skin_url('images/icon-upload.png');
                                        $href_upload = base_url('profile/addphotos');
                                        if ($this->session->userdata('user_info')) {                                   
                                            if( isset($user["is_blog"]) && $user["is_blog"] == "yes"){
                                                $images_logo_upload = skin_url('images/icon_articles.png');
                                                $href_upload        = base_url("article/add");
                                            }
                                        }
                                        $not_login = "";
                                        if($this->session->userdata('user_sr_info')){
                                            $images_logo_upload = skin_url('images/Business.png');
                                            $not_login = "not_login";
                                            $href_upload = base_url("business/view_profile?share");
                                        }
                                       ?>
                                        <div class="col-user-item">
                                            <ul class="menu-img <?php echo ($user["is_blog"] == "yes") ? "is_blog" : "";?>">
                                                <li><a class="btn-upload <?php echo $not_login;?>" href="<?php echo $href_upload; ?>"><img src="<?php echo $images_logo_upload; ?>"></a></li>
                                                <?php if(!$this->session->userdata('user_sr_info')){?>
                                                    <li><a class="btn-upload" href="<?php echo base_url("/profile/edit?share");?>"><img src="<?php echo skin_url("/images/Business.png");?>"></a></li>                                                
                                                <?php } ?>
                                                <?php if (isset($is_login) && $is_login == true) {?>
                                                <li>
                                                    <?php $notification = get_notifications($user["id"])?>
                                                    <a id="show-notification" class="btn-upload <?php echo $not_login;?>" href="#"><img src="<?php echo skin_url("images/bell.png"); ?>"><?php if($notification > 0):?><span class="number"><?php echo $notification;?></span><?php endif;?></a>
                                                    <?php $this->load->view("include/notification",$user)?>
                                                </li>
                                                <?php } ?>
                                                <li>
                                                	<?php
			                                            $login_data = 0 ;
			                                            if(!$this->session->userdata('user_sr_info')){
			                                                if (isset($is_login) && $is_login == true) {
			                                                $login_data = 1;
			                                                $this->load->view("include/header_user_login", @$record_user);
			                                                } else {
			                                                    $login_data = 1;
			                                                    $this->load->view("include/header_user_logout");
			                                                }
			                                            }else{
			                                                $this->load->view("include/user_sr_login");
			                                            }
		                                            ?>
                                                </li>
                                            </ul>
                                            <script type="text/javascript">
                                                var height_header = $("body #header").outerHeight();
                                                $(".menu-destop-new #show-notification").click(function(){
                                                    if($(this).hasClass("open-box") == true){      
                                                        $("#header #notifications").animate({
                                                            opacity:0
                                                        },500,function(){
                                                            $("#header #notifications").hide();  
                                                        }); 
                                                        $(this).removeClass("open-box");
                                                    }else{
                                                        $("#header #notifications").show();
                                                        $("#header #notifications").animate({
                                                            opacity:1
                                                        },500);      
                                                        $(this).addClass("open-box");
                                                        $.get(base_url+"photos/view_notifications");
                                                        $("#header #show-notification .number").remove();
                                                    } 
                                                    return false; 
                                                });
                                                $(document).ready(function(){
                                                    $("#header #notifications #close-form").click(function(e){
                                                        $("#header #notifications").animate({
                                                            opacity:0
                                                        },500,function(){
                                                            $("#header #notifications").hide();  
                                                        }); 
                                                        $("#show-notification").removeClass("open-box");
                                                   });
                                                });
                                                $(window).load(function(){
                                                    var height_header = $("#header").outerHeight();
                                                    var height_footer = $("#footer").outerHeight();
                                                    var body_hegiht   = screen.height;
                                                    var height_notification = body_hegiht - (height_header + height_footer + 60);
                                                    $("#notifications .dw-event-body .body-child").css("height",height_notification+"px");
                                                });
                                                $(document).on("click","#notifications #more-nofication",function(){
                                                    var type = $(this).attr("data-type");
                                                    var object = $(this).attr("data-object");
                                                    var _this = $(this);
                                                    var current_parent = $(this).closest(".body-child-main");
                                                    var number_items = current_parent.find(".media").length;
                                                    $.ajax({
                                                        url : base_url + "photos/more_nofication",
                                                        dataType:"json",
                                                        type:"post",
                                                        data:{"type" : type , "object" : object, "number_items": number_items},
                                                        success:function(res){
                                                            console.log(res);
                                                            if(res["status"] == "success"){
                                                                _this.closest(".row").before(res["response"]);
                                                                if(res["next"] == false){
                                                                    _this.closest(".row").remove();
                                                                }
                                                            }else{
                                                                alert("Error!");
                                                            }
                                                        },error:function(){
                                                             alert("Error!");
                                                        }
                                                    });
                                                    return false;
                                                });
                                                $(document).on("click","#notifications #confirm-follow",function(){
                                                    var id = $(this).attr("data-id");
                                                    var _this = $(this);
                                                    $.ajax({
                                                        url : base_url + "photos/confirm_follow",
                                                        type:"post",
                                                        data :{id:id},
                                                        dataType:"json",
                                                        success : function(res){
                                                            console.log(res);
                                                            if(res["status"] == "success")
                                                                _this.attr("disabled","true");
                                                            else 
                                                                alert("Error!"); 
                                                        },error:function(){
                                                            alert("Error!"); 
                                                        }
                                                    })
                                                });
                                                $(document).on("click","#notifications #delete-follow",function(){
                                                    var id = $(this).attr("data-id");
                                                    var _this = $(this);
                                                    $.ajax({
                                                        url : base_url + "photos/delete_follow",
                                                        type:"post",
                                                        data :{id:id},
                                                        dataType:"json",
                                                        success : function(res){
                                                            if(res["status"] == "success")
                                                                _this.closest(".media").remove();
                                                            else 
                                                                alert("Error!");    
                                                        },error:function(){
                                                            alert("Error!");

                                                        }   
                                                    })
                                                });
                                            </script>
                                        </div>
                                    </div>    
                                </div>
                            </div>
                        </div>
                        <div class="menu-mobile-new">
                            <div class="col-xs-11 col-sm-10 col-md-9 col-lg-7 text-right mobile-static">
                                <div class="row mobile-static">
                                    <div class="seach-home mobile-seach relative col-xs-2 col-sm-2 col-md-2 mobile-no-padding">
                                        <button class="seach-sumit text-right" id="seach-sumit"><img src="<?php echo skin_url(); ?>/images/icon-seach.png"></button>
                                    </div>
                                    <div class="col-xs-2 col-sm-6 col-md-<?php echo $colum_search;?> col-lg-<?php echo $colum_search;?> static col-search">
                                        <div class="seach-mobile-box-refine-search">
                                            <?php 
                                                $data['class_control'] = @$class_control;
                                                $this->load->view("include/header-seach", $data['class_control']);
                                            ?>  
                                        </div>
                                    </div>
                                    <div class="col-xs-2 col-md-12 mobile">
                                        <a href="#" class="mobile control-menu-mobile text-right">
                                            <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>
                                        </a>
                                    </div>
                                    <?php $columnlast = 12 - ($column * 2)?>
                                    <div class="col-xs-8 col-sm-4 col-md-6 col-lg-<?php echo @$column_profile;?> right mobile-no-padding col-user">
                                       <?php 
                                        $images_logo_upload = skin_url('images/icon-upload.png');
                                        $href_upload = base_url('profile/addphotos');
                                        if ($this->session->userdata('user_info')) {                                   
                                            if( isset($user["is_blog"]) && $user["is_blog"] == "yes"){
                                                $images_logo_upload = skin_url('images/icon_articles.png');
                                                $href_upload        = base_url("article/add");
                                            }
                                        }
                                        $not_login = "";
                                        if($this->session->userdata('user_sr_info')){
                                            $images_logo_upload = skin_url('images/Business.png');
                                            $not_login = "not_login";
                                            $href_upload = base_url("business/view_profile?share");
                                        }
                                       ?>
                                        <div class="col-user-item">
                                            <ul class="menu-img">
                                                <li><a class="btn-upload <?php echo $not_login;?>" href="<?php echo $href_upload; ?>"><img src="<?php echo $images_logo_upload; ?>"></a></li>
                                                <?php if(!$this->session->userdata('user_sr_info')){?>
                                                    <li><a class="btn-upload" href="<?php echo base_url("/profile/edit?share");?>"><img src="<?php echo skin_url("/images/Business.png");?>"></a></li>                                                
                                                <?php } ?>
                                                <?php if (isset($is_login) && $is_login == true) {?>
                                                <li>
                                                    <?php $notification = get_notifications($user["id"])?>
                                                    <a id="show-notification" class="btn-upload <?php echo $not_login;?>" href="#"><img src="<?php echo skin_url("images/bell.png"); ?>"><?php if($notification > 0):?><span class="number"><?php echo $notification;?></span><?php endif;?></a>
                                                    <?php $this->load->view("include/notification",$user)?>
                                                </li>
                                                <?php } ?>
                                                <li>
                                                    <?php
                                                        $login_data = 0 ;
                                                        if(!$this->session->userdata('user_sr_info')){
                                                            if (isset($is_login) && $is_login == true) {
                                                            $login_data = 1;
                                                            $this->load->view("include/header_user_login", @$record_user);
                                                            } else {
                                                                $login_data = 1;
                                                                $this->load->view("include/header_user_logout");
                                                            }
                                                        }else{
                                                            $this->load->view("include/user_sr_login");
                                                        }
                                                    ?>
                                                </li>
                                            </ul>
                                        </div>
                                        
                                    </div>    
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="box-menu menu-category">
                                    <ul class="menu-category parents list-inline">
                                        <?php
                                            $CI = & get_instance();
                                            $CI->load->model('Menu_model');
                                            $menu = $CI->Menu_model->get_list_menu_group(1);
                                            echo $CI->Menu_model->build_menu(0, $menu, 'menu-category parents list-inline');
                                        ?>
                                        
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    if (!isset($is_login) || $is_login != true) {
                        $this->load->view("include/from-login");
                        $this->load->view("include/from-signup");
                    }
                    ?>
                </div>
            </div>
            <!--header box-favorite-bar-->
            <!--!header box-favorite-bar-->
        </div>
        <?php if (isset($is_login) && $is_login == true) {?>
        <div class="boxshow-destop">
            <?php $this->load->view("include/events-box");?>
            <script>
                $(window).load(function(){
                   var with_net_box = $("body #show-events").outerWidth();
                   var width_current_box = $(".boxshow-destop").outerWidth();
                   $(".boxshow-destop").hide();
                   $("#header #show-events").click(function(){
                        if($(this).hasClass("open-box") == true){      
                            $(".boxshow-destop").animate({
                                opacity:0
                            },500,function(){
                                $(".boxshow-destop").hide();  
                            }); 
                            $("#header #show-events").removeClass("open-box");
                       }else{
                            var height_header = $("body #header #show-events").parent().outerHeight();
                            var top_box = $("body #header #show-events").parent().offset().top;
                            var left_box = $("body #show-events").parent().offset().left;
                            top_box = height_header +top_box;
                            left_box = left_box - width_current_box + with_net_box;
                            $(".boxshow-destop").css({top: top_box+"px",left:left_box+"px"});
                            $(".boxshow-destop").show();
                            $(".boxshow-destop").animate({
                                opacity:1
                            },500);      
                            $("#header #show-events").addClass("open-box");
                       }
                   });
                });
                $(document).ready(function(){
                    $(".boxshow-destop #box-events #close-form").click(function(e){
                       $(".boxshow-destop").animate({
                           opacity:0
                       },500,function(){
                           $(".boxshow-destop").hide();
                       });
                       $("#header #show-events").removeClass("open-box");
                       return false;
                   });
                });
            </script>
        </div>
        <div class="boxshow-mobile">
            <div class="modal fade" id="modal-events" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <?php $this->load->view("include/events-box");?>
                    </div>
                </div>
                <script type="text/javascript">
                    $("#show-pouup-events").click(function(){
                        $(".boxshow-mobile #modal-events").modal();
                    });
                    $(".boxshow-mobile #modal-events #close-form").click(function(e){
                        e.stopPropagation();
                        $(".boxshow-mobile #modal-events").modal("hide");
                        return false;
                    });
                </script>
            </div>
        </div>
        <div id="social-post">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <div id="wrapper2" class="structural-block <?php echo @$class_page;?>">
            <?php if(@$is_home == true && isset($is_login) && $is_login == true):?>
            <?php $data_record = get_company_top_follow(@$user["id"])?>
            <div class="box-favorite-bar">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 border-right column-left box-favorite">
                            <p class="remove-bottom-10">Latest updates from the companies you follow:</p>
                            <?php if($data_record != null):?>
                            <ul class="list-inline fix-margin follow-companys">
                                <?php 
                                    foreach ($data_record as $key => $value) {?>
                                    <?php 
                                        $avatar = isset($value["logo"]) && $value["logo"]!= "" ? base_url(@$value["logo"]) : skin_url("images/logo-company.png");
                                    ?>
                                    <li>
                                        <a href="<?php echo base_url("company/view/".$value["member_id"])?>">
                                            <img class="img-circle" src="<?php echo base_url($avatar)?>">
                                        </a>
                                        <span class="counter"><?php echo ($value["number_follow"]/1000 >= 1) ? "+".($value["number_follow"]/1000 )."k" : "+".$value["number_follow"]?></span>
                                    </li>     
                                <?php } ?>   
                            </ul>
                            <?php endif;?>
                        </div>
                        <div class="col-md-6 border-left column-right box-favorite">
                            <p class="remove-bottom-10">Share socially...</p>
                            <div class="media remove-margin">
                                <div class="media-left">
                                    <img class="img-circle media-object" src="<?php echo isset($user["avatar"])&& $user["avatar"]!="" ? base_url($user["avatar"]) : skin_url("images/avatar-full.png"); ?>" width="50px">
                                </div>
                                <div class="media-body">
                                    <a id="btn-add-social" class="btn-up-comment" href="#">Hi <?php echo @$user["first_name"];?>! What’s on your mind?</a>
                                </div>
                            </div>
                        </div>           
                    </div>
                </div>
            </div>
            <?php endif;?>   