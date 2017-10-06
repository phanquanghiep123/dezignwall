<style>
.uesr-box-impromation {height:auto;}
.custom-columns .col-xs-2{
    width: 13.5%;
}
.wrapper-image .item  .view-story img{
	width: auto;
	height: auto;
	max-height: inherit;
    min-height: inherit;
    object-fit: inherit;
    padding-top: 0;
}
.print_pdf{
    position: absolute;
    right: 36%;
    bottom: 10px;
}
.print_pdf img{width: 40px;}
.dropdown-impromation > span.glyphicon-menu-hamburger{padding: 0;font-size: 24px;}
#wrapper-impormant-image .impromation{
    padding-right: 25px;
    z-index: 1;
    padding-top: 4px;
}
#wrapper-impormant-image .image-page .impromation-project .logo-company img {
    width: 50px;
    height: 50px;
}
.item-slider-same{width: 100%;float: left;position: relative;}
.item-slider-same .bx-wrapper .bx-viewport {
    -moz-box-shadow: 0 !important;
    -webkit-box-shadow: 0 !important;
    box-shadow: 0 0 0px #fff !important;
    border: 0 !important;
    left: 0;
    background: transparent !important;
}
.item-slider-same .bx-slider-catalog li img{
    width: 100%;
}
.item-slider-same .number-same-photo{right: 3px;top: 0;}
ul.list-all-catalog  {
    padding: 0; 
    margin: 0;
    max-height: 228px;
    overflow: auto;
}
.list-all-catalog li {width: 42%; list-style: none; float: left; margin-bottom: 10px;margin-right: 10px;}
.save-dw{position: absolute; right: 20px; bottom: 20px;}
.save-dw #save-photo-choose{padding:5px 20px;font-size: 24px ;text-transform: uppercase; color: #fff; border-radius: 0; border: 0;}
.save-dw .memu-save{position: absolute; top: -100%;right: 0;z-index: 99;}
.save-dw .memu-save li{ list-style: none; font-size: 14px;}
.save-dw .memu-save{
    width: 160px;
    position: relative;
    top: -100%;
    right: 0;
    background-color: #fff;
    padding: 10px;
    text-align: left;
    display: none;
}
.save-dw .memu-save li a{color:#212121;}

.memu-save-top{position: absolute; top: -100%;right: 0;z-index: 99;}
.memu-save-top li{ list-style: none; font-size: 14px;}
.memu-save-top{
    width: 170px;
    position: relative;
    top: -100%;
    right: 0;
    background-color: #fff;
    padding: 10px;
    text-align: left;
    display: none;
}
.memu-save-top li a{color:#212121;}
body .image-page .colum-right .value-text{color: #545454;}
body .image-page .colum-right .value-text a{ color: #37a7a7; }
body .image-page .dropdown-impromation{
    left: auto;
}
.dropdown-data{
    background-color: rgba(255, 255, 255, 0.81);
    padding: 5px 20px 5px 5px;
    list-style: none;
    border-radius: 5px;
    text-align: left;

}
body .image-page .dropdown-impromation .dropdown-impromation-menu{
    padding: 0;
    background-color:transparent;
}
.show-mobile{display: none;}
.bx-wrapper{margin: inherit !important; }
body .image-page .bx-wrapper .bx-controls-direction a{top: 45% !important}
body .image-page  .dropdown-impromation .dropdown-impromation-menu{position: relative;}
@media screen and (max-width: 768px){
    body .image-page .bx-wrapper .bx-controls-direction a{top: 40%;}
    .view-all-comment{width: 100%;}
    .image-page .colum-left,.image-page .colum-right{padding: 0 10px;}
    .structural-block .commen-like{float: inherit;}
    .image-page .impromation-project .impromation p {
        width: 75%;
    }
    body .image-page .dropdown-impromation{
        left: auto;
        top: 10px;
        right: 20px;
    }
    .box-warpper-images,.wrapper-image .item{height: auto !important;}
    body .image-page .colum-right .checkbox{padding-left: 20px;}
    .save-dw #save-photo-choose {
        font-size: 15px;
    }
    .show-mobile{display: inline;}
}
@media screen and (max-width: 350px){
    .image-page .impromation-project .impromation p {
        width: 71%;
    }
}
</style>
<?php if (isset($photo)): 
    $company = $this->Common_model->get_record("company",array("member_id" =>$photo["member_id"]));
    $catalog = $this->Common_model->get_record("manufacturers",array("id" => $photo["manufacture"]));
    $categorys = $photo["category"];
    $categorys = explode("/", $categorys);
    $datacate = null;
    $categorys = array_diff($categorys,array(""));
    if($categorys != null){
        $this->db->select("title");
        $this->db->from("categories");
        $this->db->where_in("id",$categorys);
        $query = $this->db->get();
        $datacate = $query->result_array();
    }
    $data_ct_new = null;
    if($datacate != null){
        foreach ($datacate as $key => $value) {
            $data_ct_new [] =  $value["title"];
        }
    } 
    if($data_ct_new != null)
        $categorys = implode(", ", $data_ct_new);


?>
    <script type="text/javascript">
        dataLayer = [{
            mid :"<?php echo @$photo["member_id"];?>",
            transactionCompanyID:"<?php echo @$company["id"];?>",
            transactionCompanyName:"<?php echo @$company["company_name"];?>",
            transactionCompanyCatalog:"<?php echo @$catalog["company_name"];?>",
            transactionManufacturer:"<?php echo @$catalog["name"];?>",
            transactionProducts :[{
                sku : null,
                name :"<?php echo @$photo["name"] ?>",
                category :"<?php echo @$categorys;?>",
                price:"<?php echo  @$point[0]["one_off"]; ?>",
                quantity:"<?php echo @$point[0]["max_qty"]; ?>",

            }],
            pageurl:"<?php echo urlencode (base_url(uri_string()));?>"
        }];
    </script>
    <link href="<?php echo skin_url(); ?>/css/upload.css" rel="stylesheet">
    <div class="container box-public box-lg box-bg-gray">
        <div class="row">
            <div class="col-md-8 colum-left">
                <div id="wrapper-impormant-image" data-id ="<?php echo $photo["photo_id"]; ?>">
                    <div class="relative box-warpper-images">
                        <div class="wrapper-image">
                            <div class="item relative wrap-cropper">
                                <?php
                                $images =   $photo['path_file'];
                                $file = urlencode (base_url($images));
                                $file_headers = @get_headers($file);
                                if($file_headers[0] === 'HTTP/1.1 404 Not Found') {
                                    $images = "skins/images/no-photo.png";
                                }
                                $size_new = @getimagesize('.' . @$images);
                                ?>
                                <div class="relative" style="text-align: center;">
                                    <img class="photo-detail" title="<?php echo @$photo["name"];?>" data-w="<?php echo @$size_new[0]; ?>" data-h="<?php echo @$size_new[1]; ?>" src="<?php echo base_url($images); ?>">
                                    <div class="save-dw">
                                        <ul class="memu-save">
                                            <li style="list-style: none;"><a class="not-report download_photo" data-id="<?php echo $company["company_name"] .'-'. $photo["member_id"] .'-'. $photo["manufacture"] . '-'. $photo["photo_id"];?>"  data-reload ="<?php echo base_url(uri_string());?>?download_photo=true" id="login-check" href="<?php echo base_url($images);?>" download><span class="show-mobile">> </span>Save as jpeg...</a></li>
                                            <li style="list-style: none;"><a class="not-report" data-id="<?php echo $company["company_name"] .'-'. $photo["member_id"] .'-'. $photo["manufacture"] . '-'. $photo["photo_id"];?>"  id="login-check" href="<?php echo base_url("photos/download_pdf/". $photo["photo_id"]);?>"><span class="show-mobile">> </span>SAVE / Print PDF...</a></li>
                                            <li style="list-style: none;"><a id="pins-to" data-id="<?php echo $company["company_name"] .'-'. $photo["member_id"] .'-'. $photo["manufacture"] . '-'. $photo["photo_id"];?>"  class="upgrade-account-link not-report" href="#"><span class="show-mobile">> </span>Pin to Wall...</a></li>
                                        </ul>
                                        <button id="save-photo-choose" class="sign-in btn btn-primary button-signin right">Save</button>
                                    </div>
                                    <?php if($photo["is_story"] == "1"){?>
                                        <div class="view-story"><img src="<?php echo base_url("skins/images/story-icon.png");?>"></div>
                                    <?php }?>
                                </div>                       
                            </div>
                            <?php $album = json_decode($photo["album"],true);?>
                            <?php if($album  != null){?>
                                <div class="list-album">
                                   <div class="header-list-album">
                                       <ul class="list-more-view">
                                            <li>More views</li>
                                            <li id="show-album" class=""><p class="text-right"><img src="<?php echo base_url("skins/images/more-view.png");?>"></p></li>
                                        </ul>
                                    </div>
                                    <ul id="scrollbars-dw">

                                        <?php 
                                            echo '<li><a href="'.base_url("photos/".$photo["photo_id"]."/".gen_slug($photo["name"])).'"><img title="'.$photo["name"].'" src="'.base_url($photo["thumb"]).'"></a></li>';
                                            foreach($album as $key_album => $value_album) {
                                                echo '<li><a href="'.base_url("photos/".$photo["photo_id"]."/".gen_slug($photo["name"])."?number=".base64_encode($key_album)).'"><img title="'.$value_album["title"].'" src="'.base_url($value_album["path"]).'"></a></li>';
                                            }
                                        ?>
                                    </ul>   
                                </div>
                            <?php }?>
                            
                        </div>
                        <div class="impromation-project">
                            <div class="dropdown-impromation relative">
                                <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>
                                <div class="dropdown-impromation-menu">
                                    <ul class="dropdown-data">
                                        <li style="list-style: none;"><a href="<?php echo base_url("profile/index/" . $user["id"]); ?>" class="not-report" data-title ="<?php echo $photo["name"]; ?>" data-type ="image" data-id ="<?php echo $photo["photo_id"]; ?>">Company profile...</a></li>
                                        <li style="list-style: none;"><a href="#" class="not-report" onclick="$('.memu-save-top').toggleClass('block');return false;" data-title ="<?php echo $photo["name"]; ?>" data-type ="image" data-id ="<?php echo $photo["photo_id"]; ?>"> Save this item...</a></li>
                                        <?php if($photo['image_category'] == "Product"):?><li style="list-style: none;"><a class="upgrade-account-link not-report" id ="login-check" href="<?php echo base_url("profile/request_quote/".$photo["photo_id"]);?>" name="RFQ" data-title ="<?php echo $photo["name"]; ?>" data-type ="image" data-id ="<?php echo $photo["photo_id"]; ?>">Request a Quote...</a></li><?php endif;?>
                                        <li style="list-style: none;"><a href="#" class="not-report" id="report-image" data-title ="<?php echo $photo["name"]; ?>" data-type ="image" data-id ="<?php echo $photo["photo_id"]; ?>">Report this image...</a></li>
                                    </ul>
                                    <ul class="memu-save-top">
                                        <li style="list-style: none;"><a data-id="<?php echo $company["company_name"] .'-'. $photo["member_id"] .'-'. $photo["manufacture"] . '-'. $photo["photo_id"];?>" id="login-check" data-reload ="<?php echo base_url(uri_string());?>?download_photo=true" class="not-report" href="<?php echo base_url($images);?>" download><span class="show-mobile">> </span>Save as jpeg...</a></li>
                                        <li style="list-style: none;"><a id="login-check" class="not-report" href="<?php echo base_url("photos/download_pdf/". $photo["photo_id"]);?>"><span class="show-mobile">> </span>SAVE / Print PDF...</a></li>
                                        <li style="list-style: none;"><a id="pins-to" class="upgrade-account-link not-report" href="#"><span class="show-mobile">> </span>Pin to Wall...</a></li>
                                    </ul>
                                </div>
                            </div>
                            <?php $record_type = 1; ?>
                            <?php if ($record_type != 0): ?>
                                <?php $logo = ( $user["logo"] != "" && file_exists(FCPATH . "/" . $user["logo"]) ) ? base_url($user["logo"]) : skin_url("images/logo-company.png"); ?>
                                <div class="logo-company"><a id="login-check" href="<?php echo base_url("profile/index/" . $user["id"]); ?>"><img src="<?php echo $logo; ?>"></a></div>
                                <div class="impromation">
                                    <h1 class="photo-name"><a id="login-check" href="<?php echo base_url("profile/index/" . $user["id"]); ?>"><?php echo $company["company_name"]; ?></a></h1>
                                    <p><?php echo $company["business_type"] ?> | <?php echo $company["business_description"]?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="commen-like">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="row">
                                        <div class="custom-columns">
                                            <?php
                                            $images_like = "";
                                            $title_like = "Click here to like.";
                                            if (count($user_total_like) == 0) {
                                                $images_like = "";
                                            } else {
                                                if ($user_total_like["status"] != 0) {

                                                    $images_like = " like";
                                                    $title_like = "Click here to unlike.";
                                                }
                                            }
                                            ?>
                                            <div class="col-xs-2 remove-padding text-center"><div class="likes"><p><span id="number-like"><?php echo count(@$like); ?></span> Like(s)</p><h3  id="like-photo" data-id ="<?php echo $photo["photo_id"]; ?>"><i class="fa fa-heart<?php echo $images_like; ?>" title="<?php echo $title_like; ?>"></i></h3></div></div>
                                            <div class="col-xs-2 remove-padding text-center">
                                                <div class="microsite">
                                                    <p style="height:15px"></p>
                                                    <a id="goto-microsite" title="Go to microsite." href="<?php echo base_url("profile/index/" . $user["id"]); ?>"><img src="<?php echo base_url("skins/images/i-white.png");?>"></a>
                                                </div>
                                            </div>
                                            <div class="col-xs-2 remove-padding text-center"><p style="height:15px"></p><a id="myphoto_user" href="<?php echo base_url("profile/myphoto/" . $user["id"]."?catalog=".$photo["manufacture"]);?>"><img src="<?php echo skin_url("images/catalog-white.png")?>"></a></div>
                                            <?php if ($photo['type'] == 2) : ?>
                                                <div class="col-xs-2 remove-padding text-center"><p><span id="num-pin"><?php echo $record_pin; ?></span> Pins</p><h3 id="pins-to" title="Click here to Save to DEZIGNWALL."><i class="fa fa-thumb-tack"></i></div>
                                                <div class="col-xs-2 remove-padding text-center"><p style="height:15px"></p><h3 id="share-social" title="Click here to share image." data-title ="<?php echo $photo["name"]; ?>" data-type ="image" data-id ="<?php echo $photo["photo_id"]; ?>"><i class="fa fa-share-alt"></i></h3></div>
                                                <?php if($photo['image_category'] == "Product"){
                                                    echo '<div class="col-xs-2 remove-padding text-center"><p style="height:15px"></p><h3 title="Click here to RFQ of image."><a id ="login-check" href="'.base_url("profile/request_quote/".$photo["photo_id"]).'" name="RFQ"><img src="'.skin_url("images/RFQ-white.png").'"></a></h3></div> ';
                                                }?>
                                                <div class="col-xs-2 remove-padding text-center"><p style="height:15px"></p><h3 id="share-image-email" title="Click here to share image."><i class="fa fa-envelope"></i></h3></div> 
                                            <?php endif; ?>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5 remove-padding sm-padding text-sm-center">
                                    <p class="text-sm-left"><span id="num-comment"><?php echo @$comment; ?></span> Comment(s)</p>
                                    <div class="comment" data-id="<?php echo $company["company_name"] .'-'. $photo["member_id"] .'-'. $photo["manufacture"] . '-'. $photo["photo_id"];?>">
                                        <h3 id="view-all-comment">
                                            <span class="glyphicon glyphicon-comment" aria-hidden="true" title="Click here to comment."></span>
                                            <input type="text" name="comment" id="comment-input" class="left form-control" placeholder="Comment">
                                        </h3>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                    <!-- Section for comment -->
                    <div class="commen-like" id="search-home-show">
                        <div class="conment-show <?php echo ($comment > 0) ? "block" : ""; ?>">
                            <div class="col-xs-12">
                                <div class="uesr-box-impromation" id="scrollbars-dw">
                                    <div class="avatar">
                                        <table id="list-table-comment" data-id="<?php echo $photo["photo_id"]; ?>">
                                            <thead>
                                                <tr>
                                                    <td class="left-td">&nbsp;</td>
                                                    <td class="right-td">
                                                        <div class="likes-header-box"><p><span id="number-like"><?php echo count(@$like); ?></span> Like(s)</p></div>
                                                        <div class="comments-header-box"><p><span id="num-comment"><?php echo @$comment; ?></span> Comment(s)</p></div>
                                                    </td>
                                                    <td class="right-extra-td" align="right">
                                                        <?php if ($comment > 3) : ?>
                                                            <p class="view-more-comment" id="view-more-detail" data-type="photo"><span class="glyphicon glyphicon-comment" aria-hidden="true"></span> View older comments…</p>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if ($comment > 0) {
                                                    $value_comment = $record_comment;
                                                    $total_comment = count($record_comment);
                                                    for ($i = $total_comment; $i > 0; $i--) {
                                                        $logo_user = ( $value_comment[($i - 1)]['avatar'] != "" && file_exists(FCPATH . $value_comment[($i - 1)]['avatar']) ) ? base_url($value_comment[($i - 1)]['avatar']) : base_url("skins/images/signup.png");
                                                        ?>
                                                        <tr class="comment-items single-page-comment offset_default">
                                                            <td class="left-td"><img src="<?php echo $logo_user; ?>" class="left"></td>
                                                            <td class="right-td" colspan="2">
                                                                <?php
                                                                $company_name = "";
                                                                if ($value_comment[($i - 1)]['company_name'] != null && $value_comment[($i - 1)]['company_name'] != "") {
                                                                    $company_name = " | " . $value_comment[($i - 1)]['company_name'];
                                                                }
                                                                ?>
                                                                <p><a id="login-check" href="<?php echo base_url("profile/index/" . $value_comment[($i - 1)]["member_id"]); ?>"><strong><?php echo $value_comment[($i - 1)]['first_name'] . " " . $value_comment[($i - 1)]['last_name']; ?><?php echo $company_name; ?> | <?php echo $value_comment[($i - 1)]['created_at']; ?></strong></a></p>
                                                                <div>
                                                                    <p class="text-comment" data-id="<?php echo @$value_comment[($i - 1)]['id']; ?>">
                                                                        <?php
                                                                        if (strlen($value_comment[($i - 1)]['comment']) <= 210) {
                                                                            echo "<span>" . $value_comment[($i - 1)]['comment'] . "</span>";
                                                                        } else {
                                                                            echo "<span class='comment-item-text default-show block'>" . substr($value_comment[($i - 1)]['comment'], 0, 200) . "<span class='more' id='more-comment'> MORE...</span></span>";
                                                                            echo "<span class='comment-item-text default-hide'>" . $value_comment[($i - 1)]['comment'] . "<span class='more' id='more-comment'> LESS</span></span>";
                                                                        }
                                                                        ?>
                                                                    </p>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 colum-right">
                <div class="info-inmage">
                    <h3><strong><?php echo (@$photo["name"] == null || trim($photo["name"]) == "") ? "photo" : $photo["name"];?></strong><span> - <?php echo @count($album);?></span></h3>
                    <div class="breadcrumb"><p class="lable-text"><a href="<?php echo base_url();?>">Home</a> / <a href="<?php echo base_url("search");?>">Search</a> / <a href="<?php echo base_url("search/?keyword=".$photo["name"]);?>"> <?php echo $photo["name"];?></a></p></div>
                    <p class="lable-text"><?php echo @$photo["description"];?></p>
                    <div class="box-data custom">  
                        <div class="checkbox check-yelow checkbox-circle">                  
                            <p style="padding-top: 3px;"><img style=" margin: -5px 10px 0px 0px; " src="<?php echo base_url('skins/images/check_allow.png')?>"><?php echo ($photo['image_category'] == "Product")? "Product from" : "Project from"?> <a id="login-check" href="<?php echo base_url("search?catalog=".$photo["manufacture"]."");?>"><?php echo @$manufacturers["name"];?></a> by <a href="<?php echo base_url("profile/index/".$photo["member_id"]);?>"><?php echo $company["company_name"];?></a></p>
                        </div>
                        <div class="row">
                            <div class="col-md-6"><p class="lable-text">Product is available in:</p></div>
                            <div class="col-md-6"><p class="value-text"><a href="<?php echo base_url("search?offer_product=".$photo["offer_product"]);?>"><?php echo $photo["offer_product"];?></a></p></div>
                            <div class="col-md-6"><p class="lable-text">Single unit price is:</p></div>
                            <div class="col-md-6"><p class="value-text"><?php echo ($photo["unit_price"] != null) ? "<a href='".base_url("profile/request_quote/".$photo["photo_id"])."'>$".$photo["unit_price"]."</a>" : "" ;?></p></div>
                            <div class="col-md-6"><p class="lable-text">Max sample quantity is:</p></div>
                            <div class="col-md-6"><p class="value-text"><?php echo ($photo["maximum_price"] != null) ? $photo["maximum_price"] : "" ;?></p></div>
                            <div class="col-md-6"><p class="lable-text">Product is for:</p></div>
                            <div class="col-md-6"><p class="value-text"><?php echo @$indoor_outdoor;?></p></div>
                            <div class="col-md-6"><p class="lable-text">Style:</p></div>
                            <div class="col-md-6"><p class="value-text"><?php echo @$styles; ?></p></div>
                            <div class="col-md-6"><p class="lable-text">Category:</p></div>
                            <div class="col-md-6"><p class="value-text"><?php echo @$category?></p></div>
                            <div class="col-md-6"><p class="lable-text">Location:</p></div>
                            <div class="col-md-6"><p class="value-text"><?php echo @$localtion?></p></div>
                            <div class="col-md-6"><p class="lable-text">Certifications:</p></div>
                            <div class="col-md-6"><p class="value-text"><?php echo @$certifications;?></p></div>
                        </div>
                        <hr/>
                    </div>
                    <?php
                        if(@$photo["height"] != null || @$photo["width"] != null || @$photo["depth_proj"] != null || @$photo["weight_lbs"] != null ):
                    ?>
                    <div class="box-data custom">
                        <h4>Product Dimensions:</h4>                      
                        <div class="row">
                            <?php if(@$photo["height"] != null):?>
                                <div class="col-xs-8 col-md-6"><p class="lable-text">Height:</p></div>
                                <div class="col-xs-4 col-md-6"><p class="value-text bold"><?php echo str_replace('\"','"',$photo["height"]);?></p></div>
                            <?php endif;?>
                            <?php if(@$photo["width"] != null):?>
                                <div class="col-xs-8 col-md-6"><p class="lable-text">Width:</p></div>
                                <div class="col-xs-4 col-md-6"><p class="value-text bold"><?php echo str_replace('\"','"',$photo["width"]);?></p></div>
                            <?php endif;?>
                            <?php if(@$photo["depth_proj"] != null):?>
                                <div class="col-xs-8 col-md-6"><p class="lable-text">Depth/Projection:</p></div>
                                <div class="col-xs-4 col-md-6"><p class="value-text bold"><?php echo str_replace('\"','"',$photo["depth_proj"]);?></p></div>
                            <?php endif;?>
                            <?php if(@$photo["weight_lbs"] != null):?>
                                <div class="col-xs-8 col-md-6"><p class="lable-text">Weight:</p></div>
                                <div class="col-xs-4 col-md-6"><p class="value-text bold"><?php echo str_replace('\"','"',$photo["weight_lbs"]);?></p></div>    
                            <?php endif;?>
                        </div>
                        <hr/>
                    </div>
                    <?php endif;?>
                    <?php
                        $count_photo_catalog = count(@$photo_catalog);
                        if($count_photo_catalog > 0):
                    ?>
                    <div class="box-data custom">
                        <h4>More Images in this <a id="login-check" href="<?php echo base_url("profile/myphoto/".$photo["member_id"]."?catalog=".$photo["manufacture"]."");?>"><?php echo (@$manufacturers["name"] != null && trim(@$manufacturers["name"])) ? @$manufacturers["name"] : "Catalog default"; ?></a></h4>                      
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="item-slider-same">
                                <?php
                                    echo '<ul class="bx-slider-catalog">';
                                        foreach ($photo_catalog as $key_photo_catalog => $value_photo_catalog) {
                                            $images_same = ($value_photo_catalog['thumb'] != "" && file_exists(FCPATH . $value_photo_catalog['thumb']) ) ? $value_photo_catalog['thumb'] : $value_photo_catalog['path_file'];
                                            echo '<li><a href ="'.base_url("photos/" . $value_photo_catalog['photo_id'] . "/" . gen_slug($value_photo_catalog["name"])).'"><img src="'.base_url($images_same).'"></a></li>';
                                        }
                                    echo "</ul>";
                                    echo ($photo_count_catalog > 3) ? '<div class="number-same-photo"><p><a id="login-check" href="'.base_url("profile/myphoto/".$photo["member_id"]."?catalog=".$photo["manufacture"]."").'"><span>+'.($photo_count_catalog - 3).'</span></a></p></div>' : "" ;
                                ?>
                                </div> 
                            </div>
                        </div>
                        <hr/>
                    </div>
                    <?php endif;?>
                    <div class="box-data custom">
                        <h4>Search Tags:</h4>                      
                        <div class="row">
                            <div class="col-md-12">
                                <div>
                                    <?php
                                    $text_keyword = "";
                                    if (isset($keyword) && is_array($keyword)) {
                                        foreach ($keyword as $key => $value) {
                                            if ($value["title"] != "") {
                                                $text_keyword.="<a href='". base_url("search?keyword=". trim($value["title"])). "'>" . $value["title"] . "</a>, ";
                                            }
                                        }
                                        $text_keyword = substr($text_keyword, 0, -2);
                                    }
                                    ?>
                                    <p>
                                        <?php echo $text_keyword; ?>
                                    </p>
                                </div>
                            </div>  
                        </div>
                        <hr/>
                    </div>
                    <?php if(count(@$all_catalog) > 0):?>
                    <div class="box-data custom">
                        <h4>More Catalogs:</h4>                      
                        <div class="row">
                            <div class="col-md-12">
                                <?php
                                    echo '<ul class="list-all-catalog">';
                                        foreach ($all_catalog as $key_all_catalog => $value_all_catalog) {
                                            if($value_all_catalog['logo'] != "" && file_exists(FCPATH . $value_all_catalog['logo']) ) 
                                                echo '<li><a id="login-check" href="'.base_url("profile/myphoto/".$photo["member_id"]."?catalog=".$value_all_catalog["id"]."").'"><img src="'.base_url($value_all_catalog['logo']).'"></a></li>';
                                        }
                                    echo "</ul>";   
                                ?>
                            </div>  
                        </div>
                        <hr/>
                    </div>
                    <?php endif;?>
                    <?php if($photo_kw_like_count > 0):?>
                    <div class="box-data custom">
                        <h4>More products like this:</h4>                      
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="item-slider-same">
                                <?php
                                    echo '<ul class="bx-slider-catalog">';
                                        foreach ($photo_kw_like as $key_photo_catalog => $value_photo_catalog) {
                                            $images_same = ($value_photo_catalog['thumb'] != "" && file_exists(FCPATH . $value_photo_catalog['thumb']) ) ? $value_photo_catalog['thumb'] : $value_photo_catalog['path_file'];
                                            echo '<li><a href ="'.base_url("photos/" . $value_photo_catalog['photo_id'] . "/" . gen_slug($value_photo_catalog["name"])).'"><img src="'.base_url($images_same).'"></a></li>';
                                        }
                                    echo "</ul>";
                                    echo ($photo_kw_like_count > 3) ? '<div class="number-same-photo"><p><a id="login-check" href="'.base_url("profile/myphoto/".$photo["member_id"]."?keyword_photo=".$photo["keywords"]."").'"><span>+'.($photo_kw_like_count - 3).'</span></a></p></div>' : "" ;
                                ?>
                                </div> 
                            </div>
                        </div>
                    </div>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view("include/share"); ?>
    <?php $this->load->view("include/report-images"); ?>
    <?php $this->load->view("include/view-comment"); ?>
    <script type="text/javascript">

        $(document).ready(function () {
            var height_header = $("#header").height();
            var height_footer = $("#footer").height();
            var height_bar = $(".commen-like").height();
            var height_screen = $(window).height();
            var max_height = (height_screen+height_bar) - ((height_header * 2) + (height_footer * 2));
            var box_img = (height_screen + height_bar) - ((height_header * 2) + (height_footer * 2));
            $(document).on({
                mouseenter: function () {
                    $(this).css('z-index', 1000);
                },
                mouseleave: function () {
                    $(this).css('z-index', 100);
                }
            }, '#point');

            $(document).on('click', '#point .newImageTagIcon', function () {
                $(this).parents('#point').addClass('show');
                $(this).parents('#point').find('.box-point-view').addClass('show');
                return false;
            });

            $(document).on('click', '#point .close-box', function () {
                $(this).parents('#point').removeClass('show');
                $(this).parents('.box-point-view').removeClass('show');
                return false;
            });
        });
         $(window).load(function () {
            var wrap_w = $('.wrap-cropper').width();
            var wrap_h = $('.wrap-cropper').height();
            var image_w_d = parseInt($(".wrap-cropper .photo-detail").attr('data-w'));
            var image_h_d = parseInt($(".wrap-cropper .photo-detail").attr('data-h'));
            var image_w = parseInt($(".wrap-cropper .photo-detail").width());
            var image_h = parseInt($(".wrap-cropper .photo-detail").height());
            var scell_w   = image_w/image_w_d;
            var scell_h   = image_h/image_h_d;
            var center_w = (wrap_w - image_w) / 2;
            var center_h = (wrap_h - image_h) / 2;
            var tag = $.parseJSON('<?php echo json_encode(@$point); ?>');
            //var ratio_w=parseFloat($(".wrap-cropper").width()/image_w);
            //var ratio_h=parseFloat($(".wrap-cropper").height()/image_h);
            if (tag.length > 0) {
                var point = '';
                for (var i = 0; i < tag.length; i++) {
                    var html = '<div class="box-point-view">';
                    html += '    <span class="close-box"><i class="fa fa-times"></i></span>';
                    html += '    <div class="row">';
                    html += '        <div class="col-sm-7 sm-remove-padding-right">';
                    html += '          <p class="text-left">Product available in:</p>';
                    html += '      </div>';
                    html += '        <div class="col-sm-5 sm-remove-padding-left">';
                    html += '          <p class="text-left">' + tag[i]['product_in'] + '</p>';
                    html += '      </div>';
                    html += '    </div>';
                    if (tag[i]['one_off'] != 0 && tag[i]['max_qty'] != 0) {
                        html += '    <div class="row">';
                        html += '        <div class="col-sm-7 sm-remove-padding-right">';
                        html += '          <p class="text-left">One-off pricing:</p>';
                        html += '      </div>';
                        html += '        <div class="col-sm-5 sm-remove-padding-left">';
                        html += '          <p class="text-left">$' + tag[i]['one_off'] + '</p>';
                        html += '      </div>';
                        html += '    </div>';

                        html += '    <div class="row">';
                        html += '        <div class="col-sm-7 sm-remove-padding-right">';
                        html += '          <p class="text-left">Maximum Sample Qty:</p>';
                        html += '      </div>';
                        html += '        <div class="col-sm-5 sm-remove-padding-left">';
                        html += '          <p class="text-left">' + tag[i]['max_qty'] + '</p>';
                        html += '      </div>';
                        html += '    </div>';
                    } else {
                        html += '<p>Sample pricing does not apply</p>';
                    }
                    html += '      <p class="text-right" style="margin-right:20px;"><a style="border-radius: 6px;" href="<?php echo base_url(); ?>profile/request_quote/<?php echo @$photo["photo_id"] ?>/' + tag[i]['id'] + '" class="btn btn-custom btn-primary">Request a quote</a></p>';
                    html += '   </div>';
                    point += '<div id="point" data-on="on" data-rol="tag-' + i + '" class="point-' + i + ' ui-draggable ui-draggable-handle" style="top: ' + (parseFloat(tag[i]['top'] * scell_w) + center_h) + 'px; left: ' + (parseFloat(tag[i]['left'] * scell_h) + center_w) + 'px;">' + html + '<a><span id="lbImageTags"><i class="newImageTagIcon animate"></i></span></a></div>';
                }
                $('.wrap-cropper').append(point);
            }
        });
    </script>
<?php endif; ?>
<?php if (isset($_GET["show_comment"])): ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $('html,body').animate({scrollTop: $("#list-table-comment").offset().top},'slow');

        });

    </script>
<?php endif; ?>
<script type="text/javascript">
    $(document).on("click", ".impromation-project .glyphicon-menu-hamburger", function () {
        $(this).parents(".impromation-project").find(".dropdown-impromation-menu").toggleClass("block");
        return false;
    });
    $(document).on("click","li#show-album",function(){
        if($(this).hasClass("open") == true){
            $("#wrapper-impormant-image .list-album").animate({"left": '-125px'},"slow");
            $(this).removeClass("open");
        }else{
             $("#wrapper-impormant-image .list-album").animate({"left": '0'},"slow");
            $(this).addClass("open");
        }
    });
</script>

<script type="text/javascript">
var width_box = $(".item-slider-same").width();
$(".item-slider-same .bx-slider-catalog li img").css("height",((width_box/4) - 4)+"px");
$(".item-slider-same .number-same-photo").css({"width":((width_box/4) - 4)+"px","height":((width_box/4) - 4)+"px"});
$(".item-slider-same .bx-slider-catalog").bxSlider({
    auto: false,
    minSlides: 1,
    maxSlides:4,
    slideMargin: 0,
    pager:false,
    slideWidth:(width_box/4) - 4,
    slideMargin:4,
    moveSlides:1,
    infiniteLoop:false,
    onSliderLoad:function(e){
        $(".item-slider-same .bx-slider-catalog").css({"visibility":"visible","max-height":"auto"});
    },
});
$(document).ready(function(){
    $("#save-photo-choose").click(function(){
        $(".save-dw .memu-save").toggleClass("block");
    });
    <?php if($this->input->get("download_photo") == "true"){ ?>
        $("li a.download_photo")[0].click();
    <?php } ?>
});        

</script>