<div class="modal fade" id="crop-logo-catalog" tabindex="1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<form method="POST" action="" enctype="multipart/form-data" id="cropimage">
				<div class="modal-header box-cyan text-white">
					<button type="button" class="close" data-dismiss="modal">x</button>
					<h4 class="modal-title" id="modal-label">Crop logo catalog</h4>
				</div>
				<div class="modal-body" style="position: relative;">
					<div class="row">
						<div class="col-md-12">
						    <div id="lable-upload">
								<div id="loading-custom" class="custom-loading"><img width="48" src="<?php echo skin_url(); ?>/images/loading.gif"></div>
								<div class="box-midde-logo">
									<img id="catalog_uploadPreview" src="">
								</div>
							</div>
							<ul class="text-right" id="list-action">
								<li><a href="#" id="remove_crop"><img src="<?php echo skin_url("images/back.png")?>"></a></li>
								<li><a href="#" id="add_crop"><img src="<?php echo skin_url("images/crop-now.png")?>"></a></li>
							</ul>
						</div>
						<div class="docs-data">
							<canvas id="new_canvas_images" width="500" height="500"></canvas>
						</div>
					</div>
				</div>
				<div class="modal-footer text-right docs-buttons">
					<button class="btn btn-gray" class="close" data-dismiss="modal" aria-label="Close">Cancel</button>

					<button type="button" class="btn btn-primary" data-method="getCroppedCanvas">
			            <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="$().cropper(&quot;getCroppedCanvas&quot;)">
			              Save
			            </span>
			        </button>
				</div>
			</form>
		</div>
	</div>
</div>
<style type="text/css">
    #crop-logo-catalog .modal-dialog{
    	max-width: 602px;
    	max-width: 100%;
    }
	#list-action {
		position: absolute;
		right: 15px;
		bottom: 0;
		z-index: 99;
	}
	
	#list-action li {
		display: inline;
		list-style: none;
	}
	#crop-logo-catalog .modal-footer .btn {margin-bottom: auto;}
	#crop-logo-catalog #lable-upload {
	    height: 570px;
	    padding: 4px;
	    border: 1px solid #339999;
	    display: table;
	    vertical-align: middle;
	    width: 570px;
	    background: rgba(204, 204, 204, 0.34);
	    position: relative;
	    overflow: hidden;
	}
	#crop-logo-catalog .box-midde-logo {
	    display: table-cell;
	    vertical-align: middle;
	    text-align: center;
	}
	#crop-logo-catalog #catalog_uploadPreview {
   		margin: 0 auto;
   		max-height: 570px;
   		max-width: 570px;
	}
