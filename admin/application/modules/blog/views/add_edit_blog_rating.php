<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="">

                    <div class="x_title">
                        <?php echo heading($heading, '2');?>

                        <div style="text-align:right;">
                            <?php
                            echo anchor(
                                'blog/add_edit_blog/'.$blog_id,
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
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">×</span>
                            </button>
                            <strong>Success!</strong> <?php echo $this->session->flashdata('success');?>
                        </div>
                        <?php endif; ?>

                        <?php if ($this->session->flashdata('error') != '') : // Display session data ?>
                        <div class="alert alert-warning alert-dismissible fade in text-center" id="warning-alert"
                            role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">×</span>
                            </button>
                            <strong><?php echo $this->session->flashdata('error');?></strong>
                        </div>
                        <?php endif; ?>

                        <?php
              			// Break tag
              			echo br();

              			// Form Tag
              			echo form_open_multipart(
                			'blog/insert_update_blog_rating',
                			'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
              			);
						
						// Input tag hidden
              			echo form_input(array(
                			'type'  => 'hidden',
                			'name'  => 'blog_id',
                			'id'    => 'blog_id',
                			'value' => $blog_id
              			));

              			// Input tag hidden
              			echo form_input(array(
                			'type'  => 'hidden',
                			'name'  => 'blog_rating_id',
                			'id'    => 'blog_rating_id',
                			'value' => $blog_rating_id
              			));

			   			// Input tag hidden
             			echo form_input(array(
                			'type'  => 'hidden',
                			'name'  => 'website_id',
                			'id'    => 'website_id',
                			'value' => $website_id
              			));
            			?>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_content">

                                    <div class="form-group">

                                        <?php
                                      	echo form_label('Name', 'name', 'class="control-label col-md-3 col-sm-3 col-xs-12"');
                                      	?>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <?php
                                          	// Input tag
                                          	echo form_input(array(
                                            	'id'       => 'name',
                                            	'name'     => 'name',
                                            	'class'    => 'form-control col-md-7 col-xs-12',
                                            	'value'    => $name
                                          	));
                                        	?>
                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <?php
                                      	echo form_label('Email', 'email', 'class="control-label col-md-3 col-sm-3 col-xs-12"');
                                      	?>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <?php
                                          	// Input tag
                                          	echo form_input(array(
                                            	'id'       => 'email',
                                            	'name'     => 'email',
                                            	'class'    => 'form-control col-md-7 col-xs-12',
                                            	'value'    => $email
                                          	));
                                        	?>
                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <?php
                                        echo form_label('Comment', 'text', 'class="control-label col-md-3 col-sm-3 col-xs-12"');
										?>

                                        <div class="col-md-6 col-sm-6 col-xs-12">

                                            <?php
                                            // TextArea
                                            $data = array(
                                                'name'	=> 'comment',
                                                'id'	=> 'text',
												'class'	=> 'form-control col-md-7 col-xs-12',
                                                'value'	=> $comment
                                            );
                                            echo form_textarea($data);
                                        	?>

                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <?php
                                      	echo form_label('Sort Order', 'sort_order', 'class="control-label col-md-3 col-sm-3 col-xs-12"');
                                      	?>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <?php
                                          	// Input tag
                                          	echo form_input(array(
                                            	'id'       => 'sort_order',
                                            	'name'     => 'sort_order',
                                            	'class'    => 'form-control col-md-7 col-xs-12',
                                            	'value'    => $sort_order
                                          	));
                                        	?>
                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <?php
                                      	echo form_label('Comment Date', 'created_at', 'class="control-label col-md-3 col-sm-3 col-xs-12"');
                                      	?>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <?php
											$date = DateTime::createFromFormat('m-d-Y', $created_at);
									
                                          	// Input tag
                                          	echo form_input(array(
                                            	'id'       => 'created_at',
                                            	'name'     => 'date',
                                            	'class'    => 'form-control col-md-7 col-xs-12',
                                            	'value'    => date("F d, Y", strtotime($date->format('d-m-Y')))
                                          	));
                                        	?>
                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <?php
                                        echo form_label(
                                            'Rating',
                                            'rating',
                                            'class="control-label col-md-3 col-sm-3 col-xs-12"'
                                        );
                                        ?>

                                        <div class="col-md-6 col-sm-6 col-xs-12">

                                            <?php
											if(is_numeric($rating)):
											
												echo form_fieldset('', 'class="rating"');
											
												// Star 5
												echo form_radio(array(
														'id' => 'star5',
														'name' => 'rating',
														'value' => 5,
														'checked' => ($rating == 5) ? TRUE: FALSE
												));
												
												// Star 5 Label
												echo form_label(
													'',
													'star5',
													array(
														'class' => 'full',
														'title' => 'Awesome - 5 stars'
													)
												);
												
												// Star 4 Half
												echo form_radio(array(
														'id' => 'star4half',
														'name' => 'rating',
														'value' => 4.5,
														'checked' => ($rating == 4.5) ? TRUE: FALSE
												));
												
												// Star 4 Half Label
												echo form_label(
													'',
													'star4half',
													array(
														'class' => 'half',
														'title' => 'Pretty good - 4.5 stars'
													)
												);
												
												// Star 4
												echo form_radio(array(
														'id' => 'star4',
														'name' => 'rating',
														'value' => 4,
														'checked' => ($rating == 4) ? TRUE: FALSE
												));
												
												// Star 4 Label
												echo form_label(
													'',
													'star4',
													array(
														'class' => 'full',
														'title' => 'Pretty good - 4 stars'
													)
												);
												
												// Star 3 Half
												echo form_radio(array(
														'id' => 'star3half',
														'name' => 'rating',
														'value' => 3.5,
														'checked' => ($rating == 3.5) ? TRUE: FALSE
												));
												
												// Star 3 Half Label
												echo form_label(
													'',
													'star3half',
													array(
														'class' => 'half',
														'title' => 'Meh - 3.5 stars'
													)
												);
												
												// Star 3
												echo form_radio(array(
														'id' => 'star3',
														'name' => 'rating',
														'value' => 3,
														'checked' => ($rating == 3) ? TRUE: FALSE
												));
												
												// Star 3 Label
												echo form_label(
													'',
													'star3',
													array(
														'class' => 'full',
														'title' => 'Meh - 3 stars'
													)
												);
												
												// Star 2 Half
												echo form_radio(array(
														'id' => 'star2half',
														'name' => 'rating',
														'value' => 2.5,
														'checked' => ($rating == 2.5) ? TRUE: FALSE
												));
												
												// Star 2 Half Label
												echo form_label(
													'',
													'star2half',
													array(
														'class' => 'half',
														'title' => 'Kinda bad - 2.5 stars'
													)
												);
												
												// Star 2
												echo form_radio(array(
														'id' => 'star2',
														'name' => 'rating',
														'value' => 2,
														'checked' => ($rating == 2) ? TRUE: FALSE
												));
												
												// Star 2 Label
												echo form_label(
													'',
													'star2',
													array(
														'class' => 'full',
														'title' => 'Kinda bad - 2 stars'
													)
												);
												
												// Star 1 Half
												echo form_radio(array(
														'id' => 'star1half',
														'name' => 'rating',
														'value' => 1.5,
														'checked' => ($rating == 1.5) ? TRUE: FALSE
												));
												
												// Star 1 Half Label
												echo form_label(
													'',
													'star1half',
													array(
														'class' => 'half',
														'title' => 'Meh - 1.5 stars'
													)
												);
												
												// Star 1
												echo form_radio(array(
														'id' => 'star1',
														'name' => 'rating',
														'value' => 1,
														'checked' => ($rating == 1) ? TRUE: FALSE
												));
												
												// Star 1 Label
												echo form_label(
													'',
													'star1',
													array(
														'class' => 'full',
														'title' => 'Sucks big time - 1 star'
													)
												);
												
												// Star Half
												echo form_radio(array(
														'id' => 'starhalf',
														'name' => 'rating',
														'value' => 0.5,
														'checked' => ($rating == 0.5) ? TRUE: FALSE
												));
												
												// Star Half Label
												echo form_label(
													'',
													'starhalf',
													array(
														'class' => 'half',
														'title' => 'Sucks big time - 0.5 stars'
													)
												);
												
												echo form_fieldset_close();
												
											else:
											
												echo '<span>'.$rating.'</span>';
											
											endif;
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
                    			if (empty($blog_rating_id)) :
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
                      				'blog/add_edit_blog/'.$blog_id,
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