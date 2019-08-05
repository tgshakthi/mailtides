<?php
	/**
	 * Gallery View
	 *
	 * @category View
	 * @package  Gallery
	 * @author   Saravana
	 * Created at:  11-Jul-2018
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
            <div class="col-md-6 col-xs-12">
                <div class="x_panel">

                    <div class="x_title">

                        <?php
							echo heading('Gallery Title', '2');

							$attributes = array('class' => 'nav navbar-right panel_toolbox');
							$list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
							echo ul($list,$attributes);
						?>

                        <div class="clearfix"></div>
                    </div>

                    <div class="x_content">

                        <?php
							// Break Tag
							echo br();

							// Form Tag
							  echo form_open(
								'gallery/insert_update_gallery_title',
								'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
							  );

										// Input tag hidden
							  echo form_input(array(
								'type'  => 'hidden',
								'name'  => 'page-id',
								'id'    => 'page-id',
								'value' => $page_id
											));

											// Input tag hidden
							  echo form_input(array(
								'type'  => 'hidden',
								'name'  => 'sort_id',
								'id'    => 'sort_id',
								'value' => $page_id
											));

							// Website Id
							echo form_input(array(
								'type' => 'hidden',
								'name' => 'website_id',
								'id' => 'website_id',
								'value'=> $website_id
							));
						?>

                        <div class="form-group">
                            <?php
								echo form_label(
									'Title',
									'gallery_title',
									'class="control-label col-md-3 col-sm-3 col-xs-12"'
								);
							?>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <?php
									// Input tag
									echo form_input(array(
										'id'       => 'gallery_title',
										'name'     => 'gallery_title',
										'class'    => 'form-control col-md-7 col-xs-12',
										'value'    => $gallery_title
									));
								?>
                                <span id="error_result"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php
								echo form_label(
									'Title Color',
									'title-color',
									'class="control-label col-md-3 col-sm-3 col-xs-12"'
								);

								// Input tag hidden
								echo form_input(array(
									'type'  => 'hidden',
									'name'  => 'title-color',
									'id'    => 'title-color',
									'value' => $gallery_title_color
								));
							?>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <?php
									// Input Tag
									$this->color->view($gallery_title_color,'title-color',1);
								?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php
								echo form_label(
									'Title Position',
									'title_position',
									'class="control-label col-md-3 col-sm-3 col-xs-12"'
								);
							?>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <?php
									$options = array(
										'left-align'	 => 'Left',
										'center-align' => 'Center',
										'right-align'	 => 'Right'
									);

									$attributes = array(
										'name'	=> 'gallery_title_position',
										'id'	=> 'gallery_title_position',
										'class'	=> 'form-control col-md-7 col-xs-12'
									);

									echo form_dropdown($attributes, $options, $gallery_title_position);
								?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php
								echo form_label(
									'Status',
									'Status',
									'class="control-label col-md-3 col-sm-3 col-xs-12"'
								);
							?>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <?php
									// Input checkbox
									echo form_checkbox(array(
										'id'      => 'gallery_title_status',
										'name'    => 'gallery_title_status',
										'class'   => 'js-switch',
										'checked' => ($gallery_title_status === '1') ? TRUE : FALSE,
										'value'   => $gallery_title_status
									));
								?>
                            </div>
                        </div>

                        <div class="ln_solid"></div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="input-button-group">
                                <?php
									// Submit Button
									if (empty($gallery_title_data)) :
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

            <div class="col-md-6 col-xs-12">
                <div class="x_panel">

                    <div class="x_title">

                        <?php
							echo heading('Customize Gallery', '2');
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
                'gallery/insert_update_gallery_customize',
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
								'id' => 'website_id',
								'value'=> $website_id
							));
						?>

                        <div class="form-group">
                            <?php
								echo form_label(
									'Gallery Per Rows',
									'position',
									'class="control-label col-md-3 col-sm-3 col-xs-12"'
								);
							?>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <?php
									$options = array(
										'gallery-two-col'	=> '2',
										'gallery-three-col'	=> '3',
										'gallery-four-col'	=> '4',
										'gallery-five-col'	=> '5',
										'gallery-six-col'	=> '6',
									);

									$attributes = array(
										'name'	=> 'gallery_row_count',
										'id'	=> 'gallery_row_count',
										'class'	=> 'form-control col-md-7 col-xs-12'
									);

									echo form_dropdown($attributes, $options, $row_count);
								?>
                            </div>
                        </div>

                      <!--  <div class="form-group">
                            <?php
								echo form_label(
									'Background Color',
									'gallery_background_color',
									'class="control-label col-md-3 col-sm-3 col-xs-12"'
								);

								// Input tag hidden
								echo form_input(array(
									'type'  => 'hidden',
									'name'  => 'gallery_background_color',
									'id'    => 'gallery_background_color',
									'value' => $background_color
								));
							?>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <?php
									// Color
									$this->color->view($background_color,'gallery_background_color',2);
								?>
                            </div>
                        </div> -->

						 <div class="form-group">
                            <?php
								echo form_label(
									'Background',
									'component-background',
									'class="control-label col-md-3 col-sm-3 col-xs-12"'
								);
							?>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <?php

									$options = array(
										'' => 'Select',
										'color'	 => 'Color',
										'image' => 'Image'
									);

									$attributes = array(
										'name'	=> 'component-background',
										'id'	=> 'component-background',
										'class'	=> 'form-control col-md-7 col-xs-12'
									);

									echo form_dropdown($attributes, $options, $component_background);			
									
								?>
                            </div>
                        </div>

                        <div class="form-group" id="component-bg-color" <?php if ($component_background == 'color') :?>
                            style="display:block;" <?php else : ?> style="display:none;" <?php endif;?>>
                            <?php
								echo form_label(
									'Background Color',
									'gallery_image_background_color',
									'class="control-label col-md-3 col-sm-3 col-xs-12"'
								);

								// Input tag hidden
								echo form_input(array(
									'type'  => 'hidden',
									'name'  => 'gallery_image_background_color',
									'id'    => 'gallery_image_background_color',
									'value' => $gallery_image_background
								));
							?>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <?php									
									// Color
									$this->color->view($gallery_image_background,'gallery_image_background_color',4);
								?>
                            </div>
                        </div>

                        <div class="form-group" id="component-bg-image" <?php if ($component_background == 'image') :?>
                            style="display:block;" <?php else : ?> style="display:none;" <?php endif;?>>

                            <?php

								if ($component_background == 'color') :
									$gallery_image_background = '';
								endif;

								// label
								echo form_label(
									'Image <span class="required">* Recommended size(1200*500)</span>',
									'imgInp',
									'class="control-label col-md-3 col-sm-3 col-xs-12"'
								);
							?>

                            <div class="img-thumbnail sepH_a" id="show_image1">
                                <?php
									if ($gallery_image_background != '') :

										$gallery_img = $ImageUrl . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR . $gallery_image_background;
										echo img(array(
												'src'   => $gallery_img,
												'id'    => 'image_preview',
												'style' => 'width:168px; height:114px'
										));

									else :

										echo img(array(
											'src'   => $ImageUrl.'images/noimage.png',
											'alt'   => 'No Image',
											'id'    => 'image_preview',
											'style' => 'width:168px; height:114px'
										));

									endif;
								?>
                            </div>

                            <div style="display:none" class="img-thumbnail sepH_a" id="show_image2">
                                <?php
									echo img(array(
										'src'   => $ImageUrl.'images/noimage.png',
										'alt'   => 'No Image',
										'id'    => 'image_preview2',
										'style' => 'width:168px; height:114px'
									));
								?>
                            </div>

                            <?php
								echo form_input(array(
									'type'  => 'hidden',
									'name'  => 'image',
									'id'    => 'image',
									'value' => $gallery_image_background
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

                            <a data-toggle="modal" class="btn btn-primary" data-target="#ImagePopUp" href="javascript:;"
                                type="button">
                                Select Image
                            </a>

                        </div>

                        <!-- FileManager -->
                        <div class="modal fade" id="ImagePopUp">
                            <div class="modal-dialog popup-width">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <?php
											echo form_button(array(
												'name'         => '',
												'type'         => 'button',
												'class'        => 'close',
												'data-dismiss' => 'modal',
												'aria-hidden'  => 'true',
												'content'      => '&times;'
											));
										?>
                                    </div>

                                    <div class="modal-body">
                                        <iframe width="880" height="400"
                                            src="<?php echo $ImageUrl ;?>filemanager/dialog.php?type=1&field_id=image&rootfldr=<?php echo $website_folder_name;?>/"
                                            frameborder="0"
                                            style="overflow: scroll; overflow-x: hidden; overflow-y: scroll; "></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>	
						
					  <div class="ln_solid"></div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="input-button-group">
                                <?php
									// Submit Button
									if (empty($gallery_customize_data)) :
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
					'gallery/delete_multiple_gallery',
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
							'value' => base_url().'gallery/update_sort_order'
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
								'gallery/category/'.$page_id,
								'<i class="fa fa-info-circle" aria-hidden="true"></i> Category',
								array(
									'class' => 'btn btn-info'
								)
							);

							echo anchor(
								'gallery/add_edit_gallery/'.$page_id,
								'<i class="fa fa-plus" aria-hidden="true"></i> Add Gallery',
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