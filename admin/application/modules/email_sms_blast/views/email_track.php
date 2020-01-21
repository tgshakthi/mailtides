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
							<!-- <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
							
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
							<table id="datatable-email"
								class="table table-striped table-bordered dt-responsive nowrap jambo_table bulk_action" width="100%"
								cellspacing="0">

								<thead>
									<tr>
										<th>Name</th>
										<th>Email</th>
										<th>Cell Phone</th>
										<th>Provider Name</th>
										<th>Email Sent Date</th>										
										<th>Email Status</th>
										<th>Email Open Date</th>
										<th>Tiny Url</th>
										<th>Resend Mail</th>
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
									<?php 							
									foreach (($email_tracks ? $email_tracks : array()) as $email_track) :								
										if(!empty($email_track['email'])):
											$user_id = $email_track['id'];
											$email = $email_track['email'];
											if(!empty($email_track['name']))
											{
												$patient_name = $email_track['name'];
											}
											if(!empty($email_track['provider_name']))
											{
												$provider_name = $email_track['provider_name'];
											}
											
											if(!empty($email_track['phone_number']))
											{
												$phone_number = $email_track['phone_number'];
											}
											if(!empty($email_track['email_sent_date']))
											{
												$email_sent_date = $email_track['email_sent_date'];
											}else{
												$email_sent_date = '';
											}
											if(!empty($email_track['email_open_date']))
											{
												$email_open_date = $email_track['email_open_date'];
											}else{
												$email_open_date = "";
											}
											
											if ($email_track['email_link_open'] === '1') {
												$email_status = '<span class="label label-success">Open</span>';
											} else {
												$email_status = '<span class="label label-danger">Not Open</span>';
											}
											
											if ($email_track['email_link_open'] === '0' && $email_track['resend_sms'] === '0')  {
												$resend_status = '<span class="label label-success"><a href="resend_email/'.$user_id.'">Resend</a></span>';
											} else {
												$resend_status = '<span class="label label-danger"></span>';
											}
																		
										?>
									<tr>
										<td><?php echo $patient_name;?></td>
										<td><?php echo trim($email);?></td>
										<td><?php echo $phone_number;?></td>
										<td><?php echo $provider_name;?></td>
										<td><?php echo $email_sent_date;?></td>
										<td><?php echo $email_status;?></td>
										<td><?php echo $email_open_date;?></td>
										<td><?php echo $email_track['email_tiny_url'];?></td>
										<td><?php echo $resend_status;?></td>
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
