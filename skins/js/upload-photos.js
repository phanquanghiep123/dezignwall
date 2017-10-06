$(document).ready(function () {
    var $dataX = $('#dataX');
    var $dataY = $('#dataY');
    var $dataHeight = $('#dataHeight');
    var $dataWidth = $('#dataWidth');
    var $dataRotate = $('#dataRotate');
    var $dataScaleX = $('#dataScaleX');
    var $dataScaleY = $('#dataScaleY');
    $('.action-image [data-method="rotate"]').click(function () {
        if (!is_crop) {
            is_crop = true;
            $('.wrap-cropper .image-cropper').cropper({
                preview: '.img-preview',
                background:false,
                autoCropArea:1,
                crop: function(e) {
                    $dataX.val(Math.round(e.x));
                    $dataY.val(Math.round(e.y));
                    $dataHeight.val(Math.round(e.height));
                    $dataWidth.val(Math.round(e.width));
                    $dataRotate.val(e.rotate);
                    $dataScaleX.val(e.scaleX);
                    $dataScaleY.val(e.scaleY);
                }
            });
            
        }
        $('.image-cropper').cropper('rotate', 45);
        return false;
    });
    $('#share-modal').on('hidden.bs.modal', function (e) {
       document.location.href = base_url;
    });
    $('.action-image [data-method="crop"]').click(function () {
        if (!is_crop) {
            is_crop = true;
            $('.wrap-cropper .image-cropper').cropper({
                preview: '.img-preview',
                background:false,
                autoCropArea:1,
                crop: function(e) {
                    $dataX.val(Math.round(e.x));
                    $dataY.val(Math.round(e.y));
                    $dataHeight.val(Math.round(e.height));
                    $dataWidth.val(Math.round(e.width));
                    $dataRotate.val(e.rotate);
                    $dataScaleX.val(e.scaleX);
                    $dataScaleY.val(e.scaleY);
                }
            });
            
        }
        $('.image-cropper').cropper('crop');
        return false;
    });
    $('.upload-box-button #file-upload').click(function () {
        $("#ImageUploader_image").trigger('click');
        return false;
    });

    //Autocomplete
    $(document).on('click', '.custom-input-complete', function (event) {
        event.stopPropagation();
        $(this).find('input').focus();
        return false;
    });

    $(document).on('click', '.custom-input-complete .token-x a', function (event) {
        event.stopPropagation();
        var parents = $(this).parents('.form-group');
        $(this).parents('.item').remove();
        var value = '';
        var len = parents.find('.custom-input-complete .item').length;
        parents.find('.custom-input-complete p').each(function (i) {
            //value+=$(this).find('.text_inser .text-name').text();
            value += $(this).attr('data-id');
            if (i < len - 1) {
                value += ',';
            }
        });
        parents.find('.form-control').val(value);
        return false;
    });

    $(document).on('click', '.custom-auto-complete ul li', function (event) {
        event.stopPropagation();
        var element_set = $(this).find("a");
        var id = element_set.attr('data-id');
        var html = '<p class="item" data-id="' + id + '"><span class="text_inser"><span class="text-name">' + element_set.text() + '</span><span class="token-x"><a href="#">x</a></span></span></p>';
        var parents = element_set.parents('.form-group');
        var value = parents.find('.form-control').val();
        parents.find('.form-control').val(value + id + ',');
        if (parents.find('p.item').length > 0) {
            var len = parents.find('p.item').length;
            parents.find('p.item').eq(len - 1).after(html);
        } else {
            parents.find('.custom-input-complete').prepend(html);
        }
        parents.find('.custom-input-complete input').val('');
        parents.find('.custom-auto-complete').hide();
        $(this).parents(".wrap-custom-input ").find(".custom-input-complete input").focus();
        return false;
    });

    $(document).on('focus', '.custom-input-complete input', function () {
        var value = $(this).val();
        if (value != null && $.trim(value) != '') {
            $(this).parents('.wrap-custom-input').find('.custom-auto-complete').show();
        }
    });

    $('html,body').click(function () {
        $('.wrap-custom-input .custom-auto-complete').hide();
    });

    //Tag Point Image
    function dragFix(event, ui) {
        var containmentArea = $(".wrap-cropper"),
                percent = 1;
        var contWidth = containmentArea.width(),
                contHeight = containmentArea.height();
        ui.position.left = Math.max(0, Math.min(ui.position.left / percent, contWidth - ui.helper.width())) - 15;
        ui.position.top = Math.max(0, Math.min(ui.position.top / percent, contHeight - ui.helper.height())) - 28;
        if (ui.position.left < 0) {
            ui.position.left = 0;
        }
        if (ui.position.top < 0) {
            ui.position.top = 0;
        }
        $(this).find('.row').removeClass('show');
    }

    var update_point = function () {
        var data = {};
        $('.wrap-cropper #point').each(function (i) {
            data[i] = {
                'id': $(this).attr("data-rol"),
                'top': $(this).position().top, // - center_h,
                'left': $(this).position().left, // - center_w,
                'product_in': $('.section-product input[name="offer_product"]:checked').val(),
                'one_off': $('.section-product #unit_price').val(),
                'max_qty': $('.section-product #max_unit_price').val()
            }
        });
        $('#point-tag').val('');
        $('#point-tag').val(JSON.stringify(data));
    }

    /*Tag in image*/
    $(document).on("mouseover", ".wrap-cropper #point", function () {
        $(this).draggable({
            containment: ".wrap-cropper",
            cursor: "move",
            drag: dragFix,
            stop: function (event, ui) {
                $(this).attr("data-x", $(this).css("left"));
                $(this).attr("data-y", $(this).css("top"));
                $(this).attr("data-on", 'on');
                update_point();
            }
        });
    });
    document.getElementById("dimensions_apply").addEventListener("click", function(){
        if($(this).is(":checked")){
            $(this).parents(".section-product").find("input.required-number").removeClass("required-number").val("");
        }else{
            $(this).parents(".section-product").find("input[type=number]").addClass("required-number");
        }
    });
    $(document).on('change', 'input[name="project_image"]', function () {
        if ($("#photo_id").val() == '' || $("#photo_id").val() == 0) {
            messenger_box("Upload Images", 'Please choose image.');
            $('input[name="project_image"]:checked').prop('checked', false);
            return false;
        }
        var value = $(this).val();
        if (value == 'Product') {
            $(".section-product").show();
            $(".section-product input[type='number']").addClass('required-number');
            $(".section-product ul.list-inline").addClass('required-group');
            var len = 1;
            var point = '<div id="point" data-on="on" data-rol="tag-' + len + '" class="point-' + len + ' ui-draggable ui-draggable-handle" style="top: 70%; left: 48%;"><a><span id="lbImageTags"><i class="newImageTagIcon animate"></i></span></a></div>';
            $('.wrap-cropper').append(point);
        } else {
            $(".section-product").hide();
            $(".section-product input[type='number']").removeClass('required-number');
            $(".section-product ul.list-inline").removeClass('required-group');
            $('.wrap-cropper #point').remove();
        }
    });

    /*ADD Tag in image*/
    $(document).on('click', '.tag-image a', function () {
        /*var check=true;
         if($("#upload-form").length > 0){
         if (!$("#ImageUploader_image").val()) {
         check = false;
         }
         }
         if ($('.wrap-cropper #point[data-on="off"]').length == 0 && check==true) {
         var len = $('.wrap-cropper #point').length;
         var html='<div class="row">';
         html+='  <div class="col-sm-12">';
         html+='    <div class="delete-box"><a href="#"><i class="fa-trash  fa"></i></a></div>';
         html+='    <div class="close-box"><a href="#"><i class="fa-times fa"></i></a></div>';
         html+='    <div class="form-group">';
         html+='          <label>Product available in:</label>';
         html+='          <input value="" type="text" maxlength="15" name="product_in" id="product-in" class="form-control">';
         html+='    </div>';
         html+='    <div class="form-group">';
         html+='          <label>One-off pricing:</label>';
         html+='          <input value="0" type="number" name="one_off" id="one-off" class="form-control">';
         html+='    </div>';
         html+='    <div class="form-group">';
         html+='          <label>Maximum Sample Qty:</label>';
         html+='          <input value="0" type="number" name="max_qty" id="max-qty" class="form-control">';
         html+='    </div>';
         html+='  </div>';
         html+='</div>';
         html='';
         var point = '<div id="point" data-on="off" data-rol="tag-' + len + '" class="point-' + len + ' ui-draggable ui-draggable-handle" style="top: 70%; left: 48%;">'+html+'<a><span id="lbImageTags"><i class="newImageTagIcon animate"></i></span></a></div>';
         $('.wrap-cropper').append(point);
         }*/
        return false;
    });

    $(document).on('click', '#point .row .close-box', function () {
        $(this).parents('.row').hide().removeClass('show');
        $(this).parents('#point').css('z-index', '100');
        return false;
    });

    $(document).on('click', '#point', function () {
        $(this).find('.row').addClass('show');
        $(this).css('z-index', '1000');
        return false;
    });

    $(document).on('click', '#point .row .delete-box', function () {
        $(this).parents('#point').remove();
        update_point();
        return false;
    });

    /*Upload Image*/
    $("#upload-form").submit(function () {
        $(this).find(".border-error").removeClass("border-error");
        if(is_crop){
            var result = $('.wrap-cropper .image-cropper').cropper("getCroppedCanvas");
            $("#section-cropper #photo_id").val( result.toDataURL() );
        }
        var bool = true;
        var first_point = true;
        var style_other  = "";
        $(".wrap-custom-input .custom-input-complete input").hide();
        $.each( $(".wrap-custom-input .custom-input-complete"),function(){
            style_other = "";
            $.each($(this).find("p"),function(){
                if($(this).data("id") == "0" && ($(this).text()).trim() !=""){
                    style_other+= $(this).find(".text-name").text()+",";
                }
            });
            $(this).find(" > input").val(style_other);
        });
        if ($("#photo_id").val() == '' || $("#photo_id").val() == 0) {
            $("#file-upload").addClass('border-error');
            bool = false;
        } else {
            $("#file-upload").removeClass('border-error');
        }

        $('.required-number').each(function () {
            var value = $(this).val();
            if (value == null || value == '' || value <= 0 || value > 10000000000) {
                $(this).addClass('border-error');
                bool = false;
                if (first_focus == null) {
                    first_focus = $(this);
                }
            } else {
                $(this).removeClass('border-error');
            }
        });

        $('.required-group').each(function () {
            if ($(this).find('input[type="radio"]:checked').length > 0) {
                $(this).find('input[type="radio"]').removeClass('border-error');
            } else {
                $(this).find('input[type="radio"]').addClass('border-error');
                bool = false;
            }
        });
        var first_focus = null;

        $('.required-custom').each(function () {
            var value = $.trim($(this).val());
            var value1 = $(this).parents('.form-group').find('.custom-input-complete input').val();
            if ((value == null || value == '') && (value1 == null || value1 == '')) {
                $(this).parents('.form-group').find('.custom-input-complete').addClass('border-error');
                bool = false;
                if (first_focus == null) {
                    first_focus = $(this).parents('.form-group').find('.custom-input-complete input');
                }
            } else {
                $(this).parents('.form-group').find('.custom-input-complete').removeClass('border-error');
            }
        });

        $('input.required,textarea.required').keypress(function () {
            if ($(this).hasAttr('maxlength')) {
                var length = $(this).attr('maxlength');
                var current_length = $(this).val().length;
                if (!isNaN(length)) {
                    if (current_length >= length) {
                        return false;
                    }
                }
            }
        });

        $('input.required,textarea.required').each(function () {
            var value = $.trim($(this).val());
            if (value == null || value == '') {
                $(this).addClass('border-error');
                bool = false;
                if (first_focus == null) {
                    first_focus = $(this);
                }
            } else {
                var length = $(this).attr('maxlength');
                if (typeof length !== typeof undefined && length != '') {
                    $(this).addClass('border-error');
                    bool = false;
                    if (first_focus == null) {
                        first_focus = $(this);
                    }
                } else {
                    $(this).removeClass('border-error');    
                }
            }
        });

        $('.section-products input[type="number"]').each(function () {
            var value = $(this).val();
            if (value != '' && (value < 0 || value > 10000000000)) {
                $(this).addClass('border-error');
                bool = false;
                if (first_focus == null) {
                    first_focus = $(this);
                }
            } else {
                if (!$(this).hasClass('required')) {
                    $(this).removeClass('border-error');
                }
            }
        });
        var description = $(this).find("#description").val();
        if (description.length > 144) {
            bool = false;
            $(this).find("#description").addClass('border-error');
        }
        if (first_focus != null) {
            first_focus.focus();
        }
        if (bool == false) {
            $(".wrap-custom-input .custom-input-complete input").val("");
            $(".wrap-custom-input .custom-input-complete input").show();
            messenger_box("Upload Images", 'Please fill in all required fields.');
        } else {
            update_point();
            var parents = $(this);
            $(this).find('.loading-fixed').show();
            var options = {
                dataType: "json",
                uploadProgress: function (event, position, total, percentComplete) {},
                success: function (data) {
                    console.log(data);
                    if (data['status'] == 'success') {
                        $.each($(".wrap-custom-input .custom-input-complete input"),function(){
                            $(this).val("");
                        });
                        var photo_new = $(".wrap-cropper #photo_id").val();
                        $("#share-modal #photo-share").attr("src",photo_new);
                        $("#share-modal #url-share-photo").val(data['url_photo_public']);
                        url_share_social = data['url_photo_public'];
                        if ($('#messenger-upload').length > 0) {
                            $('#messenger-upload').modal();
                        } else {
                            $('#share-modal').modal();
                        }
                        $(".wrap-custom-input .custom-input-complete input").val("");
                        $(".wrap-custom-input .custom-input-complete input").show();
                        return false;
                    }
                },
                complete: function (response) {
                    parents.find('.loading-fixed').hide();
                    $(".wrap-custom-input .custom-input-complete input").val("");
                    $(".wrap-custom-input .custom-input-complete input").show();
                },
                error: function () {
                    messenger_box("Upload Images", 'Error uploading image.');
                    $(".wrap-custom-input .custom-input-complete input").val("");
                    $(".wrap-custom-input .custom-input-complete input").show();
                }

            };
            $(this).ajaxSubmit(options);
        }

        return false;
    });
    /*Edit Image*/
    $("#edit-form").submit(function () {
        var bool = true;
        var first_point = true;
        var style_other  = "";
        $(".wrap-custom-input .custom-input-complete input").hide();
        $.each( $(".wrap-custom-input .custom-input-complete"),function(){
            style_other = "";
            $.each($(this).find("p"),function(){
                if($(this).data("id") == "0" && ($(this).text()).trim() !=""){
                   style_other+= $(this).find(".text-name").text()+",";
                }
            });
            $(this).find(" > input").val(style_other);
        });
        $('.required-number').each(function () {
            var value = $(this).val();
            if (value == null || value == '' || value <= 0 || value > 10000000000) {
                $(this).addClass('border-error');
                bool = false;
                if (first_focus == null) {
                    first_focus = $(this);
                }
            } else {
                $(this).removeClass('border-error');
            }
        });


        $('.required-group').each(function () {
            if ($(this).find('input[type="radio"]:checked').length > 0) {
                $(this).find('input[type="radio"]').removeClass('border-error');
            } else {
                $(this).find('input[type="radio"]').addClass('border-error');
                bool = false;
            }
        });
        var first_focus = null;

        $('.required-custom').each(function () {
            var value = $.trim($(this).val());
            var value1 = $(this).parents('.form-group').find('.custom-input-complete input').val();
            if ((value == null || value == '') && (value1 == null || value1 == '')) {
                $(this).parents('.form-group').find('.custom-input-complete').addClass('border-error');
                bool = false;
                if (first_focus == null) {
                    first_focus = $(this).parents('.form-group').find('.custom-input-complete input');
                }
            } else {
                $(this).parents('.form-group').find('.custom-input-complete').removeClass('border-error');
            }
        });

        $('input.required,textarea.required').keypress(function () {
            if ($(this).hasAttr('maxlength')) {
                var length = $(this).attr('maxlength');
                var current_length = $(this).val().length;
                if (!isNaN(length)) {
                    if (current_length >= length) {
                        return false;
                    }
                }
            }
        });

        $('input.required,textarea.required').each(function () {
            var value = $.trim($(this).val());
            var cssclass = $(this).val();
            if (value == null || value == '') {
                $(this).addClass('border-error');
                bool = false;
                if (first_focus == null) {
                    first_focus = $(this);
                }
            } else {
                $(this).removeClass('border-error');
            }
        });

        $('.section-products input[type="number"]').each(function () {
            var value = $(this).val();
            if (value != '' && (value < 0 || value > 10000000000)) {
                $(this).addClass('border-error');
                bool = false;
                if (first_focus == null) {
                    first_focus = $(this);
                }
            } else {
                if (!$(this).hasClass('required')) {
                    $(this).removeClass('border-error');
                }
            }
        });
        var description = $(this).find("#description").val();
        if (description.length > 144) {
            bool = false;
            $(this).find("#description").addClass('border-error');
        }
        if (first_focus != null) {
            first_focus.focus();
        }
        if (bool == false) {
            $(".wrap-custom-input .custom-input-complete input").val("");
            $(".wrap-custom-input .custom-input-complete input").show();
            messenger_box("Edit Photos", 'Please fill in all required fields.');
        } else {
            update_point();
            var parents = $(this);
            $(this).find('.loading-fixed').show();
            var options = {
                dataType: "json",
                beforeSend: function () {},
                uploadProgress: function (event, position, total, percentComplete) {},
                success: function (data) {
                    console.log(data);
                    if (data['status'] == 'success') {
                        $.each($(".wrap-custom-input .custom-input-complete input"),function(){
                            $(this).val("");
                        });
                        $("#share-modal #photo-share").attr("src", $('.image-cropper').attr("src"));
                        $("#share-modal #url-share-photo").val(data['url_photo_public']);
                        url_share_social = data['url_photo_public'];
                        $('#share-modal').modal();
                        return false;
                    }
                    $(".wrap-custom-input .custom-input-complete input").val("");
                    $(".wrap-custom-input .custom-input-complete input").show();
                },
                complete: function (response) {
                    parents.find('.loading-fixed').hide();
                    $(".wrap-custom-input .custom-input-complete input").val("");
                    $(".wrap-custom-input .custom-input-complete input").show();
                },
                error: function () {
                    messenger_box("Edit Photos", 'Save Image Error.');
                    $(".wrap-custom-input .custom-input-complete input").val("");
                    $(".wrap-custom-input .custom-input-complete input").show();
                }

            };
            $(this).ajaxSubmit(options);
        }
        return false;
    });
    //------------------
    //Close modal
    //------------------
    $('#imageCropper-modal').on('hidden.bs.modal', function () {
        if (jcrop_api != null && typeof jcrop_api != 'undefined') {
            jcrop_api.destroy();
            jcrop_api = null;
        }
        $('#imageCropper-modal #uploadPreview').removeAttr('style');
    });
    //----------------------
    //Crop Image
    //----------------------
    $("#cropimage").submit(function () {
        $("#imageCropper-modal #loading-custom").show();
        $("#imageCropper-modal #btnSaveView2").attr('disabled', 'disabled');
        var options = {
            dataType: "json",
            beforeSend: function () {
            },
            uploadProgress: function (event, position, total, percentComplete) {
            },
            success: function (data) {
                console.log(data);
                if (data['status'] == 'success') {
                    var option = {
                        aspectRatio: 1,
                        autoCrop: false,
                        zoomable: false,
                        strict: false,
                        viewMode: 1,
                        center: true,
                        movable: false,
                        crop: function (e) {
                            var json = [
                                '{"x":' + e.x,
                                '"y":' + e.y,
                                '"w_image":' + $('.wrap-cropper > .cropper-container').width(),
                                '"h_image":' + $('.wrap-cropper > .cropper-container').height(),
                                '"height":' + e.height,
                                '"width":' + e.width,
                                '"rotate":' + e.rotate + '}'
                            ].join();
                            $("#cropper-data").val(json);
                        }
                    };
                    $('.wrap-cropper .image-cropper').cropper('destroy');
                    $('.wrap-cropper').addClass('active');
                    $('.wrap-cropper .image-cropper').attr('src', data['name']);
                    $('.wrap-cropper #photo_id').val(data['photo_id']);
                    var current_href = $('#btn-delete-photo').attr('href');
                    $('#btn-delete-photo').attr('href', base_url + 'profile/delete_photo/' + data['photo_id'] + '/?href=' + current_href);
                    $(".box-button-upload").hide();
                }
            },
            complete: function (response) {
                $("#imageCropper-modal #loading-custom").hide();
                $("#imageCropper-modal #btnSaveView2").removeAttr('disabled');
            },
            error: function () {
                //alert('error');
            }
        };
        $(this).ajaxSubmit(options);
        return false;
    });
});
$(window).load(function () {
    $("#w_box").val($(".wrap-cropper").width());
    $("#h_box").val($(".wrap-cropper").height());
    if ($("#edit-form").length > 0) {
        var wrap_w = $('.wrap-cropper').width();
        var wrap_h = $('.wrap-cropper').height();
        var image_w = parseInt($(".wrap-cropper .image-cropper").attr('data-w'));
        var image_h = parseInt($(".wrap-cropper .image-cropper").attr('data-h'));
        var center_w = (wrap_w - image_w) / 2;
        var center_h = (wrap_h - image_h) / 2;
        var tag = $.parseJSON($("#point-tag").val());
        var ratio_w = parseFloat($(".wrap-cropper").width() / image_w);
        var ratio_h = parseFloat($(".wrap-cropper").height() / image_h);
        if (tag.length > 0) {
            var point = '';
            for (var i = 0; i < tag.length; i++) {
                var html = '<div class="row">';
                html += '  <div class="col-sm-12">';
                html += '    <div class="delete-box"><a href="#"><i class="fa-trash  fa"></i></a></div>';
                html += '    <div class="close-box"><a href="#"><i class="fa-times fa"></i></a></div>';
                html += '    <div class="form-group">';
                html += '          <label>Product available in:</label>';
                html += '          <input value="' + tag[i]['product_in'] + '" type="text" maxlength="15" name="product_in" id="product-in" class="form-control">';
                html += '    </div>';
                html += '    <div class="form-group">';
                html += '          <label>One-off pricing:</label>';
                html += '          <input value="' + tag[i]['one_off'] + '" type="number" name="one_off" id="one-off" class="form-control">';
                html += '    </div>';
                html += '    <div class="form-group">';
                html += '          <label>Maximum Sample Qty:</label>';
                html += '          <input value="' + tag[i]['max_qty'] + '" type="number" name="max_qty" id="max-qty" class="form-control">';
                html += '    </div>';
                html += '  </div>';
                html += '</div>';
                html = '';
                point += '<div id="point" data-on="on" data-rol="tag-' + i + '" class="point-' + i + ' ui-draggable ui-draggable-handle" style="top: ' + (parseFloat(tag[i]['top']) * ratio_h + center_h) + 'px; left: ' + (parseFloat(tag[i]['left']) * ratio_w + center_w) + 'px;">' + html + '<a><span id="lbImageTags"><i class="newImageTagIcon animate"></i></span></a></div>';
            }
            $('.wrap-cropper').append(point);
        }
    }
});
/**************/
/* Get autocomplete textbox category*/
/***************/
var get_category_children = function (t, parents_id,event) {
    var offset_parent = $(t).parents(".wrap-custom-input").offset();
    var offset_element = $(t).offset();
    var offset_left  = offset_element.left - offset_parent.left;
    var offset_top  = offset_element.top - offset_parent.top;
    var height_element = $(t).height();
    var value = $(t).val();
    $(t).parents('.wrap-custom-input').find('.custom-auto-complete').css({"left" : offset_left+"px","top": (offset_top + height_element + 11) + "px" });
    $(t).parents('.wrap-custom-input').find('.custom-auto-complete').hide();
    if (value != null && $.trim(value) != '' && parents_id != null && parents_id != '') {
        if(event == 188){
            if($(t).val().length>3){
                var text_keycode = $(t).val();
                text_keycode = text_keycode.substr(0,(text_keycode.length-1))
                var html = '<p class="item" data-id="' + 0 + '"><span class="text_inser"><span class="text-name">' + text_keycode + '</span><span class="token-x"><a href="#">x</a></span></span></p>';
                var parents = $(t).parents('.form-group');
                if (parents.find('p.item').length > 0) {
                    var len = parents.find('p.item').length;
                    parents.find('p.item').eq(len - 1).after(html);
                }else{
                    parents.find('.custom-input-complete').prepend(html);
                }
            }
            $(t).val("");
        }else{
            var list_id = '';
            if ($(t).parents('.wrap-custom-input').find('.custom-input-complete .item').length > 0) {
                var len = $(t).parents('.wrap-custom-input').find('.custom-input-complete .item');
                $(t).parents('.wrap-custom-input').find('.custom-input-complete .item').each(function (i) {
                    list_id += $(this).attr('data-id') + ',';
                });
            }
            $.ajax({
                url: base_url + '/profile/get_by_category',
                type: 'POST',
                data: {
                    "parents_id": parents_id,
                    "slug": value,
                    'list_id': list_id
                },
                dataType: 'json',
                //async:false,
                success: function (reponse) {
                    if (reponse['status'] == 'success') {
                        var result = reponse['reponse'];
                        var html = '<ul>';
                        if (result.length > 0) {
                            for (var i = 0; i < result.length; i++) {
                                html += '<li><a href="#" data-id="' + result[i]['id'] + '">' + result[i]['title'] + '</a></li>'
                            }
                        }
                        html += "</ul>";
                        $(t).parents('.wrap-custom-input').find('.custom-auto-complete').html(html);
                        if (result.length > 0) {
                            $(t).parents('.wrap-custom-input').find('.custom-auto-complete').show();
                        }else{
                            $(t).parents('.wrap-custom-input').find('.custom-auto-complete').hide();
                        }
                    }
                },
                complete: function () {

                },
                error: function () {
                    $(t).parents('.wrap-custom-input').find('.custom-auto-complete').hide();
                }
            });
        }
    }
    return false;
}
/**************/
/* Option cropper*/
/***************/
var is_crop = false;


