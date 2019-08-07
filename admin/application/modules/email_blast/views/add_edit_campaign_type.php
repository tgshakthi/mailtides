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
									'email_blast/campaign_type',
									'<i class="fa fa-chevron-left" aria-hidden="true"></i> Back',
									array(
										'class' => 'btn btn-primary'
									));
							?>
						</div>
						<div class="clearfix"></div>
					</div>

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

					<div class="x_content">						

						<?php
							// Break tag
							echo br();


								// Form Tag
								echo form_open_multipart(
									'email_blast/insert_update_campaign_type',
									'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate autocomplete="off"'
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
									'name'  => 'website_id',
									'id'    => 'website_id',
									'value' => $website_id
								));

								// Input tag hidden
								echo form_input(array(
									'type'  => 'hidden',
									'name'  => 'base-url',
									'id'    => 'base-url',
									'value' =>  base_url()
								));
						?>
					
						<div class="col-md-6 col-md-offset-3 col-xs-6">
							<div class="x_panel">

								<div class="x_title">
									<?php
										echo heading('Campaign Details', '2');
										$list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
										$attributes = array('class' => 'nav navbar-right panel_toolbox');
										echo ul($list,$attributes);
									?>
									<div class="clearfix"></div>
								</div>

								<div class="x_content">

									<div class="form-group">

										<?php
											echo form_label('Campaign Type','campaign_type');

											// Input tag
											echo form_input(array(
												'id'       => 'campaign_type',
												'name'     => 'campaign_type',
												'class'    => 'form-control col-md-6 col-sm-6 col-xs-12',
												'value'    => $campaign_type
											));
										?>
                                        <span id='error' class="control-label col-md-4 col-sm-4 col-xs-12"></span>
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
										'email_blast/campaign_type',
										'Back',
										array(
											'title' => 'Back',
											'class' => 'btn btn-primary'
										)
									);
								?>
                            </div>
                        </div>

						<?php 
							echo form_close(); //Form close 
						?>

					</div>			

				</div>
			</div>
		</div>
	</div>
	
	
	