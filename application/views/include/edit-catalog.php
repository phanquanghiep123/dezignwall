<div id="modal_edit_catalog" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            	 <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4  class="modal-title col-md-12">You are in Edit Catalog mode...</h4>
            </div>
            <div class="modal-body">
	            <form id="form-add-catalog" method="post" action="<?php echo base_url("profile/edit_catalog")?>">
	                <div class="row">
	                    <div id="messenger-error"></div>
	                    <div class="form-group box-upload">
	                        <div class="col-md-12">
	                        	<div id="lable-upload">
	                        	    <div class="box-midde-logo">
	                            		<img id="logo-old" src="<?php echo skin_url("images/upload-catalog.png");?>">
	                        		</div>
	                        		<div class="profile-edit-photo banner-custom">
						                <div class="profile-action-edit">
						                    <a class="text-white" href="#" onclick="$('#file-logo').click();return false;"><i class="fa fa-3 fa-pencil"></i> <small>  Change Icon</small></a>
						                	<input id="file-logo" class="file none" type="file" accept="image/*">
						                	<input type="hidden" class="hidden" id="url-photo-logo" name="logo">
						                	<input type="hidden" class="hidden" id="logo-name" name="logo_name">
						                	<input type="hidden" class="hidden" id="logo-type" name="logo_type">
						                </div>
						            </div>
	                        		<ul class="text-right" id="list-action">
										<li><a href="#" id="remove_crop"><img src="<?php echo skin_url("images/back.png")?>"></a></li>
										<!--<li><a href="#" id="add_crop"><img src="<?php echo skin_url("images/crop-now.png")?>"></a></li>-->
									</ul>
									<div class="docs-data">
										<input type="hidden" class="form-control" id="dataX" placeholder="x">
										<input type="hidden" class="form-control" id="dataY" placeholder="y">
										<input type="hidden" class="form-control" id="dataWidth" placeholder="width">
										<input type="hidden" class="form-control" id="dataHeight" placeholder="height">
										<input type="hidden" class="form-control" id="dataRotate" placeholder="rotate">
										<input type="hidden" class="form-control" id="dataScaleX" placeholder="scaleX">
										<input type="hidden" class="form-control" id="dataScaleY" placeholder="scaleY">
									</div>
	                        	</div>
	                        	<p class="text-right" style="color:#339999;margin-top: 10px;">Icon  Size: 200 X 200 or 50 X 200 pixcels</p>
	                       	</div>
	                    </div>
	                    <div class="form-group">
	                        <label class="col-md-4">Catalog Name:</label>
	                        <div class="col-md-8"><input  type="text" id="catalog-name" class="form-control" name="title" placeholder="Give this catalog a title (one to five words)..."></div>
	                    </div>
	                    <div class="form-group">
	                        <label class="col-md-4">Catalog Description:</label>
	                        <div class="col-md-8"><input  type="text" id="catalog-description" class="form-control" name="description" placeholder="5-words or less to describe this catalog..."></div>
	                    </div>
	                    <div class="form-group text-right">
	                        <div class="col-md-12 docs-buttons">
	                            <input type="hidden" name="id" id="catalog-id" value="null">
	                            <a type="button" class="btn action-bnt btn-gray" data-dismiss="modal">Cancel</a>
	                            <button type="submit" class="btn btn-primary" data-method="getCroppedCanvas">
						            <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="$().cropper(&quot;getCroppedCanvas&quot;)">
						              Save/Update
						            </span>
			        			</button>
	                        </div>  
	                    </div>
	                </div>             
	            </form>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
    .box-upload{margin-top:20px;}
    #modal_edit_catalog .form-group { float: left;  width: 100%; margin-bottom: 15px; }
    #modal_edit_catalog .form-group{float: left;width: 100%;}
    #modal_edit_catalog .modal-content{border-radius: 10px !important;}
    body #modal_edit_catalog .modal-dialog{width: auto; max-width: 650px;}
    body #modal_edit_catalog .modal-title {color: #ff9900; font-size: 24px; margin-bottom: 0;}
    button.close{
        font-size: 30px;
        color: #000;
        opacity: 1;
        position: absolute;
        right: 10px;
        top: 5px;
        z-index: 9;
    }
    #modal_edit_catalog  #lable-upload{
    	min-height: 526px;
	    padding: 4px;
	    border: 1px solid #339999;
	    display: table;
	    vertical-align: middle;
	    max-width: 618px;
	    width: 100%;
	    background: rgba(204, 204, 204, 0.34);
	    position: relative;
    }
    #modal_edit_catalog #lable-upload img#logo-old{max-width: 618px;}
    #list-action {
		position: absolute;
		right: 15px;
		bottom: 0;
	}
	#modal_edit_catalog
	#list-action li {
		display: inline;
		list-style: none;
	}
	#modal_edit_catalog #logo-old{margin: 0 auto;}
    #modal_edit_catalog .box-midde-logo:hover ~ .profile-edit-photo{display: block;}
    #modal_edit_catalog .box-midde-logo{display: table-cell; vertical-align: middle;}
    #modal_edit_catalog .box-midde-logo img{display: table-cell; vertical-align: middle;}
    #modal_edit_catalog .modal-header {
	    border-top-left-radius: 5px;
	    border-top-right-radius: 5px;
	    background-color: #e5e5e5;
	    padding: 10px 15px;
	    float: left;
	    width: 100%;
	}
    #modal_edit_catalog .modal-dialog{ma}
	@media screen and ( max-width:  768px){
		#modal_edit_catalog #lable-upload .profile-action-edit{display: block;}
		#modal_edit_catalog #lable-upload img#logo-old{max-width: 100%}
		#modal_edit_catalog #lable-upload{max-width: 100%;}
	}
