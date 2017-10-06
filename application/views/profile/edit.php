
<link rel="stylesheet" type="text/css" href="<?php echo skin_url("css/page/company.css")?>">
<style type="text/css">
<?php if (isset($_GET["payment"]) && $_GET["payment"] == "true") { ?>
        #message-upgrade{display: block !important;}
<?php } else { ?>
        #message-upgrade{display: none !important;}
<?php } ?>  
</style>
<?php if (isset($_GET["payment"]) && $_GET["payment"] == "true") { 
    $user_info = $this->session->userdata('user_info');
    $member_upgrade = $this->Common_model->get_record(
        "member_upgrade",
        array("member_id" => $user_info["id"]),
        array(["field" => "id","sort" => "DESC"])
    );
    $member_payment = $this->Common_model->get_record(
        "member_payment",
        array("member_id" => $user_info["id"]),
        array(["field" => "id","sort" => "DESC"])
    );
    $packages = $this->Common_model->get_record(
        "packages",
        array("id" => @$member_payment["package_id"])
    );
    $offer = $this->Common_model->get_record(
        "offer",
        array("id" => $member_upgrade["offer_id"])
    );
    ?>
    <script type="text/javascript">
        dataLayer = [{
            mid : "<?php echo $user_info["id"];?>",
            transactionPromo:"<?php echo @$offer["title_offer"];?>",
            transactionProducts:[{
                sku: "<?php echo @$member_payment["package_id"];?>",
                name:"plan <?php echo @$packages["name"];?>",
                category:"Monthly",
                price :"<?php echo @$packages["price"];?>",
                quantity:"1"
            }],
            pageurl:"<?php echo urlencode (base_url(uri_string()));?>",
            transactionId:"<?php echo @$member_payment["id"];?>",
            transactionTotalquantity: "1",
            transactionTotal:"<?php echo @$packages["price"];?>",
            transactionShipping: 0,
            transactionTax:0,
            transactionGrandtotal:"<?php echo @$packages["price"];?>"
        }];
    </script>
<?php } ?>
<?php
$bg_top = ($type_member == 1) ? "yellow" : "";
?>
<div id="message-upgrade" class="modal-message-wrapper">
    <div class="box-table">
        <div class="box-table-cell align-middle">
            <div class="modal-message-body text-center">
                <h2 class="color-white">Thank you for upgrading with Dezignwall!</h2>
                <p class="color-brand-primary">Branding your images dramatically increases volume of engagement and new bussiness.</p>
                <div class="space-20"></div>
                <img src="<?php echo skin_url('images/img-message-upgrade.png') ?>">
                <div class="space-20"></div>
                <a href="<?php echo base_url('profile/edit'); ?>" class="btn btn-gray">Update Profile</a>
                <a href="<?php echo base_url('profile/addphotos'); ?>" class="btn btn-secondary">Upload Image</a>
            </div> 
        </div>
    </div>
</div>

<section class="section box-wapper-show-image box-wapper-brand <?php echo $bg_top; ?>">
    <div class="container">
        <p class="h2 text-center"><?php echo $type_member == 1 ? "Upgraded Member – " : ""; ?>You are in Edit Profile mode</p>
    </div>
</section>

<?php
    $this->load->view("include/banner.php", $member);
