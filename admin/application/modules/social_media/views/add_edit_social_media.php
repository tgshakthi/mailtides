<?php
	/**
	 * Social Media view
	 *
	 * @category View
	 * @package  Add Edit Social Media
	 * @author   Karthika
	 * Created at:  19-Sep-18
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
										'social_media',
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

						<?php
              // Break tag
              echo br();

              // Form Tag

              echo form_open(
                'social_media/insert_update_social_media',
                'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate autocomplete="off"'
              );

              // Input tag hidden
              echo form_input(array(
                'type'  => 'hidden',
                'name'  => 'media_id',
                'id'    => 'media_id',
                'value' => $media_id
							));

							// Input tag hidden
              echo form_input(array(
                'type'  => 'hidden',
                'name'  => 'website_id',
                'id'    => 'website_id',
                'value' => $website_id
              ));
            ?>

						<!-- Social Media Details -->
						<div class="col-md-6 col-sm-12 col-xs-12">
							<div class="x_panel">

								<div class="x_title">
									<?php
										echo heading('Social Media Details', '2');
										$list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
										$attributes = array('class' => 'nav navbar-right panel_toolbox');
										echo ul($list,$attributes);
									?>
									<div class="clearfix"></div>
								</div>

								<div class="x_content">

									<div class="form-group">

										<?php
											echo form_label('Media Title <span class="required">*</span>','media_title');

											// Input tag
											echo form_input(array(
												'id'       => 'media_title',
												'name'     => 'media_title',
												'required' => 'required',
												'class'    => 'form-control',
												'value'    => $media_title
											));
										?>

									</div>

									<div class="form-group">

										<?php
											echo form_label('Media URL <span class="required">*</span>','media_url');

											// Input tag
											echo form_input(array(
												'id'       => 'media_url',
												'name'     => 'media_url',
												'required' => 'required',
												'class'    => 'form-control',
												'value'    => $media_url
											));
										?>

									</div>


									<div class="form-group">

										<?php
											echo form_label(
												'Media Icon',
												'icon'
											);

											// Input
											echo form_input(array(
												'id'                => 'icon',
												'name'              => 'icon',
												'required'          => 'required',
												'class'             => 'form-control col-md-7 col-xs-12 icp icp-auto',
												'data-input-search' => 'true',
												'value'             => $icon
											));

											echo br('2');

											echo '<p class="lead"><i class="fa '.$icon.' fa-3x picker-target"></i></p>';

										?>

									</div>



								</div>
							</div>
						</div>
						<!-- Social Media Details -->

						<!-- Customize Social Media icon -->
						<div class="col-md-6 col-sm-12 col-xs-12">
							<div class="x_panel">

								<div class="x_title">
									<?php
										echo heading('Customize Social Media icon', '2');
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

											echo form_label('Media Icon Color','media_icon_color');

											// Input tag hidden
											echo form_input(array(
													'type'  => 'hidden',
													'name'  => 'media_icon_color',
													'id'    => 'media_icon_color',
													'value' => $media_icon_color
											));

											// Color
											$this->color->view($media_icon_color,'media_icon_color',1);
										?>

									</div>

									<div class="form-group">

										<?php

											echo form_label('Media Icon Hover Color','media_icon_hover_color');

											// Input tag hidden
											echo form_input(array(
													'type'  => 'hidden',
													'name'  => 'media_icon_hover_color',
													'id'    => 'media_icon_hover_color',
													'value' => $media_icon_hover_color
											));

											// Color
											$this->color->view($media_icon_hover_color, 'media_icon_hover_color', 2);
										?>

									</div>
									<div class="form-group">

										<?php

											echo form_label('Background Color','background_color');

											// Input tag hidden
											echo form_input(array(
													'type'  => 'hidden',
													'name'  => 'background_color',
													'id'    => 'background_color',
													'value' => $background_color
											));

											// Color
											$this->color->view($background_color, 'background_color', 3);
										?>

									</div>
									<div class="form-group">

										<?php

											echo form_label('Background Hover Color','background_hover_color');

											// Input tag hidden
											echo form_input(array(
													'type'  => 'hidden',
													'name'  => 'background_hover_color',
													'id'    => 'background_hover_color',
													'value' => $background_hover_color
											));

											// Color
											$this->color->view($background_hover_color, 'background_hover_color', 4);
										?>

									</div>

								</div>
							</div>
						</div>
						<!-- Customize Social Media icon -->
					</div>

					<!-- Sort Order & Status -->
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

									<div class="clearfix"></div>
									<br>

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
								if (empty($media_id)) :
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
									'social_media',
									'Back',
									array(
										'title' => 'Back',
										'class' => 'btn btn-primary'
									)
								);

								echo br(4);
							?>
						</div>
					</div>

					<?php echo form_close(); //Form close ?>

				</div>
			</div>
		</div>
	</div>
	<!-- /page content -->
