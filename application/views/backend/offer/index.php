<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
			<li class="active">Offer</li>
		</ol>
	</div><!--/.row-->
	
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Offer</h1>
			<a style="margin-bottom:20px;" href="/admin/offer/add_new" class="btn btn-primary">Add Offer</a>
		</div>
	</div><!--/.row-->
	
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">Offer manager</div>
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
					        <th data-field="f_name"  data-sortable="true">Title</th>
					        <th data-fiedl="num_day">Code</th>
					        <th data-field="mumber">Number uses</th>
					        <th data-field="Start">Start date</th>
					        <th data-field="End">End date</th>
					        <th data-fiedl="Type">Month plan</th>
					        <th data-fiedl="action">Action</th>
					    </tr>
					    </thead>
					    <tbody>
					    	
					    <?php 
					    	foreach($table_offer as $photo){
					    	$row = 0;
					    	$type = "Upgrade Account";
					    	if($photo['type']==2){
					    		$type = "Upgrade Design Wall";
					    	}
					    ?>
					    	<tr data-index="<?php echo $row; ?>">
					    		<td class="bs-checkbox"><input type="checkbox" name="photo[]" data-index="0"></td>
					   			<td><?php echo $photo['title_offer']; ?></td>
					   			<td><?php echo $photo['code']; ?></td>
					   			<td><?php echo $photo['number_uses']; ?></td>
					    		<td><?php echo $photo['start_date']; ?></td>
					    		<td><?php echo $photo['end_date']; ?></td>
					    		<td><?php echo $photo["max_files"] ;?></td>
					    		<td>
					    			<span class="action-buttons">			
										<?php echo anchor('admin/offer/edit/'.$photo["id"], '<span class="glyphicon glyphicon-pencil"></span>', array('title'=>'Del photo','class'=>'edit'));?>
										<?php echo anchor('admin/offer/delete/'.$photo["id"], '<span class="glyphicon glyphicon-trash"></span>', array('title'=>'Del photo','class'=>'trash','onclick' => 'return confirm(\'Are you sure to delete this offer?\')'));?>							
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