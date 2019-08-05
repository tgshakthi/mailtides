<?php
/**
 * Copyrights
 *
 * @category class
 * @package  Copyrights
 * @author   Shiva
 * Created at:  14-June-2018
 */

defined('BASEPATH') OR exit('No direct script access allowed');
class Copyrights extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('logged_in'))
		{
			redirect('login');
		}

		$this->load->model('Copyrights_model');
		$this->load->module('admin_header');
		
		$this->load->module('color');
		$this->form_validation->CI =& $this;
	}

	/**
	 * Footer Copyrights Details
	 * get table data from get table method
	 */

	function index()
	{
		$data['website_id']	= $this->admin_header->website_id();
		 
	
		$data['copyrights_details']    = $this->Copyrights_model->get_copyrights_details($data['website_id'],'footer-copyrights');
		
		
		if(!empty($data['copyrights_details']))
			{
				$keys 	= json_decode($data['copyrights_details'][0]->key);
				$values = json_decode($data['copyrights_details'][0]->value);
				$i = 0;
				foreach($keys as $key)
				{
					$data[$key] = $values[$i];
					$i++;
				}
			}
		else
			{
				$data['copyrights_content']   = '';
				$data['copyrights_text_color']='';
			    $data['copyrights_bg_color']='';
			    $data['copyright_status']='';
			}
		
		$data['heading'] 		= 'Copyrights';
		$data['title'] 			= "Copyrights | Administrator";
		
		$data['ImageUrl']		= $this->admin_header->image_url();
		$data['httpUrl']	= $this->admin_header->host_url();
		$this->load->view('template/meta_head', $data);
		$this->load->view('copyrights_header');
		$this->admin_header->index();
		$this->load->view('footer_copyrights', $data);
		$this->load->view('template/footer_content');
		$this->load->view('copyrights_script');
		$this->load->view('template/footer');
	}


	/**
	 *	Copyrights insert and Update
	 *  get table data from get table method
	 */

	function insert_update_copyrights()
	{
		$continue	= $this->input->post('btn_continue');
		
		$this->Copyrights_model->insert_update_copyrights();
		
		
		if (isset($continue) && ($continue === "Add & Continue"))
		{
			$this->session->set_flashdata('success', 'Footer Copyrights Successfully Added.');
			$url = 'footer/copyrights';
		}
		else if(isset($continue) && ($continue === "Update & Continue"))
		{
			$this->session->set_flashdata('success', 'Footer Copyrights Successfully Updated.');
			$url = 'footer/copyrights';			
		}
		else
		{
			$url = 'footer';
		}


			redirect($url);

	}


}
