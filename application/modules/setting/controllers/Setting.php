<?php
/**
 * Setting
 * Created at : 05-June-2018
 * Author : Athi
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Setting extends MX_Controller
{
	function __construct()
  	{
    	parent::__construct();

		$this->load->model('Setting_model');
  	}

	// Get Website ID
	function website_id()
	{
		$websites = $this->Setting_model->get_website_id();
		$website = (!empty($websites)) ? strtolower($websites[0]->id) : '0' ;
		return $website;
	}

	// Get Website Folder Name
	function website_folder()
	{
		$website_folder = '';
		$website_id = $this->website_id();
		$website_folder_data = $this->Setting_model->get_website_folder($website_id);
		if (!empty($website_folder_data)) :
			$website_folder = $website_folder_data[0]->folder_name;
		endif;
		return $website_folder;
	}

	// Image Url
	function image_url()
	{
		return 'assets/images/' . $this->website_folder() . '/';
	}

	// Get Theme Name
	function theme_name()
	{
		$themes = $this->Setting_model->get_theme();
		$theme = (!empty($themes)) ? strtolower($themes[0]->name) : 'default' ;
		return $theme;
	}

	// Get Page ID
	function page_id()
	{
		$website_id = $this->website_id();

		$url = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		// Parse URL
		$parse_url = parse_url($url);
		$host_url = $parse_url['host'];
		$path_url = $parse_url['path'];

		$page_url = str_replace(base_url(), '', (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $host_url . $path_url);
		$page_url = (!empty($page_url)) ? $page_url : 'index.html';

		$pages = $this->Setting_model->get_page_id($website_id, $page_url);
		$page_id = (!empty($pages)) ? $pages[0]->id : 0;

		return $page_id;
	}

	// Get Page URL
	function page_url()
	{
		$website_id = $this->website_id();
		$url = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		// Parse URL
		$parse_url = parse_url($url);
		$host_url = $parse_url['host'];
		$path_url = $parse_url['path'];

		$page_url = str_replace(base_url(), '', (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $host_url . $path_url);
		$page_url = (!empty($page_url)) ? $page_url : 'index.html';
		return $page_url;
	}

	// Get Favicon
	function favicon()
	{
		$website_id = $this->website_id();
		$favicons = $this->Setting_model->get_favicon($website_id);
		$favicon = '';
		if(!empty($favicons))
		{
			$favicon = $favicons[0]->favicon;
		}
		return $favicon;
	}

	// Get Css File
	function css_file()
	{
		$data['theme'] = $this->theme_name();
		$this->load->view('css', $data);
	}

	// Get Js File
	function js_file()
	{
		$data['theme'] = $this->theme_name();
		$this->load->view('js', $data);
	}

	// Get data from settings
	function get_setting($field, $id, $code)
	{
		$data_settings = $this->Setting_model->get_settings_data($field, $id, $code);
		$records = array();
		if (!empty($data_settings))
		{
			$keys = json_decode($data_settings[0]->key);
			$values = json_decode($data_settings[0]->value);
			$i = 0;
			foreach($keys as $key)
			{
				$data[$key] = $values[$i];
				$i++;
			}
			return $records = $data;
		}
		else
		{
			return $records;
		}
	}

	// Change Text Area Class
	function text_head_attributes(array $attributes, $text)
	{
		$attributes = (!empty($attributes)) ? implode(' ', $attributes): '';
		$heading_tag = array('<h1>', '<h2>', '<h3>', '<h4>', '<h5>', '<h6>');

		$replace_heading_tag = array(
			'<h1 '.$attributes.'>',
			'<h2 '.$attributes.'>',
			'<h3 '.$attributes.'>',
			'<h4 '.$attributes.'>',
			'<h5 '.$attributes.'>',
			'<h6 '.$attributes.'>',
		);

		return str_replace($heading_tag, $replace_heading_tag, $text);
	}

	// Change Text Area Class
	function text_attributes(array $attributes, $text)
	{
		$attributes = (!empty($attributes)) ? implode(' ', $attributes): '';
		$text_tag = array('<span>', '<p>', '<label>', '<ol>', '<ul>');

		$replace_text_tag = array(
			'<span '.$attributes.'>',
			'<p '.$attributes.'>',
			'<label '.$attributes.'>',
			'<ol '.$attributes.'>',
			'<ul '.$attributes.'>'
		);

		return str_replace($text_tag, $replace_text_tag, $text);
	}
}
?>
