<div id="modal-comments" class="modal fade" role="dialog">
	<div class="modal-dialog">
	    <!-- Modal content-->
	    <div class="modal-content revised-comment">
	    	<button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
	        <div class="modal-body">
			   	<div class="media">
			   		<a href="#"><img style="margin-top: -10px;" width="25px" src="<?php echo base_url ("skins/icon/hearth.png")?>"><b id="title-comment-top"></b>   <button class="btn btn-link"><i class="fa fa-chevron-right fa-2x"></i></button></a>
			   	</div>
			   	<!-- list comment -->
			   	<div class="list-comment">
			   		
				   	 
			   	</div>
			   	<!--//// list comment -->
			   	<div class="row">
			   		<div class="col-md-12 text-right">
			   			<a id="more_comment" class="btn btn-link">MORE</a>
			   		</div>
			   	</div>
			   	<div class="row">
			   		<div class="col-md-12">
			   			<!-- form comment -->
			         	<form method="post" id="post_comment" action="<?php echo base_url("photos/postcomment");?>"  class="form">
				         	<div class="media remove-padding">
					            <div class="media-left">
					                <input type="file" accept="image/*" id="media-comment" class="none hidden hide" name="media">
					               	<a href="#" onclick="$('#modal-comments #post_comment #media-comment').trigger('click');return false;"><img width="40px;" class="media-object" src="<?php echo base_url("skins/icon/camera.png");?>"></a>
					            </div>
					            <div class="media-body">
					               	<div class="form-group">
					               		<textarea name ="comment" class="form-control border-input-style" rows="3" placeholder="Write a comment..." ></textarea>
					               	</div>
					               	<div id="box-media-show"></div>
					               	<div class="form-group">
					               	</div>
					               	<div class="row">
					               		<div class="col-md-12 text-right">
					               		    <input type="hidden" id="set-id" name="id" class="none">
					               		    <input type="hidden" id="set-type" name="type" class="none">
					               			<input type="hidden" id="follow_comment" name="follow_comment_id" value="0">
					               			<button type="button" class="btn btn-gray" data-dismiss="modal">Cancel</button>
	            							<button type="submit" class="btn btn-primary relative">Post</button>
					               		</div>
					               	</div>
					            </div>
				         	</div>
				        </form>
				        <!--//// form comment -->
			   		</div>
			   	</div>
			   	
	        </div>
	        <!--//// body modal -->
	    </div>
	    <!--//// Modal content-->
   	</div>
