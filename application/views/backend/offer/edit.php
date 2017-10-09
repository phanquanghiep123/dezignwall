<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">		
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
			<li class="active"></li>
		</ol>
	</div><!--/.row-->
	
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Offer</h1>
		</div>
	</div><!--/.row-->
			
	
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">Edit Offer</div>
				<div class="panel-body">
					<?php if($this->session->flashdata('message')): ?>
						<div class="alert bg-success" role="alert"><span class="glyphicon glyphicon-exclamation-sign"></span> <?php echo($this->session->flashdata('message'));?><a href="#" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a></div>
                    <?php endif;?>

					<?php 
						$attibuts= array('name' => 'editOffer');
						echo form_open('',$attibuts);
					?>
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<label>Title</label>
								<?php $data = array('name' => 'title_offer','required'=>'required','value' => @$post["title_offer"],'class'=>'form-control','id' => 'title','placeholder'=> 'Title');
		            			echo form_input($data); ?>
							</div>
							<div class="form-group">
								<label>Code</label>
								<?php $data = array("type"=>"text",'name' => 'code','required'=>'required','value' => @$post["code"],'class'=>'form-control','id' => 'code','placeholder'=> 'Code');
		            			echo form_input($data); ?>
							</div>
							<div class="form-group">
								<label>Number uses</label>
								<?php $data = array("type"=>"number",'name' => 'number_uses','required'=>'required','value' => @$post["number_uses"],'class'=>'form-control','id' => 'number_uses','placeholder'=> 'Number uses');
		            			echo form_input($data); ?>
							</div>
							<div class="form-group">
								<label>Start date</label>
								<?php $data = array('name' => 'start_date','required'=>'required','value' =>  @$post["start_date"],'class'=>'form-control datepicker','id' => 'start_date','placeholder'=> 'Start date');
		            			echo form_input($data); ?>
							</div>
							<div class="form-group">
								<label>End date</label>
								<?php $data = array('name' => 'end_date','required'=>'required','value' => @$post["end_date"],'class'=>'form-control datepicker','id' => 'end_date','placeholder'=> 'End date');
		            			echo form_input($data); ?>
							</div>
							<div class="form-group row">
								<div class="col-md-4">
									<label>Type Offer</label>
									<select name="type" class="form-control ">
										<?php 
											if(isset($packages)):
												$type = ""; 
												foreach ($packages as $key => $value){ 

													if($post["type"] == $value["id"]){
														$type="selected";
													}
													echo "<option value = '".$value["id"]."' ".$type.">Month plan ".$value["max_files"]."</option>";
													$type = ""; 
												}
											endif;
										?>
									</select>
								</div>
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
