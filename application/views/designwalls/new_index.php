    <?php
        $user_info = $this->session->userdata('user_info');
        $allow_edit = (isset($member) && isset($user_info) && $user_info['id'] == $member['id'] && !$this->session->userdata('user_sr_info')) ? true : false;
        $data = null;
        if ($allow_edit) {
            $data['menu_banner'] = array(
                array('href' => '#', 'title' => 'Edit background', 'class' => 'edit_background'),
                array('href' => '#', 'title' => 'Hide background', 'class' => 'show_hide_background'),
                array('href' => '#', 'title' => 'Invite team members', 'class' => 'invite_member'),
                array('href' => '#', 'title' => 'Delete your Wall', 'class' => 'delete_wall'),
                array('href' => base_url('/profile/upgrade/'), 'title' => 'Upgrade Account', 'class' => '')
            );
        } else {
            $data['menu_banner'] = array(
                array('href' => '#', 'title' => 'Hide background', 'class' => 'show_hide_background'),
                array('href' => '#', 'title' => 'Invite team members', 'class' => 'invite_member')
            );
        }
        $this->load->view("include/banner.php", $data);
    ?>
    
     <div class="content_designwalls box-wapper-show-image">
        <div class="container">
            <h1 class="text-center title">Your Walls</h1>
            <div class="row">
                <div class="col-md-4">
                    <?php if(@$upgrade == true):?>
                    <div class="box-add-new">
                        <div class="header-add-new">
                            <a href="<?php echo base_url("designwalls/add")?>"><p style="position: relative;z-index: 9; "><strong>Create a New Wall</strong></p></a>
                            <p>Manage multiple projects</p>
                            <div class="impromation-project ">
                                <div class="impromation-project-dropdown">
                                    <div class="dropdown-impromation relative">
                                        <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>
                                        <ul class="dropdown-impromation-menu">
                                            <li><a class="not-report" href="<?php echo base_url("designwalls/add");?>">Create New Wall...</a></li>
                                            <li><a class="not-report" href="<?php echo base_url("designwalls/upgrade");?>">Upgrade Your Wall...</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="content-add-new">
                            <div class="box-add">
                                <a href="<?php echo base_url("designwalls/add")?>"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                <p>Create a New Wall</p>
                            </div>
                        </div>
                        <div class="box-footer-and-more">
                            <p class="project-folders">Project Folders:</p>
                            <div class="footer-add-new">
                                <div class="row item-footer">
                                    <div class="col-xs-2 text-center">
                                        <img src="<?php echo skin_url("images/footer-add-new-1.png")?>">
                                    </div>
                                    <div class="col-xs-10">
                                        <p><strong>Create New Projects</strong></p>
                                        <p>Stay orgnaized while you ideate and source vendors without losing contact information.</p>
                                    </div>
                                </div>
                                <div class="row item-footer">
                                    <div class="col-xs-2 text-center">
                                        <img src="<?php echo skin_url("images/footer-add-new-2.png")?>">
                                    </div>
                                    <div class="col-xs-10">
                                        <p><strong>Build Unique Teams</strong></p>
                                        <p>Create teams around the different areas and products of your project. Share with clients!</p>
                                    </div>
                                </div>
                                <div class="row item-footer">
                                    <div class="col-xs-2 text-center">
                                        <img src="<?php echo skin_url("images/footer-add-new-3.png");?>">
                                    </div>
                                    <div class="col-xs-10">
                                        <p><strong>Upload Private Images</strong></p>
                                        <p>Upload images from your phone and other sites and share them privately with your team. </p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-right"><a href="<?php echo base_url("designwalls/add")?>">Create a New Wall</a></div>
                                </div>
                            </div>
                    </div>
                <?php else :?>
                    <div class="box-add-new">
                        <div class="header-add-new">
                            <a id="upgrade-show" href="#"><p style="position: relative;z-index: 9; "><strong>Create a New Wall</strong></p></a>
                            <p>Manage multiple projects</p>
                            <div class="impromation-project ">
                                <div class="impromation-project-dropdown">
                                    <div class="dropdown-impromation relative">
                                        <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>
                                        <ul class="dropdown-impromation-menu">
                                            <li><a class="not-report" href="<?php echo base_url("designwalls/add");?>">Create New Wall...</a></li>
                                            <li><a class="not-report" href="<?php echo base_url("designwalls/upgrade");?>">Upgrade Your Wall...</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="content-add-new">
                            <div class="box-add">
                                <a id="upgrade-show" href="#"><i class="fa fa-plus" aria-hidden="true"></i></i></a>
                                <p>Create a New Wall</p>
                                <p id="add_upgrade"><a href="<?php echo base_url("designwalls/upgrade")?>">Oops! Looks like you’re out of Walls.<br>
                                Click here to add more Walls.</a></p>
                            </div>
                        </div>
                        <div class="box-footer-and-more">
                            <p class="project-folders">Project Folders:</p>
                            <div class="footer-add-new">
                                <div class="row item-footer">
                                    <div class="col-xs-2 text-center">
                                        <img src="<?php echo skin_url("images/footer-add-new-1.png")?>">
                                    </div>
                                    <div class="col-xs-10">
                                        <p><strong>Create New Projects</strong></p>
                                        <p>Stay orgnaized while you ideate and source vendors without losing contact information.</p>
                                    </div>
                                </div>
                                <div class="row item-footer">
                                    <div class="col-xs-2 text-center">
                                        <img src="<?php echo skin_url("images/footer-add-new-2.png")?>">
                                    </div>
                                    <div class="col-xs-10">
                                        <p><strong>Build Unique Teams</strong></p>
                                        <p>Create teams around the different areas and products of your project. Share with clients!</p>
                                    </div>
                                </div>
                                <div class="row item-footer">
                                    <div class="col-xs-2 text-center">
                                        <img src="<?php echo skin_url("images/footer-add-new-3.png");?>">
                                    </div>
                                    <div class="col-xs-10">
                                        <p><strong>Upload Private Images</strong></p>
                                        <p>Upload images from your phone and other sites and share them privately with your team. </p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-right"><a id="upgrade-show" href="#">Create a New Wall</a></div>
                                </div>
                            </div>
                    </div>
                <?php endif;?>
                </div>
                <?php if(isset($project) && $project != null):?>
                    <?php foreach ($project AS $key => $value):?>
                        <div class="col-md-4">
                            <div class="box-item-designwalls">
                                <div class="header-add-item">
                                    <div class="impromation-project ">
                                        <div class="top-impromation-designwalls">
                                            <a href="<?php echo base_url("designwalls/view/".$value["project_id"])?>"><p style="position: relative;z-index: 9; "><strong><?php echo $value["project_name"]?></strong></p></a>
                                            <p><?php echo $value["start_date"]?> - <?php echo $value["due_date"]?></p>
                                        </div>
                                        <div class="impromation-project-dropdown">
                                            <div class="dropdown-impromation relative">
                                                <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>
                                                <ul class="dropdown-impromation-menu">
                                                <?php if($value["type_project"] == "custom"):?>
                                                    <li><a class="not-report" id="delete_wall" data-id="<?php echo $value["project_id"]?>" href="#">Delete Wall...</a></li>
                                                <?php endif;?>
                                                    <li><a class="not-report" href="<?php echo base_url("designwalls/add");?>">Create New Wall...</a></li>
                                                    <li><a class="not-report" href="<?php echo base_url("designwalls/upgrade");?>">Upgrade Your Wall...</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <?php $img = (isset($value["path_file"]) && file_exists(FCPATH.'/'.$value["path_file"]) && $value["path_file"] != "") ? $value["path_file"] : "skins/images/default-wall.jpg" ;?>
                                    <a href="<?php echo base_url("designwalls/view/".$value["project_id"])?>"><div class="img-category" style="background-image: url('<?php echo base_url($img) ;?>');"></div></a>
                                </div>
                                <div class="box-footer-and-more">
                                    <p class="project-folders">Project Folders:</p>
                                    <div class="footer-add-new" id="scrollbars-dw">
                                        <?php if(isset($value["folder"]) && $value["folder"] != null):?>
                                            <?php foreach($value["folder"] AS $key_1 => $value_1 ) :?>
                                                <div class="row item-footer">
                                                    <div class="col-xs-2 text-center">
                                                        <?php $img = (isset($value_1["path_file"]) &&  $value_1["path_file"] != "" && file_exists(FCPATH.$value_1["path_file"])) ? $value_1["path_file"] : "skins/images/default-product.jpg" ?>
                                                        <img src="<?php echo base_url($img) ;?>" >
                                                    </div>
                                                    <div class="col-xs-10">
                                                        <a href="<?php echo base_url("designwalls/photos/".$value['project_id']."/".$value_1["category_id"]."/");?>"><p><strong><?php echo $value_1["title"];?></strong></p></a>
                                                        <p><?php echo $value_1["specs"];?></p>
                                                    </div>
                                                </div>
                                            <?php endforeach?>
                                        <?php endif;?>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 text-right"><a href="<?php echo base_url("designwalls/view/".$value["project_id"])?>">MORE</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;?>
                <?php endif;?>
                
            </div>
        </div>
        <?php $this->load->view("include/delete_walls");?>
     </div>
