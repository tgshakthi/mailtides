<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="">

                    <div class="x_title">
                        <?php echo heading($heading, '2');?>
                        <div class="btn_right" style="text-align:right;">
                            <?php
																echo anchor(
																		'counter/counter_index/'.$page_id,
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
                        <div class="alert alert-success alert-dismissible fade in text-center" id="success-alert"
                            role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">×</span>
                            </button>
                            <strong>Success!</strong> <?php echo $this->session->flashdata('success');?>
                        </div>
                        <?php endif; ?>

                        <?php if ($this->session->flashdata('error') != '') : // Display session data ?>
                        <div class="alert alert-warning alert-dismissible fade in text-center" id="warning-alert"
                            role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">×</span>
                            </button>
                            <strong><?php echo $this->session->flashdata('error');?></strong>
                        </div>
                        <?php endif; ?>

                        <?php
													// Break tag
													echo br();

													// Form Tag
													echo form_open_multipart(
													'counter/insert_update_counter',
													'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate autocomplete="off"'
													);

													// Input tag hidden
													echo form_input(array(
													'type'  => 'hidden',
													'name'  => 'counter_id',
													'id'    => 'counter_id',
													'value' => $counter_id
													));

													// Input tag hidden
													echo form_input(array(
													'type'  => 'hidden',
													'name'  => 'page_id',
													'id'    => 'page_id',
													'value' => $page_id
													));
            						?>

                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">

                                    <?php
																			echo heading('Customize Title', '2');
																			$list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
																			$attributes = array('class' => 'nav navbar-right panel_toolbox');
																			echo ul($list,$attributes);
																		?>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="x_content">

                                    <div class="form-group">

                                        <?php
																					echo form_label('Count Number<span class="required">*</span>','count_number');

																					// Input tag
																					echo form_input(array(
																						'id'       => 'count_number',
																						'name'     => 'count_number',
																						'required' => 'required',
																						'class'    => 'form-control',
																						'value'    => $count_number
																					));
																				?>

                                    </div>
                                    <div class="form-group">

                                        <?php
																					echo form_label('Counter Number Color','count_number_color');

																					// Input tag hidden
																					echo form_input(array(
																						'type'  => 'hidden',
																						'name'  => 'count_number_color',
																						'id'    => 'count_number_color',
																						'value' => $count_number_color
																					));

																					// Input tag
																					$this->color->view($count_number_color,'count_number_color',1);
																				?>
                                    </div>
                                    <div class="form-group">

                                        <?php
                        									echo form_label('Counter Title','counter_title');

																					// Input tag
																					echo form_input(array(
																						'id'       => 'counter_title',
																						'name'     => 'counter_title',
																						'class'    => 'form-control',
																						'value'    => $counter_title
																					));
																				?>
                                    </div>
                                    <div class="form-group">

                                        <?php
																					echo form_label('Counter Title Color','counter_title_color');

																					// Input tag hidden
																					echo form_input(array(
																						'type'  => 'hidden',
																						'name'  => 'counter_title_color',
																						'id'    => 'counter_title_color',
																						'value' => $counter_title_color
																					));

																					// Input tag
																					$this->color->view($counter_title_color,'counter_title_color',2);
																				?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <?php
																			echo heading('Customize Icon', '2');
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
																						'Counter Icon <span class="required">*</span>',
																						'counter_icon',
																						'class="control-label"'
																					);
																					
																					// Input
																					echo form_input(array(
																						'id'                => 'counter_icon',
																						'name'              => 'counter_icon',
																						'required' 					=> 'required',
																						'class'             => 'form-control icp icp-auto',
																						'data-input-search' => 'true',
																						'value'             => $counter_icon
																					));

																					echo br('1');
																					
																					echo '<p class="lead"><i class="fa ' . $counter_icon . ' fa-3x picker-target"></i></p>';
																				?>
                                    </div>
                                    <div class="form-group">

                                        <?php
																					echo form_label('Count Icon Color','counter_icon_color');

																					// Input tag hidden
																					echo form_input(array(
																						'type'  => 'hidden',
																						'name'  => 'counter_icon_color',
																						'id'    => 'counter_icon_color',
																						'value' => $counter_icon_color
																					));

																					// Input tag
																					$this->color->view($counter_icon_color,'counter_icon_color',3);
																				?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">

                                    <?php
																			echo heading('Status', '2');
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
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="input-button-group">
                                <?php
																	// Submit Button
																	if (empty($counter_id)) :
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
																	// Anchor Tag
																	echo anchor(
																		'counter/counter_index/'.$page_id,
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