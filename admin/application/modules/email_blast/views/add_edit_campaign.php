<!-- page content -->
<div class="right_col" role="main">
	<div class="">

		<div class="page-title">
			<div class="title_left">
				<h3>Campaign</h3>				
			</div>
			<div class="btn_right" style="text-align:right;">
				<a href="<?php echo base_url();?>email_blast/campaign" class="btn btn-primary">
					<i class="fa fa-chevron-left"></i> 
					Back
				</a>
			</div>
		</div>

		<div class="clearfix"></div>

		<div class="row">

			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h2><?php echo $heading;?></h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">


						<!-- Smart Wizard -->
						<div id="wizard" class="form_wizard wizard_horizontal">

							<ul class="wizard_steps">
								<li>
									<a href="#step-1">
										<span class="step_no">1</span>
										<span class="step_descr">
											Step 1<br />
											<small>Campaign Details</small>
										</span>
									</a>
								</li>
								<li>
									<a href="#step-2">
										<span class="step_no">2</span>
										<span class="step_descr">
											Step 2<br />
											<small>Import Campaign Users</small>
										</span>
									</a>
								</li>
								<li>
									<a href="#step-3">
										<span class="step_no">3</span>
										<span class="step_descr">
											Step 3<br />
											<small>Email Template</small>
										</span>
									</a>
								</li>
								<!-- <li>
									<a href="#step-4">
										<span class="step_no">4</span>
										<span class="step_descr">
											Step 4<br />
											<small>Step 4 description</small>
										</span>
									</a>
								</li> -->
							</ul>

							<div id="step-1">
								<h2 class="StepTitle">Campaign Details</h2>

								<form class="form-horizontal form-label-left">
									<input type="hidden" name="base-url" id="base-url" value="<?php echo base_url();?>">						
									<input type="hidden" name="campaign-id" id="campaign-id">

									<div class="form-group">

										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="campaign-name">
											Campaign Name 
											<span class="required">*</span>
										</label>

										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="text" name="campaign_name" id="campaign-name" required="required" class="form-control col-md-7 col-xs-12">
											
										</div>

										<span id='error' class="control-label col-md-2 col-sm-2 col-xs-12"></span>
										
									</div>
									

									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="text">
											Description 
											<span class="required">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<textarea name="description" id="text"></textarea>
										</div>
									</div>	

									<div class="form-group">
										<label for="campaign-type" class="control-label col-md-3 col-sm-3 col-xs-12">
											Campaign Type
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<select name="campaign-type" id="campaign-type" class="form-control">
												<?php foreach (($campaign_type ? $campaign_type : array()) as $camp_type) :?>
												<option value="<?php echo $camp_type->id;?>"><?php echo $camp_type->campaign_type;?></option>
												<?php endforeach;?>
											</select>
										</div>
									</div>

									<div class="form-group">
										<label for="send-date" class="control-label col-md-3 col-sm-3 col-xs-12">
											Send Date
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="text" name="send-date" class="form-control col-md-7 col-xs-12" id="send-date">
										</div>
									</div>							


								</form>

							</div>

							<div id="step-2">
								<h2 class="StepTitle">Campaign Users</h2>
								
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<input type="hidden" name="email_blast_users" id="email_blast_uesrs" value="<?php echo $email_blast_users ;?>">
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

								<button class="btn btn-default" id="filter-data-import">Import</button>

								<br />

								<?php echo $table;?>
								<br/>
							</div>

							<div id="step-3">
								<h2 class="StepTitle col-md-6 col-md-offset-3 col-xs-6">Choose Email Template</h2>
								<select name="email-template" id="email-template" class="col-md-6 col-md-offset-3 col-xs-6" style="padding: 10px;">
									<option value="">Select Template</option>
									<?php foreach (($email_templates ? $email_templates : array()) as $email_template) :?>
										<option value="<?php echo $email_template->id;?>"><?php echo $email_template->template_name;?></option>
									<?php endforeach;?>
								</select>
								<div class="clearfix"></div>
								<div class="preview-template-container"></div>
							</div>

							<!-- <div id="step-4">
								<h2 class="StepTitle">Step 4 Content</h2>
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
									incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
									exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
									Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
									fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa
									qui officia deserunt mollit anim id est laborum.
								</p>
								<p>
									Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
									incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
									exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute
									irure dolor
									in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
									Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
									mollit anim id est laborum.
								</p>
								<p>
									Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
									incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
									exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute
									irure dolor
									in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
									Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
									mollit anim id est laborum.
								</p>
							</div> -->

						</div>
						<!-- End SmartWizard Content -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- page content -->