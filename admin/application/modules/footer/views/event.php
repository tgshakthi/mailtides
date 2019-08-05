<!-- page content -->
<div class="right_col" role="main">
	<div class="">
    	<div class="clearfix"></div>

    	<div class="row">
      		<div class="col-md-12 col-sm-12 col-xs-12">
        		<div class="">

          			<div class="x_title">
            			<?php echo heading($heading, '2');?>
                        
                        <div style="text-align:right;">
							<?php
                            echo anchor(
                                'footer',
                                '<i class="fa fa-chevron-left" aria-hidden="true"></i> Back',
                                array(
                                    'class' => 'btn btn-primary'
                                )
                            );
                            ?>
                        </div>
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

            			<?php
              			// Break tag
              			echo br();

              			// Form Tag
              			echo form_open_multipart(
                			'footer/event/insert_update_footer_event',
                			'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
              			);
						
						// Input tag hidden
             			echo form_input(array(
                			'type'  => 'hidden',
                			'name'  => 'setting_id',
                			'id'    => 'setting_id',
                			'value' => $setting_id
              			));
						
			   			// Input tag hidden
             			echo form_input(array(
                			'type'  => 'hidden',
                			'name'  => 'website_id',
                			'id'    => 'website_id',
                			'value' => $website_id
              			));
            			?>
                        
                        <div class="col-md-12 col-sm-12 col-xs-12">
                        	<div class="x_panel">
                            	<div class="x_title">
                                	<?php
                                	echo heading('Events', '2');
                                	$list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
                                	$attributes = array('class' => 'nav navbar-right panel_toolbox');
                                	echo ul($list,$attributes);
                                	?>
              
                                	<div class="clearfix"></div>
                              	</div>
                              	<div class="x_content">
              						
                                    <div class="form-group">
										<?php
                                        echo form_label(
                                            'Status',
                                            'status',
                                            'class="control-label col-md-3 col-sm-3 col-xs-12"'
                                        );
                                        ?>
            
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <?php
                                            // Input checkbox
                                            echo form_checkbox(array(
                                                'id'      => 'status',
                                                'name'    => 'status',
                                                'class'   => 'js-switch',
                                                'checked' => ($status === '1') ? TRUE : FALSE,
                                                'value'   => $status
                                            ));
                                            ?>
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="ln_solid"></div>
                                    
                                	<div class="cf nestable-lists">
                                    	<div class="dd" id="nestable">
                                        	<h3 class="heading">Events List</h3>
                                          	<?php
                                            if (isset($events_unselected) && !empty($events_unselected)) :
											  
                                            	echo '<ol class="dd-list">';
												  
                                                foreach ($events_unselected as $events_unselecteds) :
												  
                                                	echo '<li class="dd-item" data-id="'.$events_unselecteds->id.'">
                                                    		<div class="dd-handle">
                                                            	'.$events_unselecteds->title.'
                                                          	</div>
                                                      	</li>';
													  
                                              	endforeach;
												  
                                                	echo '</ol>';
												  
                                            else :
											  
                                            	echo '<div class="dd-empty"></div>';
												  
                                           	endif;
                                          	?>
                                      	</div>
                                      	<div class="dd" id="nestable2">
                                        	<h3 class="heading">Events Active List</h3>
                                            <?php
                                            if (isset($events_selected) && !empty($events_selected)) :
											  
                                            	echo '<ol class="dd-list">';
												  
                                                foreach ($events_selected as $event_selected) :
												  
                                                	echo '<li class="dd-item" data-id="'.$event_selected->id.'">
                                                    		<div class="dd-handle">
                                                            	 '.$event_selected->title.'
                                                          	</div>
														</li>';
													  
                                              	endforeach;
												  
                                                	echo '</ol>';
												  
                                           	else :
											  
                                            	echo '<div class="dd-empty"></div>';
												  
                                           	endif;
                                          	?>
                                      	</div>
                                  	</div>
              
                                  	<?php
                                  	echo form_textarea(array(
                                    	'name'  => 'output_data',
                                      	'id'    => 'nestable-output',
                                      	'style' => 'display:none'
                                  	));
              
                                  	echo form_textarea(array(
                                    	'name'  => 'output_update',
                                      	'id'    => 'nestable2-output',
                                      	'style' => 'display:none'
                                  	));
                                  	?>
              
                              	</div>
                         	</div>
                     	</div>
                          
              			<!-- Button Group -->
              			<div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="input-button-group">
                  				<?php
                    			// Submit Button
                    			if (empty($setting_id)) :
                      				$submit_value = 'Save';
                    			else :
                      				$submit_value = 'Update';
                    			endif;

                    			echo form_submit(
                      				array(
                        				'class' => 'btn btn-success',
                        				//'id'    => 'btn',
                        				'value' => $submit_value
                      				)
                    			);

                    			echo form_submit(
                      				array(
                        				'class' => 'btn btn-success',
                        				'id'    => 'btn',
                        				'name'  => 'btn_continue',
                        				'value' => $submit_value.' & Continue'
                      				)
                    			);
					   		
					 			// Anchor Tag
                    			echo anchor(
                      				'footer',
                      				'Back',
                      				array(
                        				'title' => 'Back',
                        				'class' => 'btn btn-primary'
                      				)
                    			);

								echo br(3);

                  				?>
                			</div>
              			</div>

              			<?php echo form_close(); //Form close ?>
            		</div>
          		</div>
        	</div>
      	</div>
	</div>
</div>
<!-- /page content -->
