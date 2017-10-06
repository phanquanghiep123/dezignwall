<link rel="stylesheet" type="text/css" href="<?php echo skin_url("css/page/profile.css")?>">
<section class="section profile">
	<div id="crop-avatar">
		<div class="banner">
		    <?php 
		        $avatar = ( @$member['avatar'] != null ) ? base_url($member['avatar']) :  base_url("/skins/images/avatar-full.png");
		    	$banner = ( @$member['banner'] != null ) ? base_url($member['banner']) :  base_url("/skins/images/banner-profile.jpg");
		    ?>
			<div><img id="bannershow" style="width: 100% ;height: 365px;" src="<?php echo $banner ;?>"></div>
			<div class="profile-edit-photo custom-avatar">
	            <div class="profile-action-edit">
	                <a class="avatar-view text-white" data-type="banner" href="javascript:;" data-img="<?php echo $banner ;?>"><i class="fa fa-camera"></i> <small>  Edit background</small></a>
	            </div>
	        </div>
		</div>
		<div class="container">
			<div class="panel panel-default relative top-profile">
				<div class="avatar">
					<div class="profile-image">
	                    <div class="box-avatar">
	                    	<img id="avatarshow" class="media-object avatar-full" src="<?php echo $avatar; ?>" alt="..." width="162" height="162">
	                    	<div class="profile-edit-photo custom-avatar">
	                            <div class="profile-action-edit">
	                                <a class="avatar-view text-white" data-type="avatar" href="javascript:;" data-img ="<?php echo $avatar; ?>"><i class="fa fa-camera"></i> <small>  Change Image</small></a>
	                            </div>
	                        </div>
	                    </div>
	                </div>
				</div>
				<h2 class="text-center"><?php echo $member["first_name"];?> <?php echo $member["last_name"];?></h2>
				<h2 class="text-center"><a href="javascript:;"><i class="upgrade-account-link" id="Personal_Message_Popup_show" data-type="profile"><?php echo $member['post_messeger'] != null ? '"'.$member['post_messeger'].'"' : '"Post all message"'?></i></a></h2>
				<h2 class="text-center"><?php echo $member_company["business_description"];?> | <?php echo $member_company["company_name"];?></h2>
				<?php
				    $arglist_education = [];
					if(@$list_education){
						
						foreach ($list_education AS $key => $value){
							$arglist_education [] = $value["school_name"];
						}
					}
				?>
				<h4 class="text-center text-color-green"><?php echo $arglist_education == null ? "" : implode(" - ", $arglist_education);?></h4>
				<?php 
					$argAddress = (@$member['city'] != null) ? @$member['city'] . " &#8226; " : "";
					$argAddress .= (@$member['state'] != null) ? @$member['state'] . " &#8226; " : "";
					$argAddress .= (@$member['country'] != null) ? @$member['country'] : "";
				?>
				<h4 class="text-center text-color-green" id="set-address-data"><?php echo $argAddress;?></h4>
				<h4 class="text-center"><a href="javascript:;" style="color: #000;" id="Personal_Message_Popup_show" data-type="company"><?php echo ($member_company["post_messeger"] != null) ? $member_company["post_messeger"] : "Brief descripton of what you or your company does..." ?></a></h4>
				<div class="banner-button-share"> <a class="btn btn-gray" href="<?php echo base_url();?>/profile/download_impormation" download="">Download Contacts</a> <button class="btn btn-gray clear-button" data-title="abc company" onclick="document.location.href='<?php echo base_url("profile/reports");?>';" data-type="profile" data-id="1072">Reports</button> <button class="btn share_click" data-toggle="modal" data-target="#share-modal" data-title="abc company" data-type="profile" data-id="1072">Share Profile</button> </div>
			</div>
		</div>
		<?php $this->load->view("include/modal-cropper");?>
	</div>
	<div class="box-profile">
		<div class="container">
			<div class="row item-profile relative">
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
							<div class="col-md-6"><h3 class="upgrade-account-link"><a id="show_number_viewed_profile" href="javascript:;"><strong><?php echo $number_view_profile;?></strong></a></h3><p class="remove-margin">Who's viewed your profile</p></div>
							<div class="col-md-6">
							    <div class="row">
							    	<div class="col-md-6"><h3 class="upgrade-account-link text-center"><a id="show_number_follower_profile" href="javascript:;"><strong><?php echo $number_follow_profile ;?></strong></a></h3><p class="remove-margin text-center">Followers</p></div>
							    	<div class="col-md-6"><h3 class="upgrade-account-link text-center"><a id="show_number_following_profile" href="javascript:;"><strong><?php echo $number_my_follow_profile;?></strong></a></h3><p class="remove-margin text-center">Following</p></div>							    	
							    </div>	
							</div>
						</div>	
						<div class="between-center"></div>
					</div>
				</div>	
			</div>
			<div class="row item-profile">
				<div class="col-md-6">
					<div class="panel panel-default relative padding-bottom-0">
						<div class="panel-header">
			                <h2 class="panel-title">Personal Profile Info</h2>
			                <a href="#" class="panel-action" data-toggle="modal" data-target="#Personal_Profile_Info"><i class="fa fa-pencil"></i></a>
			            </div>
						<div  class="form-horizontal form-profile">
							<div class="form-group"> <label class="col-sm-5 control-label">First Name:</label>
								<div class="col-sm-7">
									<p data-value ="first_name" class="form-control-static view-profile"><?php echo @$member['first_name']; ?></p>
								</div>
							</div>
							<div class="form-group"> <label class="col-sm-5 control-label">Last Name:</label>
								<div class="col-sm-7">
									<p data-value ="last_name" class="form-control-static view-profile"><?php echo @$member['last_name']; ?></p>
								</div>
							</div>
							<div class="form-group"> <label class="col-sm-5 control-label">Personal Email:</label>
								<div class="col-sm-7">
									<p data-value ="email" class="form-control-static view-profile"><?php echo @$member['email']; ?></p>
								</div>
							</div>
							
							<div class="form-group"> <label class="col-sm-5 control-label">Password:</label>
								<div class="col-sm-7">
									<p class="form-control-static view-profile">xxxxxx</p>
								</div>
							</div>
							<div class="form-group"> <label class="col-sm-5 control-label">Confirm Password:</label>
								<div class="col-sm-7">
									<p class="form-control-static view-profile">xxxxxx</p>
								</div>
							</div>


							<div class="form-group"> <label class="col-sm-5 control-label">City/State/Country:</label>
								<div class="col-sm-7">
								    <ul id="data-adress" class="list-inline">
								    	<li><p data-value ="city" class="form-control-static view-profile"><?php echo @$member['city']; ?></p></li>
								    	<li> &#8226; </li>
								    	<li><p data-value ="state" class="form-control-static view-profile"><?php echo @$member['state']; ?></p></li>
								    	<li> &#8226; </li>
								    	<li><p data-value ="country" class="form-control-static view-profile"><?php echo @$member['country']; ?></p></li>
								    </ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="panel panel-default relative padding-bottom-0">
						<div class="panel-header">
							<h2 class="panel-title">Contact Info</h2> 
							<a class="panel-action" href="#" data-toggle="modal" data-target="#Personal_Contact_Info"><i class="fa fa-pencil"></i></a>
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
			</div>
			<div class="row item-profile">
				<div class="col-md-6">
					<div class="panel panel-default relative padding-bottom-0" id="your_follow_box">
						<div class="panel-header">
			                <h2 class="panel-title">Companies You Follow</h2>
			            </div>	
			            <?php if(@$follow_record != null):?>
				            <ul class="list-company-follow">
				                <?php foreach ($follow_record as $key => $value) {
				                	if($key  <= 15){
				                	$avatar = isset($value["logo"]) && $value["logo"]!= "" ? base_url(@$value["logo"]) : skin_url("images/logo-company.png");
				                ?>
				                	<li>
				            			<a title="<?php echo $value["company_name"]?>" class="text-white" href="<?php echo base_url("company/view/".$value["member_id"]."")?>" ><img class="img-circle" src="<?php echo $avatar;?>"></a>
				            		</li>
				                <?php }}?>
				                <?php if($count_follow_company > 0):?>
				                	<li>
				            			<p class="count-all-item">+<?php echo $count_follow_company;?></p>
				            		</li>
				                <?php endif;?>
				            </ul>
				            <?php if($count_follow_company > 0):?>
				            <div id="more-follow" class="more-manufacturers"><a href="#" class="btn btn-primary">MORE</a></div>
				            <?php endif;?>
			        	<?php endif;?>
					</div>
				</div>
				<div class="col-md-6">
					<div class="panel panel-default relative padding-bottom-0" id="follow_you_box">
						<div class="panel-header">
			                <h2 class="panel-title">Your Favorite Companies</h2>
			            </div>	
			            <?php if(@$my_follow_company != null):?>
			            	<ul class="list-company-follow">
				                <?php foreach ($my_follow_company as $key => $value) {
				                	if($key  <= 15){
				                	$avatar = isset($value["logo"]) && $value["logo"]!= "" ? base_url(@$value["logo"]) : skin_url("images/logo-company.png");
				                ?>
				                	<li>
				            			<a title="<?php echo $value["company_name"]?>" class="text-white" href="<?php echo base_url("company/view/".$value["member_id"]."")?>" ><img class="img-circle" src="<?php echo $avatar;?>"></a>
				            		</li>
				                <?php } }?>
				                <?php if($count_my_follow_company > 0):?>
				                	<li>
				            			<p class="count-all-item">+<?php echo $count_my_follow_company;?></p>
				            		</li>
				                <?php endif;?>
				            </ul>
				            <?php if($count_my_follow_company > 0):?>
				            <div id="more-follow" class="more-manufacturers"><a href="#" class="btn btn-primary">MORE</a></div>
				            <?php endif;?>
			        	<?php endif;?>
					</div>
				</div>
			</div>
			<div class="row item-profile">
				<div class="col-md-6">
					<div class="panel panel-default relative" id="box-wall-working">
						<div class="panel-header">
			                <h2 class="panel-title">Projects You Are Working On</h2>
			            </div>
			            <?php if(isset($list_project)):?>
			            	<?php foreach ($list_project AS $key => $value):?>
			            		<div class="row">
					            	<div class="col-sm-7">
					            		<div class="list-wall-member">
					            			<h4 class="upgrade-account-link"><?php echo $value["project_name"]?></h4>
					            			<?php if(@$value["folder"] != null){?>
					            			    <p>Recently added images:</p>
					            			    <ul class="list-company-follow">
						            				<?php foreach ($value["folder"] as $key_1 => $value_1) { ?>
						            				        <?php  $avatar = isset($value_1["thumb"]) && $value_1["thumb"]!= "" ? base_url(@$value_1["thumb"]) : base_url(@$value_1["path_file"]); ?>
										            	    <?php if($key_1 >= 4 ):?>
										            		<?php if(($value["countfolder"] - 5) > 0) :?>
											            		<li>
							                                        <div class="more-list-item">
							                                            <a href="<?php echo base_url("designwalls/photos/".$value["project_id"]."/".$value_1["category_id"])?>"><img width="82px" height="82px" class="media-object" src="<?php echo $avatar;?>"></a>
							                                            <a href="<?php echo base_url("designwalls/view/".$value["project_id"])?>" class="list-inline background-child">
							                                                <ul class="list-inline number">
							                                                    <li>+<?php echo ($value["countfolder"] - 5);?></li>
							                                                </ul>
							                                            </a>
							                                        </div>
							                                    </li>
							                                <?php endif;?>
						                                    <?php else : ?>
						                                 	<li>
							            						<a href="<?php echo base_url("designwalls/photos/".$value["project_id"]."/".$value_1["category_id"])?>"><img width="82px" height="82px" class="media-object" src="<?php echo $avatar;?>"></a>
											            	</li>
										                <?php endif;?>
						            				<?php } ?>
					            				</ul>
					            			<?php }?>
					            			</ul>
					            		</div>
					            	</div>
					            	<div class="col-sm-5">
					            	    <?php if(@$value["lastupdate"] != null ):?>
					            	    <?php  
					            	    if (strlen($value["lastupdate"]["comment"]) <= 50) {
	                                        $comment = "<span>" . $value["lastupdate"]["comment"] . "</span>";
	                                    } else {
	                                        $comment = "<span class='comment-item-text default-show block'>" . trim(substr($value["lastupdate"]['comment'], 0, 50)) . "<span class='more btn-link' id='more-comment'>... MORE</span></span> 
	                                        <span class='comment-item-text default-hie'>" . $value["lastupdate"]['comment'] . "<span class='more btn-link' id='more-comment'> LESS</span></span>";
	                                    }  
					            	    ?>
					            	    <?php  $avatar = isset($value["lastupdate"]["avatar"]) && $value["lastupdate"]["avatar"]!= "" ? base_url(@$value["lastupdate"]["avatar"]) : skin_url("images/avatar-full.png"); ?>
					            	    <p>Updates:</p>
					            		<div class="row">
							            	<ul class="list-wall">
						            			<li> 
						            				<div class="col-sm-3"><a class="text-white" href="<?php echo base_url("profile/view/".$value["lastupdate"]["id"]);?>"><div class="img-circle" style="background-image:url(<?php echo $avatar;?>)"></div></a></div>
						            				<div class="col-sm-9">
						            					<p class="upgrade-account-link"><?php echo date('Y F d h:i a', strtotime($value["lastupdate"]["created_at_comment"])) ?></p>
						            					<p class="text-comment"><?php echo $comment; ?></p>  
						            				</div>
						            			</li>
						            		</ul>	
					            		</div>
					            		<?php endif;?>	
					            		<h4 class="text-right"><a href="<?php echo base_url("designwalls/view/".$value["project_id"])?>" class="btn btn-primary">Go to project</a></h4>		            		
					            	</div>
					            </div>
					            <?php if($key == 0):?>
					            	<hr style="margin-top: 30px; margin-bottom: 24px;">
					            <?php endif;?>
			            	<?php endforeach;?>
			        	<?php endif;?>
			        	<?php if ($show_more_walls != 0 && isset($list_project)) : ?>
			            	<p class="text-center" id="box-bottom-more"><a href="">MORE PROJECTS <?php echo $show_more_walls?></a></p>
						<?php endif;?>
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
				            				
				                		?>
				                		<div class="col-sm-12 item-experience">
					                		<div class="row">
					                			<?php  
					                				$avatar = isset($value["logo"]) && $value["logo"] != "" ? base_url(@$value["logo"]) : skin_url("images/logo-company.png"); 
					                				if($value["type"] == "photo"){
					                					$avatar = $value["photo_thumb"];
					                				}
					                			?>
							            		<div class="col-sm-2"><a class="text-white" href="<?php echo base_url("company/view/" . $value['member_id']);?>"><div class="img-circle" style="background-image:url(<?php echo $avatar;?>)"></div></a></div>
							            		<div class="col-sm-10">
							            		    <?php if($value["type"] == "photo"):?>
							            			<p><a href="<?php echo base_url("photos/" . $value['photo_id'] . "/" . gen_slug($value["name"]));?>"><b><?php echo $value["name"];?></b></a></p>						            			
							            			<?php else:?>
							            			<p><a href="<?php echo base_url("company/view/" . $value['member_id']);?>"><b><?php echo $value["company_name"];?></b></a></p>
							            			<?php endif;?>
							            			<p>by <a href="<?php echo base_url("company/view/".$value["member_id"]);?>"><b><?php echo $value["company_name"]?></b></a> on <?php echo date('F d\, Y \a\t g:ia', strtotime($created_at_object)); ?></p>
							            			<?php $value["type"] = str_replace("photo","image",$value["type"]) ; ?>
							            			<p class="upgrade-account-link"><?php echo $type_object;?> <?php echo $value["type"] ;?> on date - <?php echo date('F d\, Y \a\t g:ia', strtotime($value["enter_active"])) ?></p>
							            		</div>
							            	</div>	
						            	</div>	 
				                		<?php }
				                	}
				                ?>
				            </ul>
			        	</div>
			        	<?php if (@$active_show_more && @$get_active != null) : ?>
			        		<p class="text-center" id="box-bottom-more"><a href="">MORE Activity</a></p>
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
			            	<a id="get_experience" class="panel-action" href="#"><i class="fa fa-pencil"></i></a>
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
	                                        $description = "<span class='comment-item-text default-show block'>" . trim(substr(@$value["description"], 0, 50)) . "<span class='more btn-link' id='more-comment'>... MORE</span></span> 
	                                        <span class='comment-item-text default-hie'>" . $value['description'] . "<span class='more btn-link' id='more-comment'> LESS</span></span>";
	                                    }
			                		}
			                		$logo = ($value["logo"] != null) ? base_url($value["logo"]) : skin_url("images/logo-company.png");
			                		if($key == 0){
			                			$current_admin = '<span style="color:#f90"> &#9679; Profile admin</<span>';
			                		}else{
			                			$current_admin = "";
			                		}
			                		echo '
			                		<div class="col-sm-12 item-experience">
			                		    <div class="row">
					            		<div class="col-sm-2"><a class="text-white" href="#"><div class="img-circle" style="background-image:url('.$logo.')"></div></a></div>
					            		<div class="col-sm-10">
					            			<p><b>'.$value["job_title"].' | '.$value["company_name"].'</b>'.$current_admin.'</p>
					            			<p>'.date('F Y', strtotime($value["start_day"])) .' - '.date('F Y', strtotime($value["end_day"])). get_diff_year($value["start_day"],$value["end_day"]).'</p>
					            			<p class="text-comment">'.$description.'</p>
					            		</div>
					            		</div>
					            	</div>';
			                	}
			                	echo '</div>';
			                	if(@$list_experience_show == true && isset($list_experience))
			                		echo '<p class="text-center more-experience-now" id="box-bottom-more"><a href=""> MORE Experience</a></p>';
			                }?>
			        	</div>
			        </div>
			    </div>
			    <div class="col-md-6">
					<div class="panel panel-default relative">
						<div class="panel-header">
			                <h2 class="panel-title">Education</h2>
			            	<a id="get_education" class="panel-action" href="#"><i class="fa fa-pencil"></i></a>
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
							            			<p><?php echo date('Y F d', strtotime($value["start_day"]));?> - <?php echo date('Y F d', strtotime($value["end_day"]));?><?php echo get_diff_year($value["start_day"],$value["end_day"]);?></p>	
							            		</div>
						            		</div>
						            	</div>
			                		<?php endforeach;?>
			                	</div>
			                	<?php if(@$list_education_show == true && @$list_education != null):?>
			                	<p class="text-center"><a id="more-education-now" href="">MORE EDUCATION</a></p>
			                	<?php endif;?>
			                <?php endif;?>  
				            
			            </div>
			            <hr>
			            <div class="row">
			               <div class="col-sm-12">
			               	<h3>Volunteer Experience & Causes</h3>
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
							            			<p><?php echo date('Y F d', strtotime($value["start_day"]));?><?php echo get_diff_year($value["start_day"],$value["end_day"]);?></p>	
							            		</div>
						            		</div>
						            	</div>
			                		<?php endforeach;?>
			                	</div>
			                	<?php if(@$list_volunteer_show == true && @$list_volunteer != null):?>
			                	<p class="text-center" id="box-bottom-more"><a id="more-volunteer-now" href="">MORE Volunteer Experience</a></p>
			                	<?php endif;?>
			                <?php endif;?>   				            
			            </div>	
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="Personal_Profile_Info" class="modal fade" role="dialog">
		<div class="modal-dialog">
		    <!-- Modal content-->
		    <div class="modal-content">
		        <div class="modal-header">
		            <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
		            <h2 class="modal-title"><b>Personal Profile Info</b></h2>
		        </div>
		        <form id="saveprofile_from" action="<?php echo base_url()."profile/update" ?>" method="post" class="Personal_Profile_Info">
			        <div class="modal-body">
			            <div class="media">
		                    <div class="media-body">
		                        <div class="form-group">
		                            <label class="col-sm-4 control-label"><small>Firts Name*:</small></label>
		                            <div class="col-sm-8 remove-padding">
		                                <input validate data-validate="required" type="text" class="first_name form-control" value="<?php echo @$member['first_name']; ?>" name="first_name" placeholder="Your firts name...">
		                            </div>
		                        </div>

		                        <div class="form-group">
		                            <label class="col-sm-4 control-label"><small>Last Name*:</small></label>
		                            <div class="col-sm-8 remove-padding">
		                                <input validate data-validate="required" type="text" class="last_name form-control" value="<?php echo @$member['last_name']; ?>" name="last_name" placeholder="Your last name...">
		                            </div>
		                        </div>

		                        <div class="form-group">
		                            <label for="work-company" class="col-sm-4 control-label"><small>City:</small></label>
		                            <div class="col-sm-8 remove-padding">
		                                <input type="text" class="city form-control" value="<?php echo @$member["city"]; ?>" name="city" placeholder="City your live in...">
		                                <span class="error"><?php echo form_error('city'); ?></span>
		                            </div>
		                        </div>

		                        <div class="form-group">
		                            <label for="work-company" class="col-sm-4 control-label"><small>State*:</small></label>
		                            <div class="col-sm-8 remove-padding">
		                                <input validate data-validate="required" type="text" class="state form-control" value="<?php echo @$member["state"]; ?>" name="state" placeholder="State your live in...">
		                            </div>
		                        </div>

		                        <div class="form-group">
		                            <label for="work-company" class="col-sm-4 control-label"><small>Country*:</small></label>
		                            <div class="col-sm-8 remove-padding">
		                                <input validate data-validate="required" type="text" class="country form-control" value="<?php echo @$member["country"]; ?>" name="country" placeholder="Country your live in...’s name...">
		                            </div>
		                        </div>
		                    </div>
		                </div>
		                <div class="media">
		                	<h3 class="personal-login-info">Private Log-in Information</h3>
		                    <div class="media-body">
		                        <div class="form-group disable">
		                            <label class="col-sm-4 control-label"><small>Personal Email*:</small></label>
		                            <div class="col-sm-8 remove-padding">
		                                <input validate data-validate="email" disabled type="text" class="form-control" value="<?php echo @$member['email']; ?>" placeholder="Your personal email...">
		                            </div>
		                        </div>
		                        <div class="form-group disable">
		                            <label class="col-sm-4 control-label"><small>Password*:</small></label>
		                            <div class="col-sm-8 remove-padding">
		                                <input validate data-validate="onchangepassword|min:6" type="password" class="passwork form-control " disabled="true" name="password" placeholder="Your password...">
		                            </div>
		                        </div>
		                        <div class="form-group">
		                            <label for="work-company" class="col-sm-4 control-label"><small>Confirm Password*:</small></label>
		                            <div class="col-sm-8 remove-padding">
		                                <input type="password" validate data-validate="cfpassword|min:6" class="passwork form-control" disabled="true" name="confirm_password" placeholder="Confirm your password...">
		                                <div class="checkbox">
		                                	<span>Need to change your password? </span>
					                        <a href="<?php echo base_url("accounts/forgot");?>" id="validate-show-check" for="check" class="btn-link"> Click Here</a>
					                    </div>
		                            </div>
		                        </div>
		                    </div>
		                </div>
			        </div>
			        <div class="modal-footer">
			        	<button type="button" class="btn btn-link success text-right"></button>
			        	<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			            <button type="submit" name="UpdatePersonal" class="btn btn-primary relative">Save/Update</button>
			        </div>
			    </form>
		    </div>
		</div>
	</div>
	<div id="Personal_Contact_Info" class="modal fade" role="dialog">
		<div class="modal-dialog">
		    <!-- Modal content-->
		    <div class="modal-content">
		        <div class="modal-header">
		            <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
		            <h2 class="modal-title"><b>Personal Contact Info</b></h2>
		        </div>
		        <form id="saveprofile_from" method="post" action="<?php echo base_url()."profile/update" ?>"  class="Personal_Contact_Info">
		        	<input type="hidden" name="form2" value="Norway">
			        <div class="modal-body">
			            <div class="media">
		                    <div class="media-body">
		                        <div class="form-group">
		                            <label class="col-sm-4 control-label"><small>Work Email:</small></label>
		                            <div class="col-sm-8 remove-padding">
		                                <input type="text" validate data-validate="email" class="form-control format-phone" name="work_email" value="<?php echo @$member["work_email"]; ?>" placeholder="Your work email...">
		                            </div>
		                        </div>

		                        <div class="form-group">
		                            <label class="col-sm-4 control-label"><small>Work Phone:</small></label>
		                            <div class="col-sm-8 remove-padding">
		                                <input type="text" validate data-validate="phone" class="work_ph form-control format-phone" name="work_ph" value="<?php echo @$member["work_ph"]; ?>" placeholder="Your work phone number...">
		                            </div>
		                        </div>

		                        <div class="form-group">
		                            <label for="work-company" class="col-sm-4 control-label"><small>Cell Phone:</small></label>
		                            <div class="col-sm-8 remove-padding">
		                                <input type="text" validate data-validate="phone" class="cellphone form-control" name="cellphone" id="cellphone" value="<?php echo @$member["cellphone"]; ?>" placeholder="(Optional) Your cell phone number...">
		                            </div>
		                        </div>

		                        <div class="form-group">
		                            <label for="work-company" class="col-sm-4 control-label"><small>Dezignwall Handle:</small></label>
		                            <div class="col-sm-8 remove-padding">
		                                <input type="text" class="designWall_handel form-control" name="designWall_handel" value="<?php echo @$member["designWall_handel"]; ?>" placeholder="@FirstLastName (no spaces, case sensitive)...">
		                            </div>
		                        </div>

		                        <div class="form-group">
		                            <label for="work-company" class="col-sm-4 control-label"><small>Twitter Handle:</small></label>
		                            <div class="col-sm-8 remove-padding">
		                                <input type="text" class="twitter_handel form-control" name="twitter_handel" value="<?php echo @$member["twitter_handel"]; ?>" placeholder="Your Twittter handle (@Name)...">
		                            </div>
		                        </div>

		                        <div class="form-group">
		                            <label for="work-company" class="col-sm-4 control-label"><small>Instagram Handle:</small></label>
		                            <div class="col-sm-8 remove-padding">
		                                <input type="text" class="instagram_handel form-control" name="instagram_handel" value="<?php echo @$member["instagram_handel"]; ?>" placeholder="Your Instagram handle (@Name)...">
		                            </div>
		                        </div>
		                    </div>
		                </div>
			        </div>
			        <div class="modal-footer">
			        	<button type="button" class="btn btn-link success text-right"></button>
			            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			            <button type="submit" name="UpdateContact" class="btn btn-primary relative">Save/Update</button>
			        </div>
			    </form>
		    </div>
		</div>
	</div>
	<?php $this->load->view("include/view_all_following");?>
	<?php $this->load->view("include/view_all_my_follow");?>
	<?php $this->load->view("include/modal_number_view_profile");?>
	<?php $this->load->view("include/model_follow_company");?>
	<?php $this->load->view("include/model_follow_you_company");?>
	<?php $this->load->view("include/model_more_wall");?>
	<?php $this->load->view("include/modal_activity");?>
	<?php $this->load->view("include/modal-experience");?>
	<?php $this->load->view("include/modal_education");?>
	<?php $this->load->view("include/modal_messeger_post");?>
	<?php $this->load->view("include/getting-started-popup"); ?> 
