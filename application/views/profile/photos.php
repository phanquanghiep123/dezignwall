<link rel="stylesheet" type="text/css" href="<?php echo skin_url("css/page/profile.css");?>">
<?php
    $this->load->view("include/banner", @$member);
?>
<?php 
$project = $product = $project_and_product = "";
if( isset($all_product) && is_array($all_product) ){
    $i_product = 0;
    foreach ($all_product as $key => $value) {
        $i_product ++;
        if($i_product < 30){
            $product .= "<p><a href='".$current_url."?product=" .$value["id"]."'>".$value["title"]."</a></p>";
        }
    }
    
}
if( isset($random_project) && is_array($random_project) ){
    foreach ($random_project as $key => $value) {
        $echo_name = $value["name"];
        if (strlen($echo_name) > 25) {
          $echo_name =  substr($echo_name, 0, 25)."...";
        } 
        $project .= "<p><a href='".base_url("photos/" . $value['photo_id'] . "/" . gen_slug($value["name"]))."'>".$echo_name."</a></p>";
    }
}
?>
<section class="section box-wapper-show-image my_photo" id="wrapper">
    <div class="container" style="position: relative;min-height:400px;">
        <div class="row"><h1 id="all-img-seach"><?php echo $all_photo;?> results found in <?php echo $in_;?></h1></div>
        <div class="row">
            <div class="gird-img col-md-12" id="my_photo_page">
                <div class="cards row">
                    <?php
                    $i = 0;
                    $count_photo = count($results);
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
                    foreach ($results as $photo):  
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
                        <?php  $this->load->view('seach/seach_result_ajax',  array('photo' => $photo,"myphoto" => true));?>
                        <?php
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
        <div class="company_catalog">
            <div class="icon-catalog">
                <img src="<?php echo skin_url("images/catalog-icon.png");?>"/>
            </div>
            <h3 class="text-center">Company Catalog</h3>
            <div class="row">
                <div class="col-xs-8">
                    <div class="box-seach">
                        <form id="seach-home-photo" method="GET" action="<?php echo base_url('/profile/myphoto/'.@$member_id); ?>" class="relative form-color">
                            <input type="text" class="form-control" value="<?php echo gen_slug_st(@$_GET['keyword_photo']); ?>" name="keyword_photo" value="" placeholder="Search Catalog..." autocomplete="off">
                            <button class="seach-sumit"><img src="<?php echo skin_url(); ?>/images/icon-seach.png"></button>
                        </form>
                    </div>
                </div>
                <div class="col-xs-4 xsl-remove-padding-left">
                    <div class="box-refine">
                        <a href="#" class="refine-search">Refine<br>your search</a>
                    </div>
                </div>
            </div>
            <div class="compamy_catalog_cat">
                <div class="box_scroll_search">
                    <?php if(trim($project) != ""){?>
                        <strong>Projects</strong>
                        <div class="list-projects">
                            <?php echo $project;?>
                        </div>
                        <div style="height:20px;"></div>
                    <?php }?>
                    <?php if(trim($product) != ""){?>
                        <strong>Products</strong>
                        <div class="list-projects">
                            <?php echo $product;?>
                        </div>
                        <div style="height:20px;"></div>
                    <?php }?>
                    <?php if(trim($project_and_product) != "" && false){ ?>
                        <strong>Projects, Product</strong>
                        <div class="list-projects">
                           <?php echo $project_and_product;?>
                        </div>
                        <div style="height:20px;"></div>
                    <?php }?>
                </div>
            </div>
        </div><!--end company catalog -->
        <div class="row">
            <div class="col-sm-12">
                <?php echo $this->pagination->create_links(); ?>
            </div>
        </div>
    </div><!--end container-->
