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
								// Button tag
								echo anchor(
									'theme/choose_theme',
									'<i class="fa fa-plus"></i> Install Theme',
									array(
										'title' => 'Install Theme',
										'class' => 'btn btn-success'
									)
								);
								
								echo heading('Theme', '2');
								
								$data = '';
								$base_url = str_replace("admin/", "", base_url());
								$i = 1;
								foreach ($themes as $theme) {
									
									$activebutton = '';
									if ($i != 1) {
										
										$activebutton = anchor(
												'theme/active_theme/'.$theme->id,
												'Active',
												array(
													'title' => 'Active',
													'class' => 'btn btn-success'
												)
										 );
									}
									
									$previewbutton = form_button(array(
                                        'type'	=> 'button',
										'data-toggle'	=> 'modal',
										'data-target'	=> '#livepreview'.$theme->id,
                                        'class'	=> 'btn btn-primary',
										'content'	=> 'Live Preview'
                                    ));
									
									// Image Tag
									$image = img(array('src' => $base_url.$theme->image, 'alt'=> $theme->name));
									
									$heading = heading($theme->name, '3', 'class="img_heading"');
									$preview_heading = heading('Preview', '4', 'class="modal-title"');
									
									$xclosebutton = form_button(array(
                                        'type'	=> 'button',
										'data-dismiss'	=> 'modal',
                                        'class'	=> 'close',
										'content'	=> '&times;'
                                    ));
									
									$closebutton = form_button(array(
                                        'type'	=> 'button',
										'data-dismiss'	=> 'modal',
                                        'class'	=> 'btn btn-default',
										'content'	=> 'Close'
                                    ));
									
									$data .= '<div class="col-md-4 col-sm-6 col-xs-12">
											  	<div class="content-box-image">
													'.$image.'
											  	</div>
											  	'.$heading.$activebutton.$previewbutton.'
										  	 </div>
											 
											 <div id="livepreview'.$theme->id.'" class="modal fade" role="dialog">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
													  		'.$xclosebutton.$preview_heading.'
														</div>
														<div class="modal-body">
													  		'.$image.'
														</div>
														<div class="modal-footer">
													  		'.$closebutton.'
														</div>
												  	</div>
												</div>
											 </div>';
									$i++;
								}
								echo $data;
								?>
                                
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
