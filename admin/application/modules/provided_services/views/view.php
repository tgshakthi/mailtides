
<?php
	/**
	 * Provide Services View
	 *
	 * @category View
	 * @package  Provided Services
	 * @author   Karthika
	 * Created at:  03-Dec-2018
	 */
?>

<!-- page content -->
<div class="right_col" role="main">

	<div class="">

		<div class="page-title">

			<div class="title_left">
				<?php echo heading($heading, '3');?>
			</div>

			<div class="btn_right" style="text-align:right;">
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
			<div class="col-md-6 col-xs-12">
				<div class="x_panel">

					<div class="x_title">

						<?php
							echo heading('Provided Services Title', '2');

							$attributes = array('class' => 'nav navbar-right panel_toolbox');
							$list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
							echo ul($list,$attributes);
						?>

						<div class="clearfix"></div>
					</div>

					<div class="x_content">

						<?php
							// Break Tag
							echo br();

							// Form Tag
              echo form_open(
                'provided_services/insert_update_provided_service_data',
                'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
              );

			   			// Input tag hidden
              echo form_input(array(
                'type'  => 'hidden',
                'name'  => 'page-id',
                'id'    => 'page-id',
                'value' => $page_id
							));
							
							// Input tag hidden
              echo form_input(array(
                'type'  => 'hidden',
                'name'  => 'sort_id',
                'id'    => 'sort_id',
                'value' => $page_id
							));
							
							echo form_input(array(
                'type'  => 'hidden',
                'name'  => 'sort_url',
                'id'    => 'sort_url',
                'value' => base_url().'image_card/update_sort_order'
							));

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
									'Title',
									'provided_services_title',
									'class="control-label col-md-3 col-sm-3 col-xs-12"'
								);
							?>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<?php
									// Input tag
									echo form_input(array(
										'id'       => 'provided_services_title',
										'name'     => 'provided_services_title',
										'class'    => 'form-control col-md-7 col-xs-12',
										'value'    => $provided_services_title
									));
								?>
								<span id="error_result"></span>
							</div>
						</div>

						<div class="form-group">
							<?php
								echo form_label(
									'Title Color',
									'provided_services_title_color',
									'class="control-label col-md-3 col-sm-3 col-xs-12"'
								);

								// Input tag hidden
								echo form_input(array(
									'type'  => 'hidden',
									'name'  => 'provided_services_title_color',
									'id'    => 'provided_services_title_color',
									'value' => $provided_services_title_color
								));
							?>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<?php
									// Input Tag
									$this->color->view($provided_services_title_color,'provided_services_title_color',1);
								?>
							</div>
						</div>

						<div class="form-group">
							<?php
								echo form_label(
									'Title Position',
									'provided_services_title_position',
									'class="control-label col-md-3 col-sm-3 col-xs-12"'
								);
							?>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<?php
									$options = array(
										'left-align'	 => 'Left',
										'center-align' => 'Center',
										'right-align'	 => 'Right'
									);

									$attributes = array(
										'name'	=> 'provided_services_title_position',
										'id'	=> 'provided_services_title_position',
										'class'	=> 'form-control col-md-7 col-xs-12'
									);

									echo form_dropdown($attributes, $options, $provided_services_title_position);
								?>
							</div>
						</div>

						<div class="form-group">
							<?php
								echo form_label(
									'Status',
									'provided_services_title_status',
									'class="control-label col-md-3 col-sm-3 col-xs-12"'
								);
							?>

							<div class="col-md-6 col-sm-6 col-xs-12">
								<?php
									// Input checkbox
									echo form_checkbox(array(
										'id'      => 'provided_services_title_status',
										'name'    => 'provided_services_title_status',
										'class'   => 'js-switch',
										'checked' => ($provided_services_title_status === '1') ? TRUE : FALSE,
										'value'   => $provided_services_title_status
									));
								?>
							</div>
						</div>

						<div class="ln_solid"></div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="input-button-group">
								<?php
									// Submit Button
									if (empty($provided_services_title_data)) :
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

			<div class="col-md-6 col-xs-12">
				<div class="x_panel">

					<div class="x_title">

						<?php
							echo heading('Customize Provided Services', '2');
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
                'provided_services/insert_provided_service_customize',
                'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
							);

							// Input tag hidden
              echo form_input(array(
                'type'  => 'hidden',
                'name'  => 'page-id',
                'id'    => 'page-id',
                'value' => $page_id
							));

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
									'Provided Services Per Row',
									'position',
									'class="control-label col-md-3 col-sm-3 col-xs-12"'
								);
							?>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<?php
									$options = array(
										'l6 xl6'	=> '2',
										'l4 xl4'	=> '3',
										'l3 xl3'	=> '4',
									);

									$attributes = array(
										'name'	=> 'provided_services_row_count',
										'id'	=> 'provided_services_row_count',
										'class'	=> 'form-control col-md-7 col-xs-12'
									);

									echo form_dropdown($attributes, $options, $row_count);
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
												<div class="form-group" id="component-bg-color" <?php if ($component_background == 'color') :?>
                            style="display:block;" <?php else : ?> style="display:none;" <?php endif;?>>
                            <?php
								echo form_label(
									'Background Color',
									'provided_services_background_color',
									'class="control-label col-md-3 col-sm-3 col-xs-12"'
								);

								// Input tag hidden
								echo form_input(array(
									'type'  => 'hidden',
									'name'  => 'provided_services_background_color',
									'id'    => 'provided_services_background_color',
									'value' => $provided_services_background
								));
							?>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <?php									
									// Color
									$this->color->view($provided_services_background,'provided_services_background_color',2);
								?>
                            </div>
                        </div>
												<div class="form-group" id="component-bg-image" <?php if ($component_background == 'image') :?>
                            style="display:block;" <?php else : ?> style="display:none;" <?php endif;?>>

                            <?php

								if ($component_background == 'color') :
									$provided_services_background = '';
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
									if ($provided_services_background != '') :

										$provided_img = $ImageUrl . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR . $provided_services_background;
										echo img(array(
												'src'   => $provided_img,
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
									'value' => $provided_services_background
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


						<div class="ln_solid"></div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="input-button-group">
								<?php
									// Submit Button
									if (empty($provided_services_customize_data)) :
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
        <div class="page_buut_right">

				

				<div class="col-lg-12 col-md-12 col-sm-6 col-xs-6" style="text-align:right;">
						<?php
							echo anchor(
								'provided_services/add_edit_provided_service/'.$page_id,
								'<i class="fa fa-plus" aria-hidden="true"></i> Add Provided Services',
								array(
								'class' => 'btn btn-success'
								)
							);
						?>
				</div>

			</div>

			<div class="row">
				<?php
					// Table
					echo $table;
				?>
			</div>

			<?php echo form_close();?>

			<!-- Confirm Delete Modal -->
			

		</div>

	</div>
</div>
<!-- Page Content -->
