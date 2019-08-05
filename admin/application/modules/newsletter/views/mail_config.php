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
                                'newsletter',
                                'Back',
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
                			'newsletter/insert_update_newsletter_mail_configure',
                			'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
              			);
						
						// Input tag Website ID
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
					  				echo heading('Mail Content', '2');
					  				$list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
					  				$attributes = array('class' => 'nav navbar-right panel_toolbox');
					  				echo ul($list,$attributes);
				  					?>
									
                  					<div class="clearfix"></div>
                				</div>

                				<div class="x_content">
                                	
                                    <div class="form-group">
                        				<?php
                            			echo form_label(
											'Mail Subject ',
											'mail_subject',
											'class="control-label col-md-3 col-sm-3 col-xs-12"'
										);
										?>
                                        
    									<div class="col-md-6 col-sm-6 col-xs-12">
                            				<?php
                                            // Input tag
                            				echo form_input(array(
                            					'id'       => 'mail_subject',
                            					'name'     => 'mail_subject',
                            					'class'    => 'form-control',
                            					'value'    => $mail_subject
                            				));
                        					?>
                                      	</div>
                                        
                    				</div>
                                    
                                    <div class="form-group">
                        				<?php
                            			echo form_label(
											'From Name ',
											'from_name',
											'class="control-label col-md-3 col-sm-3 col-xs-12"'
										);
										?>
                                        
    									<div class="col-md-6 col-sm-6 col-xs-12">
                            				<?php
                                            // Input tag
                            				echo form_input(array(
                            					'id'       => 'from_name',
                            					'name'     => 'from_name',
                            					'class'    => 'form-control',
                            					'value'    => $from_name
                            				));
                        					?>
                                      	</div>
                                        
                    				</div>
                                    
                                    <div class="form-group">
                        				<?php
                            			echo form_label(
											'Message Content ',
											'message_content',
											'class="control-label col-md-3 col-sm-3 col-xs-12"'
										);
										?>
                                        
    									<div class="col-md-6 col-sm-6 col-xs-12">
                            				<?php
											// Text Area
                                            echo form_textarea(array(
												'name'        => 'message_content',
												'id'          => 'message_content',
												'value'       => $message_content,
												'class'       => 'form-control'
											));
                        					?>
                                      	</div>
                                        
                    				</div>

									<div class="form-group">
                        				<?php
                            			echo form_label(
											'Success Title ',
											'success_title',
											'class="control-label col-md-3 col-sm-3 col-xs-12"'
										);
										?>
                                        
    									<div class="col-md-6 col-sm-6 col-xs-12">
                            				<?php
                                            echo form_input(array(
												'name'        => 'success_title',
												'id'          => 'success_title',
												'value'       => $success_title,
												'class'       => 'form-control'
											));
                        					?>
                                      	</div>
                                        
                    				</div>

									<div class="form-group">
                        				<?php
                            			echo form_label(
											'Success Message ',
											'success_message',
											'class="control-label col-md-3 col-sm-3 col-xs-12"'
										);
										?>
                                        
    									<div class="col-md-6 col-sm-6 col-xs-12">
                            				<?php
                                            echo form_input(array(
												'name'        => 'success_message',
												'id'          => 'success_message',
												'value'       => $success_message,
												'class'       => 'form-control'
											));
                        					?>
                                      	</div>
                                        
                    				</div>
                                    
                                    <div class="form-group">
										<?php
										echo form_label(
											'Status ',
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
                        
                        <div class="col-md-12 col-sm-12 col-xs-12">
              				<div class="x_panel">
                				<div class="x_title">

                  					<?php
					  				echo heading('Mail Address', '2');
					  				$list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
					  				$attributes = array('class' => 'nav navbar-right panel_toolbox');
					  				echo ul($list,$attributes);
				  					?>
									
                  					<div class="clearfix"></div>
                				</div>

                				<div class="x_content">
                                	
                               		<div class="row">
                                    	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        	<div class="form-group ">
                                            	<?php
												echo form_label(
													'Add To Address ',
													''
												);
												?>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                            <div class="form-group">
                                            	<?php
												echo form_label(
													'Add CC ',
													''
												);
												?>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                            <div class="form-group ">
                                            	<?php
												echo form_label(
													'Add BCC ',
													''
												);
												?>
                                            </div>
                                        </div>
                                        
                                        <div class="formSep col-lg-4 col-md-4 col-sm-4 col-xs-12 scrollbar">
                                            <div id="result_fieldto" >
                                                <?php
                                                if($to_address != "") {
													
                                                    $to_address = explode(",",$to_address);
													
                                                    for($to = 0; $to < count($to_address); $to++) {
														
                                                        ?>
                                                        <div class="row" id="form_toid_<?php echo $to;?>">
                                                            <div class="form-group col-md-10 col-lg-10 col-sm-10 col-xs-12 ">
                                                            	<?php
																	// Input tag
																	echo form_input(array(
																		'id'       	  => 'carbon_copy',
																		'name'     	=> 'to_address[]',
																		'class'       => 'form-control',
																		'placeholder' => 'Add To Address',
																		'required'	=> 'required',
																		'value'       => $to_address[$to]
																	));
																?>
                                                            </div>
                                                            <div class="col-md-2 col-lg-2 col-sm-2 col-xs-12 ">
                                                            	<?php
																	// Remove Button
																	echo form_button(array(
																		'type'    => 'Remove',
																		'class'   => 'btn btn-remove btn-danger',
																		'onclick' => 'remove_from_fieldsto('.$to.')',
																		'content' => '<span class="glyphicon glyphicon-minus"></span>'
																	));
																	
																	// Hidden To Address
																	echo form_input(array(
																		'type'  => 'hidden',
																		'id'    => 'count_to',
																		'value' => count($to_address)
																	));
																?>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                            <?php
												// Add Button
												echo form_button(array(
													'title'   => 'Add',
													'type'    => 'button',
													'id'	  => 'add_fieldto',
													'class'   => 'btn btn-success btn-add',
													'onclick' => 'add_moreto()',
													'content' => '<span class="glyphicon glyphicon-plus"></span> Add To Address'
												));
												
												echo br(1);
											?>
                                        </div>
                                        
                                        <div class="formSep col-lg-4 col-md-4 col-sm-4 col-xs-12 scrollbar">
                                            <div id="result_fieldcc">
                                                <?php
                                                if($cc != "") {
													
                                                    $cc = explode(",",$cc);

                                                    for($ccid = 0; $ccid < count($cc); $ccid++) {
														
                                                        ?>
                                                        <div class="row" id="form_ccid_<?php echo $ccid;?>">
                                                            <div class="form-group col-md-10 col-lg-10 col-sm-10 col-xs-12 ">
                                                            	<?php
																	// Input tag
																	echo form_input(array(
																		'id'       	  => 'carbon_copy',
																		'name'     	=> 'carbon_copy[]',
																		'class'       => 'form-control',
																		'placeholder' => 'Add CC',
																		'required'	=> 'required',
																		'value'       => $cc[$ccid]
																	));
																?>
                                                            </div>
                                                            <div class="col-md-2 col-lg-2 col-sm-2 col-xs-12 ">
                                                            	<?php
																	// Remove Button
																	echo form_button(array(
																		'type'    => 'Remove',
																		'class'   => 'btn btn-remove btn-danger',
																		'onclick' => 'remove_from_fieldscc('.$ccid.')',
																		'content' => '<span class="glyphicon glyphicon-minus"></span>'
																	));
																	
																	// Hidden To Address
																	echo form_input(array(
																		'type'  => 'hidden',
																		'id'    => 'count_cc',
																		'value' => count($cc)
																	));
																?>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                            <?php
												// Add Button
												echo form_button(array(
													'title'   => 'Add',
													'type'    => 'button',
													'id'	  => 'add_fieldcc',
													'class'   => 'btn btn-success btn-add',
													'onclick' => 'add_morecc()',
													'content' => '<span class="glyphicon glyphicon-plus"></span> Add CC'
												));
												
												echo br(1);
											?>
                                        </div>
                                        
                                        <div class="formSep col-lg-4 col-md-4 col-sm-4 col-xs-12 scrollbar">
                                            <div id="result_fieldbcc">
                                                <?php
                                                if($bcc != "") {
													
                                                    $bcc = explode(",",$bcc);

                                                    for($bccid = 0; $bccid < count($bcc); $bccid++) {
														
                                                        ?>
                                                        <div class="row" id="form_bccid_<?php echo $bccid;?>">
                                                            <div class="form-group col-md-10 col-lg-10 col-sm-10 col-xs-12 ">
                                                            	<?php
																	// Input tag
																	echo form_input(array(
																		'id'       	  => 'carbon_copy',
																		'name'     	=> 'blind_carbon_copy[]',
																		'class'       => 'form-control',
																		'placeholder' => 'Add BCC',
																		'required'	=> 'required',
																		'value'       => $bcc[$bccid]
																	));
																?>
                                                            </div>
                                                            <div class="col-md-2 col-lg-2 col-sm-2 col-xs-12">
                                                            	<?php
																	// Remove Button
																	echo form_button(array(
																		'type'    => 'Remove',
																		'class'   => 'btn btn-remove btn-danger',
																		'onclick' => 'remove_from_fieldsbcc('.$bccid.')',
																		'content' => '<span class="glyphicon glyphicon-minus"></span>'
																	));
																	
																	// Hidden To Address
																	echo form_input(array(
																		'type'  => 'hidden',
																		'id'    => 'count_bcc',
																		'value' => count($bcc)
																	));
																?>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                            <?php
												// Add Button
												echo form_button(array(
													'title'   => 'Add',
													'type'    => 'button',
													'id'	  => 'add_fieldbcc',
													'class'   => 'btn btn-success btn-add',
													'onclick' => 'add_morebcc()',
													'content' => '<span class="glyphicon glyphicon-plus"></span> Add BCC'
												));
												
												echo br(1);
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
								if (empty($newsletter_mail_config)) :
									$submit_value = 'Save';
								else :
									$submit_value = 'Update';
								endif;

								echo form_submit(
								  array(
									'class' => 'btn btn-success',
									//'id'    => 'btn',
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
								
								echo anchor(
									'newsletter',
									'Back',
									array(
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