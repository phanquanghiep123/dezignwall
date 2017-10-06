var box = 568;
$(document).on("click","#show_hidden",function(){
    $(this).toggleClass("open");
    if( $(this).hasClass("open") == true ){
        $(this).parent().find("input").attr("type","text");
    }else{
        $(this).parent().find("input").attr("type","password");
    }
    return false;
});
$(document).ready(function() {
    $.each($("form #keyword-tag"), function() {
        var _this_new = $(this);
        $(this).tagit({
            allowSpaces: true,
            fieldName: "keyword[]",
            autocomplete: {
                delay: 0,
                minLength: 1
            },
            tagSource: function(request, response) {
                name_not_show = _this_new.val();
                $.ajax({
                    url: base_url + "profile/get_services",
                    type: "post",
                    data: {
                        slug: request.term,
                        list_id: name_not_show
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data["status"] == "success") {
                            response($.map(data["reponse"], function(item) {
                                console.log(item);
                                return {
                                    label: item.title,
                                    value: item.title,
                                }
                            }));
                        }

                    }
                });
            }
        });
    });
    $(document).on('click', '.rep-item .clear-button-sr', function() {
        $(this).parents('form').find("ul.tagit li:not(.tagit-new)").remove();
        $(this).parents('form').find('input:not(.disabled)').val('');
        $(this).parents('form').find('textarea:not(.disabled)').val('');
        return false;
    });
    var reset_click = 0;
    $(document).on('submit', '.rep-item form', function() { 
        var bool = true;
        var messenger = "";
        $(this).find("#password,#password-confirm").attr("type","password");
        $(this).find(".open").removeClass("open");
        $(this).find(".warning").removeClass("warning");
        $(this).find('input,textarea').each(function(){
            if($(this).hasClass('required')){
                var value=$(this).val();
                if(value == null || $.trim(value)==''){
                    $(this).addClass("warning");
                    bool = false;
                    messenger = 'Please fill in all required fields marked with an asterisk.';
                }
                else{
                    if( $(this).attr("type") == "password" && $(this).val().length < 6) {
                        if(messenger =="" ){
                            messenger = "Password must be at least 6 characters long";
                        }
                        bool = false;
                        $(this).addClass("warning");
                    }else if(typeof $(this).data("math") !== "undefined"){
                        if($(this).val() != $(this).parents("form").find($(this).data("math")).val()){
                            $(this).addClass("warning");
                            bool = false;
                            if(messenger =="" ){
                                messenger = "Confirm Password do not match Password.";
                            }
                        }
                    }
                    
                }
                if($(this).hasClass("format-email") == true){
                  if(!isEmail(value)){
                    $(this).addClass("warning");
                    messenger = "Email is invalid. Please try again.";
                    bool = false;
                  }
                }
                if($(this).hasClass("format-url") == true){
                  if(!ValidURL(value)){
                    $(this).addClass("warning");
                    messenger = "URL is invalid. Please try again.";
                    bool = false;
                  }
                }
            }
        });
        if (bool == false) {
            messenger_box("Edit Reps",messenger);
            return false;
        } else {
            bool = bool && valid_all_format($(this), false);
        }

        if (bool == false) {
            return false;
        }
        var parent = $(this).parents('.rep-item');
        var data_form = new FormData($(this)[0]);
        parent.find('.custom-loading').show();
        if (reset_click == 0) {
            reset_click = 1;
            $.ajax({
                url: base_url + 'business/save_sales_reps',
                type: 'POST',
                data: data_form,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                success: function(reponse) {
                    if (reponse['status'] == 'success') {
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    }
                    reset_click = 0;
                },
                complete: function() {
                    parent.find('.custom-loading').hide();
                },
                error: function(data) {
                    console.log(data['responseText']);
                    reset_click = 0;
                }
            });
        }
        return false;
    });
    $("#ImageUploader").change(function(){
        $("#imageCropper-modal #loading-custom").show();
        var file    = document.querySelector('#ImageUploader').files[0];
        var reader  = new FileReader();
        var p = $("#imageCropper-modal #uploadPreview");
        var width_box = $("#imageCropper-modal .modal-dialog").width();
        var padding_ = parseInt(jQuery("#imageCropper-modal .modal-body").css("padding-left"));
        reader.addEventListener("load", function () {
            var img = new Image();
            img.onload = function () {
                p.attr("src", reader.result);
                if (jcrop_api != null && typeof jcrop_api != 'undefined') {
                    jcrop_api.destroy();
                    jcrop_api = null;
                }
                p.Jcrop({
                    setSelect: [0, 0, 400, 400],
                    onChange: setInfo,
                    onRelease: clearCoords,
                    boxWidth: width_box - (padding_ * 2),
                    aspectRatio: 1/1,
                }, function () {
                    jcrop_api = this;
                });
                $("#imageCropper-modal").modal();
                $("#imageCropper-modal #loading-custom").hide();
            };
            img.src = reader.result;
        }, false);
        if (file) {
            reader.readAsDataURL(file);
        }
    });
    $("#crop-avatar-business").submit(function(){
        if($("#ImageUploader").val() !=""){
            var data_form = new FormData($(this)[0]);
            $("#imageCropper-modal #loading-custom").show();
            $("#imageCropper-modal #save-logo-business").attr("disabled","true");
            $.ajax({
                url:base_url + 'business/save_logo',
                type:"POST",
                data:data_form,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                success:function(data){
                    if(data["status"] == "status"){
                        $(".media-object.avatar-full").attr("src",base_url+data["logo"]);
                        $("#header .avatar-user img").attr("src",base_url+data["logo"]);
                    }
                    var img = new Image();
                    img.onload = function () {
                        $("#imageCropper-modal #loading-custom").hide();
                        $("#imageCropper-modal").modal("hide");
                        $("#imageCropper-modal #save-logo-business").removeAttr("disabled");
                    }
                    img.src = base_url+data["logo"];                 
                },
                error:function(){
                    $("#imageCropper-modal #loading-custom").hide();
                    $("#imageCropper-modal").modal("hide");
                    $("#imageCropper-modal #save-logo-business").removeAttr("disabled");

                }
            });
        }
        return false;
    });
});

function isEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}
function ValidURL(str) {
  var urlregex = /^(https?|ftp):\/\/([a-zA-Z0-9.-]+(:[a-zA-Z0-9.&%$-]+)*@)*((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9][0-9]?)(\.(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9]?[0-9])){3}|([a-zA-Z0-9-]+\.)*[a-zA-Z0-9-]+\.(com|edu|gov|int|mil|net|org|biz|arpa|info|name|pro|aero|coop|museum|[a-zA-Z]{2}))(:[0-9]+)*(\/($|[a-zA-Z0-9.,?'\\+&%$#=~_-]+))*$/;
  return urlregex.test(str);
}