var out_click = 0;
function how_it_works() {
    $("#how-it-works-buyer-2").modal();
    $('#how-it-works-buyer-2').on('hidden.bs.modal', function (e) {
        if(out_click == 1){
            $("body").addClass("modal-open");
            out_click = 0;
        }
        
    });
  
}

function how_it_works_buyer_1() {
    out_click = 1;
    $("#how-it-works-buyer-2").modal("hide");
    $("#how-it-works-buyer").modal();
}
function how_it_works_buyer_2() {
    out_click = 1;
    $("#how-it-works-buyer-2").modal("hide");
    $("#how-it-works-buyer-1").modal();
}
$(document).ready(function () {

    var href_current = window.location.href;
    $("#promo_code").keypress(function(event){
		if(event.keyCode == 13){
			event.preventDefault();
		}
	});
    $("#header .box-menu a").each(function () {
        var link = base_url + $(this).attr('href').substr(1);
        if (link == href_current) {
            $(this).parents('li').addClass('active');
        }
    });

    $("#form-user #close-form").click(function () {
        $(this).parents("#form-user").slideUp("slow");
        if ($(window).width() < 992) {
            if ($(window).width() < 768) {
                $("#wrapper2.structural-block").css("padding-top", "70px");
            } else {
                ("#wrapper2.structural-block").css("padding-top", "105px");
            }
            $("#header").css("position", "fixed");
        }
    });
    $("#header .avatar-user").click(function () {
        if ($(window).width() < 992) {
            $("#header").css("position", "fixed");
        }
        $(this).parents(".box-user").find(".nav-user").slideToggle("slow");
    });
    $(".control-menu-mobile").click(function () {
        $(".box-menu").toggleClass("open");
        $(".box-menu").slideToggle();
        return false;
    });
    /*slider home*/
    $('.bxslider').bxSlider({
        pager: false,
    });
    $("#show_box_login").click(function(){
        $("#header .avatar-user").trigger("click");
        return false;
    })
    $(".box-user.not-login .avatar-user").click(function () {
        $("#form-user.singup-form").slideUp("slow", function () {
            $("#form-user.login-form").slideToggle("slow");
        });
        return false;
    });
    $("#form-user.login-form #join-now").click(function () {
        if ($(window).width() < 992) {
            $("#wrapper2.structural-block").css("padding-top", "0");
            $(window).scrollTop(0);
            $("#header").css("position", "relative");
        }
        $("#form-user.login-form").slideToggle("slow", function () {
            $("#form-user.singup-form").slideToggle("slow");
        });
        return false;
    });
    //Menu Primary
    $('.box-menu .menu-category > li').each(function (i) {
        var more = $(this).find('ul .view-more').index();
        if (i < 2) {//Product, Project
            $(this).find('ul > li').each(function (i) {
                if (i > more) {
                    $(this).addClass('hidden');
                }
            });
        } else {
            $(this).find('ul > li').each(function () {
                $(this).find('ul > li').each(function (i) {
                    if (i > more) {
                        $(this).addClass('hidden');
                    }
                });
            });
        }
    });
    $('.box-menu .menu-category .view-more').click(function () {
        $(this).parent('ul').find('li').each(function () {
            $(this).removeClass('hidden');
        });
        $(this).addClass('hidden');
        return false;
    });
    $(document).on("keyup", "input[type = password]", function (event) {
        if (event.keyCode == 32) {
            $(this).val($(this).val().replace(" ", ""));
        }
    })

});
var top_seach = 0;
$(document).on("click", "#header .mobile-seach #seach-sumit", function () {
    $("#form-user").slideUp("slow");
    $(".col-search").slideToggle("slow");
});
$(document).on("click", ".destop-seach .box-seach .close-seach", function () {

});

