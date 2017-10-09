// Valid Phone number
$(document).on('blur', ".format-phone", function(e) {
    var val_par = parseInt($(this).val()) + 1;
    /*if(isNaN(val_par)==true){
        $(this).val("");
        $(this).addClass('warning');
        messenger_box("Error Message", 'Phone number is invalid. Please try again.');
    }*/
    return valid_phone_number($(this), true);
});
// Valid Number
$(document).on('blur', ".format-number", function(e) {
    return valid_number($(this), true);
});
// Valid Number Advance
$(document).on('blur', ".format-number-advance", function(e) {
    return valid_number_advance($(this), true);
});
// Valid Email
$(document).on('blur', ".format-email", function(e) {
    return valid_emails($(this), true);
});
// Valid URL
$(document).on('blur', ".format-url", function(e) {
    return valid_url($(this), true);
});
function valid_all_format(obj, param) {
    if (obj.hasClass('format-phone')) {
        return valid_phone_number(obj, param);
    }
    if (obj.hasClass('format-number')) {
        return valid_number(obj, param);
    }
    if (obj.hasClass('format-number-advance')) {
        return valid_number_advance(obj, param);
    }
    if (obj.hasClass('format-email') || obj.hasClass('format-email-inver')) {
        return valid_emails(obj, param);
    }
    if (obj.hasClass('format-url')) {
        return valid_url(obj, param);
    }
    return true;
}

function valid_phone_number(obj, is_show) {
    if (obj.val() === '') {
        obj.removeClass("warning");
        return false;
    }
    
    // No validate if no enter any value.
    var val = obj.val();
    val = val.replace(/[^\d]/g, '');

    if (val == '') {
        obj.addClass("warning");
        if (is_show == true) {
            messenger_box("Error Message", 'Phone number is invalid. Please try again.');
        }
        return false;
    }

    var str = '';
    var length = val.length;
    var prefix = '';
    if (length >= 10) {
        prefix = '(' + val.substring(0, 3) + ') ';
        val = val.substring(3, length);
        length = val.length;
    }

    if (length >= 4) {
        var index = 0;
        var last_item = true;
        var num;
        while (index < length) {
            num = 3;
            if (last_item) {
                num = 4;
                last_item = false;
                str = val.substring(val.length - num, val.length)
            } else {
                str = val.substring(val.length - num, val.length) + '-' + str;
            }
            val = val.substring(0, val.length - num);
            index += num;
        }
        obj.val(prefix + '' + str);
        obj.removeClass("warning");
        //obj.attr('Placeholder', '');
        return true;
    } else {
        obj.val(val);
        obj.addClass("warning");
        //$(this).attr('Placeholder','Phone number is invalid.');
        if (is_show == true) {
            messenger_box("Error Message", 'Phone number is invalid. Please try again.');
        }
        //$(this).focus();
        return false;
    }
    
    return false;
}

function valid_number_advance(obj, is_show) {
    if (valid_number(obj, false)) {
    	var min = parseInt($(obj).attr("min"));
    	var max = parseInt($(obj).attr("max"));
    	var length = $(obj).attr("maxlength");
    	var val = parseInt($(obj).val());
    	if (val.length > length || val < min || val > max) {
    		if (is_show == true) {
	            messenger_box("Error Message", 'Number is invalid. The number in range [' + min + ',' + max + '].');
	        }
    		return false;
    	}
    	return true;
    }
    return false;
}

function valid_number(obj, is_show) {
    if (obj.val() === '') {
        $(this).removeClass("warning");
        return false;
    }
    
    // No validate if no enter any value.
    var val = obj.val();
    if (val != '' && isNaN(val)) {
        obj.addClass("warning");
        if (is_show == true) {
            messenger_box("Error Message", 'Number is invalid. Please try again.');
        }
        return false;
    }
    val = val.replace(/[^\d]/g, '');

    if (val == '') {
        obj.val('');
        return true;
    }

    var length = val.length;
    obj.val(val);
    if (length == 0) {
        obj.addClass("warning");
        //$(this).attr('Placeholder','Number is invalid.');
        if (is_show == true) {
            messenger_box("Error Message", 'Number is invalid. Please try again.');
        }
        //$(this).focus();
        return false;
    } else {
        obj.removeClass("warning");
        //$(this).attr('Placeholder','');
        return true;
    }
}

function valid_emails(obj, is_show) {
    // No validate if no enter any value.
    if (obj.val() === '') {
        obj.removeClass("warning");
        return false;
    }

    var val = obj.val();
    filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (!filter.test(val)) {
        obj.addClass("warning");
        //$(this).attr('Placeholder','Email is invalid.');
        if (is_show == true) {
            messenger_box("Error Message", 'Email is invalid. Please try again.');
        }
        // $(this).focus();
        return false;
    } else {
        obj.removeClass("warning");
        return true;
        //$(this).attr('Placeholder','');
    }
}

function valid_url(obj, is_show) {
    // No validate if no enter any value.
    if (obj.val() === '') {
        obj.removeClass("warning");
        return false;
    }

    var val = obj.val();
    filter = /^(http[s]?:\/\/){0,1}(www\.){0,1}[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,5}[\.]{0,1}/;
    if (!filter.test(val)) {
        obj.addClass("warning");
        //$(this).attr('Placeholder','URL is invalid.');
        if (is_show == true) {
            messenger_box("Error Message", 'URL is invalid. Please try again.');
        }
        // $(this).focus();
        return false;
    } else {
        obj.removeClass("warning");
        return true;
        // $(this).attr('Placeholder','');
    }
}