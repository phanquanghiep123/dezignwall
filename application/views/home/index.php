<?php if (!isset($is_login) || $is_login != true) : ?>
    <style type="text/css">
        #message-upgrade{
            display: none;
        }
        #message-upgrade.home .modal-message-body{
            max-width: 900px;
            width: 100%;
        }
        #message-upgrade.home .modal-message-body h3{
            margin-top: 0;
            padding-top: 0;
        }
        #message-upgrade.home .modal-message-body .btn{
            font-size: 18px;
            margin-right: 20px;
            margin-bottom: 15px;
        }
        .bx-wrapper .bx-controls-direction a{
            z-index: 99;
        }
        .space-30{
            height: 30px;
        }
        @media (min-width: 768px) {
            .modal-message-wrapper.home{
                position: absolute;
                z-index: 100;
            }
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#just-browse').click(function () {
                $(this).parents('#message-upgrade').hide();
                return false;
            });
            function setCookie(cname, cvalue, exdays) {
                var d = new Date();
                d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
                var expires = "expires=" + d.toUTCString();
                document.cookie = cname + "=" + cvalue + "; " + expires;
            }
            function getCookie(cname) {
                var name = cname + "=";
                var ca = document.cookie.split(';');
                for (var i = 0; i < ca.length; i++) {
                    var c = ca[i];
                    while (c.charAt(0) == ' ')
                        c = c.substring(1);
                    if (c.indexOf(name) == 0)
                        return c.substring(name.length, c.length);
                }
                return "";
            }
            if (getCookie('hide_poppup') == '') {
                $('#just-browse').parents('#message-upgrade').show();
                setCookie('hide_poppup', 'true', 365);
            }
            
        });
    </script>
    <?php endif; ?>
    <div class="section section-1 relative">
        <?php if (!isset($is_login) || $is_login != true) : ?>
            <div id="message-upgrade" class="modal-message-wrapper home">
                <div class="box-table">
                    <div class="box-table-cell align-middle">
                        <div class="modal-message-body text-center">
                            <h3 class="color-white">The social market network exclusively for the commercial <br> design, architecture, products and contract trades.</h3>
                            <div class="space-30"></div>
                            <h3 class="color-brand-primary">Share images. Engage directly. Grow business.</h3>
                            <div class="space-30"></div>
                            <a href="#" class="btn btn-gray" id="just-browse">Just browse</a>
                            <a href="#" id="show_box_login" class="btn btn-primary">Sign in</a>
                            <a href="#" id="get-started" class="btn btn-secondary">Join now</a>
                        </div> 
                    </div>
                </div>
            </div>
        <?php endif;?>
        <?php if (!isset($is_login) || $is_login != true) : ?>
            <div id="slider-home-page">
                <a href="#" id="how_it_works" onclick="how_it_works();return false;" id="">How It Works</a>
                <div class="slider-home-img">
                    <img src="<?php echo skin_url("images/dezignwall-slider.gif");?>">
                </div>
                <div class="slider-home-video">
                <!--<iframe id="frame-slide" src="//giphy.com/embed/2sz9QzFB9RrHy" width="100%" height="513px" frameBorder="0" class="giphy-embed" allowFullScreen></iframe>-->
                <video  autoplay muted loop webkit-playsinline src="<?php echo ("//media.dezignwall.com/media/Dezignwall-Index-Page-Video-8.mp4");?>" id="video1" class="video"  poster ="<?php echo skin_url("images/bg-slider.png")?>" width="100%"></video></div>
                <div id="home-bg-slider">
                    <div class="seach-in-slider">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12 content-cented"></div>
                            </div>
                        </div>
                        <h2 class="prodemiCn text-center color-white">DESIGN YOUR COMMERCIAL SPACE</h2>
                        <h4>A visual way to discover and source products and design inspiration with tools to make collaborating on the go, easy.</h4>
                        <form id="seach-home-photo" method="get" action="<?php echo base_url("search") ?>" class="relative fom-seach-slider content-cented destop">
                            <input type="text" class="seach-input-slider form-control" name="keyword" id="input-seach" placeholder="Find your commercial design inspiration..." autocomplete="off">
                            <button class="seach-sumit"><img src="<?php echo skin_url(); ?>/images/search-icon-1.png"></button>
                        </form>
                    </div>  
                    <h3 class="free-join">Free to join. Free to use. Upgrade to unlock tools to grow your business.</h3>
                </div>
            </div>
        <?php endif;?>
    </div>
    <?php if (!isset($is_login) || $is_login != true) : ?>
        <div class="section section-2 section-intro text-center">
            <div class="container">
                <h3><strong>the bold new way to find and share design inspiration.</strong></h3>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="box-intro">
                            <img src="<?php echo skin_url(); ?>/images/home-intro-1.png">
                            <p><strong>Post high quality images to showcase your projects or products to a B2B audience</strong></p>
                            <a href="#" name="started-one" class="singup" id="get-started"><strong>Get started...</strong></a>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="box-intro">
                            <img src="<?php echo skin_url(); ?>/images/home-intro-2.png">
                            <p><strong>Engage directly with companies interested in buying or selling commercial design solutions</strong></p>
                            <a href="#" name="started-two" class="singup" id="get-started"><strong>Get started...</strong></a>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="box-intro">
                            <img src="<?php echo skin_url(); ?>/images/home-intro-3.png">
                            <p><strong>Pin your images to virtual mood boards and collaborate with colleagues 24/7</strong></p>
                            <a href="#" class="singup" name="started-three" id="get-started"><strong>Get started...</strong></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section section-3 text-center">
            <div class="manufacturer-box">
                <div class="container">
                    <div class="row">
                        <div class="col-md-9 text-sm-center">
                            <h1>Are you a design firm or a product manufacturer?</h1>
                        </div>
                        <div class="col-md-3 text-left text-sm-center">
                            <a class="btn singup" name="singup-now" id="get-started" href="#">Sign Up</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
