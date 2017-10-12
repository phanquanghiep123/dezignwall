<div class="modal fade in" id="work-education" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form id="save_education" class="form-horizontal form-skin-17" method="post" action="<?php echo base_url("profile/save_education");?>">
				<div class="modal-header"> 
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Education</h4>
				</div>
				<div class="modal-body">
					<div class="box-content" id="education-show">    
					</div>
					<div class="add-more-content"><p class="text-right"><a href="javascript:;" id="add-education">Add More Education</a></p></div>
				</div>
				<div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
					<h4 class="modal-title" id="myModalLabel">Volunteer Experience</h4>
				</div>
				<div class="modal-body">
					<div class="box-content" id="volunteer-education-show"> 
					</div>
					<div class="add-more-content"><p class="text-right"><a href="javascript:;" id="add-volunteer">Add More Volunteer Experience</a></p></div>
				</div>
				<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> <button type="submit" class="relative btn btn-primary">Save/Update</button> </div>
			</form>
		</div>
	</div>
</div>
<style type="text/css">
    #work-education .media-left{
        float: left;
        width: 13%;
        position: relative; 
    }
    #work-education .media-body{
        float: left;
        width: 87%;
    }
    #work-education .modal-dialog {
        width: 750px;
    }
    body #work-education .modal-header{background-color: #fff; float: left;width: 100%;}
    body #work-education .modal-title{font-size: 30px; color: #000;}
    body #work-education .modal-body{float: left;width: 100%; margin-top: 0;padding-top: 0;}
    #work-education .media, #work-education .media-body{
        overflow: inherit;
    }
    #work-education .work-add{
    	font-size: 50px;
    	color: #37a9a9;
    }
    #work-education hr {
    	margin: 0px 0 40px;
	    border: 1px solid #ccc;
	    width: 100%;
	    float: left;
	    padding-top: 0;
    }
    #work-education .loadding{position: absolute; width: 100%;cursor: wait;right: 0;top: 0;bottom: 0; text-align: center;}
    #work-education .loadding img {max-height: 100%;max-width: 100%; margin: 0 auto;}
    #work-education .media-left img {width: 100%;}
    #work-education .box-logo-education {position: absolute;display: table; vertical-align: middle; top: 0 ; bottom: 0; left: 0; right: 0}
    #work-education .box-logo-education .click-logo{
    	display: table-cell;
	    vertical-align: middle;
	    height: 84px;
	    text-align: center;
	    width: 84px;
	    margin: auto auto;
	    max-width: 100%;
    }
    #work-education .box-logo-education .click-logo a{color: #fff; font-size: 29px; font-weight: bold;}
    #work-education .box-logo-education .click-logo a:hover{color: #37a7a7}
    #work-education .media-left .relative{width: 100%}
    #work-education .media-left .img-circle{
	   	width: 84px;
	    height: 84px;
	    background-size: cover;
	    background-position: center;
	    background-repeat: no-repeat;
    }
    #work-education .media{margin-top: 0;}
