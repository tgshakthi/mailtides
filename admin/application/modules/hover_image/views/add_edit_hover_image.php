<?php
	/**
	 * Hover Image View
	 * @category View
	 * @package  Add Edit Hover Image
	 * @author   Velu Samy
	 * Created at:  05-Apr-2019
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
                                    'hover_image/hover_image_index/'.$page_id,
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
								'hover_image/insert_update_hover_image',
								'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
							);

							// Input tag hidden
							echo form_input(array(
								'type'  => 'hidden',
								'name'  => 'hover_image_id',
								'id'    => 'hover_image_id',
								'value' => $hover_image_id
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
										$list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
										$attributes = array('class' => 'nav navbar-right panel_toolbox');
										echo ul($list,$attributes);
									?>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="x_content">
									<!-- Primary Image-->
                                    <div class="form-group">

                                        <?php
											// label
											echo form_label(
												'Primary Image <span class="required">* Recommended size(700*500)</span>',
												'imgInp',
												'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);
										?>

                                        <div class="img-thumbnail sepH_a" id="show_image1">
                                            <?php
												if ($primary_image != '') :

													$primary_img = $ImageUrl . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR . $primary_image;

													echo img(array(
														'src'   => $primary_img,
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
												'name'  => 'primary_image',
												'id'    => 'image',
												'value' => $primary_image
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

									<!-- secondary Image -->
									<div class="form-group">

                                        <?php
											// label
											echo form_label(
												'Secondary Image <span class="required">* Recommended size(700*500)</span>',
												'imgInp',
												'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);
										?>

                                         <div class="img-thumbnail sepH_a" id="show_image1">
                                            <?php
												if ($secondary_image != '') :

													$secondary_img = $ImageUrl . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR . $secondary_image;

													echo img(array(
														'src'   => $secondary_img,
														'id'    => 'image_previews',
														'style' => 'width:168px; height:114px'
													));

												else :

													echo img(array(
														'src'   => $ImageUrl.'images/noimage.png',
														'alt'   => 'No Image',
														'id'    => 'image_previews',
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
													'id'    => 'image_previews2',
													'style' => 'width:168px; height:114px'
												));
											?>
                                        </div>

                                        <?php
											echo form_input(array(
												'type'  => 'hidden',
												'name'  => 'secondary_image',
												'id'    => 'image1',
												'value' => $secondary_image
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

                                        <a data-toggle="modal" class="btn btn-primary" data-target="#ImagePopUpsecond"
                                            href="javascript:;" type="button">
                                            Select Image
                                        </a>                                   
                                    </div> 
                                    <!-- FileManager -->
                                    <div class="modal fade" id="ImagePopUpsecond">
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
                                                        src="<?php echo $ImageUrl ;?>filemanager/dialog.php?type=1&field_id=image1&rootfldr=<?php echo $website_folder_name;?>/"
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
                        <div class="col-md-12 col-sm-12 col-xs-12">
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
                                 
                                    <div class="form-group col-md-12 col-sm-12 col-xs-12">

                                        <?php
											echo form_label('Title','text2');

											// TextArea
											$data = array(
													'name'        => 'content',
													'id'          => 'text',
													'value'       => $hover_image_title
												);
											echo form_textarea($data);
										?>

                                    </div>
									<div class="form-group col-md-12 col-sm-12 col-xs-12">
										<?php
											echo form_label(
												'Title Color',
												'title_color',
												'class="control-label "'
											);

											// Input tag hidden
											echo form_input(array(
												'type'  => 'hidden',
												'name'  => 'title_color',
												'id'    => 'title_color',
												'value' => $title_color
											));
										?>

										<div class="col-md-12 col-sm-12 col-xs-12">
											<?php
												// Color
												$this->color->view($title_color,'title_color',1);
											?>
										</div>

									</div>
									<div class="form-group col-md-12 col-sm-12 col-xs-12">
										<?php
											echo form_label(
												'Title Hover Color',
												'title_hover_color',
												'class="control-label "'
											);

											// Input tag hidden
											echo form_input(array(
												'type'  => 'hidden',
												'name'  => 'title_hover_color',
												'id'    => 'title_hover_color',
												'value' => $title_hover_color
											));
										?>

										<div class="col-md-12 col-sm-12 col-xs-12">
											<?php
												// Color
												$this->color->view($title_hover_color,'title_hover_color',2);
											?>
										</div>

									</div>
									<div class="form-group col-md-12 col-sm-12 col-xs-12">
										<?php
											echo form_label(
												'Title Background Color',
												'title_background_color',
												'class="control-label "'
											);

											// Input tag hidden
											echo form_input(array(
												'type'  => 'hidden',
												'name'  => 'title_background_color',
												'id'    => 'title_background_color',
												'value' => $title_background_color
											));
										?>

										<div class="col-md-12 col-sm-12 col-xs-12">
											<?php
												// Color
												$this->color->view($title_background_color,'title_background_color',3);
											?>
										</div>

									</div>
									<div class="form-group col-md-12 col-sm-12 col-xs-12">
										<?php
											echo form_label(
												'Title Background Hover Color',
												'title_bg_hover_color',
												'class="control-label "'
											);

											// Input tag hidden
											echo form_input(array(
												'type'  => 'hidden',
												'name'  => 'title_bg_hover_color',
												'id'    => 'title_bg_hover_color',
												'value' => $title_bg_hover_color
											));
										?>

										<div class="col-md-12 col-sm-12 col-xs-12">
											<?php
												// Color
												$this->color->view($title_bg_hover_color,'title_bg_hover_color',4);
											?>
										</div>

									</div>

                                </div>
                            </div>
                        </div>
                        <!-- Title & Image -->

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

                        <!-- Button Group -->
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="input-button-group">
                                <?php
									// Submit Button
									if (empty($hover_image_id)) :
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
										'hover_image/hover_image_index/'.$page_id,
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