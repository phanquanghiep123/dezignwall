<link rel="stylesheet" type="text/css" href="<?php echo skin_url("css/page/profile.css");?>">
<section class="section banner-box">
   <div class="relative">
      <?php
        $src = '';
        if(isset($article[0]['thumbnail']) && $article[0]['thumbnail']!=null){
            $src = $article[0]['thumbnail'];
        }
      ?>
      <?php list($width, $height) = getimagesize(base_url($src));?>
      <div style="background-image:url('<?php echo base_url($src); ?>');width: <?php echo $width."px";?>;height: <?php echo $height."px";?>; margin: 0px auto;" class="banner image-banner text-center">
            <?php if($src == ''): ?>
                <img class="image-default" style="height:200px;margin-top: 80px;" src="<?php echo skin_url(); ?>/images/image-upload1.png">
            <?php endif; ?>
      </div>
      <div class="impromation-project" style="display:block;">
          <?php if ($user_id == $article[0]['member_id']) : ?>
            <div class="dropdown-impromation relative">
              <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>
              <ul class="dropdown-impromation-menu">
                  <li><a href="<?php echo base_url('article/edit/' . $article[0]['id']); ?>" class="not-report">Edit Article</a></li>
                  <li><a href="<?php echo base_url('article/delete/' . $article[0]['id']); ?>" class="not-report" onclick="javascript:return confirm('Do you want to delete this item?');">Delete Article</a></li>
              </ul>
            </div>
          <?php endif; ?>
         <div class="container relative title-blog">
             <div class="row">
                 <div class="col-sm-12">
                     <h1 class="h2" style="color: #fff;"><?php echo @$article[0]['title']; ?></h1>
                 </div>
             </div>
         </div>
      </div>
   </div>
