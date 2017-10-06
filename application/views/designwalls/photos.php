<?php
$user_info = $this->session->userdata('user_info');
$allow_edit = (isset($member) && isset($user_info) && $user_info['id'] == $member['id'] && !$this->session->userdata('user_sr_info')) ? true : false;
$data = null;
if ($allow_edit) {
    $data['menu_banner'] = array(
        array('href' => '#', 'title' => 'Edit background', 'class' => 'edit_background'),
        array('href' => '#', 'title' => 'Hide background', 'class' => 'show_hide_background'),
        array('href' => '#', 'title' => 'Invite team members', 'class' => 'invite_member'),
        array('href' => '#', 'title' => 'Delete your Wall', 'class' => 'delete_wall'),
        array('href' => base_url('/profile/upgrade/'), 'title' => 'Upgrade Account', 'class' => '')
    );
} else {
    $data['menu_banner'] = array(
        array('href' => '#', 'title' => 'Hide background', 'class' => 'show_hide_background'),
        array('href' => '#', 'title' => 'Invite team members', 'class' => 'invite_member')
    );
}
$this->load->view("include/banner.php", $data);
?>
<section id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <ol class="breadcrumb" style="padding-bottom: 0;margin-bottom: 0;margin-top:10px;">
                    <li><a href="<?php echo base_url(); ?>designwalls/index/<?php echo $project_id; ?>/"><?php echo $title_project; ?></a></li>
                    <li><?php echo $cat_name; ?></li>
                </ol>
                <br />
            </div>
        </div>
        <div class="row">
            <div class="gird-img col-md-12">
                <div class="cards">
                    <?php
                    $i = 0;
                    $count_photo = count($results);
                    $index = count($results);
                    if ($count_photo < 5) {
                        $count_photo = 3;
                    }
                    $max_items_set = ceil($count_photo / 3);
                    $user_id = -1;
                    if ($this->session->userdata('user_info')) {
                        $user_info = $this->session->userdata('user_info');
                        $user_id = $user_info["id"];
                    }
                    $colum = 1;
                    $items = 0;
                    $max_items = $max_items_set;
                    foreach ($results as $photo) : $comments = $photo['photo_comment'];
                        if ($max_items % $max_items_set == 0) {
                            if (($count_photo == 3 && $colum > 3)) {
                                
                            } else {
                                echo "<div class='col-md-4 grid-column' id='grid-column-" . $colum . "'>";
                            }
                            $colum++;
                            $items = 0;
                        }
                        $max_items++;
                        $items++;
                        ?>
                        <div class="card" data-id="<?php echo @$photo['product_id']; ?>" data-type="product" style="z-index:<?php echo $index; ?>">
                            <div class="card-wrapper" id="wrapper-impormant-image" data-id="<?php echo @$photo['product_id']; ?>">
                                <div class="card-image relative">
                                    <a name= "product-<?php echo $photo['product_id'];?>"href ="<?php echo base_url("designwalls/view_photos/" . $photo['product_id']); ?>"><img class="photo-details" src = "<?php echo base_url(@$photo['path_file']); ?>"/></a>
                                    <?php if($user_info != null && !$this->session->userdata('user_sr_info')):?>
                                        <div class="impromation-project" style="background:none;">
                                            <div class="impromation-project-dropdown">
                                                <div class="dropdown-impromation relative">
                                                    <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>
                                                    <ul class="dropdown-impromation-menu" id="deziwall">
                                                        <li><a href="<?php echo base_url(); ?>profile/addphotos/<?php echo $project_id; ?>/<?php echo $category_id; ?>/">Upload photo</a></li>
                                                        <?php if ($photo['type'] == 4 && $view_member_id == $photo['member_id']) : // Photo type = 4. DEZIGN WALL ?>
                                                            <li><a href="<?php echo base_url(); ?>profile/editphoto/<?php echo $photo['photo_id']; ?>/<?php echo $category_id; ?>/<?php echo $project_id; ?>/" class="edit-photo">Edit photo</a></li>
                                                        <?php else : ?>
                                                            <li><a href="#"  data-category="<?php echo @$category_id; ?>"  data-id="<?php echo @$photo['photo_id']; ?>" class="edit-product">Edit Photo</a></li>
                                                        <?php endif; ?>
                                                        <li><a href="<?php echo base_url(); ?>designwalls/delete_photo/<?php echo $project_id; ?>/<?php echo $category_id; ?>/<?php echo $photo['photo_id']; ?>/" class="delete-photo" onclick="deletepoppup(this.href);return false;">Delete photo</a></li>
                                                        <!--<li><a href="#" data-toggle="modal" data-id="<?php echo $photo['photo_id']; ?>" data-title="<?php echo $photo['name']; ?>" data-path-file="<?php echo $photo["path_file"]; ?>" data-target="#send_mail_dialog" class="send-photo" title="Sent email...">Send Email</a></li>-->
                                                        <li><a href="<?php echo base_url(); ?>payment/upgrade">Upgrade Account</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                     <?php endif;?>
                                </div>
                                <div class="commen-like" id="search-home-show">
                                    <?php if (trim($photo['description']) != ""): ?>
                                        <div class="description">
                                            <div class="col-xs-12">
                                                <p class="text-comment"> 
                                                    <?php
                                                    if (strlen($photo['description']) <= 80) {
                                                        echo "<span>" . $photo['description'] . "</span>";
                                                    } else {
                                                        echo "<span class='comment-item-text default-show block'>" . trim(substr($photo['description'], 0, 80)) . "<span class='more' id='more-comment'> MORE...</span></span>";
                                                        echo "<span class='comment-item-text default-hie'>" . $photo['description'] . "<span class='more' id='more-comment'> LESS</span></span>";
                                                    }
                                                    ?>
                                                </p>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php
                                    $images_like = '';
                                    $title_like = "Click here to like.";
                                    if (isset($photo['status']) && $photo['status'] == 1) {
                                        $images_like = "like";
                                        $title_like = "Click here to unlike.";
                                    }
                                    ?>
                                    <div class="box-top">
                                        <div class="col-xs-3 col-md-2 text-center"><div class="likes"><p><span id="number-like"><?php echo ($photo["qty_like"] != "") ? $photo["qty_like"] : "0"; ?></span> Likes</p></div></div>
                                        <div class="col-xs-2 col-md-2 text-center remove-l-padding"></div>
                                        <div class="col-xs-7 col-md-8 remove-l-padding"><p><span id="num-comment"><?php echo ($photo['qty_comment'] != "") ? $photo['qty_comment'] : "0"; ?></span> Comments</p></div>
                                    </div>
                                    <div class="conment-show <?php echo ($photo["qty_comment"] > 0) ? "block" : ""; ?>">
                                        <div class="col-xs-12">
                                            <?php if (isset($photo['qty_comment']) && $photo['qty_comment'] > 3): ?>
                                                <p class="view-more-comment" id="view-more" data-type="product"><span class="glyphicon glyphicon-comment" aria-hidden="true"></span> View older comments…</p>
                                            <?php endif; ?>
                                            <div class="uesr-box-impromation" id="scrollbars-dw">
                                                <div class="avatar">
                                                    <?php if (isset($photo['qty_comment']) && $photo['qty_comment'] > 0) { ?>
                                                        <?php
                                                        $value_comment = $photo['photo_comment'];
                                                        $total_comment = count($photo['photo_comment']);
                                                        for ($i = $total_comment; $i > 0; $i--) {
                                                            $logo_user = ( $value_comment[($i - 1)]['avatar'] != "" && file_exists(FCPATH . $value_comment[($i - 1)]['avatar']) ) ? base_url($value_comment[($i - 1)]['avatar']) : base_url("skins/images/signup.png");
                                                            ?>
                                                            <div class="row comment-items offset_default">
                                                                <div class="col-xs-2 remove-padding"><img src="<?php echo $logo_user; ?>" class="left"></div>
                                                                <div class="col-xs-10 box-impromation">
                                                                    <?php
                                                                    $company_name = "";
                                                                    if ($value_comment[($i - 1)]['company_name'] != null && $value_comment[($i - 1)]['company_name'] != "") {
                                                                        $company_name = " | " . $value_comment[($i - 1)]['company_name'];
                                                                    }
                                                                    ?>
                                                                    <p><a href="<?php echo base_url("profile/index/" . $value_comment[($i - 1)]["member_id"]); ?>"><strong><?php echo $value_comment[($i - 1)]['first_name'] . " " . $value_comment[($i - 1)]['last_name']; ?><?php echo $company_name; ?></strong></a></p>
                                                                    <div>
                                                                        <p class="text-comment" data-id="<?php echo @$value_comment[($i - 1)]['id']; ?>">
                                                                            <?php
                                                                            if (strlen($value_comment[($i - 1)]['comment']) <= 79) {
                                                                                echo "<span>" . $value_comment[($i - 1)]['comment'] . "</span>";
                                                                            } else {
                                                                                echo "<span class='comment-item-text default-show block'>" . substr($value_comment[($i - 1)]['comment'], 0, 71) . "<span class='more' id='more-comment'> MORE...</span></span>";
                                                                                echo "<span class='comment-item-text default-hie'>" . $value_comment[($i - 1)]['comment'] . "<span class='more' id='more-comment'> LESS</span></span>";
                                                                            }
                                                                            ?>
                                                                        </p>
                                                                        <?php if ($user_id == $value_comment[($i - 1)]['member_id']) : ?>
                                                                            <span class="action-comment">
                                                                                <a data-id="<?php echo @$value_comment[($i - 1)]['id']; ?>" class="edit-comment" href="#"><i class="fa fa-pencil"></i></a>
                                                                                <a data-id="<?php echo @$value_comment[($i - 1)]['id']; ?>" class="delete-comment" href="#"><i class="fa fa-times"></i></a>
                                                                            </span>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    <?php } ?>  
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-bottom">
                                        <div class="col-xs-3 col-md-2 text-center"><div class="likes"><h3 id="like-photo" data-object="product" data-id ="<?php echo $photo['product_id']; ?>"><i class="fa fa-heart <?php echo $images_like; ?>" title="<?php echo $title_like; ?>"></i></h3></div></div>
                                        <div class="col-xs-2 col-md-2 text-center remove-l-padding"><div class="microsite">
                                                <h3>
                                                    <a href="<?php echo base_url("profile/index/" . $photo["member_id"]); ?>" title="Go to microsite."><i class="fa fa-microsite"></i> </a>
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="col-xs-7 col-md-8 remove-l-padding">
                                            <div class="comment">
                                                <h3 id="comment-show"><span class="glyphicon glyphicon-comment" aria-hidden="true" title="Click here to comment."></span> <input type="text" name="add-commemt-input" id="add-commemt-input" disabled ></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-info">
                                        <div class="close_box">x</div>
                                        <div class="box-input-comment">
                                            <div class="relative">
                                                <textarea id="content-comment" class="scroll-textarea"></textarea>
                                                <div class="action text-right">
                                                    <button  class="btn btn-gray clear button-singin" id="clear-text">Clear Text</button>
                                                    <button class="sign-in btn btn-primary button-singin" id="add-comment" data-object="product" data-id="<?php echo $photo['product_id']; ?>" data-parent="card-<?php echo $photo['photo_id']; ?>">Post Comment</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        $index --;
                        if ($items == $max_items_set || (($max_items - $max_items_set) == $count_photo) && $items < $max_items_set) {
                            if ($count_photo == 3 && $colum > 3) {
                                
                            } else {
                                echo "</div>";
                            }
                        }
                        ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <?php if (isset($links) && $links != null) : ?>
            <div class="row">
                <div class="col-sm-12">
                    <?php echo $links; ?>
                </div>
            </div>
        <?php endif; ?>
    </div><!--end container-->
</section>

<div id="save-product" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <form method="post" id="save-product-info">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Product Info</h4>
                </div>
                <div class="modal-body relative">
                    <div class="custom-loading"><img width="48" src="<?php echo skin_url(); ?>/images/loading.gif"></div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row form-group">
                                        <div class="col-sm-4 sm-text-right"> 
                                            <label>Product Name: </label> 
                                        </div>
                                        <div class="col-sm-8">
                                            <input type="text" value="" class="form-control product_name" required name="product[product_name]" id="product-name">
                                        </div> 
                                    </div> 
                                    <div class="row form-group">
                                        <div class="col-sm-4 sm-text-right">
                                            <label>Product No: </label> 
                                        </div> 
                                        <div class="col-sm-8"> 
                                            <input type="number" value="" class="form-control product_no" required name="product[product_no]" id="product-no">
                                        </div>
                                    </div>
                                    <div class="row form-group"> 
                                        <div class="col-sm-4 sm-text-right"> 
                                            <label>Price: </label> 
                                        </div>
                                        <div class="col-sm-8">
                                            <input type="number" value="" class="form-control price" name="product[price]" min="1"  step="0.01">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-sm-4 sm-text-right"> 
                                            <label>Qty: </label>
                                        </div>
                                        <div class="col-sm-8">
                                            <input type="number" value="" class="form-control qty" name="product[qty]" id="qty">
                                        </div> 
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-sm-4 sm-text-right">
                                            <label>FOB: </label>
                                        </div>
                                        <div class="col-sm-8">
                                            <input type="text" value="" class="form-control fob" name="product[fob]" id="fob">
                                        </div> 
                                    </div> 
                                    <div class="form-group row">
                                        <div class="col-sm-4 sm-text-right">
                                            <label>Product Notes: </label> 
                                        </div>
                                        <div class="col-sm-8">
                                            <textarea style="max-width:100%;" name="product[product_note]" cols="40" rows="5" class="product-note"></textarea>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="product[category_id]" id="category_id" value="">
                    <input type="hidden" name="product[photo_id]" value="" id="photo-id">
                    <input type="submit" class="btn btn-primary btn-custom" value="Send">
                </div>
            </form>
        </div>
    </div>
</div>

<div id="send_mail_dialog" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Send a Message</h4>
            </div>
            <div class="modal-body">
                <div class="form-group alert-send-mail">
                    <div class="row">
                        <div class="col-sm-12">
                            <h6 class="send-error alert" style="color:red;text-align:center;display:none;">Email has not been sent successfully.</h6>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-3 text-right"><label>To:</label></div>
                        <div class="col-sm-9 "><input class="format-email-inver form-control" type="text" name="email"  id="email" placeholder="Enter recipient emails, separated by commas" required/></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-3 text-right"><label>Subject:</label></div>
                        <div class="col-sm-9 "><input type="text" name="subject" class="form-control" id="subject" required/></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-3 text-right"><label>Message:</label></div>
                        <div class="col-sm-9 "><textarea name="message" id="message" class="form-control" required>Take a look at this great space that I found on Dezignwall, and let me know what you think.</textarea></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" value="" id="photo-id">
                <input type="hidden" value="" id="photo-src">
                <input type="hidden" value="" id="photo-title">
                <input type="submit" class="button radius" id="send-mail" value="Send">
            </div>
        </div>
    </div>
</div>
<style type="text/css">
    @media (min-width: 768px) {
        .sm-text-right{text-align: right;}
    }
</style>
<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('click', '.edit-product', function () {
            var data_id = $(this).attr('data-id');
            var category_id = $(this).attr('data-category');
            $('#save-product #category_id').val(category_id);
            $('#save-product #photo-id').val(data_id);
            $.ajax({
                url: "<?php echo base_url('designwalls/get_info_prouct'); ?>/" + category_id + "/" + data_id,
                type: 'POST',
                dataType: "json",
                data: {},
                success: function (data) {
                    console.log(data);
                    if (data['status'].trim() == "success") {
                        var reponse = data['reponse'];
                        $('#save-product .product_name').val(reponse['product_name']);
                        $('#save-product .product_no').val(reponse['product_no']);
                        $('#save-product .price').val(reponse['price']);
                        $('#save-product .qty').val(reponse['qty']);
                        $('#save-product .fob').val(reponse['fob']);
                        $('#save-product .product-note').val(reponse['product_note']);
                    }
                },
                complete: function () {
                }
            });
            $("#save-product").modal('show');
            return false;
        });

        $('#save-product-info').submit(function () {
            var data = $(this).serialize();
            $(this).find('.custom-loading').show();
            $.ajax({
                url: "<?php echo base_url('designwalls/save_info_prouct'); ?>/",
                type: 'POST',
                dataType: "json",
                data: data,
                success: function (reponse) {
                    console.log(reponse);
                    if (reponse['status'].trim() == "success") {
                        $("#save-product").modal('toggle');
                        messenger_box("Save Product", 'Save successfully.');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    }
                },
                complete: function () {
                    $(this).find('.custom-loading').hide();
                }
            });
            return false;
        });



    });
    /*
     ==========================================================
     BEGIN: COMMENT
     */
    function clean_comment(obj) {
        $(obj).parents('.form-comment').find('textarea').val('');
    }

    function add_comment(obj) {
        var object_id = $(obj).attr('data-id');
        var text = $(obj).parents('.form-comment').find('textarea').val();
        if (text.trim() != '' && text.trim() != null) {
            $(obj).attr('disabled', 'disabled');
            $(obj).parents('.form-comment').find('.load-comment').css('display', 'initial');
            $.ajax({
                url: "<?php echo base_url("/comments/add"); ?>/" + object_id + "/photo",
                type: 'POST',
                dataType: "json",
                data: {
                    "text": text
                },
                success: function (data) {
                    if (data['status'].trim() == "true") {
                        var qty = data['num_comment'];
                        var strqty = (qty < 2) ? 'comment' : 'comments';
                        $(obj).parents('.form-comment').find('.photo-action-all-comment').append('<p style="margin-bottom:0;"><b>' + data['full_name'] + ':</b> <span class="text-comment">' + text + '</span></p>');
                        $(obj).parents('.form-comment').find('.text-tiny').html(qty + ' ' + strqty);
                        $(obj).parents('.form-comment').find('.photo-action-all-comment').animate({scrollTop: $(obj).parents('.form-comment').find('.photo-action-all-comment').prop("scrollHeight")}, 1000);
                    }
                },
                complete: function () {
                    $(obj).removeAttr('disabled');
                    $(obj).parents('.form-comment').find('.load-comment').css('display', 'none');

                }
            });
            $(obj).parents('.form-comment').find('textarea').val('');
        }
    }
    /*
     ==========================================================
     END: COMMENT
     */
</script>