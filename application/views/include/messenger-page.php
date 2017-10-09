<div class="section section-1 box-wapper-show-image">
	<div class="container">
	    <div class="top">
	    	<?php if(isset($message)):?>
	    		<h1><?php echo $message['title']; ?></h1>
	    		<div class="alert <?php echo $message['type']?>" role="alert"><?php echo $message['content']?></div>
	    	<?php endif ?>
	    </div>
	</div>
</div>