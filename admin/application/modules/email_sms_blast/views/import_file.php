<!-- page content -->
<div class="right_col" role="main">
	<div class="">
		<div class="clearfix"></div>

		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="">

					<div class="x_title">
						<h2><?php echo $heading;?></h2>

						<div class="btn-right">	
				<?php
					if($admin_user_id == '6'):
				?>
						<a href="<?php echo base_url();?>email_sms_blast" class="btn btn-primary">
							<i class="fa fa-upload"></i> Patients Import
						</a> 
						<a href="<?php echo base_url();?>email_sms_blast/get_all_patients" class="btn btn-primary">
							<i class="fa fa-upload"></i> Patients List
						</a>
						<a href="<?php echo base_url();?>email_sms_blast/campaign_category" class="btn btn-dark">
							<i class="fa fa-bomb" aria-hidden="true"></i>Campaign Category
						</a>
						<a href="<?php echo base_url();?>email_sms_blast/campaign" class="btn btn-dark">
							<i class="fa fa-bomb" aria-hidden="true"></i> Assign to Campaign
						</a>
						<a href="<?php echo base_url();?>email_sms_blast/send_email_blast_status" class="btn btn-danger">
							<i class="fa fa-envelope"></i> Send Mail
						</a>
						<a href="<?php echo base_url();?>email_sms_blast/send_sms_blast" class="btn btn-danger">
							<i class="fa fa-envelope"></i> Send SMS
						</a>
						<!--<a href="<?php echo base_url();?>email_sms_blast/send_fb_sms_blast" class="btn btn-primary">
							<i class="fa fa-bar-chart"></i> Send Fb SMS
						</a> -->
						<a href="<?php echo base_url();?>email_sms_blast/email_tracking" class="btn btn-warning">
							<i class="fa fa-flag"></i> Email Reports
						</a>
						<a href="<?php echo base_url();?>email_sms_blast/sms_tracking" class="btn btn-warning">
							<i class="fa fa-flag"></i> Sms Reports
						</a>
						<!--<a href="<?php echo base_url();?>email_sms_blast/facebook_tracking" class="btn btn-warning">
							<i class="fa fa-flag"></i> Facebook Reports
						</a>-->
						<a href="<?php echo base_url();?>email_sms_blast/new_patient" class="btn btn-primary">
							<i class="fa fa-bar-chart"></i> New Patient
						</a>
						<a href="<?php echo base_url();?>email_sms_blast/graphical_reports" class="btn btn-primary">
							<i class="fa fa-bar-chart"></i> Graphical Reports
						</a>
						
				<?php
					elseif($admin_user_id == '7'):
					?>
						<a href="<?php echo base_url();?>email_sms_blast" class="btn btn-primary">
							<i class="fa fa-upload"></i> Patients Import
						</a> 
						<a href="<?php echo base_url();?>email_sms_blast/get_all_patients" class="btn btn-primary">
							<i class="fa fa-upload"></i> Patients List
						</a>
						<a href="<?php echo base_url();?>email_sms_blast/campaign_category" class="btn btn-dark">
							<i class="fa fa-bomb" aria-hidden="true"></i>Campaign Category
						</a>
						<a href="<?php echo base_url();?>email_sms_blast/campaign" class="btn btn-dark">
							<i class="fa fa-bomb" aria-hidden="true"></i> Assign to Campaign
						</a>
						<a href="<?php echo base_url();?>email_sms_blast/send_email_blast_status" class="btn btn-danger">
							<i class="fa fa-envelope"></i> Send Mail
						</a>
						<a href="<?php echo base_url();?>email_sms_blast/send_sms_blast" class="btn btn-danger">
							<i class="fa fa-envelope"></i> Send SMS
						</a>
						<!--<a href="<?php echo base_url();?>email_sms_blast/send_fb_sms_blast" class="btn btn-primary">
							<i class="fa fa-bar-chart"></i> Send Fb SMS
						</a>-->
						<a href="<?php echo base_url();?>email_sms_blast/email_tracking" class="btn btn-warning">
							<i class="fa fa-flag"></i> Email Reports
						</a>
						<a href="<?php echo base_url();?>email_sms_blast/sms_tracking" class="btn btn-warning">
							<i class="fa fa-flag"></i> Sms Reports
						</a>
						<!--<a href="<?php echo base_url();?>email_sms_blast/facebook_tracking" class="btn btn-warning">
							<i class="fa fa-flag"></i> Facebook Reports
						</a>-->
						<a href="<?php echo base_url();?>email_sms_blast/new_patient" class="btn btn-primary">
							<i class="fa fa-bar-chart"></i> New Patient
						</a>
						<a href="<?php echo base_url();?>email_sms_blast/graphical_reports" class="btn btn-primary">
							<i class="fa fa-bar-chart"></i> Graphical Reports
						</a>
						
					<?php
					else:
				?>
						<a href="<?php echo base_url();?>email_sms_blast" class="btn btn-primary">
							<i class="fa fa-upload"></i> Patients Import
						</a> 
						<a href="<?php echo base_url();?>email_sms_blast/get_all_patients" class="btn btn-primary">
							<i class="fa fa-upload"></i> Patients List
						</a>
						<a href="<?php echo base_url();?>email_sms_blast/campaign_category" class="btn btn-dark">
							<i class="fa fa-bomb" aria-hidden="true"></i>Campaign Category
						</a>
						<a href="<?php echo base_url();?>email_sms_blast/campaign" class="btn btn-dark">
							<i class="fa fa-bomb" aria-hidden="true"></i>Assign to Campaign
						</a>
						<a href="<?php echo base_url();?>email_sms_blast/email_blast" class="btn btn-danger">
							<i class="fa fa-envelope"></i> Mail
						</a>
						<a href="<?php echo base_url();?>email_sms_blast/sms_blast" class="btn btn-success">
							<i class="fa fa-comment"></i> SMS
						</a>
						<a href="<?php echo base_url();?>email_sms_blast/reports" class="btn btn-warning">
							<i class="fa fa-rss"></i> Reports
						</a>
						<a href="<?php echo base_url();?>email_sms_blast/new_patient" class="btn btn-primary">
							<i class="fa fa-user"></i> New Patient
						</a>
						<a href="<?php echo base_url();?>email_sms_blast/graphical_reports" class="btn btn-primary">
							<i class="fa fa-bar-chart"></i> Graphical Reports
						</a>
						
				<?php
					endif;
				?>
			</div>
						<div class="clearfix"></div>
					</div>

					<div class="x_content">

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

						<br>
						
						<!-- Import CSV Files - Page One -->
						<?php if ($page_status == '1') :?>

							<form action="<?php echo base_url()?>email_sms_blast" method="POST"
								class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate autocomplete="off" enctype="multipart/form-data">
								
								<input type="hidden" name="website_id" id="website_id" value="<?php echo $website_id;?>">							

								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="x_panel">
										<div class="x_title">
											<h2>Import Master File</h2>
											<ul class="nav navbar-right panel_toolbox">
												<li>
													<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
												</li>
											</ul>

											<div class="clearfix"></div>
										</div>
										<div class="x_content">

											<div class="form-group">
												<label for="users" class="control-label col-md-3 col-sm-3 col-xs-12">
													Upload CSV File <span class="required">*</span>
												</label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<input type="file" name="users" class="form-control col-md-7 col-xs-12" id="users" required="required">
												</div>
											</div>
										</div>
									</div>
								</div>

								<!-- Button Group -->

								<div class="col-md-12 col-sm-12 col-xs-12">

									<div class="input-button-group">

										<input type="submit" class="btn btn-success" id="btn" name="import-csv-file" value="Field Map">

										<a href="<?php echo base_url()?>email_sms_blast" class="btn btn-primary" title="Back">Back</a>

									</div>

								</div>
								
							</form>

						<?php endif;?>

						<!-- Import CSV Files - Field Mapping - Page Two -->

						<?php if ($page_status == '2') :?>

							<form action="<?php echo base_url()?>email_sms_blast" method="POST"
								class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate autocomplete="off" enctype="multipart/form-data">
								
								<input type="hidden" name="website_id" id="website_id" value="<?php echo $website_id;?>">							
								<input type="hidden" name="file" id="file" value="<?php echo $file;?>">				

								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="x_panel">

										<div class="x_title">

											<h2>Field Mapping</h2>

											<ul class="nav navbar-right panel_toolbox">
												<li>
													<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
												</li>
											</ul>

											<div class="clearfix"></div>
										</div>

										<div class="x_content">
										<div class="form-group">
												<label for="name" class="control-label col-md-3 col-sm-3 col-xs-12">
													Patient Name <span class="required">*</span>
												</label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<select name="name" id="name" class="form-control col-md-7 col-xs-12" required="required">
														<?php foreach($csv_columns as $row){ ?>
														<option <?php echo $selected = (trim($row) == "Patient Name") ? "selected" : "";?> value="<?php echo trim($row); ?>"><?php echo trim($row); ?></option>
														<?php } ?>
													</select>
												</div>
											</div>

											<div class="form-group">
												<label for="email" class="control-label col-md-3 col-sm-3 col-xs-12">
													Patient Email <span class="required">*</span>
												</label>
												<div class="col-md-6 col-sm-6 col-xs-12">							
													<select name="email" id="email" class="form-control col-md-7 col-xs-12" required="required">
														<?php foreach($csv_columns as $row){ ?>
														<option <?php echo $selected = (trim($row) == "Patient Email") ? "selected" : "";?> value="<?php echo trim($row); ?>"><?php echo trim($row); ?></option>
														<?php } ?>
													</select>													
												</div>
											</div>
											<div class="form-group">
												<label for="facility_name" class="control-label col-md-3 col-sm-3 col-xs-12">
													Facility Name <span class="required">*</span>
												</label>
												<div class="col-md-6 col-sm-6 col-xs-12">							
													<select name="facility_name" id="facility_name" class="form-control col-md-7 col-xs-12" required="required">
														<?php foreach($csv_columns as $row){ ?>
														<option <?php echo $selected = (trim($row) == "Facility Name") ? "selected" : "";?> value="<?php echo trim($row); ?>"><?php echo trim($row); ?></option>
														<?php } ?>
													</select>													
												</div>
											</div>
											
											<div class="form-group">
												<label for="phone_number" class="control-label col-md-3 col-sm-3 col-xs-12">
													Cell Phone <span class="required">*</span>
												</label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<select name="phone_number" id="phone_number" class="form-control col-md-7 col-xs-12" required="required">
														<?php foreach($csv_columns as $row){ ?>
														<option <?php echo $selected = (trim($row) == "Patient Cell Phone") ? "selected" : "";?> value="<?php echo trim($row); ?>"><?php echo trim($row); ?></option>
														<?php } ?>
													</select>													
												</div>
											</div>
											
											<div class="form-group">
												<label for="visited-date" class="control-label col-md-3 col-sm-3 col-xs-12">
													Appoinment Date <span class="required">*</span>
												</label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<select name="visited_date" id="visited-date" class="form-control col-md-7 col-xs-12" required="required">
														<?php foreach($csv_columns as $row){ ?>
														<option <?php echo $selected = (trim($row) == "Appointment Date") ? "selected" : "";?> value="<?php echo trim($row); ?>"><?php echo trim($row); ?></option>
														<?php } ?>
													</select>													
												</div>
											</div>

											<div class="form-group">
												<label for="provider-name" class="control-label col-md-3 col-sm-3 col-xs-12">
													Provider Name <span class="required">*</span>
												</label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<select name="provider_name" id="provider-name" class="form-control col-md-7 col-xs-12" required="required">
														<?php foreach($csv_columns as $row) { ?>
														<option <?php echo $selected = (trim($row) == "Appointment Provider Name") ? "selected" : "";?> value="<?php echo trim($row); ?>"><?php echo trim($row); ?></option>
														<?php } ?>
													</select>													
												</div>
											</div>

										</div>
									</div>
								</div>

								<!-- Button Group -->

								<div class="col-md-12 col-sm-12 col-xs-12">

									<div class="input-button-group">

										<input type="submit" class="btn btn-success" id="btn" name="update-users" value="Import">

									</div>

								</div>
								
							</form>

						<?php endif;?>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /page content -->
