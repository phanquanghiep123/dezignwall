// JavaScript Document
(function($){
    $.fn.extend({ 
    	validatefrom : function(options){
    		var defaults = {
                message : {
                	"email"    		: "This emali is not valid",
                	"number"        : "Please enter the number",
                	"required" 		: "This field is not empty",
                	"min-text"      : "Please enter at least {value} characters",
                	"max-text"      : "Please enter at most {value} characters",
                	"date"			: "Date format must be entered",
                	"min-date"      : "Please enter at least {value} date",
                	"max-date"      : "Please enter at most {value} date" ,
                	"min-number"    : "Please enter a number of greater than {value}",
                	"max-number"    : "Please enter a number less than {value}",
                	"same"          : "Must enter the same as {value}",
                	"phone"			: "Please enter telephone number",
                	"url"			: "Please enter a url"
                },
                formatDate :"yyyy/mm/dd",
                before : function(check,options){},
                after  : function (check,options){},
                beforeadderror:function(check,options,_childe,message,validatefunction){},
                afteradderror:function(check,options,_childe,message,validatefunction){},
                email : function($pramte1,$pramte2,$pramte3,$pramte4){
                    if($pramte2 != "" && $pramte2 != null){
                        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                        return re.test($pramte2);
                    }
                    return true;
                },
                number : function($pramte1,$pramte2,$pramte3,$pramte4){
                    if($pramte2 != "" && $pramte2 != null){
                        return $.isNumeric($pramte2);
                    }
                    return true;
                },
                min : function ($pramte1,$pramte2,$pramte3,$pramte4){
                    if($pramte2 != "" && $pramte2 != null){
                        if($pramte1 != "number" && $pramte1 != "date"){
                            return ($pramte2.length >= $pramte3);
                        }
                        if($pramte1 == "number"){
                            return ($pramte2 >= $pramte3);
                        }
                        if($pramte1 == "date"){
                            var date1 = new Date($pramte2);
                            var date2 = new Date($pramte3);
                            return ($date1 >= $date2);
                        }   
                    }
                    return true;    
                    
                },
                max : function ($pramte1,$pramte2,$pramte3,$pramte4){
                    if($pramte2 != "" && $pramte2 != null){
                        if($pramte1 == "text"){
                            return ($pramte2.length <= $pramte3);
                        }
                        if($pramte1 == "number"){
                            return ($pramte2 <= $pramte3);
                        }
                        if($pramte1 == "date"){
                            var date1 = new Date($pramte2);
                            var date2 = new Date($pramte3);
                            return ($date1 <= $date2);
                        } 
                    }  
                    return true;
                },
                date : function ($pramte1,$pramte2,$pramte3,$pramte4){
                    if($pramte2 != "" && $pramte2 != null){
                        var dtRegex = new RegExp(/\b\d{1,2}[\/-]\d{1,2}[\/-]\d{4}\b/);
                        return dtRegex.test($pramte2);
                    }
                    return true;
                },
                required : function ($pramte1,$pramte2,$pramte3,$pramte4){
                    return ( $pramte2 != null && $pramte2 != "" );
                },
                same : function ($pramte1,$pramte2,$pramte3,$pramte4){
                    if($pramte2 != "" && $pramte2 != null){
                        var samdata = $pramte3.split(",");
                        return ($.inArray($pramte2,samdata) != -1);
                    }
                    return true;
                },
                url : function  ($pramte1,$pramte2,$pramte3,$pramte4){
                    if($pramte2 != "" && $pramte2 != null){
                        var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
                        return regexp.test($pramte2);
                    }
                    return true;
                },
                phone : function ($pramte1,$pramte2,$pramte3,$pramte4){
                    if($pramte2 != "" && $pramte2 != null){
                        var filter = /^[0-9-+]+$/;
                        return filter.test($pramte2);
                    }
                    return true;
                }
            }
            var _olddefaults = { 
                "email"         : "This emali is not valid",
                "number"        : "Please enter the number",
                "required"      : "This field is not empty",
                "min-text"      : "Please enter at least {value} characters",
                "max-text"      : "Please enter at most {value} characters",
                "date"          : "Date format must be entered",
                "min-date"      : "Please enter at least {value} date",
                "max-date"      : "Please enter at most {value} date" ,
                "min-number"    : "Please enter a number of greater than {value}",
                "max-number"    : "Please enter a number less than {value}",
                "same"          : "Must enter the same as {value}",
                "phone"         : "Please enter telephone number",
                "url"           : "Please enter a url"
            };
            var _this = this;
            var _childe; 
            var options =  $.extend(defaults,options);
            $.each(_olddefaults,function($key,$value){
                if(typeof options.message[$key] === "undefined"){
                    options.message[$key] = $value;
                }
            });
            var valueInput;
            var type = "text";
            var eval_string = "";
            var validateData ;
            var functionAuto;
            var argAutofunction;
            var check = true;
            var message_error = "";
            /*run plugin*/
            options.before(check,options);
            init ();
            options.after(check,options);
            return check;
            function init (){
            	_this.find(".validate-error").remove();
			    $.each(_this.find("[validate]"),function(key,value){
			    	_childe = $(this);
			    	type  = _childe.data("type");
			    	if(typeof type === "undefined") type = _childe.attr("type");
			    	if(typeof type === "undefined") type = "text"; 
                    if(type != "number" && type != "date"){
                        type = "text";
                    }
		    		validateData = _childe.attr("data-validate");
		    		valueInput   = _childe.val();
                    functionAuto = validateData.split("|");
                    if(typeof _childe.attr("data-validate-show") !== "undefined"){
                    	_childe = $(_childe.attr("data-validate-show"));
			    	}
                	$.each(functionAuto,function(key ,value){
            			try{
                            argAutofunction = value.split(":");
                            var checkdata = options[argAutofunction[0]](type,valueInput,argAutofunction[1],_childe);
            				if(!checkdata){           	
            				    if(argAutofunction[0] == "min" || argAutofunction[0] == "max"){
            				    	message_error = options.message[argAutofunction[0] + "-" + type];
                                }else{
            				    	message_error = options.message[argAutofunction[0]];
            				    }

                                if(typeof argAutofunction[1] !== "undefined"){ 
                                    message_error = message_error.replace("{value}",argAutofunction[1]);
                                }
                                if(typeof argAutofunction[2] !== "undefined"){
                                    message_error = message_error.replace("{value1}",argAutofunction[2]);
                                }	
                                if(typeof argAutofunction[3] !== "undefined"){
                                    message_error = message_error.replace("{value2}",argAutofunction[3]);
                                }
                                if(typeof argAutofunction[4] !== "undefined"){
                                    message_error = message_error.replace("{value3}",argAutofunction[4]);
                                }		
            					check = false;
                                if(options.beforeadderror(check,options,_childe,message_error,argAutofunction[0]) == false) return false;
            					   _childe.after('<p class="validate-error error"><span>'+message_error+'</span></p>');
            					if(options.afteradderror(check,options,_childe,message_error,argAutofunction[0]) == false) return false;
                                return false;
            				}
            			}catch (err){
            				console.log(err);
                            console.log(argAutofunction);
            			}
                	});		
			    });  
            }   
    	}
    })
})(jQuery);

