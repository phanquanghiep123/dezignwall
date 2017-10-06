<script type="text/javascript">
	//delete item
    $(document).on('click','.delete-menu', function(){
    	var li_current=$(this).parent('.ns-actions').parent('.ns-row').parent('.sortable');
    	var id=li_current.find('#menu_id').val();
    	if(confirm('Do you delete this item?')){
    		$.ajax({
		      type: 'POST',
		      url: '/admin/delete_item_category/'+id,
		      data:{"business_type": "<?php echo @$business_type; ?>"},
		      success: function(data) {
			  	if(data.trim()=='true'){
			  		li_current.fadeOut(800,function(){
			  			$(this).remove();
			  		});
			  	}
		      }
	        });
    	}

    	return false;
    });

    //edit item
    $(document).on('click','.edit-menu',function(){
    	var li_current=$(this).parent('.ns-actions').parent('.ns-row').parent('.sortable');
    	var id=li_current.find('#menu_id').val();
    	$('#edit-id').val(id);
    	$.ajax({
	      type: 'POST',
          dataType:'json',
	      url: "/admin/get_item_category/"+id,
	      data: {"business_type": "<?php echo @$business_type; ?>"},
	      success: function(data) {
		 $('#edit-title').val(data.title);
	         $('#edit-url').val(data.url);
	         $('#edit-class').val(data.class);
	      }
        });
    });

    //add item
    $(document).on('click','#add-menu',function(){
    	var title=$('#add-title').val();
    	var bool=true;
    	if (title.trim()=='' || title.trim()==null) {
    		bool=false;
    		$('#add-title').addClass('border-error');
    	} else {
    		$('#add-title').removeClass('border-error');
    	}
    	
    	if (bool) {
    		$('#form-add-menu .image-load').show();
    		$(this).attr('disabled','disabled');
    		$.ajax({
		      type: 'POST',
		      url: '/admin/add_item_category/',
		      data:{"title":title,"business_type": "<?php echo @$business_type; ?>"},
		      success: function(data) {
			  		if (parseInt(data) == 0) {
			  			alert("Error: ");
			  		} else {
			  			var obj = JSON.parse(data);
			  			var html ='<li id="menu-' + obj.id + '" class="sortable">';
			          		html+='	      <div class="ns-row">';
							html+='            <div class="ns-title">' + obj.title + '</div>';
							html+='            <div class="ns-url">' + obj.slug + '</div>';
							html+='            <div class="ns-class">' + obj.sort + '</div>';
							html+='            <div class="ns-actions">';
							html+='               <a href="#" class="edit-menu" data-toggle="modal" data-target="#editModal" title="Edit"><img src="/skins/images/edit.png" alt="Edit"></a>';
		                    html+='               <a href="#" class="delete-menu"><img src="/skins/images/cross.png" alt="Delete"></a>';
							html+='               <input type="hidden" id="menu_id" name="menu_id" value="' + obj.id + '">';
							html+='            </div>';
							html+='         </div>';
	                       	html+='	  </li>';
	                        $('#easymm').append(html).SortableAddItem($('#menu-'+obj.id)[0]);
	                        $('#add-title').val('');
			  		}
		      },
		      complete:function() {
				$('#add-menu').removeAttr('disabled');
				$('#form-add-menu .image-load').hide();
		      }
	        });
    	}
    });
	
	//save edit menu
    $(document).on('click','.btn-edit',function(){
    	var title=$('#edit-title').val();
    	var id=$('#edit-id').val();
    	var bool=true;
    	if(title.trim()=='' || title.trim()==null){
    		bool=false;
    		$('#edit-title').addClass('border-error');
    	}
    	else{
    		$('#edit-title').removeClass('border-error');
    	}

    	if(bool){
    		$('#editModal .image-load').show();
    		$(this).attr('disabled','disabled');
    		$.ajax({
		      type: 'POST',
		      url: '/admin/update_item_category/'+id,
		      data:{"title":title,"business_type": "<?php echo @$business_type; ?>"},
		      success: function(data) {
                    var li=$('#menu-'+id);
                    li.find('.ns-title').html(title);
			        $('#edit-title').val();
		      },
		      complete:function(){
				$('.btn-edit').removeAttr('disabled');
				$('#editModal .image-load').hide();
                $('#editModal .btn-close').trigger('click');
		      }
	        });
    	}
    });
