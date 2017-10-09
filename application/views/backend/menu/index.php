<script type="text/javascript">
	//delete menu item
	$(document).on("click",'#box-category-menu li.parent > #colspan',function (event) {
		event.stopPropagation();
  		$(this).parent().find(">ul.tree").slideToggle();
  	});

    $(document).on('click','.delete-menu', function(){
    	var li_current=$(this).parent('.ns-actions').parent('.ns-row').parent('.sortable');
    	var id=li_current.find('#menu_id').val();
    	if(confirm('Do you delete menu item?')){
    		$.ajax({
		      type: 'POST',
		      url: '/admin/delete_menu_item/'+id,
		      data:{},
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

    //edit menu item
    $(document).on('click','.edit-menu',function(){
    	var li_current=$(this).parent('.ns-actions').parent('.ns-row').parent('.sortable');
    	var id = li_current.find('#menu_id').val();
    	//$('#edit-title').val(li_current.find('.ns-title').html());
    	//$('#edit-url').val(li_current.find('.ns-url').html());
    	//$('#edit-class').val(li_current.find('.ns-class').html());
    	$('#edit-id').val(id);
    	$.ajax({
			type: 'POST',
			dataType:'json',
			url: "/admin/get_item_menu/"+id,
			data:{},
			success: function(data) {                
				$('#edit-title').val(data.title);
				$('#edit-url').val(data.url);
				$('#edit-class').val(data.class);	
			}
        });
    });

    //add menu item
    $(document).on('click','.box:not(#box-category-menu) #add-menu',function(){
    	var title=$('#add-title').val();
    	var url=$('#add-url').val();
    	var clas=$('#add-class').val();
    	var bool=true;
    	if(title.trim()=='' || title.trim()==null){
    		bool=false;
    		$(this).parent(".box").find('#add-title').addClass('border-error');
    	}
    	else{
    		$(this).parent(".box").find('#add-title').removeClass('border-error');
    	}

    	if(url.trim()=='' || url.trim()==null){
    		bool=false;
    		$(this).parent(".box").find('#add-url').addClass('border-error');
    	}
    	else{
    		$(this).parent(".box").find('#add-url').removeClass('border-error');
    	}

    	if(bool){
    		$('#form-add-menu .image-load').show();
    		$(this).attr('disabled','disabled');
    		var post = {"title":title,"url":url,"class":clas,"group_id":<?php echo $id; ?>};
    		save_new_menu(post);
    	}
    });
    var text ="";
    $(document).on('click','#box-category-menu #add-menu',function(event){
    	event.stopPropagation();
    	var new_text =[];
    	$.each($(this).parents("#box-category-menu").find("input:checked"),function(){
    		var url     = "/search/"+get_parent($(this).attr("data-parent")) + $(this).val();
    		var title   = $(this).attr("data-title");
    		var slug    = $(this).val();
    		var arg_new = {"url":url,"title":title,"slug":slug}
    		new_text.push(arg_new);
    	});
    	if(new_text.length>0){
    		$('#box-category-menu .image-load').show();
    		$.ajax({
				type: 'POST',
				url: '/admin/add_menu_of_category/',
			    dataType:"json",
				data:{"new_text" : new_text,"id" : "<?php echo @$id; ?>"},
				success: function(data){
					if(data.length>0){
						var html="";
						console.log(data);
						$.each(data,function(key,value){
							html+='<li id="menu-'+parseInt(value["id_insert"])+'" class="sortable">';
				      		html+='<div class="ns-row">';
							html+='<div class="ns-title">'+value['title']+'</div>';
							html+='<div class="ns-url">'+value['url']+'</div>';
							html+='<div class="ns-class"></div>';
							html+='<div class="ns-actions">';
							html+='<a href="#" class="edit-menu" data-toggle="modal" data-target="#editModal" title="Edit Menu"><img src="/skins/images/edit.png" alt="Edit"></a>';
				            html+='<a href="#" class="delete-menu"><img src="/skins/images/cross.png" alt="Delete"></a>';
							html+='<input type="hidden" id="menu_id" name="menu_id" value="'+parseInt(value["id_insert"])+'">';
							html+='</div>';
							html+='</div>';
				           	html+='</li>';
                            $('#easymm').append(html).SortableAddItem($('#menu-'+parseInt(value["id_insert"]))[0]);
                            html = "";
						});	
					}
				},
				complete:function(){
					$('#add-menu').removeAttr('disabled');
					$('#box-category-menu .image-load').hide();
					$(window).scrollTop($(document).height());
				}
		    });
    	}
    });
    
    function get_parent(parent_id){
    	text ="";
    	if(parent_id != 0){
    		$.each($("#box-category-menu #"+parent_id+""),function(){
    			text += $(this).find("input").val()+"/";	
    			if($(this).find("input").attr("data-parent") != 0){
    				get_parent($(this).find("input").attr("data-parent"));
    			}
    		});
    	}
    	return text;
    }
    function save_new_menu(post){
    	$.ajax({
			type: 'POST',
			url: '/admin/add_item_menu/',
			data:post,
			success: function(data) {
					console.log(data);
					if(parseInt(data)>0){
						var html='<li id="menu-'+parseInt(data)+'" class="sortable">';
			      		html+='	      <div class="ns-row">';
						html+='            <div class="ns-title">'+post['title']+'</div>';
						html+='            <div class="ns-url">'+post['url']+'</div>';
						html+='            <div class="ns-class">'+post['clas']+'</div>';
						html+='            <div class="ns-actions">';
						html+='               <a href="#" class="edit-menu" data-toggle="modal" data-target="#editModal" title="Edit Menu"><img src="/skins/images/edit.png" alt="Edit"></a>';
			            html+='               <a href="#" class="delete-menu"><img src="/skins/images/cross.png" alt="Delete"></a>';
						html+='               <input type="hidden" id="menu_id" name="menu_id" value="'+parseInt(data)+'">';
						html+='            </div>';
						html+='         </div>';
			           	html+='	  </li>';
			            $('#easymm').append(html).SortableAddItem( $('#menu-'+parseInt(data))[0] );
			            $('#add-title').val('');
			    	 $('#add-url').val('');
			    	 $('#add-class').val('');
					}
			},
			complete:function(){
				$('#add-menu').removeAttr('disabled');
				$('#form-add-menu .image-load').hide();
				$(window).scrollTop($(document).height());
			}
	    });
    }	
	//save edit menu
    $(document).on('click','.btn-edit',function(){
    	var title=$('#edit-title').val();
    	var url=$('#edit-url').val();
    	var clas=$('#edit-class').val();
    	var id=$('#edit-id').val();
    	var bool=true;
    	if(title.trim()=='' || title.trim()==null){
    		bool=false;
    		$('#edit-title').addClass('border-error');
    	}
    	else{
    		$('#edit-title').removeClass('border-error');
    	}

    	if(url.trim()=='' || url.trim()==null){
    		bool=false;
    		$('#edit-url').addClass('border-error');
    	}
    	else{
    		$('#edit-url').removeClass('border-error');
    	}

    	if(bool){
    		$('#editModal .image-load').show();
    		$(this).attr('disabled','disabled');
    		$.ajax({
		      type: 'POST',
		      url: '/admin/update_item_menu/'+id,
		      data:{"title":title,"url":url,"class":clas},
		      success: function(data) {
                    var li=$('#menu-'+id+' .ns-row');
                    $('#menu-'+id+' > .ns-row .ns-title').html(title);
                    $('#menu-'+id+' > .ns-row .ns-url').html(url);
                    $('#menu-'+id+' > .ns-row .ns-class').html(clas);
			        $('#edit-title').val();
			    	$('#edit-url').val();
			    	$('#edit-class').val();	
		      },
		      complete:function(){
				$('.btn-edit').removeAttr('disabled');
				$('#editModal .image-load').hide();
                $('#editModal .btn-close').trigger('click');
		      }
	        });
    	}
    });

	//add group menu
	$(document).on('click','.btn-add-group',function(){
		var name=$("#add-name").val();
		var bool=true;
    	if(name.trim()=='' || name.trim()==null){
    		bool=false;
    		$("#add-name").addClass('border-error');
    	}
    	else{
    		$("#add-name").removeClass('border-error');
    	}

    	if(bool){
    		$('#addModal .image-load').show();
    		$(this).attr('disabled','disabled');
    		$.ajax({
		      type: 'POST',
		      url: '/admin/add_menu_group/',
		      data:{"name":name},
		      success: function(data) {
                  $('#addModal .image-load').hide();
                  $(".btn-add-group").removeAttr('disabled');
                  location.href="/admin/menu/"+data;
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
	$.each($("#box-category-menu li"),function(){
		if($(this).find(">ul.tree li").length > 0 ){
			$(this).addClass("parent");
			$(this).append('<span class="glyphicon glyphicon-resize-vertical" id="colspan" aria-hidden="true"></span>')
		}
	});
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
        $(this).attr('disabled','disabled');
        $.ajax({
	      type: 'POST',
	      url: '/admin/test',
	      data: menu_serialized,
	      success: function(data) {
		  	//alert(data);
            if(data=='true'){
                
            }	
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
			 <li class="active">Menu</li>
      </ol>
  </div>
  <div class="row">
     <div class="col-lg-12">
        <div class="panel panel-default">
           <div class="panel-body">
			   <div class="row">
				   	 <div class="col-lg-8 col-sm-12">

				   	    <div class="row">
				   	      <div class="col-lg-12">
					   	 	<ul style="float: left;width:100%;border-bottom: 5px solid #009900;" class="menu-tab-group" id="menu-group">
								<?php 
									if(isset($menu_group) && $menu_group!=null):
										foreach ($menu_group as  $value) :	
								?>
										   <li <?php if($value['id']==$id){echo 'class="current"';} ?>><a href="/admin/menu/<?php echo $value['id']; ?>"><?php echo $value['name']; ?></a></li>
								<?php
								       endforeach;
								   endif;
								   ?>
								<li id="add-group"><a  data-toggle="modal" data-target="#addModal" href="#" title="Add Menu Group">+</a></li>
							</ul>
						  </div>
						</div><!--end row-->

				   	    <div class="ns-row" id="ns-header">
					      <div class="ns-actions">Actions</div>
					      <div class="ns-class">Class</div>
					      <div class="ns-url">URL</div>
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
					      <button type="submit" disabled="disabled" class="btn btn-save btn-primary" id="btn-save-menu">Update Menu</button>
                                              <span class="image-load" style="display:none;"><img style="width:15px;" src="/skins/images/loading.gif"></span>
					    </div>
				   	 </div>
				   	 <div class="col-lg-4 col-sm-12">
				   	 	<div class="box">
							<h3>Add Menu Custom</h3>
							<div id="form-add-menu">
							    <div class="form-group">
							        <label for="exampleInputName2">Title</label>
							        <input type="text" class="form-control" id="add-title">
							    </div>
								<div class="form-group">
							        <label for="exampleInputName2">Url</label>
							        <input type="text" class="form-control" id="add-url">
							    </div>
							    <div class="form-group">
							        <label for="exampleInputName2">Class</label>
							        <input type="text" class="form-control" id="add-class">
							    </div>
							    <div class="form-group">
									<button id="add-menu" type="submit" class="btn btn-primary">Add Menu</button>
      								<span class="image-load" style="display:none;"><img style="width:15px;" src="/skins/images/loading.gif"></span>
      							</div>
							</div>
						</div>
						<div class="box" id="box-category-menu">
							<h3>Add Menu Category</h3>
							<div id="form-add-menu">
							    <?php echo @$menu_category;?>   
							</div>
							<div class="form-group">
								<button id="add-menu" type="submit" class="btn btn-primary">Add Menu</button>
  								<span class="image-load" style="display:none;"><img style="width:15px;margin-top: 10px;" src="/skins/images/loading.gif"></span>
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
        <h4 class="modal-title" id="myModalLabel">Creat new menu</h4>
      </div>
      <div class="modal-body">
          <div class="form-group">
	     <label >Name</label>
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
        <h4 class="modal-title" id="myModalLabel">Menu item</h4>
      </div>
      <div class="modal-body">
      	  <div class="form-group">
		     <label >Title</label>
		     <input type="text" name="title" class="form-control" id="edit-title">
		  </div>
		  <div class="form-group">
		     <label >Url</label>
		     <input type="text" name="url" class="form-control" id="edit-url">
		  </div>
		  <div class="form-group">
		     <label >Class</label>
		     <input type="text" name="class" class="form-control" id="edit-class">
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
	  max-width: 100%;
	  width: 100%;
  	  padding: 0 20px;
  	  margin-top: 50px;
	}
	.form-group label{font-weight: 0;}
	.border-error{border: 1px solid red !important;}
</style>