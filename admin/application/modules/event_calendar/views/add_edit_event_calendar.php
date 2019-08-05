<div class="right_col" role="main">
	<div class="">
		<div class="clearfix"></div>
		 <div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="">
					<div class="x_title">
                        <?php
							echo heading($heading, '2');
						?>
                        <div class="btn_right" style="text-align:right;">
							<?php
								echo anchor(
									'event_calendar/event_calendar_index/'.$page_id,
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
                               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                               <span aria-hidden="true">×</span>
                               </button>
                               <strong>Success!</strong>
                               <?php
									echo $this->session->flashdata('success');
								?>
                            </div>
                            <?php endif; ?>

                        <?php if ($this->session->flashdata('error') != '') : // Display session data ?>
							<div class="alert alert-warning alert-dismissible fade in text-center" id="warning-alert" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">×</span>
								</button>
								<strong>
								<?php
									echo $this->session->flashdata('error');
								?>
								</strong>
							</div>
							<?php endif; ?>

							<?php
								// Break tag
								echo br();

								// Form Tag

								echo form_open(
									'event_calendar/insert_update_event_calendar',
									'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
								);

								// Input tag hidden
								echo form_input(array(
									'type'  => 'hidden',
									'name'  => 'id',
									'id'    => 'id',
									'value' => $id
								));
								// Input tag hidden
								echo form_input(array(
									'type'  => 'hidden',
									'name'  => 'page_id',
									'id'    => 'page_id',
									'value' => $page_id
								  ));

								// Input tag hidden
								echo form_input(array(
									'type'  => 'hidden',
									'name'  => 'website_id',
									'id'    => 'website_id',
									'value' => $website_id
								));
							?>
							<div class="x_panel">
								<div class="x_title">
									<?php
										echo heading('Event Calendar Details', '2');
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
												'Date & Time <span class="required">*</span>',
												'date_time',
												'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);
											?>

										<div class="col-md-6 col-sm-6 col-xs-12">
											<?php
												echo form_input(array(
													'name'     => 'date_time',
													'class'    => 'form-control input-group date',
													'required' => 'required',
													'id'       => 'reservation-time',
													'value'    => $date_time
												));
											?>
										</div>
									</div>
									<div class="form-group">
										<?php
											echo form_label(
												'Event Name <span class="required">*</span>',
												'event_name',
												'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);
											?>

										<div class="col-md-6 col-sm-6 col-xs-12">
											<?php
											   // Input tag
												echo form_input(array(
													'id'       => 'event_name',
													'name'     => 'event_name',
													'required' => 'required',
													'class'    => 'form-control',
													'value'    => $event_name
												));
											?>
										</div>
									</div>
									<div class="form-group">
										<?php
											echo form_label('Event Details',
											'text',
											'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);
										?>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<?php
												// TextArea
												$data = array(
													'name'        => 'event_details',
													'id'          => 'text',
													'value'       => $event_details
													);
												echo form_textarea($data);
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
										'event_calendar/event_calendar_index/'.$page_id,
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
				</div>
			</div>
		 </div>
	</div>
</div>
