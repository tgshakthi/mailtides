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
                                'contact_us/form_layout',
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
                			'contact_us/update_form_field',
                			'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
              			);
            			?>

            			<div class="col-md-12 col-sm-12 col-xs-12">
              				<div class="x_panel">
                				<div class="x_title">

                  					<?php
					  				echo heading('Form Field', '2');
					  				$list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
					  				$attributes = array('class' => 'nav navbar-right panel_toolbox');
					  				echo ul($list,$attributes);
				    					?>
									
                  					<div class="clearfix"></div>
                				</div>

                				<div class="x_content">

                                    <div class="x_title">

										<?php
                                        echo heading('Edit Field', '2');
                                        ?>
    
                                        <div class="clearfix"></div>
                                    </div>
                                    
                                    <?php
									// Input tag
									echo form_input(array(
										'type'     => 'hidden',
										'id'       => 'id',
										'name'     => 'id',
										'value'    => $id
									));
									
									$character_out = array('& ', ' ');
									$character_in = array('', '_');
									$old_label_name = str_replace($character_out, $character_in, $label_name);
									
									// Label Name
									echo form_input(array(
										'type'     => 'hidden',
										'id'       => 'old_label_name',
										'name'     => 'old_label_name',
										'value'    => strtolower($old_label_name)
									));
									?>
                                    
                                    <div class="form-group">
                        				<?php
                            			echo form_label('Label Name <span class="required">*</span>','label_name');
    
                            			// Input tag
                            			echo form_input(array(
                            				'id'       => 'label_name',
                            				'name'     => 'label_name',
											'required' => 'required',
                            				'class'    => 'form-control',
                            				'value'    => $label_name
                            			));
                        				?>
                    				</div>
                                    
                                    <div class="form-group">
                        				<?php
                            			echo form_label('Field Type','field_type');
    
                            			// Input tag
                            			echo form_input(array(
                            				'id'       => 'field_type',
											'readonly' => 'readonly',
                            				'class'    => 'form-control',
                            				'value'    => $field_type
                            			));
										
										// Input tag
                            			echo form_input(array(
                            				'type'     => 'hidden',
                            				'name'     => 'field_type',
                            				'class'    => 'form-control',
                            				'value'    => $field_type
                            			));
                        				?>
                    				</div>
                                    
                                    <?php if($field_type == 'textbox' || $field_type == 'textarea' || $field_type == 'datepicker') { ?>
										
                                        <div class="form-group">
											<?php
											echo form_label('Placeholder','placeholder');
		
											// Input tag
											echo form_input(array(
												'id'       => 'placeholder',
												'name'     => 'placeholder',
												'class'    => 'form-control',
												'value'    => $placeholder
											));
											?>
										</div>
										
										<div class="form-group">
											<?php
											echo form_label('Validation :','validation');
		
											//select options
											$validationoptions = array(
												'none'   => 'None',
												'number' => 'Number',
												'email'  => 'Email'
											);
		  
											$validationattributes = array(
												'name'	 => 'validation',
												'id'	   => 'validation',
												'class'	=> 'form-control'
											);
		  
											echo form_dropdown($validationattributes, $validationoptions, $validation);
											?>
										</div>
                                        
                                    <?php } elseif($field_type == 'dropdown') { ?>
                                    
                                    	<div class="form-group">
                                            <?php echo form_label('Add '.$label_name.' Field :',''); ?>
                                            <div id="field_selectoptions">
                                                <span class="input-group-btn">
													<?php
                                                    // Add Button
                                                    echo form_button(array(
                                                        'title'      => 'Add',
                                                        'type'       => 'button',
                                                        'class'      => 'btn btn-success btn-add',
                                                        'onclick'	=> 'add_moreselectoptsep()',
                                                        'content'    => '<span class="glyphicon glyphicon-plus"></span> Add Field'
                                                    ));
													
													// Placeholder Hidden
													echo form_input(array(
														'type'     => 'hidden',
														'name'     => 'placeholder',
														'class'    => 'form-control',
														'value'    => $placeholder
													));
													
													// Validation Hidden
													echo form_input(array(
														'type'     => 'hidden',
														'name'     => 'validation',
														'class'    => 'form-control',
														'value'    => $validation
													));
                                                    ?>
                                                </span>

                                                <?php
												echo br();
												
                                                if($field_attributes != "")
                                                {
                                                    $field_attributes = explode(",",$field_attributes);
                                                    for($d = 0; $d <count($field_attributes); $d++)
                                                    {
                                                        ?>
                                                        <div class="form-group entry" id="remove_options_<?php echo $d;?>">
                                                        	<?php
															// Input tag
															echo form_input(array(
																'name'        => 'options[]',
																'placeholder' => 'Dropdown option value',
																'class'       => 'form-control',
																'value'       => $field_attributes[$d]
															));
															?>
                                                            <span class="input-group-btn">
                                                            	<?php
																$hiddenremove = form_input(array(
																	'type'  => 'hidden',
																	'id'    => 'select_options',
																	'name'  => 'select_options[]',
																	'value' => $d
																));
									
																// Remove Button
																echo form_button(array(
																	'title'      => 'Add',
																	'type'       => 'button',
																	'class'      => 'btn btn-remove btn-danger',
																	'onclick'	=> 'remove_selectoptsep('.$d.')',
																	'content'    => $hiddenremove.'<span class="glyphicon glyphicon-minus"></span>'
																));
																?>
                                                            </span>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        
                                   	<?php } elseif($field_type == 'checkbox') { ?>
                                    
                                    	<div class="form-group">
                                            <?php echo form_label('Add '.$label_name.' Field :',''); ?>
                                            <div id="field_checkoptions">
                                                <span class="input-group-btn">
													<?php
                                                    // Add Button
                                                    echo form_button(array(
                                                        'title'      => 'Add',
                                                        'type'       => 'button',
                                                        'class'      => 'btn btn-success btn-add',
                                                        'onclick'	=> 'add_morechkoptionssep()',
                                                        'content'    => '<span class="glyphicon glyphicon-plus"></span> Add Field'
                                                    ));
													
													// Placeholder Hidden
													echo form_input(array(
														'type'     => 'hidden',
														'name'     => 'placeholder',
														'class'    => 'form-control',
														'value'    => $placeholder
													));
													
													// Validation Hidden
													echo form_input(array(
														'type'     => 'hidden',
														'name'     => 'validation',
														'class'    => 'form-control',
														'value'    => $validation
													));
													
													// Required Hidden
													echo form_input(array(
														'type'     => 'hidden',
														'name'     => 'required',
														'class'    => 'form-control',
														'value'    => $required
													));
													
													// Icon Hidden
													echo form_input(array(
														'type'     => 'hidden',
														'name'     => 'icon',
														'class'    => 'form-control',
														'value'    => $icon
													));
                                                    ?>
                                                </span>

                                                <?php
												echo br();
												
                                                if($field_attributes != "")
                                                {
                                                    $field_attributes = explode(",",$field_attributes);
                                                    for($c = 0; $c <count($field_attributes); $c++)
                                                    {
                                                        ?>
                                                        <div class="form-group entry" id="remove_chkoptions_<?php echo $c;?>">
                                                        	<?php
															// Input tag
															echo form_input(array(
																'name'        => 'chk_options[]',
																'placeholder' => 'Checkbox Label',
																'class'       => 'form-control',
																'value'       => $field_attributes[$c]
															));
															?>
                                                            <span class="input-group-btn">
                                                            	<?php
																$hiddenremove = form_input(array(
																	'type'  => 'hidden',
																	'id'    => 'chk_options_hid',
																	'name'  => 'chk_options_hid[]',
																	'value' => $c
																));
									
																// Remove Button
																echo form_button(array(
																	'title'      => 'Remove',
																	'type'       => 'button',
																	'class'      => 'btn btn-remove btn-danger',
																	'onclick'	=> 'remove_chkoptsep('.$c.')',
																	'content'    => $hiddenremove.'<span class="glyphicon glyphicon-minus"></span>'
																));
																?>
                                                            </span>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        
                                        <?php } elseif($field_type == 'radio') { ?>
                                    
                                    	<div class="form-group">
                                            <?php echo form_label('Add '.$label_name.' Field :',''); ?>
                                            <div id="field_radiooptions">
                                                <span class="input-group-btn">
													<?php
                                                    // Add Button
                                                    echo form_button(array(
                                                        'title'      => 'Add',
                                                        'type'       => 'button',
                                                        'class'      => 'btn btn-success btn-add',
                                                        'onclick'	=> 'add_moreradiooptionssep()',
                                                        'content'    => '<span class="glyphicon glyphicon-plus"></span> Add Field'
                                                    ));
													
													// Placeholder Hidden
													echo form_input(array(
														'type'     => 'hidden',
														'name'     => 'placeholder',
														'class'    => 'form-control',
														'value'    => $placeholder
													));
													
													// Validation Hidden
													echo form_input(array(
														'type'     => 'hidden',
														'name'     => 'validation',
														'class'    => 'form-control',
														'value'    => $validation
													));
													
													// Required Hidden
													echo form_input(array(
														'type'     => 'hidden',
														'name'     => 'required',
														'class'    => 'form-control',
														'value'    => $required
													));
													
													// Icon Hidden
													echo form_input(array(
														'type'     => 'hidden',
														'name'     => 'icon',
														'class'    => 'form-control',
														'value'    => $icon
													));
                                                    ?>
                                                </span>

                                                <?php
												echo br();
												
                                                if($field_attributes != "")
                                                {
                                                    $field_attributes = explode(",",$field_attributes);
                                                    for($r = 0; $r <count($field_attributes); $r++)
                                                    {
                                                        ?>
                                                        <div class="form-group entry" id="remove_radiooptions_<?php echo $r;?>">
                                                        	<?php
															// Input tag
															echo form_input(array(
																'name'        => 'radio_options[]',
																'placeholder' => 'Radio Label',
																'class'       => 'form-control',
																'value'       => $field_attributes[$r]
															));
															?>
                                                            <span class="input-group-btn">
                                                            	<?php
																$hiddenremove = form_input(array(
																	'type'  => 'hidden',
																	'id'    => 'radio_option_hid',
																	'name'  => 'radio_option_hid[]',
																	'value' => $r
																));
									
																// Remove Button
																echo form_button(array(
																	'title'      => 'Add',
																	'type'       => 'button',
																	'class'      => 'btn btn-remove btn-danger',
																	'onclick'	=> 'remove_selectoptsep('.$r.')',
																	'content'    => $hiddenremove.'<span class="glyphicon glyphicon-minus"></span>'
																));
																?>
                                                            </span>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    
                                    <?php } ?>
                                    
                                    <?php if($field_type == 'textbox' || $field_type == 'textarea' || $field_type == 'datepicker' || $field_type == 'dropdown') { ?>
                                    
                                        <div class="form-group">
                                            <?php
                                            echo form_label('Required :','required');
        
                                            //select options
                                            $requiredoptions = array(
                                                'yes' => 'Yes',
                                                'no'  => 'No'
                                            );
          
                                            $requiredattributes = array(
                                                'name'	 => 'required',
                                                'id'	   => 'required',
                                                'class'	=> 'form-control'
                                            );
          
                                            echo form_dropdown($requiredattributes, $requiredoptions, $required);
                                            ?>
                                        </div>
                                        
                                        <div class="form-group">
											<?php
                                            echo form_label('Icon','icon');
        
                                            // Input tag
                                            echo form_input(array(
                                                'id'       => 'icon',
                                                'name'     => 'icon',
                                                'class'    => 'form-control',
                                                'value'    => $icon
                                            ));
                                            ?>
                                        </div>
                                        
                                    <?php } ?>
                                    
                				</div>
              				</div>
            			</div>

						<!-- Button Group -->

						<div class="col-md-12 col-sm-12 col-xs-12 ">
               				<div class="input_butt">
								<?php

								// Submit Button
								if (empty($id)) :
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
