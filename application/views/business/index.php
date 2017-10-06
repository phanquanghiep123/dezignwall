	<link rel="stylesheet" type="text/css" href="<?php echo skin_url("css/page/profile.css")?>">
	<?php
		$user_info = $this->session->userdata('user_info');
		$allow_edit = (isset($member) && isset($user_info) && $user_info['id'] == $member['id']) ? true : false;
		$data = null;
		if ($allow_edit) {
    		$data['menu_banner'] = array(
                array('href' => base_url('business/edit_rep_info'), 'title' => 'Edit profile', 'class' => ''),
                array('href' => base_url('business/view_profile'), 'title' => 'View profile', 'class' => ''),
                array('href' => base_url('profile/conversations'), 'title' => 'Your conversations', 'class' => '')
            );
    	}

	    $this->load->view("include/banner-wall.php", $data);

	?>
	<section class="section box-wapper-show-image">
		<div class="container">
			<div class="row row-height">
				<div class="col-sm-6">
					<div class="inner-height panel panel-default">
						<div class="panel-header">
							<h2 class="panel-title">Contact Info</h2>
						</div>
						<?php if (isset($company_info_sr) && is_array($company_info_sr)) : ?>
						<form class="form-horizontal form-large">
						    <div class="form-group">
						        <label class="col-sm-4 control-label">Toll free:</label>
						        <div class="col-sm-8">
						            <p class="form-control-static"><?php echo @$company_info_sr['number_800']; ?></p>
						        </div>
						    </div>
						    <div class="form-group">
						        <label class="col-sm-4 control-label">Local phone:</label>
						        <div class="col-sm-8">
						            <p class="form-control-static"><?php echo @$company_info_sr['main_business_ph']; ?></p>
						        </div>
						    </div>
						    <div class="form-group">
						        <label class="col-sm-4 control-label">Email:</label>
						        <div class="col-sm-8">
						            <p class="form-control-static"><a href="mailto:<?php echo @$company_info_sr['contact_email']; ?>"><?php echo @$company_info_sr['contact_email']; ?></a></p>
						        </div>
						    </div>
						    <div class="form-group">
						        <label class="col-sm-4 control-label">Website:</label>
						        <div class="col-sm-8">
									<?php 
										$url_site = $company_info['web_address'];
										$url_site = strpos($url_site,"http://") === FALSE ? "http://" . $url_site : $url_site;
									?>
						            <p class="form-control-static"><a href="<?php echo $url_site; ?>" target="_blank"><?php echo @$company_info['web_address']; ?></a></p>
						        </div>
						    </div>
						    <div class="form-group">
						        <label class="col-sm-4 control-label">Address:</label>
						        <div class="col-sm-8">
						            <p class="form-control-static"><?php echo @$company_info_sr['main_address']; ?></p>
						        </div>
						    </div>
						    <div class="form-group">
						        <label class="col-sm-4 control-label">City, State:</label>
						        <div class="col-sm-8">
						            <p class="form-control-static"><?php echo @$company_info_sr['city'].','.@$company_info_sr['state']; ?></p>
						        </div>
						    </div>

						    <div class="form-group">
						        <label class="col-sm-4 control-label">Zip code:</label>
						        <div class="col-sm-8">
						            <p class="form-control-static"><?php echo @$company_info_sr['zip_code']; ?></p>
						        </div>
						    </div>
						    <div class="form-group">
						        <label class="col-sm-4 control-label">Country:</label>
						        <div class="col-sm-8">
						            <p class="form-control-static">
						            	<?php
							            	 if(isset($company_info_sr['country']) && $company_info_sr['country']!=null ){
							            	 	$country = $this->config->item('country');
							            	 	echo $country[$company_info_sr['country']];
							            	 }
						            	?>
						            </p>
						        </div>
						    </div>
						    <div class="form-group">
						        <label class="col-sm-4 control-label">Local Reps:</label>
						        <div class="col-sm-8">
						            <p class="form-control-static"><a href="<?php echo base_url('profile/sales_reps/'.$company_info_sr['member_id']); ?>"><strong>View Local Reps/Locations</strong></a></p>
						        </div>

						    </div>
						</form>
						<?php endif; ?>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="inner-height panel panel-default">
						<div class="panel-header">
							<h2 class="panel-title">About</h2>
						</div>
						<form class="form-large">
							<div class="form-group">
								<textarea class="form-control" rows="14" readonly><?php echo @$member['company_about']; ?></textarea>
							</div>
						</form>
					</div>
				</div>
			</div><!--end row-->
			<?php if ($is_blog === 'no') : ?>
			<div class="row row-height">
				<div class="col-sm-6">
					<div class="inner-height panel panel-default profile">
						<div class="panel-header">
							<h2 class="panel-title remove-margin-bottom">Photos</h2>
							<div class="impromation-project" style="display:block;background: none;left:auto;top:-10px;">
				            	<div class="container relative">
					                <div class="impromation-project-dropdown">
					                    <div class="dropdown-impromation relative">
					                        <span class="glyphicon glyphicon-menu-down" aria-hidden="true" style="color:#212121;"></span>
					                        <ul class="dropdown-impromation-menu" style="background: #f1f1f1;min-width: 120px;" id="deziwall">
					                            <li><a href="<?php echo base_url('profile/myphoto/'.@$id_post); ?>">View all images</a></li>
					                            <li><a href="#" class="not-report" data-reporting="company" id="share-social" data-title ="<?php echo @$member['company_name']; ?>" data-type ="profile" data-id ="<?php echo $member["id"]; ?>">Share Profile</a></li>
					                        </ul>
					                    </div>
					                </div>
					            </div>
					        </div>
						</div>
						<?php if(isset($photos) && count($photos)>0): ?>
							<ul class="pgwSlideshow">
								<?php foreach ($photos as $key => $value):?>
							    	<li><a class="slider-item" name ="photo-<?php echo $value['photo_id'];?>" href="<?php echo base_url(); ?>photos/<?php echo $value['photo_id']; ?>/<?php echo gen_slug($value['name']);?>"><img src="<?php echo base_url(@$value['path_file']); ?>" alt="<?php echo @$value['name'] ?>"></a></li>
								<?php endforeach;?>
							</ul>
						<?php endif; ?>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="inner-height panel panel-default">
						<form class="form-large">
							<div class="panel-header">
								<h2 class="panel-title remove-margin-bottom">Certifications</h2>
							</div>
							<div class="form-group">
								<?php $certifications=json_decode(@$company_info['certifications'],true); ?>
								<p class="text-left">
								  <?php
								    if(count($certifications) > 0):
								  	  $image=json_decode(@$certifications['image'],true);
								  	  if(isset($image) && count($image) > 0){
								  		foreach ($image as $key => $value) { 
								  ?>	<span>
								  		 	<img src="<?php echo $value; ?>" style="height:100px;display:inline-block;margin-right:10px;margin-top:10px;">
								  		</span>
								  <?php	
								  		}
								  	  }
								  	endif;
								  ?>
								</p>
								<textarea class="form-control" rows="3" readonly><?php if(count($certifications) > 0){ echo @$certifications['text']; } else{ echo @$company_info['certifications'];} ?></textarea>
							</div>
							<div class="space-20"></div>
							<div class="panel-header">
								<h2 class="panel-title remove-margin-bottom">Service Areas</h2>
							</div>
							<div class="form-group">
								<textarea class="form-control" rows="6" readonly><?php echo @$company_info_sr['service_area']; ?></textarea>
							</div>
						</form>
					</div>
				</div>
			</div>
			<?php else:?>
    		<div class="row row-height">
	            <div class="col-sm-12">
	                <div class="inner-height panel panel-default relative profile">
	                    <div class="custom-loading"><img width="48" src="<?php echo skin_url(); ?>/images/loading.gif"></div>
	                    <div class="panel-header">
	                        <h2 class="panel-title remove-margin-bottom">Posted Articles</h2>                 
	                    </div>
	                    <?php if (isset($article) && count($article) > 0): ?>
	                    	<div class="bx-slider-edit">
                            <div class="slider-top">
                    			<ul class="bxsliders_edit">
                    			    <?php $page_slider = ""?>
                    			    <?php $i_page = 0;?>
    	                            <?php foreach ($article as $key => $value): ?>
    	                                <li data-id ="<?php echo $value["id"];?>">
    	                                    <div class="row">
    	                                		<div class="col-sm-6 slider-left"><img src="<?php echo @$value['thumbnail'] ?>" alt="<?php echo @$value['title'] ?>"></div>
    	                               			<div class="col-sm-6 slider-right">
    	                               				<p class="text-right"><?php echo date('F j, Y',strtotime($value['date_create'])); ?></p>
                                           			<h3 class="text-center" style="margin-bottom:10px;"><strong><?php echo $value['title']; ?></strong></h3>
    		                                        <div class="row" style="margin-bottom:10px;">
    		                                            <div class="col-sm-1 col-xs-4 avatar-slider text-center remove-padding">
    		                                                <?php 
    		                                                    $avatar = skin_url().'/images/avatar-full.png';
    		                                                    if(isset($value['avatar']) && $value['avatar'] != null && file_exists('.'.$value['avatar'])) {
    		                                                        $avatar = $value['avatar'];
    		                                                    }
    		                                                ?>
    		                                                <img width="60" style="display:inline-block;" class="circle" src="<?php echo $avatar; ?>">
    		                                            </div>
    		                                            <div class="col-sm-11 col-xs-8 profile-slider">
    		                                            <?php $full_name = @$value['first_name'] . " ". @$value['last_name'];
                                                            $user_info_bar = $full_name ;
                                                            if($value['company_name'] != ""){
                                                                $user_info_bar.= " | ".$value['company_name'];
                                                            }
                                                        ?>
    		                                                <p><strong><?php echo $user_info_bar; ?></strong></p>
    		                                                <p><?php echo @$value['job_title']; ?></p>
    		                                            </div>
    		                                        </div>
    	                                        	<p><?php echo substr(strip_tags($value['content']), 0, 450); ?> <a href="<?php echo base_url(); ?>article/post/<?php echo $value['id']; ?>">MORE</a></p>
    		                               		</div>
    		                               	</div>
    	                                </li>
    	                            	<?php $page_slider.= '<li><a data-slide-index="'.$i_page.'" href="#"><img src="'.@$value['thumbnail'].'"></a></li>'; ?>
                                            <?php $i_page++; ?>
    	                            <?php endforeach; ?>
                            	</ul>
                            </div>
                        	<div class="slider-bottom">
                                <ul id="bx-pager-edit">
                        	       <?php echo $page_slider;?>
                                </ul>
							</div>

                        </div>
	                        <div class="row">
	                            <div class="col-sm-12  text-right edit-profile" style="display: block;">
	                                <div class="space-20"></div>
	                                <a href="<?php echo base_url("article/index/".$member["id"]);?>" class="btn btn-primary">Click to View All</a>
	                            </div>
	                        </div>
	                    <?php endif; ?>
	                    <div class="space-20"></div>
	                    <!--<div class="text-right edit-profile">
	                      <button class="btn btn-gray clear-button">Clear</button>
	                      <button class="btn btn-primary">Click to Edit</button>
	                    </div>-->
	                </div>
	            </div>
	        </div>
        	<?php endif;?>
		</div>
	</section>
<style type="text/css">
	.form-group{margin-bottom: 0;}
</style>
<?php if ($is_blog === 'yes') : ?>
<script type="text/javascript">
	var mySider = $('.bxsliders_edit').bxSlider({
		pagerCustom: '#bx-pager-edit',
        auto:true,
        pause:4000,
        autoStart:true,
        onSlideNext:function($slideElement, oldIndex, newIndex){
            var id = $slideElement.attr("data-id");
            $("#goto-edit-post").attr("href",base_url+"article/edit/"+id);
            
        },
        onSlidePrev:function($slideElement, oldIndex, newIndex){
            var id = $slideElement.attr("data-id");
            $("#goto-edit-post").attr("href",base_url+"article/edit/"+id);
        }
	});
	var box_width = $(".bx-slider-edit").width();
    var width_img = box_width / 10;
    $("#bx-pager-edit").bxSlider({
        minSlides:10,
        maxSlides:10,
        slideWidth: width_img,
        pager:false
    });
</script>
<?php endif;?>