var number_nav_page = 30;
var present_page = 1;
var defaul_click = 0;
var arg_record = [];
var number_page = 0;
var defaul_number_results = parseInt($(".gird-img").attr("data-count"));
var reset = 0;
var new_image = 0;
$('#share-social-modal').on('hidden.bs.modal', function () {
    $("body").addClass("modal-open");
});
var width_same;
$(window).load(function () {
    width_same = $(".item-slider-same").width() - 10;
    $.each($(".item-slider-same .bx-slider-same"),function(){
        _this = $(this);
        var slider_same = _this.bxSlider({
            auto: false,
            minSlides: 1,
            maxSlides:5,
            slideMargin: 0,
            pager:false,
            slideWidth:width_same/5,
            slideMargin:4,
            moveSlides:1,
            infiniteLoop:false,
            onSliderLoad:function(e){
                _this.addClass("onload-success");
                _this.css({"visibility":"visible","max-height":"auto"});
            },
        });
        
        _this.find("li img").css("height",width_same/5+"px");
        _this.parents(".data-same").find(".number-same-photo").css({"height":width_same/5+"px","width":(width_same/5 - 4)+"px"});
        _this.parents(".item-slider-same").find("#more-slider").click(function(){
            var current = slider_same.getCurrentSlide();
            var countslider = slider_same.getSlideCount();
            var next = current + 5;
            if(next > (countslider-5)){
                next = countslider - 5;   
            }
            slider_same.goToSlide(next);
        }); 
    }); 
    $(".microsite > h3 > a").show();
    if ($("#refresh-new-image").length > 0) {
        $.ajax({
            url: base_url + "photos/new_imgaes",
            type: 'POST',
            dataType: 'json',
            data: {"id": 0},
            success: function (data) {
                if (data["success"] == "success") {
                    new_image = data["id"];
                }
            }
        });
        var time_load_chat = setInterval(function () {
         get_count_new_image();
        }, 30000);
    }
});
var imset = 0;
function get_count_new_image() {
    if (new_image != 0) {
        $.ajax({
            url: base_url + "photos/get_count_new_imgaes",
            type: 'POST',
            dataType: 'json',
            data: {"id": new_image},
            success: function (data) {
                if (data["success"] == "success" && parseInt(data["count"]) % 5 == 0 && data["count"] >= 5 && data["count"] > imset) {
                    imset = data["count"];
                    $("#refresh-new-image > a").attr("href",window.location.href);
                    $("#refresh-new-image > a").text(data["count"] + " New Images Posted");
                    $("#refresh-new-image").fadeIn("slow");
                }
            }
        });
    } else {
        $.ajax({
            url: base_url + "photos/new_imgaes",
            type: 'POST',
            dataType: 'json',
            data: {"id": 0},
            success: function (data) {
                if (data["success"] == "success") {
                    new_image = data["id"];
                }
            }
        });
    }
}
$(document).ready(function () {
    var screen_with = $(document).width();
    $(".structural-block .bar-search").css("max-width",(screen_with-45) + "px");
    $(".microsite > h3 > a").hide();
    /*---------------------------------------Advertise slider------------------------------------------------------*/
    $('.slide-logo').bxSlider({
        auto: true,
        slideWidth: 100,
        minSlides: 2,
        maxSlides: 8,
        slideMargin: 10
    });
    /*---------------------------------------company comment------------------------------------------------------*/
    var id_member = 0;
    var box_this = null;
    $(".company-content-box .comment-like .comment > h3 > span.glyphicon").click(function () {
        if (check_login() != false) {
            id_member = $(this).parents(".company-item").attr("data-id");
            box_this = $(this).parents(".company-item");
            $('#comment_company').modal();
        }
    });
    $(".company-item #post-comment").click(function () {
        $(this).parents(".company-item").find(".company-content-box .comment-like .comment > h3 > span.glyphicon").trigger("click");
        return false;
    });
    $("#email").attr("required", false);
    $("#comment_company #sent_comment").click(function () {
        var text = $(this).parents("#comment_company").find("#messenger").val();
        var box_comment = $(this).parents("#comment_company");
        $(this).parents("form").find("#messenger").removeClass("warning");
        if (text == "") {
            $(this).parents("form").find("#messenger").addClass("warning");
        }
        if (text != "" && reset_comment == 0 && check_login() != false) {
            reset_comment = 1;
            $.ajax({
                url: base_url + "comments/add/" + id_member + "/member",
                type: 'POST',
                dataType: "json",
                data: {
                    "text": text
                },
                success: function (data) {
                    if (data["status"] == "true") {
                        var num_comment = parseInt(box_this.find("#num-comment").text()) + 1;
                        box_this.find("#num-comment").html(num_comment);
                        box_comment.find("#messenger").val("");
                        var logo = base_url + "skins/images/signup.png";
                        if (data["logo"] != "") {
                            logo = base_url + data["logo"];
                        }
                        box_this.find(".company-content-box.expand-height").append('<div class="comment-item"><a href="' + base_url + 'profile/index/' + data["member_id"] + '"><img class="media-object" src ="' + logo + '" width="46" height="46"><p><strong>' + data["full_name"] + ' | ' + data["company"] + '</strong></a></p><p>' + text + '</p></div>');
                    } else {
                        messenger_box("Error message", "Implementation process fails.");
                    }
                    reset_comment = 0;
                },
                error: function () {
                    messenger_box("Error message", "Implementation process fails.");
                    reset_comment = 0;
                }
            });
        }

    });
    /*---------------------------------------!company comment------------------------------------------------------*/
    // apply matchHeight to each item container's items
    $('.row-height').each(function () {
        $(this).find('.inner-height').matchHeight({
            byRow: true,
        });
    });
    $(".forgot_page #form-forgot,.reset_pw #form-forgot").submit(function (event) {
        event.stopPropagation();
        var valid_form1 = valid_form($(this), "warning", true);
        if (valid_form1 != true) {
            return false;
        }
    });
    /* signin ajax*/
    $("#form-user.login-form #sign-in").click(function () {
        $("#form-user.login-form .error").html("");
        if (valid_form($("#form-user.login-form"), "warning", false) == true) {
            var text_mail = $(this).parents(".login-form").find("#email").val();
            var password = $(this).parents(".login-form").find("#password").val();
            var project_id = $(this).parents(".login-form").find("#project_id").val();
            var token = $(this).parents(".login-form").find("#token").val();
            var data = {
                "email": text_mail,
                "password": password,
                "project_id": project_id,
                "token": token
            };
            $(this).prop('disabled', 'disabled');
            var ajax_this = $(this);
            $.ajax({
                url: base_url + "accounts/signin",
                type: 'POST',
                data: data,
                dataType: "json",
                success: function (data_ajax) {
                    if (data_ajax["success"] == "success") {
                        window.location.href = url_reload;
                    } else {
                        var messenger = "";
                        var i = 0;
                        $.each(data_ajax["messenger"], function (key, value) {
                            ;
                            i++;
                            $(".login-form #" + key + "").addClass("warning");
                            messenger += "<p>" + value + "</p>";
                        });
                        $("#form-user.login-form .error").html(messenger);
                        ajax_this.removeAttr('disabled');
                    }
                },
                error: function (data_ajax) {
                    messenger_box("Error message", "Error message");
                    ajax_this.removeAttr('disabled');
                }
            });
        } else {
            var error_ = valid_form($("#form-user.login-form"), "warning", false);
            $("#form-user.login-form .error").html(error_);
        }
        return false;
    });
    /* signup ajax*/
    $(".singup-form #upload-avatar-control").click(function () {
        $(this).parents(".singup-form").find("#upload_avatar").trigger("click");
    });
    $("#form-user.singup-form #form-user-input").submit(function (event) {
        var valid_form1 = valid_form($("#form-user.singup-form"), "warning", true);
        $("#form-user.singup-form .error").html("");
        if (valid_form1 == true) {
            var company = $(this).parents(".singup-form").find("#company").val();
            var first_name = $(this).parents(".singup-form").find("#first-name").val();
            var last_name = $(this).parents(".singup-form").find("#last-name").val();
            var email = $(this).parents(".singup-form").find("#email").val();
            var password = $(this).parents(".singup-form").find("#password").val();
            var project_id = $(this).parents(".singup-form").find("#project_id").val();
            var token = $(this).parents(".singup-form").find("#token").val();
            var url = (typeof (project_id) == 'undefined' || $.trim(project_id) == '') ? window.location.href : '/designwalls/index/' + project_id;
            $("#header #form-user .loadding").show();
            var messenger = "";
            var i;
            var options = {
                dataType: 'json',
                success: function (responseText, statusText, xhr, $form) {
                    messenger = "";
                    if (responseText["success"] == "success") {
                        messenger = "<p>Signup Successfully</p>";
                        if (responseText["messenger"]) {
                            messenger = "<p>Signup Successfully</p>";
                            i = 1;
                            $.each(responseText["messenger"], function (key, value) {
                                i++;
                                messenger += "<p>" + value + "</p>";
                            });
                            messenger_box("Message", messenger);
                            setTimeout(function () { 
                                if(url_reload != window.location.href){
                                    window.location.href = url_reload;
                                }else{
                                    window.location.href = base_url + "company/edit";
                                }
                            }, 4000);
                        } else {
                            if(url_reload != window.location.href){
                                window.location.href = url_reload;
                            }else{
                                window.location.href = base_url + "company/edit";
                            }
                        }
                    } else {
                        i = 0;
                        $.each(responseText["messenger"], function (key, value) {
                            i++;
                            messenger += "<p>" + value + "</p>";
                        });
                        $("#form-user.singup-form .error").html(messenger);
                    }
                    $("#header #form-user .loadding").hide();
                }
            };
            $(this).ajaxSubmit(options);
        } else {
            var tmp = valid_form1.split('</p><p>');
            $("#form-user.singup-form .error").html(tmp[0] + '</p>');
        }
        return false;
    });
    $.each($(".box-refine .right-box li"), function () {
        if ($(this).find("ul").hasClass("parents") == true) {
            $(this).addClass("li-parents").append('<div class="dropdown-category"><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span></div>');
        }
    });
    $(document).on('click', function (e) {
        if ($(e.target).closest(".box-refine-search").length === 0) {
            $(".box-refine-search").removeClass('block');
        }
    });
    $(document).on('click', function (e) {
        var width_box_seach = $(".structural-block .bar-search").width();
        if ($(e.target).closest(".structural-block .bar-search").length === 0) {
            $(".bar-search").animate({left:(-width_box_seach)+"px"});
            $(".bar-search .tem-open").removeClass("open");
        }
    });
    $.each($(".box-refine-search .right-box.category"), function () {
        var li_top = "<li id='0'><a href='#'>" + $(this).find(">p").text() + "</a></li>";
        $(this).find(">ul").prepend(li_top);
    });
    var all_category_get = location_photo + all_category;
    var category_search = all_category_get.slice(0, (all_category_get.length - 1));
    var res = [];
    if (category_search != "") {
        res = category_search.split(",");
    }
    res = res.sort();
    if (res.length > 0) {
        var _parentdata ;
        $.each($(".box-refine-search"),function(){
            _parentdata = $(this);
            $.each(res, function (key, value) {
                if (value.trim() != "") {
                    if(value == 1){
                        _parentdata.find(".indoor").prop("checked",true);
                    }
                    if(value == 2){
                        _parentdata.find(".outdoor").prop("checked",true);
                    }
                    $.each(_parentdata.find("#"+value), function () {

                        var tagname = $(this).prop("tagName");
                        if (tagname == "INPUT") {
                            $(this).prop("checked", true);
                        }
                        if (tagname == "LI") {
                            $(this).parents(".category").find(">p").remove();
                            var text_li = "<p id ='" + value + "'>" + $(this).find(">a").text() + "<span class='glyphicon glyphicon-menu-down' aria-hidden='true'></span></p>";
                            $(this).parents(".category").prepend(text_li);
                        }
                    });
                }
            });
        })
        
    }

    function split(val) {
        return val.split(/,\s*/);
    }

    function extractLast(term) {
        return split(term).pop();
    }
    $("#search-service").bind("keydown", function (event) {
        if (event.keyCode === $.ui.keyCode.TAB &&
                $(this).autocomplete("instance").menu.active) {
            event.preventDefault();
        }
    }).autocomplete({
        minLength: 0,
        source: function (request, response) {
            var arg_business = request.term.split(",");
            var keyword_business = arg_business[(arg_business.length - 1)];
            if (keyword_business != "") {
                $.ajax({
                    url: base_url + "services/get_business_categories",
                    type: "post",
                    dataType: "json",
                    data: {
                        "keyword": keyword_business,
                        "business_type": business_type
                    },
                    success: function (data) {
                        response($.ui.autocomplete.filter(data, extractLast(keyword_business)));
                    }
                });
            }

        },
        focus: function () {

            return false;
        },
        select: function (event, ui) {
            var terms = split(this.value);
            terms.pop();
            terms.push(ui.item.value);
            terms.push("");
            this.value = terms.join(",");
            var value_input_business = terms[(terms.length - 2)];
            if (value_input_business == "Search all " + business_type + "") {
                this.value = value_input_business;
            } else {
                this.value = this.value.replace("Search all " + business_type + ",", "");
            }
            return false;
        }
    });
    $("#page_service .pagination li > a").click(function () {
        return false;
    });
    $("#page_service .pagination li:not(.disabled,.active) > a").click(function (event) {
        event.stopPropagation();
        $(this).parents("#page_service").find("input[name = perpage]").val($(this).attr("href"));
        $(this).parents("#page_service").trigger("submit");
        return false;
    });
    $("#messenger-box").on("hidden.bs.modal", function () {
        if(defaul_click == 1){
            defaul_click = 0;
            $("body").addClass("modal-open");
        }
    });
    $(".bar-search .tem-open").click(function(){
        var width_box_seach = $(".structural-block .bar-search").width();
        if($(this).hasClass("open")){
            $(".structural-block .bar-search").animate({left:(-width_box_seach)+"px"});
            $(this).removeClass("open");
        }else{
            $(".structural-block .bar-search").animate({left:"0px"});
            $(this).addClass("open");
        }
    });
});

