<?php // “style” id = [3].?>
<div class="main" style="position:relative;width:100%">
    <!--<div class="form-group">
    	<p><strong>Search keyword ID by Text</strong></p>
    	<ul class="tag tagit ui-widget ui-widget-content ui-corner-all" data-type ="keyword" id="tag-style" data-root = "3">
			<li class="tagit-new"><input type="text" class="ui-widget-content ui-autocomplete-input" autocomplete="off"></li>
		</ul>
    </div>-->
	<div class="form-group">
	    <p><strong>What “style” best describes this image:</strong></p>
	    <ul class="tag tagit ui-widget ui-widget-content ui-corner-all" data-type ="category" id="tag-style" data-root = "3">
			<li class="tagit-new"><input type="text" class="ui-widget-content ui-autocomplete-input" autocomplete="off"></li>
		</ul>
		<input type="hidden" id="style" class="required value" data-for ="tag-style"/>
	</div>
	<?php // “category” id = [9,192].?>
	<div class="form-group">
	   <p><strong>What “category” best describes this image:</strong></p>
	    <ul class="tag tagit ui-widget ui-widget-content ui-corner-all" data-type ="category" id="tag-category" data-root = "9,192">
	    	<li class="tagit-new"><input type="text" class="ui-widget-content ui-autocomplete-input" autocomplete="off"></li>
		</ul>
		<input type="hidden" id="category" class="required value" data-for ="tag-category"/>                              
	</div>
	<?php // “location” id = [215].?>
	<div class="form-group">
	   <p><strong>What “location” best describes this image:</strong></p>
	    <ul class ="tag tagit ui-widget ui-widget-content ui-corner-all" data-type ="category" id="tag-location" data-root = "215">
			<li class="tagit-new"><input type="text" class="ui-widget-content ui-autocomplete-input" autocomplete="off"></li>
		</ul>
		<input type="hidden" id="location" class="required value" data-for ="tag-location"/>                              
	</div>
	<?php // “certifications” id = [263].?>
	<div class="form-group">
	   <p><strong>List any certifications (seperate words with a comma):</strong></p>
	    <ul class ="tag tagit ui-widget ui-widget-content ui-corner-all" data-type ="category" id="tag-certifications" data-root = "263">
			<li class="tagit-new"><input type="text" class="ui-widget-content ui-autocomplete-input" autocomplete="off"></li>
		</ul>
		<input type="hidden" id="certifications" class="required value" data-for ="tag-certifications"/>                              
	</div>
	<div class="form-group" id="box-return">
		
	</div>
	<div class="form-group"><button style="font-size: 20px;float: right;" id="get-text-category">get text category</button></div>
	<div class="menu-tag">
		<ul class="ui-autocomplete ui-front ui-menu ui-widget ui-widget-content tagit-autocomplete"></ul>
	</div>
