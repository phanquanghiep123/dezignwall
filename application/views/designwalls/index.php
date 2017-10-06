    <?php
    	$user_info = $this->session->userdata('user_info');
		$allow_edit = (isset($member) && isset($user_info) && $user_info['id'] == $member['id'] && !$this->session->userdata('user_sr_info')) ? true : false;
		$data = null;
        $type_project_arg = array();
        if($type_project == "custom"){
            $type_project_arg = array('href' => '#','id' => 'delete_wall', 'title' => 'Delete your Wall..', 'class' => 'delete_wall_1','data-id'=> $project_id);
        }
		if ($allow_edit) {
    		$data['menu_banner'] = array(
				array('href' => '#', 'title' => 'Edit background...', 'class' => 'edit_background'),
				array('href' => '#', 'title' => 'Hide background...', 'class' => 'show_hide_background'),
		    	array('href' => '#', 'title' => 'Invite team members...', 'class' => 'invite_member'),
		    	$type_project_arg,
		    	array('href' => base_url('/profile/upgrade/'), 'title' => 'Upgrade Account...', 'class' => 'upgrade-account-link')
			);
    	} else {
    		$data['menu_banner'] = array(
				array('href' => '#', 'title' => 'Hide background', 'class' => 'show_hide_background'),
		    	array('href' => '#', 'title' => 'Invite team members', 'class' => 'invite_member')
			);
    	}
	    $this->load->view("include/banner.php", $data);
	?>
    
    <section class="section box-wapper-show-image you-wall">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-header">
                            <h2 class="panel-title">Project Info</h2>
                            <a class="panel-action-photo" data-toggle="collapse" href="#project-info-content" aria-expanded="true" aria-controls="project-info-content"><i class="fa fa-angle-down"></i></a>
                        </div>
                        <div class="collapse in" id="project-info-content">
                            <form class="project-form" action="/designwalls/view/<?php echo $project_id; ?>" method="POST">
                                <?php if (isset($message) && $message != null) : ?>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="alert alert-success">
                                                <?php echo $message; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label class="control-label">Project:</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <select value-index="<?php echo @$project_id; ?>" name="allprojects" id="allprojects" class="form-control">
                                                <?php if (isset($left_projects)) : ?>
                                                    <?php foreach ($left_projects as $item_project) : ?>
                                                        <?php
                                                            $prefix_project = " (created by " .  @$item_project["first_name"] . " " . @$item_project["last_name"] . ")";
                                                            if (@$view_member_id == $item_project["member_id"]) {
                                                                $prefix_project = "";
                                                            }
                                                            $start_date = "";
                                                            if (isset($item_project["start_date"]) && $item_project["start_date"] != "0000-00-00")
                                                            {
                                                                $start_date = " - " . date('m/d/Y', strtotime($item_project["start_date"]));
                                                            }
                                                        ?>
                                                        <option value="<?php echo $item_project["project_id"]; ?>"><?php echo $item_project["project_name"] . " - #" . $item_project["project_no"] .  $start_date . $prefix_project; ?></a></option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>   
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label class="control-label">Start Date:</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" name="start_date" id="start_date" value="<?php if (isset($result["start_date"]) && $result["start_date"] != "0000-00-00") echo $result["start_date"]; ?>" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label class="control-label">Due Date:</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" name="due_date" value="<?php if (isset($result["due_date"]) && $result["due_date"] != "0000-00-00") echo $result["due_date"]; ?>" id="due_date" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-3 ">
                                            <label class="control-label">Team Members:</label>
                                            <p><small>
                                                <a id="add_tems" data-toggle="modal" data-target="#send_invite_dialog" href="#">Add member</a>
                                            </small></p>
                                        </div>
                                        <div class="col-sm-9">
                                            <?php
                                                $team='';
                                                if(isset($team_member) && count($team_member) > 0 ){
                                                    foreach ($team_member as $key => $value) {
                                                       $team.=$value['first_name'].' '.$value['last_name'];
                                                       if($key < count($team_member)-1){
                                                        $team.=',';
                                                       }
                                                    }
                                                } 
                                            ?>
                                            <input type="text" class="form-control" onkeypress="return false;" name="team_member" id="team_member"  value="<?php echo $team; ?>" maxlength="1000" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-3 ">
                                            <label>Project Name:</label></div>
                                        <div class="col-sm-9 ">
                                            <input type="hidden" name="project_id" id="project_id" value="<?php echo @$project_id; ?>" />
                                            <input type="text" class="form-control" name="project_name" required value="<?php echo @$result["project_name"]; ?>" maxlength="255" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Project Notes:</label>
                                    <textarea class="form-control" name="project_specs" rows="5"><?php echo @$result["project_specs"]; ?></textarea>
                                </div>
                                <div class="form-group text-right">
                                    <?php if($user_info != null && !$this->session->userdata('user_sr_info')):?>
                                        <button type="submit" class="btn btn-primary btn-custom">Update/Save</button>
                                    <?php endif;?>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div><!--end row-->

            <?php /* Folder: Category */ ?>
            <div class="row box-folder" id="deziwall" data-equalizer="foo">
                <?php 
                    $html_cattegory = ""; 
                    $total_category = count($result_categories);
                    foreach ($result_categories as $key=>$category_item) : 
                        $html_cattegory .= "<option value='" . $category_item['category_id'] . "'>" . $category_item['title'] . "</option>";
                ?>
                        <div class="col-sm-6">
                            <div class="panel panel-default">
                                <div class="panel-header">
                                    <h2 class="panel-title remove-margin-bottom"><?php echo $category_item['title']; ?></h2>
                                    <p class="panel-des"><small><strong>Folder description:</strong></small><br><?php echo $category_item['specs']; ?></p>
                                    <span class="panel-action">
                                        <a id="folder-1" data-target="#" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bars"></i></a>
                                        <ul class="dropdown-menu dropdown-menu-right box-folder" aria-labelledby="folder-1">
                                            <li><a href="#" onclick="document.location.href='<?php echo base_url(); ?>designwalls/photos/<?php echo $project_id; ?>/<?php echo $category_item['category_id']; ?>/'">View all images...</a></li>
                                            <?php if($user_info != null && !$this->session->userdata('user_sr_info')):?>
                                                <li><a href="#" onclick="document.location.href='<?php echo base_url(); ?>profile/addphotos/<?php echo $project_id; ?>/<?php echo $category_item['category_id']; ?>/'">Upload image...</a></li>
                                                <li><a href="#" data-toggle="modal" data-target="#send_invite_dialog">Invite member...</a></li>
                                                <li><a href="#" data-toggle="modal" data-target="#category_dialog" class="rename-category" data-title="<?php echo $category_item['title']; ?>" data-description="<?php echo $category_item['specs']; ?>" data-id="<?php echo $category_item['category_id']; ?>" >Rename folder...</a></li>
                                                <li class="copy-category"><a href="<?php echo base_url(); ?>designwalls/copy_category/<?php echo $project_id; ?>/<?php echo $category_item['category_id']; ?>/">Copy folder...</a></li>
                                                <li><a href="#" data-toggle="modal" data-target="#category_dialog" class="add-category">Create NEW folder...</a></li>
                                                <li><a href="#" class="upgrade-account-link" onclick="document.location.href='<?php echo base_url();?>profile/upgrade/'">Upgrade Account..</a></li>
                                                <?php if ($allow_delete_category) : ?>
                                                    <li class="delete-category"><a href="<?php echo base_url(); ?>/designwalls/delete_category/<?php echo $project_id; ?>/<?php echo $category_item['category_id']; ?>/">Delete folder...</a></li>
                                                <?php endif; ?>
                                            <?php endif;?>
                                        </ul>
                                    </span>
                                </div>
                                <?php if (count($category_item['photos']) > 0) : ?>
                                <ul class="pgwSlideshow">
                                    <?php $index = 0;?>
                                    <?php $index_gallery = 0; foreach ($category_item['photos'] as $key => $value) : $index_gallery++; ?>
                                    <li class="photo-item" data-index-photo="<?php echo $index_gallery; ?>" id="photo-item-<?php echo $value["photo_id"]; ?>" data-thumb="<?php echo base_url($value['path_file']); ?>">
                                        <a id="view-list-slider" data-id = "<?php echo $category_item['category_id']; ?>" href="#"><img data-index="<?php echo $index;?>" class="draggable" category-id="<?php echo $category_item['category_id']; ?>" id="<?php echo $value["photo_id"]; ?>"  src="<?php echo base_url($value['path_file']); ?>"></a>
                                    </li>
                                    <?php $index++;?>
                                    <?php endforeach; ?>
                                </ul>
                                <?php endif; ?>
                                <form class="form-comment">
                                    <div class="form-group">
                                        <label style="width:100%;"><span class="text-tiny"><?php echo (null == $category_item['qty_comment']) ? '0' : $category_item['qty_comment'] ;?> Comments</span><br>
                                        <div class="photo-action-all-comment" style="height:100px;overflow:auto;width:100%;">
                                            <?php if (count($category_item['comments']) > 0) : ?>
                                                <?php foreach ($category_item['comments'] as $comment) : ?>
                                                    <p style="margin-bottom:0;"><b><?php echo $comment["first_name"] . ' ' . $comment["last_name"]; ?>:</b> <span class="text-comment"><?php echo $comment["comment"]; ?></span></p>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </div>
                                        <strong>Comments</strong></label>
                                        <textarea class="form-control" rows="5" placeholder="A space to place notes related to this project"></textarea>
                                    </div>
                                    <div class="form-group text-right">
                                        <button class="btn btn-gray btn-custom" onclick="clean_comment(this);return false;">Clear</button>
                                        <button class="btn btn-primary btn-custom" data-id="<?php echo $category_item['category_id']; ?>" onclick="add_comment(this);return false;">Comment</button>
                                        <span class="load-comment" style="display: none;"><img src="<?php echo skin_url() ?>/images/loading.gif" style="width:18px;"></span>
                                    </div>
                                </form>
                            </div>
                        </div>
                <?php endforeach; ?>
            </div>
            <?php if (isset($links) && $links != null) : ?>
            <div class="row">
                <div class="col-sm-12">
                    <?php echo $links; ?>
                </div>
            </div>
            <?php endif; ?>
            <?php /* */?>
        </div>
    </section>
    <div id="send_invite_dialog" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Invite team members into your DEZIGNWALL</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3 text-right"><label>Email:</label></div>
                            <div class="col-sm-9 "><input class="format-email-inver form-control" type="text" name="email"  id="email" required/></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3 text-right"><label>First Name:</label></div>
                            <div class="col-sm-9 "><input type="text" name="first_name" class="format-first-name-inver form-control" id="first_name"/></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3 text-right"><label>Last Name:</label></div>
                            <div class="col-sm-9 "><input type="text" name="last_name" class="format-last-name-inver form-control" id="last_name"/></div>
                        </div>
                    </div>
                    <div class="form-group">
                       <div class="row">
                            <div class="col-sm-3 text-right"><label>Design Wall:</label></div>
                            <div class="col-sm-9 ">
                                <select name="design_wall" id="design_wall" class="form-control">
                                  <option value="0">--Design Wall:--</option>
                                </select>
                                <input type="hidden" name="category"  id="category" value="0"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3 text-right"><label style="margin-bottom:0;">Include a personal note:</label></div>
                            <div class="col-sm-9">
                               <textarea id= "personal_note" class="form-control" name="personal_note"></textarea>
                            </div>
                        </div>
        				<div class="row">
                            <div class="col-sm-3 text-right"></div>
                            <div class="col-sm-9">
                               <div class="list-member-invite"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <span class="load" style="display:none;"><p class="load-send_invite"><img src="<?php echo skin_url(); ?>/images/loading.gif" ></p></span><button type="submit" class="btn btn-primary btn-custom" id="add_invite">Add more</button>
                    <button type="submit" class="btn btn-primary btn-custom" id="send_invite">Send invite</button><br clear="all" />
                    <p class="text-right">Need more room? <a href="<?php echo base_url();?>/page/dezignwall-price/">Upgrade</a></p>
                    <p class="message-invitation-member"></p>
                    <input type="hidden" value="0" id="photo_id_invite">
                    <input type="hidden" value="0" id="category_id_invite">
                </div>
            </div>
        </div>
    </div>  
    <div id="category_dialog" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Create NEW Folder</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3 text-right"><label>Folder Name:</label></div>
                            <div class="col-sm-9 "><input class="form-control" type="text" name="category_name"  id="category_name" required/></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3 text-right"><label style="margin-bottom:0;">Folder Description:</label></div>
                            <div class="col-sm-9">
                               <textarea id= "category_description" class="form-control" name="category_description"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <span class="load" style="display:none;"><p class="load-send_invite"><img src="<?php echo skin_url(); ?>/images/loading.gif" ></p></span> 
                    <button type="submit" class="btn btn-primary btn-custom" id="addnewcategory" value="Save">Save</button>
                    <input type="hidden" name="category_id" id="category_id" value="0" />
                </div>
            </div>
        </div>  
    </div>
    <?php $this->load->view("include/delete_walls");?>
