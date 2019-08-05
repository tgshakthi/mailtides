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
                                    'text_icon/text_icon_index/'.$page_id,
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
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <strong>Success!</strong>
                            <?php echo $this->session->flashdata('success');?>
                        </div>
                        <?php endif; ?>

                        <?php if ($this->session->flashdata('error') != '') : // Display session data ?>
                        <div class="alert alert-warning alert-dismissible fade in text-center" id="warning-alert"
                            role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <strong>
                                <?php echo $this->session->flashdata('error');?>
                            </strong>
                        </div>
                        <?php endif; ?>

                        <?php
							// Break tag
							echo br();

							// Form Tag

							echo form_open(
								'text_icon/insert_update_text_icon',
								'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate autocomplete="off"'
							);

							// Input tag hidden
							echo form_input(array(
								'type'  => 'hidden',
								'name'  => 'text-icon-id',
								'id'    => 'text-icon-id',
								'value' => $text_icon_id
							));

							// Input tag hidden
							echo form_input(array(
								'type'  => 'hidden',
								'name'  => 'page-id',
								'id'    => 'page-id',
								'value' => $page_id
							));
						?>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">

                                <div class="x_title">
                                    <?php
										echo heading('Text Icon', '2');
										$list = array(
											'<a title="Customize Text Icon" data-toggle = "tooltip" data-placement = "left" onclick="customize_text_icon_developer()">
												<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
											</a>',
											'<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>'
										);
										$attributes = array('class' => 'nav navbar-right panel_toolbox');
										echo ul($list,$attributes);
									?>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="x_content">

                                    <div class="form-group">

                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="text-icon">
                                            Choose Icon <span class="required">*</span>
                                        </label>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <?php
												// Input
												echo form_input(array(
													'id'                => 'text-icon',
													'name'              => 'icon',
													'required'          => 'required',
													'class'             => 'form-control col-md-7 col-xs-12 icp icp-auto',
													'data-input-search' => 'true',
													'value'             => $icon
												));

												echo br('2');

												echo '<p class="lead"><i class="fa '.$icon.' fa-3x picker-target"></i></p>';
											?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <?php

											echo form_label(
												'Icon Color',
												'icon_color',
												'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);

											// Input tag hidden
											echo form_input(array(
												'type'  => 'hidden',
												'name'  => 'icon_color',
												'id'    => 'icon_color',
												'value' => $icon_color
											));
										?>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <?php
												// Color
												$this->color->view($icon_color,'icon_color',1);
											?>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <?php
											echo form_label(
												'Icon Position',
												'position',
												'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);
										?>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <?php
												$options = array(
													'left-align'	 => 'Left',
													'right-align'	 => 'Right',
													'center-align' => 'Center'
												);

												$attributes = array(
													'name' => 'icon_position',
													'id' => 'icon_position',
													'class' => 'form-control col-md-7 col-xs-12'
												);

												echo form_dropdown($attributes, $options, $icon_position);
											?>
                                        </div>

                                    </div>

                                    <div id="customize_text_icon_developer" style="display:none">
                                        <?php echo br(1); ?>

                                        <div class="x_title">
                                            <?php echo heading('Customize Text Icon', '2'); ?>
                                            <div class="clearfix"></div>
                                        </div>

                                        <div class="form-group">
                                            <?php
												echo form_label(
													'Icon Shape',
													'position',
													'class="control-label col-md-3 col-sm-3 col-xs-12"'
												);
											?>

                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?php
													$options = array(
														'none'		=> 'None',
														'square'	=> 'Square',
														'circle'	=> 'Circle',
														'oval'		=> 'Oval'
													);

													$attributes = array(
														'name'	=> 'icon_shape',
														'id'	=> 'icon_shape',
														'class'	=> 'form-control col-md-7 col-xs-12'
													);
													echo form_dropdown($attributes, $options, $icon_shape);
												?>
                                            </div>
                                        </div>

                                        <div class="form-group" id="hidden_div"
                                            style="display: <?php echo (!empty($icon_shape) && $icon_shape != 'none') ?'block': 'none'; ?>;">
                                            <?php
												echo form_label(
													'Icon Background Color',
													'icon_background_color',
													'class="control-label col-md-3 col-sm-3 col-xs-12"'
												);

												// Input tag hidden
												echo form_input(array(
													'type'  => 'hidden',
													'name'  => 'icon_background_color',
													'id'    => 'icon_background_color',
													'value' => $icon_background_color
												));
											?>

                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?php
													// Color
													$this->color->view($icon_background_color,'icon_background_color',2);
												?>
                                            </div>

                                        </div>

                                        <div class="form-group" id="hidden_div_hover_icon"
                                            style="display: <?php echo (!empty($icon_shape) && $icon_shape != 'none') ?'block': 'none'; ?>;">
                                            <?php
												echo form_label(
													'Icon Hover Color',
													'icon_hover_color',
													'class="control-label col-md-3 col-sm-3 col-xs-12"'
												);

												// Input tag hidden
												echo form_input(array(
													'type'  => 'hidden',
													'name'  => 'icon_hover_color',
													'id'    => 'icon_hover_color',
													'value' => $icon_hover_color
												));
											?>

                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?php
													// Color
													$this->color->view($icon_hover_color,'icon_hover_color',3);
												?>
                                            </div>
                                        </div>

                                        <div class="form-group" id="hidden_div_hover"
                                            style="display:<?php echo (!empty($icon_shape) && $icon_shape != 'none') ?'block': 'none'; ?>;">
                                            <?php
												echo form_label(
													'Icon Background Hover Color',
													'icon_hover_background',
													'class="control-label col-md-3 col-sm-3 col-xs-12"'
												);

												// Input tag hidden
												echo form_input(array(
													'type'  => 'hidden',
													'name'  => 'icon_hover_background',
													'id'    => 'icon_hover_background',
													'value' => $icon_hover_background
												));
											?>

                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?php
													// Color
													$this->color->view($icon_hover_background,'icon_hover_background',4);
												?>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Title & Content -->
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="x_panel">

                                <div class="x_title">
                                    <?php
										echo heading('Title & Content', '2');
										$list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
										$attributes = array('class' => 'nav navbar-right panel_toolbox');
										echo ul($list,$attributes);
									?>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="x_content">

                                    <div class="form-group">

                                        <?php
											echo form_label('Title','title');

											// Input tag
											echo form_input(array(
												'id'       => 'title',
												'name'     => 'title',
												'class'    => 'form-control',
												'value'    => $icon_title
											));
										?>

                                    </div>

                                    <div class="form-group">

                                        <?php
											echo form_label('Content','text');

											// TextArea
											$data = array(
												'name'        => 'content',
												'id'          => 'text',
												'value'       => $content
											);
											echo form_textarea($data);
										?>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- Title & Content -->

                        <!-- Customize Title & Content -->
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="x_panel">

                                <div class="x_title">
                                    <?php
										echo heading('Customize Title & Content', '2');
										$list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
										$attributes = array('class' => 'nav navbar-right panel_toolbox');
										echo ul($list,$attributes);
									?>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="x_content">

                                    <div class="form-group">

                                        <?php

											echo form_label('Title Color','title-color');

											// Input tag hidden
											echo form_input(array(
												'type'  => 'hidden',
												'name'  => 'title-color',
												'id'    => 'title-color',
												'value' => $title_color
											));

											// Input tag
											$this->color->view($title_color,'title-color',5);
										?>

                                    </div>

                                    <div class="form-group">

                                        <?php

											echo form_label('Title Position','title_position');

											$options = array(
												'left-align'	=> 'Left',
												'center-align' => 'Center',
												'right-align' => 'Right'
											);

											$attributes = array(
												'name' => 'title_position',
												'id' => 'title_position',
												'class'	=> 'form-control'
											);

											echo form_dropdown($attributes, $options, $title_position);
										?>

                                    </div>

                                    <div class="form-group">

                                        <?php

											echo form_label('Content Title Color','content-title-color');

											// Input tag hidden
											echo form_input(array(
													'type'  => 'hidden',
													'name'  => 'content-title-color',
													'id'    => 'content-title-color',
													'value' => $content_title_color
											));

											// Color
											$this->color->view($content_title_color,'content-title-color',6);
										?>

                                    </div>

                                    <div class="form-group">

                                        <?php

											echo form_label('Content Title Position','content_title_position');

											$options = array(
												'left-align'	=> 'Left',
												'center-align'	=> 'Center',
												'right-align'	=> 'Right',
											);

											$attributes = array(
												'name' => 'content_title_position',
												'id' => 'content_title_position',
												'class'	=> 'form-control'
											);

											echo form_dropdown($attributes, $options, $content_title_position);
										?>

                                    </div>

                                    <div class="form-group">

                                        <?php

											echo form_label('Content Color','content-color');

											// Input tag hidden
											echo form_input(array(
												'type'  => 'hidden',
												'name'  => 'content-color',
												'id'    => 'content-color',
												'value' => $content_color
											));

											// Color
											$this->color->view($content_color,'content-color',7);
										?>

                                    </div>

                                    <div class="form-group">

                                        <?php
											echo form_label('Content Position','content_position');

											$options = array(
												'left-align'	=> 'Left',
												'center-align'	=> 'Center',
												'justify-align' => 'Justify',
												'right-align'	=> 'Right',
											);

											$attributes = array(
												'name' => 'content_position',
												'id' => 'content_position',
												'class'	=> 'form-control'
											);

											echo form_dropdown($attributes, $options, $content_position);
										?>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- Customize Title & Content -->


                        <div class="col-md-12 col-sm-12 col-xs-12">

                            <!-- Redirect -->
                            <div class="x_panel">

                                <div class="x_title">
                                    <?php
										echo heading('Redirect', '2');
										$list = array(
											'<a title="Customize Options" data-toggle = "tooltip" data-placement	= "left" onclick="text_icon_developer()">
												<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
											</a>',
											'<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>'
										);
										$attributes = array('class' => 'nav navbar-right panel_toolbox');
										echo ul($list,$attributes);
				  					?>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="x_content">

                                    <div class="form-group ">
                                        <?php
											echo form_label(
												'Redirect',
												'redirect',
												'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);
                      					?>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <?php
												// Input checkbox
												echo form_checkbox(array(
													'id'      => 'redirect',
													'name'    => 'redirect',
													'onchange' => 'redirect_btn()',
													'class'   => 'js-switch',
													'checked' => ($redirect === '1') ? TRUE : FALSE,
													'value'   => $redirect
												));
											?>
                                        </div>

                                    </div>

                                    <div id="redirect_url"
                                        style="display:<?php if($redirect == 1){echo 'block';}else{echo 'none';} ?>">

                                        <div class="form-group">
                                            <?php
												echo form_label(
													'Redirect URL <span class="required">*</span>',
													'redirect_url',
													'class="control-label col-md-3 col-sm-3 col-xs-12"'
												);
											?>

                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?php
													// Input tag
													echo form_input(array(
														'id'       => 'redirect_url',
														'name'     => 'redirect_url',
														'class'    => 'form-control col-md-7 col-xs-12',
														'value'    => $redirect_url
													));
												?>
                                                <span id="error_result"></span>
                                            </div>

                                        </div>

                                        <div class="form-group">

                                            <?php
												echo form_label(
													'Open New Tab',
													'open_new_tab',
													'class="control-label col-md-3 col-sm-3 col-xs-12"'
												);
                        					?>

                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?php
													// Input checkbox
													echo form_checkbox(array(
														'id'      => 'open_new_tab',
														'name'    => 'open_new_tab',
														'class'   => 'js-switch',
														'checked' => ($open_new_tab === '1') ? TRUE : FALSE,
														'value'   => $open_new_tab
													));
												?>
                                            </div>

                                        </div>

                                    </div>

                                    <div id="text_icon_developer" style="display:none">
                                        <?php echo br(1); ?>

                                        <div class="x_title">
                                            <?php echo heading('Customize Option', '2'); ?>
                                            <div class="clearfix"></div>
                                        </div>

                                        <div class="form-group">
                                            <?php
												echo form_label(
													'Background Hover',
													'background_hover',
													'class="control-label col-md-3 col-sm-3 col-xs-12"'
												);

												// Input tag hidden
												echo form_input(array(
													'type'  => 'hidden',
													'name'  => 'background_hover',
													'id'    => 'background_hover',
													'value' => $background_hover_color
												));
											?>

                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?php
													// Color
													$this->color->view($background_hover_color,'background_hover',8);
												?>
                                            </div>

                                        </div>

                                        <div class="form-group">
                                            <?php
												echo form_label(
													'Hover Title Color',
													'hover_title_color',
													'class="control-label col-md-3 col-sm-3 col-xs-12"'
												);

												// Input tag hidden
												echo form_input(array(
													'type'  => 'hidden',
													'name'  => 'hover_title_color',
													'id'    => 'hover_title_color',
													'value' => $hover_title_color
												));
                        					?>

                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?php
													// Color
													$this->color->view($hover_title_color,'hover_title_color',9);
												?>
                                            </div>

                                        </div>

                                        <div class="form-group">
                                            <?php
												echo form_label(
													'Content Title Hover Color',
													'content_title_hover',
													'class="control-label col-md-3 col-sm-3 col-xs-12"'
												);

												// Input tag hidden
												echo form_input(array(
													'type'  => 'hidden',
													'name'  => 'content_title_hover',
													'id'    => 'content_title_hover',
													'value' => $content_title_hover
												));
                        					?>

                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?php
													// Color
													$this->color->view($content_title_hover,'content_title_hover',10);
												?>
                                            </div>

                                        </div>

                                        <div class="form-group">
                                            <?php
												echo form_label(
													'Content Hover Color',
													'text_hover',
													'class="control-label col-md-3 col-sm-3 col-xs-12"'
												);

												// Input tag hidden
												echo form_input(array(
													'type'  => 'hidden',
													'name'  => 'text_hover',
													'id'    => 'text_hover',
													'value' => $text_hover_color
												));
                        					?>

                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?php
													// Color
													$this->color->view($text_hover_color,'text_hover',11);
												?>
                                            </div>

                                        </div>

                                    </div>

                                </div>
                            </div>
                            <!-- Redirect -->

                            <!-- Sort Order & Background Color -->
                            <div class="x_panel">

                                <div class="x_title">
                                    <?php
										echo heading('Sort Order & Background Color', '2');
										$list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
										$attributes = array('class' => 'nav navbar-right panel_toolbox');
										echo ul($list,$attributes);
									?>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="x_content">

                                    <div class="form-group">

                                        <?php
											echo form_label('Background Color','background-color','class="control-label col-md-3 col-sm-3 col-xs-12"');

											// Input tag hidden
											echo form_input(array(
													'type'  => 'hidden',
													'name'  => 'background-color',
													'id'    => 'background-color',
													'value' => $background_color
											));
										?>

                                        <div class="col-md-6 col-sm-6 col-xs-12">

                                            <?php
												// Color
												$this->color->view($background_color,'background-color',12);
											?>

                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <?php
											echo form_label('Sort Order <span class="required">*</span>','sort_order','class="control-label col-md-3 col-sm-3 col-xs-12"');
                      					?>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <?php
												// Input tag
												echo form_input(array(
													'id'       => 'sort_order',
													'name'     => 'sort_order',
													'required' => 'required',
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
                            <!-- Redirect -->

                            <!-- Button Group -->

                            <div class="col-md-12 col-sm-12 col-xs-12 ">
                                <div class="input-button-group">
                                    <?php
										// Submit Button
										if (empty($text_icon_id)) :
											$submit_value = 'Add';
										else :
											$submit_value = 'Update';
										endif;

										echo form_submit(
											array(
												'class' => 'btn btn-success',
											
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
											'text_icon/text_icon_index/'.$page_id,
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