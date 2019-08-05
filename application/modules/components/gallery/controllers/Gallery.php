<?php
/**
 * Gallery
 *
 * @category class
 * @package  Gallery
 * @author   Saravana
 * Created at:  13-Jul-2018
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Gallery extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Gallery_model');
		$this->load->module('Setting');
	}

	/* Get Gallery */
	function view($page_id)
	{
		// Gallery Title
		$data_title_settings = $this->setting->get_setting('page_id', $page_id, 'gallery_title');

		if (!empty($data_title_settings)) :
			$data['gallery_title'] = $data_title_settings['gallery_title'];
			$data['gallery_title_color'] = $data_title_settings['gallery_title_color'];
			$data['gallery_title_position'] = $data_title_settings['gallery_title_position'];
			$data['gallery_title_status'] = $data_title_settings['gallery_title_status'];
		else :
			$data['gallery_title'] = '';
			$data['gallery_title_color'] = '';
			$data['gallery_title_position'] = '';
			$data['gallery_title_status'] = '';
		endif;

		// Gallery Customized data
		$data_customize_from_setting = $this->setting->get_setting('page_id', $page_id, 'gallery_customize');

		if (!empty($data_customize_from_setting)) :
			$data['count'] = $data_customize_from_setting['row_count'];
			$data['component_background'] = $data_customize_from_setting['component_background'];
			$data['gallery_image_background'] = $data_customize_from_setting['gallery_image_background'];
		else :
			$data['count'] = '';
			//$data['background_color'] = '';
			$data['component_background'] = '';
			$data['gallery_image_background'] = '';
		endif;
		
		// Image Url
		$data['image_url'] = $this->setting->image_url();

		// Background
		if ($data['component_background'] != '') :
			if ($data['component_background'] == 'image') :
				$data['bg_image'] = $data['image_url'] . $data['gallery_image_background'];
				$data['bg_color'] = "";
			elseif ($data['component_background'] == 'color') :
				$data['bg_color'] = $data['gallery_image_background'];
				$data['bg_image'] = "";
			else :
				$data['bg_color'] = '';
				$data['bg_image'] = '';
			endif;
		endif;	
		
		$data['gallery'] = $this->Gallery_model->get_gallery($page_id);
		$data['gallery_tab_list'] = $this->gallery_tab_list($page_id);
		$data['gallery_tab_image_data'] = $this->gallery_tab_images($page_id);
		$this->load->view('gallery', $data);
	}

	function gallery_tab_list($page_id)
	{
		$website_id = $this->setting->website_id();

		// Gallery Customized data
		$data_customize_from_setting = $this->setting->get_setting('page_id', $page_id, 'gallery_customize');

		if (!empty($data_customize_from_setting)) :
			$component_background = $data_customize_from_setting['component_background'];
			$gallery_image_background = $data_customize_from_setting['gallery_image_background'];
		else :
			//$background_color = '';
			$component_background = '';
			$gallery_image_background = '';
		endif;

		$list = '';
		$gallery_categories = $this->Gallery_model->get_gallery_category($website_id, $page_id);

		if (!empty($gallery_categories)) :

			$i = 2;

			foreach ($gallery_categories as $gallery_category) :

				$list .= '<li class="tab"><a href="#test'.$i.'" id="gallery_tab_text">'.$gallery_category->category_name.'</a></li>';
				$i++;

			endforeach;

		endif;

		$data = '<ul class="tabs gallery-tab ">
		<li class="tab">
			<a href="#test1" class="active" id="gallery_tab_text">All</a>
		</li>
		'.$list.'
		</ul>';

		return $data;
	}

	function gallery_tab_images($page_id)
	{
		$website_id = $this->setting->website_id();
		$image_url = $this->setting->image_url();

		// Gallery Customized data
		$data_customize_from_setting = $this->setting->get_setting('page_id', $page_id, 'gallery_customize');

		if (!empty($data_customize_from_setting)) :
			$count = $data_customize_from_setting['row_count'];
		else :
			$count = '';
		endif;

		$gallery_tab_image_data = '';
		$gallery_tab_image_data_index = '';

		$gallery = $this->Gallery_model->get_gallery($page_id);

		$gallery_tab_image_data_index .= '<div class="col s12" id="test1">
			<div class="'.$count.'" id="photos">';

					foreach ($gallery as $gallery_result) :
						//$thumb_image = str_replace('images/', 'thumbs/', $gallery_result->image);
						$gallery_tab_image_data_index .= anchor(
							$image_url . $gallery_result->image,
							img(array(
								//'src' => 'assets/'.$thumb_image,
								'src' => $image_url . $gallery_result->image,
								'alt' => $gallery_result->image_alt,
								'title' => $gallery_result->image_title,
								'style' => 'width:100%'
							)),
							array(
								'class' => 'galleryItem',
								'data-group' => '1'
							)
						);
					endforeach;

		$gallery_tab_image_data_index .= '</div>
		</div>';

		$gallery_category_ids = $this->Gallery_model->get_gallery_category($website_id, $page_id);

		if (!empty($gallery_category_ids)) :

			$i = 2;

			foreach ($gallery_category_ids as $gallery_category_id) :

				$gallery_tab_images = $this->Gallery_model->get_tab_gallery_images($page_id, $gallery_category_id->id);

				$gallery_tab_image_data .= '<div class="col s12" id="test'.$i.'">
				<div id="photos" class="'.$count.'" >';

				foreach ($gallery_tab_images as $gallery_tab_image) :
					//$thumb_image = str_replace('images/', 'thumbs/', $gallery_tab_image->image);
					$gallery_tab_image_data .= anchor(
						$image_url . $gallery_tab_image->image,
						img(array(
							//'src' => 'assets/'.$thumb_image,
							'src' => $image_url . $gallery_tab_image->image,
							'alt' => $gallery_tab_image->image_alt,
							'title' => $gallery_tab_image->image_title,
							'style' => 'width:100%'
						)),
						array(
							'class' => 'galleryItem',
							'data-group' => '1'
						)
					);

				endforeach;

				$gallery_tab_image_data .= '</div></div>';

				$i++;

			endforeach;

		endif;

		return $gallery_tab_image_data_index.$gallery_tab_image_data;
	}

}

?>