$(document).on("click","#login-check",function(){
    if(typeof $(this).attr("href") !== "undefined"){
        url_reload = $(this).attr("href");
    }
    return check_login();
})
$(document).on("click", ".card-info .close_box", function () {
    $(this).parents(".card-info").slideUp("slow");
});
$(document).on("click", "#button-close-form", function () {
    $(this).parents(".parent-box-show").animate({top: -1000}, 1000);
    return false;
});
$(window).scroll(function () {
    var wintop = $(this).scrollTop();
});
/*check email*/
function valid_email(text) {
    filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (!filter.test(text)) {
        return false;
    } else {
        return true;
    }
}
/*check password*/
function valid_password(text) {
    if (text.trim().length < 6) {
        return false;
    } else {
        return true;
    }
}
/*popup messenger check valid and messenger successfully*/
function messenger_box(title, warning, type) {
    if (type == "error") {
        $("#title-messenger").html("Oh, <span class='moderate-cyan-color'>@</span><span class='orange-color'>#</span><span class='strong-red-color'>%</span><span class='moderate-green-color'>&</span><span class='very-dark-gray-color'>!</span>");
    } else {
        $("#title-messenger").html(title);
    }
    $("#warning-messenger").html(warning);
    $("#messenger-box").modal({backdrop:false});
}
function ajax_request() {
    var data_recoder;
    this.begin = function (function_begin) {
        function_begin();
    }
    this.ajax = function (url, data) {
        $.ajax({
            url: base_url + url,
            async: false,
            type: 'POST',
            data: data,
            dataType: "json",
            success: function (data_ajax) {
                data_recoder = data_ajax;
            },
            error: function (data) {
                data_recoder = "error";
            }
        });
        return data_recoder;
    }
    this.success = function (function_success) {
        if (this.ajax.length > 0) {
            function_success();
        }
    }
}
/*check input in element_parent and data-valid = true */
function valid_form(element_parent, warning_class, show_messenger) {
    var valid = 0;
    var type_password = "";
    var messenger = [];
    element_parent.find("[data-valid]").removeClass(warning_class);
    $.each(element_parent.find("[data-valid]"), function () {
        if ($(this).attr("data-valid") == "true") {
            if ($(this).attr("type") == "text") {
                if ($(this).val() == "") {
                    $(this).addClass(warning_class);
                    valid++;
                    messenger.push("Please enter your " + $(this).attr("title").replace("-", " ").replace("_", " "));
                }
            } else if ($(this).attr("type") == "email") {
                if (!valid_email($(this).val())) {
                    $(this).addClass(warning_class);
                    valid++;
                    messenger.push("Please enter a valid " + $(this).attr("title").replace("-", " ").replace("_", " "));

                }
            } else if ($(this).attr("type") == "password") {
                if (type_password == "") {
                    if (!valid_password($(this).val())) {
                        $(this).addClass(warning_class);
                        valid++;
                        messenger.push($(this).attr("title").replace("-", " ").replace("_", " ") + " must be at least 6 characters long");
                    } else {
                        type_password = $(this).val();
                    }
                } else {
                    if (type_password != $(this).val()) {
                        $(this).addClass(warning_class);
                        valid++;
                        messenger.push("Password does not match.");
                    }
                }
            } else if ($(this).attr("type") == "number") {
                if (!isNaN($(this).val())) {
                    $(this).addClass(warning_class);
                    valid++;
                    messenger.push("Please enter required field " + $(this).attr("title").replace("-", " ").replace("_", " "));
                }
            } else {
                if ($(this).val() == "") {
                    $(this).addClass(warning_class);
                    valid++;
                    messenger.push("Please enter required field " + $(this).attr("title").replace("-", " ").replace("_", " "));
                }
            }
            if ($(this).attr("id") == "email" && $(this).val() != "" && $(this).attr("type") != "email") {
                if (!valid_email($(this).val())) {
                    $(this).addClass(warning_class);
                    valid++;
                    messenger.push("Please enter a valid " + $(this).attr("title").replace("-", " ").replace("_", " "));
                }
            }

        }
    });
    if (valid > 0) {
        var messenger_text = "";
        var i = 0;
        $.each(messenger, function (key, value) {
            i++;
            messenger_text += "<p>" + value + "</p>";
        });
        return messenger_text;
    } else {
        return true;
    }
}
/*clear input = " " of for-parent(#id)*/
$(document).on("click", "#clear", function () {
    var parent = $(this).parents("form");
    clear_text(parent);
    return false;
});
$(document).on("click", "#clear-text", function () {
    clear_text($(this).parents(".card-info"));
    $(this).parents(".card-info").find("#add-comment").removeAttr('data-edit-id');
});
$(document).on("click", "#header .box-refine .refine-search", function () {
    $("#header .box-refine .box-refine-search").toggleClass("block");
    return false;
});
function to_slug(str) {
    str = str.toLowerCase();
    str = str.replace(/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/g, 'a');
    str = str.replace(/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/g, 'e');
    str = str.replace(/(ì|í|ị|ỉ|ĩ)/g, 'i');
    str = str.replace(/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/g, 'o');
    str = str.replace(/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/g, 'u');
    str = str.replace(/(ỳ|ý|ỵ|ỷ|ỹ)/g, 'y');
    str = str.replace(/(đ)/g, 'd');
    str = str.replace(/([^0-9a-z-\s])/g, '');
    str = str.replace(/(\s+)/g, '-');
    str = str.replace(/^-+/g, '');
    str = str.replace(/-+$/g, '');
    return str;
}
function check_login() {
    if (is_login != 1) {
        $("#form-user.singup-form").slideUp("slow");
        $("html, body").animate({scrollTop: 0}, "slow", function () {
            $("#form-user.login-form").slideDown("slow");
            $("#form-user.login-form #email").focus();
        });
        $(".modal").modal('hide');
        return false;
    }
}