$(document).on("click", ".box-refine .right-box.category", function () {
    if ($(this).find(">ul").hasClass("block") == true) {
        $(this).find(">ul").removeClass("block");
    } else {
        $(".box-refine .right-box.category > ul.block").removeClass("block");
        $(this).find(">ul").addClass("block");
    }
});
$(document).on("click", ".box-refine .right-box.category li", function () {
    var tagname_parent = $("#seach-home-photo").prop("tagName");
    all_category = "";
    var text = $(this).find(">a").text() + '<span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>';
    var id = $(this).attr("id");
    $(this).parents(".category").find("p").attr("id", id).html(text);
    $(".box-refine .right-box.category > ul.block").removeClass("block");
    return false;
});
$(document).on("click", ".box-refine-search .show-parent", function () {
    $(this).toggleClass("show");
    $(this).parents(".li-parents").find(".parents").toggleClass("block");
    return false;
});
$(document).on("click", ".li-parents .dropdown-category span", function (event) {
    event.stopPropagation();
    $(this).parent().parent().find("> ul.parents").toggleClass("block");
    if ($(this).parent().parent().hasClass("show_parent") != true) {
        $(this).parent().parent().addClass("show_parent");
        $(this).parent().parent().find(" > .dropdown-category").html('<span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span>');
    } else {
        $(this).parent().parent().removeClass("show_parent");
        $(this).parent().parent().find(" > .dropdown-category").html('<span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span>');
    }
});
/*-------------------------------paging seach----------------------------*/
$(document).on("keyup", "#header #seach-home-photo #input-seach", function (event) {
    if (event.keyCode == 13) {
        $(this).parents("#seach-home-photo").find(".seach-sumit").trigger("click");
    }
});
get_page();
$(document).on("click", "#find-search", function () {
    $(this).parents("#box-refine-common").find("#seach-home-photo .seach-sumit").trigger("click");
});
$(document).on("click", "#clear-find-search", function () {
    $.each($(".right-box.location .menu-location input[type=checkbox]:checked"), function () {
        $(this).prop("checked", false);
    });
    $.each($(".right-box.category"), function () {
        $(this).find(" > p").remove();
        var text_li = "<p id ='0'>" + $(this).find("li#0 >a").text() + "<span class='glyphicon glyphicon-menu-down' aria-hidden='true'></span></p>";
        $(this).prepend(text_li);
    });
    all_category = "";
    location_photo = "";
});
$(document).on("submit", "#seach-home-photo", function () {
    $(".box-seach .like_search").remove();
    keyword = $(this).find('#input-seach').val();
    location_photo = "";
    $.each($(this).parents("#box-refine-common").find(".right-box.location .menu-location input[type=checkbox]:checked"), function () {
        location_photo += $(this).val() + ",";
    });
    $(this).find("#location").val(location_photo);
    $.each($(".right-box.category "), function () {
        var idpareant_category = $(this).find(" > p").attr("id");
        if (idpareant_category != 0) {
            all_category += idpareant_category + ",";
        }
    });
    $(this).find("#all_category").val(all_category);
    $(".box-refine .box-refine-search.block").removeClass("block");
});
var top_left_profile = 0;
var get_height = 0;
$(window).scroll(function () {
    if (($(window).scrollTop() + $(window).height() + 4000) >= $(document).height() && number_page > present_page && reset == 0 ) {
        reset = 1;
        get_record_search("false");
        present_page++;
    }
    var top_set = top_left_profile.top;
    if ($(window).scrollTop() >= (top_set - 50)) {
        $("body #box-like-profile").removeClass("hie");
        if ($("body #box-like-profile").hasClass("slow") == false) {
            $("body #box-like-profile").css({"position": "fixed", "margin-top": "0", "top": get_height + "px"});
            $("body #box-like-profile").addClass("slow");
        }
    } else {
        $("body #box-like-profile").removeClass("slow");
        if ($("body #box-like-profile").hasClass("hie") == false) {
            $("body #box-like-profile").css({"position": "static", "top": top_set + "px"});
            $("body #box-like-profile").addClass("hie");
        }
    }

});
function before_search() {
    $(".gird-img .loadding").show();
}
var width_paging =  $(window).width() ;
function get_record_search(page_get) {
    
    before_search();
    $.ajax({
        url: base_url + "photos/seachimages",
        type: 'POST',
        dataType: "json",
        data: {
            "location_photo": location_photo,
            "keyword": keyword,
            "catalog" : catalog,
            "all_category": all_category,
            "nav": present_page,
            "number_nav_page": number_nav_page,
            "type_photo": photo_type,
            "slug_category": slug_category,
            "offer_product": offer_product,
            "is_home" : is_home,
            "post_social_show" : post_social 
        },
        success: function (data) {

            arg_record = data["photo"];
            if (arg_record.length > 0) {
                var nav_html = 3;
                if (is_business  != "1" && data["login"] == true && current_page != "search") {
                    nav_html = 2;
                }
                var nav_set = Math.ceil(data["photo"].length / nav_html);
                $.each(arg_record, function (key, value) {
                    if(width_paging > 768){
                        if (nav_html == 2) {
                            if ((key + 1) <= nav_set) {
                                $(".gird-img .cards #grid-column-1").append(value);
                            } else {
                                $(".gird-img .cards #grid-column-2").append(value);
                            }
                        } else if (nav_html == 3) {
                            if ((key + 1) <= nav_set) {
                                $(".gird-img .cards #grid-column-1").append(value);
                            } else if ((key + 1) <= nav_set * 2) {
                                $(".gird-img .cards #grid-column-2").append(value);
                            } else {
                                $(".gird-img .cards #grid-column-3").append(value);
                            }
                        }
                    }else{
                        if (nav_html == 2) {
                            $(".gird-img .cards #grid-column-2").append(value);
                        }else{
                             $(".gird-img .cards #grid-column-3").append(value);
                        }
                    }
                    
                });

            }
            after_search();
            $.each($(".item-slider-same .data-same .bx-slider-same:not(.onload-success)"),function(key,value){
                var data_this = $(this);
                var slider_same = data_this.bxSlider({
                    auto: false,
                    minSlides: 1,
                    maxSlides:5,
                    slideMargin: 0,
                    pager:false,
                    slideWidth:width_same/5,
                    slideMargin:4,
                    moveSlides:1,
                    infiniteLoop:false,
                    onSliderLoad:function(e){
                        data_this.addClass("onload-success");
                        data_this.css({"visibility":"visible","max-height":"auto"});
                    }
                });
                data_this.find("li img").css("height",(width_same/5)+"px");
                data_this.parents(".data-same").find(".number-same-photo").css({"height":width_same/5+"px","width":(width_same/5 - 4)+"px"});
                data_this.parents(".item-slider-same").find("#more-slider").click(function(){
                    var current = slider_same.getCurrentSlide();
                    var countslider = slider_same.getSlideCount();
                    var next = current + 5;
                    if(next > (countslider-5)){
                        next = countslider - 5;   
                    }
                    slider_same.goToSlide(next);
                }); 
            }); 
           
        }, error: function (data, error) {
            after_search();
        }
    });
}
function get_page() {
    var page = defaul_number_results / number_nav_page;
    page = ("" + page).split(".");
    if (page.length > 1) {
        number_page = parseInt(page[0]) + 1;
    } else {
        number_page = parseInt(page[0]);
    }
}
function after_search() {
    $(".gird-img .loadding").hide();
    reset = 0;
}
/*-------------------------------!paging seach----------------------------*/
/*-------------------------------like photo----------------------------*/
var reset_like = 0;
$(document).on("click", "#like-photo", function () {
    if (check_login() != false) {
        var this_total = $(this);
        var photo_id_like = $(this).attr("data-id");
        var object = 'photo';
        if (typeof $(this).attr('data-object') != 'undefined' && $(this).attr('data-object') != null) {
            object = $(this).attr('data-object');
        }
        if (isNaN(photo_id_like) == false && photo_id_like != "" && reset_like == 0) {
            var number_like = parseInt(this_total.parents(".likes").find("#number-like").text());
            reset_like = 1;
            $.ajax({
                url: base_url + "photos/like/" + object,
                type: 'POST',
                dataType: "json",
                data: {
                    "photo_id": photo_id_like
                },
                success: function (data) {
                    if (data["status"] == "false") {
                        messenger_box("Error message", data["message"]);
                    } else if (data["success"] == "success") {
                        var img_like = "";
                        var title_like = "Click here to like.";
                        if (data["like"] == 1) {
                            img_like = "like";
                            title_like = "Click here to unlike.";
                        } else {
                            this_total.find(" > i").removeClass("like");
                        }
                        if(data["record_tracking"] == 0){
                            this_total.parents(".commen-like").find("#number-like").html("");
                            this_total.parents(".like-blog").find("#number-like").html("");
                        }else{
                            this_total.parents(".commen-like").find("#number-like").html(data["record_tracking"]+" Likes");
                            this_total.parents(".like-blog").find("#number-like").html(data["record_tracking"]+" Likes");
                        }
                        
                        this_total.find(" > i").addClass(img_like).attr("title", title_like);
                    }
                    reset_like = 0;
                },
                error: function () {
                    reset_like = 0;
                }
            });
        }
    }
});

