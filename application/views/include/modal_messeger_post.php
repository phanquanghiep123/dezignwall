<!-- Modal -->
<div class="modal fade" id="Personal_Message_Popup" role="dialog">
    <div class="modal-dialog">

	    <!-- Modal content-->
	    <form method="post" id="add_post_messenger" action="<?php echo base_url("profile/add_post_messenger")?>">
		    <div class="modal-content">
		        <div class="modal-header">
		          	<!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
		          	<button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
		          	<h3 class="modal-title">Post a pesonal message!</h3>
		        </div>
		        <div class="modal-body">
		          	<p>Share with the community what's on your mind</p>
		          	<div class="form-group">
		          		<input class="form-control custum solid " type="text" name="messenger" placeholder="Have fun and show your personality...">
		          		<i class="note">Maybe you’re looking for new opportunities? Maybe you just want to say something inspirational? This is your space to get creative and share!</i>
		          	</div>
		          	
		        </div>
		        <div class="modal-footer">
		          	<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
		          	<button type="submit" class="btn btn-primary relative">Save/Update</button>
		        </div>
	      	</div>
      	</form>
      	<!--! Modal content-->

    </div>
</div>
<!--! Modal -->

<style type="text/css">
	#Personal_Message_Popup .modal-dialog{width: 670px;max-width: 100%}
	#Personal_Message_Popup .modal-header{background-color: #339999;}
	#Personal_Message_Popup .modal-header .close{text-shadow: none;}
	#Personal_Message_Popup .modal-header .modal-title{color: #fff;}/*padding-top: 15px;*/
	#Personal_Message_Popup .modal-body p{color: #333;}
	#Personal_Message_Popup .modal-body .form-group .form-control{margin-bottom: 5px;}
	#Personal_Message_Popup .modal-body .note{color: #339999;font-size: 14px;}
	#Personal_Message_Popup .modal-footer{border: none;}
	#Personal_Message_Popup .loadding{position: absolute; width: 100%;cursor: wait;right: 0;top: 0;bottom: 0; text-align: center;}
    #Personal_Message_Popup img {max-height: 100%;max-width: 100%; margin: 0 auto;}
</style>
<script type="text/javascript">
	var type_data ;
	var _thiscurrent;
    $(document).ready(function(){
    	$("body #Personal_Message_Popup_show").click(function(){
    		_thiscurrent = $(this);
    		type_data = $(this).attr("data-type");
    		if(type_data == "company"){
    			$("#Personal_Message_Popup .modal-title").html("Post a company message!");
    			$("#Personal_Message_Popup [name=messenger]").attr("placeholder","Have fun and show your company...");
    		}else{
    			$("#Personal_Message_Popup .modal-title").html("Post a pesonal message!");
    			$("#Personal_Message_Popup [name=messenger]").attr("placeholder","Have fun and show your personality...");
    		}
			$("#Personal_Message_Popup").modal();
			return false;
		});

    });

    $('#Personal_Message_Popup #add_post_messenger').submit(function(){
        var _this = $(this);
        $(this).ajaxSubmit({
            beforeSubmit:function(){
                _this.find("button[type='submit']").append('<div class="loadding"><img src="<?php echo skin_url("images/loading.gif");?>"></div>');
            },
            data : {type_data : type_data},
            success:function(res){
                _this.find("button[type='submit'] .loadding").remove();
                _thiscurrent.text(_this.find("[name='messenger']").val());
                $("#Personal_Message_Popup").modal("hide");
                _this[0].reset();
            },
            error : function(){
                alert("Error!");
                _this.find("button[type='submit'] .loadding").remove();
            }
        });
        return false;
    }) ; 
	
</script>