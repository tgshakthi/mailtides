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
                        'city',
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
                'city/insert_update_city',
                'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
              );

              // Input tag hidden
              echo form_input(array(
                'type'  => 'hidden',
                'name'  => 'city-id',
                'id'    => 'city-id',
                'value' => $id
              ));
            ?>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                    <?php
                        echo heading(
                            'City',
                            '2'
                        );
                    ?>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">                	
                    <div class="form-group">
                      <?php
                      echo form_label('City Name','city-name','class="control-label col-md-3 col-sm-3 col-xs-12"');
                      ?>

                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php
                          // Input tag
                          echo form_input(array(
                            'id'       => 'city-name',
                            'name'     => 'city-name',
                            'class'    => 'form-control col-md-7 col-xs-12',
                            'value'    => $name,
                            'required' => 'required'
                          ));
                        ?>
                      </div>
                    </div>
                    <div class="form-group">

                      <?php
                      echo form_label('Sort Order','sort_order','class="control-label col-md-3 col-sm-3 col-xs-12"');
                      ?>

                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php
                          // Input tag
                          echo form_input(array(
                            'id'       => 'sort_order',
                            'name'     => 'sort_order',
                            'class'    => 'form-control col-md-7 col-xs-12',
                            'value'    => $sort_order,
                            'required' => 'required'
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
                <div class="input_butt">
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
                        'id'    => 'btn',
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
                      'city',
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
