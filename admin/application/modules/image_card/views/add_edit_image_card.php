<?php
	/**
	 * Image Card View
	 *
	 * @category View
	 * @package  Add Edit Image Card
	 * @author   Saravana
	 * Created at:  27-Jun-2018
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
                        <div class="btn_right" style="text-align:right;">
                            <?php
                                echo anchor(
                                    'image_card/image_card_index/'.$page_id,
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
                'image_card/insert_update_image_card',
                'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
              );

              // Input tag hidden
              echo form_input(array(
                'type'  => 'hidden',
                'name'  => 'image_card_id',
                'id'    => 'image_card_id',
                'value' => $image_card_id
              ));

			   			// Input tag hidden
              echo form_input(array(
                'type'  => 'hidden',
                'name'  => 'page_id',
                'id'    => 'page_id',
                'value' => $page_id
              ));
            ?>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">

                                <div class="x_title">
                                    <?php
										echo heading('Image Card', '2');
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
											// label
											echo form_label(
												'Image <span class="required">* Recommended (700*497)</span>',
												'imgInp',
												'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);
										?>

                                        <div class="img-thumbnail sepH_a" id="show_image1">
                                            <?php
												if ($image != '') :

													$image_card_img = $ImageUrl . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR . $image;

													echo img(array(
															'src'   => $image_card_img,
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

                                        <a data-toggle="modal" class="btn btn-primary" data-target="#ImagePopUp"
                                            href="javascript:;" type="button">
                                            Select Image
                                        </a>

                                        <?php if($image != "") :?>
                                        <a data-toggle="modal" class="btn btn-primary" id="imageRemove"
                                            data-target="#confirm-delete" href="javascript:;">
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
                                                    <iframe width="880" height="400"
                                                        src="<?php echo $ImageUrl ;?>filemanager/dialog.php?type=1&field_id=image&rootfldr=<?php echo $website_folder_name;?>/"
                                                        frameborder="0"
                                                        style="overflow: scroll; overflow-x: hidden; overflow-y: scroll; "></iframe>
                                                </div>
                                            </div>
                                        </div>
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

                                </div>

                            </div>
                        </div>

                        <!-- Title & Content -->
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="x_panel">

                                <div class="x_title">
                                    <?php
										echo heading('Title & Contents', '2');
										$list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
										$attributes = array('class' => 'nav navbar-right panel_toolbox');
										echo ul($list,$attributes);
									?>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="x_content">

                                    <div class="form-group">

                                        <?php
											echo form_label('Title','text3');

											$data = array(
												'name'        => 'title',
												'id'          => 'text3',
												'value'       => $image_card_title
											);
											echo form_textarea($data);
										?>

                                    </div>

                                <div class="form-group">

                                        <?php
											echo form_label('Description','text2');

											// TextArea
											$data = array(
												'name'        => 'long_desc',
												'id'          => 'text2',
												'value'       => $description
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
										echo heading('Customize Title & Contents', '2');
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

											echo form_label('Title Color','title_color');

											// Input tag hidden
											echo form_input(array(
													'type'  => 'hidden',
													'name'  => 'title_color',
													'id'    => 'title_color',
													'value' => $title_color
											));

											// Input tag
											if(!empty($title_color)):
												$this->color->view($title_color,'title_color',1);
											else:
												$this->color->view('black-text','title_color',1);
											endif;
											
										?>

                                    </div>



                                    <div class="form-group">

                                        <?php

											echo form_label('Description Title Color','desc_title_color');

											// Input tag hidden
											echo form_input(array(
													'type'  => 'hidden',
													'name'  => 'desc_title_color',
													'id'    => 'desc_title_color',
													'value' => $desc_title_color
											));

											// Color
											if(!empty($desc_title_color)):
												$this->color->view($desc_title_color,'desc_title_color',2);
											else:
												$this->color->view('black-text','desc_title_color',2);
											endif;
											
										?>

                                    </div>

                                    <div class="form-group">

                                        <?php

											echo form_label('Description Title Position','desc_title_position');

											$options = array(
												'left-align'	=> 'Left',
												'center-align'	=> 'Center',
												'right-align'	=> 'Right',
											);

											$attributes = array(
												'name' => 'desc_title_position',
												'id' => 'desc_title_position',
												'class'	=> 'form-control'
											);

											echo form_dropdown($attributes, $options, $desc_title_position);
										?>

                                    </div>

                                    <div class="form-group">

                                        <?php

											echo form_label('Description Color','desc_color');

											// Input tag hidden
											echo form_input(array(
													'type'  => 'hidden',
													'name'  => 'desc_color',
													'id'    => 'desc_color',
													'value' => $desc_color
											));

											// Color
											if(!empty($desc_color)):
												$this->color->view($desc_color,'desc_color',3);
											else:
												$this->color->view('black-text','desc_color',3);
											endif;
											
										?>

                                    </div>

                                    <div class="form-group">

                                        <?php

											echo form_label('Description Position','desc_position');

											$options = array(
												'left-align'	=> 'Left',
												'center-align'	=> 'Center',
												'justify-align' => 'Justify',
												'right-align'	=> 'Right',
											);

											$attributes = array(
												'name' => 'desc_position',
												'id' => 'desc_position',
												'class'	=> 'form-control'
											);

											echo form_dropdown($attributes, $options, $desc_position);
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
										$list = array('<a title="Customize Redmore Button" data-toggle = "tooltip" data-placement	= "left" onclick="customize_image_card_button()"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>','<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
										$attributes = array('class' => 'nav navbar-right panel_toolbox');
										echo ul($list,$attributes);
									?>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="x_content">
                                    <div class="form-group ">
                                        <?php
											echo form_label(
												'Readmore Button',
												'readmore_btn',
												'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);
										?>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
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

                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?php
												$options = array(
													'square'	=> 'Square',
													'oval'	=> 'Oval'
													
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

                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?php
												// Color
												if(!empty($btn_background_color)):
													$this->color->view($btn_background_color,'btn_background_color',8);
												else:
													$this->color->view('white','btn_background_color',8);
												endif;
											
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

                                            <div class="col-md-6 col-sm-6 col-xs-12">
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

                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?php
												// Color
												if(!empty($readmore_label_color)):
													$this->color->view($readmore_label_color,'readmore_label_color',9);
												else:
													$this->color->view('black-text','readmore_label_color',9);
												endif;
												
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

                                            <div class="col-md-6 col-sm-6 col-xs-12">
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

                                    <div id="customize_image_card_button" style="display:none">
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

                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?php
												// Color
												if(!empty($btn_background_hover)):
													$this->color->view($btn_background_hover,'btn_background_hover',10);
												else:
													$this->color->view('white','btn_background_hover',10);
												endif;
												
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
												'value' => $btn_label_hover_color
											));
										?>

                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?php
												// Color
												if(!empty($btn_label_hover_color)):
													$this->color->view($btn_label_hover_color,'btn_label_hover',11);
												else:
													$this->color->view('black-text','btn_label_hover',11);	
												endif;
											
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

                    </div>
             	</div>

         	</div>

												<!-- Button Group -->
												<div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="input-button-group">
                                <?php
								// Submit Button
								if (empty($image_card_id)) :
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

								// Anchor Tag
								echo anchor(
									'image_card/image_card_index/'.$page_id,
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

             	</div>
         	</div>

                        <?php echo form_close(); //Form close ?>

                    </div>
                </div>
            </div>
		</div>
		</div>
         	</div>
                       
             	</div>
         	</div>
        <!-- /page content -->