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
				$attibuts= array('name' => 'editprofile');
				echo form_open('',$attibuts);
			?>
				<div class="panel-heading">Personal info</div>
				<div class="panel-body">
					<?php echo($this->session->flashdata('message'));?>

                    <?php if(validation_errors()) echo validation_errors(); ?>
					
					
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>First Name</label>
								<?php $data = array('name' => 'first_name','value' => $profile["first_name"],'class'=>'form-control','id' => 'first_name','placeholder'=> 'First Name');
		            			echo form_input($data); ?>
							</div>
							<div class="form-group">
								<label>Last Name</label>
								<?php $data = array('name' => 'last_name','value' => $profile["last_name"],'class'=>'form-control','id' => 'last_name','placeholder'=> 'Last Name');
		            			echo form_input($data); ?>
							</div>
							<div class="form-group">
								<label>Email</label>
								<?php $data = array('name' => 'email','value' => $profile["email"],'class'=>'form-control','id' => 'email','placeholder'=> 'Email');
		            			echo form_input($data); ?>
							</div>
							<div class="form-group">
								<label>New Password</label>
								<?php $data = array('name' => 'password_new','value' => '','class'=>'form-control','id' => 'password');
		            			echo form_password($data); ?>
							</div>
							<div class="form-group">
								<label>Repeat New Password</label>
								<?php $data = array('name' => 'password_new','value' => '','class'=>'form-control','id' => 'password_new_repeat');
		            			echo form_password($data); ?>
							</div>
							<div class="form-group">
								<label>Company Name</label>
								<?php $data = array('name' => 'company_name','value' => $profile["company_name"],'class'=>'form-control','id' => 'company_name','placeholder'=> 'Company Name');
		            			echo form_input($data); ?>
							</div>
							
						</div>
						<div class="col-lg-6">
							
							
						</div>

					</div>
					

				</div>


				<?php 

	                if(isset($role) && $role=='administrator'){
	                
				?>
				<div class="panel-heading">Permissions</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<?php 
							if(!empty($profile["role"])){
                				$role_obj = json_decode($profile["role"]);
	                			
							?>
							<div class="form-group">
								<label>Role</label><br>
								<?php 
									$options = array(
					                	'default'  		=> '— No role for this site —',
					                	'administrator' => 'Administrator',
					                	'contributor'   => 'Contributor'
					                );
									$selected = $role_obj->{'name'};
					                

					                echo form_dropdown('role', $options, $selected);
								?>
							</div>
							<div class="form-group">
								<table class="table table-hover">
									<thead>
										<tr><th>Rule Name</th><th>View</th><th>Add</th><th>Edit</th><th>Delete</th></tr>
									</thead>
									<tbody>
										
									
									<?php 
										
										foreach ($role_obj->{'rules'} as $key => $rule) {
											echo '<tr><td>'.$rule->{'name'}.'</td>';
											for ($i=0; $i < 4; $i++) {

												$details = $rule->{'do'};
												$data = array(
											    'name'        => $rule->{'name'}.'_'.$i,
											    'id'          => $rule->{'name'}.'_'.$i,
											    'value'       => 1,
											    'checked'     => $details[$i]==1?true:false,
											    );

											echo '<td>'.form_checkbox($data).'</td>';
												
											}
											
											echo '</tr>';
										}
									?>
									</tbody>
								</table>
							</div>
							<?php }else{?>
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

							<?php }//endif?>
						</div>
					</div>
				</div>
				<?php }//endif?>

				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<?php $data = array('name' => 'Submit','id' => 'Submit','value' =>'Update','class' => 'btn btn-primary');
    							echo form_submit($data); ?>
						</div>
					</div>
				</div>

			<?php  echo form_close();?>
			</div>
		</div>
	</div><!--/.row-->	
	
	
	
</div><!--/.main-->
