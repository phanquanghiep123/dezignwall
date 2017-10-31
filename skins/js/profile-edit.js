var jcrop_api = null;
var jcrop_api_logo = null;
var jcrop_api_banner = null;
$(document).ready(function () {
    //----------------------
    // Business Description
    //----------------------
    $("#business_type").change(function () {
        $('#business_description').val('');
    });
    $('#business_description').autocomplete({
        source: function (request, response) {
            var business_type = $("#business_type").val();
            $.ajax({
                type: "POST",
                url: "/profile/suggest_business/",
                data: {
                    "keyword": extractLast(request.term),
                    "business_type": business_type
                },
                success: function (data) {
                    if (typeof (data) !== 'undefined' && data != '' && $.trim(data) != '') {
                        data = $.trim(data);
                        response($.map($.parseJSON(data), function (item) {
                            return {
                                label: item.title,
                                value: item.title
                            }
                        }));
                    }
                },
                error: function (msg) {

                }
            })
        },
        select: function (event, ui) {
            var terms = split(this.value);
            // remove the current input
            terms.pop();
            // add the selected item
            terms.push(ui.item.label);
            // add placeholder to get the comma-and-space at the end
            terms.push("");
            this.value = terms.join(", ");
            return false;
        }
    });
    function split(val) {
        return val.split(/,\s*/);
    }

    function extractLast(term) {
        return split(term).pop();
    }

    //------------------
    //Close modal avatar
    //------------------
    $('#imageCropper-modal').on('hidden.bs.modal', function () {
        if (jcrop_api != null && typeof jcrop_api != 'undefined') {
            jcrop_api.destroy();
            jcrop_api = null;
        }
        $('#imageCropper-modal #uploadPreview').removeAttr('style');
    });

    //------------------
    //Close modal logo
    //------------------
    $('#imageCropperlogo-modal').on('hidden.bs.modal', function () {
        if (jcrop_api_logo != null && typeof jcrop_api_logo != 'undefined') {
            jcrop_api_logo.destroy();
            jcrop_api_logo = null;
        }
        $('#imageCropperlogo-modal #uploadPreview').removeAttr('style');
    });

    //------------------
    //Close modal banner
    //------------------
    $('#imageCropperbanner-modal').on('hidden.bs.modal', function () {
        if (jcrop_api_banner != null && typeof jcrop_api_banner != 'undefined') {
            jcrop_api_banner.destroy();
            jcrop_api_banner = null;
        }
        $('#imageCropperbanner-modal #uploadPreview').removeAttr('style');
    });

    //------------------
    //Edit Icon
    //------------------
    $(document).on('click', '.panel-action', function () {

        var parent = $(this).parents('.panel');
        if (!$(this).hasClass('cancel')) {
            var old_height = $(this).parents(".panel").innerHeight() + 2;
            $(this).parents(".panel").attr("data-old-height",old_height);
            $(this).parents(".panel").css("height","auto");
            parent.find('.view-profile').hide();
            parent.find('.edit-profile').show();
            parent.find('textarea').removeAttr('readonly');
            parent.find('input').removeAttr('readonly');
            $(this).addClass('cancel');
            $(this).find('i').removeClass('fa-pencil');
            $(this).find('i').addClass('fa-times');
        } else {
            var set_old_height = $(this).parents(".panel").attr("data-old-height");
            $(this).parents(".panel").css("height",set_old_height + "px");
            parent.find('.edit-profile').hide();
            parent.find('.view-profile').show();
            parent.find('textarea').attr('readonly', 'readonly');
            parent.find('input').attr('readonly', 'readonly');
            $(this).removeClass('cancel');
            $(this).find('i').removeClass('fa-times');
            $(this).find('i').addClass('fa-pencil');
        }
        $(this).parents('.row-height').find('.inner-height').matchHeight({
            byRow: true,
        });
        return false;
    });

    //------------------
    //Clear
    //------------------
    $(document).on('click', '.clear-button', function () {
    	$(this).parents('.panel').find('.panel-action').trigger("click");
        //$(this).parents('.panel').find('textarea').val('');
        //$(this).parents('.panel').find('input').val('');
        return false; 
    });

    //------------------
    //Save Profile
    //------------------
    $('.form-profile').submit(function () {
        var bool = true;
        $(this).find('input,textarea,select').each(function () {
            if ($(this).hasClass('required')) {
                var value = $(this).val();
                if (value == null || $.trim(value) == '') {
                    $(this).addClass("warning");
                    bool = false;
                } else {
                    $(this).removeClass("warning");
                }
            }
        });
        if ($(this).find("#password").length > 0) {
            var password = $(this).find("#password").val();
            var confirmpassword = $(this).find("#confirmpassword").val();
            if (password != '' || confirmpassword != '') {

                if (password != '' && password.length < 6) {
                    messenger_box("Edit Profile", 'Password must be at least 6 characters long.');
                    return false;
                } else {
                    if (confirmpassword == '' || confirmpassword.length < 6) {
                        messenger_box("Edit Profile", 'Confirm Passwords must be at least 6 characters long.');
                        return false;
                    }
                }

                if (password != confirmpassword) {
                    messenger_box("Edit Profile", 'Password does not match.');
                    return false;
                }
            }
        }
        if (bool == false) {
            messenger_box("Edit Profile", 'Please fill in all required fields.');
        } else {
            bool = bool && valid_all_format($(this), false);
        }

        if (bool == false) {
            return bool;
        }
        var parent = $(this).parents('.panel');
        var data_form = $(this).serialize();
        parent.find('.custom-loading').show();
        $.ajax({
            url: base_url + '/profile/save',
            type: 'POST',
            data: data_form,
            dataType: 'json',
            success: function (reponse) {
                // console.log(reponse);
                if (reponse['status'] == 'success') {
                    if (typeof(reponse['last_photo_id']) !== 'undefined' && !isNaN(reponse['last_photo_id'])) {
                        document.location.href = base_url + 'profile/editphoto/' + reponse['last_photo_id'] + '/?show_popup=true';
                    } else {
                        location.reload();
                    }
                }
            },
            complete: function () {
                parent.find('.custom-loading').hide();
            },
            error: function (data) {
                console.log(data);
            }
        });
        return false;
    });

    //------------------------------------------------
    //--------Save and upload image Certifications----
    //------------------------------------------------ 
    $("#certifications-form").submit(function () {
        $("#imageCropperlogo-modal #loading-custom").show();
        var parent = $(this).parents('.panel');
        var options = {
            beforeSend: function () {
                parent.find('.custom-loading').show();
            },
            uploadProgress: function (event, position, total, percentComplete) {
            },
            success: function (data) {
                var data1 = JSON.parse(data);
                console.log(data1);
                if (data1['status'] == 'success') {
                    location.reload();
                }
            },
            complete: function (response) {
                parent.find('.custom-loading').hide();
            },
            error: function () {
                //alert('error');
            }
        };
        $(this).ajaxSubmit(options);
        return false;
    });

    $(document).on('click', '.delete-image-certifications', function () {
        $(this).parent().remove();
        var data = {};
        $('.certifications_image > span').each(function (i) {
            data[i] = $(this).find('img').attr('src');
        });
        $('input[name="certifications_image"]').val('');
        $('input[name="certifications_image"]').val(JSON.stringify(data));
        return false;
    });

    //------------------
    //Crop Avatar
    //------------------
    $("#crop-avatar").submit(function () {
        $("#imageCropper-modal #loading-custom").show();
        var options = {
            'dataType': 'json',
            beforeSend: function () {
            },
            uploadProgress: function (event, position, total, percentComplete) {
            },
            success: function (data) {
                console.log(data);
                if (data['status'] == 'success') {
                    $(".avatar-full,.avatar-user img").attr('src', data['name']);
                    $('#imageCropper-modal').modal('toggle');
                }
            },
            complete: function (response) {
                $("#imageCropper-modal #loading-custom").hide();
            },
            error: function () {
                //alert('error');
            }
        };
        $(this).ajaxSubmit(options);
        return false;
    });
    //------------------
    //Crop Logo
    //------------------
    $("#crop-logo").submit(function () {
        $("#imageCropperlogo-modal #loading-custom").show();
        var options = {
            'dataType': 'json',
            beforeSend: function () {
            },
            uploadProgress: function (event, position, total, percentComplete) {
            },
            success: function (data1) {
                console.log(data1);
                if (data1['status'] == 'success') {
                    $(".logo-company img").attr('src', data1['name']);
                    $('#imageCropperlogo-modal').modal('toggle');
                }
            },
            complete: function (response) {
                $("#imageCropperlogo-modal #loading-custom").hide();
            },
            error: function () {
                //alert('error');
            }
        };
        $(this).ajaxSubmit(options);
        return false;
    });

    //------------------
    //Crop Banner
    //------------------
    $("#crop-banner").submit(function () {
        $("#imageCropperbanner-modal #loading-custom").show();
        var options = {
            'dataType': 'json',
            beforeSend: function () {
            },
            uploadProgress: function (event, position, total, percentComplete) {
            },
            success: function (data) {
                console.log(data);
                if (data['status'] == 'success') {
                    $(".banner.image-banner > img").hide();
                    $(".image-banner").attr('style', 'background:url("' + data['name'] + '") no-repeat center center;background-size:cover;');
                    $('#imageCropperbanner-modal').modal('toggle');
                }
            },
            complete: function (response) {
                $("#imageCropperbanner-modal #loading-custom").hide();
            },
            error: function () {
                //alert('error');
            }
        };
        $(this).ajaxSubmit(options);
        return false;
    });
});

