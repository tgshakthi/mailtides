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
						'email_blast',
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
						<a href="<?php echo base_url();?>/email_blast/resend_mail" class="btn btn-success">
							Resend Mail ( Not Opened )
						</a>

						<form action="<?php echo base_url()?>email_blast/delete_multiple_user" id="form_selected_record"
							method="post">						
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
.btn-right{
    text-align: right;
}
</style>