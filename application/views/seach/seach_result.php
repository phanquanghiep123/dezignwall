<?php
if (isset($photo) && count($photo) > 0) :
    $i = 0;
    $count_photo = count($photo);
    $index = $count_photo;
    $colum = 1;
    $item_per_column = floor($count_photo / 3);
    $root_item_per_column = $item_per_column;
    $surplus = $count_photo % 3;
    $step = 1;
    $current_photo = 0;
    $location_article = rand(1,$item_per_column);
    $offset_article = 0;
    foreach ($photo as $value) {
        $current_photo++;
        $item_per_column = $root_item_per_column;
        if ($surplus >= $colum) {
            $item_per_column = $item_per_column + 1;
        }
        if ($step == 1) {
            echo "<div class='col-md-4 grid-column' id='grid-column-" . $colum . "'>";
            $location_article = rand(1,$item_per_column);
            $location_social = rand(1,$item_per_column);
        }
        if($value["is_type_post"] == "photo"){
            $this->load->view("seach/seach_result_ajax",array("photo" => $value));
        }
        if( $value["is_type_post"] == "social" ){
            $this->load->view("seach/social-post",array("social" => $value));
        }
        if(isset($article) && count($article) && isset( $article[$offset_article]) > 0 && $step == $location_article){
            $full_name = $article[$offset_article]["first_name"]. " " . $article[$offset_article]["last_name"];
            $company = "Editor/Content Writer";
            if($article[$offset_article]["company_name"] != ""){
                $company.=" | ".$article[$offset_article]["company_name"];
            }
            $avatar_article = ($article[$offset_article]["avatar"] != "" && file_exists(FCPATH . $article[$offset_article]["avatar"]) ) ? $article[$offset_article]["avatar"] : "skins/images/signup.png";
            echo '<div id ="card-article-'.@$article[$offset_article]["id"].'" class = "card article" >
                    <div class="card-wrapper" id ="wrapper-impormant-image">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="content-article">
                                    <div class="title-article"><a href ="'.base_url("article/post/".$article[$offset_article]["id"]).'"><h2>'.@$article[$offset_article]["title"].'</h2></a></div>
                                    <div class="owner-information">
                                        <div class="avatar-owner">
                                            <img src ="'.base_url($avatar_article).'"/>
                                        </div>
                                        <div class="information">
                                            <div class="box-name"><a href ="'.base_url("profile/index/".$article[$offset_article]["member_id"]).'"><h3>'.$full_name.'</h3></a></div>
                                            <div class="box-company"><a href ="'.base_url("profile/index/".$article[$offset_article]["member_id"]).'"><p>'.$company.'</p></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="box-thumb-article">
                                    <a href ="'.base_url("article/post/".$article[$offset_article]["id"]).'"><img src = "'.@$article[$offset_article]["thumbnail"].'"></a>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>';
            $offset_article++;
        }
        if ($step >= $item_per_column) {
            echo "</div>";
            $step = 1;
            $colum++;
        } else {
            if ($current_photo >= $count_photo) {
                echo "</div>";
            } else {
                $step++;
            }
        }
    }
endif;