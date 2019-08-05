
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
                                    'reviews_entry/reviews_entry_index/'.$page_id,
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
                        <div class="alert alert-success alert-dismissible fade in text-center" id="success-alert"
                            role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <strong>Success!</strong>
                            <?php echo $this->session->flashdata('success');?>
                        </div>
                        <?php endif; ?>

                        <?php if ($this->session->flashdata('error') != '') : // Display session data ?>
                        <div class="alert alert-warning alert-dismissible fade in text-center" id="warning-alert"
                            role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <strong>
                                <?php echo $this->session->flashdata('error');?>
                            </strong>
                        </div>
                        <?php endif; ?>

                        <?php
							// Break tag
							echo br();

							// Form Tag

							echo form_open(
								'reviews_entry/insert_update_review_entry',
								'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
							);

							// Input tag hidden
							echo form_input(array(
								'type'  => 'hidden',
								'name'  => 'reviews_entry_id',
								'id'    => 'reviews_entry_id',
								'value' => $reviews_entry_id
							));
							// Input tag hidden
							echo form_input(array(
								'type'  => 'hidden',
								'name'  => 'website_id',
								'id'    => 'website_id',
								'value' => $website_id
							));

							// Input tag hidden
							echo form_input(array(
								'type'  => 'hidden',
								'name'  => 'page_id',
								'id'    => 'page_id',
								'value' => $page_id
							));
						?>

                        <!-- Title & Content -->
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">

                                <div class="x_title">
                                    <?php
										echo heading('Reviews Entry', '2');
										$list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
										$attributes = array('class' => 'nav navbar-right panel_toolbox');
										echo ul($list,$attributes);
									?>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="x_content">

                                    <div class="form-group">

                                        <?php
											echo form_label('Name','name');
											echo form_input(array(
														'type'  => 'text',
														'name'  => 'name',
														'id'    => 'name',
														'class'    => 'form-control',
														'value' => $name
													));	
										?>

                                    </div>
									
									<div class="form-group">

                                        <?php
											echo form_label('Email','email');
											echo form_input(array(
														'type'  => 'text',
														'name'  => 'email',
														'id'    => 'email',
														'class'    => 'form-control',
														'value' => $email
													));	
										?>

                                    </div>

                                    <div class="form-group">

                                        <?php
											echo form_label('Rating','rating');
											echo form_input(array(
														'type'  => 'text',
														'name'  => 'rating',
														'id'    => 'rating',
														'class'    => 'form-control',
														'value' => $ratings
													));	
										?>

                                    </div>
									<div class="form-group">

                                        <?php
											echo form_label('Contents','text1');

											// TextArea
											$data = array(
												'name'        => 'content',
												'id'          => 'text',
												'class'    => 'form-control',
												'value'       => $reviews
											);
											echo form_textarea($data);
										?>

                                    </div>
									<div class="form-group">

                                        <?php
											echo form_label('Source','source');

											echo form_input(array(
														'type'  => 'text',
														'name'  => 'source',
														'id'    => 'source',
														'class'    => 'form-control',
														'value' => $source
													));	
										?>

                                    </div>
									<div class="form-group">

                                        <?php
											echo form_label('Source Url','source_url');

											echo form_input(array(
														'type'  => 'text',
														'name'  => 'source_url',
														'id'    => 'source_url',
														'class'    => 'form-control',
														'value' => $source_url
													));	
										?>

                                    </div>
									
									<div class="form-group">

                                        <?php
											echo form_label('Sort Order','sort_order');

											echo form_input(array(
														'type'  => 'text',
														'name'  => 'sort_order',
														'id'    => 'sort_order',
														'class'    => 'form-control',
														'value' => $sort_order
													));	
										?>

                                    </div>
									<div class="form-group">

                                        <?php
											echo form_label('Updated','date_updated');

											echo form_input(array(
														'type'  => 'text',
														'name'  => 'date_updated',
														'id'    => 'date_updated',
														'class'    => 'form-control',
														'value' => $date_updated
													));	
										?>

                                    </div>
									<div class="form-group">

										<?php
											echo form_label(
												'Publish',
												'publish',
												'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);
										?>

										<div class="col-md-6 col-sm-6 col-xs-12">
											<?php
												// Input checkbox
												echo form_checkbox(array(
													'id'      => 'publish',
													'name'    => 'publish',
													'class'   => 'js-switch',
													'checked' => ($publish === '1') ? TRUE : FALSE,
													'value'   => $publish
												));
											?>
										</div>
									</div>
                                </div>
                            </div>
                        </div>
                        <!-- Title & Content -->

                        <!-- Button Group -->
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="input-button-group">
                                <?php
									// Submit Button
									if (empty($reviews_entry_id)) :
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
										'reviews_entry/reviews_entry_index/'.$page_id,
										'Back',
										array(
											'title' => 'Back ',
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
        <!-- /page content -->