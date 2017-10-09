
<div class="box-wapper-show-image">
	<div class="container">
	    <div class="box-public">
			<div class="row">
			  <div class="col-md-12 text-center"><h3 class="title-forget">Enter your new password</h3>
			  <div class="col-md-9 content-cented">
			<?php
			$pass = array(
				'name'=> 'password',
				'type'=>'password',
				'class'=>'password form-control',
				'id'=>'password',
				'title' => 'Password',
				'placeholder'=>'Create a new password',
				'tabindex'=>'1',
				'data-valid'=>"true"
			);
			$confirm = array(
				'name'=> 'confirm-password',
				'type'=>'password',
				'title' => 'Confirm password',
				'class'=>'confirm-password form-control',
				'id'=>'password',
				'placeholder'=>'Confirm new password',
				'tabindex'=>'2',
				'data-valid'=>"true"
			);
			$slug = array(
				'name'		=>  'slug',
				'type'		=>	'hidden',
				'tabindex'	=>	'3',
				'value'		=>  @$this->input->get("slug")
			);
			$token = array(
				'name'		=>  'token',
				'type'		=>	'hidden',
				'tabindex'	=>	'4',
				'value'		=>  @$this->input->get("token")
			);
			$forgot = array(
				'type'=>"submit",
				'name'=> 'update-password',
				'class'=>'update-password btn btn-primary button-singin',
				'id'=>'update-password',
				'value' => "Update password",
				'tabindex'=>'5'
			);
			$attributes = array('class' => 'form-horizontal', 'id' => 'form-forgot','method'=>"POST");
			echo form_open(base_url("accounts/reset"),$attributes); ?>
				<div class="form-group row">
					<label for="email" class="col-sm-4 control-label">New password</label>
					<div class="col-md-8"><?php echo form_input($pass);?></div>
				</div>
				<div class="form-group row">
					<label for="email" class="col-sm-4 control-label">New password confirm</label>
					<div class="col-md-8"><?php echo form_input($confirm);?></div>
				</div>
				<?php echo form_input($slug);?>
				<?php echo form_input($token);?>
				<div class="form-group row">
					<div class="col-md-12 text-right"><a class="btn btn-gray" id="clear" href="#">Clear</a><?php echo form_input($forgot);?></div>
				</div>
			<?php echo form_close();?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php 
if(isset($success) && isset($message) ){?>
<script type="text/javascript">
$(document).ready(function(){
	var success_pass = "<?php echo $success ;?>";
	if(success_pass == "success" ){
		messenger_box("Message", "<?php echo @$message; ?>");
	}else{
		messenger_box("Error message", "<?php echo @$message; ?>");
	}
});
</script>
<?php }?>