/**************/
/* Get autocomplete textbox keywords*/
/**************/
var get_keywords = function (t,event) {
    var value = $(t).val();
    var offset_parent = $(t).parents(".wrap-custom-input").offset();
    var offset_element = $(t).offset();
    var offset_left  = offset_element.left - offset_parent.left;
    var offset_top  = offset_element.top - offset_parent.top;
    var height_element = $(t).height();
    $(t).parents('.wrap-custom-input').find('.custom-auto-complete').css({"left" : offset_left+"px","top": (offset_top + height_element + 11) + "px" });
    $(t).parents('.wrap-custom-input').find('.custom-auto-complete').hide();
    if(event==188){
        if($(t).val().length>3){
            var text_keycode = $(t).val();
            text_keycode = text_keycode.substr(0,(text_keycode.length-1))
            var html = '<p class="item" data-id="' + 0 + '"><span class="text_inser"><span class="text-name">' + text_keycode + '</span><span class="token-x"><a href="#">x</a></span></span></p>';
            var parents = $(t).parents('.form-group');
            if (parents.find('p.item').length > 0) {
                var len = parents.find('p.item').length;
                parents.find('p.item').eq(len - 1).after(html);
            } else {
                parents.find('.custom-input-complete').prepend(html);
            }
        }
        $(t).val("");
    }else{
        if (value != null && $.trim(value) != '') {
            var list_id = '';
            if ($(t).parents('.wrap-custom-input').find('.custom-input-complete .item').length > 0) {
                var len = $(t).parents('.wrap-custom-input').find('.custom-input-complete .item');
                $(t).parents('.wrap-custom-input').find('.custom-input-complete .item').each(function (i) {
                    list_id += $(this).attr('data-id') + ',';
                });
            }
            $.ajax({
                url: base_url + '/profile/get_keywords',
                type: 'POST',
                data: {
                    "slug": value,
                    'list_id': list_id
                },
                dataType: 'json',
                //async:false,
                success: function (reponse) {
                    if (reponse['status'] == 'success') {
                        var result = reponse['reponse'];
                        var html = '<ul>';
                        if (result.length > 0) {
                            for (var i = 0; i < result.length; i++) {
                                html += '<li><a href="#" data-id="' + result[i]['keyword_id'] + '">' + result[i]['title'] + '</a></li>'
                            }
                        }
                        html += "</ul>";
                        $(t).parents('.wrap-custom-input').find('.custom-auto-complete').html(html);
                        if (result.length > 0) {
                            $(t).parents('.wrap-custom-input').find('.custom-auto-complete').show();
                        }
                        else{
                            $(t).parents('.wrap-custom-input').find('.custom-auto-complete').hide();
                        }
                    }
                },
                complete: function () {

                },
                error: function () {
                    $(t).parents('.wrap-custom-input').find('.custom-auto-complete').hide();
                }
            });
        }
    }
   
    return false;
}

