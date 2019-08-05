<?php
/**
 * Page
 * Created at : 09-Mar-2018
 * Author : Saravana
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Page extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Page_model');
		$this->load->module('Setting');
		$this->load->module('header');
		$this->load->module('footer');
	}

	function index()
	{
		
		$data['title'] = 'Home';
		$this->header->index();
		$theme = $this->setting->theme_name();
		$page_id = $this->setting->page_id();
		if ($page_id != 0)
		{
			$components = $this->Page_model->get_page_components($page_id);
			
			if (!empty($components))
			{
				foreach($components as $component)
				{
					$character_out = array(
						' & ',
						' '
					);
					$character_in = array(
						' ',
						'_'
					);
					$function_name = str_ireplace($character_out, $character_in, strtolower($component->name));
					//$this->load->module(ucwords($function_name));
					$s =$this->load->module($function_name);
					$this->$function_name->view($page_id);
				}
			}
		}
		else
		{
			show_404();
		}

		$this->footer->index();
	}

	/**
	 * Get Referral Path
	 */
	function get_error_page_path()
	{
		if(!empty($_POST['url'])) :
			$website_id = $this->setting->website_id();
			$this->Page_model->get_error_page($website_id);
		endif;
	}
}

?>
