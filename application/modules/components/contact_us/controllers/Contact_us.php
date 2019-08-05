<?php
/**
 * Contact Us
 * Created at : 02-July-2018
 * Author : Athi
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Contact_us extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('captcha');
		$this->load->model('Contact_us_model');
		$this->load->module('setting');
		$this->load->module('mail');
	}

	/* Get Contact Us */
	function view($page_id)
	{
		$data['website_id'] = $this->setting->website_id();
		$data['page_url'] = $this->setting->page_url();
		$data['page_id'] = $this->setting->page_id();
		$data['image_url'] = $this->setting->image_url();

		// Contact Page Layout
		$contact_page_layout = $this->Contact_us_model->get_contact_page_layout($data['website_id'], $page_id);
		if(!empty($contact_page_layout)) :

			$keys = json_decode($contact_page_layout[0]->key);
			$values = json_decode($contact_page_layout[0]->value);

			$i = 0;
			foreach($keys as $key)
			{
				$data[$key] = $values[$i];
				$i++;
			}

		else :

			$data['contact_row'] = '';
			$data['contact_column'] = '';

		endif;
		
		// Contact Form
		$contact_form = $this->Contact_us_model->contact_form($data['website_id']);

		if(!empty($contact_form)) :

			$contact_customize = json_decode($contact_form[0]->contact_customize);
			$data['contact_form_field'] = json_decode($contact_form[0]->contact_form_field);
			$data['contact_form_layout'] = json_decode($contact_form[0]->contact_form_layout);

			//echo '<pre>';

			if(!empty($contact_customize)) :

				foreach($contact_customize as $key => $val) :
					$data[$key] = $val;
				endforeach;

			else :

				$data['component_background'] = "";
				$data['contact_us_background'] = "";
				$data['form_title'] = "";

			endif;


		else :

			//$data['contact_customize'] = "";
			$data['contact_form_field'] = "";
			$data['contact_form_layout'] = "";

		endif;
		// Background
		if ($data['component_background'] != '') :
			if ($data['component_background'] == 'image') :
				$data['bg_image'] = $data['image_url'] . $data['contact_us_background'];
				$data['bg_color'] = "";
			elseif ($data['component_background'] == 'color') :
				$data['bg_color'] = $data['contact_us_background'];
				$data['bg_image'] = "";
			else :
				$data['bg_color'] = '';
				$data['bg_image'] = '';
			endif;
		endif;	

		$data['forms_fields'] = array('contact_us', 'contact_information');
		$data['controller'] = $this;
		$this->load->view('contact_us', $data);

	}

	// Form Table

	function form_table($website_id, $form_id, $datepicker_count)
	{
		$data['contact_forms'] = $this->Contact_us_model->contact_form($website_id);
		
		if (!empty($data['contact_forms']) && $data['contact_forms'][0]->contact_form_field != '' && $data['contact_forms'][0]->contact_customize != '')
		{
			$data['contact_form_fields'] = json_decode($data['contact_forms'][0]->contact_form_field);
			$data['contact_label_names'] = $data['contact_form_fields']->label_name;
			$data['contact_enable_label_names'] = $this->Contact_us_model->get_enable_label_name($website_id);
			$data['field_key']			 = array_search(str_replace('_', ' ', $form_id), $data['contact_label_names']);
			$data['contact_fields']		 = $data['contact_form_fields']->choosefield;
			$data['contact_requireds']   = $data['contact_form_fields']->required;
			$data['contact_customize'] 	 = json_decode($data['contact_forms'][0]->contact_customize);
		}
		else
		{
			$data['contact_form_fields'] = array();
			$data['contact_label_names'] = '';
			$data['contact_enable_label_names'] = array();
			$data['field_key'] = '';
			$data['contact_fields'] = '';
			$data['contact_requireds'] = '';
			$data['contact_customize'] = array();
		}
		$data['datepicker_count'] = $datepicker_count;
		$this->load->view('contact_us_table', $data);
	}

	// Contact Us Information

	function contact_us_information($website_id, $page_id, $page_url, $contact_row_column_count, $contact_column_data)
	{
		$data['website_id'] = $website_id;
		$data['page_url'] = $page_url;
		$data['page_id'] = $page_id;
		$data['contact_row_column_count'] = $contact_row_column_count;
		$data['contact_column_datas'] = $contact_column_data;
		$data['contact_forms'] = $this->Contact_us_model->contact_form($website_id);
		if (!empty($data['contact_forms']) && $data['contact_forms'][0]->contact_form_field != '' && $data['contact_forms'][0]->contact_customize != '' && $data['contact_forms'][0]->contact_form_layout != '')
		{
			$data['contact_form_fields'] = json_decode($data['contact_forms'][0]->contact_form_field);
			$data['contact_customize'] = json_decode($data['contact_forms'][0]->contact_customize);
			$data['contact_form_layout'] = json_decode($data['contact_forms'][0]->contact_form_layout);
		}
		else
		{
			$data['contact_form_fields'] = array();
			$data['contact_customize'] = array();
			$data['contact_form_layout'] = array();
		}

		if (!empty($data['contact_customize']))
		{
			if($data['contact_customize']->captcha == 1 && $data['contact_customize']->choose_captcha == 'google_captcha')
			{
				$data['google_site_key'] = $data['contact_customize']->google_site_key;
			}
			elseif($data['contact_customize']->captcha == 1 && $data['contact_customize']->choose_captcha == 'image_captcha')
			{
				$config = array(
					'img_url'     => base_url() . 'assets/image_for_captcha/',
					'img_path'    => 'assets/image_for_captcha/',
					'font_path'   => 'system/fonts/texb.ttf',
					'img_height'  => $data['contact_customize']->image_captcha_height,
					'word_length' => $data['contact_customize']->image_captcha_word_length,
					'img_width'   => $data['contact_customize']->image_captcha_width,
					'font_size'   => $data['contact_customize']->image_captcha_font_size,
					'expiration'  => 7200
				);
				$captcha = create_captcha($config);
				$this->session->unset_userdata('valuecaptchaCode');
				$this->session->set_userdata('valuecaptchaCode', $captcha['word']);
				$data['captchaImg'] = $captcha['image'];
			}
		}
		
		// Contact Page Layout
		$contact_pages = $this->Contact_us_model->get_contact_pages($data['website_id'], $page_id);
		if(!empty($contact_pages)) :

			$keys = json_decode($contact_pages[0]->key);
			$values = json_decode($contact_pages[0]->value);

			$i = 0;
			foreach($keys as $key)
			{
				$data[$key] = $values[$i];
				$i++;
			}

		else :

			$data['contact_us'] = '';
			$data['contact_info_page'] = '';

		endif;
		
		$data['contact_informations'] = $this->Contact_us_model->contact_information($website_id);
		$data['contact_enable_label_names'] = $this->Contact_us_model->get_enable_label_name($website_id);

		$this->load->view('contact_us_information', $data);
	}

	// Get Refresh Image

	function refresh()
	{
		$website_id = $this->setting->website_id();
		$contact_forms = $this->Contact_us_model->contact_form($website_id);
		if (!empty($contact_forms) && $contact_forms[0]->contact_customize != '')
		{
			$contact_customize = json_decode($contact_forms[0]->contact_customize);
			if ($contact_customize->captcha == 1 && $contact_customize->choose_captcha == 'image_captcha')
			{
				$config = array(
					'img_url' => base_url() . 'assets/image_for_captcha/',
					'img_path' => 'assets/image_for_captcha/',
					'font_path' => 'system/fonts/texb.ttf',
					'img_height' => $contact_customize->image_captcha_height,
					'word_length' => $contact_customize->image_captcha_word_length,
					'img_width' => $contact_customize->image_captcha_width,
					'font_size' => $contact_customize->image_captcha_font_size,
					'expiration' => 7200
				);
				$captcha = create_captcha($config);
				$this->session->unset_userdata('valuecaptchaCode');
				$this->session->set_userdata('valuecaptchaCode', $captcha['word']);
				echo $captcha['image'];
			}
		}
	}

	// Insert Data

	function insert_contact_us()
	{
		$page_url = $this->input->post('page_url');
		$page_id = $this->input->post('page_id');
		$website_id = $this->input->post('website_id');
		$contact_forms = $this->Contact_us_model->contact_form($website_id);
		if (!empty($contact_forms) && $contact_forms[0]->contact_customize != '' && $page_id != 0)
		{
			$contact_customize = json_decode($contact_forms[0]->contact_customize);
			if ($contact_customize->captcha == 1 && $contact_customize->choose_captcha == 'google_captcha')
			{
				// your site secret key
				$secret = $contact_customize->google_secret_key;

				// get verify response data
				$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);
				$responseData = json_decode($verifyResponse);
				if (!$responseData->success)
				{
					$data['title'] = 'Oops';
					$data['message'] = 'Please check the Captcha';
					$data['type'] = 'error';
					$data['code'] = 0;
					$data['page_url'] = $page_url;
					echo json_encode($data); die;
				}
			}
			elseif ($contact_customize->captcha == 1 && $contact_customize->choose_captcha == 'image_captcha')
			{
				$captcha_insert = $this->input->post('captcha');
				$contain_sess_captcha = $this->session->userdata('valuecaptchaCode');
				if ($captcha_insert != $contain_sess_captcha)
				{
					$data['title'] = 'Oops';
					$data['message'] = 'Invalid Captcha';
					$data['type'] = 'error';
					$data['code'] = 0;
					$data['page_url'] = $page_url;
					echo json_encode($data); die;
				}
			}
		}

		$contact_mail_configures = $this->Contact_us_model->contact_form_mail_configure($website_id);
		$contact_label_names = $this->Contact_us_model->contact_form_label_name($website_id);
		$contact_enable_label_names = $this->Contact_us_model->get_enable_label_name($website_id);
		$out = array(
			' '
		);
		$in = array(
			'_'
		);
		if ($this->Contact_us_model->insert_contact_us() && !empty($contact_mail_configures) && !empty($contact_label_names) && $contact_mail_configures->status == 1)
		{
			$mailvalueto = '';
			for($i = 0;$i < count($contact_label_names); $i++)
			{
				$label_name = str_replace($out, $in, $contact_label_names[$i]);
				if (strpos(' ' . $label_name, 'mail') && in_array($contact_label_names[$i], $contact_enable_label_names))
				{
					$m = 0;
					if ($m == 0)
					{
						if ($contact_mail_configures->send_mail_to == 1)
						{
							$mailvalueto = $this->input->post($label_name);
						}
						$m++;
					}
				}
			}
			$sort_label_names = ($contact_mail_configures->sort_label_name != '') ? explode(',', $contact_mail_configures->sort_label_name): array();
			$mailvalue = array();
			if (!empty($sort_label_names))
			{
				foreach($sort_label_names as $sort_label_names)
				{
					$label_name = str_replace($out, $in, $sort_label_names);
					$mailvalue[] = $this->input->post($label_name);
				}
			}
			$mailvalue = (!empty($mailvalue)) ? implode(",", $mailvalue) : '';
			$send_mail = $this->mail->send_mail($website_id, $mailvalueto, $mailvalue, 'contact_mail_configure');
			if ($send_mail == '')
			{
				$data['title'] = $contact_mail_configures->success_title;
				$data['message'] = $contact_mail_configures->success_message;
				$data['type'] = 'success';
				$data['code'] = 1;
				$data['page_url'] = $page_url;
				echo json_encode($data);
			}
			else
			{
				echo $page_url;
			}
		}
		else
		{
			echo $page_url;
		}
	}
}

?>