?>
<section class="section box-wapper-show-image">
    <div class="container">
        <div class="panel panel-default">
            <div class="custom-loading"><img width="48" src="<?php echo skin_url(); ?>/images/loading.gif"></div>
            <div class="panel-header">
                <h2 class="panel-title">Admin Profile Info</h2>
                <a class="panel-action" href="#"><i class="fa fa-pencil"></i></a>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div id="crop-avatar">
                        <?php $this->load->view("include/modal-cropper");?>
                        <div class="media">
                            <div class="media-left">
                                <?php
                                $src = skin_url() . '/images/avatar-full.png';
                                if (isset($member['avatar']) && file_exists('.' . $member['avatar']) && !empty($member['avatar'])) {
                                    $src = base_url($member['avatar']);
                                }
                                ?>
                                <div class="profile-image relative">
                                    
                                        <img id="avatarshow" class="img-circle media-object avatar-full" src="<?php echo $src; ?>" alt="..." width="162" height="162">
                                        <div class="profile-edit-photo custom-avatar">
                                            <div class="profile-action-edit">
                                                <a class="avatar-view text-white" data-type="avatar" data-img="<?php echo $src; ?>" href="javascript:;"><i class="fa fa-camera"></i> <small>  Change Image</small></a>
                                            </div>
                                        </div>
                                        
                                </div>
                            </div>
                        </div>
                        <div class="media-body">
                            <h3 class="remove-margin-top">Upload a profile picture!</h3>
                            <p><small>Your profile picture will be viewed by the commercial design community, worldwide. Be sure to use a photo that best supports your companies public profile image.</small></p>
                        </div>
                    </div>
                    <?php if ($is_blog === 'yes') : ?><a class="link-article color-brand-secondary" href="<?php echo base_url('/article/add')?>">Dezignwall Industry Articles Program Platform</a><?php endif; ?>
                </div>
                <div class="col-sm-6">
                    <form action="" method="post" class="form-horizontal form-profile">
                        <div class="form-group">
                            <label class="col-sm-5 control-label">First Name:</label>
                            <div class="col-sm-7">
                                <p class="form-control-static view-profile"><?php echo @$member['first_name']; ?></p>
                                <p class="edit-profile" style="display:none;"><input type="text" class="form-control required" value="<?php echo @$member['first_name']; ?>" placeholder="First Name" name="personal[first_name]"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-5 control-label">Last Name:</label>
                            <div class="col-sm-7">
                                <p class="form-control-static view-profile"><?php echo @$member['last_name']; ?></p>
                                <p class="edit-profile" style="display:none;"><input type="text" value="<?php echo @$member['last_name']; ?>" class="form-control required" placeholder="Last Name" name="personal[last_name]"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-5 control-label">Personal Email:</label>
                            <div class="col-sm-7">
                                <p class="form-control-static view-profile"><?php echo isset($member['work_email']) ? $member['work_email'] : $member['email']; ?></p>
                                <p class="edit-profile" style="display:none;"><input readonly type="email" value="<?php echo isset($member['work_email']) ? $member['work_email'] : $member['email']; ?>" class="form-control format-email required" placeholder="Email" name="personal[work_email]"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-5 control-label">Job Title:</label>
                            <div class="col-sm-7">
                                <p class="form-control-static view-profile"><?php echo @$member['job_title']; ?></p>
                                <p class="edit-profile" style="display:none;"><input  type="text" value="<?php echo @$member['job_title']; ?>" class="form-control required" placeholder="Job Title" name="personal[job_title]"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-5 control-label">Cell Phone:</label>
                            <div class="col-sm-7">
                                <p class="form-control-static view-profile"><?php echo @$member['cellphone']; ?></p>
                                <p class="edit-profile" style="display:none;"><input  type="text" value="<?php echo @$member['cellphone']; ?>" class="form-control required format-phone" placeholder="Cell Phone" name="personal[cellphone]"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-5 control-label">Password:</label>
                            <div class="col-sm-7">
                                <p class="form-control-static view-profile">xxxxxx</p>
                                <p class="edit-profile" style="display:none;"><input type="password" class="form-control" id="password" placeholder="Password" name="personal[password]"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-5 control-label">Confirm Password:</label>
                            <div class="col-sm-7">
                                <p class="form-control-static view-profile">xxxxxx</p>
                                <p class="edit-profile" style="display:none;"><input type="password" readonly="readonly" class="form-control" id="confirmpassword" name="personal[confirmpassword]" placeholder="Confirm Password"></p>
                            </div>
                        </div>
                        <div class="form-group edit-profile">
                            <div class="col-sm-12  text-right">
                                <div class="space-20"></div>
                                <button class="btn btn-gray clear-button">Clear</button>
                                <button class="btn btn-primary">Save/Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!--end .panel-->
        <?php if ($is_blog === 'no') : ?>
        <div class="panel panel-default advanced-settings relative">
            <div class="custom-loading"><img width="48" src="<?php echo skin_url(); ?>/images/loading.gif"></div>
            <div class="panel-header">
                <h2 class="panel-title">Advanced Settings</h2>
                <a class="panel-action" href="#"><i class="fa fa-pencil"></i></a>
            </div>
            <div class="row">
                <form method="post" action="" class="form-profile">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Newsletter Edition:</label>
                        <div class="col-sm-6">
                           <p class="view-profile"><?php echo @$this->config->item('country')[@$setting['newsletter_edition']];?></p>
                            <p class="edit-profile">
                                <select class="form-control" name="settings[newsletter_edition]" style="max-width:100%;">
                                    <?php foreach ($this->config->item('country') as $key => $value) : ?>
                                        <option <?php
                                        if ($key == @$setting['newsletter_edition']) {
                                            echo 'selected="selected"';
                                        }
                                        ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                        <?php endforeach; ?>
                                </select>
                            </p>
                        </div>
                    </div><!--end group -->
                    <div class="form-group custom" style="padding: 0 15px;margin-bottom: 10px;">
                        <label class="col-sm-12 control-label" style="padding-left:0;"><strong>Email Subscriptions:</strong></label>
                        <div class="row text-center xs-text-left">
                            <div class="col-sm-3 col-xs-12">
                                <div class="checkbox check-yelow checkbox-circle">
                                    <input <?php
                                    if ('yes' == @$setting['newslettter']) {
                                        echo 'checked';
                                    }
                                    ?> id="designwall_newlettter" name="settings[newslettter]" class="" type="checkbox" value="1">
                                    <label for="designwall_newlettter">Newsletter</label>
                                </div>
                            </div>
                            <div class="col-sm-3 col-xs-12">
                                <div class="checkbox check-yelow checkbox-circle">
                                    <input id="general_updates" <?php
                                    if ('yes' == @$setting['general_updates']) {
                                        echo 'checked';
                                    }
                                    ?> name="settings[general_updates]" class="" type="checkbox" value="1">
                                    <label for="general_updates">General updates</label>
                                </div>
                            </div>
                            <div class="col-sm-3 col-xs-12">
                                <div class="checkbox check-yelow checkbox-circle">
                                    <input id="promotions" <?php
                                    if ('yes' == @$setting['promotions']) {
                                        echo 'checked';
                                    }
                                    ?> name="settings[promotions]" class="" type="checkbox" value="1">
                                    <label for="promotions">Promotions</label>
                                </div>
                            </div>
                            <div class="col-sm-3 col-xs-12">
                                <div class="checkbox check-yelow checkbox-circle">
                                    <input id="research_emails" <?php
                                    if ('yes' == @$setting['research_emails']) {
                                        echo 'checked';
                                    }
                                    ?> name="settings[research_emails]" class="" type="checkbox" value="1">
                                    <label for="research_emails">Research emails</label>
                                </div>
                            </div>
                        </div>
                    </div><!--end group -->

                    <div class="form-group">
                        <?php
                        $settings = array(
                            'every' => 'Every time',
                            'hour' => 'Limit 1 per hour',
                            'day' => 'Once a day',
                            'week' => 'Once per week',
                            'never' => 'Never'
                        );
                        ?>
                        <label class="col-sm-12 control-label"><strong>Notifications Frequency:</strong></label>
                        <div class="form-group row" style="padding: 0 15px;margin-bottom: 10px;">
                            <label class="col-sm-4 control-label">Image comments (Public):</label>
                            <div class="col-sm-6">
                                <p class="view-profile"><?php echo @$settings[$setting['image_comment']]?></p>
                                <p class="edit-profile"><select class="form-control " name="settings[image_comment]" id="image-comement">
                                    <?php foreach ($settings as $key => $value): ?>
                                        <option <?php
                                        if ($key == @$setting['image_comment']) {
                                            echo 'selected="selected"';
                                        }
                                        ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                        <?php endforeach; ?>
                                </select>
                                </p>
                            </div>
                        </div>
                        <div class="form-group row" style="padding: 0 15px;margin-bottom: 10px;">
                            <label class="col-sm-4 control-label">Image Likes (Public):</label>
                            <div class="col-sm-6">
                                <p class="view-profile"><?php echo @$settings[$setting['image_like']]?></p>
                                <p class="edit-profile"><select class="form-control" name="settings[image_like]" id="image-like">
                                    <?php foreach ($settings as $key => $value): ?>
                                        <option <?php
                                        if ($key == @$setting['image_like']) {
                                            echo 'selected="selected"';
                                        }
                                        ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                        <?php endforeach; ?>
                                </select>
                                </p>
                            </div>
                        </div>
                        <div class="form-group row" style="padding: 0 15px;margin-bottom: 10px;">
                            <label class="col-sm-4 control-label">Dezignwall image comments:</label>
                            <div class="col-sm-6">
                                <p class="view-profile"><?php echo @$settings[$setting['dezignwall_comment']]?></p>
                                <p class="edit-profile">
                                <select class="form-control" name="settings[dezignwall_comment]" id="dezignwall-comment">
                                    <?php foreach ($settings as $key => $value): ?>
                                        <option <?php
                                        if ($key == @$setting['dezignwall_comment']) {
                                            echo 'selected="selected"';
                                        }
                                        ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                        <?php endforeach; ?>
                                </select>
                                </p>
                            </div>
                        </div>
                        <div class="form-group row" style="padding: 0 15px;margin-bottom: 10px;">
                            <label class="col-sm-4 control-label">Dezignwall image Likes (Private):</label>
                            <div class="col-sm-6">
                                <p class="view-profile"><?php echo @$settings[$setting['dezignwall_like']]?></p>
                                <p class="edit-profile">
                                <select class="form-control" name="settings[dezignwall_like]" id="dezignwall-like">
                                    <?php foreach ($settings as $key => $value): ?>
                                        <option <?php
                                        if ($key == @$setting['dezignwall_like']) {
                                            echo 'selected="selected"';
                                        }
                                        ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                        <?php endforeach; ?>
                                </select>
                                </p>
                            </div>
                        </div>
                        <div class="form-group row" style="padding: 0 15px;margin-bottom: 10px;">
                            <label class="col-sm-4 control-label">Dezignwall folder comments:</label>
                            <div class="col-sm-6">
                                <p class="view-profile"><?php echo @$settings[$setting['dezignwall_folder_comment']]?></p>
                                <p class="edit-profile">
                                <select class="form-control" name="settings[dezignwall_folder_comment]" id="dezignwall-folder-comment">
                                    <?php foreach ($settings as $key => $value): ?>
                                        <option <?php
                                        if ($key == @$setting['dezignwall_folder_comment']) {
                                            echo 'selected="selected"';
                                        }
                                        ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                        <?php endforeach; ?>
                                </select>
                                </p>
                            </div>
                        </div>
                        <div class="form-group row" style="padding: 0 15px;margin-bottom: 10px;">
                            <label class="col-sm-4 control-label">Dezignwall folder Likes (Private):</label>
                            <div class="col-sm-6">
                                <p class="view-profile"><?php echo @$settings[$setting['dezignwall_folder_like']]?></p>
                                <p class="edit-profile">
                                <select class="form-control" name="settings[dezignwall_folder_like]" id="dezignwall-folder-like">
                                    <?php foreach ($settings as $key => $value): ?>
                                        <option <?php
                                        if ($key == @$setting['dezignwall_folder_like']) {
                                            echo 'selected="selected"';
                                        }
                                        ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                        <?php endforeach; ?>
                                </select>
                                </p>
                            </div>
                        </div>
                    </div><!--end group -->
                    <div class="col-sm-12  text-right edit-profile">
                        <div class="space-20"></div>
                        <button class="btn btn-gray clear-button">Clear</button>
                        <button class="btn btn-primary">Save/Update</button>
                    </div>
                </form>
            </div>
        </div>
        <?php endif;?>
        <div class="row row-height">
                <div class="col-sm-12">
                    <div class="inner-height panel panel-default box-manufacturers">
                        <div class="panel-header">
                            <div class="panel-header">
                                <h2 class="panel-title">Product Lines</h2>
                                <a class="panel-action" href="#"><i class="fa fa-pencil"></i></a>
                            </div>
                            <ul class=" manufacturers list-inline custom required-group">
                                <?php if(@$manufacturers != "" && is_array($manufacturers)):?>
                                <?php 
                                $i = 0;
                                foreach($manufacturers AS $value):?>
                                    <li>   
                                        <img src="<?php echo base_url($value["logo"]);?>">
                                        <div class="action">
                                            <div id="delete" data-type ="delete" data-id="<?php echo $value["id"];?>"><img src="<?php echo skin_url("images/delete_catalog.png");?>"></div>
                                            <div id="edit" data-type ="edit" data-id="<?php echo $value["id"];?>"><img src="<?php echo skin_url("images/edit-catalog.png")?>"></div>
                                            <div><a href="<?php echo base_url("profile/addphotos?catalog=".$value["id"]."")?>"><img src="<?php echo skin_url("images/catalog-view.png")?>"></a></div>
                                        </div>
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
                <div class="inner-height panel panel-default relative">
                    <div class="custom-loading"><img width="48" src="<?php echo skin_url(); ?>/images/loading.gif"></div>
                    <div class="panel-header">
                        <h2 class="panel-title">Contact Info</h2>
                        <a class="panel-action" href="#"><i class="fa fa-pencil"></i></a>
                    </div>
                    <form action="" method="post" class="form-horizontal form-profile">
                        <div class="form-group">
                            <label class="col-sm-4 control-label" style="font-size: 17px;">Company Name:</label>
                            <div class="col-sm-8">
                                <p class="form-control-static view-profile"><?php echo @$company_info['company_name']; ?></p>
                                <p class="edit-profile" style="display:none;"><input type="text"  value="<?php echo @$company_info['company_name']; ?>" class="form-control required" placeholder="Company Name" name="contact[company_name]"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <?php
                            $business_type = array(
                                'service' => 'All Services',
                                'architects' => 'Architects',
                                'designer' => 'Designer',
                                'manufacturer' => 'Manufacturer',
                                'supplier' => 'Supplier',
                                'photographer' => 'Service (Photographer)'
                            );
                            ?>
                            <label class="col-sm-4 control-label">Business Type:</label>
                            <div class="col-sm-8">
                                <p class="form-control-static view-profile"><?php
                                    if (isset($business_type[@$company_info['business_type']]) && $business_type[@$company_info['business_type']] != null) {
                                        echo $business_type[@$company_info['business_type']];
                                    }
                                    ?></p>
                                <p class="edit-profile" style="display:none;">
                                    <select class="form-control required" id="business_type" name="contact[business_type]">
                                        <option value=""> - Select - </option>
                                        <?php foreach ($business_type as $key => $value): ?>
                                            <option <?php
                                            if ($key == @$company_info['business_type']) {
                                                echo 'selected';
                                            }
                                            ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                            <?php endforeach; ?>
                                    </select>
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Business Description:</label>
                            <div class="col-sm-8">
                                <p class="form-control-static view-profile"><?php echo @$company_info['business_description']; ?></p>
                                <p class="edit-profile" style="display:none;"><input type="text" id="business_description"  value="<?php echo @$company_info['business_description']; ?>" class="form-control required" placeholder="Business Description" name="contact[business_description]"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Toll free:</label>
                            <div class="col-sm-8">
                                <p class="form-control-static view-profile"><?php echo @$company_info['company_800_number']; ?></p>
                                <p class="edit-profile" style="display:none;"><input type="text"  value="<?php echo @$company_info['company_800_number']; ?>" class="form-control format-phone" placeholder="Toll Free" name="contact[company_800_number]"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Local phone:</label>
                            <div class="col-sm-8">
                                <p class="form-control-static view-profile"><?php echo @$company_info['main_business_ph']; ?></p>
                                <p class="edit-profile" style="display:none;"><input type="text" value="<?php echo @$company_info['main_business_ph']; ?>" class="form-control format-phone" placeholder="Local Phone" name="contact[main_business_ph]"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Company Email:</label>
                            <div class="col-sm-8">
                                <p class="form-control-static view-profile"><a href="mailto:<?php echo @$company_info['contact_email']; ?>"><?php echo @$company_info['contact_email']; ?></a></p>
                                <p class="edit-profile" style="display:none;"><input type="email"  class="form-control required format-email" placeholder="Email"  value="<?php echo @$company_info['contact_email']; ?>" name="contact[contact_email]"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Website:</label>
                            <div class="col-sm-8">
                                <p class="form-control-static view-profile"><a href="<?php echo @$company_info['web_address']; ?>" target="_blank"><?php echo @$company_info['web_address']; ?></a></p>
                                <p class="edit-profile" style="display:none;"><input type="text"  value="<?php echo @$company_info['web_address']; ?>" class="form-control required format-url" placeholder="Website" name="contact[web_address]"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Address:</label>
                            <div class="col-sm-8">
                                <p class="form-control-static view-profile"><?php echo @$company_info['main_address']; ?></p>
                                <p class="edit-profile" style="display:none;"><input type="text" value="<?php echo @$company_info['main_address']; ?>" class="form-control" placeholder="Address" name="contact[main_address]"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">City, State:</label>
                            <div class="col-sm-8">
                                <p class="form-control-static view-profile"><?php echo @$company_info['city'] . ',' . @$company_info['state']; ?></p>
                                <div class="row edit-profile" style="display:none;">
                                    <div class="col-xs-6">
                                        <p><input type="text" value="<?php echo @$company_info['city']; ?>" class="form-control" placeholder="City" name="contact[city]"></p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><input type="text" value="<?php echo @$company_info['state']; ?>" class="form-control" placeholder="State" name="contact[state]"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Zip code:</label>
                            <div class="col-sm-8">
                                <p class="form-control-static view-profile"><?php echo @$company_info['zip_code']; ?></p>
                                <p class="edit-profile" style="display:none;"><input type="text" value="<?php echo @$company_info['zip_code']; ?>" class="form-control" placeholder="Zip Code" name="contact[zip_code]"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Country:</label>
                            <div class="col-sm-8">
                                <p class="form-control-static view-profile">
                                    <?php
                                    $country = $this->config->item('country');
                                    if (isset($company_info['country']) && $company_info['country'] != null) {
                                        echo $country[$company_info['country']];
                                    }
                                    ?>
                                </p>
                                <p class="edit-profile" style="display:none;">
                                    <select class="form-control" name="contact[country]" style="max-width:100%;">
                                        <?php foreach ($country as $key => $value) : ?>
                                            <option <?php
                                            if (@$company_info['country'] == $key) {
                                                echo 'selected="selected"';
                                            }
                                            ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                            <?php endforeach; ?>
                                    </select>
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Local Reps:</label>
                            <div class="col-sm-8">
                                <p class="form-control-static"><a href="<?php echo base_url('profile/edit_sales_reps/'); ?>"><strong>Add Additional Reps/Locations</strong></a></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12  text-right edit-profile">
                                <div class="space-20"></div>
                                <button class="btn btn-gray clear-button">Clear</button>
                                <button class="btn btn-primary">Save/Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="inner-height panel panel-default relative">
                    <div class="custom-loading"><img width="48" src="<?php echo skin_url(); ?>/images/loading.gif"></div>
                    <div class="panel-header">
                        <h2 class="panel-title">About</h2>
                        <a class="panel-action" href="#"><i class="fa fa-pencil"></i></a>
                    </div>
                    <form action="" method="post" class="form-large form-profile">
                        <div class="form-group">
                            <textarea class="form-control required" rows="13" name="about[company_about]" readonly><?php echo @$member['company_about']; ?></textarea>
                        </div>
                        <div class="form-group text-right edit-profile">
                            <div class="space-20"></div>
                            <button class="btn btn-gray clear-button">Clear</button>
                            <button class="btn btn-primary">Save/Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!--end row-->
        <?php if ($is_blog === 'no') : ?>
        <div class="row row-height">
            <div class="col-sm-6">
                <div class="inner-height panel panel-default relative profile">
                    <div class="custom-loading"><img width="48" src="<?php echo skin_url(); ?>/images/loading.gif"></div>
                    <div class="panel-header">
                        <h2 class="panel-title remove-margin-bottom">Photos</h2>
                        <div class="impromation-project" style="display:block;background: none;left:auto;top:-10px;">
                            <div class="container relative">
                                <div class="impromation-project-dropdown">
                                    <div class="dropdown-impromation relative">
                                        <span class="glyphicon glyphicon-menu-down" aria-hidden="true" style="color:#212121;"></span>
                                        <ul class="dropdown-impromation-menu" style="background: #f1f1f1;min-width: 120px;" id="deziwall">
                                            <li><a href="<?php echo base_url('profile/myphoto'); ?>">View all images</a></li>
                                            <li><a href="<?php echo base_url('profile/addphotos'); ?>">Upload images</a></li>
                                            <li><a class="edit-image" href="#" >Edit images</a></li>
                                            <li><a href="#" class="not-report" data-reporting="company" id="share-social" data-title ="<?php echo @$member['company_name']; ?>" data-type ="profile" data-id ="<?php echo $member["id"]; ?>">Share Profile</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if (isset($photos) && count($photos) > 0): ?>
                        <ul class="pgwSlideshow">
                            <?php foreach ($photos as $key => $value): ?>
                                <li><a class="slider-item" href="<?php echo base_url(); ?>photos/<?php echo $value['photo_id']; ?>/<?php echo @$value['name']; ?>.html"><img data-src="<?php echo base_url('/profile/editphoto/'.$value['photo_id']); ?>" src="<?php echo base_url(@$value['path_file']); ?>" alt="<?php echo @$value['name'] ?>"></a></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                    <div class="space-20"></div>
                    <!--<div class="text-right edit-profile">
                      <button class="btn btn-gray clear-button">Clear</button>
                      <button class="btn btn-primary">Click to Edit</button>
                    </div>-->
                </div>
            </div>
            <div class="col-sm-6">
                <div class="inner-height panel panel-default relative">
                    <div class="custom-loading"><img width="48" src="<?php echo skin_url(); ?>/images/loading.gif"></div>
                    <form method="post" id="certifications-form" action="<?php echo base_url(); ?>profile/save" enctype="multipart/form-data" class="form-large form-profiles">
                        <div class="panel-header">
                            <h2 class="panel-title remove-margin-bottom">Certifications</h2>
                            <a class="panel-action" href="#"><i class="fa fa-pencil"></i></a>
                        </div>
                        <div class="form-group">
                            <?php $certifications = json_decode(@$company_info['certifications'], true); ?>
                            <p class="edit-profile text-left">
                                <span class="btn btn-default btn-file">
                                    Browse <input type="file" name="certification[]" multiple="multiple" accept="image/*">
                                </span>
                            </p>
                            <p class="text-left certifications_image" style="margin-bottom:0;">
                                <?php
                                $certifications_image = '';
                                if (count($certifications) > 0) :
                                    $image = json_decode(@$certifications['image'], true);
                                    $certifications_image = json_encode($image);
                                    if (isset($image) && count($image) > 0) {
                                        foreach ($image as $key => $value) {
                                            ?>  <span style="display: inline-block;position: relative;">
                                                <a href="#" class="edit-profile delete-image-certifications"><i class="fa fa-times"></i></a>
                                                <img src="<?php echo $value; ?>" style="height:100px;display:inline-block;margin-right:10px;margin-bottom:10px;">
                                            </span>
                                            <?php
                                        }
                                    }
                                endif;
                                ?>
                            </p>
                            <input type="hidden" name="certifications_image" value='<?php echo @$certifications_image; ?>'>
                            <textarea class="form-control" name="company[certifications]" rows="4" readonly><?php
                                if (count($certifications) > 0) {
                                    echo @$certifications['text'];
                                } else {
                                    echo @$company_info['certifications'];
                                }
                                ?></textarea>
                        </div>
                        <div class="space-20"></div>
                        <div class="panel-header">
                            <h2 class="panel-title remove-margin-bottom">Service Areas</h2>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control"  name="company[service_area]" rows="7" readonly><?php echo @$company_info['service_area']; ?></textarea>
                        </div>
                        <div class="form-group text-right edit-profile">
                            <div class="space-20"></div>
                            <button class="btn btn-gray clear-button">Clear</button>
                            <button class="btn btn-primary">Save/Update</button>
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
                        <?php if(isset($article[0])):?>
                            <a class="panel-action-photo" id="goto-edit-post" title="edit article" href="<?php echo base_url("article/edit/".$article[0]["id"]);?>"><i class="fa fa-pencil"></i></a>
                        <?php endif; ?>
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
                                <a href="<?php echo base_url("article");?>" class="btn btn-primary">Click to Edit</a>
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
<div id="myModal-download-contacts" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content" style=" border-radius: 0; ">
            <div class="modal-body">
                <h4><strong>Download Contact Information</strong></h4>
                <div class="content-form">
                    <div class="form-group row">
                        <label class="control-label col-md-3">Save in:</label>
                        <div class="col-md-9">
                            <select id="save-in" class="form-control">
                                <option value="1">Downloads</option>
                                <option value="1">test</option>
                                <option value="1">test</option>
                                <option value="1">test</option>
                                <option value="1">test</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3">File name:</label>
                        <div class="col-md-9"><input type="text" value="file-name.csv" id="file-name" class="form-control" placeholder="File name" disabled></div>
                    </div>
                    <div class="form-group row text-right">
                        <div class="col-md-12">
                            <button class="btn btn-gray" data-dismiss="modal">Cancel</button>
                            <button class="btn btn-primary">Save AS</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<?php $this->load->view("include/edit-catalog"); ?>
