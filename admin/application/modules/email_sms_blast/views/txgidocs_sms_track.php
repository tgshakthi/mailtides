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
						'email_sms_blast',
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
							<!--<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
							
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
								</div> -->

							<table id="datatable-sms"
								class="table table-striped table-bordered dt-responsive nowrap jambo_table bulk_action" width="100%"
								cellspacing="0">

								<thead>
									<tr>
										<th>Name</th>
										<th>Email</th>
										<th>Cell Phone</th>
										<th>provider Name</th>
										<th>Dldc SMS Sent Date</th>
										<th>Dldc SMS Status</th>
										<th>Dldc SMS Open Date</th>
										<th>Tiny Url</th>
										<th>Resend Dldc SMS</th>
									</tr>
									<tr id="filters">
										<th></th>
										<th></th>
										<th></th>
										<th></th>
										<th></th>
										<th></th>
										<th></th>
										<th></th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<?php foreach (($txgidocs_tracks ? $txgidocs_tracks : array()) as $txgidocs_track) : 
									
										if(!empty($txgidocs_track['phone_number'])):
											$user_id = $txgidocs_track['id'];
											
											if ($txgidocs_track['fb_link_open'] === '1') {
												$txgidocs_sms_status = '<span class="label label-success">Open</span>';
												$resend_sms = '<span class="label label-danger"></span>';
											} else {
												$txgidocs_sms_status = '<span class="label label-danger">Not Open</span>';
												$resend_sms = '<span class="label label-success"><a href="resend_fb_sms/'.$user_id.'">Resend</a></span>';
											}
										
										?>

									<tr>
										<td><?php echo $txgidocs_track['name'];?></td>
										<td><?php echo trim($txgidocs_track['email']);?></td>
										<td><?php echo $txgidocs_track['phone_number'];?></td>
										<td><?php echo $txgidocs_track['provider_name'];?></td>
										<td><?php echo $txgidocs_track['dldc_sms_sent_date'];?></td>
										<td><?php echo $txgidocs_sms_status;?></td>
										<td><?php echo $txgidocs_track['dldc_sms_open_date'];?></td>
										<td><?php echo $txgidocs_track['dldc_sms_tiny_url'];?></td>
										<td><?php echo $resend_sms;?></td>
									</tr>

									<?php endif;
											endforeach;?>
								</tbody>

							</table>


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
