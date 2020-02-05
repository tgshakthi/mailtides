<!-- page content -->
<div class="right_col" role="main">
          <div class="">           

            <div class="page-title">
              <div class="title_left">
                <h3><?php echo $heading;?></h3>
              </div>  

              <div class="btn_right" style="text-align:right;">
                <a href="<?php echo base_url()?>email_blasts" class="btn btn-primary"><i class="fa fa-chevron-left"
                    aria-hidden="true"></i> Back</a>
              </div>
              <div class="clearfix"></div>
            </div>

            <div class="row">       
               <div class="col-md-12 col-sm-12 col-xs-12">
                 	<div class="x_panel">

							     	<!-- <div class="x_title">
								     	<?php
									    	echo heading('Details', '2');
									    	$list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
										    $attributes = array('class' => 'nav navbar-right panel_toolbox');
										    echo ul($list,$attributes);
									     ?>
									       <div class="clearfix"></div>
							     	</div> -->

								    <div class="x_content">
                    <div class="form-group">
                        <label for="campaign-id" class="control-label col-md-3 col-sm-3 col-xs-12">Select Campaign Type</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input type="hidden" name="website_id" id="website_id" value="<?php echo $website_id;?>">
							<input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
							<select name="campaign" class="form-control col-md-7 col-xs-12" id="campaign_type_id" required="required" onchange="campaign_types(this.value);">							
							<option value="">Select Campaign Category</option>                                                   
								<?php foreach($get_campaign_category as $campaign_category):
							  ?>
							<option value="<?php echo $campaign_category->id ?>"><?php echo $campaign_category->category; ?></option>
							   <?php endforeach; ?>
							  <!-- <option value="">Select Type</option>
							   <option value="email">Email</option>
							   <option value="sms">SMS</option>-->
							</select>
						</div> 
					</div>




                    </div>
                  </div>
                </div>     

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">                  
                  <div class="x_content">				 
                  <div id="text_area">
                  </div>
                    <textarea id="mail-opened-type" style="display: none">
                         <?php //echo $opened;
                         ?>
                    </textarea>
                   <canvas id="mybarChart_type"></canvas>                    
                   </div>
                </div>
              </div>
              
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
        <!-- page content -->