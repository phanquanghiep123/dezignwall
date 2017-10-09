<div class="service_page">
<section class="section box-wapper-show-image box-wapper-secondary">
	<div class="container">
		<h2><strong>Business Services Directory</strong></h2>
	</div>
</section>

<section class="search-service">
	<div class="container">
		<p><strong>Find a local commercial service or pro:</strong></p>
		<form class="form-color" method="post" id ="formsearch_service">
			<div class="row">
				<div class="col-sm-7">
					<div class="form-group text-right"><input class="form-control" autocomplete="off" id="search-service" type="text" value="<?php echo @$_POST["search-service"]; echo @$slug;?>" name="search-service" placeholder="Start your search..."></div>
				</div>
				<div class="col-sm-5">
					<div class="form-group"><input class="form-control" id="search-city" autocomplete="off" type="text" value="<?php echo @$_POST["search-city"]?>" name="search-city" placeholder="Sort by city..."></div>
				</div>
			</div>
			<div class="form-group text-right">
				<a id="clear" for-parent="#formsearch_service" class="btn btn-gray">Clear</a>
				<button class="btn btn-primary">Search</button>
			</div>
		</form>
	</div>
</section>
<section class="box-wapper-show-image">
	<div class="container">
		<?php echo breadcrumb();?>
		<h1><?php echo @$number_items;?> results for <?php echo @ucfirst($business_type);?> <?php echo @$service_search;?> <?php echo (isset($city) && $city !="") ? "in ".$city : "";?><?php echo (isset($state) && $state !="") ? ", ".$state : "";?></h1>
		<div class="space-20"></div>
		 <?php if(isset($arg_record) && count($arg_record)>0){	
				foreach ($arg_record AS $key => $value){ ?>
					<?php 
						if($value["record"] != null && count($value["record"]) > 0 ){
							if(!is_numeric($key)){?><a href="<?php echo base_url("services/".$value["slug"]);?>"><h3><?php echo $key ;?></h3></a> <?php }
							  	foreach($value["record"] AS $value_record){?>
									<div class="company-item" id="wrapper-impormant-image" data-id ="<?php echo  $value_record["company"]["member_id"];?>">
										<div class="impromation-project">
											<div class="dropdown-impromation relative" id="services-report">
												<span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>
												<ul class="dropdown-impromation-menu">
												  <li><a href="#" data-reporting="company" data-name ="<?php echo $value_record["company"]["company_name"];?>" id ="share-image-email">Email Company</a></li>
												  <li><a  id="goto-microsite" href="<?php echo base_url("profile/index/".$value_record["company"]["member_id"]);?>" data-reporting ="member">Go to profile</a></li>
												  <li><a href="#" data-reporting ="member" id="post-comment">Post a comment</a></li>
												  <li><a href="<?php echo base_url("profile/myphoto/".$value_record["company"]["member_id"]);?>" data-reporting ="member">View images</a></li>
												  <li><a href="#" data-reporting ="member" id="report-company">Report this company</a></li>
												</ul>
											</div>
											<?php $img = ($value_record["company"]["logo"] != "" && file_exists(FCPATH.$value_record["company"]["logo"])) ? $value_record["company"]["logo"] : "skins/images/logo-company.png"; ?>
											<div class="logo-company"><img src="<?php echo base_url($img);?>"></div>
											<div class="impromation">
												<?php if($value_record["company"]["company_name"] !=""):?><h5><a id="goto-microsite" href="<?php echo base_url("profile/index/".$value_record["company"]["member_id"]);?>"><strong><?php echo $value_record["company"]["company_name"];?></strong></a></h5><?php endif;?>
												<?php if($value_record["company"]["business_description"] !=""):
													$business_description = trim($value_record["company"]["business_description"]);
													$business_description = str_replace(";","",$business_description);
													$before = strlen($business_description) - 1 ;
													$after  = $before + 1;
													if(substr( $business_description,$before,$after)==","){
														$business_description = substr($business_description,0,-1);
													};
													echo "<p>".$business_description."</p>";
												?>

												<?php endif;?>
											</div>
										</div>
										<div class="company-body">
											<div class="row gutter-2">
												<div class="col-sm-5 com company-body-left">
												<?php if( is_array($value_record["photo"]) && count($value_record["photo"])):?>
													<div class="company-content-box">
														<ul class="pgwSlideshow">
														    <?php foreach ($value_record["photo"] as $value_photo) {
														    	echo '<li><a id="goto-microsite" href ="'.base_url("photos/".$value_photo['photo_id']."/".gen_slug( $value_photo["name"])).'"><img src="'.base_url($value_photo["path_file"]).'" alt=""></a></li>';
														    }?>	
														</ul>
													</div>
												<?php endif?>
												</div>
												<div class="col-sm-7 company-body-right">
													<div class="company-content-box">
														<p><strong>Contact info</strong></p>
														<dl class="dl-horizontal"> 
														    <?php 
														    	$state =  ($value_record["company"]["state"] != "" ) ?	", ".$value_record["company"]["state"] :"";
														    ?>
															<dt>Toll free:</dt> <dd><?php echo @$value_record["company"]["company_800_number"] ;?></dd>
															<dt>Local phone:</dt> <dd><?php echo @$value_record["company"]["main_business_ph"] ;?></dd>
															<dt>City, State:</dt> <dd><?php echo @$value_record["company"]["city"];?><?php echo $state;?></dd>
														</dl>
														<p class="color-brand-primary"><a id="goto-microsite" href="<?php echo base_url("profile/index/".$value_record["company"]["member_id"]);?>">Microsite</a> | <a href="mailto: <?php echo $value_record["company"]["email"] ;?>">Email</a> | <a href="#" data-reporting="company" data-name ="<?php echo $value_record["company"]["company_name"];?>" id ="share-image-email">Share</a></p>
													</div>
													<div class="company-content-box" id="about">
														<p><strong>About</strong></p>
														<p id="hide_about"><?php echo (strlen($value_record["company"]["company_about"])> 110) ? substr($value_record["company"]["company_about"],0,110)."<a href='#' id='more-about'><strong> More...</strong></a>" : $value_record["company"]["company_about"];?></p>
														<?php echo (strlen($value_record["company"]["company_about"])> 110) ? "<p id='show_about'>".$value_record["company"]["company_about"]."<a href='#' id='more-about'><strong> Collapse...</strong></a></p>" : "";?>
													</div>
													<div class="row gutter-2 bottom-services">
														<div class="col-sm-7">
														    <div class="company-content-box expand-height"> 
														    <?php if( is_array( $value_record["comment"] ) && count( $value_record["comment"] ) > 0 ) : ?>
															    <?php foreach ($value_record["comment"] as $value_comment):?>								    
																	<div class="comment-item">
																		<a id="goto-microsite" href="<?php echo base_url("profile/index/".$value_comment["member_id"]);?>">
																		    <?php 
																		    	$img_logo =  ($value_comment["logo"] !="" && file_exists(FCPATH.$value_comment["logo"]) ) ? $value_comment["logo"] : "skins/images/signup.png";
																		    ?>
																			<img class="media-object" src="<?php echo base_url($img_logo);?>" alt="..." width="46" height="46">
																		</a>
																		<p><a id="goto-microsite" href="<?php echo base_url("profile/index/".$value_comment["member_id"]);?>"><strong><?php echo $value_comment["first_name"]." ".$value_comment["last_name"];?> | <?php echo $value_comment["company_name"];?></strong></a></p>
																		<p><?php echo $value_comment["comment"]; ?></p>
																	</div>
																<?php endforeach;?>
															<?php endif;?>
															</div>
														</div>
														<div class="col-sm-5">
															<div class="company-content-box">
																<div class="comment-like commen-like">
																	<div class="row">
																		<div class="col-xs-3 col-md-3 text-center">
																			<div class="likes relative">
																			    <?php $img = "" ; $title ="Click here to like.";?>
																				<?php foreach ($value_record["like"] as $key => $value) {
																					if($value["member_id"] == $user_id && $value["status"] == 1){
																						$img = "like";
																						$title ="Click here to unlike.";
																					}
																				}?>
																				<p><span id="number-like"><?php echo count($value_record["like"]); ?></span> Likes</p>
																				<h3 id="like-photo" data-id="<?php echo $value_record["company"]["member_id"]; ?>" data-object ="member"><i class="fa fa-heart <?php echo $img;?>" title="<?php echo $title;?>"></i></h3>
																			</div>
																		</div>
																		<div class="col-xs-3 col-md-3 text-center">
																			<div class="microsite relative">
																				<a id="goto-microsite" title="Go to microsite." href="<?php echo base_url("profile/index/".$value_record["company"]["member_id"]);?>"><h3><i class="fa fa-microsite"></i></h3></a>
																			</div>
																		</div>
																		<div class="col-xs-6 col-md-6">
																			<div class="comment relative">
																				<p><span id="num-comment"><?php echo count($value_record["comment"]);?></span> Comments</p>
																				<h3><span class="glyphicon glyphicon-comment" aria-hidden="true" title="Click here to comment."></span></h3>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div><!--end item-->
								<?php }	
							} ?>
				  <?php } ?>
		 <?php } ?>
		<?php if(isset($total_rows) && isset($perpage)):?>
			<div class="row">
				<form method="post" id="page_service">
					<input type="hidden" value="<?php echo @$_POST["search-service"]?>" name="search-service">
					<input type="hidden" value="<?php echo @$_POST["search-city"]?>" name="search-city">
					<input type="hidden" name="perpage" value="<?php echo @$perpage;?>">
					<div class="col-md-12 text-right"><?php echo paging($total_rows,$perpage);?></div>
				</form>
		   </div>
		<?php endif; ?>
	</div>
