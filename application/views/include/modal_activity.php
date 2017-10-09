<div id="Activity_Pop_up" class="modal fade" role="dialog">
	<div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
		    <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
		        <h3 class="modal-title"><b>Activity</b></h3>
		    </div>
		    <div class="modal-body">
		        <div class="list">
		        	<div class="media">
					  	<div class="media-left">
						    <img src="https://www.w3schools.com/bootstrap/img_avatar6.png" class="img-circle media-object" width="60px">
					  	</div>
					  	<div class="media-body">
						    <h4 class="media-heading"><b>Image Title</b></h4>
						    <p>Lorem ipsum dolor sit amet, conse adip icing elit...</p>
						    <p class="date-time">Like image on Date - Time</p>
						</div>
					</div>
					<div class="media">
					  	<div class="media-left">
						    <img src="https://www.w3schools.com/bootstrap/img_avatar6.png" class="img-circle media-object" width="60px">
					  	</div>
					  	<div class="media-body">
						    <h4 class="media-heading"><b>Image Title</b></h4>
						    <p>Lorem ipsum dolor sit amet, conse adip icing elit...</p>
						    <p class="date-time">Like image on Date - Time</p>
						</div>
					</div>
					<div class="media">
					  	<div class="media-left">
						    <img src="https://www.w3schools.com/bootstrap/img_avatar6.png" class="img-circle media-object" width="60px">
					  	</div>
					  	<div class="media-body">
						    <h4 class="media-heading"><b>Image Title</b></h4>
						    <p>Lorem ipsum dolor sit amet, conse adip icing elit...</p>
						    <p class="date-time">Like image on Date - Time</p>
						</div>
					</div>
					<div class="media">
					  	<div class="media-left">
						    <img src="https://www.w3schools.com/bootstrap/img_avatar6.png" class="img-circle media-object" width="60px">
					  	</div>
					  	<div class="media-body">
						    <h4 class="media-heading"><b>Image Title</b></h4>
						    <p>Lorem ipsum dolor sit amet, conse adip icing elit...</p>
						    <p class="date-time">Like image on Date - Time</p>
						</div>
					</div>
					<div class="media">
					  	<div class="media-left">
						    <img src="https://www.w3schools.com/bootstrap/img_avatar6.png" class="img-circle media-object" width="60px">
					  	</div>
					  	<div class="media-body">
						    <h4 class="media-heading"><b>Image Title</b></h4>
						    <p>Lorem ipsum dolor sit amet, conse adip icing elit...</p>
						    <p class="date-time">Like image on Date - Time</p>
						</div>
					</div>
		        </div>
		    </div>
		    <div class="row">
		    	<div class="col-sm-12 text-right">
		    		<a href="#" id="more-activity" class="btn btn-link">MORE</a>
		    	</div>
		    </div>
	    </div>
	    <!--! Modal content-->
	</div>
</div>

<style type="text/css">
	#Activity_Pop_up .remove-margin{margin: 0!important}
	#Activity_Pop_up .remove-padding{padding: 0!important}
	#Activity_Pop_up {padding: 0!important;}
	#Activity_Pop_up .modal-header,#Activity_Pop_up .modal-body,#Activity_Pop_up .modal-footer{padding: 0;background-color: #fff}
	#Activity_Pop_up .modal-header{border-bottom: 3px solid #ddd!important;padding-bottom: 10px;}
	#Activity_Pop_up .modal-content{padding: 10px 15px;}
	#Activity_Pop_up p{color: #333;margin: 0 0 5px 0;font-size: 16px;line-height: 1}
	#Activity_Pop_up .modal-dialog{width: 670px;max-width: 100%;margin: 10px auto;}
	#Activity_Pop_up .modal-title{color: #333;}
	#Activity_Pop_up .list{height: 440px;overflow-x: hidden;overflow-y: auto;}
	#Activity_Pop_up .list .media{margin: 20px 0}
	#Activity_Pop_up .list .media .media-heading{color: #333;}
	#Activity_Pop_up .date-time{color: #339999;font-size: 14px;}
	#Activity_Pop_up .modal-header .close{	
    	top: 0px;
    	right: 9px;
	}
</style>
<script type="text/javascript">
	$("#activity #box-bottom-more a").click(function(){
    	get_active();
    	return false;
    });	
	$("#Activity_Pop_up #more-activity").click(function(){
		var items = $("#Activity_Pop_up .list .media").length;
    	get_active(items,true);
    	return false;
	});
	function get_active(items = 0,append = false){
	 	$.ajax({
    		url:base_url + "profile/get_active",
    		dataType:"json",
    		type:"post",
    		data :{items : items},
    		success:function(res){
    			if(res["status"] == 'success'){
    				if(append == false)
    					$("#Activity_Pop_up .list").html(res["response"]);
    			    else
    					$("#Activity_Pop_up .list").append(res["response"]);
    				if(res["more"] == false){
						$("#Activity_Pop_up #more-activity").hide();
					}else{
						$("#Activity_Pop_up #more-activity").show();
					}
    				$("#Activity_Pop_up").modal();
    			}else{
    				alert("Error");
    			}
    		},error:function(){
    			alert("Error");
    		}
    	});
	}
</script>