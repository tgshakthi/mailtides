<?php
if(!empty($contact_form_fields) && !empty($contact_customize)):
		
	$data = '';	
	$out = array(' ');
	$in = array('_');
				
	$is_required = ($contact_requireds[$field_key] == 1) ? '<span class="required">*</span>': '';
	$required_array = array('required' => 'required');
	$required = ($contact_requireds[$field_key] == 1) ? 'required => required': '';
	$label_name = str_replace($out, $in, $contact_label_names[$field_key]);
	
	$label_attributes = array(
		'class' => $contact_customize->label_color
	);
	
	// From Label
	$label = form_label(
		$contact_label_names[$field_key].' '.$is_required,
		$label_name,
		$label_attributes
	);
	
	if($contact_fields[$field_key] == 'textbox'):

		$textbox_array = array(
			'id'       => $label_name,
			'name'     => $label_name,
			'class'    => 'validate',
			'value'    => ''
		);
		$textbox = ($contact_requireds[$field_key] == 1 && in_array($contact_label_names[$field_key], $contact_enable_label_names)) ? array_merge($textbox_array, $required_array): $textbox_array;

		// Input tag
		echo form_input($textbox);
		
	elseif($contact_fields[$field_key] == 'textarea'):
		
		$textarea_array = array(
			'name'        => $label_name,
			'id'          => $label_name,
			'value'       => '',
			'class'       => 'materialize-textarea'
		);
		$textarea = ($contact_requireds[$field_key] == 1 && in_array($contact_label_names[$field_key], $contact_enable_label_names)) ? array_merge($textarea_array, $required_array): $textarea_array;
		
		// Text Area
		echo form_textarea($textarea);
	
	/*elseif($contact_fields[$field_key] == 'dropdown'):
		
		$options = ($separate_contact_form_fields[0]->field_attributes != '') ? explode(',', $separate_contact_form_fields[0]->field_attributes): array();
		$dropdownoptions = array('' => 'select');
		if(!empty($options)):
			
			foreach($options as $option):
				
				$option_value = strtolower(str_replace($out, $in, $option));
				$dropdownoptions[$option_value] = $option;
			endforeach;
		endif;

		$dropdown_array = array(
			'name' => $label_name,
			'id' => $label_name,
		);
		$dropdown= ($contact_requireds[$field_key] == 1) ? array_merge($dropdown_array, $required_array): $dropdown_array;
		
		// Dropdown
		echo form_dropdown($dropdown, $dropdownoptions, '');
		
	elseif($contact_fields[$field_key] == 'checkbox'):
		
		$options = ($separate_contact_form_fields[0]->field_attributes != '') ? explode(',', $separate_contact_form_fields[0]->field_attributes): array();
		if(!empty($options)):
			
			foreach($options as $option):
				
				$checkbox_array = array(
					'name'          => $label_name.'[]',
					'id'            => strtolower(str_replace($out, $in, $option)),
					'class'         => 'flat',
					'value'         => $option
				);
				$checkbox = ($contact_requireds[$field_key] == 1) ? array_merge($checkbox_array, $required_array): $checkbox_array;
				
				// Checkbox Label
				$checkboxlabel = form_label(
					$option,
					strtolower(str_replace($out, $in, $option))
				);
				
				// Checkbox
				echo '<p>'.form_checkbox($checkbox).$checkboxlabel.'</p>';
			endforeach;
		endif;
		
	elseif($contact_fields[$field_key] == 'radio'):
		
		$options = ($separate_contact_form_fields[0]->field_attributes != '') ? explode(',', $separate_contact_form_fields[0]->field_attributes): array();
		if(!empty($options)):
			
			foreach($options as $option):
				
				$radio_array = array(
					'id'       => strtolower(str_replace($out, $in, $option)),
					'class'    => 'flat'
				);
				$radio = ($contact_requireds[$field_key] == 1) ? array_merge($radio_array, $required_array): $radio_array;
				
				// Radio Label
				$radiolabel = form_label(
					$option,
					strtolower(str_replace($out, $in, $option))
				);
				
				// Radio
				echo '<p>'.form_radio($label_name, $option, '', $radio).$radiolabel.'</p>';
			endforeach;
		endif;
		
	elseif($contact_fields[$field_key] == 'datepicker'):
		
		$datepicker_array = array(
			'id'          => 'datepicker_'.$datepicker_count,
			'name'        => $label_name,
			'placeholder' => 'MM-DD-YYYY',
			'class'       => 'form-control',
			'value'       => ''
		);
		$datepicker = ($contact_requireds[$field_key] == 1) ? array_merge($datepicker_array, $required_array): $datepicker_array;

		// Input tag
		echo form_input($datepicker);*/
		
	endif;

	echo $label;
	
endif;
?>