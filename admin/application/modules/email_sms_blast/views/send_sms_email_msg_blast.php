<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="">
			<div class="page-title">
				<div class="title_left">
					<h3><?php echo $heading;?></h3>
				</div>
				<div class="btn_right" style="text-align:right;"> <a href="<?php echo base_url()?>email_sms_blast" class="btn btn-primary"><i class="fa fa-chevron-left"
							aria-hidden="true"></i> Back</a> </div>
				<div class="clearfix"></div>
			</div>
          <div class="x_content">
            <?php if ($this->session->flashdata('success')!='') : // Display session data ?>
              <div class="alert alert-success alert-dismissible fade in text-center" id="success-alert" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <strong>Success!</strong> <?php echo $this->session->flashdata('success');?>
              </div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('error') != '') : // Display session data ?>
              <div class="alert alert-warning alert-dismissible fade in text-center" id="warning-alert" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <strong><?php echo $this->session->flashdata('error');?></strong>
              </div>
            <?php endif; ?>
            <?php
              // Break tag
              echo br();
              // Form Tag
              echo form_open_multipart(
                'email_sms_blast/insert_sms_email_blast_msg_patients',
                'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
              );

              // Input tag hidden
              echo form_input(array(
                'type'  => 'hidden',
                'name'  => 'base_url',
                'id'    => 'base_url',
                'value' => base_url()
              ));
			  // Input tag hidden
              echo form_input(array(
                'type'  => 'hidden',
                'name'  => 'website_id',
                'id'    => 'website_id',
                'value' => $website_id
              ));
            ?>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                    <?php
                        echo heading(
                            'Email blasts',
                            '2'
                        );
                    ?>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                
				  <div class="x_content">                	
                    <div class="form-group">
                      <?php
                      echo form_label('First Name','first_name','class="control-label col-md-3 col-sm-3 col-xs-12"');
                      ?>

                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php
                          // Input tag
                          echo form_input(array(
                            'id'       => 'first_name',
                            'name'     => 'first_name',
                            'class'    => 'form-control col-md-7 col-xs-12',
                            'value'    => '',
                            'required' => 'required'
                          ));
						  
                        ?>
                      </div>
                    </div>
                  </div>
                  <div class="x_content">                	
                    <div class="form-group">
                      <?php
                      echo form_label('Last Name','last_name','class="control-label col-md-3 col-sm-3 col-xs-12"');
                      ?>

                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php
                          // Input tag
                          echo form_input(array(
                            'id'       => 'last_name',
                            'name'     => 'last_name',
                            'class'    => 'form-control col-md-7 col-xs-12',
                            'value'    => '',
                            'required' => 'required'
                          ));
						  
                        ?>
                      </div>
                    </div>
                  </div>
				  <div class="x_content">                	
                    <div class="form-group">
                      <?php
                      echo form_label('Patient Email','patient_email','class="control-label col-md-3 col-sm-3 col-xs-12"');
                      ?>

                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php
                          // Input tag
                          echo form_input(array(
                            'id'       => 'patient_email',
                            'name'     => 'patient_email',
                            'class'    => 'form-control col-md-7 col-xs-12',
                            'value'    => ''
                            // 'required' => 'required'
                          ));
						  
                        ?>
                      </div>
                    </div>
					<div class="x_content">                	
                    <div class="form-group">
                      <?php
                      echo form_label('Phone Number','phone_number','class="control-label col-md-3 col-sm-3 col-xs-12"');
                      ?>

                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php
                          // Input tag
                          echo form_input(array(
						              	'type'      => 'text',
                            'id'        => 'phone_number',
                            'name'      => 'phone_number',
							              'maxlength' => '12',
							   
                            'class'     => 'form-control col-md-7 col-xs-12',
                            'value'     => '',
                            'required'  => 'required'
                          ));
                        ?>
                      </div>
                    </div>
                  </div>
				  <div class="form-group">
							<label for="campaign-type" class="control-label col-md-3 col-sm-3 col-xs-12">
								Campaign
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							<select name="campaign" class="form-control col-md-7 col-xs-12" id="campaign" required="required" >
								<option value="">Select campaign</option>
								<?php
								if(!empty($get_campaign_categorys)){
									foreach($get_campaign_categorys as $get_campaign_category){
									?>
										<option value="<?php echo $get_campaign_categorys->id;?>"><?php echo $get_campaign_categorys->category;?></option>
									<?php									
									}
								}
								?>
							</select>
							</div>	
						</div>
				  <div class="form-group">
							<label for="campaign-type" class="control-label col-md-3 col-sm-3 col-xs-12">
								Location
							</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							<?php
								$facility_options = array(
														'' => 'Please Select',
														'houston'	=> 'Houston',
														'humble' => 'Humble',
														'woodlands' => 'Woodlands'
													);
							
									
								$facility_attributes = array(
															'id'       => 'location',
															'name'     => 'location',	
															// 'required' => 'required',
															'class'    => 'form-control'									
															);
							
								// Dropdown
								echo form_dropdown(
												  $facility_attributes,
												  $facility_options,
												  ''
												);
								?>
								
							</div>	
						</div>
			    </div>
						
					
		</div>	                              
    </div>
 </div>		
	    </div>
     </div>
              <!-- Button Group -->
                <div class="col-md-12 col-sm-12 col-xs-12 ">
                <div class="input_butt center">
                  <?php
                    echo form_submit(
									  array(
										'class' => 'btn btn-success',
										'id'    => 'btn',
										'name'  => 'btn_continue',
										'value' => 'Send Sms'
									  )
									);
					 //Anchor Tag
                    echo anchor(
							  'email_sms_blast',
							  'Back',
							  array(
								'title' => 'Back',
								'class' => 'btn btn-danger'
							  )
							);
					echo br(3);
                  ?>
                  </div>
                </div>
				
				 <?php echo form_close(); //Form close ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
 
