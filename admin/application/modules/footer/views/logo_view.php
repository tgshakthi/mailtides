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
                'footer/Logo/insert_update_logo',
                'class ="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
              );

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
				  echo heading('Choose Logo ', '2');
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
												'Logo',
												'imgInp',
												'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);
										?>

										<div class="img-thumbnail sepH_a" id="show_image1">
											<?php
												if ($footer_logo_image != '') :

													$footer_logo = $ImageUrl . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR . $footer_logo_image;
													echo img(array(
														'src'   => $footer_logo,
														'alt'   => $website_name,
														'title' => $website_name,
														'id'    => 'image_preview',
														'style' => 'width:168px; height:114px'
													));

												else :

													echo img(array(
														'src'   => $ImageUrl.'images/no-logo.png',
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
													'src'   => $ImageUrl.'images/no-logo.png',
													'alt'   => 'No Logo',
													'id'    => 'image_preview2',
													'style' => 'width:168px; height:114px'
												));
											?>
										</div>

										<?php
											echo form_input(array(
												'type'  => 'hidden',
												'name'  => 'logo',
												'id'    => 'logo',
												'value' => $footer_logo_image
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
											Select Logo
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
													<iframe id="iframe-filemanager-logo" width="880" height="400" src="<?php echo $ImageUrl ;?>filemanager/dialog.php?type=1&field_id=logo&rootfldr=<?php echo $website_folder_name;?>/logo/" frameborder="0" style="overflow: scroll; overflow-x: hidden; overflow-y: scroll; "></iframe>
												</div>
											</div>
										</div>
										</div>

								
										</div>

				  <div class="form-group">
					  <?php
						  echo form_label(
								  'Logo Size',
								  'logo-size',
								  'class="control-label col-md-3 col-sm-3 col-xs-12"'
								  );
						 ?>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<?php
						  $options = array(
								'footer-logo-length-15'	=> '15 %',
								'footer-logo-length-20'	=> '20 %',
								'footer-logo-length-25'	=> '25 %',
								'footer-logo-length-30'	=> '30 %'
												);

						  $attributes = array(
							  'name' => 'logo-size',
							  'id' => 'logo-size',
							  'class'	=> 'form-control'
						  );

						  echo form_dropdown($attributes, $options,$footer_logo_size);
                      ?>
					 </div>
                  </div>
					

					  <div class="form-group">
						<?php
                         // Input tag hidden
						echo form_input(array(
                            'type'  => 'hidden',
                            'name'  => 'website_id',
                            'id'    => 'website_id',
                            'value' => $website_id
                        ));
                        ?>
					</div>

				<!--	<div class="form-group">
						<?php
                         // Input tag hidden

						echo form_input(array(
                            'type'  => 'hidden',
                            'name'  => 'website_settings_id',
                            'id'    => 'website_settings_id',
                            'value' => $website_settings_id
                        ));
                        ?>
					</div> -->
					<div class="form-group">
						<?php
							echo form_label(
								'Footer Logo Status',
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
									'checked' => ($footer_logo_status === '1') ? TRUE : FALSE,
									'value'   => $footer_logo_status
								));
							?>
						</div>
					</div>


                </div>
              </div>
            </div>
	
            <!-- <div class="ln_solid"></div> -->

              <!-- Button Group -->


							<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="input-button-group">
                  <?php

                    // Submit Button
                    if (empty($website_id)) :
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
