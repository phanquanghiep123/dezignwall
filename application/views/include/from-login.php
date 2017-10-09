<link href="https://fonts.googleapis.com/css?family=Pacifico|Yellowtail" rel="stylesheet">
<div id="form-user" class="login-form box-bg-white box-ball">
    <div id="close-form">x</div>
	<h2 class="title">Welcome back!</h2>
<?php
	$email = array(
		'name' => 'email',
		'type'=>'email',
		'data-valid'=>'true',
		'class' => 'email form-control',
		'id' => 'email',
		'title' => "Email",
		'placeholder' => 'Enter your email',
		'value' => isset($_GET['email']) ? $_GET['email'] : @$_COOKIE['email'],
		'tabindex'=>'1'
	);
	$pass = array(
		'type'=>'password',
		'data-valid'=>'true',
		'name'=> 'password',
		'class'=>'password form-control',
		'id'=>'password',
		'title' => "Password",
		'placeholder'=>'Enter your password',
		'value' => isset($_GET['pwd']) ? $_GET['pwd'] : @$_COOKIE['pwd'],
		'tabindex'=>'2'
	);
	$sign_in = array(
		'type'=>"submit",
		'name'=> 'sign-in',
		'class'=>'sign-in btn btn-primary button-signin right',
		'id'=>'sign-in',
		'value' => "Sign in",
		"onclick"	=>"return false;",
		'tabindex'=>'4'
	);
	$attributes = array('class' => 'form-horizontal form-signin', 'id' => 'form-user-input');
	echo form_open(base_url(),$attributes); ?>
	<div class="col-md-12">
	    
		<div class="row">
		    <div class="error"></div>
			<div class="form-group">
				<label for="email" class="col-sm-4 control-label">Email</label>
				<div class="col-md-8"><?php echo form_input($email);?></div>
			</div>
			<div class="form-group">
				<label for="password" class="col-sm-4 control-label">Password</label>
				<div class="col-md-8">
					<div class="row">
						<div class="col-md-12"><?php echo form_input($pass);?></div>
						<div class="col-md-12 text-right"><p class="forgot-text"><a href="<?php echo base_url("accounts/forgot");?>" class="avenir-regular">Forgot your password?</a></p></div>
					</div>
				</div>
			</div>
			<div class="form-group relative action-signin">
				<input type="hidden" id="project_id" value="<?php echo @$_GET['project_id']; ?>" name="project_id" />
				<input type="hidden" id="token" value="<?php echo @$_GET['token']; ?>" name="token" />
				<div class="col-xs-4 col-sm-4 text-center action-signin"><a href="#" id="join-now" class="left text-center btn btn-default join-now button-signin">Join Now</a></div>
				<div class="col-xs-4 col-sm-4 text-center action-signin"><a href="#" id="clear" for-parent="#form-user" class="btn btn-gray clear button-signin">Clear</a></div>
				<div class="col-sx-4 col-sm-4 text-center"><?php echo form_input($sign_in);?></div>
			</div>
			<div class="box-login-linkedin form-group">
				<div class="line-or">
					<div class="col-lg-5 box-line-left"><p class="line line-left"></p></div>
					<div class="col-lg-2 box-line-middel"><p class="line-middel text-center">or</p></div>
					<div class="col-lg-5 box-line-right"><p class="line line-right"></p></div>
				</div>
				<div class="col-lg-12">
					<div class="width-linkedin row">
						<div class="col-lg-5">
							<p class="business-pros">business pros</p>
						</div>
						<div class="col-lg-7 right">
							<script type="in/Login"></script>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php echo form_close();?>

</div>
<style type="text/css">
	.box-login-linkedin .business-pros{
	    color: #37a7a7;
	    font-style: italic;
	    font-family: 'Pacifico', cursive;
		font-family: 'Yellowtail', cursive;
	    text-transform: capitalize;
	    font-size: 30px;
	    margin-top: 5px;
	}
</style>
<script type="text/javascript" src="//platform.linkedin.com/in.js">
  api_key: 8198z19grqigeu
  authorize: false
  onLoad: onLinkedInLoad
</script>

<script type="text/javascript">
    // Setup an event listener to make an API call once auth is complete
    function onLinkedInLoad() {
    	$('a[id*=li_ui_li_gen_]').css({"margin-bottom":'20px'}).html('<img src="<?php echo skin_url("images/linked-login.png")?>" border="0" />');
        IN.Event.on(IN, "auth", getProfileData);
    }
    // Handle the successful return from the API call
    function onSuccess(data) {
        console.log(data);
    }

    // Handle an error response from the API call
    function onError(error) {
        console.log(error);
    }

    // Use the API call wrapper to request the member's basic profile data
    function getProfileData() {
    	var fields = ['first-name', 'last-name', 'email-address','positions'];
        IN.API.Profile("me").fields(fields).result(function(data) {
        	console.log(data);
        	var value = data["values"][0];
        	var emailAddress = value["emailAddress"];
        	var firstName    = value["firstName"];
        	var lastName     = value["lastName"];
        	var positions    = value["positions"]
        	var valueP       = positions["values"][0];
        	var company      = valueP["company"]["name"];
        	var title_job    = valueP["title"]
        	$.ajax({
        		url: base_url + 'accounts/loginsocial',
        		dataType:"json",
        		type:"post",
        		data:{
	        		'firstname' : firstName,
	        		'lastname'  : lastName,
	        		'email'     : emailAddress,
	        		'company'   : company,
	        		'title_job' : title_job
	        	},
        		success:function(res){
        			if (res["success"] == "success") {
                        window.location.href = url_reload;
                    } else {
                        var messenger = "";
                        var i = 0;
                        $.each(res["messenger"], function (key, value) {
                            i++;
                            $(".login-form #" + key + "").addClass("warning");
                            messenger += "<p>" + value + "</p>";
                        });
                        $("#form-user.login-form .error").html(messenger);
                    }
        		}
        	});
	    }).error(function(data) {
	        console.log(data);
	    });
    }

</script>