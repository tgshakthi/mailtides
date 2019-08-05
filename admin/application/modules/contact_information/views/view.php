<?php
	/**
	 * Top header Contact info view
	 *
	 * @category View
	 * @package contact information view
	 * @author   Velu
	 * Created at:  21-Sep-18
	 */
 ?>
<!-- page content -->
<div class="right_col" role="main">
	<div class="">
		<div class="clearfix"></div>

		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="">

					<div class="x_title">
						<?php echo heading($heading, '2');?>
						<div class="clearfix"></div>
					</div>

					<div class="x_content">

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

						<?php
              // Break tag
              echo br();

           // Form Tag
				echo form_open_multipart(
					'contact_information/insert_update_contact_info',
					'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
					);
				echo form_input(array(
					'type'  => 'hidden',
					'name'  => 'contact_id',
					'id'    => 'contact_id',
					'value' => $id
				  ));
				echo form_input(array(
					'type'  => 'hidden',
					'name'  => 'website_id',
					'id'    => 'website_id',
					'value' => $website_id
				  ));
            ?>
						<!-- Title & Content -->
						<div class="col-md-6 col-sm-12 col-xs-12">
							<div class="x_panel">

								<div class="x_title">
									<?php
										echo heading('Contact Information', '2');
										$list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
										$attributes = array('class' => 'nav navbar-right panel_toolbox');
										echo ul($list,$attributes);
									?>
									<div class="clearfix"></div>
								</div>

								<div class="x_content">
                                
                                	<div class="form-group">
										<?php
											echo form_label(
												'Title',
												'title',
												'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);
											?>

										<div class="col-md-9 col-sm-9 col-xs-12">
											<?php
											   // Input tag
												echo form_input(array(
													'id'       => 'title',
													'name'     => 'title',
													'class'    => 'form-control',
													'value'    => $info_title
												));
											?>
										</div>
									</div>
									<div class="form-group">
										<?php
											echo form_label(
												'Phone No',
												'phone_no',
												'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);
											?>

										<div class="col-md-9 col-sm-9 col-xs-12">
											<?php
											   // Input tag
												echo form_input(array(
													'id'       => 'phone_no',
													'name'     => 'phone_no',
													'class'    => 'form-control',
													'value'    => $phone_no
												));
											?>
										</div>
									</div>
									<div class="form-group">
										<?php
											echo form_label(
												'Email',
												'email',
												'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);
										?>

										<div class="col-md-9 col-sm-9 col-xs-12">
											<?php
											   // Input tag
												echo form_input(array(
													'id'       => 'email',
													'name'     => 'email',
													'class'    => 'form-control',
													'value'    => $email
												));
											?>
										 </div>
									</div>
									<div class="form-group">
										<?php
											echo form_label(
												'Address',
												'address',
												'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);
											?>

										<div class="col-md-9 col-sm-9 col-xs-12">
											<?php
												// Input tag
												$data = array(
													'name'        => 'address',
													'id'          => 'address',
													'value'       => $address,
													'class' => 'form-control'
												);
												echo form_textarea($data);
											?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- Title & Content -->
						<!-- Customize Title & Content -->
						<div class="col-md-6 col-sm-12 col-xs-12">
							<div class="x_panel">
								
                                <div class="x_title">
									<?php
										echo heading('Customize Title', '2');
										$list = array(
											'<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>'
										);
										$attributes = array('class' => 'nav navbar-right panel_toolbox');
										echo ul($list,$attributes);
									?>
									<div class="clearfix"></div>
								</div>
                                
                                <div class="x_content">
									
                                    <div class="form-group">
										<?php
											echo form_label(
												'Title Color',
												'title_color',
												'class="control-label col-md-3 col-sm-3 col-xs-12"'
												);
										?>
										<div class="col-md-9 col-sm-9 col-xs-12">
											<?php
												// Input tag hidden
												echo form_input(array(
													'type'  => 'hidden',
													'name'  => 'title_color',
													'id'    => 'title_color',
													'value' => $title_color
													));
												// Input tag
												$this->color->view($title_color, 'title_color', 1);
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
                                                'right-align'	 => 'Right',
                                                'center-align' => 'Center'
                                          	);

                                            $attributes = array(
                                            	'name' => 'title_position',
                                                'id' => 'title_position',
                                                'class' => 'form-control col-md-7 col-xs-12'
                                            );

                                            echo form_dropdown($attributes, $options, $title_position);
                                            ?>
                                        </div>

                                    </div>

							</div>
                                
								<div class="x_title">
									<?php
										echo heading('Customize Phone No', '2');
										$list = array(
											'<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>'
										);
										$attributes = array('class' => 'nav navbar-right panel_toolbox');
										echo ul($list,$attributes);
									?>
									<div class="clearfix"></div>
								</div>

								<div class="x_content">
									
									<div class="form-group">
										<?php
											echo form_label(
												'Phone No Title Color',
												'phone_no_title_color',
												'class="control-label col-md-3 col-sm-3 col-xs-12"'
												);
										?>
										<div class="col-md-9 col-sm-9 col-xs-12">
											<?php
												// Input tag hidden
												echo form_input(array(
													'type'  => 'hidden',
													'name'  => 'phone_no_title_color',
													'id'    => 'phone_no_title_color',
													'value' => $phone_no_title_color
													));
												// Input tag
												$this->color->view($phone_no_title_color, 'phone_no_title_color', 2);
											?>
										</div>
								</div>
								<div class="form-group">
										<?php
											echo form_label(
												'Phone Title Hover Color',
												'phone_title_hover_color',
												'class="control-label col-md-3 col-sm-3 col-xs-12"'
												);
										?>
										<div class="col-md-9 col-sm-9 col-xs-12">
											<?php
												// Input tag hidden
												echo form_input(array(
													'type'  => 'hidden',
													'name'  => 'phone_title_hover_color',
													'id'    => 'phone_title_hover_color',
													'value' => $phone_title_hover_color
													));
												// Input tag
												$this->color->view($phone_title_hover_color, 'phone_title_hover_color', 3);
											?>
										</div>
								</div>

								<div class="form-group">
									<?php
										echo form_label(
											'Phone Icon',
											'phone_icon',
											'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);
                                       ?>
									<div class="col-md-9 col-sm-9 col-xs-12">

										<?php
										 // Input
											echo form_input(array(
												'id'                => 'phone_icon',
												'name'              => 'phone_icon',
												'class'             => 'form-control col-md-7 col-xs-12 icp icp-auto',
												'data-input-search' => 'true',
												'value'             => $phone_icon
											));

											echo br('2');
											echo '<p class="lead"><i class="fa '.$phone_icon.' fa-3x picker-target"></i></p>';
										?>
									</div>
                                </div>
								<div class="form-group">
									<?php
										echo form_label(
											'Phone Icon Color',
											'phone_icon_color',
											'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);
									?>
									<div class="col-md-9 col-sm-9 col-xs-12">
										<?php
											// Input tag hidden
											echo form_input(array(
												'type'  => 'hidden',
												'name'  => 'phone_icon_color',
												'id'    => 'phone_icon_color',
												'value' => $phone_icon_color
												));
											// Input tag
											$this->color->view($phone_icon_color, 'phone_icon_color', 4);
										?>
									</div>
								</div>

								<div class="form-group">
									<?php
										echo form_label(
											'Phone Icon Hover Color',
											'phone_icon_hover_color',
											'class="control-label col-md-3 col-sm-3 col-xs-12"'
										);
									?>
									<div class="col-md-9 col-sm-9 col-xs-12">
										<?php
											// Input tag hidden
											echo form_input(array(
												'type'  => 'hidden',
												'name'  => 'phone_icon_hover_color',
												'id'    => 'phone_icon_hover_color',
												'value' => $phone_icon_hover_color
											));
											// Color
											$this->color->view($phone_icon_hover_color,'phone_icon_hover_color',5);
										?>
									</div>
								</div>
							</div>
                            
								<div class="x_title">
									<?php
										echo heading('Customize Email', '2');
									?>
									<div class="clearfix"></div>
								</div>

								<div class="x_content">

								<div class="form-group">
									<?php
										echo form_label(
											'Email Title Color',
											'email_title_color',
											'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);
									?>
									<div class="col-md-9 col-sm-9 col-xs-12">
										<?php
											// Input tag hidden
											echo form_input(array(
												'type'  => 'hidden',
												'name'  => 'email_title_color',
												'id'    => 'email_title_color',
												'value' => $email_title_color
												));
											// Input tag
											$this->color->view($email_title_color, 'email_title_color', 6);
										?>
									</div>
								</div>
								<div class="form-group">
									<?php
										echo form_label(
											'Email Title Hover Color',
											'email_title_hover_color',
											'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);
									?>
									<div class="col-md-9 col-sm-9 col-xs-12">
										<?php
											// Input tag hidden
											echo form_input(array(
												'type'  => 'hidden',
												'name'  => 'email_title_hover_color',
												'id'    => 'email_title_hover_color',
												'value' => $email_title_hover_color
												));
											// Input tag
											$this->color->view($email_title_hover_color, 'email_title_hover_color', 7);
										?>
									</div>
								</div>

								<div class="form-group">
									<?php
										echo form_label(
											'Email Icon',
											'email_icon',
											'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);
                                    ?>
									<div class="col-md-9 col-sm-9 col-xs-12">
										<?php
											 // Input tag
											echo form_input(array(
												'id'                => 'email_icon',
												'name'              => 'email_icon',
												'class'             => 'form-control col-md-7 col-xs-12 icp1 icp-auto',
												'data-input-search' => 'true',
												'value'             => $email_icon
											));

											echo br('1');

											echo '<p class="lead1"><i class="fa '.$email_icon.' fa-3x picker-target"></i></p>';
										?>
									</div>
                                </div>
								<div class="form-group">
									<?php
										echo form_label(
											'Email Icon Color',
											'email_icon_color',
											'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);
									?>
									<div class="col-md-9 col-sm-9 col-xs-12">
										<?php
											// Input tag hidden
											echo form_input(array(
												'type'  => 'hidden',
												'name'  => 'email_icon_color',
												'id'    => 'email_icon_color',
												'value' => $email_icon_color
												));
												// Input tag
												$this->color->view($email_icon_color, 'email_icon_color', 8);
										?>
									</div>
								</div>

								<div class="form-group">
									<?php
										echo form_label(
											'Email Icon Hover Color',
											'email_icon_hover_color',
											'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);
									?>
									<div class="col-md-9 col-sm-9 col-xs-12">
										<?php
											// Input tag hidden
											echo form_input(array(
												'type'  => 'hidden',
												'name'  => 'email_icon_hover_color',
												'id'    => 'email_icon_hover_color',
												'value' => $email_icon_hover_color
												));
										// Input tag
											$this->color->view($email_icon_hover_color, 'email_icon_hover_color',9);
										?>
									</div>
								</div>
							</div>
								<div class="x_title">
									<?php
										echo heading('Customize Address', '2');
									?>
									<div class="clearfix"></div>
								</div>

								<div class="x_content">
								<div class="form-group">
									<?php
										echo form_label(
											'Address Title Color',
											'address_title_color',
											'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);
									?>
									<div class="col-md-9 col-sm-9 col-xs-12">
										<?php
											// Input tag hidden
											echo form_input(array(
												'type'  => 'hidden',
												'name'  => 'address_title_color',
												'id'    => 'address_title_color',
												'value' => $address_title_color
												));
											// Input tag
											$this->color->view($address_title_color, 'address_title_color', 10);
										?>
									</div>
								</div>
								<div class="form-group">
									<?php
										echo form_label(
											'Address Title Hover Color',
											'address_title_hover_color',
											'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);
									?>
									<div class="col-md-9 col-sm-9 col-xs-12">
										<?php
											// Input tag hidden
											echo form_input(array(
												'type'  => 'hidden',
												'name'  => 'address_title_hover_color',
												'id'    => 'address_title_hover_color',
												'value' => $address_title_hover_color
												));
											// Input tag
											$this->color->view($address_title_hover_color, 'address_title_hover_color', 11);
										?>
									</div>
								</div>
								<div class="form-group">
									<?php
										echo form_label(
											'Address Icon',
											'address_icon',
											'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);
                                   ?>
									<div class="col-md-9 col-sm-9 col-xs-12">

										<?php
											// Input
											echo form_input(array(
												'id'                => 'address_icon',
												'name'              => 'address_icon',
												'class'             => 'form-control col-md-7 col-xs-12 icp2 icp-auto',
												'data-input-search' => 'true',
												'value'             => $address_icon
												));

											echo br('1');

											echo '<p class="lead2"><i class="fa '.$address_icon.' fa-3x picker-target"></i></p>';
										?>
									</div>
                               </div>
								<div class="form-group">
									<?php
										echo form_label(
											'Address Icon Color',
											'address_icon_color',
											'class="control-label col-md-3 col-sm-3 col-xs-12"'
												);
									?>
									<div class="col-md-9 col-sm-9 col-xs-12">
											<?php
												// Input tag hidden
												echo form_input(array(
														'type'  => 'hidden',
														'name'  => 'address_icon_color',
														'id'    => 'address_icon_color',
														'value' => $address_icon_color
														));
												// Input tag
													$this->color->view($address_icon_color, 'address_icon_color', 12);
											?>
										</div>
									</div>
									<div class="form-group">
										<?php
											echo form_label(
													'Address Icon Hover Color',
													'address_icon_hover_color',
													'class="control-label col-md-3 col-sm-3 col-xs-12"'
												);
											?>
										<div class="col-md-9 col-sm-9 col-xs-12">
											<?php
												// Input tag hidden
												echo form_input(array(
														'type'  => 'hidden',
														'name'  => 'address_icon_hover_color',
														'id'    => 'address_icon_hover_color',
														'value' => $address_icon_hover_color
														));
												// Input tag
													$this->color->view($address_icon_hover_color, 'address_icon_hover_color',13);
											?>
										</div>
									</div>
								</div>
							</div>
						</div>
					<!-- Customize Title & Content -->
					<!-- Status -->
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="x_panel">

								<div class="x_title">
									<?php
										echo heading('Status', '2');
										$list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
										$attributes = array('class' => 'nav navbar-right panel_toolbox');
										echo ul($list,$attributes);
									?>
									<div class="clearfix"></div>
								</div>

								<div class="x_content">
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
									'id'    => 'btn',
									'value' => $submit_value
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
