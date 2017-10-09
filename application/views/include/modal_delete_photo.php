<div id="modal_delete_photo" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md" style=" width: 700px; max-width: 100%;">
        <input type="hidden" id="action" value="">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">
                    <div class="logo">
                        <img class="left" src="<?php echo skin_url("/images/logo-mobile.png");?>">
                        <span class="left" style="margin-left: 15px;color: #37a7a7;font-size: 22px;margin-top: 6px;">Whoa! Are you sure you want to delete this...</span>
                    </div>
                </h4>
            </div>
            <div class="modal-body">
                <p class="text-center">Designers and specifiers may have already pinned <br>
this image to their Project Walls. You have options...</p>
                <div class="row">
                    <div class="col-md-3">
                        <div class="single-image"><img src="" id="set-data-image"></div>
                    </div>
                    <div class="col-md-9">
                        <div class="infor-images">
                            <p style="margin: 10px 0;">Did you know you could mark an item as “discontinued”?
Give your customers a friendly heads up and an 
opportunity to choose another product from your line.
Simply mark this item as discontinued and suggest a few
options. Your customers will love you for it!</p>
                        </div>
                    </div>     
                </div>
                <label><strong>How much of a heads up would you like to give?</strong></label>
                <div class="choose-month-hide">
                    <p>Display as discontinued for ____ months before deleting:</p>
                    <div class="list-month">
                        <ul class="list-inline custom">
                            <li>
                                <div class="checkbox check-yelow checkbox-circle">
                                    <input type="radio" name="choose-month" id="choose-month-1" value="6">
                                    <label for="choose-month-1">
                                        6 months
                                    </label>
                                </div>
                            </li>
                            <li>
                                <div class="checkbox check-yelow checkbox-circle">
                                    <input type="radio" checked="" name="choose-month" id="choose-month-2" value="12">
                                    <label for="choose-month-2">
                                        12 months (recommended)
                                    </label>
                                </div>
                            </li>
                            <li>
                                <div class="checkbox check-yelow checkbox-circle">
                                    <input type="radio" name="choose-month" id="choose-month-3" value="18">
                                    <label for="choose-month-3">
                                        18 months
                                    </label>
                                </div>
                            </li>
                            <li>
                                <div class="checkbox check-yelow checkbox-circle">
                                    <input type="radio" name="choose-month" id="choose-month-4" value="24">
                                    <label for="choose-month-4">
                                        24 months
                                    </label>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <label><strong>Give them some options...</strong></label>
                <div class="choose-number-images">
                    <p>Pick up to six alternatives for them to choose from:</p>
                    <ul class="list-number list-inline">
                        <li><a href="#" data-choose = "1">1</a></li>
                        <li><a href="#" data-choose = "2">2</a></li>
                        <li><a href="#" data-choose = "3">3</a></li>
                        <li><a href="#" data-choose = "4">4</a></li>
                        <li><a href="#" data-choose = "5">5</a></li>
                        <li><a href="#" data-choose = "6">6</a></li>
                    </ul>
                </div>
            </div>
             <div class="modal-footer text-right">
                <a href="#" onclick="deletepoppup(this.href);return false;" data-type="0" class="btn btn-default" id="delete-image-discontinued">Delete Image</a>
                <a href="#" id="ok-delete" data-type="2" class="btn action-bnt btn-primary delete-now-discontinue" id="post-as-discontinue">Post as Discontinued</a>
            </div>
        </div>
    </div>