</div>
<style type="text/css">
	#modal-comments #box-media-show {position: relative;width: auto;display: inline-block;}
	#modal-comments #box-media-show a {position: absolute;top: 5px;right: 5px;}
	
    #modal-comments .allow-like,#modal-comments .allow-follow{ color: #37a7a7!important; }
    #modal-comments .error {border:1px solid red !important;}
    #modal-comments #post_comment {margin-top: 10px;}
    #modal-comments #box-media-show img {max-height: 150px;}
	.revised-comment .media .media{border-bottom: 3px solid #ddd;padding-bottom: 15px;}
	.revised-comment .media .media:last-child{border-bottom: 0;}
	#modal-comments .list-comment .show{border-bottom: 3px solid #ddd;padding-bottom: 15px;}
	#modal-comments .list-comment .show:last-child{border-bottom: 0 !important;}
	.revised-comment .media .media-body p{color: #333;font-size: 14px;}
	.revised-comment .media .media-body .Date_Time_Posted{color: #777;font-size: 14px;}
	.revised-comment .media .list-inline li a{color: #333;font-size: 14px;font-weight: 100;}
	.revised-comment .media .media-body a{color: #000;font-weight: 600;font-size: 14px;}
	.revised-comment .media .media-body a span{font-weight: 100;}
	.revised-comment .media a b{color: #333;font-size: 22px;font-weight: 600;}
	.revised-comment .media a .btn-link{color: #333;font-size: 10px;}
	.revised-comment .form-comment textarea, .revised-comment .form textarea{font-size: 14px;}
	.close{
		color: #000;
		opacity: 1;
		font-size: 22px;
		position: relative;
	    top: 0px;
	    right: 18px;
	    z-index: 999;
	}
	.btn{border-radius: 2px!important;}
	#modal-comments .form-comment{display: none;box-shadow: inset 0px -5px 20px -5px #777;padding: 5px 10px;margin: 15px 0;}
	.border-input-style{border:none !important;box-shadow: inset 0px -2px 15px -5px #777}
	.revised-comment .list-comment{
		border-bottom: 3px solid #ccc;
	    max-height: 395px;
	    overflow-x: hidden;
	    overflow-y: auto;
	    padding: 10px 2px 5px 0;
	    min-height: 350px;
	}
	#modal-comments .loadding{position: absolute; width: 100%;cursor: wait;right: 0;top: 0;bottom: 0; text-align: center;}
    #modal-comments .loadding img {max-height: 100%;max-width: 100%; margin: 0 auto;}
    #box-media-show a:hover i {color: red;}
    #box-media-show a{
    	padding: 0 3px;
	    background: #fff;
	    border-radius: 100%;
	    height: 19px;
	    width: 19px;
	    text-align: center;
    }
</style>
<script type="text/javascript">
    var current_box_comment ;
	$(document).on("click", "body #comment-show", function () {
	    if (check_login() != false) {
	    	current_box_comment = $(this).parents(".card");
	    	var id = current_box_comment.attr("data-id");
	    	var type = current_box_comment.attr("data-type");
	    	if(id && type){
	    		$.ajax({
	    			url  : base_url + "photos/get_comment",
	    			type : "post",
	    			dataType : "json",
	    			data : {id : id , type : type},
	    			success:function(res){
	    				if(res["status"] == "success"){
	    					if(res["response"] == ""){
	    						$("#modal-comments .list-comment").html('<p class="no-comment">No comment!</p>');
	    						$("#modal-comments #title-comment-top").html(" Currently no comments!");
	    					}else{
	    						if(res["dataComment"]["numberComment"] > 0){
	    							$("#modal-comments #title-comment-top").html(" "+res["dataComment"]["month"]+" "+res["dataComment"]["full_name"]+" and  "+res["dataComment"]["numberComment"]+" others");
	    						}else if(res["dataComment"]["numberComment"] == 0){
	    							$("#modal-comments #title-comment-top").html(" "+res["dataComment"]["month"]+" "+res["dataComment"]["full_name"]+"");
	    						}else{
	    							$("#modal-comments #title-comment-top").html(" "+res["dataComment"]["month"]+" no comments");
	    						}
	    						$("#modal-comments .list-comment").html(res["response"]);	
	    					}	
	    					if($("#modal-comments .list-comment > .media").length <= 3){
	    						$("#modal-comments #more_comment").addClass('none');
	    					}else{
	    						$("#modal-comments #more_comment").removeClass("none");
	    					}
	    					$("#modal-comments #set-id").val(id);
	    					$("#modal-comments #set-type").val(type);
	    					$("#modal-comments").modal();    					
	    				}
	    			},
	    			error : function (){

	    			}
	    		})
	    	}
	        
	    }
	    return false;
	});
	$(document).on("click", "#notifications #comment-view-and-show", function () {
	    if (check_login() != false) {
	    	var id = $(this).attr("data-id");
	    	var type = $(this).attr("data-type");
	    	current_box_comment = $(".card[data-id='"+id+"'][data-type='"+type+"']");
	    	if(id && type){
	    		$.ajax({
	    			url  : base_url + "photos/get_comment",
	    			type : "post",
	    			dataType : "json",
	    			data : {id : id , type : type},
	    			success:function(res){
	    				if(res["status"] == "success"){
	    					if(res["response"] == ""){
	    						$("#modal-comments .list-comment").html('<p class="no-comment">No comment!</p>');
	    					}else{
	    						$("#modal-comments .list-comment").html(res["response"]);	
	    					}	
	    					if($("#modal-comments .list-comment > .media").length <= 3){
	    						$("#modal-comments #more_comment").addClass('none');
	    					}else{
	    						$("#modal-comments #more_comment").removeClass("none");
	    					}
	    					$("#modal-comments #set-id").val(id);
	    					$("#modal-comments #set-type").val(type);
	    					$("#modal-comments").modal();    					
	    				}
	    			},
	    			error : function (){

	    			}
	    		})
	    	}
	        
	    }
	    return false;
	});
	$(document).on("change","#modal-comments #post_comment #media-comment",function(){
		var _this = $(this);
        if ($(this)[0].files && $(this)[0].files[0]) {
            var file = $(this)[0].files[0];
            window.URL = window.URL || window.webkitURL;
            var url = window.URL.createObjectURL(file);
            $("#modal-comments #box-media-show").html('<img src="'+url+'" /><a href="#"><i class="fa fa-trash"></i></a>');
       
        }else{
            $("#modal-comments #box-media-show").html('');
        }
	});
	var control = $("#media-comment");
	$(document).on("click","#modal-comments #box-media-show a",function(){
    	$("#modal-comments #box-media-show").html('');
    	control.val(null);
    	control.replaceWith(control=control.clone(true));
    	return false;
	});
	
	$(document).on("submit","#modal-comments #post_comment",function(){
		var _this = $(this);
		_this.find("[name=comment]").removeClass("error");
		if(_this.find("[name=comment]").val() != ""){
			_this.ajaxSubmit({
		        beforeSubmit : function(){
		            _this.find("button[type=submit]").append('<div class="loadding"><img src="<?php echo skin_url("images/loading.gif");?>"></div>');
		        },
		        dataType:"json",
		        success:function(res){

		        	if(res["status"] == "success"){
		        		if(_this.find("#follow_comment").val() == "0" || _this.find("#follow_comment").val() == "" || _this.find("#follow_comment").val() == 0){
		        			$("#modal-comments .list-comment ").prepend(res["response"]);
		        			_this.parents().find("#box-media-show").html("");
		        		}else{
		        			_this.after(res["response"]);
		        			_this.slideToggle();
		        		}
		        		$("#modal-comments .no-comment").remove();
		        		current_box_comment.find("#num-comment").text(res["tkrecord"]["qty_comment"] + " Comments");
		        		if(_this.find("#follow_comment").val() == "0" || _this.find("#follow_comment").val() == "" || _this.find("#follow_comment").val() == 0){
		        			$.each ($("#modal-comments .list-comment").find(">.media"),function(key,val){
			        			var sortorder = "";
			        			if(key == 0) sortorder = (key+1) +"st";
			        			if(key == 1) sortorder = (key+1) +"nd";
			        			if(key == 2) sortorder = (key+1) +"rd";
			        			if(key > 2)  sortorder = (key+1) +"th";
			        			$(this).find("#order_post").text(sortorder);
			        		});
		        		}else{
		        			$.each (_this.closest(".media-body").find(">.media"),function(key,val){
			        			key ++;
			        			var sortorder = "";
			        			if(key == 0) sortorder = (key+1) +"st";
			        			if(key == 1) sortorder = (key+1) +"nd";
			        			if(key == 2) sortorder = (key+1) +"rd";
			        			if(key > 2)  sortorder = (key+1) +"th";
			        			$(this).find("#order_post").text(sortorder);
			        		});
		        		}
		        		_this[0].reset();	
		        	}
		        	_this.find(".loadding").remove();
		        },
		        error:function(){
		            _this.find(".loadding").remove();
		        }
		    });
		}else{
			_this.find("[name=comment]").addClass("error");
		}
		
	    return false;
	});
    $(document).on("click",'#modal-comments .btn-write-comment',function() {

        $(this).parents('.media-body').find('.form-comment').slideToggle();
        return false;
    });
    $(document).on("click","#modal-comments #more_comment",function(){
    	$.each($("#modal-comments .list-comment > .media.none"),function(key ,val){
    		if(key > 2){
    			return false;
    		}else{
    			$(this).removeClass("none").addClass("show");
    		}
    	});
    	if($("#modal-comments .list-comment > .media.none").length == 0){
    		$(this).addClass("none");
    	}
    });
    $(document).on("click","#modal-comments #like-comment-now",function(){
    	var _this = $(this);
    	var id = $(this).attr('data-id');
    	if(id){
    		$.ajax({
    			url:base_url + "photos/like_comment",
    			dataType:"json",
    			type:"post",
    			data: {id:id},
    			success:function(res){
    				if(res["status"] == "success"){
    					if(res["response"]["status"] == true){
    						_this.addClass("allow-like");
    						_this.attr("title","Unlike comment");
    						_this.removeClass("not-like");
    					}else{
    						_this.removeClass("allow-like");
    						_this.attr("title","Like comment");
    						_this.addClass("not-like");
    					}
    					_this.html('<i class="fa fa-circle icon-xs"></i> '+res["response"]["numlive"] + " Like");
    				}else{
    					alert("Error!");
    				}
    			},error:function(){
    				alert("Error!");
    			}
    		})
    	}
    	return false;
    });
    $(document).on("click","#modal-comments #like-follow-now",function(){
    	var _this = $(this);
    	var id = $(this).attr('data-id');
    	if(id){
    		$.ajax({
    			url:base_url + "photos/follow_comment",
    			dataType:"json",
    			type:"post",
    			data: {id:id},
    			success:function(res){
    				console.log(res);
    				if(res["status"] == "success"){
    					if(res["response"]["status"] == true){
    						_this.addClass("allow-follow");
    						_this.attr("title","Unfollow comment");
    						_this.removeClass("not-follow");
    					}else{
    						_this.removeClass("allow-follow");
    						_this.attr("title","Follow comment");
    						_this.addClass("not-follow");
    					}
    				}else{
    					alert("Error!");
    				}
    			},error:function(){
    				alert("Error!");
    			}
    		})
    	}
    	return false;
    });
</script>