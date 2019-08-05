<?php
if(!empty($contact_customize) && !empty($contact_form_layout) && !empty($contact_form_fields)) :
	
	$forms_fields = array();
	$column = $contact_form_layout->column;

	if($contact_column_datas == 'contact_us' && $contact_us == 1):

		?>
<div class="col <?php echo ($contact_row_column_count == 'l6' && $contact_info_page == 1 ? 'l7': 'l12'); ?>">
    <?php
			echo heading(
				$contact_customize->form_title,
				'4',
				array(
					'class' => $contact_customize->title_color.' '.$contact_customize->title_position .' h3-head',
				)
			);
			?>
    <div class="row">

        <?php
				// Form Tag
				echo form_open_multipart(
				  'contact_us/insert_contact_us',
				  'class="col s12 l12" id="contact_form" method="post"'
				);

				$datepicker_count = 0;
				$out = array('& ', ' ');
				$in = array('', '_');

				// Hidden Website ID
				echo form_input(array(
					'id'    => 'website_id',
					'name'  => 'website_id',
					'type'  => 'hidden',
					'value' => $website_id
				));

				// Hidden Page URL
				echo form_input(array(
					'id'    => 'page_url',
					'name'  => 'page_url',
					'type'  => 'hidden',
					'value' => $page_url
				));

				// Hidden Page ID
				echo form_input(array(
					'id'    => 'page_id',
					'name'  => 'page_id',
					'type'  => 'hidden',
					'value' => $page_id
				));

				foreach($contact_form_fields->label_name as $contact_form_field):
					$forms_fields[] = str_replace(' ', '_', $contact_form_field);
				endforeach;

				$column_data_value = array();
				if($column != ''):
				
					$row_column = explode("/",$column);
					
					for($r = 0; $r < count($row_column); $r++):
					
						$column_data = explode("-", $row_column[$r]);
						if(!empty($column_data)):
						
							if($column_data[1] != ""):
							
								$column_data_value = ($r != 0) ? $column_data_value: array();
								$column_datas   = explode(",", $column_data[1]);
								$column_data_value = array_merge($column_datas, $column_data_value);
								
							endif;
							
						endif;
						
					endfor;

					for($r = 0; $r < count($row_column); $r++):
					
						$column_data = explode("-", $row_column[$r]);
						if(!empty($column_data)):
						
							if($column_data[1] != ""):
							
								$column_datas = explode(",", $column_data[1]);
								$column_count = count($column_datas);
								$row_column_count = ($column_count == 1 ? 'l12': ($column_count == 2 ? 'l6': ($column_count == 3 ? 'l4': ($column_count == 4 ? 'l3': 'l12'))));
								
								for($c = 0; $c < $column_count; $c++):
									
									$hidden_fields = (!in_array($column_datas[$c], $contact_enable_label_names)) ? '': '';
									?>
        <div class="input-field <?php echo $hidden_fields; ?> col s12 <?php echo $row_column_count; ?>">

            <?php
										// Get Contact Us Form Table
										echo $controller->form_table($website_id, $column_datas[$c], $datepicker_count);
										
										/*$separate_contact_form_fields = $this->Contact_us_model->get_separate_contact_form_field($website_id, $column_datas[$c]);
										if(!empty($separate_contact_form_fields)):
										
											($separate_contact_form_fields[0]->field == 'datepicker') ? $datepicker_count++: '';
										
										endif;*/
										?>

        </div>
        <?php
									
								endfor;
								
							endif;
							
						endif;
						
					endfor;
					
				endif;
				
				$single_column_data = array_diff($forms_fields, $column_data_value);
				if(!empty($single_column_data)):
				
					foreach($single_column_data as $key => $value):
						
						$hidden_fields = (!in_array($single_column_data[$key], $contact_enable_label_names)) ? 'hide': '';
						?>
        <div class="input-field <?php echo $hidden_fields; ?> col s12 l12">

            <?php
                            // Get Contact Us Form Table
							echo $controller->form_table($website_id, $single_column_data[$key], $datepicker_count);
							
							/* $separate_contact_form_fields = $this->Contact_us_model->get_separate_contact_form_field($website_id, $single_column_data[$key]);
							if(!empty($separate_contact_form_fields)):
							
								($separate_contact_form_fields[0]->field == 'datepicker') ? $datepicker_count++: '';
							
							endif;*/
							?>

        </div>
        <div class="captcha  col s12 l12">
        <?php
						
					endforeach;
					
				endif;
				
				echo form_input(array(
					'id'       => 'datepicker_count',
					'name'     => 'datepicker_count',
					'type'   => 'hidden',
					'value' => $datepicker_count
				));
				
				// Check border is enabled
				if ($contact_customize->border == 1):
				
					$border = array(
						'style' => 'border: '.$contact_customize->border_size.' solid '.$contact_customize->border_color
					);
					
				else :
				
					$border = array();
					
				endif;
				
				$button_hover = array(
					'onmouseover' => 'contactButtonHover(\'' . $contact_customize->button_background_color . '\', \'' . $contact_customize->button_label_color . '\', \'' . $contact_customize->hover_background_color . '\', \'' . $contact_customize->hover_label_color . '\',\'contact_us\')',
					'onmouseout' => 'contactButtonHoverOut(\'' . $contact_customize->button_background_color . '\', \'' . $contact_customize->button_label_color . '\', \'' . $contact_customize->hover_background_color . '\', \'' . $contact_customize->hover_label_color . '\',\'contact_us\')'
				);
				
				// Form Submit
				
				$form_submit = array(
					'class' => $contact_customize->button_type.' '.$contact_customize->button_label_color.' '.$contact_customize->button_background_color,
					'id'    => 'contact_us_submit',
					'name'  => 'submit',
					'value' => $contact_customize->button_label
				);
				$submit = array_merge($form_submit, $border);
				$submit = array_merge($submit, $button_hover);
				
				if($contact_customize->captcha == 1 && $contact_customize->choose_captcha == 'google_captcha'):
				
					echo '<div class="g-recaptcha" data-sitekey="'.$google_site_key.'"></div>';
				
				elseif($contact_customize->captcha == 1 && $contact_customize->choose_captcha == 'image_captcha'):
					
					
					echo '<div class="google-captach-right"><span id="image_captcha">'.$captchaImg.'</span>
						<a href="javascript:void(0);" onclick="captcha_refresh()" class="captcha-refresh"><i class="fas fa-sync-alt"></i></a></div>';
					
					echo form_input(array(
						'id'       => 'captcha',
						'name'     => 'captcha',
						'required' => 'required',
						'class'    => 'validate',
						'placeholder' => 'Enter Captcha',
						'value'    => ''
					));
				
				endif;
				
				echo form_submit($submit);
				
				//Form close
				echo form_close(); 
				?>
