<style type="text/css">
	.icon-xs{font-size: 7px;position: relative;top: -2px;}
	.title{font-size: 14px;color: #777;margin: 5px 0;}
	#notifications {
		width: 650px;
	    max-width: inherit;
	    right: 0;
	    top: 103%;
	    position: absolute;
	    display: none;
	    opacity: 0;
	}
	#notifications .button-dw-event .btn{
		padding: 5px 7px;
		font-size: 16px;
	}
	#notifications .body-child h4 {text-align: left;}
	#notifications .media-body a{color: #565656;font-size: 13px;}
	#notifications .media-body a:hover{color: #399}
	#notifications .media-body{text-align: left;}
	#notifications .body-child{max-height: 460px;}
	#notifications a{color: #399;font-size: 16px;padding-left: 0;padding-right: 0;}
	.body-child{max-height: 700px;overflow-x: hidden;overflow-y: auto;}
	.body-child .body-child-main{
		margin-bottom: 10px;
	    border-bottom: 3px solid #ddd;
	    padding-bottom: 10px;
	    margin-right: 10px;
	}
	#notifications .media-body .color-blue{color: #399; font-size: 15px;}
	.body-child .body-child-main:last-child{border: none;}
	.body-child .body-child-main .btn-lg{font-size:18px; }
	#notifications .list-inline{margin: 0;display: inline-flex;}
	#notifications .btn-fix{position: relative;top: -20px;}
	.fix {display: inline-flex;}
	.fix li{margin-right: 25px;}
	#notifications{display: none;}
	#notifications .img-circle, .dw-event-body .img-circle{max-width: none;}
	#notifications.dw-event .dw-event-head {
	    background-color: #ffffff;
	    padding: 5px 15px;
	    border-radius: 0;
	    position: relative;
	}
	#notifications.dw-event .dw-event-head h4{
		color: #212121;
		text-align: left;
	}
	#notifications.dw-event #close-form {
	    position: absolute;
	    top: 0;
	    border: none;
	    background: rgba(255, 255, 255, 0);
	    font-weight: bold;
	    font-size: 20px;
	    outline: none;
	    right: 0;
	}
	#notifications .loadding-notifications{
		position: absolute;
		left: 0;
		right: 0;
		text-align: center;
	}
</style>

<div id="notifications" class="dw-event">
	<div class="dw-event-head relative">
	    <div class="loadding-notifications none"><img src="<?php echo base_url("/skins/images/facbook-loadding.gif");?>"></div>
		<h4>Notifications</h4> <button id="close-form"><b>x</b></button> </div>
	<div class="dw-event-body">
		<div class="body-child">
		    <?php $like_record = get_notifications_by_user(@$id,"like","photo",0,7);?>
		    <?php if($like_record  != null) :?>
				<div class="body-child-main">
				    <?php 						
						foreach ($like_record as $key_1 => $value) {
							if($key_1 < 6){
								$number_data = $value["number_data"];
								$list_record = get_notifications_by_type(@$id,$value["reference_id"],"like","photo");
								$tow_member = [];
								$avatar     = "";
								$created_at = "";
								$count_like  = "";
								if($list_record != null){
									foreach ($list_record as $key => $value) {

										if($key  == 0) {
											$created_at = date(DW_FORMAT_DATETIME, strtotime($value["created_at"]));
											$avatar = (isset($value["avatar"]) && $value["avatar"]!= "") ? base_url(@$value["avatar"]) : skin_url("images/avatar-full.png");
											if($number_data > 2){
												$count_like = "and ".($number_data - 2)." other ";
											}
										}
										$tow_member [] =  '<a href="'.base_url("profile/view/".$value["member_owner"]."").'">'.$value["first_name"]." " .$value["last_name"] ."</a>";
									}
								}
								echo '
								<div class="media">
									<div class="media-left"> <a href="'.base_url("profile/view/".$value["member_owner"]."").'"><img src="'.$avatar.'" class="img-circle notification-avatar"></a> </div>
									<div class="media-body">
										<h5 class="media-heading remove-margin">'.implode(", ", $tow_member).'</h5>
										<h5 class="remove-margin">'.$count_like.'people like your photo</h5> <span class="remove-margin color-blue">'.$created_at.'</span> 
									</div>
								</div>';
							}else{
								echo '<div class="row">
									<div class="col-sm-12 text-right"><a href="#" data-type="photo" data-object ="like" id="more-nofication" class="btn btn-link">MORE</a></div>
								</div>';
							}				
						}
					?>					
				</div>
			<?php endif;?>
			<?php $follow_record = get_follow_by_user(@$id,"follow","company",0,7);?>
		    <?php if($follow_record  != null) :?>
			<div class="body-child-main">
				<h4>Follow request </h4>
				<?php 
					foreach ($follow_record as $key_3 => $value) {
						$job_title = $value["job_title"];
						if($value["company_name"] != null)
						$job_title .= $job_title != "" ? ' | <a href="'.base_url("company/view/".$value["member_owner"]).'">'. $value["company_name"].'</a>' : '<a href="'.base_url("company/view/".$value["member_owner"]).'">'.$value["company_name"].'</a>';
						$created_at = date(DW_FORMAT_DATETIME, strtotime($value["created_at"]));
						$avatar = isset($value["avatar"]) && $value["avatar"]!= "" ? base_url(@$value["avatar"]) : skin_url("images/avatar-full.png");
						if($key_3 < 6){ ?>
							<div class="media">
								<div class="media-left"> <?php echo '<a href="'.base_url("profile/view/".$value["member_owner"]."").'">'; ?><img class="img-circle notification-avatar" src="<?php echo $avatar;?>"></a> </div>
								<div class="media-body">
									<div class="row">
										<div class="col-sm-8">
											<h5 class="media-heading remove-margin"><?php echo '<a href="'.base_url("profile/view/".$value["member_owner"]."").'">'.$value["first_name"]." " .$value["last_name"] ."</a>";?></h5>
											<h5 class=" title"><?php echo $job_title?></h5>
										</div>
										<div class="col-sm-4">
											<ul class="list-inline button-dw-event">
											    <?php 
												    $allow = "disabled";
													if($value["allow"] != 2){
														$allow = "";
													}
												?>
												<li><button id="delete-follow" data-id ="<?php echo $value["id"]?>" class="btn btn-default" <?php echo $allow;?> >Ignore</button></li>
												<?php 
												    $allow = "disabled";
													if($value["allow"] == 0){
														$allow = "";
													}
												?>
												<li><button id="confirm-follow" data-id ="<?php echo $value["id"]?>" class="btn btn-primary" <?php echo $allow;?> >Accept</button></li>
											</ul>
										</div>
									</div>
								</div>
							</div>	
						<?php } else { ?>
							<div class="row">
								<div class="col-xs-12 text-right"><a data-type="company" data-object ="follow" href="#" id="more-nofication" class="btn btn-link btn-lg">MORE</a></div>
							</div>
						<?php } ?> 	
					<?php 	} ?>
			</div>
		    <?php endif?>
			 
		</div>
	</div>
</div>
