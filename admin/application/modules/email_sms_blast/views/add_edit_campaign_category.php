 <!-- page content -->
<div class="right_col" role="main">
	<div class="">
    	<div class="clearfix"></div>

    	<div class="row">
      		<div class="col-md-12 col-sm-12 col-xs-12">
        		<div class="">

          			<div class="x_title">
            			<?php echo heading($heading, '2');?>
                        
                        <div style="text-align:right;">
							<?php
                            echo anchor(
                                'email_sms_blast/campaign_category',
                                '<i class="fa fa-chevron-left" aria-hidden="true"></i> Back',
                                array(
                                    'class' => 'btn btn-primary'
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
                			'email_sms_blast/insert_update_campaign_category',
                			'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate autocomplete="off"'
              			);

              			// Input tag hidden
              			echo form_input(array(
                			'type'  => 'hidden',
                			'name'  => 'campaign_category_id',
                			'id'    => 'campaign_category_id',
                			'value' => $campaign_category_id
              			));
						
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
										echo heading('Add Edit Campaign Category', '2');
										$list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
										$attributes = array('class' => 'nav navbar-right panel_toolbox');
										echo ul($list,$attributes);
									?>
                                    <div class="clearfix"></div>
                                </div>
                				<div class="x_content">
                                	<div class="form-group">
										<?php
                                      	echo form_label('Category <span class="required">*</span>','name','class="control-label col-md-3 col-sm-3 col-xs-12"');
                                      	?>
            
                                      	<div class="col-md-6 col-sm-6 col-xs-12">
                                        	<?php
                                          	// Input tag
                                          	echo form_input(array(
                                            	'id'       => 'category_name',
                                            	'name'     => 'category_name',
												'required' => 'required',
                                            	'class'    => 'form-control col-md-7 col-xs-12',
                                            	'value'    => $category
                                          	));
                                        	?>
                                      	</div>
                                        <span id="error"></span>
                                 	</div>
									<div class="form-group">

										<?php
                                      	echo form_label('Web Url','web_url','class="control-label col-md-3 col-sm-3 col-xs-12"');
                                      	?>
            
                                      	<div class="col-md-6 col-sm-6 col-xs-12">
                                        	<?php
                                          	// Input tag
                                          	echo form_input(array(
                                            	'id'       => 'web_url',
                                            	'name'     => 'web_url',
                                            	'class'    => 'form-control col-md-7 col-xs-12',
                                            	'value'    => $web_url
                                          	));
                                        	?>
                                      	</div>                                        
                                 	</div>
									<div class="form-group">
										<?php
                                      	echo form_label('Tiny Url','tiny_url','class="control-label col-md-3 col-sm-3 col-xs-12"');
                                      	?>            
                                      	<div class="col-md-6 col-sm-6 col-xs-12">
                                        	<?php
                                          	// Input tag
                                          	echo form_input(array(
                                            	'id'       => 'tiny_url',
                                            	'name'     => 'tiny_url',
                                            	'class'    => 'form-control col-md-7 col-xs-12',
                                            	'value'    => $tiny_url
                                          	));
                                        	?>
                                      	</div>
                                        
                                 	</div>
									<div class="form-group">
										<?php
											echo form_label('Select Type <span class="required">*</span>','campaign_type_name','class="control-label col-md-3 col-sm-3 col-xs-12"');
										?>            
                                      	<div class="col-md-6 col-sm-6 col-xs-12">
                                        <?php
											$options = array(
												''	=> 'Select',
												'sms' => 'SMS',
											 	'email' => 'EMAIL'
											);

											$attributes = array(
												'name' => 'campaign_type_name',
												'id' => 'campaign_type_name',
												'required' => 'required',
												'onchange' =>'get_email_template(this.value)',
 												'class'	=> 'form-control col-md-7 col-xs-12'
											);
											echo form_dropdown($attributes, $options, $campaign_type);
										?>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="templates" id="template_label">
											Templates
											<span class="required">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<select id="templates" name="templates" class="form-control col-md-7 col-xs-12" >
												<option value="">Select Template</option>
												<?php
													foreach($templates as $template){ ?>
														<option value="<?php echo $template->id;?>"><?php echo $template->template_name;?></option>	
												<?php	}
												?>
											</select>	
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="menu-url">
											User Email
											<span class="required">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<?php
											// Input
											echo form_input(array(
												'id'       => 'user_email',
												'name'     => 'user_email',
												'required' => 'required',
												'type' 	   => 'email',
												'class'    => 'form-control col-md-7 col-xs-12',
												'value'    => $email
											));
											?>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="menu-url">
											Provider Name
											<span class="required">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<?php
												// Input
												echo form_input(array(
													'id'       => 'provider_name',
													'name'     => 'provider_name',
													'required' => 'required',
													'type' 	   => 'text',
													'class'    => 'form-control col-md-7 col-xs-12',
													'value'    => $provider_name
												));
											?>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="menu-url">
											Facility Name
											<span class="required">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<?php
												// Input
												echo form_input(array(
													'id'       => 'facility_name',
													'name'     => 'facility_name',
													'required' => 'required',
													'type' 	   => 'text',
													'class'    => 'form-control col-md-7 col-xs-12',
													'value'    => $facility_name
												));
											?>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="menu-url">
											Password
											<span class="required">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<?php
											// Input
											echo form_input(array(
												'id'       => 'password',
												'name'     => 'password',
												'type'     => 'password',
												'required' => 'required',
												'class'    => 'form-control col-md-7 col-xs-12',
												'value'    => $password
											));
											?>
										</div>
									</div>
									<div class="form-group">
										<?php
                                      	echo form_label('Mail Content','mail_content','class="control-label col-md-3 col-sm-3 col-xs-12"');
                                      	?>            
                                      	<div class="col-md-6 col-sm-6 col-xs-12">
                                        	<?php
                                          	// Input tag
                                          	echo form_input(array(
                                            	'id'       => 'mail_content',
                                            	'name'     => 'mail_content',
                                            	'class'    => 'form-control col-md-7 col-xs-12',
                                            	'value'    => $mail_content
                                          	));
                                        	?>
                                      	</div>                                        
                                 	</div>
                                   <!-- <div class="form-group">
										<?php
										  echo form_label('Template <span class="required">*</span>','template',
												   'class="control-label col-md-3 col-sm-3 col-xs-12"');
										?>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<?php
											$selected ="";
											$options = array('0' => 'Select Template');
											
											foreach($templates as $template):
												$options[$template->id] = $template->template_name;
											endforeach;
											if(!empty($templates)):
												$selected = $template->template_name;
											endif;
											
											$attributes = array(
																'id'       => 'template',
																'name'     => 'template',
																'class'    => 'form-control col-md-7 col-xs-12',
															);
											echo form_dropdown($attributes, $options, $selected_template);
										?>
									   </div>
									</div> -->
                                    <div class="form-group">

										<?php
                                      	echo form_label('Sort Order','sort_order','class="control-label col-md-3 col-sm-3 col-xs-12"');
                                      	?>
            
                                      	<div class="col-md-6 col-sm-6 col-xs-12">
                                        	<?php
                                          	// Input tag
                                          	echo form_input(array(
                                            	'id'       => 'sort_order',
                                            	'name'     => 'sort_order',
                                            	'class'    => 'form-control col-md-7 col-xs-12',
                                            	'value'    => $sort_order
                                          	));
                                        	?>
                                      	</div>
                                        
                                 	</div>  
									<div class="form-group">
                                        <?php
											echo form_label(
												'Status',
												'status',
												'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);
										?>

                                        <div class="col-md-6 col-sm-6 col-xs-12 center-align">
                                            <?php
												// Input checkbox
												echo form_checkbox(array(
													'id'      => 'status',
													'name'    => 'status',
													'class'   => 'js-switch',
													'checked' => ($status === '1') ? TRUE : FALSE,
													'value'   => $status
												));
											?>
                                        </div>
                                    </div>									
                				</div>
              				</div>
            			</div>

              			<!-- Button Group -->
              			<div class="col-md-12 col-sm-12 col-xs-12 ">
               				<div class="input-button-group">
                  				<?php
                    			// Submit Button
                    			if (empty($campaign_category_id)) :
                      				$submit_value = 'Add';
                    			else :
                      				$submit_value = 'Update';
                    			endif;

                    			echo form_submit(
                      				array(
                        				'class' => 'btn btn-success',
                        				'id'    => 'btn',
                        				'value' => $submit_value
                      				)
                    			);

                    			echo form_submit(
                      				array(
                        				'class' => 'btn btn-success',
                        				'id'    => 'btn',
                        				'name'  => 'btn_continue',
                        				'value' => $submit_value.' & Continue'
                      				)
                    			);
					   			// Reset Button
                    			echo form_reset(
                      				array(
                        				'class' => 'btn btn-primary',
                        				'value' => 'Reset'
                      				)
                    			);
					 			// Anchor Tag
                    			echo anchor(
                      				'email_sms_blast/campaign_category',
                      				'Back',
                      				array(
                        				'title' => 'Back',
                        				'class' => 'btn btn-primary'
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
<!-- /page content -->
