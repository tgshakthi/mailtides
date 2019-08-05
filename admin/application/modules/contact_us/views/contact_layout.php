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
                                'contact_us/contact_page/'.$page_id,
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
                			'contact_us/update_contact_layout',
                			'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
              			);
						
						echo form_input(
							array(
								'type' => 'hidden',
								'name' => 'page_id',
								'id' => 'page_id',
								'value' => $page_id
							)
						);
            			?>

            			<div class="col-md-12 col-sm-12 col-xs-12">
              				<div class="x_panel">
                				<div class="x_title">

                  					<?php
					  				echo heading('Layout', '2');
					  				$list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
					  				$attributes = array('class' => 'nav navbar-right panel_toolbox');
					  				echo ul($list,$attributes);
				  					?>
                                    
                  					<div class="clearfix"></div>
                				</div>

                				<div class="x_content">
									<div class="custom_form row" id="custom_form">
										<?php
										// Hidden Row
										echo form_input(array(
											'type'  => 'hidden',
											'id'    => 'row',
											'name'  => 'row',
											'value' => $contact_row
										));
										
										$row_column_name = array();
                                        if(!empty($contact_column)) {
                                            
                                            $column = ($contact_column != '') ? explode('/', $contact_column): array();
                                            for($rc = 1; $rc <= count($column); $rc++) {
                                                
                                                $rc1 = $rc - 1;
                                                ?>
                                                <div class="form_totalorow" id="form_totalorow_<?php echo $rc; ?>">
                                                    <div class="form_row col-md-10 col-lg-10 col-sm-10 col-xs-12">
                                                        <ul id="form_row_<?php echo $rc; ?>">
                                                            <?php
                                                            $column_no     = str_replace($rc."r-","",$column[$rc1]);
                                                            $column_no     = explode(",",$column_no);
                                                            if(count($column_no) == 1) {
                                                                
                                                                $size = "form_row_column col-md-12 col-lg-12 col-sm-12 col-xs-12";
                                                                
                                                            } elseif(count($column_no) == 2) {
                                                                
                                                                $size = "form_row_column col-md-6 col-lg-6 col-sm-6 col-xs-12";
																$disable_array = array('disabled' => 'disabled');
                                                                
                                                            } else {
                                                                
                                                                $size = "form_row_column col-md-12 col-lg-12 col-sm-12 col-xs-12";
                                                            }
                                                            
                                                            for($cd = 1; $cd <= count($column_no); $cd++) {
                                                                
																$cd1 = $cd - 1;
																if($column_no[$cd1] == 'contact_us') {
																		
																	$row_column_name[] = $column_no[$cd1];
																	?>
																	<li class="<?php echo $size; ?>" id="form_row_column_<?php echo $rc.$cd; ?>">
																		<div>
																			<?php
																			// Form Label
																			echo form_label('Contact Us', '');
																			
																			// Hidden Select Column
																			$hidden_select_column = form_input(array(
																				'type'  => 'hidden',
																				'id'    => 'select_column_'.$rc,
																				'name'  => 'select_column_'.$rc.'[]',
																				'value' => $cd
																			));
																			
																			// Hidden Select Row Column
																			$hidden_select_row_column = form_input(array(
																				'type'  => 'hidden',
																				'id'    => 'select_row_column_'.$rc,
																				'name'  => 'select_row_column_'.$rc.'[]',
																				'value' => $rc.$cd
																			));
																			
																			// Hidden Row Column Field Name
																			$hidden_row_column_field_name = form_input(array(
																				'type'  => 'hidden',
																				'id'    => 'row_column_field_name'.$rc.$cd,
																				'name'  => 'row_column_field_name'.$rc.$cd.'[]',
																				'value' => $column_no[$cd1]
																			));
																			
																			// Remove Button
																			echo form_button(array(
																				'title'      => 'Remove',
																				'type'       => 'button',
																				'onclick'	=> 'contact_remove_form_row_column('.$rc.$cd.','.$rc.')',
																				'content'    => $hidden_select_column.$hidden_select_row_column.$hidden_row_column_field_name.'<i class="fa fa-times-circle" aria-hidden="true"></i>'
																			));
																			?>
																		</div>
																	</li>
																	<?php
																	
																} elseif($column_no[$cd1] == 'contact_information') {
																	
																	$row_column_name[] = $column_no[$cd1];
																	?>
																	<li class="<?php echo $size; ?>" id="form_row_column_<?php echo $rc.$cd; ?>">
																		<div>
																			<?php
																			// Form Label
																			echo form_label('Contact Information', '');
																			
																			// Hidden Select Column
																			$hidden_select_column = form_input(array(
																				'type'  => 'hidden',
																				'id'    => 'select_column_'.$rc,
																				'name'  => 'select_column_'.$rc.'[]',
																				'value' => $cd
																			));
																			
																			// Hidden Select Row Column
																			$hidden_select_row_column = form_input(array(
																				'type'  => 'hidden',
																				'id'    => 'select_row_column_'.$rc,
																				'name'  => 'select_row_column_'.$rc.'[]',
																				'value' => $rc.$cd
																			));
																			
																			// Hidden Row Column Field Name
																			$hidden_row_column_field_name = form_input(array(
																				'type'  => 'hidden',
																				'id'    => 'row_column_field_name'.$rc.$cd,
																				'name'  => 'row_column_field_name'.$rc.$cd.'[]',
																				'value' => $column_no[$cd1]
																			));
																			
																			// Remove Button
																			echo form_button(array(
																				'title'      => 'Remove',
																				'type'       => 'button',
																				'onclick'	=> 'contact_remove_form_row_column('.$rc.$cd.','.$rc.')',
																				'content'    => $hidden_select_column.$hidden_select_row_column.$hidden_row_column_field_name.'<i class="fa fa-times-circle" aria-hidden="true"></i>'
																			));
																			?>
																		</div>
																	</li>
																	<?php
																}
                                                            }
                                                            ?>
                                                        </ul>
                                                    </div>
                                                    <div class="row_button col-md-2 col-lg-2 col-sm-2 col-xs-12">
                                                    	<?php
														$addbutton_array = array(
															'title'       => 'Add Column',
															'name'	    => 'opener',
															'class'	   => 'btn btn-success btn-add',
															'id'		  => 'add_morerowcolumn_'.$rc,
															'type'        => 'button',
															'data-toggle' => 'modal',
															'data-target' => '#contact_myModal',
															'onclick'	 => 'contact_add_morerowcolumn('.$rc.')',
															'content'     => 'Add Column <span class="glyphicon glyphicon-plus"></span>'
														);

														$addbutton_array = (count($column_no) == 2) ? array_merge($addbutton_array, $disable_array): $addbutton_array;

														// Add More Column Button
														echo form_button($addbutton_array);
														
														// Hidden Row Column No
														$hidden_row_column_no = form_input(array(
															'type'  => 'hidden',
															'id'    => 'row_column_no_'.$rc,
															'name'  => 'row_column_no[]',
															'value' => $column[$rc1]
														));
														
														// Hidden Row No
														$hidden_row_no = form_input(array(
															'type'  => 'hidden',
															'id'    => 'row_no_'.$rc,
															'name'  => 'row_no_'.$rc,
															'value' => $rc
														));
														
														// Hidden Select Row
														$hidden_select_row = form_input(array(
															'type'  => 'hidden',
															'id'    => 'select_row',
															'name'  => 'select_row[]',
															'value' => $rc
														));
														
														// Remove Column Button
														echo form_button(array(
															'title'       => 'Remove Column',
															'class'	   => 'btn btn-remove btn-danger space_padd',
															'id'		  => 'form_row_id_'.$rc,
															'type'        => 'button',
															'onclick'	 => 'contact_remove_form_row('.$rc.')',
															'content'     => $hidden_row_column_no.$hidden_row_no.$hidden_select_row.'<span title="Remove Row"><i class="fa fa-trash-o" aria-hidden="true"></i></span>'
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
									$row_column_name = (!empty($row_column_name)) ? implode(',', $row_column_name): '';
									
									// Hidden Label Names
									echo form_input(array(
										'type'  => 'hidden',
										'id'    => 'label_names',
										'value' => $row_column_name
									));
									
									// Add Row Button
									echo form_button(array(
										'title'       => 'Add Row',
										'class'	   => 'btn btn-success btn-add',
										'type'        => 'button',
										'onclick'	 => 'contact_add_morerow()',
										'content'     => 'Add Row <span class="glyphicon glyphicon-plus"></span>'
									));

									?>
                                    <!-- Form Fields Modal -->
                                    <div class="modal fade" id="contact_myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                          
                                                <div class="modal-header">
                                                    <?php
                                                    // Modal Close Button
                                                    echo form_button(array(
                                                        'title'        => 'Close',
                                                        'class'	    => 'close',
                                                        'type'         => 'button',
                                                        'data-dismiss' => 'modal',
                                                        'content'      => '&times;'
                                                    ));
                                                    
                                                    // Modal Heading
                                                    echo heading('Choose Field', 4, 'class="modal-title"');
                                                    ?>
                                                </div>
                          
                                                <div class="modal-body">
                                                    <?php
                                                    $field_name_options = array(
														'' => 'select',
														'contact_us' => 'Contact Us',
														'contact_information' => 'Contact Infomation'
													);
													
                                                    // Dropdown Attributes
                                                    $field_name_attributes = array(
                                                        'name'	 => 'select_column',
                                                        'id'	   => 'select_column',
                                                        'class'	=> 'form-control'
                                                    );
                                                    
                                                    // Dropdown Filed Select
                                                    echo form_dropdown($field_name_attributes, $field_name_options, '');
                                                    ?>
                                                </div>
                          
                                                <div class="modal-footer">
                                                    <?php
                                                    echo form_button(array(
                                                        'type'         => 'button',
                                                        'id'		   => 'closemodel',
                                                        'class'        => 'btn btn-default',
                                                        'data-dismiss' => 'modal',
                                                        'content'      => 'Close'
                                                    ));
                                                    ?>
                                                </div>
                                              
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="formSep">
                                        <div class="demo">
                                            <ul class="connectedSortable" id="sortable">
                                                <li id="contact_usff" data-id="0" class="ui-state-default">
                                                    <div class="formSep border_bottom">
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <?php
                                                                // Form Label
                                                                echo form_label('Contact Us', '');
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li id="contact_informationff" data-id="1" class="ui-state-default">
                                                    <div class="formSep border_bottom">
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <?php
                                                                // Form Label
                                                                echo form_label('Contact Infomation', '');
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
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
										'id'    => 'btn',
										'value' => $submit_value
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
