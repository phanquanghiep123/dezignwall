<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Forms</title>

<link href="<?php echo backend_url('css/bootstrap.min.css');?>" rel="stylesheet">
<link href="<?php echo backend_url('css/datepicker3.css');?>" rel="stylesheet">
<link href="<?php echo backend_url('css/styles.css');?>" rel="stylesheet">

<!--[if lt IE 9]>
<script src="<?php echo backend_url('js/html5shiv.js');?>"></script>
<script src="<?php echo backend_url('js/respond.min.js');?>"></script>
<![endif]-->

</head>

<body>
	
	<div class="row">
		<div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
			<div class="login-panel panel panel-default">
				<div class="panel-heading">Log in</div>
				<div class="panel-body">
					<?php
						$attibuts= array('name' => 'loginForm');
						echo form_open('admin/login',$attibuts);

                    ?>
                    	<?php echo($this->session->flashdata('error_data'));?>

                        <?php if(validation_errors()) echo validation_errors(); ?>

                        
						<fieldset>
							<div class="form-group">
								<?php 
								 	$data = array('class'=> 'form-control', 'name' => 'user','value' => set_value('user'),'id' => 'user','placeholder'=> 'user');
								    echo form_input($data); 
								?>
							</div>
							<div class="form-group">
								<?php 
									$data = array('class'=> 'form-control', 'name'=> 'password','placeholder'=>'password','id'=> 'password');
									echo form_password($data); 
								?>
							</div>
						
							<?php
								$data = array('name'=> 'login', 'id'=> 'login', 'value'=>'login', 'class' => 'btn btn-primary');
	                            echo form_submit($data); 
                            ?>
						</fieldset>
					<?php  echo form_close();?>
				</div>
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->	
	
		

	<script src="<?php echo backend_url('js/jquery-1.11.1.min.js');?>"></script>
	<script src="<?php echo backend_url('js/bootstrap.min.js');?>"></script>
	<script src="<?php echo backend_url('js/chart.min.js');?>"></script>
	<script src="<?php echo backend_url('js/chart-data.js');?>"></script>
	<script src="<?php echo backend_url('js/easypiechart.js');?>"></script>
	<script src="<?php echo backend_url('js/easypiechart-data.js');?>"></script>
	<script src="<?php echo backend_url('js/bootstrap-datepicker.js');?>"></script>
	<script>
		!function ($) {
			$(document).on("click","ul.nav li.parent > a > span.icon", function(){		  
				$(this).find('em:first').toggleClass("glyphicon-minus");	  
			}); 
			$(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
		}(window.jQuery);

		$(window).on('resize', function () {
		  if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
		})
		$(window).on('resize', function () {
		  if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
		})
	</script>	
</body>

</html>
