<link rel="stylesheet" type="text/css" href="<?php echo skin_url("css/page/profile.css");?>">
<section class="section box-wapper-show-image box-wapper-brand" style="background:#ffde00;">

    <div class="container">

        <p class="h2 text-center">You are in Creat/Edit Blog Article mode...</p>

    </div>

</section>
<form method="post" class="form-article" action="<?php echo @$action; ?>" enctype="multipart/form-data">

	<section class="section banner-box">

	   <div class="relative">

	   	  <?php
	   	  	$src = '';
	   	  	if(isset($article['thumbnail']) && $article['thumbnail']!=null){
	   	  		$src = $article['thumbnail'];
	   	  	}
	   	  	if($src != ""){
	   	  		list($width, $height) = getimagesize(base_url($src));?>
	   	  		<div style="background-image:url('<?php echo $src; ?>'); width: <?php echo $width."px";?>;height: <?php echo $height."px";?>; margin: 0px auto;" class="banner image-banner text-center">
	   	  	<?php } else{ ?>
	   	  		<div style="background-image:url('<?php echo $src; ?>');" class="banner image-banner text-center">
	   	    <?php	
	   			}
	   	    ?>
           
	      
	         <?php if($src == ''): ?>
	         	<img class="image-default" style="height:200px;margin-top: 80px;" src="<?php echo skin_url(); ?>/images/image-upload1.png">
	      	 <?php endif; ?>
	      	 <input name="file" type="file" class="hidden <?php echo $current == 'add' ? 'required' : ''; ?>" onchange="readURL(this);" id="ImageUploader_image2">
	      </div>
	      <div class="profile-edit-photo banner-custom">
                <div class="profile-action-edit">
                    <a class="text-white" href="#" onclick="$('#ImageUploader_image2').click();return false;"><i class="fa fa-3 fa-pencil"></i> <small>  Edit Header Image</small></a>
                </div>
          </div>

	      <div class="impromation-project" style="display:block;">

	         <div class="container relative">

	             <div class="row">

	                 <div class="col-sm-12">

	                     <p class="h2"><input type="text" name="title" value="<?php echo @$article['title']; ?>" style="color: #fff;background-color: transparent;outline:0;border:none;" class="form-control required" placeholder="Give your article a headline..."></p>

	                 </div>

	             </div>

	         </div>

	      </div>

	   </div>

	</section>

	<section class="section section-article box-wapper-show-image">

	   <div class="container">

	   	  <div class="row">

	   	  	  <div class="col-sm-12">

	   	  	      <div class="row" style="margin: 0;">

	   	  	         <div class="col-sm-6 sm-remove-padding-left">

	   	  	  	  		<div class="panel panel-default relative">

		                    <div class="row">

		                        <div class="col-sm-2 col-xs-4 avatar-slider">

		                        	<?php 

		                        		$avatar = skin_url().'/images/avatar-full.png';

		                        		if(isset($user_info['avatar']) && $user_info['avatar']!=null && file_exists('.'.$user_info['avatar'])) {

		                        			$avatar = $user_info['avatar'];

		                        		}

		                        	?>

		                            <img width="80" style="display:inline-block;" class="circle" src="<?php echo $avatar; ?>">

		                        </div>

		                        <div class="col-sm-10 col-xs-8" >

		                            <p><strong><?php echo @$user_info['full_name']; ?> | <?php echo @$user_info['company_name']; ?></strong></p>

		                            <p><?php echo @$user_info['job_title']; ?></p>

		                            <p>February 20, 2016</p>

		                        </div>

		                    </div>

	                	</div><!-- end panel -->

	   	  	  	  	 </div>

	   	  	  	  	 <div class="col-sm-6 sm-remove-padding-right">

	   	  	  	  		<div class="panel panel-default relative" style="padding:0;">

	   	  	  	  			<div class="panel-heading" style="background:#7f7f7f;color: #fff;">

	   	  	  	  				<p class="text-center"><img src="<?php echo skin_url(); ?>/images/editer/panel-header.png"> Editing Tool Bar</p>

	   	  	  	  			</div>

		                    <div id="toolbar" class="wysihtml5-toolbar" style="display: none;">
							    <a data-wysihtml5-command="bold" title="CTRL+B"></a>
							    <a data-wysihtml5-command="italic" title="CTRL+I"></a>
							    <a data-wysihtml5-command="underline" title="CTRL+U"></a>
								<a data-wysihtml5-command="justifyLeft"></a>
								<a data-wysihtml5-command="justifyCenter"></a>
								<a data-wysihtml5-command="insertUnorderedList"></a>
							    <a data-wysihtml5-command="insertOrderedList"></a>
								<a data-wysihtml5-command="createLink"></a> <!-- onclick="return modal_insert_url();" -->
								<a data-wysihtml5-command="insertImage" onclick="return upload();"></a>
								<a data-wysihtml5-command="insertAudio"  onclick="return upload_audio(this);" href="javascript:;" unselectable="on"></a>
								<div data-wysihtml5-dialog="createLink" class="link-box" style="display: none;">
								  	<label>
								    	Link:
								    	<input data-wysihtml5-dialog-field="href" value="http://">
								  	</label>
								  	<a data-wysihtml5-dialog-action="save" class="btn btn-primary" href="#">OK</a>
								  	<a data-wysihtml5-dialog-action="cancel" class="btn btn-gray clear-button" href="#">Cancel</a>
								</div>
	                	    </div>

	                	</div><!-- end panel -->

	   	  	  	  	 </div>

	   	  	  	  </div> 

	   	  	  	  <div class="panel panel-default relative" id="box-editor">
	   	  	  	  		<p><input type="text" name="sub_title"  value="<?php echo @$article['sub_title']; ?>" class="form-control required" placeholder="Give your article a sub-title.."></strong></p>
				  		<textarea id="textarea" name="content" class="required-editer" placeholder="Start writing ..." style="width: 100%; height: 500px"><?php echo @$article['content']; ?></textarea>
				  </div><!-- end panel -->
	   	  	  	  <div class="panel panel-default relative">
		            <p><strong>Keywords</strong></p>
		            <ul id = "keyword-tag">
	                    <?php
	                    if (isset($article["keywords"]) && is_array($article["keywords"])) {
	                        foreach ($article["keywords"] as $key => $value) {
	                            echo "<li>" . $value["title"] . "</li>";
	                        }
	                    }
                    	?>
                	</ul>
                	<input type="hidden" id="keyword" class="required" data-for ="#keyword-tag"/>
		             <!--<textarea name="keyword" class="required" style="width: 100%;height: 150px;"><?php echo @$article['keyword']; ?></textarea>-->

		          </div><!-- end panel -->
		          <div class="panel panel-default relative">
		              <div class="save-article text-right">
		              	  <input type="hidden" id="type-article" value="" name="type">
		                  <button onclick="$('#type-article').val('1');" type="submit" name="save" class="btn btn-gray clear-button">Save</button>
		                  <button onclick="$('#type-article').val('0');" type="submit" name="publish" class="btn btn-primary">Publish</button>
	                  </div>

		          </div><!-- end panel -->

	   	  	  </div>

	   	  </div>

	   </div>

	</section>

