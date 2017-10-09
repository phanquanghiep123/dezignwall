$(document).ready(function(){
	$(document).on('click','.js-add-comment',function(){
		var e_data = document.getElementById($(this).attr('data-parent'));
		var obj_id = e_data.getAttribute('data-id');
		var obj_type = e_data.getAttribute('data-type');
		e_data.classList.add('e-loading');
		$.ajax({

		  	url: base_url+'comments/add',
		  	type: 'POST',
		  	data: {'object_id':obj_id,'type_object': obj_type},
		  	dataType:'json',
		  	success: function(reponse) {

			if(reponse['status']=='success'){
				location.reload();
			}

		  },

		  complete: function() {
			e_data.classList.remove('e-loading');
		  }

		});

		return false;
	})
})