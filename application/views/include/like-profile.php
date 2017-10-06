<div id="box-like-profile">
    <?php
    $user = array();
    if ($this->session->userdata('user_info')) {
        $user = $this->session->userdata('user_info');
        $days = ['Monday' => 0, 'Tuesday' => 1, 'Wednesday' => 2, 'Thursday' => 3, 'Friday' => 4, 'Saturday' => 5, 'Sunday' => 6];
        $get_date = getdate();
        $month = $get_date["weekday"];
        $date_old  = date( "Y-m-d", strtotime( "".date('Y-m-d')." - ".$days[$month]." day" ));
        $number_view_photo = $this->Common_model->get_result_distinct($user["id"],"photo",$date_old,"createdat_photo_blog");
        $number_view_profile = $this->Common_model->get_result_distinct($user["id"],"profile",$date_old,"createdat_profile");
        $conversations = $this->Comment_model->get_conversation_comment($this->user_id,'photo', 2,0);
        if(isset($user["is_blog"]) && $user["is_blog"] == "yes"){
            $number_view_photo = $this->Common_model->get_result_distinct($user["id"],"blog",$date_old);
            $conversations = $this->Common_model->get_conversation_comment_blog($this->user_id,'blog', 2,0);
        }
    ?>
        <div class = "user box-bg-white box-ball">
            <div class = "row">
                <div class = "col-sm-3 text-center">
                    <div class = "avatar">
                        <?php
                        $avatar = ($user["avatar"] != "" && file_exists(FCPATH. $user["avatar"])) ? $user["avatar"] : "skins/images/avatar-full.png";
                        ?>
                        <img src="<?php echo base_url($avatar); ?>">
                    </div>
                </div>
                <div class="col-sm-9">
                    <h3 class="name"><?php echo $user["full_name"] ?></h3>
                    <p class="company-name"><?php echo $user["company_name"] ?></p>
                    <?php
                    if (isset($user["job_title"]) && $user["job_title"] != "") {
                        echo '<p class="job-title ">' . $user["job_title"] . '</p>';
                    } else {
                        echo '<a href="' . base_url('profile/edit') . '"><p class="number" >Update your job title</p></a>';
                    }
                    ?>

                </div>
            </div>
        </div>
        <?php
          $notification = $this->Common_model->get_result('notification',null,0,1,array(array('field' => 'id' , 'sort' => 'DESC')));
        ?>
        <?php if($notification != null):?>
        <div class="box-bg-white box-ball">
            <h4 class="number text-center"><?php echo @$notification[0]['title']; ?></h4>
            <div style="height:10px;"></div>
            <div class="row">
                <div class="col-sm-7">
                    <?php 
                        if(strlen($notification[0]['summary']) <= 151){
                            echo '<p>'.$notification[0]['summary'].'</p>';
                        }else{
                            echo '<p>'. trim(substr($notification[0]['summary'], 0, 151)).' <a href="#" style="color:#FF9900;">...MORE</a></p>';
                        }
                    ?> 
                </div>
                <div class="col-sm-5">
                    <?php
                        if($notification[0]['image'] != "" && file_exists(FCPATH . $notification[0]['image'])){
                            echo '<img src="'.base_url($notification[0]['image']).'"/>';
                        }
                    ?>
                </div>
            </div>
        </div>
        <?php endif;?>
        <?php if($user['type_member'] == "1"):?>
        <div class="box-bg-white box-ball">
            <div clas="row">
                <div class="col-sm-3 text-center">
                    <a class="btn-upload" href="<?php echo base_url() ?>profile/your_reports">
                        <img src="<?php echo base_url() ?>skins/images/reports.png">
                    </a>
                </div>
                <div class="col-sm-9">
                    <h4 class="number">View reports</h4>
                    <a href="<?php echo base_url() ?>profile/your_reports" class=" text-center btn btn-secondary browse">Reports</a>
                </div>
            </div>
        </div> 
        <?php endif;?> 
        <?php if ($number_view_profile > 0) : ?>
        <div class="box-bg-white box-ball">
            <div class="row">
                <div class="col-sm-3 text-center">
                    <h1 class="number"><?php echo $number_view_profile; ?></h1>
                </div>
                <div class="col-sm-9">
                    <p>People viewed your business profile in the last week.</p>
                </div>
            </div>
        </div>
    	<?php endif; ?>
    	<?php if ($number_view_photo > 0) : ?>
                <div class="box-bg-white box-ball">
                    <div class="row">
                        <div class="col-sm-3 text-center">
                            <h1 class="number"><?php echo $number_view_photo;?></h1>
                        </div>
                        <div class="col-sm-9">
                        <?php if($user["is_blog"] == "no"):?>
                            <p>Times people clicked on your posted photos in the last week.</p>
                        <?php else:?>
                            <p>Times people clicked on your posted articles in the last week.</p>
                        <?php endif?>
                        </div>
                    </div>
                </div>                 
        <?php endif; ?>
        <div class="box-bg-white box-ball">
            <div class="row">
            <?php if(isset($user["is_blog"]) && $user["is_blog"] == "no"):?>

                <div class="col-sm-3 text-center">
                    <a class="btn-upload" href="<?php echo base_url() ?>profile/addphotos">
                        <img src="<?php echo base_url() ?>skins/images/icon-upload.png">
                    </a>
                </div>
                <div class="col-sm-9">
                    <h4 class="number">Upload a Photo</h4>
                    <a href="<?php echo base_url() ?>profile/addphotos" class=" text-center btn btn-secondary browse">Browse</a>
                </div>
            <?php else:?>
                <div class="col-sm-3 text-center">
                    <a class="btn-upload" href="<?php echo base_url("article/add") ;?>">
                        <img src="<?php echo base_url("skins/images/icon_articles.png"); ?>">
                    </a>
                </div>
                <div class="col-sm-9">
                    <h4 class="number">Post a New Blog Article</h4>
                    <a href="<?php echo base_url("article/add") ;?>" class=" text-center btn btn-secondary browse">Get Started</a>
                </div>
            <?php endif;?>
            </div>
        </div>
        <?php if (isset($conversations) && count($conversations)): ?>
        <div class="conversations box-bg-white box-ball">
            <h4 class="number text-center">Your Conversations</h4>
            <div class="comment-conversations" id="scrollbars-dw">
                <?php foreach ($conversations AS $key => $value) : 
                    $avatar = ($value["avatar"] != "" && file_exists(FCPATH. $value["avatar"])) ? $value["avatar"] : "skins/images/avatar-full.png";
                    ?>
                    <div class="row item item-conversation-memember-bar">
                        <div class="col-sm-3 text-center">
                        	<?php if( $user["is_blog"] == "no"):?>
                            <a href="<?php echo base_url("photos/".$value["photo_id"]."/". gen_slug($value["name"])); ?>" style="display:block;">
                                <div class="square" style="background:url('<?php echo $value["thumb"]; ?>') no-repeat center center;background-size:cover;width:90px;height:100px;"></div>
                            </a>
	                        <?php else:?>
	                         <a href="<?php echo base_url("article/post/".$value["photo_id"]); ?>" style="display:block;">
                                <div class="square" style="background:url('<?php echo $value["thumb"]; ?>') no-repeat center center;background-size:cover;width:80px;height:80px;"></div>
                            </a>
	                        <?php endif;?>
                        </div>
                        <div class="col-sm-9">
                            <div class="avatar left">
                                <a class="avatar" href="<?php echo base_url('profile/index/'.$value["member_id"]) ?>">
                                    <img src="<?php echo base_url($avatar); ?>">
                                </a>
                            </div>
                            <div class="importation left">
                                <h6><strong><?php echo $value["first_name"] . " " . $value["last_name"]; ?></strong></h6>
                                <p><?php echo $value["company_name"]; ?> | <?php echo date('Y F d h:ia', strtotime($value["created_at"])); ?></p>                                  
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="text-comment"> 
                                        <?php
                                            if (strlen($value['comment']) <= 35) {
                                            echo "<span>" . $value['comment'] . "</span>";
                                        } else {
                                            echo "<span class='comment-item-text default-show block'>" . trim(substr($value['comment'], 0, 35)) . "<span class='more' id='more-comment'> MORE...</span></span>";
                                            echo "<span class='comment-item-text default-hie'>" . $value['comment'] . "<span class='more' id='more-comment'> LESS</span></span>";
                                        }
                                        ?>
                                    </p>
                                </div>
                                <div class="col-md-12">
                                    <div class="comment">
                                        <h3 id="comment-show"><span class="glyphicon glyphicon-comment" aria-hidden="true" title="Click here to comment."></span>
                                        	<?php if($user["is_blog"] == "no"):?>
                                        	    <a href="<?php echo base_url("photos/".$value["photo_id"]."/". gen_slug($value["name"])."?show_comment");?>" id="add-commemt-input"></a>
                                        	<?php else:?>
                                        		<a href="<?php echo base_url("article/post/".$value["photo_id"]."?show_comment");?>" id="add-commemt-input"></a>
                                        	<?php endif;?>
                                        </h3>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="more text-right"><a href="<?php echo base_url("profile/conversations");?>" style="text-transform: uppercase;">More</a></div>
        </div>
        <?php endif; ?>
    </div>
<?php } ?>