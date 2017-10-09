<div class="modal fade how-it-works" id="how-it-works-buyer" tabindex="-1" role="dialog" aria-labelledby="modal-label">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content" style="padding: 35px 35px;border-radius: 0;">
            <button style="position: relative;top: -5px;" type="button" class="close" data-dismiss="modal" aria-label="Close"><span style="font-size: 27px;" aria-hidden="true">×</span></button>
            <div style="height:20px;"></div>
            <h2 class="text-center text-blue title-popup">Looking for a commercially available<br>product or service?</h2>
            <div class="content-text-1">
            	<p class="text-center">Dezignwall is a virtual marketplace for finding commercial products,<br>
				services, and collaborating with teams, vendors and clients.</p>
				<p class="text-center">We believe that the commercial design community requires<br>
				autonomy in working with, finding and sourcing vendors,<br>
				products and pricing.</p>
				<p class="text-center"><i>We simply bring buyer and seller together.</i></p>
            </div>
            <h3 class="text-center text-blue">Here’s how it works...</h3>
            <div class="content-text-2">
            	<div class="row">
            	    <div class="item-popup">
	            		<div class="col-md-2"><img src="<?php echo base_url("skins/images/search-icon.png");?>"></div>
	            		<div class="col-md-10">
		            		<p>Search for products or projects posted by commercial
							manufacturers, suppliers and/or designers. Filter your 
							search by industry or keywords.</p>
						</div>
					</div>
					<div class="item-popup">
						<div class="col-md-2"><img src="<?php echo base_url("skins/images/microste-icon.png");?>"></div>
	            		<div class="col-md-10">
		            		<p>Easily find manufacturers and suppliers contact
							information and local sales locations, by simply clicking 
							on their business profiles.</p>
						</div>
					</div>
					<div class="item-popup">
						<div class="col-md-2"><img src="<?php echo base_url("skins/images/heart-icon.png");?>"></div>
	            		<div class="col-md-10">
		            		<p>Leave a comment and show some love! Engage in
							conversation with members of the design community
							worldwide. Who knows who you’ll meet...</p>
						</div>
					</div>
					<div class="item-popup">
						<div class="col-md-2"><img src="<?php echo base_url("skins/images/pin-blue.png");?>"></div>
	            		<div class="col-md-10">
		            		<p>Pin your finds to private virtual mood boards (or “Your
							Wall”). Start off with a Free Wall, then upgrade to
							create unique Walls for each of your projects!</p>
						</div>
					</div>
					<div class="item-popup">
						<div class="col-md-2"><img src="<?php echo base_url("skins/images/team-blue.png");?>"></div>
	            		<div class="col-md-10">
		            		<p>Invite team members, colleagues, vendors and clients
							into your private Walls, and take your design ideation,
							collaboration and product sourcing...Virtual!</p>
						</div>
					</div>
					<div class="item-popup">
						<div class="col-md-2"><img src="<?php echo base_url("skins/images/upload-orange.png");?>"></div>
	            		<div class="col-md-10">
		            		<p>Out this weekend and find an item that would be
							perfect for your project? Snap a photo or upload it
							from another site and Pin it to your private Wall!</p>
						</div>
					</div>
					<div class="item-popup">
						<div class="col-md-2"><img src="<?php echo base_url("skins/images/tag-orange.png");?>"></div>
	            		<div class="col-md-10">
		            		<p>Need to get pricing but want to avoid the whole “sales
							pitch”? Click on a “Price tag” and send off a Request
							for Quote (There is “no buying” through Dezignwall)</p>
						</div>
					</div>
					<div class="item-popup">
						<div class="col-md-2"><img src="<?php echo base_url("skins/images/post-pictures-Icon.png");?>"></div>
	            		<div class="col-md-10">
		            		<p>All done with your project? Why not showcase your own 
							Project photos to Dezignwall? Get your own projects
							in front of business owners and the design community!</p>
						</div>
					</div>
            	</div>
            </div>
            <div class="content-text-3">
            	<h3 class="text-center text-blue">Take your design collaboration mobile...</h3>
            	<p class="text-center started">Ready to get started?</p>
            	<div class="row">
            		<div class="col-md-6"><a href="<?php echo base_url("search");?>" class="btn action-bnt btn-gray">Start your search</a></div>
            		<div class="col-md-6"><a href="<?php echo base_url("designwalls/upgrade")?>" id="mulitple-walls" class="btn action-bnt btn-primary">Create mulitple Walls</a></div>
            		<div class="col-md-12 text-right"><a id="get-signin" href="#" class="text-blue">Haven’t signed in? Click Here</a></div>
            	</div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
	$("#mulitple-walls").click(function(){
		$("#how-it-works-buyer").modal("hide");
		if(check_login() == false){
			url_reload = $(this).attr("href");
			return false;
		}
	});
</script>

