var reset_click = 0;
$(document).on("click",".your_reports .relative .icon",function(){
	$(".your_reports .relative").not($(this).parents(".open")).removeClass("open");
	if($(this).parent().hasClass("open") == true){
		$(this).parent().removeClass("open");
	}else{
		$(this).parent().addClass("open");
	}
});
$(document).on("click",".list-chose .list-item li a",function(){
	var loadding = "<p class='loadding-reports' style='width: 100%;text-align: center;height: 10px;position: absolute;left: 0;bottom: 15px;'><img style='height:20px;' src='"+base_url+"skins/images/loadding.GIF'/></p>";
	var new_this = $(this);
	var box_select = $(this).parents(".box-right-your-reports").find("#list-items");
	var data_order = $(this).data("order");
	var data_type = $(this).parents(".box-right-your-reports").data("type");
	var post_id   = $(this).parents(".content-your-reports").data("id");
	var data_colum = $(this).parents(".list-chose").data("colum");
	var limit_box = $(this).parents(".box-right-your-reports").find("#list-items").find(".items").length;
	if(reset_click == 0){
		$(this).parents(".box-right-your-reports").append(loadding);
		reset_click++;
		$.ajax({
			url : base_url + "profile/order_reports",
			type:"post",
			dataType: "json",
			data:{
				"data_order" : data_order,
				"data_type"  : data_type,
				"post_id"    : post_id,
				"data_colum" : data_colum,
				"limit_box"  : limit_box
			},
			success:function(data){
				if(data["success"] == "success"){		
					box_select.html(data["reponse"]);
					new_this.parents(".box-right-your-reports").find("#order_set").val(data["orderby"]);
				}else{
					alert("error");
				}
				reset_click = 0;
				new_this.parents(".box-right-your-reports").find(".loadding-reports").remove();
			},error:function(){
				reset_click = 0;
				new_this.parents(".box-right-your-reports").find(".loadding-reports").remove();
			}
		});
	}
	return false;
});
$(document).on("click","#more-your-reports a",function(){
	var loadding = "<p class='loadding-reports' style='width: 100%;text-align: center;height: 10px;position: absolute;left: 0;bottom: 15px;'> <img style='height: 20px;' src='"+base_url+"skins/images/loadding.GIF'/></p>";
	var data_type = $(this).parents(".box-right-your-reports").data("type");
	var data =  $(this).parents(".box-right-your-reports").find("#order_set").val();
	var limit_box = $(this).parents(".box-right-your-reports").find("#list-items").find(".items").length;
	var new_this = $(this);
	var box_select = $(this).parents(".box-right-your-reports").find("#list-items");
	var post_id   = $(this).parents(".content-your-reports").data("id");
	if(reset_click == 0){
		$(this).parents(".box-right-your-reports").append(loadding);
		reset_click++;
		$.ajax({
			url : base_url + "profile/more_reports",
			type:"post",
			dataType: "json",
			data:{
				"data" : data,
				"data_type"  : data_type,
				"limit_box"  : limit_box,
				"post_id"    : post_id

			},
			success:function(data){
				new_this.parents(".box-right-your-reports").find(".loadding-reports").remove();
				if(data["success"] == "success"){		
					box_select.append(data["reponse"]);
					if(data["hidden_more"] == "true"){
						new_this.parents("#more-your-reports").remove();
					}
				}else{
					alert("error");
				}
				reset_click = 0;
				
			},error:function(){
				reset_click = 0;
				new_this.parents(".box-right-your-reports").find(".loadding-reports").remove();
			}
		});
	}
	return false;
});
var reset_paging = 0;
var item_total = 5;
var number_scroll = 0;
var next_page = 0;
$(document).ready(function(){
	get_number_scroll();
	$(window).scroll(function () {
		if( number_scroll > 1 && reset_paging == 0 && ($(window).scrollTop() + $(window).height() + 100) >= $(document).height() ){
			reset_paging ++ ;
			number_scroll--;
			next_page++
			get_items();
		}
	});
});
function get_number_scroll(){
	number_scroll = Math.ceil(reports_total/item_total);
}
function get_items(){
	$("#reports-photo-box .loadding").show();
	$.ajax({
		url:base_url+"profile/paging_reports",
		type:"post",
		dataType:"json",
		data:{"next_page":next_page,"item_total": item_total},
		success:function(data){
			if(data["success"] == "success"){		
				$("#reports-photo-box .box-items-reports-photo").append(data["reponse"]);
			}else{
				alert("error");
			}
			reset_paging = 0;
			$("#reports-photo-box .loadding").hide();
		},
		error:function(){
			reset_paging = 0;
			$("#reports-photo-box .loadding").hide();
		}
	});
}

