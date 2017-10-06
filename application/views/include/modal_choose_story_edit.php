
<link rel="stylesheet" type="text/css" href="<?php echo skin_url("/wysihtml5/css/prettify.css")?>"></link>
<link rel="stylesheet" type="text/css" href="<?php echo skin_url("/wysihtml5/css/bootstrap-wysihtml5.css")?>"></link>
<style type="text/css">
    #modal_choose_story .close {
        float: right;
        font-size: 39.5px;
        font-weight: bold;
        line-height: 1;
        position: relative;
        color: #000;
        text-shadow: 0 1px 0 #fff;
        z-index: 99999;
        opacity: .2;
    }
    .box-img-select img {max-height:  100%;}
    .loadding-upload-content img {
        width: 30px;
        height: 30px;
        vertical-align: middle;
        color: #fff;
        font-size: 20px;
    }
    .top-story #add-story-now{
    	position: relative;
    	z-index: 7777;
    	color: #ff9900; 
    	cursor: pointer;
    }
    .top-story {position: absolute; top: 10px ;left: 0;right: 0;}
    .action-choose {
        display: table-cell;
        width: 100%;
        vertical-align: middle;
        text-align: center;
        position:  relative;
        z-index: 999;
    }
    .action-choose a{
        position:  relative;
        z-index: 999;
    }
    .box-img-select{
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
    }
    .wysihtml5-toolbar a{margin: 5px 10px;}
    .wysihtml5-toolbar a i{font-size: 32px; color: #a3a3a3; }
    .wysihtml5-toolbar a img{
        width: 44px;
        margin-top: -7px;
    }
    .link-box{
        padding: 5px 10px;
        width: 100%;
    }
    .add-item-story a#add-story-now{
        color: #ff9900; cursor: pointer;
    }
    #modal_choose_story p.title-story{font-size: 16px;}
    .list-action i{font-size: 35px !important; margin-left: 5px !important;}
    .add-item-story{ min-height: 35px;}
    .wysihtml5-toolbar .link-box a{margin: 0;}
    .item-story-box{margin-bottom: 20px;}
    .list-action{width: 100%; text-align: right; margin-top: 10px;}
    #remove-story-now,#add-story-now,#move-box-story{cursor: pointer;}
    .wysihtml5-sandbox{background-color:  transparent !important; border: none !important;}
    .box-caption-title{
        margin: 0 -10px -10px;
        padding: 10px;
        background-color: #5d5d5d;
    }
    .box-caption-title h3{color: #fff;}
    #modal_choose_story .box-caption-title .title-input{color: #fff;}
    .box-caption-title .title-input::-webkit-input-placeholder { /* WebKit, Blink, Edge */
        color:    #fff;
    }
    .box-caption-title .title-inpute:-moz-placeholder { /* Mozilla Firefox 4 to 18 */
       color:    #fff;
       opacity:  1;
    }
    .box-caption-title .title-inpute::-moz-placeholder { /* Mozilla Firefox 19+ */
       color:    #fff;
       opacity:  1;
    }
    .box-caption-title .title-inpute:-ms-input-placeholder { /* Internet Explorer 10-11 */
       color:    #fff;
    }
    .box-caption-title .title-inpute::-ms-input-placeholder { /* Microsoft Edge */
       color:    #fff;
    }
    .box-story .title-input{
        border: 0;
        background: transparent;
        width: 100%;
        padding: 10px 5px;
    }
    .box-story .video-slider-box .title-input{color: #fff;}
    .box-choose-file{
        background-color: #fff;
        border: 1px solid #000000;
        width: 100%;
        height: 360px;
        display: table;
        vertical-align: middle;
    }
    .type-story {margin-top: 50px;position: relative;}
    .list-month ul li {width: 49%;}
    .title-story{font-size: 16px; }
    .choose-month-hide,.choose-number-images{padding:  0 20px; margin-top: 10px;}
    .choose-month-hide .checkbox{padding-left:  0;}
    .action-choose a{
        color: #fff;
        background: rgba(0, 0, 0, 0.67);
        vertical-align: middle;
        height: 40px;
        width: 200px;
        padding: 10px 24px;
        text-align: center;
        margin: 0 auto;
    }
    .action-choose  {
        display: table-cell;
        width: 100%;
        vertical-align: middle;
        text-align: center;
    }
    #modal_choose_story .modal-header{
        float: left;
        width: 100%;
        margin-bottom: 70px;
    }
    #modal_choose_story .modal-header{
        float: left;
        width: 100%;
        margin-bottom: 30px;
    }
    .list-month ul.list-inline.custom {padding:  0 20px;}
    #modal_choose_story .choose-number-images .list-number a{
        width: 50px;
        height: 50px;
        background-color: #f1f1f1;
        color: #000;
        border: 1px solid #000;
        border-radius: 5px;
        float: left;
        font-size: 30px;
        line-height: 1.5;
        text-align: center;
        font-weight: bold;
    }
    #modal_choose_story .choose-number-images .list-number a.activer{
        background-color: #37a7a7;
    }
    #modal_choose_story .choose-number-images li{
        width:16%;
    }
    @media screen and ( max-width: 768px ){
        .list-month ul li {width: 100%;}
    }
    .modal-header .close{
        z-index: 99999;
        position: relative;
    }
    .list_data_photo_same_catalog{margin-top: 20px;padding-left: 20px;max-height: 400px;overflow-y: auto; overflow-x: hidden;}
    .list_data_photo_same_catalog .checkbox img{max-height: 120px;}
    .box-imfor-data{margin-top: 30px;}
    .box-imfor-data .number-choosed-data{color: #37a7a7;}
    .box-imfor-data .load-more-image{color: #37a7a7;}
    #modal_choose_story .modal-content{
        border-radius:  0;
    }
    .modal-body{position: relative;}
    #modal_choose_story .custom-head{
        background-color: rgba(0, 0, 0, 0.6);
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        z-index: 99;
        padding: 14px 10px;
    }
    #modal_choose_story .custom-head .title-image{
        color: #fff;
        font-size:  24px;
    }
    #modal_choose_story .card{
        position: relative;
    }
    #modal_choose_story .custom-head .close{position: absolute; top:10px; right: 10px; color: #fff; opacity: 1;padding: 5px 10px;}
    #modal_choose_story .card #pins-to{
        position: absolute;
        right: 10px;
        z-index: 99999;
        top: 67px;
    }
    #modal_choose_story .button-close-view{
        position:  absolute; 
        bottom: 30px;
        right: 0px;
    }
    #modal_choose_story #pins-to img{
        max-height: 45px;
    }
    #single-img-view{width: auto !important;}
     #modal_choose_story .card-image{float: inherit;}
    .btn-black{background-color: rgba(0, 0, 0, 0.6); border: 1px solid #fff; color: #fff; font-size: 24px; border-radius:  0;}
    #modal_choose_story .modal-full{width: 95%;}
    #modal_choose_story{padding-right: 0 !important;}
    #modal_choose_story .box-story{
        background-color:  #f7f7f7;
        border-radius: 2px;
        border: 1px solid #000000;
        min-height: 600px;
        width: 100%;
        padding: 10px;
    }
    .video-slider-box .box-choose-file{height: 476px; background-color: transparent; border: none;}
    iframe{max-width: 100% !important;}
    .loadding-upload-content {
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.15);
        position: absolute;
        right: 0;
        top: 0;
        left: 0;
        bottom: 0;
        display: none;
        cursor: wait;
    }
