    <?php if(@$social != null)
        $images = ($social['thumb'] != "" && file_exists(FCPATH . $social['thumb']) ) ? $social['thumb'] : $social['path'];
        $id     = $social['id'];
        $avatar = ($social['avatar'] != "" && file_exists(FCPATH . $social['avatar'])) ? base_url($social['avatar']) : base_url("skins/images/signup.png"); 
        $full_name  = $social['first_name']. " ".$social['last_name'];
        if(@$view == 1) $images =  $social['path'];
        $social["content"] = make_links_blank($social["content"]);
        $social["content"] = preg_replace('/\r?\n|\r/','<br/>', $social["content"]);
        $social["content"] = str_replace(array("\r\n","\r","\n"),"<br/>", $social["content"]);
        $social["content"] = nl2br($social["content"]);
    ?>
   <?php $social_post = "";?>
    <div id="card-<?php echo $id; ?>" class="card social-card" data-id ="<?php echo $id; ?>" data-social="yes" data-type="social">
        <div class="card-wrapper" id ="wrapper-impormant-image" data-id = "<?php echo $id; ?>">
            <div class="card-image relative">
                <div class="top-social">
                    <div class="left-box">
                        <a class="avatar" href="<?php echo base_url("/profile/view/".$social['member_id']);?>">
                            <img src="<?php echo $avatar; ?>">
                        </a>
                    </div>
                    <div class="right-box">
                        <?php $arg = [$social['job_title'],'<a href="'.base_url("/company/view/".$social["member_id"]).'">'.$social['company_name'].'</a>']?>
                        <?php $arg = array_diff($arg,array(""));?>
                        <h6 class="full-name"><a href="<?php echo base_url("/profile/view/".$social['member_id']);?>"><strong><?php echo $full_name;?></strong></a></h6>
                        <p class="full-name"><strong><?php echo implode($arg," | ")?></strong></p>                  
                        <p class="full-name date"><?php echo date(DW_FORMAT_DATETIME, strtotime($social["created_at"]));?></p>                
                    </div>
                    <?php if(@$type == "my" && @$owner == true):?>
                        <div class="action">
                            <ul class="inline-bock">
                                <li><a title="Edit this social post" href="javascript:;" id="edit-socail-post" data-id="<?php echo $social['id']?>"><i class="fa fa-edit" aria-hidden="true"></i></a></li>
                                <li><a title="Delete this social post" href="javascript:;" id="delete-socail-post" data-id="<?php echo $social['id']?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a></li>                            
                            </ul>
                        </div>
                    <?php endif;?>
                </div>
                <div class="content-text">
                    <p><?php echo $social["content"]?></p>  
                </div>
                <?php if( trim($images)):?>
                    <div class="content-image"><a href="<?php echo base_url("socialposts/".$social["id"])?>"><img src="<?php echo base_url($images);?>"/></a></div>
                <?php endif;?>
            </div>
            <?php $likenew  = ($social["qty_like"] != "" && $social["qty_like"] != 0) ? "red-color" : ""; ?>
            <div class="commen-like" id="search-home-show">
                <div class="no-border box-top custom-columns">
                    <div class="col-xs-6"></div>
                    <div class="col-xs-2 text-center">
                        <div id="view-likes" class="likes">
                            <p><span id="number-like"><?php echo ($social["qty_like"]) ? $social["qty_like"] . " Likes" : "";?></span></p>
                        </div>
                    </div>
                    <div class="col-xs-2 text-center">
                        <p><span id="num-comment"><?php echo ($social["qty_comment"]) ? $social["qty_comment"]." Comments" : "" ;?></span></p>
                    </div>
                    <div class="col-xs-2 text-center"></div>
                </div>
                <div class="box-bottom custom-columns">
                    <div class="col-xs-6"></div>
                    <div class="col-xs-2 text-center">
                        <div class="likes" data-id="<?php echo $id;?>">
                            <?php 
                            $like_class = "";
                            if($social["is_like"] != null){
                                $title_like = "Click here to unlike";
                                $like_class = "like";
                            }else{
                                $title_like = "Click here to like";
                            }?>
                            <h3 id="like-photo" data-id="<?php echo $id;?>" data-object="social"><i class="fa fa-heart <?php echo $likenew ;?> <?php echo $like_class;?>" title="<?php echo $title_like;?>"></i></h3>
                        </div>
                    </div>
                    <div class="col-xs-2 text-center">
                        <div class="comment" data-id="<?php echo $id;?>">
                            <h3 id="comment-show"><span class="glyphicon glyphicon-comment" aria-hidden="true" title="Click here to comment."></span></h3>
                        </div>
                    </div>
                	<div class="col-xs-2 col-md-2 text-center"><div class="share" data-id="<?php echo $id;?>" ><h3 id="share-photo" data-id="<?php echo $id;?>" ><span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span></h3></div></div>
                </div>
            </div>
        </div>
    </div>