/*-------------------------------!like photo----------------------------*/
$(document).on("click", ".impromation-project .glyphicon-menu-down", function () {
    $(this).parents(".impromation-project").find(".dropdown-impromation-menu").toggleClass("block");
    return false;
});
var photo_id;
var title;
var message;
var object_reporting = "photos";
$(document).on("click", ".impromation-project :not(#services-report) .dropdown-impromation-menu:not(#deziwall) a:not(.not-report),#services-report #report-company", function () {
    $("#reporting_modal").find("#messenger").removeClass("warning");
    if (check_login() != false) {
        photo_id = $(this).parents("#wrapper-impormant-image").attr("data-id");
        title = $(this).text();
        if (typeof $(this).attr("data-reporting") != 'undefined') {
            object_reporting = $(this).attr("data-reporting");
        }
        $('#reporting_modal').modal();
    }
    return false;
});

$(document).on("click", "#reporting_modal #sent-report", function () {
    message = $(this).parents("#reporting_modal").find("#messenger").val();
    if (message.trim() != "") {
        sent_report(photo_id, message, title, object_reporting);
    } else {
        $(this).parents("#reporting_modal").find("#messenger").addClass("warning");
    }
});
$(document).on("click", "#report-image", function () {
    object_reporting = "photo";
    photo_id = $(this).data("id");
    if ($(this).data("type") == "image") {
        object_reporting = "photo";
    } else {
        object_reporting = $(this).data("type");
    }
    $("#reporting_images .type-report").text($(this).data("type"));
    $('#reporting_images').modal();
    return false;
});
$(document).on("click", "#reporting_images #sent-report", function () {
    $("#reporting_images").find("#messenger").removeClass("warning");
    message = $(this).parents("#reporting_images").find("#messenger").val();
    title = $(this).parents("#reporting_images").find("input[name = reporting]:checked").val();
    if (message.trim() != "") {
        sent_report(photo_id, message, title, object_reporting)
    } else {
        $(this).parents("#reporting_images").find("#messenger").addClass("warning");
    }
});
$(document).on("click", "#share-social", function () {
    if ($(this).data("type") == "profile") {
        $("#share-modal .text-share-tip").text("Did our profile catch your eye? Thank you for taking the time to share us with your friends and colleagues! ");
    }
    photo_id = $(this).attr("data-id");
    var url_photo = $(".photo-detail").attr("src");
    $("#share-modal #photo-share").attr("src", url_photo);
    $("#share-modal #share-image-email").attr("data-reporting", $(this).attr("data-reporting"));
    $('#share-modal').modal();
    return false;
});
$(document).on("click", "#share-social-photo", function () {
    photo_id = $(this).attr("data-id");
    var url_photo = $(this).parents('.card-image').find('.photo-details').attr("src");
    $("#share-modal #photo-share").attr("src", url_photo);
    $("#share-modal #share-image-email").attr("data-reporting", $(this).attr("data-reporting"));
    $('#share-modal').modal();
    return false;
});
function sent_report(photo_id, message, title, object_reporting) {
    $.ajax({
        url: base_url + "home/send_mail_flag",
        type: "post",
        data: {
            'id': photo_id,
            "message": message,
            "title": title,
            "object_reporting": object_reporting
        },
        success: function (data) {
            if (data.trim() == "success") {
                $('#reporting_modal').modal('hide');
                $('#reporting_images').modal('hide');
                messenger_box("Message", "Email sent successfully");
            } else {
                $('#reporting_modal').modal('hide');
                $('#reporting_images').modal('hide');
                messenger_box("Error message", "Implementation process fails");
            }
        },
    });
}