</style>
<div id="modal_choose_story" class="modal fade" role="dialog">
    <div class="modal-dialog modal-full">
        <form method="post" action="<?php echo base_url("profile/add_story");?>" id="add-story-from">
            <input type="hidden" name="photo_id" value="<?php echo @$photo_id ;?>">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class ="modal-body">              
                   <div class="row">
                        <div class="col-md-1">
                            <img src="<?php echo skin_url("/images/story-icon.png");?>">
                        </div>
                        <div class="col-md-10">    
                            <p class="title-story">Telling your Story is important on so many levels. This is an opportunity to share, educate, and relate to your audience. 
                                Create your story with up to 6-Slides, using any combination of the following 3 templates. Move the order using the
                                arrow icon  <i class="fa fa-play-circle" aria-hidden="true" style="color: #7f7f7f; transform: rotate(29deg); -webkit-transform: rotate(29deg); -ms-transform: rotate(29deg); -moz-transform: rotate(29deg); font-size: 25px;"></i>, to customize your Story. Add or remove slide styles by selecting <i class="fa fa-times-circle" aria-hidden="true" style=" color: #af1219; font-size: 25px; "></i> (delete) or <i class="fa fa-plus-circle" aria-hidden="true" style=" color: #ff9900; font-size: 25px; "></i> (add).
                            </p>
                        </div>
                    </div>
                    <div class="row type-story">
                        <?php 
                            $data["liststory"] = $liststory;
                            $this->load->view("include/list_story",$data["liststory"]);
                        ?>
                    </div>
                         
                </div>
                 <div class="modal-footer text-right">
                    <button type="button" class="btn btn-default">Clear</button>
                    <button type="submit" class="btn action-bnt btn-primary relative">Post Your Story<div class="loadding-upload-content"><img src="<?php echo base_url("skins/images/loadding.GIF");?>"></div></button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="mymodal_upload" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Upload image</h4>
        </div>
        <div class="modal-body">
            <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#upload-image">Upload Image</a></li>
              <li><a data-toggle="tab" href="#insert-image">Insert Image</a></li>
            </ul>
            <div class="tab-content">
              <div id="upload-image" class="tab-pane fade in active"> 
                <form method="post" action="<?php echo base_url("profile/upload_file_content")?>" id ="upload-file-in-content" enctype="multipart/form-data">
                    <div id="wrapp-box"> 
                        <div class="list-photos" id="box-photos">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="not-image">
                                        <h2 class="text-center">Selected Photos</h2>
                                        <h2 class="text-center"><a href="#" class="btn btn-default set-image" onclick="chose_image(); return false;">Select Image</a></h2>
                                    </div>
                                    <div id="box" class="text-center"></div>
                                </div> 
                            </div>                                                
                        </div>
                    </div>
                    <input type="file" name="file" id="upload-file-content"  class="none" accept="image/*" />
                </form>
              </div>
              <div id="insert-image" class="tab-pane fade">
                <div class="list-photos" id="box-photos">
                    <div class="box-src" id="box-src-set">
                      <div class="form-group">
                        <label for="pwd">Image:</label>
                        <input id="src-image-set" class="form-control" value="" placeholder="http://">
                      </div>
                    </div>
                </div>
              </div>  
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="text-center btn btn-secondary relative" id="add-new-image">Add <div class="loadding-upload-content"><img src="<?php echo base_url("skins/images/loadding.GIF");?>"></div></button>
        </div>
      </div>
    </div>