<div class="section section-4 box-wapper-show-image">
    <div class="container">
        <div class="row">
            <div class="col-md-12 relative">
                <h2 class="text-center find-inspiration" style="padding-bottom: 20px;">Find your commercial design inspiration...</h2>
                <div id="refresh-new-image"><a href="<?php echo base_url(); ?>" class="btn btn-primary">15 New Images Posted</a></div>
            </div>
            <?php if (isset($is_login) && $is_login == true && !$this->session->userdata('user_sr_info')) { ?>
                <div class="col-sm-8 col-lg-8">
                    <div class="gird-img column-2" data-count="<?php echo @$photo_count; ?>">
                        <div class="cards"> 
                            <div class="row">
                                <?php
                                if (isset($photo)) {
                                    $data["photo"] = $photo;
                                    $this->load->view("seach/search_result_login", $data);
                                }
                                ?>
                            </div>
                        </div>
                        <div class="loadding text-center"><img src="<?php echo skin_url("images/loadding.GIF"); ?>"></div>
                    </div>
                </div>
                <div class="col-sm-4 col-lg-4">
                    <?php $this->load->view("include/like-profile"); ?>
                </div>
            <?php } else { ?>
                <div class="col-sm-12">
                    <div class="gird-img column-3" data-count="<?php echo @$photo_count; ?>">
                        <div class="cards">
                            <div class="row">
                                <?php
                                if (isset($photo)) {
                                    $data["photo"] = $photo;
                                    $this->load->view("seach/seach_result", $data);
                                }
                                ?>
                            </div>
                        </div>
                        <div class="loadding text-center"><img src="<?php echo skin_url("images/loadding.GIF"); ?>"></div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php $this->load->view("include/how-it-works-buyer");?>
<?php $this->load->view("include/how-it-works-buyer-1");?>
<?php $this->load->view("include/how-it-works-buyer-2");?>
<link rel="stylesheet" type="text/css" href="<?php echo  base_url("skins/js/jPlayer/dist/skin/blue.monday/css/jplayer.blue.monday.min.css");?>">
<script type="text/javascript" src ="<?php echo base_url("skins/js/jPlayer/dist/jplayer/jquery.jplayer.min.js");?>"></script>
<script type="text/javascript">
	$(document).contextmenu(function() {
	    return false;
	});
    $(document).ready(function(){
        var height_header = $("#header").height();
        var height_footer = $("#footer").height();
        var height_screen = $(window).height();
        var width_screen = $(window).width();
        var max_height = (height_screen) - ((height_header) + (height_footer));
        if(max_height < 513){ max_height = 513; }
        if(width_screen >= 768){
            $(".home_page #slider-home-page").css("max-height",max_height+"px");
            $(".home_page #slider-home-page #frame-slide").attr("height",max_height+"px");
        }
        
    });
    $('.bxslider-home').bxSlider({
        auto: true,
        pager: true,
        autoControls: true,
        controls:false,
        pause:2000,
        autoStart:true
    });
  
</script>