var type_sent_mail = "photo";
var company_name = "Company name";
var url_site_send = "";
$(document).on("click","#modal_sendmessenger_like .comment-items .button-signin",function(){
    if(check_login() == false) return false;
    $("#sentmail-like #email").val($(this).attr("data-email"));
    $("#sentmail-like #full-name").val($(this).attr("data-full-name"));  
    $("#sentmail-like #message").val("Take a look at this great space that I found on Dezignwall, and let me know what you think.");
    url_site_send = "";
    photo_id = $(this).attr("data-id");
    $('#sentmail-like').modal();
    return false;
});

$(document).on("click", "#share-image-email", function () {
    $type = $(this).data("type");
    if($type == "article"){
        $("#sent_image #message").val("Take a look at this great article that I found on Dezignwall. Let me know what you think.");
    }else{
        $("#sent_image #message").val("Take a look at this great space that I found on Dezignwall, and let me know what you think.");
    }
    if (typeof $(this).parents("#wrapper-impormant-image").attr("data-id") != "undefined") {
        photo_id = $(this).parents("#wrapper-impormant-image").attr("data-id");
    }
    if(typeof $(this).attr("data-id") != "undefined" && $(this).attr("data-id")!=""){
        photo_id = $(this).attr("data-id");
    }
    var type = $(this).attr("data-reporting");
    if (typeof type != 'undefined') {
        type_sent_mail = type;
        company_name = $(this).attr("data-name");
    }
    url_site_send = window.location.href;
    $('#sent_image').modal();
    return false;
});