</form>

<div class="modal fade" id="modal_insert_url" role="dialog">
<div class="modal-dialog modal-xs">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">Insert Url</h4>
    </div>
    <div class="modal-body">
        <div class="row">
        	<div class="col-md-12">
        		<label>
			    	Link:
			    	<input data-wysihtml5-dialog-field="href" id="url" value="http://">
			  	</label>
        	</div> 
        </div>                                                
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" id="btn-save">Insert</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
  </div>
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
			    <form method="post" action="<?php echo base_url("article/upload_file_content")?>" id ="upload-file-in-content" enctype="multipart/form-data">
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
<div class="modal fade" id="upload_audio" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Upload audio</h4>
        </div>
        <div class="modal-body">
            <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#upload-audio-box">Upload audio</a></li>
              <li><a data-toggle="tab" href="#insert-upload-audio-box">Insert audio</a></li>
            </ul>
            <div class="tab-content">
              <div id="upload-audio-box" class="tab-pane fade in active"> 
                <form method="post" action="<?php echo base_url("profile/upload_file_content")?>" id ="upload-file-audio-in-content" enctype="multipart/form-data">
                    <div id="wrapp-box"> 
                        <div class="list-photos" id="box-photos">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="not-image">
                                        <h2 class="text-center">Selected audio</h2>
                                        <h2 class="text-center"><a href="#" class="btn btn-default set-image" onclick="$('#upload-file-audio-content').trigger('click'); return false;">Select audio</a></h2>
                                    </div>
                                    <div id="box" class="text-center"></div>
                                </div> 
                            </div>                                                
                        </div>
                    </div>
                    <input type="file" name="file" id="upload-file-audio-content"  class="none" accept="audio/*" />
                </form>
              </div>
              <div id="insert-upload-audio-box" class="tab-pane fade">
                <div class="list-photos" id="box-photos">
                    <div class="box-src" id="box-src-set">
                      <div class="form-group">
                        <label for="pwd">Audio:</label>
                        <input id="src-image-set" class="form-control" value="" placeholder="http://">
                      </div>
                    </div>
                </div>
              </div>  
            </div>
        </div>
        <div class="modal-footer">
            <div class="progress">
              <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">
                <span class="sr-only">0% Complete</span>
              </div>
            </div>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="text-center btn btn-secondary relative" id="add-new-image">Add <div class="loadding-upload-content"><img src="<?php echo base_url("skins/images/loadding.GIF");?>"></div></button>
        </div>
      </div>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="<?php echo skin_url(); ?>/css/blog.css">
