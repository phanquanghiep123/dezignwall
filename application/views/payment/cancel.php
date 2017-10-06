<script src="/skins/js/jquery.min.js"></script>
<div class="content-main column content-profile">
    <div class="row" style="height:10px"></div>
    <div class="row">
        <div class="content-waper">
			<div class="row">
                <div class="large-12 medium-12 small-12 columns">
                    <center>
    					<strong>You have canceled your payment process.</strong>
    					<br /><br />
    					You are being redirected to the homepage after <span id="time">5</span> second(s)
    				</center>
                </div>
            </div>
    	</div>
	</div>
</div>

<script type="text/javascript">
	setInterval(function(){ 
		var t = $("#time").html();
		t = parseInt(t);
		if (t > 0) {
			t--;
			$("#time").html(t)
		} else {
			document.location.href = "/";
		}
	}, 1000);
</script>