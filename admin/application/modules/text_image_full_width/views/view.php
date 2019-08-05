<!-- page content -->
<div class="right_col" role="main" id="datatable_content">
  <div class="">

    <div class="page-title">
      <div class="title_left">
        <?php echo heading($heading, '3');?>
      </div>
			<div class="btn_right" style="text-align:right;">
				<?php
					echo anchor(
						'page/page_details/'.$page_id,
						'<i class="fa fa-chevron-left" aria-hidden="true"></i> Back',
						array(
							'class' => 'btn btn-primary'
						)
					);
				?>
			</div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
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
	  

      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_content">

          <?php
						echo form_open(
						'text_image_full_width/delete_multiple_text_image_full_width',
						'id="form_selected_record"'
						);
					?>

          <div class="page_buut_right">

						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
							<?php

									echo form_input(array(
										'type'  => 'hidden',
											'name'  => 'page_id',
											'id'    => 'page_id',
											'value' => $page_id
									));
									
									echo form_input(array(
										'type'  => 'hidden',
										'name'  => 'sort_id',
										'id'    => 'sort_id',
										'value' => $page_id
									));
									
									echo form_input(array(
										'type'  => 'hidden',
										'name'  => 'sort_url',
										'id'    => 'sort_url',
										'value' => base_url().'text_image_full_width/update_sort_order'
									));

								echo form_button(array(
									'type'    => 'button',
									'id'	  => 'delete_selected_record',
									'name'    => 'delete-selected-menu',
									'class'   => 'btn btn-danger',
									'content' => '<i class="fa fa-trash-o" aria-hidden="true"></i> Delete'
								));


							?>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="text-align:right;">
              <?php
                echo anchor(
                  'text_image_full_width/add_edit_text_image_full_width/'.$page_id,
                  '<i class="fa fa-plus" aria-hidden="true"></i> Add Text Image Full Width',
                  array(
                    'class' => 'btn btn-success'
                  )
                );
              ?>
            </div>

					</div>

             <?php
  				// Table
              echo $table;

              echo form_close();
			    ?>
          </div>

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
<!-- /page content -->
