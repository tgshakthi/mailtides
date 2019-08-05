<?php
	/**
	 * Top header view
	 *
	 * @category View
	 * @package  Top header view
	 * @author   Velu
	 * Created at:  21-Sep-18
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
						'header',
						'<i class="fa fa-chevron-left" aria-hidden="true"></i> Back',
						array(
							'class' => 'btn btn-primary'
						)
					);
				?>
			</div>

		</div>

		<div class="clearfix"></div>

		<div class="row">
			
			<?php if ($this->session->flashdata('success') != '') : // Display session data ?>
				<div class="alert alert-success alert-dismissible fade in text-center" id="success-alert" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
					<strong>Success!</strong> <?php echo $this->session->flashdata('success');?>
				</div>
			<?php endif; ?>

			<?php if ($this->session->flashdata('error') != '') : // Display session data ?>
				<div class="alert alert-warning alert-dismissible fade in text-center" id="warning-alert" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
					<strong><?php echo $this->session->flashdata('error');?></strong>
				</div>
			<?php endif; ?>

			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">

					<div class="x_title">
						<?php
							echo heading('Customize Top Header', '2');
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
								'header/top_header/insert_update_top_header_customize',
								'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
							);

							echo form_input(
								array(
									'type' => 'hidden',
									'name' => 'website_id',
									'value' => $website_id
								)							
							);
							
						?>
						
						<div class="form-group">
							<?php
								echo form_label(
									'Background Color',
									'top_header_background_color',
									'class="control-label col-md-3 col-sm-3 col-xs-12"'
								);

								// Input tag hidden
								echo form_input(array(
									'type'  => 'hidden',
									'name'  => 'top_header_background_color',
									'id'    => 'top_header_background_color',
									'value' => $top_header_background_color
								));
							?>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<?php
									// Color
									$this->color->view($top_header_background_color,'top_header_background_color',1);
								?>
							</div>
						</div>

						<div class="form-group">
							<?php
								echo form_label(
									'Top Header Status',
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
										'checked' => ($top_header_status === '1') ? TRUE : FALSE,
										'value'   => $top_header_status
										));
								?>
							</div>
					    </div>

						<div class="ln_solid"></div>

						<div class="col-md-12 col-sm-12 col-xs-12">
              <div class="input-button-group">
								<?php
									// Submit Button
									if (empty($top_header_background_color)) :
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
			</div>

			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_content">
						<?php
							// Table
							echo $table;
						?>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
</div>
<!-- /page content -->
