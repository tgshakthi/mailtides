<div class="right_col" role="main">
	
	<div class="">

		<div class="page-title">
			<div class="title_left">
				<?php echo heading($heading, '3');?>
			</div>
			
		</div>
		<div class="clearfix"></div>
		
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

		<div class="row">
			<div class="col-md-12 col-xs-12">

				<div class="x_panel">

					<div class="x_title">

						<?php
							echo heading('Customize Footer', '2');
							$attributes = array('class' => 'nav navbar-right panel_toolbox');
							$list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
							echo ul($list,$attributes);
						?>

						<div class="clearfix"></div>
					</div>

					<div class="x_content">

						<?php
							echo br();

								// Form Tag
							echo form_open(
								'footer/insert_update_footer_customize',
								'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
								);

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
						<div class="form-group" id="component-bg-color" <?php if ($component_background == 'color') :?>
                            style="display:block;" <?php else : ?> style="display:none;" <?php endif;?>>
                            <?php
								echo form_label(
									'Background Color',
									'footer_background_color',
									'class="control-label col-md-3 col-sm-3 col-xs-12"'
								);

								// Input tag hidden
								echo form_input(array(
									'type'  => 'hidden',
									'name'  => 'footer_background_color',
									'id'    => 'footer_background_color',
									'value' => $footer_background
								));
							?>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <?php									
									// Color
									$this->color->view($footer_background,'footer_background_color',4);
								?>
                            </div>
                        </div>
						<div class="form-group" id="component-bg-image" <?php if ($component_background == 'image') :?>
                            style="display:block;" <?php else : ?> style="display:none;" <?php endif;?>>

                            <?php

								if ($component_background == 'color') :
									$footer_background = '';
								endif;

								// label
								echo form_label(
									'Image <span class="required">* Recommended size(1200*400)</span>',
									'imgInp',
									'class="control-label col-md-3 col-sm-3 col-xs-12"'
								);
							?>
							
                            <div class="img-thumbnail sepH_a" id="show_image1">
                                <?php
									if ($footer_background != '') :

										$footer = $ImageUrl . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR . $footer_background;
										echo img(array(
												'src'   => $footer,
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
									'value' => $footer_background
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

                            <a data-toggle="modal" class="btn btn-primary" data-target="#ImagePopUp" href="javascript:;"
                                type="button">
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
									'Footer Status',
									'footer_status',
									'class="control-label col-md-3 col-sm-3 col-xs-12"'
									);
							?>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<?php
								// Input checkbox
									echo form_checkbox(array(
										'id'      => 'footer_status',
										'name'    => 'footer_status',
										'class'   => 'js-switch',
										'checked' => ($footer_status === '1') ? TRUE : FALSE,
										'value'   => $footer_status
										));
								?>
							</div>
						</div>
						
						<div class="ln_solid"></div>
						
						<div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="input-button-group">
								<?php
									// Submit Button
									if (empty($component_background)) :
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
	</div>

	<div class="x_panel">
		<div class="x_content">
			<div class="row">
				<?php
					// Table
					echo $table;
				?>
			</div>
		</div>
	</div>
</div>
