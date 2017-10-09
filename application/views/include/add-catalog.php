<div class="group-box-add-catalog">
	<div id="modal_add_catalog" class="modal fade" role="dialog">
	    <div class="modal-dialog modal-md">
	        <div class="modal-content">
	            <button type="button" class="close" data-dismiss="modal">&times;</button>
	             <h3 class="modal-title col-md-12">Create a New Catalog</h3>
	            <form id="form-add-catalog" method="post" action="<?php echo base_url("profile/add_catalog")?>">
	                <div class="modal-body">
	                    <div class="row">
	                        <div id="messenger-error"></div>
	                        <div class="form-group box-upload">
	                            <div class="col-xs-3 col-md-2"><label id="lable-upload">
	                                <img src="<?php echo skin_url("images/upload-catalog.png");?>">
	                                <input type="hidden" class="hidden" id="url-photo-logo" name="logo">
	                                <input type="hidden" class="hidden" id="logo-name" name="logo_name">
	                                <input type="hidden" class="hidden" id="logo-type" name="logo_type">
	                            </label>
	                            <input id="file-logo" class="file none" type="file" accept="image/*">
	                            </div>
	                            <div class="col-md-4 col-xs-9">
	                            	<p style=" padding-top: 0; line-height: 1.2; padding-top: 5px; ">Click to upload your<br/>own logo or button<br/>for this catalog</p>
	                            </div>
	                            <div class="col-md-1 col-xs-12 sm-text-center">
	                            	<p style="color: #37a7a7; font-size: 25px; padding: 23px 0px; font-weight: bold;">Or</p>
	                            </div>
	                            <div class="col-md-5">
		                            <div class="content-custom-button">
		                            	<div class="box-custom-button"><a href="#" class="create-custom-button" id="click-custom-button">CUSTOM BUTTON</a></div>
		                           		<p style="text-align: center;">Create a custom button</p> 
		                           	</div>
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <label class="col-md-4">Catalog Name:</label>
	                            <div class="col-md-8"><input  type="text" class="form-control" name="title" placeholder="Give this catalog a title (one to five words)..."></div>
	                        </div>
	                        <div class="form-group">
	                            <label class="col-md-4">Catalog Description:</label>
	                            <div class="col-md-8"><input  type="text" class="form-control" name="description" placeholder="5-words or less to describe this catalog..."></div>
	                        </div>
	                        <div class="col-md-12 text-right" id="batch-upload-show"><p style="float: right;">To batch upload an entire catalog click here: <a id="upload-batch" href="#">Batch Upload</a></p></div>
	                        <div class="form-group text-right">
	                            <div class="col-md-12">
	                                <a type="button" class="btn action-bnt btn-gray" data-dismiss="modal">Cancel</a>
	                                <button type="submit" class="btn action-bnt btn-primary relative">Save/Continue</button>
	                            </div>  
	                        </div>
	                    </div>
	                </div>
	            </form>
	        </div>
	    </div>
	</div>
	<div id="modal_add_custom_button" class="modal fade" role="dialog">
	    <div class="modal-dialog modal-md">
	        <div class="modal-content not-border-radius">
	        	<div class="modal-body">
	        	    <button type="button" class="close" data-dismiss="modal">&times;</button>
	                <h3 class="modal-title col-md-12">Custom Button Maker Tool</h3>
	            	<div id="form-add-catalog">
	                    <div class="row">
	                    	<div class="col-md-8 content-cented" style="margin-top: 30px;">
	                    	    <p>Button Preview:</p>
	                    	    <div class="row">
	                    	    	<div class="col-md-11 content-cented">
			                            <div class="box-custom-button">
			                            	<a href="#" class="create-custom-button" id="change-text">CUSTOM BUTTON</a>	
			                            	<input type="text" value="CUSTOM BUTTON" id="input-change-text">
			                            </div>
		                            </div>
	                            </div>
	                    		<div class="row" id="button-preview">
	                    			<div class="col-md-5 parent-box-chose" id="box-chose-bg-button">
	                    				<div class="button-color box-data">
	                    					<p>Button Color:<span id="value-color"></span></p>
	                    				</div>
	                    				<div class="select-color-bg box-data">
	                    					<div class="bg-img"><img src="<?php echo skin_url("images/color_picker_social_image.jpg");?>"></div>
	                    				</div>
	                    				<div class="text-color box-data">
	                    					<input id="text-color-set" type="text" value="37a7a7" readonly="true" disabled="true">
	                    				</div>
	                    			</div>
	                    			<div class="col-md-2 col-xs-12" id="box-chose-font-size-button" style="position: relative;">
	                    				<a href="#" data-plus ="1" style="color: #000;float: left;font-size: 32px;margin-top: 10px;position: relative;margin-left: 5px;z-index: 999;">A</a>
	                    				<a href="#" data-plus ="-1" style="color: #000;float: left;font-size: 16px;margin-top: 10px;position: absolute;text-align: center;left: 44px;;">A</a>
	                    			</div>
	                    			<div class="col-md-5 parent-box-chose" id="box-chose-color-button">
	                    				<div class="button-color box-data">
	                    					<p>Text Color:<span id="value-color"></span></p>
	                    				</div>
	                    				<div class="select-color-bg box-data">
	                    					<div class="bg-img"><img src="<?php echo skin_url("images/color_picker_social_image.jpg");?>"></div>
	                    				</div>
	                    				<div class="text-color box-data">
	                    					<input type="text" id="text-color-set" value="ffffff" readonly="true" disabled="true">
	                    				</div>
	                    			</div>
	                    		</div>
	                    	</div>
	                        <div class="col-md-12 text-right">
	                            <a type="button" class="btn action-bnt btn-gray" data-dismiss="modal">Cancel</a>
	                            <button id="save-custom-button" type="submit" class="btn action-bnt btn-primary relative">Save/Continue</button>
	                        </div>  
	                    </div>
	                </div>
	            </div>
	            
	        </div>
	    </div>
	</div>