<?php $this->load->view("include/delete_catalog"); ?>
<?php if (isset($status_member) && $status_member == 0): ?>
<?php $this->load->view("include/getting-started-popup"); ?> 
<?php endif; ?>
<style type="text/css">
    .form-group{margin-bottom: 0;}
    @media screen and ( max-width: 768px ){
        .manufacturers li{width: 100% !important;}
        .manufacturers .action{right: 0 !important;}
    }
</style>
<?php if ($is_blog === 'yes') : ?>
<script type="text/javascript">
    var mySider = $('.bxsliders_edit').bxSlider({
        pagerCustom: '#bx-pager-edit',
        auto:true,
        pause:4000,
        autoStart:true,
        onSlideBefore:function($slideElement, oldIndex, newIndex){
            var id = $slideElement.attr("data-id");
            $("#goto-edit-post").attr("href",base_url+"article/edit/"+id);      
        },
        onSlideAfter:function($slideElement, oldIndex, newIndex){
            var id = $slideElement.attr("data-id");
            $("#goto-edit-post").attr("href",base_url+"article/edit/"+id); 
        },
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
    var number_slider = 10;
    if(box_width < 768){
        number_slider = 5;
    }
    if(box_width < 460){
        number_slider  = 3;
    }
    var width_img = box_width / number_slider;
    $("#bx-pager-edit").bxSlider({
        minSlides:number_slider,
        maxSlides:number_slider,
        slideWidth: width_img,
        pager:false
    });
</script>
<?php endif;?>
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
<script type="text/javascript">
    $(document).ready(function(){
        var number = $(".manufacturers li").length;
        if(number > 4){
            $(".more-manufacturers").show();
        }else{
            $(".more-manufacturers").hide();
        }
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
    var _this;
    $(document).on("click",".manufacturers .action #delete",function(){
        $("#delete_catalog").modal();
        _this = $(this);
    });
    $(document).on("click","#delete_catalog #ok-delete",function(e){
        var id = _this.data("id");
        if(typeof id !=="undefined"){
            $.ajax({
                url:base_url+"profile/action_manufacturers",
                type:"post",
                dataType:"json",
                data:{"id" : id},
                success:function(data){
                    if(data["status"] == "success"){
                        _this.parents("li").remove();
                        $("#delete_catalog").modal("hide");
                    }
                }
            });
        }
        return false;
    })
    $(document).on("click",".manufacturers .action #catalog",function(){
        var id = $(this).data("id");
        $(".upload-logo #upload-logo-form #catalog-id").val(id);
        $(".upload-logo #upload-logo-form #file-logo").trigger("click");
    });
</script>
<style type="text/css">
    #lable-upload{cursor: pointer;}
    .box-upload{margin-top:20px;}
    #modal_edit_catalog .modal-title{font-size: 24px; color: #212121;}
    #modal_edit_catalog .form-group{float: left;width: 100%;}
    #modal_edit_catalog .modal-dialog{width: 650px; max-width: 100%;}
    button.close{
        font-size: 30px;
        color: #000;
        opacity: 1;
        position: absolute;
        right: 10px;
        top: 5px;
        z-index: 9;
    }
    #modal_edit_catalog .modal-content{border-radius: 0;}
    .bx-slider-edit{background-color: #7f7f7f; padding: 10px 10px 10px 0px;}
    .bx-slider-edit .slider-top .bx-wrapper .bx-viewport{
        margin: 0;
        margin-left: 10px;
    }

    #bx-pager-edit .slider-top a img {
        padding: 3px;
        border: solid #ccc 1px;
        width: 100px;
        height: 100px;
        display: inline-block;

    }
    #bx-pager-edit .slider-top a:hover img,
    #bx-pager-edit .slider-top a.active img {
        border: solid #5280DD 1px;
    }
    #myModal-download-contacts .form-group{
        margin-bottom: 10px;
    }
    #myModal-download-contacts .content-form{
        margin-top: 30px;
    }
    #myModal-download-contacts #file-name{
        border: 1px solid #000;
        background-color: #f1f1f1 !important;
        border: 1px solid #000;
        padding: 0px 10px !important;
    }
    .manufacturers li {width: 49%; margin-bottom: 30px;position: relative;}
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
    .manufacturers .action{
        position: absolute; 
        right: 40%;
        top:0;
    }
    .manufacturers .action > div{display: inline-block;margin-left: 10px; cursor: pointer;}
    .manufacturers .action > div img{height: 25px;}
    body .box-wapper-show-image{z-index: auto;}
    body .profile-image .avatar-media-object {
        width: 162px;
        height: 162px;
    }
    body .avatar-view{border:none;box-shadow: none;}

</style>