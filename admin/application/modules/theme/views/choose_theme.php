<!-- page content -->
<div class="right_col" role="main">
	<div class="">
    	<div class="clearfix"></div>

    	<div class="row">
      		<div class="col-md-12 col-sm-12 col-xs-12">
        		<div class="">

          			<div class="x_title">
            			<?php echo heading($heading, '2');?>
            			<div class="clearfix"></div>
          			</div>

          			<div class="x_content">

						<?php if ($this->session->flashdata('success')!='') : // Display session data ?>
                          <div class="alert alert-success alert-dismissible fade in text-center" id="success-alert" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                            </button>
                            <strong>Success!</strong> <?php echo $this->session->flashdata('success');?>
                          </div>
                        <?php endif; ?>
            
                        <?php if ($this->session->flashdata('error') != '') : // Display session data ?>
                          <div class="alert alert-warning alert-dismissible fade in text-center" id="warning-alert" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                            </button>
                            <strong><?php echo $this->session->flashdata('error');?></strong>
                          </div>
                        <?php endif; ?>
						
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <div class="x_panel">
                            <div class="x_content">
            					
                                <?php
								// Back Button
								echo anchor(
									'theme',
									'Back',
									array(
										'title' => 'Back',
										'class' => 'btn btn-primary'
									)
								);
								
								echo heading('Upload A Zip File', '2');
								
								// Form Tag
								echo form_open_multipart(
								  'theme/install',
								  'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate enctype="multipart/form-data"'
								); 
								?>
								<div class="form-group">
                                	<div class="input-group input-file" name="fupload">
                                    	<span class="input-group-btn">
                                        	<?php
											// Choose Button
											echo form_button(array(
												'type'         => 'button',
												'class'        => 'btn btn-default',
												'content'      => 'Choose'
											));
											?>
                                        </span>
                                        <?php
										// Input tag
										echo form_input(array(
											'id'          => 'fupload',
											'class'       => 'form-control',
											'placeholder' => 'Choose a file...'
										));
										?>
                                   	</div>
                               	</div>
                                <?php
								echo form_submit(
								  array(
									'class' => 'btn btn-success',
									'id'    => 'btn',
									'value' => 'Install'
								  )
								);
								?>
                                <!-- Spinner -->
                                <div class="spinner" style="display:none;">
                                	<div class="dot1"></div>
                                	<div class="dot2"></div>
                              	</div>
                                <?php echo br(1); ?>
                                <div class="progress1" id="progress-div" style="display:none;">
        							<div class="progress-bar progress-bar-success progress-bar-striped" id="progress-bar" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
      							</div>
								<?php echo form_close(); //Form close ?>
                                
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