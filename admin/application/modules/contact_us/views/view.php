<!-- page content -->
<div class="right_col" role="main" id="datatable_content">
	<div class="">
	
    	<div class="page-title">
      		<div class="title_left">
        		<?php echo heading($heading, '3');?>
      		</div>
      		<div style="text-align:right;">
		  		<?php
				// Choose Field Button
				echo form_button(array(
					'class'	   => 'btn btn-success',
					'type'        => 'button',
					'data-toggle' => 'modal',
					'data-target' => '#choose_field',
					'content'     => 'Choose Field'
				));
				
				// Customize
          		echo anchor(
              		'contact_us/contact_customize',
              		'Customize',
              		array(
                  		'class' => 'btn btn-success'
              		)
          		);
          		?>           
      		</div>
    	</div>

    	<div class="clearfix"></div>

    	<div class="row">
	  		<?php if ($this->session->flashdata('success') != '') : // Display session data ?>
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
						echo form_open(
							'contact_us/delete_multiple_contact_us',
							'id="form_selected_record"'
						);
						?>

          				<div class="page_buut_right">

							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<?php
								echo form_button(array(
									'type'    => 'button',
									'id'	  => 'delete_selected_record',
									'name'    => 'delete-selected-menu',
									'class'   => 'btn btn-danger',
									'content' => '<i class="fa fa-trash-o" aria-hidden="true"></i> Delete'
								));
								?>
            				</div>

						</div>

             			<?php
  						// Table
              			echo $table;

              			echo form_close();
			   			?>
          			</div>

          			<!-- Confirm Delete Modal -->
          			<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          				<div class="modal-dialog">
            				<div class="modal-content">

                				<div class="modal-header">
                    				Confirm Delete
                    			</div>

                    			<div class="modal-body">
                    				<p>Are you sure you want to delete this record?</p>
                        			<p>Do you want to proceed?</p>
                   				</div>

                    			<div class="modal-footer">
                    				<?php
                        			echo form_button(array(
                        				'type'         => 'button',
                            			'class'        => 'btn btn-default',
                            			'data-dismiss' => 'modal',
                            			'content'      => 'Cancel'
                      				));
                        			?>
                        			<a class="btn btn-danger" id="delete_btn_ok">Delete</a>
                   				</div>

             				</div>
          				</div>
          			</div>
                    
                    <?php
					echo form_open(
						'contact_us/update_choose_field',
						'id="form_selected_record"'
					);
					?>
                    
                    <!-- Choose Field Modal -->
          			<div class="modal fade" id="choose_field" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                                    echo heading('Choose Field', 4, 'class="modal-title"');
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
									
									if(!empty($contact_form_fields)) {
										
										$out = array(' ');
										$in = array('_');
										
										foreach($contact_choose_fields as $contact_choose_field) {
											
											if(in_array($contact_choose_field, $contact_enable_fields))
											{
												$checkbox = array(
													'name'          => 'field_id[]',
													'id'            => strtolower(str_replace($out, $in, $contact_choose_field)),
													'class'         => 'flat',
													'value'         => $contact_choose_field,
													'checked'       => (in_array($contact_choose_field, $is_show)) ? TRUE: FALSE,
												);
												
												// Checkbox Label
												$checkbox_label = form_label(
													$contact_choose_field,
													strtolower(str_replace($out, $in, $contact_choose_field))
												);
												
												// Checkbox
												echo '<p>'.form_checkbox($checkbox).$checkbox_label.'</p>';
											}
										}
									}
                                    ?>
                                </div>
          
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
      		</div>
    	</div>
  	</div>
</div>
<!-- /page content -->
