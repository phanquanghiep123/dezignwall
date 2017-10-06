

<div class="box-user login relative ">
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

	<ul class="nav-user box-ball">
	<?php if(@$user["is_blog"] == "yes") { 
		echo '<li class="highlight"><a href="'.base_url("profile/edit/").'">Edit profile </a></li>
		<li class="highlight"><a href="'.base_url("designwalls/").'">Your walls</a></li>
	    <li class="highlight"><a class="article-add-link" href="'.base_url("article/add").'">Create new article</a></li>
	    <li class="highlight"><a href="'.base_url("article").'">Your articles</a></li>
		<li class="highlight"><a href="'.base_url("profile/conversations").'">Your conversations</a></li>
		<li class="highlight"><a class="upgrade-account-link" href="'.base_url("profile/upgrade").'">Upgrade account</a></li>
		<li class="highlight"><a href="'.base_url("profile/logout/").'">Logout</a></li>';
	} else {
		echo '<li class="highlight"><a href="'.base_url("profile/edit/").'">Edit profile </a></li>
		<li class="highlight"><a href="'.base_url("designwalls/").'">Your walls</a></li>
	    <li class="highlight"><a class="upgrade-account-link" href="'.base_url("designwalls/upgrade").'">Upgrade Your wall</a></li>
	    <li class="highlight"><a href="'.base_url("profile/addphotos/").'">Upload images</a></li>
	    <li class="highlight"><a href="'.base_url("profile/myphoto/").'">Your uploaded images</a></li>
		<li class="highlight"><a href="'.base_url("profile/conversations").'">Your conversations</a></li>
		<li class="highlight"><a class="upgrade-account-link" href="'.base_url("profile/upgrade").'">Upgrade account</a></li>
		<li class="highlight"><a href="'.base_url("profile/logout/").'">Logout</a></li>';
	}?>
	</ul>
</div>
