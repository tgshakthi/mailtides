   
   <!-- Admin user view page content -->

   <div class="right_col" role="main">
   <div class="">
      <div class="page-title">
         <div class="title_left">
            <h3><?php echo heading($heading, '3');?></h3>
         </div>
         <div class="title_right">
            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
               <div class="input-group">
                  <input type="text" class="form-control" id ="search_details" placeholder="Search for..." onKeyUp="search_user_details();" onKeyDown="search_user_details();">
                  <span class="input-group-btn">
                  <button class="btn btn-default" type="button">Go!</button>
                  </span>
               </div>
            </div>
         </div>
      </div>
      <div class="clearfix"></div>
      <div class="row">
         <div class="col-md-12">
            <div class="x_panel">
               <div class="x_content">
                  <div class="row">
                     <ul class="stats-overview">
                        <center>
                           <li>
                              <span class="name"></span>
                              <span class="value text-success"> Total User (<?php echo $cms_count;?>)</span>
                           </li>
                        </center>
                     </ul>
                     <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                        <ul class="pagination pagination-split">
                           <?php
                              for($i = 65 ; $i<=90; $i++)
                              {
                              ?>			
                           <li><a href= "javascript:;"  onclick="alpha_val_click('<?php echo chr($i); ?>')" ><?php echo chr($i); ?></a></li>
                           <input type="hidden" id="click_alpha_val" name="click_alpha_val" value="<?php echo chr($i); ?>">
                           <?php
                              } 
                              ?>	
                        </ul>
                     </div>
                     <div id="search_data">
                        <?php
                           foreach($admin_user_details_website as $admin_user_single_values)
                           {
                           	$data_ex = ($admin_user_single_values->website_name != '') ? explode(",",$admin_user_single_values->website_name): array();
                           	$data_web_url = ($admin_user_single_values->website_url != '') ? explode(",",$admin_user_single_values->website_url): array();
                           ?>
                        <div class="col-md-4 col-sm-4 col-xs-12 profile_details">
                           <div  class="well profile_view">
                              <div class="col-sm-12">
                                 <h4 class="brief"><i><?php echo $admin_user_single_values->user_role_name; ?> </i></h4>
                                 <div class="left col-xs-7">
                                    <h2><?php echo $admin_user_single_values->first_name ;?> <?php echo $admin_user_single_values->last_name ;?></h2>
                                    <ul class="list-unstyled">
                                       <li><i class="fa fa-building"></i> Email : <?php echo $admin_user_single_values->email; ?></li>
                                       <i class="fa fa-globe"></i> Website : 
                                       <?php
                                          if(!empty($data_ex)){
                                          $i=0;		
                                          foreach($data_ex as $data_ex_details)
                                          { ?>
                                       <li><a href="<?php echo $data_web_url[$i]; ?>">
                                          <?php echo $data_ex_details; ?>
                                          </a>
                                       </li>
                                       <?php $i++; } } ?>
                                    </ul>
                                 </div>
                                 <div class="right col-xs-5 text-center">
                                    <?php if(!empty($admin_user_single_values->user_image)){ ?>
                                    <img src="<?php echo $admin_user_single_values->user_image; ?>" alt="" class="img-circle img-responsive"/>
                                    <?php }else{ ?>
                                    <img src="<?php echo $ImageUrl;?>images/userimg.png" alt="" class="img-circle img-responsive"/>
                                    <?php } ?>  
                                 </div>
                              </div>
                              <div class="col-xs-12 bottom text-center">
                                 <div class="col-xs-12 col-sm-6 emphasis">
                                    <button type="button" class="btn btn-success btn-xs"><i class="fa fa-user"></i><i class="fa fa-comments-o">Online</i> </button>
                                    <button type="button" class="btn btn-primary btn-xs"><i class="fa fa-user"> </i> <a style="color:white;" href="<?php echo base_url();?>admin_user_profile/profile/<?php echo $admin_user_single_values->id;?>">View Profile</a></button>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <?php } ?>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
   
  <!-- /Admin user view page content -->
		
