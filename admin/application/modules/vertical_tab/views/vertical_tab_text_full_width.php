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
									'vertical_tab/vertical_tab_component/'.$page_id.'/'.$vertical_tab_id,
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
                'vertical_tab/insert_update_vertical_tab_text_full_width',
                'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
              );

              // Input tag hidden
              echo form_input(array(
                'type'  => 'hidden',
                'name'  => 'text_full_width_id',
                'id'    => 'text_full_width_id',
                'value' => $text_full_width_id
              ));
			  
			  // Input tag hidden
              echo form_input(array(
                'type'  => 'hidden',
                'name'  => 'vertical_tab_id',
                'id'    => 'vertical_tab_id',
                'value' => $vertical_tab_id
              ));

			   // Input tag hidden
              echo form_input(array(
                'type'  => 'hidden',
                'name'  => 'page_id',
                'id'    => 'page_id',
                'value' => $page_id
              ));
            ?>

            <div class="col-md-6 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">

                  <?php
										echo heading('Title & Content', '2');
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
						'id'       => 'text_full_width_title',
						'name'     => 'text_full_width_title',
						'class'    => 'form-control',
						'value'    => $text_full_width_title
					  ));
                      ?>
                    </div>

                    <div class="form-group">
					  <?php
                      echo form_label('Content <span class="required">*</span>','full-text');

                      // TextArea
					  $data = array(
						'name'        => 'full_text',
						'id'          => 'full_text',
						'value'       => $full_text
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
				  echo heading('Customize', '2');
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
						  'center-align'	=> 'Center',
						  'right-align'	=> 'Right'
					  );

					  $attributes = array(
						  'name'	=> 'title_position',
						  'id'	=> 'title_position',
						  'class'	=> 'form-control'
					  );

					  // Dropdown
					  echo form_dropdown($attributes, $options, $title_position);
                      ?>
                    </div>

                    <div class="form-group">

					  <?php
                      echo form_label('Content Title Color','content-title-color');

                       // Input tag hidden
                      echo form_input(array(
                        'type'  => 'hidden',
                        'name'  => 'content_title_color',
                        'id'    => 'content_title_color',
                        'value' => $content_title_color
                      ));

                      // Input tag
                      $this->color->view($content_title_color,'content_title_color',2);
                      ?>
                    </div>

                    <div class="form-group">
					  <?php
                      echo form_label('Content Title Position','content_title_position');

					  $options = array(
						  'left-align'	=> 'Left',
						  'center-align'	=> 'Center',
						  'right-align'	=> 'Right'
					  );

					  $attributes = array(
						  'name'	=> 'content_title_position',
						  'id'	=> 'content_title_position',
						  'class'	=> 'form-control'
					  );

					  // Dropdown
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

                    <div class="form-group">
					  <?php
                      echo form_label('Content Position','content_position');

					  $options = array(
						  'left-align'	=> 'Left',
						  'center-align'	=> 'Center',
						  'right-align'	=> 'Right',
						  'justify-align'	=> 'Justify'
					  );

					  $attributes = array(
						  'name'	=> 'content_position',
						  'id'	=> 'content_position',
						  'class'	=> 'form-control'
					  );

					  // Dropdown
					  echo form_dropdown($attributes, $options, $content_position);
                      ?>
                    </div>

                    <div class="form-group">
					  <?php
                      echo form_label('Background Color','background_color');

                      // Input tag hidden
					  echo form_input(array(
						'type'  => 'hidden',
						'name'  => 'background_color',
						'id'    => 'background_color',
						'value' => $background_color
					  ));

					  // Input tag
                  	  $this->color->view($background_color, 'background_color', 4);
                      ?>
                    </div>

                </div>
              </div>
            </div>



              <!-- Button Group -->

           <div class="col-md-12 col-sm-12 col-xs-12 ">
                <div class="input-button-group">
                  <?php
				      // Submit Button
                    if (empty($text_full_width_id)) :
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
                      'vertical_tab/vertical_tab_component/'.$page_id.'/'.$vertical_tab_id,
                      'Back',
                      array(
                        'title' => 'Back',
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
      </div>
    </div>
  </div>
<!-- /page content -->
