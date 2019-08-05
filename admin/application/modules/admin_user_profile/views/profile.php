<!-- page content -->

<div class="right_col" role="main">
  <div class="">
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <?php
				/* Heading */
				echo heading($heading, '2');
			?>
            <div class="clearfix"></div>
            <?php if ($this->session->flashdata('success')!='') : // Display session data ?>
            <div class="alert alert-success alert-dismissible fade in text-center" id="success-alert" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">× </span> </button>
              <strong>Success! </strong> <?php echo $this->session->flashdata('success');?> </div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('error') != '') : // Display session data ?>
            <div class="alert alert-warning alert-dismissible fade in text-center" id="warning-alert" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">× </span> </button>
              <strong> <?php echo $this->session->flashdata('error');?> </strong> </div>
            <?php endif; ?>
          </div>
          <div class="x_content">
            <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
              <div class="profile_img">
                <div id="crop-avatar">
                  <!-- Current avatar -->
                  <?php
										echo img(array(
										'src' => $profile_pic,
										'class' => 'img-responsive avatar-view',
										'alt' => $adminUserName,
										'title' => $adminUserName
										));
									?>
                </div>
              </div>
              <?php echo heading($adminUserName, '3');?>
              <ul class="list-unstyled user_data">
                <li> <i class="fa fa-users user-profile-icon"> </i> <?php echo $role_name;?> </li>
                <li> <i class="fa fa-envelope user-profile-icon"> </i> <a href="mailto:<?php echo $email;?>"> <?php echo $email;?> </a> </li>
                <?php if ($id != 1) :?>
                <li class="m-top-xs"> <i class="fa fa-external-link user-profile-icon"> </i> Website
                  <?php
										echo br();
										$i = 1;

										foreach ($website_ids as $website_id) {
											$website_data = $this->Admin_user_profile_model->get_website_by_id($website_id);
											if(!empty($website_data)) :
												foreach($website_data as $web_data) :
													echo $i;
													echo ' <a href="' . $web_data->website_url . '" target="_blank">' . $web_data->website_name . '</a>';
													echo br();
													$i++;
												endforeach;
											endif;
										}
				  				?>
                </li>
                <?php endif;?>
              </ul>
              <br />
            </div>
            <div class="col-md-9 col-sm-9 col-xs-12">
              <div class="" role="tabpanel" data-example-id="togglable-tabs">
                <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                  <li role="presentation" class="active"> <a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true"> Edit Profile </a> </li>
                  <li role="presentation" class=""> <a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"> Recent Activity </a> </li>
                  <li role="presentation" class=""> <a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Worked on </a> </li>
                </ul>
                <div id="myTabContent" class="tab-content">
                  <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                    <?php
											// Break tag
											echo br();

											// Form Tag
											echo form_open_multipart(
												'admin_user_profile/insert_update_user',
												'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
											);

											// Input tag hidden
											echo form_input(array(
												'type'  => 'hidden',
												'name'  => 'id',
												'id'    => 'id',
												'value' => $id
											));
										?>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> First Name <span class="required">* </span> </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php
													// Input tag
													echo form_input(array(
														'id'       => 'first-name',
														'name'     => 'first-name',
														'required' => 'required',
														'class'    => 'form-control col-md-7 col-xs-12',
														'value'    => $firstName
													));
												?>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"> Last Name <span class="required">* </span> </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php
													// Input
													echo form_input(array(
														'id'       => 'last-name',
														'name'     => 'last-name',
														'required' => 'required',
														'class'    => 'form-control col-md-7 col-xs-12',
														'value'    => $lastName
													));
												?>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="user-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Username <span class="required">* </span> </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php
													// Input
													echo form_input(array(
														'id'       => 'user-name',
														'name'     => 'user-name',
														'required' => 'required',
														'class'    => 'form-control col-md-7 col-xs-12',
														'value'    => $username
													));
												?>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="password" class="control-label col-md-3 col-sm-3 col-xs-12"> Password <span class="required">* </span> </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php
													// Password
													echo form_password(array(
														'id'       => 'password',
														'name'     => 'password',
														'required' => 'required',
														'class'    => 'form-control col-md-7 col-xs-12',
														'value'    => $password
													));

													// Input tag hidden
													echo form_input(array(
														'type'  => 'hidden',
														'name'  => 'password-hidden',
														'id'    => 'password-hidden',
														'value' => $password
													));
												?>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="email" class="control-label col-md-3 col-sm-3 col-xs-12"> Email <span class="required">* </span> </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php
													// Input
													echo form_input(array(
														'type'     => 'email',
														'id'       => 'email',
														'name'     => 'email',
														'required' => 'required',
														'class'    => 'form-control col-md-7 col-xs-12',
														'value'    => $email
													));
												?>
                      </div>
                    </div>
                    <div class="form-group">
                      <?php
												// label
												echo form_label(
													'Gender',
													'gender',
													'class="control-label col-md-3 col-sm-3 col-xs-12"'
												);
											?>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <label> Male
                          <?php
														// Radio
														echo form_radio(array(
															'name'    => 'gender',
															'value'   => 'Male',
															'checked' => ('Male' == $gender) ? TRUE : FALSE,
															'class'   => 'flat'
														));
													?>
                        </label>
                        <label>Female
                          <?php
														// Radio
														echo form_radio(array(
															'name'    => 'gender',
															'value'   => 'Female',
															'checked' => ('Female' == $gender) ? TRUE : FALSE,
															'class'   => 'flat'
														));
													?>
                        </label>
                      </div>
                    </div>

                    <div class="form-group">
                      <?php
												// label
												echo form_label(
													'User Image',
													'imgInp',
													'class="control-label col-md-3 col-sm-3 col-xs-12"'
												);
											?>

											<div class="col-md-6 col-sm-6 col-xs-12 profile-container" <?php echo (!empty($user_image)) ? 'style="display: none"'  : ''; ?>>

												<div class="input-group input-file" name="profile"  >

													<span class="input-group-btn">
															<?php
																	// Choose Button
																	echo form_button(
																			array(
																					'type' => 'button',
																					'class' => 'btn btn-default btn-choose',
																					'content' => 'Upload'
																			)
																	);
															?>
													</span>

													<?php
															// Input Tag
															echo form_input(
																	array(
																			'id' => 'profile',
																			'class' => 'form-control',
																			'placeholder' => 'Upload Profile Image'
																	)
															);
													?>

													<span class="input-group-btn">
															<?php
																	echo form_button(
																			array(
																					'type' => 'button',
																					'class' => 'btn btn-warning btn-reset',
																					'content' => 'Reset'
																			)
																	);
															?>
													</span>

												</div>

											</div>

											<?php if ($user_image != '') : ?>
												<div class="img-thumbnail sepH_a" id="show_image1">
													<?php
															echo img(array(
																'src'   => $ImageUrl.$user_image,
																'alt'   => $firstName,
																'title' => $firstName,
																'id'    => 'image_preview_fav',
																'style' => 'width:170px; height:120px'
															));

															echo form_input(array(
																'type'  => 'hidden',
																'name'  => 'profile',
																'id'    => 'profile-img',
																'value' => $user_image
															));
													?>
												</div>

												<?php 
														echo form_button(
															array(
																	'id' => 'change-profile-img',
																	'class' => 'btn btn-primary',
																	'content' => 'Change Profile Image'
															)
														);                 
												?>
											<?php  endif;?> 

                    </div>  

                    <div class="form-group">
                      <?php
												// Label
												echo form_label(
													'User Role',
													'user-role',
													'class="control-label col-md-3 col-sm-3 col-xs-12"'
												);
											?>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php
													$userRoleOptions[''] = 'Please Select';
													foreach ($user_role_options as $user_role) :
														$userRoleOptions[$user_role->user_role_id] = $user_role->user_role_name;
													endforeach;

													$user_role_attributes = array(
														'id'       => 'user-role',
														'name'     => 'user-role',
														'required' => 'required',
														'class'    => 'form-control col-md-7 col-xs-12'
													);

													// Dropdown
													echo form_dropdown(
														$user_role_attributes,
														$userRoleOptions,
														$user_role_id
													);
												?>
                      </div>
                    </div>
                    <div class="form-group">
                      <?php
												// Label
												echo form_label(
													'Websites',
													'websites',
													'class="control-label col-md-3 col-sm-3 col-xs-12"'
												);
											?>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php
													$websiteOptions = array();
													foreach ($website_options as $website) :
														$websiteOptions[$website->id] =  $website->website_name;
													endforeach;

													$selected = $website_ids;

													$website_attributes = array(
														'id'       => 'websites',
														'name'     => 'websites[]',
														'required' => 'required',
														'class'    => 'form-control col-md-7 col-xs-12 multiselect'
													);

													// Dropdown Multiselect
													echo form_multiselect(
														$website_attributes,
														$websiteOptions,
														$selected
													);
												?>
                      </div>
                    </div>
                    <div class="ln_solid"> </div>
                    <!-- Button Group -->
                    <div class="form-group">
                      <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
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
												?>
                      </div>
                    </div>

                    <?php echo form_close(); //Form close ?> </div>

                  <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">

                    <!-- User Activity -->

                    <?php echo $table;?>

                    <!--<table class="data table table-striped no-margin">
                      <thead>
                        <tr>
                          <th>S.No</th>
                          <th>Last login at</th>
                          <th>Ip Address</th>
                          <?php if ($id != 1 ) :?>
                          <th>Website</th>
                          <?php endif;?>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
							if (!empty($user_recent_activities)) {
								$j = 1;
								foreach ($user_recent_activities as $user_recent_activity) {
									echo '<tr>
										<td>'.$j.'</td>
										<td>'.$user_recent_activity->login_at.'</td>
										<td>'.$user_recent_activity->ip_address.'</td>';
										if ($id != 1) :
											echo '<td>'.$user_recent_activity->website_name.'</td>';
										endif;
									echo '</tr>';

									$j++;
								}
							}
						?>
                      </tbody>
                    </table>-->

                    <!-- end User Activity -->

                  </div>

                  <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
                    <!-- start recent activity -->
                    <!-- <ul class="messages">
                      <li> <img src="images/img.jpg" class="avatar" alt="Avatar">
                        <div class="message_date">
                          <h3 class="date text-info">24 </h3>
                          <p class="month">May </p>
                        </div>
                        <div class="message_wrapper">
                          <h4 class="heading">Desmond Davison </h4>
                          <blockquote class="message">Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua butcher retro keffiyeh dreamcatcher synth. </blockquote>
                          <br />
                          <p class="url"> <span class="fs1 text-info" aria-hidden="true" data-icon=""> </span> <a href="#"> <i class="fa fa-paperclip"> </i> User Acceptance Test.doc </a> </p>
                        </div>
                      </li>
                      <li> <img src="images/img.jpg" class="avatar" alt="Avatar">
                        <div class="message_date">
                          <h3 class="date text-error">21 </h3>
                          <p class="month">May </p>
                        </div>
                        <div class="message_wrapper">
                          <h4 class="heading">Brian Michaels </h4>
                          <blockquote class="message">Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua butcher retro keffiyeh dreamcatcher synth. </blockquote>
                          <br />
                          <p class="url"> <span class="fs1" aria-hidden="true" data-icon=""> </span> <a href="#" data-original-title="">Download </a> </p>
                        </div>
                      </li>
                      <li> <img src="images/img.jpg" class="avatar" alt="Avatar">
                        <div class="message_date">
                          <h3 class="date text-info">24 </h3>
                          <p class="month">May </p>
                        </div>
                        <div class="message_wrapper">
                          <h4 class="heading">Desmond Davison </h4>
                          <blockquote class="message">Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua butcher retro keffiyeh dreamcatcher synth. </blockquote>
                          <br />
                          <p class="url"> <span class="fs1 text-info" aria-hidden="true" data-icon=""> </span> <a href="#"> <i class="fa fa-paperclip"> </i> User Acceptance Test.doc </a> </p>
                        </div>
                      </li>
                      <li> <img src="images/img.jpg" class="avatar" alt="Avatar">
                        <div class="message_date">
                          <h3 class="date text-error">21 </h3>
                          <p class="month">May </p>
                        </div>
                        <div class="message_wrapper">
                          <h4 class="heading">Brian Michaels </h4>
                          <blockquote class="message">Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua butcher retro keffiyeh dreamcatcher synth. </blockquote>
                          <br />
                          <p class="url"> <span class="fs1" aria-hidden="true" data-icon=""> </span> <a href="#" data-original-title="">Download </a> </p>
                        </div>
                      </li>
                    </ul> -->
                    <!-- end recent activity -->
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
</div>
<!-- /page content -->
