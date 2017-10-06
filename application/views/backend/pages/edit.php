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
		<div class="col-lg-8">
			<div class="panel panel-default">
				<div class="panel-heading"><?php echo isset($title)?$title:'Unknow'; ?> manager</div>
				<div class="panel-body">
					<?php $data_session = $this->session->flashdata('data_flash_session');?>
					<?php echo isset($data_session)?$data_session['message']:''; ?>

                    <?php if(validation_errors()) echo validation_errors(); ?>

                    <?php 
						$attibuts= array('name' => 'edit-page');
						echo form_open('',$attibuts);
					?>
					<div class="form-group">
						<label>Title</label>
						<?php $data = array('name' => 'page_title', 'value' => $the_page['title'], 'class'=>'form-control','id' => 'page_title','placeholder'=> 'Page Title');
            				echo form_input($data); ?>
					</div>
					<div class="form-group">
						<label>Content</label>
						<?php $data = array('name' => 'page_content', 'value' => $the_page['content'], 'class'=>'form-control','id' => 'page_content');
            				echo form_textarea($data); ?>
					</div>
				</div><!--/.panel-body-->	
			</div>

			<div class="panel panel-default">
				<div class="panel-heading">Settings</div>
				<div class="panel-body">
					<div class="form-group">
						<label>Banner Image</label>
						<?php 
            				echo form_upload(); ?>
					</div>
					<div class="form-group">
						<label>Banner Title</label>
						<?php $data = array('name' => 'page_banner_title', 'value' => '', 'class'=>'form-control','id' => 'page_banner_title','placeholder'=> 'Banner Title');
            				echo form_input($data); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="panel panel-default">
				<div class="panel-heading">Page Attributes</div>
				<div class="panel-body">
					<div class="form-group">
						<label>Parent</label>
						<?php 	$options = array('0'=>'Select Parent');

							if(isset($pages) && count($pages) >0){
								foreach($pages as $page){
									$options[$page['id']]=$page['depth'].$page['title'];
								}
							}
							$batch = $the_page['parent_id'];
							echo form_dropdown('page_parent', $options, $batch, 'class="form-control" id="page_parent"');?>
					</div>
					<div class="form-group">
						<label>Template</label>
						<?php 	$options = array(
				                  'default'  => 'Default',
				                  '3column'	=> '3 columns',
				                  'blog'    => 'Blog',
	                			);

								$batch = $the_page['template'];
				
							echo form_dropdown('page_template', $options, $batch, 'class="form-control" id="page_template"');?>
					</div>
					<div class="text-right">
						<?php 	$data = array('name' => 'Submit','id' => 'Submit','value' =>'Publish','class' => 'btn btn-primary');
	            			echo form_submit($data); ?>
					</div>
					<?php  echo form_close();?>	
				</div><!--/.panel-body-->

				
			</div>
		</div>
	</div><!--/.row-->	
	
	
	
</div><!--/.main-->