</section>
<section class="section box-wapper-show-image">
    <div class="container">
         <div class="row">
            <div class="col-sm-6">
              <div class="panel panel-default relative">
                <div class="row">
                  <div class="col-sm-2 col-xs-4 avatar-slider">
                    <?php 
                      $avatar = skin_url().'/images/avatar-full.png';
                      if(isset($user_info['avatar']) && $user_info['avatar']!=null && file_exists('.'.$user_info['avatar'])) {
                        $avatar = $user_info['avatar'];
                      }
                    ?>
                    <a href="<?php echo base_url().'profile/view/'.@$article[0]['member_id']; ?>"><img width="80" style="display:inline-block;" class="circle" src="<?php echo $avatar; ?>"></a>
                  </div>
                  <div class="col-sm-10 col-xs-8">
                    <p><strong><a href="<?php echo base_url().'profile/view/'.@$article[0]['member_id']; ?>"><?php echo @$user_info['full_name']; ?></a> | <?php echo @$user_info['company_name']; ?></strong></p>
                    <p><?php echo @$user_info['job_title']; ?></p>
                    <p><?php echo date('F d, Y', strtotime($article[0]['date_create'])); ?></p>
                  </div>
                </div>
              </div><!-- end panel -->
            </div>
            <div class="col-sm-6">
                <div class="panel panel-default relative social-profile card" data-id="<?php echo @$article[0]['id'];?>" data-type="blog">
                  <div class="row">
                  	<div class="custom-column-article commen-like">
	                    <div class="col-xs-2 text-center like-blog remove-padding">
	                      <a href="javascript:;" class="text-view-article view-all-member-like " id="view-likes"><span id="number-like"><?php echo isset($tracking['qty_like']) && $tracking['qty_like'] != "" && $tracking['qty_like'] != 0 ? $tracking['qty_like']." Likes" : ''; ?></span></a><hr>
	                      <h3 id="like-photo" data-object="blog" data-id="<?php echo @$article[0]['id'];  ?>" style="color:#7f7f7f;">
	                        <i class="fa fa-heart <?php echo ($tracking['qty_like'] > 0) ? "red-color" : ""; ?> <?php echo isset($like['status']) && $like['status'] == 1 ? 'like' : ''; ?>"></i>
	                      </h3>
	                    </div>
	                    <div class="col-xs-2 text-center remove-padding">
	                      <a class="text-view-article"><?php echo isset($tracking['qty_view']) && $tracking['qty_view'] != "" && $tracking['qty_view'] != 0 ? $tracking['qty_view']. " Views" : ''; ?></a>
	                      <hr>
	                      <h3><img style="margin-top: -10px;" src="<?php echo skin_url(); ?>/images/view-icon.png"></h3>
	                    </div>
	                    <div class="col-xs-2 text-center remove-padding">
	                      <a class="text-view-article">Share</a>
	                      <hr>
	                      <a href="#" data-toggle="modal" data-target="#share-blog-modal"><h3><i class="fa fa-share-alt"></i></h3></a>
	                    </div>
	                    <div class="col-xs-2 text-center remove-padding">
	                      <a href="#">&nbsp;&nbsp;</a>
	                      <hr>
	                      <a href="<?php echo base_url().'profile/view/'.@$article[0]['member_id']; ?>"><h3><i class="fa fa-microsite"></i></h3></a>
	                    </div>
	                    <div class="col-xs-2 remove-padding">
	                      <a class="text-view-article"><span id="num-comment"><?php echo isset($tracking['qty_comment']) && $tracking['qty_comment'] != "" && $tracking['qty_comment'] != 0  ? $tracking['qty_comment'] . " Comments" : ''; ?></span></a>
	                      <hr>
	                      <div class="comment text-center" data-id="Company-1312-1806-1273385">
                          <h3 id="comment-show"><span class="glyphicon glyphicon-comment" aria-hidden="true" title="Click here to comment."></span></h3>
                        </div>
	                    </div>
	                </div>
                  </div>
                </div><!-- end panel -->
            </div>
         </div>

         <div class="panel panel-default relative content">
            <h2><?php echo @$article[0]['sub_title']; ?></h2>
            <div class="article-content">
                <?php echo @$article[0]['content']; ?>
            </div>
         </div><!-- end panel -->
          <?php if(isset($newpost_keyword)): $list_hrf = [];?>
          <?php foreach ($newpost_keyword AS $value){
            $list_hrf[] = '<a href="'.base_url("search?keyword=".$value).'">'.$value.'</a>';
          }?>
          <div class="panel panel-default relative">
            <p><strong>Article Tags</strong></p>
              <p><?php echo implode(", ",$list_hrf); ?></p>
            <?php endif;?>
          </div><!-- end panel -->
          
         <div class="panel panel-default relative">
            <p class="h2" style="margin-top:0;"><strong>Other Articles</strong></p>
            <?php if (isset($article) && count($article) > 0): ?>
                      <div class="bx-slider-edit">
                            <div class="slider-top">
                          <ul class="bxsliders_edit">
                              <?php $page_slider = ""?>
                              <?php $i_page = 0;?>
                                  <?php foreach ($article as $key => $value): ?>
                                      <li data-id ="<?php echo $value["id"];?>">
                                          <div class="row">
                                          <div class="col-sm-6 slider-left"><img src="<?php echo @base_url($value['thumbnail']); ?>" alt="<?php echo @$value['title'] ?>"></div>
                                          <div class="col-sm-6 slider-right">
                                            <p class="text-right"><?php echo date(DW_FORMAT_DATE,strtotime($value['date_create'])); ?></p>
                                                <h3 class="text-center" style="margin-bottom:10px;"><strong><?php echo $value['title']; ?></strong></h3>
                                                <div class="row" style="margin-bottom:10px;">
                                                    <div class="col-sm-2 col-xs-4 avatar-slider text-center remove-padding">
                                                        <?php 
                                                            $avatar = skin_url().'/images/avatar-full.png';
                                                            if(isset($value['avatar']) && $value['avatar'] != null && file_exists('.'.$value['avatar'])) {
                                                                $avatar = $value['avatar'];
                                                            }
                                                        ?>
                                                        <a href="<?php echo base_url().'profile/view/'.@$value['member_id']; ?>"><img width="60" style="display:inline-block;" class="circle" src="<?php echo $avatar; ?>"></a>
                                                    </div>
                                                    <div class="col-sm-10 col-xs-8 profile-slider">
                                                    <?php $full_name = @$value['first_name'] . " ". @$value['last_name'];
                                                            $user_info_bar = $full_name ;
                                                            if($value['company_name'] != ""){
                                                                $user_info_bar.= " | ".$value['company_name'];
                                                            }
                                                        ?>
                                                        <p><strong><a href="<?php echo base_url().'profile/view/'.@$value['member_id']; ?>"><?php echo $user_info_bar; ?></a></strong></p>
                                                        <p><?php echo @$value['job_title']; ?></p>
                                                    </div>
                                                </div>
                                                <p><?php echo substr(strip_tags($value['content']), 0, 450); ?> <a href="<?php echo base_url(); ?>article/post/<?php echo $value['id']; ?>">MORE</a></p>
                                          </div>
                                        </div>
                                      </li>
                                    <?php $page_slider.= '<li><a data-slide-index="'.$i_page.'" href="#"><img src="'.@base_url($value['thumbnail']).'"></a></li>'; ?>
                                            <?php $i_page++; ?>
                                  <?php endforeach; ?>
                              </ul>
                            </div>
                          <div class="slider-bottom">
                                <ul id="bx-pager-edit">
                                 <?php echo $page_slider;?>
                                </ul>
              </div>

                        </div>
                        <div class="row">
                            <div class="col-sm-12  text-right edit-profile" style="display: block;">
                                <div class="space-20"></div>
                                <!--<a href="<?php echo base_url('article/edit/' . $article[0]['id']); ?>" class="btn btn-primary">Click to Edit</a>-->
                            </div>
                        </div>
                    <?php endif; ?>
         </div><!-- end panel -->
    </div>
