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
			<?php /*
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
			*/ ?>
			<div class="carousel-inner" role="listbox">
				<div class="item active">
					<img src="<?php echo skin_url('images/upgrade-4.png')?>" alt="...">
				</div>
				<div class="item">
					<img src="<?php echo skin_url('images/upgrade-5.png')?>" alt="...">
				</div>
				<div class="item">
					<img src="<?php echo skin_url('images/upgrade-6.png')?>" alt="...">
				</div>
			</div>
		</div>
		<?php 
			if (isset($package) && count($package) > 0) :
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
							<a name ="plan-<?php echo $value['id'];?>" id="go-to-plan" href="<?php echo base_url('/payment/plan/' . $value['id']); ?>" class="btn btn-primary">Select</a>
						</div>
					</div>
				</div>
		<?php endforeach ;?>
		<div class="upgrade-panel text-center">
			You will be charged the total sum stated above. All will be recurring based on the plan you choose.
		</div>
				
		<div class="upgrade-panel">
			<form action="<?php echo base_url("/checkout/promo"); ?>" method="POST" id="form-purchase">
				<div class="row">
					<div class="col-sm-8 text-right">
						<div class="row">
							<div class="col-sm-6 text-right">
								Do you have a promotion code?<br/>
								Enter your Promo code here:
							</div>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="promo_code" name="promo_code" placeholder="Redeem your offer ..." />
							</div>
						</div>
					</div>
					<div class="col-sm-4 text-right-sm">
						<a name="send-now" href="javascript:;" class="btn btn-submit btn-primary" style="margin-top:0px">Send</a>
					</div>
				</div>
			</form>
		</div>
		
		<div class="upgrade-panel text-center">
			Follow Dezignwall on social media for more exclusive offers? 
			
			<a href="#" onclick="share(); return false;"><img width="16" src="<?php echo skin_url(); ?>/images/facebook.png"></a>
			<a href="#" id="container" onclick="share_tw(); return false;"><img width="16" src="<?php echo skin_url(); ?>/images/twitter.png"></a>
			<a href="#" class="poup-share-in"><img width="16" src="<?php echo skin_url(); ?>/images/in.png"></a>
			<a href="#" class='st_instagram_small' displayText='Instagram Badge'><img width="16" src="<?php echo skin_url(); ?>/images/instagram.png"></a>
			
		</div>
		<?php endif; ?>
	</div>
</section>

<?php /* 
<div id="promo-code-dialog" class="modal fade modal-no-radius modal-promocode" tabindex="-1" role="dialog">
      <div class="modal-dialog">
            <div class="modal-content">
                  <div class="modal-body text-center">
                      	<!--<h3>It looks like you’ve entered promo code: <strong class="color-green-yellow" id="promo-code-popup"></strong></h3>
                      	<div class="space-10"></div>-->
                      	<div id="promo-summary-popup"></div>
                        <div class="space-20"></div>
                        <p class="remove-margin">Note: No credit and/or debit card information was provided under the terms of this promotion code. At the end of this promotion period, you will be contacted with offers to extend your upgraded service. By selecting "complete upgrade", you acknowledge these terms.</p>
                        <div class="space-20"></div>
                        <div class="text-right">
                              <button class="btn btn-primary" id="submit-purchase-promo" type="button">Complete Purchase</button>
                        </div>
                  </div>
            </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
*/ ?>

<div id="promo-code-dialog" class="modal fade modal-no-radius modal-promocode" tabindex="-1" role="dialog">
      <div class="modal-dialog">
            <div class="modal-content">
                  <div class="modal-body text-center">
                      	<div id="promo-summary-popup"></div>
                        <div class="space-20"></div>
                        <p class="remove-margin" id="note-upgrade-blog">
                        	<div class="upgrade-member">Note: No credit and/or debit card information was provided under the terms of this promotion code. At the end of this promotion period, you will be contacted with offers to extend your upgraded service. By selecting "complete upgrade", you acknowledge these terms.</div>
							<div class="upgrade-blog" style="display:none;">Note: No credit and/or debit card information was provided under the terms of this promotion code. The access this pass code grants you is conditional, based on our beta program and can be revoked without notice at anytime, in accordance with the terms and conditions of the site.</div>
                        </p>
                        <div class="space-20"></div>
                        <div class="text-right">
                              <button class="btn btn-primary" id="submit-purchase-promo" type="button">Complete Upgrade</button>
                        </div>
                  </div>
            </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
$(".btn-submit").click(function () {
	if ($.trim($("#promo_code").val()) != '') {
		// Open popup and remove disable
		$(this).removeAttr('disabled');
		$.ajax({
			url     : "<?php echo base_url('payment/check_promo_code');?>",
			type    : "post",
			dataType: "json",
			data	: {"promo_code": $("#promo_code").val()},
			success : function(data) {
				console.log(data);
				if (data["success"] == "success") {
					$('#promo-summary-popup').html(data["offer_summary"]);
					if (data["type_offer"] === 'local' || data["type_offer"] === 'blog') { // Type: Upgrade member or Upgrade Blog
						if (data["type_offer"] === 'blog') {
							$('#note-upgrade-blog .upgrade-member').hide();
							$('#note-upgrade-blog .upgrade-blog').show();
						} else {
							$('#note-upgrade-blog .upgrade-blog').hide();
							$('#note-upgrade-blog .upgrade-member').show();
						}
						$('#promo-code-dialog').modal('show');
					} else {
						messenger_box("Success Message", "Your promo code is available. Please select package above to continue");
						$('.upgrade-panel a.btn').each (function () {
							var url = $(this).attr('href');
							var tmp = url.split("?")[0];
							url = tmp + "?promo_code=" + $.trim($("#promo_code").val());
							$(this).attr('href',url);
						});
					}
				} else {
					messenger_box("Error Message",data["message"]);
				}
			},
			error: function() {
				messenger_box("Error Message", "Cannot check promo code. Please check again.");
			}
		});
		return false;
	} else {
		messenger_box("Error Message", "Please enter redeem your offer.");
	}
});

$("#submit-purchase-promo").click(function () {
	$(this).attr('disabled','disabled');
	if ($.trim($("#promo_code").val()) != '') {
    	$('#form-purchase').submit();
    }
});
$(document).on("click", "#go-to-plan", function (e) {
    e.stopPropagation();
    if (check_login() == false ) {
        url_reload = $(this).attr("href");
        return false;
    }
});
</script>






