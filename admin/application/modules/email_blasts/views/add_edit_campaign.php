<!-- page content -->
<div class="right_col" role="main">
	<div class="">

		<div class="page-title">
			<div class="title_left">
				<h3>Campaign</h3>				
			</div>
			<div class="btn_right" style="text-align:right;">
				<a href="<?php echo base_url();?>email_blasts/campaign" class="btn btn-primary">
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
											<small id="templates">Template</small>
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
									<input type="hidden" name="campaign-id" id="campaign-id" value="<?php echo $id;?>">
									<?php
										// Input tag hidden
										echo form_input(array(
											'type'  => 'hidden',
											'name'  => 'category_url',
											'id'    => 'category_url',
											'value' => base_url().'email_blasts/select_campaign_category'
										));
										
										// Input tag hidden
										echo form_input(array(
											'type'  => 'hidden',
											'name'  => 'category_select_url',
											'id'    => 'category_select_url',
											'value' => base_url().'email_blasts/selected_category'
											));
									?>
									
									<div class="form-group">

										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="campaign-name">
											Campaign Category 
											<span class="required">*</span>
										</label>

										<div class="col-md-6 col-sm-6 col-xs-12">
                                            <?php
												
												$campaign_category_options[''] = 'Please Select';
												foreach ($campaign_categories as $campaign_category) :
													$campaign_category_options[$campaign_category->id] = $campaign_category->category;
												endforeach;
												if(!empty($campaign_category_id)):
													$campaign_category_attributes = array(
																					  'id'       => 'campaign_category_id',
																					  'name'     => 'campaign_category_id',
																					  'required' => 'required',
																					  'disabled' => 'disabled',
																					  'class'    => 'form-control col-md-7 col-xs-12'
																					);
												else:
													$campaign_category_attributes = array(
																					  'id'       => 'campaign_category_id',
																					  'name'     => 'campaign_category_id',
																					  'required' => 'required',
																					  'class'    => 'form-control col-md-7 col-xs-12'
																					);
												endif;
												
												// Dropdown
												echo form_dropdown(
																  $campaign_category_attributes,
																  $campaign_category_options,
																  $campaign_category_id
																);
											
                                            ?>
                                        </div>
                                        <div class="col-md-1 col-sm-1 col-xs-12">
                                            <?php
												// Add Category Button
												echo form_button(array(
													'title'      => 'Add Category',
													'type'       => 'button',
													'class'      => 'btn btn-success btn-add',
													'data-toggle' => 'modal',
													'data-target' => '#add_campaign_category',
													'content'    => '<span class="glyphicon glyphicon-plus"></span>'
												));
                                            ?>
                                        </div>							
									</div>
									
									<div class="form-group">

										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="campaign-name">
											Campaign Name 
											<span class="required">*</span>
										</label>

										<div class="col-md-6 col-sm-6 col-xs-12">
											<?php
												if(!empty($campaign_name)):
													$readonly ='disabled';
												else:
													$readonly = '';
												endif;
											?>
											<input type="text" name="campaign_name" id="campaign-name" <?php echo $readonly;?> value="<?php echo $campaign_name;?>" required="required" class="form-control col-md-7 col-xs-12">
											
										</div>

										<span id='error' class="control-label col-md-2 col-sm-2 col-xs-12"></span>
										
									</div>
									

									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="text">
											Description 
											<span class="required">*</span>
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<?php
												if(!empty($description)):
													$readonly ='disabled';
												else:
													$readonly = '';
												endif;
											?>
											<textarea name="description" id="text" <?php echo $readonly;?>><?php echo $description;?></textarea>
										</div>
									</div>	

									<div class="form-group">
										<label for="campaign-type" class="control-label col-md-3 col-sm-3 col-xs-12">
											Campaign Type
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
										<?php
											$camp_type_options = array(
																	'' => 'Please Select',
																	'email'	=> 'Email',
																	'sms' => 'SMS'
																);
											/* $camp_type_options[''] = 'Please Select';
												foreach ($campaign_types as $camp_type) :
													$camp_type_options[$camp_type->id] = $camp_type->campaign_type;
												endforeach; */
												if(!empty($campaign_type)):
													$camp_type_attributes = array(
																				'id'       => 'campaign-type',
																				'name'     => 'campaign-type',
																				'required' => 'required',
																				'class'    => 'form-control',
																				'disabled' => 'disabled'
																				);
												else:
													$camp_type_attributes = array(
																				'id'       => 'campaign-type',
																				'name'     => 'campaign-type',
																				'required' => 'required',
																				'onchange' => 'changetemplate()',
																				'class'    => 'form-control'									
																				);
												endif;
												// Dropdown
												echo form_dropdown(
																  $camp_type_attributes,
																  $camp_type_options,
																  $campaign_type
																);
											?>
											<!--<select name="campaign-type" id="campaign-type" class="form-control">
												<?php foreach (($campaign_type ? $campaign_type : array()) as $camp_type) :?>
												<option value="<?php echo $camp_type->id;?>"><?php echo $camp_type->campaign_type;?></option>
												<?php endforeach;?>
											</select>-->
										</div>
									</div>

									<div class="form-group">
										<label for="send-date" class="control-label col-md-3 col-sm-3 col-xs-12">
											Send Date
										</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
										<?php
											if(!empty($send_date)):
												$readonly ='disabled';
											else:
												$readonly = '';
											endif;
										?>
											<input type="text" name="send-date" class="form-control col-md-7 col-xs-12" <?php echo $readonly;?> id="send-date" value="<?php echo $send_date;?>">
										</div>
									</div>							


								</form>
								<?php
                        echo form_open(
                            'email_blasts/insert_campaign_category',
                            'id="form_selected_records"'
                        );
                        ?>
                        
                        <!-- Add Category Modal -->
                        <div class="modal fade" id="add_campaign_category" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    
                                    <div class="modal-header">
                                        <?php
                                        // Modal Close Button
                                        echo form_button(array(
                                            'title'        => 'Close',
                                            'class'	    => 'close',
                                            'type'         => 'button',
                                            'data-dismiss' => 'modal',
                                            'content'      => '&times;'
                                        ));
                                        
                                        // Modal Heading
                                        echo heading('Add Category', 4, 'class="modal-title"');
                                        ?>
                                    </div>
              
                                    <div class="modal-body">
                                        <?php
                                        // Input tag Website ID
                                        echo form_input(array(
                                          'type'  => 'hidden',
                                          'name'  => 'website_id',
                                          'id'    => 'website_id',
                                          'value' => $website_id
                                        ));
                                        
                                        echo form_input(array(
                                            'type'  => 'hidden',
                                            'name'  => 'base_url',
                                            'id'    => 'base_url',
                                            'value' => base_url()
                                        ));
                                        ?>
                                        
                                        <div class="form-group">

                                            <?php
                                            echo form_label('Category Name <span class="required">*</span>','name','class="control-label col-md-3 col-sm-3 col-xs-12"');
                                            ?>
            
                                            <div class="col-md-8 col-sm-8 col-xs-12" style="padding-bottom:10px">
                                                <?php
                                                // Input tag
                                                echo form_input(array(
                                                    'id'       => 'category_name',
                                                    'name'     => 'category_name',
                                                    'required' => 'required',
                                                    'class'    => 'form-control col-md-7 col-xs-12',
                                                    'value'    => ''
                                                ));
                                                ?>
                                            </div>
                                            <span id="error"></span>
                                        </div>
                                        
                                        <div class="form-group">
                                            <?php
                                                echo form_label(
                                                    'Sort Order <span class="required">*</span>',
                                                    'sort_order',
                                                    'class="control-label col-md-3 col-sm-3 col-xs-12"'
                                                );
                                            ?>
    
                                            <div class="col-md-8 col-sm-8 col-xs-12" style="padding-bottom:10px">
                                                <?php
                                                    // Input tag
                                                    echo form_input(array(
                                                        'id'       => 'sort_order',
                                                        'name'     => 'sort_order',
                                                        'required' => 'required',
                                                        'class'    => 'form-control col-md-7 col-xs-12',
                                                        'value'    => ''
                                                    ));
                                                ?>
                                            </div>
                                        </div>   
                                
                                    </div>
                                    
                                    <?php echo br(1); ?>
                                    
                                    <div class="modal-footer">
                                        <?php
                                        echo form_button(array(
                                            'type'         => 'button',
                                            'id'		   => 'closemodel',
                                            'class'        => 'btn btn-default',
                                            'data-dismiss' => 'modal',
                                            'content'      => 'Close'
                                        ));
                                        
                                        // Form Submit
                                        echo form_submit(
                                          array(
                                            'class' 		=> 'btn btn-success',
                                            'id' 		=> 'btn',
                                            'value' 		=> 'Save'
                                          )
                                        );
                                        ?>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        
                        <?php
                        // Form Close
                        echo form_close();
                        ?>
                        

							</div>

							<div id="step-2">
								<h2 class="StepTitle">Campaign Users</h2>
								
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
								
								<button class="btn btn-default" id="filter-data-import">Import</button>
                                 
								<br/>

								<?php echo $table;?>
								<br/>
							</div>
							
							<div id="step-3">
								<div id="templates_step">
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
								<div id="preview_templates" class="col-md-6 col-sm-6 col-xs-12 col-sm-offset-3">
									
									<h2 class="StepTitle col-md-6 col-md-offset-3 col-xs-6">Choose SMS Template</h2>
									<select name="sms-template" id="sms-template" class="col-md-6 col-md-offset-3 col-xs-6" style="padding: 10px;">
										<option value="">Select Template</option>
										<?php foreach (($sms_templates ? $sms_templates : array()) as $sms_template) :?>
											<option value="<?php echo $sms_template->id;?>"><?php echo $sms_template->template_name;?></option>
										<?php endforeach;?>
									</select>
								</div>
								<div class="clearfix"></div>
								<div class="modal fade" id="preview-sms-template-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">

												<div class="modal-header">
													SMS Template Preview
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

<style>
.sorting > input {
	color : black
}
</style>