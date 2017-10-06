<?php $user = $this->session->userdata('user_info');?>
<div class="modal modal-skin17 modal-work-experience fade" id="add-social-popup-box" tabindex="-1" role="dialog" aria-labelledby="slide9-popup-upload">
    <div id="comment-popup-box" class="modal-dialog" role="document">
        <div class="modal-content">
                <div class="comment-popup-head">
                    <h4 class="remove-margin">Share socially...</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                </div>
                <div class="modal-body">
                <!-- commment pop_up -->
                    <div class="comment-body">
                        <div class="media">
                            <div class="media-left">
                                <img class="img-circle media-object" src="<?php echo isset($user["avatar"]) && $user["avatar"]!="" ? base_url(@$user["avatar"]) : skin_url("images/avatar-full.png"); ?>" class="media-object" width="50px">
                            </div>
                            <div class="media-body">
                              <h4 class="name">Hi <b><?php echo $user["first_name"];?></b>! Post a message and connect with the design community.</h4>
                            </div>
                        </div> 
                        <form id="form-post-upload" method="post" action="<?php echo base_url("profile/add_social")?>">
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
                                        <li><button type="submit" class="relative btn btn-primary">Post</button></li>
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
    #comment-popup-box{width: 400px;max-width: 100%;border-radius: 5px;box-shadow: -5px 5px 5px 0px #333;}
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
    #add-social-popup-box .fa-globe{font-size: 38px;}
    #add-social-popup-box .dropdown-menu{padding: 0 10px;}
    #add-social-popup-box .dropdown-menu .checkbox{padding-left: 0;}
    #add-social-popup-box .checkbox input[type="checkbox"]:checked + label::after, #add-social-popup-box .checkbox input[type="radio"]:checked + label::after{
        content: "";
        top: 1px;
        left: 1px;
        width: 16px;
        height: 16px;
    }
    #add-social-popup-box #comment-popup-box .close {
	    position: relative;
	    top: -27px;
	    right: -5px;
	    font-size: 20px;
	}
    #form-post-upload .thumbnail.error{border:1px solid red;}
    #add-social-popup-box  .loadding{position: absolute; width: 100%;cursor: wait;right: 0;top: 0;bottom: 0; text-align: center;}
    #add-social-popup-box  .loadding img {max-height: 100%;max-width: 100%; margin: 0 auto;}
    /*////slide 9 post upload image*/
</style>
<script type="text/javascript">
$(document).ready(function(){
    $("#btn-add-social").click(function(){
        var maxlength = 300;
        var currentlength = $(this).val().length;
        var cl_length =  maxlength - currentlength;
        $("#add-social-popup-box #max-length-content").text(cl_length);
        $("#add-social-popup-box").modal();
        return false;
    });
    $("#add-social-popup-box  .loadding").click(function(event){
        event.stopPropagation();
        event.preventDefault();
        return false;
    });
    $("#add-social-popup-box #form-post-upload").submit(function(){
    	if($(this).find("#content-social").val() == null || $(this).find("#content-social").val().trim() == ""){
    		$(this).find(".thumbnail").addClass("error");
    		return false;
    	}
    	$(this).find(".thumbnail").removeClass("error");
    	$(this).ajaxSubmit({
	        beforeSubmit : function(){
	            $("#add-social-popup-box #form-post-upload").find("button[type=submit]").append('<div class="loadding"><img src="<?php echo skin_url("images/loading.gif");?>"></div>');
	        },
	        dataType:"json",
	        success:function(res){
	            console.log(res);
	            if(res["status"] == "success"){
	                post_social.push(res["id"]);
	                $("#grid-column-1").prepend(res["reponse"]);
	                $("#add-social-popup-box #form-post-upload")[0].reset();
	                $("#add-social-popup-box .content-upload-image").addClass("none");
	                $("#add-social-popup-box").modal("hide");
	            }else{
	                alert("Error!");
	            }
	            $("#add-social-popup-box #form-post-upload").find(".loadding").remove();
	        },
	        error:function(){
	            $("#add-social-popup-box #form-post-upload").find(".loadding").remove();
	        }
	    }); 
	    return false;
    });
    $("#add-social-popup-box  #form-post-upload #file-upload-socail").change(function(){
        var _this = $(this);
        if ($(this)[0].files && $(this)[0].files[0]) {
            var file = $(this)[0].files[0];
            window.URL = window.URL || window.webkitURL;
            var url = window.URL.createObjectURL(file);
            $("#add-social-popup-box .content-upload-image #read-image-social").attr("src",url);
            $("#add-social-popup-box .content-upload-image").removeClass("none");
        }else{
            $(this).parent().find(".box-img-select").html('');
        }
        return false;
    });
    $("#add-social-popup-box #remove-image-social").click(function(){
        var input = $("#form-post-upload #file-upload-socail");
        input.replaceWith(input.val('').clone(true));
         $("#add-social-popup-box .content-upload-image").addClass("none");
         $("#add-social-popup-box .content-upload-image #read-image-social").attr("src","#");

    });
    $("#add-social-popup-box #content-social").keydown(function(event){
        var maxlength = 300;
        var currentlength = $(this).val().length;
        var cl_length =  maxlength - currentlength;
        $("#add-social-popup-box #max-length-content").text(cl_length);
        if(event.keyCode != 8){
            if(cl_length <= 0){
                event.stopPropagation();
                event.preventDefault();
                return false;
            }
        }
        return true;
    });
    $("#add-social-popup-box #content-social").keyup(function(event){
        var maxlength = 300;
        var currentlength = $(this).val().length;
        var cl_length =  maxlength - currentlength;
        $("#add-social-popup-box #max-length-content").text(cl_length);
        if(event.keyCode != 8){
            if(cl_length <= 0){
                event.stopPropagation();
                event.preventDefault();
                return false;
            }
        }
        return true;
    });
    $("#add-social-popup-box #datetimepicker1").datetimepicker({
        format :"Y/MM/DD"
    });
});
</script>