<link rel="stylesheet" type="text/css" href="<?php echo skin_url(); ?>/css/jquery.tagit.css">
<link rel="stylesheet" type="text/css" href="<?php echo skin_url(); ?>/css/tagit.ui-zendesk.css">
<script src="<?php echo skin_url(); ?>/js/tag-it.min.js"></script>
<script src="<?php echo skin_url(); ?>/js/parser_rules/advanced.js"></script>
<script src="<?php echo skin_url(); ?>/js/wysihtml5-0.4.0pre.js"></script>

<?php if (isset($_GET['share']) && $article != null) : ?>
<div class="modal fade" id="share-blog-modal" tabindex="-1" role="dialog" aria-labelledby="modal-label">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content" style="padding: 20px;border-radius: 0;">
            <button style="position: relative;top: -5px;" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h1 class="h2"><?php echo $article['title']; ?></h1>
            <div class="row" style="margin-bottom:10px;">
                <div class="col-sm-2 col-xs-4 avatar-slider">
                  <?php 
                        $avatar = skin_url().'/images/avatar-full.png';
                        if (isset($user_info['avatar']) && $user_info['avatar']!=null && file_exists('.'.$user_info['avatar'])) {
                            $avatar = base_url($user_info['avatar']);
                        }
                    ?>
                    <img width="60" style="display:inline-block;" class="circle" src="<?php echo $avatar; ?>">
                </div>
                <div class="col-sm-10 col-xs-8 profile-slider">
                    <p style="margin-bottom:0;"><strong><?php echo @$user_info['full_name']; ?> | <?php echo @$user_info['company_name']; ?></strong></p>
                    <p><?php echo @$user_info['job_title']; ?></p>
                </div>
            </div>
            <p class="text-center"><img id="photo-share" src="<?php echo base_url($src); ?>"></p>
            <p class="text-center text-share-tip" style="margin-top: 20px;">Great article! Your article will appear in multiple targeted searches based on your keywords. Share your article socially and help drive more traffic to your personal or company blogs.</p>
            <p class="text-center">
                <a href="#" onclick="share(); return false;"><img width="42" src="<?php echo skin_url(); ?>/images/facebook.png"></a>
                <a href="#" id="container" onclick="share_tw(); return false;"><img width="42" src="<?php echo skin_url(); ?>/images/twitter.png"></a>
                <a href="#" class="poup-share-in"><img width="42" src="<?php echo skin_url(); ?>/images/in.png"></a>
                <?php /* <a href="#" class='st_instagram_large' displayText='Instagram Badge'></a> */ ?>
                <a href="#" id="share-image-email" data-type="article"><img width="42" src="<?php echo skin_url(); ?>/images/email1.png"></a> 
            </p>
            <p class="text-center" style="font-size:12px;">Having trouble copying your articles URL? Simply copy and paste the link below:</p>
          <p class="text-center" style="font-size:12px;"><a style="color: #ffa126;" href="#"><?php echo base_url(); ?>article/post/<?php echo $article['id']; ?></a></p>
        </div>
    </div>
</div>

<script>
    
	$("#share-blog-modal").modal('show');
    var w = 600;
    var h = 400;
    var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
    var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;
    var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
    var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;
    var left = ((width / 2) - (w / 2)) + dualScreenLeft;
    var top = ((height / 2) - (h / 2)) + dualScreenTop;
    var description = "<?php echo @$article['title']; ?>";
    var url = window.location.href;
    var img = $("#photo-share").attr("src");
    var title = "<?php echo @$article['title']; ?>";
    var type_post = "<?php echo @$type_post;?>";
    var id_post = "<?php echo @$id_post;?>";
    var url_share_social = "<?php echo base_url("article/post/".$id_post);?>";

    function share() {
       tracking_share("facebook",type_post,id_post);
	    window.open('https://www.facebook.com/sharer/sharer.php?u=' + url_share_social,'_blank','width=' + w + ', height=' + h + ', top=' + 150 + ', left=' + left)
	}
    function share_tw() {
    	tracking_share("twitter",type_post,id_post);
        window.open("https://twitter.com/share?url=" + url_share_social + "&text=dezignwall: ", '_blank','width=' + w + ', height=' + h + ', top=' + 150 + ', left=' + left);
    }
    $(".poup-share-in").click(function () {
    	tracking_share("linkedin",type_post,id_post);
        window.open("https://www.linkedin.com/shareArticle?mini=true&url=" + url_share_social, '_blank','width=' + w + ', height=' + h + ', top=' + 150 + ', left=' + left);
        return false;
    });
    $("#share-image-emailto").click(function () {
    	var email = $(this).attr('data-email');
    	var subject = $(this).attr('data-title');
    	var content = $(this).attr('data-url');
    	var mailto_link = "mailto:" + email + "?Subject=" + subject + "&Content=" + content;
    	window.location = mailto_link;
    	win = window.open(mailto_link, 'emailWindow');
    	if (win && win.open && !win.closed) 
    		win.close();
    });
    $(document).on("click","#sendmail",function(){
      tracking_share("email",type_post,id_post);
    });