//------------------
//Read Image avatar
//------------------
function readURL(input) {
    if (input.files && input.files[0]) {
        if (!checkUploadSize(input)) {
            return false;
        }
        var p = $("#imageCropper-modal #uploadPreview");
        $("#imageCropper-modal").modal("show");
        p.fadeOut();
        // prepare HTML5 FileReader
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("ImageUploader_image").files[0]);
        oFReader.onload = function (oFREvent) {
            p.attr("src", oFREvent.target.result).fadeIn();
            p.css('max-width', '100%');
            //p.css('max-height', $(window).height());
            //p.class('large-11 large-centered columns');
        };
        $("#imageCropper-modal #loading-custom").show();
        if (jcrop_api != null && typeof jcrop_api != 'undefined') {
            jcrop_api.destroy();
            jcrop_api = null;
        }
        setTimeout(function () {
            p.Jcrop({
                setSelect: [0, 0, 400, 400],
                onChange: setInfo,
                onRelease: clearCoords,
                boxWidth: 600,
                aspectRatio: 1 / 1,
            }, function () {
                jcrop_api = this;
            });
            $("#imageCropper-modal #loading-custom").hide();
        }, 1000);
    }// end if
}
function setInfo(c) {
    $("#imageCropper-modal #x").val(c.x);
    $("#imageCropper-modal #y").val(c.y);
    $("#imageCropper-modal #w").val(c.w);
    $("#imageCropper-modal #h").val(c.h);
    $('#image_w').val($('#imageCropper-modal .jcrop-holder').width());
    $('#image_h').val($('#imageCropper-modal .jcrop-holder').height());
    $("#imageCropper-modal #btnSaveView2").removeAttr('disabled');
}

