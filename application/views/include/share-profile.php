<div class="modal fade" id="share-modal" tabindex="-1" role="dialog" aria-labelledby="modal-label" style="display: none;">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content" style="padding: 20px;border-radius: 0;">
            <button style="position: relative;top: -5px;" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <div style="height:20px;"></div>
            <p class="text-center"><strong>Share your profile, as a digital business card!</strong></p>
            <form method="post" id="share_your_profile" action="<?php echo base_url("home/share_your_profile");?>" enctype="multipart/form-data">
                <div class="row">
                    <?php $avatar = ( @$member['avatar'] != null ) ? base_url($member['avatar']) :  base_url("/skins/images/avatar-full.png");?>
                    <div class="col-xs-3">
                        <img style="border-radius:50%;width: 100%;height: auto;border: 1px solid #37a7a7;" class="img-circle" src="<?php echo base_url($avatar); ?>">
                    </div>
                    <div class="col-xs-9">
                        <img id="photo-share" src="<?php echo @$member['banner']; ?>" />
                        <div class="info-profile">
                            <label class="full-width">
                                <strong class="text-contact block-inline" id="name"><?php echo $member['first_name'] . ' ' . $member['last_name']; ?></strong>
                                <input class="input-contact" type="text" data-for="name" name="name" value="<?php echo $member['first_name'] . ' ' . $member['last_name']; ?>" placeholder="Full Name" />
                            </label>
                            <label class="full-width">
                                <span class="text-contact block-inline" id="job-title"><?php echo $member['job_title']; ?></span>
                                <input type="text" class="input-contact" data-for="job_title" name="job_title" value="<?php echo $member['job_title']; ?>" placeholder="Job Title" />
                            </label>
                            <label class="full-width">
                                <span class="text-contact block-inline" id="company-name"><?php echo $company_info['company_name']; ?></span>
                                <input type="text" class="input-contact" data-for="company_name" name="company_name" value="<?php echo $company_info['company_name']; ?>" placeholder="Company Name" />
                            </label>
                            <label class="full-width">
                                Cell Phone:
                                <span class="text-contact block-inline" id="cell-phone"><?php echo $member['cellphone']; ?></span>
                                <input type="text" class="input-contact" data-for="cell_phone" name="cell_phone" value="<?php echo $member['cellphone']; ?>" placeholder="(xxx) xxx-xxxx" />
                            </label>
                            <label class="full-width">Work Phone: 
                                <span class="text-contact block-inline" id="work-phone"><?php echo $member['work_ph']; ?></span>
                                <input type="text" class="input-contact" data-for="work_phone" name="work_ph" value="<?php echo $member['work_ph']; ?>" placeholder="(xxx) xxx-xxxx" />
                            </label>
                            <label class="full-width">Email:
                                <span class="text-contact block-inline" id="email"><?php echo $member['email']; ?></span>
                                <input type="text" class="input-contact" data-for="email" name="email" value="<?php echo $member['email']; ?>" placeholder="Email" />
                            <label>
                            <?php if(!isset($not_edit)):?>
                            <div class="eidt-contact"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></div>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
                <p><strong>Customize your message:</strong></p>
                <div>
                    <textarea name="message_sent" class="panel panel-custom-message-share">It was great connecting with you. Attached is my contact info along with a link to our Dezignwall Business profile. Feel free to browse our product images and reach out to me with any questions you might have.</textarea>
                </div>
                <div class="row form-group">
                    <label for="send_to" class="col-md-2 col-sm-3" style="line-height: 36px;">Send To:</label>
                    <div class="col-md-10 col-sm-9">
                        <input id="email-tag" name="email_tag" type="text" class="form-control input-raduis" >
                        <small style="font-size: 11px;">Seperate multiple email address by comma.</small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 col-xs-12 custom right sm-margin-top-30">
                        <div class="checkbox check-yelow checkbox-circle small">
                            <input type="checkbox" name="save_multiple" id="check-susses-upload" value="save">
                            <label for="check-susses-upload">
                                Add to contacts list
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-7 col-xs-12">
                        <!--<p style="line-height: 40px;"><a href="#" data-target="#share-social-modal" data-toggle="modal">Search for contacts</a></p>-->
                    </div>
                    <div class="col-sm-5 col-xs-12">
                        <input type="file" name="attach" id="attach" style="display:none;" accept=".csv,.zip"/>
                        <a href="#" onclick="$('#attach').trigger('click');return false;" class="btn btn-gray clear-button sm-width-68">Add attachment</a>
                        <button id="sent-share" type="submit" class="btn btn-primary sm-width-28">Send</button>
                        <p class="text-left remove-margin attach_container">10MB max</p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="share-social-modal" tabindex="-1" role="dialog" aria-labelledby="modal-label" style="display: none;">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content" style="padding: 20px;border-radius: 0;">
            <button style="position: relative;top: -5px;" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <div class="row">
                    <div class="col-sm-12">
                        <ul class="list-social-api">
                            <li><a href="<?php echo @$outlookImportUrl; ?>"><strong>X &nbsp;&nbsp;Outlook</strong></a></li>
                            <?php if (!empty($yahooImportUrl)) : ?>
                            <li><a title="Please hit ctrl + F5 again if you see error in yahoo site" href="<?php echo $yahooImportUrl; ?>"><strong>X &nbsp;&nbsp;Yahoo</strong></a></li>
                            <?php endif; ?>
                            <li><a href="<?php echo @$googleImportUrl; ?>"><strong>X &nbsp;&nbsp;Gmail</strong></a></li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3 sm-text-center">
                        <input type="checkbox" id="select-all-input" class="custom-api" value="all">
                        <label class="label-input" id="select-all" for="select-all-input" style="line-height:36px;">
                            Select All
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <div id="seach-home-photo" class="relative form-color">
                            <input type="text" class="form-control" name="filter_contact" id="filter_contact" value="" placeholder="Find a contact ..." autocomplete="off">
                            <button class="seach-sumit"><img src="<?php echo skin_url(); ?>/images/icon-seach.png"></button>
                        </div>
                    </div>
                </div>
                <div style="height:20px;"></div>
                <div id="box-contact-email">
                    <?php if (isset($_SESSION['contacts'])) : $first_letter = ''; ?>
                        <?php 
                            $i = 0;
                            foreach ($_SESSION['contacts'] as $contact_item) :
                                $tmp = substr($contact_item['name'],0,1);
                                $i++;
                                $display = $i <= 20 ? "block" : "none";
                        ?>
                            <div class="row contact-item" row-id="<?php echo $i; ?>" style="display:<?php echo $display; ?>">
                                <div class="col-sm-1 col-xs-1">
                                    <?php if (strtoupper($first_letter) != strtoupper($tmp)) : ?>
                                    <strong><?php echo strtoupper($tmp); $first_letter = $tmp; ?></strong>
                                    <?php endif; ?>
                                </div>
                                <div class="col-sm-10 col-xs-8">
                                    <div class="row">
                                        <div class="col-sm-2 col-xs-3 text-center">
                                            <?php if ($contact_item['image'] != 'data:image/jpeg;base64,UGhvdG8gbm90IGZvdW5k') : ?>
                                               <img width="30" height="30" style="border-radius:50%;" src="<?php echo $contact_item['image']; ?>" />
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-sm-10 col-xs-9">
                                            <p style="line-height:30px;"><?php echo $contact_item['name']; ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-1 col-xs-2 text-right">
                                    <input type="checkbox" class="custom-api" id="all-api-<?php echo $i; ?>" value="<?php echo $contact_item['email']; ?>">
                                    <label class="label-input" for="all-api-<?php echo $i; ?>" style="line-height:36px;">
                                        &nbsp;
                                    </label>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <?php if ($i > 20) : ?>
                            <p class="text-right"><a id="load_more_contact" data-value="20" href="#">More</a></p>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                <div class="row"><div class="col-md-12 text-right"><button type="button" class="btn btn-primary" id="add-email">Add</button></div></div>
            
        </div>
    </div>
