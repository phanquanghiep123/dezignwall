<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
			<li class="active">Campaign</li>
		</ol>
	</div><!--/.row-->
	
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Campaign</h1>
			<a style="margin-bottom:20px;" href="/admin/add_campaign/" class="btn btn-primary">Add Menu</a>
		</div>
	</div><!--/.row-->
			
	
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">Campaign manager</div>
				<div class="panel-body">
					<?php if($this->session->flashdata('message')){ ?>
						<div class="alert bg-success" role="alert">
							<span class="glyphicon glyphicon-check"></span>
							<?php echo $this->session->flashdata('message')?>

							<a href="#" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a>
						</div>
					<?php } //end if ?>

					<?php 
						if(isset($table_campaign) && count($table_campaign) >0){
                	?>

					<table data-toggle="table" data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
					    <thead>
					    <tr>
					        <th data-field="state" data-checkbox="true" >Item ID</th>
					        <th data-field="f_name"  data-sortable="true">Title</th>
					        <th data-field="l_name" data-sortable="true">Summary</th>
					        <th data-field="email">Start date</th>
					        <th data-field="company">End date</th>
					        <th data-field="login" data-sortable="true">Package ID</th>
					        <th data-fiedl="num_day">Num days</th>
					        <th data-fiedl="action">Action</th>
					    </tr>
					    </thead>
					    <tbody>
					    	
					    <?php 
					    	foreach($table_campaign as $photo){
					    	$row=0;
					    ?>
					    	<tr data-index="<?php echo $row; ?>">
					    		<td class="bs-checkbox"><input type="checkbox" name="photo[]" data-index="0"></td>
					   			<td><?php echo $photo['title']; ?></td>
					    		<td><?php echo $photo['summary']; ?></td>
					    		<td><?php echo $photo['start_date']; ?></td>
					    		<td><?php echo $photo['end_date']; ?></td>
					    		<td><?php echo $photo['package_id']; ?></td>
					    		<td><?php echo $photo['num_days']; ?></td>
					    		<td>
					    			<span class="action-buttons">			
										<?php echo anchor('admin/edit_campaign/'.$photo["id"], '<span class="glyphicon glyphicon-pencil"></span>', array('title'=>'Del photo','class'=>'edit'));?>
										<?php echo anchor('admin/delete_campaign/'.$photo["id"], '<span class="glyphicon glyphicon-trash"></span>', array('title'=>'Del photo','class'=>'trash','onclick' => 'return confirm(\'Are you sure to delete this Campaign?\')'));?>
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
</div><!--/.main-->