</section>
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
	    border: 1px solid #399;
	}
	.list-wall .img-circle{
	    width: 50px;
	    height: 50px;
	}
    #activity .img-circle, #Activity_Pop_up .img-circle {
	    width: 85px;
	    height: 85px;
	    background-size: cover;
	    background-position: center;
	    background-repeat: no-repeat;
	    border: none;
	    border-radius: 0;
	}
    .list-wall-member .list-company-follow li{display: inline-flex;}
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
    .box-profile .item-profile #box-bottom-more{position: absolute;left: 0 ;bottom:0; right: 0; padding-top: 20px;text-transform: uppercase;}
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
    body #crop-avatar .profile-edit-photo.custom-avatar{display: block;}
    body #crop-avatar .profile-edit-photo.custom-logo a, 
    body #crop-avatar .profile-edit-photo.custom-avatar a{
    	display: block;
    	height: 35px
    }
    body #crop-avatar .profile-edit-photo .profile-action-edit{
    	display: block;
    }
    body #crop-avatar .banner .avatar-view {
    	margin: 0 auto;
    }
    #crop-avatar .profile-edit-photo{
    	top: 30%
    }
    #crop-avatar .banner .profile-edit-photo.custom-avatar{top: 25px !important }
    body .form-horizontal .control-label.text-center{text-align: center !important;}
    body .profile .modal-header {
	    background-color: #fff;
	    width: 100%;
	    border-top-left-radius: 0;
        border-top-right-radius: 0;
	}
	body .profile .modal-content{
		border-radius: 0;
	}
	body .profile .modal-title {
	    font-size: 30px;
	    color: #000;
	}
	body .profile .modal button.close {
	    font-size: 40px;
	    color: #000;
	    opacity: 1;
	    position: absolute;
	    right: 10px;
	    top: 5px;
	    z-index: 9;
	}
	hr{float: left;width: 100%;}
	#box-experience-common .work-add{line-height: 0;}
	@media screen and (max-width: 788px){
		body #more-follow a.btn{
	        font-size: 13px;
	    }
	}
	.modal-body .media .media-heading{
		color: #333;
	    font-size: 15px;
	    line-height: 2;
	}
	.remove-items{position: absolute; right: 0; top: 5px; color: #000; cursor: pointer; font-size: 22px;}
	.remove-items:hover{color: #ccc;}
	.work-item{position: relative; float: left;width: 100%;}
	.work-item hr {margin: 0px 0 40px;}
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
    				"phone"     : "Please enter telephone number (ex: (xxx) xxx-xxxxx)",
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
        				from_current.parents(".modal").modal("hide");
        			}else{
        				messenger_box("Update profile","Update not success! Please try again");
        			}
        			from_current.find(".lodding-update").remove();
        			var address = $(".form-profile ul#data-adress").text();
        			$("body .profile #set-address-data").html(address);
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
   	$(document).on("click","body .modal .remove-items",function(){
   		var id = $(this).attr("data-id");
   		var type = $(this).attr("data-type");
   		if(id != 0){
   			var _this = $(this);
   			$.ajax({
   				url  : base_url + "profile/commondelete",
   				data : {id : id ,type:type},
   				type : "post",
   				dataType:"json",
   				success:function(res){
   					if(res["status"]== "error"){
   						alert(res["message"]);
   					}else{
   						_this.parent().remove();
   					}
   				},error : function(){
   					alert("Error!");
   				}
   			});
   		}else{
   			$(this).parent().remove();
   		}
   		return false;
   	});

</script>

<?php if (isset($status_member) && $status_member == 0): ?>
    <script>
        $("#getting-started-popup").modal();
        $("#business-profile").click(function () {
            $.each($(".panel-action"), function () {
                $("#getting-started-popup").modal("hide");
                $(this).trigger("click");
            });
            return false;
        });      
    </script>
<?php endif; ?>