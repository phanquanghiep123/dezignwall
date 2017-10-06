<?php if(! (isset($sales_reps) && count($sales_reps)>0)  ){
   $sales_reps=array(
      array('id'=>0),
      array('id'=>0)
   );
}?>
  <?php
    $data['menu_banner'] = array(
    array('href' => base_url('profile/edit'), 'title' => 'Edit profile', 'class' => ''),
    array('href' => base_url('profile/'), 'title' => 'View public profile', 'class' => ''),
      array('href' => base_url('profile/conversations/'), 'title' => 'View Messages', 'class' => ''),
      array('href' => base_url('/profile/upgrade/'), 'title' => 'Upgrade Account', 'class' => ''),
      array('href' => '#', 'title' => 'Delete account', 'class' => 'delete_account')
  );
  $this->load->view("include/banner.php", $data);
  ?>
      <section class="section box-wapper-show-image">
<div class="container">
     <div class="space-20"></div>
     <p class="text-right"><button id="btn-add-more" class="btn btn-primary">Add More</button></p>
     <?php if(isset($sales_reps) && count($sales_reps)>0):?>
          <div class="row form-rep-info-add">
           <?php foreach ($sales_reps as $key => $value) : ?>

             <div class="col-sm-6 rep-item">
                <form class="form-horizontal" action="" method="post">    
                     <div class="panel panel-default relative">
                           <div class="custom-loading"><img width="48" src="<?php echo skin_url(); ?>/images/loading.gif"></div>
                           <div class="panel-header">
                              <a class="panel-action cancel" href="#" style="display:none;"><i class="fa fa-times"></i></a>
                              <div class="row custom">
                                <div class="col-sm-4">
                                  <h3 class="remove-margin-top"><strong>Local Rep:</strong></h3>
                                </div>
                                <div class="col-sm-8">
                                <div class="checkbox check-yelow checkbox-circle" style="margin-top: -8px;">
                                    <?php 
                                        $public = "";
                      if(isset($value["is_public"]) && $value["is_public"] == 1){
                          $public= "checked";
                      }
                                    ?>
                                    <p class="edit-profile"><input type="checkbox" value="1" <?php echo $public;?> disabled> <label>Display on public profile</label></p>
                                      <p class="hide edit-profile"><input id="public-<?php echo $key; ?>" name="public"  type="checkbox" value="1" <?php echo $public;?>>
                                      <label for="public-<?php echo $key; ?>">Display on public profile</label></p>
                                  </div>
                              </div>
                            </div>
                              <div class="impromation-project" style="display:block;background: none;left:auto;top:-10px;">
                        <div class="container relative">
                          <div class="impromation-project-dropdown">
                              <div class="dropdown-impromation relative">
                                  <span class="glyphicon glyphicon-menu-down" aria-hidden="true" style="color:#212121;"></span>
                                <ul class="dropdown-impromation-menu" style="background: #f1f1f1;min-width: 140px;" id="deziwall">
                                    <?php if(isset($value["id"]) && $value["id"] != 0 && @$type_member == 1):?>
                                            <li><a href="#" id="send_digital_card" data-id ="<?php echo $value["id"] ;?>">Send confirmation</a></li>              
                                          <?php endif;?>
                                          <li><a href="#" onclick="$(this).parents('.rep-item').find('.panel-action').trigger('click'); return false; ">Delete profile</a></li>
                                          <li><a id="edit-item" href="<?php base_url("profile/edit")?>">Edit profile</a></li>
                                  </ul>
                              </div>
                          </div>
                        </div>
                  </div>
                           </div>
                           <div style="height:10px;"></div>
                           <input type="hidden" class="disabled" name="rep[id]" value="<?php echo @$value['id']; ?>">
                           <div class="form-group">
                              <label class="col-sm-4 control-label">First name:</label>
                              <div class="col-sm-8">
                                <p class="edit-profile"><?php echo @$value['first_name']; ?></p>
                                <p class="hide edit-profile"><input type="text"  value="<?php echo @$value['first_name']; ?>" class="form-control required" placeholder="First name" name="rep[first_name]"></p>
                              </div>
                           </div>

                           <div class="form-group">
                              <label class="col-sm-4 control-label">Last name:</label>
                              <div class="col-sm-8">
                                <p class="edit-profile"><?php echo @$value['last_name']; ?></p>
                                <p class="hide edit-profile"><input type="text"  value="<?php echo @$value['last_name']; ?>" class="form-control required" placeholder="Last name" name="rep[last_name]"></p>
                              </div>
                           </div>

                           <div class="form-group">
                              <label class="col-sm-4 control-label">Job title:</label>
                              <div class="col-sm-8">
                                 <p class="edit-profile"><?php echo @$value['job_title']; ?></p>
                                 <p class="hide edit-profile"><input type="text"  value="<?php echo @$value['job_title']; ?>" class="form-control" placeholder="Job title" name="rep[job_title]"></p>
                              </div>
                           </div>
                           <div class="form-group">
                              <label class="col-sm-4 control-label">Toll free:</label>
                              <div class="col-sm-8">
                                 <p class="edit-profile"><?php echo @$value['number_800']; ?></p>
                                 <p class="hide edit-profile"><input type="text" value="<?php echo @$value['number_800']; ?>" class="form-control format-phone" placeholder="Toll Free" name="rep[number_800]"></p>
                              </div>
                           </div>
                           <div class="form-group">
                              <label class="col-sm-4 control-label">Local phone:</label>
                              <div class="col-sm-8">
                                 <p class="edit-profile"><?php echo @$value['main_business_ph']; ?></p>
                                 <p class="hide edit-profile"><input type="text" value="<?php echo @$value['main_business_ph']; ?>" class="form-control format-phone" placeholder="Local phone" name="rep[main_business_ph]"></p>
                              </div>
                           </div>
                         <div class="form-group">
                            <label class="col-sm-4 control-label">Cell phone:</label>
                            <div class="col-sm-8">
                               <p class="edit-profile"><?php echo @$value['cellphone']; ?></p>
                               <p class="hide edit-profile"><input type="text" value="<?php echo @$value['cellphone']; ?>" class="form-control disabled format-phone" placeholder="Cell phone" disabled></p>
                            </div>
                         </div>
                           <div class="form-group">
                              <label class="col-sm-4 control-label">Email:</label>
                              <div class="col-sm-8">
                                 <p class="edit-profile"><?php echo @$value['contact_email']; ?></p>
                                 <p class="hide edit-profile"><input type="text" value="<?php echo @$value['contact_email']; ?>" class="form-control format-email required" placeholder="Email" name="rep[contact_email]"></p>
                              </div>
                           </div>
                           <div class="form-group">
                              <label class="col-sm-4 control-label">Website:</label>
                              <div class="col-sm-8">
                                 <p class="edit-profile"><?php echo @$value['web_address']; ?></p>
                                 <p class="hide edit-profile"><input type="text" value="<?php echo @$value['web_address']; ?>" class="form-control format-url" placeholder="Website" name="rep[web_address]"></p>
                              </div>
                           </div>
                           <div class="form-group">
                              <label class="col-sm-4 control-label">Address:</label>
                              <div class="col-sm-8">
                                 <p class="edit-profile"><?php echo @$value['main_address']; ?></p>
                                 <p class="hide edit-profile"><input type="text" value="<?php echo @$value['main_address']; ?>" class="form-control" placeholder="Address" name="rep[main_address]"></p>
                              </div>
                           </div>
                           <div class="form-group">
                              <label class="col-sm-4 control-label">City:</label>
                              <div class="col-sm-8">
                                 <p class="edit-profile"><?php echo @$value['city']; ?></p>
                                 <p class="hide edit-profile"><input type="text" value="<?php echo @$value['city']; ?>" class="form-control" placeholder="City" name="rep[city]"></p>
                              </div>
                           </div>
                           <div class="form-group">
                              <label class="col-sm-4 control-label">State:</label>
                              <div class="col-sm-8">
                                <p class="edit-profile"><?php echo @$value['state']; ?></p>
                                <p class="hide edit-profile"><input type="text" value="<?php echo @$value['state']; ?>" class="form-control" placeholder="State" name="rep[state]"></p>
                              </div>
                           </div>
                           <div class="form-group">
                              <label class="col-sm-4 control-label">Zip code:</label>
                              <div class="col-sm-8">
                                 <p class="edit-profile"><?php echo @$value['zip_code']; ?></p>
                                 <p class="hide edit-profile"><input type="text" value="<?php echo @$value['zip_code']; ?>" class="form-control" placeholder="Zip code" name="rep[zip_code]"></p>
                              </div>
                           </div>
                           <div class="form-group">
                              <label class="col-sm-4 control-label">Country:</label>
                              <div class="col-sm-8">
                                 <p class="edit-profile">
                                  <?php foreach ($this->config->item('country') as $key1 => $value1) :?>
                                         <?php if($key1==@$value['country']){ echo $value1; }?>
                                    <?php endforeach; ?>
                                 </p>
                                 <p class="hide edit-profile"><select class="form-control" name="rep[country]" style="max-width:100%;">
                                    <?php foreach ($this->config->item('country') as $key1 => $value1) :?>
                                        <option <?php if($key1==@$value['country']){echo 'selected="selected"';} ?> value="<?php echo $key1; ?>"><?php echo $value1; ?></option>
                                    <?php endforeach; ?>
                                 </select></p>
                              </div>
                           </div>
                           <div class="form-group">
                              <label class="col-sm-4 control-label">Service area:</label>
                              <div class="col-sm-8">
                                  <p class="edit-profile"><?php echo @$value['service_area']; ?></p>
                                  <p class="hide edit-profile"><input type="text" id="keyword-tag" value="<?php echo @$value['service_area']; ?>" class="form-control" placeholder="Service area" name="rep[service_area]"></p>
                              </div>
                           </div>
                           <h2>Personal login password</h2>
                           <div class="form-group">
                              <label class="col-sm-4 control-label">Password:</label>
                              <div class="col-sm-8">
                                 <?php $password = (isset($value['pwd']) && $value['pwd'] != "") ? $value['pwd'] : "Admin123";?>
                                 <p class="edit-profile password-text">******</p>
                                 <p class="hide edit-profile relative"><input type="password" id="password" value="<?php echo $password; ?>" class="form-control bg-input" placeholder="XXXXXX" name="rep[password]"><div id="show_hidden" class="hide edit-profile"><img src="<?php echo base_url("skins/images/View-Icon.png");?>"></div></p>
                              </div>
                           </div>
                           <div class="form-group">
                              <label class="col-sm-4 control-label">Confirm Password:</label>
                              <div class="col-sm-8">
                                 <p class="edit-profile password-text">******</p>
                                 <p class="hide edit-profile relative"><input type="password" id="password-confirm" data-math="#password" value="<?php echo $password; ?>" class="form-control bg-input" placeholder="XXXXXX" name="rep[confirm_password]"><div id="show_hidden" class="hide edit-profile"><img src="<?php echo base_url("skins/images/View-Icon.png");?>"></div></p>
                              </div>
                           </div>
                           <div class="form-group hide edit-profile">
                              <div class="col-sm-12 text-right">
                                 <div class="space-20"></div>
                                 <a class="btn btn-gray clear-button-sr">Clear</a>
                                 <button class="btn btn-primary">Save/Update</button>
                              </div>
                           </div>
                     </div>
                  </form>
             </div>
           <?php endforeach; ?>
           </div><!--end row-->
     <?php endif;?>