$(document).on("click", "#sendmail", function () {
    var check_form = valid_form($(this).parents("#sent_image"), "warning", true);
    if (check_form == true) {
        var email = $(this).parents(".modal-content").find("#email").val();
        var subject = $(this).parents(".modal-content").find("#subject").val();
        var message = $(this).parents(".modal-content").find("#message").val();
        $.ajax({
            url: base_url + 'home/sendmail',
            type: 'post',
            data: {
                'email': email,
                'subject': subject,
                'photo_id': photo_id,
                'message': message,
                'url': url_site_send,
                'type_sent_mail': type_sent_mail,
                'company_name': company_name
            },
            success: function (data) {
                console.log(data);
                if (data.trim() == 'success') {
                    $('#sent_image').modal('hide');
                    messenger_box("Message", "Email sent successfully.");

                } else {
                    $('#sent_image').modal('hide');
                    messenger_box("Message", "Email sent unsuccessful.");
                }
            },
            error: function () {
                $('#sent_image').modal('hide');
                messenger_box("Message", "Email sent unsuccessful.");
            }
        });
    }
    return false;
});
/*---------------------------------------Pin to wall-------------------------------------------------------*/
var type_designwall = 0;
var number_project_owner = 0;
var pin_project = "";
var pin_category = "";
var more_click   = ""
var upgrade_now = false;
$(document).on("click", "#pins-to", function () {
    pin_project = "";
    pin_category = ""
    $("#new-project").hide();
    $("#add_upgrade").hide();
    $("#add_new_project").show();
    if (check_login() != false) {
        $("#pin_to_wall .chose-value").removeClass("chose-value");
        $("#pin_to_wall #new-project").val("");
        $("#pin_to_wall #pin-new-category").val("");
        $("#pin_to_wall #pin-comment").val("");
        $("#pin_to_wall #pin-category").hide();
        $("#pin-new-category").hide();
        var htmlct = '';
        $("#box-all-category .box-wall-pin").html(htmlct);
        $(".common-box-wall #more_wall").remove();
        var html = '';
        photo_id = $(this).parents("#wrapper-impormant-image").attr("data-id");
        var url_img = $(this).parents("#wrapper-impormant-image").find(".wrapper-image .item > img").attr("src");
        if(typeof url_img == "undefined"){
            url_img = $(this).parents("#wrapper-impormant-image").find(".card-image .photo-details").attr("src");
        }
        $("#pin_to_wall #image-pin").attr("src", url_img);
        $.ajax({
            url: base_url + 'photos/get_project_member',
            type: 'post',
            dataType: 'json',
            data: {
                'photo_id': photo_id,
            },
            success: function (data) {
                var user_onew = "";
                if (data["success"] == "success") {
                    type_designwall = data["type_designwall"];
                    number_project_owner = data["number_project_owner"];
                    if (data["reponse"].length > 0) {
                        $.each(data["reponse"], function (key, value) {
                            if (value["first_name"] != "" || value["last_name"] != "") {
                                user_onew = value["first_name"] + " " + value["last_name"] ;
                            }
                            if(key > 2){
                                 html += "<li data-value = '" + value['pr_id'] + "'>" + value['project_name'] + " - " + user_onew + "</li>";
                            }else{
                                html += "<li class='show' data-value = '" + value['pr_id'] + "'>" + value['project_name'] + " - " + user_onew + "</li>";
                            }
                           
                            user_onew = "";
                        });
                        html = "<ul>"+html+"</ul>";

                    }
                    if (type_designwall > number_project_owner) { 
                        upgrade_now = false;
            
                    } else {
                        upgrade_now = true;
                    }
                    $("#box-all-wall .box-wall-pin").html(html);
                    if(data["reponse"].length > 3){
                        $("#box-all-wall").append("<a href='#' id='more_wall'>MORE</a>");
                    }else{
                        $("#box-all-wall #more_wall").remove();
                    }
                    $('#pin_to_wall').modal();
                } else {
                    messenger_box("Message", "Implementation process fails.");
                }
            },
            error: function () {
                messenger_box("Message", "Implementation process fails.");
            }
        });
    }
    return false;
});
$(document).on("click","#pin_to_wall #add_new_project",function(){
    if(upgrade_now == true){
        $("#add_upgrade").show();
        $("#add_new_project").hide();
    }else{
        $("#pin_to_wall #new-project").toggle();
        $("#pin_to_wall #pin-new-category").toggle();   
    }
    $("#box-all-category").hide();
    $("#box-all-wall .chose-value").removeClass("chose-value");
    pin_project = "";
    pin_category = "";
    return false;
});
$(document).on("click",".common-box-wall #more_wall",function(){
    var datashow = $(this).parents(".common-box-wall").find(".box-wall-pin ul li.show").length;
    datashow = datashow - 1;
    datashow = datashow + 3;
    var data_max_key;
    $.each($(this).parents(".common-box-wall").find(".box-wall-pin ul li"),function(key,value){
        if(key <= datashow){
            $(this).addClass("show");
        }
        data_max_key = key
    });
    if(datashow >= data_max_key){
        $(this).parents(".common-box-wall").find("#more_wall").remove();
    }
    return false;
});
$(document).on("click", "#box-all-wall li", function () {
    var project_id = $(this).data("value");
    var html = '';
    pin_project = project_id;
    new_category = "";
    $("#box-all-wall .chose-value").removeClass("chose-value");
    $("#box-all-category .chose-value").removeClass("chose-value");
    $("#new-project").val("");
    $("#new-project").hide();
    $("#pin-new-category").val("");
    $("#pin-new-category").hide();
    $(this).addClass("chose-value");
    $("#messenger_upgrade").hide();
    $("#new-project").hide();
    if (project_id != 0 && project_id != "defaul") {
        $.ajax({
            url: base_url + 'photos/get_project_category',
            type: 'post',
            dataType: 'json',
            data: {
                'project_id': project_id
            },
            success: function (data) {
                if (data["success"] == "success") {
                    if (data["reponse"].length > 0) {
                        $("#pin-new-category").css("display", "none");
                        html = '';
                        $.each(data["reponse"], function (key, value) {
                            if(key > 2){
                                html += '<li data-value="' + value["category_id"] + '">' + value["title"] + '</li>';
                            }else{
                                html += '<li class="show" data-value="' + value["category_id"] + '">' + value["title"] + '</li>';
                            }
                        }); 
                    } 
                    html = "<ul>"+html+"</ul>";
                    $("#box-all-category .box-wall-pin").html(html);
                    if(data["reponse"].length > 3){
                        
                        $("#box-all-category").append("<a href='#' id='more_wall'>MORE</a>");
                    }else{
                        $("#box-all-category #more_wall").remove();
                    }
                    $("#box-all-category").show();
                    $("#pin-category").show();
                } else {
                    messenger_box("Message", "Implementation process fails.");
                }
                html = "";
                $("#pin_to_wall #pin-category").show();
            },
            error: function () {
                messenger_box("Error message", "Implementation process fails.");
            }
        });
    } else {
        if (project_id == "upgrade") {
            $("#messenger_upgrade").show();
        }
        if (project_id == 0) {
            $("#new-project").css("display", "block");
        }
        $("#pin-new-category").css("display", "block");
        $("#pin-category").hide();
    }
});
$(document).on("click", "#box-all-category ul li", function () {
    pin_category = $(this).data("value");
    $("#box-all-category .chose-value").removeClass("chose-value");
    $(this).addClass("chose-value");
    $("#pin-new-category").hide();
    $("#pin-new-category").val("");
});
$(document).on("click", "#pin_to_wall #add_new_category", function () {
    $("#box-all-category .chose-value").removeClass("chose-value");
    $("#pin-new-category").toggle();
    pin_category = "";
    return false;
});
$(document).on("click", "#save-dezignwall", function () {
    
    $("#pin_to_wall .warning").removeClass("warning");
    var new_project = $("#new-project").val();
    var new_category = $("#pin-new-category").val();
    var pin_comment = $("#pin-comment").val();
    if ((pin_project == "" && new_project == "") || (pin_category == "" && new_category == "")) {
        defaul_click = 1;
        if (pin_project == "" && new_project == "") {
            messenger_box("Error message", "Please choose a Dezignwall.");
            return false;
        }
        if (pin_category == "" &&new_category == "") {
            messenger_box("Error message", "Please enter folder name.");
            return false;
        }
        
    } else {
        defaul_click = 0;
        $.ajax({
            url: base_url + "photos/pin_to_wall",
            type: "POST",
            dataType: "json",
            data: {
                "photo_id": photo_id,
                "project_id": pin_project,
                "new_project": new_project,
                "category_id": pin_category,
                "new_category": new_category,
                "pin_comment": pin_comment
            },
            success: function (data) {
                if (data["success"] == "success") {
                    var number_pin = parseInt($("#num-pin").text()) + 1;
                    if (pin_comment != "") {
                        $("#num-comment").html(parseInt($("#num-comment").text()) + 1);
                    }
                    $("#num-pin").html(number_pin);
                    $('#pin_to_wall').modal('hide');
                    var content_html = '<div class="return-pins text-center"><a href="' + base_url + 'search" id="return-seach" class="btn btn-gray" name="return-seach">Return to Search</a>';
                    content_html += '<a href="' + base_url + 'designwalls/view/' + data["project_id"] + '" id="return-dezignwall" class="btn btn-primary" name="return-dezignwall">Go to your Dezignwall</a></div>';
                    messenger_box("Successfully saved to Dezignwall!", content_html);
                } else {
                    messenger_box("Error message", data["messenger"]);
                    defaul_click = 1;
                }
            },
            error: function () {
                $('#pin_to_wall').modal('hide');
                defaul_click = 0;
                messenger_box("Error message", "Implementation process fails.");
            }
        });
    }
});

