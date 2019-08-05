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
                                'page/page_details/'.$page_id,
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
								'blog/insert_update_blog_page',
								'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
							);

							// Input tag hidden
							echo form_input(array(
								'type'  => 'hidden',
								'name'  => 'blog_id',
								'id'    => 'blog_id',
								'value' => $blog_id
							));

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
								'name'  => 'website_id',
								'id'    => 'website_id',
								'value' => $website_id
							));
            			?>

                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="x_panel">
                                <div class="x_content">

                                    <div class="form-group">

                                        <?php
											echo form_label('Title', 'title');

											// Input tag
											echo form_input(array(
												'id'       => 'title',
												'name'     => 'title',
												'class'    => 'form-control',
												'value'    => $blog_title
											));
										?>

                                    </div>

                                    <div class="form-group">

                                        <?php
											echo form_label('Title Color', 'title_color');

											// Input tag hidden
											echo form_input(array(
													'type'  => 'hidden',
													'name'  => 'title_color',
													'id'    => 'title_color',
													'value' => $title_color
											));

											// Input tag
											$this->color->view($title_color, 'title_color', 1);
                                        ?>

                                    </div>

                                    <div class="form-group">

                                        <?php
											echo form_label('Title Position', 'title_position');

											$options = array(
												'left-align'	=> 'Left',
												'center-align'	=> 'Center',
												'right-align'	=> 'Right'
											);

											$attributes = array(
												'name'	=> 'title_position',
												'id'	=> 'title_position',
												'class'	=> 'form-control'
											);

											echo form_dropdown($attributes, $options, $title_position);
                                        ?>

                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="x_panel">
                                <div class="x_content">

                                    <div class="form-group">

                                        <?php 
											echo form_label(
												'Blog Per Row', 
												'blog_per_row',
												'class="control-label col-md-3 col-sm-3 col-xs-12"'
											); 
										?>

                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <?php
												$options = array(
													'l4 '	=> '1',
													'l6'	=> '2',
													'l4'	=> '3'											
												);

												$attributes = array(
													'name'	=> 'blog_per_row',
													'id'	=> 'blog_per_row',
													'class'	=> 'form-control col-md-7 col-xs-12'
												);

												echo form_dropdown($attributes, $options, $blog_per_row);
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
                                        <?php if ($component_background == 'color') :?> style="display:block;"
                                        <?php else : ?> style="display:none;" <?php endif;?>>
                                        <?php
											echo form_label(
												'Background Color',
												'blog_background_color',
												'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);

											// Input tag hidden
											echo form_input(array(
												'type'  => 'hidden',
												'name'  => 'blog_background_color',
												'id'    => 'blog_background_color',
												'value' => $blog_background
											));
										?>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <?php									
												// Color
												$this->color->view($blog_background,'blog_background_color',4);
											?>
                                        </div>
                                    </div>

                                    <div class="form-group" id="component-bg-image"
                                        <?php if ($component_background == 'image') :?> style="display:block;"
                                        <?php else : ?> style="display:none;" <?php endif;?>>

                                        <?php

											if ($component_background == 'color') :
												$blog_background = '';
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
												if ($blog_background != '') :

													$blog_bg_img = $ImageUrl . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR . $blog_background;
													echo img(array(
															'src'   => $blog_bg_img,
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
												'value' => $blog_background
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

                                    <div class="form-group">
                                        <?php
											echo form_label(
												'Status',
												'status',
												'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);
										?>

                                        <div class="col-md-9 col-sm-9 col-xs-12">
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
                                	echo heading('Blogs', '2');
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
											'Show Blog ',
											'show_blog',
											'class="control-label col-md-3 col-sm-3 col-xs-12"'
										);
										?>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <?php
												$options = array(
													''	 => 'None',
													'blog'	 => 'Blogs without Category',
													'blog_category' => 'Blog with Category'
												);

												$attributes = array(
													'name' => 'show_blog',
													'id' => 'show_blog',
													'class' => 'form-control col-md-7 col-xs-12'
												);

												echo form_dropdown($attributes, $options, $show_blog);
                        					?>
                                        </div>

                                    </div>

                                    <div id="blog_nestable" class="cf nestable-lists"
                                        style="display:<?php echo ($show_blog == 'blog') ? 'block': 'none'; ?>">
                                        <div class="dd" id="nestable">
                                            <h3 class="heading">Blog List</h3>
                                            <?php
												if (!empty($blogs_unselected)) :

													echo '<ol class="dd-list">';

													foreach ($blogs_unselected as $blog_unselected) :

														echo '<li class="dd-item" data-id="'.$blog_unselected->id.'">
																<div class="dd-handle">
																	'.$blog_unselected->name.' - '.$blog_unselected->title.'
																</div>
															</li>';

													endforeach;

														echo '</ol>';

												else :

													echo '<div class="dd-empty"></div>';

												endif;
                                          	?>
                                        </div>
                                        <div class="dd" id="nestable2">
                                            <h3 class="heading">Blog Page</h3>
                                            <?php
												if (!empty($blogs_selected)) :

													echo '<ol class="dd-list">';

													foreach ($blogs_selected as $blog_selected) :

														echo '<li class="dd-item" data-id="'.$blog_selected->id.'">
																<div class="dd-handle">
																	'.$blog_selected->name.' - '.$blog_selected->title.'
																</div>
															</li>';

													endforeach;

														echo '</ol>';

												else :

													echo '<div class="dd-empty"></div>';

												endif;
                                          	?>
                                        </div>
                                    </div>

                                    <div id="blog_category_nestable" class="cf nestable-lists"
                                        style="display:<?php echo ($show_blog == 'blog_category') ? 'block': 'none'; ?>">
                                        <div class="dd" id="nestable_category">
                                            <h3 class="heading">Blog Category List</h3>
                                            <?php
												if (!empty($blog_categories_unselected)) :

													echo '<ol class="dd-list">';

													foreach ($blog_categories_unselected as $blog_category_unselected) :

														echo '<li class="dd-item" data-id="'.$blog_category_unselected->id.'">
																<div class="dd-handle">
																	'.$blog_category_unselected->name.'
																</div>
															</li>';

													endforeach;

													echo '</ol>';

												else :

													echo '<div class="dd-empty"></div>';

												endif;
                                          	?>
                                        </div>
                                        <div class="dd" id="nestable_category2">
                                            <h3 class="heading">Blog Category Page</h3>
                                            <?php
												if (!empty($blog_categories_selected)) :

													echo '<ol class="dd-list">';

													foreach ($blog_categories_selected as $blog_category_selected) :

														echo '<li class="dd-item" data-id="'.$blog_category_selected->id.'">
																<div class="dd-handle">
																	'.$blog_category_selected->name.'
																</div>
															</li>';

													endforeach;

														echo '</ol>';

												else :

													echo '<div class="dd-empty"></div>';

												endif;
                                          	?>
                                        </div>
                                    </div>

                                    <?php
										echo form_textarea(array(
											'name'  => 'output_data',
											'id'    => 'nestable-output',
											'style' => 'display:none'
										));

										echo form_textarea(array(
											'name'  => 'output_update',
											'id'    => 'nestable2-output',
											'style' => 'display:none'
										));

										echo form_textarea(array(
											'name'  => 'output_category_data',
											'id'    => 'nestable_category-output',
											'style' => 'display:none'
										));

										echo form_textarea(array(
											'name'  => 'output_category_update',
											'id'    => 'nestable_category2-output',
											'style' => 'display:none'
										));
                                  	?>

                                </div>
                            </div>
                        </div>

                        <!-- Button Group -->
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="input-button-group">
                                <?php
									// Submit Button
									if (empty($blog_id)) :
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
									
									// Anchor Tag
									echo anchor(
										'page/page_details/'.$page_id,
										'Back',
										array(
											'title' => 'Back ',
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