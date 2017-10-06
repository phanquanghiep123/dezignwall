<div class="modal fade" id="View_profile_follow" role="dialog">
    <div class="modal-dialog">
	    <!-- Modal content-->
	    <div class="modal-content">
	        <div class="modal-header">
	          	<button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
	          	<h4 class="modal-title"><b>Who's follow profile</b></h4>
	          	<p class="number-view"><b id="number-view"></b> <span> Profile views in the last 90 days</span></p>
	        </div>
	        <div class="modal-body">
	          	<div class="list">
	          	</div>
	          	<div class="row">
	          		<div id="more-followers" class="col-sm-12 text-right"><a href="javascript:;" class="btn btn-link btn-lg">MORE</a></div>
	          	</div>
	        </div>
	        
      	</div>
      	<!--! Modal content-->

    </div>
</div>
<script type="text/javascript">
    var member_id = <?php echo $member_id;?>;
	$(document).on("click","#show_number_follower_profile",function(){
		$.ajax({
			url : "<?php echo base_url("profile/all_follower_profile")?>",
		    type: "post",
		    dataType : "json",
		    data : {id : member_id,ofset : 0},
		    success : function(res){
		    	if(res["status"] == "success"){
		    		$("#View_profile_follow #number-view").text(res["number"]);
		    		$("#View_profile_follow .list").html(res["response"]);
		    		$("#View_profile_follow").modal();
		    	}else{
		    		messenger_box("Error!","An error occurred please try again");
		    	}	
		    },error : function(){
		    	messenger_box("Error!","An error occurred please try again");
		    }
		})
		
	});
</script>

<style type="text/css">
	.remove-margin{margin: 0!important}
	.remove-padding{padding: 0!important}
	#View_profile_follow .modal-dialog{width: 720px;max-width: 100%}
	#View_profile_follow .modal-header{background-color: #fff;}
	#View_profile_follow .modal-header .modal-title{margin-top: 10px;color: #000}
	#View_profile_follow .modal-header .number-view{color: #339999;font-size: 36px;}
	#View_profile_follow .modal-header {border-bottom: 2px solid #ddd}
	#View_profile_follow .modal-header, #View_profile_follow .modal-body, #View_profile_follow .modal-footer{padding: 0px;}
	#View_profile_follow .modal-content{padding: 15px;}
	#View_profile_follow .modal-body h4 span,#View_profile_follow .modal-body p{color: #777;font-size: 16px;}
	#View_profile_follow .modal-body .list{height: 400px;overflow-x: hidden;overflow-y: auto;margin: 10px 0;padding-right: 20px;}
	#View_profile_follow .modal-body .list .media{margin: 15px 0}
	#View_profile_follow .modal-body .list .media:last-child{margin: 0;}
	#View_profile_follow .modal-footer{border-top: 2px solid #ddd}
	#View_profile_follow .day_time{color: #339999;font-size: 16px;}
	#View_profile_follow span{color: #333;font-size: 16px;}
</style>