/*---------------------------------------!Profile-------------------------------------------------------*/


$(document).on("click", ".microsite a", function () {
    if (is_business == "" && check_login() == false ) {
        url_reload = $(this).attr("href");
        return false;
    }
});
$(document).on("click","body .commen-like #myphoto_user",function(){
    if (is_business == "" && check_login() == false ) {
        url_reload = $(this).attr("href");
        return false;
    }
});
/*---------------------------------------!Pin to wall-------------------------------------------------------*/
/*---------------------------------------photo comment------------------------------------------------------*/
var reset_comment = 0;
$(document).on("keyup", ".image-page #comment-input", function (event) {
    if (event.keyCode == 13 && $(this).val() != "" && reset_comment == 0) {
        reset_comment = 1;
        var type = "photo";
        if(typeof $(this).data("object") !=="undefined"){
            type = $(this).data("object");
        }
        if (check_login() != false) {
            var object_id = $(this).parents("#wrapper-impormant-image").attr("data-id");
            var text = $(this).val();
            $.ajax({
                url: base_url + "comments/add/" + object_id + "/" + type,
                type: 'POST',
                dataType: "json",
                data: {
                    "text": text
                },
                success: function (data) {
                    if (data["status"] == "true") {
                        var qty = parseInt($("#num-comment").text()) + 1;
                        $("#num-comment").html(qty);
                        if ($(".uesr-box-impromation table #num-comment").length > 0) {
                            $(".uesr-box-impromation table #num-comment").html(qty);
                            var logo = base_url + "skins/images/signup.png";
                            var full_name = data["full_name"];
                            var company = data["company"];
                            if (company != "" && typeof (company) !== undefined) {
                                company = " | " + company;
                            }
                            var information = full_name + company + " | " + data["created_at"];
                            if (data["avatar"] != "") {
                                logo = data["avatar"];
                            }
                            var html = '';
                            // append to html
                            html += '<tr class="comment-items single-page-comment offset_default">'
                            html += '   <td class="left-td"><img src="' + logo + '" class="left"></td>';
                            html += '   <td class="right-td" colspan="2">';
                            html += '       <p><a href="' + base_url + '/profile/index/' + data["member_id"] + '"><strong>' + information + '</strong></a></p>';
                            html += '       <div><p class="text-comment" data-id="' + data["comment_id"] + '">';
                            if (text.length <= 210) {
                                html += '<span>' + text + '</span>';
                            } else {
                                html += '   <span class="comment-item-text default-show block">' + text.slice(0, 200) + '<span class="more" id="more-comment"> MORE...</span></span>';
                                html += '   <span class="comment-item-text default-hie">' + text + '<span class="more" id="more-comment"> LESS</span></span>';
                            }
                            html += "</p>";
                            html += '</div></td></tr>';

                            $('.uesr-box-impromation table tbody').append(html);
                        }
                        $(".image-page #comment-input").val("");
                    } else {
                        messenger_box("Error message", "Implementation process fails.");
                    }
                    reset_comment = 0;
                },
                error: function () {
                    messenger_box("Error message", "Implementation process fails.");
                    reset_comment = 0;
                }
            });
        }
    }
});
$(document).on("click", ".action-comment .delete-comment", function () {
    delete_comment_function(this);
    return false;
});
$(document).on("click", ".action-comment .edit-comment", function () {
    var text = $(this).parents('.comment-items').find('.text-comment').text();
    if ($(this).parents('.comment-items').find('.default-hie').length > 0) {

        text = $(this).parents('.comment-items').find('.default-hie').text();
    }
    var data_id = $(this).attr('data-id');
    if ($(this).parents('.card-wrapper').length > 0) {
        $(this).parents('.card-wrapper').find('.card-info').stop().slideUp('slow');
        $(this).parents('.card-wrapper').find('.card-info').stop().slideDown('slow');
    }
    if ($(this).parents('.item-conversations').length > 0) {
        $('.item-conversations').find('.box-input-comment').stop().slideUp('slow');
        $(this).parents('.item-conversations').find('.box-input-comment').stop().slideDown('slow');
    }
    $(this).parents('.card-wrapper').find('#content-comment').val((text.trim()).replace("LESS", ""));
    $(this).parents('.card-wrapper').find('#add-comment').attr('data-edit-id', data_id);
    return false;
});
function delete_comment_function(obj) {
    if (confirm('Are you sure you want to delete this?')) {
        var comment_id = $(obj).attr('data-id');
        var object_id = $(obj).parents('.card').attr('data-id');
        var object = $(obj).parents('.card').attr('data-type');
        $.ajax({
            url: base_url + "comments/delete/" + object + '/' + object_id,
            type: 'POST',
            dataType: "json",
            data: {
                'comment_id': comment_id
            },
            success: function (data) {
                if (data['status'].trim() == "true") {
                    $(obj).parents('.comment-items').fadeOut('slow', function () {
                        $(this).remove();
                    });
                    $(obj).parents(".card-wrapper").find(".commen-like #num-comment").html(data['number_like_comment']);
                    $(obj).parents(".card-wrapper").find(".card-top #num-comment").html(data['number_like_comment']);
                    if (data['number_like_comment'] == 0) {
                        $(obj).parents(".conment-show").removeClass("block");
                    }
                }
            },
            complete: function () {
            },
            error: function (data) {

            }
        });
    }
}
function edit_comment_function(obj) {
    var comment_id = $(obj).attr('data-edit-id');
    var object = $(obj).parents('.card').attr('data-type');
    var text = $(obj).parents('.card').find('#content-comment').val();
    var html = "";
    if (text.length <= 100) {
        html += '<span>' + text + '</span>';
    } else {
        html += '<span class="comment-item-text default-show">' + text.slice(0, 100) + '<span class="more" id="more-comment"> MORE...</span></span>';
        html += '<span class="comment-item-text default-hie block">' + text + '<span class="more" id="more-comment"> LESS</span></span>';
    }
    if (text.trim() != '' && text.trim() != null) {
        $(obj).attr('disabled', 'disabled');
        $(obj).parents('.form-comment').find('.load-comment').css('display', 'initial');
        $.ajax({
            url: base_url + "comments/update/" + object,
            type: 'POST',
            dataType: "json",
            data: {
                "text": text,
                'data_id': comment_id
            },
            success: function (data) {
                if (data['status'].trim() == "true") {
                    $(obj).parents('.card').find('.text-comment[data-id="' + comment_id + '"]').html(html);
                }
                var height = $(obj).parents(".card").find(".uesr-box-impromation")[0].scrollHeight;
                $(obj).parents(".card").find(".uesr-box-impromation").scrollTop(height);
                $(obj).parents('.card').find(".card-info").slideUp("slow");
            },
            complete: function () {
                $(obj).removeAttr('disabled');
            },
            error: function (data) {
            }
        });
        $(obj).parents('.card').find('#content-comment').val('');
        $(obj).removeAttr('data-edit-id');
    }
}
$(document).on("click", "#add-comment", function () {
    var this_new = $(this);
    var photo_comment = this_new.data("id");
    var object = 'photo';
    if (typeof $(this).attr('data-object') != 'undefined' && $(this).attr('data-object') != null) {
        object = $(this).attr('data-object');
    }
    var text = this_new.parents(".card-info").find("#content-comment").val();
    var avatar = base_url + 'skins/images/signup.png';
    $(this).parents(".box-input-comment").find("#content-comment").removeClass("warning");
    if (text == "") {
        $(this).parents(".box-input-comment").find("#content-comment").addClass("warning");
    }
    if (check_login() != false && text.trim() != "") {
        if (typeof $(this).attr('data-edit-id') != 'undefined' && $(this).attr('data-edit-id') != null) {
            edit_comment_function(this);
        } else {
            $.ajax({
                url: base_url + "comments/add/" + photo_comment + "/" + object,
                type: 'POST',
                dataType: "json",
                data: {
                    "text": text
                },
                success: function (data) {
                    if (data["status"] == "true") {
                        var number_comment = parseInt(this_new.parents(".card-wrapper").find("#num-comment").text()) + 1;
                        this_new.parents(".card-wrapper").find("#num-comment").text(data["number_like_comment"]);
                        this_new.parents(".card-info").find("#content-comment").val("");
                        if (data["avatar"] != "") {
                            avatar = data["avatar"];
                        }
                        var company = "";
                        if (data["company"] != "" && data["company"] != null) {
                            company = ' | ' + data["company"];
                        }
                        var html = '<div class="row comment-items"><div class="col-xs-2 remove-padding"><img src="' + avatar + '" class="left"></div>';
                        html += '<div class="col-xs-10 box-impromation">';
                        html += '<p><a href ="' + base_url + '/profile/index/' + data['member_id'] + '"><strong>' + data["full_name"] + company + '</strong></a></p>';
                        html += '<div>';
                        html += '<p class="text-comment" data-id="' + data["comment_id"] + '">';
                        if (text.length <= 100) {
                            html += '<span>' + text + '</span>';
                        } else {
                            html += '<span class="comment-item-text default-show">' + text.slice(0, 100) + '<span class="more" id="more-comment"> MORE...</span></span>';
                            html += '<span class="comment-item-text default-hie block">' + text + '<span class="more" id="more-comment"> LESS</span></span>';
                        }
                        html += '</p>';
                        html += '<span class="action-comment">';
                        html += '<a data-id="' + data['comment_id'] + '" class="edit-comment" href="#"><i class="fa fa-pencil"></i></a>';
                        html += '<a data-id="' + data['comment_id'] + '" class="delete-comment" href="#"><i class="fa fa-times"></i></a>';
                        html += '</span>';
                        html += '</div></div>';
                        this_new.parents(".card").find(".uesr-box-impromation .avatar").append(html);
                        var height = this_new.parents(".card").find(".uesr-box-impromation")[0].scrollHeight;
                        this_new.parents(".card").find(".uesr-box-impromation").scrollTop(height);
                        this_new.parents(".card").find(".conment-show").addClass("block");

                    } else {
                        if (typeof (data["message"]) != "undefined")
                            messenger_box("Error message", data["message"]);
                        else
                            messenger_box("Error message", "Implementation process fails.");
                    }
                    this_new.parents(".card").find(".card-info:not(.conversations-info)").slideUp("slow");
                    reset_comment = 0;
                },
                error: function () {
                    messenger_box("Error message", "Implementation process fails.");
                    reset_comment = 0;
                }
            });
        }

    }
});
/*---------------------------------------!photo comment------------------------------------------------------*/
$(document).on("click", "#hide_about #more-about", function () {
    $(this).parents("#hide_about").hide();
    $(this).parents("#about").find("#show_about").slideDown();
    return false;
});
$(document).on("click", "#show_about #more-about", function () {
    $(this).parents("#show_about").slideUp("slow", function () {
        $(this).parents("#about").find("#hide_about").show();
    });
    return false;
});
$(document).on("click", ".box-menu .services a", function (e) {
    e.stopPropagation();
    if (is_business == "" && check_login() == false ) {
        url_reload = base_url + "services";
        return false;
    }
});


