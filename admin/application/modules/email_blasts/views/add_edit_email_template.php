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
								'email_blasts/insert_update_email_template',
								'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
							);

							// Input tag hidden
							echo form_input(array(
								'type'  => 'hidden',
								'name'  => 'id',
								'id'    => 'id',
								'value' => $id
							));

						
						?>

                        <!-- <div class="col-md-6 offset-md-3"> -->
						<div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">

                                    <?php
										echo heading('Template & Status', '2');
										$list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
										$attributes = array('class' => 'nav navbar-right panel_toolbox');
										echo ul($list,$attributes);
									?>

                                    <div class="clearfix"></div>
                                </div>

                                <div class="x_content">

                                    <div class="form-group  ">
                                        <?php
											echo form_label('Template Name','template_name','class="control-label col-md-3 col-sm-3 col-xs-12"');
                                        ?>
										<div class="col-md-6 col-sm-6 col-xs-12">
										<?php
											// Input tag
											echo form_input(array(
											'id'       => 'template_name',
											'name'     => 'template_name',
											'class'    => 'form-control col-md-7 col-xs-12',
											'value'    => $template_name
											));
										?>
										</div>
                                    </div>

                                    <div class="form-group  ">
                                        <?php
											echo form_label('Template <span class="required">*</span>','template','class="control-label col-md-3 col-sm-3 col-xs-12"');
                                        ?>
										<div class="col-md-6 col-sm-6 col-xs-12">
										<?php
											// TextArea
											$data = array(
											'name'        => 'template',
											'id'          => 'template',
											'class'       => 'form-control',
											'value'       => $template
											);

											echo form_textarea($data);
										?>
                                    </div>
									</div>
									 <div class="form-group">

												<?php

                            // label
                                echo form_label(
                            'Image',
                            'imgInp',
                            'class="control-label col-md-3 col-sm-3 col-xs-12"'
                             );
                            ?>

                           <div class="img-thumbnail sepH_a" id="show_image1">
                            <?php
                            if ($image != '') :
                              $image = $ImageUrl . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR . $image;
                                
                                echo img(array(
                                    'src'   => $image,
                                    'alt'   => $image,
                                    'title' => $image,
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
                          <a data-toggle="modal" class="btn btn-primary" id="imageRemove" data-target="#confirm-delete" href="javascript:;">
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
                    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
											echo form_label(
												'Status',
												'status',
												'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);
										?>

                                        <div class="col-md-6 col-sm-6 col-xs-12 center-align">
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
									if (empty($id)) :
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
										'email_blasts/email_template',
										'Back',
										array(
											'title' => 'Back',
											'class' => 'btn btn-primary'
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