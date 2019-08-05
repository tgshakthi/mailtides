<div class="right_col" role="main">

	<div class="">

		<div class="page-title">

			<div class="title_left">
				<?php echo heading($heading, '3');?>
			</div>

			<div class="btn_right" style="text-align:right;">
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
			<?php
				echo br();

				// Form Tag
				echo form_open(
					'footer/insert_update_footer_contact_info',
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

			<div class="col-md-6 col-xs-12">
				<div class="x_panel">

					<div class="x_title">

						<?php
							echo heading('Footer Contact Info', '2');
							$attributes = array('class' => 'nav navbar-right panel_toolbox');
							$list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
							echo ul($list,$attributes);
						?>

						<div class="clearfix"></div>
					</div>

					<div class="x_content">

						<?php
							if(!empty($contact_informations)) :
								foreach($contact_informations[0] as $key => $val):
						?>

							<div class="form-group">

									<?php
									 	$checked	= (in_array($key, $footer_contact_info)) ? 'checked' : '';

										echo form_checkbox(
											array(
												'name' => 'contact_info[]',
												'id' => $key,
												'class' => 'flat',
												'value' => $key,
												'checked' => $checked
											)
										);

										echo form_label(
											ucwords(str_replace('_', ' ', $key)),
											$key,
											array(
												'data-toggle' => 'tooltip',
												'data-placement' => 'right',
												'data-original-title' => $val
											)
										);

									?>

							</div>

						<?php
								endforeach;
							endif;
						?>

					</div>
				</div>
			</div>

			<div class="col-md-6 col-xs-12">
				<div class="x_panel">

					<div class="x_title">

						<?php
							echo heading('Customize Footer Contact info', '2');
							$attributes = array('class' => 'nav navbar-right panel_toolbox');
							$list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
							echo ul($list,$attributes);
						?>

						<div class="clearfix"></div>
					</div>

					<div class="x_content">

						<!-- <div class="form-group">
							<?php
								echo form_label(
									'Position',
									'footer_position',
									'class="control-label col-md-3 col-sm-3 col-xs-12"'
								);
							?>

							<div class="col-md-6 col-sm-6 col-xs-12">
								<?php
									$options = array(
										'left'	=> 'Left',
										'right'	=> 'Right'
									);

									$attributes = array(
										'name'	=> 'position',
										'id'	=> 'position',
										'class'	=> 'form-control col-md-3 col-xs-12'
									);
									echo form_dropdown($attributes, $options, $footer_contact_info_position);
								?>
							</div>
						</div> -->

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
										'checked' => ($footer_contact_info_status === '1') ? TRUE : FALSE,
										'value'   => ''
									));
								?>
							</div>

						</div>

					</div>
				</div>
			</div>

			<!-- Button Group -->
			<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="input-button-group">
					<?php
						// Submit Button
						if (empty($footer_contact_info_data)) :
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

			<?php
				//Form close
				echo form_close();
			?>

		</div>
	</div>
</div>