</script>
<script src="<?php echo backend_url('js/jquery.1.4.1.min.js');?>"></script>
<link rel="stylesheet" href="<?php echo skin_url('css/menu.css'); ?>" />
<script src="<?php echo skin_url('js/interface-1.2.js'); ?>"></script>
<script src="<?php echo skin_url('js/inestedsortable.js'); ?>"></script>
<script>
  $(document).ready(function(){
	var menu_serialized;
	var fixSortable = function() {
		if (!$.browser.msie) return;
		//this is fix for ie
		$('#easymm').NestedSortableDestroy();
		$('#easymm').NestedSortable({
			accept: 'sortable',
			helperclass: 'ns-helper',
			opacity: .8,
			handle: '.ns-title',
			onStop: function() {
				fixSortable();
			},
			onChange: function(serialized) {
				menu_serialized = serialized[0].hash;
				$('#btn-save-menu').attr('disabled', false);
			}
		});
	};
	$('#easymm').NestedSortable({
		accept: 'sortable',
		helperclass: 'ns-helper',
		opacity: .8,
		handle: '.ns-title',
		onStop: function() {
			fixSortable();
		},
		onChange: function(serialized) {
			menu_serialized = serialized[0].hash;
            $('#btn-save-menu').attr('disabled', false);
		}
	});

      /*Update position menu item*/
      $('#btn-save-menu').click(function() {
        $('#ns-footer .image-load').show();
        //alert(menu_serialized);
        //return false;
        $(this).attr('disabled','disabled');
        $.ajax({
	      type: 'POST',
	      url: '/admin/category_position/<?php echo @$business_type; ?>',
	      data: menu_serialized,
	      //dataType:'json',
	      success: function(data) {
	      	//console.log(data);
            //if(data=='true'){
                
            //}	
	      },
          complete:function(){
			  $('#btn-save-menu').removeAttr('disabled');
			  $('#ns-footer .image-load').hide();
			  location.reload();
	      }
        });
        return false;
      });

  });   
 
</script>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
  <div class="row">
      <ol class="breadcrumb">
			 <li><a href="/admin/"><span class="glyphicon glyphicon-home"></span></a></li>
			 <li class="active">Categories</li>
      </ol>
  </div>
  <div class="row">
     <div class="col-lg-12">
        <div class="panel panel-default">
           <div class="panel-body">
			   <div class="row">
				   	 <div class="col-lg-9 col-sm-12">
				   	    <div class="row">
				   	      <div class="col-lg-12">
					   	 	<ul style="float: left;width:100%;border-bottom: 5px solid #009900;" class="menu-tab-group" id="menu-group">
					   	 		<li <?php if (!isset($business_type)) { echo 'class="current"';} ?>><a href="/admin/categories">Categories</a></li>
					   	 		<li <?php if (isset($business_type)) { echo 'class="current"';} ?>><a href="/admin/categories/business_type">Business Categories</a></li>
							</ul>
						  </div>
						</div><!--end row-->

				   	    <div class="ns-row" id="ns-header">
					      <div class="ns-actions">Actions</div>
					      <div class="ns-class">Sort</div>
					      <div class="ns-url">Slug</div>
					      <div class="ns-title">Title</div>
					    </div>
					    <?php
	                        if(isset($menu) && $menu!=null){
	                        	echo $menu;
	                        }
	                        else{
	                        	echo '<ul id="easymm"></ul>';
	                        }
                    	?>
					    <div id="ns-footer">
					      <button type="submit" disabled="disabled" class="btn btn-save btn-primary" id="btn-save-menu">Update</button>
                                              <span class="image-load" style="display:none;"><img style="width:15px;" src="/skins/images/loading.gif"></span>
					    </div>
				   	 </div>
				   	 <div class="col-lg-3 col-sm-12">
				   	 	<div class="box">
							<h3>Add New</h3>
							<div id="form-add-menu">
							    <div class="form-group">
							        <label for="exampleInputName2">Title</label>
							        <input type="text" class="form-control" id="add-title">
							    </div>
							    <div class="form-group">
									<button id="add-menu" type="submit" class="btn btn-primary">Add</button>
      								<span class="image-load" style="display:none;"><img style="width:15px;" src="/skins/images/loading.gif"></span>
      							</div>
							</div>
						</div>
				   	 </div>
			   </div>
           </div>
        </div>
     </div>
  </div>
</div>

<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add New</h4>
      </div>
      <div class="modal-body">
          <div class="form-group">
	     <label >Title</label>
             <input type="text" name="menu" class="form-control" id="add-name" required>
	  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-add-group">Save changes</button>
      	<span class="image-load" style="display:none;"><img style="width:15px;" src="/skins/images/loading.gif"></span>
      </div>
    </div>
  </div>
</div>


<!--model chang menu item-->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Category</h4>
      </div>
      <div class="modal-body">
      	  <div class="form-group">
		     <label >Title</label>
		     <input type="text" name="title" class="form-control" id="edit-title">
		  </div>
      </div>
      <div class="modal-footer">
        <input type="hidden" name="class" class="form-control" id="edit-id">
        <button type="button" class="btn btn-default btn-close" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-edit">Save changes</button>
        <span class="image-load" style="display:none;"><img style="width:15px;" src="/skins/images/loading.gif"></span>
      </div>
    </div>
  </div>
</div>
<style>
	.box {
	  border: 1px solid #e5e5e5;
	  background: #fafafa;
	  margin-bottom: 10px;
	  max-width: 245px;
  	  padding: 0 20px;
  	  margin-top: 50px;
	}
	.form-group label{font-weight: 0;}
	.border-error{border: 1px solid red !important;}
</style>