<style type="text/css">
    .pgwSlideshow .ps-current li{
        text-align: center;
        max-height: 258px;
    }
    .pgwSlideshow .ps-current li img{
        max-height: 258px;
    }
</style>
<link href="<?php echo skin_url(); ?>/jquery.datepick/jquery.datepick.css" rel="stylesheet">
<script src="<?php echo skin_url(); ?>/jquery.datepick/jquery.plugin.js"></script>
<script src="<?php echo skin_url(); ?>/jquery.datepick/jquery.datepick.js"></script>
<script type="text/javascript">
var max_item_thumb_show = 3;
$(document).on("click","#view-list-slider img",function(){
    var _this = $(this);
    var hieght_document = $(window).height();
    var index_data = _this.attr("data-index");
    hieght_document = hieght_document - 100;
    var id = _this.parents("#view-list-slider").attr('data-id');
    if(typeof id !== 'undefined'){
        $.ajax({
            url : base_url + "designwalls/get_slider",
            type:"post",
            dataType:"json",
            data: {id : id},
            success : function(data){
                if(data["status"] == "success"){
                    var html = "";
                    $.each(data["response"],function(key,value){
                        html += '<div class="col-md-12 items-data" id="number-scroll-'+key+'"><div class="single-image"><a href="'+base_url +'"designwalls/view_photos/"'+value["product_id"]+'"><img src="'+base_url + value["path"] +'" title="'+value["title"]+'"></a>';
                        html += '<div><p class="text-comment">';
                        var text = value["name"];
                        if (text.length <= 100) {
                            html += '<span>' + text + '</span>';
                        } else {
                            html += '<span class="comment-item-text default-show block">' + text.slice(0, 100) + '<span class="more" id="more-comment"> MORE...</span></span>';
                            html += '<span class="comment-item-text default-hie">' + text + '<span class="more" id="more-comment"> LESS</span></span>';
                        }
                        html += "</p>";
                        html += '</div></div></div>';
                    });
                    $("#modal_view_album .content-album #scrollbars-dw").css("height",hieght_document+"px");
                    $("#modal_view_album .content-album #scrollbars-dw").html(html);
                    $("#modal_view_album").modal();
                    setTimeout(function(){
                        $("#modal_view_album #scrollbars-dw").scrollTo("#modal_view_album #scrollbars-dw #number-scroll-"+index_data+"");
                    },500);
                }
            },error:function(){

            }
        })
    }
});
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
    document.location.href = "<?php echo base_url(); ?>designwalls/view/" + $(this).val() + "/";
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
                    document.location.href = '<?php echo base_url(); ?>designwalls/view/' + project_id;
                }
            }
        });
    }
});

function update_category(category_id, category_name, project_id) {
    // Call ajax at here
    $.ajax({
        url: "<?php echo base_url(); ?>designwalls/categoryform",
        type: "post",
        data: {
            'category_id': category_id,
            'category_name': category_name,
            'project_id': project_id
        },
        success: function(response) {
            if (response.trim() == 'ok') {
                document.location.href = '<?php echo base_url(); ?>designwalls/designform/' + project_id;
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
var project_id = '<?php echo $project_id; ?>';
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
            url: "<?php echo base_url(); ?>designwalls/update_category",
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
    var project_id = "<?php echo $project_id;?>";
    var title = "<?php echo $title_project;?>";
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
</style>