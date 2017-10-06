

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="/admin"><span class="glyphicon glyphicon-home"></span></a></li>
			
		</ol>
	</div><!--/.row-->
	
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Dashboard</h1>
		</div>
	</div><!--/.row-->
			
	
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading"><?php if(isset($role) && $role=='administrator') echo 'Role manager'; else 'Welcome to the admin dashboard panel'; ?></div>
				<div class="panel-body">
					<?php if($this->session->flashdata('message')) echo $this->session->flashdata('message'); ?>

					<?php 
						if(isset($role) && $role=='administrator' && isset($profiles) && count($profiles) >0){
                	?>

					<table data-toggle="table" data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
					    <thead>
					    <tr>
					        <th data-field="state" data-checkbox="true" >Item ID</th>
					        
					        <th data-field="f_name"  data-sortable="true">First name</th>
					        <th data-field="l_name" data-sortable="true">Last name</th>
					        <th data-field="email">Email</th>
					        <th data-field="company">Role</th>
					        <th data-field="login" data-sortable="true">Last Login</th>
					        <th data-field="created" data-sortable="true">Date create</th>
					        <th data-fiedl="action">Action</th>
					    </tr>
					    </thead>
					    <tbody>
					    	
					    <?php 
					    	foreach($profiles as $profile){
					    	$row=0;
					    ?>
					    	<tr data-index="<?php echo $row; ?>">
					    		<td class="bs-checkbox"><input type="checkbox" name="profile[]" data-index="0"></td>
					   			<td style=""><?php echo $profile['first_name']; ?></td>
					    		<td style=""><?php echo $profile['last_name']; ?></td>
					    		<td style=""><?php echo $profile['email']; ?></td>
					    		<td style=""><?php echo json_decode($profile['role'])->{'name'}; ?></td>
					    		<td style="">14:20:20 04-16-2015</td>
					    		<td style="">14:20:20 04-16-2015</td>
					    		<td style="">
					    		    <?php $status = 'status on';
					    		    	if($profile['status_member'] == 0){
					    		    		$status = 'status of';
					    		    	}
					    		     ?>
					    			<span class="action-buttons">			
										<?php echo anchor('admin/editProfile/'.$profile["id"], '<span class="glyphicon glyphicon-pencil"></span>', array('title'=>'Del Profile','class'=>'edit'));?>
										<a class="flag <?php echo $status;?>" href="<?php echo 'http://designwall.mosaweb.com/admin/hiddenStatusmember/'.$profile['id'].'';?>" onclick="return confirm('Are you sure you want to change the value of the member status are not?')"><span class="glyphicon glyphicon-flag"></span></a>	
										<?php echo anchor('admin/delProfile/'.$profile["id"], '<span class="glyphicon glyphicon-trash"></span>', array('title'=>'Del Profile','class'=>'trash','onclick' => 'return confirm(\'Are you sure to delete this profile?\')'));?>
									</span>
								</td>

					    	</tr>
					    <?php 
					    	$row++;
					    	} //end foreach
					    ?>
					    	
					    </tbody>
					</table>
					<?php } ?>
				</div>
			</div>
		</div>
	</div><!--/.row-->	
	
	
	
</div><!--/.main-->