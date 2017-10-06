<!--css-->
<link href="<?php echo skin_url(); ?>/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo skin_url(); ?>/fonts/AvenirNextLT/fonts.css" rel="stylesheet">
<link href="<?php echo skin_url(); ?>/css/style.css" rel="stylesheet">
<link href="<?php echo skin_url(); ?>/css/reponsive.css" rel="stylesheet">
<link href="<?php echo skin_url(); ?>/css/page/profile.css" rel="stylesheet">
<link href="<?php echo skin_url(); ?>/jquery.bxslider/jquery.bxslider.css" rel="stylesheet" />
<link href="<?php echo skin_url(); ?>/css/bootstrap-select.css" rel="stylesheet">
<link href="<?php echo skin_url(); ?>/css/bootstrap-checkbox.css" rel="stylesheet">
<link href="<?php echo skin_url(); ?>/css/grid-img.css" rel="stylesheet">
<link href="<?php echo skin_url(); ?>/fonts/font-awesome/css/font-awesome.css" rel="stylesheet">
<link href="<?php echo skin_url(); ?>/css/pgwslideshow.css" rel="stylesheet">
<link href="<?php echo skin_url(); ?>/css/jquery-ui.css" rel="stylesheet">
<link href="<?php echo skin_url(); ?>/css/stylesheet.css" rel="stylesheet">
<!--css page-->
<link href="<?php echo skin_url(); ?>/css/page/home.css" rel="stylesheet">
<link href="<?php echo skin_url(); ?>/css/page/forgot.css" rel="stylesheet">
<link href="<?php echo skin_url(); ?>/css/page/image-page.css" rel="stylesheet">
<?php
if (isset($skins)) {
    echo '<link href="' . skin_url() . '/css/page/' . $skins . '.css" rel="stylesheet">';
}
?>
<!--js-->
<script src="<?php echo skin_url(); ?>/js/jquery.min.js"></script>
<script src="<?php echo skin_url(); ?>/jquery.bxslider/jquery.bxslider.min.js"></script>
<script src="<?php echo skin_url(); ?>/js/bootstrap.min.js"></script>
<script src="<?php echo skin_url(); ?>/js/pgwslideshow.js"></script>
<script src="<?php echo skin_url(); ?>/js/jquery.form.js"></script>
<script src="<?php echo skin_url(); ?>/js/jquery-ui.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var pgw = $('.pgwSlideshow').pgwSlideshow();
        if($('.pgwSlideshow').length > 0){
            try {           
                var current_slider = pgw.getCurrentSlide();
                var count_slider = pgw.getSlideCount();
                if($('.pgwSlideshow .ps-prev').parents('.profile').find('.edit-image').length > 0) {
                    var url = $('.ps-list .elt_'+current_slider+' img').attr('data-src');
                    $('.pgwSlideshow .ps-prev').parents('.profile').find('.edit-image').attr('href',url);
                }
            }catch(err) {
              
            }
            $(".ps-list .ps-item .slider-item").on('click',function(){
                if($(this).parents('.profile').find('.edit-image').length > 0) {
                    var url = $(this).find('img').attr('data-src');
                    $(this).parents('.profile').find('.edit-image').attr('href',url);
                }
            });

            $(".pgwSlideshow .ps-next").on('click',function(){
                current_slider = pgw.getCurrentSlide();
                console.log(current_slider);
                if($(this).parents('.profile').find('.edit-image').length > 0) {
                    var url = $('.ps-list .elt_'+current_slider+' img').attr('data-src');
                    $(this).parents('.profile').find('.edit-image').attr('href',url);
                }
            });

            $(".pgwSlideshow .ps-prev").on('click',function(){
                current_slider = pgw.getCurrentSlide();
                console.log(current_slider);
                if($(this).parents('.profile').find('.edit-image').length > 0) {
                    var url = $('.ps-list .elt_'+current_slider+' img').attr('data-src');
                    $(this).parents('.profile').find('.edit-image').attr('href',url);
                }
            });

        }

    });
</script>
<!--variables public-->
<script type="text/javascript">
    <?php $is_business = ($this->session->userdata('user_sr_info')) ? 1 : "";?>
    var base_url = "<?php echo @base_url(); ?>";
    var is_login = "<?php echo @$is_login; ?>";
    var is_business = "<?php echo @$is_business;?>";
    var offer_product = "<?php echo @$offer_product;?>";
    var type_photo_seach = "<?php echo @$type_photo; ?>";
    var keyword = "<?php echo addslashes(@$keyword); ?>";
    var catalog = "<?php echo addslashes(@$catalog); ?>";
    var all_category = "<?php echo gen_slug_st(@$all_category); ?>";
    var slug_category = "<?php echo @$category_slug; ?>";
    var photo_type = "<?php echo @$photo_type; ?>";
    var business_type = "<?php echo @$business_type ?>";
    var location_photo = "<?php echo @$location_photo ?>";
    var current_page   = "<?php echo @$data_current; ?>";
    var is_home  = "<?php echo @$is_home;?>";
    var url_reload = window.location.href;
    <?php if($this->input->get("action") && $this->input->get("url") != null && $this->input->get("url") != ""){
        echo "url_reload ='".str_replace("[]","&",$this->input->get("url"))."';";
    }?>
    var dataLayerHd ;
    var dataLayer;
    var dw_mid;
    var searchResultcount="<?php echo @$photo_count; ?>";

</script>
<?php 
   $user_infor =  $this->session->userdata('user_info');
   if($user_infor != null){ ?>
        <script type="text/javascript">
             dataLayer = [{
                dw_mid :"<?php echo @$user_infor["id"];?>",
                pageurl:"<?php echo urlencode (base_url(uri_string()));?>"
            }];
            dw_mid="<?php echo @$user_infor["id"];?>";
        </script>
   <?php } ?>
<script src="<?php echo skin_url(); ?>/js/main.js"></script>
<script src="<?php echo skin_url(); ?>/js/validate.js"></script>
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<!--Global variables javascript-->