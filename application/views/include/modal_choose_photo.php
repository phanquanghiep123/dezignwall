<div id="modal_choose_photo" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md" style=" width: 700px; max-width: 100%;">
        <input type="hidden" id="action" value="">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">
                    <div class="logo">
                        <img class="left" src="<?php echo skin_url("/images/logo-mobile.png");?>">
                        <span class="left" style="margin-left: 15px;color: #37a7a7;font-size: 22px;margin-top: 6px;">Pick up to six alternate product images...</span>
                    </div>
                </h4>
            </div>
            <div class ="modal-body">
               <p class ="text-center">Click on an image to get a better view.</p>
               <div class="list_data_photo_same_catalog">
                   <div class="row custom">
                       
                   </div>
               </div>
               <div class="box-imfor-data">
                    <div class="row">
                        <div class="col-md-6"><p class="number-choosed-data"><span id="total-choosed-images">0</span> Selected...<span id="max-choose-image">6</span> more to go!</p></div>
                        <div class="col-md-6 text-right"><a id="load-more-image" href="#">MORE</a></div>
                    </div>
               </div>
            </div>
             <div class="modal-footer text-right">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a href="#" id="ok-delete" class="btn action-bnt btn-primary">Update</a>
            </div>
        </div>
    </div>
</div>
<div id="modal_view_photo" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md" style=" width: 700px; max-width: 100%;">
        <input type="hidden" id="action" value="">
        <div class="modal-content">
            <div class ="modal-body">
                <div class="custom-head">
                    <div class="title-image"></div>
                    <a type="button" class="close" data-dismiss="modal">&times;</a>
                </div>
                <div id="card-1283180" class="card" data-id="1283180" data-type="photo">
                    <div class="card-wrapper" id="wrapper-impormant-image" data-id="1283180">
                        <a href="#" id="pins-to"><img src="<?php echo skin_url("images/pin-blue.png");?>"></a>
                        <div class="card-image ">
                            <div class="row">
                               <div class="col-md-12 text-center">
                                   <img class="photo-details" src="" id="single-img-view"/>
                               </div>
                            </div>
                        </div>
                        <div class="text-right button-close-view">
                            <button type="button" class="btn btn-black" data-dismiss="modal">Close</button>       
                        </div>
                    </div>
                </div>
               
               
                <div class="row">
                    <div class="description col-md-12" style="margin-top: 30px;">
                       <p class="text-description"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
    .list-month ul li {width: 49%;}
    .choose-month-hide,.choose-number-images{padding:  0 20px; margin-top: 10px;}
    .choose-month-hide .checkbox{padding-left:  0;}
    #modal_choose_photo .modal-header{
        float: left;
        width: 100%;
        margin-bottom: 30px;
    }
    #modal_view_photo .modal-header{
        float: left;
        width: 100%;
        margin-bottom: 30px;
    }
    .list-month ul.list-inline.custom {padding:  0 20px;}
    #modal_choose_photo .choose-number-images .list-number a{
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
    #modal_choose_photo .choose-number-images .list-number a.activer{
        background-color: #37a7a7;
    }
    #modal_choose_photo .choose-number-images li{
        width:16%;
    }
    @media screen and ( max-width: 768px ){
        .list-month ul li {width: 100%;}
    }
    .modal-header .close{
        z-index: 99999;
        position: relative;
    }
    .list_data_photo_same_catalog{margin-top: 20px;padding-left: 20px;max-height: 400px;overflow-y: auto; overflow-x: hidden;}
    .list_data_photo_same_catalog .checkbox img{max-height: 120px;}
    .box-imfor-data{margin-top: 30px;}
    .box-imfor-data .number-choosed-data{color: #37a7a7;}
    .box-imfor-data .load-more-image{color: #37a7a7;}
    #modal_view_photo .modal-content{
        border-radius:  0;
    }
    .modal-body{position: relative;}
    #modal_view_photo .custom-head{
        background-color: rgba(0, 0, 0, 0.6);
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        z-index: 99;
        padding: 14px 10px;
    }
    #modal_view_photo .custom-head .title-image{
        color: #fff;
        font-size:  24px;
    }
    #modal_view_photo .card{
        position: relative;
    }
    #modal_view_photo .custom-head .close{position: absolute; top:10px; right: 10px; color: #fff; opacity: 1;padding: 5px 10px;}
    #modal_view_photo .card #pins-to{
        position: absolute;
        right: 10px;
        z-index: 99999;
        top: 67px;
    }
    #modal_view_photo .button-close-view{
        position:  absolute; 
        bottom: 30px;
        right: 0px;
    }
    #modal_view_photo #pins-to img{
        max-height: 45px;
    }
    #single-img-view{width: auto !important;}
     #modal_view_photo .card-image{float: inherit;}
    .btn-black{background-color: rgba(0, 0, 0, 0.6); border: 1px solid #fff; color: #fff; font-size: 24px; border-radius:  0;}
    #modal_choose_photo .logo img{width: 40px;}
</style>
<script type="text/javascript">
    $(document).on("click","#modal_choose_photo .choose-image",function(){
       var all_choose =  $("#modal_choose_photo .choose-image:checked").length;
       if(all_choose > number_choose_images){
            alert("Maximum number of images is "+number_choose_images+"");
            return false;
       }else{
            $("#modal_choose_photo .number-choosed-data #total-choosed-images").text(all_choose);
       }
    });
    var click_more = 1;
    $(document).on("click","#modal_choose_photo #load-more-image",function(){
        click_more ++;
        var show_item = click_more * 12;
        var i = 1;
        $.each($("#modal_choose_photo .custom .item"),function(key,value){
            if(i <= show_item){
                $(this).addClass("block").removeClass("none");
            }
            i++;
        });
        if(i >= $("#modal_choose_photo .custom .item").length){
            $(this).hide();
        }
        return false;
    });
    var view = 0;
    $("#modal_choose_photo").on("hidden.bs.modal",function(){
        click_more = 1;  
        if(view == 0){
            $("#modal_choose_photo .number-choosed-data #total-choosed-images").text("0");
            $("#modal_choose_photo #load-more-image").show();
            $("#modal_delete_photo").modal();
        }
       
    });
    $("#modal_delete_photo").on("hidden.bs.modal",function(){
        photo_sam = "";
        click_more = 1;  
        $("#modal_choose_photo .number-choosed-data #total-choosed-images").text("0");
        $("#modal_choose_photo #load-more-image").show();
        
    });
    $("#modal_view_photo").on("hidden.bs.modal",function(){
        view = 0;
        $("#modal_choose_photo").modal();
    });
   
    $(document).on("click","#modal_choose_photo #ok-delete",function(){
        $.each($("#modal_choose_photo .list_data_photo_same_catalog .item .choose-image:checked"),function(){
            photo_sam += $(this).val()+",";
        });
        $("#modal_choose_photo").modal("hide");
        return false;
    });
    
    $(document).on("click",".list_data_photo_same_catalog #view-image",function(){
        view = 1;
        var description = $(this).attr("data-description");
        var data_photo_id = $(this).attr("data-id");
        $("#modal_view_photo .description p").html(description);
        $("#modal_view_photo .card").attr("data-id",data_photo_id);
        $("#modal_view_photo .card-wrapper").attr("data-id",data_photo_id);
        $("#modal_view_photo .title-image").html($(this).attr("data-title"));
        $("#modal_view_photo #single-img-view").attr("src",$(this).attr("href"));
        $("#modal_view_photo #single-img-view").attr("src",$(this).attr("href"));
        $("#modal_choose_photo").modal("hide");
        setTimeout(function(){
            $("#modal_view_photo").modal();   
        },1000); 
        return false;
    });
</script>