</style>
<link rel="stylesheet" href="<?php echo skin_url();?>/jquey_corpper/dist/cropper.css">
<link rel="stylesheet" href="<?php echo skin_url();?>/jquey_corpper/demo/css/main.css">
<script src="<?php echo skin_url();?>/jquey_corpper/dist/cropper.js"></script>
<script type="text/javascript">
	var box_current = null;
	var p = $("#crop-logo-catalog #catalog_uploadPreview");
	var URL = window.URL || window.webkitURL;
  	var blobURL;
  	var scale = 0;
	var img_w = 0, img_h = 0;
	var df_w = 0 , df_h = 0;
	var x = 0;
	var y = 0;
	var scale_x = 1;
	var scale_y = 1;
	var md_h;
	var md_w;
	var toggle = false;
	var rotate = 0;
	$('#crop-logo-catalog').on('hidden.bs.modal', function () {
	    $("body").addClass("modal-open");
	});
	/*$(document).on("click", "#list-action #add_crop", function() {
		toggle = !toggle;
		if(toggle){
			img_h = img_h < 570 ? 570 : img_h;
			img_w = img_w < 570 ? 570 : img_w;	
			$("#catalog_uploadPreview").css({"max-width":"inherit","max-height":"inherit","min-width":img_w+"px","min-height":img_h+"px"});
			img_w = $("#catalog_uploadPreview").width();
			img_h = $("#catalog_uploadPreview").height();
			md_h = 570/2 - (img_h/2);
			md_w = 570/2 - (img_w/2);
			$(".box-midde-logo").css({"position":"absolute","top":md_h+"px","left":md_w+"px"});
			x = md_w;
			y = md_h;
		}else{
			$("#catalog_uploadPreview").css({"max-width":"100%","min-width":"inherit","min-height":"inherit"});
			$(".box-midde-logo").css({"position":"static","top":"auto","left":"auto"});
			x = 0;
			y = 0;
		}
		return false;
	});
	$(document).on("click", "#list-action #remove_crop", function() {
		rotate = rotate + 45;
		if(rotate > 180) rotate = 0;
		if(rotate > 0 && rotate != 180 ){
			x = md_h;
			y = md_w;
		}
		$("#catalog_uploadPreview").rotate(rotate);
		return false;
	});*/
	$.fn.rotate = function(degrees) {
	    $(this).css({'transform' : 'rotate('+ degrees +'deg)'});
	    return $(this);
	};
    var type_img = "";
    var submit = false;
	function reader_file(box_edit, input_file, ojb_show,data) {
		p.cropper('destroy');
		submit = data;
		box_current = box_edit;
		var file = input_file.files[0];
		var reader = new FileReader();
		var width_box = $("#crop-logo-catalog .modal-dialog").width();
		width_box = (width_box * 7) / 10;
		reader.addEventListener("load", function() {
			var img = new Image();
			img.onload = function() {
				img_w = this.width;
				img_h = this.height;
				df_w = this.width; 
				df_h = this.height;
				p.attr("src", reader.result);
				//$("#crop-logo-catalog").modal();
				blobURL = URL.createObjectURL(file);
				box_current.find("#url-photo-logo").val(reader.result);
				box_current.find("#logo-name").val(file.name);
				box_current.find("#lable-upload img").attr("src",blobURL);
				type_img = "image/png" ;
				//$("#crop-logo-catalog #loading-custom").hide();
			};
			img.src = reader.result;
		}, false);
		if(file) {
			reader.readAsDataURL(file);
		}
	}
	$('.docs-buttons').on('click', '[data-method]', function() {
		var canvas  = document.getElementById("new_canvas_images");
		var img  = document.getElementById("catalog_uploadPreview");
		var context = canvas.getContext('2d');
		scale_x = img.width/df_w;
		scale_y = img.height/df_h;
		data = {
			naturalWidth : df_w,
			naturalHeight : df_h,
			rotate : rotate,
			scaleX :scale_x,
			scaleY :scale_y,
			x      : x,
			y      : y,
			toggle : toggle  
		}
		var data_canvas = getSourceCanvas(canvas,img,data);
		console.log(data);
	});
	function getSourceCanvas(canvas,image, data) {
	    var canvas = canvas;
	    var context = canvas.getContext('2d');
	    var width = data.naturalWidth;
	    var height = data.naturalHeight;
	    var rotate = data.rotate;
	    var scaleX = data.scaleX;
	    var scaleY = data.scaleY;
	    var scalable = isNumber(scaleX) && isNumber(scaleY) && (scaleX !== 1 || scaleY !== 1);
	    var rotatable = isNumber(rotate) && rotate !== 0;
	    var advanced = rotatable || scalable;
	    var canvasWidth = width;
	    var canvasHeight = height;
	    var translateX;
	    var translateY;
	    var rotated;
	    if (scalable) {
	      translateX = width / 2;
	      translateY = height / 2;
	    }
	    if (rotatable) {
		    rotated = getRotatedSizes({
		        width: width,
		        height: height,
		        degree: rotate
		    });
		    canvasWidth = rotated.width;
		    canvasHeight = rotated.height;
		    translateX = rotated.width / 2;
		    translateY = rotated.height / 2;
		}
		
	   
	    if (advanced) {
			x = -width / 2;
			y = -height / 2;
			context.save();
			context.translate(translateX, translateY);
	    }

	    if (rotatable) {
	      context.rotate(rotate * Math.PI / 180);
	    }
	    // Should call `scale` after rotated
	    if (scalable) {
	      context.scale(scaleX, scaleY);
	    }
	    if(!toggle){
	    	alert("1");
			canvasWidth  = 570;
	    	canvasHeight = 570;
	    	x = (width/2) - (570/2);
	    	y = (height/2) - (570/2);
		}
		canvas.width = canvasWidth;
	    canvas.height = canvasHeight;
	    console.log(x);
	    console.log(y);
	    context.drawImage(image, x, y, 570, 570);
	    if (advanced) {
	      context.restore();
	    }

	    return canvas;
  	}
  	function isNumber(n) {
	    return typeof n === 'number' && !isNaN(n);
	  }

	function isUndefined(n) {
	    return typeof n === 'undefined';
	}
	function getRotatedSizes(data, isReversed) {
	    var deg = Math.abs(data.degree) % 180;
	    var arc = (deg > 90 ? (180 - deg) : deg) * Math.PI / 180;
	    var sinArc = Math.sin(arc);
	    var cosArc = Math.cos(arc);
	    var width = data.width;
	    var height = data.height;
	    var aspectRatio = data.aspectRatio;
	    var newWidth;
	    var newHeight;
	    if (!isReversed) {
	      newWidth = width * cosArc + height * sinArc;
	      newHeight = width * sinArc + height * cosArc;
	    } else {
	      newWidth = width / (cosArc + sinArc / aspectRatio);
	      newHeight = newWidth / aspectRatio;
	    }

	    return {
	      width: newWidth,
	      height: newHeight
	    };
	}
</script>