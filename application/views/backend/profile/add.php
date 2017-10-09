<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">		
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
			<li class="active">Profiles</li>
		</ol>
	</div><!--/.row-->
	
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Profiles</h1>
		</div>
	</div><!--/.row-->
			
	
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
			<?php 
				$attibuts= array('name' => 'addprofile');
				echo form_open('',$attibuts);
			?>
				<div class="panel-heading">Add New</div>
				<div class="panel-body">
					<?php $data_session = $this->session->flashdata('data_flash_session');?>
					<?php echo isset($data_session)?$data_session['message']:''; print_r($data_session['data']) ?>

                    <?php if(validation_errors()) echo validation_errors(); ?>
					
					
					<div class="form-group">
						<label>First Name</label>
						<?php $data = array('name' => 'first_name', 'value' => isset($data_session)?$data_session['data']['first_name']:'', 'class'=>'form-control','id' => 'first_name','placeholder'=> 'First Name');
            			echo form_input($data); ?>
					</div>
					<div class="form-group">
						<label>Last Name</label>
						<?php $data = array('name' => 'last_name', 'value' => isset($data_session)?$data_session['data']['last_name']:'', 'class'=>'form-control','id' => 'last_name','placeholder'=> 'Last Name');
            			echo form_input($data); ?>
					</div>
					<div class="form-group">
						<label>Email</label>
						<?php $data = array('name' => 'email','value' => isset($data_session)?$data_session['data']['email']:'Email','class'=>'form-control','id' => 'email','placeholder'=> 'Email');
            			echo form_input($data); ?>
					</div>
					<div class="form-group">
						<label>Password</label>
						<?php 
							$data = array('name'=> 'password', 'value' => isset($data_session)?$data_session['data']['pwd']:'', 'class'=> 'form-control', 'id'=> 'password', 'placeholder'=>'Password');
							echo form_password($data); 
						?>
					</div>
					<div class="form-group">
						<label>Confirm Password</label>
						<?php 
							$data = array('name'=> 'confirm_password', 'value' => isset($data_session)?$data_session['data']['pwd']:'', 'class'=> 'form-control', 'id'=> 'confirm_password', 'placeholder'=>'Confirm password');
							echo form_password($data); 
						?>
					</div>
					<div class="form-group">
						<label>Company Name</label>
						<?php $data = array('name' => 'company_name', 'value' => isset($data_session)?$data_session['data']['company_name']:'Company Name', 'class'=>'form-control','id' => 'company_name','placeholder'=> 'Company Name');
            			echo form_input($data); ?>
					</div>
					
					
				</div>
				<?php 

	                if(isset($role) && $role=='administrator'){
	                
				?>
				<div class="panel-heading">Permissions</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<label>Role</label><br>
								<?php 
									$options = array(
					                	'default'  		=> '— No role for this site —',
					                	'administrator' => 'Administrator',
					                	'contributor'   => 'Contributor'
					                );
									
					                
									$js = 'class="role_option"';
					                echo form_dropdown('role', $options, 'default',$js);
								?>
							</div>
							<div class="form-group rules_wrapper">
								<table class="table table-hover">
									<thead>
										<tr><th>Rule Name</th><th>View</th><th>Add</th><th>Edit</th><th>Delete</th></tr>
									</thead>
									<tbody>
										<?php for ($i=0; $i < count($modules); $i++) { 
											echo '<tr><td>'.$modules[$i].'</td>';
												for ($j=0; $j < 4; $j++) {

													
													$data = array(
													    'name'        => $modules[$i].'_'.$j,
													    'id'          => $modules[$i].'_'.$j,
													    'value'       => 1,
													    'checked'     => false,
													    );

													echo '<td>'.form_checkbox($data).'</td>';
													
												}
											echo '</tr>';
										}?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<?php }//endif?>

				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
						<?php $data = array('name' => 'Submit','id' => 'Submit','value' =>'Add New','class' => 'btn btn-primary');
            				echo form_submit($data); ?>
						</div>
					</div>
				</div>
			<?php  echo form_close();?>
			</div>
		</div>
	</div><!--/.row-->	
	
	
	
</div><!--/.main-->