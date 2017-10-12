<div class="box-user login">
<?php
	$user = $this->session->userdata('user_sr_info');
?>
	<div class="avatar-user">
		<img src="<?php echo isset($user["avatar"])&& $user["avatar"]!="" ? base_url($user["avatar"]) : skin_url("images/avatar-full.png"); ?>">
		<p class="destop">Your Profile</p>
	</div>
	<ul class="nav-user box-ball">
		<li class="highlight"><a href="<?php echo base_url("business/edit_rep_info")?>">Edit profile</a></li>
		<li class="highlight"><a href="<?php echo base_url("designwalls");?>">Your wall</a></li>
		<li class="highlight"><a href="<?php echo base_url("business/view_profile");?>">View public profile</a></li>
		<li class="highlight"><a class="upgrade-account-link" href="<?php echo base_url("/business/view_profile?share")?>">Share digital card</a></li>
		<li class="highlight"><a href="<?php echo base_url("profile/conversations")?>">View conversations</a></li>
		<li class="highlight"><a class="upgrade-account-link" href="<?php echo base_url("profile/reports")?>">Your reports</a></li>
		<li class="highlight"><a href="<?php echo base_url("profile/logout/"); ?>">Logout</a></li>
	</ul>
</div>