function clear_text(box) {
    $.each(box.find("input:not([type='submit']),textarea"), function () {
        $(this).val("");
    });
}
$(document).on("click", "#redirect-href", function () {
    if ($(this).attr("id") == "redirect-href") {
        window.location.href = $(this).data("href");
    }

});
$(document).on("click", "#redirect-href .send-photo", function () {
    return false;
});
$(document).on("click", "#get-started", function () {
   
    $("html, body").animate({scrollTop: 0}, "slow", function () {
        if ($(window).width() < 992) {
            $("#wrapper2.structural-block").css("padding-top", "0");
            $("#header").css("position", "relative");
        }
        $("#form-user.login-form").slideUp("slow");
        $("#form-user.singup-form").slideDown("slow");
    });

    return false;
});
$(document).on("click","#get-signin",function(){
    $("#how-it-works-buyer-2").modal("hide");
    $("#how-it-works-buyer").modal("hide");
    $("#how-it-works-buyer-1").modal("hide");
    $("html, body").animate({scrollTop: 0}, "slow", function () {
        if ($(window).width() < 992) {
            $("#wrapper2.structural-block").css("padding-top", "0");
            $("#header").css("position", "relative");
        }
        $("#form-user.login-form").slideDown("slow");
        $("#form-user.singup-form").slideUp("slow");
    });
    return false;
});
$(document).on("click", ".box-refine-search #close-form", function () {
    $(this).parents(".box-refine-search").removeClass("block");
});

$(document).on("click", ".btn-upload:not(.not_login)", function () {
    if (check_login() == false) {
        return false;
    }
});
function deletepoppup(url){
    $("#modal_delete #ok-delete").attr("href",url);
    $("#modal_delete").modal();
    return false;
}
function tracking_share(type,type_post,id_post){
    $.ajax({
        url:base_url+"home/tracking_share",
        type:"post",
        data:{"type":type,"type_post":type_post,"id_post":id_post},
        success:function(data){
            console.log(data);
        },error:function(){

        }
    });
}