</section>
<div class="modal fade" id="share-blog-modal" tabindex="-1" role="dialog" aria-labelledby="modal-label" style="display: none;">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content" style="padding: 20px;border-radius: 0;">
            <button style="position: relative;top: -5px;" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h1 class="h2"><?php echo @$article[0]['title']; ?></h1>
            <div class="row" style="margin-bottom:10px;">
                <div class="col-sm-2 col-xs-4 avatar-slider">
                  <?php 
                        $avatar = skin_url().'/images/avatar-full.png';
                        if(isset($user_info['avatar']) && $user_info['avatar']!=null && file_exists('.'.$user_info['avatar'])) {
                            $avatar = base_url($user_info['avatar']);
                        }
                    ?>
                    <img width="60" style="display:inline-block;" class="circle" src="<?php echo $avatar; ?>">
                </div>
                <div class="col-sm-10 col-xs-8 profile-slider">
                    <p style="margin-bottom:0;"><strong><?php echo @$user_info['full_name']; ?> | <?php echo @$user_info['company_name']; ?></strong></p>
                    <p><?php echo @$user_info['job_title']; ?></p>
                </div>
            </div>
            <p class="text-center"><img id="photo-share" src="<?php echo base_url($src); ?>"></p>
            <p class="text-center text-share-tip" style="margin-top: 20px;">Great article! Your article will appear in multiple targeted searches based on your keywords. Share your article socially and help drive more traffic to your personal or company blogs.</p>
            <p class="text-center">
                <a href="#" onclick="share(); return false;"><img width="42" src="<?php echo skin_url(); ?>/images/facebook.png"></a>
                <a href="#" id="container" onclick="share_tw(); return false;"><img width="42" src="<?php echo skin_url(); ?>/images/twitter.png"></a>
                <a href="#" class="poup-share-in"><img width="42" src="<?php echo skin_url(); ?>/images/in.png"></a>
                <?php /* <a href="#" class='st_instagram_large' displayText='Instagram Badge'></a> */ ?>
                <a href="#" id="share-image-email" data-type="article"><img width="42" src="<?php echo skin_url(); ?>/images/email1.png"></a> 
            </p>
            <p class="text-center" style="font-size:12px;">Having trouble copying your articles URL? Simply copy and paste the link below:</p>
          <p class="text-center" style="font-size:12px;"><a style="color: #ffa126;" href="#"><?php echo base_url(); ?>article/post/<?php echo @$article[0]['id']; ?></a></p>
        </div>
    </div>
