<!-- page content -->
<div class="right_col" role="main">
	<div class="">
		<div class="page-title">

			<div class="title_left">
				<h3><?php echo $heading;?></h3>
			</div>

			<div class="btn-right">
				<?php
					echo anchor(
						'email_sms_blast/reports',
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
								<?php echo $table;?>							
						</form>
						<!-- Confirm Delete Modal -->
					
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- page content -->

<style>
#filters th select {
	color: black !important;
}
</style>
