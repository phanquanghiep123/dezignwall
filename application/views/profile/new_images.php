<link rel="stylesheet" type="text/css" href="<?php echo skin_url("css/page/profile.css");?>">
<?php $this->load->view("include/banner", @$member);?>
<section class="section box-wapper-show-image my_photo" id="wrapper">
    <div class="container" style="position: relative;min-height:400px;">
        <div class="row"><h1 id="all-img-seach"><?php echo $all_photo;?> results found</h1></div>
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
                        <?php 
                            $this->load->view("seach/seach_result_ajax",array("photo" => $photo)); 
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
<style type="text/css">
    .card .top-social .action{
        position: absolute;
        right: 10px;
        top: 0;
        display: inline-block;
    }
    .card .top-social .action ul li{   
        display: inline-block;
        list-style: none;
        margin-right: 10px;
    }
    .card .top-social{position: relative;}
    .card .top-social{position: relative;}
</style>


<div class="modal fade" id="edit-social-popup-box" tabindex="-1" role="dialog" aria-labelledby="slide9-popup-upload">
    <div id="comment-popup-box" class="modal-dialog" role="document">
        <div class="modal-content">
                <div class="comment-popup-head">
                    <h4 class="remove-margin">Share socially...</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                </div>
                <div class="modal-body">
                <!-- commment pop_up -->
                    <div class="comment-body">
                         
                        <form id="form-post-upload" method="post" action="<?php echo base_url("profile/update_social")?>">
                            <div class="thumbnail">
                                <div class="post">
                                    <div class="form-group">
                                        <textarea id="content-social" name="content" class="form-control" rows="6" placeholder="What's on your mind? Share a question, post a topic, or an idea..."></textarea>
                                    </div>                                   
                                    <div class="content-upload-image none">
                                        <p class="images-post remove-margin">
                                            <img width="100%" src="#" alt="image" id="read-image-social">
                                            <button type="button" id="remove-image-social" class="btn btn-default btn-image">x</button>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <p class="text-right" id="max-length-content">300</p>
                            <div class="row">
                                <div class="col-sm-12">
                                    <ul class="list-inline list-btn remove-margin"">
                                        <li>
                                            <div class="dropdown">
                                              <a href="#" class="dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-globe "></i></a>
                                              <ul class="dropdown-menu">
                                                <li>
                                                    <div class="checkbox checkbox-circle">
                                                        <input checked id="data-check-public" name="public" type="radio" value="1">
                                                        <label for="data-check-public">Public</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox checkbox-circle">
                                                        <input id="data-check-connection-only" name="public" type="radio" value="0">
                                                        <label for="data-check-connection-only">Connection only</label>
                                                    </div>
                                                </li>
                                              </ul>
                                            </div>
                                        </li>
                                        <li>
                                            <div class='input-group date' id='datetimepicker1'>
                                                <input style="display: none; width: 0;" type='text' name="daytime" class="none form-control" />
                                                <span class="input-group-addon">
                                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                                </span>
                                            </div>
                                        </li>
                                        <li><input id="file-upload-socail" style="display: none;" type="file" class="none" name="image" accept="image/*"><a onclick="$('#file-upload-socail').trigger('click'); return false;" href="#"><i class="fa fa-camera "></i></a></li>
                                        <li><button type="button" class="btn btn-gray"  data-dismiss="modal" aria-label="Close">Cancel</button></li>
                                        <li><button type="submit" class="relative btn btn-primary">Update</button></li>
                                    </ul>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- commment pop_up -->
            
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo skin_url('datetimepicker/js/moment.js');?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo skin_url('datetimepicker/css/bootstrap-datetimepicker.min.css')?>">
<script type="text/javascript" src="<?php echo skin_url('datetimepicker/js/bootstrap-datetimepicker.min.js')?>"></script>
<style type="text/css">
    /*slide 9 post upload image*/
    #comment-popup-box{width: 450px;max-width: 100%;border-radius: 5px;box-shadow: -5px 5px 5px 0px #333;}
    #comment-popup-box .close{position: relative;top: -35px;right: -5px;font-size: 20px;}
    #comment-popup-box .comment-popup-head{background-color: #339999;padding: 15px;border-top-left-radius: 5px;border-top-right-radius: 5px;}
    #comment-popup-box .modal-content{border: none;}
    .comment-body .name, .comment-body .name:hover{color: #333;font-size: 16px;}
    .comment-popup-head h4{color: #fff;}
    #form-post-upload{margin: 5px 0;}
    #form-post-upload .thumbnail{border: 1px solid #777;}
    #form-post-upload textarea{border: none;box-shadow: none;font-size: 16px;padding: 0;}
    .thumbnail .post{padding: 5px;}
    .thumbnail .post p{font-size: 16px;}
    .images-post{position: relative;}
    .list-btn .btn-fix{font-size: 14px;font-weight: 100;margin-left: 15px;padding: 6px 12px;}
    .list-btn .btn{padding:8px 16px;font-size: 16px;}
    .images-post .btn-image{position: absolute;right: 0;top:-40px;color: #000;border: none;font-size: 20px;padding-top: 2px;}
    .btn-primary,.btn-primary:hover,.btn-primary:focus{
        background-color: #339999;
        border-color: #339999;
    }
    .list-btn{display: inline-flex;}
    .list-btn .fa{font-size: 35px;color: #ccc;}
    .list-btn li{margin:3px 18px 3px 0;}
    .list-btn li:last-child{margin-right: 0px;}
    #datetimepicker1 .input-group-addon{border: none; padding: 0;}
    #datetimepicker1 .input-group-addon .input-group{display: block;}
    #edit-social-popup-box .fa-globe{font-size: 38px;}
    #edit-social-popup-box .dropdown-menu{padding: 0 10px;}
    #edit-social-popup-box .dropdown-menu .checkbox{padding-left: 0;}
    #edit-social-popup-box .checkbox input[type="checkbox"]:checked + label::after, #edit-social-popup-box .checkbox input[type="radio"]:checked + label::after{
        content: "";
        top: 1px;
        left: 1px;
        width: 16px;
        height: 16px;
    }
    #edit-social-popup-box #comment-popup-box .close {
        position: relative;
        top: -27px;
        right: -5px;
        font-size: 20px;
    }
    #form-post-upload .thumbnail.error{border:1px solid red;}
    #edit-social-popup-box  .loadding{position: absolute; width: 100%;cursor: wait;right: 0;top: 0;bottom: 0; text-align: center;}
    #edit-social-popup-box  .loadding img {max-height: 100%;max-width: 100%; margin: 0 auto;}
    /*////slide 9 post upload image*/
</style>
<script type="text/javascript">
$(document).ready(function(){
    var id;
    $("body #delete-socail-post").click(function(){
        $("#modal_delete").modal();
        id = $(this).attr("data-id");

    });
    $("#modal_delete #ok-delete").click(function(){
        $.ajax({
            url : base_url + "profile/delete_socail",
            type : "post",
            dataType : "json",
            data : {id : id},
            success : function(res){
                if(res["status"] == "success"){
                    location.reload();
                }else{
                    alert("Error!");
                }
            },error : function(){
                alert("Error!");
            }
        });
        return false;
    });
    $("body #edit-socail-post").click(function(){
        id = $(this).attr("data-id");
        //get info post
        $.ajax({
            url : base_url + "profile/get_info_socail_post",
            type : "post",
            dataType : "json",
            data : {id : id},
            success : function (res){
                if(res["status"] == "success"){
                    $("#edit-social-popup-box #content-social").val(res["response"]["content"]);
                    $("#edit-social-popup-box [name=public][value="+res["response"]["public"]+"]").prop('checked', true);
                    $("#edit-social-popup-box [name=daytime]").val(res["response"]["created_at"]);
                    if(res["response"]["thumb"] != null && res["response"]["thumb"].trim() != ""){
                        $("#edit-social-popup-box #read-image-social").attr("src",res["response"]["thumb"]);
                        $("#edit-social-popup-box .content-upload-image").removeClass("none");
                    }else{
                        $("#edit-social-popup-box .content-upload-image").addClass("none");
                    } 
                }
            },error : function(){
                alert("Error!")
            }
        })
        $("#edit-social-popup-box").modal();
        return false;
    });
    $("#edit-social-popup-box .loadding").click(function(event){
        event.stopPropagation();
        event.preventDefault();
        return false;
    });
    $("#edit-social-popup-box #form-post-upload").submit(function(){
        if($(this).find("#content-social").val() == null || $(this).find("#content-social").val().trim() == ""){
            $(this).find(".thumbnail").addClass("error");
            return false;
        }
        $(this).find(".thumbnail").removeClass("error");
        $(this).ajaxSubmit({
            beforeSubmit : function(){
                $("#edit-social-popup-box #form-post-upload").find("button[type=submit]").append('<div class="loadding"><img src="<?php echo skin_url("images/loading.gif");?>"></div>');
            },
            dataType:"json",
            data :{id : id},
            success:function(res){
                if(res["status"] == "success"){
                    location.reload();
                }else{
                    alert("Error!");
                    $("#edit-social-popup-box #form-post-upload").find(".loadding").remove();
                }
            },
            error:function(){
                $("#edit-social-popup-box #form-post-upload").find(".loadding").remove();
            }
        }); 
        return false;
    });
    $("#edit-social-popup-box  #form-post-upload #file-upload-socail").change(function(){
        var _this = $(this);
        if ($(this)[0].files && $(this)[0].files[0]) {
            var file = $(this)[0].files[0];
            window.URL = window.URL || window.webkitURL;
            var url = window.URL.createObjectURL(file);
            $("#edit-social-popup-box .content-upload-image #read-image-social").attr("src",url);
            $("#edit-social-popup-box .content-upload-image").removeClass("none");
        }else{
            $(this).parent().find(".box-img-select").html('');
        }
        return false;
    });
    $("#edit-social-popup-box #remove-image-social").click(function(){
        var input = $("#form-post-upload #file-upload-socail");
        input.replaceWith(input.val('').clone(true));
         $("#edit-social-popup-box .content-upload-image").addClass("none");
         $("#edit-social-popup-box .content-upload-image #read-image-social").attr("src","#");

    });
    $("#edit-social-popup-box #content-social").keydown(function(event){
        var maxlength = 300;
        var currentlength = $(this).val().length;
        var cl_length =  maxlength - currentlength;
        $("#edit-social-popup-box #max-length-content").text(cl_length);
        if(event.keyCode != 8){
            if(cl_length <= 0){
                event.stopPropagation();
                event.preventDefault();
                return false;
            }
        }
        return true;
    });
    $("#edit-social-popup-box #content-social").keyup(function(event){
        var maxlength = 300;
        var currentlength = $(this).val().length;
        var cl_length =  maxlength - currentlength;
        $("#edit-social-popup-box #max-length-content").text(cl_length);
        if(event.keyCode != 8){
            if(cl_length <= 0){
                event.stopPropagation();
                event.preventDefault();
                return false;
            }
        }
        return true;
    });
    $("#edit-social-popup-box #datetimepicker1").datetimepicker({
        format :"Y/MM/DD"
    });
});
</script>