<!-- Modal -->
<div class="modal fade" id="View_profile" role="dialog">
    <div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	        <div class="modal-header">
	          	<button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
	          	<h4 class="modal-title"><b>Who's view're your profile</b></h4>
	          	<p class="number-view"><b id="number-view">444</b> <span> Profile views in the last 90 days</span></p>
	        </div>
	        <div class="modal-body">
	          	<div class="list">

	          	</div>
	          	<div class="row">
	          		<div class="col-sm-12 text-right"><a id="more-data" href="javascript:;" class="btn btn-link btn-lg">MORE</a></div>
	          	</div>
	        </div>
	        
      	</div>
      	<!--! Modal content-->

    </div>
</div>
<!--! Modal -->

<style type="text/css">
	.remove-margin{margin: 0!important}
	.remove-padding{padding: 0!important}
	#View_profile .modal-dialog{width: 720px;max-width: 100%}
	#View_profile .modal-header{background-color: #fff;}
	#View_profile .modal-header .modal-title{margin-top: 10px;color: #000}
	#View_profile .modal-header .number-view{color: #339999;font-size: 36px;}
	#View_profile .modal-header {border-bottom: 2px solid #ddd}
	#View_profile .modal-header, #View_profile .modal-body, #View_profile .modal-footer{padding: 0px;}
	#View_profile .modal-content{padding: 15px;}
	#View_profile .modal-body h4 span,#View_profile .modal-body p{color: #777;font-size: 16px;}
	#View_profile .modal-body .list{height: 400px;overflow-x: hidden;overflow-y: auto;margin: 10px 0;padding-right: 20px;}
	#View_profile .modal-body .list .media{margin: 15px 0}
	#View_profile .modal-body .list .media:last-child{margin: 0;}
	#View_profile .modal-footer{border-top: 2px solid #ddd}
	#View_profile .day_time{color: #339999;font-size: 16px;}
	#View_profile span{color: #333;font-size: 16px;}
	#View_profile .img-circle {
	    width: 60px;
	    height: 60px;     
	}
</style>
<script type="text/javascript">
	$(document).on("click","#show_number_viewed_profile",function(){
		var member_id = "<?php echo @$member_id;?>";
		$.ajax({
			url:"<?php echo base_url("profile/get_viewed_profile");?>",
			type:"post",
			dataType:"json",
			data:{member_id:member_id,items:0},
			success:function(res){
				if(res["status"] == "success"){
					if(res["show"] == false){
						$("#View_profile #more-data").hide();
					}else{
						$("#View_profile #more-data").show();
					}
					$("#View_profile #number-view").text(res["number_view_profile"]);
					$("#View_profile .modal-body .list").html(res["response"]);
					$("#View_profile").modal();
				}else{
					alert("Error!");
				}
			},
			error:function(){
				alert("Error!");
			}

		});
		
		return false;
	});
	$(document).on("click","#View_profile #more-data",function(){
		var items = $("#View_profile .modal-body .list .media").length;
		var member_id = "<?php echo @$member_id;?>";
		$.ajax({
			url:"<?php echo base_url("profile/get_viewed_profile");?>",
			type:"post",
			dataType:"json",
			data:{member_id:member_id,items:items},
			success:function(res){
				if(res["status"] == "success"){
					if(res["show"] == false){
						$("#View_profile #more-data").hide();
					}else{
						$("#View_profile #more-data").show();
					}
					$("#View_profile #number-view").text(res["number_view_profile"]);
					$("#View_profile .modal-body .list").append(res["response"]);
				}else{
					alert("Error!");
				}
			},
			error:function(){
				alert("Error!");
			}
		});
		return false;
	});
</script>