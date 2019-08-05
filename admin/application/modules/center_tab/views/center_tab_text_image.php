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
					'center_tab/center_tab_index/'.$page_id,
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
                'center_tab/insert_update_center_tab_text_image',
                'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
              );

              // Input tag hidden
              echo form_input(array(
                'type'  => 'hidden',
                'name'  => 'text_image_id',
                'id'    => 'text_image_id',
                'value' => $text_image_id
              ));

			  // Input tag hidden
              echo form_input(array(
                'type'  => 'hidden',
                'name'  => 'center_tab_id',
                'id'    => 'center_tab_id',
                'value' => $center_tab_id
              ));

			  // Input tag hidden
              echo form_input(array(
                'type'  => 'hidden',
                'name'  => 'page_id',
                'id'    => 'page_id',
                'value' => $page_id
              ));
            ?>

            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <?php
										echo heading('Choose Image', '2');
										$list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
										$attributes = array('class' => 'nav navbar-right panel_toolbox');
										echo ul($list,$attributes);
									?>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <div class="form-group">

												<?php

                        // label
                        echo form_label(
                            'Image <span class="required">* Recommended (700*497)</span>',
                            'imgInp',
                            'class="control-label col-md-3 col-sm-3 col-xs-12"'
                        );
                        ?>

                        <div class="img-thumbnail sepH_a" id="show_image1">
                            <?php
                            if ($image != '') :
                                
                                $image = $ImageUrl . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR . $image;
							

                                echo img(array(
                                    'src'   => $image,
                                    'alt'   => $image_alt,
                                    'title' => $image_title,
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
                            'value' => $image
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

                        <a data-toggle="modal" class="btn btn-primary" data-target="#ImagePopUp" href="javascript:;" type="button">
                            Select Image
                        </a>

                        <?php if($image != "") :?>
                        <a data-toggle="modal" class="btn btn-primary" id="imageRemove" data-target="#confirm-delete" href="javascript:;">
                            Remove Image
                        </a>
                        <?php endif;?>
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
                                    <iframe width="880" height="400" src="<?php echo $ImageUrl ;?>filemanager/dialog.php?type=1&field_id=image&rootfldr=<?php echo $website_folder_name;?>/" frameborder="0" style="overflow: scroll; overflow-x: hidden; overflow-y: scroll; "></iframe>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Confirm Delete Modal -->
                    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <div class="modal-header">
                                    Confirm Delete
                                </div>

                                <div class="modal-body">
                                    <p>You are about to delete this Image</p>
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
                                    <a class="btn btn-danger" id="btn_ok">Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">

                          <?php
                          echo form_label('Image Title','image_title','class="control-label col-md-3 col-sm-3 col-xs-12"');
                          ?>

                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                              // Input tag
                              echo form_input(array(
                                'id'       => 'image_title',
                                'name'     => 'image_title',
                                'class'    => 'form-control col-md-7 col-xs-12',
                                'value'    => $image_title
                              ));
                            ?>
                          </div>

                    </div>

                    <div class="form-group">

                      <?php
                      echo form_label('Image Alt','image_alt','class="control-label col-md-3 col-sm-3 col-xs-12"');
                      ?>

                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php
                          // Input tag
                          echo form_input(array(
                            'id'       => 'image_alt',
                            'name'     => 'image_alt',
                            'class'    => 'form-control col-md-7 col-xs-12',
                            'value'    => $image_alt
                          ));
                        ?>
                      </div>

                    </div>

                    <div class="form-group">

						<?php
                        echo form_label('Choose Text & Image Template','','class="control-label col-md-3 col-sm-3 col-xs-12"');
                        ?>

                        <div class="col-md-3 col-sm-3 col-xs-12">

                            <?php

							$choose_btn_template_color = ($template == 1) ? 'success' : 'danger';

                            $textimagebulletbtn = array(
                                'data-toggle'	=> 'modal',
                                'data-target'	=> '#textimagebullet',
								'id'	=> 'templatetextimagebullet',
                                'class'	=> 'btn btn-'.$choose_btn_template_color.' form-control col-md-7 col-xs-12',
                                'content'	=> 'Text & Image with bullets'
                            );

                            echo form_button($textimagebulletbtn);
                            ?>

                        </div>

                        <div class="col-md-3 col-sm-3 col-xs-12">

                            <?php
							$choose_btn_template_color_2 = ($template == 2) ? 'success' : 'danger';
                            $textimagewithoutbulletbtn = array(
                                'data-toggle'	=> 'modal',
                                'data-target'	=> '#textimagewithoutbullet',
								'id'	=> 'templatetextimagewithoutbullet',
                                'class'	=> 'btn btn-'.$choose_btn_template_color_2.' form-control col-md-7 col-xs-12',
                                'content'	=> 'Text & Image without bullets'
                            );

                            echo form_button($textimagewithoutbulletbtn);
                            ?>

                        </div>

                    </div>

                     <!-- Image With Bullet -->

                    <div class="modal fade in" id="textimagebullet" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog previewwidth" role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <?php
                                    echo img(array(
                                        'src'   => $ImageUrl.'images/text_image/textandimagewithbullet.png',
                                        'style' => 'width:100%;'
                                    ));
                                    ?>
                                </div>
                                <div class="modal-footer">
                                    <?php
                                    $Closebtn = array(
                                        'data-dismiss'	=> 'modal',
                                        'class'	=> 'btn btn-default',
                                        'content'	=> 'Close'
                                    );

                                    echo form_button($Closebtn);

                                    $choosetemplatebtn = array(
                                        'data-dismiss'	=> 'modal',
                                        'class'	=> 'btn btn-primary',
                                        'onclick'	=> 'choosetemplate(1)',
                                        'content'	=> 'Choose Template'
                                    );

                                    echo form_button($choosetemplatebtn);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                     <!-- Image Without Bullet -->

                    <div class="modal fade" id="textimagewithoutbullet" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog previewwidth" role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <?php
                                    echo img(array(
                                        'src'   => $ImageUrl.'images/text_image/textimagewithout_bullet.png',
                                        'style' => 'width:100%;'
                                    ));
                                    ?>
                                </div>
                                <div class="modal-footer">
                                    <?php
                                    $Closebtn = array(
                                        'data-dismiss'	=> 'modal',
                                        'class'	=> 'btn btn-default',
                                        'content'	=> 'Close'
                                    );

                                    echo form_button($Closebtn);

                                    $choosetemplatebtn = array(
                                        'data-dismiss'	=> 'modal',
                                        'class'	=> 'btn btn-primary',
                                        'onclick'	=> 'choosetemplate(2)',
                                        'content'	=> 'Choose Template'
                                    );

                                    echo form_button($choosetemplatebtn);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Image With Bullet -->

                    <div class="form-group" id="imagepostionwithbullet" style="display:<?php echo (isset($template) && $template == "1")? "block": 'none';?>;">
                        <?php
                        echo form_label('Image Position','image_position_bullet','class="control-label col-md-3 col-sm-3 col-xs-12"');
                        ?>

                        <div class="col-md-6 col-sm-6 col-xs-12">

                            <?php
                            $options = array(
                                'left'	=> 'Left',
                                'right'	=> 'Right'
                            );

                            $attributes = array(
                                'name' => 'image_position_bullet',
                                'id' => 'image_position_bullet',
                                'class'	=> 'form-control col-md-8 col-xs-12'
                            );

                            echo form_dropdown($attributes, $options, $image_position);
                            ?>

                        </div>

                    </div>

                    <div class="form-group" id="imagesizewithbullet" style="display:<?php echo (isset($image_position) && $template == '1' && $image_position == "img_part_center")? "block": 'none';?>;">

                        <?php
                        echo form_label('Image Size','image_size_with_bullet','class="control-label col-md-3 col-sm-3 col-xs-12"');
                        ?>

                        <div class="col-md-6 col-sm-6 col-xs-12">

                            <?php
                            $options = array(
                                'm1' => '8 %',
                                'm2' => '16 %',
                                'm3' => '25 %',
                                'm4' => '33 %',
                                'm5' => '41 %',
                                'm6' => '50 %',
                                'm7' => '58 %',
                                'm8' => '66 %',
                                'm9' => '75 %',
                                'm10' => '83 %',
                                'm11' => '91 %',
                                'm12' => '100 %'
                            );

                            $attributes = array(
                                'name' => 'image_size_with_bullet',
                                'id' => 'image_size_with_bullet',
                                'class'	=> 'form-control col-md-7 col-xs-12'
                            );

                            echo form_dropdown($attributes, $options, $image_size);
                            ?>

                        </div>

                    </div>

                    <?php
					echo form_input(array(
                        'type'  => 'hidden',
                        'name'  => 'template',
                        'id'    => 'template',
                        'value' => $template
                    ));
                    echo form_input(array(
                        'type'  => 'hidden',
                        'name'  => 'image_pos',
                        'id'    => 'image_pos',
                        'value' => (!empty($image_position)) ? $image_position : 'left'
                    ));
					echo form_input(array(
                        'type'  => 'hidden',
                        'name'  => 'image_size',
                        'id'    => 'image_size',
                        'value' => (!empty($image_size)) ? $image_size : 'm1'
                    ));
                    ?>

                    <!-- Image Without Bullet -->

                    <div class="form-group" id="imagepostionwithoutbullet" style="display:<?php echo (isset($template) && $template == "2")? "block": 'none';?>;">

                        <?php
                        echo form_label('Image Position','image_position','class="control-label col-md-3 col-sm-3 col-xs-12"');
                        ?>

                        <div class="col-md-6 col-sm-6 col-xs-12">

                            <?php
                            $options = array(
                                'left'	=> 'Left',
                                'right'	=> 'Right'
                            );

                            $attributes = array(
                                'name' 	=> 'image_position',
                                'id' 	=> 'image_position',
                                'class'	=> 'form-control col-md-7 col-xs-12'
                            );

                            echo form_dropdown($attributes, $options, $image_position);
                            ?>

                        </div>
                    </div>

                    <div class="form-group" id="image_sizediv" style="display:<?php echo (isset($template) && $template == "2")? "block": 'none';?>;">

                        <?php
                        echo form_label('Image Size','image_size_without_bullet','class="control-label col-md-3 col-sm-3 col-xs-12"');
                        ?>

                        <div class="col-md-6 col-sm-6 col-xs-12">

                            <?php
                            $options = array(
															'm1' => '8 %',
															'm2' => '16 %',
															'm3' => '25 %',
															'm4' => '33 %',
															'm5' => '41 %',
															'm6' => '50 %',
															'm7' => '58 %',
															'm8' => '66 %',
															'm9' => '75 %',
															'm10' => '83 %',
															'm11' => '91 %',
															'm12' => '100 %'
                            );

                            $attributes = array(
                                'name' => 'image_size_without_bullet',
                                'id' => 'image_size_without_bullet',
                                'class'	=> 'form-control col-md-7 col-xs-12'
                            );

                            echo form_dropdown($attributes, $options, $image_size);
                            ?>

                        </div>

                    </div>

                </div>
              </div>
            </div>

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
							'value'    => $text_image_title
						));
						?>

                    </div>

                    <div class="form-group">

						<?php
                        echo form_label('Text','text');

						// TextArea
						$data = array(
							'name'        => 'text',
							'id'          => 'full_text',
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
                        echo form_label('Title Color','title_color');

                        // Input tag hidden
                        echo form_input(array(
                            'type'  => 'hidden',
                            'name'  => 'title_color',
                            'id'    => 'title_color',
                            'value' => $title_color
                        ));

						// Input tag
						$this->color->view($title_color,'title_color',1);
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
                      echo form_label('Content Title Color','content_title_color');

                      // Input tag hidden
                      echo form_input(array(
                          'type'  => 'hidden',
                          'name'  => 'content_title_color',
                          'id'    => 'content_title_color',
                          'value' => $content_title_color
                      ));

					  // Color
					  $this->color->view($content_title_color, 'content_title_color', 2);
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
                        echo form_label('Content Color','content_color');

                        // Input tag hidden
                        echo form_input(array(
                            'type'  => 'hidden',
                            'name'  => 'content_color',
                            'id'    => 'content_color',
                            'value' => $content_color
                        ));

						// Color
						$this->color->view($content_color,'content_color',3);
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
                            'Background Hover',
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
                            'Text Hover',
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
                     <div class="form-group ">

						<?php
                        echo form_label(
                            'Border',
                            'border_status',
                            'class="control-label col-md-3 col-sm-3 col-xs-12"'
                        );
                        ?>

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            // Input checkbox
                            echo form_checkbox(array(
                                'id'      => 'border_status',
                                'name'    => 'border_status',
								//'onclick' => 'border_status()',
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
                                $this->color->view($border_color,'border_color',8);
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
                            echo form_label('Background Color','background_color','class="control-label col-md-3 col-sm-3 col-xs-12"');

                            // Input tag hidden
                            echo form_input(array(
                                'type'  => 'hidden',
                                'name'  => 'background_color',
                                'id'    => 'background_color',
                                'value' => $background_color
                            ));
                            ?>

                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <?php
                                // Color
                                $this->color->view($background_color,'background_color',9);
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
                    if (empty($text_image_id)) :
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
                      'center_tab/center_tab_index/'.$page_id,
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
