<?php
	/**
	 * Hover Image View
	 *
	 * @category View
	 * @package  Hover Image
	 * @author   Velu Samy
	 * Created at:  05-apr-2019
	 */
?>

<!-- page content -->
<div class="right_col" role="main">

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

        <?php if ($this->session->flashdata('success')!='') : // Display session data ?>
        <div class="alert alert-success alert-dismissible fade in text-center" id="success-alert" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <strong>Success!</strong>
            <?php echo $this->session->flashdata('success');?>
        </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error') != '') : // Display session data ?>
        <div class="alert alert-warning alert-dismissible fade in text-center" id="warning-alert" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <strong>
                <?php echo $this->session->flashdata('error');?>
            </strong>
        </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="x_panel">

                    <div class="x_title">

                        <?php
							echo heading('Customize Hover Image', '2');
							$attributes = array('class' => 'nav navbar-right panel_toolbox');
							$list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
							echo ul($list,$attributes);
						?>

                        <div class="clearfix"></div>
                    </div>

                    <div class="x_content">

                        <?php
							echo br();

							// Form Tag
							echo form_open(
								'hover_image/insert_update_hover_image_customize',
								'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
							);

							// Input tag hidden
							echo form_input(array(
								'type'  => 'hidden',
								'name'  => 'page-id',
								'id'    => 'page-id',
								'value' => $page_id
							));

							// Website Id
							echo form_input(array(
								'type' => 'hidden',
								'name' => 'website_id',
								'id' 	=> 'website_id',
								'value'=> $website_id
							));
						?>

                        <div class="form-group">
                            <?php
								echo form_label(
									'Hover Image Per Row',
									'position',
									'class="control-label col-md-3 col-sm-3 col-xs-12"'
								);
							?>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <?php
									$options = array(
										'over-one-col' 	 => '1',
										'over-two-col'	 => '2',
										'over-three-col' => '3',
										'over-four-col'  => '4'
									);

									$attributes = array(
										'name'	=> 'hover_image_row_count',
										'id'	=> 'hover_image_row_count',
										'class'	=> 'form-control col-md-7 col-xs-12'
									);

									echo form_dropdown($attributes, $options, $hover_image_row_count);
								?>
                            </div>
                        </div>

                        <div class="ln_solid"></div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="input-button-group">
                                <?php
									// Submit Button
									if (empty($hover_image_customize_data)) :
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
								?>
                            </div>
                        </div>

                        <?php
							//Form close
							echo form_close();
						?>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="x_panel">

        <div class="x_content">

            <?php
				echo form_open(
					'hover_image/delete_multiple_hover_image',
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
							'value' => base_url().'hover_image/update_sort_order'
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
							'hover_image/add_edit_hover_image/'.$page_id,
							'<i class="fa fa-plus" aria-hidden="true"></i> Add Hover Image',
							array(
							'class' => 'btn btn-success'
							)
						);
					?>
                </div>

            </div>

            <div class="row">
                <?php
					// Table
					echo $table;
				?>
            </div>

            <?php echo form_close();?>

            <!-- Confirm Delete Modal -->
            <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                aria-hidden="true">
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
<!-- Page Content -->