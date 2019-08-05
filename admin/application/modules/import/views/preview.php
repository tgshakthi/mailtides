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
										'import/table_import',
										'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate enctype="multipart/form-data"'
									);


								?>

									<div class="page_buut_right">

										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
											<a href="<?php echo base_url();?>import" class="btn btn-info"> Back </a>
										</div>

										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="text-align:right;">
											<input type="hidden" name="table_name" value="<?php echo $table_name;?>">
											<input type="submit" value="Import" class="btn btn-success">
										</div>

									</div>

								<?php echo form_close(); //Form close ?>

								<?php echo $table;?>

							</div>

						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /page content -->
