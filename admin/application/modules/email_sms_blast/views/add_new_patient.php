<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="">
          <div class="x_title">
            <?php echo heading($heading, '3');?>
            <div class="btn_right" style="text-align:right;">
                <?php
                    echo anchor(
                        'email_sms_blast',
                        '<i class="fa fa-chevron-left" aria-hidden="true"></i> Back',
                        array(
                            'class' => 'btn btn-danger'
                        )
                    );
                ?>
            </div>
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
                'email_sms_blast/insert_new_patients',
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
							              // 'oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '');",
                            'class'     => 'form-control col-md-7 col-xs-12',
                            'value'     => '',
                            'required'  => 'required'
                          ));
                        ?>
                      </div>
                    </div>
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
						  // Input tag
							// echo form_input(array(
							// 					'type'     => 'hidden',
							// 					'id'       => 'hidden_patient_name',
							// 					'name'     => 'patient_name',
							// 					'class'    => 'form-control col-md-7 col-xs-12',
							// 					'value'    =>''
							// 				  ));
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
						  // Input tag
							// echo form_input(array(
							// 					'type'     => 'hidden',
							// 					'id'       => 'hidden_patient_name',
							// 					'name'     => 'patient_name',
							// 					'class'    => 'form-control col-md-7 col-xs-12',
							// 					'value'    =>''
							// 				  ));
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
						  // Input tag
							// echo form_input(array(
							// 					'type'     => 'hidden',
							// 					'id'       => 'hidden_patient_email',
							// 					'name'     => 'patient_email',
							// 					'class'    => 'form-control col-md-7 col-xs-12',
							// 					'value'    =>''
							// 				  ));
                        ?>
                      </div>
                    </div>
			    </div>
				<div class="x_content">                	
                    <div class="form-group">
                      <?php
                      echo form_label('visit date','visit_date','class="control-label col-md-3 col-sm-3 col-xs-12"');
                      ?>

                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php
                          // Input tag
                          echo form_input(array(
                            'id'       => 'visit_date',
                            'name'     => 'visit_date',
                            'class'    => 'form-control col-md-7 col-xs-12',
							              'value'    => '',
                            'required' => 'required'
                          ));
                        ?>
                      </div>
                    </div>
			    </div>
				 <div class="form-group">
										<label for="campaign-type" class="control-label col-md-3 col-sm-3 col-xs-12">
											Provider Name
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
										<?php
											$provider_options = array(
																	'' => 'Please Select',
																	'dldc'	=> 'DLDC',
																	'reddy' => 'REDDY',
																	'hamat' => 'HAMAT'
																);
											
												
											$provider_attributes = array(
																		'id'       => 'provider_name',
																		'name'     => 'provider_name',
																		// 'required' => 'required',
																		'class'    => 'form-control'									
																		);
											
											// Dropdown
											echo form_dropdown(
															  $provider_attributes,
															  $provider_options,
															  ''
															);
										?>
											
										</div>
									</div>
									<div class="form-group">
										<label for="campaign-type" class="control-label col-md-3 col-sm-3 col-xs-12">
											Facility Name
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
										<?php
											$facility_options = array(
																	'' => 'Please Select',
																	'lb_dldc'	=> 'LB Digestive & Liver Disease Consults, PA',
																	'hum_dldc' => 'HUM Digestive & Liver Disease Consults, PA'
																);
										
												
											$facility_attributes = array(
																		'id'       => 'facility_name',
																		'name'     => 'facility_name',
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
									
								
					<div class="form-group">
                      <?php
                      echo form_label('Carrier','carrier_data','class="control-label col-md-3 col-sm-3 col-xs-12"');
                      ?>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php
                          // Input tag
                          echo form_input(array(
												'id'       => 'carrier_data',
												'name'     => 'carrier_data',
												'class'    => 'form-control col-md-7 col-xs-12',
												// 'required' => 'required',
												'value' =>''
											  ));
							// Input tag
							echo form_input(array(
												'type'     => 'hidden',
												'id'       => 'hidden_carrier_data',
												'name'     => 'carrier_data',
												'class'    => 'form-control col-md-7 col-xs-12',
												'value'    =>''
											  ));
                        ?>
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
                        'class' => 'btn btn-warning',
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
  
 