</div>
    </div>
</div>

<?php
		
	elseif($contact_column_datas == 'contact_information' && $contact_info_page == 1):
		
		if(!empty($contact_informations))
		{
			?>
<div
    class="contact-information-container col <?php echo ($contact_row_column_count == 'l6' && $contact_us == 1 ? 'l5': 'l12'); ?>">
    <?php
                echo heading(
                    $contact_informations[0]->title,
                    '4',
                    array(
                        'class' => $contact_informations[0]->title_color.' '.$contact_informations[0]->title_position .' h3-head',
                    )
                );
                ?>
    <ul class="contact-information-list">
        <li>
            <div class="contact-information-icon"> <i
                    class="fa <?php echo $contact_informations[0]->address_icon.' '.$contact_informations[0]->address_icon_color; ?>"></i>
            </div>
            <div class="contact-information-detail ">
                <h5 class="<?php echo $contact_informations[0]->address_title_color; ?>">Address:</h5>
                <p class="<?php echo $contact_informations[0]->address_title_color; ?>">
                    <?php echo $contact_informations[0]->address; ?></p>
            </div>
        </li>
        <li>
            <div class="contact-information-icon"> <i
                    class="fa <?php echo $contact_informations[0]->phone_icon.' '.$contact_informations[0]->phone_icon_color; ?>"></i>
            </div>
            <div class="contact-information-detail ">
               <h5 class="<?php echo $contact_informations[0]->phone_no_title_color; ?>">phone:</h5>
                <p class="<?php echo $contact_informations[0]->phone_no_title_color; ?>">
                    <?php echo $contact_informations[0]->phone_no; ?></p>
            </div>
        </li>
        <li>
            <div class="contact-information-icon "> <i
                    class="fa <?php echo $contact_informations[0]->email_icon.' '.$contact_informations[0]->email_icon_color; ?>"></i>
            </div>
            <div class="contact-information-detail">
            <h5 class="<?php echo $contact_informations[0]->email_title_color; ?>">Email:</h5>
                <p class="<?php echo $contact_informations[0]->email_title_color; ?>">
                    <?php echo $contact_informations[0]->email; ?></p>
            </div>
        </li>
    </ul>
</div>
<?php 
		}
	
	endif;
	
endif;