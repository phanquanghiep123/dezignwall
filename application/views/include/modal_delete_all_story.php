<!-- Modal -->
<div class="modal fade" id="modal_delete_all_story" role="dialog">
    <div class="modal-dialog">

	    <!-- Modal content-->
	    <form method="post" id="form_delete_all_story" action="">
		    <div class="modal-content">
		        <div class="modal-header">
		          	<!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
		          	<button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
		          	<h3 class="modal-title">Whoa! Are you sure ?</h3>
		        </div>
		        <div class="modal-body">    	 
		          	<p>Look live you are about to delete your story Are you sure ?</p>
		        </div>
		        <div class="modal-footer">
			          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			          <button type="submit" class="text-center btn btn-secondary relative" id="add-new-image">Delete </button>
		        </div>
	      	</div>
      	</form>
      	<!--! Modal content-->

    </div>
</div>
<!--! Modal -->

<style type="text/css">
	#modal_delete_all_story .modal-header{background-color: #339999;}
	#modal_delete_all_story .modal-header .close{text-shadow: none;}
	#modal_delete_all_story .modal-header .modal-title{color: #fff;padding-top: 15px;}
	#modal_delete_all_story .modal-body p{color: #333;}
	#modal_delete_all_story .modal-body .form-group .form-control{margin-bottom: 5px;}
	#modal_delete_all_story .modal-body .note{color: #339999;font-size: 14px;}
	#modal_delete_all_story .modal-footer{border: none;}
	#modal_delete_all_story .loadding{position: absolute; width: 100%;cursor: wait;right: 0;top: 0;bottom: 0; text-align: center;}
    #modal_delete_all_story img {max-height: 100%;max-width: 100%; margin: 0 auto;}
</style>
<script type="text/javascript">
	var photo_id = 0;
    $(document).on("click","#delete-all-story",function(){
        photo_id = $("#modal_choose_story #add-story-from [name='photo_id']").val();
        $("#modal_delete_all_story").modal(); 
    });
    $(document).on("submit","#modal_delete_all_story #form_delete_all_story",function(){
        $.ajax({
            url : "<?php echo base_url("profile/delete_all_story");?>",
            type:"post",
            dataType:"json",
            data:{photo_id : photo_id},
            success :function(res){
            	console.log(res);
            	if(res["status"] == "success"){
            		window.location.reload();
            	}else{
            		alert("Error!");
            	}
            },error:function(){
                alert("Error!");
            }
        });
        return false;
    });
     $('#modal_delete_all_story').on('hidden.bs.modal', function (e) {
        $("body").addClass("modal-open");
    });
</script>