</section>
<?php if(isset($another_services) && count($another_services) > 0) :?>
	<?php foreach($another_services AS $key => $value):?>
		<section class="section box-wapper-secondary another">
			<div class="container">
				<h2><strong><?php echo $key;?></strong></h2>
			</div>
		</section>
		<?php if(count($value["record"]) > 0):?>
		<section class="box-wapper-show-image">
			<div class="container">
			    <?php foreach ($value["record"] AS $key_record => $value_record):?>
					<div class="company-item" id="wrapper-impormant-image" data-id ="<?php echo  $value_record["company"]["member_id"];?>">
						<div class="impromation-project">
							<div class="dropdown-impromation relative" id="services-report">
								<span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>
								<ul class="dropdown-impromation-menu">
								  <li><a href="#" data-reporting="company" data-name ="<?php echo $value_record["company"]["company_name"];?>" id ="share-image-email">Email Company</a></li>
								  <li><a  id="goto-microsite" href="<?php echo base_url("profile/index/".$value_record["company"]["member_id"]);?>" data-reporting ="member">Go to profile</a></li>
								  <li><a href="#" data-reporting ="member" id="post-comment">Post a comment</a></li>
								  <li><a href="<?php echo base_url("profile/myphoto/".$value_record["company"]["member_id"]);?>" data-reporting ="member">View images</a></li>
								  <li><a href="#" data-reporting ="member" id="report-company">Report this company</a></li>
								</ul>
							</div>
							<?php $img = ($value_record["company"]["logo"] != "" && file_exists(FCPATH.$value_record["company"]["logo"])) ? $value_record["company"]["logo"] : "skins/images/logo-company.png"; ?>
							<div class="logo-company"><img src="<?php echo base_url($img);?>"></div>
							<div class="impromation">
								<?php if($value_record["company"]["company_name"] !=""):?><h5><a id="goto-microsite" href="<?php echo base_url("profile/index/".$value_record["company"]["member_id"]);?>"><strong><?php echo $value_record["company"]["company_name"];?></strong></a></h5><?php endif;?>
								<?php if($value_record["company"]["business_description"] !=""):
									$business_description = trim($value_record["company"]["business_description"]);
									$business_description = str_replace(";","",$business_description);
									$before = strlen($business_description) - 1 ;
									$after  = $before + 1;
									if(substr( $business_description,$before,$after)==","){
										$business_description = substr($business_description,0,-1);
									};
									echo "<p>".$business_description."</p>";
								?>

								<?php endif;?>
							</div>
						</div>
						<div class="company-body">
							<div class="row gutter-2">
								<div class="col-sm-5 com company-body-left">
								<?php if( is_array($value_record["photo"]) && count($value_record["photo"])):?>
									<div class="company-content-box">
										<ul class="pgwSlideshow">
										    <?php foreach ($value_record["photo"] as $value_photo) {
										    	echo '<li><a id="goto-microsite" href ="'.base_url("photos/".$value_photo['photo_id']."/".gen_slug( $value_photo["name"])).'"><img src="'.base_url($value_photo["path_file"]).'" alt=""></a></li>';
										    }?>	
										</ul>
									</div>
								<?php endif?>
								</div>
								<div class="col-sm-7 company-body-right">
									<div class="company-content-box">
										<p><strong>Contact info</strong></p>
										<dl class="dl-horizontal"> 
										    <?php 
										    	$state =  ($value_record["company"]["state"] != "" ) ?	", ".$value_record["company"]["state"] :"";
										    ?>
											<dt>Toll free:</dt> <dd><?php echo @$value_record["company"]["company_800_number"] ;?></dd>
											<dt>Local phone:</dt> <dd><?php echo @$value_record["company"]["main_business_ph"] ;?></dd>
											<dt>City, State:</dt> <dd><?php echo @$value_record["company"]["city"];?><?php echo $state;?></dd>
										</dl>
										<p class="color-brand-primary"><a id="goto-microsite" href="<?php echo base_url("profile/index/".$value_record["company"]["member_id"]);?>">Microsite</a> | <a href="mailto: <?php echo $value_record["company"]["email"] ;?>">Email</a> | <a href="#" data-reporting="company" data-name ="<?php echo $value_record["company"]["company_name"];?>" id ="share-image-email">Share</a></p>
									</div>
									<div class="company-content-box" id="about">
										<p><strong>About</strong></p>
										<p id="hide_about"><?php echo (strlen($value_record["company"]["company_about"])> 110) ? substr($value_record["company"]["company_about"],0,110)."<a href='#' id='more-about'><strong> More...</strong></a>" : $value_record["company"]["company_about"];?></p>
										<?php echo (strlen($value_record["company"]["company_about"])> 110) ? "<p id='show_about'>".$value_record["company"]["company_about"]."<a href='#' id='more-about'><strong> Collapse...</strong></a></p>" : "";?>
									</div>
									<div class="row gutter-2 bottom-services">
										<div class="col-sm-7">
										    <div class="company-content-box expand-height"> 
										    <?php if( is_array( $value_record["comment"] ) && count( $value_record["comment"] ) > 0 ) : ?>
											    <?php foreach ($value_record["comment"] as $value_comment):?>								    
													<div class="comment-item">
														<a id="goto-microsite" href="<?php echo base_url("profile/index/".$value_comment["member_id"]);?>">
														    <?php 
														    	$img_logo =  ($value_comment["logo"] !="" && file_exists(FCPATH.$value_comment["logo"]) ) ? $value_comment["logo"] : "skins/images/signup.png";
														    ?>
															<img class="media-object" src="<?php echo base_url($img_logo);?>" alt="..." width="46" height="46">
														</a>
														<p><a id="goto-microsite" href="<?php echo base_url("profile/index/".$value_comment["member_id"]);?>"><strong><?php echo $value_comment["first_name"]." ".$value_comment["last_name"];?> | <?php echo $value_comment["company_name"];?></strong></a></p>
														<p><?php echo $value_comment["comment"]; ?></p>
													</div>
												<?php endforeach;?>
											<?php endif;?>
											</div>
										</div>
										<div class="col-sm-5">
											<div class="company-content-box">
												<div class="comment-like commen-like">
													<div class="row">
														<div class="col-xs-3 col-md-3 text-center">
															<div class="likes relative">
															    <?php $img = "" ;?>
																<?php foreach ($value_record["like"] as $key => $value) {
																	if($value["member_id"] == $user_id && $value["status"] == 1){$img = "like";}
																}?>
																<p><span id="number-like"><?php echo count($value_record["like"]); ?></span> Likes</p>
																<h3 id="like-photo" data-id="<?php echo $value_record["company"]["member_id"]; ?>" data-object ="member"><i class="fa fa-heart <?php echo $img;?>" title="Click here to like."></i></h3>
															</div>
														</div>
														<div class="col-xs-3 col-md-3 text-center">
															<div class="microsite relative">
																<a id="goto-microsite" title="Go to microsite." href="<?php echo base_url("profile/index/".$value_record["company"]["member_id"]);?>"><h3><i class="fa fa-microsite"></i></h3></a>
															</div>
														</div>
														<div class="col-xs-6 col-md-6">
															<div class="comment relative">
																<p><span id="num-comment"><?php echo count($value_record["comment"]);?></span> Comments</p>
																<h3><span class="glyphicon glyphicon-comment" aria-hidden="true" title="Click here to comment."></span></h3>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div><!--end item-->
				<?php endforeach;?>
			</div>
		</section>
		<?php endif;?>
    <?php endforeach;?>
<?php endif;?>
<?php $this->load->view("include/comment");?>

</div>