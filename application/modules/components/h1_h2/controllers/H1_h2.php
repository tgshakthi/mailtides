<?php
/**
 * H1 adn H2 tag
 * Created at : 30-Nov-2018
 * Author : Karthika
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class H1_h2 extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('H1andh2_model');
		$this->load->module('setting');
	}

	/* Get H1 and H2 tag */
	function view($page_id)
	{
		$website_id = $this->setting->website_id();
		$page_id = $this->setting->page_id();
		 $h1_and_h2_data_customizations = $this->H1andh2_model-> get_h1_and_h2_customization($website_id, $page_id, 'h1_and_h2');

		if (!empty($h1_and_h2_data_customizations))
		{
			$keys = json_decode($h1_and_h2_data_customizations[0]->key);
			$values = json_decode($h1_and_h2_data_customizations[0]->value);
			$i = 0;

			foreach($keys as $key)
			{
				$data[$key] = $values[$i];
				$i++;
			}
			
		}
		else
		{
			$data['h1_title_color'] = "";
			$data['h2_title_color'] = "";
			$data['h1_title_position'] ="";
			$data['h2_title_position'] = "";
			$data['background_color']	= "";
		}

		$h1_and_h2_datas=$this->H1andh2_model->get_h1andh2($page_id);

		if(!empty($h1_and_h2_datas))
		{
			foreach($h1_and_h2_datas as $h1_and_h2_data)
			{
				$data['h1_tag']=$h1_and_h2_data->h1_tag;
				$data['h2_tag']=$h1_and_h2_data->h2_tag;
			}
		}
		else{
			$data['h1_tag'] = '';
			$data['h2_tag'] = '';
		}
	
		$this->load->view('h1andh2', $data);
	}
}

?>