<style type="text/css">
    .pgwSlideshow .ps-current li{
        text-align: center;
        max-height: 258px;
    }
    .pgwSlideshow .ps-current li img{
        max-height: 258px;
    }
</style>
<link href="<?php echo skin_url(); ?>/css/designwalls.css" rel="stylesheet">
<link href="<?php echo skin_url(); ?>/jquery.datepick/jquery.datepick.css" rel="stylesheet">
<script src="<?php echo skin_url(); ?>/jquery.datepick/jquery.plugin.js"></script>
<script src="<?php echo skin_url(); ?>/jquery.datepick/jquery.datepick.js"></script>
<script type="text/javascript">
var max_item_thumb_show = 3;
$(function() {
    $(".paging-gallery .next").click(function() {
        var ci = $(this).parent().parent().find(".current-index-gallery").val();
        var ct = $(this).parent().parent().find(".current-total-gallery").val();
        if (ct <= max_item_thumb_show) {
            return false;
        }
        if (ci < (ct - max_item_thumb_show)) {
            ci++;
        } else {
            ci = 0;
        }

        // Bind gallery
        $(this).parent().parent().find(".thumb-item-photo").each(function(index) {
            if (index < (ci + max_item_thumb_show) && index >= ci) {
                $(this).parent().show();
            } else {
                $(this).parent().hide();
            }
        });
        $(this).parent().parent().find(".current-index-gallery").val(ci);
    });

    $(".paging-gallery .previous").click(function() {
        var ci = $(this).parent().parent().find(".current-index-gallery").val();
        var ct = $(this).parent().parent().find(".current-total-gallery").val();
        if (ct <= max_item_thumb_show) {
            return false;
        }
        if (ci > 0) {
            ci--;
        } else {
            ci = ct - max_item_thumb_show;
        }

        // Bind gallery
        $(this).parent().parent().find(".thumb-item-photo").each(function(index) {
            if (index < (ci + max_item_thumb_show) && index >= ci) {
                $(this).parent().show();
            } else {
                $(this).parent().hide();
            }
        });
        $(this).parent().parent().find(".current-index-gallery").val(ci);
    });

    $(document).on("click", ".paging-gallery .thumb-item-photo", function() {
        $(this).closest(".gallery").find("li.photo-item").hide();
        $(this).closest(".gallery").find("li#photo-item-" + $(this).attr("thumb-item-id")).show();
    });

    $(".delete-category a").click(function() {
        if(confirm('Are you sure you want to delete this folder?')){
            window.location.href=$(this).attr('href');
        }
        //delete_category_warning('Are you sure you want to delete this folder?', $(this).attr('href'););
        return false;
    });

    $(".copy-category a").click(function() {
        if(confirm('Are you sure you want to clone this folder?')){
            window.location.href=$(this).attr('href');
        }
        //delete_category_warning('Are you sure you want to delete this folder?', $(this).attr('href'););
        return false;
    });

    // Project info
    $("#allprojects").val($('#project_id').val());
    $("#start_date").datepick({
        dateFormat: 'yyyy-mm-dd',
        onSelect: function(selected) {
            if (from_bigger_to(selected, $("#due_date").val())) {
                $("#due_date").val($("#start_date").val());
            }
        }
    });
    $("#due_date").datepick({
        dateFormat: 'yyyy-mm-dd',
        onSelect: function(selected) {
            if (from_bigger_to($("#start_date").val(), selected)) {
                $("#start_date").val($("#due_date").val());
            }
        }
    });
});

