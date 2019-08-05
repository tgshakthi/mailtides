<!-- page content -->
<div class="right_col" role="main">
	<div class="">
		<div class="clearfix"></div>

		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="">

					<div class="x_title">
						<?php echo heading($heading, '2');?>
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
							<strong>
								<?php if (!empty($this->session->flashdata('error')['error'])) :?>
									<?php echo $this->session->flashdata('error')['error'];?>
								<?php else :?>
									<?php echo $this->session->flashdata('error');?>
								<?php endif;?>
							</strong>
						</div>
						<?php endif; ?>

						<div class="x_panel">
							<div class="x_content">

								<?php
									// Form Tag
									echo form_open_multipart(
										'import/import_file',
										'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate enctype="multipart/form-data"'
									);
								?>

								<div class="form-group">
									<?php
										echo form_label(
											'Choose Table',
											'choose-table',
											array(
												'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
											)
										);
									?>

									<div class="col-md-6 col-sm-6 col-xs-12">
										<?php

											foreach($tables as $table) :
												$options[$table] = $table;
											endforeach;

											$attributes = array(
												'name' => 'table_name',
												'class' => 'form-control col-md-3 col-xs-12',
												'required' => 'required'
											);

											echo form_dropdown($attributes, $options);
										?>
									</div>

								</div>

								<div class="form-group">
									<?php
										echo form_label(
											'Choose File  ( <span class="">CSV Files only</span> )',
											'choose_file',
											array(
												'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
											)
										);
									?>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<div class="input-group input-file" name="fupload">
											<span class="input-group-btn">
												<?php
													// Choose Button
													echo form_button(array(
														'type'         => 'button',
														'class'        => 'btn btn-default',
														'content'      => 'Choose'
													));
												?>
											</span>
											<?php
												// Input tag
												echo form_input(array(
													'type' => 'file',
													'id' => 'fupload',
													'name' => 'files',
													'class' => 'form-control col-md-3 col-xs-12',
													'placeholder' => 'Choose a file...',
													'required' => 'required'
												));
											?>

										</div>
									</div>
								</div>

								<!-- <div class="form-group">
									<?php
										echo form_label(
											'Source',
											'source',
											array(
												'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
											)
										);
									?>

									<div class="col-md-6 col-sm-6 col-xs-12">
										<?php
											echo form_input(
												array(
													'type'  => 'text',
													'name'  => 'source',
													'class' => 'form-control col-md-3 col-xs-12',
													'value' => ''
												)
											);
										?>
									</div>

								</div> -->

								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="input_butt">
										<?php
											echo form_submit(
												array(
												'class' => 'btn btn-success',
												'id'    => 'btn',
												'value' => 'Map Field'
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
	</div>
</div>
<!-- /page content -->