</div>
<style>
    .label-input{cursor: pointer;}
    ul.tagit li.tagit-choice .tagit-label:not(a){font-size: 13px;}
    ul.tagit {
        border-style: solid;
        border-width: 1px;
        border-color: #C6C6C6;
        background: inherit;
        max-height: 86px;
    }
    .panel-custom-message-share{
        background: #F1F1F1;
        height: 124px;
        width: 100%;
    }
    .block-inline{display: inline !important;}
    .full-width{width: 100%;}
    .text-contact{display: none;}
    .full-width .input-contact.block-inline{display: block !important;}
    .full-width .input-contact{
        display: none;
        width: 80%;
        height: 34px;
        padding: 6px 12px;
        font-size: 14px;
        line-height: 1.42857143;
        color: #555;
        background-color: #fff;
        background-image: none;
        border: 1px solid #ccc;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
        box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
        -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
        -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
        transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    }
    .info-profile{position: relative;margin: 10px 0;}
    .input-raduis{border-radius: 4px;}
    .list-social-api{list-style: none;padding-left: 0;}
    .list-social-api li{display: inline-block;padding: 0 15px;}
    .list-social-api li a{color: #545454;}
    input[type='checkbox'].custom-api{display: none;}
    input[type='checkbox'].custom-api + label:before{
        width: 18px;
        height: 18px;
        border: 1px solid #ccc;
        display: inline-block;
        content:'';
        font: normal normal normal 14px/1 FontAwesome;
        font-size: inherit;
        text-rendering: auto;
        -webkit-font-smoothing: antialiased;
        color: #37a7a7;
        font-size: 20px;
    }
    input[type='checkbox'].custom-api:checked + label:before{
        content: "\f00c";
    }
    .eidt-contact span {
        color: #f90;
        font-size: 22px;
        position: absolute;
        right: 0;
        top: 0;
        cursor: pointer;
    }

    #share-modal ul.tagit{
        max-width: 100%;
        overflow-x: hidden;
        height: 100px;
    }
    @media (min-width: 768px) {
        .sm-margin-top-30{
            margin-top: -30px;
        }
        .sm-text-right{
            text-align: right;
        }
        .sm-width-28{
            width: 28%;
        }
        .sm-width-68{
            width: 68%;
        }
        .sm-text-center{
            text-align: center;
        }
    }
