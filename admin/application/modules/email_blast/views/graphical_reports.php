<!-- page content -->
<div class="right_col" role="main">
          <div class="">           

            <div class="x_title">
              <h3><?php echo $heading;?></h3>

              <div class="btn_right" style="text-align:right;">
                <a href="<?php echo base_url()?>email_blast" class="btn btn-primary"><i class="fa fa-chevron-left"
                    aria-hidden="true"></i> Back</a>
              </div>
              <div class="clearfix"></div>
            </div>

            <div class="row">       
               <div class="col-md-12 col-sm-12 col-xs-12">
                 	<div class="x_panel">

							     	<div class="x_title">
								     	<?php
									    	echo heading('Details', '2');
									    	$list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
										    $attributes = array('class' => 'nav navbar-right panel_toolbox');
										    echo ul($list,$attributes);
									     ?>
									       <div class="clearfix"></div>
							     	</div>

								    <div class="x_content">
                    <div class="form-group">
                          <label for="campaign-id" class="control-label col-md-3 col-sm-3 col-xs-12">
                                  Select Campaign
												  </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="hidden" name="website_id" id="website_id" value="<?php echo $website_id;?>">
						              	<input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
                              <select name="campaign" class="form-control col-md-7 col-xs-12" id="campaign_id" required="required" onchange="campaign(this.value)"  >
                                  <option value="">Select Campaign</option>                                                   
													            <?php foreach($campaign_details as $campaign):
													          ?>
													        <option value="<?php echo $campaign->id ?>"><?php echo $campaign->campaign_name; ?></option>
													           <?php endforeach; ?>
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

                   

                    <canvas id="mybarChart"></canvas>                    
                  </div>
                </div>
              </div>
              
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
        <!-- page content -->