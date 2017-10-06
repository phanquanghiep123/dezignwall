<div id="Projects_You_Are" class="modal fade" role="dialog">
	<div class="modal-dialog">
    	<div class="modal-content">
		    <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
		        <h3 class="modal-title">Projects You Are Working On</h3>
		    </div>
		    <div class="modal-body">
		    	
		    </div>
		    <p class="text-center" id="box-bottom-more"><a href="#">6 MORE PROJECTS</a></p>
    	</div>
	</div>
</div>
<style type="text/css">
#Projects_You_Are .modal-dialog .more {font-size: 11px;}
#Projects_You_Are .modal-dialog .img-circle{width: 60px; height: 60px}
.media-body{max-width: 100%;}
.remove-margin{margin: 0!important}
.remove-padding{padding: 0!important}
#Projects_You_Are {padding: 0!important;}
#Projects_You_Are .modal-header,#Projects_You_Are .modal-body,#Projects_You_Are .modal-footer{padding: 0}
#Projects_You_Are .modal-content{padding: 10px 15px;}
#Projects_You_Are p{color: #333;margin: 0 0 5px 0;font-size: 16px;line-height: 1}
#Projects_You_Are .modal-dialog{width: 670px;max-width: 100%;margin: 10px auto;}
#Projects_You_Are .modal-title{color: #333;background-color: #fff;}
#Projects_You_Are .list-group{margin:0;padding-bottom: 20px;border-bottom: 3px solid #ddd;}
#Projects_You_Are .list-group:last-child{border: none;}
#Projects_You_Are .list-group .media .media-heading{color: #333}
#Projects_You_Are .list-group .media{margin-top: 35px;}
#Projects_You_Are .list-group .media .media-left img{border: 2px solid #339999;border-radius: 50%;}
#Projects_You_Are .list-group .media > p{margin: 0 0 5px 0}
#Projects_You_Are .list-group .btn-primary {border: 2px solid #555}
#Projects_You_Are .list-group .media .date-time{color: #339999}

/* css list-child */
#Projects_You_Are .list-child .title-list {color: #339999!important;font-size: 18px;margin: 10px 0;}
.list-group .list-child{margin-bottom: 15px;}
.list-group .list-child:last-child{margin:0;}
.list-child .list-item{display: inline-flex;padding: 0;margin-left: 0}
.list-child .list-item li{padding: 0;}
.list-item a:hover{opacity: 0.8;display: block;}

.more-list-item{position: relative;}
.more-list-item .background-child{position: absolute;top: 0;background: rgba(0, 0, 0, 0.69);width: 100%;height: 100%;color: #fff;margin: 0;transition: all .3s;}
#Projects_You_Are .number{margin: 0;margin-top: 20px;text-align: center;font-size: 14px;transition:  all .3s;}
#Projects_You_Are .number .fa{font-size: 12px;transition:  all .3s;}
#Projects_You_Are a:hover .number{font-size: 18px}
#Projects_You_Are a:hover .number .fa{font-size: 16px}
#Projects_You_Are a:hover, #Projects_You_Are a:focus{text-decoration: none;}
.background-child:hover{background-color: rgba(0, 0, 0, 0.37)}
#Projects_You_Are .modal-body{
	max-height: 540px;
    overflow-y: auto;
    overflow-x: hidden;
}
/*! css list-child*/
</style>
<script type="text/javascript">
	$(document).ready (function(){
		$("#box-wall-working #box-bottom-more").click(function(){
			more_walls();
			return false;
		});
		$("#Projects_You_Are #box-bottom-more").click(function(){
			var items = $("#Projects_You_Are .modal-body .list-group").length;
			more_walls(items,true);
			return false;
		});
	});
	function more_walls(items = 0,append = false){
		$.ajax({
			url : "<?php echo base_url("profile/get_walls");?>",
			type:"post",
			dataType :"json",
			data:{items : items },
			success:function(res){
				console.log(res);
				if(res["status"]=="success"){
					if(append == false){
						$("#Projects_You_Are .modal-body").html(res["response"]);
					}else{
						$("#Projects_You_Are .modal-body").append(res["response"]);
					}
					if(res["more"] == false){
						$("#Projects_You_Are #box-bottom-more").hide();
					}else{
						$("#Projects_You_Are #box-bottom-more").show();
					}
					$("#Projects_You_Are").modal();
				}else{
					alert("Error");
				}				
			},error:function(){
				alert("Error");
			}
		})
	}
</script>