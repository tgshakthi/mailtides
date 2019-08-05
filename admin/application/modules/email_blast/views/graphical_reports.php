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
										<label for="campaign-type" class="control-label col-md-3 col-sm-3 col-xs-12">
											Campaign Type
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<select name="campaign-type" id="campaign-type" class="form-control">
												<?php foreach (($campaign_type ? $campaign_type : array()) as $camp_type) :?>
												<option value="<?php echo $camp_type->id;?>"><?php echo $camp_type->campaign_type;?></option>
												<?php endforeach;?>
											</select>
										</div>
									</div>




                    </div>
                  </div>
                </div>     

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">                  
                  <div class="x_content">

                    <textarea id="mail-opened" style="display: none"><?php echo $opened;?></textarea>
                    <textarea id="mail-unopened" style="display: none"><?php echo $not_opened;?></textarea>

                    <textarea id="mail-comments-posted" style="display: none"><?php echo $posted;?></textarea>
                    <textarea id="mail-comments-not-posted" style="display: none"><?php echo $not_posted;?></textarea>

                    <textarea id="mail-txgidocs" style="display: none"><?php echo $txgidocs;?></textarea>
                    <textarea id="mail-google" style="display: none"><?php echo $google;?></textarea>
                    <textarea id="mail-facebook" style="display: none"><?php echo $facebook;?></textarea>
                    <textarea id="mail-sent" style="display: none"><?php echo $sent;?></textarea>

                    <canvas id="mybarChart"></canvas>                    
                  </div>
                </div>
              </div>
              
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
        <!-- page content -->