/**************/
/* Read url image*/
/***************/
var jcrop_api = null;
function readURL(input) {
    if (input.files && input.files[0]) {
        if (!checkUploadSize(input)) {
            return false;
        }
        var p = $("#imageCropper-modal #uploadPreview");
        p.fadeOut();
        var oFReader = new FileReader();
        var file_name = input.files[0]["name"];
        oFReader.readAsDataURL(document.getElementById("ImageUploader_image").files[0]);
        oFReader.onload = function (oFREvent) {
            var img = new Image();
            img.onload = function() {
                img_w = this.width;
                img_h = this.height;
                $("#section-cropper .box-button-upload").remove();
                $("#section-cropper .wrap-cropper .autoCropArea").css({"width": img_w+"px"})
                $("#section-cropper .image-cropper").attr("src",oFREvent.target.result);
                $("#section-cropper #photo_id").val(oFREvent.target.result);
                $("#section-cropper #file_name").val(file_name);
                $(".action-image button").removeAttr("disabled");
            };
            img.src = oFREvent.target.result;
        };
        //$("#imageCropper-modal #loading-custom").show();
    }// end if
}

function setInfo(c) {
    $("#imageCropper-modal #x").val(c.x);
    $("#imageCropper-modal #y").val(c.y);
    $("#imageCropper-modal #w").val(c.w);
    $("#imageCropper-modal #h").val(c.h);
    $('#imageCropper-modal #image_w').val($('#imageCropper-modal .jcrop-holder').width());
    $('#imageCropper-modal #image_h').val($('#imageCropper-modal .jcrop-holder').height());
    $("#imageCropper-modal #btnSaveView2").removeAttr('disabled');
}

