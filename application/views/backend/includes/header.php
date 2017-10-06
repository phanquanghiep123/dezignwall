<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>DEZIGNWALL</title>

<link href="<?php echo backend_url('css/bootstrap.min.css');?>" rel="stylesheet">
<link href="<?php echo backend_url('css/datepicker3.css');?>" rel="stylesheet">
<link href="<?php echo backend_url('css/bootstrap-table.css');?>" rel="stylesheet">
<link href="<?php echo backend_url('css/styles.css');?>" rel="stylesheet">

<!--[if lt IE 9]>
<script src="<?php echo backend_url('js/html5shiv.js');?>"></script>
<script src="<?php echo backend_url('js/respond.min.js');?>"></script>
<![endif]-->
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="<?php echo backend_url('js/bootstrap.min.js');?>"></script>
<!--<script src="<?php //echo backend_url('js/chart.min.js');?>"></script>
<script src="<?php //echo backend_url('js/chart-data.js');?>"></script>
<script src="<?php //echo backend_url('js/easypiechart.js');?>"></script>
<script src="<?php //echo backend_url('js/easypiechart-data.js');?>">--></script>
<script src="<?php echo backend_url('js/bootstrap-datepicker.js');?>"></script>
<script src="<?php echo backend_url('js/bootstrap-table.js');?>"></script>
<script src="<?php echo backend_url('js/ckeditor/ckeditor.js');?>"></script>
<script src="<?php echo backend_url('js/ckeditor/adapters/jquery.js');?>"></script>
  <script>
	 $(document).ready(function(){
		if ($('textarea#page_content').length) {
			$('textarea#page_content').ckeditor();
		}
		
	    $(document).on("click","ul.nav li.parent  a  span.icon", function(){      
	        $(this).find('em:first').toggleClass("glyphicon-minus");      
	    });
            
	    $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");

		$(window).on('resize', function () {
		  if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
		})
		$(window).on('resize', function () {
		  if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
		})

        $('#hover, #striped, #condensed').click(function () {
            var classes = 'table';

            if ($('#hover').prop('checked')) {
                classes += ' table-hover';
            }
            if ($('#condensed').prop('checked')) {
                classes += ' table-condensed';
            }
            $('#table-style').bootstrapTable('destroy')
                .bootstrapTable({
                    classes: classes,
                    striped: $('#striped').prop('checked')
                });
        });
	
	    function rowStyle(row, index) {
	        var classes = ['active', 'success', 'info', 'warning', 'danger'];
	
	        if (index % 2 === 0 && index / 2 < classes.length) {
	            return {
	                classes: classes[index / 2]
	            };
	        }
	        return {};
	    }

	     function display_rules(role) {
	     	//if(role=='default') $('.rules_wrapper').toggle();
	     	alert(role);
	     }

	  });
	</script>

</head>

