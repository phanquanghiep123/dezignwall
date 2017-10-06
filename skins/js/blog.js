var _reset_comment = 0;
$(window).load(function(){
  var height =$('.comment-wrap')[0].scrollHeight;
  $('.comment-wrap').scrollTop(height);
});
$(document).ready(function(){
    $('.bxsliders').bxSlider({
      pagerCustom: '#bx-pager'
    });
    $('#comment-show #add-commemt-input').on('keypress', function (event) {
         if(event.which === 13){
           var edit = $(this).attr('data-comment-id');
           if(typeof(edit) != 'undefined'){
           	   edit_comment(this);
           }
           else{
           		add_comment(this);
           }
         }
    });

    $(document).on('click','.action-comments .delete-comment',function(){
      	delete_comment(this);
      	return false;
    });

    $(document).on('click','.action-comments .edit-comment',function(){

      	var text = $(this).parents('.comment-items').find('.text-comment').text();

      	var data_id = $(this).parents('.comment-items').attr('data-id');

      	$(".section-comment #comment-show #add-commemt-input").attr('data-comment-id',data_id);

      	$(".section-comment #comment-show #add-commemt-input").val(text);

      	return false;

    });

    $(document).on('click','#view-more-comment',function(){
        get_more_comment(this);
        return false;
    });
});
$(document).on("click", "#more-comments", function (event) {
    event.stopPropagation() ;
    $(this).parents(".text-comment-wrap").find(".comment-item-text").toggleClass("block");
    return false;
});

/*

    ==========================================================

    BEGIN: COMMENT

*/

var add_comment = function(obj) {

    var object_id = $(obj).attr('data-id');

    var text = $(obj).val();

    if (text.trim() != '' && text.trim() != null && _reset_comment == 0) {
        _reset_comment = 1;

        $(obj).attr('disabled', 'disabled');

        $(obj).parents('#comment-show').find('.load-comment').css('display', 'initial');

        $.ajax({

            url: base_url + "/comments/add/" + object_id + "/blog",

            type: 'POST',

            dataType: "json",

            data: { "text": text },

            success: function(data) {

                if (data['status'].trim() == "true") {

                    var qty = data['num_comment'];

                    $.each($(".panel #number-comment"),function(){
                      $(this).text(qty);
                    });

                    var avatar = base_url+'skins/images/avatar-full.png';

                    if(data['avatar']!=''){

                       avatar = data['avatar'];

                    }

                    var html  ='<div class="row comment-items" data-object-id="'+object_id+'" data-id="'+data['comment_id']+'" data-object="blog" style="margin-bottom:15px;">';

                        html +='    <div class="col-xs-3 col-sm-2 col-md-1"><img width="100" class="circle" src="'+avatar+'"></div>';

                        html +='    <div class="col-xs-9 col-sm-10 col-md-11">';

                        html +='		    <span class="action-comments">';

        						  	html +='            <a class="edit-comment" href="#"><i class="fa fa-pencil"></i></a>';

        						  	html +='            <a class="delete-comment" href="#"><i class="fa fa-times"></i></a>';

        						  	html +='        </span>';

                        html +='        <p><strong>'+data['full_name']+' | '+data['company']+'</strong></p>';
                        html += "<p class ='text-comment-wrap'>";
                        if (text.length <= 250) {
                            html += '<span class="comment-item-text block"><span class="text-comment">' + text + '</span></span>';
                        } else {
                            html += '<span class="comment-item-text default-hidden block"><span class="text-comment">' + text.slice(0, 250) + '</span><a href="#" class="more-comments more" id="more-comments"> MORE</a></span>';
                            html += '<span class="comment-item-text default-hidden"><span class="text-comment">' + text + '</span><a href="#" class="more-comments more" id="more-comments"> LESS</a></span>';
                        }
                        html +='</p></div>';

                        html +='</div>';

                    $('.comment-wrap').append(html);
                    var height =$('.comment-wrap')[0].scrollHeight;
                    $('.comment-wrap').scrollTop(height);

                }
                _reset_comment = 0;

            },

            complete: function() {

                $(obj).removeAttr('disabled');

                $(obj).parents('#comment-show').find('.load-comment').css('display', 'none');

                 _reset_comment = 0;

            },error:function(){
              _reset_comment = 0;
            }

        });

        $(obj).val('');

    }

}



