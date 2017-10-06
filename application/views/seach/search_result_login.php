<?php
if (isset($photo) && count($photo) > 0):
    $count_photo = count($photo);
    $max_items_set = ceil($count_photo / 2);
    $user_id = -1;
    if ($this->session->userdata('user_info')) {
        $user_info = $this->session->userdata('user_info');
        $user_id = $user_info["id"];
    }
    $max_items = $max_items_set;
    $colum = 1;
    $items = 0;
    $location_article = rand(1,$max_items_set);
    $offset_article = 0;
    foreach ($photo as $value) {
        if ($max_items % $max_items_set == 0) {
            echo "<div class='col-md-6 grid-column' id='grid-column-" . $colum . "'>";
            $colum++;
            $items = 0;
        }
        $max_items++;
        $images = ($value['thumb'] != "" && file_exists(FCPATH . $value['thumb']) ) ? $value['thumb'] : $value['path_file'];
        $photo_id = $value['photo_id'];
        $items++;
        $this->load->view("seach/seach_result_ajax",array("photo" => $value));
            if(isset($article) && count($article) && isset( $article[$offset_article]) > 0 && $items == $location_article){
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
        ?>
        <?php
        if ($items == $max_items_set || ( ($max_items - $max_items_set) == $count_photo && $items < $max_items_set)) {
            echo "</div>";
            $location_article = rand(1,$max_items_set);
        }
    }
endif;
?>