function clearCoords() {
    $("#imageCropper-modal #btnSaveView2").attr('disabled', 'disabled');
}
//------------------
//Read Image logo
//------------------
function readURL1(input) {
    if (input.files && input.files[0]) {
        if (!checkUploadSize(input)) {
            return false;
        }
        var p = $("#imageCropperlogo-modal #uploadPreview");
        $("#imageCropperlogo-modal").modal("show");
        p.fadeOut();
        // prepare HTML5 FileReader
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("ImageUploader_image1").files[0]);
        oFReader.onload = function (oFREvent) {
            p.attr("src", oFREvent.target.result).fadeIn();
            p.css('max-width', '100%');
            //p.css('max-height', $(window).height());
            //p.class('large-11 large-centered columns');
        };
        $("#imageCropperlogo-modal #loading-custom").show();
        if (jcrop_api_logo != null && typeof jcrop_api_logo != 'undefined') {
            jcrop_api_logo.destroy();
            jcrop_api_logo = null;
        }
        setTimeout(function () {
            p.Jcrop({
                setSelect: [0, 0, 400, 400],
                onChange: setInfo1,
                onRelease: clearCoords1,
                boxWidth: 600,
                aspectRatio: 1 / 1,
            }, function () {
                jcrop_api_logo = this;
            });
            $("#imageCropperlogo-modal #loading-custom").hide();
        }, 1000);
    }// end if
}

