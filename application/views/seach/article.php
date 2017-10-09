<?php if(isset($article)):
    $full_name = $article["first_name"]. " " . $article["last_name"];
    $company = "Editor/Content Writer";
    if($article["company_name"] != ""){
        $company.=" | ".$article["company_name"];
    }
    $avatar_article = ($article["avatar"] != "" && file_exists(FCPATH . $article["avatar"]) ) ? $article["avatar"] : "skins/images/signup.png";
?>
<div id ="card-article-<?php echo @$article["id"];?>" class = "card article" >
    <div class="card-wrapper" id ="wrapper-impormant-image">
        <div class="row">
            <div class="col-md-7">
                <div class="content-article">
                    <div class="title-article"><a href ="<?php echo base_url("article/post/".$article["id"]);?>"><h2><?php echo @$article["title"];?></h2></a></div>
                    <div class="owner-information">
                        <div class="avatar-owner">
                            <img src ="<?php echo base_url($avatar_article);?>"/>
                        </div>
                        <div class="information">
                            <div class="box-name"><a href ="<?php echo base_url("profile/index/".$article["member_id"]);?>"><h3><?php echo $full_name;?></h3></a></div>
                            <div class="box-company"><a href ="<?php echo base_url("profile/index/".$article["member_id"]);?>"><p><?php echo $company; ?></p></a></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="box-thumb-article">
                    <a href ="<?php echo base_url("article/post/".$article["id"]);?>"><img src = "<?php echo @$article["thumbnail"];?>"></a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif;?>