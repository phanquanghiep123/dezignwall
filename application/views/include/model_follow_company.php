<div id="Companies_you_follow" class="modal fade" role="dialog">
   	<div class="modal-dialog">
      	<!-- Modal content-->
      	<div class="modal-content">
         	<div class="modal-header">
	            <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
	            <h3 class="modal-title">These are the companies you follow...</h3>
         	</div>
         	<div class="modal-body">
         		<div class="form-group">
		            <select id="select-company" class="form-control selectpicker" title="Narrow your search...">
		                <?php if(@$follow_record != null)
		                {
		                	foreach ($follow_record as $key => $value) {
		                		echo '<option value="'.$value["id"].'">'. $value ["company_name"].'</option>';
		                	}
		                }
		                ?>
					</select>
				</div>
				<ul id="sort-by" class="inline-block">
				    <li class="margin-top-20"><p class="margin-top-20">Sort by:</p><li>
					<li class="margin-top-20"><a href="javascript:;" id="sort-by-now" class="active" data-sort="company_name">A-Z</a></li>
					<li class="margin-top-20"><a href="javascript:;" id="sort-by-now" data-sort="created_at">Date</a></li>
				</ul>
				<!-- list content -->
				<div id="az">
					<div class="list">
					</div>
				</div>
				<!--! list content -->
				<div class="row">
					<div class="col-sm-12 text-right"><a href="#" id="more-your-follow" class="btn btn-link">MORE</a></div>
				</div>
         	</div>

      	</div>
   	</div>
</div>

