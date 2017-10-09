<!-- Modal -->
<div id="box-experience-common">
<div class="modal modal-skin17 modal-work-experience fade" id="work-experience" tabindex="-1" role="dialog" aria-labelledby="work-experience">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Your Work Experience</h4>
            </div>
            <form id="save_experience" class="form-horizontal form-skin-17" method="post" action="<?php echo base_url("profile/save_experience")?>">
                <div class="modal-body">
                    <div class="text-right">
                        <a id="add-experience" href="#"><span class="work-add">+</span></a>
                    </div>
                    <div class="box-content"></div>            
                </div>
                <div class="modal-footer">
                    <button type="button" id="more-work-experience" class="btn btn-link">MORE</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="relative btn btn-primary">Save/Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal modal-skin17 modal-work-experience fade" id="work-experience-saved" tabindex="-1" role="dialog" aria-labelledby="work-experience-saved">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Congrats on your new role!</h4>
            </div>
            <form id ="save_experience" class="form-horizontal form-skin-17" method="post" action="<?php echo base_url("profile/save_experience")?>">
                <div class="modal-body">
                    <h3>Lets add your new position to your work experience!</h3>
                    <hr>
                    <div class="box-content">
                        <div class="work-item media">
                           <div class="media-left">
	                            <div class="relative">
	                                <div class="box-logo-experience">
	        				            <div class="click-logo"><a href="javascript:;">+</a></div>                                
	                                </div>
	                                <div class="img-circle" style="background-image:url(<?php echo skin_url("images/logo-company.png");?>)"></div>
	                                <input accept="image/*" type="file" class="add-logo none" id="logo-0" name=Logo-0>
	                            </div>
	                        </div>
                            <div class="media-body">
                                <div class="form-group">
                                    <label for="job_title" class="col-sm-3 control-label"><small>Job Title:</small></label>
                                    <div class="col-sm-9">
                                        <input type="text" value="" class="form-control" name="Experience[0][job_title]" placeholder="What was your job title...">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="work-company" class="col-sm-3 control-label"><small>Company Name:</small></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" value="" name="Experience[0][company_name]" placeholder="What was your company’s name...">
                                    </div>
                                </div>
                                <div class="form-group date-range">
                                    <label for="work-start-date" class="col-sm-3 control-label">Start Date:</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control start_day" value="" name="Experience[0][start_day]" placeholder="mm/dd/yyyy">
                                    </div>
                                    <label for="work-end-date" class="col-sm-3 control-label">End Date:</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control end_day" value="" name="Experience[0][end_day]" placeholder="mm/dd/yyyy">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12 custom">
                                        <div class="checkbox check-yelow checkbox-circle">
                                            <input class="is_present_check" type="checkbox" id="work-present-add" name="Experience[0][present]" value="1"> 
                                            <label for="work-present-add">
                                                Present
                                            </label>   
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label for="work-description"><small>Job Description:</small></label>
                                        <textarea class="form-control" name="Experience[0][description]" placeholder="Describe your role and accomplishments..."></textarea>
                                    </div>
                                </div><p class="help-block">Are you the admin for this companies profile? As an admin you have the ability to post on behalf of the company, build Digital Product Catalogs and manage your companies account activity. If so, lets start building your company profile!</p>
                                <p class="help-block">By selecting the radial button you acknowledge that you have the right and authorization to post content on behalf of this company. After selecting “Save/Update”, you will be redirected to your company profile.</p>
                                <div class="form-group">
                                    <div class="col-sm-12 custom">
                                        <div class="checkbox check-yelow checkbox-circle">
                                            <input class="is_admin_check" value="1" type="checkbox" id="work-who-add" name="Experience[0][is_admin]">
                                            <label for="work-who-add">
                                                <small>I am the admin for this companies profile.</small>
                                            </label>
                                        </div>
                                    </div>
                                </div></div>
                            <input type="hidden" name="Experience[0][id]" value="">
                        
                        </div> 
                        <hr>       
                    </div>
                </div>
                
                <div class="modal-footer">
                    <a id="add-item-more" type="button" class="btn btn-link">Add More Experience</a>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary relative">Save/Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<script type="text/javascript" src="<?php echo skin_url('datetimepicker/js/moment.js');?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo skin_url('datetimepicker/css/bootstrap-datetimepicker.min.css')?>">
