<div id="modal_view_story" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content not-border-radius">
        	<div class="modal-body">
        	    <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="row content-album">
                	<div id="scrollbars-dw">
                		<ul class="slider-story"></ul>
                	</div>
                </div>
            </div>           
        </div>
    </div>
</div>
<style type="text/css">
    #modal_view_story audio{
	    width: 100%;
	}
	#modal_view_story .not-border-radius{border-radius: 0;}
	#modal_view_story .media_url{text-align:  center;max-height: 100%;}
	#modal_view_story .media_url img{margin: 0 auto;}
	#modal_view_story video{width: 100%; float: left;}
	#modal_view_story .items-data{
		-webkit-box-shadow: -3px 3px 5px -2px rgba(0,0,0,0.75);
	    -moz-box-shadow: -3px 3px 5px -2px rgba(0,0,0,0.75);
	    box-shadow: -3px 3px 5px -2px rgba(0,0,0,0.75);
	    margin-bottom:  10px;
	}
	#modal_view_story{
		-webkit-box-shadow: -3px 3px 5px -2px rgba(0,0,0,0.75);
	    -moz-box-shadow: -3px 3px 5px -2px rgba(0,0,0,0.75);
	    box-shadow: -3px 3px 5px -2px rgba(0,0,0,0.75);
	    margin-bottom:  10px;
	}
	#modal_view_story #scrollbars-dw{overflow:  hidden;}
	#modal_view_story .items-data .description{margin-top: 7px;}
	#modal_view_story .items-data .description p{text-align: left;}
	#modal_view_story .items-data .single-image{width: 100%; text-align: center;}
	#modal_view_story #scrollbars-dw{float: left;width: 100%;margin-top: 10px;}
	#modal_view_story .text-comment{text-align: left; font-size: 12px; margin-top: 10px;}
	#modal_view_story .slider-story > li .box-story-slider{overflow-y: auto;}

	#modal_view_story .slider-story > li .box-story-slider::-webkit-scrollbar {
	    width: 5px;
	}
	#modal_view_story .slider-story > li .box-story-slider::-webkit-scrollbar-track {
	    -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
	    border-radius: 2px;
	}
	#modal_view_story .slider-story > li .box-story-slider::-webkit-scrollbar-thumb {
	    border-radius: 2px;
	    -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.5);
	}
	#modal_view_story .bx-wrapper .bx-viewport {
	    -moz-box-shadow: none;
	    -webkit-box-shadow: none;
	    box-shadow: none;
	    border: none;
	    left: 0;
	    background: #fff;
	    -webkit-transform: translatez(0);
	    -moz-transform: translatez(0);
	    -ms-transform: translatez(0);
	    -o-transform: translatez(0);
	    transform: translatez(0);
	}
	#modal_view_story .bx-wrapper .bx-prev{
		background-image:url(<?php echo base_url('skins/images/story-icon.png');?>);
		width: 50px;
	    height: 50px;
	    background-size: contain;
	    background-position: 0; 
	}
	#modal_view_story .bx-wrapper .bx-next{
		background-image:url(<?php echo base_url('skins/images/story-icon.png');?>);
		width: 50px;
	    height: 50px;
	    background-size: contain;
	    background-position: 0; 
	}
	#modal_view_story .box-story-slider{padding: 0 15px;}
	#modal_view_story .modal-body .close{
		position: absolute;
	    right: 5px;
	    top: 5px;
	    z-index: 9999;
	}
	#modal_view_story .modal-body .image-video .bottom-slider{
		position: absolute;
	    left: 0px;
	    right: 0px;
	    background-color: rgba(93, 93, 93, 0.67);
	    bottom: 0;
	    padding: 0 9px 10px;
	    color: #fff !important;
	} 
</style>
<script type="text/javascript">
	var sliderstory = null;
	var current_slider = 0;
	$(document).on("click","#modal_view_story .bx-controls-direction .bx-prev",function(){
		current_slider --;
		if(current_slider < 0){
    		$("#modal_view_story").modal("hide");
    		current_slider = 0;
    	} 
	});
	$(document).on("click","#modal_view_story .bx-controls-direction .bx-next",function(){
		current_slider ++;
    	var item = $("#modal_view_story .slider-story > li").length;
    	if(current_slider >= item){
    		$("#modal_view_story").modal("hide");
    		current_slider = 0;
    	}
	});
	$(document).on("click",".view-story img",function(){
		var photo_id = $(this).parents("#wrapper-impormant-image").attr("data-id");
		var height_document = $(window).height() - 90;
		if(typeof photo_id !== "undefined"){
			$("#modal_view_story #scrollbars-dw ul.slider-story").html('');
			$("#modal_view_story #scrollbars-dw").css("height",height_document + "px");
			$("#modal_view_story").modal();
			$.ajax({
				url:base_url + "photos/get_story",
				type:"post",
				dataType:"json",
				data:{id:photo_id},
				success:function(data){
					if(data["status"]== "success"){
						$("#modal_view_story #scrollbars-dw ul.slider-story").html(data["response"]);
						$("#modal_view_story .slider-story > li .box-story-slider").css("height",height_document+"px");
						if(sliderstory == null){
							sliderstory = $("#modal_view_story #scrollbars-dw ul.slider-story").bxSlider({
					            auto: false,
					            minSlides: 1,
					            maxSlides:1,
					            pager:false, 
					            infiniteLoop:false,
					            onSliderLoad:function($slideElement, oldIndex, newIndex){
					            	if(screen.width > 768){
					            		if($("#modal_view_story .slider-story li:eq(0)").find("video").length > 0)
					            			$("#modal_view_story .slider-story li:eq(0)").find("video")[0].play();
					            	}
					            	
					            },
					            onSlideBefore:function($slideElement, oldIndex, newIndex){ 			
				            		$.each ($("#modal_view_story video"),function(){
				            			$(this)[0].pause();
				            		});          	
					            },
					            onSlideAfter :function($slideElement, oldIndex, newIndex){
					            	if(screen.width > 768){
					            		if($($slideElement).find("video").length > 0)
					            			$($slideElement).find("video")[0].play();
					            	}
					            }
					        }); 
						}else{
							sliderstory.reloadSlider();
						}
						
					}else{
						alert("Error");
					}
				},error:function(){
					alert("Error");
				}
			});
		}
		
	});
	$('#modal_view_story').on('hidden.bs.modal', function (e) {
		current_slider = 0;
		$.each ($("#modal_view_story video"),function(){
			$(this)[0].pause();
		});
	});
</script>