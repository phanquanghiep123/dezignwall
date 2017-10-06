<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">		
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
			<li class="active">Packages</li>
		</ol>
	</div><!--/.row-->
	
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Packages</h1>
		</div>
	</div><!--/.row-->
			
	
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading"><?php echo @$title; ?></div>
				<div class="panel-body">
					<?php if($this->session->flashdata('message')): ?>
						<div class="alert bg-success" role="alert"><span class="glyphicon glyphicon-exclamation-sign"></span> <?php echo($this->session->flashdata('message'));?><a href="#" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a></div>
                    <?php endif;?>

					<?php 
						$attibuts= array('name' => 'edit_packages');
						echo form_open('',$attibuts);
					?>
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<label>Title</label>
								<?php $data = array('name' => 'title_packages','required'=>'required','value' => @$result["name"],'class'=>'form-control','id' => 'title','placeholder'=> 'Title');
		            			echo form_input($data); ?>
							</div>

							<div class="form-group">
								<label>Summary</label>
								<?php $data = array('name' => 'summary','required'=>'required','value' =>  @$result["summary"],'class'=>'form-control','placeholder'=> 'Summary');
		            			echo form_textarea($data); ?>
							</div>
							<div class="form-group">
								<label>Price</label>
								<?php
									$option=array(
										'19.99'=>'$19.99',
										'50.97'=>'$50.97',
										'95.95'=>'$95.95',
										'179.91'=>'$179.91'
									);
								?>
								<?php $data = array('name' => 'price',"type"=>"number",'required'=>'required','value' => @$result["price"],'class'=>'form-control','placeholder'=> 'Price');
		            			//echo form_input($data); ?>
		            			<?php
		            				echo form_dropdown('price', $option,@$result["price"] ,'class="form-control" id="package_id"'); 
		            			?>
							</div>
							<div class="form-group">
								<label>Month</label>
								<?php $data = array("type"=>"number",'name' => 'max_file','required'=>'required','value' => @$result["max_files"],'class'=>'form-control','placeholder'=> 'Max Files');
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