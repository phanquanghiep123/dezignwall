<div class="box-wapper-show-image">
	<div class="container">
	    <div class="box-public">
			<div class="row">
			  <div class="col-md-12 text-center"><h3 class="title-forget">Enter your email address to reset your password. You may need to check your spam folder.</h3>
			  <div class="col-md-8 content-cented">
			<?php
			$email = array(
				'name' => 'email',
				'type'=>'text',
				'data-valid' => 'true',
				'class' => 'email form-control',
				'id' => 'email',
				'title' => 'Email',
				'placeholder' => 'Your email',
				'value' => isset($_POST['email']) ? $_POST['email'] : "",
				'tabindex'=>'1'
			);
			$forgot = array(
				'type'=>"submit",
				'name'=> 'forgot',
				'class'=>'forgot btn btn-primary button-singin',
				'id'=>'forgot',
				'value' => "Send",
				'tabindex'=>'2'
			);
			$attributes = array('class' => 'form-horizontal', 'id' => 'form-forgot','method'=>"POST");
			echo form_open(base_url("accounts/forgot"),$attributes); ?>
				<div class="form-group row">
					<label for="email" class="col-sm-2 control-label">Email</label>
					<div class="col-md-10"><?php echo form_input($email);?></div>
				</div>
				<div class="form-group row">
					<div class="col-md-12  text-right">
						<a class="btn btn-gray" id ="clear" href="<?php base_url();?>">Clear</a>
						<?php echo form_input($forgot);?>
					</div>
				</div>
			<?php echo form_close();?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php if(isset($success) && isset($message) ){?>
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