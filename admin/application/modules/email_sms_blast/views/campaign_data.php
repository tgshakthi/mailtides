<!-- page content -->
<div class="right_col" role="main">

	<div class="">

		<div class="page-title">

			<div class="title_left">
				<?php echo heading($heading, '3');?>
			</div>

			<div class="btn-right" style="text-align:right;">	
				<?php
					echo anchor(
					'email_sms_blast',
					'<i class="fa fa-chevron-left" aria-hidden="true"></i> Back',
					array(
						'class' => 'btn btn-primary'
					));
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
	</div>

	<div class="x_panel">

		<div class="x_content">
			<div class="page_buut_right">
			<?php
				foreach($campaign_datas as $campaign_data):
			?>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
						<a href='<?php echo base_url();?>email_sms_blast/campaign_import/<?php echo $campaign_data->id;?>' class="btn btn-warning">
							<i class="fa fa-flag"></i><?php echo $campaign_data->category;?>
						</a>
					</div>
			<?php
				endforeach;
			?>				
			</div>

			<div class="row">
				<?php
					// Table
					//echo $table;
				?>
			</div>

			<?php echo form_close();?>

			<!-- Confirm Delete Modal -->
			<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
							<?php
								echo form_button(array(
									'type'         => 'button',
										'class'        => 'btn btn-default',
										'data-dismiss' => 'modal',
										'content'      => 'Cancel'
								));
								?>
								<a class="btn btn-danger" id="delete_btn_ok">Delete</a>
						</div>

					</div>
				</div>
      		</div>

		</div>

	</div>
</div>
<!-- Page Content -->
