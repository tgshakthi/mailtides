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
						<a href="<?php echo base_url();?>email_sms_blast/import_master_file" class="btn btn-primary">
							<i class="fa fa-upload"></i> Import Patient Master File
						</a>
						<a href="<?php echo base_url();?>email_sms_blast/get_all_patients" class="btn btn-primary">
							<i class="fa fa-upload"></i> Patients
						</a>
						<a href="<?php echo base_url();?>email_sms_blast/campaign" class="btn btn-dark">
							<i class="fa fa-bomb" aria-hidden="true"></i> Campaign
						</a>
						<a href="<?php echo base_url();?>email_sms_blast/send_email_blast_status" class="btn btn-danger">
							<i class="fa fa-envelope"></i> Send Mail
						</a>
						<a href="<?php echo base_url();?>email_sms_blast/send_sms_blast" class="btn btn-danger">
							<i class="fa fa-envelope"></i> Send SMS
						</a>
						<a href="<?php echo base_url();?>email_sms_blast/email_tracking" class="btn btn-warning">
							<i class="fa fa-flag"></i> Email Reports
						</a>
						<a href="<?php echo base_url();?>email_sms_blast/sms_tracking" class="btn btn-warning">
							<i class="fa fa-flag"></i> Sms Reports
						</a>
						<a href="<?php echo base_url();?>email_sms_blast/graphical_reports" class="btn btn-primary">
							<i class="fa fa-bar-chart"></i> Graphical Reports
						</a>
						
				<?php
					elseif($admin_user_id == '7'):
					?>
						<a href="<?php echo base_url();?>email_sms_blast/import_master_file" class="btn btn-primary">
							<i class="fa fa-upload"></i> Import Patient Master File
						</a>
						<a href="<?php echo base_url();?>email_sms_blast/get_all_patients" class="btn btn-primary">
							<i class="fa fa-upload"></i> Patients
						</a>
						<a href="<?php echo base_url();?>email_sms_blast/campaign" class="btn btn-dark">
							<i class="fa fa-bomb" aria-hidden="true"></i> Campaign
						</a>
						<a href="<?php echo base_url();?>email_sms_blast/send_email_blast_status" class="btn btn-danger">
							<i class="fa fa-envelope"></i> Send Mail
						</a>
						<a href="<?php echo base_url();?>email_sms_blast/send_sms_blast" class="btn btn-danger">
							<i class="fa fa-envelope"></i> Send SMS
						</a>
						<a href="<?php echo base_url();?>email_sms_blast/email_tracking" class="btn btn-warning">
							<i class="fa fa-flag"></i> Email Reports
						</a>
						<a href="<?php echo base_url();?>email_sms_blast/sms_tracking" class="btn btn-warning">
							<i class="fa fa-flag"></i> Sms Reports
						</a>
						<a href="<?php echo base_url();?>email_sms_blast/graphical_reports" class="btn btn-primary">
							<i class="fa fa-bar-chart"></i> Graphical Reports
						</a>
						
					<?php
					else:
				?>
						<a href="<?php echo base_url();?>email_sms_blast/import_master_file" class="btn btn-primary">
							<i class="fa fa-upload"></i> Import Patient Master File
						</a>
						<a href="<?php echo base_url();?>email_sms_blast/get_all_patients" class="btn btn-primary">
							<i class="fa fa-upload"></i> Patients
						</a>
						<a href="<?php echo base_url();?>email_sms_blast/campaign" class="btn btn-dark">
							<i class="fa fa-bomb" aria-hidden="true"></i> Campaign
						</a>
						<a href="<?php echo base_url();?>email_sms_blast/send_email_blast_status" class="btn btn-danger">
							<i class="fa fa-envelope"></i> Send Mail
						</a>
						<a href="<?php echo base_url();?>email_sms_blast/send_sms_blast" class="btn btn-danger">
							<i class="fa fa-envelope"></i> Send SMS
						</a>
						<a href="<?php echo base_url();?>email_sms_blast/email_tracking" class="btn btn-warning">
							<i class="fa fa-flag"></i> Email Reports
						</a>
						<a href="<?php echo base_url();?>email_sms_blast/sms_tracking" class="btn btn-warning">
							<i class="fa fa-flag"></i> Sms Reports
						</a>
						
						<a href="<?php echo base_url();?>email_sms_blast/graphical_reports" class="btn btn-primary">
							<i class="fa fa-bar-chart"></i> Graphical Reports
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
						<form action="<?php echo base_url()?>email_sms_blast/delete_multiple_user" id="form_selected_record"
							method="post">
							<input type="hidden" name="website_id" value="<?php echo $website_id;?>">
							
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