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
                'admin_menu/insert_update_menu',
                'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate autocomplete="off"'
              );

              // Input tag hidden
              echo form_input(array(
                'type'  => 'hidden',
                'name'  => 'menu-id',
                'id'    => 'menu-id',
                'value' => $menu_id
              ));
            ?>

            <div class="form-group">

              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="menu-name">
                Menu Name
                <span class="required">*</span>
              </label>

              <div class="col-md-6 col-sm-6 col-xs-12">
                <?php
                  // Input tag
                  echo form_input(array(
                    'id'       => 'menu-name',
                    'name'     => 'menu-name',
                    'required' => 'required',
                    'class'    => 'form-control col-md-7 col-xs-12',
                    'value'    => $menu_name
                  ));
                ?>
              </div>

            </div>

            <div class="form-group">

              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="menu-url">
                Menu Url
                <span class="required">*</span>
              </label>

              <div class="col-md-6 col-sm-6 col-xs-12">
                <?php
                  // Input
                  echo form_input(array(
                    'id'       => 'menu-url',
                    'name'     => 'menu-url',
                    'required' => 'required',
                    'class'    => 'form-control col-md-7 col-xs-12',
                    'value'    => $menu_url
                  ));
                ?>
              </div>
            </div>

            <div class="form-group">
              
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="menu-icon">
                Menu Icon                
              </label>

            
              <div class="col-md-6 col-sm-6 col-xs-12">
                <?php
                   // Input
                   echo form_input(array(
                    'id'                => 'menu-icon',
                    'name'              => 'menu-icon',
                    'required'          => 'required',
                    'class'             => 'form-control col-md-7 col-xs-12 icp icp-auto',
                    'data-input-search' => 'true',
                    'value'             => $menu_icon
                  ));

                  echo br('2');

                  echo '<p class="lead"><i class="fa '.$menu_icon.' fa-3x picker-target"></i></p>';                  
                ?>                
              </div>
            </div>

            <div class="form-group">
              <?php
                echo form_label(
                  'Status',
                  'menu-status',
                  'class="control-label col-md-3 col-sm-3 col-xs-12"'
                );
              ?>
            
              <div class="col-md-6 col-sm-6 col-xs-12">
                <?php
                  // Input checkbox
                  echo form_checkbox(array(
                    'id'      => 'menu-status',
                    'name'    => 'menu-status',
                    'class'   => 'js-switch',
                    'checked' => ($status === '1') ? TRUE : FALSE,
                    'value'   => $status
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
                    if (empty($menu_id)) :
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
                      'admin_menu',
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
