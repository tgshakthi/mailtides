<?php
	/**
	 * Our Service View
	 *
	 * @category View
	 * @package  Add Edit Our Service
	 * @author   Saravana
	 * Created at:  27-Oct-2018
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
                                    'our_service/our_service_index/'.$page_id,
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
								'our_service/insert_update_our_service',
								'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
							);

							// Input tag hidden
							echo form_input(array(
								'type'  => 'hidden',
								'name'  => 'our_service_id',
								'id'    => 'our_service_id',
								'value' => $our_service_id
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
										echo heading('Image', '2');
										$list = array(
											'<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>'
										);
										$attributes = array('class' => 'nav navbar-right panel_toolbox');
										echo ul($list, $attributes);
									?>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="x_content">

                                    <div class="form-group">

                                        <?php
											// label
											echo form_label(
												'Image <span class="required"> Recommended size(597*497)</span>',
												'imgInp',
												'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);
										?>

                                        <div class="img-thumbnail sepH_a" id="show_image1">
                                            <?php
												if ($image != '') :

													$our_service_img = $ImageUrl . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR . $image;
													
													echo img(array(
														'src'   => $our_service_img,
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
                                        <div>

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

                                        </div>

                                    </div>
                                </div>

                                <!-- Title & Content -->
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="x_panel">

                                        <div class="x_title">
                                            <?php
												echo heading('Title', '2');
												$list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
												$attributes = array('class' => 'nav navbar-right panel_toolbox');
												echo ul($list,$attributes);
											?>
                                            <div class="clearfix"></div>
                                        </div>

                                        <div class="x_content">

                                            <div class="form-group">

                                                <?php
													echo form_label('Title <span class="required"> ( 15 Characters Only ) </span>','title');

													// Input tag
													echo form_input(array(
														'id'       => 'title',
														'name'     => 'title',
														'class'    => 'form-control',
														'value'    => $our_service_title,
														'data-parsley-trigger' => 'keyup',
														'data-parsley-maxlength' => '15' 
													));
												?>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!-- Title -->

                                <!-- Customize Title -->
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="x_panel">

                                        <div class="x_title">
                                            <?php
												echo heading('Customize Title', '2');
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
													$this->color->view($title_color,'title_color',1);
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
													'<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>'
												);
												$attributes = array('class' => 'nav navbar-right panel_toolbox');
												echo ul($list, $attributes);
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
												echo ul($list, $attributes);
											?>
                                            <div class="clearfix"></div>
                                        </div>

                                        <div class="x_content">

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
											if (empty($our_service_id)) :
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
												'our_service/our_service_index/'.$page_id,
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
                <!-- /page content -->