
<!-- page content -->
<div class="right_col" role="main">
	<div class="">
		<div class="clearfix"></div>
		<div id="loader"></div>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="">

					<div class="x_title">
						<h2><?php echo $heading;?></h2>

						<div class="btn_right" style="text-align:right;">
							<a href="<?php echo base_url()?>email_blast" class="btn btn-primary"><i class="fa fa-chevron-left"
									aria-hidden="true"></i> Back</a>
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

						<form action="<?php echo base_url()?>email_blast/send_mail_based_on_campaign" method="POST"
							class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate autocomplete="off" enctype="multipart/form-data">
							
							<input type="hidden" name="website_id" id="website_id" value="<?php echo $website_id;?>">
							<input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">							

							<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="x_panel">
									<div class="x_title">
										<h2>Send Mail</h2>
										<ul class="nav navbar-right panel_toolbox">
											<li>
												<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
											</li>
										</ul>

										<div class="clearfix"></div>
									</div>
									<div class="x_content">

									<div class="form-group">
                                            <label for="campaign-id" class="control-label col-md-3 col-sm-3 col-xs-12">
                                                Select Campaign
												<span class="required">*</span>
                                            </label>

                                            <div class="col-md-6 col-sm-6 col-xs-12">
												<input type="hidden" id="hidden-selected-id">
                                                <select name="campaign" class="form-control col-md-7 col-xs-12" id="campaign_id" required="required"  >

													<option value="">Select Campaign</option>                                                   
													<?php foreach($campaign_details as $campaign):
													 ?>
													  <option value="<?php echo $campaign->id ?>"><?php echo $campaign->campaign_name; ?></option>
													 <?php endforeach; ?>
                                                </select>
                                            </div>
                                    
									</div>
									 <div class="form-group">

                                                    <?php
													echo form_label('Subject <span class="required">*</span>','subject','class="control-label col-md-3 col-sm-3 col-xs-12"');
													?>

                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <?php
														// Input tag
														echo form_input(array(
															'id'       => 'subject',
															'name'     => 'subject',
															'required'=>'required',
															'class'    => 'form-control col-md-7 col-xs-12'
														
														));
														?>
                                                    </div>

                                                </div>
									
									     <div class="form-group">

                                                    <?php
													echo form_label('From Name <span class="required">*</span>','from_name','class="control-label col-md-3 col-sm-3 col-xs-12"');
													?>

                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <?php
															// Input tag
															echo form_input(array(
																'id'       => 'from_name',
																'name'     => 'from_name',
																'required'=>'required',
																'class'    => 'form-control col-md-7 col-xs-12',
																'value'=>'Digestive & Liver Disease Consultants , P.A'
															));
														?>
                                                    </div>

                                                </div>
												
									       <div class="form-group">

                                                    <?php
													echo form_label('From Email <span class="required">*</span>','from_email','class="control-label col-md-3 col-sm-3 col-xs-12"');
													?>

                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <?php
														// Input tag
														echo form_input(array(
															'id'       => 'from_email',
															'name'     => 'from_email',
															'required' => 'required',
															'class'    => 'form-control col-md-7 col-xs-12',
															'value' => $email
															
														));
														?>
                                                    </div>

                                             </div>
												<?php 
												
											echo form_input(array(
												'type'  => 'hidden',
												'name'  => 'image_url',
												'id'    => 'image_url',
												'value' => $ImageUrl
											));

											echo form_input(array(
												'type'  => 'hidden',
												'name'  => 'httpUrl',
												'id'    => 'httpUrl',
												'value' => $httpUrl
											));
											?>

											<div cass="form-group">
												<div class= "col-md-6 col-sm-6 col-xs-12 col-sm-offset-3">
													<a data-toggle="modal" class="btn btn-primary" id="preview_template" data-target="#ImagePopUp"> 
														Preview Template 
													</a>
												</div>
											</div>
								</div>
							</div>

							<!-- Button Group -->

							<div class="col-md-12 col-sm-12 col-xs-12 ">
								<div class="input-button-group">									
									<input type="submit" class="btn btn-success" id="btn" value="Send">
									<a href="<?php echo base_url()?>email_blast" class="btn btn-primary" title="Back">Back</a>
								</div>
                            </div>
                            
						</form>
						<div class="modal fade" id="preview-template-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">

							<div class="modal-header">
								Email Template Preview
							</div>

							<div class="modal-body" id="modal-body-img" style="text-align: center;"> 
							
								
							</div>

							<div class="modal-footer">								
									<a class="btn btn-danger" id="btn_ok" data-dismiss="modal">close</a>
							</div>

					</div>
				</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- /page content -->
