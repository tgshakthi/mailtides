<!-- page content -->
<div class="right_col" role="main">
	<div class="">
		<div class="page-title">

			<div class="title_left">
				<h3><?php echo $heading;?></h3>
			</div>

			<div class="btn-right">	
				<?php
					if($admin_user_id == '6'):
				?>
						<a href="<?php echo base_url();?>email_blasts/import_master_file" class="btn btn-primary">
							<i class="fa fa-upload"></i> Import Patient Master File
						</a>
						<a href="<?php echo base_url();?>email_blasts/email_tracking" class="btn btn-warning">
							<i class="fa fa-flag"></i> Email Reports
						</a>
						<a href="<?php echo base_url();?>email_blasts/sms_tracking" class="btn btn-warning">
							<i class="fa fa-flag"></i> Sms Reports
						</a>

						<a href="<?php echo base_url();?>email_blasts/graphical_reports" class="btn btn-primary">
							<i class="fa fa-bar-chart"></i> Graphical Reports
						</a>
						<a href="<?php echo base_url();?>email_blasts/new_patient" class="btn btn-dark">
							<i class="fa fa-bomb" aria-hidden="true"></i> New Patient
						</a>
						<!--<a href="<?php echo base_url();?>email_blasts/campaign_type_reports" class="btn btn-info">
							<i class="fa fa-bar-chart"></i> BI Reports
						</a>-->
						<a href="<?php echo base_url();?>email_blasts/campaign" class="btn btn-dark">
							<i class="fa fa-bomb" aria-hidden="true"></i> Campaign
						</a>

						<!--<a href="<?php echo base_url();?>email_blasts/send_email_blast_status" class="btn btn-danger">
							<i class="fa fa-envelope"></i> Send Mail
						</a>
						
						<a href="<?php echo base_url();?>email_blasts/send_sms_blast" class="btn btn-danger">
							<i class="fa fa-envelope"></i> Send SMS
						</a>-->
						<a href="<?php echo base_url();?>email_blasts/send_sms_import_data_view" class="btn btn-danger">
							<i class="fa fa-envelope"></i> Send SMS & Email
						</a>
				<?php
					elseif($admin_user_id == '7'):
					?>
						<a href="<?php echo base_url();?>email_blasts/import_master_file" class="btn btn-primary">
							<i class="fa fa-upload"></i> Import Patient Master File
						</a>
						<a href="<?php echo base_url();?>email_blasts/email_tracking" class="btn btn-warning">
							<i class="fa fa-flag"></i> Email Reports
						</a>
						<a href="<?php echo base_url();?>email_blasts/sms_tracking" class="btn btn-warning">
							<i class="fa fa-flag"></i> Sms Reports
						</a>

						<a href="<?php echo base_url();?>email_blasts/graphical_reports" class="btn btn-primary">
							<i class="fa fa-bar-chart"></i> Graphical Reports
						</a>
						<a href="<?php echo base_url();?>email_blasts/new_patient" class="btn btn-dark">
							<i class="fa fa-bomb" aria-hidden="true"></i> New Patient
						</a>
						<a href="<?php echo base_url();?>email_blasts/campaign" class="btn btn-dark">
							<i class="fa fa-bomb" aria-hidden="true"></i> Campaign
						</a>

						<!--<a href="<?php echo base_url();?>email_blasts/send_email_blast_status" class="btn btn-danger">
							<i class="fa fa-envelope"></i> Send Mail
						</a>
						
						<a href="<?php echo base_url();?>email_blasts/send_sms_blast" class="btn btn-danger">
							<i class="fa fa-envelope"></i> Send SMS
						</a>-->
						<a href="<?php echo base_url();?>email_blasts/send_sms_import_data_view" class="btn btn-danger">
							<i class="fa fa-envelope"></i> Send SMS & Email
						</a>
					<?php
					else:
				?>
						<a href="<?php echo base_url();?>email_blasts/import_master_file" class="btn btn-primary">
							<i class="fa fa-upload"></i> Import Patient Master File
						</a>
						
						<a href="<?php echo base_url();?>email_blasts/email_template" class="btn btn-warning">
							<i class="fa fa-inbox" aria-hidden="true"></i> Email Template
						</a>
						<a href="<?php echo base_url();?>email_blasts/sms_template" class="btn btn-warning">
							<i class="fa fa-inbox" aria-hidden="true"></i> Sms Template
						</a>
						<!--<a href="<?php echo base_url();?>email_blasts/campaign_type" class="btn btn-info">
							<i class="fa fa-drumstick-bite" aria-hidden="true"></i> Campaign Type
						</a>-->
						<a href="<?php echo base_url();?>email_blasts/campaign_category" class="btn btn-dark">
							<i class="fa fa-bomb" aria-hidden="true"></i> Campaign Category
						</a>
						<a href="<?php echo base_url();?>email_blasts/campaign" class="btn btn-dark">
							<i class="fa fa-bomb" aria-hidden="true"></i> Campaign
						</a>

						<!--<a href="<?php echo base_url();?>email_blasts/send_email_blast_status" class="btn btn-danger">
							<i class="fa fa-envelope"></i> Send Mail
						</a>
						
						<a href="<?php echo base_url();?>email_blasts/send_sms_blast" class="btn btn-danger">
							<i class="fa fa-envelope"></i> Send SMS
						</a>-->
						<a href="<?php echo base_url();?>email_blasts/send_sms_import_data_view" class="btn btn-danger">
							<i class="fa fa-envelope"></i> Send SMS & Email
						</a>

						<a href="<?php echo base_url();?>email_blasts/email_tracking" class="btn btn-warning">
							<i class="fa fa-flag"></i> Email Reports
						</a>
						<a href="<?php echo base_url();?>email_blasts/sms_tracking" class="btn btn-warning">
							<i class="fa fa-flag"></i> Sms Reports
						</a>

						<a href="<?php echo base_url();?>email_blasts/graphical_reports" class="btn btn-primary">
							<i class="fa fa-bar-chart"></i> Graphical Reports
						</a>
						<a href="<?php echo base_url();?>email_blasts/campaign_type_reports" class="btn btn-info">
							<i class="fa fa-bar-chart"></i> BI Reports
						</a>
						<a href="<?php echo base_url();?>email_blasts/new_patient" class="btn btn-dark">
							<i class="fa fa-bomb" aria-hidden="true"></i> New Patient
						</a>
				<?php
					endif;
				?>
				

			</div>

		</div>

		<div class="clearfix"></div>

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
						<form action="<?php echo base_url()?>email_blast/delete_multiple_user" id="form_selected_record"
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
							

							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<div class="email-blast-date">
									<div>
										<label>From Date:</label>
										<input type="text" id="min">
									</div>
									<div>
										<label>To Date:</label>
										<input type="text" id="max">

									</div>
								</div>
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