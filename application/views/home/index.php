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
                            <h3 class="color-white">The social market network exclusively for the <br> design, architecture, products and contract trades.</h3>
                            <div class="space-30"></div>
                            <h3 class="color-brand-primary">Share images. Engage directly. Grow business.</h3>
                            <div class="space-30"></div>
                            <a href="#" class="btn btn-gray" id="just-browse">Just browse</a>
                            <a href="#" id="show_box_login" class="btn btn-primary">Sign in</a>
                            <a href="#" id="get-started" class="btn btn-secondary">Join Today</a>
                        </div> 
                    </div>
                </div>
            </div>
        <?php endif;?>
        <?php if (!isset($is_login) || $is_login != true) : ?>
            <div id="dw-slider-home">	
               <a href="#" id="how_it_works" onclick="how_it_works();return false;" id="">How It Works</a>
               <video  autoplay muted loop webkit-playsinline src="<?php echo  skin_url("/media/Dezignwall-Index-Page-Video-12.mp4");?>" id="video1" class="video"  poster ="<?php echo skin_url("images/video_bg.jpg");?>" width="100%"></video>
				<div class="video-poster-mobile hidden-md hidden-lg" style="background-image: url('<?php echo skin_url("images/Dezignwall-Index-Page-Gif.gif");?>')"></div>
                
                <div class="slider-content-holder">
                	<div class="container">
						<div class="div-table">
							<div class="div-cell">
								<div class="slider-head">
									<img class="wordmark-image" src="<?php echo skin_url("images/Dezignwall-Icon-with-Wordmark.png");?>" title="Dezignwall-Icon-with-Wordmark">
									<h2 class="slider-title">The Fastest Growing Network for Design Professionals</h2>
								</div>
								<h4 class="slider-subtitle">The world's largest design and architecture virtual tradeshow</h4> 
								<form id="dw-seach-home-photo" method="get" action="<?php echo base_url("search") ?>">
									<input type="text" class="seach-input-slider form-control" name="keyword" id="input-seach" placeholder="Find your design inspiration..." autocomplete="off">
									<button type="submit"><img src="<?php echo skin_url(); ?>/images/search-icon-1.png"></button>
								</form>
							</div>
						</div>
						<p class="slider-text-bottom">Free to join. Free to use. Free to grow your business.</p>
					</div>
                </div>
			</div>
        <?php endif;?>
    </div>
    <?php if (!isset($is_login) || $is_login != true) : ?>
        <div class="section section-2 section-intro text-center">
            <div class="container">
                <h3><strong>A social platform for us. The Design Community.</strong></h3>
                <div class="row">
                     <div class="col-sm-3">
                        <div class="box-intro">
                            <img src="<?php echo skin_url(); ?>/images/user_two.png">
                            <p><strong>Connect with colleagues, vendors, suppliers and reps in a global </strong></p>
                            <a href="#" name="started-one" class="singup" id="get-started"><strong>Connect...</strong></a>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="box-intro">
                            <img src="<?php echo skin_url(); ?>/images/home-intro-1.png">
                            <p><strong>Post high quality images to showcase your projects or products to a B2B audience</strong></p>
                            <a href="#" name="started-one" class="singup" id="get-started"><strong>Share...</strong></a>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="box-intro">
                            <img src="<?php echo skin_url(); ?>/images/home-intro-2.png">
                            <p><strong>Engage directly with designers, manufacturers, suppliers, artists and craftsmen of all sizes</strong></p>
                            <a href="#" name="started-two" class="singup" id="get-started"><strong>Source...</strong></a>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="box-intro">
                            <img src="<?php echo skin_url(); ?>/images/home-intro-3.png">
                            <p><strong>Pin your images to virtual mood boards and collaborate with colleagues 24/7</strong></p>
                            <a href="#" class="singup" name="started-three" id="get-started"><strong>Collaborate....</strong></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section section-3 text-center">
            <div class="manufacturer-box">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-sm-center">
                            <h1 class="is_dezignwall"><span>Is Dezignwall a fit for you? Yes, it is.</span> <a class="btn singup" name="singup-now" id="get-started" href="#">Join Today</a></h1>
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
                <h2 class="text-center find-inspiration" style="padding-bottom: 20px;">Find your design inspiration...</h2>
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