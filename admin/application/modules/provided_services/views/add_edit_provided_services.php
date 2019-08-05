<?php
	/**
	 * Provided Services View
	 *
	 * @category View
	 * @package  Provided Services
	 * @author   Karthika
	 * Created at:  07-Dec-2018
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
									'provided_services/provided_service_index/'.$page_id,
									'<i class="fa fa-chevron-left" aria-hidden="true"></i> Back',
									array( 'class' => 'btn btn-primary' )
								);
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
                'provided_services/insert_update_provided_service',
                'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
              );

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
								<div class="x_content">

									<div class="form-group">

										<?php
											echo form_label(
												'Choose Cities <span class="required">*</span>',
												'choose_cities',
												'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);
										?>

										<div class="col-md-6 col-sm-6 col-xs-12">
											<?php
												$cities_options = array();
												foreach ($cities as $city) :
													if(!in_array($city->id, $selected_cities)) :
														$cities_options[$city->id] =  $city->name;
													endif;
												endforeach;

												//$selected = $selected_cities;

												$cities_attributes = array(
													'id'       => 'cities',
													'name'     => 'cities[]',
													'required' => 'required',
													'class'    => 'form-control col-md-7 col-xs-12 multiselect'
												);

												// Dropdown Multiselect
												echo form_multiselect(
													$cities_attributes,
													$cities_options
													//$selected
												);
											?>
										</div>

									</div>

									<div class="form-group">

										<?php
											echo form_label(
												'Page Url',
												'page_url',
												'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);
										?>

										<div class="col-md-6 col-sm-6 col-xs-12">
											<?php
												echo form_input(
													array(
														'type' => 'text',
														'class' => 'form-control col-md-7 col-xs-12',
														'id' => 'page_url',
														'name' => 'page_url',
														'disabled' => 'disabled',
														'value' => $page_url[0]->url
													)
												);
											?>
										</div>

									</div>

									<div class="form-group">
										<?php
											echo form_label(
												'Page Content',
												'page_content',
												'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);
										?>

										<div class="col-md-6 col-sm-6 col-xs-12">
											<?php
												echo form_textarea(
													array(
														'class' => 'form-control col-md-7 col-xs-12',
														'id' => 'text',
														'name' => 'content'
													)
												);
											?>
										</div>
									</div>

									<div class="form-group">
										<?php
											echo form_label(
												'Title Color',
												'title_color',
												'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);

											// Input tag hidden
											echo form_input(array(
												'type'  => 'hidden',
												'name'  => 'title_color',
												'id'    => 'title_color'
											));
										?>
										<div class="col-md-6 col-xs-12">
											<?php
												// Input Tag
												$this->color->view('', 'title_color', 1);
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
															//'checked' => ($status === '1') ? TRUE : FALSE,
															//'value'   => $status
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
									$submit_value = 'Add';

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
										'provided_services/provided_service_index/'.$page_id,
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

						<?php
							// Form close
							echo form_close();
            			?>
						
					</div>

				</div>
			</div>
		</div>
	</div>
	<!-- /page content -->
