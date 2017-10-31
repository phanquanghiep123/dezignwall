<div class="modal fade" id="View_profile_following" role="dialog">
    <div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	        <div class="modal-header">
	          	<button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
	          	<h4 class="modal-title"><b>These are the people you are following</b></h4>
	          	<span>You begin following <b class="number-view" id="number-view">0</b> more the people in the last 30 days</span>
	        </div>
	        <div class="modal-body">
	          	<div class="list">
	          	</div>
	          	<div class="row">
	          		<div class="col-sm-12 text-right"><button class="btn btn-link btn-lg upgrade-account-link">MORE</button></div>
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
	#View_profile_following .modal-dialog{width: 720px;max-width: 100%}
	#View_profile_following .modal-header{background-color: #fff;}
	#View_profile_following .modal-header .modal-title{margin-top: 10px;color: #000}
	#View_profile_following .modal-header .number-view{color: #339999;font-size: 36px;}
	#View_profile_following .modal-header {border-bottom: 2px solid #ddd}
	#View_profile_following .modal-header, #View_profile_following .modal-body, #View_profile_following .modal-footer{padding: 0px;}
	#View_profile_following .modal-content{padding: 15px;}
	#View_profile_following .modal-body h4 span,#View_profile_following .modal-body p{color: #777;font-size: 16px;}
	#View_profile_following .modal-body .list{height: 400px;overflow-x: hidden;overflow-y: auto;margin: 10px 0;padding-right: 20px;}
	#View_profile_following .modal-body .list .media{margin: 15px 0}
	#View_profile_following .modal-body .list .media:last-child{margin: 0;}
	#View_profile_following .modal-footer{border-top: 2px solid #ddd}
	#View_profile_following .day_time{color: #339999;font-size: 16px;}
	#View_profile_following span{color: #333;font-size: 16px;}
</style>
<script type="text/javascript">
    var member_id = <?php echo $member_id;?>;
	$(document).on("click","#show_number_following_profile",function(){
		$.ajax({
			url : "<?php echo base_url("profile/all_following")?>",
		    type: "post",
		    dataType : "json",
		    data : {id : member_id,ofset : 0},
		    success : function(res){
		    	if(res["status"] == "success"){
		    		$("#View_profile_following #number-view").text(res["number"]);
		    		$("#View_profile_following .list").html(res["response"]);
		    		$("#View_profile_following").modal();
		    	}else{
		    		messenger_box("Error!","An error occurred please try again");
		    	}	
		    },error : function(){
		    	messenger_box("Error!","An error occurred please try again");
		    }
		})
		
	});
</script>
