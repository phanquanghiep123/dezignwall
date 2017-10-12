    <link rel="stylesheet" type="text/css" href="<?php echo skin_url("css/page/profile.css")?>">
	<?php
	    $this->load->view("include/banner.php", $member);
	?>

	<section class="section box-wapper-show-image">
		<div class="container">
		    <div class="row row-height">
		    	<div class="col-sm-12">
					<div class="inner-height panel panel-default box-manufacturers">
						<div class="panel-header">
							<h2 class="panel-title">Product Catalogs</h2>
							<ul class=" manufacturers list-inline custom required-group">
                        	<?php if(@$manufacturers != "" && is_array($manufacturers)):?>  	
                               	<?php 
                               	$i = 0;
                               	foreach($manufacturers AS $value):?>
                               		<li>   
                                        <a href="#" id="view-catalog" data-id="<?php echo $value["id"] ?>"><img src="<?php echo base_url($value["logo"]);?>"></a>
                                    </li>
                               	<?php endforeach;?>
                                <?php endif?>
                            </ul>
                            <div class="more-manufacturers" style="display: none;"><a href="#" class="btn btn-primary">MORE</a></div>
						</div>
					</div>
				</div>
		    </div>
			<div class="row row-height">
				<div class="col-sm-6">
					<div class="inner-height panel panel-default">
						<div class="panel-header">
							<h2 class="panel-title">Contact Info</h2>
						</div>
						<?php if (isset($company_info) && is_array($company_info)) : ?>
						<form class="form-horizontal form-large">
						    <div class="form-group">
						        <label class="col-sm-4 control-label">Toll free:</label>
						        <div class="col-sm-8">
						            <p class="form-control-static"><?php echo @$company_info['company_800_number']; ?></p>
						        </div>
						    </div>
						    <div class="form-group">
						        <label class="col-sm-4 control-label">Local phone:</label>
						        <div class="col-sm-8">
						            <p class="form-control-static"><?php echo @$company_info['main_business_ph']; ?></p>
						        </div>
						    </div>
						    <div class="form-group">
						        <label class="col-sm-4 control-label">Email:</label>
						        <div class="col-sm-8">
						            <p class="form-control-static"><a href="mailto:<?php echo @$company_info['contact_email']; ?>"><?php echo @$company_info['contact_email']; ?></a></p>
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
						            <p class="form-control-static"><?php echo @$company_info['main_address']; ?></p>
						        </div>
						    </div>
						    <div class="form-group">
						        <label class="col-sm-4 control-label">City, State:</label>
						        <div class="col-sm-8">
						            <p class="form-control-static">
						            	<?php 
						            	if ($company_info['city'] && $company_info['state']) :
						            		echo $company_info['city'].','.@$company_info['state'];
						            	else :
						            		echo $company_info['city'].@$company_info['state'];
						            	endif;
						            	?>
						            </p>
						        </div>
						    </div>

						    <div class="form-group">
						        <label class="col-sm-4 control-label">Zip code:</label>
						        <div class="col-sm-8">
						            <p class="form-control-static"><?php echo @$company_info['zip_code']; ?></p>
						        </div>
						    </div>
						    <div class="form-group">
						        <label class="col-sm-4 control-label">Country:</label>
						        <div class="col-sm-8">
						            <p class="form-control-static">
						            	<?php
							            	 if(isset($company_info['country']) && $company_info['country']!=null ){
							            	 	$country = $this->config->item('country');
							            	 	echo $country[$company_info['country']];
							            	 }
						            	?>
						            </p>
						        </div>
						    </div>
						    <div class="form-group">
						        <label class="col-sm-4 control-label">Local Reps:</label>
						        <div class="col-sm-8">
						            <p class="form-control-static"><a href="<?php echo base_url('profile/sales_reps/'.$company_info['member_id']); ?>"><strong>Click to find a local rep</strong></a></p>
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
							    	<li><a name="slider-item-<?php echo $value['photo_id']; ?>" class="slider-item" href="<?php echo base_url(); ?>photos/<?php echo $value['photo_id']; ?>/<?php echo gen_slug($value['name']);?>"><img src="<?php echo base_url(@$value['path_file']); ?>" alt="<?php echo @$value['name'] ?>"></a></li>
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
								  		 	<img src ="<?php echo $value; ?>" style="height:100px;display:inline-block;margin-right:10px;margin-top:10px;">
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
								<textarea class="form-control" rows="6" readonly><?php echo @$company_info['service_area']; ?></textarea>
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
    	                               				<p class="text-right"><?php echo date(DW_FORMAT_DATE,strtotime($value['date_create'])); ?></p>
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
	<div id="modal_view_catalog" class="modal fade" role="dialog">
	    <div class="modal-dialog modal-sm">
	        <div class="modal-content">
	            <button type="button" class="close" data-dismiss="modal">&times;</button>
	            <div class="modal-body">
	                <div class="logo-catalog"><img src="<?php echo base_url("uploads/manufacturers/logov1-1473673468.png")?>"/></div>
	                <div class="title-catalog"><p>Companies about statement goes here. </p></div>
	                <div class="number-catalog"><a>378 Catalog items</a></div>
	                <div class="row">
	                   <form id="seach-home-photo" method="GET" action="<?php echo base_url('profile/myphoto/'.$member_id.'');?>" class="relative form-color">
			                <div class="box-seach col-md-7">
			                	<input type="hidden" value="" name="catalog" id="catalog_id">
		                        <input type="text" class="form-control" value="" name="keyword_photo" placeholder="Search Catalog..." autocomplete="off">
		                        <div class="seach-sumit"><img src="<?php echo skin_url();?>/images/icon-seach.png"></div>
		                    </div>
		                    <div class="col-md-5 text-right"><button type="submit" class="view-catalog btn btn-primary">View Catalog</button></div>
	                    </form>
                    </div>
	            </div>  
	        </div>
	    </div>
	</div>