</script>
<script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "cdb00310-a660-4dd1-ac4b-4e962d9f3397", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
<style>
    .st_instagram_large .stLarge{
        background-image: url('<?php echo skin_url("images/im.png"); ?>') !important;
        width: 42px;
        height: 42px;
        background-size: contain;
        background-position: 0 0 !important;
        opacity: 1 !important;
        top:17px;
    }
    .st_instagram_large .stLarge:hover{background-image: url('<?php echo skin_url("images/im.png"); ?>') !important;}
    .wysihtml5-toolbar a {display: inline-block; width:  40px; }
</style> 
<?php endif; ?>

<script>
var editor = new wysihtml5.Editor("textarea", {
    toolbar:        "toolbar",
    stylesheets:    "<?php echo skin_url(); ?>/css/stylesheet.css",
    parserRules:    wysihtml5ParserRules

});
function upload_audio(element){
    $("#upload_audio").modal();
    return false;
}
function modal_insert_url() {
	$("#modal_insert_url").modal();
	return false;
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

$(document).on("click","#modal_insert_url #btn-save",function(){
	//var range = editor.composer.selection.getRange();
    //console.log(range);

    //var bookmark = editor.composer.selection.getBookmark();
	//editor.composer.selection.setBookmark(bookmark);
	//console.log(bookmark);

	var val = $(this).closest('#modal_insert_url').find('#url').val();
	val = $.trim(val);
	if (!ValidURL(val)) {
		return false;
	}
	editor.composer.commands.exec("createLink", { href: val, target: "", rel: "nofollow", text: "" });
	$(this).closest('#modal_insert_url').find('url').val("");
	$("#modal_insert_url").modal("hide");
});

function upload(){
	$("#mymodal_upload").modal();
	return false;
}

function chose_image(){
	$("#upload-file-content").trigger("click");
}

$(document).on("change","#upload-file-content",function(){
	reader_file($(this));
});

$(document).on("click",".loadding-upload-content",function(){
	return false;
});

function reader_file(element){
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
    		success:uploadstatus 
    	}); 
	}else if(src.trim() != ""){
		if (!ValidURL(src)) {
			return false;
		}
		$(".loadding-upload-content").show();
		editor.composer.commands.exec("insertImage", { src:src, alt: "This is an image" });
		$("#mymodal_upload #src-image-set").val("");
		$(".loadding-upload-content").hide();
		$("#mymodal_upload").modal("hide");
	} else {
		alert("Please select an image or Image Url is invalid.");
	}
});

