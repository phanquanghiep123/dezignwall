<section class="section box-wapper-show-image box-wapper-secondary">
	<div class="container">
		<p class="h2 text-center"><strong>Secure Upgrade...</strong>Put your brand top of mind!</p>
	</div>
</section>
<section class="section box-wapper-show-image">
	<div class="container">
		<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
			<!-- Indicators -->
			<ol class="carousel-indicators">
				<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
				<li data-target="#carousel-example-generic" data-slide-to="1"></li>
				<li data-target="#carousel-example-generic" data-slide-to="2"></li>
			</ol>
			<!-- Wrapper for slides -->
			<div class="carousel-inner" role="listbox">
				<div class="item active">
					<img src="<?php echo skin_url('images/upgrade-1.png')?>" alt="...">
					<div class="carousel-caption">
						<h3><strong>Promote your brand!</strong></h3>
						<p>Prominantly display your logo above<br>
						all of the images you post.</p>
					</div>
				</div>
				<div class="item">
					<img src="<?php echo skin_url('images/upgrade-2.png')?>" alt="...">
					<div class="carousel-caption">
						<h3><strong>Display your company name!</strong></h3>
						<p>Create instant recognition and brand confidence by<br>
						displaying your company name with each image.</p>
					</div>
				</div>
				<div class="item">
					<img src="<?php echo skin_url('images/upgrade-3.png')?>" alt="...">
					<div class="carousel-caption">
						<h3><strong>Share your specific business category!</strong></h3>
						<p>Don’t leave your potential clients guessing! Clearly display your<br>
						business category so they can quickly engage with you directly.</p>
					</div>
				</div>
				
			</div>
		</div>
		<div class="upgrade-panel">
			<div class="row">
				<div class="col-sm-4">
					<div class="media">
						<div class="media-left">
							<span class="mo-num">1</span>
						</div>
						<div class="media-body  media-middle">
							<span class="mo-text">Month<br>plan</span>
						</div>
					</div>
				</div>
				<div class="col-sm-4 text-center-sm">
					<span class="wrap">
						<span class="price">$19.99</span> / Month<br>
					</span>
				</div>
				<div class="col-sm-4 text-right-sm">
					<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
						<input type="hidden" name="cmd" value="_s-xclick">
						<input type="hidden" name="hosted_button_id" value="EP26YNZVC4YCQ">
						<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
						<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
					</form>
					<div class="form-group"><input type="text" id="promo-code" placeholder = "Promo code" autocomplete="off"></div>
				</div>
			</div>
		</div>
		<?php 
			/*
			if(isset($package) && count($package)>0):
			  foreach ($package as $key => $value) :
		?>
				<div class="upgrade-panel">
					<div class="row">
						<div class="col-sm-4">
							<div class="media">
								<div class="media-left">
									<span class="mo-num"><?php echo @$value['name']; ?></span>
								</div>
								<div class="media-body  media-middle">
									<span class="mo-text">Month<br>plan</span>
								</div>
							</div>
						</div>
						<div class="col-sm-4 text-center-sm">
							<?php echo @$value['summary']; ?>
						</div>
						<div class="col-sm-4 text-right-sm">
							<a href="<?php echo base_url('/profile/plan/' . $value['id']); ?>" class="btn btn-primary">Select</a>
						</div>
					</div>
				</div>
		<?php
			  endforeach;
			endif;
			*/
		?>
		<div class="upgrade-panel text-center">
			You will be charged the total sum stated above. All will be recurring based on the plan you choose.
		</div>
	</div>
</section>
<script type="text/javascript">
	$(document).on("keyup","#promo-code",function(event){
		var _thiscode = $(this);
		_thiscode.removeClass("warning");
		if(event.keyCode == 13){
			if($(this).val().trim() == ""){
				$(this).addClass("warning");
			}else{
				$.ajax({
					url     :"<?php echo base_url();?>"+"profile/offer_code",
					type    :"post",
					dataType:"json",
					data:{"code": $(this).val()},
					success:function(data){
						if(data["success"] == "success"){
							messenger_box("Message",data["message"]);
							setTimeout(function(){ window.location.href = window.location.href;}, 3000);
						}else{
							_thiscode.addClass("warning");
							messenger_box("Error Message",data["message"]);
						}
					},
					error:function(){
						messenger_box("Error Message","Error Message");
					}
				});
			}
		}
	});
</script>