function setInfo1(c) {
    $("#imageCropperlogo-modal #x").val(c.x);
    $("#imageCropperlogo-modal #y").val(c.y);
    $("#imageCropperlogo-modal #w").val(c.w);
    $("#imageCropperlogo-modal #h").val(c.h);
    $('#imageCropperlogo-modal #image_w').val($('#imageCropperlogo-modal .jcrop-holder').width());
    $('#imageCropperlogo-modal #image_h').val($('#imageCropperlogo-modal .jcrop-holder').height());
    $("#imageCropperlogo-modal #btnSaveView2").removeAttr('disabled')
}

function clearCoords1() {
    $("#imageCropperlogo-modal #btnSaveView2").attr('disabled', 'disabled');
}

//------------------
//Read Image banner
//------------------
function readURL2(input) {
    if (input.files && input.files[0]) {
        if (!checkUploadSize(input)) {
            return false;
        }
        var p = $("#imageCropperbanner-modal #uploadPreview");
        $("#imageCropperbanner-modal").modal("show");
        p.fadeOut();
        // prepare HTML5 FileReader
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("ImageUploader_image2").files[0]);
        oFReader.onload = function (oFREvent) {
            p.attr("src", oFREvent.target.result).fadeIn();
            p.css('max-width', '100%');
            //p.css('max-height', $(window).height());
            //p.class('large-11 large-centered columns');
        };
        $("#imageCropperbanner-modal #loading-custom").show();
        if (jcrop_api_banner != null && typeof jcrop_api_banner != 'undefined') {
            jcrop_api_banner.destroy();
            jcrop_api_banner = null;
        }
        setTimeout(function () {
            p.Jcrop({
                setSelect: [0, 0, 900, 300],
                onChange: setInfo2,
                onRelease: clearCoords2,
                boxWidth: 900,
                aspectRatio: 3 / 1,
            }, function () {
                jcrop_api_banner = this;
            });
            $("#imageCropperbanner-modal #loading-custom").hide();
        }, 1000);
    }// end if
}

function setInfo2(c) {
    $("#imageCropperbanner-modal #x").val(c.x);
    $("#imageCropperbanner-modal #y").val(c.y);
    $("#imageCropperbanner-modal #w").val(c.w);
    $("#imageCropperbanner-modal #h").val(c.h);
    $('#imageCropperbanner-modal #image_w').val($('#imageCropperbanner-modal .jcrop-holder').width());
    $('#imageCropperbanner-modal #image_h').val($('#imageCropperbanner-modal .jcrop-holder').height());
    $("#imageCropperbanner-modal #btnSaveView2").removeAttr('disabled');
}

function clearCoords2() {
    $("#imageCropperbanner-modal #btnSaveView2").attr('disabled', 'disabled');
}

//------------------
//Check file read
//------------------
var checkUploadSize = function (input) {
    if (input.files[0].size > 8400000) {
        alert("Image size exceeds limit.");
        return false;
    }
    var legal_types = Array("image/jpeg", "image/png", "image/jpg");
    if (!inArray(input.files[0].type, legal_types)) {
        alert("File format is invalid. Only upload jpeg or png");
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