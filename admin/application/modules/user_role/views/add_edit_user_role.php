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
                'user_role/insert_update_user_role',
                'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
              );

              // Input tag hidden
              echo form_input(array(
                'type'  => 'hidden',
                'name'  => 'user_role_id',
                'id'    => 'user_role_id',
                'value' => $user_role_id
              ));
            ?>

            <div class="form-group">

              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user-role-name">
                User Role Name
                <span class="required">*</span>
              </label>

              <div class="col-md-6 col-sm-6 col-xs-12">
                <?php
                  // Input tag
                  echo form_input(array(
                    'id'       => 'user-role-name',
                    'name'     => 'user-role-name',
                    'required' => 'required',
                    'class'    => 'form-control col-md-7 col-xs-12',
                    'value'    => $user_role_name
                  ));
                ?>
              </div>

            </div>

            <div class="form-group">

              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user-role">
                User Role
                <span class="required">*</span>
              </label>

              <div class="col-md-6 col-sm-6 col-xs-12">
                <?php
                  // Input
                  echo form_input(array(
                    'id'       => 'user-role',
                    'name'     => 'user-role',
                    'required' => 'required',
                    'class'    => 'form-control col-md-7 col-xs-12',
                    'value'    => $user_role
                  ));
                ?>
              </div>
            </div>
            
            <div class="form-group">
              
              <?php
                echo form_label(
                  'Read',
                  'user-role-view',
                  'class="control-label col-md-3 col-sm-3 col-xs-12"'
                );
              ?>
              
              <div class="col-md-6 col-sm-6 col-xs-12">
                <?php                  
                  // Input checkbox
                  echo form_checkbox(array(
                    'id'      => 'user-role-view',
                    'name'    => 'user-role-view',
                    'class'   => 'js-switch',
                    'checked' => ($view === '1') ? TRUE : FALSE,
                    'value'   => $view
                  ));
                ?>
              </div>
            </div>
            
            <div class="form-group">
              
              <?php
                echo form_label(
                  'Add',
                  'user-role-add',
                  'class="control-label col-md-3 col-sm-3 col-xs-12"'
                );
              ?>
              
              <div class="col-md-6 col-sm-6 col-xs-12">
                
                <?php
                  // Input checkbox
                  echo form_checkbox(array(
                    'id'      => 'user-role-add',
                    'name'    => 'user-role-add',
                    'class'   => 'js-switch',
                    'checked' => ($add === '1') ? TRUE : FALSE,
                    'value'   => $add
                  ));
                ?>
              </div>
            </div>
            
            <div class="form-group">
              
              <?php
                echo form_label(
                  'Edit',
                  'user-role-edit',
                  'class="control-label col-md-3 col-sm-3 col-xs-12"'
                );
              ?>
              
              <div class="col-md-6 col-sm-6 col-xs-12">
                <?php
                  // Input checkbox
                  echo form_checkbox(array(
                    'id'      => 'user-role-edit',
                    'name'    => 'user-role-edit',
                    'class'   => 'js-switch',
                    'checked' => ($edit === '1') ? TRUE : FALSE,
                    'value'   => $edit
                  ));
                ?>
              </div>
            </div>
            
            <div class="form-group">
              
              <?php
                echo form_label(
                  'Delete',
                  'user-role-delete',
                  'class="control-label col-md-3 col-sm-3 col-xs-12"'
                );
              ?>
              
              <div class="col-md-6 col-sm-6 col-xs-12">
                <?php
                  // Input checkbox
                  echo form_checkbox(array(
                    'id'      => 'user-role-delete',
                    'name'    => 'user-role-delete',
                    'class'   => 'js-switch',
                    'checked' => ($delete === '1') ? TRUE : FALSE,
                    'value'   => $delete
                  ));
                ?>
              </div>
            </div>
            
            <div class="form-group">
              
              <?php
                echo form_label(
                  'Publish',
                  'user-role-publish',
                  'class="control-label col-md-3 col-sm-3 col-xs-12"'
                );
              ?>
              
              <div class="col-md-6 col-sm-6 col-xs-12">
                <?php
                  // Input checkbox
                  echo form_checkbox(array(
                    'id'      => 'user-role-publish',
                    'name'    => 'user-role-publish',
                    'class'   => 'js-switch',
                    'checked' => ($publish === '1') ? TRUE : FALSE,
                    'value'   => $publish
                  ));
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
                    'id'      => 'user-role-status',
                    'name'    => 'user-role-status',
                    'class'   => 'js-switch',
                    'checked' => ($active === '1') ? TRUE : FALSE,
                    'value'   => $active
                  ));
                ?>
              </div>
            </div>
            
            <div class="ln_solid"></div>

              <!-- Button Group -->

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="input-button-group">
                  <?php
				  
				            // Submit Button
                    if (empty($user_role_id)) :
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
                      'user_role',
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
