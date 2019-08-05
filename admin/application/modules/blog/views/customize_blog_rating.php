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
								'blog/mail_configure/'.$blog_id,
								'Mail Configure',
								array(
									'class' => 'btn btn-success'
								)
							);
                            echo anchor(
                                'blog/add_edit_blog/'.$blog_id,
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
                			'blog/insert_update_blog_rating_customize',
                			'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
              			);
						
						// Input tag hidden
             			echo form_input(array(
                			'type'  => 'hidden',
                			'name'  => 'blog_id',
                			'id'    => 'blog_id',
                			'value' => $blog_id
              			));
						
						// Input tag hidden
             			echo form_input(array(
                			'type'  => 'hidden',
                			'name'  => 'rating_form_id',
                			'id'    => 'rating_form_id',
                			'value' => $rating_form_id
              			));
						
			   			// Input tag hidden
             			echo form_input(array(
                			'type'  => 'hidden',
                			'name'  => 'website_id',
                			'id'    => 'website_id',
                			'value' => $website_id
              			));
            			?>

            			<div class="col-md-6 col-sm-6 col-xs-12">
              				<div class="x_panel">
                            
                            	<div class="x_title">
									<?php
                                        echo heading('Title', '2');
                                        $list = array(
                                            '<a title="Title" data-toggle = "tooltip" data-placement = "left" onclick="customize_rating_title()">
                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                            </a>',
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
                                      	echo form_label('Title <span class="required">*</span>','title');

										// Input tag
										echo form_input(array(
											'id'       => 'title',
											'name'     => 'title',
											'required' => 'required',
											'class'    => 'form-control',
											'value'    => $rating_title
										));
										?>
                                        
                                 	</div>
                                    
                                    <div class="form-group">

										<?php
                                      	echo form_label('Title Color', 'title_color');
			
										// Input tag hidden
										echo form_input(array(
												'type'  => 'hidden',
												'name'  => 'title_color',
												'id'    => 'title_color',
												'value' => $title_color
										));

										// Input tag
										$this->color->view($title_color, 'title_color', 1);
										?>

                                 	</div>
                                    
                                    <div class="form-group">
			
										<?php
										echo form_label('Title Position', 'title_position');

										$options = array(
											'left-align'	=> 'Left',
											'center-align'	=> 'Center',
											'right-align'	=> 'Right'
										);

										$attributes = array(
											'name'	=> 'title_position',
											'id'	=> 'title_position',
											'class'	=> 'form-control'
										);

										echo form_dropdown($attributes, $options, $title_position);
                                        ?>

                                    </div>
                                    
                                    <div id="customize_rating_title" style="display:none">
										<?php echo br(1); ?>
    
                                        <div class="x_title">
                                            <?php echo heading('Customize Title Hover', '2'); ?>
                                            <div class="clearfix"></div>
                                        </div>
                                        
                                        <div class="form-group">
			
											<?php
                                            echo form_label('Title Hover', 'title_hover');
			
											// Input tag hidden
											echo form_input(array(
													'type'  => 'hidden',
													'name'  => 'title_hover',
													'id'    => 'title_hover',
													'value' => $title_hover
											));
	
											// Input tag
											$this->color->view($title_hover, 'title_hover', 2);
                                            ?>
    
                                        </div>
                                        
                                  	</div>
                                    
                				</div>
              				</div>
            			</div>
                        
                        <div class="col-md-6 col-sm-6 col-xs-12">
              				<div class="x_panel">
                            
                            	<div class="x_title">
									<?php
                                        echo heading('Form', '2');
                                        $list = array(
                                            '<a title="Title" data-toggle = "tooltip" data-placement = "left" onclick="customize_rating_form()">
                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                            </a>',
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
                                      	echo form_label('Label Color', 'label_color');
			
										// Input tag hidden
										echo form_input(array(
												'type'  => 'hidden',
												'name'  => 'label_color',
												'id'    => 'label_color',
												'value' => $label_color
										));

										// Input tag
										$this->color->view($label_color, 'label_color', 3);
										?>

                                 	</div>
                                    
                                    <div class="form-group">

										<?php
                                      	echo form_label('Comment Name Color', 'comment_name_color');
			
										// Input tag hidden
										echo form_input(array(
												'type'  => 'hidden',
												'name'  => 'comment_name_color',
												'id'    => 'comment_name_color',
												'value' => $comment_name_color
										));

										// Input tag
										$this->color->view($comment_name_color, 'comment_name_color', 4);
										?>

                                 	</div>
                                    
                                    <div class="form-group">

										<?php
                                      	echo form_label('Comment Text Color', 'comment_text_color');
			
										// Input tag hidden
										echo form_input(array(
												'type'  => 'hidden',
												'name'  => 'comment_text_color',
												'id'    => 'comment_text_color',
												'value' => $comment_text_color
										));

										// Input tag
										$this->color->view($comment_text_color, 'comment_text_color', 5);
										?>

                                 	</div>
                                                                        
                                    <div id="customize_rating_form" style="display:none">
										<?php echo br(1); ?>
    
                                        <div class="x_title">
                                            <?php echo heading('Customize Form', '2'); ?>
                                            <div class="clearfix"></div>
                                        </div>
                                        
                                        <div class="form-group">
			
											<?php
                                            echo form_label('Label Hover', 'label_hover');
			
											// Input tag hidden
											echo form_input(array(
													'type'  => 'hidden',
													'name'  => 'label_hover',
													'id'    => 'label_hover',
													'value' => $label_hover
											));
	
											// Input tag
											$this->color->view($label_hover, 'label_hover', 6);
                                            ?>
    
                                        </div>
                                        
                                  	</div>
                                    
                				</div>
              				</div>
            			</div>
                        
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
    
                                <div class="x_title">
                                    <?php
                                        echo heading('Button', '2');
                                        $list = array('<a title="Customize Button" data-toggle = "tooltip" data-placement	= "left" onclick="customize_rating_form_button()"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>','<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
                                        $attributes = array('class' => 'nav navbar-right panel_toolbox');
                                        echo ul($list,$attributes);
                                    ?>
                                    <div class="clearfix"></div>
                                </div>
    
                                <div class="x_content">
                                    
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
                                                    'class'    => 'form-control col-md-7 col-xs-12',
                                                    'value'    => $button_label
                                                ));
                                            ?>
                                        </div>
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
                                                    'btn'	=> 'Square',
                                                    'btn oval'	=> 'Oval',
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
                                                'Button Position',
                                                'button_position',
                                                'class="control-label col-md-3 col-sm-3 col-xs-12"'
                                            );
                                        ?>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <?php
                                                $options = array(
                                                    'left'	=> 'Left',
                                                    'blog_form_btn_center'	=> 'Center',
                                                    'right'	=> 'Right'
                                                );

                                                $attributes = array(
                                                    'name'	=> 'button_position',
                                                    'id'	=> 'button_position',
                                                    'class'	=> 'form-control col-md-7 col-xs-12'
                                                );

                                                echo form_dropdown($attributes, $options, $button_position);
                                            ?>
                                        </div>

                                    </div>
    
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
                                                $this->color->view($button_background_color, 'button_background_color', 7);
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
                                                $this->color->view($button_label_color, 'button_label_color', 8);
                                            ?>
                                        </div>
                                        
                                    </div>
    
    
                                    <div id="customize_rating_form_button" style="display:none">
                                        <?php echo br(1); ?>
    
                                        <div class="x_title">
                                            <?php echo heading('Customize Button', '2'); ?>
                                            <div class="clearfix"></div>
                                        </div>
    
                                        <div class="form-group">
                                            <?php
                                                echo form_label(
                                                    'Button Background Hover',
                                                    'button_background_hover',
                                                    'class="control-label col-md-3 col-sm-3 col-xs-12"'
                                                );
    
                                                // Input tag hidden
                                                echo form_input(array(
                                                    'type'  => 'hidden',
                                                    'name'  => 'button_background_hover',
                                                    'id'    => 'button_background_hover',
                                                    'value' => $button_background_hover
                                                ));
                                            ?>
    
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?php
                                                    // Color
                                                    $this->color->view($button_background_hover, 'button_background_hover', 9);
                                                ?>
                                            </div>
    
                                        </div>
    
                                        <div class="form-group">
                                            <?php
                                                echo form_label(
                                                    'Button Label Hover',
                                                    'button_label_hover',
                                                    'class="control-label col-md-3 col-sm-3 col-xs-12"'
                                                );
    
                                                // Input tag hidden
                                                echo form_input(array(
                                                    'type'  => 'hidden',
                                                    'name'  => 'button_label_hover',
                                                    'id'    => 'button_label_hover',
                                                    'value' => $button_label_hover
                                                ));
                                            ?>
    
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?php
                                                    // Color
                                                    $this->color->view($button_label_hover, 'button_label_hover', 10);
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
                                                        'id'      => 'border_status',
                                                        'name'    => 'border',
                                                        'class'   => 'js-switch',
                                                        'checked' => ($border === '1') ? TRUE : FALSE,
                                                        'value'   => $border
                                                    ));
                                                ?>
                                            </div>
    
                                        </div>
    
                                        <div id="bordersizecolor" style="display:<?php if($border == 1){echo 'block';}else{echo 'none';} ?>">
    
                                            <div class="form-group">
                                                <?php
                                                    echo form_label(
                                                        'Border Size (in Pixel)',
                                                        'border_size',
                                                        'class="control-label col-md-3 col-sm-3 col-xs-12"'
                                                    );
                                                ?>
    
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <?php
                                                        //select options
                                                        $options = array(
                                                            '0px' => '0',
                                                            '1px'	=> '1',
                                                            '2px'	=> '2',
                                                            '3px'	=> '3',
                                                            '4px'	=> '4',
                                                            '5px'	=> '5'
                                                        );
    
                                                        $attributes = array(
                                                            'name'	=> 'border_size',
                                                            'id'	=> 'border_size',
                                                            'class'	=> 'form-control col-md-7 col-xs-12'
                                                        );
    
                                                        echo form_dropdown($attributes, $options, $border_size);
                                                    ?>
                                                </div>
                                            </div>
    
                                            <div class="form-group">
                                                <?php
                                                    echo form_label(
                                                        'Border color',
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
                                                        $this->color->view($border_color, 'border_color', 11);
                                                    ?>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <?php
                                                    echo form_label(
                                                        'Border Hover',
                                                        'border_hover',
                                                        'class="control-label col-md-3 col-sm-3 col-xs-12"'
                                                    );
    
                                                    // Input tag hidden
                                                    echo form_input(array(
                                                        'type'  => 'hidden',
                                                        'name'  => 'border_hover',
                                                        'id'    => 'border_hover',
                                                        'value' => $border_hover
                                                    ));
                                                ?>
    
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <?php
                                                        // Color
                                                        $this->color->view($border_hover, 'border_hover', 12);
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
                                        echo heading('Status', '2');
                                        $list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>'
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
               				<div class="input_butt">
                  				<?php
                    			// Submit Button
                    			if (empty($blog_rating_forms)) :
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
					   			// Reset Button
                    			echo form_reset(
                      				array(
                        				'class' => 'btn btn-primary',
                        				'value' => 'Reset'
                      				)
                    			);
					 			// Anchor Tag
                    			echo anchor(
                      				'blog/add_edit_blog/'.$blog_id,
                      				'Back ',
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