</div>
<script src="<?php echo skin_url(); ?>/js/parser_rules/advanced.js"></script>
<script src="<?php echo skin_url(); ?>/js/wysihtml5-0.4.0pre.js"></script>
<script type="text/javascript">
    var editcurrent ;
    var editor = null
    var editor1 = null;
    function upload_editer(element){
        editcurrent = $(element).attr("data-edit");
        $("#mymodal_upload").modal();
        return false;
    }
    $("#mymodal_upload .close-model").click(function(){
        $("#mymodal_upload").modal("hide");
        return false;
    })
     function uploadstatus(responseText, statusText, xhr, $form)  {
       if(responseText["status"] == "success"){
            if(editcurrent == "1"){
                editor.composer.commands.exec("insertImage", { src:responseText["src"], alt: "This is an image" });
            }else{
                editor1.composer.commands.exec("insertImage", { src:responseText["src"], alt: "This is an image" });
            }
            var control = $("#upload-file-content");
            control.replaceWith( control.val('').clone( true ) );
            var image_holder = $("#mymodal_upload #box-photos #box");
            image_holder.empty();
            $(".loadding-upload-content").hide();
            $("#mymodal_upload").modal("hide");
       }else{
        alert("error");
       }
    }
    function ValidURL(str) {
        var regex = /(http|https):\/\/(\w+:{0,1}\w*)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%!\-\/]))?/;
        if(!regex .test(str)) {
            alert("Please enter valid URL.");
            return false;
        } else {
            return true;
        }
    }
    function readURLStory(input) {
        if (input.files && input.files[0]) {
            if (!checkUploadSize(input)) {
                return false;
            }
            // prepare HTML5 FileReader
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("ImageUploader_image2").files[0]);
            oFReader.onload = function (oFREvent) {
                var theImage = new Image();
                theImage.src = oFREvent.target.result;
                var imageWidth = theImage.width;
                var imageHeight = theImage.height;
                var width_bd = $("body").width();
                if(imageWidth > width_bd){
                    imageHeight = imageHeight * (width_bd/imageWidth);
                    imageWidth = width_bd;
                }
                $('.image-banner').css({"background-image":'url(' + oFREvent.target.result + ')',"width": imageWidth +"px","height": imageHeight+"px","margin":"0 auto"});
                $('.image-default').hide();
            };
        }// end if
    }
    var checkUploadSize = function (input) {
        if (input.files[0].size > 8400000) {
            alert("Image size exceeds limit.");
            return false;
        }
        var legal_types = Array("image/jpeg", "image/png", "image/jpg");
        if (!inArray(input.files[0].type, legal_types)) {
            alert("File format is invalid. Only upload jpeg or png");
            return false;
        }
        return true;
        }
        var inArray = function (needle, haystack) {
        var length = haystack.length;
        for (var i = 0; i < length; i++) {
            if (typeof haystack[i] == 'object') {
                if (arrayCompare(haystack[i], needle))
                    return true;
            } else {
                if (haystack[i] == needle)
                    return true;
            }
        }
        return false;
    }
    $('#mymodal_upload').on('hidden.bs.modal', function (e) {
        $("body").addClass("modal-open");
    })
    function chose_image(){
        $("#upload-file-content").trigger("click");
    }
    $(document).on("change","#upload-file-content",function(){
        reader_file_editter($(this));
    });

    $(document).on("click",".loadding-upload-content",function(){
        return false;
    });
    function reader_file_editter(element){
        var countFiles = element[0].files.length;
        var imgPath = element[0].value;
        var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
        var image_holder = $("#mymodal_upload #box-photos #box");
        image_holder.empty();
        if (typeof(FileReader) != "undefined") {
            for (var i = 0; i < countFiles; i++) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var img = new Image;
                    img.onload = function() {          
                        $("<img src = '" + e.target.result + "'>").appendTo(image_holder);
                    };
                    img.src = e.target.result;
                }
                image_holder.show();
                reader.readAsDataURL(element[0].files[i]);
            }
        } else {
            alert("This browser does not support FileReader.");
        }
    }

    $(document).on("click","#mymodal_upload #add-new-image",function(){
        var file = $("#upload-file-content")[0].files.length;
        var src  = $("#mymodal_upload #src-image-set").val();
        if(file > 0){
            $(".loadding-upload-content").show();
            $('#upload-file-in-content').ajaxSubmit({
                dataType:"json",
                success:uploadstatus ,
                error:function(){
                	alert("Error");
                }
            }); 
        }else if(src.trim() != ""){
            if (!ValidURL(src)) {
                return false;
            }
            $(".loadding-upload-content").show();
            if(editcurrent == "1"){
                editor.composer.commands.exec("insertImage", { src:src, alt: "This is an image" });
            }else{
                editor1.composer.commands.exec("insertImage", { src:src, alt: "This is an image" });
            }
            $("#mymodal_upload #src-image-set").val("");
            $(".loadding-upload-content").hide();
            $("#mymodal_upload").modal("hide");
        } else {
            alert("Please select an image or Image Url is invalid.");
        }
    });
    $(document).on("click","#modal_choose_story .item-story-box #remove-story-now",function(){
        $(this).parents("#wrapp-box-story").find(".title-input").val("");
        var id = $(this).parents(".item-story-box").attr("data-id");
        if(typeof id !== "undefined"){
            var input_story = $(".action-save #story-id").val();
            input_story = input_story.replace(","+id,"");
            input_story = input_story.replace(id+",","");
            $(".action-save #story-id").val(input_story);
        }
        $(this).parents(".item-story-box").addClass("none");
    });
    $(document).on("click","#modal_choose_story .item-story-box #add-story-now",function(){
        var type = $(this).parents(".item-story-box").attr("data-type");
        $("#modal_choose_story .content-story .item-story-box.none[data-type="+type+"]").first().removeClass("none");
        if(type == "editorial"){
            if(editor1 == null){
                editor1 = new wysihtml5.Editor("editorial-2", {
                    toolbar:        "toolbar-2",
                    stylesheets:    "<?php echo skin_url(); ?>/css/story-editor.css",
                    parserRules:    wysihtml5ParserRules
                });
            }
        }
    });
    $(document).on("click",".top-story #add-story-now",function(){
        var type = $(this).attr("data-type");
        $("#modal_choose_story .content-story .item-story-box.none[data-type="+type+"]").first().removeClass("none");
        if(type == "editorial"){
            if(editor1 == null){
                editor1 = new wysihtml5.Editor("editorial-2", {
                    toolbar:        "toolbar-2",
                    stylesheets:    "<?php echo skin_url(); ?>/css/story-editor.css",
                    parserRules:    wysihtml5ParserRules
                });
            }
        }
    });
    $(document).on("click","#modal_choose_story #move-box-story",function(){
        var number_current = $(this).parents(".item-story-box").index();
        if(number_current != 0){
            $data = $(this).parents(".item-story-box");
            $data.insertBefore($(this).parents("#modal_choose_story").find(".item-story-box").eq(number_current-1));
        } 
    });
    $(document).on("click","#modal_choose_story #upload-media",function(){
        $(this).parent().find("#media_url").trigger("click");
        return false;
    });
    $(document).on("change","#modal_choose_story #media_url",function(){
        var _this = $(this);
        if ($(this)[0].files && $(this)[0].files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                _this.parent().find(".box-img-select").html('<img src ="'+e.target.result+'">');
            }
            reader.readAsDataURL($(this)[0].files[0]);
        }else{
            $(this).parent().find(".box-img-select").html('');
        }
    })
    $("#add-story-from").submit(function(){
    	var i = 0;
        $.each($("#modal_choose_story .item-story-box"),function(key,val){
        	if($(this).find("#wrapp-box-story").hasClass("none") == false){
        		$(this).find("#sort").val(i);
        		i++;
        	}     
        });
        var _this = $(this);
        $(this).find(".loadding-upload-content").show();
        $(this).ajaxSubmit({
            dataType:"json",
            success:function(data){
            	console.log(data);
                if($.isArray(data["response"])){
                   	var argId = []; 
                    var current_box ;
                    $.each($("#modal_choose_story .item-story-box"),function(key,val){
			        	if($(this).find("#wrapp-box-story").hasClass("none") == false){
			        		current_box = $(this);
			        		$.each(data["response"],function(key,val){
			        			if(this.sort == current_box.find("#sort").val()){
			        				current_box.attr("data-id",this.id);
			                        current_box.find("input#story-id").val(this.id);
			                        current_box.find("#media_url").val('').clone(true);
			        				argId.push(this.id);
			        			}  
		                    });
			        	}
			        }); 
			        var story_id = argId.join();
                    $(".action-save #story-id").val(story_id);
                    $("#modal_choose_story").modal("hide");          
                }
                _this.find(".loadding-upload-content").hide();
            },error:function(){
                _this.find(".loadding-upload-content").hide();
            }
        });
        return false;
    })
    $(document).on("click",".add-a-story .add-story",function(){
        $("#modal_choose_story").modal();
        if(editor == null){
            editor = new wysihtml5.Editor("editorial-1", {
                toolbar:        "toolbar-1",
                stylesheets:    "<?php echo skin_url(); ?>/css/story-editor.css",
                parserRules:    wysihtml5ParserRules

            });
        }
        if(editor1 == null){
            editor1 = new wysihtml5.Editor("editorial-2", {
                toolbar:        "toolbar-2",
                stylesheets:    "<?php echo skin_url(); ?>/css/story-editor.css",
                parserRules:    wysihtml5ParserRules
            });
        }
        return false;
    });
</script>