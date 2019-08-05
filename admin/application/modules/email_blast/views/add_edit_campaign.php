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

					<div class="x_content">						

						<?php
							// Break tag
							echo br();

							if ($page_status == '1') :

								// Form Tag
								echo form_open_multipart(
									'email_blast/field_map_campaign_users',
									'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate autocomplete="off"'
								);

								// Input tag hidden
								echo form_input(array(
									'type'  => 'hidden',
									'name'  => 'id',
									'id'    => 'id',
									'value' => $id
								));

								// Input tag hidden
								echo form_input(array(
									'type'  => 'hidden',
									'name'  => 'website_id',
									'id'    => 'website_id',
									'value' => $website_id
								));
						?>
					
						<div class="col-md-12 col-md-12 col-xs-12">
							<div class="x_panel">

								<div class="x_title">
									<?php
										echo heading('Campaign Details', '2');
										$list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
										$attributes = array('class' => 'nav navbar-right panel_toolbox');
										echo ul($list,$attributes);
									?>
									<div class="clearfix"></div>
								</div>

								<div class="x_content">

									<div class="form-group ">

										<?php
											echo form_label('Campaign Name','name');

											// Input tag
											echo form_input(array(
												'id'       => 'name',
												'name'     => 'name',
												'class'    => 'form-control col-md-6 col-sm-6 col-xs-12',
												'value'    => $campaign_name
											));
										?>
									<div class="form-group">

										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="campaign-name">
											Campaign Name 
											<span class="required">*</span>
										</label>

										<div class="col-md-6 col-sm-6 col-xs-12">
											<input type="text" name="campaign_name" id="campaign-name" required="required" class="form-control col-md-7 col-xs-12">
										</div>
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


								</form>

							</div>

							<div id="step-2">
								<h2 class="StepTitle">Campaign Users</h2>

								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
									<div class="email-blast-date">
										<div>
											<label>From Date:</label>
											<input type="text" id="min-campaign-users">
										</div>
										<div>
											<label>To Date:</label>
											<input type="text" id="max-campaign-users">
										</div>
									</div>
								</div>

								<button class="btn btn-default" id="filter-data-import">Import</button>

								<br />

								<?php echo $table;?>
								<br/>
							</div>

							<div id="step-3">
								<h2 class="StepTitle">Step 3 Content</h2>
								<p>
									sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
									veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
									consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum
									dolore
									eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
									culpa qui officia deserunt mollit anim id est laborum.
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
<!-- /page content -->