</div>
      </section>
<link rel="stylesheet" type="text/css" href="<?php echo skin_url(); ?>/css/jquery.tagit.css">
<link rel="stylesheet" type="text/css" href="<?php echo skin_url(); ?>/css/tagit.ui-zendesk.css">
<script src="<?php echo skin_url(); ?>/js/tag-it.min.js"></script>
<style type="text/css">
    .form-group{margin-bottom: 0;}
    .rep-item:first-child .panel-action{display: none;}
    .panel-header .panel-action{
      top: -12px;
      right: -5px;
      font-size: 15px;
      z-index: 100;
    }
    .bg-input{background-color: #f1f1f1;}
    .edit-profile {display:block;}
    body ul.tagit{
      border-color: #000;
      border-radius: 0;
      padding: 0;
      max-height: 35.5px
    }
    body ul.tagit li{font-size: 17px;}
    .none{opacity: 0;visibility: hidden;height: 0;width: 0;overflow: hidden;}
  .disabled{
      background-color: #f1f1f1 !important;
      border: 1px solid #000 ;
      padding: 0px 10px !important;
  }
  input[disabled]{
      border: 1px solid #000 !important ;
  }
    #show_hidden{position: absolute; right: 15px;top: 5px;width: 25px; cursor: pointer;}
    .show{display: block !important;}
    .hide{display: none;}
    .password-text{margin-top:10px; margin-bottom: 0;}
</style>
<script type="text/javascript">
    $(document).on("click", "#show_hidden", function() {
        $(this).toggleClass("open");
        if ($(this).hasClass("open") == true) {
            $(this).parent().find("input").attr("type", "text");
        } else {
            $(this).parent().find("input").attr("type", "password");
        }
        return false;
    });
    $(document).on("click", ".rep-item .form-horizontal #edit-item", function() {
        $(this).parents(".rep-item").find(".edit-profile").toggleClass("hide");
        $(this).toggleClass("open");
        if ($(this).hasClass("open") == true) {
            $(this).text("View profile");
        } else {
            $(this).text("Edit profile");
        }
        return false;
    });
    $(document).ready(function() {
        var name_not_show = "";
        $(document).on("mouseup", "#keyword-tag", function() {
            var _this_new = $(this);
            $(this).tagit({
                allowSpaces: true,
                fieldName: "keyword[]",
                autocomplete: {
                    delay: 0,
                    minLength: 1
                },
                tagSource: function(request, response) {
                    name_not_show = _this_new.val();
                    $.ajax({
                        url: base_url + "profile/get_services",
                        type: "post",
                        data: {
                            slug: request.term,
                            list_id: name_not_show
                        },
                        dataType: "json",
                        success: function(data) {
                            if (data["status"] == "success") {
                                response($.map(data["reponse"], function(item) {
                                    return {
                                        label: item.title,
                                        value: item.title,
                                    }
                                }));
                            }
                        }
                    });
                }
            });
            $(this).parents(".form-group").find(".edit-profile .tagit .tagit-new > input").focus();
        });
        $.each($("form #keyword-tag"), function() {
            var _this_new = $(this);
            $(this).tagit({
                allowSpaces: true,
                fieldName: "keyword[]",
                autocomplete: {
                    delay: 0,
                    minLength: 1
                },
                tagSource: function(request, response) {
                    name_not_show = _this_new.val();
                    $.ajax({
                        url: base_url + "profile/get_services",
                        type: "post",
                        data: {
                            slug: request.term,
                            list_id: name_not_show
                        },
                        dataType: "json",
                        success: function(data) {
                            if (data["status"] == "success") {
                                response($.map(data["reponse"], function(item) {
                                    return {
                                        label: item.title,
                                        value: item.title,
                                    }
                                }));
                            }

                        }
                    });
                }
            });
        });
        var clone_html = $(".rep-item").eq(0).html();
        $('#btn-add-more').click(function() {
            var html = clone_html;
            html = '<div class="col-sm-6 rep-item">' + html + '</div>';
            var el = $(html);
            var key = makeid();
            el.find('input,select').val('');
            el.find('input[name="rep[id]"]').val('0');
            el.find("#send_digital_card").remove();
            el.find("ul.tagit").remove();
            el.find("#keyword-tag").removeClass("tagit-hidden-field");
            el.find(".checkbox.check-yelow.checkbox-circle").find(">input").prop("checked", false);
            el.find(".checkbox.check-yelow.checkbox-circle").find(">input").attr("id", "public-" + key);
            el.find(".checkbox.check-yelow.checkbox-circle").find(">label").attr("for", "public-" + key);
            el.find("p.edit-profile:not(.hide)").text("");
            el.find("input[type=password]").val("Admin123");
            el.find(".edit-profile").toggleClass("hide");
            el.find("#edit-item").text("View profile").addClass("open");
            $(".form-rep-info-add").append(el);
            return false;
        });

        function makeid() {
            var text = "";
            var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
            for (var i = 0; i < 15; i++)
                text += possible.charAt(Math.floor(Math.random() * possible.length));
            return text;
        }
        $(document).on('click', '.panel-action', function() {
            var parent = $(this).parents('.rep-item');
            var id = parseInt(parent.find('input[name="rep[id]"]').val());
            if (id == 0) {
                $(this).parents('.rep-item').fadeOut('slow', function() {
                    $(this).remove();
                });
            } else {
                $.ajax({
                    url: base_url + '/profile/delete_salep_rep',
                    type: 'POST',
                    data: {
                        'id': id
                    },
                    dataType: 'json',
                    success: function(reponse) {
                        if (reponse['status'] == 'success') {
                            parent.fadeOut('slow', function() {
                                $(this).remove();
                            });

                        }
                    },
                    complete: function() {},
                    error: function(data) {
                        console.log(data['responseText']);
                    }
                });
            }
            return false;
        });
        $(document).on('click', '.rep-item .clear-button-sr', function() {
            $(this).parents('form').find("ul.tagit li:not(.tagit-new)").remove();
            $(this).parents('form').find('input:not(.disabled)').val('');
            $(this).parents('form').find('textarea').val('');
            return false;
        });
        var reset_click = 0;
        $(document).on('submit', '.rep-item form', function() {
            var bool = true;
            var messenger = "";
            $(this).find("#password,#password-confirm").attr("type", "password");
            $(this).find(".open").removeClass("open");
            $(this).find(".warning").removeClass("warning");
            $(this).find('input,textarea').each(function() {
                var value = $(this).val();
                if ($(this).hasClass('required')) {
                    if (value == null || $.trim(value) == '') {
                        $(this).addClass("warning");
                        bool = false;
                        messenger = 'Please fill in all required fields marked with an asterisk.';
                    } else {
                        if ($(this).attr("type") == "password" && $(this).val().length < 6) {
                            if (messenger == "") {
                                messenger = "Password must be at least 6 characters long";
                            }
                            bool = false;
                            $(this).addClass("warning");
                        } else if (typeof $(this).data("math") !== "undefined") {
                            if ($(this).val() != $(this).parents("form").find($(this).data("math")).val()) {
                                $(this).addClass("warning");
                                bool = false;
                                if (messenger == "") {
                                    messenger = "Confirm Password do not match Password.";
                                }
                            }
                        }
                    }
                }
                if (value != "" && $(this).attr("type") == "password" && $(this).val().length < 6) {
                    if (messenger == "") {
                      messenger = "Password must be at least 6 characters long";
                    }
                    bool = false;
                    $(this).addClass("warning");
                }
                if (typeof $(this).data("math") !== "undefined") {
                    if ($(this).val() != $(this).parents("form").find($(this).data("math")).val()) {
                        $(this).addClass("warning");
                        bool = false;
                        if (messenger == "") {
                          messenger = "Confirm Password do not match Password.";
                        }
                    }
                }
                if($(this).hasClass("format-email") == true){
                  if(!isEmail(value)){
                    $(this).addClass("warning");
                    messenger = "Email is invalid. Please try again.";
                    bool == false;
                  }
                }
            });
            if (bool == false) {
                messenger_box("Edit Reps", messenger);
            } else {
                bool = bool && valid_all_format($(this), false);
            }
            if (bool == false) {
                return bool;
            }
            var parent = $(this).parents('.rep-item');
            var data_form = $(this).serialize();
            parent.find('.custom-loading').show();
            if (reset_click == 0) {
                reset_click = 1;
                $.ajax({
                    url: base_url + '/profile/save_salep_rep',
                    type: 'POST',
                    data: data_form,
                    dataType: 'json',
                    success: function(reponse) {
                        if (reponse['status'] == 'success') {
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        }
                        reset_click = 0;
                    },
                    complete: function() {
                        parent.find('.custom-loading').hide();
                    },
                    error: function(data) {
                        console.log(data['responseText']);
                        reset_click = 0;
                    }
                });
            }
            return false;
        });
        $(document).on("click", "#send_digital_card", function() {
            var id_sales_reps = $(this).data("id");
            if (reset_click == 0) {
                reset_click = 1;
                $.ajax({
                    url: base_url + "home/send_digital_card",
                    type: "post",
                    dataType: "json",
                    data: {
                        "id": id_sales_reps
                    },
                    success: function(data) {
                        if (data["success"] == 'success') {
                            messenger_box("Message", "Email sent successfully.");
                        } else {
                            messenger_box("Message", "Email sent unsuccessful.");
                        }
                        reset_click = 0;
                    },
                    error: function() {
                        messenger_box("Message", "Email sent unsuccessful.");
                        reset_click = 0;
                    }
                });
            }
            return false;
        });
    });;
function isEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}
</script>