<?php 
/*$data_wrapper an array*/
if(isset($view_wrapper) && file_exists(APPPATH."views/{$view_wrapper}.php")){?>
    <div class="<?php echo @$class_wrapper; ?>">
		<?php $this->load->view($view_wrapper,@$data_wrapper); ?>
	</div>
<?php } ?>