</style>
<script type="text/javascript">
    $("#get_education").click(function(){
    	$.ajax({
    		url: "<?php echo base_url("profile/get_education")?>",
    		type:"post",
    		dataType:"json",
    		data:{id:0,items:0},
    		success:function(res){
    			if(res["status"] == "success"){
            		$("#work-education #education-show").html(res["reponse"]["education"]);
            		$("#work-education #volunteer-education-show").html(res["reponse"]["volunteer"]);
	                if(res["show"]  == true) $("#more-work-experience").show();
	                else $("#more-work-experience").hide();
	                $("#work-education").modal();
	                $.each($("#work-education .start_day.new"),function(){
	                    $(this).datetimepicker({
	                        format :"MM/DD/Y",
	                        widgetPositioning:{
	                            horizontal: 'right',
	                            vertical: 'bottom'
	                        }
	                    });
	                    $(this).removeClass("new");
	                });
	                $.each($("#work-education .end_day.new"),function(){
	                    $(this).datetimepicker({
	                        format :"MM/DD/Y",
	                         widgetPositioning:{
	                            horizontal: 'right',
	                            vertical: 'bottom'
	                        }
	                    });
	                    $(this).removeClass("new");
	                });	
            	}else{
            		alert("error");
            	}
    		},
    		error:function(){

    		}
    	})    	
    	return false;
    });
	$(document).on("change","#work-education input[type=file].add-logo",function(){
    	var _this = $(this);
        if ($(this)[0].files && $(this)[0].files[0]) {
            var file = $(this)[0].files[0];
            window.URL = window.URL || window.webkitURL;
            var url = window.URL.createObjectURL(file);
            var fileURL = URL.createObjectURL(file);
            _this.parents(".media-left").find(".img-circle").css("background-image","url("+fileURL+")");
        }else{
            $(this).parent().find(".box-img-select").html('');
        }
        return false;
    });
    $(document).on("click","#work-education .click-logo a",function(){
    	$(this).parents(".media-left").find("input[type=file].add-logo").trigger("click");
    });
    $('body #save_education').submit(function(){
        var _this = $(this);
        $(this).ajaxSubmit({
            beforeSubmit:function(){
                _this.find("button[type='submit']").append('<div class="loadding"><img src="<?php echo skin_url("images/loading.gif");?>"></div>');
            },
            success:function(res){
            	console.log(res);
                _this.find("button[type='submit'] .loadding").remove();
                location.reload();
            },
            error : function(){
                alert("Error!");
                _this.find("button[type='submit'] .loadding").remove();

            }
        });
        return false;
    }) ; 
    $(document).on("click","#save_education #add-education",function(){
    	var logo = "<?php echo base_url("skins/images/logo-company.png");?>";
    	var length_box = $(this).parents(".modal-body").find(".box-content .work-item.media").length;
    	var box_appen = '<div class="work-item media"><hr><div class="remove-items" data-id="0" data-type="education">×</div> <div class="media-left"> <div class="relative"> <div class="box-logo-education"> <div class="click-logo"><a href="javascript:;">+</a></div> </div> <div class="img-circle" style="background-image:url('+logo+')"></div> <input accept="image/*" type="file" class="add-logo none" id="educationlogo-'+length_box+'" name="educationlogo-'+length_box+'"> </div> </div> <div class="media-body"> <div class="form-group"> <label for="work-company" class="col-sm-3 control-label"><small>School Name:</small></label> <div class="col-sm-9"> <input type="text" class="form-control" value="" name="education['+length_box+'][school_name]" placeholder="What was the name of your school..."> </div> </div> <div class="form-group"> <label for="major_degeer" class="col-sm-3 control-label"><small>Major Degeer:</small></label> <div class="col-sm-9"> <input type="text" value="" class="form-control" name="education['+length_box+'][major_degeer]" placeholder="What was your major/degree..."> </div> </div> <div class="form-group date-range"> <label for="work-start-date-'+length_box+'" class="col-sm-3 control-label">Start Date:</label> <div class="col-sm-3"> <input type="text" id="work-start-date-'+length_box+'" class="form-control start_day new" value="" name="education['+length_box+'][start_day]" placeholder="mm/dd/yyyy"> </div> <label for="work-end-date-'+length_box+'" class="col-sm-3 control-label">End Date:</label> <div class="col-sm-3"> <input type="text" id="work-end-date-'+length_box+'" class="form-control end_day new" value="" name="education['+length_box+'][end_day]" placeholder="mm/dd/yyyy"> </div> </div> <div class="form-group"> <div class="col-sm-12 custom"> <div class="checkbox check-yelow checkbox-circle"> <input class="is_present_check" type="checkbox" id="education-present-'+length_box+'" name="education['+length_box+'][present]" value="1"> <label for="education-present-'+length_box+'"> Present </label> </div> </div> </div> </div> <input type="hidden" name="education['+length_box+'][id]" value="0"> </div>';
   		$(this).parents(".modal-body").find(".box-content").append(box_appen);
   		$.each($("#work-education .start_day.new"),function(){
            $(this).datetimepicker({
                format :"MM/DD/Y",
                widgetPositioning:{
                    horizontal: 'right',
                    vertical: 'bottom'
                }
            });
            $(this).removeClass("new");
        });
        $.each($("#work-education .end_day.new"),function(){
            $(this).datetimepicker({
                format :"MM/DD/Y",
                 widgetPositioning:{
                    horizontal: 'right',
                    vertical: 'bottom'
                }
            });
            $(this).removeClass("new");
        });	
   		return false;
    });
    $(document).on("click","#save_education #add-volunteer",function(){
    	var logo = "<?php echo base_url("skins/images/logo-company.png");?>";
    	var length_box = $(this).parents(".modal-body").find(".box-content .work-item.media").length;
    	var box_appen = '<div class="work-item media"><hr><div class="remove-items" data-id="0" data-type="volunteer">×</div><div class="media-left"><div class="relative"><div class="box-logo-education"><div class="click-logo"><a href="javascript:;">+</a></div></div><div class="img-circle" style="background-image:url('+logo+')"></div><input accept="image/*" type="file" class="add-logo none" id="volunteerlogo-'+length_box+'" name="volunteerlogo-'+length_box+'"></div></div><div class="media-body"><div class="form-group"> <label class="col-sm-3 control-label"><small>Organization:</small></label><div class="col-sm-9"> <input type="text" class="form-control" value="" name="volunteer['+length_box+'][organization]" placeholder="What was the name of the organization..."> </div></div><div class="form-group"> <label class="col-sm-3 control-label"><small>Role:</small></label><div class="col-sm-9"> <input type="text" value="" class="form-control" name="volunteer['+length_box+'][role]" placeholder="What was your role..."> </div></div><div class="form-group date-range"> <label for="volunteer-start-date-'+length_box+'" class="col-sm-3 control-label">Start Date:</label><div class="col-sm-3"> <input type="text" id="volunteer-start-date-'+length_box+'" class="form-control start_day new" value="" name="volunteer['+length_box+'][start_day]" placeholder="mm/dd/yyyy"> </div> <label for="volunteer-end-date-'+length_box+'" class="col-sm-3 control-label">End Date:</label><div class="col-sm-3"> <input type="text" id="volunteer-end-date-'+length_box+'" class="form-control end_day new" value="" name="volunteer['+length_box+'][end_day]" placeholder="mm/dd/yyyy"> </div></div><div class="form-group"><div class="col-sm-12 custom"><div class="checkbox check-yelow checkbox-circle"> <input class="is_present_check" type="checkbox" id="volunteer-present-'+length_box+'" name="volunteer['+length_box+'][present]" value="1"> <label for="volunteer-present-'+length_box+'">Present</label> </div></div></div></div><input type="hidden" name="volunteer['+length_box+'][id]" value="0"></div>';
   		$(this).parents(".modal-body").find(".box-content").append(box_appen);
   		$.each($("#work-education .start_day.new"),function(){
            $(this).datetimepicker({
                format :"MM/DD/Y",
                widgetPositioning:{
                    horizontal: 'right',
                    vertical: 'bottom'
                }
            });
            $(this).removeClass("new");
        });
        $.each($("#work-education .end_day.new"),function(){
            $(this).datetimepicker({
                format :"MM/DD/Y",
                 widgetPositioning:{
                    horizontal: 'right',
                    vertical: 'bottom'
                }
            });
            $(this).removeClass("new");
        });	
   		return false;
    });
    $(document).on("click","#save_education .is_present_check",function(){
    	var box_parent = $(this).parents(".box-content");
        $.each(box_parent.find(".is_present_check").not(this),function(){
            $(this).prop("checked",false);
        });
    });
  
</script>