function from_bigger_to(from_date, to_date) {
    if (to_date == '' || from_date == '')
        return false;
    return new Date(from_date).getTime() >= new Date(to_date).getTime();
}

$("#addnewcategory").click(function() {
    var title_c = $(this).attr('data-id-category');
    if (title_c != $('#myModal #category_name').val()) {
        update_category($('#myModal #category_id').val(), $('#myModal #category_name').val(), $('#project_id').val());
    } else {
        $(this).parents('#myModal').find('.close-reveal-modal').trigger('click');
    }
});

$("#allprojects").change(function() {
    document.location.href = "<?php echo base_url(); ?>/designwalls/index/" + $(this).val() + "/";
});

$(".action-delete").click(function() {
    var category_id = $(this).attr("data-category-id");
    var project_id = $('#project_id').val();
    // Call ajax at here
    if (confirm('Are you sure to delete this category?')) {
        $.ajax({
            url: "<?php echo base_url(); ?>/designwalls/delete_category",
            type: "post",
            data: {
                'category_id': category_id,
                'project_id': project_id
            },
            success: function(response) {
                if (response.trim() == 'ok') {
                    document.location.href = '<?php echo base_url(); ?>/designwalls/index/' + project_id;
                }
            }
        });
    }
});

function update_category(category_id, category_name, project_id) {
    // Call ajax at here
    $.ajax({
        url: "<?php echo base_url(); ?>/designwalls/categoryform",
        type: "post",
        data: {
            'category_id': category_id,
            'category_name': category_name,
            'project_id': project_id
        },
        success: function(response) {
            if (response.trim() == 'ok') {
                document.location.href = '<?php echo base_url(); ?>/designwalls/designform/' + project_id;
            } else {
                if (response.trim() == 'same')
                messenger_box("Error message", "The category already exist.");
                else
                messenger_box("Error message", "Error message.");
            }
        }
    });
}

