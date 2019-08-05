<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">

          <div class="x_title">
            <?php 
				echo heading($heading, '2');
				$list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
				$attributes = array('class' => 'nav navbar-right panel_toolbox');
				echo ul($list,$attributes);
				?>
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
                'Social_media_feed/insert_update_social_media_feed',
                'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
              );

              // Input tag hidden
              echo form_input(array(
                'type'  => 'hidden',
                'name'  => 'feed_id',
                'id'    => 'feed_id',
                'value' => $feed_id
              ));
            ?>

            <div class="form-group">

              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user-role-name">
               Media Name
                <span class="required">*</span>
              </label>

              <div class="col-md-6 col-sm-6 col-xs-12">
                <?php
                  // Input tag
                  echo form_input(array(
                    'id'       => 'media_name',
                    'name'     => 'media_name',
                    'required' => 'required',
                    'class'    => 'form-control col-md-7 col-xs-12',
                    'value'    => $media_name
                  ));
                ?>
              </div>

            </div>

            <div class="form-group">

              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user-role">
               Media Name Url
                <span class="required">*</span>
              </label>

              <div class="col-md-6 col-sm-6 col-xs-12">
                <?php
                  // Input
                  echo form_input(array(
                    'id'       => 'media_url',
                    'name'     => 'media_url',
                    'required' => 'required',
                    'class'    => 'form-control col-md-7 col-xs-12',
                    'value'    => $media_url
                  ));
                ?>
              </div>
            </div>
            
			<div class="form-group">
				<?php
					echo form_label(
						'Media Feed Url<span class="required">*</span>',
						'Media Feed Url',
						'class="control-label col-md-3 col-sm-3 col-xs-12"'
						
					);
					?>

				<div class="col-md-6 col-sm-6 col-xs-12">
					<?php
						// Input tag
						$data = array(
							'name'        => 'media_feed_text',
							'id'          => 'media_feed_text',
							'required' => 'required',
							'value'       => $media_feed_text,
							'class' => 'form-control'
						);
						echo form_textarea($data);
					?>
				</div>
			</div>	
           
           
          
            <div class="form-group">

              <?php
                echo form_label(
                  'Status',
                  'user-role-status',
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

              <!-- Button Group -->

              <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">
                  <?php
				  
				   // Submit Button
                    if (empty($feed_id)) :
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
                      'social_media_feed',
                      'Back',
                      array(
                        'title' => 'Back',
                        'class' => 'btn btn-primary'
                      )
                    );

                    // Reset Button
                    echo form_reset(
                      array(
                        'class' => 'btn btn-primary',
                        'value' => 'Reset'
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
