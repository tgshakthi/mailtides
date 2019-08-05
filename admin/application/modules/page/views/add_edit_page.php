<!-- page content -->
<div class="right_col" role="main">
	<div class="">
    	<div class="clearfix"></div>

    	<div class="row">

            <?php
			// Form Tag
			echo form_open_multipart(
				'page/insert_update_page',
				'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
			);
			?>

      		<div class="col-md-9 col-sm-12 col-xs-12">
        		<div class="x_panel">

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

                        <?php
							// Break tag
							echo br();

							// Input tag hidden
							echo form_input(array(
								'type'  => 'hidden',
								'name'  => 'id',
								'id'    => 'id',
								'value' => $id
							));

							// HTTP URL
							echo form_input(array(
								'type' => 'hidden',
								'name' => 'http_url',
								'id' => 'http_url',
								'value' => $http_url."/zstaff/admin/page"
							));
                        ?>

            			<div class="form-group">

              				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="page-title">
                				Page Title
                				<span class="required">*</span>
              				</label>

              				<div class="col-md-6 col-sm-6 col-xs-12">
                				<?php
                  				// Input tag
								echo form_input(array(
								  'id'       => 'page-title',
								  'name'     => 'page-title',
								  'required' => 'required',
								  'class'    => 'form-control col-md-7 col-xs-12',
								  'value'    => $page_title
								));
                				?>
              				</div>

            			</div>

            			<div class="form-group">

              				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="page-url">
                				Page Url
                				<span class="required">*</span>
              				</label>

              				<div class="col-md-6 col-sm-6 col-xs-12">
                				<?php
                  				// Input
                  				echo form_input(array(
                    				'id'       => 'page-url',
                    				'name'     => 'page-url',
                    				'required' => 'required',
                    				'class'    => 'form-control col-md-7 col-xs-12',
									'onkeyup'  => 'check_url();',
                    				'value'    => $url
                  				));
                				?>

                                <span id="check-url-result"></span>
              				</div>
            			</div>
                        
                        <?php if (empty($id)) : ?>
                        	
                            <div class="form-group">
                
								<?php
                                echo form_label(
                                    'If Page Clone <span class="required">*</span>',
                                    'page_clone',
                                    'class="control-label col-md-3 col-sm-3 col-xs-12"'
                                );
                                ?>
                
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?php
                                    $options = array(
                                        '' => 'select',
                                        '1' => 'Yes',
                                        '0' => 'No'
                                    );
                                  
                                    $attributes = array(
                                        'name'	=> 'page_clone',
                                        'id'	=> 'page_clone',
                                        'class'	=> 'form-control',
                                        'required' => 'required'
                                    );
                  
                                    echo form_dropdown($attributes, $options, '');
                                    ?>
                                </div>
                            </div>
                        
                        	<div class="form-group" id="clone_page_div" style="display:none">
                
								<?php
                                echo form_label(
                                    'Clone Page <span class="required">*</span>',
                                    'clone_page',
                                    'class="control-label col-md-3 col-sm-3 col-xs-12"'
                                    );
                                ?>
                
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?php
                                    $options = array('' => 'select');
                                    if(!empty($pages)):
                                
                                        foreach($pages as $page):
                                    
                                            $options[$page->id] = $page->title;
                                        
                                        endforeach;
                                
                                    endif;
                                  
                                    $attributes = array(
                                        'name'	=> 'clone_page',
                                        'id'	=> 'clone_page',
                                        'class'	=> 'form-control',
                                    );
                  
                                    echo form_dropdown($attributes, $options, '');
                                    ?>
                                </div>
                            </div>

            				<div class="form-group" id="page_components_div" style="display:none">

                                <label for="page-components" class="control-label col-md-3 col-sm-3 col-xs-12">
                                    Page components
                                    <span class="required">*</span>
                                </label>
    
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?php
                                    $component_options  = array();
                                    $selected           = array();
    
                                    if (!empty($components)) :
                                        foreach ($components as $component) :
                                            if (in_array($component->id, array_column($web_component_ids, 'id')))
                                            {
                                                $component_options[$component->id] = $component->name;
                                            }
                                        endforeach;
    
                                        $selected = array_merge(explode(',', $component_id));
    
                                    endif;
    
                                    $component_attributes = array(
                                        'id'        => 'components',
                                        'name'      => 'components[]',
                                        'class'     => 'form-control col-md-7 col-xs-12 multiselect'
                                    );
    
                                    // Dropdown Multiselect
                                    echo form_multiselect(
                                        $component_attributes,
                                        $component_options,
                                        $selected
                                    )
                                    ?>
                                </div>
    
                            </div>
                            
                        <?php else: ?>
                      
            			<div class="form-group">

              				<label for="page-components" class="control-label col-md-3 col-sm-3 col-xs-12">
                				Page components
                				<span class="required">*</span>
              				</label>

              				<div class="col-md-6 col-sm-6 col-xs-12">
                				<?php
                  				$component_options  = array();
								$selected           = array();

                  				if (!empty($components)) :
									foreach ($components as $component) :
										if (in_array($component->id, array_column($web_component_ids, 'id')))
										{
											$component_options[$component->id] = $component->name;
										}
                    				endforeach;

                    				$selected = array_merge(explode(',', $component_id));

								endif;

								$component_attributes = array(
									'id'        => 'components',
								  	'name'      => 'components[]',
								  	'class'     => 'form-control col-md-7 col-xs-12 multiselect'
								);

								// Dropdown Multiselect
								echo form_multiselect(
									$component_attributes,
								  	$component_options,
								  	$selected
								)
                				?>
              				</div>

            			</div>
                        
                        <?php endif; ?>

            			<div class="form-group">

              				<?php
                			echo form_label(
                  				'Page Status',
                  				'page-status',
                  				'class="control-label col-md-3 col-sm-3 col-xs-12"'
                			);
              				?>

              				<div class="col-md-6 col-sm-6 col-xs-12">
                				<?php
                  				// Input
								echo form_checkbox(array(
									'id'      => 'page-status',
								  	'name'    => 'page-status',
								  	'class'   => 'js-switch',
								  	'checked' => ($status === '1') ? TRUE : FALSE,
								  	'value'   => $status
								));
							  	?>
							</div>
            			</div>
          			</div>
        		</div>
      		</div>

            <?php
			if(!empty($common_components)) {

				?>
                <div class="col-md-3 col-sm-12 col-xs-12" id="common_components_div" style="display:<?php echo (empty($id)) ? 'none': 'block'; ?>">
                    <div class="x_panel">

                        <div class="x_title">
                            <?php echo heading('Common Components', '2');?>
                            <div class="clearfix"></div>
                        </div>

                        <div class="x_content">

                            <?php
							foreach($common_components as $common_component) {

								if (in_array($common_component->code, array_column($web_component_ids, 'id')))
								{
									$checkbox = array(
										'name'          => 'common_components[]',
										'id'            => $common_component->code,
										'class'         => 'flat',
										'value'         => $common_component->code,
										'checked'       => (in_array($common_component->code, $selected)) ? TRUE: FALSE,
									);

									// Checkbox Label
									$checkboxlabel = form_label(
										$common_component->name,
										$common_component->code
									);

									// Checkbox
									echo '<p>'.form_checkbox($checkbox).$checkboxlabel.'</p>';
								}
							}
                            ?>

                        </div>
                    </div>
                </div>
                <?php
			}
			?>

            <div class="ln_solid"></div>

            <!-- Button Group -->

            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="input-button-group">
                    <?php
                    // Submit Button
                    if (empty($id)) :
                        $submit_value = 'Add';
                    else :
                        $submit_value = 'Update';
                    endif;

                    echo form_submit(
                        array(
                            'class' => 'btn btn-success',
                            'id'    => 'btn',
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


                    // Reset Button
                    echo form_reset(
                        array(
                            'class' => 'btn btn-primary',
                            'value' => 'Reset'
                        )
                    );
                    // Anchor Tag
                    echo anchor(
                        'page',
                        'Cancel',
                        array(
                            'title' => 'Cancel',
                            'class' => 'btn btn-primary'
                        )
                    );
                    ?>
                </div>
            </div>

            <?php echo form_close(); //Form close ?>

    	</div>
  	</div>
</div>
<!-- /page content -->