$(document).ready(function() {
    $(document).on("click", ".poup_sent_mail", function() {
        $(".done").html(" ");
        $(".load-login").hide();
    });
    $("#poup-delete-project").click(function() {
        //$('#poup-select').foundation('reveal','open');
    });

    $(document).on('click', '.photo-item', function() {
        $(this).find('.poup_photo').trigger('click');
    });
});
 
/*
    ==========================================================
    BEGIN: FOLDER
*/
var project_id = '<?php echo @$project_id; ?>';
var title_category = '';
var description_category = '';
$(document).on('click', '.add-category', function() {
    $("#category_dialog .modal-header h4.modal-title").html("Create NEW Folder");
    $("#category_dialog #category_id").val("0");
    $("#category_dialog #category_name").val("");
    $("#category_dialog #category_description").val("");
});

$(document).on('click', '.rename-category', function() {
    $("#category_dialog #category_id").val($(this).attr("data-id"));
    $("#category_dialog #category_name").val($(this).attr('data-title'));
    $("#category_dialog .modal-header h4.modal-title").html("Rename Folder");
    $("#category_dialog #category_description").val($(this).attr('data-description'));
});

$("#addnewcategory").click(function() {
    var category_id = $("#category_dialog #category_id").val();
    var category_name = $("#category_dialog #category_name").val();
    var category_description = $("#category_dialog #category_description").val();
    if ($.trim(category_name) != '') {
        $.ajax({
            url: "<?php echo base_url(); ?>/designwalls/update_category",
            type: "post",
            data: {
                'category_id': category_id,
                'category_name': category_name,
                'category_description': category_description,
                'project_id': project_id
            },
            success: function(response) {
                if (response.trim() == 'ok') {
                    // document.location.href = '<?php echo base_url(); ?>/designwalls/index/' + project_id;
                    window.location.reload();
                } else {
                   messenger_box("Error message",response);
                }
            }
        });
    }
});
/*
    ==========================================================
    END: FOLDER
*/