function clearCoords() {
    $("#imageCropper-modal #btnSaveView2").attr('disabled', 'disabled');
}

var checkUploadSize = function (input) {
    if (input.files[0].size > 8400000) {
        messenger_box("Upload Images", "Image size exceeds limit.");
        return false;
    }
    var legal_types = Array("image/jpeg", "image/png", "image/jpg");
    if (!inArray(input.files[0].type, legal_types)) {
        messenger_box("Upload Images", "Valid file formats are: jpeg or png.");
        return false;
    }
    return true;
}

var inArray = function (needle, haystack) {
    var length = haystack.length;
    for (var i = 0; i < length; i++) {
        if (typeof haystack[i] == 'object') {
            if (arrayCompare(haystack[i], needle))
                return true;
        } else {
            if (haystack[i] == needle)
                return true;
        }
    }
    return false;
}

//add catalog;
$(document).on("click",".catalog-box #add-new-catalog",function(){
    current_click = "";
    $("#modal_add_catalog").modal();
    return false;
});

$(document).on("click",".catalog-box #ba-add-new-catalog",function(){
    current_click ="batch";
    $(".group-box-add-catalog").css({"position":"relative","z-index": "9999"});
    $("#modal_add_catalog #batch-upload-show").hide();
    $("#modal_add_catalog").modal();
    return false;
});
$(document).on("paste",".custom-input-complete > input",function(e){
    e.stopPropagation();
    var _this = $(this);
    setTimeout( function() {
        var textdata = _this.val();
        var res = textdata.split(",");
        if(res.length > 0){
            var html ="";
            $.each(res,function(key,value){
                if(value.trim() != ""){
                    html += '<p class="item" data-id="' + 0 + '"><span class="text_inser"><span class="text-name">' + value.trim() + '</span><span class="token-x"><a href="#">x</a></span></span></p>';
                }
            });
            var parents = _this.parents('.form-group');
            if (parents.find('p.item').length > 0) {
                var len = parents.find('p.item').length;
                parents.find('p.item').eq(len - 1).after(html);
            } else {
                parents.find('.custom-input-complete').prepend(html);
            }
            _this.val("");
        }
    },100);

});