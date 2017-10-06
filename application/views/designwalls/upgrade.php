<section class="section box-wapper-show-image box-wapper-secondary">
    <div class="container">
        <p class="h2 text-center"><strong>Secure Upgrade...</strong>Put your brand top of mind!</p>
    </div>
</section>
<section class="section box-wapper-show-image" id="designwalls-upgrade">
    <div class="container">
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                <li data-target="#carousel-example-generic" data-slide-to="3"></li>
            </ol>
            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
                <div class="item active">
                    <div class="box-slider">
                        <img src="<?php echo skin_url('images/slider-1dw.png')?>" alt="...">
                        <h3>Manage Multiple Projects</h3>
                        <p>Save time and money collorating with colleagues in<br> virtual space, as you ideate and plan multiple projects.</p>
                    </div>
                </div>
                <div class="item">
                    <div class="box-slider">
                        <img src="<?php echo skin_url('images/slider-2dw.png')?>" alt="...">
                        <h3>Create Unique Project Teams</h3>
                        <p>Invite colleagues, vendors and clients into projects<br> and build unique teams to meet your project goals.</p>
                    </div>
                </div>
                <div class="item">
                    <div class="box-slider">
                        <img src="<?php echo skin_url('images/slider-3dw.png')?>" alt="...">
                        <h3>Collaborate 24/7, globally</h3>
                        <p>Find and share products and design inspiration<br> with colleauges any-time, from any-where.</p>
                    </div>
                </div>
                <div class="item">
                    <div class="box-slider">
                        <img src="<?php echo skin_url('images/slider-4dw.png')?>" alt="...">
                        <h3>Upload and share images privately</h3>
                        <p>Found a great product or design inspiration? Snap a photo,<br> upload and share it to your provate project folders, instantly.</p>
                    </div>
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
                                    <span class="mo-num"><?php echo @$value['max_files']; ?></span>
                                </div>
                                <div class="media-body  media-middle">
                                    <span class="mo-text">Project<br>Walls</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 text-center-sm">
                            <div class="box-summary">
                                <?php echo @$value['summary']; ?>
                            </div>
                        </div>
                        <div class="col-sm-4 text-right-sm">
                            <a name ="plan-<?php echo $value['id'];?>" href="<?php echo base_url('/designwalls/plan/' . $value['id']); ?>" class="btn btn-primary">Select</a>
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
                                    <p class="most-popular-blue">Do you have a promotion code?<br/> Enter your Promo code here:</p>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="promo_code" name="promo_code" placeholder="Redeem your offer ..." />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 text-right-sm">
                            <a name ="send-now" href="javascript:;" class="btn btn-submit btn-primary" style="margin-top:0px">Send</a>
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
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script type="text/javascript">
    $(".btn-submit").click(function() {
        if ($.trim($("#promo_code").val()) != '') {
            // Open popup and remove disable
            $(this).removeAttr('disabled');
            $.ajax({
                url: "<?php echo base_url('payment/check_promo_code');?>",
                type: "post",
                dataType: "json",
                data: {
                    "promo_code": $("#promo_code").val()
                },
                success: function(data) {
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
                            $('.upgrade-panel a.btn').each(function() {
                                var url = $(this).attr('href');
                                var tmp = url.split("?")[0];
                                url = tmp + "?promo_code=" + $.trim($("#promo_code").val());
                                $(this).attr('href', url);
                            });
                        }
                    } else {
                        messenger_box("Error Message", data["message"]);
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

    $("#submit-purchase-promo").click(function() {
        $(this).attr('disabled', 'disabled');
        if ($.trim($("#promo_code").val()) != '') {
            $('#form-purchase').submit();
        }
    });
</script>
<style type="text/css">
    #designwalls-upgrade .carousel-inner .item .box-slider {
        padding: 25px 0;
        min-height: 380px;
        display: table;
        vertical-align: middle;
        text-align: center;
        width: 100%;
    }
    
    #designwalls-upgrade .carousel-inner .item .box-slider img {
        vertical-align: middle;
    }
    
    .most-popular {
        font-size: 18px;
        color: #ff9900;
    }
    
    .most-popular-blue {
        font-size: 18px;
        color: #217c7e;
    }
    
    .number-summary {
        font-size: 22px;
        color: #212121;
    }
    .box-summary{
      padding-top: 20px;
    }
    input#promo_code{border:1px solid #000;border-radius: 5px;height: 45px;background-color: #f1f1f1;font-size: 20px;}
    input#promo_code::-webkit-input-placeholder { /* WebKit, Blink, Edge */
        color: #217c7e;
    }
    input#promo_code:-moz-placeholder { /* Mozilla Firefox 4 to 18 */
       color: #217c7e;
       opacity:  1;
    }
    input#promo_code::-moz-placeholder { /* Mozilla Firefox 19+ */
       color: #217c7e;
       opacity:1;
    }
    input#promo_code:-ms-input-placeholder { /* Internet Explorer 10-11 */
       color:#217c7e;
    }
    .box-slider h3{
      font-size: 22px;
      font-weight: bold;
    }
</style>