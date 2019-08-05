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
                                'footer',
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
                			'footer/contact/insert_update_footer_contact',
                			'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
              			);
						
						// Input tag hidden
						echo form_input(array(
						  'type'  => 'hidden',
						  'name'  => 'setting_id',
						  'id'    => 'setting_id',
						  'value' => $setting_id
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
					  				echo heading('Contact', '2');
					  				$list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
					  				$attributes = array('class' => 'nav navbar-right panel_toolbox');
					  				echo ul($list,$attributes);
				  					?>
                                    
                  					<div class="clearfix"></div>
                				</div>

                				<div class="x_content">
                                	
                                    <div class="form-group">

										<?php
                                      	echo form_label('Choose ','common_components','class="control-label col-md-3 col-sm-3 col-xs-12"');
                                      	?>
            
                                      	<div class="col-md-6 col-sm-6 col-xs-12">
                                        	<?php
											// Input tag hidden
											echo form_input(array(
											  'type'  => 'hidden',
											  'name'  => 'contact[]',
											  'id'    => 'contact',
											  'value' => 'contact_us'
											));
											
											$checkbox = array(
												'name'          => 'common_components[]',
												'id'            => 'contact_us',
												'class'         => 'flat',
												'value'         => 'contact_us',
												'checked'       => ($contact_us == 1) ? TRUE: FALSE,
											);
											
											// Checkbox Label
											$checkboxlabel = form_label(
												'Contact Us',
												'contact_us'
											);
											
											// Contact Us Checkbox
											echo '<p>'.form_checkbox($checkbox).$checkboxlabel.'</p>';
											
											// Input tag hidden
											echo form_input(array(
											  'type'  => 'hidden',
											  'name'  => 'contact[]',
											  'id'    => 'contact',
											  'value' => 'contact_information'
											));
											
											$checkbox = array(
												'name'          => 'common_components[]',
												'id'            => 'contact_information',
												'class'         => 'flat',
												'value'         => 'contact_information',
												'checked'       => ($contact_information == 1) ? TRUE: FALSE,
											);
											
											// Checkbox Label
											$checkboxlabel = form_label(
												'Contact Information',
												'contact_information'
											);
											
											// Contact Information Checkbox
											echo '<p>'.form_checkbox($checkbox).$checkboxlabel.'</p>';
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
            
                                        <div class="col-md-6 col-sm-6 col-xs-12">
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

						<div class="col-md-12 col-sm-12 col-xs-12">
              <div class="input-button-group">
								<?php
								// Submit Button
								echo form_submit(
									array(
										'class' => 'btn btn-success',
										'id'    => 'btn',
										'value' => 'Save'
									)
								);
								
								// Submit Button
								echo form_submit(
								  array(
									'class' => 'btn btn-success',
									'id'    => 'btn',
									'name'  => 'btn_continue',
									'value' => 'Save & Continue'
								  )
								);
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
