<div class="box-user login">
<?php
    $user = array();
	if ($this->session->userdata('user_info')) {
		$user = $this->session->userdata('user_info');
	}
?>
	<div class="avatar-user">
		<img src="<?php echo isset($user["avatar"])&& $user["avatar"]!="" ? base_url($user["avatar"]) : skin_url("images/avatar-full.png"); ?>">
		<p class="destop">Your Profile</p>
	</div>

	<ul class="nav-user box-ball personal_member">
	<?php if(@$user["is_blog"] == "yes") { 
		echo '<li class="highlight"><a href="'.base_url("profile/edit/").'">Edit profile </a></li>
		<li class="highlight"><a href="'.base_url("designwalls/").'">Your walls</a></li>
	    <li class="highlight"><a class="article-add-link" href="'.base_url("article/add").'">Create new article</a></li>
	    <li class="highlight"><a href="'.base_url("article").'">Your articles</a></li>
		<li class="highlight"><a href="'.base_url("profile/conversations").'">Your conversations</a></li>
		<li class="highlight"><a href="'.base_url("profile/logout/").'">Logout</a></li>';
	} else {
		if(@$user["active_company"] == 1){
			echo '<li class="highlight"><a class="upgrade-account-link" href="'.base_url("company/edit").'">Edit company profile </a></li>
				<li class="highlight"><a href="'.base_url("company/view").'">View company public profile </a></li>
				<li class="highlight"><a class="article-add-link" href="'.base_url("profile/addphotos/").'">Upload new image</a></li>
				<li class="highlight"><a href="'.base_url("profile/myphoto/").'">View uploaded images</a></li>
				<li class="highlight"><a href="'.base_url("designwalls/").'">Your walls</a></li>
				<li class="highlight"><a href="'.base_url("profile/edit/").'">Edit personal profile </a></li>
				<li class="highlight"><a href="'.base_url("profile/view/").'">View personal public profile </a></li>
				<li class="highlight"><a class="upgrade-account-link" href="'.base_url("profile/edit?share").'">Send digital card </a></li>
				<li class="highlight"><a href="'.base_url("profile/conversations").'">View conversations</a></li>
				<li class="highlight"><a class="upgrade-account-link" href="'.base_url("company/reports").'">Your company reports</a></li>
			    <li class="highlight"><a href="'.base_url("profile/reports").'">Your personal reports</a></li>
				<li class="highlight"><a href="'.base_url("profile/logout/").'">Logout</a></li>';
		}else{
			echo '<li class="highlight"><a href="'.base_url("profile/edit/").'">Edit profile </a></li>
			<li class="highlight"><a class="article-add-link" href="'.base_url("designwalls/").'">Your walls</a></li>
			<li class="highlight"><a href="'.base_url("profile/view/").'">View public profile </a></li>
			<li class="highlight"><a class="upgrade-account-link" href="'.base_url("profile/edit?share").'">Send digital card </a></li>
			<li class="highlight"><a href="'.base_url("profile/conversations").'">View conversations</a></li>
			<li class="highlight"><a href="'.base_url("profile/logout/").'">Logout</a></li>';
		}
	}?>
	</ul>
</div>