function uploadstatus(responseText, statusText, xhr, $form)  { 
   if(responseText["status"] == "success"){
   	    editor.composer.element.focus();
   		editor.composer.commands.exec("insertImage", { src:responseText["src"], alt: "This is an image" });
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

function readURL(input) {
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
</script>
<script type="text/javascript">
	$(document).ready(function(){
		$(".form-article").submit(function(){
			$(".form-article .border-error").removeClass("border-error");
			var bool = true;
			var keyword_text = "";
			$.each($("#keyword-tag li"),function(){
				if($(this).find("> input").val() != ""){
					keyword_text += $(this).find(" > input").val()+",";
				}
			});
			$("input#keyword").val(keyword_text);
			$(this).find('.required').each(function(i){
				var value = $(this).val();
				if($.trim(value) == '' || $.trim(value) == null){
					if(typeof $(this).data("for") != "undefined" && $(this).data("for") != "")
						$($(this).data("for")).addClass('border-error');
					else
						$(this).addClass('border-error');
					bool = false;
				}
				else{
					$(this).removeClass('border-error');
				}
			});
			$(this).find('.required-editer').each(function(i){
				var value = $(this).val();
				if($.trim(value) == '' || $.trim(value) == null){
					$(this).next().next().addClass('border-error');
					bool = false;
				}
				else{
					$(this).next().next().removeClass('border-error');
				}
			});
			$(this).find('input[type="file"].required').each(function(i){
				var value = $(this).val();
				if($.trim(value) == '' || $.trim(value) == null){
					$('.image-banner').addClass('border-error');
					bool = false;
				}else{
					$('.image-banner').removeClass('border-error');
				}

			});
			if(bool == false){
				messenger_box("Article", 'Please fill in all required fields.');
			}
			return bool;
		});
		var name_not_show ="";
		$("#keyword-tag").tagit({
	        allowSpaces: true,
	        fieldName: "keyword[]",
	        autocomplete: {delay: 0, minLength: 1},
	        tagSource: function (request, response) {
	            $.ajax({
	                url: base_url + "article/get_keywords",
	                type: "post",
	                data: {slug: request.term, list_id: name_not_show,"type":"blog"},
	                dataType: "json",
	                success: function (data) {
	                	console.log(data);
	                    if (data["status"] == "success") {
	                        response($.map(data["reponse"], function (item) {
	                        	console.log(item);
	                            return {
	                                label: item.title,
	                                value: item.title,
	                            }
	                        }));
	                    }

	                }
	            });
	        },
	        afterTagAdded: function (evt, ui) {
	            name_not_show += "," + ui.tagLabel;
	        },
	        beforeTagRemoved: function (evt, ui) {
	            name_not_show = name_not_show.replace("," + ui.tagLabel, "");
	        },
	    });	 
	    <?php if (isset($error)){?>
            var error = "<?php echo $error ;?>";
			messenger_box("Error",error);
		<?php } ?>   
	});

	$(document).on("change","#upload-file-audio-content",function(){
        var _this = $(this);
        if ($(this)[0].files && $(this)[0].files[0]) {
            var file = $(this)[0].files[0];
            window.URL = window.URL || window.webkitURL;
            var url = window.URL.createObjectURL(file);
            var fileURL = URL.createObjectURL(file);
            contents ='<audio width="100%" controls><source src="'+url+'" type="'+_this[0].files[0].type+'"></audio>';
            $("#upload_audio #box-photos #box").html(contents);
            $("#mymodal_upload #box-photos #box").show();
        }else{
            $(this).parent().find(".box-img-select").html('');
        }
        return false;
    });
    $(document).on("click","#upload_audio #add-new-image",function(){
        var file = $("#upload-file-audio-content")[0].files.length;
        var src  = $("#upload_audio #src-image-set").val();
        
        if(file > 0){
            $(".loadding-upload-content").show();
            $('#upload-file-audio-in-content').ajaxSubmit({
                dataType:"json",
                success:function(res){
                	console.log(res);
                    if(res["status"] == "success"){
                        var contents ='<audio width="100%" controls src="'+res["src"]+'" type="audio/mp3"></audio>';
                        editor.composer.element.focus();
                        editor.composer.commands.exec("insertHTML", contents);
                        var control = $("#upload-file-audio-content");
                        control.replaceWith( control.val('').clone( true ) );
                        var image_holder = $("#upload_audio #box-photos #box");
                        image_holder.empty();
                        $(".loadding-upload-content").hide();
                        $("#upload_audio").modal("hide");
                    }else{
                        alert("error");
                    }
                    $("#upload_audio .progress-bar").css("width",0 +"%");
                    $("#upload_audio .progress-bar").attr("aria-valuenow",0);
                } ,
                error:function(){
                    $("#upload_audio .progress-bar").attr("aria-valuenow",0);
                    $("#upload_audio .progress-bar").css("width",0 +"%");
                    alert("Error");
                },
                uploadProgress : function(event,position ,total ,percentComplete ){
                    $("#upload_audio .progress-bar").css("width",percentComplete +"%");
                    $("#upload_audio .progress-bar").attr("aria-valuenow",percentComplete);
                }
            }); 
        }else if(src.trim() != ""){
            if (!ValidURL(src)) {
                return false;
            }
            $(".loadding-upload-content").show();

            var contents ='<audio width="100%" controls src="'+src+'" type="audio/mp3"/></audio>';
            editor.composer.element.focus();
            editor.composer.commands.exec("insertHTML", contents); 
            $("#mymodal_upload #src-image-set").val("");
            $(".loadding-upload-content").hide();
            $("#mymodal_upload").modal("hide");
        } else {
            alert("Please select an image or Image Url is invalid.");
        }
    });
    $(document).on("click",".loadding-upload-content",function(){
        return false;
    });
</script>