/*
    ==========================================================
    BEGIN: INVITE MEMBER
*/
$(document).ready(function() {
    function validate_inver(obj){
        var parents=$(obj).parents('#send_invite_dialog');
        var email=parents.find('.format-email-inver').val();
        var first_name=parents.find('.format-first-name-inver').val();
        var last_name=parents.find('.format-last-name-inver').val();
        
        if(email=='' || !check_mail(email)){
            parents.find('.format-email-inver').addClass('border-error').focus();
        }
        else{
            parents.find('.format-email-inver').removeClass('border-error');
        }

        if(first_name=='' || $.trim(first_name) ==''){
            parents.find('.format-first-name-inver').addClass('border-error').focus();
        }
        else{
            parents.find('.format-first-name-inver').removeClass('border-error');
        }

        if(last_name=='' || $.trim(last_name) ==''){
            parents.find('.format-last-name-inver').addClass('border-error').focus();
        }
        else{
            parents.find('.format-last-name-inver').removeClass('border-error');
        }
    }   
    function check_mail(string) {
        var filter = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
        if (!filter.test(string)) {
            return false;
        } else {
            return true;
        }
    }
    var collection_member = "";
    var project_id = "<?php echo @$project_id;?>";
    var title = "<?php echo @$title_project;?>";
    var add_tems = new Array();
    var select_option_name_project = "";
    var get_data;
    $.ajax({
        url: "<?php echo base_url();?>/home/get_project",
        type: "post",
        data: {
            'project_id': project_id,
        },
        success: function(data) {
            get_data = $.parseJSON(data);
            if (get_data.length == 0) {
                select_option_name_project = "<option value='0'>--DEZIGNWALL--</option>";
            }
            $.each(get_data, function(index, value) {
                select_option_name_project += "<option value='" + value['project_id'] + "' data-text='" + value['project_name'] + "'>" + value['project_name'] + "</option>";
            });
            $("#design_wall").html(select_option_name_project);
        },
        error: function() {}
    });
    
    $(document).on("click", "#add_tems", function(e) {
        var attr_photo_id = $(this).attr('photo-id');
        var attr_category_id = $(this).attr('category-id');
        if (typeof attr_photo_id !== typeof undefined && attr_photo_id !== false && typeof attr_category_id !== typeof undefined && attr_category_id !== false) {
            $("#photo_id_invite").val(attr_photo_id);
            $("#category_id_invite").val(attr_category_id);
        }
        $(".message-invitation-member").html("");
        return false;
    });
    
    $(document).on('closed.fndtn.reveal', '#send-invite', function() {
        var photo_id_invite = $("#photo_id_invite").val();
        var category_id_invite = $("#category_id_invite").val();
        if (photo_id_invite != 0 && category_id_invite != 0) {
            $("html, body").scrollTop(0);
            if ($('.project[category-id="' + category_id_invite + '"] .poup_photo[photo-id="' + photo_id_invite + '"]').length > 0) {
                $('.project[category-id="' + category_id_invite + '"] .poup_photo[photo-id="' + photo_id_invite + '"]').trigger('click');
            } else if ($('.photo-item .poup_photo[photo-id="' + photo_id_invite + '"]').length > 0) {
                $('.photo-item .poup_photo[photo-id="' + photo_id_invite + '"]').trigger('click');
            }
            $("#photo_id_invite").val('0');
            $("#category_id_invite").val('0');
        }
        return false;
    });
    
    $(document).on("click", "#send_invite_dialog #add_invite", function() {
        var email = $("#send_invite_dialog #email").val();
        var first_name = $("#send_invite_dialog #first_name").val();
        var last_name = $("#send_invite_dialog #last_name").val();
        var designwall = $("#send_invite_dialog #design_wall").val();
        var project_name = $("#send_invite_dialog #design_wall option:selected").text();
        var category = $("#send_invite_dialog #category").val();
        var messenger_inver = $("#send_invite_dialog #personal_note").val();
        if (check_mail(email) && designwall != 0 && $.trim(first_name) != '' && $.trim(last_name) != '') {
            var new_tem = {
                'email': email,
                'first_name': first_name,
                'last_name': last_name,
                'designwall': designwall,
                'category_id': category,
                'messenger_inver': messenger_inver
            };
            $.each(get_data, function(index, value) {
                if (value['project_id'] == designwall) {
                    new_tem['project_name'] = value['project_name'];
                    new_tem['project_no'] = value['project_no'];
                }
            });
            if (add_tems.length > 0) {
                var i = 0;
                $.each(add_tems, function(key, value) {
                    var index_value = value['email'];
                    var index_project = value['designwall'];
                    if (new_tem['email'] == index_value && index_project == new_tem['designwall']) {
                        i++;
                    }
                });
                if (i == 0) {
                    add_tems.push(new_tem);
                }
            } else {
                add_tems.push(new_tem);
            }
            collection_member = $('#team_member').val();
            if (collection_member == "") {
                collection_member = first_name + " " + last_name;
            } else {
                collection_member = first_name + " " + last_name + ", " + collection_member;
            }

            $('#team_member').val(collection_member);
            collection_member = "";
            var invar_tem = "";
            $.each(add_tems, function(key, value) {
                invar_tem += "#" + value['designwall'] + "-" + value['first_name'] + " " + value['last_name'] + ", ";
            })

            var all_inver = "<p>" + invar_tem.slice(0, (invar_tem.length - 2)) + "</p>";
            $(".list-member-invite").html(all_inver);
            $("#send_invite_dialog #email").val('');
            $("#send_invite_dialog #first_name").val('');
            $("#send_invite_dialog #last_name").val('');
            $("#send_invite_dialog #personal_note").val('');
            $("#send_invite_dialog #email").attr('placeholder', '');
            $("#send_invite_dialog #first_name").attr('placeholder', '');
            $("#send_invite_dialog #last_name").attr('placeholder', '');
            $("#send_invite_dialog #personal_note").attr('placeholder', '');
            $("#send-invite input").removeClass("warning");
        } else {
            validate_inver("#send_invite");
        }

    });

    $(document).on("click", "#send_invite_dialog #send_invite", function() {
        var email = $("#send_invite_dialog #email").val();
        var first_name = $("#send_invite_dialog #first_name").val();
        var last_name = $("#send_invite_dialog #last_name").val();
        var designwall = $("#send_invite_dialog #design_wall").val();
        var project_name = $("#send_invite_dialog #design_wall option:selected").text();
        var category = $("#send_invite_dialog #category").val();
        var messenger_inver = $("#send_invite_dialog #personal_note").val();
        if (check_mail(email) && designwall != 0 && $.trim(first_name) != '' && $.trim(last_name) != '') {
            var new_tem = {
                'email': email,
                'first_name': first_name,
                'last_name': last_name,
                'designwall': designwall,
                'category_id': category,
                'messenger_inver': messenger_inver
            };
            $.each(get_data, function(index, value) {
                if (value['project_id'] == designwall) {
                    new_tem['project_name'] = value['project_name'];
                    new_tem['project_no'] = value['project_no'];
                }
            });
            if (add_tems.length > 0) {
                var i = 0;
                $.each(add_tems, function(key, value) {
                    var index_value = value['email'];
                    var index_project = value['designwall'];
                    if (new_tem['email'] == index_value && index_project == new_tem['designwall']) {
                        i++;
                    }
                });
                if (i == 0) {
                    add_tems.push(new_tem);
                }
            } else {
                add_tems.push(new_tem);
            }
            collection_member = $('#team_member').val();
            if (collection_member == "") {
                collection_member = first_name + " " + last_name;
            } else {
                collection_member = first_name + " " + last_name + ", " + collection_member;
            }

            $('#team_member').val(collection_member);
            collection_member = "";
            $("#send_invite_dialog #email").val('');
            $("#send_invite_dialog #first_name").val('');
            $("#send_invite_dialog #last_name").val('');
            $("#send_invite_dialog #personal_note").val('');
            $("#send_invite_dialog #email").attr('placeholder', '');
            $("#send_invite_dialog #first_name").attr('placeholder', '');
            $("#send_invite_dialog #last_name").attr('placeholder', '');
            $("#send_invite_dialog #personal_note").attr('placeholder', '');
        }
        if (add_tems.length > 0 || (check_mail(email) && designwall != 0 && $.trim(first_name) != '' && $.trim(last_name) != '')) {
            $(".load .load-send_invite").show();
            $.ajax({
                url: "<?php echo base_url();?>designwalls/invite_member",
                type: "post",
                data: {
                    'add_tems': add_tems
                },
                success: function(data) {
                    $(".load .load-send_invite").hide();
                    add_tems = new Array();
                    if (data.trim() == 'done') {
                        $(".list-member-invite").html('');
                        $("#send-invite").removeClass("warning")
                        messenger_box("Message", "Invitation sent successfully.");
                        window.reload();
                    }else{

                    }
                },
                error: function() {
                    $(".load .load-send_invite").hide();
                     messenger_box("Error message", "Error message.");
                }
            });
        } else {
            validate_inver("#send_invite");
        }
    });
});
/*
    ==========================================================
    END: INVITE MEMBER
*/

