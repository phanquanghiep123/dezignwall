$(document).ready(function() {

    //Cropper
    //if ($("#edit-form").length <= 0) {
        //$('.image-cropper').cropper(option);
    //}
    
    $('.btn[data-method="rotate"]').click(function() {
        var check=true;
        if($("#upload-form").length > 0){
            if (!$("#ImageUploader_image").val()) {
                check = false;
            }
        }
        if(check==true){
            $('.image-cropper').cropper('rotate', 90);
        }
        return false;
    });

    $('.btn[data-method="clear"]').click(function() {
        var check=true;
        if($("#upload-form").length > 0){
            if (!$("#ImageUploader_image").val()) {
                check = false;
            }
        }
        if(check==true){
            $('.image-cropper').cropper('clear');
        }
        return false;
    });

    $('.btn[data-method="crop"]').click(function() {
        var check=true;
        if($("#upload-form").length > 0){
            if (!$("#ImageUploader_image").val()) {
                check = false;
            }
        }
        if(check==true){
            $('.image-cropper').cropper('crop');
        }
        return false;
    });

    $('.upload-box-button #file-upload').click(function() {
        //$(".image-cropper").cropper('destroy');
        $("#ImageUploader_image").trigger('click');
        return false;
    });

    //Autocomplete
    $(document).on('click', '.custom-input-complete', function(event) {
        event.stopPropagation();
        $(this).find('input').focus();
        return false;
    });

    $(document).on('click', '.custom-input-complete .token-x a', function(event) {
        event.stopPropagation();
        var parents = $(this).parents('.form-group');
        $(this).parents('.item').remove();
        var value = '';
        var len = parents.find('.custom-input-complete .item').length;
        parents.find('.custom-input-complete p').each(function(i) {
            //value+=$(this).find('.text_inser .text-name').text();
            value += $(this).attr('data-id');
            if (i < len - 1) {
                value += ',';
            }
        });
        parents.find('.form-control').val(value);
        return false;
    });

    $(document).on('click', '.custom-auto-complete ul li a', function(event) {
        event.stopPropagation();
        var id = $(this).attr('data-id');
        var html = '<p class="item" data-id="' + id + '"><span class="text_inser"><span class="text-name">' + $(this).text() + '</span><span class="token-x"><a href="#">x</a></span></span></p>';
        var parents = $(this).parents('.form-group');
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
        return false;
    });

    $(document).on('focus', '.custom-input-complete input', function() {
        var value = $(this).val();
        if (value != null && $.trim(value) != '') {
            $(this).parents('.wrap-custom-input').find('.custom-auto-complete').show();
        }
    });

    $('html,body').click(function() {
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

    var update_point= function(){
    	///var image_w = $('.wrap-cropper .image-cropper').attr('data-w');
        //var image_h = $('.wrap-cropper .image-cropper').attr('data-h');
        //var wrap_w = $('.wrap-cropper').width();
        //var wrap_h = $('.wrap-cropper').height();
        //var center_w = (wrap_w - image_w) / 2;
        //var center_h = (wrap_h - image_h) / 2;
        var data = {};
        $('.wrap-cropper #point').each(function(i) {
            data[i] = {
                'id': $(this).attr("data-rol"),
                'top': $(this).position().top,// - center_h,
                'left': $(this).position().left,// - center_w,
                'product_in':$(this).find('#product-in').val(),
                'one_off':$(this).find('#one-off').val(),
                'max_qty':$(this).find('#max-qty').val()
            }
        });
        $('#point-tag').val('');
        $('#point-tag').val(JSON.stringify(data));
    }

    /*Tag in image*/
    $(document).on("mouseover", ".wrap-cropper #point", function() {
        $(this).draggable({
            containment: ".wrap-cropper",
            cursor: "move",
            drag: dragFix,
            stop: function(event, ui) {
                //console.log('center_w:'+center_w+', center_h:'+center_h);
                $(this).attr("data-x", $(this).css("left"));
                $(this).attr("data-y", $(this).css("top"));
                $(this).attr("data-on", 'on');
                update_point();
            }
        });
    });

    /*ADD Tag in image*/
    $(document).on('click', '.tag-image a', function() {
        var check=true;
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
                html+='			 <label>Product available in:</label>';
                html+='          <input value="" type="text" name="product_in" id="product-in" class="form-control">';
                html+='    </div>';
                html+='    <div class="form-group">';
                html+='			 <label>One-off pricing:</label>';
                html+='          <input value="0" type="number" name="one_off" id="one-off" class="form-control">';
                html+='    </div>';
                html+='    <div class="form-group">';
                html+='			 <label>Maximum Sample Qty:</label>';
                html+='          <input value="0" type="number" name="max_qty" id="max-qty" class="form-control">';
                html+='    </div>';
                html+='  </div>';
                html+='</div>';
            //html='';
            var point = '<div id="point" data-on="off" data-rol="tag-' + len + '" class="point-' + len + ' ui-draggable ui-draggable-handle" style="top: 70%; left: 48%;">'+html+'<a><span id="lbImageTags"><i class="newImageTagIcon animate"></i></span></a></div>';
            $('.wrap-cropper').append(point);
        }
        return false;
    });

	$(document).on('click','#point .row .close-box',function(){
		$(this).parents('.row').hide().removeClass('show');
		$(this).parents('#point').css('z-index','100');
		return false;
	});

	$(document).on('click','#point',function(){
		$(this).find('.row').addClass('show');
		$(this).css('z-index','1000');
		return false;
	});

	$(document).on('click','#point .row .delete-box',function(){
		$(this).parents('#point').remove();
		update_point();
		return false;
	});

    /*Upload Image*/
    $("#upload-form").submit(function() {
        var bool = true;
        var first_point=true;

        $('.wrap-cropper #point').each(function(i) {
            var bool_point=true;
            var product_in=$(this).find('#product-in').val();
            var one_off=$(this).find('#one-off').val();
            var max_qty=$(this).find('#max-qty').val();
            if(product_in=='' || $.trim(product_in)==''){
                $(this).find('#product-in').addClass('border-error');
                bool_point=false;
            }
            else{
                $(this).find('#product-in').removeClass('border-error');
            }

            if(one_off=='' || $.trim(one_off)=='' || one_off==0){
                $(this).find('#one-off').addClass('border-error');
                bool_point=false;
            }
            else{
                $(this).find('#one-off').removeClass('border-error');
            }

            if(max_qty=='' || $.trim(max_qty)=='' || max_qty==0){
                $(this).find('#max-qty').addClass('border-error');
                bool_point=false;
            }
            else{
                $(this).find('#max-qty').removeClass('border-error');
            }

            if(bool_point==false){
                if(first_point){
                    $(this).find('.row').addClass('show');
                    $(this).css('z-index',1000);
                    first_point=false;
                }
                bool=false;
            }
        });
        if (!$("#ImageUploader_image").val()) {
            $("#file-upload").addClass('border-error');
            bool = false;
        } else {
            $("#file-upload").removeClass('border-error');
        }
        $('.required-group').each(function() {
            if ($(this).find('input[type="radio"]:checked').length > 0) {
                $(this).find('input[type="radio"]').removeClass('border-error');
            } else {
                $(this).find('input[type="radio"]').addClass('border-error');
                bool = false;
            }
        });
        var first_focus = null;

        $('.required-custom').each(function() {
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

        $('input.required,textarea.required').each(function() {
            var value = $.trim($(this).val());
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

        if (first_focus != null) {
            first_focus.focus();
        }
        if (bool == false) {
            messenger_box("Upload Images", 'Please fill in all required fields marked with an asterisk.');
        } else {
            var parents = $(this);
            $(this).find('.loading-fixed').show();
            var options = {
				dataType:"json",
                beforeSend: function() {},
                uploadProgress: function(event, position, total, percentComplete) {},
                success: function(data) {
                    if (data['status'] == 'success') {
                        messenger_box("Upload Images", data['message']);
                        setTimeout(function() {
                            document.location.href = data['url'];
                        }, 4000);
                    }
                },
                complete: function(response) {
                    parents.find('.loading-fixed').hide();
                },
                error: function() {
                    messenger_box("Upload Images", 'Upload Image Error.');
                }

            };
            $(this).ajaxSubmit(options);
        }

        return false;
    });

    /*Edit Image*/
    $("#edit-form").submit(function() {
        var bool = true;
        var first_point=true;
        $('.wrap-cropper #point').each(function(i) {
        	var bool_point=true;
            var product_in=$(this).find('#product-in').val();
            var one_off=$(this).find('#one-off').val();
            var max_qty=$(this).find('#max-qty').val();
            if(product_in=='' || $.trim(product_in)==''){
            	$(this).find('#product-in').addClass('border-error');
            	bool_point=false;
            }
            else{
            	$(this).find('#product-in').removeClass('border-error');
            }

            if(one_off=='' || $.trim(one_off)=='' || one_off==0){
            	$(this).find('#one-off').addClass('border-error');
            	bool_point=false;
            }
            else{
            	$(this).find('#one-off').removeClass('border-error');
            }

            if(max_qty=='' || $.trim(max_qty)=='' || max_qty==0){
            	$(this).find('#max-qty').addClass('border-error');
            	bool_point=false;
            }
            else{
            	$(this).find('#max-qty').removeClass('border-error');
            }

            if(bool_point==false){
            	if(first_point){
	            	$(this).find('.row').addClass('show');
	            	$(this).css('z-index',1000);
	            	first_point=false;
	            }
            	bool=false;
            }
        });


        $('.required-group').each(function() {
            if ($(this).find('input[type="radio"]:checked').length > 0) {
                $(this).find('input[type="radio"]').removeClass('border-error');
            } else {
                $(this).find('input[type="radio"]').addClass('border-error');
                bool = false;
            }
        });
        var first_focus = null;

        $('.required-custom').each(function() {
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

        $('input.required,textarea.required').each(function() {
            var value = $.trim($(this).val());
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

        if (first_focus != null) {
            first_focus.focus();
        }
        if (bool == false) {
            messenger_box("Edit Photos", 'Please fill in all required fields marked with an asterisk.');
        } else {
        	update_point();
            var parents = $(this);
            $(this).find('.loading-fixed').show();
            var options = {
                beforeSend: function() {},
                uploadProgress: function(event, position, total, percentComplete) {},
                success: function(data1) {
                    var data = JSON.parse(data1);
                    console.log(data);
                    if (data['status'] == 'success') {
                        messenger_box("Upload Images", data['message']);
                        setTimeout(function(){
                            location.reload();
                        },1000);
                    }
                },
                complete: function(response) {
                    parents.find('.loading-fixed').hide();
                },
                error: function() {
                    messenger_box("Edit Photos", 'Save Image Error.');
                }

            };
            $(this).ajaxSubmit(options);
        }
        return false;
    });
});

$(window).load(function() {
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
            	var html='<div class="row">';
                html+='  <div class="col-sm-12">';
                html+='    <div class="delete-box"><a href="#"><i class="fa-trash  fa"></i></a></div>';
                html+='    <div class="close-box"><a href="#"><i class="fa-times fa"></i></a></div>';
                html+='    <div class="form-group">';
                html+='			 <label>Product available in:</label>';
                html+='          <input value="'+tag[i]['product_in']+'" type="text" name="product_in" id="product-in" class="form-control">';
                html+='    </div>';
                html+='    <div class="form-group">';
                html+='			 <label>One-off pricing:</label>';
                html+='          <input value="'+tag[i]['one_off']+'" type="number" name="one_off" id="one-off" class="form-control">';
                html+='    </div>';
                html+='    <div class="form-group">';
                html+='			 <label>Maximum Sample Qty:</label>';
                html+='          <input value="'+tag[i]['max_qty']+'" type="number" name="max_qty" id="max-qty" class="form-control">';
                html+='    </div>';
                html+='  </div>';
                html+='</div>';
                point += '<div id="point" data-on="on" data-rol="tag-' + i + '" class="point-' + i + ' ui-draggable ui-draggable-handle" style="top: ' + (parseFloat(tag[i]['top']) * ratio_h + center_h) + 'px; left: ' + (parseFloat(tag[i]['left']) * ratio_w + center_w) + 'px;">'+html+'<a><span id="lbImageTags"><i class="newImageTagIcon animate"></i></span></a></div>';
            }
            $('.wrap-cropper').append(point);
        }
    }
});

/**************/
/* Get autocomplete textbox category*/
/***************/
var get_category_children = function(t, parents_id) {
    var value = $(t).val();
    $(t).parents('.wrap-custom-input').find('.custom-auto-complete').hide();
    if (value != null && $.trim(value) != '' && parents_id != null && parents_id != '') {
        var list_id = '';
        if ($(t).parents('.wrap-custom-input').find('.custom-input-complete .item').length > 0) {
            var len = $(t).parents('.wrap-custom-input').find('.custom-input-complete .item');
            $(t).parents('.wrap-custom-input').find('.custom-input-complete .item').each(function(i) {
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
            success: function(reponse) {
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
                    }
                }
            },
            complete: function() {

            },
            error: function() {
                $(t).parents('.wrap-custom-input').find('.custom-auto-complete').hide();
            }
        });
    }
    return false;
}

/**************/
/* Get autocomplete textbox keywords*/
/**************/
var get_keywords = function(t) {
        var value = $(t).val();
        $(t).parents('.wrap-custom-input').find('.custom-auto-complete').hide();
        if (value != null && $.trim(value) != '') {
            var list_id = '';
            if ($(t).parents('.wrap-custom-input').find('.custom-input-complete .item').length > 0) {
                var len = $(t).parents('.wrap-custom-input').find('.custom-input-complete .item');
                $(t).parents('.wrap-custom-input').find('.custom-input-complete .item').each(function(i) {
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
                success: function(reponse) {
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
                    }
                },
                complete: function() {

                },
                error: function() {
                    $(t).parents('.wrap-custom-input').find('.custom-auto-complete').hide();
                }
            });
        }
        return false;
    }

    /**************/
    /* Read url image*/
    /***************/
    var readURL = function(input) {
        if (input.files && input.files[0]) {
            if (!checkUploadSize(input)) {
                return false;
            }
            var p = $(".image-cropper");
            var src = p.attr('src');
            $('.section-1').find('.custom-loading').show();
            p.cropper('destroy');
            p.parents('.wrap-cropper').css('opacity', 0);
            // prepare HTML5 FileReader
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("ImageUploader_image").files[0]);

            oFReader.onload = function(oFREvent) {
                p.attr("src", oFREvent.target.result);
                var oImg = new Image();
                oImg.src = oFREvent.target.result;
                oImg.onload = function() {
                        //if(this.width<1000){
                        // messenger_box("Upload Images",'Size image 1000 pixels wide or more.');
                        //p.attr("src", src);
                        //}
                    }
                    //p.css('max-width','100%');
            };
            p.parents('.wrap-cropper').addClass('active');
            setTimeout(function() {
                p.cropper(option);
                $('.section-1').find('.custom-loading').hide();
                p.parents('.wrap-cropper').css('opacity', 1);
            }, 600);
        }
    }
    /**************/
    /* Option cropper*/
    /***************/
var option = {
    aspectRatio: 1,
    autoCrop: false,
    zoomable: false,
    //preview: this.$avatarPreview.selector,
    strict: false,
    viewMode: 1,
    center: true,
    movable: false,
    //minCropBoxWidth: 681,
    //minContainerWidth: 681,
    //minContainerHeight: 681,
    crop: function(e) {
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
        //console.log(json);
    }
};

var checkUploadSize = function(input) {
    if (input.files[0].size > 8400000) {
        messenger_box("Upload Images", "Image size exceeds limit.");
        return false;
    }
    var legal_types = Array("image/jpeg", "image/png", "image/jpg");
    if (!inArray(input.files[0].type, legal_types)) {
        messenger_box("Upload Images", "File format is invalid. Only upload jpeg or png");
        return false;
    }
    return true;
}

var inArray = function(needle, haystack) {
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