$(document).on("keyup", "#seach-home-photo #input-seach", function (event) {
    var element = $(this);
    $(this).parents("#seach-home-photo").find(">ul.like_search").remove();
    var new_this_seach = $(this);
    if ($(this).val().trim() != "" && event.keyCode != 13) {
        $.ajax({
            url: base_url + "photos/get_photos_like",
            type: "POST",
            data: {
                "keyword": $(this).val().trim()
            },
            dataType: "json",
            success: function (data) {
                var html = "";
                if (data["success"] == "success" && data["record"].length > 0) {
                    html += "<ul class='like_search'>";
                    $.each(data["record"], function (key, value) {
                        html += '<li>' + value["name"] + '</li>';
                    });
                    html += "</ul>";
                    element.parents("#seach-home-photo").find(">ul.like_search").remove();
                    new_this_seach.parents("#seach-home-photo").append(html);
                }
            }
        });
    }
});
$(document).on("click", "#seach-home-photo .like_search li", function () {
    var text_like = $(this).text();
    $(this).parents("#seach-home-photo").find("#input-seach").val(text_like);
    $(this).parents("#seach-home-photo").find(".seach-sumit").trigger("click");
    $(this).parents(".like_search").remove();
});
$(document).on("click", "#view-all-comment > span.glyphicon-comment", function () {
    photo_id = $(this).parents("#wrapper-impormant-image").attr("data-id");
    if (photo_id != "" && $.isNumeric(photo_id)) {
        $.ajax({
            url: base_url + "photos/get_all_comment_photo",
            type: "post",
            dataType: "json",
            data: {"photo_id": photo_id},
            success: function (data) {
                if (data.length > 0) {
                    $("#view-comment #box-all-comment .uesr-box-impromation .avatar").html("");
                    var avatar = base_url + 'skins/images/signup.png';
                    var html = "";
                    $.each(data, function (key, value) {
                        if (value["avatar"] != "") {
                            avatar = base_url + value["avatar"];
                        }
                        html += '<div class="row"><div class="col-xs-2 remove-padding"><img src="' + avatar + '" class="left"></div>';
                        html += '<div class="col-xs-10 box-impromation">';
                        html += '<p><a href="' + base_url + "profile/index/" + value["member_id"] + '"><strong>' + value["first_name"] + ' ' + value["last_name"] + ' | ' + value["company_name"] + '</strong></a></p>';
                        html += '<p>' + value["comment"] + '</p>';
                        html += '</div></div>';
                    });
                    $("#view-comment #box-all-comment .uesr-box-impromation .avatar").html(html);
                }
                $("#view-comment").modal();
            }
        });
    }

});
var reset_click = 0;
$(document).on("click", "#view-more", function (event) {
    var _this = $(this);
    var item = _this.parents(".card").find(".uesr-box-impromation .avatar .comment-items").length;
    var numall_comment = _this.parents(".card").find("#num-comment").text();
    numall_comment = parseInt(numall_comment);
    var _phototype = "photo";
    if (typeof _this.attr("data-type") != "undefined") {
        _phototype = $(this).attr("data-type");
    }
    var photo_id = _this.parents(".card").attr("data-id");
    var number_click = 1;
    if (typeof _this.attr("number-click") != "undefined") {
        number_click = parseInt(_this.attr("number-click")) + 1;
    }
    if ($.isNumeric(photo_id) && reset_click == 0) {
        $.ajax({
            url: base_url + "photos/get_comment_photo/" + _phototype,
            type: "post",
            dataType: "json",
            data: {"photo_id": photo_id, "item": item},
            success: function (data) {
                if (data["comment"].length > 0) {
                    _this.parents(".card-wrapper").find("#num-comment").text(data["all_comment"]);
                    var html = "";
                    var total_comment = data["comment"].length;
                    var data_comment = data["comment"]
                    for (var i = total_comment; i > 0; i--) {
                        var logo = base_url + "skins/images/signup.png";
                        var full_name = data_comment[(i - 1)]["first_name"] + " " + data_comment[(i - 1)]["last_name"];
                        var company = data_comment[(i - 1)]["company_name"];
                        if (company != "") {
                            company = " | " + company;
                        }
                        var impromation = full_name + company;
                        if (data_comment[(i - 1)]["avatar"] != "") {
                            logo = data_comment[(i - 1)]["avatar"];
                        }
                        if (i <= 2) {
                            html += '<div class="row comment-items offset_default">';
                        } else {
                            html += '<div class="row comment-items">';
                        }
                        html += '<div class="col-xs-2 remove-padding"><img src="' + logo + '" class="left"></div>';
                        html += '<div class="col-xs-10 box-impromation">';
                        html += '<p><a href="' + base_url + '/profile/index/' + data_comment[(i - 1)]["member_id"] + '"><strong>' + impromation + '</strong></a></p>';
                        html += '<div><p class="text-comment" data-id="' + data_comment[(i - 1)]["id"] + '">';
                        if (data_comment[(i - 1)]["comment"].length <= 79) {
                            html += '<span>' + data_comment[(i - 1)]["comment"] + '</span>';
                        } else {
                            html += '<span class="comment-item-text default-show block">' + data_comment[(i - 1)]["comment"].slice(0, 71) + '<span class="more" id="more-comment"> MORE...</span></span>';
                            html += '<span class="comment-item-text default-hie">' + data_comment[(i - 1)]["comment"] + '<span class="more" id="more-comment"> LESS</span></span>';
                        }
                        html += "</p>";
                        if (data_comment[(i - 1)]["member_id"] == data["user_id"]) {
                            html += '<span class="action-comment">';
                            html += '<a data-id="' + data_comment[(i - 1)]["id"] + '" class="edit-comment" href="#"><i class="fa fa-pencil"></i></a>';
                            html += '<a data-id="' + data_comment[(i - 1)]["id"] + '" class="delete-comment" href="#"><i class="fa fa-times"></i></a>';
                            html += '</span>';
                        }
                        html += '</div></div></div>';
                    }
                    _this.parents(".card").find(".uesr-box-impromation .avatar").html(html);
                    _this.parents(".card").find(".uesr-box-impromation").scrollTop(0);
                    _this.attr("number-click", number_click);
                    if (numall_comment <= data["comment"].length) {
                        _this.remove();
                    }
                }
                reset_click = 0;
            },
            error: function () {
                reset_click = 0;
            }
        });
    }
});