</div>
<script type="text/javascript">
	$(".menu-tag .ui-autocomplete").hide();
    var tag_html = '<li class="tagit-choice ui-widget-content ui-state-default ui-corner-all tagit-choice-editable"> <span class="tagit-label" data-id ="0" data-parent = "0">a</span> <a class="tagit-close"> <span class="text-icon">×</span> <span class="ui-icon ui-icon-close"></span> </a> <input type="hidden" value="a" name="category[]" class="tagit-hidden-field"> </li>';
    var el_menu = $("#menu-tag");
    var el_menu_offset = $(".main").offset();
    var el_parent ;
    function event_tag(el_parent,keycode,value,parents,top,left,type){
    	var base_get = "report/get_category_children";
    	if(type == "keyword"){
    		base_get = "report/get_keyword";
    	}
    	$(".menu-tag .ui-autocomplete").hide();
    	if(keycode != 13 && keycode != 44  && keycode != 188){
    		var name_not_show = "";
	        $.each(el_parent.find("li"),function(){
	        	name_not_show += $(this).find(".tagit-label").text()+","; 
	        });
	    	$.ajax({
	            url: base_url + base_get,
	            type: 'POST',
	            data: {
	                "parents_id": parents,
	                "notshow" : name_not_show,
	                "value" : value
	            },
	            dataType: 'json',
	            success: function (data) {
	            	var html = "";
	                if (data["status"] == "success") {
	                    if(data["reponse"].length > 0){
	                    	$.each(data["reponse"],function(key,value){
	                    		if(type == "keyword"){
	                    			if(value.title != ""){
		                    			html += '<li class="ui-menu-item" data-id = "'+value.keyword_id+'" id="ui-id-'+value.keyword_id+'" tabindex="-1">'+value.title+'</li>';
		                    		}
	                    		}else{
	                    			if(value.title != ""){
		                    			html += '<li class="ui-menu-item" data-parent="'+value.parents_id+'" data-id = "'+value.id+'" id="ui-id-'+value.id+'" tabindex="-1">'+value.title+'</li>';
		                    		}
	                    		}
	                    			
	                    	});
	                    	if(html != ""){
	                    		$(".menu-tag .ui-autocomplete").show();
	                    	}else{
	                    		$(".menu-tag .ui-autocomplete").hide();
	                    	}	
	                    }
	                }
	                $(".menu-tag .ui-autocomplete").html(html).css({"top":top+"px","left":left+"px"});
	            }
	        });
    	}
    }
    function complete(){
    }
    $(".tag .tagit-new > input").keyup(function(event){
    	if($(this).val() != ""){
    		var type = $(this).parents(".tag").data("type");
			var height_input = $(this).height();
	    	var offset = $(this).offset();
	    	var left = offset.left - el_menu_offset.left ;
	    	var top  = offset.top - (el_menu_offset.top - height_input) ;
	    	var value = $(this).val();
	    	var parents = $(this).parents(".tag").data("root");
	    	el_parent  = $(this).parents(".tag");
	    	event_tag(el_parent,event.keyCode,value,parents,top,left,type);
	    	el_parent.find(".tagit-new").find(">input").focus;			
    	}else{
    		$(".menu-tag .ui-autocomplete").hide().html("");
    	}
    	if(event.keyCode == 13 || event.keyCode == 188){
    		$(this).val("");
    	}
    });
    $(".tag .tagit-new > input").keydown(function(event){
    	var root_data = $(this).parents(".tag").data("root");
    	if($(this).val() == ""){
	    	$(".menu-tag .ui-autocomplete").hide().html("");
			if(event.keyCode == 8){
				$(this).parents(".tagit-new").prev().remove();
			}
		}else{
			if(event.keyCode == 13 ||  event.keyCode == 188){
				var tag_ap = $(tag_html);
	    		tag_ap.find('.tagit-label').text($(this).val());
	    		tag_ap.find('.tagit-label').attr("data-parent",root_data);
	    		$(el_parent).find(".tagit-new").before(tag_ap);
	    		$(".menu-tag .ui-autocomplete").hide().html("");
	    	}
		}
    	
    });
    $("#get-text-category").click(function(){
    	var data_sent = [];
    	var arg = new Array();
        var arg_kw = new Array();
    	$.each($(".tag"),function(){
    		var type = $(this).data("type");
    		var root_data = $(this).attr("data-root");
    		$.each($(this).find("li:not(.tagit-new)"),function(){
    			if(type == "keyword"){
    				var arg_kw_items = {"id":$(this).find(".tagit-label").data("id"),"value": $(this).find(".tagit-label").text()}
    				arg_kw.push(arg_kw_items);
    			}else{
    				var arg_item = {"root":$(this).find(".tagit-label").data("parent"),"id":$(this).find(".tagit-label").data("id"),"value": $(this).find(".tagit-label").text()}
    				arg.push(arg_item);
    				console.log(arg_item);
    			}
    			
    		});
    	});
    	data_sent = { keyword : arg_kw, category : arg };
    	$.ajax({
    		url: base_url + "report/conver_id",
    		type:"post",
    		dataType:"json",
    		data:data_sent,
    		success:function(data){
    			console.log(data);
    			if(data["status"] == "success"){
    				var html = "";
    				if(data["category"] != null){
    					html += "<div><h2>Category text ID</h2><p>"+data["category"]+"</p><div>";
    				}
    				$("#box-return").html(html);

    			}
    		},
    		error:function(){
    			alert("error");
    		}
    	});

    });
    $(document).on("click",".menu-tag .ui-menu-item",function(){
    	var id = $(this).data("id");
    	var parents = $(this).data("parent");
    	var tag_ap = $(tag_html);
    	var value = $(this).text();
		tag_ap.find('.tagit-label').text(value).attr("data-id",id).attr("data-parent",parents);
		el_parent.find(".tagit-new").before(tag_ap);
		el_parent.find(".tagit-new").find(">input").val("");
		el_parent.find(".tagit-new").find(">input").focus();
		$(".menu-tag .ui-autocomplete").hide().html("");
    });
    $(document).on("click",".tagit-close",function(){
    	$(this).parents("li").remove();
    	return false;
    });
     $(".tag").click(function(){
     	$(this).find(".tagit-new").find(">input").focus();
     });
</script>
<style type="text/css">
	.menu-tag .tagit-autocomplete.ui-menu .ui-menu-item{padding: 5px 0; }
	.ui-menu-item:hover{background-color: #ccc; cursor: pointer;}
</style>