<body>
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="http://designwall.mosaweb.com/"><img src="<?php echo skin_url("images/logo_dezignwall.png"); ?>" style="height:40px;padding-top:5px" /></a>
				<ul class="user-menu">
					<li class="dropdown pull-right">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo isset($name) ? $name : ""; ?> <span class="glyphicon glyphicon-user"></span>  <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="<?php echo base_url();?>admin/editProfile/<?php echo isset($user_id) ? $user_id : ''; ?>"><span class="glyphicon glyphicon-user"></span> Profile</a></li>
							<li><a href="<?php echo base_url();?>admin/logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div><!-- /.container-fluid -->
	</nav>
	<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">

		<ul class="nav menu">
			<li ><a href="<?php echo base_url();?>admin"><span class="glyphicon glyphicon-dashboard"></span> Dashboard</a></li>
			<?php if ($rules[0]['do'][0]==1){ ?>
				<li class="parent">
					<a href="<?php echo base_url();?>admin/profiles" class="link open <?php  if(@$current=="profile"){echo 'active';} ?>">
						<span class="glyphicon glyphicon-user"></span> Profiles <span data-toggle="collapse" href="#sub-item-1" class="icon pull-right"><em class="glyphicon glyphicon-s glyphicon-plus"></em></span>
					</a>
					<ul class="children collapse" id="sub-item-1">
						<li>
							<a class="" href="<?php echo base_url();?>admin/profiles">
								<span class="glyphicon glyphicon-list-alt"></span> All Profiles
							</a>
						</li>
						<li>
							<a class="" href="<?php echo base_url();?>admin/addProfile">
								<span class="glyphicon glyphicon-plus"></span> Add New
							</a>
						</li>
					</ul>
				</li>
			<?php } ?>
			<?php if ($rules[1]['do'][0]==1){ ?>
				<li class="parent">
					<a href="/admin/menu" class="link <?php  if(@$current=="menu"){echo 'active';} ?>">
						<span class="glyphicon glyphicon-align-justify"></span> Menu <span data-toggle="collapse" class="icon pull-right"><em class="glyphicon glyphicon-s glyphicon-plus"></em></span>
					</a>
				</li>
			
			<?php } ?>

			<?php if ($rules[2]['do'][0]==1){ ?>
			<li class="parent ">
				<a href="<?php echo base_url();?>admin/photos" class="link open <?php  if(@$current=="photo"){echo 'active';} ?>">
					<span class="glyphicon glyphicon-picture"></span> Photo <span data-toggle="collapse" href="#sub-item-3" class="icon pull-right"><em class="glyphicon glyphicon-s glyphicon-plus"></em></span>
				</a>
				<ul class="children collapse" id="sub-item-3">
					<li>
						<a class="" href="#">
							<span class="glyphicon glyphicon-list-alt"></span> All Photos
						</a>
					</li>
					<li>
						<a class="" href="#">
							<span class="glyphicon glyphicon-plus"></span> Add New
						</a>
					</li>
				</ul>
			</li>
			<?php } ?>
			<?php if ($rules[3]['do'][0]==1){ ?>
			<li class="parent ">
				<a href="<?php echo base_url(); ?>/admin/packages" class="link open <?php  if(@$current=="packages"){echo 'active';} ?>">
					<span class="glyphicon glyphicon-shopping-cart"></span> Package <span data-toggle="collapse" href="#sub-item-4" class="icon pull-right"><em class="glyphicon glyphicon-s glyphicon-plus"></em></span>
				</a>
				<ul class="children collapse" id="sub-item-4">
					<li>
						<a class="" href="<?php echo base_url(); ?>/admin/packages">
							<span class="glyphicon glyphicon-list-alt"></span> All Package
						</a>
					</li>
					<li>
						<a class="" href="<?php echo base_url(); ?>/admin/add_packages">
							<span class="glyphicon glyphicon-plus"></span> Add New
						</a>
					</li>
				</ul>
			</li>
			<?php } ?>
			<?php if ($rules[4]['do'][0]==1){ ?>
			<li class="parent ">
				<a href="<?php echo base_url(); ?>/admin/packages_dezig" class="link open <?php  if(@$current=="packages_dezig"){echo 'active';} ?>">
					<span class="glyphicon glyphicon-shopping-cart"></span> Package DEZIGNWALL <span data-toggle="collapse" href="#sub-item-5" class="icon pull-right"><em class="glyphicon glyphicon-s glyphicon-plus"></em></span>
				</a>
				<ul class="children collapse" id="sub-item-5">
					<li>
						<a class="" href="<?php echo base_url(); ?>/admin/packages_dezig">
							<span class="glyphicon glyphicon-list-alt"></span> All Package DEZIGNWALL
						</a>
					</li>
					<li>
						<a class="" href="<?php echo base_url(); ?>/admin/add_packages_dezig">
							<span class="glyphicon glyphicon-plus"></span> Add New
						</a>
					</li>
				</ul>
			</li>
			<?php } ?>
			<?php if ($rules[5]['do'][0]==1){ ?>
			
			<li class="parent">
				<a href="/admin/campaign" class="link <?php  if(@$current=="campaign"){echo 'active';} ?>">
					<span class="glyphicon glyphicon-flag"></span> Campaign <span data-toggle="collapse" class="icon pull-right"><em class="glyphicon glyphicon-s glyphicon-plus"></em></span>
				</a>
			</li>
			<?php } ?>
			<?php if ($rules[6]['do'][0]==1){ ?>
			<li class="parent">
				<a href="/admin/offer" class="link <?php  if(@$current=="offer"){echo 'active';} ?>">
					<span class="glyphicon glyphicon-flag"></span> Offer <span data-toggle="collapse" class="icon pull-right"><em class="glyphicon glyphicon-s glyphicon-plus"></em></span>
				</a>
			</li>
			<?php } ?>
			<?php if ($rules[7]['do'][0]==1){ ?>
			<li class="parent">
				<a href="/admin/categories" class="link <?php  if(@$current=="categories"){echo 'active';} ?>">
					<span class="glyphicon glyphicon-flag"></span> Categories <span data-toggle="collapse" class="icon pull-right"><em class="glyphicon glyphicon-s glyphicon-plus"></em></span>
				</a>
			</li>
			<?php } ?>
		</ul>
	</div><!--/.sidebar-->
			
		