</style>
<link rel="stylesheet" type="text/css" href="<?php echo skin_url(); ?>/css/jquery.tagit.css">
<link rel="stylesheet" type="text/css" href="<?php echo skin_url(); ?>/css/tagit.ui-zendesk.css">
<script src="<?php echo skin_url(); ?>/js/tag-it.min.js"></script>
<script type="text/javascript">
     $(document).ready(function(){
        <?php if(isset($_GET["share_profile"])):?>
            <?php if($_GET["share_profile"] == "success"){?>
                 messenger_box("Messenge","Share your profile successfully");
            <?php }?>
            <?php if($_GET["share_profile"] == "error"){?>
                 messenger_box("Messenge","Share your profile error");
            <?php }?>
        <?php endif;?>

        // Trigger popup form

        <?php if(isset($param_social) && ($param_social == 'yahoo' || $param_social == 'google')): ?>
            $('#share-modal').modal('toggle'); 
            $('#share-social-modal').modal('toggle'); 
        <?php endif; ?>
    });

    $("#filter_contact").keyup(function() {
        var value = $.trim(this.value);
        if (value != '') {
            $('#load_more_contact').hide();
            var rows = $("#box-contact-email").find(".contact-item").hide();
            rows.filter(":contains('" + value + "')").show();
        } else {
            $('#load_more_contact').show();
            $("#box-contact-email").find(".contact-item").hide();
            // Display the first 20 records
            var current = parseInt($('#load_more_contact').attr('data-value'));
            $('#box-contact-email .contact-item').each(function () {
                if (parseInt($(this).attr('row-id')) < current) {
                    $(this).show();
                }
            });
        }

        
        //var data = this.value.split(" ");
        //$.each(data, function(i, v) {
        //  rows.filter(":contains('" + v + "')").show();
        //});

    });
    
    $('#load_more_contact').click(function() {
        var current = parseInt($(this).attr('data-value'));
        current += 20;
        $('#box-contact-email .contact-item').each(function () {
            if (parseInt($(this).attr('row-id')) < current) {
                $(this).show();
            }
        });
        $(this).attr('data-value',current);
        if (current > $('#box-contact-email .contact-item').length) {
            $(this).hide();
        }
    });

    $('#attach').change(function() {
        var filename = $('#attach').val();
        $('.attach_container').html(filename);
    });
    $("#email-tag").tagit({
        allowSpaces: false,
        fieldName: "keyword[]",
        autocomplete: {delay: 0, minLength: 1},
        afterTagAdded : function(e,t){
            if(!isEmail(t.tagLabel)){
                t.tag.css("border","1px solid red");
                t.tag.addClass("error-email");
            }
        }
    });  

    $(document).on("click",".eidt-contact",function(){
        $(".text-contact").toggleClass("block-inline");
        $(".input-contact").toggleClass("block-inline");
        $.each($(".info-profile .input-contact"),function(){
            $(this).parents(".info-profile").find("#"+$(this).data("for")+"").text($(this).val());
        });
    });
    $(document).on("click","#add-email",function(){
        $.each($("#box-contact-email input:checked"),function(){
            $("#email-tag").tagit("createTag", $(this).val());
        });
        // Close popup
        $('#share-social-modal').modal('toggle'); 
        return false;
    });
    $(document).on("click","#box-contact-email input[type=checkbox]",function(){
        var length_input = $("#box-contact-email input[type=checkbox]").length;
        var length_check = $("#box-contact-email input:checked").length;
        if(length_input <= length_check){
            $("#share-social-modal #select-all-input").prop("checked",true);
        }else{
            $("#share-social-modal #select-all-input").prop("checked",false);
        }
    });
    $(document).on("click","#share-social-modal #select-all",function(){
        if($(this).hasClass("set-all") == false){
            $.each($("#box-contact-email input[type = checkbox]"),function(){
                $(this).prop( "checked",true);
            });
        }else{
            $.each($("#box-contact-email input[type = checkbox]"),function(){
                $(this).prop( "checked",false);
            });
        }
        $(this).toggleClass("set-all");
    });
    $(document).on("submit","#share-modal #share_your_profile",function(){
        var i = 0;
        $("#share-modal ul.tagit").css("border","none");
        $.each($("#share-modal .ui-widget-content li .tagit-label"),function(){
            if(!isEmail($(this).text())){
                i++;
                return false;
            }
        });
        if( i > 0 ){
            $("#share-modal ul.tagit").css("border","1px solid red");
            messenger_box("Share profile error!","Please check list email !");
            return false;
        }
    });
    <?php if(isset($_GET["share"])):?>
        $("#share-modal").modal();
    <?php endif;?>
    function isEmail(email) {
      var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
      return regex.test(email);
    }
</script>