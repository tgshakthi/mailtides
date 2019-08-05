<?php
/**
 * Footer
 * Created at : 11-May-2018
 * Author : Athi
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Footer extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->module('setting');
		$this->load->module('header');
		$this->load->model('Footer_model');
	}

	// Footer Logo
	function footer_logo($website_id)
	{
		$website_folder = $this->setting->website_folder();
		$footer_logo = '';

		// Get Logo Customization

		$footer_logo_data = $this->setting->get_setting('website_id', $website_id, 'footer-logo');
		if (!empty($footer_logo_data))
		{
			if ($footer_logo_data['footer_logo_status'] === '1'):
				$footer_logo.= "<li class='col s12 m6 l2 xl2'>
						<div class='div-container'>
							<div class='footer-logo footer-equal-height ".$footer_logo_data["footer_logo_size"]."'>";
								$footer_logo.= anchor("", img(array(
									'src' => 'assets/images/' . $website_folder . '/' . $footer_logo_data['footer_logo_image']
								)) , array(
									'class' => 'footer-logo-a'
								));
				$footer_logo.= "</div>
						</div>
					</li>";
			endif;
		}
		return $footer_logo;
	}

	// Footer Events
	function footer_events($website_id)
	{
		$footer_event_list = '';
		// Get Events From Setting
		$footer_events_data = $this->setting->get_setting('website_id', $website_id, 'footer_event');

		if (!empty($footer_events_data) && $footer_events_data['status'] === '1') :

			$footer_events_ids = explode(',', $footer_events_data['event_id']);

			if (!empty($footer_events_ids)) :

				$footer_event_list .= "<li class='col s12 m6 l2 xl2'>
				<div class='div-container'>
					<div class='footer-event footer-equal-height'></div>
					<h3 class='footer-event-heading h4-head white-text'>EVENTS</h3>
					<div class='footer-scrollbar'>";
					
					foreach ($footer_events_ids as $footer_events_id) :
						$get_event_list = $this->Footer_model->get_event_details($website_id, $footer_events_id);

						if (!empty($get_event_list)) :	

							// Background Color
							$background_color = (!empty($get_event_list[0]->background_color)) ? $get_event_list[0]->background_color : 'white';
							// Date Color
							$date_color = (!empty($get_event_list[0]->date_color)) ? $get_event_list[0]->date_color : 'black-text';
							//Title Color
							$title_color = (!empty($get_event_list[0]->title_color)) ? $get_event_list[0]->title_color : 'black-text';
							// Short Desc color
							$short_desc_color = (!empty($get_event_list[0]->short_description_color)) ? $get_event_list[0]->short_description_color : 'black-text';

							// Replace p tag with color
							$replace_text = "<p class='$short_desc_color'>";
							$short_desc = str_ireplace('<p>', $replace_text, $get_event_list[0]->short_description);

							$footer_event_list .= "<div class='footer-event-list $background_color'>
								<a href='" . base_url() . $get_event_list[0]->event_url . "'>
									<h6 class='$date_color right-align'>" . $get_event_list[0]->date . "</h6>
									<h4 class='$title_color'>" . $get_event_list[0]->title . "</h4>
									$short_desc
								</a>
							</div>";

						endif;						
					
					endforeach;					
					
				$footer_event_list .= "</div>
					</div>
				</li>";

			endif;

		endif;

		return $footer_event_list;
	}

	// Footer Contact Info
	function footer_contact_info($website_id)
	{
		$footer_contact_info = '';

		$footer_contact_info_datas = $this->setting->get_setting('website_id', $website_id, 'footer_contact_info');

		if (!empty($footer_contact_info_datas) && $footer_contact_info_datas['footer_contact_info_status']) :

			// Get Contact Information from contact_info table
			$get_footer_contact_informations = $this->Footer_model->get_footer_contact_information($footer_contact_info_datas['footer_contact_info'], $website_id);

			if (!empty($get_footer_contact_informations)) :

				$footer_contact_info .= "<li class='col s12 m6 l2 xl2'>
					<div class='div-container'>
						<div class='footer-contact-info footer-equal-height'>
							<h3 class='footer-event-heading h4-head white-text'>contact info</h3>
							<ul class='footer-contact-info-details'>";

							// Phone Number
							if(in_array('phone_no', $footer_contact_info_datas['footer_contact_info'])) :

								$phone_icon = $get_footer_contact_informations[0]->phone_icon;
								$phone_icon_color = $get_footer_contact_informations[0]->phone_icon_color;
								$phone_no = $get_footer_contact_informations[0]->phone_no;
								$phone_icon_color = (!empty($phone_icon_color)) ? $phone_icon_color : 'black-text';

								$footer_contact_info .= "<li>
									<i class='fa $phone_icon $phone_icon_color' aria-hidden='true'></i>
									<div class='contact-foot-detail white-text'>$phone_no</div>
								</li>";

							endif;
							
							// Email
							if(in_array('email', $footer_contact_info_datas['footer_contact_info'])) :
								$email_icon = $get_footer_contact_informations[0]->email_icon;
								$email_icon_color = $get_footer_contact_informations[0]->email_icon_color;
								$email = $get_footer_contact_informations[0]->email;
								$email_icon_color = (!empty($email_icon_color)) ? $email_icon_color : 'black-text';

								$footer_contact_info .= "<li>
									<i class='fa $email_icon $email_icon_color'></i>
									<div class='contact-foot-detail white-text'>$email</div>
								</li>";
							endif;

							// Address
							if(in_array('address', $footer_contact_info_datas['footer_contact_info'])) :

								$address_icon = $get_footer_contact_informations[0]->address_icon;
								$address_icon_color = $get_footer_contact_informations[0]->address_icon_color;
								$address = $get_footer_contact_informations[0]->address;

								$address_icon_color = (!empty($address_icon_color)) ? $address_icon_color : '';

								$footer_contact_info .= "<li>
									<i class='fa $address_icon $address_icon_color'></i>
									<div class='contact-foot-detail white-text'>$address</div>
								</li>";

							endif;
							
				$footer_contact_info .= "<ul>
						</div>
					</div>
				</li>";				

			endif;

		endif;

		return $footer_contact_info;
	}

	// Footer Blog
	function footer_blog($website_id)
	{
		$website_folder = $this->setting->website_folder();
		$footer_blog_list = '';
		// Get Blogs From Setting
		$footer_blogs_data = $this->setting->get_setting('website_id', $website_id, 'footer_blog');	

		if (!empty($footer_blogs_data) && $footer_blogs_data['status'] === '1') :

			$blog_ids = explode(',', $footer_blogs_data['blog_id']);

			if (!empty($blog_ids)) :

				$footer_blog_list .= "<li class='col s12 m6 l2 xl2'>
					<div class='div-container'>
						<div class='footer-recent-post footer-equal-height'>
							<h3 class='footer-event-heading h4-head white-text'>Recent Post</h3>
							<div class='footer-scrollbar'>";

							foreach ($blog_ids as $blog_id) :
								$get_blog_list = $this->Footer_model->get_blog_details($website_id, $blog_id);

								// Background Color
								$background_color = (!empty($get_blog_list[0]->background_color)) ? $get_blog_list[0]->background_color : 'white';
								// Date Color
								$date_color = (!empty($get_blog_list[0]->date_color)) ? $get_blog_list[0]->date_color : 'black-text';
								//Title Color
								$title_color = (!empty($get_blog_list[0]->title_color)) ? $get_blog_list[0]->title_color : 'black-text';
								

								$footer_blog_list .= "<div class='footer-recent-post'>
									<a href='" . base_url() . $get_blog_list[0]->blog_url . "'>
										<div class='footer-blog-post-image'>
											<img src='assets/images/". $website_folder ."/". $get_blog_list[0]->image ."' />
										</div>

										<div class='footer-blog-post-content'>
											<h5 class='$title_color'>" . $get_blog_list[0]->title . "</h5>

											<ul class='footer-blog-date-time'>
												<li><a href='#' class='date-2 $date_color'><i class='far fa-calendar-alt'></i> " . $get_blog_list[0]->date . "</a></li>
											</ul>
										</div>
									</a>
								</div>";
								
							endforeach;

				$footer_blog_list .= "</div>
						</div>
					</div>
				</li>";

			endif;

		endif;
		
		return $footer_blog_list;
	}

	// Footer Social Media
	function footer_social_media($website_id)
	{
		$footer_social_media_list = '';

		// Footer Social Media
		$get_footer_setting_social_media = $this->setting->get_setting('website_id', $website_id, 'footer_social_media_info');

		if (!empty($get_footer_setting_social_media) && $get_footer_setting_social_media['footer_social_info_status'] === '1') :

			$get_footer_social_media_informations = $this->Footer_model->get_footer_social_media($website_id);

			if (!empty($get_footer_social_media_informations)) :

				
				$footer_social_media_list .= "<div class='foot-social-media'>
					
							<ul class='footer-social-media-list center'>";

							foreach ($get_footer_social_media_informations as $get_footer_social_media_information) :
								// icon color
								$media_icon_color = $get_footer_social_media_information->icon_color;

								$media_icon_color = (!empty($media_icon_color)) ? $media_icon_color : 'black-text';

								$footer_social_media_list .= "<li>
									<a href='$get_footer_social_media_information->media_url' class='$media_icon_color' target='_blank'><i class='fa $get_footer_social_media_information->icon'></i></a>
								</li>";

							endforeach;

				$footer_social_media_list .= "</ul>
						
				</div>";				

			endif;

		endif;

		return $footer_social_media_list;
	}

	// View Selected Theme Footer

	function index()
	{
		$website_folder = $this->setting->website_folder();
		$data['website'] = $this->setting->website_id();
		$data['theme']   = $this->setting->theme_name();
		$data['page_url'] = $this->setting->page_url();
		$data['image_url'] = $this->setting->image_url();
		$data['menus_new'] = $this->header->menu_new($data['website']);
		$data['mobile_nav'] = $this->header->mobile_nav($data['website']);

		// Footer status
		$footer_status_info = $this->setting->get_setting('website_id', $data['website'], 'footer_status_and_background');

		if(!empty($footer_status_info)) :
			$data['footer_status'] = $footer_status_info['footer_status'];
			$data['component_background'] = $footer_status_info['component_background'];
			$data['footer_background'] = $footer_status_info['footer_background'];
		else:
			$data['footer_status'] = "";
			$data['component_background'] = '';
			$data['footer_background'] = '';
		endif;
		
		// Background
		if ($data['component_background'] != '') :
			if ($data['component_background'] == 'image') :
				$data['bg_image'] = $data['image_url'] . $data['footer_background'];
				$data['bg_color'] = "";
			elseif ($data['component_background'] == 'color') :
				$data['bg_color'] = $data['footer_background'];
				$data['bg_image'] = "";
			else :
				$data['bg_color'] = '';
				$data['bg_image'] = '';
			endif;
		endif;	
		// Footer Logo
		$data['footer_logo'] = $this->footer_logo($data['website']);

		// Footer Events
		$data['footer_events'] = $this->footer_events($data['website']);

		// Footer Contact info
		$data['footer_contact_info'] = $this->footer_contact_info($data['website']);

		// Footer Blog
		$data['footer_blog'] = $this->footer_blog($data['website']);

		// Footer Social Media
		$data['footer_social_media'] = $this->footer_social_media($data['website']);
		
		// Footer Menu
		$data['menus'] = $this->Footer_model->get_menu($data['website']);

		// Get Menu Customize From Footer Model
		$menu_customs = $this->Footer_model->get_menu_customize($data['website']);
		if (!empty($menu_customs))
		{
			$keys = json_decode($menu_customs[0]->key);
			$values = json_decode($menu_customs[0]->value);
			$i = 0;
			foreach($keys as $key)
			{
				$data[$key] = $values[$i];
				$i++;
			}
		}
		else
		{
			$data['column'] = '';
			$data['status'] = '';
		}


		$copyrights_details = $this->setting->get_setting('website_id', $data['website'], 'footer-copyrights');
		if (!empty($copyrights_details))
		{
			$data['copyrights_content'] = $copyrights_details['copyrights_content'];
			$data['copyrights_text_color'] = $copyrights_details['copyrights_text_color'];
			$data['copyrights_bg_color'] = $copyrights_details['copyrights_bg_color'];
			$data['copyright_status'] = $copyrights_details['copyright_status'];
		}
		else
		{
			$data['copyrights_content'] = "";
			$data['copyrights_text_color'] = "";
			$data['copyrights_bg_color'] = "";
			$data['copyright_status'] = "";
		}

		//gallery settings
		$footer_gallery_title_attribute	 = $this->setting->get_setting('website_id', $data['website'], 'gallery_title');
		$footer_gallery_customize 		 = $this->setting->get_setting('website_id', $data['website'], 'gallery_customize');

		$data['footer_blog_status'] 	 = $this->setting->get_setting('website_id', $data['website'], 'footer_blog');





		$contact_details = $this->setting->get_setting('website_id', $data['website'], 'footer_contact');
		if (!empty($contact_details))
		{
			$data['contact_us'] = $contact_details['contact_us'];
			$data['contact_information'] = $contact_details['contact_information'];
			$data['contact_status'] = $contact_details['status'];
		}
		else
		{
			$data['contact_us'] = "";
			$data['contact_information'] = "";
			$data['contact_status'] = "";
		}

		$data['contact_forms'] = $this->Footer_model->contact_form($data['website']);

	if (!empty($data['contact_forms']) && $data['contact_forms'][0]->contact_form_field != '' && $data['contact_forms'][0]->contact_customize != '')
		{
			$data['contact_form_fields'] = json_decode($data['contact_forms'][0]->contact_form_field);
			$data['contact_label_names'] = $data['contact_form_fields']->label_name;
			$data['contact_fields']		 = $data['contact_form_fields']->choosefield;
			$data['contact_placeholders']	= $data['contact_form_fields']->placeholder;
			$data['contact_requireds']   = $data['contact_form_fields']->required;
			$data['contact_customize'] 	 = json_decode($data['contact_forms'][0]->contact_customize);
		}
		else
		{
			$data['contact_form_fields'] = array();
			$data['contact_label_names'] = '';
			$data['contact_fields'] = '';
			$data['contact_requireds'] = '';
			$data['contact_customize'] = array();
		}

		//Footer Menu status check
		$footer_menu_status = $this->setting->get_setting('website_id', $data['website'], 'footer-menu');
		if(!empty($footer_menu_status)){
			$data['column'] 						= $footer_menu_status['column'];
			$data['main_menu_text_color'] 			= $footer_menu_status['main_menu_text_color'];
			$data['sub_menu_text_color']			= $footer_menu_status['sub_menu_text_color'];
			$data['main_menu_hover_color'] 			= $footer_menu_status['main_menu_hover_color'];
			$data['sub_menu_hover_color']			= $footer_menu_status['sub_menu_hover_color'];
			$data['footer_menu_status']				= $footer_menu_status['status'];
		}else {
			$data['column'] 						= "";
			$data['main_menu_text_color'] 			= "";
			$data['sub_menu_text_color']			= "";
			$data['main_menu_hover_color'] 			= "";
			$data['sub_menu_hover_color']			= "";
			$data['footer_menu_status']				= "";
		}
		$data['footer_social_feed'] = $this->Footer_model->get_social_feed();


		$this->load->view('theme/' . $data['theme'] . '/inc/footer', $data);
		$this->setting->js_file();
		$this->load->view('theme/' . $data['theme'] . '/inc/view');
	}

	// Footer Contact Us

	function footer_contact_us($website_id)
	{
		$this->load->module('Contact_us');

		$footer_contact_forms = $this->Contact_us_model->contact_form($website_id);
		$footer_contact_form_fields = $this->Contact_us_model->get_contact_form_field($website_id);
		$footer_contact_info = $this->setting->get_setting('website_id', $website_id, 'footer_contact');

		if(!empty($footer_contact_form_fields) && !empty($footer_contact_forms) && !empty($footer_contact_info) && !empty($footer_contact_info['status'])) :

		endif;

	}

	// function footer_social_feed()
	// {
		// $data['footer_social_feed'] = $this->Footer_model->get_social_feed();
		// print_r($data['footer_social_feed']);die;
		// $this->load->view('theme/' . $data['theme'] . '/inc/footer', $data);
	// }



}

?>
