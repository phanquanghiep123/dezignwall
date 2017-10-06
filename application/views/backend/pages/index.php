
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="<?php echo admin_url(); ?>"><span class="glyphicon glyphicon-home"></span></a></li>
			<li class="active"><?php echo isset($title)?$title:'Unknow'; ?></li>
		</ol>
	</div><!--/.row-->
	
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><?php echo isset($title)?$title:'Unknow'; ?></h1>
		</div>
	</div><!--/.row-->
			
	
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading"><?php echo isset($title)?$title:'Unknow'; ?> manager</div>
				<div class="panel-body">
					<?php if($this->session->flashdata('message')){ ?>
						<div class="alert bg-success" role="alert">
							<span class="glyphicon glyphicon-check"></span>
							<?php echo $this->session->flashdata('message')?>

							<a href="#" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a>
						</div>
					<?php } //end if ?>

					<?php 
						if(isset($pages) && count($pages) >0){
                	?>

					<table data-toggle="table" data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
					    <thead>
					    <tr>
					        <th data-field="state" data-checkbox="true" >Item ID</th>
					        
					        <th data-field="title"  data-sortable="true">Title</th>
					        <th data-field="slug" data-sortable="true">Slug</th>
					        <th data-field="created_at">Created at</th>
					        <th data-fiedl="action">Action</th>
					    </tr>
					    </thead>
					    <tbody>
					    	
					    <?php 
					    	foreach($pages as $page){
					    	$row=0;
					    ?>
					    	<tr data-index="<?php echo $row; ?>">
					    		<td class="bs-checkbox"><input type="checkbox" name="profile[]" data-index="0"></td>
					   			<td style=""><?php echo $page['depth'].$page['title']; ?></td>
					    		<td style=""><?php echo $page['slug']; ?></td>
					    		<td style=""><?php echo $page['created_at']; ?></td>
	
					    		<td style="">
					    			<span class="action-buttons">
										
										<?php echo anchor('admin/editPage/'.$page["id"], '<span class="glyphicon glyphicon-pencil"></span>', array('title'=>'Edit Page','class'=>'edit'));?>
										<a class="flag" href="#"><span class="glyphicon glyphicon-flag"></span></a>
										
										<?php echo anchor('admin/delPage/'.$page["id"], '<span class="glyphicon glyphicon-trash"></span>', array('title'=>'Del Page','class'=>'trash', 'onclick' => 'return confirm(\'Are you sure to delete this page?\')'));?>
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
				</div><!--/.panel-body->	
			</div>
		</div>
	</div><!--/.row-->	
	
	
	
</div><!--/.main-->