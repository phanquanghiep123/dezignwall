<link rel="stylesheet" type="text/css" href="<?php echo skin_url("css/page/profile.css")?>">
<section class="section profile">
	<div id="crop-avatar">
		<div class="banner">
		    <?php 
		        $avatar = ( @$member['avatar'] != null ) ? base_url($member['avatar']) :  base_url("/skins/images/avatar-full.png");
		    	$banner = ( @$member['banner'] != null ) ? base_url($member['banner']) :  base_url("/skins/images/banner-profile.jpg");
		    ?>
			<div><img id="bannershow" style="width: 100% ;height: 365px;" src="<?php echo $banner ;?>"></div>
		</div>
		<div class="container">
			<div class="panel panel-default relative top-profile">
				<div class="avatar">
					<div class="profile-image">
	                    <div class="box-avatar">
	                    	<img id="avatarshow" class="media-object avatar-full" src="<?php echo $avatar; ?>" alt="..." width="162" height="162"> 
	                    </div>
	                </div>
				</div>
				<h2 class="text-center"><?php echo $member["first_name"];?> <?php echo $member["last_name"];?></h2>
				<h2 class="text-center"><i class="upgrade-account-link">"Post all message"</i></h2>
				<h2 class="text-center"><?php echo $member_company["business_description"];?> | <?php echo $member_company["company_name"];?></h2>
				<?php
				    $arglist_education = [];
					if(@$list_education){
						
						foreach ($list_education AS $key => $value){
							$arglist_education [] = $value["school_name"];
						}
					}
				?>
				<h4 class="text-center text-color-green"><?php echo $arglist_education == null ? " - " : implode(" - ", $arglist_education);?></h4>
				<h4 class="text-center text-color-green">Orange Country California area 500+</h4>
				<h4 class="text-center">Brief description of what you or company does...</h4>
				<div class="banner-button-share"> <a class="btn btn-gray" href="<?php echo base_url();?>/profile/download_impormation" download="">Download Contacts</a> <button class="btn btn-gray clear-button" data-title="abc company" onclick="document.location.href='<?php echo base_url();?>/profile/reports';" data-type="profile" data-id="1072">Reports</button> <button class="btn share_click" data-toggle="modal" data-target="#share-modal" data-title="abc company" data-type="profile" data-id="1072">Share Profile</button> </div>
			</div>
		</div>
	</div>
	<div class="box-profile">
		<div class="container">
			<div class="row item-profile">
				<div class="col-md-6">
					<div class="panel panel-default relative padding-bottom-0">
						<div class="panel-header">
			                <h2 class="panel-title"><img class="star-image" src="<?php echo skin_url("images/star.png");?>"><span class="maggin-10">All star Profile</span></h2>
			            </div>	
					</div>
				</div>
				<div class="col-md-6">
					<div class="panel panel-default relative padding-bottom-0">
						<div class="row">
							<div class="col-md-6"><h3 class="upgrade-account-link"><strong><?php echo $number_view_profile;?></strong></h3><p class="remove-margin">Who's viewed your profile</p></div>
							<div class="col-md-6"><h3 class="upgrade-account-link"><strong><?php echo $number_view_post;?></strong></h3><p class="remove-margin">Viewed of your post</p></div>
						</div>	
					</div>
				</div>
			</div>
			<div class="row item-profile">
				<div class="col-md-6">
					<div class="panel panel-default relative padding-bottom-0">
						<div class="panel-header">
							<h2 class="panel-title">Contact Info</h2> 
						</div>
						<form id="saveprofile_from" action="<?php echo base_url()."profile/update" ?>" method="post" class="form-horizontal form-profile">
							<div class="form-group"> <label class="col-sm-4 control-label" style="font-size: 17px;">Work Email:</label>
								<div class="col-sm-8">
									<p data-value ="work_email" class="form-control-static view-profile"><?php echo @$member["work_email"]; ?></p>
								</div>
							</div>
							
							<div class="form-group"> <label class="col-sm-4 control-label">Work Phone:</label>
								<div class="col-sm-8">
									<p data-value ="work_ph" class="form-control-static view-profile"><?php echo @$member["work_ph"]; ?></p>
								</div>
							</div>
							<div class="form-group"> <label class="col-sm-4 control-label">Cell Phone:</label>
								<div class="col-sm-8">
									<p data-value ="cellphone" class="form-control-static view-profile"><?php echo @$member["cellphone"]; ?></p>
								</div>
							</div>
							<div class="form-group"> <label class="col-sm-4 control-label">Dezignwall Handle:</label>
								<div class="col-sm-8">
									<p data-value ="designWall_handel" class="form-control-static view-profile"><?php echo @$member["designWall_handel"]; ?></p>
								</div>
							</div>
							<div class="form-group"> <label class="col-sm-4 control-label">Twitter Handle:</label>
								<div class="col-sm-8">
									<p data-value ="twitter_handel" class="form-control-static view-profile"><?php echo @$member["twitter_handel"]; ?></p>
								</div>
							</div>
							<div class="form-group"> <label class="col-sm-4 control-label">Instagram Handle:</label>
								<div class="col-sm-8">
									<p data-value ="instagram_handel" class="form-control-static view-profile"><?php echo @$member["instagram_handel"]; ?></p>
								</div>
							</div>
						</form>
					</div>
				</div> 
				<div class="col-md-6">
					<div class="panel panel-default relative" id="activity">
						<div class="panel-header">
			                <h2 class="panel-title">Activity</h2>
			            </div>
			            <div class="row">
				            <div class="lis-post-photo">
				                <?php 
				                	if(@$get_active != null){

				                		foreach ($get_active as $key => $value) {
				                			if($value["type"] == "photo"){
				                				$created_at_object = $value["photo_created"] ;

				                			}else{
				                				$created_at_object = $value["company_created"] ;
				                			}
				                			$data_text     = $value["type_object"]."ed" ;
				            				$type_object   = str_replace("ee", "e", $data_text );
				            				$type_object   = str_replace("pined", "pinned", $type_object );
				            				$value["type"] = str_replace("photo","image",$value["type"]) ;
				                		?>
				                		<div class="col-sm-12 item-experience">
					                		<div class="row">
					                			<?php  $avatar = isset($value["logo"]) && $value["logo"] != "" ? base_url(@$value["logo"]) : skin_url("images/logo-company.png"); ?>
							            		<div class="col-sm-2"><a class="text-white" href="<?php echo base_url("company/view/".$value["member_id"])?>"><div class="img-circle" style="background-image:url(<?php echo $avatar;?>)"></div></a></div>
							            		<div class="col-sm-10">
							            		    <?php if($value["type"] == "photo"):?>
							            			<p><a href="<?php echo base_url("photos/" . $value['photo_id'] . "/" . gen_slug($value["name"]));?>"><b><?php echo $value["name"];?></b></a></p>						            			
							            			<?php else:?>
							            			<p><a href="<?php echo base_url("company/view/" . $value['member_id']);?>"><b><?php echo $value["company_name"];?></b></a></p>
							            			<?php endif;?>
							            			<p>by Company <a href="<?php echo base_url("company/view/".$value["member_id"]);?>"><b><?php echo $value["company_name"]?></b></a> on <?php echo date('F Y', strtotime($created_at_object)) ?></p>
							            			<p class="upgrade-account-link"><?php echo $type_object;?> <?php echo $value["type"] ;?> on date - <?php echo date('F Y h:i a', strtotime($value["enter_active"])) ?></p>
							            		</div>
							            	</div>	
						            	</div>	 
				                		<?php }
				                	}
				                ?>
				            </div>
			        	</div>
			        	<?php if (@$active_show_more && @$get_active != null) : ?>
			        		<p class="text-center" id="box-bottom-more"><a href="">MORE ACTIVITY</a></p>
			        	<?php endif;?>
			        </div>
			    </div>
			</div>
			</div>
			<div class="row item-profile">
				<div class="col-md-6">
					<div class="panel panel-default relative">
						<div class="panel-header">
			                <h2 class="panel-title">Experience</h2>
			            </div>
			            <div class="row">
			                <?php if(isset($list_experience)){
			                	echo '<div class="lis-post-photo" id="box-experience-append">';
			                	foreach ($list_experience as $key => $value) {
			                		$description = "";
			                		if(trim($value["description"]) != ""){
			                			if (strlen($value["description"]) <= 50) {
	                                        $description = "<span>" . $value["description"] . "</span>";
	                                    } else {
	                                        $description = "<span class='comment-item-text default-show block'>" . trim(substr(@$value["description"], 0, 50)) . "<span class='more btn btn-link' id='more-comment'>... MORE</span></span> 
	                                        <span class='comment-item-text default-hie'>" . $value['description'] . "<span class='more btn btn-link' id='more-comment'>LESS</span></span>";
	                                    }
			                		}
			                		$logo = ($value["logo"] != null) ? base_url($value["logo"]) : skin_url("images/logo-company.png");
			                		echo '
			                		<div class="col-sm-12 item-experience">
			                		    <div class="row">
					            		<div class="col-sm-2"><a class="text-white" href="#"><div class="img-circle" style="background-image:url('.$logo.')"></div></a></div>
					            		<div class="col-sm-10">
					            			<p><b>'.$value["job_title"].' | '.$value["company_name"].'</b></p>
					            			<p>'.date('F Y', strtotime($value["start_day"])).' - '.date('F Y', strtotime($value["end_day"])).'</p>
					            			<p class="text-comment">'.$description.'</p>
					            		</div>
					            		</div>
					            	</div>';
			                	}
			                	echo '</div>';
			                	if(@$list_experience_show == true)
			                		echo '<p class="text-center more-experience-now" id="box-bottom-more"><a href=""> MORE EXPERIENCE</a></p>';
			                }?>

			        	</div>
			        	
			        </div>
			    </div>
			    <div class="col-md-6">
					<div class="panel panel-default relative">
						<div class="panel-header">
			                <h2 class="panel-title">Education</h2>
			            </div>
			            <div class="row">
			                <?php if(@$list_education != null):?>
			                	<div class="lis-post-photo" id="box-list-education">
			                		<?php foreach ($list_education AS $key => $value):?>
			                			<?php $logo = ($value["logo"] != null) ? base_url($value["logo"]) : skin_url("images/logo-company.png"); ?>
			                			<div class="col-sm-12 item-experience">
			                			    <div class="row">
							            		<div class="col-sm-2"><a class="text-white" href="#"><div class="img-circle" style="background-image:url(<?php echo $logo;?>)"></div></a></div>
							            		<div class="col-sm-9">
							            			<p><strong><?php echo $value["school_name"];?></strong></p>
							            			<p><?php echo $value["major_degeer"];?></p>
							            			<p><?php echo date('F Y', strtotime($value["start_day"]));?> - <?php echo date('F Y', strtotime($value["end_day"]));?></p>	
							            		</div>
						            		</div>
						            	</div>
			                		<?php endforeach;?>
			                	</div>
			                	<?php if(@$list_education_show == true):?>
			                	<p class="text-center"><a id="more-education-now" href="">MORE EDUCATION</a></p>
			                	<?php endif;?>
			                <?php endif;?>  
				            
			            </div>
			            <hr>
			            <div class="row">
			               <div class="col-sm-12">
			               	<h3>Volunteen Experience & Causes</h3>
			               	<br>
			               </div>
			            	<?php if(@$list_volunteer != null):?>
			                	<div class="lis-post-photo" id="box-list-volunteer">
			                		<?php foreach ($list_volunteer AS $key => $value):?>
			                			<?php $logo = ($value["logo"] != null) ? base_url($value["logo"]) : skin_url("images/logo-company.png"); ?>
			                			<div class="col-sm-12 item-experience">
			                			    <div class="row">
							            		<div class="col-sm-2"><a class="text-white" href="#"><div class="img-circle" style="background-image:url(<?php echo $logo;?>)"></div></a></div>
							            		<div class="col-sm-9">
							            			<p><strong><?php echo $value["organization"];?></strong></p>
							            			<p><?php echo $value["role"];?></p>
							            			<p><?php echo date('F Y', strtotime($value["start_day"]));?> - <?php echo date('F Y', strtotime($value["end_day"]));?></p>	
							            		</div>
						            		</div>
						            	</div>
			                		<?php endforeach;?>
			                	</div>
			                	<?php if(@$list_volunteer_show == true):?>
			                	<p class="text-center" id="box-bottom-more"><a id="more-volunteer-now" href="">MORE</a></p>
			                	<?php endif;?>
			                <?php endif;?>   
				            
			            </div>	
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php $this->load->view("include/view_all_following");?>
<?php $this->load->view("include/view_all_my_follow");?>
<?php $this->load->view("include/modal_number_view_profile");?>
<?php $this->load->view("include/modal_activity");?>
<style type="text/css">
	#Personal_Contact_Info .modal-dialog{width: 670px;max-width: 100%;margin: 10px auto;}
	#Personal_Contact_Info .modal-header{background-color: #fff}
	.modal-header, .modal-footer{border: none!important;}
	#Personal_Contact_Info .modal-title{color: #333;margin-top: 10px;}
	.Personal_Contact_Info .form-group .form-control{margin-bottom: 10px;}
	.Personal_Contact_Info .media{margin-bottom: 10px;border-bottom: 3px solid #ccc;padding-bottom: 10px;padding-top: 10px}
	.Personal_Contact_Info .media:last-child{margin-bottom: 0;border: none;}
	.Personal_Contact_Info .form-group .control-label{padding: 0}
	.Personal_Contact_Info .btn-link{color: #339999;}
	.Personal_Contact_Info span{font-size: 14px;}
	.Personal_Contact_Info .form-control[disabled]{background-color: #ddd;cursor: not-allowed;padding: 5px 10px}
	.icon_load{display: none;}
	#Personal_Contact_Info .modal-footer .btn{padding: 12px}
	.img-circle{
	    width: 85px;
	    height: 85px;
	    background-size: cover;
	    background-position: center;
	    background-repeat: no-repeat;
	    max-width: 100%;
	}
	.list-wall .img-circle{
	    width: 50px;
	    height: 50px;
	}
    .list-wall-member .list-company-follow li{display: inline-block;}
	#Personal_Profile_Info .modal-dialog{width: 670px;max-width: 100%;margin: 10px auto;}
	#Personal_Profile_Info .modal-header{background-color: #fff}
	#Personal_Profile_Info .modal-title{color: #333;margin-top: 10px;}
	.Personal_Profile_Info .form-group .form-control{margin-bottom: 10px;}
	.Personal_Profile_Info .media{margin-bottom: 10px;border-bottom: 3px solid #ccc;padding-bottom: 25px;padding-top: 10px}
	.Personal_Profile_Info .media:last-child{margin-bottom: 0;border: none;}
	.Personal_Profile_Info .form-group .control-label{padding: 0}
	.Personal_Profile_Info .btn-link{color: #339999;text-decoration: none;font-size: 14px;font-weight: bold;}
	.Personal_Profile_Info .control-label{margin: 0;padding: 6px 0!important;line-height: 20px;}
	.Personal_Profile_Info span{font-size: 14px;}
	.Personal_Profile_Info .form-control[disabled]{background-color: #ddd;cursor: not-allowed;padding: 5px 10px}
	.error{color: red;font-size: 14px;border: none;}
	.alert-success .close{line-height: 20px;position: inherit;}
	.form-group .checkbox {padding: 0}
	.personal-login-info{color: #9E9E9E;margin: 0;padding-bottom: 25px;}
	.form-group .checkbox label{padding-left: 30px;}
	.form-group .checkbox input[type="checkbox"]:checked + label::after, .checkbox input[type="radio"]:checked + label::after{left: 25px!important;padding-top: 2px!important;}
	body #saveprofile_from .modal-footer .btn{padding: 5px 10px;}
	.btn-link{text-decoration: none;}
	.form-group .checkbox label#validate-show-check.error::before{border-color: red;}
    .lodding-update {position: absolute;left: 0;right: 0;top: 0;bottom: 0; cursor: wait;text-align: center;}
    .lodding-update img{max-height: 100%; margin:auto auto}
    body .list-company-follow li {position: relative;}
    body .list-company-follow li img{max-width: 65px; max-height: 65px;}
    .count-all-item{
    	font-size: 36px;
	    color: #9e9e9e;
	    position: absolute;
	    bottom: -35px;
	    left: 0;
    }
    body #share-modal .custom .check-yelow label::before {
	    margin-left: -20px;
	}
    body .custom .check-yelow label::before{margin-left: 3px;}
    .box-profile .item-profile #box-bottom-more{position: absolute;left: 0 ;bottom:0; right: 0; padding-top: 20px;}
    .item-profile .more-manufacturers { bottom: -15px; }
    .profile .item-profile  .panel{padding-bottom: 40px;}
    .item-experience{margin-bottom: 20px;}
    .item-experience p {margin-bottom: 0;}
    .list-wall-member .list-company-follow .more-list-item .background-child {
	    position: absolute;
	    top: 0;
	    background: rgba(0, 0, 0, 0.46);
	    width: 100%;
	    height: 100%;
	    color: #fff;
	    margin: 0;
	    transition: all .3s;
	}
	.list-wall-member .list-company-follow .number{
		margin-top: 20px;
		font-size: 18px;
	}
	.list-wall p.upgrade-account-link{font-size: 16px}
	#Personal_Profile_Info #saveprofile_from .checkbox label::before{
		margin-left: 5px;
	}
	.padding-bottom-0{padding-bottom: 0 !important;}
	body #crop-avatar .top-profile{
		margin-bottom: 45px;
    	margin-top: -120px;
	}
	.lis-post-photo{float: left;width: 100%;}
	.media-body{max-width: 100%;}
	#box-wall-working .more {font-size: 11px;}
	#box-wall-working .more {font-size: 11px;}
	.between-center{
		position: absolute;
	    top: 15px;
	    bottom: 15px;
	    left: 45%;
	    background-color: #ccc;
	    width: 2px;
	}
	body a b{color: #000 !important;}
	.modal .img-circle{width: 64px ;height:64px;}

	#activity .img-circle, #Activity_Pop_up .img-circle {
	    border: none;
	    border-radius: 0;
	}
	 </style>

<link rel="stylesheet" type="text/css" href="<?php echo skin_url("css/validatefrom.css")?>">
<script type="text/javascript" src="<?php echo skin_url("js/validatefrom.js");?>"></script>
<script type="text/javascript">
	$(".btn-change-pass").click(function(event){
	   event.preventDefault();
	   $('.password').prop("disabled", false); // Element(s) are now enabled.
	});

	$('#check').click(function(){
        if($(this).is(':checked')){
            $('.password').removeAttr('disabled');
        }else {
            $('.password').attr('disabled', true);
        }
    });

	$(window).load(function(){		
		$.each($(".box-profile .item-profile"),function(){
			var height = 0;
			$.each($(this).find("> .col-md-6"),function(){
				if($(this).find(".panel").innerHeight() > height){
					height = $(this).innerHeight();
				}
			});
			$.each($(this).find("> .col-md-6 > .panel"),function(){
				$(this).css("min-height",height+"px");
			});
		});
		$(".item-profile").css("opacity","1");
	});
	$(document).on("click",".lodding-update",function(e){
		e.stopPropagation();
		return false;
	});
	
    $(document).ready(function() { 
    	$("body #messenger-box").on("hidden.bs.modal",function(){
			$("body").addClass("modal-open");
		});
    	$('body #saveprofile_from').submit(function(){
    		var from_current = $(this); 
    		var check =  $(this).validatefrom({
    			message : {
    				"cfpassword": "Confirm passwork does not match Password",
    				"onchangepassword":"Please enter passwork or turn off check on change password"
    			},
	            before: function(check,options){
	                this.cfpasswork =function(){
	                	var pass = from_current.find("input[name='password']").val();
	                	var cfpass = from_current.find("input[name='confirm_password']").val();
	                	return (pass == cfpass);
	                }
	                this.phone = function ($pramte1,$pramte2,$pramte3,$pramte4){
	                	if($pramte2 != "" && $pramte2 != null){
	                        var filter = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im;
	                        return filter.test($pramte2);
	                    }
                    	return true;	
	                }   
	                this.onchangepasswork = function($pramte1,$pramte2,$pramte3,$pramte4){
		            	if( from_current.find("[name='checkbox']:checked").length > 0 ){
		            		 
		            		if ($pramte2 == "" || $pramte2 == null ) return false;
		            	}
		            	from_current.find("#validate-show-check").removeClass("error");	
		            	return true;
		            	
		            }        
	            },
	            beforeadderror :function (check,options,_childe,messege_error,validatefunction){
	                if(validatefunction == "onchangepassword"){
	                	if(check == false){
	                		from_current.find("#validate-show-check").addClass("error");
	                	}else{
	                		from_current.find("#validate-show-check").removeClass("error");	
	                	}
	                }       
	            },
	            afteradderror :function (check,options,_childe,messege_error,validatefunction){
	                
	            },
	            after : function(check,options){
	                
	            }
	        });
	        if(check == false) return check;
			$(this).ajaxSubmit({    			 
				dataType: 'json',
				beforeSubmit:function(){
					from_current.find("button[type = 'submit']").append('<div class="lodding-update"><img src="<?php echo base_url("/skins/icon/loader.gif"); ?>"></div>');		
				},
        		success:function(data){
        			if(data["status"] == "success"){
        				//messenger_box("Update profile","Update successfully");
        				var data_post = data["post"];
        				$.each(data_post,function(key,value){
        					$("body .panel [data-value='"+key+"']").text(value);
        				});
        			}else{
        				messenger_box("Update profile","Update not success! Please try again");
        			}
        			from_current.find(".lodding-update").remove();
        		},
        		error: function ( data ) {
           			messenger_box("Update profile","Error! Please try again");
        			from_current.find(".lodding-update").remove();
       		 	}
    		}); 
    		return false;
    	});        
    });
    $(document).on("click",".more-experience-now#box-bottom-more",function(){
    	var height = $("body .lis-post-photo#box-experience-append").outerHeight();
    	$("#box-experience-append").css({"max-height": height+"px","overflow-y":"auto"});
    	var items = $("body #box-experience-append").find(".item-experience").length;
    	var member_id = "<?php echo $member_id;?>";
    	var _this = $(this);
    	$.ajax({
    		url : base_url + "profile/more_experience",
    		type:"post",
    		dataType:"json",
    		data:{items : items,member_id:member_id},
    		success : function(res){
    			if(res["status"]== "success"){
    				$("#box-experience-append").append(res["reponse"]);
    				if(res["show"] == false){
    					_this.hide();
    				}
    			}
    		},error:function(){
    			alert("Error!");
    		}
    	})
    	return false;
   	});
   	$(document).on("click","#more-education-now",function(){
    	var height = $("body .lis-post-photo#box-list-education").outerHeight();
    	$("body .lis-post-photo#box-list-education").css({"max-height": height+"px","overflow-y":"auto"});
    	var items = $("body #box-list-education").find(".item-experience").length;
    	var member_id = "<?php echo $member_id;?>";
    	var _this = $(this);
    	$.ajax({
    		url : base_url + "profile/more_education",
    		type:"post",
    		dataType:"json",
    		data:{items : items,member_id:member_id},
    		success : function(res){
    			if(res["status"]== "success"){
    				$("body .lis-post-photo#box-list-education").append(res["reponse"]);
    				if(res["show"] == false){
    					_this.hide();
    				}
    			}
    		},error:function(){
    			alert("Error!");
    		}
    	})
    	return false;
   	});

   	$(document).on("click","#more-volunteer-now",function(){
    	var height = $("body .lis-post-photo#box-list-volunteer").outerHeight();
    	$("body .lis-post-photo#box-list-volunteer").css({"max-height": height+"px","overflow-y":"auto"});
    	var items = $("body #box-list-volunteer").find(".item-experience").length;
    	var member_id = "<?php echo $member_id;?>";
    	var _this = $(this);
    	$.ajax({
    		url : base_url + "profile/more_volunteer",
    		type:"post",
    		dataType:"json",
    		data:{items : items,member_id:member_id},
    		success : function(res){
    			if(res["status"]== "success"){
    				$("body .lis-post-photo#box-list-volunteer").append(res["reponse"]);
    				if(res["show"] == false){
    					_this.hide();
    				}
    			}
    		},error:function(){
    			alert("Error!");
    		}
    	})
    	return false;
   	});
</script>