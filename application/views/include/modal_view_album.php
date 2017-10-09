<div id="modal_view_album" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content not-border-radius">
        	<div class="modal-body">
        	    <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="row content-album">
                	<div id="scrollbars-dw"></div>
                </div>
            </div>           
        </div>
    </div>
</div>
<style type="text/css">
	#modal_view_album .not-border-radius{border-radius: 0;}
	#modal_view_album .items-data{
		-webkit-box-shadow: -3px 3px 5px -2px rgba(0,0,0,0.75);
	    -moz-box-shadow: -3px 3px 5px -2px rgba(0,0,0,0.75);
	    box-shadow: -3px 3px 5px -2px rgba(0,0,0,0.75);
	    margin-bottom:  10px;
	}
	#modal_view_album{
		-webkit-box-shadow: -3px 3px 5px -2px rgba(0,0,0,0.75);
	    -moz-box-shadow: -3px 3px 5px -2px rgba(0,0,0,0.75);
	    box-shadow: -3px 3px 5px -2px rgba(0,0,0,0.75);
	    margin-bottom:  10px;
	}
	#modal_view_album .items-data .description{margin-top: 7px;}
	#modal_view_album .items-data .description p{text-align: left;}
	#modal_view_album .items-data .single-image{width: 100%; text-align: center;}
	#modal_view_album #scrollbars-dw{float: left;width: 100%;margin-top: 10px;}
	#modal_view_album .text-comment{text-align: left; font-size: 12px; margin-top: 10px;}
</style>
<script type="text/javascript">
	$(document).on("click","#wrapper-impormant-image .number-same-photo p span",function(){
		_this = $(this);
		var base_url_photo = _this.parents("#wrapper-impormant-image").find(".card-image .relative > a").attr("href");
		var hieght_document = $(window).height();
		hieght_document = hieght_document - 100;
		var photo_id = _this.parents("#wrapper-impormant-image").attr("data-id");
		if(typeof photo_id !== "undefined"){
			$.ajax({
				url 		: base_url + "photos/get_album",
				type 		: "post",
				dataType 	:"json",
				data 		: {"photo_id" : photo_id},
				success		: function(response){
					if(response["status"] == "success"){
						var html = "";
						$.each(response["response"]["album"],function(key,value){
							html += '<div class="col-md-12 items-data" id="number-scroll-'+key+'"><div class="single-image"><a href="'+base_url_photo+'?number='+btoa(key)+'"><img src="'+base_url + value["path"] +'" title="'+value["title"]+'"></a>';
							html += '       <div><p class="text-comment">';
                            var text = value["title"]
                            if (text.length <= 100) {
                                html += '<span>' + text + '</span>';
                            } else {
                                html += '   <span class="comment-item-text default-show block">' + text.slice(0, 100) + '<span class="more" id="more-comment"> MORE...</span></span>';
                                html += '   <span class="comment-item-text default-hie">' + text + '<span class="more" id="more-comment"> LESS</span></span>';
                            }
                            html += "</p>";
                            html += '</div></div></div>';
						});
						$("#modal_view_album .content-album #scrollbars-dw").css("height",hieght_document+"px")
						$("#modal_view_album .content-album #scrollbars-dw").html(html);
						$("#modal_view_album").modal();
					}
				},
				error 		: function(error){

				}
			})
		}
		return false;
	});
	$(document).on("click","#see-same-photo",function(){
		_this = $(this);
		var hieght_document = $(window).height();
		hieght_document = hieght_document - 100;
		var photo_id = _this.parents("#wrapper-impormant-image").attr("data-id");
		var index_data = _this.attr("data-index");
		if(typeof photo_id !== "undefined"){
			$.ajax({
				url 		: base_url + "photos/get_same",
				type 		: "post",
				dataType 	:"json",
				data 		: {"photo_id" : photo_id},
				success		: function(response){
					if(response["status"] == "success"){
						var html = "";
						$.each(response["response"]["same"],function(key,value){
							html += '<div class="col-md-12 items-data" id="number-scroll-'+key+'"><div class="single-image"><a href="'+base_url+'photos/'+value["photo_id"]+'/'+to_slug(value["name"])+'.html"><img src="'+base_url + value["path_file"] +'" title="'+value["name"]+'"></a>';
							html += '       <div><p class="text-comment">';
                            var text = value["name"];
                            if (text.length <= 100) {
                                html += '<span>' + text + '</span>';
                            } else {
                                html += '   <span class="comment-item-text default-show block">' + text.slice(0, 100) + '<span class="more" id="more-comment"> MORE...</span></span>';
                                html += '   <span class="comment-item-text default-hie">' + text + '<span class="more" id="more-comment"> LESS</span></span>';
                            }
                            html += "</p>";
                            html += '</div></div></div>';
						});
						$("#modal_view_album .content-album #scrollbars-dw").css("height",hieght_document+"px")
						$("#modal_view_album .content-album #scrollbars-dw").html(html);
						$("#modal_view_album").modal();
						setTimeout(function(){
				            $("#modal_view_album #scrollbars-dw").scrollTo("#modal_view_album #scrollbars-dw #number-scroll-"+index_data+"");
				        },500);
					    

					}
				},
				error : function(error){

				}
			})
		}
		return false;
	});
	$(document).on("click","#view-item-album",function(){
		_this = $(this);
		var base_url_photo = _this.parents("#wrapper-impormant-image").find(".card-image .relative > a").attr("href");
		var hieght_document = $(window).height();
		hieght_document = hieght_document - 100;
		var photo_id = _this.parents("#wrapper-impormant-image").attr("data-id");
		var index_data = _this.attr("data-index");
		if(typeof photo_id !== "undefined"){
			$.ajax({
				url 		: base_url + "photos/get_album",
				type 		: "post",
				dataType 	:"json",
				data 		: {"photo_id" : photo_id},
				success		: function(response){
					if(response["status"] == "success"){
						var html = "";
						$.each(response["response"]["album"],function(key,value){
							html += '<div class="col-md-12 items-data" id="number-scroll-'+key+'"><div class="single-image"><a href="'+base_url_photo+'?number='+btoa(key)+'"><img src="'+base_url + value["path"] +'" title="'+value["title"]+'"></a>';
							html += '       <div><p class="text-comment">';
                            var text = value["title"]
                            if (text.length <= 100) {
                                html += '<span>' + text + '</span>';
                            } else {
                                html += '<span class="comment-item-text default-show block">' + text.slice(0, 100) + '<span class="more" id="more-comment"> MORE...</span></span>';
                                html += '<span class="comment-item-text default-hie">' + text + '<span class="more" id="more-comment"> LESS</span></span>';
                            }
                            html += "</p>";
                            html += '</div></div></div>';
						});
						$("#modal_view_album .content-album #scrollbars-dw").css("height",hieght_document+"px")
						$("#modal_view_album .content-album #scrollbars-dw").html(html);
						$("#modal_view_album").modal();
						setTimeout(function(){
				            $("#modal_view_album #scrollbars-dw").scrollTo("#modal_view_album #scrollbars-dw #number-scroll-"+index_data+"");
				        },500);
					}
				},
				error : function(error){

				}
			})
		}
		return false;
	});
	jQuery.fn.scrollTo = function(elem) { 
	    $(this).scrollTop($(this).scrollTop() - $(this).offset().top + $(elem).offset().top); 
	    return this; 
	};
</script>