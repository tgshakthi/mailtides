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
                'admin_user/insert_update_user',
                'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate autocomplete="off"'
              );

              // Input tag hidden
              echo form_input(array(
                'type'  => 'hidden',
                'name'  => 'id',
                'id'    => 'id',
                'value' => $id
              ));
            ?>

            <div class="form-group">

              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                First Name
                <span class="required">*</span>
              </label>

              <div class="col-md-6 col-sm-6 col-xs-12">
                <?php
                  // Input tag
                  echo form_input(array(
                    'id'       => 'first-name',
                    'name'     => 'first-name',
                    'required' => 'required',
                    'class'    => 'form-control col-md-7 col-xs-12',
                    'value'    => $firstName
                  ));
                ?>
              </div>

            </div>

            <div class="form-group">

              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">
                Last Name
                <span class="required">*</span>
              </label>

              <div class="col-md-6 col-sm-6 col-xs-12">
                <?php
                  // Input
                  echo form_input(array(
                    'id'       => 'last-name',
                    'name'     => 'last-name',
                    'required' => 'required',
                    'class'    => 'form-control col-md-7 col-xs-12',
                    'value'    => $lastName
                  ));
                ?>
              </div>
            </div>

            <div class="form-group">

              <label for="user-name" class="control-label col-md-3 col-sm-3 col-xs-12">
                Username
                <span class="required">*</span>
              </label>

              <div class="col-md-6 col-sm-6 col-xs-12">
                <?php
                  // Input
                  echo form_input(array(
                    'id'       => 'user-name',
                    'name'     => 'user-name',
                    'required' => 'required',
                    'class'    => 'form-control col-md-7 col-xs-12',
                    'value'    => $username
                  ));
                ?>
              </div>
            </div>

            <div class="form-group">
              <label for="password" class="control-label col-md-3 col-sm-3 col-xs-12">
                Password
                <span class="required">*</span>
              </label>

              <div class="col-md-6 col-sm-6 col-xs-12">
                <?php
                  // Password
                  echo form_password(array(
                    'id'       => 'password',
                    'name'     => 'password',
                    'required' => 'required',
                    'class'    => 'form-control col-md-7 col-xs-12',
                    'value'    => $password
                  ));

                  // Input tag hidden
                  echo form_input(array(
                    'type'  => 'hidden',
                    'name'  => 'password-hidden',
                    'id'    => 'password-hidden',
                    'value' => $password
                  ));

                ?>
                </div>
              </div>

              <div class="form-group">
                <label for="email" class="control-label col-md-3 col-sm-3 col-xs-12">
                  Email
                  <span class="required">*</span>
                </label>

                <div class="col-md-6 col-sm-6 col-xs-12">
                  <?php
                    // Input
                    echo form_input(array(
                      'type'     => 'email',
                      'id'       => 'email',
                      'name'     => 'email',
                      'required' => 'required',
                      'class'    => 'form-control col-md-7 col-xs-12',
                      'value'    => $email
                    ));
                  ?>
                </div>
              </div>

              <div class="form-group">
                <?php
                  // label
                  echo form_label(
                    'Gender',
                    'gender',
                    'class="control-label col-md-3 col-sm-3 col-xs-12"'
                  );
                ?>

                <div class="col-md-6 col-sm-6 col-xs-12">

                  <label> Male
                    <?php
                      // Radio
                      echo form_radio(array(
                        'name'    => 'gender',
                        'value'   => 'Male',
                        'checked' => ('Male' == $gender) ? TRUE : FALSE,
                        'class'   => 'flat'
                      ));
                    ?>
                  </label>

                  <label>Female
                    <?php
                      // Radio
                      echo form_radio(array(
                        'name'    => 'gender',
                        'value'   => 'Female',
                        'checked' => ('Female' == $gender) ? TRUE : FALSE,
                        'class'   => 'flat'
                      ));
                    ?>
                  </label>

                </div>
              </div>

              <div class="form-group">
                <?php
                  // label
                  echo form_label(
                    'User Image',
                    'imgInp',
                    'class="control-label col-md-3 col-sm-3 col-xs-12"'
                  );
                ?>

                <div class="col-md-6 col-sm-6 col-xs-12 profile-container" <?php echo (!empty($user_image)) ? 'style="display: none"'  : ''; ?>>

                  <div class="input-group input-file" name="profile"  >

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
                                'id' => 'profile',
                                'class' => 'form-control',
                                'placeholder' => 'Upload Profile Image'
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

                <?php if ($user_image != '') : ?>
                  <div class="img-thumbnail sepH_a" id="show_image1">
                    <?php
                        echo img(array(
                          'src'   => $ImageUrl.$user_image,
                          'alt'   => $firstName,
                          'title' => $firstName,
                          'id'    => 'image_preview_fav',
                          'style' => 'width:170px; height:120px'
                        ));

                        echo form_input(array(
                          'type'  => 'hidden',
                          'name'  => 'profile',
                          'id'    => 'profile-img',
                          'value' => $user_image
                        ));
                    ?>
                  </div>

                  <?php 
                      echo form_button(
                        array(
                            'id' => 'change-profile-img',
                            'class' => 'btn btn-primary',
                            'content' => 'Change Profile Image'
                        )
                      );                 
                  ?>
                <?php  endif;?> 

              </div> 

              <div class="form-group">

                <?php
                  // Label
                  echo form_label(
                    'User Role',
                    'user-role',
                    'class="control-label col-md-3 col-sm-3 col-xs-12"'
                  );
                ?>

                <div class="col-md-6 col-sm-6 col-xs-12">

                  <?php
                    $userRoleOptions[''] = 'Please Select';
                    foreach ($user_role_options as $user_role) :
                      $userRoleOptions[$user_role->user_role_id] = $user_role->user_role_name;
                    endforeach;

                    $user_role_attributes = array(
                      'id'       => 'user-role',
                      'name'     => 'user-role',
                      'required' => 'required',
                      'class'    => 'form-control col-md-7 col-xs-12'
                    );

                    // Dropdown
                    echo form_dropdown(
                      $user_role_attributes,
                      $userRoleOptions,
                      $user_role_id
                    );
                  ?>
                </div>
              </div>

              <div class="form-group">

                <?php
                  // Label
                  echo form_label(
                    'Websites',
                    'websites',
                    'class="control-label col-md-3 col-sm-3 col-xs-12"'
                  );
                ?>

                <div class="col-md-6 col-sm-6 col-xs-12">
                  <?php
                    $websiteOptions = array();
                    foreach ($website_options as $website) :
                      $websiteOptions[$website->id] =  $website->website_name;
                    endforeach;
                    $selected = array_merge(explode(',', $website_id));
                    $website_attributes = array(
                      'id'       => 'websites',
                      'name'     => 'websites[]',
                      'required' => 'required',
                      'class'    => 'form-control col-md-7 col-xs-12 multiselect'
                    );

                    // Dropdown Multiselect
                    echo form_multiselect(
                      $website_attributes,
                      $websiteOptions,
                      $selected
                    );
                  ?>
                </div>
              </div>

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
                      'admin_user',
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