</style>
<script type="text/javascript">
    var i_reset = 0;
    $("#form-add-catalog").submit(function(){
        $("#messenger-error").html("");
        var title = $(this).find("input[name=title]").val();
        var logo = $(this).find("input[name=logo]").val();
        var description = $(this).find("input[name=description]").val().trim();
        var error = 0;
        var count = (description.match(/ /g) || []).length;
        if(title == ""){
            error = 1;
            $(this).find("input[name=title]").addClass("warning");
        }else{
            $(this).find("input[name=title]").removeClass("warning");
        }
        if(error == 0 && i_reset == 0){
            i_reset = 1;
           $(this).ajaxSubmit(
                {
                    dataType: "json",
                    beforeSend: function () {
                    },
                    uploadProgress: function (event, position, total, percentComplete) {
                    },
                    success: function (data) {
                        console.log(data);
                        if(data["status"] == "status"){
                            location.reload();
                        }else{
                            $("#messenger-error").html('<p class="text-center" style="color:red;">'+data["message"]+'</p>');
                        }
                        i_reset = 0;

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
    $(document).on("change","#modal_edit_catalog #file-logo[type = file]",function(){
        reader_file($("#modal_edit_catalog"),$(this)[0],$("#modal_edit_catalog #lable-upload img"));
    });
</script>

<link rel="stylesheet" href="<?php echo skin_url();?>/jquey_corpper/dist/cropper.css">
<link rel="stylesheet" href="<?php echo skin_url();?>/jquey_corpper/demo/css/main.css">
<script src="<?php echo skin_url();?>/jquey_corpper/dist/cropper.js"></script>
<script type="text/javascript">
	var box_current = $("#modal_edit_catalog");
	var p = $("#modal_edit_catalog #logo-old");
	var $dataX = $('#dataX');
	var $dataY = $('#dataY');
	var $dataHeight = $('#dataHeight');
	var $dataWidth = $('#dataWidth');
	var $dataRotate = $('#dataRotate');
	var $dataScaleX = $('#dataScaleX');
	var $dataScaleY = $('#dataScaleY');
	var max_w = $(window).width() - 50;
	var URL = window.URL || window.webkitURL;
  	var blobURL;
  	var options = {
		preview: '.img-preview',
		autoCrop:false,
		background:false,
		movable:false,
		scalable:true,
		zoomable:false,
		dragMode:"none",
		zoom:1,
		crop: function(e) {
			$dataX.val(Math.round(e.x));
			$dataY.val(Math.round(e.y));
			$dataHeight.val(Math.round(e.height));
			$dataWidth.val(Math.round(e.width));
			$dataRotate.val(e.rotate);
			$dataScaleX.val(e.scaleX);
			$dataScaleY.val(e.scaleY);
		}
	};
	$(document).on("click",".manufacturers .action #edit",function(){
		p.cropper('destroy');
        var id = $(this).data("id");
        var url_img = $(this).parents("li").find(" > img").attr("src");
        p.attr("src",url_img);
        $("#modal_edit_catalog #catalog-id").val(id);
        $.ajax({
            url:base_url+"profile/get_manufacturers",
            type:"post",
            dataType:"json",
            data:{"id":id},
            success:function(data){
                if(data["status"]){
                    $("#modal_edit_catalog #catalog-name").val(data["reponse"]["name"]);
                    $("#modal_edit_catalog #catalog-description").val(data["reponse"]["description"]);
                    $("#modal_edit_catalog").modal();
                }else{
                    alert("Error");
                }
                
            }
        });
    });
	$(document).on("click", "#list-action #add_crop", function() {
		var img = new Image();
		img.onload = function () {
		    p.cropper(options);
		    var zom_data = p.cropper('getCanvasData');
		}
		img.src = p.attr("src");
		return false;
	});
	$(document).on("click", "#list-action #remove_crop", function() {
	    p.cropper(options);
	    setTimeout(function(){ p.cropper('rotate', 45); }, 500);		
	    return false;
	});
    var type_img = "";
	function reader_file(box_edit, input_file, ojb_show) {
		p.cropper('destroy');
		box_current = box_edit;
		var file = input_file.files[0];
		var reader = new FileReader();
		reader.addEventListener("load", function() {
			var img = new Image();
			img.onload = function() {
				p.attr("src", reader.result);
				$("#crop-logo-catalog").modal();
				blobURL = URL.createObjectURL(file);
				box_current.find("#url-photo-logo").val(reader.result);
				box_current.find("#logo-name").val(file.name);
				type_img = "image/png" ;
				$("#modal_edit_catalog #loading-custom").hide();
			};
			img.src = reader.result;
		}, false);
		if(file) {
			reader.readAsDataURL(file);
		}
	}
	$('.docs-buttons').on('click', '[data-method]', function() {
		var $this = $(this);
		var data = $this.data();
		var $target;
		var result;
		if(p.data('cropper') && data.method) {
			data = $.extend({}, data); // Clone a new one
			result = p.cropper(data.method, data.option, data.secondOption);
			if(result) {
				// Bootstrap's Modal
				var blobBin = atob(result.toDataURL(type_img).split(',')[1]);
				var array = [];
				for(var i = 0; i < blobBin.length; i++) {
				    array.push(blobBin.charCodeAt(i));
				}
				var file = new Blob([new Uint8Array(array)], {type: type_img});
  				blobURL = URL.createObjectURL(file);
				p.cropper('destroy');
				p.attr ("src",blobURL);
				box_current.find("#url-photo-logo").val(result.toDataURL(type_img));
			}
			if($.isPlainObject(result) && $target) {
				try {
					$target.val(JSON.stringify(result));
				} catch(e) {
					console.log(e.message);
				}
			}
		}
	});
</script>