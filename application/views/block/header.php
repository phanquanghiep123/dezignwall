<!DOCTYPE html>
<html lang="en" prefix="og: http://ogp.me/ns#">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta http-equiv="X-UA-Compatible" content="IE=9">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta content="<?php echo isset($description_page) ? $description_page . " | Dezignwall - Discover, collaborate, source products and inspiration from designers, manufacturers, suppliers, craftsmen, artists globally." : $title_page . " | Dezignwall is the fastest growing network for interior design and architecture professionals. Discover, collaborate, source products and inspiration from designers, manufacturers, suppliers, craftsmen, artists globally." ?>" name="description"/>
        <meta name="theme-color" content="#14110f">
        <link rel="manifest" href="/manifest.json">
        <meta name="application-name" content="Dezignwall">
        <?php if(isset($data_share)){echo $data_share;}?>
        <link rel="shortcut icon" href="<?php echo skin_url('images/favicon.ico') ?>">
        <title><?php echo isset($title_page) ? $title_page ." | Dezignwall is the fastest growing network for interior design and architecture professionals. Discover, collaborate, source products and inspiration from designers, manufacturers, suppliers, craftsmen, artists globally." : "Dezignwall is the fastest growing network for interior design and architecture professionals. Discover, collaborate, source products and inspiration from designers, manufacturers, suppliers, craftsmen, artists globally." ?> </title>
        <?php
        $data["type_photo"] = @$type_photo;
        $data["keyword"] = @$keyword;
        $data["all_category"] = @$all_category;
        $data["id_photo_show"] = @$id_photo_show;
        ?>
        <?php $this->load->view("include/head.php", $data); ?>


    </head>
    <body>


<!-- GA Tag  moved to GTM hdr -->

<script>
/*
// #37a7a7
if ('serviceWorker' in navigator) {
  window.addEventListener('load', function() {
    navigator.serviceWorker.register('/dw-sw.js').then(function(registration) {
      // Registration was successful
      console.log('DW ServiceWorker registration successful with scope: ', registration.scope);
    }, function(err) {
      // registration failed :(
      console.log('DW ServiceWorker registration failed: ', err);
    });
  });
}
*/

/*
if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register('/dw-sw.js', {scope: './'}).then(function(registration) {
    console.log ('succeeded');
  }).catch(function(error) {
    console.log('error:' + error);
  });
} else {
    console.log('error2: else');
}
*/

/*
 if(typeof(Worker) !== "undefined") {
        if(typeof(w) == "undefined") {
            w = new Worker("/dw-sw.js");
        }
        w.onmessage = function(event) {
            //document.getElementById("result").innerHTML = event.data;
            console.log(event.data);
        };
    } else {
        document.getElementById("result").innerHTML = "Sorry, your browser does not support Web Workers...";
    }
    w.terminate();
    w=undefined;
*/
</script>

<!-- End GA Tag -->
        <div id="header" class="structural-block ">
            <div class="top mobile-static">
                <div class="container box-public relative mobile-static">
                    <div class="row relative mobile-static">
                        <div class="col-xs-2 col-sm-2">
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
                            elseif(!$is_login){
                                $colum_search = "7";
                                $h_sr = '<a onclick="return check_login();" name="share" class="btn-upload" href="#"><img src="'.skin_url('images/Business.png').'"></a>';
                                $column = "2";
                                $column_re = "5";
                                $column_img = "5";
                                $colum_search ="7";
                                $column_profile = "5";

                            }
                            if($h_sr == "" || !$is_login){
                                $colum_search ="7";
                                $column_profile = "5";
                            }else{
                                 $colum_search = "6";
                                $column_profile = "6";
                            }
                        ?>  
                        <div class="menu-destop-new">
                            <div class="col-md-3">
                                <div class="box-menu menu-category">
                                    <?php
                                    $CI = & get_instance();
                                    $CI->load->model('Menu_model');
                                    $menu = $CI->Menu_model->get_list_menu_group(1);
                                    echo $CI->Menu_model->build_menu(0, $menu, 'menu-category parents list-inline');
                                    ?>
                                </div>
                            </div>
                            <div class="col-xs-10 col-sm-10 col-md-9 col-lg-7 text-right mobile-static">
                                <div class="row mobile-static">
                                    <div class="seach-home mobile-seach relative col-xs-2 col-sm-2 col-md-2 mobile-no-padding">
                                        <button class="seach-sumit text-right" id="seach-sumit"><img src="<?php echo skin_url(); ?>/images/icon-seach.png"></button>
                                    </div>
                                    <div class="col-xs-<?php echo $column;?> col-sm-6 col-md-<?php echo $colum_search;?> col-lg-<?php echo $colum_search;?> static col-search">
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
                                    <div class="col-xs-7 col-sm-4 col-md-6 col-lg-<?php echo @$column_profile;?> right mobile-no-padding col-user">
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
                        </div>
                        <div class="menu-mobile-new">
                            <div class="col-xs-10 col-sm-10 col-md-9 col-lg-7 text-right mobile-static">
                                <div class="row mobile-static">
                                    <div class="seach-home mobile-seach relative col-xs-2 col-sm-2 col-md-2 mobile-no-padding">
                                        <button class="seach-sumit text-right" id="seach-sumit"><img src="<?php echo skin_url(); ?>/images/icon-seach.png"></button>
                                    </div>
                                    <div class="col-xs-<?php echo $column;?> col-sm-6 col-md-<?php echo $colum_search;?> col-lg-<?php echo $colum_search;?> static col-search">
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
                                    <div class="col-xs-7 col-sm-4 col-md-6 col-lg-<?php echo @$column_profile;?> right mobile-no-padding col-user">
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
                            <div class="col-md-3">
                                <div class="box-menu menu-category">
                                    <?php
                                    $CI = & get_instance();
                                    $CI->load->model('Menu_model');
                                    $menu = $CI->Menu_model->get_list_menu_group(1);
                                    echo $CI->Menu_model->build_menu(0, $menu, 'menu-category parents list-inline');
                                    ?>
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
        </div>
        <div id="wrapper2" class="structural-block <?php echo @$class_page;?>">            