</div>
<script>
    var w = 600;
    var h = 400;
    var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
    var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;
    var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
    var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;
    var left = ((width / 2) - (w / 2)) + dualScreenLeft;
    var top = ((height / 2) - (h / 2)) + dualScreenTop;
    var description = $("head meta[name = description]").attr("content");
    var url = window.location.href;
    var img = $("#photo-share").attr("src");
    var title = $("head title").text();
    var type_post = "<?php echo @$type_post;?>";
    var id_post = "<?php echo @$id_post;?>";
    var url_share_social = "<?php echo base_url("article/post/".$id_post);?>";

    function share() {
       tracking_share("facebook",type_post,id_post);
      window.open('https://www.facebook.com/sharer/sharer.php?u=' + url_share_social,'_blank','width=' + w + ', height=' + h + ', top=' + 150 + ', left=' + left)
    }
    function share_tw() {
      tracking_share("twitter",type_post,id_post);
      var title_page = "<?php echo @$article[0]['title'] . " - " . @$article[0]['sub_title']; ?>";
        window.open("https://twitter.com/share?url=" + url_share_social + "&text="+title_page+": ", '_blank','width=' + w + ', height=' + h + ', top=' + 150 + ', left=' + left);
    }
    $(".poup-share-in").click(function () {
        tracking_share("linkedin",type_post,id_post);
        window.open("https://www.linkedin.com/shareArticle?mini=true&url=" + url_share_social, '_blank','width=' + w + ', height=' + h + ', top=' + 150 + ', left=' + left);
        return false;
    });
    $(document).on("click","#sendmail",function(){
      tracking_share("email",type_post,id_post);
    });
</script>
<script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="https://ws.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "cdb00310-a660-4dd1-ac4b-4e962d9f3397", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
<style>
    .st_instagram_large .stLarge{
        background-image: url('<?php echo skin_url("images/im.png"); ?>') !important;
        width: 42px;
        height: 42px;
        background-size: contain;
        background-position: 0 0 !important;
        opacity: 1 !important;
        top:17px;
    }
     .st_instagram_large .stLarge:hover{background-image: url('<?php echo skin_url("images/im.png"); ?>') !important;}
</style> 
<link rel="stylesheet" type="text/css" href="<?php echo skin_url(); ?>/css/blog.css">
<script type="text/javascript">
    var member_owner_id = '<?php echo @$user_info["member_id"]; ?>';
    var total_comment = <?php echo isset($count_comment) && $count_comment!=null ? $count_comment : '0' ; ?>;
    var mySider = $('.bxsliders_edit').bxSlider({
    pagerCustom: '#bx-pager-edit',
        auto:true,
        pause:4000,
        autoStart:true,
        onSlideBefore:function($slideElement, oldIndex, newIndex){
            var id = $slideElement.attr("data-id");
            $("#goto-edit-post").attr("href",base_url+"article/edit/"+id);      
        },
        onSlideAfter:function($slideElement, oldIndex, newIndex){
            var id = $slideElement.attr("data-id");
            $("#goto-edit-post").attr("href",base_url+"article/edit/"+id); 
        },
        onSlideNext:function($slideElement, oldIndex, newIndex){
            var id = $slideElement.attr("data-id");
            $("#goto-edit-post").attr("href",base_url+"article/edit/"+id);          
        },
        onSlidePrev:function($slideElement, oldIndex, newIndex){
            var id = $slideElement.attr("data-id");
            $("#goto-edit-post").attr("href",base_url+"article/edit/"+id);
        }
    });
    var box_width = $(".bx-slider-edit").width();
    var number_slider = 10;
    if(box_width < 768){
        number_slider = 5;
    }
    if(box_width < 460){
        number_slider  = 3;
    }
    var width_img = box_width / number_slider;
    $("#bx-pager-edit").bxSlider({
        minSlides:number_slider,
        maxSlides:number_slider,
        slideWidth: width_img,
        pager:false
    });
</script>
<script src="<?php echo skin_url(); ?>/js/blog.js"></script>
<?php if(isset($_GET["show_comment"])):?>
<script type="text/javascript">
  $(document).ready(function () {
      $('html,body').animate({
          scrollTop: ($("#list-table-comment").offset().top - 83)},
      'slow');
  });
</script>
<?php endif;?>
<style type="text/css">
    .bx-slider-edit{background-color: #7f7f7f; padding: 10px 10px 10px 0px;}
    .bx-slider-edit .slider-top .bx-wrapper .bx-viewport{
      margin: 0;
      margin-left: 10px;
    }

  #bx-pager-edit .slider-top a img {
    padding: 3px;
    border: solid #ccc 1px;
    width: 100px;
    height: 100px;
    display: inline-block;

  }

  #bx-pager-edit .slider-top a:hover img,
  #bx-pager-edit .slider-top a.active img {
    border: solid #5280DD 1px;
  }
  body #bx-pager-edit a{margin: 0;}
  .custom-column-article .col-xs-2{width: 20%; text-align: center;}
  .text-view-article {min-height: 23px; display: block;}
</style>