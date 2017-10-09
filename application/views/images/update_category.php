<?php
$this->load->view('block/header');
$this->load->view('block/footer');

?>
<script type="text/javascript">
    var page = 0;
	function update_category() {
		$.ajax({
			"url":base_url + "photos/update_category",
			"type":"post",
			"dataType":"json",
			"data":{"page" : page},
			success:function(data){
				if(data["success"] == "success"){
					page = page + 1;
					update_category();
				}else{
					update_category();
				}
				console.log(data);
			},error:function(){
				update_category();
			}
		})
	}
	$(document).ready(function(){
		update_category();
	});
</script>