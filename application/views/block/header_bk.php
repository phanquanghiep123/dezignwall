<!DOCTYPE html>
<html lang="en" prefix="og: http://ogp.me/ns#">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    	  <meta http-equiv="X-UA-Compatible" content="IE=9">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta content="<?php echo isset($description_page) ? $description_page : "Discover commercial products, inspiring architectural, exterior, interior design walls and design trends posted by design professionals." ?>" name="description"/>
        <?php if(isset($data_share)){echo $data_share;}?>
        <link rel="shortcut icon" href="<?php echo skin_url('/images/favicon.ico') ?>">
        <title><?php echo isset($title_page) ? $title_page ." | DezignWall - Discover inspiring architectural exterior interior product design walls!" : "Find and share commercial products and inspiration" ?> </title>
        <?php
        $data["type_photo"] = @$type_photo;
        $data["keyword"] = @$keyword;
        $data["all_category"] = @$all_category;
        $data["id_photo_show"] = @$id_photo_show;
        ?>
        <?php $this->load->view("include/head.php", $data); ?>




    </head>
    <body>


<!-- Google Tag -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-87683167-1', 'auto');
  // ga('send', 'pageview');

</script>

<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WBL6PKK"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag -->


        <div id="header" class="structural-block ">
            <div class="top mobile-static">
                <div class="container box-public relative mobile-static">
                    <div class="row relative mobile-static">
                        <div class="col-xs-2 col-sm-3">
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
                            if (!$this->session->userdata('user_sr_info') && $this->session->userdata('user_info') && @$user["type_member"] == 1 && @$user["is_blog"] == "no") {
                                $h_sr = '<a class="btn-upload" href="'.base_url("profile/edit?share").'"><img src="'.skin_url('images/Business.png').'"></a>';
                                $column = "2";
                                $column_re = "8";
                                $column_img = "5";
                            }
                            elseif(!$is_login){
                                $h_sr = '<a onclick="return check_login();" name="share" class="btn-upload" href="#"><img src="'.skin_url('images/Business.png').'"></a>';
                                $column = "2";
                                $column_re = "8";
                                $column_img = "5";
                            }
                        ?>
                        <div class="col-xs-10 col-sm-9 text-right mobile-static">
                            <div class="row mobile-static">
                                <div class="seach-home mobile-seach relative col-xs-2 col-sm-7 col-md-7 mobile-no-padding">
                                    <button class="seach-sumit text-right" id="seach-sumit"><img src="<?php echo skin_url(); ?>/images/icon-seach.png"></button>
                                </div>
                                <div class="col-xs-<?php echo $column;?> col-sm-7 col-md-7 col-lg-7 static col-search">
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
                                <div class="col-xs-<?php echo $column_re;?> col-sm-5 col-md-5 col-lg-<?php echo $column_img?> right mobile-no-padding col-user">
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
                                        <a class="btn-upload <?php echo $not_login;?>" href="<?php echo $href_upload; ?>"><img src="<?php echo $images_logo_upload; ?>"></a>
                                        <?php echo $h_sr;?>
                                    </div>
                                    <div class="col-user-item right">
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
                                    </div>

                                    
                                </div>    
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="box-menu box-menu-left left ">
                                <?php
                                $CI = & get_instance();
                                $CI->load->model('Menu_model');
                                $menu = $CI->Menu_model->get_list_menu_group(1);
                                echo $CI->Menu_model->build_menu(0, $menu, 'menu-category parents list-inline');
                                ?>
                            </div>
                            <div class="box-menu box-menu-right left ">
                                <?php
                                $CI = & get_instance();
                                $CI->load->model('Menu_model');
                                $menu = $CI->Menu_model->get_list_menu_group(6);
                                echo $CI->Menu_model->build_menu(0, $menu, 'menu-category parents list-inline');
                                ?>
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
        </div>

        <div id="wrapper2" class="structural-block <?php echo @$class_page;?>">