<script type="text/javascript" src="<?php echo skin_url('datetimepicker/js/bootstrap-datetimepicker.min.js')?>"></script>
<style type="text/css">
    #box-experience-common .media-left{
        float: left;
        width: 13%;
        position: relative;
    }
    #box-experience-common .media-body{
        float: left;
        width: 87%;
    }
    #box-experience-common .modal-dialog {
        width: 750px;
    }
    body #work-experience-saved .modal-header{background-color: #37a7a7;}
    body #work-experience-saved .modal-title{font-size: 24px; color: #fff;}
    #box-experience-common .media, #box-experience-common .media-body{
        overflow: inherit;
    }
    #box-experience-common .work-add{
    	font-size: 50px;
    	color: #37a9a9;
    }
    #save_experience .loadding{position: absolute; width: 100%;cursor: wait;right: 0;top: 0;bottom: 0; text-align: center;}
    #save_experience .loadding img {max-height: 100%;max-width: 100%; margin: 0 auto;}
    #box-experience-common .media-left img {width: 100%;}
    .box-logo-experience {position: absolute;display: table; vertical-align: middle; top: 0 ; bottom: 0; left: 0; right: 0}
    .box-logo-experience .click-logo{
    	display: table-cell;
	    vertical-align: middle;
	    height: 84px;
	    text-align: center;
	    width: 84px;
	    margin: auto auto;
	    max-width: 100%;
    }
    .box-logo-experience .click-logo a{color: #fff; font-size: 29px; font-weight: bold;}
    .box-logo-experience .click-logo a:hover{color: #37a7a7}
    #box-experience-common .media-left .relative{width: 100%}
    #box-experience-common .media-left .img-circle{
	   	width: 84px;
	    height: 84px;
	    background-size: cover;
	    background-position: center;
	    background-repeat: no-repeat;
    }
    
</style>
<script type="text/javascript">
    $("#more-work-experience").click(function(){
    	var items = $("#work-experience #save_experience .work-item.media").length;
    	$.ajax({
            url : base_url + "profile/get_experience",
            type:"post",
            dataType:"json",
            data:{id : 0 ,items : items},
            success:function(res){
            	if(res["status"] == "success"){
            		$("#work-experience #save_experience .box-content").append(res["reponse"]);
	                if(res["show"]  == true) $("#more-work-experience").show();
	                else $("#more-work-experience").hide();
	                $("#work-experience").modal();
	                $.each($("#work-experience #save_experience .start_day.new"),function(){
	                    $(this).datetimepicker({
	                        format :"MM/DD/Y",
	                        widgetPositioning:{
	                            horizontal: 'right',
	                            vertical: 'bottom'
	                        }
	                    });
	                    $(this).removeClass("new");
	                });
	                $.each($("#work-experience #save_experience .end_day.new"),function(){
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
                
            }
        });
        return false;
    });
    $("#get_experience").click(function(){
        $.ajax({
            url : base_url + "profile/get_experience",
            type:"post",
            dataType:"json",
            data:{id : 0 ,items : 0},
            success:function(res){
            	if(res["status"] == "success"){
            		$("#work-experience #save_experience .box-content").html(res["reponse"]);
	                if(res["show"]  == true) $("#more-work-experience").show();
	                else $("#more-work-experience").hide();
	                $("#work-experience").modal();
	                $.each($("#work-experience #save_experience .start_day"),function(){
	                    $(this).datetimepicker({
	                        format :"MM/DD/Y",
	                        widgetPositioning:{
	                            horizontal: 'right',
	                            vertical: 'bottom'
	                        }
	                    });
	                });
	                $.each($("#work-experience #save_experience .end_day"),function(){
	                    $(this).datetimepicker({
	                        format :"MM/DD/Y",
	                         widgetPositioning:{
	                            horizontal: 'right',
	                            vertical: 'bottom'
	                        }
	                    });
	                });	
            	}else{
            		alert("error");
            	}
                
            }
        });
        return false;
    });
    $(document).ready(function(){ 
        $("body #work-experience-saved").on("hidden.bs.modal",function(){
            $("body").addClass("modal-open");
        });
        $("#save_experience .end_day").datetimepicker({
            format :"MM/DD/Y",
            widgetPositioning:{
                horizontal: 'right',
                vertical: 'bottom'
            }
        });    
        $("#save_experience .start_day").datetimepicker({
            format :"MM/DD/Y",
            widgetPositioning:{
                horizontal: 'right',
                vertical: 'bottom'
            }
        }); 
        $('body #save_experience').submit(function(){
            var _this = $(this);
            $(this).ajaxSubmit({
                beforeSubmit:function(){
                    _this.find("button[type='submit']").append('<div class="loadding"><img src="<?php echo skin_url("images/loading.gif");?>"></div>');
                },
                success:function(res){
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
        
    });
    $(document).on("click","#save_experience .is_present_check",function(){
        $.each($("#work-experience #save_experience .is_present_check").not(this),function(){
            $(this).val("0");
            $(this).prop("checked",false);
        });
        $(this).val("1");
    });
    $(document).on("click","#save_experience .is_admin_check",function(){
        if($(this).is(':checked') == true){
            $(this).val("1");
        }else{
            $(this).val("0");
        }
    });
    
    $(document).on("click","#work-experience #add-experience",function(){
        $("#work-experience-saved").modal();
        return false;
    });
    $(document).on("click","#work-experience-saved #add-item-more",function(){
        
        var length_item = $("#work-experience-saved .box-content .work-item").length;
        var item ='<div class="work-item media new"> <div class="media-left"> <div class="relative"> <div class="box-logo-experience"> <div class="click-logo"><a href="javascript:;">+</a></div> </div> <div class="img-circle" style="background-image:url(<?php echo skin_url("images/logo-company.png");?>)"></div> <input accept="image/*" type="file" class="add-logo none" id="logo-'+length_item+'" name=Logo-'+length_item+'> </div> </div><div class="media-body"> <div class="form-group"> <label for="job_title" class="col-sm-3 control-label"><small>Job Title:</small></label> <div class="col-sm-9"> <input type="text" value="" class="form-control" name="Experience['+length_item+'][job_title]" placeholder="What was your job title..."> </div> </div> <div class="form-group"> <label for="work-company" class="col-sm-3 control-label"><small>Company Name:</small></label> <div class="col-sm-9"> <input type="text" class="form-control" value="" name="Experience['+length_item+'][company_name]" placeholder="What was your company’s name..."> </div> </div> <div class="form-group date-range"> <label for="work-start-date" class="col-sm-3 control-label">Start Date:</label> <div class="col-sm-3"> <input type="tex" class="form-control start_day" value="" name="Experience['+length_item+'][start_day]" placeholder="mm/dd/yyyy"> </div> <label for="work-end-date" class="col-sm-3 control-label">End Date:</label> <div class="col-sm-3"> <input type="tex" class="end_day form-control" value="" name="Experience['+length_item+'][end_day]" placeholder="mm/dd/yyyy"> </div> </div> <div class="form-group"> <div class="col-sm-12 custom"> <div class="checkbox check-yelow checkbox-circle"> <input class="is_present_check" type="checkbox" id="work-present-0" name="Experience['+length_item+'][present]"> <label for="work-present-0"> Present </label> </div> </div> </div> <div class="form-group"> <div class="col-sm-12"> <label for="work-description"><small>Job Description:</small></label> <textarea class="form-control" name="Experience['+length_item+'][description]" placeholder="Describe your role and accomplishments..."></textarea> </div> </div>';
            if(length_item < 1){
                item += '<p class="help-block">Are you the admin for this companies profile? As an admin you have the ability to post on behalf of the company, build Digital Product Catalogs and manage your companies account activity. If so, lets start building your company profile!</p> <p class="help-block">By selecting the radial button you acknowledge that you have the right and authorization to post content on behalf of this company. After selecting “Save/Update”, you will be redirected to your company profile.</p> <div class="form-group"> <div class="col-sm-12 custom"> <div class="checkbox check-yelow checkbox-circle"> <input class="is_admin_check" value="" type="checkbox" id="work-who-0" name="Experience['+length_item+'][is_admin]"> <label for="work-who-0"> <small>I am the admin for this companies profile.</small> </label> </div> </div> </div>  ';
            }
            item += '<input type="hidden" name="Experience['+length_item+'][id]" value="0"></div><hr></div>';  
            $("#work-experience-saved .box-content").append(item);
            $("#work-experience-saved .box-content .new .end_day").datetimepicker({
                format :"MM/DD/Y",
                widgetPositioning:{
                    horizontal: 'right',
                    vertical: 'bottom'
                }
            });    
            $("#work-experience-saved .box-content .new .start_day").datetimepicker({
                format :"MM/DD/Y",
                widgetPositioning:{
                    horizontal: 'right',
                    vertical: 'bottom'
                }
            }); 
            $("#work-experience-saved .box-content .new").removeClass("new");    
            return false;
    });
    $(document).on("click","#box-experience-common .click-logo a",function(){
    	$(this).parents(".media-left").find("input[type=file].add-logo").trigger("click");
    });
    $(document).on("change","#box-experience-common input[type=file].add-logo",function(){
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
</script>