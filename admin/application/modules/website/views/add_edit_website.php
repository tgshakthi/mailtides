<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">

          <div class="x_title">
            <?php echo heading($heading, '2');?>
            <div class="clearfix"></div>
          </div>

          <div class="x_content">

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

            <?php
              // Break tag
              echo br();

              // Form Tag
              echo form_open_multipart(
                'website/insert_update_website',
                'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate autocomplete="off"'
              );

              // Input tag hidden
              echo form_input(array(
                'type'  => 'hidden',
                'name'  => 'id',
                'id'    => 'id',
                'value' => $id
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

            <div class="form-group">

              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                Website Name
                <span class="required">*</span>
              </label>

              <div class="col-md-6 col-sm-6 col-xs-12">
                <?php
                  // Input tag
                  echo form_input(array(
                    'id'       => 'website-name',
                    'name'     => 'website-name',
                    'required' => 'required',
                    'class'    => 'form-control col-md-7 col-xs-12',
                    'value'    => $websiteName
                  ));
                ?>
              </div>

            </div>

            <div class="form-group">

              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="website-url">
                Website Url
                <span class="required">*</span>
              </label>

              <div class="col-md-6 col-sm-6 col-xs-12">
                <?php
                  // Input
                  echo form_input(array(
                    'id'       => 'website-url',
                    'name'     => 'website-url',
                    'required' => 'required',
                    'class'    => 'form-control col-md-7 col-xs-12',
                    'value'    => $websiteUrl
                  ));
                ?>
              </div>
            </div>

            <div class="form-group">

              <?php
                // label
                echo form_label(
                  'Favicon  <span class="required"> Recommended (16x16)</span>',
                  'favicon',
                  'class="control-label col-md-3 col-sm-3 col-xs-12"'
                );
              ?>

              <div class="col-md-6 col-sm-6 col-xs-12 favicon-container" <?php echo (!empty($favicon)) ? 'style="display: none"'  : ''; ?>>

                <div class="input-group input-file" name="favicon"  >

                  <span class="input-group-btn">
                      <?php
                          // Choose Button
                          echo form_button(
                              array(
                                  'type' => 'button',
                                  'class' => 'btn btn-default btn-choose',
                                  'content' => 'Upload'
                              )
                          );
                      ?>
                  </span>

                  <?php
                      // Input Tag
                      echo form_input(
                          array(
                              'id' => 'favicon',
                              'class' => 'form-control',
                              'placeholder' => 'Upload Favicon'
                          )
                      );
                  ?>

                  <span class="input-group-btn">
                      <?php
                          echo form_button(
                              array(
                                  'type' => 'button',
                                  'class' => 'btn btn-warning btn-reset',
                                  'content' => 'Reset'
                              )
                          );
                      ?>
                  </span>

                </div>

              </div>

              <?php if ($favicon != '') : ?>
                <div class="img-thumbnail sepH_a" id="show_image1">
                  <?php
                      $favicon_img = $ImageUrl . 'images' . DIRECTORY_SEPARATOR . $folder_name . DIRECTORY_SEPARATOR . $favicon;
                      echo img(array(
                        'src'   => $favicon_img,
                        'alt'   => $websiteName,
                        'title' => $websiteName,
                        'id'    => 'image_preview_fav',
                        'style' => 'width:70px; height:50px'
                      ));

                      echo form_input(array(
                        'type'  => 'hidden',
                        'name'  => 'favicon',
                        'id'    => 'favicon-img',
                        'value' => $favicon
                      ));
                  ?>
                </div>

                <?php 
                    echo form_button(
                      array(
                          'id' => 'change-favicon',
                          'class' => 'btn btn-primary',
                          'content' => 'Change Favicon'
                      )
                    );                 
                ?>

              <?php  endif;?> 

            </div>


            <div class="form-group">

              <?php
                // label
                echo form_label(
                  'Logo <span class="required"> Recommended (700x250)</span>',
                  'imgInp',
                  'class="control-label col-md-3 col-sm-3 col-xs-12"'
                );
              ?>

              <div class="col-md-6 col-sm-6 col-xs-12 logo-container" <?php echo (!empty($logo)) ? 'style="display: none"'  : ''; ?>>

              <div class="input-group input-file" name="logo">

                <span class="input-group-btn">
                    <?php
                        // Choose Button
                        echo form_button(
                            array(
                                'type' => 'button',
                                'class' => 'btn btn-default btn-choose',
                                'content' => 'Upload'
                            )
                        );
                    ?>
                </span>

                <?php
                    // Input Tag
                    echo form_input(
                        array(
                            'id' => 'logo',
                            'class' => 'form-control',
                            'placeholder' => 'Upload logo'
                        )
                    );
                ?>

                <span class="input-group-btn">
                    <?php
                        echo form_button(
                            array(
                                'type' => 'button',
                                'class' => 'btn btn-warning btn-reset',
                                'content' => 'Reset'
                            )
                        );
                    ?>
                </span>

              </div>

              </div>

              <?php if ($logo != '') : ?>

                <div class="img-thumbnail sepH_a" id="show_image2">
                  <?php
                    $logo_img = $ImageUrl . 'images' . DIRECTORY_SEPARATOR . $folder_name . DIRECTORY_SEPARATOR . $logo;
                    
                    echo img(array(
                      'src'   => $logo_img,
                      'alt'   => $websiteName,
                      'title' => $websiteName,
                      'id'    => 'image_preview_fav',
                      'style' => 'width:170px; height:120px'
                    ));

                    echo form_input(array(
                      'type'  => 'hidden',
                      'name'  => 'logo',
                      'id'    => 'logo-img',
                      'value' => $logo
                    ));
                  ?>
                </div>

                <?php 
                    echo form_button(
                      array(
                          'id' => 'change-logo',
                          'class' => 'btn btn-primary',
                          'content' => 'Change Logo'
                      )
                    );                 
                ?>

              <?php  endif;?> 

            </div>
              

            <div class="form-group">

              <?php
                echo form_label(
                  'Website Status',
                  'website-status',
                  'class="control-label col-md-3 col-sm-3 col-xs-12"'
                );
              ?>

              <div class="col-md-6 col-sm-6 col-xs-12">
                <?php
                  // Input
                  echo form_checkbox(array(
                    'id'      => 'website-status',
                    'name'    => 'website-status',
                    'class'   => 'js-switch',
                    'checked' => ($status === '1') ? TRUE : FALSE,
                    'value'   => $status
                  ));
                ?>
              </div>
            </div>

            <?php if (empty($id)): ?>

            	<div class="form-group">

				  <?php
                    echo form_label(
                      'Clone Website',
                      'clone_website',
                      'class="control-label col-md-3 col-sm-3 col-xs-12"'
                    );
                  ?>

                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php
                    $options = array('' => 'select');
                    if(!empty($websites)):

                        foreach($websites as $website):

                            $options[$website->id] = $website->website_name;

                        endforeach;

                    endif;

                      $attributes = array(
                          'name'	=> 'clone_website',
                          'id'	=> 'clone_website',
                          'class'	=> 'form-control'
                      );

                      echo form_dropdown($attributes, $options, '');
                    ?>
                  </div>
                </div>

            <?php endif; ?>

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
                      'website',
                      'Back',
                      array(
                        'title' => 'back',
                        'class' => 'btn btn-primary'
                      )
                    );

                    echo br(3)

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
