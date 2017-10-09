  <script>
	 $(document).ready(function(){

	 	
	 	if($('.role_option').val()=='default') $('.rules_wrapper').hide();

	    $('.role_option').change(function () {
            if($(this).val()=='default') $('.rules_wrapper').hide(); else $('.rules_wrapper').show();
            
        });

	  });
	</script>
  </body>

</html>

<style>
.pagination > a {
    display: inline-block;
    padding: 5px 10px;
    background: #009900; color: #FFF;
    margin: 0px 5px;
}

.pagination > strong, .pagination > a:hover {
    display: inline-block;
    padding: 5px 10px;
    background: #eee;color:#5f6468;
    margin: 0px 5px;
}




</style>