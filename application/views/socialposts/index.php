<div class="container box-public box-lg box-bg-gray">
   <div class="row">
      <div class="gird-img">
         <div class="col-md-6 grid-column" style="margin: auto; float: none; margin-top: 50px;">
         	
            <?php 
                $record["avatar"]       = $member["avatar"];
                $record["first_name"]   = $member["first_name"];
                $record["last_name"]    = $member["last_name"];
                $record["job_title"]    = $member["job_title"];
                $record["qty_like"]     = $tracking["qty_like"];
                $record["qty_comment"]  = $tracking["qty_comment"];
                $record["is_like"]      = $is_like;
                $record["company_name"] = $company["company_name"];
            	$this->load->view("seach/social-post",array("social" => $record,"view" => 1)); 
            ?>
         </div>
      </div>
   </div>
</div>
<style type="text/css">
	body .social-card .top-social .avatar img{
		border-radius: 50%;
	    border: 1px solid #37a7a7;
	    margin: 0 auto;
	    width: 50px;
	    height: 50px !important;
	}
</style>