<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">		
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
			<li class="active"></li>
		</ol>
	</div><!--/.row-->
	
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Campaign</h1>
		</div>
	</div><!--/.row-->
			
	
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">Add Campaign</div>
				<div class="panel-body">
					
					<?php 
						$attibuts= array('name' => 'addcampaign');
						echo form_open('',$attibuts);
					?>
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<label>Title</label>
								<?php $data = array('name' => 'title','required'=>'required','value' => '','class'=>'form-control','id' => 'title','placeholder'=> 'Title');
		            			echo form_input($data); ?>
							</div>
							<div class="form-group">
								<label>Summary</label>
								<?php $data = array('name' => 'summary','required'=>'required','value' => '','class'=>'form-control','id' => 'summary','placeholder'=> 'Summary');
		            			echo form_input($data); ?>
							</div>
							<div class="form-group">
								<label>Start date</label>
								<?php $data = array('name' => 'start_date','required'=>'required','value' => '','class'=>'form-control datepicker','id' => 'start_date','placeholder'=> 'Start date');
		            			echo form_input($data); ?>
							</div>
							<div class="form-group">
								<label>End date</label>
								<?php $data = array('name' => 'end_date','required'=>'required','value' => '','class'=>'form-control datepicker','id' => 'end_date','placeholder'=> 'End date');
		            			echo form_input($data); ?>
							</div>
							<div class="form-group">
								<?php
									$option=array();
									foreach ($package as $key => $value) {
										$option[$value['id']]=$value['name'];
									}
									
								?>
								<label>Package id</label>
								<?php //$data = array('name' => 'package_id','value' => $record["package_id"],'class'=>'form-control','id' => 'package_id','placeholder'=> 'Package ID');
		            				  echo form_dropdown('package_id', $option, '','class="form-control" id="package_id"'); 
		            			?>
							</div>
							<div class="form-group">
								<label>Num days</label>
								<?php $data = array('name' => 'num_days','required'=>'required','value' => '','class'=>'form-control','id' => 'num_days','placeholder'=> 'Num days');
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
<script>
	$(function() {
		$(".datepicker").datepicker({
			 startDate: new Date(),
			 format: 'yyyy/mm/dd',
		});
	});
</script>
