<!-- page content -->
<div class="right_col" role="main" id="datatable_content">
  <div class="">

    <div class="page-title">
      <div class="title_left">
        <?php echo heading('Social Media Feed', '3');?>
      </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">

      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
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

          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-11">
              <?php
                echo anchor(
                  'Social_media_feed/edit_social_media_feed',
                  'Add Social Feed',
                  array(
                    'class' => 'btn btn-success'
                  )
                );
              ?>
            </div>

            <?php
             /*  echo form_open(
								'Social_media_feed/delete_selected_user_role',
								'id="form_selected_record"'
              );

              echo form_button(array(
                'type'    => 'button',
                'name'    => 'delete-selected-user-role',
                'class'   => 'btn btn-danger',
								'content' => 'Delete',
								'id'			=> 'delete_selected_record'
              )); */

              // Table
              echo $table;

              echo form_close();
            ?>

						<!-- Confirm Delete Modal -->
						<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog">
										<div class="modal-content">

												<div class="modal-header">
														Confirm Delete
												</div>

												<div class="modal-body">
														<p>Are you sure you want to delete this record?</p>
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
																<a class="btn btn-danger" id="delete_btn_ok">Delete</a>
												</div>
										</div>
								</div>
						</div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /page content -->
