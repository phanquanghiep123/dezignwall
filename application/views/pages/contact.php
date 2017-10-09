<div class="wrapper-contact">
	<div class="container">
		<div class="panel-contact">
			<h1 class="page-title">Contact us</h1>
			<form action="<?php echo base_url();?>pages/contact/" method="post" class="form-horizontal form-large">
			    <?php if($this->session->flashdata('success')): ?>
					<div class="alert alert-success">
					 <?php echo $this->session->flashdata('success'); ?>
					</div>
				<?php endif; ?>
				 <?php if($this->session->flashdata('error')): ?>
					<div class="alert alert-danger">
					 <?php echo $this->session->flashdata('error'); ?>
					</div>
				<?php endif; ?>
			    <div class="form-group">
			        <label for="" class="col-sm-3 control-label">Name*:</label>
			        <div class="col-sm-9">
			            <input type="text" class="form-control" name="name" required id="name" placeholder="Name">
			        </div>
			    </div>
			    <div class="form-group">
			        <label for="" class="col-sm-3 control-label">Company Name*:</label>
			        <div class="col-sm-9">
			            <input type="text" required class="form-control" name="company" id="company" placeholder="Company Name">
			        </div>
			    </div>
			    <div class="form-group">
			        <label for="inputPassword3" class="col-sm-3 control-label">Phone*:</label>
			        <div class="col-sm-9">
			            <input type="text" required name="phone" class="form-control"  placeholder="Phone">
			        </div>
			    </div>
			    <div class="form-group">
			        <label for="" class="col-sm-3 control-label">Country:</label>
			        <div class="col-sm-9">
			            <input type="text" name="country" class="form-control" id="country" placeholder="Country">
			        </div>
			    </div>
			    <div class="form-group">
			        <label for="" class="col-sm-3 control-label">Email*:</label>
			        <div class="col-sm-9">
			            <input type="email" name="email" class="form-control" id="country" placeholder="Email" required>
			        </div>
			    </div>
			    <div class="form-group">					        
			        <div class="col-sm-12">
			        	<label for="inputPassword3">Message*:</label>
			            <textarea name="message" required class="form-control" rows="3"></textarea>
			        </div>
			    </div>
			    
			    <div class="form-group">
			        <div class="col-sm-12  text-right">
			        	<button type="submit" class="btn btn-lg btn-equal btn-custom btn-white btn-clear">Clear</button>
			            <button type="submit" class="btn btn-lg btn-equal btn-custom btn-primary">Send</button>
			        </div>
			    </div>
			</form>

			<div class="row">
				<div class="col-sm-6">
					<h3>Corporate office</h3>
					<dl class="dl-horizontal">
					    <dt>Phone:</dt>
					    <dd>(949) 988-0604 pst</dd>
					    <dt>Email:</dt>
					    <dd>info@dezignwall.com</dd>
					    <dt>Address:</dt>
					    <dd>1621 Alton Pkwy #250 Irvine CA 92606</dd>
					</dl>
					<ul class="list-inline list-logo">
						<li><a href=""><img src="<?php echo skin_url('images/logo-contact-1.png'); ?>"></a></li>
						<li><a href=""><img src="<?php echo skin_url('images/logo-contact-2.png'); ?>"></a></li>
					</ul>
				</div>
				<div class="col-sm-6">
					<h3 class="color-brand-primary">Social media</h3>
					<ul class="list-social">
						<li><a href="https://www.facebook.com/Dezignwall" target="_blank"><i class="fa fa-facebook"></i></a></li>
						<li><a href="https://www.linkedin.com/company/dezignwall-com" target="_blank"><i class="fa fa-linkedin"></i></a></li>
						<li><a href="https://twitter.com/dezignwall" target="_blank"><i class="fa fa-twitter"></i></a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('.panel-contact .btn-clear').click(function(){
			$('.panel-contact input').val('');
			$('.panel-contact textarea').val('');
			return false;
		});
	});
</script>