<style type="text/css">
	.logo-catalog{margin-bottom: 15px;} 
	#modal_view_catalog .seach-sumit{right: 16px;}
	.title-catalog{margin-bottom: 10px;}
	.number-catalog{margin-bottom: 10px;}
	button.view-catalog{font-size: 18px;}
    .manufacturers li {width: 24%; margin-bottom: 30px;}
    .manufacturers {height: 125px; overflow-y: hidden;}
    .manufacturers img{max-width: 100%;max-height: 40px;}
	.form-group{margin-bottom: 0;}
	.more-manufacturers a.btn{
		border-radius: 0;
		-webkit-box-shadow: -2px 2px 3px 0 rgba(0,0,0,0.5);
    	box-shadow: -2px 2px 3px 0 rgba(0,0,0,0.5);
    	font-size: 22px;
	}
	.more-manufacturers{position: absolute; width: 100%;left: 0; text-align: center;}
	.box-manufacturers {margin-bottom: 50px;}
	button.close {
	    font-size: 25px;
	    color: #000;
	    opacity: 1;
	    position: absolute;
	    right: 10px;
	    top: 5px;
	    z-index: 9;
	}
	#modal_view_catalog .modal-content { border-radius: 0;}
	body.not_bg .modal-backdrop{background-color: transparent!important;}
	#modal_view_catalog{top: 20%;}
	#modal_view_catalog .logo-catalog > img{max-height: 40px;}
	
	@media screen and ( max-width: 768px ){
		.manufacturers li{width: 48%;}
		#modal_view_catalog .seach-sumit{
			width: auto;
    		right: 18px;
		}
		#modal_view_catalog #seach-home-photo .form-control{margin-bottom: 15px;}
	}
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
<script type="text/javascript">
	$(document).ready(function(){
		var number = $(".manufacturers li").length;
		if(number > 8){
			$(".more-manufacturers").show();
		}else{
			$(".more-manufacturers").hide();
		}
		if($(window).width() < 768){
			if(number > 4){
				$(".more-manufacturers").show();
			}else{
				$(".more-manufacturers").hide();
			}
		}
    	var page_more = 0;
	    $(".more-manufacturers a.btn").click(function(){
	    	if(!$(this).hasClass("show-now")){
	    		$(this).text("LESS");
	    		$(this).addClass("show-now");
	    		$("ul.manufacturers").css({"height":"auto","overflow-y": "initial"});
	    	}else{
	    		$(this).removeClass("show-now");
	    		$(this).text("MORE");
	    		$("ul.manufacturers").attr("style","");
	    	}
	    	return false;
	    });
    });
    $('#modal_view_catalog').on('hidden.bs.modal', function (e) { 
    	$("body").removeClass("not_bg");
    });
    $('#modal_view_catalog').on('show.bs.modal', function (e) { 
    	$("body").addClass("not_bg");
    });
    $(document).on("click","#view-catalog",function(){
    	var id = $(this).data("id");
    	$.ajax({
    		url:base_url+"profile/get_manufacturers",
    		type:"post",
    		dataType:"json",
    		data:{"id":id},
    		success:function(data){		
    			if(data["status"]){
    				$("#modal_view_catalog #catalog_id").val(data["reponse"]["id"]);
    				$("#modal_view_catalog .logo-catalog > img").attr("src",base_url+data["reponse"]["logo"]);
    				$("#modal_view_catalog .title-catalog > p").text(data["reponse"]["description"]);
    				$("#modal_view_catalog .number-catalog > a").text(data["reponse"]["number_photo"]+" Catalog items");
    				$("#modal_view_catalog").modal();
    			}else{
    				alert("Error");
    			}
    			
    		}
    	});
    	return false;
    })
</script>