<style type="text/css">
	#Companies_you_follow ul#sort-by{margin: 0;padding: 0}
	ul#sort-by li {margin-right: 20px;}
	ul#sort-by li a{color: #000;}
	ul#sort-by li a.active{color: #37a7a7;}
	.remove-btn{padding: 0!important;border: none!important;}
	#Companies_you_follow{padding: 0!important;}
	#Companies_you_follow p{color: #333;line-height: 1;}
	#Companies_you_follow .modal-dialog{max-width: 100%;margin: 10px auto;}
	#Companies_you_follow .modal-title{color: #339999;}
	#Companies_you_follow .modal-header{background-color: #fff;}
	#Companies_you_follow .list .media .media-heading{color: #333}
	
	/* css list-child */
	.list .list-child{margin-bottom: 15px;}
	.list .list-child:last-child{margin:0;}
	.list-child .title-list {color: #339999!important;font-size: 14px;margin-top: 10px;}
	#Companies_you_follow .list-child .list-item{display: inline-table;padding: 0;margin-left: 0}
	.list-child .list-item li{padding: 0;}
	.list-item a:hover{opacity: 0.8;display: block;}
	
	.more-list-item{position: relative;}
	.more-list-item .background-child{position: absolute;top: 0;background: rgba(0, 0, 0, 0.69);width: 100%;height: 100%;color: #fff;margin: 0;transition: all .3s;}
	.number{margin: 0;margin-top: 29px;text-align: center;font-size: 20px;transition:  all .3s;}
	.number .fa{font-size: 16px;transition:  all .3s;}
	a:hover .number{font-size: 24px}
	a:hover .number .fa{font-size: 20px}
	a:hover,a:focus{text-decoration: none;}
	.background-child:hover{background-color: rgba(0, 0, 0, 0.37)}
	/*! css list-child*/
	a.btn-link:hover,a.btn-link:focus,a.btn-link{color: #339999!important}
	.close {color: #000;opacity: 1;font-size: 22px;position: relative;top: -5px;right: 0px;}
	#Companies_you_follow .form-group .bootstrap-select > .dropdown-toggle{background-color: #f8f8f8;font-size: 16px;border: 1px solid #000}
	.btn.btn-link,.btn.btn-link:hover,.btn.btn-link:focus{text-decoration: none;border: none;outline: none;box-shadow: none;color: #333;font-size: 16px;}
	.bootstrap-select.btn-group .dropdown-toggle .caret{top: 35%;border-top: 18px dashed;border-right: 10px solid transparent;    border-left: 10px solid transparent;}
	.bootstrap-select.btn-group .dropdown-toggle .filter-option{color: #339999;font-weight: 600}
	.btn-link{color: #339999}

	.btn-popup-follow{position: relative;}
	.btn-popup-follow .popup-follow{
	    position: absolute;
	    top: 25px;
	    padding: 15px;
	    width: 200px;
	    right: 20px;
	    color: #999;
	    background: #fff;
	    box-shadow: -3px 5px 10px 0px #333;
	    z-index: 1;
	    text-align: justify;
		font-size: 14px;
		visibility: hidden;
		opacity: 0;
	    -webkit-transition: all 500ms ease-in-out;
	    -moz-transition: all 500ms ease-in-out;
	    -ms-transition: all 500ms ease-in-out;
	    -o-transition: all 500ms ease-in-out;
	    transition: all 500ms ease-in-out;
	}
	.btn-popup-follow:hover .popup-follow{visibility: visible;opacity: 1}
	.nav-fix{margin-bottom: 20px;border: none;font-size: 18px;}
	.nav-fix li{margin-right: 30px;}
	.margin-top-20{margin-top: 20px;margin-bottom: 20px;}
	.nav-fix li a{background: #fff!important;color: #000!important;}
	.nav-fix .active a,.nav-fix li a:hover{color: #339999!important;font-weight: 600;}
	#Companies_you_follow .img-circle{width: 64px ;height: 64px;}
	.link-to-my-photo {
		position: absolute;
	    left: 0;
	    right: 0;
	    padding-top: 29px;
	    top: 0;
	    background: rgba(13, 11, 11, 0.63);
	    bottom: 0;
	}
	.link-to-my-photo a{
		color: #fff;
	    text-align: center;
	    width: 100%;
	    float: left;
	}
	#Companies_you_follow .item-follow{ width: 100%; }
	#Companies_you_follow .modal .item-follow{ width: 100%; }
	#Companies_you_follow .item-follow img{max-width: 100%; height: 85px;}
	#Companies_you_follow .modal-content .modal-body .list {
	    max-height: 600px;
	    overflow-x: hidden;
	    overflow-y: auto;
	}
</style>
<script type="text/javascript">
    var request = {order : "company_name",items:0};
    function get_data_you_follow (append = false){
    	$.ajax({
			url : base_url + "profile/get_all_follow_company",
			type:"post",
			dataType:"json",
			data :request,
			success:function(res){
				console.log(res);
				if (res["status"] == "success"){
					if(append == false){
						$("#Companies_you_follow").find(".list").html(res["response"]);
					    $("#Companies_you_follow").modal();
					}else{
						$("#Companies_you_follow").find(".list").append(res["response"]);
					}
					if(res["more"] == false){
						$("#Companies_you_follow #more-your-follow").hide();
					}else{
						$("#Companies_you_follow #more-your-follow").show();
					}	
				}
			},
			error:function(){

			}
		});
    }
    $(document).on("click","#Companies_you_follow #more-your-follow",function(){
    	request.items  = $("#Companies_you_follow .list .list-child").length;
    	get_data_you_follow(true);
    	return false;
    });
	$(document).on("click","#your_follow_box #more-follow",function(){
		request = {order : "company_name",items:0};
		get_data_you_follow();
		return false;
	});
    $(document).on("click","#Companies_you_follow #sort-by-now",function(){
    	request.items  = 0;
		request.order  = $(this).attr("data-sort");
		$("#Companies_you_follow sort-by li a.active").removeClass("active");
		$(this).addClass("active");
		get_data_you_follow();
		return false;
	});
	$(document).on("click","#Companies_you_follow #allow_follow",function(){
		var id = $(this).attr("data-id");
        var _this = $(this);
        $.ajax({
            url : base_url + "profile/add_favorite_company",
            type:"post",
            data :{id:id,table:"follow"},
            dataType:"json",
            success : function(res){
                console.log(res);
                if(res["status"] == "success")
                    window.location.reload(true);
                else 
                    alert("Error!"); 
            },error:function(){
                alert("Error!"); 
            }
        })
		return false;
	});

	$(document).on("click","#Companies_you_follow #delete_follow",function(){
		var id = $(this).attr("data-id");
        var _this = $(this);
        $.ajax({
            url : base_url + "profile/delete_follow",
            type:"post",
            data :{id:id,table:"follow"},
            dataType:"json",
            success : function(res){
                console.log(res);
                if(res["status"] == "success")
                    window.location.reload(true);
                else 
                    alert("Error!"); 
            },error:function(){
                alert("Error!"); 
            }
        })
		return false;
	});
	$(document).on("change","#Companies_you_follow #select-company",function(){
		var company_id = $(this).val();
		$.ajax({
            url : base_url + "profile/get_company_you_follow",
            type:"post",
            data :{id:company_id,table:"follow"},
            dataType:"json",
            success : function(res){
                if(res["status"] == "success"){
                   $("#Companies_you_follow").find(".list").html(res["response"]);
                   $("#Companies_you_follow #sort-by li a.active").removeClass("active");
                   $("#Companies_you_follow #more-your-follow").hide();
                }
                else 
                    alert("Error!"); 
            },error:function(){
                alert("Error!"); 
            }
        });
	});
</script>