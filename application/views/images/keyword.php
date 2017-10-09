<?php
$this->load->view('block/header');
$this->load->view('block/footer');

?>
<script type="text/javascript">
    var page = 0;
	function update_keyword() {
		$.ajax({
			"url":base_url + "photos/update_keyword",
			"type":"post",
			"dataType":"json",
			"data":{"page" : page},
			success:function(data){
				if(data["success"] == "success"){
					page = page + 1;
					update_keyword();
				}else{
					update_keyword();
				}
				console.log(data);
			},error:function(){
				update_keyword();
			}
		})
	}
	$(document).ready(function(){
		update_keyword();
	});
</script>