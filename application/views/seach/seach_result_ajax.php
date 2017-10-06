<?php
if (isset($photo) && count($photo) > 0):
    if(!isset($user_id)){
        $user_id = -1;
        if ($this->session->userdata('user_info')) {
            $user_info = $this->session->userdata('user_info');
            $user_id = $user_info["id"];
        }
    }    
    $images = ($photo['thumb'] != "" && file_exists(FCPATH . $photo['thumb']) ) ? base_url($photo['thumb']) : base_url($photo['path_file']);
    $photo_id = $photo['photo_id'];
    ?>
    <div id="card-<?php echo $photo_id; ?>" class="card" data-id ="<?php echo $photo_id; ?>" data-type="photo">
        <div class="card-wrapper" id ="wrapper-impormant-image" data-id = "<?php echo $photo_id; ?>">
            <div class="card-image relative">
                <div class="relative">
                <?php if($photo["status_photo"] == "1"):?>
                    <a title="<?php echo @$photo["name"]; ?>" href ="<?php echo base_url("photos/" . $photo['photo_id'] . "/" . gen_slug($photo["name"])); ?>"><img class="photo-details" src = "<?php echo $images; ?>"/></a>
                <?php endif;?>
                <?php if($photo["is_story"] == "1"){ ?>
                    <div class="view-story"><img src="<?php echo base_url("skins/images/story-icon.png")?>"></div>
                <?php }?>
                <?php if($photo["status_photo"] == "0" && @$myphoto == true):?>
                    <a href ="<?php echo base_url("photos/" . $photo['photo_id'] . "/" . gen_slug($photo["name"])); ?>"><img class="photo-details" src = "<?php echo base_url($images); ?>"/></a>
                <?php endif;?>
                <?php if(@$myphoto == true ):?>
                    <?php if($photo['id'] == $user_id):?>
                    <div class="action-photo">
                        <ul>
                            <li><a href="#" data-id = "<?php echo $photo['photo_id']; ?>" class="add-story-photo btn-story-my-photo">Add a Story</a></li>
                            <li><a href="#" data-id = "<?php echo $photo['photo_id']; ?>" class="delete-photo btn-delete-my-photo">Delete photo</a></li>
                            <li><a href="<?php echo base_url(); ?>profile/editphoto/<?php echo $photo['photo_id']; ?>" class="edit-photo btn-edit-my-photo">Edit photo</a></li>     
                        </ul>
                    </div>
                    <?php endif;?>
                <?php endif;?>
                </div>
                <?php if($photo["status_photo"] == "2"):?>
                    <div class="item-slider-same">
                        <div class="single-image relative">
                            <div class="bg-black-full"></div>
                            <h2 class="messeger-delete">Opps! It looks like this item<br/> has been discontinued...</h2>
                            <img class="photo-details" src = "<?php echo base_url($images); ?>"/>
                            <p class="text-center worry">But don’t worry, your manufacturer<br/> has these other great alternatives!</p>
                            <?php if(@$myphoto == true ):?>
                                <?php if($photo['id'] == $user_id):?>
                                <div class="action-photo">
                                    <ul>
                                        <li><a href="#" data-id = "<?php echo $photo['photo_id']; ?>" class="delete-photo btn-delete-my-photo">Delete photo</a></li>
                                        <li><a href="<?php echo base_url(); ?>profile/editphoto/<?php echo $photo['photo_id']; ?>" class="edit-photo btn-edit-my-photo">Edit photo</a></li>     
                                    </ul>
                                </div>
                                <?php endif;?>
                            <?php endif;?>
                        </div>
                        <div class="data-same">
                            <?php
                            if($photo["same_photo"]){
                                $same_photo = json_decode(@$photo["same_photo"],true);                                  
                                if($same_photo){
                                    echo '<ul class="bx-slider-same">';
                                    foreach ($same_photo as $key_same => $value_same) {
                                        $images_same = ($value_same['thumb'] != "" && file_exists(FCPATH . $value_same['thumb']) ) ? $value_same['thumb'] : $value_same['path_file'];
                                        echo '<li><a data-index = "'.$key_same.'" id="see-same-photo" href ="'.base_url("photos/" . $value_same['photo_id'] . "/" . gen_slug($value_same["name"])).'"><img src="'.base_url($images_same).'"></a></li>';
                                    }
                                    echo "</ul>";
                                }?>
                            <?php }       
                            ?>
                        </div>
                    </div>
                <?php else:?>
                    <?php $album = json_decode($photo["album"],true)?>
                    <?php if($album != null):?>
                    <div class="item-slider-same">  
                        <?php if(count($album) > 0){ ?>
                        <div class="view-more-same"><p id="more-slider">View more: </p></div>
                        <?php } ?>
                        <div class="data-same">
                            <?php
                            echo '<ul class="bx-slider-same">';
                            foreach ($album as $key_album => $value_album) {
                                $images_album = ($value_album['thumb'] != "" && file_exists(FCPATH . $value_album['thumb']) ) ? $value_album['thumb'] : $value_album['path'];
                                echo '<li><a id="view-item-album" href="#" data-index = "'.$key_album.'"><img src="'.base_url($images_album).'"></a></li>';
                            }
                            echo "</ul>";
                            echo ((count($album)) > 0) ? '<div class="number-same-photo"><p><span>+'.(count($album) ).'</span></p></div>' : "" ;?>
                        </div>
                    </div>
                     <?php endif;?>
                <?php endif;?>
                
                <?php $no_bg = ""; ?>
                <?php
                if ($photo['type_member'] == 0) {
                    //$no_bg = "not_bg";
                }
                ?>
                <div class="impromation-project <?php echo @$no_bg; ?>">
                    <?php $no_bg = ""; ?>
                    <?php if (true): ?>
                        <?php if (isset($photo['company_name']) && $photo['company_name'] != "") { ?>
                            <div class="logo-company">
                                <?php $logo = ($photo['logo'] != "" && file_exists(FCPATH . $photo['logo'])) ? base_url($photo['logo']) : base_url("skins/images/signup.png"); ?>
                                <a id="login-check" href="<?php echo base_url("profile/index/" . $photo['id']); ?>"><img src="<?php echo $logo; ?>"></a>
                                <?php
                                $business_description = (isset($photo['business_description'])) ? trim($photo['business_description']) : "";
                                $business_description = str_replace(";", "", $business_description);
                                $before = strlen($business_description) - 1;
                                $after = $before + 1;
                                if (substr($business_description, $before, $after) == ",") {
                                    $business_description = substr($business_description, 0, -1);
                                };
                                ?>
                                <p><a id="login-check" href="<?php echo base_url("profile/index/" . $photo['id']); ?>"><strong><?php echo @$photo['company_name']; ?></strong><br><?php echo @$business_description; ?></a></p>
                            </div>
                        <?php } ?>
                    <?php endif; ?>
                    <?php if(@$myphoto != true):?>
                    <div class="impromation-project-dropdown">
                        <div class="dropdown-impromation relative">
                            <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>     
                            <ul class="dropdown-impromation-menu">
                                <li><a href="#">Residential...</a></li>
                                <li><a href="#">Inappropriate...</a></li>
                                <li><a href="#">Wrong category...</a></li>
                                <li><a href="#">Unauthorized image use...</a></li>
                            </ul>
                        </div>
                    </div>
                    <?php endif;?>
                    <?php if(@$myphoto == true && $photo['id'] != $user_id):?>
                    <div class="impromation-project-dropdown">
                        <div class="dropdown-impromation relative">
                            <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>     
                            <ul class="dropdown-impromation-menu">
                                <li><a href="#">Residential...</a></li>
                                <li><a href="#">Inappropriate...</a></li>
                                <li><a href="#">Wrong category...</a></li>
                                <li><a href="#">Unauthorized image use...</a></li>
                            </ul>
                        </div>
                    </div>
                    <?php endif;?>
                </div>
            </div>
            <div class="commen-like" id="search-home-show">
                <?php if (trim($photo['description']) != ""): ?>
                    <div class="description">
                        <div class="col-xs-12">
                            <p class="text-comment"> 
                                <?php
                                if (strlen($photo['description']) <= 65) {
                                    echo "<span>" . $photo['description'] . "</span>";
                                } else {
                                    echo "<span class='comment-item-text default-show block'>" . trim(substr($photo['description'], 0, 65)) . "<span class='more' id='more-comment'> MORE...</span></span>";
                                    echo "<span class='comment-item-text default-hie'>" . $photo['description'] . "<span class='more' id='more-comment'> LESS</span></span>";
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                <?php endif; ?>
                <div>
                    <?php
                    $images_like = "";
                    $title_like = "Click here to like " . $photo["name"] . " ";
                    if ($photo["member_total"] != null) {
                        $images_like = "like";
                        $title_like = "Click here to unlike.";
                    }
                    ?> 
                    <div class="box-top <?php echo ( $photo["image_category"] == "Product" ||  $photo["image_category"] == "Projects,Products") ? "custom-columns" : "";?>">
                        <div class="col-xs-3 col-md-2 text-center"><div id="view-likes" class="likes"><p><span id="number-like"><?php echo ($photo["num_like"] != "") ? $photo["num_like"] : "0"; ?></span> Likes</p></div></div>
                        <div class="col-xs-2 col-md-2 text-center"></div>
                        <div class="col-xs-2 col-md-2 text-center"></div>
                        <?php echo ( $photo["image_category"] == "Product" ||  $photo["image_category"] == "Projects,Products") ? '<div class="col-xs-2 col-md-2 text-center remove-l-padding"></div>' : "";?>
                        <div class="col-xs-3 col-md-4 remove-l-padding"><p><span id="num-comment"><?php echo ($photo['num_comment'] != "") ? $photo['num_comment'] : "0"; ?></span> Comments</p></div>
                    </div>
                    <div class="conment-show <?php echo ($photo["num_comment"] > 0) ? "block" : ""; ?>">
                        <div class="col-xs-12">
                            <?php if (isset($photo['num_comment']) && $photo['num_comment'] > 2): ?>
                                <p class="view-more-comment" id="view-more" data-type="photo"><span class="glyphicon glyphicon-comment" aria-hidden="true"></span> View older comments…</p>
                            <?php endif; ?>
                            <div class="uesr-box-impromation" id="scrollbars-dw">
                                <div class="avatar">
                                    <?php if (isset($photo['last_comment']) && $photo['last_comment'] != null &&isset($photo['num_comment']) && $photo['num_comment'] > 0) { ?>
                                            <?php
                                            $value_comment = json_decode($photo['last_comment'],true);
                                            $logo_user = ( @$value_comment['avatar'] != "" && file_exists(FCPATH . @$value_comment['avatar']) ) ? base_url(@$value_comment['avatar']) : base_url("skins/images/signup.png");
                                            ?>
                                            <div class="row comment-items offset_default">
                                                <div class="col-xs-2 remove-padding"><a id="login-check" href="<?php echo base_url("profile/index/" . @$value_comment["member_id"]); ?>"><img src="<?php echo $logo_user; ?>" class="left"></a></div>
                                                <div class="col-xs-10 box-impromation">
                                                    <?php
                                                    $company_name = "";
                                                    if (@$value_comment['company_name'] != null && @$value_comment['company_name'] != "") {
                                                        $company_name = " | " . @$value_comment['company_name'];
                                                    }
                                                    ?>
                                                    <p><a id="login-check" href="<?php echo base_url("profile/index/" . @$value_comment["member_id"]); ?>"><strong><?php echo @$value_comment['first_name'] . " " . @$value_comment['last_name']; ?><?php echo $company_name; ?> | <?php echo @$value_comment["created_at"]; ?></strong></a></p>
                                                    <div>
                                                        <p class="text-comment" data-id="<?php echo @$value_comment['id']; ?>">
                                                            <?php
                                                            if (strlen(@$value_comment['comment']) <= 100) {
                                                                echo "<span>" . @$value_comment['comment'] . "</span>";
                                                            } else {
                                                                echo "<span class='comment-item-text default-show block'>" . substr(@$value_comment['comment'], 0, 100) . "<span class='more' id='more-comment'> MORE...</span></span>";
                                                                echo "<span class='comment-item-text default-hie'>" . @$value_comment['comment'] . "<span class='more' id='more-comment'> LESS</span></span>";
                                                            }
                                                            ?>
                                                        </p>
                                                        <?php if ($user_id == @$value_comment['member_id']) : ?>
                                                            <span class="action-comment">
                                                                <a data-id="<?php echo @$value_comment['id']; ?>" class="edit-comment" href="#"><i class="fa fa-pencil"></i></a>
                                                                <a data-id="<?php echo @$value_comment['id']; ?>" class="delete-comment" href="#"><i class="fa fa-times"></i></a>
                                                            </span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>  
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-bottom <?php echo ( $photo["image_category"] == "Product" ||  $photo["image_category"] == "Projects,Products") ? "custom-columns" : "";?>">
                        <div class="col-xs-3 col-md-2 text-center"><div class="likes" data-id="<?php echo $photo['company_name'] .'-'. $photo["id"] .'-'. $photo["manufacture"] . '-'. $photo["photo_id"];?>" ><h3 id="like-photo" data-id="<?php echo $photo["photo_id"];?>" ><i class="fa fa-heart <?php echo $images_like; ?>" title="<?php echo $title_like; ?>"></i></h3></div></div>
                        <div class="col-xs-2 col-md-2"><a id="myphoto_user" data-id="<?php echo $photo['company_name'] .'-'. $photo["id"] . '-'. $photo["photo_id"] .'-'. $photo["manufacture"];?>" title="View this catalog" href="<?php echo base_url('profile/myphoto/'.$photo['id']."?catalog=".$photo["manufacture"]);?>" title="Go to catalog"><img src="<?php echo skin_url("images/catalog.png")?>"/></a></div>
                        <div class="col-xs-2 col-md-2">
                            <a href="#" id="pins-to" data-id="<?php echo $photo['company_name'] .'-'. $photo["id"] .'-'. $photo["manufacture"] . '-'. $photo["photo_id"];?>" ><img src="<?php echo base_url("skins/images/pushpin-myphoto.png");?>"></a>
                        </div>
                        <?php echo ( $photo["image_category"] == "Product" ||  $photo["image_category"] == "Projects,Products") ? '<div class="col-xs-2 col-md-2 text-center remove-l-padding"> <a id ="login-check" href="'.base_url('profile/request_quote/'.$photo["photo_id"]).'" data-id="' .$photo['company_name'] ."-" .$photo["id"] . "-" .$photo["photo_id"] ."-" . $photo["manufacture"] .'" ><img src="'.base_url("skins/images/RFQ.png").'"></a> </div>' : "";?>
                        <div class="col-xs-3 col-md-4">
                            <div class="comment"  data-id="<?php echo $photo['company_name'] .'-'. $photo["id"] .'-'. $photo["manufacture"] . '-'. $photo["photo_id"];?>" >
                                <h3 id="comment-show"><span class="glyphicon glyphicon-comment" aria-hidden="true" title="Click here to comment."></span><input type="text" name="add-commemt-input" id="add-commemt-input" disabled ></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="card-info">
                        <div class="close_box">x</div>
                        <div class="box-input-comment">
                            <div class="relative">
                                <textarea id="content-comment" class="scroll-textarea"></textarea>
                                <div class="action text-right">
                                    <button  class="btn btn-gray clear button-singin" id="clear-text">Clear Text</button>
                                    <button class="sign-in btn btn-primary button-singin" id="add-comment" data-id="<?php echo $photo_id; ?>" data-parent="card-<?php echo $photo_id; ?>">Post Comment</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
<?php endif; ?>