</div>
<?php ?>
<script type="text/javascript">
    var photo_id  = 0;
    var photo_sam = "";
    $(document).on("click",".btn-delete-my-photo",function(){
        photo_id = $(this).data("id");
        var src_single = $(this).parents(".card-image").find(".photo-details").attr("src");
        $("#modal_delete_photo .single-image #set-data-image").attr("src",src_single);
        $("#modal_delete_photo #delete-image-discontinued").attr("href",base_url +"profile/delete_photo/"+photo_id);
        $("#modal_delete_photo").modal();
        return false;
    });
    var number_choose_images = 0;
    $(document).on("click","#modal_delete_photo .choose-number-images li a",function(){
        $("#modal_delete_photo .choose-number-images li a.activer").removeClass("activer");
        $(this).addClass("activer");
        number_choose_images = $(this).data("choose");
        if(photo_id != 0 && typeof photo_id !== "undefined"){
            $.ajax({
                url  : base_url + "profile/get_photo_same_catalog",
                type:"post",
                dataType:"json",
                data : {"photo_id":photo_id},
                success:function(data){
                    if(data["status"] == "success"){
                        if(data["list_photo"] != null){
                            var html = "";
                            $.each(data["list_photo"],function(key,value){
                                if(key < 12){
                                  html+='<div class="col-md-4 block item"><div class="checkbox check-yelow checkbox-circle"> <input type="checkbox" class="choose-image" name="choose-image" id="choose-image-'+key+'" value="'+value["photo_id"]+'"> <label for="choose-image-'+key+'"></label><a id="view-image" data-description = "'+value["description"]+'" data-id = "'+value["photo_id"]+'" data-title="'+value["name"]+'" href="'+base_url + value["thumb"]+'"><img src ="'+base_url + value["thumb"]+'"></a></div></div>';
                                }else{
                                	html+='<div class="col-md-4 none item"><div class="checkbox check-yelow checkbox-circle"> <input type="checkbox" class="choose-image" name="choose-image" id="choose-image-'+key+'" value="'+value["photo_id"]+'"> <label for="choose-image-'+key+'"></label><a id="view-image" data-description = "'+value["description"]+'"  data-id = "'+value["photo_id"]+'" data-title="'+value["name"]+'" href="'+base_url + value["thumb"]+'"><img src ="'+base_url + value["thumb"]+'"></a></div></div>';
                                }
                            });
                            $("#modal_choose_photo .list_data_photo_same_catalog .row").html(html);
                            $("#modal_delete_photo").modal("hide");
                            setTimeout(function(){
                            	if($("#modal_choose_photo .custom .item").length <= 12){
                            		$("#modal_choose_photo #load-more-image").hide();
                            	}else{
                            		$("#modal_choose_photo #load-more-image").show();
                            	}
                   				$("#modal_choose_photo").modal();
                            },1000);
                            
                        }
                    }               
                    $("#modal_choose_photo #max-choose-image").text(number_choose_images);   
                }

            });
        }
        return false;
    });
    $(document).on("click","#modal_delete_photo .delete-now-discontinue",function(){
        var type = $(this).data("type");
        var month = $("#modal_delete_photo .list-month input[name='choose-month']:checked").val();
        $.ajax({
            url:base_url+"profile/delete_image_discontinued",
            type:"post",
            dataType:"json",
            data:{
                "month"     : month,
                "photo_sam" : photo_sam,
                "type"      : type,
                "photo_id"  : photo_id
            },
            success:function(data){
                if(data["status"] == "success"){
                    $("#messenger-box .modal-footer button").attr("onclick","location.reload();");
                    messenger_box("Delete image","Delete image successful");
                }else{
                    messenger_box("Delete image","Delete image not successful, Please try again");
                }
            },error:function(){
                messenger_box("Delete image","Delete image not successful, Please try again");
            }
        });
        return false;
    });
    $(document).on("click","#modal_delete #ok-delete",function(){
        var data_url = $(this).attr("href");
        $.ajax({
            url: data_url,
            type:"get",
            success:function(data){
                $("#modal_delete").modal("hide");
                $("#messenger-box .modal-footer button").attr("onclick","location.reload();");
                messenger_box("Delete image","Delete image successful");
            }
        });
        return false;
    });
</script>
<style type="text/css">
    .list-month ul li {width: 49%;}
    .choose-month-hide,.choose-number-images{padding:  0 20px; margin-top: 10px;}
    .choose-month-hide .checkbox{padding-left:  0;}
    #modal_delete_photo .modal-header{
        float: left;
        width: 100%;
        margin-bottom: 30px;
    }
    .list-month ul.list-inline.custom {padding:  0 20px;}
    #modal_delete_photo .choose-number-images .list-number a{
        width: 50px;
        height: 50px;
        background-color: #f1f1f1;
        color: #000;
        border: 1px solid #000;
        border-radius: 5px;
        float: left;
        font-size: 30px;
        line-height: 1.5;
        text-align: center;
        font-weight: bold;
    }
    #modal_delete_photo .choose-number-images .list-number a.activer{
        background-color: #37a7a7;
    }
    #modal_delete_photo .choose-number-images li{
        width:16%;
    }
    @media screen and ( max-width: 768px ){
        .list-month ul li {width: 100%;}
    }
    #modal_delete_photo .logo img{width: 40px;}
</style>