</div>
<style type="text/css">
    .text-color{
    	position: relative;
		float: right;
		width: 50%;
    }
    .box-custom-button{position: relative;}
    .box-custom-button #input-change-text{
    	position: absolute;
		left: 10px;
		right: 10px;
		top: 10px;
		bottom: 10px;
		border: 1px solid #000;
		width: 95%;
		height: 75%;
		text-align: center;
		display: none;
		min-height: 53px;
    }
    .bg-img{cursor: pointer;}
    #modal_add_custom_button .create-custom-button{
    	background-color: #37a7a7;
		color: #fff;
		padding: 6px 0px;
		float: left;
		font-size: 32px;
		position: relative;
		border-radius: 3px;
    }
    #modal_add_custom_button .box-custom-button {
	    background-color: #f1f1f1;
	    border: 1px solid #37a7a7;
	    padding: 10px;
	    float: left;
	    text-align: center;
	    margin-bottom: 5px;
	    border-radius: 2px;
	    margin: 0 auto;
	    width:  354px;
	    max-width: 100%;
	}
    #button-preview{margin-bottom: 30px; margin-top: 20px;}
    .text-color input{
    	font-size: 15px;
    	padding-left: 10px;
		width: auto;
		max-width: 100%;
		background-color: #f1f1f1;
		border-radius: 3px;
		border: 1px solid #000;

    }
    .box-data{margin-top: 10px;}
    .text-color:after{
    	content: "#: ";
    	position: absolute;
    	left: -20px;
    	top: 0;
    }
    .button-color #value-color{
    	width: 28px;
		height: 28px;
		background: #37a7a7;
		float: right;
		border: 1px solid #000;
		border-radius: 3px;
		
    }
    #box-chose-color-button .button-color #value-color{
    	background-color: #fff;
    }
    #lable-upload{cursor: pointer;}
    .box-upload{margin-top:20px;}
    .group-box-add-catalog .modal-title{font-size: 24px; color: #212121;}
    .group-box-add-catalog .form-group{float: left;width: 100%;}
    .group-box-add-catalog .modal-dialog{max-width: 650px; max-width: 100%;}
    button.close{
        font-size: 30px;
        color: #000;
        opacity: 1;
        position: absolute;
        right: 10px;
        top: 5px;
        z-index: 9;
    }
    .group-box-add-catalog .modal-content{border-radius: 0;}
    .loading-catalog{
    	position: absolute;
	    left: 0;
	    top: 0;
	    bottom: 0;
	    right: 0;
	    z-index: 999;
	    text-align: center;
	    cursor: wait;
    }
    .loading-catalog img {max-height: 100%;margin: 0 auto;}
    .box-custom-button{
    	background-color: #f1f1f1;
		border: 1px solid #37a7a7;
		padding: 5px;
		float: left;
		width: 100%;
		text-align: center;
		margin-bottom: 5px;
		border-radius: 2px;
    }
    .content-custom-button{
    	width: 93%;
    	float: right;
    }
    .create-custom-button{
    	background-color: #37a7a7;
    	color: #fff;
    	width: 100%;
    	padding: 2px;
    	text-align:  center;
    	float: left;
    	font-size: 22px;
    	border-radius: 3px;
    }
    #modal_add_catalog .modal-content{padding: 20px 0;}
    .group-box-add-catalog #form-add-catalog{padding: 30px 0;}
    .cp-color-picker{z-index: 99999;}
    .bg-img{background-color: transparent !important;}
    @media screen and (max-width:  768px){
    	.sm-text-center{text-align:center;}
         .content-custom-button{
            width: 100%;
            float: right;
        }
    }
</style>
<script type="text/javascript" src="<?php echo skin_url("tinyColorPicker/jqColorPicker.min.js")?>"></script>
<script src="<?php echo skin_url("htmlcanvas/promise.js");?>"></script>
<script src="<?php echo skin_url("htmlcanvas/html2canvas.js");?>"></script>
<script type="text/javascript">
    var i_reset = 0;
    $("#form-add-catalog").submit(function(){
        $("#messenger-error").html("");
        var title = $(this).find("input[name=title]").val();
        var logo = $(this).find("input[name=logo]").val();
        var description = $(this).find("input[name=description]").val().trim();
        var error = 0;
        var count = (description.match(/ /g) || []).length;
        var value_custom = $("#modal_add_custom_button #input-change-text").val();
    	
        if(logo == ""){
            error = 1;
            $("#lable-upload > img").addClass("warning");
        }else{
            $("#lable-upload > img").removeClass("warning");
        }
        if(title == ""){
            error = 1;
            $(this).find("input[name=title]").addClass("warning");
        }else{
            $(this).find("input[name=title]").removeClass("warning");
        }
        if(error == 0 && i_reset == 0){
            i_reset = 1;
            var new_this = $(this);
            new_this.find("button[type = submit].action-bnt").append("<div class='loading-catalog'><img class='loading-catalog' src='<?php echo skin_url('images/loading.gif')?>'></div>");
           	$(this).ajaxSubmit(
                {
                    dataType: "json",
                    beforeSend: function () {
                    },
                    uploadProgress: function (event, position, total, percentComplete) {
                    },
                    success: function (data) {
                        if(data["status"] == "status"){
                            var li_list = '<li> <div class="checkbox check-yelow checkbox-circle"> <input type="radio" name="manufacturers" id="manufacturers-'+data["reponse"]["id"]+'" value="'+data["reponse"]["id"]+'" checked> <label for="manufacturers-'+data["reponse"]["id"]+'"> <img src="'+base_url+data["reponse"]["logo"]+'"> </label> </div> </li>';
                            $("#upload-of-page ul").prepend(li_list);
                            var list_batch = '<li> <div class="checkbox check-yelow checkbox-circle"> <input type="radio" name="manufacturers" id="batch-manufacturers-'+data["reponse"]["id"]+'" value="'+data["reponse"]["id"]+'" checked> <label for="batch-manufacturers-'+data["reponse"]["id"]+'"> <img src="'+base_url+data["reponse"]["logo"]+'"> </label> </div> </li>';
                            $("#upload-of-batch ul").prepend(list_batch);
                            $(".catalog-box ul.list-inline").scrollTop(0);
                            $("#modal_add_catalog #form-add-catalog")[0].reset();
                            $(".box-upload #lable-upload img").attr("src",base_url+"skins/images/upload-catalog.png");
                            $("#modal_add_catalog").modal("hide");
                            $("#modal_add_catalog .box-custom-button").html('<a href="#" class="create-custom-button" id="click-custom-button">CUSTOM BUTTON</a>')
                        	$("#modal_add_custom_button .box-custom-button").html('<a href="#" class="create-custom-button" id="change-text">CUSTOM BUTTON</a><input type="text" value="CUSTOM BUTTON" id="input-change-text">');
                        	$("#modal_add_custom_button #box-chose-color-button").find("#value-color").css("background-color","#ffffff");
							$("#modal_add_custom_button #box-chose-color-button").find("#text-color-set").val("ffffff");
                        	$("#modal_add_custom_button #box-chose-bg-button").find("#value-color").css("background-color","#37a7a7");
							$("#modal_add_custom_button #box-chose-bg-button").find("#text-color-set").val("37a7a7");
                        }else{
                            $("#messenger-error").html('<p class="text-center" style="color:red;">'+data["message"]+'</p>');
                        }
                        i_reset = 0;
                        new_this.find("button[type = submit].action-bnt").find(".loading-catalog").remove();

                    },
                    complete: function (response) {
                    },
                    error: function () {
                        i_reset = 0;
                    }
                }
            ); 
        }  
        return false;
    });
    $(document).on("click",".loading-catalog",function(){
    	return false;
    });
    $(document).on("click",".box-custom-button #click-custom-button",function(){
    	$("#modal_add_custom_button").modal();
    	return false;
    });
    $(document).on("click","#change-text",function(){
    	$(this).css("opacity","0");
    	$("#input-change-text").show();
    	$("#input-change-text").focus();
    	return false;
    });
    $(document).on("blur","#input-change-text",function(event){
    	event.stopPropagation();
    	event.preventDefault() 
    	if($(this).val().trim() != ""){
    		$("#change-text").text($(this).val());
	    	$(this).hide();
	    	$("#change-text").css("opacity","1");
    	}else{
    		$("#input-change-text").addClass("warning");
    		$("#input-change-text").focus();
    		return false;
    	}
    	
    });
    var chose_1 = 0;
    var chose_2 = 0;
    var size_font = 32;
    $('#box-chose-bg-button .bg-img').colorPicker({
    	buildCallback:function($elm){
    		$(".cp-color-picker").show();
    		var value_custom = $("#modal_add_custom_button #input-change-text").val();
	    	if(value_custom.trim() == ""){
	    		$("#modal_add_custom_button #input-change-text").addClass("warning");
    			$("#modal_add_custom_button #input-change-text").show();
    			$("#modal_add_custom_button #input-change-text").focus();
	    		return false;
	    	}
    	},
    	renderCallback: function ($elm, toggled) {
    		$("#change-text").text($("#input-change-text").val());
    		$("#input-change-text").hide();
    		$("#change-text").css("opacity","1");
    		if(chose_1 != 0){
    			var colors = this.color.colors; // the whole color object
				var rgb = colors.RND.rgb; // the RGB color in 0-255
				$("#change-text").css("background-color","#"+colors.HEX);
				$("#box-chose-bg-button").find("#value-color").css("background-color","#"+colors.HEX);
				$("#box-chose-bg-button").find("#text-color-set").val(colors.HEX);
    		}
			chose_1 = 1;
		}
    });
    $("body div").not(".bg-img").click(function(e){ 
    	$(".cp-color-picker").hide();
    });
    $("body div.bg-img").click(function(e){ 
    	e.stopPropagation();
    	$(".cp-color-picker").show();
    });
    $('#box-chose-color-button .bg-img').colorPicker({
    	buildCallback:function($elm){
    		$(".cp-color-picker").show();
    		var value_custom = $("#modal_add_custom_button #input-change-text").val();
	    	if(value_custom.trim() == ""){
	    		$("#modal_add_custom_button #input-change-text").addClass("warning");
    			$("#modal_add_custom_button #input-change-text").show();
    			$("#modal_add_custom_button #input-change-text").focus();
    			return false;
	    	}
    		chose_2 = 0;
    	},
    	renderCallback: function ($elm, toggled) {
    		$("#change-text").text($("#input-change-text").val());
    		$("#change-text").css("opacity","1");
    		if(chose_2 != 0){
				var colors = this.color.colors; // the whole color object
				var rgb = colors.RND.rgb; // the RGB color in 0-255
				$("#change-text").css("color","#"+colors.HEX);
				$("#box-chose-color-button").find("#value-color").css("background-color","#"+colors.HEX);
				$("#box-chose-color-button").find("#text-color-set").val(colors.HEX);
			}
			chose_2 = 1;
		}
    });
    $(document).on("click","#box-chose-font-size-button a",function(){ 
    	var plus = $(this).attr("data-plus");
	    plus = parseInt(plus);
	    size_font = size_font + (plus); 	
    	if(size_font <= 32 && size_font >= 6){    		
    		$("#change-text").css("font-size",size_font + "px");
    	}else{
    		if(size_font > 32) size_font = 32;
	    	if(size_font < 6) size_font  = 6;
    	}
    	return false;
    });
     $(document).on("click","#save-custom-button",function(){
     	var urlData;
     	var name = $(".box-custom-button #change-text").text() + ".png";
     	var box_width = $(".box-custom-button #change-text").width();
        var box_height = $(".box-custom-button #change-text").outerHeight();
        var value_custom = $("#modal_add_custom_button #input-change-text").val();
        if(value_custom.trim() != ""){
        	$("#modal_add_custom_button #input-change-text").removeClass("warning");
        	$("#modal_add_custom_button #input-change-text").hide();
        	html2canvas($(".box-custom-button #change-text"), {
	            background:'#fff',
	            onrendered: function(canvas) {
	               urlData = canvas.toDataURL("image/png");      
	               $("#modal_add_catalog #click-custom-button").css("background-color","transparent").html('<img src="'+urlData+'">');
	               $("#modal_add_catalog #lable-upload #url-photo-logo").val(urlData);
	               $("#modal_add_catalog #lable-upload #logo-name").val(name);
	               $("#modal_add_catalog #lable-upload #logo-type").val("png");
	               $("#modal_add_custom_button").modal('hide');
	            },
	            width: box_width,
	            height: box_height
	        });
        }else{
        	$("#modal_add_custom_button #input-change-text").addClass("warning");
        	$("#modal_add_custom_button #input-change-text").show();
        	$("#modal_add_custom_button #input-change-text").focus();
        }
        
     });
    $('#modal_add_catalog').on('hidden.bs.modal', function (e) {
    	$(".group-box-add-catalog").css({"position":"relative","z-index": "auto"});
	  	$("#batch-upload-show").show();
	});
</script>