<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">		
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
			<li class="active">Photos</li>
		</ol>
	</div><!--/.row-->
	
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Photos</h1>
		</div>
	</div><!--/.row-->
			
	
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">Edit Photo</div>
				<div class="panel-body">
					<?php echo($this->session->flashdata('message'));?>

                    <?php if(validation_errors()) echo validation_errors(); ?>
					
					<?php 
						$attibuts= array('name' => 'editprofile');
						echo form_open('',$attibuts);
					?>
					<div class="row">
						<div class="col-lg-12 text-center banner-img"style="margin-bottom: 25px;">
							<img  src="<?php echo base_url($items_photo["path_file"]);?>" style="max-height:600px;">
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Name</label>
								<?php $data = array('name' => 'name','value' => $items_photo["name"],'class'=>'form-control','id' => 'name','placeholder'=> 'Name');
		            			echo form_input($data); ?>
							</div>
							<div class="form-group">
								<label>Type</label>
								<?php $data = array('name' => 'type','value' => $items_photo["type"],'class'=>'form-control','type'=>'number','id' => 'type','placeholder'=> 'Type');
		            			echo form_input($data); ?>
							</div>
							<div class="form-group">
								<label>Product name</label>
								<?php $data = array('name' => 'product_name','value' => $items_photo["product_name"],'class'=>'form-control','id' => 'product_name','placeholder'=> 'Product name');
		            			echo form_input($data); ?>
							</div>
							<div class="form-group">
								<label>Product no</label>
								<?php $data = array('name' => 'product_no','value' => $items_photo["product_no"],'class'=>'form-control','type'=>'number','id' => 'product_no','placeholder'=> 'Product no');
		            			echo form_input($data); ?>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Price</label>
								<?php $data = array('name' => 'price','value' => $items_photo["price"],'class'=>'form-control','type'=>'number','id' => 'price','placeholder'=> 'price');
		            			echo form_input($data); ?>
							</div>
							<div class="form-group">
								<label>Qty</label>
								<?php $data = array('name' => 'qty','value' => $items_photo["qty"],'class'=>'form-control','type'=>'number','id' => 'qty','placeholder'=> 'Qty');
		            			echo form_input($data); ?>
							</div>
							<div class="form-group">
								<label>Product note</label>
								<?php $data = array('name' => 'product_note','value' => $items_photo["product_note"],'class'=>'form-control','id' => 'product_note','placeholder'=> 'Product note');
		            			echo form_input($data); ?>
							</div>
							<div class="form-group">
								<label>Fob</label>
								<?php $data = array('name' => 'fob','value' => $items_photo["fob"],'class'=>'form-control','id' => 'fob','placeholder'=> 'Fob');
		            			echo form_input($data); ?>
							</div>
						</div>
					</div>
					<?php $data = array('name' => 'Submit','id' => 'Submit','value' =>'Update','class' => 'btn btn-primary');
            		echo form_submit($data); ?>
					<?php  echo form_close();?>

				</div>
			</div>
		</div>
	</div><!--/.row-->	
	
	
	
</div><!--/.main-->