<div id="modal-album-chosse" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <h3 class="text-center" style="margin: 20px 0"><strong class="upgrade-account-link">Show your products and project in multiple views...</strong></h3>
                <div class="view-png">
                    <p class="text-center"><img src="<?php echo base_url("skins/images/view-album-poup.png")?>"></p>
                </div>
                <h4 class="text-center" style="margin: 40px 0"><strong>Note: The first item selected will be primary view. Select up to 12 images.</strong></h4>
                <div class="form-group text-right">
                    <a type="button" class="btn action-bnt btn-gray" data-dismiss="modal">Cancel</a>
                    <button type="button" id="multiple-chosse-file" class="btn action-bnt btn-primary relative">Browse for multiples</button>  
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).on("click",".multi-album",function(){
        $("#modal-album-chosse").modal();
        return false;
    });
    $(document).on("click","#modal-album-chosse #multiple-chosse-file",function(){
        $("#multiple-file-input").trigger("click");
    });
    $(document).on("change","#multiple-file-input",function(){
        $(".list-show-album").html("");
        $("#modal-album-chosse #multiple-chosse-file").append("<div class='loading-catalog'><img class='loading-catalog' src='<?php echo skin_url('images/loading.gif')?>'></div>");
        var file = $(this)[0].files;
        if(file.length > 12){
            $("#modal-album-chosse #multiple-chosse-file").find(".loading-catalog").remove();
            messenger_box("Messenger","Select up to 12 images, please check number file upload");
            return false;
        }
        for (var i = 0; i < file.length; i++) {
            console.log(i);
            if( i > 0){
                var reader = new FileReader();
                reader.onload = function(e){
                  $(".list-show-album").append('<li><img src="'+e.target.result+'"/></li>');
                  if(i >= (file.length - 1)){
                    console.log(i +"---");
                    $("#modal-album-chosse").modal("hide");
                    $("#modal-album-chosse #multiple-chosse-file").find(".loading-catalog").remove();
                  }
                }
                reader.readAsDataURL(file[i]);
            }else{
                var p = $("#imageCropper-modal #uploadPreview");
                p.fadeOut();
                var oFReader = new FileReader();
                var file_name = file[i]["name"];
                oFReader.readAsDataURL(file[i]);
                oFReader.onload = function (oFREvent) {
                    var img = new Image();
                    img.onload = function() {
                        console.log(i +"---");
                        img_w = this.width;
                        img_h = this.height;
                        $("#section-cropper .box-button-upload").remove();
                        $("#section-cropper .wrap-cropper .autoCropArea").css({"width": img_w+"px"})
                        $("#section-cropper .image-cropper").attr("src",oFREvent.target.result);
                        $("#section-cropper #photo_id").val(oFREvent.target.result);
                        $("#section-cropper #file_name").val(file_name);
                        $(".action-image button").removeAttr("disabled");
                        if(i >= (file.length - 1)){
                             console.log(i +"---");
                            $("#modal-album-chosse").modal("hide");
                            $("#modal-album-chosse #multiple-chosse-file").find(".loading-catalog").remove();
                          }
                    };
                    img.src = oFREvent.target.result;
                };
            }
            
        }   
        if(file.length > 0){
            $(".list-show-album").append('<li class="last-sum"><p> +'+file.length+'</p></li>');
        }
        
        
    });
</script>
<style type="text/css">
    #modal-album-chosse .btn{font-size: 18px;}
    #modal-album-chosse .modal-content{border-radius: 0;}
</style>