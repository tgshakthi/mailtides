<?php
/**
 * H1 and H2 tag
 * *
 *
 * @category class
 * @package  H1 and H2 tag
 * @author   Karthika
 * Created at:  30-Nov-2018
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class H1andh2  extends MX_Controller
{
    function __construct()
	{
		parent::__construct();
		if ( ! $this->session->userdata('logged_in'))
		{
			redirect('login');
		}
		$this->load->model('H1andh2_model');
		$this->load->module('admin_header');
		$this->load->module('color');
    }
   // Get H1 and H2 Text

    function h1andh2_index($page_id)
    {

		$h1andh2_datas	= $this->H1andh2_model->get_h1andh2($page_id);
		if ( ! empty ($h1andh2_datas) )
		{
			foreach ($h1andh2_datas as $h1andh2_data)
			{
				$data['id']	= $h1andh2_data->id;
				$data['h1_tag']	= $h1andh2_data->h1_tag;
				$data['h2_tag']	= $h1andh2_data->h2_tag;
		    }
		}
		else
		{
			$data['id']	= "";
			$data['h1_tag']	= "";
			$data['h2_tag'] = "";
		}

		$data['h1_and_h2_customization'] = $this->H1andh2_model->get_h1_and_h2_customization(
			$this->admin_header->website_id() ,
			$page_id,
			'h1_and_h2'
		);

		if (!empty($data['h1_and_h2_customization']))
		{
			$keys = json_decode($data['h1_and_h2_customization'][0]->key);
			$values = json_decode($data['h1_and_h2_customization'][0]->value);
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

		$data['page_id']  = $page_id;
		$data['heading']  = 'H1 and H2 ';
		$data['title']	  = "H1 and H2 | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('h1andh2_header');
		$this->admin_header->index();
		$this->load->view('add_edit_h1andh2', $data);
		$this->load->view('template/footer_content');
    	$this->load->view('script');
		$this->load->view('template/footer');
	}

	// Insert & Update H1 and H2
	function insert_update_h1andh2()
	{
		$website_id = $this->admin_header->website_id();

		$id	= $this->input->post('id');
		$page_id	= $this->input->post('page-id');
		$continue	= $this->input->post('btn_continue');
		if (empty($id))
		{
			$this->H1andh2_model->insert_update_h1andh2($website_id);
			$this->session->set_flashdata('success', 'h1and h2 successfully Added');
			if (isset($continue) && $continue === "Add & Continue")
			{
				$url = 'h1andh2/h1andh2_index/'.$page_id;
			}
			else
			{
				$url = 'page/page_details/'.$page_id;
			}
		}
		else
		{
			$this->H1andh2_model->insert_update_h1andh2($website_id, $id);
			$this->session->set_flashdata('success', 'h1andh2 Successfully Updated.');
			if (isset($continue) && $continue === "Update & Continue")
			{
				$url = 'h1andh2/h1andh2_index/'.$page_id;
			}
			else
			{
				$url = 'page/page_details/'.$page_id;
			}
		}

		redirect($url);
	}
}
