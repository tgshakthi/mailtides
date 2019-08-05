<!-- page content -->
<div class="right_col" role="main">
	<div class="">
    	<div class="clearfix"></div>

    	<div class="row">
      		<div class="col-md-12 col-sm-12 col-xs-12">
        		<div class="">

          			<div class="x_title">
            			<?php echo heading($heading, '2');?>
                        <div class="btn_right" style="text-align:right;">
							<?php
                                echo anchor(
                                    'tab/tab_index/'.$page_id,
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
                			'tab/insert_update_tab_component',
                			'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
              			);

              			// Input tag hidden
              			echo form_input(array(
                			'type'  => 'hidden',
                			'name'  => 'tab_id',
                			'id'    => 'tab_id',
                			'value' => $tab_id
              			));

			  			// Input tag hidden
              			echo form_input(array(
                			'type'  => 'hidden',
                			'name'  => 'page_id',
                			'id'    => 'page_id',
                			'value' => $page_id
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
					  				echo heading('Select Component', '2');
					  				$list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
					  				$attributes = array('class' => 'nav navbar-right panel_toolbox');
					  				echo ul($list,$attributes);
				  					?>
                  					<div class="clearfix"></div>
                				</div>
                				<div class="x_content">
									
                                    <div class="formSep">
                                        <div class="form-group">
                                            <?php echo form_label('Tab Contents : ( drag boxes to define position on Tab )'); ?>
                                                <ul id="sortable-row" class="sort_table_list">
													<?php
													
													if(!empty($tab_components)):
													
														foreach($tab_components as $tab_component):
														
															if($tab_component == 'text_full_width'):
															
																?>
																<li id="text_full_width">
																	<?php
				
																		echo form_checkbox(array(
																			'name'		=> 'tab_components[]',
																			'id'			=> 'text_full_width',
																			'value'		=> 'text_full_width',
																			'checked'	=> (in_array('text_full_width', $tab_components)) ? TRUE: FALSE,
																			'class'		=> 'flat'
																		));
				
																		echo anchor(
																			base_url().'tab/tab_text_full_width/'.$page_id.'/'.$tab_id,
																			'Text Full Width'
																		);
																	?>
																</li>
																<?php
															
															elseif($tab_component == 'text_image'):
															
																?>
																<li id="text_image">
																	<?php
																	echo form_checkbox(array(
																		'name'		=> 'tab_components[]',
																		'id'			=> 'text_image',
																		'value'		=> 'text_image',
																		'checked'	=> (in_array('text_image', $tab_components)) ? TRUE: FALSE,
																		'class'		=> 'flat'
																	));
				
																	echo anchor(
																		base_url().'tab/tab_text_image/'.$page_id.'/'.$tab_id,
																		'Text Image'
																	);
																	?>
																</li>
																<?php
															endif;
														endforeach;
													endif;
													
													if(!in_array('text_full_width', $tab_components)):
														
														?>
                                                        <li id="text_full_width">
															<?php
        
                                                                echo form_checkbox(array(
                                                                    'name'		=> 'tab_components[]',
                                                                    'id'			=> 'text_full_width',
                                                                    'value'		=> 'text_full_width',
                                                                    'checked'	=> (in_array('text_full_width', $tab_components)) ? TRUE: FALSE,
                                                                    'class'		=> 'flat'
                                                                ));
        
                                                                echo anchor(
                                                                    base_url().'tab/tab_text_full_width/'.$page_id.'/'.$tab_id,
                                                                    'Text Full Width'
                                                                );
                                                            ?>
                                                        </li>
                                                        <?php
													endif;
													
													if(!in_array('text_image', $tab_components)):
														
														?>
                                                        <li id="text_image">
                                                            <?php
                                                            echo form_checkbox(array(
                                                                'name'		=> 'tab_components[]',
                                                                'id'			=> 'text_image',
                                                                'value'		=> 'text_image',
                                                                'checked'	=> (in_array('text_image', $tab_components)) ? TRUE: FALSE,
                                                                'class'		=> 'flat'
                                                            ));
        
                                                            echo anchor(
                                                                base_url().'tab/tab_text_image/'.$page_id.'/'.$tab_id,
                                                                'Text Image'
                                                            );
                                                            ?>
                                                        </li>
                                                        <?php
														
													endif;
                                                    ?>
                                                </ul>

                                            <ul id="sortable-row" class="sort_table_list">

                                                
                                                
                                        </ul>
                                    </div>
                				</div>
              				</div>
            			</div>

              			<!-- Button Group -->

              			<div class="col-md-12 col-sm-12 col-xs-12 ">
               				<div class="input-button-group">
                  				<?php
                    			// Submit Button
                    			if (empty($tab_components)) :
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
                      				'tab/tab_index/'.$page_id,
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
