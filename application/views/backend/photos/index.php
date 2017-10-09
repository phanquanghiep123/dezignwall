<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
			<li class="active">Photos</li>
		</ol>
	</div><!--/.row-->
	
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Photos</h1>
		</div>
	</div><!--/.row-->
			
	
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<?php if($this->session->flashdata('message')){ ?>
						<div class="alert bg-success" role="alert">
							<span class="glyphicon glyphicon-check"></span>
							<?php echo $this->session->flashdata('message')?>

							<a href="#" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a>
						</div>
					<?php } //end if ?>

					<?php 
						if(isset($table_photo) && count($table_photo) >0){
                	?>

					<table data-toggle="table" data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-sort-order="desc">
					    <thead>
					    <tr>
					        <th data-field="state" data-checkbox="true" >Item ID</th>
					        <th data-field="f_name"  data-sortable="true">Name</th>
					        <th data-field="l_name" data-sortable="true">Images</th>
					        <th data-field="email">Type</th>
					        <th data-field="company">Member upload</th>
					        <th data-field="login" data-sortable="true">Created at</th>
					        <th data-fiedl="action">Action</th>
					    </tr>
					    </thead>
					    <tbody>
					    	
					    <?php 
					    	foreach($table_photo as $photo){
					    	$row=0;
					    ?>
					    	<tr data-index="<?php echo $row; ?>">
					    		<td class="bs-checkbox"><input type="checkbox" name="photo[]" data-index="0"></td>
					   			<td style=""><?php echo $photo['name']; ?></td>
					    		<td style="text-align:center;"><img style="width: 100px;  height: 60px;" src = "<?php echo base_url($photo['path_file']); ?>"/></td>
					    		<td style=""><?php echo $photo['type']; ?></td>
					    		<td style=""><?php echo $photo['member_id']; ?></td>
					    		<td style=""><?php echo $photo['created_at']; ?></td>
					    		<td style="">
					    		<?php $status = 'status on';
					    		    	if($photo['status_photo'] == 0){
					    		    		$status = 'status of';
					    		    	}
					    		  ?>
					    			<span class="action-buttons">
										<?php echo anchor('admin/delphoto/'.$photo["photo_id"].'/' . ($page <= 0 ? "" : $page), '<span class="glyphicon glyphicon-trash"></span>', array('title'=>'Delete photo','class'=>'trash','onclick' => 'return confirm(\'Are you sure to delete this photo?\')'));?>
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
							<span class="glyphicon glyphicon-warning-sign"></span> Not found data <a href="#" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a>
						</div>
					<?php } ?>
					<div class="pull-right pagination"><?php echo @$links; ?></div>
				</div>
			</div>
		</div>
	</div><!--/.row-->	
	
	
	
</div><!--/.main-->