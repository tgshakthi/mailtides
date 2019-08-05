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
                        'gallery/gallery_index/'.$page_id,
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
                'gallery/insert_update_gallery',
                'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
              );

              // Input tag hidden
              echo form_input(array(
                'type'  => 'hidden',
                'name'  => 'gallery_id',
                'id'    => 'gallery_id',
                'value' => $gallery_id
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
											echo form_label(
												'Select Category <span class="required">*</span>',
												'category',
												'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);
										?>

										<div class="col-md-5 col-sm-5 col-xs-12">

											<?php
												// Select2 Dropdown
												$attributes = array(
													'name'	=> 'category',
													'required' => 'required',
													'id'	=> 'category',
													'class'	=> 'form-control col-md-7 col-xs-12'
												);

												echo form_dropdown($attributes, array(), '');

												// Input tag hidden
												echo form_input(array(
													'type'  => 'hidden',
													'name'  => 'category_id',
													'id'    => 'category_id',
													'value' => $category_id
												));
											?>

										</div>

										<div class="col-md-1 col-sm-1 col-xs-12">

											<?php
												// Add Category Button
												echo form_button(array(
													'title'      => 'Add Category',
													'type'       => 'button',
													'class'      => 'btn btn-success btn-add',
													'data-toggle' => 'modal',
													'data-target' => '#add_category',
													'content'    => '<span class="glyphicon glyphicon-plus"></span>'
												));
											?>

										</div>

									</div>

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
                              $image = $ImageUrl . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR . $image;
                                
                                echo img(array(
                                    'src'   => $image,
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
                          echo form_label('Image Title','image-title','class="control-label col-md-3 col-sm-3 col-xs-12"');
                          ?>

                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                              // Input tag
                              echo form_input(array(
                                'id'       => 'image-title',
                                'name'     => 'image-title',
                                'class'    => 'form-control col-md-7 col-xs-12',
                                'value'    => $image_title
                              ));
                            ?>
                          </div>

                        </div>

                    <div class="form-group">

                      <?php
                      echo form_label('Image Alt','image-alt','class="control-label col-md-3 col-sm-3 col-xs-12"');
                      ?>

                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php
                          // Input tag
                          echo form_input(array(
                            'id'       => 'image-alt',
                            'name'     => 'image-alt',
                            'class'    => 'form-control col-md-7 col-xs-12',
                            'value'    => $image_alt
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
         	</div>

              <!-- Button Group -->

              <div class="col-md-12 col-sm-12 col-xs-12 ">
               <div class="input-button-group">
                  <?php

                    // Submit Button
                    if (empty($gallery_id)) :
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
                      'gallery/gallery_index/'.$page_id,
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

							<?php
								echo form_open(
									'gallery/insert_update_gallery_category',
									'id="form_selected_record"'
								);
							?>

							<!-- Add Category Modal -->
							<div class="modal fade" id="add_category" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
											echo heading('Add Category', 4, 'class="modal-title"');
											?>
										</div>

										<div class="modal-body">
											<?php
											// Input tag Website ID
											echo form_input(array(
												'type'  => 'hidden',
												'name'  => 'website_id',
												'id'    => 'website_id',
												'value' => $website_id
											));

											echo form_input(array(
												'type'  => 'hidden',
												'name'  => 'base_url',
												'id'    => 'base_url',
												'value' => base_url()
											));

											// Input tag hidden
											echo form_input(array(
												'type'  => 'hidden',
												'name'  => 'gallery_id',
												'id'    => 'gallery_id',
												'value' => $gallery_id
											));

											 // Input tag hidden
											echo form_input(array(
												'type'  => 'hidden',
												'name'  => 'page-id',
												'id'    => 'page-id',
												'value' => $page_id
											));

											echo form_input(array(
												'type' => 'hidden',
												'name' => 'quick_category',
												'value' => '1'
											));
											?>

											<div class="form-group">
												<?php
													echo form_label(
														'Category Name',
														'category_name',
														'class="control-label col-md-3 col-sm-3 col-xs-12"'
													);
												?>

												<div class="col-md-6 col-sm-6 col-xs-12">
													<?php
														// Input tag
														echo form_input(array(
															'id'       => 'category_name',
															'name'     => 'category_name',
															'required' => 'required',
															'class'    => 'form-control col-md-7 col-xs-12'
														));
													?>
												</div>
												<span id="error"></span>
											</div>

											<?php echo br(2); ?>

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
																	'class'    => 'form-control col-md-7 col-xs-12'
															));
														?>
												</div>
										</div>

										<?php echo br(2); ?>

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
																'class'   => 'js-switch'
														));
													?>
											</div>
										</div>


										</div>

										<?php echo br(1); ?>

										<div class="modal-footer">
											<?php
											echo form_button(array(
												'type'         => 'button',
												'id'		   		 => 'closemodel',
												'class'        => 'btn btn-default',
												'data-dismiss' => 'modal',
												'content'      => 'Close'
											));

											// Form Submit
											echo form_submit(
												array(
												'class' 		=> 'btn btn-success',
												'value' 		=> 'Save'
												)
											);
											?>
										</div>

									</div>
								</div>
							</div>

							<?php
								// Form Close
								echo form_close();
							?>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<!-- /page content -->
