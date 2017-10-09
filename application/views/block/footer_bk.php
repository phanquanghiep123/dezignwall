</div>		
<div id="footer" class="structural-block">
	    	<div class="top">
	    		<div class="container box-public">
	    			<div class="row">
	    				<div class="col-sm-3 text-sm-center">
	    					<p  class="copyright"><span>©dezign</span>wall, Inc. <?php echo date("Y"); ?></p>
	    				</div>
	    				<div class="col-sm-5 text-sm-center">
	    					<ul class="list-inline">
	    						<li><a name="about-us" href="<?php echo base_url('page/about-us')?>">About us</a></li>
	    						<li><a name="contact" href="<?php echo base_url('page/contact')?>">Contact</a></li>
	    						<li><a name="upgrade" href="<?php echo base_url('profile/upgrade')?>">Upgrade</a></li>
	    					</ul>
	    				</div>
	    				<div class="col-sm-4">
	    					<div class="row">
	    						<div class="col-xs-6 col-md-6 text-center"><a href="<?php echo base_url('page/terms-of-use')?>" name ="terms-of-use">Terms of use</a></div>
	    						<div class="col-xs-6 col-md-6 text-center"><a href="<?php echo base_url('page/privacy-policy')?>" name="privacy-policy">Privacy policy</a></div>
	    					</div>
	    				</div>
	    			</div>
	    		</div>
	    	</div>
	    </div>
	    <?php $this->load->view("include/messenger-box");?>
	    <?php $this->load->view("include/reporting-image");?>
	    <?php $this->load->view("include/sentmail-image");?>
	    <?php $this->load->view("include/delete_popup");?>
	    <?php $this->load->view("include/poup_comment");?>
	    <?php $this->load->view("include/pin-to-wall"); ?>
	    <?php $this->load->view("include/modal_view_album"); ?>
	    
	    <!-- Google Tag -->

<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-WBL6PKK');</script>

<!-- End Google Tag -->

    </body>
    <script src="<?php echo skin_url();?>/js/grid-img.js"></script>
    <script src="<?php echo skin_url();?>/js/jquery.matchHeight.js"></script>
    <script src="<?php echo skin_url();?>/js/bootstrap-select.min.js"></script>
    <script src="<?php echo skin_url();?>/js/main-footer.js"></script>
    <script src="<?php echo skin_url();?>/js/comment.js"></script>
</html>
<?php
	if(isset($_GET['action']) && ($_GET['action']=='signin' || $_GET['action']=='signup' )  ): 
		if ($this->session->userdata('user_info')) :
          $user_info= $this->session->userdata('user_info'); 
      	  if(isset($_GET['email']) && $user_info['email'] !=$_GET['email']) :
?>
	<div class="modal fade popup" id="invite-box" tabindex="-1" role="dialog">
	  <div class="modal-dialog modal-sm">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <p id="title-messenger">Do you want to logout?</p>
	      </div>
	      <div class="modal-body">
	        <p id="warning-messenger"></p>
	      </div>
	      <div class="modal-footer">
	      	<?php
	      		$request='';
	      		if ($_SERVER['QUERY_STRING']) {
		            $request = "?" . @$_SERVER['QUERY_STRING'];
		        }
	      	?>
	        <a class="btn btn-default" href="<?php echo base_url(); ?>profile/logout<?php echo $request; ?>">OK</a>
	        <a class="btn btn-default" data-dismiss="modal">Cancel</a>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	<script type="text/javascript">
		$(document).ready(function () {
			$('#invite-box').modal('show');
		});
	</script>
<?php
     endif;
	endif;
 endif; 
?>

<script type="text/javascript">
	$(document).ready(function () {
		$("img").on("contextmenu",function(){
	       return false;
	    }); 
		<?php if(isset($_GET["reload"]) && isset($_GET["action"])){?>
			url_reload = base_url + "<?php echo $_GET["reload"];?>";
		<?php } ?>
			
		var confirm_sales = "<?php echo isset($_GET["confirm_sales"]) ? $_GET["confirm_sales"] : ""; ?>";
		var action = "<?php echo isset($_GET["action"]) ? $_GET["action"] : ""; ?>";
		if (is_login == 1) // Silence is golden.
			return;
		if (action == "signin") {
			$("#form-user.login-form").slideToggle("slow");
			$(".form-signin #email").val('<?php echo isset($_GET["email"]) ? $_GET["email"] : ""; ?>');
			$(".form-signin #project_id").val('<?php echo isset($_GET["project_id"]) ? $_GET["project_id"] : ""; ?>');
			$(".form-signin #token").val('<?php echo isset($_GET["token"]) ? $_GET["token"] : ""; ?>');
		} else if (action == "signup") {
			$("#form-user.singup-form").slideToggle("slow");
			$(".form-signup #first-name").val('<?php echo isset($_GET["first_name"]) ? $_GET["first_name"] : ""; ?>');
			$(".form-signup #last-name").val('<?php echo isset($_GET["last_name"]) ? $_GET["last_name"] : ""; ?>');
			$(".form-signup #email").val('<?php echo isset($_GET["email"]) ? $_GET["email"] : ""; ?>');
			$(".form-signup #project_id").val('<?php echo isset($_GET["project_id"]) ? $_GET["project_id"] : ""; ?>');
			$(".form-signup #token").val('<?php echo isset($_GET["token"]) ? $_GET["token"] : ""; ?>');
		}
		if(confirm_sales == "success"){
			messenger_box("Messenger","Confirm email successfully, please check your email");
		}
		
	});
	<?php if ($this->input->get("error") && $this->input->get("url")):?>
	var url_error = "<?php echo $this->input->get('url');?>";
	messenger_box("Oh, <span class='moderate-cyan-color'>@</span><span class='orange-color'>#</span><span class='strong-red-color'>%</span><span class='moderate-green-color'>&</span><span class='very-dark-gray-color'>!</span>", "Oops..."+url_error+"... Don't worry, we're on it!");
	<?php endif;?>
</script>