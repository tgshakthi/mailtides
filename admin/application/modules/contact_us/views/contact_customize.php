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
							if(!empty($contact_forms)) {
								
								echo anchor(
									'contact_us/contact_layout',
									'Contact Layout',
									array(
										'class' => 'btn btn-success'
									)
								);
							}
							
                            echo anchor(
                                'contact_us/contact_form_field',
                                'Form Field',
                                array(
                                    'class' => 'btn btn-success'
                                )
                            );
							
							echo anchor(
                                'contact_us',
                                'Back',
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
                                'contact_us/insert_update_contact_customize',
                                'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
                            );
            			?>

            			<div class="col-md-12 col-sm-12 col-xs-12">
              				<div class="x_panel">
                				<div class="x_title">

                  					<?php
					  				echo heading('Form', '2');
					  				$list = array(
										'<a data-toggle="tooltip" data-placement = "left" data-original-title="Customize Submit Button"  onclick="customize_submit_button_developer()"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>',
										'<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>'
									);
					  				$attributes = array('class' => 'nav navbar-right panel_toolbox');
					  				echo ul($list,$attributes);
				  					?>
									
                  					<div class="clearfix"></div>
                				</div>

                				<div class="x_content">
                                	
                                	<div class="form-group">
                        				<?php
                            			echo form_label(
											'Title <span class="required">*</span>',
											'form_title',
											'class="control-label col-md-3 col-sm-3 col-xs-12"'
										);
										?>
                                        
    									<div class="col-md-6 col-sm-6 col-xs-12">
                            				<?php
                                            // Input tag
                            				echo form_input(array(
                            					'id'       => 'form_title',
                            					'name'     => 'form_title',
												'required' => 'required',
                            					'class'    => 'form-control',
                            					'value'    => $form_title
                            				));
                        					?>
                                      	</div>
                                        
                    				</div>
                                    
                                    <div class="form-group">
                        				<?php
										echo form_label(
											'Title Color',
											'title_color',
											'class="control-label col-md-3 col-sm-3 col-xs-12"'
										);

										// Input tag hidden
										echo form_input(array(
											'type'  => 'hidden',
											'name'  => 'title_color',
											'id'    => 'title_color',
											'value' => $title_color
										));
										?>
    
    									<div class="col-md-6 col-sm-6 col-xs-12">
                                        	<?php
											// Color
											$this->color->view($title_color,'title_color',1);
											?>
                                        </div>

                    				</div>
                                    
                                    <div class="form-group">
										<?php
                                        echo form_label(
                                        	'Title Position',
                                            'title_position',
                                            'class="control-label col-md-3 col-sm-3 col-xs-12"'
                                        );
                  						?>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                        	<?php
                                            $options = array(
                                                'left-align'	 => 'Left',
                                                'center-align' => 'Center',
                                                'right-align'	 => 'Right'                                                
                                          	);

                                            $attributes = array(
                                            	'name' => 'title_position',
                                                'id' => 'title_position',
                                                'class' => 'form-control col-md-7 col-xs-12'
                                            );

                                            echo form_dropdown($attributes, $options, $title_position);
                                            ?>
                                        </div>

                                    </div>
                                    
                                    <div class="form-group">
                        				<?php
										echo form_label(
											'Form Label Color',
											'label_color',
											'class="control-label col-md-3 col-sm-3 col-xs-12"'
										);

										// Input tag hidden
										echo form_input(array(
											'type'  => 'hidden',
											'name'  => 'label_color',
											'id'    => 'label_color',
											'value' => $label_color
										));
										?>
    
    									<div class="col-md-6 col-sm-6 col-xs-12">
                                        	<?php
											// Color
											$this->color->view($label_color,'label_color',2);
											?>
                                        </div>

                    				</div>
                                    
                                    <div class="form-group">
                        				<?php
                            			echo form_label(
											'Button Label <span class="required">*</span>',
											'button_label',
											'class="control-label col-md-3 col-sm-3 col-xs-12"'
										);
										?>
                                        
    									<div class="col-md-6 col-sm-6 col-xs-12">
                            				<?php
                                            // Input tag
                            				echo form_input(array(
                            					'id'       => 'button_label',
                            					'name'     => 'button_label',
												'required' => 'required',
                            					'class'    => 'form-control',
                            					'value'    => $button_label
                            				));
                        					?>
                                      	</div>
                                        
                    				</div>
                                    
                                    <div class="form-group ">
										<?php
                                        echo form_label(
                                            'Captcha',
                                            'captcha',
                                            'class="control-label col-md-3 col-sm-3 col-xs-12"'
                                        );
                                        ?>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <?php
                                            // Input checkbox
                                            echo form_checkbox(array(
                                                'id'      => 'captcha',
                                                'name'    => 'captcha',
                                                'onchange' => 'captcha_btn()',
                                                'class'   => 'js-switch',
                                                'checked' => ($captcha === '1') ? TRUE : FALSE,
                                                'value'   => $captcha
                                            ));
                                            ?>
                                        </div>

                                    </div>
                                    
                                    <div id="hidden_div_captcha" style="display: <?php echo (!empty($captcha) && $captcha == '1') ?'block': 'none'; ?>;">
                                    
                                        <div class="form-group ">
                                            <?php
                                            echo form_label(
                                                'Choose Captcha',
                                                'choose_captcha',
                                                'class="control-label col-md-3 col-sm-3 col-xs-12"'
                                            );
                                            ?>
    
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?php
												$captcha_options = array(
													''	=> 'select',
													'google_captcha'	=> 'Google Captcha',
													'image_captcha'	=> 'Image Captcha'
												);

												$captcha_attributes = array(
													'name'	=> 'choose_captcha',
													'id'	=> 'choose_captcha',
													'onchange' => 'choose_captcha_btn()',
													'class'	=> 'form-control col-md-7 col-xs-12'
												);
												echo form_dropdown($captcha_attributes, $captcha_options, $choose_captcha);
                                                ?>
                                            </div>
    
                                        </div>
                                        <div id="hidden_div_google_captcha" style="display: <?php echo (!empty($choose_captcha) && $choose_captcha == 'google_captcha') ?'block': 'none'; ?>;">
                                        	
                                            <div class="form-group">
												<?php
                                                echo form_label(
                                                    'Google Site Key',
                                                    'google_site_key',
                                                    'class="control-label col-md-3 col-sm-3 col-xs-12"'
                                                );
                                                ?>
                                                
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <?php
                                                    // Input tag
                                                    echo form_input(array(
                                                        'id'       => 'google_site_key',
                                                        'name'     => 'google_site_key',
                                                        'class'    => 'form-control',
                                                        'value'    => $google_site_key
                                                    ));
                                                    ?>
                                                </div>
                                                
                                            </div>
                                            
                                            <div class="form-group">
												<?php
                                                echo form_label(
                                                    'Google Secret Key',
                                                    'google_secret_key',
                                                    'class="control-label col-md-3 col-sm-3 col-xs-12"'
                                                );
                                                ?>
                                                
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <?php
                                                    // Input tag
                                                    echo form_input(array(
                                                        'id'       => 'google_secret_key',
                                                        'name'     => 'google_secret_key',
                                                        'class'    => 'form-control',
                                                        'value'    => $google_secret_key
                                                    ));
                                                    ?>
                                                </div>
                                                
                                            </div>
                                            
                                        </div>
                                        
                                        
                                        <div id="hidden_div_image_captcha" style="display: <?php echo (!empty($choose_captcha) && $choose_captcha == 'image_captcha') ?'block': 'none'; ?>;">
                                        
                                        	<div class="form-group">
												<?php
                                                echo form_label(
                                                    'Image Captcha Width',
                                                    'image_captcha_width',
                                                    'class="control-label col-md-3 col-sm-3 col-xs-12"'
                                                );
                                                ?>
                                                
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <?php
                                                    // Input tag
                                                    echo form_input(array(
                                                        'id'       => 'image_captcha_width',
                                                        'name'     => 'image_captcha_width',
                                                        'class'    => 'form-control',
                                                        'value'    => $image_captcha_width
                                                    ));
                                                    ?>
                                                </div>
                                                
                                            </div>
                                            
                                            <div class="form-group">
												<?php
                                                echo form_label(
                                                    'Image Captcha Height',
                                                    'image_captcha_height',
                                                    'class="control-label col-md-3 col-sm-3 col-xs-12"'
                                                );
                                                ?>
                                                
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <?php
                                                    // Input tag
                                                    echo form_input(array(
                                                        'id'       => 'image_captcha_height',
                                                        'name'     => 'image_captcha_height',
                                                        'class'    => 'form-control',
                                                        'value'    => $image_captcha_height
                                                    ));
                                                    ?>
                                                </div>
                                                
                                            </div>
                                            
                                            <div class="form-group">
												<?php
                                                echo form_label(
                                                    'Image Captcha Word Length',
                                                    'image_captcha_word_length',
                                                    'class="control-label col-md-3 col-sm-3 col-xs-12"'
                                                );
                                                ?>
                                                
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <?php
                                                    // Input tag
                                                    echo form_input(array(
                                                        'id'       => 'image_captcha_word_length',
                                                        'name'     => 'image_captcha_word_length',
                                                        'class'    => 'form-control',
                                                        'value'    => $image_captcha_word_length
                                                    ));
                                                    ?>
                                                </div>
                                                
                                            </div>
                                            
                                            <div class="form-group">
												<?php
                                                echo form_label(
                                                    'Image Captcha Font Size',
                                                    'image_captcha_font_size',
                                                    'class="control-label col-md-3 col-sm-3 col-xs-12"'
                                                );
                                                ?>
                                                
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <?php
                                                    // Input tag
                                                    echo form_input(array(
                                                        'id'       => 'image_captcha_font_size',
                                                        'name'     => 'image_captcha_font_size',
                                                        'class'    => 'form-control',
                                                        'value'    => $image_captcha_font_size
                                                    ));
                                                    ?>
                                                </div>
                                                
                                            </div>
                                        
                                        </div>
                                    
                                    </div>
                                    
                                    <div id="customize_submit_button_developer" style="display:none">
										<?php echo br(1); ?>
    
                                        <div class="x_title">
                                            <?php echo heading('Customize Submit Button', '2'); ?>
                                            <div class="clearfix"></div>
                                        </div>
    
                                        <div class="form-group">
                                            <?php
											echo form_label(
												'Button Type',
												'button_type',
												'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);
                                            ?>
    
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?php
												$options = array(
													''	=> 'select',
													'common-btn-contact'	=> 'Square',
													'common-btn-contact oval'	=> 'Oval',
													'link'	=> 'Text Link'
												);

												$attributes = array(
													'name'	=> 'button_type',
													'id'	=> 'button_type',
													'class'	=> 'form-control col-md-7 col-xs-12'
												);
												echo form_dropdown($attributes, $options, $button_type);
                                                ?>
                                            </div>
                                            
                                        </div>
                                        
                                        <div class="form-group">
											<?php
                                            echo form_label(
                                                'Button Label Color',
                                                'button_label_color',
                                                'class="control-label col-md-3 col-sm-3 col-xs-12"'
                                            );
    
                                            // Input tag hidden
                                            echo form_input(array(
                                                'type'  => 'hidden',
                                                'name'  => 'button_label_color',
                                                'id'    => 'button_label_color',
                                                'value' => $button_label_color
                                            ));
                                            ?>
        
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?php
                                                // Color
                                                $this->color->view($button_label_color,'button_label_color',3);
                                                ?>
                                            </div>
    
                                        </div>
                                        
                                        <div class="form-group">
											<?php
                                            echo form_label(
                                                'Hover Label Color',
                                                'hover_label_color',
                                                'class="control-label col-md-3 col-sm-3 col-xs-12"'
                                            );
    
                                            // Input tag hidden
                                            echo form_input(array(
                                                'type'  => 'hidden',
                                                'name'  => 'hover_label_color',
                                                'id'    => 'hover_label_color',
                                                'value' => $hover_label_color
                                            ));
                                            ?>
        
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?php
                                                // Color
                                                $this->color->view($hover_label_color,'hover_label_color',4);
                                                ?>
                                            </div>
    
                                        </div>
    
                                        <div id="hidden_div" style="display: <?php echo (!empty($button_type) && $button_type != 'link') ?'block': 'none'; ?>;">
                                        	
                                            <div class="form-group">
                                            	<?php
												echo form_label(
													'Button Background Color',
													'button_background_color',
													'class="control-label col-md-3 col-sm-3 col-xs-12"'
												);

												// Input tag hidden
												echo form_input(array(
													'type'  => 'hidden',
													'name'  => 'button_background_color',
													'id'    => 'button_background_color',
													'value' => $button_background_color
												));
                                            	?>
    
                                            	<div class="col-md-6 col-sm-6 col-xs-12">
                                                	<?php
                                                    // Color
                                                    $this->color->view($button_background_color,'button_background_color',5);
                                                	?>
                                            	</div>
    
                                        	</div>
    
                                        	<div class="form-group">
                                            	<?php
                                                echo form_label(
                                                    'Hover Background Color',
                                                    'hover_background_color',
                                                    'class="control-label col-md-3 col-sm-3 col-xs-12"'
                                                );
    
                                                // Input tag hidden
                                                echo form_input(array(
                                                    'type'  => 'hidden',
                                                    'name'  => 'hover_background_color',
                                                    'id'    => 'hover_background_color',
                                                    'value' => $hover_background_color
                                                ));
                                            	?>
    
                                            	<div class="col-md-6 col-sm-6 col-xs-12">
                                                	<?php
                                                    // Color
                                                    $this->color->view($hover_background_color,'hover_background_color',6);
                                                	?>
                                            	</div>
                                                
                                        	</div>
    
                                        	<div class="form-group ">
												<?php
												echo form_label(
													'Border',
													'border',
													'class="control-label col-md-3 col-sm-3 col-xs-12"'
												);
                      							?>

												<div class="col-md-6 col-sm-6 col-xs-12">
													<?php
													// Input checkbox
													echo form_checkbox(array(
														'id'      => 'border',
														'name'    => 'border',
														'onchange' => 'border_btn()',
														'class'   => 'js-switch',
														'checked' => ($border === '1') ? TRUE : FALSE,
														'value'   => $border
													));
                        							?>
												</div>

											</div>
                                            
                                   		</div>
                                        
                                        <div id="hidden_div_border" style="display: <?php echo (!empty($border) && $border == '1') ?'block': 'none'; ?>;">
                                        
                                        	<div class="form-group">
												<?php
                                                echo form_label(
                                                    'Border Size',
                                                    'border_size',
                                                    'class="control-label col-md-3 col-sm-3 col-xs-12"'
                                                );
                                                ?>
        
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <?php
                                                    $options = array(
                                                        '0px' => '0',
                                                        '1px' => '1',
														'2px' => '2',
														'3px' => '3',
														'4px' => '4',
                                                        '5px' => '5'
                                                    );
        
                                                    $attributes = array(
                                                        'name' => 'border_size',
                                                        'id' => 'border_size',
                                                        'class' => 'form-control col-md-7 col-xs-12'
                                                    );
        
                                                    echo form_dropdown($attributes, $options, $border_size);
                                                    ?>
                                                </div>
        
                                            </div>
                                            
                                            <div class="form-group">
                                            	<?php
                                                echo form_label(
                                                    'Border Color',
                                                    'border_color',
                                                    'class="control-label col-md-3 col-sm-3 col-xs-12"'
                                                );
    
                                                // Input tag hidden
                                                echo form_input(array(
                                                    'type'  => 'hidden',
                                                    'name'  => 'border_color',
                                                    'id'    => 'border_color',
                                                    'value' => $border_color
                                                ));
                                            	?>
    
                                            	<div class="col-md-6 col-sm-6 col-xs-12">
                                                	<?php
                                                    // Color
                                                    $this->color->view($border_color, 'border_color', 7);
                                                	?>
                                            	</div>
                                                
                                        	</div>
                                        
                                   		</div>
                                        
    
                                    </div>
                                	
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
              				<div class="x_panel">
                				<div class="x_title">

                  					<?php
					  				echo heading('Status & Background Color', '2');
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
												'Background',
												'component-background',
												'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);
											?>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<?php
												$options = array(
													'' => 'Select',
													'color'	 => 'Color',
													'image' => 'Image'
												);

												$attributes = array(
													'name'	=> 'component-background',
													'id'	=> 'component-background',
													'class'	=> 'form-control'
												);

												echo form_dropdown($attributes, $options, $component_background);			
											?>
										</div>
									</div>

									<div class="form-group" id="component-bg-color"
										<?php if ($component_background == 'color') :?> style="display:block;"
										<?php else : ?> style="display:none;" <?php endif;?>>
										<?php
											echo form_label(
												'Background Color',
												'contact_us_background_color',
												'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);
										?>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<?php
												// Input tag hidden
												echo form_input(array(
													'type'  => 'hidden',
													'name'  => 'contact_us_background_color',
													'id'    => 'contact_us_background_color',
													'value' => $contact_us_background
												));
																				
												// Color
												$this->color->view($contact_us_background,'contact_us_background_color',4);
											?>
										</div>
									</div>

									<div class="form-group" id="component-bg-image" <?php if ($component_background == 'image') :?>
											style="display:block;" <?php else : ?> style="display:none;" <?php endif;?>>

											<?php

												if ($component_background == 'color') :
													$contact_us_background = '';
												endif;

												// label
												echo form_label(
													'Image <span class="required">* Recommended size(1200*600)</span>',
													'imgInp',
													'class="control-label col-md-3 col-sm-3 col-xs-12"'
												);
											?>

											<div class="img-thumbnail sepH_a" id="show_image1">
												<?php
													if ($contact_us_background != '') :

														$contact_us_img = $ImageUrl . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR . $contact_us_background;
														echo img(array(
																'src'   => $contact_us_img,
																'id'    => 'image_preview',
																'style' => 'width:168px; height:114px'
														));

													else :

														echo img(array(
															'src'   => $ImageUrl.'images/noimage.png',
															'alt'   => 'No Image',
															'id'    => 'image_preview',
															'style' => 'width:168px; height:114px'
														));

													endif;
												?>
											</div>

											<div style="display:none" class="img-thumbnail sepH_a" id="show_image2">
												<?php
													echo img(array(
														'src'   => $ImageUrl.'images/noimage.png',
														'alt'   => 'No Image',
														'id'    => 'image_preview2',
														'style' => 'width:168px; height:114px'
													));
												?>
											</div>

											<?php
												echo form_input(array(
													'type'  => 'hidden',
													'name'  => 'image',
													'id'    => 'image',
													'value' => $contact_us_background
												));

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

											<a data-toggle="modal" class="btn btn-primary" data-target="#ImagePopUp" href="javascript:;"
												type="button">
												Select Image
											</a>
										</div>

									<!-- FileManager -->
									<div class="modal fade" id="ImagePopUp">
										<div class="modal-dialog popup-width">
											<div class="modal-content">

												<div class="modal-header">
													<?php
														echo form_button(array(
															'name'         => '',
															'type'         => 'button',
															'class'        => 'close',
															'data-dismiss' => 'modal',
															'aria-hidden'  => 'true',
															'content'      => '&times;'
														));
													?>
												</div>

												<div class="modal-body">
													<iframe width="880" height="400"
														src="<?php echo $ImageUrl ;?>filemanager/dialog.php?type=1&field_id=image&rootfldr=<?php echo $website_folder_name;?>/"
														frameborder="0"
														style="overflow: scroll; overflow-x: hidden; overflow-y: scroll; "></iframe>
												</div>
											</div>
										</div>
									</div>
                                    
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
                                    
                                </div>
                             
                         	</div>
                        </div>

						<!-- Button Group -->

						<div class="col-md-12 col-sm-12 col-xs-12 ">
               				<div class="input-button-group">
								<?php

								// Submit Button
								if (empty($id)) :
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
