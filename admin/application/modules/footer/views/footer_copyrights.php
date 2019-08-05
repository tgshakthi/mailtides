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
                                                 'footer',
                                                 '<i class="fa fa-chevron-left" aria-hidden="true"></i> Back',
                                                  array(
                                                     'class' => 'btn btn-primary'
                                                 ));
                                ?>
                             </div>
                            <div class="clearfix"></div>
                             </div>

                    <div class="x_content">

                        <?php if ($this->session->flashdata('success')!='') : // Display session data ?>
                            <div class="alert alert-success alert-dismissible fade in text-center" id="success-alert" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                                </button>
                                <strong>Success!</strong>
                                <?php echo $this->session->flashdata('success');?>
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
                                                                    'footer/copyrights/insert_update_copyrights',
                                                                     'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
                                                                      );

			                                          // Input tag hidden
                                             echo form_input(array(
                                                               'type'  => 'hidden',
                                                               'name'  => 'website_id',
                                                               'id'    => 'website_id',
                                                               'value' => $website_id
                                                            ));
                                          ?>

                     <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="x_panel">
                          <div class="x_title">
                                     <?php
										                     echo heading('Copyrights', '2');
										                         $list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
										                         $attributes = array('class' => 'nav navbar-right panel_toolbox');
										                      echo ul($list,$attributes);
									                    ?>
                              <div class="clearfix">
                              </div>
                            </div>  
                          <div class="x_content">
                              <div class="form-group">
                                         <?php
						                               echo form_label('Copyrights <span class="required">*</span>','full-text');

						                               // TextArea
						                                $data = array(
							                                          'name'        => 'copyrights_content',
							                                          'id'          => 'text',
							                                          'value'       => $copyrights_content
                                                        );
                                            echo form_textarea($data);
						                                ?>
                               </div>
                              </div>
                          </div>
                         </div>

                         <!-- Customization -->
						<div class="col-md-6 col-sm-12 col-xs-12">
							<div class="x_panel">

								<div class="x_title">
									<?php
										echo heading('Color Customization', '2');
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

                  <div class="form-group">

                                  <?php

                                        echo form_label('Content Color','copyrights_text_color');

                                              // Input tag hidden
                                           echo form_input(array(
                                                                 'type'  => 'hidden',
                                                                 'name'  => 'copyrights_text_color',
                                                                  'id'    => 'copyrights_text_color',
                                                                  'value' => $copyrights_text_color
                                                          ));

                                                // Color
                                          $this->color->view($copyrights_text_color, 'copyrights_text_color', 2);
                                  ?>

                     </div>

										<?php

											echo form_label('Background Color','copyrights_bg_color');

											// Input tag hidden
											echo form_input(array(
													'type'  => 'hidden',
													'name'  => 'copyrights_bg_color',
													'id'    => 'copyrights_bg_color',
													'value' => $copyrights_bg_color
											));

											// Color
											$this->color->view($copyrights_bg_color,'copyrights_bg_color',1);
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
										$list = array(
											'<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>'
										);
										$attributes = array('class' => 'nav navbar-right panel_toolbox');
										echo ul($list,$attributes);
									?>
									<div class="clearfix"></div>
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
                          'id'      => 'copyright_status',
                          'name'    => 'copyright_status',
                          'class'   => 'js-switch',
                          'checked' => ($copyright_status === '1') ? TRUE : FALSE,
                          'value'   => $copyright_status
												));
											?>
										</div>
									</div>
								

							</div>
					</div>


              <!-- Button Group -->

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="input-button-group">
                            <?php
				      // Submit Button
                    if (empty($copyrights_details)) :
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
                      'footer',
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