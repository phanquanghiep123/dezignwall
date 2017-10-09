<div class="top-story">
    <div class="col-md-4"><p><a id="add-story-now" data-type ="profile">+ Add a Profile Slide</a></p></div>
    <div class="col-md-4"><p><a id="add-story-now" data-type ="editorial">+ Add a Editorinal Slide</a></p></div>
    <div class="col-md-4"><p><a id="add-story-now" data-type ="images-video">+ Add a Image/Video Slide</a></p></div>
</div>
<div class="content-story">
    <?php 
        $max_item           = 1;
        $profile            = 1;
        $editorial          = 1;
        $images_video       = 1;
        $profile_show       = false;
        $editorial_show     = false;
        $images_video_show  = false;
        $box_item = 0;
        if(isset($liststory) && is_array($liststory)){
            foreach ($liststory as $key => $value) {
                if($max_item <= 3){
                    switch ($value["story_type"]) {
                        case '0':
                            echo '<div class="col-md-4 item-story-box" data-type="profile" data-box="1" data-id="'.$value["id"].'" data-togget="4">
                                <div class="add-item-story"> <p> <i id ="move-box-story" class="fa fa-play-circle" aria-hidden="true" style="float: right;color: #7f7f7f; transform: rotate(29deg); -webkit-transform: rotate(29deg); -ms-transform: rotate(29deg); -moz-transform: rotate(29deg); font-size: 25px;"></i></p></div>
                                <div id="wrapp-box-story">
                                    <div class="box-story">
                                        <div class="box-choose-file">
                                          <div class="action-choose">
                                              <div class="box-img-select"><img src ="'.base_url($value["media_url"]).'"></div>
                                              <div class="select-file"><a id="upload-media" href="#">Upload image</a></div>
                                              <input type="file" accept="image/*" id="media_url" class="none" name="media_url['.$box_item.']">
                                              <input type="hidden" value="" name="story['.$box_item.'][media_url]">
                                          </div>
                                        </div> 
                                        <h3><input class="title" name="story['.$box_item.'][title]" value="'.$value["title"].'" placeholder="Profile or Title"/></h3>
                                        <input class="title-input" value="'.$value["profile_name"].'" type="text" name="story['.$box_item.'][profile_name]" placeholder="Add name profile to here ...">   
                                        <input type="hidden" value="'.$value["id"].'" name="story['.$box_item.'][id]">
                                        <input type="hidden" value="0" id="story_type" name="story['.$box_item.'][story_type]">
                                        <input type="hidden" value="'.$value["sort"].'" id="sort" name="story['.$box_item.'][sort]">
                                    </div>
                                    <div class="list-action"><i id="remove-story-now" class="fa fa-times-circle" aria-hidden="true" style=" color: #af1219; font-size: 25px; "></i><i id="add-story-now" class="fa fa-plus-circle" aria-hidden="true" style=" color: #ff9900; font-size: 25px; "></i></div>
                                </div>
                            </div>';
                            $profile++;
                            $profile_show = true;
                            break;
                        case '1':
                            echo '<div class="col-md-4 item-story-box" data-type="editorial" data-box="3" data-id="'.$value["id"].'" data-togget="5">
                                <div class="add-item-story"> <p><i id ="move-box-story" class="fa fa-play-circle" aria-hidden="true" style="float: right;color: #7f7f7f; transform: rotate(29deg); -webkit-transform: rotate(29deg); -ms-transform: rotate(29deg); -moz-transform: rotate(29deg); font-size: 25px;"></i></p></div>
                                <div id="wrapp-box-story">
                                    <div class="box-story">
                                        <div class="panel panel-default relative" style="padding:0;">
                                            <div class="panel-heading" style="background:#7f7f7f;color: #fff;">
                                                <p class="text-center"> Editing Tool Bar</p>
                                            </div>
                                            <div id="toolbar-'.$editorial.'" class="wysihtml5-toolbar">
                                                <a data-wysihtml5-command="bold" title="CTRL+B" href="javascript:;" unselectable="on"><i class="fa fa-bold" aria-hidden="true"></i></a>
                                                <a data-wysihtml5-command="italic" title="CTRL+I" href="javascript:;" unselectable="on"><i class="fa fa-italic" aria-hidden="true"></i></a>
                                                <a data-wysihtml5-command="underline" title="CTRL+U" href="javascript:;" unselectable="on"><i class="fa fa-underline" aria-hidden="true"></i></a>
                                                <a data-wysihtml5-command="insertUnorderedList" href="javascript:;" unselectable="on"><i class="fa fa-list-ul" aria-hidden="true"></i></a>
                                                <a data-wysihtml5-command="insertOrderedList" href="javascript:;" unselectable="on"><i class="fa fa-list-ol" aria-hidden="true"></i></a>
                                                <a data-wysihtml5-command="createLink" href="javascript:;" unselectable="on"><i class="fa fa-link" aria-hidden="true"></i></a> <!-- onclick="return modal_insert_url();" -->
                                                <a data-edit ="'.$editorial.'" onclick="return upload_editer(this);" href="javascript:;" unselectable="on"><i><img src="'.base_url("skins/images/editer/editer-image.png").'"></i></a>
                                                <a data-edit ="'.$editorial.'" onclick="return upload_audio(this);" href="javascript:;" unselectable="on"><i><img src="'.base_url("skins/images/headphones-icon-gray.png").'"></i></a>
                                                <div data-wysihtml5-dialog="createLink" class="link-box" style="display: none;">
                                                    <label>Link: <input data-wysihtml5-dialog-field="href" value="http://"></label>
                                                    <a data-wysihtml5-dialog-action="save" class="btn btn-primary" href="#">OK</a>
                                                    <a data-wysihtml5-dialog-action="cancel" class="btn btn-gray clear-button" href="#">X</a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- element to edit -->
                                        <input class="title-input" value="'.$value["title"].'" type="text" name="story['.$box_item.'][title]" placeholder="Add a Title">
                                        <textarea id="editorial-'.$editorial.'" name="story['.$box_item.'][story_content]" placeholder="Add editorinal text here..." style="width: 810px; height: 400px">'.$value["story_content"].'</textarea>
                                        <input type="hidden" value="1" id="story_type" name="story['.$box_item.'][story_type]">
                                        <input type="hidden" id="story-id" value="'.$value["id"].'" name="story['.$box_item.'][id]">
                                        <input type="hidden" value="'.$value["sort"].'" id="sort" name="story['.$box_item.'][sort]">
                                    </div>
                                    <div class="list-action"><i id="remove-story-now" class="fa fa-times-circle" aria-hidden="true" style=" color: #af1219; font-size: 25px; "></i><i id="add-story-now" class="fa fa-plus-circle" aria-hidden="true" style=" color: #ff9900; font-size: 25px; "></i></div>
                                </div>
                            </div>';
                            $editorial++;
                            $editorial_show = true;
                            break;
                        default:
                           
                           if(strpos($value["type"],"video/") === false){
                                $content = '<img src ="'.base_url($value["media_url"]).'">';
                           }else{
                                $content = '<video width="100%" controls=""><source src="'.base_url($value["media_url"]).'" type="'.$value["type"].'"></video>'; 
                           }
                           echo '<div class="col-md-4 item-story-box" data-type="images-video" data-id="'.$value["id"].'" data-box="3" data-togget="6">
                           <div class="add-item-story"> <p> <i id ="move-box-story" class="fa fa-play-circle" aria-hidden="true" style="float: right;color: #7f7f7f; transform: rotate(29deg); -webkit-transform: rotate(29deg); -ms-transform: rotate(29deg); -moz-transform: rotate(29deg); font-size: 25px;"></i></p></div>
                           <div id="wrapp-box-story">
                               <div class="box-story">
                                    <div class="video-slider-box">
                                        <div class="box-choose-file">
                                          <div class="action-choose">
                                              <div class="box-img-select">'.$content.'</div>
                                              <div class="select-file"><a id="upload-media" href="#">Upload image/video</a></div>
                                              <input type="file" accept="image/*,video/*" id="media_url" class="none" name="media_url['.$box_item.']">
                                              <input type="hidden" value="" name="story['.$box_item.'][media_url]">
                                          </div>
                                        </div> 
                                    </div>
                                    <div class="box-caption-title">
                                        <h3><input class="title" name="story['.$box_item.'][title]" value="'.$value["title"].'" placeholder="Caption Title"/></h3>
                                        <input class="title-input" value="'.$value["profile_name"].'" type="text" name="story['.$box_item.'][profile_name]" placeholder="Add name profile to here ...">
                                    </div>
                                    <input type="hidden" value="2" id="story_type" name="story['.$box_item.'][story_type]">
                                    <input type="hidden" id="story-id" value="'.$value["id"].'" name="story['.$box_item.'][id]">
                                    <input type="hidden" value="'.$value["sort"].'" id="sort" name="story['.$box_item.'][sort]">
                               </div>
                               <div class="list-action"><i id="remove-story-now" class="fa fa-times-circle" aria-hidden="true" style=" color: #af1219; font-size: 25px; "></i><i id="add-story-now" class="fa fa-plus-circle" aria-hidden="true" style=" color: #ff9900; font-size: 25px; "></i></div>
                            </div>
                            </div>';
                            $images_video++;
                            $images_video_show = true;
                        break;
                    }
                }else{
                    switch ($value["story_type"]) {
                        case '0':
                            echo '<div class="col-md-4 item-story-box" data-id="'.$value["id"].'" data-type="profile" data-box="4" data-togget="1">
                                <div id="wrapp-box-story">
                                    <div class="add-item-story"><p><i id ="move-box-story" class="fa fa-play-circle" aria-hidden="true" style="float: right;color: #7f7f7f; transform: rotate(29deg); -webkit-transform: rotate(29deg); -ms-transform: rotate(29deg); -moz-transform: rotate(29deg); font-size: 25px;"></i></p></div>
                                    <div class="box-story">
                                        <div class="box-choose-file">
                                          <div class="action-choose">
                                              <div class="box-img-select"><img src ="'.base_url($value["media_url"]).'"></div>
                                              <div class="select-file"><a id="upload-media" href="#">Upload image</a></div>
                                              <input type="file" accept="image/*" id="media_url" class="none" name="media_url['.$box_item.']">
                                              <input type="hidden" value="0" name="story['.$box_item.'][media_url]">
                                          </div>
                                        </div> 
                                        <h3><input class="title" name="story['.$box_item.'][title]" value="'.$value["title"].'" placeholder="Name or Title"/></h3>
                                        <input class="title-input" value="'.$value["profile_name"].'" type="text" name="story['.$box_item.'][profile_name]" placeholder="Add name profile to here ...">  
                                        <input type="hidden" value="0" id="story_type" name="story['.$box_item.'][story_type]">
                                        <input type="hidden" id="story-id" value="'.$value["id"].'" name="story['.$box_item.'][id]">
                                        <input type="hidden" value="'.$value["sort"].'" id="sort" name="story['.$box_item.'][sort]">
                                    </div>
                                    <div class="list-action"><i id="remove-story-now" class="fa fa-times-circle" aria-hidden="true" style=" color: #af1219; font-size: 25px; "></i></div>
                                </div>
                            </div>';
                            $profile++;
                            break;
                        case '1':
                            echo '<div class="col-md-4 item-story-box" data-id="'.$value["id"].'" data-type="editorial" data-box="5" data-togget="2">
                                <div id="wrapp-box-story">
                                    <div class="add-item-story"> <p><i id ="move-box-story" class="fa fa-play-circle" aria-hidden="true" style="float: right;color: #7f7f7f; transform: rotate(29deg); -webkit-transform: rotate(29deg); -ms-transform: rotate(29deg); -moz-transform: rotate(29deg); font-size: 25px;"></i></p></div>
                                    <div class="box-story">
                                        <div class="panel panel-default relative" style="padding:0;">
                                            <div class="panel-heading" style="background:#7f7f7f;color: #fff;">
                                                <p class="text-center"> Editing Tool Bar</p>
                                            </div>
                                            <div id="toolbar-'.$editorial.'" class="wysihtml5-toolbar">
                                                <a data-wysihtml5-command="bold" title="CTRL+B" href="javascript:;" unselectable="on"><i class="fa fa-bold" aria-hidden="true"></i></a>
                                                <a data-wysihtml5-command="italic" title="CTRL+I" href="javascript:;" unselectable="on"><i class="fa fa-italic" aria-hidden="true"></i></a>
                                                <a data-wysihtml5-command="underline" title="CTRL+U" href="javascript:;" unselectable="on"><i class="fa fa-underline" aria-hidden="true"></i></a>
                                                <a data-wysihtml5-command="insertUnorderedList" href="javascript:;" unselectable="on"><i class="fa fa-list-ul" aria-hidden="true"></i></a>
                                                <a data-wysihtml5-command="insertOrderedList" href="javascript:;" unselectable="on"><i class="fa fa-list-ol" aria-hidden="true"></i></a>
                                                <a data-wysihtml5-command="createLink" href="javascript:;" unselectable="on"><i class="fa fa-link" aria-hidden="true"></i></a> <!-- onclick="return modal_insert_url();" -->
                                                <a data-edit ="'.$editorial.'" onclick="return upload_editer(this);" href="javascript:;" unselectable="on"><i><img src="'.base_url("skins/images/editer/editer-image.png").'"></i></a>
                                                <a data-edit ="'.$editorial.'" onclick="return upload_audio(this);" href="javascript:;" unselectable="on"><i><img src="'.base_url("skins/images/headphones-icon-gray.png").'"></i></a>
                                                <div data-wysihtml5-dialog="createLink" class="link-box" style="display: none;">
                                                    <label>Link: <input data-wysihtml5-dialog-field="href" value="http://"></label>
                                                    <a data-wysihtml5-dialog-action="save" class="btn btn-primary" href="#">OK</a>
                                                    <a data-wysihtml5-dialog-action="cancel" class="btn btn-gray clear-button" href="#">X</a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- element to edit -->
                                        <input class="title-input" value="'.$value["title"].'" type="text" name="story['.$box_item.'][title]" placeholder="Add a Title">
                                        <textarea id="editorial-'.$editorial.'" name="story['.$box_item.'][story_content]" placeholder="Add editorinal text here..." style="width: 810px; height: 400px">'.$value["story_content"].'</textarea>
                                        <input type="hidden" value="1" id="story_type" name="story['.$box_item.'][story_type]">
                                        <input type="hidden" id="story-id" value="'.$value["id"].'" name="story['.$box_item.'][id]">
                                        <input type="hidden" value="'.$value["sort"].'" id="sort" name="story['.$box_item.'][sort]">
                                   </div>
                                   <div class="list-action"><i id="remove-story-now" class="fa fa-times-circle" aria-hidden="true" style=" color: #af1219; font-size: 25px; "></i></div>
                                </div>
                            </div>';
                            $editorial++;
                            break;
                        default:
                           if(strpos($value["type"],"video/") === false){
                                $content = '<img src ="'.base_url($value["media_url"]).'">';
                           }else{
                                $content = '<video width="100%" controls=""><source src="'.base_url($value["media_url"]).'" type="'.$value["type"].'"></video>'; 
                           }
                           echo '<div class="col-md-4 item-story-box" data-type="images-video" data-id="'.$value["id"].'" data-box="6" data-togget="3">
                                <div id="wrapp-box-story">
                                    <div class="add-item-story"> <p><i id ="move-box-story" class="fa fa-play-circle" aria-hidden="true" style="float: right;color: #7f7f7f; transform: rotate(29deg); -webkit-transform: rotate(29deg); -ms-transform: rotate(29deg); -moz-transform: rotate(29deg); font-size: 25px;"></i></p></div>
                                    <div class="box-story ">
                                        <div class="video-slider-box">
                                            <div class="box-choose-file">
                                              <div class="action-choose">
                                                  <div class="box-img-select">'.$content.'</div>
                                                  <div class="select-file"><a id="upload-media" href="#">Upload image/video</a></div>
                                                  <input type="file" accept="image/*,video/*" id="media_url" class="none" name="media_url['.$box_item.']">
                                                  <input type="hidden" value="2" name="story['.$box_item.'][media_url]">
                                              </div>
                                            </div> 
                                            <div class="box-caption-title">
                                                <h3><input class="title" name="story['.$box_item.'][title]" value="'.$value["title"].'" placeholder="Caption Title"/></h3>
                                                <input class="title-input" value="'.$value["profile_name"].'" type="text" name="story['.$box_item.'][profile_name]" placeholder="Add name profile to here ...">
                                            </div>
                                            <input type="hidden" value="2" id="story_type" name="story['.$box_item.'][story_type]">
                                            <input type="hidden" id="story-id" value="'.$value["id"].'" name="story['.$box_item.'][id]">
                                            <input type="hidden" value="'.$value["sort"].'" id="sort" name="story['.$box_item.'][sort]">
                                        </div>
                                    </div>
                                    <div class="list-action"><i id="remove-story-now" class="fa fa-times-circle" aria-hidden="true" style=" color: #af1219; font-size: 25px; "></i></div>
                                </div>
                            </div>';
                            $images_video++;
                            break;
                    }
                }
                $max_item++;
                $box_item++;
            }
        }
        if($max_item <= 6){
            for ($i = $max_item; $i <= 6; $i++) { 
                if($i <= 3 ){
                    if($profile <= 2 && $profile_show == false){
                        echo '<div class="col-md-4 item-story-box" data-type="profile" data-box="1" data-togget="4">
                                <div class="add-item-story"> <p><i id ="move-box-story" class="fa fa-play-circle" aria-hidden="true" style="float: right;color: #7f7f7f; transform: rotate(29deg); -webkit-transform: rotate(29deg); -ms-transform: rotate(29deg); -moz-transform: rotate(29deg); font-size: 25px;"></i></p></div>
                                <div id="wrapp-box-story">
                                    <div class="box-story">
                                        <div class="box-choose-file">
                                          <div class="action-choose">
                                              <div class="box-img-select"></div>
                                              <div class="select-file"><a id="upload-media" href="#">Upload image</a></div>
                                              <input type="file" accept="image/*" id="media_url" class="none" name="media_url['.$box_item.']">
                                              <input type="hidden" value="" name="story['.$box_item.'][media_url]">
                                          </div>
                                        </div> 
                                        <h3><input class="title" name="story['.$box_item.'][title]" placeholder="Name or Title"/></h3>
                                        <input class="title-input" type="text" name="story['.$box_item.'][profile_name]" placeholder="Add name profile to here ...">   
                                        <input type="hidden" value="0" id="story_type" name="story['.$box_item.'][story_type]">
                                        <input type="hidden" value="0" name="story['.$box_item.'][id]">
                                        <input type="hidden" value="0" id="sort" name="story['.$box_item.'][sort]">
                                    </div>
                                    <div class="list-action"><i id="remove-story-now" class="fa fa-times-circle" aria-hidden="true" style=" color: #af1219; font-size: 25px; "></i><i id="add-story-now" class="fa fa-plus-circle" aria-hidden="true" style=" color: #ff9900; font-size: 25px; "></i></div>
                                </div>
                            </div>';
                            $show = "profile";
                            $profile_show = true;
                            $profile++;
                    }elseif($editorial <=2 && $editorial_show == false){
                        echo '<div class="col-md-4 item-story-box" data-type="editorial" data-box="3" data-togget="5">
                            <div class="add-item-story"> <p><i id ="move-box-story" class="fa fa-play-circle" aria-hidden="true" style="float: right;color: #7f7f7f; transform: rotate(29deg); -webkit-transform: rotate(29deg); -ms-transform: rotate(29deg); -moz-transform: rotate(29deg); font-size: 25px;"></i></p></div>
                            <div id="wrapp-box-story">
                                <div class="box-story">
                                    <div class="panel panel-default relative" style="padding:0;">
                                        <div class="panel-heading" style="background:#7f7f7f;color: #fff;">
                                            <p class="text-center"> Editing Tool Bar</p>
                                        </div>
                                        <div id="toolbar-'.$editorial.'" class="wysihtml5-toolbar">
                                            <a data-wysihtml5-command="bold" title="CTRL+B" href="javascript:;" unselectable="on"><i class="fa fa-bold" aria-hidden="true"></i></a>
                                            <a data-wysihtml5-command="italic" title="CTRL+I" href="javascript:;" unselectable="on"><i class="fa fa-italic" aria-hidden="true"></i></a>
                                            <a data-wysihtml5-command="underline" title="CTRL+U" href="javascript:;" unselectable="on"><i class="fa fa-underline" aria-hidden="true"></i></a>
                                            <a data-wysihtml5-command="insertUnorderedList" href="javascript:;" unselectable="on"><i class="fa fa-list-ul" aria-hidden="true"></i></a>
                                            <a data-wysihtml5-command="insertOrderedList" href="javascript:;" unselectable="on"><i class="fa fa-list-ol" aria-hidden="true"></i></a>
                                            <a data-wysihtml5-command="createLink" href="javascript:;" unselectable="on"><i class="fa fa-link" aria-hidden="true"></i></a> <!-- onclick="return modal_insert_url();" -->
                                            <a data-edit ="'.$editorial.'" onclick="return upload_editer(this);" href="javascript:;" unselectable="on"><i><img src="'.base_url("skins/images/editer/editer-image.png").'"></i></a>
                                            <a data-edit ="'.$editorial.'" onclick="return upload_audio(this);" href="javascript:;" unselectable="on"><i><img src="'.base_url("skins/images/headphones-icon-gray.png").'"></i></a>
                                            <div data-wysihtml5-dialog="createLink" class="link-box" style="display: none;">
                                                <label>Link: <input data-wysihtml5-dialog-field="href" value="http://"></label>
                                                <a data-wysihtml5-dialog-action="save" class="btn btn-primary" href="#">OK</a>
                                                <a data-wysihtml5-dialog-action="cancel" class="btn btn-gray clear-button" href="#">X</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- element to edit -->
                                    <input class="title-input" type="text" name="story['.$box_item.'][title]" placeholder="Add a Title">
                                    <textarea id="editorial-'.$editorial.'" name="story['.$box_item.'][story_content]" placeholder="Add editorinal text here..." style="width: 810px; height: 400px"></textarea>
                                    <input type="hidden" value="1" id="story_type" name="story['.$box_item.'][story_type]">
                                    <input type="hidden" value="0" id="story-id" name="story['.$box_item.'][id]">
                                    <input type="hidden" value="1" id="sort" name="story['.$box_item.'][sort]">
                                </div>
                                <div class="list-action"><i id="remove-story-now" class="fa fa-times-circle" aria-hidden="true" style=" color: #af1219; font-size: 25px; "></i><i id="add-story-now" class="fa fa-plus-circle" aria-hidden="true" style=" color: #ff9900; font-size: 25px; "></i></div>
                            </div>
                        </div>';
                        $editorial_show = true;
                        $editorial++;
                    }elseif ($images_video <=2 && $images_video_show == false) {
                        echo '<div class="col-md-4 item-story-box" data-type="images-video" data-box="3" data-togget="6">
                           <div class="add-item-story"> <p><i id ="move-box-story" class="fa fa-play-circle" aria-hidden="true" style="float: right;color: #7f7f7f; transform: rotate(29deg); -webkit-transform: rotate(29deg); -ms-transform: rotate(29deg); -moz-transform: rotate(29deg); font-size: 25px;"></i></p></div>
                           <div id="wrapp-box-story">
                               <div class="box-story">
                                    <div class="video-slider-box">
                                        <div class="box-choose-file">
                                          <div class="action-choose">
                                              <div class="box-img-select"></div>
                                              <div class="select-file"><a id="upload-media" href="#">Upload image/video</a></div>
                                              <input type="file" accept="image/*,video/*" id="media_url" class="none" name="media_url['.$box_item.']">
                                              <input type="hidden" value="" name="story['.$box_item.'][media_url]">
                                          </div>
                                        </div> 
                                    </div>
                                    <div class="box-caption-title">
                                        <h3><input class="title" name="story['.$box_item.'][title]" placeholder="Caption Title"/></h3>
                                        <input class="title-input" type="text" name="story['.$box_item.'][profile_name]" placeholder="Add name profile to here ...">
                                    </div>
                                    <input type="hidden" value="2" id="story_type" name="story['.$box_item.'][story_type]">
                                    <input type="hidden" value="0" name="story['.$box_item.'][id]">
                                    <input type="hidden" value="2" id="sort" name="story['.$box_item.'][sort]">
                               </div>
                               <div class="list-action"><i id="remove-story-now" class="fa fa-times-circle" aria-hidden="true" style=" color: #af1219; font-size: 25px; "></i><i id="add-story-now" class="fa fa-plus-circle" aria-hidden="true" style=" color: #ff9900; font-size: 25px; "></i></div>
                            </div>
                        </div>';
                        $images_video++;
                        $images_video_show = true;
                    }                         
                }else{  
                    $show = "none";  
                    $listadd = '<i id="add-story-now" class="fa fa-plus-circle" aria-hidden="true" style=" color: #ff9900; font-size: 25px; "></i>';                             
                    if($profile <= 2){
                    echo '<div class="col-md-4 item-story-box '.$show.'" data-type="profile" data-box="4" data-togget="1">
                                <div id="wrapp-box-story">
                                    <div class="add-item-story"><p><i id ="move-box-story" class="fa fa-play-circle" aria-hidden="true" style="float: right;color: #7f7f7f; transform: rotate(29deg); -webkit-transform: rotate(29deg); -ms-transform: rotate(29deg); -moz-transform: rotate(29deg); font-size: 25px;"></i></p></div>
                                    <div class="box-story">
                                        <div class="box-choose-file">
                                          <div class="action-choose">
                                              <div class="box-img-select"></div>
                                              <div class="select-file"><a id="upload-media" href="#">Upload image</a></div>
                                              <input type="file" accept="image/*" id="media_url" class="none" name="media_url['.$box_item.']">
                                              <input type="hidden" value="0" name="story['.$box_item.'][media_url]">
                                          </div>
                                        </div> 
                                        <h3><input class="title" name="story['.$box_item.'][title]" placeholder="Name or Title"/></h3>
                                        <input class="title-input" type="text" name="story['.$box_item.'][title]" placeholder="Add name profile to here ...">  
                                        <input type="hidden" value="0" id="story_type" name="story['.$box_item.'][story_type]">
                                        <input type="hidden" value="0" id="story-id" name="story['.$box_item.'][id]">
                                        <input type="hidden" value="3" id="sort" name="story['.$box_item.'][sort]">
                                    </div>
                                    <div class="list-action"><i id="remove-story-now" class="fa fa-times-circle" aria-hidden="true" style=" color: #af1219; font-size: 25px; "></i>'.$listadd.'</div>
                                </div>
                            </div>';
                        $profile++;
                    }elseif($editorial <=2){
                         echo '<div class="col-md-4 item-story-box '.$show.'" data-type="editorial" data-box="5" data-togget="2">
                                <div id="wrapp-box-story">
                                    <div class="add-item-story"> <p><i id ="move-box-story" class="fa fa-play-circle" aria-hidden="true" style="float: right;color: #7f7f7f; transform: rotate(29deg); -webkit-transform: rotate(29deg); -ms-transform: rotate(29deg); -moz-transform: rotate(29deg); font-size: 25px;"></i></p></div>
                                    <div class="box-story">
                                        <div class="panel panel-default relative" style="padding:0;">
                                            <div class="panel-heading" style="background:#7f7f7f;color: #fff;">
                                                <p class="text-center"> Editing Tool Bar</p>
                                            </div>
                                            <div id="toolbar-'.$editorial.'" class="wysihtml5-toolbar">
                                                <a data-wysihtml5-command="bold" title="CTRL+B" href="javascript:;" unselectable="on"><i class="fa fa-bold" aria-hidden="true"></i></a>
                                                <a data-wysihtml5-command="italic" title="CTRL+I" href="javascript:;" unselectable="on"><i class="fa fa-italic" aria-hidden="true"></i></a>
                                                <a data-wysihtml5-command="underline" title="CTRL+U" href="javascript:;" unselectable="on"><i class="fa fa-underline" aria-hidden="true"></i></a>
                                                <a data-wysihtml5-command="insertUnorderedList" href="javascript:;" unselectable="on"><i class="fa fa-list-ul" aria-hidden="true"></i></a>
                                                <a data-wysihtml5-command="insertOrderedList" href="javascript:;" unselectable="on"><i class="fa fa-list-ol" aria-hidden="true"></i></a>
                                                <a data-wysihtml5-command="createLink" href="javascript:;" unselectable="on"><i class="fa fa-link" aria-hidden="true"></i></a> <!-- onclick="return modal_insert_url();" -->
                                                <a data-edit ="'.$editorial.'" onclick="return upload_editer(this);" href="javascript:;" unselectable="on"><i><img src="'.base_url("skins/images/editer/editer-image.png").'"></i></a>
                                                <a data-edit ="'.$editorial.'" onclick="return upload_audio(this);" href="javascript:;" unselectable="on"><i><img src="'.base_url("skins/images/headphones-icon-gray.png").'"></i></a>
                                                <div data-wysihtml5-dialog="createLink" class="link-box" style="display: none;">
                                                    <label>Link: <input data-wysihtml5-dialog-field="href" value="http://"></label>
                                                    <a data-wysihtml5-dialog-action="save" class="btn btn-primary" href="#">OK</a>
                                                    <a data-wysihtml5-dialog-action="cancel" class="btn btn-gray clear-button" href="#">X</a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- element to edit -->
                                        <input class="title-input" type="text" name="story['.$box_item.'][title]" placeholder="Add a Title">
                                        <textarea id="editorial-'.$editorial.'" name="story['.$box_item.'][story_content]" placeholder="Add editorinal text here..." style="width: 810px; height: 400px"></textarea>
                                        <input type="hidden" value="1" id="story_type" name="story['.$box_item.'][story_type]">
                                        <input type="hidden" value="0" id="story-id" name="story['.$box_item.'][id]">
                                        <input type="hidden" value="4" id="sort" name="story['.$box_item.'][sort]">
                                   </div>
                                   <div class="list-action"><i id="remove-story-now" class="fa fa-times-circle" aria-hidden="true" style=" color: #af1219; font-size: 25px; "></i>'.$listadd.'</div>
                                </div>
                            </div>';
                            $editorial++;
                    }elseif ($images_video <=2) {
                        echo '<div class="col-md-4 item-story-box '.$show.'" data-type="images-video" data-box="6" data-togget="3">
                                <div id="wrapp-box-story">
                                    <div class="add-item-story"> <p><i id ="move-box-story" class="fa fa-play-circle" aria-hidden="true" style="float: right;color: #7f7f7f; transform: rotate(29deg); -webkit-transform: rotate(29deg); -ms-transform: rotate(29deg); -moz-transform: rotate(29deg); font-size: 25px;"></i></p></div>
                                    <div class="box-story ">
                                        <div class="video-slider-box">
                                            <div class="box-choose-file">
                                              <div class="action-choose">
                                                  <div class="box-img-select"></div>
                                                  <div class="select-file"><a id="upload-media" href="#">Upload image/video</a></div>
                                                  <input type="file" accept="image/*,video/*" id="media_url" class="none" name="media_url['.$box_item.']">
                                                  <input type="hidden" value="2" name="story['.$box_item.'][media_url]">
                                              </div>
                                            </div> 
                                            <div class="box-caption-title">
                                                <h3><input class="title" name="story['.$box_item.'][title]" placeholder="Caption Title"/></h3>
                                                <input class="title-input" type="text" name="story['.$box_item.'][profile_name]" placeholder="Add name profile to here ...">
                                            </div>
                                            <input type="hidden" value="2" id="story_type" name="story['.$box_item.'][story_type]">
                                            <input type="hidden" id="story-id" value="0" name="story['.$box_item.'][id]">
                                            <input type="hidden" value="5" id="sort" name="story['.$box_item.'][sort]">
                                        </div>
                                    </div>
                                    <div class="list-action"><i id="remove-story-now" class="fa fa-times-circle" aria-hidden="true" style=" color: #af1219; font-size: 25px; "></i>'.$listadd.'</div>
                                </div>
                            </div>';
                        $images_video++;
                    } 
                }
                $box_item++;
            }
        }
    ?>
</div>