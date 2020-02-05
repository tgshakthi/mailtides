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
						'email_blasts',
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
						<!--<a href="<?php echo base_url();?>/email_blasts/resend_mail" class="btn btn-success">
							Resend Mail ( Not Opened )
						</a>-->

						<form action="<?php echo base_url()?>email_blasts/delete_multiple_user" id="form_selected_record"
							method="post">				
									
							<?php //echo $table;?>
							

							<table id="datatable-sms"
								class="table table-striped table-bordered dt-responsive nowrap jambo_table bulk_action" width="100%"
								cellspacing="0">

								<thead>
									<tr>
										<th>Name</th>
										<th>Email</th>
										<th>Cell Phone</th>
										<th>Campaign Name</th>
										<!--<th>Txgidocs</th>
										<th>Google</th>
										<th>Facebook</th>
										<th>Comments</th>-->
										<!--<th>Email Status</th>-->
										<th>SMS Sent Date</th>
										<th>SMS Status</th>
										<th>SMS Open Date</th>
									</tr>
									<tr id="filters">
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
									<?php foreach (($sms_tracks ? $sms_tracks : array()) as $sms_track) : 
										if(!empty($sms_track->phone_number)):
											$campaign_name = $this->Email_blasts_model->get_campaign_by_id($sms_track->campaign_id);

											if (!empty($campaign_name)) {
											  $camp_name = $campaign_name[0]->campaign_name;
											} else {
											  $camp_name = "";
											}
											
											/* if ($sms_track->link_opened === '1') {
												$email_status = '<span class="label label-success">Open</span>';
											} else {
												$email_status = '<span class="label label-danger">Not Open</span>';
											} */
											if ($sms_track->sms_link_opened === '1') {
												$sms_status = '<span class="label label-success">Open</span>';
											} else {
												$sms_status = '<span class="label label-danger">Not Open</span>';
											}
								
											/* $reviews_entry= $this->Email_blasts_model->get_review_comments($email_track->track_id);
											if( !empty($reviews_entry[0]->review_user_id)):
											  $comment = '<span class="label label-success">Posted</span>';
											else:
											  $comment = '<span class="label label-danger">Not Posted</span>';
											endif; */
								
											 // Clicked From
											 if ($sms_track->txgidocs === '1') {
													$txgidocs = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
												} else {
													$txgidocs = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
												}
												if ($sms_track->google === '1') {
													$google = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
												} else {
													$google = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
												}
												if ($sms_track->facebook === '1') {
													$facebook = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
												} else {
													$facebook = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
												}									
										?>

									<tr>
										<td><?php echo $sms_track->name;?></td>
										<td><?php echo trim($sms_track->email);?></td>
										<td><?php echo $sms_track->phone_number;?></td>
										<td><?php echo $camp_name;?></td>
										<td><?php echo $sms_track->sms_sent_date;?></td>
										<td><?php echo $sms_status;?></td>
										<td><?php echo $sms_track->sms_open_date;?></td>
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
