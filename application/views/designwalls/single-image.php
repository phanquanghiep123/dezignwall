<?php if (isset($photo)): ?>
    <link href="<?php echo skin_url(); ?>/css/upload.css" rel="stylesheet">
    <div class="container box-public box-lg box-bg-gray">
        <div id="wrapper-impormant-image" data-id ="<?php echo $product_id; ?>">
            <div class="relative box-warpper-images">
                <div class="wrapper-image">
                    <div class="item relative wrap-cropper">
                        <?php
                        $size_new = @getimagesize('.' . @$photo['path_file']);
                        ?>
                        <img class="photo-detail" data-w="<?php echo @$size_new[0]; ?>" data-h="<?php echo @$size_new[1]; ?>" src="<?php echo base_url($photo['path_file']); ?>">
                    </div>
                </div>
                <div class="impromation-project">
                    <div class="dropdown-impromation relative">
                        <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>
                        <ul class="dropdown-impromation-menu">
                            <li><a href="#" class="not-report" id="share-social" data-title ="<?php echo $photo["name"]; ?>" data-type ="image" data-id ="<?php echo $photo["photo_id"]; ?>">Share Image</a></li>
                            <li><a href="#" class="not-report" id="report-image" data-title ="<?php echo $photo["name"]; ?>" data-type ="image" data-id ="<?php echo $photo["photo_id"]; ?>">Report Image</a></li>
                        </ul>
                    </div>
                    <?php $record_type = 1; ?>
                    <?php if ($record_type != 0): ?>
                        <?php $logo = ( $user["logo"] != "" && file_exists(FCPATH . "/" . $user["logo"]) ) ? base_url($user["logo"]) : skin_url("images/logo-company.png"); ?>
                        <div class="logo-company"><img src="<?php echo $logo; ?>"></div>
                        <div class="impromation">
                            <h5><strong><?php echo $user["company_name"] ?></strong></h5>
                            <h1 class="photo-name"><?php echo $photo["name"]; ?></h1>
                            <p>Photo by: <?php echo $user["business_type"]; ?></p>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if (!isset($view_product)) : ?>
                <div class="commen-like">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="row">

                                <?php
                                $images_like = "";
                                $title_like = "Click here to like.";
                                if (count($user_total_like) == 0) {
                                    $images_like = "";
                                } else {
                                    if ($user_total_like["status"] != 0) {

                                        $images_like = " like";
                                        $title_like = "Click here to unlike.";
                                    }
                                }
                                ?>
                                <div class="col-xs-3 remove-padding text-center"><div class="likes"><p><span id="number-like"><?php echo count(@$like); ?></span> Like(s)</p><h3  id="like-photo" data-object="product" data-id ="<?php echo $product_id; ?>"><i class="fa fa-heart<?php echo $images_like; ?>" title="<?php echo $title_like; ?>"></i></h3></div></div>
                                <div class="col-xs-2 remove-padding text-center">
                                    <div class="microsite">
                                        <p style="height:15px"></p>
                                        <a id="goto-microsite" title="Go to microsite." href="<?php echo base_url("profile/index/" . $user["id"]); ?>"><h3><i class="fa fa-microsite"></i></h3></a>
                                    </div>
                                </div>
                                <?php if ($photo['type'] == 2) : ?>
                                    <div class="col-xs-2 remove-padding text-center"><p><span id="num-pin"><?php echo $record_pin; ?></span> Pins</p><h3 id="pins-to" title="Click here to Save to DEZIGNWALL."><i class="fa fa-thumb-tack"></i></p></div>
                                    <div class="col-xs-2 remove-padding text-center"><p style="height:15px"></p><p><h3 id="share-social" title="Click here to share image." data-title ="<?php echo $photo["name"]; ?>" data-type ="image" data-id ="<?php echo $photo["photo_id"]; ?>"><i class="fa fa-share-alt"></i></h3></p></div>
                                    <div class="col-xs-3 remove-padding text-center"><p style="height:15px"></p><h3 id="share-image-email" title="Click here to share image."><i class="fa fa-envelope"></i></h3></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-4 remove-padding sm-padding text-sm-center">
                            <p class="text-sm-left"><span id="num-comment"><?php echo @$comment; ?></span> Comment(s)</p>
                            <div class="comment">
                                <h3 id="view-all-comment"><span class="glyphicon glyphicon-comment" aria-hidden="true" title="Click here to comment."></span></i>
                                <input type="text" name="comment" id="comment-input" data-object="product" class="left form-control" placeholder="Comment"></h3>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="list-img-related">
                                <ul class="list-inline">
                                    <?php if ($record_involve != null) { ?>
                                        <?php foreach ($record_involve as $key => $value) { ?>
                                            <?php if ($key < 3) { ?>
                                                <?php $thumb = ($value["thumb"] != "" && file_exists(FCPATH . $value['thumb']) ) ? base_url($value["thumb"]) : base_url($value["path_file"]); ?> 
                                                <li><a href="<?php echo base_url("photos/" . $value["photo_id"] . "/" . gen_slug($value["name"])); ?>" data-id = "<?php echo $value['photo_id'] ?>"><img src="<?php echo $thumb; ?>"></a></li>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <div class="img-description">
                <h2 class="content-description"><strong>Description: </strong><?php echo $photo["description"]; ?></h2>
            </div>
            <div class="keywords ">
                <?php
                $text_keyword = "";
                if (isset($keyword) && is_array($keyword)) {
                    foreach ($keyword as $key => $value) {
                        if ($value["title"] != "") {
                            $text_keyword.="<a href='" . base_url("search?keyword=" . $value["title"]) . "'>" . $value["title"] . "</a>, ";
                        }
                    }
                    $text_keyword = substr($text_keyword, 0, -2);
                }
                ?>
                <p>
                    <strong>Keywords:</strong>
                    <?php echo $text_keyword; ?>
                </p>
            </div>
            <!-- Section for comment -->
            <div class="commen-like" id="search-home-show">
                <div class="conment-show <?php echo ($comment > 0) ? "block" : ""; ?>">
                    <div class="col-xs-12">
                        <div class="uesr-box-impromation" id="scrollbars-dw">
                            <div class="avatar">
                                <table id="list-table-comment" data-id="<?php echo $photo["photo_id"]; ?>">
                                    <thead>
                                        <tr>
                                            <td class="left-td">&nbsp;</td>
                                            <td class="right-td">
                                                <div class="likes-header-box"><p><span id="number-like"><?php echo count(@$like); ?></span> Like(s)</p></div>
                                                <div class="comments-header-box"><p><span id="num-comment"><?php echo @$comment; ?></span> Comment(s)</p></div>
                                            </td>
                                            <td class="right-extra-td" align="right">
                                                <?php if ($comment > 3) : ?>
                                                    <p class="view-more-comment" id="view-more-detail" data-type="photo"><span class="glyphicon glyphicon-comment" aria-hidden="true"></span> View older comments…</p>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($comment > 0) {
                                            $value_comment = $record_comment;
                                            $total_comment = count($record_comment);
                                            for ($i = $total_comment; $i > 0; $i--) {
                                                $logo_user = ( $value_comment[($i - 1)]['avatar'] != "" && file_exists(FCPATH . $value_comment[($i - 1)]['avatar']) ) ? base_url($value_comment[($i - 1)]['avatar']) : base_url("skins/images/signup.png");
                                                ?>
                                                <tr class="comment-items single-page-comment offset_default">
                                                    <td class="left-td"><img src="<?php echo $logo_user; ?>" class="left"></td>
                                                    <td class="right-td" colspan="2">
                                                        <?php
                                                        $company_name = "";
                                                        if ($value_comment[($i - 1)]['company_name'] != null && $value_comment[($i - 1)]['company_name'] != "") {
                                                            $company_name = " | " . $value_comment[($i - 1)]['company_name'];
                                                        }
                                                        ?>
                                                        <p><a href="<?php echo base_url("profile/index/" . $value_comment[($i - 1)]["member_id"]); ?>"><strong><?php echo $value_comment[($i - 1)]['first_name'] . " " . $value_comment[($i - 1)]['last_name']; ?><?php echo $company_name; ?> | <?php echo $value_comment[($i - 1)]['created_at']; ?></strong></a></p>
                                                        <div>
                                                            <p class="text-comment" data-id="<?php echo @$value_comment[($i - 1)]['id']; ?>">
                                                                <?php
                                                                if (strlen($value_comment[($i - 1)]['comment']) <= 210) {
                                                                    echo "<span>" . $value_comment[($i - 1)]['comment'] . "</span>";
                                                                } else {
                                                                    echo "<span class='comment-item-text default-show block'>" . substr($value_comment[($i - 1)]['comment'], 0, 200) . "<span class='more' id='more-comment'> MORE...</span></span>";
                                                                    echo "<span class='comment-item-text default-hide'>" . $value_comment[($i - 1)]['comment'] . "<span class='more' id='more-comment'> LESS</span></span>";
                                                                }
                                                                ?>
                                                            </p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view("include/share"); ?>
    <?php $this->load->view("include/report-images"); ?>
    <?php $this->load->view("include/pin-to-wall"); ?>
    <?php $this->load->view("include/view-comment"); ?>
    <script type="text/javascript">

        $(document).ready(function () {
            var height_header = $("#header").height();
            var height_footer = $("#footer").height();
            var height_bar = $(".commen-like").height();
            var height_screen = $(window).height();
            var max_height = (height_screen+height_bar) - ((height_header * 2) + (height_footer * 2));
            var box_img = (height_screen + height_bar) - ((height_header * 2) + (height_footer * 2));
            $(".image-page .wrapper-image").css("height", box_img + "px");
            $(".box-warpper-images").css("height", box_img + "px");
            $('.wrap-cropper').css("height", max_height + "px");
            $(document).on({
                mouseenter: function () {
                    $(this).css('z-index', 1000);
                },
                mouseleave: function () {
                    $(this).css('z-index', 100);
                }
            }, '#point');

            $(document).on('click', '#point .newImageTagIcon', function () {
                $(this).parents('#point').addClass('show');
                $(this).parents('#point').find('.box-point-view').addClass('show');
                return false;
            });

            $(document).on('click', '#point .close-box', function () {
                $(this).parents('#point').removeClass('show');
                $(this).parents('.box-point-view').removeClass('show');
                return false;
            });
        });
        $(window).load(function () {
            var wrap_w = $('.wrap-cropper').width();
            var wrap_h = $('.wrap-cropper').height();
            var image_w_d = parseInt($(".wrap-cropper .photo-detail").attr('data-w'));
            var image_h_d = parseInt($(".wrap-cropper .photo-detail").attr('data-h'));
            var image_w = parseInt($(".wrap-cropper .photo-detail").width());
            var image_h = parseInt($(".wrap-cropper .photo-detail").height());
            var scell_w   = image_w/image_w_d;
            var scell_h   = image_h/image_h_d;
            var center_w = (wrap_w - image_w) / 2;
            var center_h = (wrap_h - image_h) / 2;
            var tag = $.parseJSON('<?php echo json_encode(@$point); ?>');
            //var ratio_w=parseFloat($(".wrap-cropper").width()/image_w);
            //var ratio_h=parseFloat($(".wrap-cropper").height()/image_h);
            if (tag.length > 0) {
                var point = '';
                for (var i = 0; i < tag.length; i++) {
                    var html = '<div class="box-point-view">';
                    html += '    <span class="close-box"><i class="fa fa-times"></i></span>';
                    html += '    <div class="row">';
                    html += '		 <div class="col-sm-7 sm-remove-padding-right">';
                    html += '		   <p class="text-left">Product available in:</p>';
                    html += '      </div>';
                    html += '		 <div class="col-sm-5 sm-remove-padding-left">';
                    html += '		   <p class="text-left">' + tag[i]['product_in'] + '</p>';
                    html += '      </div>';
                    html += '    </div>';
                    if (tag[i]['one_off'] != 0 && tag[i]['max_qty'] != 0) {
                        html += '    <div class="row">';
                        html += '		 <div class="col-sm-7 sm-remove-padding-right">';
                        html += '		   <p class="text-left">One-off pricing:</p>';
                        html += '      </div>';
                        html += '		 <div class="col-sm-5 sm-remove-padding-left">';
                        html += '		   <p class="text-left">$' + tag[i]['one_off'] + '</p>';
                        html += '      </div>';
                        html += '    </div>';

                        html += '    <div class="row">';
                        html += '		 <div class="col-sm-7 sm-remove-padding-right">';
                        html += '		   <p class="text-left">Maximum Sample Qty:</p>';
                        html += '      </div>';
                        html += '		 <div class="col-sm-5 sm-remove-padding-left">';
                        html += '		   <p class="text-left">' + tag[i]['max_qty'] + '</p>';
                        html += '      </div>';
                        html += '    </div>';
                    } else {
                        html += '<p>Sample pricing does not apply</p>';
                    }
                    html += '      <p class="text-right" style="margin-right:20px;"><a style="border-radius: 6px;" href="<?php echo base_url(); ?>profile/request_quote/<?php echo @$photo["photo_id"] ?>/' + tag[i]['id'] + '" class="btn btn-custom btn-primary">Request a quote</a></p>';
                    html += '   </div>';
                    point += '<div id="point" data-on="on" data-rol="tag-' + i + '" class="point-' + i + ' ui-draggable ui-draggable-handle" style="top: ' + (parseFloat(tag[i]['top'] * scell_w) + center_h) + 'px; left: ' + (parseFloat(tag[i]['left'] * scell_h) + center_w) + 'px;">' + html + '<a><span id="lbImageTags"><i class="newImageTagIcon animate"></i></span></a></div>';
                }
                $('.wrap-cropper').append(point);
            }
        });
    </script>
<?php endif; ?>
<?php if (isset($_GET["show_comment"])): ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $('html,body').animate({
        scrollTop: $("#list-table-comment").offset().top},
        'slow');
        });
    </script>
<?php endif; ?>
<style>
.uesr-box-impromation {height:auto;}
</style>