var reset_click_detail = 0;
$(document).on("click", "#view-more-detail", function (event) {
    var _this = $(this);
    var item = _this.parents("table").find(".comment-items").length;
    var numall_comment = _this.parents("table").find("#num-comment").text();
    numall_comment = parseInt(numall_comment);
    var _phototype = "photo";
    if (typeof _this.attr("data-type") != "undefined") {
        _phototype = $(this).attr("data-type");
    }
    var photo_id = _this.parents("table").attr("data-id");
    var number_click = 1;
    if (typeof _this.attr("number-click") != "undefined") {
        number_click = parseInt(_this.attr("number-click")) + 1;
    }
    if ($.isNumeric(photo_id) && reset_click_detail == 0) {
        $.ajax({
            url: base_url + "photos/get_comment_photo/" + _phototype,
            type: "post",
            dataType: "json",
            data: {"photo_id": photo_id, "item": item},
            success: function (data) {
                if (data["comment"].length > 0) {
                    _this.parents("table").find("#num-comment").text(data["all_comment"]);
                    var html = "";
                    var total_comment = data["comment"].length;
                    var data_comment = data["comment"]
                    for (var i = total_comment; i > 0; i--) {
                        var logo = base_url + "skins/images/signup.png";
                        var full_name = data_comment[(i - 1)]["first_name"] + " " + data_comment[(i - 1)]["last_name"];
                        var company = data_comment[(i - 1)]["company_name"];
                        if (company != "") {
                            company = " | " + company;
                        }
                        var impromation = full_name + company + " | " + data_comment[(i - 1)]["created_at"];
                        if (data_comment[(i - 1)]["avatar"] != "") {
                            logo = data_comment[(i - 1)]["avatar"];
                        }
                        if (i > item) { // Just display 
                            html += '<tr class="comment-items single-page-comment offset_default">'
                            html += '   <td class="left-td"><img src="' + logo + '" class="left"></td>';
                            html += '   <td class="right-td" colspan="2">';
                            html += '       <p><a href="' + base_url + '/profile/index/' + data_comment[(i - 1)]["member_id"] + '"><strong>' + impromation + '</strong></a></p>';
                            html += '       <div><p class="text-comment" data-id="' + data_comment[(i - 1)]["id"] + '">';
                            if (data_comment[(i - 1)]["comment"].length <= 210) {
                                html += '<span>' + data_comment[(i - 1)]["comment"] + '</span>';
                            } else {
                                html += '   <span class="comment-item-text default-show block">' + data_comment[(i - 1)]["comment"].slice(0, 200) + '<span class="more" id="more-comment"> MORE...</span></span>';
                                html += '   <span class="comment-item-text default-hie">' + data_comment[(i - 1)]["comment"] + '<span class="more" id="more-comment"> LESS</span></span>';
                            }
                            html += "</p>";
                            html += '</div></td></tr>';
                        }
                    }
                    _this.parents("table").find("tbody").prepend(html);
                    _this.parents("table").find("tbody").scrollTop(0);
                    _this.attr("number-click", number_click);
                    if (numall_comment <= data["comment"].length) {
                        _this.remove();
                    }
                }
                reset_click_detail = 0;
            },
            error: function () {
                reset_click_detail = 0;
            }
        });
    }
});

$(document).on("click", "#more-comment", function () {
    $(this).parents(".text-comment").find(".comment-item-text").toggleClass("block");
});

function randomIntFromInterval(min,max)
{
    return Math.floor(Math.random()*(max-min+1)+min);
}
$(document).on("click","#delete_wall",function(){
    var id = $(this).data("id");
    $("#modal_delete_walll #ok-delete").attr("href",base_url+"designwalls/delete/"+id);
    $("#modal_delete_walll").modal();
    return false;
});

$(document).on({
    mouseenter: function () {
        $(this).parents(".follow-hover").find(".follow-box").show();
        $(this).parents(".follow-hover").find(".follow-box").animate({opacity:1},500);
    },
    mouseleave: function () {
        $(this).parents(".follow-hover").find(".follow-box").animate({opacity:0},1000,function(){
            $(this).parents(".follow-hover").find(".follow-box").hide();
        });  
    }
}, "#wrapper-impormant-image #follow-company-now"); 
$(document).on("click","#wrapper-impormant-image #follow-company-now",function(){
    if (check_login() == false){
        return false;
    }
    var _this = $(this);
    var photo_id  = $(this).parents(".card").attr("data-id");
    $.ajax({
        url      : base_url + "photos/follow_company",
        type     : "post",
        dataType : "json",
        data     : { photo_id : photo_id },
        success  :function (data){
            if(data["status"] == "success"){
                if(data["response"] == "delete"){
                    _this.attr("title","Un following this company");
                    _this.find("img").attr("src",base_url + "skins/images/follow.png");
                }else{
                    _this.attr("title","Following this company");
                    _this.find("img").attr("src",base_url + "skins/images/follow-activer.png");
                }    
            }
        },
        error :function (){

        }
    });
    return false;
});
$(document).on("click","#wrapper-impormant-image .close-box-follow a",function(){
    $(this).parents(".follow-box").animate({opacity:0},1000,function(){
        _this.hide();
    });
    return false;
});