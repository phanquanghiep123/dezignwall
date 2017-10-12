<div class="modal fade" id="share-modal" tabindex="-1" role="dialog" aria-labelledby="modal-label" style="display: none;">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content" style="padding: 20px;border-radius: 0;">
            <button style="position: relative;top: -5px;" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <p class="text-center"><img id="photo-share" src="<?php echo @$member['banner']; ?>" /><input type="hidden" id="url-share-photo" value="" /></p>
            <p class="text-center text-share-tip" style="margin-top: 10px;font-weight: bold;">
                <?php if (isset($is_upload_image)) : ?>
                    Great image! Now share with your network on social media!
                <?php else : ?>
                    What a great find! Share it with your friends and colleagues!
                <?php endif; ?>
            </p>
            <?php $data_type_text = isset($data_type) ? 'data-reporting = "'.$data_type.'"' : ""; ?>
            <p class="text-center">
                <a href="#" onclick="share(); return false;"><img width="42" src="<?php echo skin_url(); ?>/images/facebook.png"></a>
                <a href="#" id="container" onclick="share_tw(); return false;"><img width="42" src="<?php echo skin_url(); ?>/images/twitter.png"></a>
                <a href="#" class="poup-share-in"><img width="42" src="<?php echo skin_url(); ?>/images/in.png"></a>
                <?php /* <a href="#" class='st_instagram_large' displayText='Instagram Badge'></a> */ ?>
                <a href="#" id="share-image-email" data-id ="<?php echo @$data_id;?>" <?php echo $data_type_text ;?>><img width="42" src="<?php echo skin_url(); ?>/images/email1.png"></a> 
            </p>
            <?php if (isset($is_upload_image)) : ?>
                <p class="text-center">
                    <a href="<?php echo base_url(); ?>" class="btn btn-gray" id="just-browse" style="margin:10px 20px;">Browse Images</a>
                    <a href="<?php echo base_url('profile/addphotos'); ?>" class="btn btn-secondary" style="margin:10px 20px;">Upload Another</a>
                </p>
            <?php endif; ?>
        </div>
    </div>
</div>
<script>
var w = 600;
var h = 400;
var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;
var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;
var left = ((width / 2) - (w / 2)) + dualScreenLeft;
var top = ((height / 2) - (h / 2)) + dualScreenTop;
var description = $("head meta[name=description]").attr("content");
var url_share_social = window.location.href;
var img = $("#photo-share").attr("src");
var title = $("head title").text();
var type_post = "<?php echo @$type_post;?>";
var id_post = "<?php echo @$id_post;?>";
var title_page = $("meta#titleshare").attr("content");
$(document).on("click",".card #share-photo",function(){
    type_post = "photo";
    var id = $(this).parents(".card").attr("data-id");
    id_post = id
    $("#share-modal .text-share-tip").text("What a great find! Share it with your friends and colleagues!");
    $("#share-modal #share-image-email").attr("data-id",id);
    $.ajax({
        url : base_url + "photos/info",
        type : "post",
        data :{id : id},
        dataType : "json",
        success : function(res){
            if(res["status"] == "success"){
                url_share_social = res["response"]["url"];
                title = res["response"]["name"];
                title_page = res["response"]["content"];
                $("#share-modal #photo-share").attr("src",base_url + res["response"]["thumb"]);
                $("#share-modal").modal();
            }
        },error : function(d,res){
            console.log(res);
        }
    })
})
window.fbAsyncInit = function () {
    FB.init({
        appId: '1728376397375375',
        xfbml: true,
        version: 'v2.5'
    });
};
(function (d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {
        return;
    }
    js = d.createElement(s);
    js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
function share() {
    tracking_share("facebook",type_post,id_post);
    window.open('https://www.facebook.com/sharer/sharer.php?u=' + url_share_social,'_blank','width=' + w + ', height=' + h + ', top=' + 150 + ', left=' + left)
}
function share_tw() {
    tracking_share("twitter",type_post,id_post);
    window.open("https://twitter.com/share?url=" + url_share_social + "&text="+title_page+": ", '_blank','width=' + w + ', height=' + h + ', top=' + 150 + ', left=' + left);
}

$(".poup-share-in").click(function () {
    tracking_share("linkedin",type_post,id_post);
    window.open("https://www.linkedin.com/shareArticle?mini=true&url=" + url_share_social, '_blank','width=' + w + ', height=' + h + ', top=' + 150 + ', left=' + left);
    return false;
});
$(document).on("click","#sendmail",function(){
    tracking_share("email",type_post,id_post);
});
</script>
<script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="https://ws.sharethis.com/button/buttons.js"></script>
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
</style> 