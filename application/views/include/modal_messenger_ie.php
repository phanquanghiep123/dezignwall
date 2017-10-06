<!-- Modal -->
<div class="modal fade" id="modal_messenger_ie" role="dialog">
    <div class="modal-dialog">

	    <!-- Modal content-->
	    <form method="post" id="add_post_messenger" action="<?php echo base_url("profile/add_post_messenger")?>">
		    <div class="modal-content">
		        <div class="modal-header">
		          	<!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
		          	<button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
		          	<h3 class="modal-title">Opps! Looks like you're on IE... </h3>
		        </div>
		        <div class="modal-body">    	 
		          	<p>Internet explorer is a bit "slow". Try posting your podcast on Chrome, Firefox or another browser with a bit more speed. </p>
		        </div>
		        <div class="modal-footer">
		          	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        </div>
	      	</div>
      	</form>
      	<!--! Modal content-->

    </div>
</div>
<!--! Modal -->

<style type="text/css">
	#modal_messenger_ie .modal-dialog{width: 670px;max-width: 100%}
	#modal_messenger_ie .modal-header{background-color: #339999;}
	#modal_messenger_ie .modal-header .close{text-shadow: none;}
	#modal_messenger_ie .modal-header .modal-title{color: #fff;padding-top: 15px;}
	#modal_messenger_ie .modal-body p{color: #333;}
	#modal_messenger_ie .modal-body .form-group .form-control{margin-bottom: 5px;}
	#modal_messenger_ie .modal-body .note{color: #339999;font-size: 14px;}
	#modal_messenger_ie .modal-footer{border: none;}
	#modal_messenger_ie .loadding{position: absolute; width: 100%;cursor: wait;right: 0;top: 0;bottom: 0; text-align: center;}
    #modal_messenger_ie img {max-height: 100%;max-width: 100%; margin: 0 auto;}
</style>
<script type="text/javascript">
	$('#modal_messenger_ie').on('hidden.bs.modal', function (e) {
		$("body").addClass("modal-open");
    });
</script>