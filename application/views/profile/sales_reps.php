<style type="text/css">
   .filter-profile{list-style: none;padding-left: 0;}
   .filter-profile li{display: inline-block;margin-right: 15px;}
</style>
<div id="wrapper" class="structural-block home-page">
   <div class="container box-public">
      <?php 
         $user_info = $this->session->userdata('user_info');
         $allow_edit = (isset($member) && isset($user_info) && $user_info['id'] == $member['id']) ? true : false;
         $data = null;
         $this->load->view("include/banner.php", $data);
      ?>
      <section class="section box-wapper-show-image">
         <div class="row">
            <div class="col-xs-12">
               <ul class="filter-profile">
                  <li>Sort by:</li>
                  <li>City A-Z</li>
                  <li>Country</li>
                  <li>Zip Code</li>
               </ul>
            </div>
         </div>
         <?php if(isset($sales_reps) && count($sales_reps)>0): $country=$this->config->item('country');?>
         <div class="row">
            <?php foreach ($sales_reps as $key => $value) : ?>
            <div class="col-sm-6">
               <div class="panel panel-default">
                  <form class="form-horizontal">
                     <div class="form-group">
                        <label class="col-sm-12 control-label"><h2><strong>Local Rep:</strong></h2> 
                     </div>
                     <div class="form-group">
                        <label class="col-sm-4 control-label">First name:</label>
                        <div class="col-sm-8">
                           <p class="form-control-static"><?php echo @$value['first_name']; ?></p>
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="col-sm-4 control-label">Last name:</label>
                        <div class="col-sm-8">
                           <p class="form-control-static"><?php echo @$value['last_name']; ?></p>
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="col-sm-4 control-label">Job title:</label>
                        <div class="col-sm-8">
                           <p class="form-control-static"><?php echo @$value['job_title']; ?></p>
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="col-sm-4 control-label">Toll free:</label>
                        <div class="col-sm-8">
                           <p class="form-control-static"><a href="tel:<?php echo @$value['number_800']; ?>"><?php echo @$value['number_800']; ?></a></p>
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="col-sm-4 control-label">Local phone:</label>
                        <div class="col-sm-8">
                           <p class="form-control-static"><a href="tel:<?php echo @$value['main_business_ph']; ?>"><?php echo @$value['main_business_ph']; ?></a></p>
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="col-sm-4 control-label">Email:</label>
                        <div class="col-sm-8">
                           <p class="form-control-static"><a href="mailto:<?php echo @$value['contact_email']; ?>"><?php echo @$value['contact_email']; ?></a></p>
                        </div>
                     </div>
                    
                     <div class="form-group">
                        <label class="col-sm-4 control-label">Address:</label>
                        <div class="col-sm-8">
                           <p class="form-control-static"><?php echo @$value['main_address']; ?></p>
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="col-sm-4 control-label">City:</label>
                        <div class="col-sm-8">
                           <p class="form-control-static"><?php echo @$value['city'];?></p>
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="col-sm-4 control-label">State:</label>
                        <div class="col-sm-8">
                           <p class="form-control-static"><?php echo @$value['state'];?></p>
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="col-sm-4 control-label">Zip code:</label>
                        <div class="col-sm-8">
                           <p class="form-control-static"><?php echo @$value['zip_code']; ?></p>
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="col-sm-4 control-label">Country:</label>
                        <div class="col-sm-8">
                           <p class="form-control-static">
                              <?php
                                 if(isset($value['country'])){
                                 	echo $country[$value['country']];
                                 }
                                 ?>
                           </p>
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="col-sm-4 control-label">Service area:</label>
                        <div class="col-sm-8">
                           <p class="form-control-static"><?php echo @$value['service_area']; ?></p>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
            <?php if(($key+1)%2==0): ?>
         </div>
         <!--end row-->
         <div class="row">
            <?php endif;?>
            <?php endforeach; ?>
         </div>
         <!--end row-->
         <?php endif;?>
      </section>
   </div>
</div>
<style type="text/css">
   .form-group{margin-bottom: 0;}
 
</style>