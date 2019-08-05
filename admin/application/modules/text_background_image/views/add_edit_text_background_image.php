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
                        'text_background_image/text_background_image_index/'.$page_id,
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
                'text_background_image/insert_update_text_background_image ',
                'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
              );

              // Input tag hidden
              echo form_input(array(
                'type'  => 'hidden',
                'name'  => 'text_background_image_id',
                'id'    => 'text_background_image_id',
                'value' => $text_background_image_id
              ));

			   			// Input tag hidden
              echo form_input(array(
                'type'  => 'hidden',
                'name'  => 'page-id',
                'id'    => 'page-id',
                'value' => $page_id
              ));
            ?>

            

            <div class="col-md-6 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">

                  <?php
				  echo heading('Content', '2');
				  $list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
				  $attributes = array('class' => 'nav navbar-right panel_toolbox');
				  echo ul($list,$attributes);
				  ?>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

					<div class="form-group">

						<?php
                        echo form_label('Title','title');

						// Input tag
						echo form_input(array(
							'id'       => 'title',
							'name'     => 'title',
							'class'    => 'form-control',
							'value'    => $text_background_image_title
						));
						?>

                    </div>

                    <div class="form-group">

						<?php
                        echo form_label('Text','text');

						// TextArea
						$data = array(
							'name'        => 'text',
							'id'          => 'text',
							'value'       => $text
						);

						echo form_textarea($data);
						?>

                    </div>

                </div>
              </div>
            </div>

            <div class="col-md-6 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">

                  <?php
				  echo heading('Customize Title & Content', '2');
				  $list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
				  $attributes = array('class' => 'nav navbar-right panel_toolbox');
				  echo ul($list,$attributes);
				  ?>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <div class="form-group">

						<?php
                        echo form_label('Title Color','title-color');

                        // Input tag hidden
                        echo form_input(array(
                            'type'  => 'hidden',
                            'name'  => 'title-color',
                            'id'    => 'title-color',
                            'value' => $title_color
                        ));

						// Input tag
						$this->color->view($title_color,'title-color',1);
						?>

                    </div>

                    <div class="form-group">

					  <?php
                      echo form_label('Title Position','title_position');

					  $options = array(
							'left-align'	=> 'Left',
							'center-align' => 'Center',
							'right-align' => 'Right'
					  );

					  $attributes = array(
						  'name' => 'title_position',
						  'id' => 'title_position',
						  'class'	=> 'form-control'
					  );

					  echo form_dropdown($attributes, $options, $title_position);
					  ?>

                    </div>

                    <div class="form-group">

					  <?php
                      echo form_label('Content Title Color','content-title-color');

                      // Input tag hidden
                      echo form_input(array(
                          'type'  => 'hidden',
                          'name'  => 'content-title-color',
                          'id'    => 'content-title-color',
                          'value' => $content_title_color
                      ));

					  // Color
					  $this->color->view($content_title_color,'content-title-color',2);
					  ?>

                   </div>

                   <div class="form-group">

					  <?php
                      echo form_label('Content Title Position','content_title_position');

                      $options = array(
						  'left-align'	=> 'Left',
						  'center-align'	=> 'Center',
						  'right-align'	=> 'Right',
					  );

					  $attributes = array(
						  'name' => 'content_title_position',
						  'id' => 'content_title_position',
						  'class'	=> 'form-control'
					  );

					  echo form_dropdown($attributes, $options, $content_title_position);
					  ?>

                    </div>

                   <div class="form-group">

						<?php
                        echo form_label('Content Color','content-color');

                        // Input tag hidden
                        echo form_input(array(
                            'type'  => 'hidden',
                            'name'  => 'content-color',
                            'id'    => 'content-color',
                            'value' => $content_color
                        ));

						// Color
						$this->color->view($content_color,'content-color',3);
						?>

                    </div>
					 <div class="form-group">

					  <?php
                      echo form_label('Content Position','content_position');

                      $options = array(
						  'left-align'	=> 'Left',
						  'center-align'	=> 'Center',
						  'right-align'	=> 'Right',
						  'justify-align'	=> 'Justify',
					  );

					  $attributes = array(
						  'name' => 'content_position',
						  'id' => 'content_position',
						  'class'	=> 'form-control'
					  );

					  echo form_dropdown($attributes, $options, $content_position);
					  ?>

                    </div>

                </div>
              </div>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <?php
				  echo heading('Redirect', '2');
				  $list = array('<a title="Customize Redmore Button" data-toggle = "tooltip" data-placement	= "left" onclick="text_image_developer()"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>','<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
				  $attributes = array('class' => 'nav navbar-right panel_toolbox');
				  echo ul($list,$attributes);
				  ?>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                	<div class="form-group ">
					  <?php
                      echo form_label(
                          'Readmore Button',
                          'readmore_btn',
                          'class="control-label col-md-3 col-sm-3 col-xs-12"'
                      );
                      ?>

                      <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php
                          // Input checkbox
                          echo form_checkbox(array(
                              'id'      => 'readmore_btn',
                              'name'    => 'readmore_btn',
                              'onchange' => 'readmorebtn()',
                              'class'   => 'js-switch',
                              'checked' => ($readmore_btn === '1') ? TRUE : FALSE,
                              'value'   => $readmore_btn
                          ));
                          ?>
                      </div>

                  </div>

                  <div id="readmoreurl" style="display:<?php if($readmore_btn == 1){echo 'block';}else{echo 'none';} ?>">

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
								  ' common-btn'	=> 'Square',
								  ' common-btn oval' => 'Oval'
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
                              'Button Background Color',
                              'btn_background_color',
                              'class="control-label col-md-3 col-sm-3 col-xs-12"'
                          );

						  // Input tag hidden
						  echo form_input(array(
							  'type'  => 'hidden',
							  'name'  => 'btn_background_color',
							  'id'    => 'btn_background_color',
							  'value' => $btn_background_color
						  ));
                          ?>

                          <div class="col-md-6 col-sm-6 col-xs-12">
                              <?php
							  // Color
							  $this->color->view($btn_background_color,'btn_background_color',4);
							  ?>
                          </div>

                      </div>

                      <div class="form-group">

                          <?php
                          echo form_label(
                              'Readmore Label',
                              'readmore_label',
                              'class="control-label col-md-3 col-sm-3 col-xs-12"'
                          );
                          ?>

                          <div class="col-md-6 col-sm-6 col-xs-12">
                              <?php
                              // Input tag
                              echo form_input(array(
                                  'id'       => 'readmore_label',
                                  'name'     => 'readmore_label',
                                  'class'    => 'form-control col-md-7 col-xs-12',
                                  'value'    => $readmore_label
                              ));
                              ?>
                          </div>

                      </div>

                      <div class="form-group">

                          <?php
                          echo form_label(
                              'Label Color',
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
							  $this->color->view($label_color,'label_color',5);
							  ?>
                          </div>

                      </div>

                      <div class="form-group">

                          <?php
                          echo form_label(
                              'Readmore URL <span class="required">*</span>',
                              'readmore_url',
                              'class="control-label col-md-3 col-sm-3 col-xs-12"'
                          );
                          ?>

                          <div class="col-md-6 col-sm-6 col-xs-12">
                              <?php
                              // Input tag
                              echo form_input(array(
                                  'id'       => 'readmore_url',
                                  'name'     => 'readmore_url',
                                  'class'    => 'form-control col-md-7 col-xs-12',
                                  'value'    => $readmore_url
                              ));
                              ?>
                              <span id="error_result"></span>
                          </div>

                      </div>

                      <div class="form-group ">
						<?php
                        echo form_label(
                            'Open New Tab',
                            'open_new_tab',
                            'class="control-label col-md-3 col-sm-3 col-xs-12"'
                        );
                        ?>

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            // Input checkbox
                            echo form_checkbox(array(
                                'id'      => 'open_new_tab',
                                'name'    => 'open_new_tab',
                                'class'   => 'js-switch',
                                'checked' => ($open_new_tab === '1') ? TRUE : FALSE,
                                'value'   => $open_new_tab
                            ));
                            ?>
                        </div>

                    </div>

                  </div>

                  <div id="text_image_developer" style="display:none">
                  	<?php echo br(1); ?>
                  	<div class="x_title">
                  		<?php echo heading('Customize Readmore Button', '2'); ?>
                  		<div class="clearfix"></div>
                  	</div>

                    <div class="form-group">

						<?php
                        echo form_label(
                            'Button Background Hover Color',
                            'background_hover',
                            'class="control-label col-md-3 col-sm-3 col-xs-12"'
                        );

                        // Input tag hidden
                        echo form_input(array(
                            'type'  => 'hidden',
                            'name'  => 'background_hover',
                            'id'    => 'background_hover',
                            'value' => $background_hover
                        ));
                        ?>

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            // Color
                            $this->color->view($background_hover,'background_hover',6);
                            ?>
                        </div>

                    </div>

                    <div class="form-group">

						<?php
                        echo form_label(
                            'Label Hover Color',
                            'text_hover',
                            'class="control-label col-md-3 col-sm-3 col-xs-12"'
                        );

                        // Input tag hidden
                        echo form_input(array(
                            'type'  => 'hidden',
                            'name'  => 'text_hover',
                            'id'    => 'text_hover',
                            'value' => $text_hover
                        ));
                        ?>

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            // Color
                            $this->color->view($text_hover,'text_hover',7);
                            ?>
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
				  		echo heading('Sort Order & Status', '2');
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
								'text_bg_image_background_color',
								'class="control-label col-md-3 col-sm-3 col-xs-12"'
							);
						?>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<?php
								// Input tag hidden
								echo form_input(array(
									'type'  => 'hidden',
									'name'  => 'text_bg_image_background_color',
									'id'    => 'text_bg_image_background_color',
									'value' => $text_bg_image_background
								));
																
								// Color
								$this->color->view($text_bg_image_background,'text_bg_image_background_color',8);
							?>
						</div>
					</div>

					<div class="form-group" id="component-bg-image" <?php if ($component_background == 'image') :?>
                            style="display:block;" <?php else : ?> style="display:none;" <?php endif;?>>

                            <?php

								if ($component_background == 'color') :
									$text_bg_image_background = '';
								endif;

								// label
								echo form_label(
									'Image <span class="required">* Recommended size(1200*400)</span>',
									'imgInp',
									'class="control-label col-md-3 col-sm-3 col-xs-12"'
								);
							?>

                            <div class="img-thumbnail sepH_a" id="show_image1">
                                <?php
									if ($text_bg_image_background != '') :

										$text_bg_image = $ImageUrl . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR . $text_bg_image_background;
										echo img(array(
												'src'   => $text_bg_image,
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
									'value' => $text_bg_image_background
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
                            echo form_label('Text Position','text_position','class="control-label col-md-3 col-sm-3 col-xs-12"');
                        ?>

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                               $options = array(
									  'left'	=> 'Left',
									  'right'	=> 'Right'
								  );

								$attributes = array(
									  'name' => 'text_position',
									  'id' => 'text_position',
									  'class'	=> 'form-control'
								  );

								echo form_dropdown($attributes, $options, $text_position);
                              ?>
                        </div>

                    </div>
				

                        <div class="form-group">

                            <?php
                            echo form_label('Sort Order <span class="required">*</span>','sort_order','class="control-label col-md-3 col-sm-3 col-xs-12"');
                            ?>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <?php
                                // Input tag
                                echo form_input(array(
                                    'id'       => 'sort_order',
                                    'name'     => 'sort_order',
									'required' => 'required',
                                    'class'    => 'form-control col-md-7 col-xs-12',
                                    'value'    => $sort_order
                                ));
                                ?>
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
                    if (empty($text_background_image_id)) :
                      $submit_value = 'Add';
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
                      'text_background_image/text_background_image_index/'.$page_id,
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
