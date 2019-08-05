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
                            if(!empty($contact_form_fields) && !empty($label_name)) {
								
								// Mail Configure Button
								echo anchor(
									'contact_us/mail_configure',
									'Mail Configure',
									array(
										'class' => 'btn btn-success'
									)
								);

                                // Form Layout Button
                                echo anchor(
                                    'contact_us/form_layout',
                                    'Form Layout',
                                    array(
                                        'class' => 'btn btn-success'
                                    )
                                );
                            }

                            // Back Button
                            echo anchor(
                                'contact_us/contact_customize',
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
                			'contact_us/insert_update_contact_form_field',
                			'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
              			);
						
						echo form_input(array(
							'type'       	=> 'hidden',
							'name'     	=> 'website_id',
							'id'     	=> 'website_id',
							'value'       => $website_id
						));
						
						echo form_input(array(
							'type'       	=> 'hidden',
							'name'     	=> 'base_url',
							'id'     	=> 'base_url',
							'value'       => base_url()
						));
            			?>

            			<div class="col-md-12 col-sm-12 col-xs-12">
              				<div class="x_panel">
                				<div class="x_title">

                  					<?php
															echo heading('Field', '2');
															$list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
															$attributes = array('class' => 'nav navbar-right panel_toolbox');
															echo ul($list,$attributes);
														?>

                  					<div class="clearfix"></div>
                				</div>

                				<div class="x_content">

                                    <?php
												if (!empty($label_name)) {

													$id = count($label_name);

									
													for($i = 0; $i < count($label_name); $i++) {

														?>
                                            <div class="row <?php echo ($is_deleted[$i] != 0) ? 'hide': ''; ?>" id="form_id_<?php echo $i; ?>">

                                                <div class="form-group col-md-2 col-lg-2 col-sm-2 col-xs-12">
                                                	<?php
                                                    echo form_label('Label Name :','label_name');

                                                    // Input tag
                                                    echo form_input(array(
                                                        'id'       	  => 'label_name',
                                                        'name'     	=> 'label_name[]',
                                                        'class'       => 'form-control',
														'placeholder' => 'Label Name',
														'required'    => 'required',
                                                        'value'       => $label_name[$i]
                                                    ));

													$character_out = array(' ');
													$character_in = array('_');
													//$old_label_name = str_replace($character_out, $character_in, $label_name[$i]);

																									// Label Name Hidden
                                                    echo form_input(array(
                                                        'type'       	=> 'hidden',
                                                        'name'     	=> 'old_label_name[]',
                                                        'class'       => 'form-control',
                                                        'value'       => $label_name[$i]
                                                    ));
													
													echo form_input(array(
                                                        'type'       	=> 'hidden',
                                                        'name'     	=> 'is_deleted[]',
                                                        'class'       => 'form-control',
                                                        'value'       => $is_deleted[$i]
                                                    ));
                                                    ?>
                                                </div>

                                                <div class="form-group col-md-2 col-lg-2 col-sm-2 col-xs-12">
                                                	<?php
                                                    echo form_label('Field Type :','choosefield');

                                                    //select options
                                                    $choosefieldoptions = array(
                                                        'textbox'	=> 'Text Box',
                                                        'textarea'   => 'Text Area',
                                                        'datepicker' => 'Date Picker',
                                                        'datepicker' => 'Date Picker',
                                                        'dropdown'   => 'Dropdown',
                                                        'checkbox'   => 'Check Box',
                                                        'radio'	  => 'Radio Button'
                                                    );

                                                    $choosefieldattributes = array(
                                                        'name'	 => 'choosefield[]',
                                                        'id'	   => 'choosefield_'.$i,
														'required' => 'required',
														'onchange' => 'choosefield('.$i.')',
                                                        'class'	=> 'form-control'
                                                    );

                                                    echo form_dropdown($choosefieldattributes, $choosefieldoptions, $choosefield[$i]);

													echo br();
                                                    ?>

                                                    <div id="option_result_<?php echo $i;?>">

                                               			<?php if($choosefield[$i] == 'dropdown') { ?>

                                                        	<div id="field_selectoptions_<?php echo $i;?>">
                                                            	<?php
                                                               	$dropdown_attributes = ($field_attributes[$i] != '')?explode(',', $field_attributes[$i]):array();

                                                               	for($d = 0; $d < count($dropdown_attributes); $d++) {

                                                                	if($d == 0) {

																		?>
                                                            			<div class="form-group entry">
                                                                        	<?php
																			// Drop Down Text Box
																			echo form_input(array(
																				'type'  		=> 'text',
																				'placeholder' => 'Dropdown option value',
																				'class'       => 'form-control',
																				'name'  		=> 'options_'.$i.'[]',
																				'value' 	   => $dropdown_attributes[$d]
																			));
																			?>
                                                                            <span class="input-group-btn">
                                                                            	<?php
																				$hiddenadd = form_input(array(
																					'type'  => 'hidden',
																					'id'    => 'select_options',
																					'name'  => 'select_options[]',
																					'value' => $i
																				));

																				// Add Button
																				echo form_button(array(
																					'title'      => 'Add',
																					'type'       => 'button',
																					'class'      => 'btn btn-success btn-add',
																					'onclick'	=> 'add_moreselectopt('.$i.')',
																					'content'    => $hiddenadd.'<span class="glyphicon glyphicon-plus"></span>'
																				));
																				?>
                                                                          	</span>
                                                            			</div>

                                                            		<?php } else { ?>

                                                            			<div class="form-group entry" id="remove_options_<?php echo $id[$i];?>">
                                                                        	<?php
																			// Drop Down Text Box
																			echo form_input(array(
																				'type'  		=> 'text',
																				'placeholder' => 'Dropdown option value',
																				'class'       => 'form-control',
																				'name'  		=> 'options_'.$i.'[]',
																				'value' 	   => $dropdown_attributes[$d]
																			));
																			?>
                                                                            <span class="input-group-btn">
                                                                            	<?php
																				$hiddenrm = form_input(array(
																					'type'  => 'hidden',
																					'id'    => 'select_options',
																					'name'  => 'select_options[]',
																					'value' => $i
																				));

																				// Remove Button
																				echo form_button(array(
																					'title'      => 'Remove',
																					'type'       => 'button',
																					'class'      => 'btn btn-remove btn-danger',
																					'onclick'	=> 'remove_selectopt('.$id[$i].')',
																					'content'    => $hiddenrm.'<span class="glyphicon glyphicon-minus"></span>'
																				));
																				?>
                                                                            </span>
                                                            			</div>
                                                            			<?php
                                                               		}
                                                               	}
                                                               	?>
                                                         	</div>

                                                      	<?php } else if($choosefield[$i] == 'checkbox') { ?>

                                                        	<div id="field_checkoptions_<?php echo $i;?>">
                                                            	<?php
																$checkbox_attributes = ($field_attributes[$i] != '')?explode(',', $field_attributes[$i]):array();

                                                               	for($c = 0; $c < count($checkbox_attributes); $c++) {

                                                                   	if($c == 0) {

															   			?>
                                                          				<div class="form-group entry">
                                                                        	<?php
																			// Drop Down Text Box
																			echo form_input(array(
																				'type'  		=> 'text',
																				'placeholder' => 'Checkbox label',
																				'class'       => 'form-control',
																				'name'  		=> 'chk_options_'.$i.'[]',
																				'value' 	   => $checkbox_attributes[$c]
																			));
																			?>
                                                                            <span class="input-group-btn">
                                                                            	<?php
																				$hiddenadd = form_input(array(
																					'type'  => 'hidden',
																					'id'    => 'chk_options_hid',
																					'name'  => 'chk_options_hid[]',
																					'value' => $i
																				));

																				// Add Button
																				echo form_button(array(
																					'title'      => 'Add',
																					'type'       => 'button',
																					'class'      => 'btn btn-success btn-add',
																					'onclick'	=> 'add_morechkoptions('.$i.')',
																					'content'    => $hiddenadd.'<span class="glyphicon glyphicon-plus"></span>'
																				));
																				?>
                                                                            </span>
                                                            			</div>

                                                            		<?php } else { ?>

                                                        				<div class="form-group entry" id="remove_chkoptions_<?php echo $id[$i];?>">
                                                                        	<?php
																			// Drop Down Text Box
																			echo form_input(array(
																				'type'  		=> 'text',
																				'placeholder' => 'Checkbox Label',
																				'class'       => 'form-control',
																				'name'  		=> 'chk_options_'.$i.'[]',
																				'value' 	   => $checkbox_attributes[$c]
																			));
																			?>
                                                                            <span class="input-group-btn">
                                                                            	<?php
																				$hiddenrm = form_input(array(
																					'type'  => 'hidden',
																					'id'    => 'chk_options_hid',
																					'name'  => 'chk_options_hid[]',
																					'value' => $i
																				));

																				// Remove Button
																				echo form_button(array(
																					'title'      => 'Remove',
																					'type'       => 'button',
																					'class'      => 'btn btn-remove btn-danger',
																					'onclick'	=> 'remove_chkopt('.$id[$i].')',
																					'content'    => $hiddenrm.'<span class="glyphicon glyphicon-minus"></span>'
																				));
																				?>
                                                                            </span>
                                                            			</div>
                                                            			<?php
																	}
                                                               	}
															   	?>
                                                         	</div>

                                                   		<?php } else if($choosefield[$i] == 'radio') { ?>

                                                  			<div id="field_radiooptions_<?php echo $i;?>">
                                                            	<?php
                                                               	$radio_attributes = ($field_attributes[$i] != '')?explode(',', $field_attributes[$i]):array();

                                                               	for($r = 0; $r < count($radio_attributes); $r++) {

                                                                	if($r == 0) {

																		?>
                                                          				<div class="form-group entry">
                                                                        	<?php
																			// Drop Down Text Box
																			echo form_input(array(
																				'type'  		=> 'text',
																				'placeholder' => 'Radion label',
																				'class'       => 'form-control',
																				'name'  		=> 'radio_options_'.$i.'[]',
																				'value' 	   => $radio_attributes[$r]
																			));
																			?>
                                                                            <span class="input-group-btn">
                                                                            	<?php
																				$hiddenadd = form_input(array(
																					'type'  => 'hidden',
																					'id'    => 'radio_option_hid',
																					'name'  => 'radio_option_hid[]',
																					'value' => $i
																				));

																				// Add Button
																				echo form_button(array(
																					'title'      => 'Add',
																					'type'       => 'button',
																					'class'      => 'btn btn-success btn-add',
																					'onclick'	=> 'add_moreradiooptions('.$i.')',
																					'content'    => $hiddenadd.'<span class="glyphicon glyphicon-plus"></span>'
																				));
																				?>
                                                                            </span>
                                                            			</div>

                                                            		<?php } else { ?>

                                                          				<div class="form-group entry" id="remove_radiooptions_<?php echo $id[$i];?>">
                                                                        	<?php
																			// Drop Down Text Box
																			echo form_input(array(
																				'type'  		=> 'text',
																				'placeholder' => 'Radio Label',
																				'class'       => 'form-control',
																				'name'  		=> 'radio_options_'.$i.'[]',
																				'value' 	   => $radio_attributes[$r]
																			));
																			?>
                                                                            <span class="input-group-btn">
                                                                            	<?php
																				$hiddenrm = form_input(array(
																					'type'  => 'hidden',
																					'id'    => 'radio_option_hid',
																					'name'  => 'radio_option_hid[]',
																					'value' => $i
																				));

																				// Remove Button
																				echo form_button(array(
																					'title'      => 'Remove',
																					'type'       => 'button',
																					'class'      => 'btn btn-remove btn-danger',
																					'onclick'	=> 'remove_radioopt('.$id[$i].')',
																					'content'    => $hiddenrm.'<span class="glyphicon glyphicon-minus"></span>'
																				));
																				?>
                                                                            </span>
                                                            			</div>
                                                            			<?php
																	}
                                                               	}
																?>
                                                         	</div>

                                                        <?php } else { ?>

                                                        	<div id="field_selectoptions_<?php echo $i;?>"></div>
                                                         	<div id="field_checkoptions_<?php echo $i;?>"></div>
                                                         	<div id="field_radiooptions_<?php echo $i;?>"></div>

                                                         <?php } ?>
                                                    </div>

                                            	</div>

                                                <div class="form-group col-md-1 col-lg-1 col-sm-1 col-xs-12">
                                                	<?php
													echo form_label('Icon :','icon');

													// Input tag
                                                    echo form_input(array(
                                                        'id'       	  => 'icon',
                                                        'name'     	=> 'icon[]',
                                                        'class'       => 'form-control icp_'.$i.' icp-auto',
														'placeholder' => 'Icon',
														'onclick'     => 'icon_preview('.$i.')',
														'data-input-search' => TRUE,
                                                        'value'       => $icon[$i]
                                                    ));

													echo br('1');

                                        			echo '<p class="lead_'.$i.'"><i class=" fa '.$icon[$i].' fa-3x picker-target"></i></p>';
													?>
                                             	</div>

                                                <div class="form-group col-md-2 col-lg-2 col-sm-2 col-xs-12">
                                                	<?php
													echo form_label('Placeholder :','placeholder');

													// Input tag
                                                    echo form_input(array(
                                                        'id'       	  => 'placeholder',
                                                        'name'     	=> 'placeholder[]',
                                                        'class'       => 'form-control',
														'placeholder' => 'Placeholder',
                                                        'value'       => $placeholder[$i]
                                                    ));
													?>
                                             	</div>

                                                <div class="form-group col-md-1 col-lg-1 col-sm-1 col-xs-12">
                                                	<?php
													echo form_label('Sort Order :','sort_order');

													// Input tag
                                                    echo form_input(array(
                                                        'id'       	  => 'sort_order',
                                                        'name'     	=> 'sort_order[]',
                                                        'class'       => 'form-control',
                                                        'value'       => $sort_order[$i]
                                                    ));
													?>
                                             	</div>

                                                <div class="form-group col-md-1 col-lg-1 col-sm-1 col-xs-12">
                                                	<?php
													echo form_label('Validation :','validation');

													//select options
                                                    $validationoptions = array(
                                                        'none'   => 'None',
                                                        'number' => 'Number',
                                                        'email'  => 'Email'
                                                    );

                                                    $validationattributes = array(
                                                        'name'	 => 'validation[]',
                                                        'id'	   => 'validation_'.$i,
                                                        'class'	=> 'form-control'
                                                    );

                                                    echo form_dropdown($validationattributes, $validationoptions, $validation[$i]);
													?>
                                             	</div>

                                                <div class="form-group col-md-1 col-lg-1 col-sm-1 col-xs-12">
                                                	<?php
													echo form_label('Required :','required');

													//select options
                                                    $requiredoptions = array(
                                                        '1'	=> 'Yes',
                                                        '0'  	=> 'No'
                                                    );

                                                    $requiredattributes = array(
                                                        'name'	 => 'required[]',
                                                        'id'	   => 'required_'.$i,
                                                        'class'	=> 'form-control'
                                                    );

                                                    echo form_dropdown($requiredattributes, $requiredoptions, $required[$i]);
													?>
                                             	</div>

                                                <?php
												// Hidden Input tag
												echo form_input(array(
													'type'  => 'hidden',
													'id'	=> 'id',
													'name'  => 'id[]',
													'class' => 'form-control',
													'value' => $id
												));
												
												?>

                                                <div class="col-md-2 col-lg-2 col-sm-2 col-xs-12" style="padding-top:22px;">
                                                	<?php
													$hiddenremove = form_input(array(
                                                        'type'  => 'hidden',
                                                        'id'    => 'remove_form_fields_id_'.$i,
                                                        'value' => $label_name[$i]
                                                    ));

													// Remove Button
                                                    echo form_button(array(
                                                        'title'      => 'Remove',
                                                        'type'       => 'button',
                                                        'class'      => 'btn btn-remove btn-danger',
                                                        'onclick'	=> 'remove_from_fields('.$i.')',
                                                        'content'    => $hiddenremove.'<span class="glyphicon glyphicon-minus"></span>'
                                                    ));
													?>
                                                 </div>

                                            </div>
                                            <?php
										}
									}
									?>

                                    <div id="result_field"></div>

                                    <div class="form-group">
                                    	<?php
										// Add Button
										echo form_button(array(
											'title'      => 'Add',
											'type'       => 'button',
											'id'		 => 'add_field',
											'class'      => 'btn btn-success btn-add',
											'onclick'	=> 'add_morefield()',
											'content'    => '<span class="glyphicon glyphicon-plus"></span> Add'
										));
										?>
                                    </div>

                				</div>
              				</div>
            			</div>

						<!-- Button Group -->

						<div class="col-md-12 col-sm-12 col-xs-12 ">
               				<div class="input-button-group">
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
