
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
									'email_blast/campaign',
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

							if ($page_status == '1') :

								// Form Tag
								echo form_open_multipart(
									'email_blast/field_map_campaign_users',
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
						?>
					
						<div class="col-md-12 col-md-12 col-xs-12">
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

									<div class="form-group col-md-6 col-md-6 col-xs-6">

										<?php
											echo form_label('Campaign Name','name');

											// Input tag
											echo form_input(array(
												'id'       => 'name',
												'name'     => 'name',
												'class'    => 'form-control',
												'value'    => $campaign_name
											));
										?>

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

										echo form_submit(
											array(
												'class' => 'btn btn-success',
												'name' => 'field-mapping',
												'value' => 'Save'
											)
										);

									else :
										echo form_submit(
											array(
												'class' => 'btn btn-success',
												'name' => 'field-mapping',
												'value' => 'Update'
											)
										);
									endif;																	

									// Anchor Tag
									echo anchor(
										'email_blast/campaign',
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

						<?php 
							echo form_close(); //Form close 
							endif;
						?>

						<!-- Field Mapping -->
						<?php
							if ($page_status == 2) :
								// Form Tag
								echo form_open(
									'email_blast/field_map_campaign_users',
									'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate autocomplete="off"'
								);

								// Input tag hidden
								echo form_input(array(
									'type'  => 'hidden',
									'name'  => 'website_id',
									'id'    => 'website_id',
									'value' => $website_id
								));

								// Campaign Id
								echo form_input(array(
									'type' => 'hidden',
									'name' => 'campaign_id',
									'id' => 'campaign_id',
									'value' => $campaign_id
								));

								// File
								echo form_input(array(
									'type' => 'hidden',
									'name' => 'file',
									'id' => 'file',
									'value' => $file
								));

								// Campaign name 
								echo form_input(array(
									'type' => 'hidden',
									'name' => 'campaign_name',
									'id' => 'campaign-name',
									'value' => $campaign_name
								));

								// Description
								echo form_input(array(
									'type' => 'hidden',
									'name' => 'description',
									'id' => 'description',
									'value' => $description
								));

								// Template Id
								echo form_input(array(
									'type' => 'hidden',
									'name' => 'template_id',
									'id' => 'template_id',
									'value' => $template_id
								));

								// Status
								echo form_input(array(
									'type' => 'hidden',
									'name' => 'status',
									'id' => 'status',
									'value' => $status
								));
						?>	

							<div class="form-group">
								<label for="name" class="control-label col-md-3 col-sm-3 col-xs-12">
									Name <span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<select name="name" id="name" class="form-control col-md-7 col-xs-12" required="required">
										<?php 
											foreach($csv_columns as $row) {  
												$searchVal = array('"', ' ', '&#65279;');
												$replaceVal = array('', '', '');
												$res = str_replace($searchVal, $replaceVal, trim($row));
										?>
											<option value="<?php echo $res; ?>"><?php echo $res; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>

							<div class="form-group">
								<label for="email" class="control-label col-md-3 col-sm-3 col-xs-12">
									Email <span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">							
									<select name="email" id="email" class="form-control col-md-7 col-xs-12" required="required">
										<?php 
											foreach($csv_columns as $row){ 
												$searchVal = array('"', ' ', '&#65279;');
												$replaceVal = array('', '', '');
												$res = str_replace($searchVal, $replaceVal, trim($row));
										?>
										<option value="<?php echo $res; ?>"><?php echo $res; ?></option>
										<?php } ?>
									</select>													
								</div>
							</div>

							<div class="form-group">
								<label for="visited-date" class="control-label col-md-3 col-sm-3 col-xs-12">
									Visited Date <span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<select name="visited_date" id="visited-date" class="form-control col-md-7 col-xs-12" required="required">
										<?php 
											foreach($csv_columns as $row){ 
												$searchVal = array('"', ' ', '&#65279;');
												$replaceVal = array('', '', '');
												$res = str_replace($searchVal, $replaceVal, trim($row));
										?>
										<option value="<?php echo $res; ?>"><?php echo $res; ?></option>
										<?php } ?>
									</select>													
								</div>
							</div>

							<!-- Button Group -->
							<div class="col-md-12 col-sm-12 col-xs-12 ">
								<div class="input-button-group">
									<?php
										
										echo form_submit(
											array(
												'class' => 'btn btn-success',
												'name' => 'import-users',
												'value' => 'Import'
											)
										);																		

										// Anchor Tag
										echo anchor(
											'email_blast/campaign',
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

						<?php echo form_close();?>

						<?php endif;?>
					
					</div>			

				</div>
			</div>
		</div>
	</div>
	<!-- /page content -->
	
	<div class="modal fade" id="preview-template-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
		aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">

				<div class="modal-header">
					Email Template Preview
				</div>

				<div class="modal-body" id="modal-body-img" style="text-align: center;">
				</div>

				<div class="modal-footer">
					<a class="btn btn-danger" id="btn_ok" data-dismiss="modal">close</a>
				</div>

			</div>
		</div>
	</div>