/*
    ==========================================================
    BEGIN: COMMENT
*/
function clean_comment(obj) {
    $(obj).parents('.form-comment').find('textarea').val('');
}

function add_comment(obj) {
    var object_id = $(obj).attr('data-id');
    var text = $(obj).parents('.form-comment').find('textarea').val();
    if (text.trim() != '' && text.trim() != null) {
        $(obj).attr('disabled', 'disabled');
        $(obj).parents('.form-comment').find('.load-comment').css('display', 'initial');
        $.ajax({
            url: "<?php echo base_url("/comments/add"); ?>/" + object_id + "/category",
            type: 'POST',
            dataType: "json",
            data: {
                "text": text
            },
            success: function(data) {
                if (data['status'].trim() == "true") {
                    var qty = data['num_comment'];
                    var strqty = (qty < 2) ? 'comment' : 'comments';
                    $(obj).parents('.form-comment').find('.photo-action-all-comment').append('<p style="margin-bottom:0;"><b>' + data['full_name'] + ':</b> <span class="text-comment">' + text + '</span></p>');
                    $(obj).parents('.form-comment').find('.text-tiny').html(qty + ' ' + strqty);
                    $(obj).parents('.form-comment').find('.photo-action-all-comment').animate({ scrollTop: $(obj).parents('.form-comment').find('.photo-action-all-comment').prop("scrollHeight")}, 1000);
                }
            },
            complete: function() {
                $(obj).removeAttr('disabled');
                $(obj).parents('.form-comment').find('.load-comment').css('display', 'none');

            }
        });
        $(obj).parents('.form-comment').find('textarea').val('');
    }
}
/*
    ==========================================================
    END: COMMENT
*/
$(document).on("click","#upgrade-show",function(){
    $("#add_upgrade").show();
    return false;
});
</script>
<style>
.ui-state-highlight {
    border: 1px solid #fcefa1!important;
    background: #fbf9ee!important;
    color: #363636;
}
.you-wall .pgwSlideshow .ps-current ul li{
    text-align: center;
}

.border-error{
    border: 1px solid red !important;
}
p#add_upgrade a {color: #fff;}
p#add_upgrade{
    background: #37a7a7;
    border-radius: 5px;
    padding: 5px 10px;
    width: 80%;
    margin: 0 auto;
    display: none;
}
#modal_delete_walll .logo{
    font-size: 20px;
    color: #37a7a7;
}
#modal_delete_walll .logo img{margin-right: 15px;}
#modal_delete_walll .modal-header .close {
    z-index: 999;
    position: relative;
}
</style>