</section>
<?php $this->load->view("include/share");?>
<?php $this->load->view("include/report-images"); ?>
<?php $this->load->view("include/modal_delete_photo"); ?>
<?php $this->load->view("include/modal_choose_photo"); ?>
<?php $this->load->view("include/modal_choose_story"); ?>
<style type="text/css">
	.company_catalog{
		position: fixed;
	    width: 350px;
	    background: #fff;
	    top: 20%;
	    right: -350px;
	    z-index: 100;
	    padding: 20px;
	    border-radius: 4px;
        border-top-left-radius: 0;
        border-bottom-right-radius: 0;
	    box-shadow: 1px 1px 1px 0px;
	    transition: right 0.5s ease-in-out;
	    -webkit-transition: right 0.5s ease-in-out;
	}
	.company_catalog.opens{
		right: -20px;
	}
	.company_catalog .icon-catalog{
		position: absolute;
	    left: -35px;
	    border-radius: 4px;
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
	    padding: 10px;
	    top: 0;
	    background: #fff;
	    cursor: pointer;
	}
    .company_catalog .icon-catalog{max-width: 38px;}
	.company_catalog h3{
		margin-top: 0;
	    color: #37a7a7;
	    font-weight: bold;
	    margin-bottom: 15px;
	}
	.company_catalog .compamy_catalog_cat{
		margin-top: 20px;
        direction: rtl;
	}
    .company_catalog .compamy_catalog_cat{
        margin-top: 20px;
        direction: rtl;
        float: left;
        max-height: 100%;
        padding-left: 15px;
        overflow: auto;
    }
    .company_catalog .compamy_catalog_cat .box_scroll_search{
        direction: ltr;
    }
	.company_catalog .compamy_catalog_cat strong{
		margin-bottom: 5px;
	}
	.company_catalog .compamy_catalog_cat .list-projects p,
	.company_catalog .compamy_catalog_cat .list-product p{
		margin-bottom: 0;
	}
	.company_catalog .box-refine a.refine-search{
		font-size: 14px;
	    color: #212121;
	    text-decoration: underline;
	    width: 100%;
	    float: left;
	    text-align: left;
	    font-family: 'Avenir Next LT Pro Regular';
	}

	@media (max-width: 768px) {
		.company_catalog .seach-sumit{
			width: auto !important;
		}

	}
	@media (max-width: 350px) {
		.company_catalog{
			width: 290px;
			right: -290px;
		}
		.company_catalog .box-seach input[type='text']{
			font-size: 12px;
		}
		.company_catalog .xsl-remove-padding-left{
			padding-left: 0;
		}
	}
