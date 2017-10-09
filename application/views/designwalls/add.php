<link rel="stylesheet" type="text/css" href="<?php echo skin_url("css/page/profile.css");?>">
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
	    $this->load->view("include/banner-wall", $data);
	?>
    
    <section class="section box-wapper-show-image you-wall">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-header">
                            <h2 class="panel-title">Add new your Wall</h2>
                        </div>
                        <div class="collapse in" id="project-info-content">
                            <form class="project-form" method="post" enctype="multipart/form-data">
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
                                <div class="wrap-cropper relative">
                                    <div class="upload-img-designwalls">
                                        <div class="relative">
                                            <div class="custom-loading"><img width="64" src="http://betadev.dezignwalldev.com/skins/images/loading.gif"></div>
                                            <div class="wrap-cropper relative">
                                                <img class="image-cropper" src="<?php echo base_url('skins/images/image-upload1.png');?>">
                                                <input type="file" value="" class="none" id="ImageUploader" name="image" accept="image/*">
                                                <input type="hidden" id="x" name="x" />
                                                <input type="hidden" id="y" name="y" />
                                                <input type="hidden" id="w" name="w" />
                                                <input type="hidden" id="h" name="h" />
                                                <div class="profile-edit-photo banner-custom">
                                                    <div class="profile-action-edit">
                                                        <a class="text-white" href="#" onclick="$('#ImageUploader').click();return false;"><i class="fa fa-3 fa-pencil"></i> <small>  Edit Background</small></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="action-image">
                                                <ul class="list-inline">
                                                    <li><button type="button" id="crop-bnt" class="btn btn-custom btn-white" data-method="crop" disabled >Crop</button></li>
                                                    <li><button type="button" id="delete-crop-bnt" class="btn btn-custom btn-white" data-method="clear" disabled >Delete</button></li>
                                                </ul>
                                            </div>
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
                                            <label>Project Name:</label></div>
                                        <div class="col-sm-9 ">
                                            <input type="text" class="form-control" name="project_name" required value="<?php echo @$result["project_name"]; ?>" maxlength="255" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Project Notes:</label>
                                    <textarea class="form-control" name="project_specs" rows="5"><?php echo @$result["project_specs"]; ?></textarea>
                                </div>
                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-primary btn-custom">Update/Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div><!--end row-->
        </div>
    </section>
<style type="text/css">
    .pgwSlideshow .ps-current li{
        text-align: center;
        max-height: 258px;
    }
    .pgwSlideshow .ps-current li img{
        max-height: 258px;
    }
</style>
<script src="<?php echo skin_url() ?>/js/jquery.Jcrop.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo skin_url(); ?>/css/jquery.Jcrop.css">
<link href="<?php echo skin_url(); ?>/css/designwalls.css" rel="stylesheet">
<link href="<?php echo skin_url(); ?>/jquery.datepick/jquery.datepick.css" rel="stylesheet">
<script src="<?php echo skin_url(); ?>/jquery.datepick/jquery.plugin.js"></script>
<script src="<?php echo skin_url(); ?>/jquery.datepick/jquery.datepick.js"></script>
<script type="text/javascript">
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
    $(".upload-img-designwalls #ImageUploader").change(function(){
        $(".upload-img-designwalls .custom-loading").show();
        var file    = document.querySelector('#ImageUploader').files[0];
        var reader  = new FileReader();
        var p = $(".upload-img-designwalls .image-cropper");
        reader.addEventListener("load", function () {
            var img = new Image();
            img.onload = function () {
                p.attr("src", reader.result);
                p.addClass("done-chose");
                $(".upload-img-designwalls #crop-bnt").removeAttr("disabled");
                $(".upload-img-designwalls .custom-loading").hide();
            };
            img.src = reader.result;
        }, false);
        if (file) {
            reader.readAsDataURL(file);
        }else{
            $(".upload-img-designwalls .custom-loading").hide();
        }
    });
    var jcrop_api;
    $(".upload-img-designwalls #crop-bnt").click(function(){
        if($(".upload-img-designwalls .image-cropper").hasClass("done-chose") == true){
            $(".upload-img-designwalls .profile-edit-photo").css({"opacity":"0"});
            if (jcrop_api != null && typeof jcrop_api != 'undefined') {
                jcrop_api.destroy();
                jcrop_api = null;
            }
            $(".upload-img-designwalls .image-cropper").Jcrop({
                setSelect: [0, 0, 200, 200],
                onSelect: updateCoords
            }, function () {
                jcrop_api = this;
                $(".upload-img-designwalls #delete-crop-bnt").removeAttr("disabled");
            });
        }
        
    });
    $(".upload-img-designwalls #delete-crop-bnt").click(function(){
        //$(".upload-img-designwalls .done-chose").removeClass("done-chose")
        $(".upload-img-designwalls .profile-edit-photo").css("opacity","1");
        if (jcrop_api != null && typeof jcrop_api != 'undefined') {
            jcrop_api.destroy();
            jcrop_api = null;
            $(".upload-img-designwalls #crop-bnt").attr("disabled");
            $(".upload-img-designwalls #delete-crop-bnt").attr("disabled");
        }
    });
    function updateCoords(c){
        $('.upload-img-designwalls #x').val(c.x);
        $('.upload-img-designwalls #y').val(c.y);
        $('.upload-img-designwalls #w').val(c.w);
        $('.upload-img-designwalls #h').val(c.h);
    };
    function from_bigger_to(from_date, to_date) {
        if (to_date == '' || from_date == '')
            return false;
        return new Date(from_date).getTime() >= new Date(to_date).getTime();
    }
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