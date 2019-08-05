<?php
	/**
	 * Testimonial View
	 *
	 * @category View
	 * @package  Add Edit Testimonial
	 * @author   Athi
	 * Created at:  14-Aug-2018
	 */
?>

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
                                'testimonial',
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
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
							<strong>Success!</strong>
							<?php echo $this->session->flashdata('success');?>
						</div>
						<?php endif; ?>

						<?php if ($this->session->flashdata('error') != '') : // Display session data ?>
						<div class="alert alert-warning alert-dismissible fade in text-center" id="warning-alert" role="alert">
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
                'testimonial/insert_update_testimonial',
                'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
              );

              // Input tag hidden
              echo form_input(array(
                'type'  => 'hidden',
                'name'  => 'testimonial_id',
                'id'    => 'testimonial_id',
                'value' => $testimonial_id
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
                                    echo heading('Choose Image', '2');
                                    $list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
                                    $attributes = array('class' => 'nav navbar-right panel_toolbox');
                                    echo ul($list,$attributes);
                                    ?>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    
                                    <div class="form-group">
              
                                        <?php
                                        // label
                                        echo form_label(
                                            'Image <span class="required">(Recommended 150x150)</span>',
                                            'imgInp',
                                            'class="control-label col-md-3 col-sm-3 col-xs-12"'
                                        );
                                        ?>
              
                                        <div class="img-thumbnail sepH_a" id="show_image1">
                                            <?php
                                            if ($image != '') :
              
												$testimonial_img = $ImageUrl . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR . $image;
												
                                                echo img(array(
                                                    'src'   => $testimonial_img,
                                                    'alt'   => $image_alt,
                                                    'title' => $image_title,
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
                                            'value' => $image
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
              
                                        <a data-toggle="modal" class="btn btn-primary" data-target="#ImagePopUp" href="javascript:;" type="button">
                                            Select Image
                                        </a>
              
                                        <?php if($image != "") :?>
                                            <a data-toggle="modal" class="btn btn-primary" id="imageRemove" data-target="#image-confirm-delete" href="javascript:;">
                                                Remove Image
                                            </a>
                                        <?php endif;?>
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
                                                    <iframe width="880" height="400" src="<?php echo $ImageUrl ;?>filemanager/dialog.php?type=1&field_id=image&rootfldr=<?php echo $website_folder_name?>/" frameborder="0" style="overflow: scroll; overflow-x: hidden; overflow-y: scroll; "></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
              
                                    <!-- Confirm Delete Modal -->
                                    <div class="modal fade" id="image-confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
              
                                                <div class="modal-header">
                                                    Confirm Delete
                                                </div>
              
                                                <div class="modal-body">
                                                    <p>You are about to delete this Image</p>
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
                                                    <a class="btn btn-danger" id="btn_ok">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
              
                                    <div class="form-group">
              
                                        <?php
                                        echo form_label('Image Title','image_title','class="control-label col-md-3 col-sm-3 col-xs-12"');
                                        ?>
              
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <?php
                                            // Input tag
                                            echo form_input(array(
                                                'id'       => 'image_title',
                                                'name'     => 'image_title',
                                                'class'    => 'form-control col-md-7 col-xs-12',
                                                'value'    => $image_title
                                            ));
                                            ?>
                                        </div>
              
                                    </div>
              
                                    <div class="form-group">
              
                                        <?php
                                        echo form_label('Image Alt','image_alt','class="control-label col-md-3 col-sm-3 col-xs-12"');
                                        ?>
              
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <?php
                                            // Input tag
                                            echo form_input(array(
                                                'id'       => 'image_alt',
                                                'name'     => 'image_alt',
                                                'class'    => 'form-control col-md-7 col-xs-12',
                                                'value'    => $image_alt
                                            ));
                                            ?>
                                        </div>
              
                                    </div>
                                    
                                    <div class="form-group">
              
                                        <?php
                                        echo form_label('Image Type','image_type','class="control-label col-md-3 col-sm-3 col-xs-12"');
                                        ?>
              
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                        
                                        	<?php


											$options = array(
												'testimonial-square' => 'Square',
												'testimonial-circle'	=> 'Circle'
											);

											$attributes = array(
												'name' => 'image_type',
												'id' => 'image_type',
												'class'	=> 'form-control col-md-7 col-xs-12'
											);

											echo form_dropdown($attributes, $options, $image_type);
											?>
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
										echo heading('Author & Contents', '2');
										$list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
										$attributes = array('class' => 'nav navbar-right panel_toolbox');
										echo ul($list,$attributes);
									?>
									<div class="clearfix"></div>
								</div>

								<div class="x_content">

									<div class="form-group">

										<?php
											echo form_label('Author','author');

											// Input tag
											echo form_input(array(
												'id'       => 'author',
												'name'     => 'author',												
												'class'    => 'form-control',
												'value'    => $author
											));
										?>

									</div>
                                    
                                    <div class="form-group">

										<?php
											echo form_label('Designation ','designation');

											// Input tag
											echo form_input(array(
												'id'       => 'designation',
												'name'     => 'designation',
												'class'    => 'form-control',
												'value'    => $designation
											));
										?>

									</div>

									<div class="form-group">

										<?php
											echo form_label('Content','text2');

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
										echo heading('Customize Author & Content', '2');
										$list = array(
											'<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>'
										);
										$attributes = array('class' => 'nav navbar-right panel_toolbox');
										echo ul($list,$attributes);
									?>
									<div class="clearfix"></div>
								</div>

								<div class="x_content">

									<div class="form-group">

										<?php

											echo form_label('Author Color','author_color');

											// Input tag hidden
											echo form_input(array(
													'type'  => 'hidden',
													'name'  => 'author_color',
													'id'    => 'author_color',
													'value' => $author_color
											));

											// Input tag
											$this->color->view($author_color, 'author_color', 1);
										?>

									</div>
                                    
                                    <div class="form-group">

										<?php

											echo form_label('Designation Color','designation_color');

											// Input tag hidden
											echo form_input(array(
													'type'  => 'hidden',
													'name'  => 'designation_color',
													'id'    => 'designation_color',
													'value' => $designation_color
											));

											// Input tag
											$this->color->view($designation_color, 'designation_color', 2);
										?>

									</div>

									<div class="form-group">

										<?php

											echo form_label('Content Title Color','content_title_color');

											// Input tag hidden
											echo form_input(array(
													'type'  => 'hidden',
													'name'  => 'content_title_color',
													'id'    => 'content_title_color',
													'value' => $content_title_color
											));

											// Color
											$this->color->view($content_title_color, 'content_title_color', 3);
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

											echo form_label('Content Color','content_color');

											// Input tag hidden
											echo form_input(array(
													'type'  => 'hidden',
													'name'  => 'content_color',
													'id'    => 'content_color',
													'value' => $content_color
											));

											// Color
											$this->color->view($content_color, 'content_color', 4);
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

						<!-- Redirect -->
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="x_panel">

								<div class="x_title">
									<?php
										echo heading('Redirect', '2');
										$list = array(
											// '<a title="Customize Options" data-toggle = "tooltip" data-placement	= "left" onclick="customize_testimonial()">
											// 	<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
											// </a>',
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
													'onchange' => 'redirectbtn()',
													'class'   => 'js-switch',
													'checked' => ($redirect === '1') ? TRUE : FALSE,
													'value'   => $redirect
												));
											?>
										</div>

								</div>

								<div id="redirect_url" style="display:<?php if($redirect == 1){echo 'block';}else{echo 'none';} ?>">

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

									<div id="testimonial_developer" style="display:none">
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
												$this->color->view($background_hover_color, 'background_hover', 5);
											?>
										</div>

									</div>

									<div class="form-group">
										<?php
											echo form_label(
												'Author Hover Color',
												'author_hover',
												'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);

											// Input tag hidden
											echo form_input(array(
												'type'  => 'hidden',
												'name'  => 'author_hover',
												'id'    => 'author_hover',
												'value' => $author_hover
											));
										?>

										<div class="col-md-6 col-sm-6 col-xs-12">
											<?php
												// Color
												$this->color->view($author_hover, 'author_hover', 6);
											?>
										</div>

									</div>
                                    
                                    <div class="form-group">
										<?php
											echo form_label(
												'Designation Hover Color',
												'designation_hover',
												'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);

											// Input tag hidden
											echo form_input(array(
												'type'  => 'hidden',
												'name'  => 'designation_hover',
												'id'    => 'designation_hover',
												'value' => $designation_hover
											));
										?>

										<div class="col-md-6 col-sm-6 col-xs-12">
											<?php
												// Color
												$this->color->view($designation_hover, 'designation_hover', 7);
											?>
										</div>

									</div>

									<div class="form-group">
										<?php
											echo form_label(
												'Content Title Hover Color',
												'content_title_hover_color',
												'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);

											// Input tag hidden
											echo form_input(array(
												'type'  => 'hidden',
												'name'  => 'content_title_hover_color',
												'id'    => 'content_title_hover_color',
												'value' => $content_title_hover_color
											));
										?>

										<div class="col-md-6 col-sm-6 col-xs-12">
											<?php
												// Color
												$this->color->view($content_title_hover_color, 'content_title_hover_color', 8);
											?>
										</div>

									</div>

									<div class="form-group">
										<?php
											echo form_label(
												'Content Hover Color',
												'content_hover_color',
												'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);

											// Input tag hidden
											echo form_input(array(
												'type'  => 'hidden',
												'name'  => 'content_hover_color',
												'id'    => 'content_hover_color',
												'value' => $content_hover_color
											));
										?>

										<div class="col-md-6 col-sm-6 col-xs-12">
											<?php
												// Color
												$this->color->view($content_hover_color, 'content_hover_color', 9);
											?>
										</div>

									</div>

									</div>

							</div>
						</div>
					</div>

					<!-- Sort Order & Background  -->
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="x_panel">

								<div class="x_title">
									<?php
										echo heading('Sort Order & Status', '2');
										$list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
										$attributes = array('class' => 'nav navbar-right panel_toolbox');
										echo ul($list,$attributes);
									?>
									<div class="clearfix"></div>
								</div>

								<div class="x_content">

									<div class="form-group">
										<?php
											echo form_label('Background Color','background_color','class="control-label col-md-3 col-sm-3 col-xs-12"');

											// Input tag hidden
											echo form_input(array(
												'type'  => 'hidden',
												'name'  => 'background_color',
												'id'    => 'background_color',
												'value' => $background_color
											));
										?>

										<div class="col-md-6 col-sm-6 col-xs-12">
											<?php
												// Color
												$this->color->view($background_color, 'background_color', 10);
											?>
										</div>
									</div>

									<div class="form-group">
										<?php
											echo form_label(
												'Sort Order <span class="required">*</span>',
												'sort_order',
												'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);
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
					</div>

					<!-- Button Group -->
					<div class="col-md-12 col-sm-12 col-xs-12 ">
						<div class="input-button-group">
							<?php
								// Submit Button
								if (empty($testimonial_id)) :
									$submit_value = 'Add';
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

								// Reset Button
								echo form_reset(
									array(
										'class' => 'btn btn-primary',
										'value' => 'Reset'
									)
								);

								// Anchor Tag
								echo anchor(
									'testimonial',
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
	<!-- /page content -->