</style>
<script type="text/javascript">
    
    var height_ =  $(".company_catalog .compamy_catalog_cat").offset();
	$(document).ready(function(){
		$(".icon-catalog").click(function(){
			$(this).parents('.company_catalog').toggleClass('opens');
            var window_height = $(window).height();
            var window_w = $(window).width();
            console.log($(".company_catalog .compamy_catalog_cat").height());
            if(window_w > 676){
                $(".company_catalog .compamy_catalog_cat").css("height",(window_height - (height_.top + 42))+"px");
            }else{
                $(".company_catalog .compamy_catalog_cat").css("height",(window_height - height_.top)+"px");
            }
		});
	});
    /*
    ==========================================================
    BEGIN: COMMENT
    */
    function action_comment(obj) {
        if (typeof $(obj).attr('comment-id') != 'undefined' && $(obj).attr('comment-id') != null) {
            edit_comment(obj);
        } else if (typeof $(obj).attr('reply-comment-id') != 'undefined' && $(obj).attr('reply-comment-id') != null) {
            reply_comment(obj);
        } else {
            add_comment(obj);
        }
    }
    function get_content_edit(obj) {
        var object_id = $(obj).attr('data-id');
        var text = $(obj).parents('.comment-items').find('.text-comment').text();
        $(obj).parents('.form-comment').find('textarea').val(text);
        $(obj).parents('.form-comment').find('.btn-custom').attr('comment-id', object_id);
        return false;
    }
    function reply(obj) {
        var object_id = $(obj).attr('data-id');
        var text = $(obj).parents('.comment-items').find('.text-comment').text();
        $(obj).parents('.form-comment').find('textarea').focus();
        $(obj).parents('.form-comment').find('.btn-custom').attr('reply-comment-id', object_id);
        return false;
    }
    function reply_comment(obj) {
        $(obj).removeAttr('comment-id');
        var object_id = $(obj).attr('data-id');
        var reply_id = $(obj).attr('reply-comment-id');
        var text = $(obj).parents('.form-comment').find('textarea').val();
        if (text.trim() != '' && text.trim() != null) {
            $(obj).attr('disabled', 'disabled');
            $(obj).parents('.form-comment').find('.load-comment').css('display', 'initial');
            $.ajax({
                url: "<?php echo base_url('/comments/reply'); ?>/" + object_id + "/photo",
                type: 'POST',
                dataType: "json",
                data: {
                    "text": text,
                    "reply_id": reply_id
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

                },
                error: function (data) {
                    console.log(data['responseText']);
                }
            });
            $(obj).parents('.form-comment').find('textarea').val('');
            $(obj).removeAttr('reply-comment-id');
        }
    }
    function delete_comment(obj) {
        if (confirm('Are you sure you want to delete this?')) {
            var object_id = $(obj).attr('data-id');
            $.ajax({
                url: "<?php echo base_url('/comments/delete'); ?>/" + object_id,
                type: 'POST',
                dataType: "json",
                data: {},
                success: function (data) {
                    if (data['status'].trim() == "true") {
                        $(obj).parents('.comment-items').fadeOut('slow', function () {
                            $(this).remove();
                        });
                    }
                },
                complete: function () {
                },
                error: function (data) {
                    console.log(data['responseText']);
                }
            });
        }
    }
    function clean_comment(obj) {
        $(obj).parents('.form-comment').find('textarea').val('');
        $(obj).parents('.form-comment').find('.btn-custom').removeAttr('reply-comment-id');
        $(obj).parents('.form-comment').find('.btn-custom').removeAttr('comment-id');
    }

    function edit_comment(obj) {
        $(obj).removeAttr('reply-comment-id');
        var object_id = $(obj).attr('data-id');
        var comment_id = $(obj).attr('comment-id');
        var text = $(obj).parents('.form-comment').find('textarea').val();
        if (text.trim() != '' && text.trim() != null) {
            $(obj).attr('disabled', 'disabled');
            $(obj).parents('.form-comment').find('.load-comment').css('display', 'initial');
            $.ajax({
                url: "<?php echo base_url('/comments/update'); ?>/" + object_id + "/photo",
                type: 'POST',
                dataType: "json",
                data: {
                    "text": text,
                    'data_id': comment_id
                },
                success: function (data) {
                    console.log(data);
                    if (data['status'].trim() == "true") {
                        $(obj).parents('.form-comment').find('.comment-items[data-id="' + comment_id + '"] .text-comment').text(text);
                    }
                },
                complete: function () {
                    $(obj).removeAttr('disabled');
                    $(obj).parents('.form-comment').find('.load-comment').css('display', 'none');
                },
                error: function (data) {
                    console.log(data['responseText']);
                }
            });
            $(obj).parents('.form-comment').find('textarea').val('');
            $(obj).parents('.form-comment').find('.btn-custom').removeAttr('comment-id');
        }
    }

    function add_comment(obj) {
        var object_id = $(obj).attr('data-id');
        var text = $(obj).parents('.form-comment').find('textarea').val();
        if (text.trim() != '' && text.trim() != null) {
            $(obj).attr('disabled', 'disabled');
            $(obj).parents('.form-comment').find('.load-comment').css('display', 'initial');
            $.ajax({
                url: "<?php echo base_url('/comments/add'); ?>/" + object_id + "/photo",
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
                },
                error: function (data) {
                    console.log(data['responseText']);
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