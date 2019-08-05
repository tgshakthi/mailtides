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
                                'contact_us',
                                'Back',
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
                			'contact_us/update_contact_us',
                			'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
              			);

						// Input tag hidden
						 echo form_input(array(
						   'type'  => 'hidden',
						   'name'  => 'id',
						   'id'    => 'id',
						   'value' => $id
						 ));

						// Input tag Website ID
						echo form_input(array(
						  'type'  => 'hidden',
						  'name'  => 'website_id',
						  'id'    => 'website_id',
						  'value' => $website_id
						));
            			?>

            			<div class="col-md-12 col-sm-12 col-xs-12">
              				<div class="x_panel">
                				<div class="x_title">

                  					<?php
					  				echo heading('Form', '2');
					  				$list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
					  				$attributes = array('class' => 'nav navbar-right panel_toolbox');
					  				echo ul($list,$attributes);
				  					?>

                  					<div class="clearfix"></div>
                				</div>

                				<div class="x_content">

                                    <?php
									if(!empty($single_contact_us) && !empty($contact_form_label_names))
									
										$form_values = json_decode($single_contact_us[0]->value);

										 $data = '';
										 $tbl_fields = $this->db->field_data('contact_us_form');
										 $out = array(' ');
										 $in = array('_');
										 foreach($contact_form_label_names as $key => $val) {

											 $value = $form_values[$key];

											 $is_required = ($contact_form_requireds[$key] == 1) ? '<span class="required">*</span>': '';
											 $required_array = array('required' => 'required');
											 $required = ($contact_form_requireds[$key] == 1) ? 'required => required': '';
											 $label_name = str_replace($out, $in, $contact_form_label_names[$key]);

											 //From Label
											 $label = form_label(
												 $contact_form_label_names[$key].' '.$is_required,
												 $label_name,
												 'class="control-label col-md-3 col-sm-3 col-xs-12"'
											 );
											$hidden_field = (!in_array($contact_form_label_names[$key], $contact_form_enable_label_names)) ? 'hide': '';
											 $data .= '<div class="form-group '.$hidden_field.'">'
														 .$label.
														 '<div class="col-md-6 col-sm-6 col-xs-12">';

											 if($contact_form_choose_fields[$key] == 'textbox') {

												 $textbox_array = array(
													 'id'       => $label_name,
													 'name'     => $label_name,
													 'class'    => 'form-control',
													 'value'    => $value
												 );
												 $textbox = ($contact_form_requireds[$key] == 1 && in_array($contact_form_label_names[$key], $contact_form_enable_label_names)) ? array_merge($textbox_array, $required_array): $textbox_array;

												 //Input tag
												 $data .= form_input($textbox);

											 } elseif($contact_form_choose_fields[$key] == 'textarea') {

												 $textarea_array = array(
													 'name'        => $label_name,
													 'id'          => $label_name,
													 'value'       => $value,
													 'class'       => 'form-control'
												 );
												 $textarea = ($contact_form_requireds[$key] == 1 && in_array($contact_form_label_names[$key], $contact_form_enable_label_names)) ? array_merge($textarea_array, $required_array): $textarea_array;

												 //Text Area
												 $data .= form_textarea($textarea);

											 } 
											 /*elseif($contact_fields[$field_key] == 'dropdown') {

												 $options = ($contact_form_field->field_attributes != '') ? explode(',', $contact_form_field->field_attributes): array();
												 $dropdownoptions = array('' => 'select');
												 if(!empty($options)) {

													 foreach($options as $option) {

														 $option_value = strtolower(str_replace($out, $in, $option));
														 $dropdownoptions[$option_value] = $option;
													 }
												 }

												 $dropdown_array = array(
													 'name' => $label_name,
													 'id' => $label_name,
													 'required' => $required,
													 'class' => 'form-control col-md-7 col-xs-12'
												 );
												 $dropdown= ($contact_requireds[$field_key] == 1) ? array_merge($dropdown_array, $required_array): $dropdown_array;

												 //Dropdown
												 $data .= form_dropdown($dropdown, $dropdownoptions, $value);

											 } elseif($contact_fields[$field_key] == 'checkbox') {

												 $options = ($contact_form_field->field_attributes != '') ? explode(',', $contact_form_field->field_attributes): array();
												 if(!empty($options)) {

													 $checkvalue = explode(",",$value);
													 foreach($options as $option) {

														 $checkbox_array = array(
															 'name'          => $label_name.'[]',
															 'id'            => strtolower(str_replace($out, $in, $option)),
															 'class'         => 'flat',
															 'value'         => $option,
															 'checked'       => (in_array($option, $checkvalue)) ? TRUE: FALSE,
														 );
														 $checkbox = ($contact_requireds[$field_key] == 1) ? array_merge($checkbox_array, $required_array): $checkbox_array;

														 //Checkbox Label
														 $checkboxlabel = form_label(
															 $option,
															 strtolower(str_replace($out, $in, $option))
														 );

														 //Checkbox
														 $data .= '<p>'.form_checkbox($checkbox).$checkboxlabel.'</p>';
													 }
												 }

											 } elseif($contact_fields[$field_key] == 'radio') {

												 $options = ($contact_form_field->field_attributes != '') ? explode(',', $contact_form_field->field_attributes): array();
												 if(!empty($options)) {

													 foreach($options as $option) {

														 $checked = ($value == $option) ? TRUE: FALSE;
														 $radio_array = array(
															 'id'       => strtolower(str_replace($out, $in, $option)),
															 'class'    => 'flat'
														 );
														 $radio = ($contact_requireds[$field_key] == 1) ? array_merge($radio_array, $required_array): $radio_array;

														 //Radio Label
														 $radiolabel = form_label(
															 $option,
															 strtolower(str_replace($out, $in, $option))
														 );

														 //Radio
														 $data .= '<p>'.form_radio($label_name, $option, $checked, $radio).$radiolabel.'</p>';
													 }
												 }

											 } elseif($contact_fields[$field_key] == 'datepicker') {

												 $datepicker_array = array(
													 'id'          => 'datepicker',
													 'name'        => $label_name,
													 'placeholder' => 'MM-DD-YYYY',
													 'class'       => 'form-control',
													 'value'       => $value
												 );
												 $datepicker = ($contact_requireds[$field_key] == 1) ? array_merge($datepicker_array, $required_array): $datepicker_array;

												 //Input tag
												 $data .= form_input($datepicker);
											 }*/

											 $data .= '</div></div>';
										 }
										 echo $data;
									// ?>

                                </div>
                            </div>
                        </div>

						<!-- Button Group -->

						<div class="col-md-12 col-sm-12 col-xs-12 ">
               				<div class="input-button-group">
								<?php

								// Submit Button
								if (empty($id)) :
									$submit_value = 'Save';
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
