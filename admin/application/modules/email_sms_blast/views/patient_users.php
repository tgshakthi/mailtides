<!-- page content -->
<div class="right_col" role="main">
	<div class="">
		<div class="page-title">
			<div class="title_left">
				<h3><?php echo $heading;?></h3>
			</div>
			<div class="btn_right" style="text-align:right;"> <a href="<?php echo base_url()?>email_sms_blast" class="btn btn-primary"><i class="fa fa-chevron-left"
						aria-hidden="true"></i> Back</a> </div>
			<div class="clearfix"></div>
		</div>

		<?php if ($this->session->flashdata('success')!='') : // Display session data ?>
		<div class="alert alert-success alert-dismissible fade in text-center" id="success-alert" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
					aria-hidden="true">×</span>
			</button>
			<strong>Success!</strong> <?php echo $this->session->flashdata('success');?>
		</div>
		<?php endif; ?>

		<?php if ($this->session->flashdata('error') != '') : // Display session data ?>
		<div class="alert alert-warning alert-dismissible fade in text-center" id="warning-alert" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
					aria-hidden="true">×</span>
			</button>
			<strong><?php echo $this->session->flashdata('error');?></strong>
		</div>
		<?php endif; ?>
		<div class="row">
			<div class="col-md-12">
				<div class="x_panel">
					<div class="x_content">
						<form action="<?php echo base_url()?>email_sms_blast/delete_multiple_user" id="form_selected_record"
							method="post">
							<input type="hidden" name="website_id" value="<?php echo $website_id;?>">
							<div class="page_buut_right">
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
									<button type="button" class="btn btn-danger" id="delete_selected_record"
										name="delete-selected-portfolio-service">
										<i class="fa fa-trash-o" aria-hidden="true"></i>
										<span class="hide-on-small-only">Delete</span>
									</button>
								</div>
							</div>
							<?php echo $table;?>
						</form>
						<!-- Confirm Delete Modal -->
						<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
							aria-hidden="true">
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
										<button class="btn btn-default" data-dismiss="modal">Cancel</button>
										<a class="btn btn-danger" id="delete_btn_ok">Delete</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- page content -->