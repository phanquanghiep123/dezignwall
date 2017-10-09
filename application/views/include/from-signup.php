<div id="form-user" class="singup-form box-bg-white box-ball">
    <div id="close-form">x</div>
	<h2 class="title">For people who love commercial design!</h2>
<?php
    $company = array(
		'name' => 'company',
		'class' => 'company form-control',
		'id' => 'company',
		'title' => 'Company',
		'placeholder' => 'Your company',
		'tabindex'=>'1',
		'data-valid'=>"true"
	);
	$first_name = array(
		'name' => 'first-name',
		'class' => 'first-name form-control',
		'id' => 'first-name',
		'title' => 'First name',
		'placeholder' => 'Your first name',
		'tabindex'=>'2',
		'data-valid'=>"true"
	);
	$last_name  = array(
		'name' => 'last-name',
		'class' => 'last-name form-control',
		'id' => 'last-name',
		'title' => 'Last name',
		'placeholder' => 'Your last name',
		'tabindex'=>'3',
		'data-valid'=>"true"
	);
	$email = array(
		'name' => 'email',
		'type'=>'text',
		'data-valid'=>'true', 
		'class' => 'email form-control',
		'id' => 'email',
		'title' => 'Email',
		'placeholder' => 'Your email',
		'tabindex'=>'4',
		'value'   => ''
	);
	$pass = array(
		'name'=> 'password',
		'type'=>'password',
		'class'=>'password form-control',
		'id'=>'password',
		'title' => 'Password',
		'placeholder'=>'Create a password',
		'tabindex'=>'5',
		'data-valid'=>"true"
	);
	$confirm = array(
		'name'=> 'confirm-password',
		'type'=>'password',
		'class'=>'confirm-password form-control',
		'id'=>'password',
		'title' => 'Confirm password',
		'placeholder'=>'Confirm password',
		'tabindex'=>'6',
		'data-valid'=>"true"
	);
	$join = array(
		'type'=>"submit",
		'name'=> 'join',
		'class'=>'join btn btn-primary button-join button-signin',
		'id'=>'join',
		'value' => "Join Now",
		'tabindex'=>'8',
		'data-valid'=>"true"
	);
	
	$attributes = array('class' => 'form-horizontal form-signup', 'id' => 'form-user-input','method'=>'post');
	echo form_open(base_url("accounts/signup"),$attributes); ?>
	<div class="col-md-12">
		<div class="row">
		    <div class="error"></div>
		    <div class="form-group">
				<label for="email" class="col-sm-5 control-label">Company Name:</label>
				<div class="col-md-7"><?php echo form_input($company);?></div>
			</div>
			<div class="form-group">
				<label for="email" class="col-sm-5 control-label">First Name:</label>
				<div class="col-md-7"><?php echo form_input($first_name);?></div>
			</div>
			<div class="form-group">
				<label for="email" class="col-sm-5 control-label">Last Name:</label>
				<div class="col-md-7"><?php echo form_input($last_name);?></div>
			</div>
			<div class="form-group">
				<label for="email" class="col-sm-5 control-label">Email:</label>
				<div class="col-md-7"><?php echo form_input($email);?></div>
			</div>
			<div class="form-group">
				<label for="email" class="col-sm-5 control-label">Password:</label>
				<div class="col-md-7"><?php echo form_input($pass);?></div>
			</div>
			<div class="form-group">
				<label for="password" class="col-sm-5 control-label">Confirm Password:</label>
				<div class="col-md-7">
					<div class="row">
						<div class="col-md-12"><?php echo form_input($confirm);?></div>
						<div class="col-md-12 text-right"><p class="forgot-text" id="upload-avatar-control">Upload Profile Image</p></div>
					</div>
				</div>
			</div>
			<input type="file" name="upload_avatar" class="upload_avatar" id="upload_avatar">
			<input type="hidden" id="project_id" value="<?php echo @$_GET['project_id']; ?>" name="project_id" />
			<input type="hidden" id="token" value="<?php echo @$_GET['token']; ?>" name="token" />
			<div class="form-group">
			    <div class="col-md-5"></div>
				<div class="col-md-7">
					<div class="col-xs-6"><a href="#" for-parent="#form-user" class="btn btn-gray clear button-signin" id="clear">Clear</a></div>
					<div class="col-xs-6"><div class="loadding text-center"><img src="<?php echo skin_url("/images/loadding.GIF");?>"></div><?php echo form_input($join);?></div>
				</div>
			</div>
		</div>
	</div>
	<?php echo form_close();?>

</div>