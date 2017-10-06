
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
			<li class="active">Offer</li>
		</ol>
	</div><!--/.row-->
	
	<div class="row">
		<div class="col-lg-12" id="add_new">
			<h1 class="page-header">View Offer</h1>
			<div class="add_new_code">
				<form method="post" action="<?php echo base_url();?>admin/offer_view_code/<?php echo $offer;?>">
					<input type="text" name="new_code" id="new_code">
					<input type="hidden" name="id_offer" value="<?php echo $offer;?>" id="id_offer">
					<input type="submit" class="btn-primary" value="Add Offer Code">
				</form>
			</div>
		</div>
		
	</div><!--/.row-->			
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">View Offer manager</div>
				<div class="panel-body">
					<?php if($this->session->flashdata('message')){ ?>
						<div class="alert bg-success" role="alert">
							<span class="glyphicon glyphicon-check"></span>
							<?php echo $this->session->flashdata('message')?>
							<a href="#" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a>
						</div>
					<?php } //end if ?>

					<?php 
						if(isset($table_offer) && count($table_offer) >0){
                	?>

					<table data-toggle="table" data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
					    <thead>
					    <tr>
					        <th data-field="state" data-checkbox="true" >Item ID</th>
					        <th data-field="f_name"  data-sortable="true">Code</th> 
					        <th data-fiedl="action">Action</th>
					    </tr>
					    </thead>
					    <tbody>
					    	
					    <?php 
					    	foreach($table_offer as $photo){
					    	$row=0;
					    ?>
					    	<tr data-index="<?php echo $row; ?>">
					    		<td class="bs-checkbox"><input type="checkbox" name="photo[]" data-index="0"></td>
					   			<td><?php echo $photo['code']; ?></td>
					    		<td>
					    			<span class="action-buttons">			
										<?php echo anchor('admin/offer_view_code_delete/'.$offer."/".$photo["id"], '<span class="glyphicon glyphicon-trash"></span>', array('title'=>'Del photo','class'=>'trash','onclick' => 'return confirm(\'Are you sure to delete this offer?\')'));?>
										<a href="#" data-code = "<?php echo $photo['code'];?>" data-id ="<?php echo $photo["id"];?>" data-toggle="modal" data-target="#myModal" title="Del photo" class="edit"><span class="glyphicon glyphicon-pencil"></span></a>
										<a class="flag status on" href="http://designwall.mosaweb.com/admin/hiddenStatusmember/394" onclick="return confirm('Are you sure you want to change the value of the member status are not?')"><span class="glyphicon glyphicon-flag"></span></a>
									</span>
								</td>

					    	</tr>
					    <?php 
					    	$row++;
					    	} //end foreach
					    ?>
					    	
					    </tbody>
					</table>
					<?php } else { ?>
						<div class="alert bg-warning" role="alert">
							<span class="glyphicon glyphicon-warning-sign"></span> Welcome to the admin dashboard panel bootstrap template <a href="#" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div><!--/.row-->
	<div id="myModal" class="modal fade" role="dialog">
  		<div class="modal-dialog">
    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title">Edit Code</h4>
	      </div>
	      <div class="modal-body">
	       		<form id="update_code" method="post" action="<?php echo base_url();?>admin/upday_code/">
					<label>Enter Code<input type="text" name="new_code" id="new_code_upday"></label>
					<input type="hidden" name="id_offer" value="<?php echo $offer;?>" id="id_offer">
					<input type="hidden" name="id" value="" id="id">
					<input type="submit" class="btn-primary" id="update_code_submit" value="Save">
				</form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>

	  </div>
	</div>
</div><!--/.main-->

<?php 
	if(isset($id_insert)){?>
		<script type="text/javascript">
			$(document).ready(function(){
				alert("<?php echo $message ;?>");
			});
		</script>
	<?php } ?>
	<script type="text/javascript">
	$(document).on("click",".action-buttons .edit",function(){
		$("#update_code #new_code_upday").val($(this).attr("data-code"));
		$("#update_code #id").val($(this).attr("data-id"));
	});
	$(document).on("click","#update_code_submit",function(){
		if($(this).parents("#update_code").find("#new_code_upday").val()==""){
			alert("Offer Code Is Not Empty.");
			return false;
		}
	});
	</script>
?>