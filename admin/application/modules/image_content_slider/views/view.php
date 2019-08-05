<!-- page content -->
<div class="right_col" role="main" id="datatable_content">
    <div class="">

        <div class="page-title">
            <div class="title_left">
                <?php echo heading($heading, '3');?>
            </div>
            <div class="btn_right" style="text-align:right;">
                <?php
					echo anchor(
						'page/page_details/'.$page_id,
						'<i class="fa fa-chevron-left" aria-hidden="true"></i> Back',
						array(
							'class' => 'btn btn-primary'
						)
					);
				?>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <?php if ($this->session->flashdata('success') != '') : // Display session data ?>
            <div class="alert alert-success alert-dismissible fade in text-center" id="success-alert" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">×</span>
                </button>
                <strong>Success!</strong>
                <?php echo $this->session->flashdata('success');?>
            </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('error') != '') : // Display session data ?>
            <div class="alert alert-warning alert-dismissible fade in text-center" id="warning-alert" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">×</span>
                </button>
                <strong><?php echo $this->session->flashdata('error');?></strong>
            </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-md-6 col-xs-12">
                    <div class="x_panel">

                        <div class="x_title">

                            <?php
							echo heading('Image Content Title', '2');

							$attributes = array('class' => 'nav navbar-right panel_toolbox');
							$list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
							echo ul($list,$attributes);
						?>

                            <div class="clearfix"></div>
                        </div>

                        <div class="x_content">

                            <?php
							// Break Tag
							echo br();

							// Form Tag
              echo form_open(
                'image_content_slider/insert_update_image_content_slider_title',
                'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
              );

			   			// Input tag hidden
              echo form_input(array(
                'type'  => 'hidden',
                'name'  => 'page_id',
                'id'    => 'page_id',
                'value' => $page_id
							));

							// Input tag hidden
              echo form_input(array(
                'type'  => 'hidden',
                'name'  => 'sort_id',
                'id'    => 'sort_id',
                'value' => $page_id
							));

							echo form_input(array(
									'type'  => 'hidden',
									'name'  => 'sort_url',
									'id'    => 'sort_url',
									'value' => base_url().'image_content_slider/update_sort_order'
							));

							// Website Id
							echo form_input(array(
								'type' => 'hidden',
								'name' => 'website_id',
								'id' => 'website_id',
								'value'=> $website_id
							));
						?>

                            <div class="form-group">
                                <?php
								echo form_label(
									'Title',
									'image_content_slider_title',
									'class="control-label col-md-3 col-sm-3 col-xs-12"'
								);
							?>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <?php
									// Input tag
									echo form_input(array(
										'id'       => 'image_content_slider_title',
										'name'     => 'image_content_slider_title',
										'class'    => 'form-control col-md-7 col-xs-12',
										'value'    => $image_content_slider_title
									));
								?>
                                    <span id="error_result"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <?php
								echo form_label(
										'Content',
										'text',
										'class="control-label col-md-3 col-sm-3 col-xs-12"'
										);
							?>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <?php
									// TextArea
									$data = array(
										'name'        => 'text',
										'id'          => 'text',
										'value'       => $image_content_slider_content
									);

									echo form_textarea($data);
								?>
                                </div>
                            </div>
                            <div class="form-group">
                                <?php
								echo form_label(
									'Status',
									'image_content_slider_status',
									'class="control-label col-md-3 col-sm-3 col-xs-12"'
								);
							?>

                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?php
									// Input checkbox
									echo form_checkbox(array(
										'id'      => 'image_content_slider_status',
										'name'    => 'image_content_slider_status',
										'class'   => 'js-switch',
										'checked' => ($image_content_slider_title_status === '1') ? TRUE : FALSE,
										'value'   => $image_content_slider_title_status
									));
								?>
                                </div>
                            </div>

                            <div class="ln_solid"></div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="input-button-group">
                                    <?php
									// Submit Button
									if (empty($image_content_slider_title_data)) :
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
								?>
                                </div>
                            </div>

                            <?php
							//Form close
							echo form_close();
						?>

                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xs-12">
                    <div class="x_panel">

                        <div class="x_title">

                            <?php
							echo heading('Customize Image Content Slider', '2');
							$list = array('<a title="Customize Redmore Button" data-toggle = "tooltip" data-placement	= "left" onclick="customize_image_content_button()"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>','<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
							$attributes = array('class' => 'nav navbar-right panel_toolbox');
							echo ul($list,$attributes);
						?>

                            <div class="clearfix"></div>
                        </div>

                        <div class="x_content">

                            <?php
							echo br();

							// Form Tag
              echo form_open(
                'image_content_slider/insert_image_content_slider_customize',
                'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
							);

							// Input tag hidden
              echo form_input(array(
                'type'  => 'hidden',
                'name'  => 'page_id',
                'id'    => 'page_id',
                'value' => $page_id
							));

							// Website Id
							echo form_input(array(
								'type' => 'hidden',
								'name' => 'website_id',
								'id' => 'website_id',
								'value'=> $website_id
							));
						?>

                            <div class="form-group">
                                <?php
								echo form_label(
									'Title Color',
									'title_color',
									'class="control-label col-md-3 col-sm-3 col-xs-12"'
								);

								// Input tag hidden
								echo form_input(array(
									'type'  => 'hidden',
									'name'  => 'title_color',
									'id'    => 'title_color',
									'value' => $title_color
								));
							?>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <?php
									// Input Tag
									$this->color->view($title_color,'title_color',1);
								?>
                                </div>
                            </div>

                            <div class="form-group">
                                <?php
								echo form_label(
									'Title Position',
									'title_position',
									'class="control-label col-md-3 col-sm-3 col-xs-12"'
								);
							?>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <?php
									$options = array(
										'left-align'	 => 'Left',
										'center-align' => 'Center',
										'right-align'	 => 'Right'
									);

									$attributes = array(
										'name'	=> 'title_position',
										'id'	=> 'title_position',
										'class'	=> 'form-control col-md-7 col-xs-12'
									);

									echo form_dropdown($attributes, $options, $title_position);
								?>
                                </div>
                            </div>
                            <div class="form-group">
                                <?php
								echo form_label(
									'Content Title Color',
									'content_title_color',
									'class="control-label col-md-3 col-sm-3 col-xs-12"'
								);

								// Input tag hidden
								echo form_input(array(
									'type'  => 'hidden',
									'name'  => 'content_title_color',
									'id'    => 'content_title_color',
									'value' => $content_title_color
								));
							?>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <?php
									// Input Tag
									$this->color->view($content_title_color, 'content_title_color', 2);
								?>
                                </div>
                            </div>

                            <div class="form-group">
                                <?php
								echo form_label(
									'Content Title Position',
									'content_title_position',
									'class="control-label col-md-3 col-sm-3 col-xs-12"'
								);
							?>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <?php
									$options = array(
										'left-align'	 => 'Left',
										'center-align' => 'Center',
										'right-align'	 => 'Right'
									);

									$attributes = array(
										'name'	=> 'content_title_position',
										'id'	=> 'content_title_position',
										'class'	=> 'form-control col-md-7 col-xs-12'
									);

									echo form_dropdown($attributes, $options, $content_title_position);
								?>
                                </div>
                            </div>
                            <div class="form-group">
                                <?php
								echo form_label(
									'Content Color',
									'content_color',
									'class="control-label col-md-3 col-sm-3 col-xs-12"'
								);

								// Input tag hidden
								echo form_input(array(
									'type'  => 'hidden',
									'name'  => 'content_color',
									'id'    => 'content_color',
									'value' => $content_color
								));
							?>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <?php
									// Input Tag
									$this->color->view($content_color, 'content_color', 3);
								?>
                                </div>
                            </div>

                            <div class="form-group">
                                <?php
								echo form_label(
									'Content Position',
									'content_position',
									'class="control-label col-md-3 col-sm-3 col-xs-12"'
								);
							?>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <?php
									$options = array(
										'left-align'	 => 'Left',
										'center-align' => 'Center',
										'right-align'	 => 'Right'
									);

									$attributes = array(
										'name'	=> 'content_position',
										'id'	=> 'content_position',
										'class'	=> 'form-control col-md-7 col-xs-12'
									);

									echo form_dropdown($attributes, $options, $content_position);
								?>
                                </div>
                            </div>
                            <div class="form-group">
                                <?php
								echo form_label(
									'Image Content Slider Position',
									'image_content_slider_position',
									'class="control-label col-md-3 col-sm-3 col-xs-12"'
								);
							?>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <?php
									$options = array(
										'left'	 => 'Left',
										'right'	 => 'Right'
									);

									$attributes = array(
										'name'	=> 'image_content_slider_position',
										'id'	=> 'image_content_slider_position',
										'class'	=> 'form-control col-md-7 col-xs-12'
									);

									echo form_dropdown($attributes, $options, $image_content_slider_position);
								?>
                                </div>
                            </div>
                            <div class="form-group">
                                <?php
								echo form_label(
									'Image Content Slider Per Row',
									'row_count',
									'class="control-label col-md-3 col-sm-3 col-xs-12"'
								);
							?>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <?php
									$options = array(
												'2'	=> '2',
												'3'	=> '3',
												'4'	=> '4',
											);

									$attributes = array(
										'name'	=> 'row_count',
										'id'	=> 'row_count',
										'class'	=> 'form-control col-md-7 col-xs-12'
									);

									echo form_dropdown($attributes, $options, $row_count);
								?>
                                </div>
                            </div>
                            <div class="form-group">
                                <?php
								echo form_label(
									'Background',
									'component-background',
									'class="control-label col-md-3 col-sm-3 col-xs-12"'
								);
							?>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <?php

									$options = array(
										'' => 'Select',
										'color'	 => 'Color',
										'image' => 'Image'
									);

									$attributes = array(
										'name'	=> 'component-background',
										'id'	=> 'component-background',
										'class'	=> 'form-control col-md-7 col-xs-12'
									);

									echo form_dropdown($attributes, $options, $component_background);			
									
								?>
                                </div>
                            </div>
                            <div class="form-group" id="component-bg-color"
                                <?php if ($component_background == 'color') :?> style="display:block;" <?php else : ?>
                                style="display:none;" <?php endif;?>>
                                <?php
								echo form_label(
									'Background Color',
									'image_content_background_color',
									'class="control-label col-md-3 col-sm-3 col-xs-12"'
								);

								// Input tag hidden
								echo form_input(array(
									'type'  => 'hidden',
									'name'  => 'image_content_background_color',
									'id'    => 'image_content_background_color',
									'value' => $image_content_background
								));
							?>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <?php									
									// Color
									$this->color->view($image_content_background,'image_content_background_color',4);
								?>
                                </div>
                            </div>
                            <div class="form-group" id="component-bg-image"
                                <?php if ($component_background == 'image') :?> style="display:block;" <?php else : ?>
                                style="display:none;" <?php endif;?>>

                                <?php

								if ($component_background == 'color') :
									$image_content_background = '';
								endif;

								// label
								echo form_label(
									'Image <span class="required">* Recommended size(1200*500)</span>',
									'imgInp',
									'class="control-label col-md-3 col-sm-3 col-xs-12"'
								);
							?>

                                <div class="img-thumbnail sepH_a" id="show_image1">
                                    <?php
									if ($image_content_background != '') :

										$image_content_bg = $ImageUrl . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR . $image_content_background;
										echo img(array(
												'src'   => $image_content_bg,
												'id'    => 'image_preview',
												'style' => 'width:168px; height:114px'
										));

									else :

										echo img(array(
											'src'   => $ImageUrl.'images/noimage.png',
											'alt'   => 'No Image',
											'id'    => 'image_preview',
											'style' => 'width:168px; height:114px'
										));

									endif;
								?>
                                </div>
                                <div style="display:none" class="img-thumbnail sepH_a" id="show_image2">
                                    <?php
									echo img(array(
										'src'   => $ImageUrl.'images/noimage.png',
										'alt'   => 'No Image',
										'id'    => 'image_preview2',
										'style' => 'width:168px; height:114px'
									));
								?>
                                </div>

                                <?php
								echo form_input(array(
									'type'  => 'hidden',
									'name'  => 'image',
									'id'    => 'image',
									'value' => $image_content_background
								));

								echo form_input(array(
									'type'  => 'hidden',
									'name'  => 'image_url',
									'id'    => 'image_url',
									'value' => $ImageUrl
								));

								echo form_input(array(
									'type'  => 'hidden',
									'name'  => 'httpUrl',
									'id'    => 'httpUrl',
									'value' => $httpUrl
								));
							?>

                                <a data-toggle="modal" class="btn btn-primary" data-target="#ImagePopUp"
                                    href="javascript:;" type="button">
                                    Select Image
                                </a>

                            </div>
                            <!-- FileManager -->
                            <div class="modal fade" id="ImagePopUp">
                                <div class="modal-dialog popup-width">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <?php
											echo form_button(array(
												'name'         => '',
												'type'         => 'button',
												'class'        => 'close',
												'data-dismiss' => 'modal',
												'aria-hidden'  => 'true',
												'content'      => '&times;'
											));
										?>
                                        </div>

                                        <div class="modal-body">
                                            <iframe width="880" height="400"
                                                src="<?php echo $ImageUrl ;?>filemanager/dialog.php?type=1&field_id=image&rootfldr=<?php echo $website_folder_name;?>/"
                                                frameborder="0"
                                                style="overflow: scroll; overflow-x: hidden; overflow-y: scroll; "></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group ">
                                <?php
										echo form_label(
											'Readmore Button',
											'readmore_btn',
											'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);
									?>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <?php
											// Input checkbox
											echo form_checkbox(array(
													'id'      => 'readmore_btn',
													'name'    => 'readmore_btn',
													'onchange' => 'readmorebtn()',
													'class'   => 'js-switch',
													'checked' => ($readmore_btn === '1') ? TRUE : FALSE,
													'value'   => $readmore_btn
												));
										?>
                                </div>
                            </div>
                            <div id="readmoreurl"
                                style="display:<?php if($readmore_btn == 1){echo 'block';}else{echo 'none';} ?>">

                                <div class="form-group">
                                    <?php
											echo form_label(
												'Button Type',
												'button_type',
												'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);
										?>

                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <?php
												$options = array(
													'btn'	=> 'Square',
													'btn oval'	=> 'Oval',
													'link'	=> 'Text Link'
												);

												$attributes = array(
													'name'	=> 'button_type',
													'id'	=> 'button_type',
													'class'	=> 'form-control col-md-7 col-xs-12'
												);

												echo form_dropdown($attributes, $options, $button_type);
											?>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <?php
											echo form_label(
												'Button Position',
												'button_position',
												'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);
										?>

                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <?php
												$options = array(
													'but_align_left'	=> 'Left',
													'but_align_center'	=> 'Center',
													'but_align_right'	=> 'Right'
												);

												$attributes = array(
													'name'	=> 'button_position',
													'id'	=> 'button_position',
													'class'	=> 'form-control col-md-7 col-xs-12'
												);

												echo form_dropdown($attributes, $options, $button_position);
											?>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <?php
											echo form_label(
												'Button Background Color',
												'btn_background_color',
												'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);

											// Input tag hidden
											echo form_input(array(
												'type'  => 'hidden',
												'name'  => 'btn_background_color',
												'id'    => 'btn_background_color',
												'value' => $btn_background_color
											));
										?>

                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <?php
												// Color
												$this->color->view($btn_background_color,'btn_background_color',13);
											?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <?php
											echo form_label(
												'Readmore Label',
												'readmore_label',
												'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);
										?>

                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <?php
												// Input tag
												echo form_input(array(
														'id'       => 'readmore_label',
														'name'     => 'readmore_label',
														'class'    => 'form-control col-md-7 col-xs-12',
														'value'    => $readmore_label
												));
											?>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <?php
											echo form_label(
												'Button Label Color',
												'readmore_label_color',
												'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);

											// Input tag hidden
											echo form_input(array(
												'type'  => 'hidden',
												'name'  => 'readmore_label_color',
												'id'    => 'readmore_label_color',
												'value' => $readmore_label_color
											));
										?>

                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <?php
												// Color
												$this->color->view($readmore_label_color,'readmore_label_color',14);
											?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <?php
											echo form_label(
												'Readmore URL <span class="required">*</span>',
												'readmore_url',
												'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);
										?>

                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <?php
												// Input tag
												echo form_input(array(
													'id'       => 'readmore_url',
													'name'     => 'readmore_url',
													'class'    => 'form-control col-md-7 col-xs-12',
													'value'    => $readmore_url
												));
											?>
                                        <span id="error_result"></span>
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <?php
											echo form_label(
												'Open New Tab',
												'open_new_tab',
												'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);
										?>

                                    <div class="col-md-9 col-sm-9 col-xs-12">
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
                            <div id="customize_image_content_button" style="display:none">
                                <?php echo br(1); ?>

                                <div class="x_title">
                                    <?php echo heading('Customize Readmore Button', '2'); ?>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="form-group">
                                    <?php
											echo form_label(
												'Button Background Hover',
												'btn_background_hover',
												'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);

											// Input tag hidden
											echo form_input(array(
												'type'  => 'hidden',
												'name'  => 'btn_background_hover',
												'id'    => 'btn_background_hover',
												'value' => $btn_background_hover
											));
										?>

                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <?php
												// Color
												$this->color->view($btn_background_hover,'btn_background_hover',15);
											?>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <?php
											echo form_label(
												'Button Label Hover',
												'btn_label_hover',
												'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);

											// Input tag hidden
											echo form_input(array(
												'type'  => 'hidden',
												'name'  => 'btn_label_hover',
												'id'    => 'btn_label_hover',
												'value' => $btn_label_hover
											));
										?>

                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <?php
												// Color
												$this->color->view($btn_label_hover,'btn_label_hover',16);
											?>
                                    </div>
                                </div>
                            </div>

                            <div class="ln_solid"></div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="input-button-group">
                                    <?php
												// Submit Button
												if (empty($image_content_slider_customize)) :
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
											?>
                                </div>
                            </div>

                            <?php
							//Form close
							echo form_close();
						?>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_content">

                        <?php
						echo form_open(
						'image_content_slider/delete_multiple_image_content_slider',
						'id="form_selected_record"'
						);
					?>

                        <div class="page_buut_right">

                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <?php

									echo form_input(array(
										'type'  => 'hidden',
											'name'  => 'page_id',
											'id'    => 'sort_id',
											'value' => $page_id
									));

									echo form_input(array(
										'type'  => 'hidden',
											'name'  => 'sort_url',
											'id'    => 'sort_url',
											'value' => base_url(). 'image_content_slider/update_sort_order'
									));

								echo form_button(array(
									'type'    => 'button',
									'id'	  => 'delete_selected_record',
									'name'    => 'delete-selected-menu',
									'class'   => 'btn btn-danger',
									'content' => '<i class="fa fa-trash-o" aria-hidden="true"></i> Delete'
								));

							?>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="text-align:right;">
                                <?php
                echo anchor(
                  'image_content_slider/add_edit_image_content_slider/'.$page_id,
                  '<i class="fa fa-plus" aria-hidden="true"></i> Add Image',
                  array(
                    'class' => 'btn btn-success'
                  )
                );
              ?>
                            </div>

                        </div>

                        <?php
  				// Table
              echo $table;

              echo form_close();
			    ?>
                    </div>

                    <!-- Confirm Delete Modal -->
                    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <div class="modal-header">
                                    Confirm Delete
                                </div>

                                <div class="modal-body">
                                    <p>Are you sure you want to delete this record?</p>
                                    <p>Do you want to proceed?</p>
                                </div>

                                <div class="modal-footer">
                                    <?php
                        echo form_button(array(
                        	'type'         => 'button',
                            'class'        => 'btn btn-default',
                            'data-dismiss' => 'modal',
                            'content'      => 'Cancel'
                      	));
                        ?>
                                    <a class="btn btn-danger" id="delete_btn_ok">Delete</a>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->