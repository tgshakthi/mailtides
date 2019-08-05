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
	</div>
	<div class="x_panel">
		<div class="x_title">
			<?php
				echo heading('Event Calendar Title', '2');
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
					'event_calendar/insert_update_event_calendar_title',
					'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
				  );

			   			// Input tag hidden
              echo form_input(array(
					'type'  => 'hidden',
					'name'  => 'page_id',
					'id'    => 'page_id',
					'value' => $page_id
					));

						// Website Id
			echo form_input(array(
					'type' 	=> 'hidden',
					'name' 	=> 'website_id',
					'id' 	=> 'website_id',
					'value'	=> $website_id
				));
			?>
			<div class="form-group">
				<?php
					echo form_label(
						'Title',
						'event_calendar_title',
						'class="control-label col-md-3 col-sm-3 col-xs-12"'
						);
					?>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<?php
						// Input tag
							echo form_input(array(
								'id'       => 'event_calendar_title',
								'name'     => 'event_calendar_title',
								'class'    => 'form-control col-md-7 col-xs-12',
								'value'    => $event_calendar_title
								));
						?>
							<span id="error_result"></span>
						</div>
					</div>
					<div class="form-group">
							<?php
								echo form_label(
									'Title Color',
									'event_calendar_title_color',
									'class="control-label col-md-3 col-sm-3 col-xs-12"'
								);

								// Input tag hidden
								echo form_input(array(
									'type'  => 'hidden',
									'name'  => 'event_calendar_title_color',
									'id'    => 'event_calendar_title_color',
									'value' => $event_calendar_title_color
								));
							?>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<?php
									// Input Tag
									$this->color->view($event_calendar_title_color,'event_calendar_title_color',1);
								?>
							</div>
					</div>

						<div class="form-group">
							<?php
								echo form_label(
									'Title Position',
									'event_calendar_title_position',
									'class="control-label col-md-3 col-sm-3 col-xs-12"'
								);
							?>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<?php
									$options = array(
										'left-align'	 => 'Left',
										'center-align' => 'Center',
										'right-align'	 => 'Right'
									);

									$attributes = array(
										'name'	=> 'event_calendar_title_position',
										'id'	=> 'event_calendar_title_position',
										'class'	=> 'form-control col-md-7 col-xs-12'
									);

									echo form_dropdown($attributes, $options, $event_calendar_title_position);
								?>
							</div>
						</div>

						<div class="form-group">
							<?php
								echo form_label(
									'Background Color',
									'event_calendar_background_color',
									'class="control-label col-md-3 col-sm-3 col-xs-12"'
								);

								// Input tag hidden
								echo form_input(array(
									'type'  => 'hidden',
									'name'  => 'event_calendar_background_color',
									'id'    => 'event_calendar_background_color',
									'value' => $event_calendar_background_color
								));
							?>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<?php
									// Color
									$this->color->view($event_calendar_background_color,'event_calendar_background_color',2);
								?>
							</div>
						</div>
						<div class="form-group">
										<?php
											echo form_label(
												'Status',
												'event_calendar_status',
												'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);
										?>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<?php
												// Input checkbox
												echo form_checkbox(array(
													'id'      => 'event_calendar_status',
													'name'    => 'event_calendar_status',
													'class'   => 'js-switch',
													'checked' => ($event_calendar_status === '1') ? TRUE : FALSE,
													'value'   => $event_calendar_status
												));
											?>
										</div>
									</div>

									<div class="ln_solid"></div>

									<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="input-button-group">
								<?php
									// Submit Button
									if (empty($event_calendar_title)) :
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

									

							<?php echo form_close();?>
		</div>

	</div>
	<div class="x_panel">

		<div class="x_content">

			<?php

				echo form_open(
					'event_calendar/delete_multiple_event_calendar/'.$page_id,
					'id="form_selected_record"'
				);

			?>

			<div class="page_buut_right">

				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">

					<?php
						echo form_button(array(
							'type'    => 'button',
							'id'	  => 'delete_selected_record',
							'name'    => 'delete-selected-event-calendar',
							'class'   => 'btn btn-danger',
							'content' => '<i class="fa fa-trash-o" aria-hidden="true"></i> Delete'
						));
					?>

				</div>

				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="text-align:right;">
				<?php
					echo anchor(
						'event_calendar/add_edit_event_calendar/'.$page_id,
						'<i class="fa fa-plus" aria-hidden="true"></i> Add Event Calendar ',
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
			<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
							<div class="modal-content">

									<div class="modal-header">
											Confirm Delete
									</div>

									<div class="modal-body">
											<p>Are you sure you want to delete this record?</p>
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
													<a class="btn btn-danger" id="delete_btn_ok">Delete</a>
									</div>
							</div>
					</div>
			</div>

		</div>

	</div>
</div>
<!-- Page Content -->