var delete_comment = function(obj){

  if (confirm('Are you sure you want to delete this?')) {

  	var comment_id = $(obj).parents('.comment-items').attr('data-id');

  	var object = $(obj).parents('.comment-items').attr('data-object');

  	var object_id = $(obj).parents('.comment-items').attr('data-object-id');

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

                  var qty = parseInt($("#number-comment").text())-1;

                  if(qty >= 0){

                  	$("#number-comment").text(qty);

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



var edit_comment = function(obj){

	var comment_id = $(obj).attr('data-comment-id');

  var object = 'blog';

    var text = $(obj).val();

    if (text.trim() != '' && text.trim() != null) {

        $(obj).attr('disabled', 'disabled');

        $(obj).parents('#comment-show').find('.load-comment').css('display', 'initial');

        $.ajax({

            url: base_url + "comments/update/" + object,

            type: 'POST',

            dataType: "json",

            data: { "text": text , 'data_id': comment_id },

            success: function(data) {

                if (data['status'].trim() == "true") {
                    var html = "";
                    if (text.length <= 250) {
                          html += '<span class="comment-item-text block"><span class="text-comment">' + text + '</span></span>';
                    } else {
                        html += '<span class="comment-item-text default-hidden block"><span class="text-comment">' + text.slice(0, 250) + '</span><a href="#" class="more-comments more"> MORE</a></span>';
                        html += '<span class="comment-item-text default-hidden"><span class="text-comment">' + text + '</span><a href="#" class="more-comments more"> LESS</a></span>';
                    }
                    $('.comment-items[data-id="' + comment_id + '"]').find('.text-comment-wrap').html(html).addClass('text-comment');

                }

            },

            complete: function() {

                $(obj).removeAttr('disabled');

                $(obj).parents('#comment-show').find('.load-comment').css('display', 'none');

            }

        });

        $(obj).val('');

        $(obj).removeAttr('data-comment-id');

    }

}



var paging = 1;
var get_more_comment = function(obj){
  var number_item = $(obj).parents("#list-table-comment").find(".comment-items").length;
  var data_id = $(obj).attr('data-id');

  if(paging*3 < total_comment){

     $(obj).hide();

     $(obj).next().show();

     $.ajax({

          url: base_url + "article/get_more_comment/",

          type: 'POST',

          dataType: "json",

          data: { "paging": paging, 'data_id':data_id ,"number_item" : number_item},

          success: function(data) {

              if (data['status'].trim() == "success") {

                  paging++;

                  if(paging*3 < total_comment){

                      $(obj).show();

                  }

                  var html  = '';

                  var avatar = '';

                  for(var i = (data['reponse'].length - 1) ; i >= 0 ; i--){

                        avatar = base_url+'skins/images/avatar-full.png';

                        if(data['reponse'][i]['avatar']!=''){

                           avatar = data['reponse'][i]['avatar'];

                        }

                        html +='<div class="row comment-items" data-id="'+data['reponse'][i]['id']+'" data-object="blog" style="margin-bottom:15px;">';

                        html +='    <div class="col-xs-3 col-sm-2 col-md-1"><img width="100" class="circle" src="'+avatar+'"></div>';

                        html +='    <div class="col-xs-9 col-sm-10 col-md-11">';

                        if(data['reponse'][i]['member_id'] == member_owner_id){

                          html +='        <span class="action-comments">';

                          html +='            <a class="edit-comment" href="#"><i class="fa fa-pencil"></i></a>';

                          html +='            <a class="delete-comment" href="#"><i class="fa fa-times"></i></a>';

                          html +='        </span>';

                        }

                        html +=' <p><strong>'+data['reponse'][i]['first_name']+' '+data['reponse'][i]['last_name']+' | '+data['reponse'][i]['company_name']+'</strong></p>';
                        html +='<p class="text-comment-wrap">';               
                        if (data['reponse'][i]['comment'].length < 250) {
                            html += '<span class="comment-item-text block"><span class="text-comment">' + data['reponse'][i]['comment'] + '</span></span>';
                        } else {
                            html += '<span class="comment-item-text default-hidden block"><span class="text-comment">' + data['reponse'][i]['comment'].slice(0, 250) + '</span><a href="#" class="more-comments more" id="more-comments"> MORE</a></span>';
                            html += '<span class="comment-item-text default-hidden"><span class="text-comment">' + data['reponse'][i]['comment'] + '</span><a href="#" class="more-comments more" id="more-comments"> LESS</a></span>';
                        }
                        html +='</p></div>';

                        html +='</div>';

                  }

                  $('.comment-wrap').html(html);
                  $('.comment-wrap').scrollTop(0);

              }

          },

          complete: function() {

              $(obj).next().hide();

          }

      });

  }

}

/*

    ==========================================================

    END: COMMENT

*/