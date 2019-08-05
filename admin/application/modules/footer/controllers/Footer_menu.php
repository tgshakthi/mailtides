<?php
/**
 * Footer Menu
 *
 * @category class
 * @package  Footer Menu
 * @author   shiva
 * Created at:  07-June-2018
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Footer_menu extends MX_Controller
{
    function __construct()
	{
		parent::__construct();
		if ( ! $this->session->userdata('logged_in'))
		{
			redirect('login');
		}
		$this->load->model('Footer_menu_model');
		$this->load->module('admin_header');
		$this->load->module('color');
    }

    // Add and Edit Menu
    function index()
    {
		$data['website_id']			= $this->admin_header->website_id();
		$data['menus']				= $this->Footer_menu_model->get_menu($data['website_id']);
		$data['selected_menus']		= $this->Footer_menu_model->get_selected_menu($data['website_id']);
		$data['unselected_menus']	= $this->Footer_menu_model->get_unselected_menu($data['website_id']);
	
		
		if(!empty($data['menus']))
			{
				$keys 	= json_decode($data['menus'][0]->key);
				$values = json_decode($data['menus'][0]->value);
				$i = 0;
				foreach($keys as $key)
				{
					$data[$key] = $values[$i];
					$i++;
				}
			}
		else
			{
				$data['column']   = '';
				$data['main_menu_text_color']='';
			    $data['sub_menu_text_color']='';
			    $data['main_menu_hover_color']='';
			    $data['sub_menu_hover_color']='';
				$data['status'] 	= '';
			}
			// echo"<pre>";
			// print_r($data);
			// die;
		$data['heading']	= "Footer Menu";
		$data['title']		= "Footer Menu | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('footer');
		$this->admin_header->index();
		$this->load->view('footer_menu', $data);
		$this->load->view('template/footer_content');
    	$this->load->view('footer_menu_script');
		$this->load->view('template/footer');
	}
	
	// Insert Update Menu
	function insert_update_menu()
	{
		$website_id	= $this->admin_header->website_id();
		$data_array = $this->input->post('output_update');
		$result = json_decode($data_array);
		$menu_one = 0;
		$menu_two = 0;
		$menu_three = 0;
		$menu_four = 0;
		$menu_five = 0;
		
		$this->Footer_menu_model->delete_assign_menu($website_id);
		foreach($result as $var => $value)
		{
			$page_id = $value->id;
			$this->Footer_menu_model->insert_assign_menu($website_id, $page_id, 0, $menu_one);
			if (!empty($value->children))
			{
				foreach($value->children as $vchild)
				{
					$page_id = $vchild->id;
					$parent_id = $value->id;
					$this->Footer_menu_model->insert_assign_menu($website_id, $page_id, $parent_id, $menu_two);
					if (!empty($vchild->children))
					{
					 	foreach ($vchild->children as $vchild1)
					 	{
					 		$page_id = $vchild1->id;
					 		$parent_id = $vchild->id;
					 		$this->Footer_menu_model->insert_assign_menu($website_id, $page_id, $parent_id, $menu_three);
							if (!empty($vchild1->children))
					 		{
					 			foreach ($vchild1->children as $vchild2)
					 			{
					 				$page_id = $vchild2->id;
					 				$parent_id = $vchild1->id;
					 				$this->Footer_menu_model->insert_assign_menu($website_id, $page_id, $parent_id, $menu_four);
									if (!empty($vchild2->children))
					 				{
					 					foreach ($vchild2->children as $vchild3)
					 					{
					 						$page_id = $vchild3->id;
					 						$parent_id = $vchild2->id;
					 						$this->Footer_menu_model->insert_assign_menu($website_id, $page_id, $parent_id, $menu_five);
					 						$menu_five++;
										}
									}
									$menu_four++;
								}
							}
							$menu_three++;
						}
					}
					$menu_two++;
				}
			}
			$menu_one++;
		}
		
		
		

		$website_id	= $this->admin_header->website_id();
		$continue	= $this->input->post('btn_continue');
		
		$menus	= $this->Footer_menu_model->get_menu($website_id);
		
		$this->Footer_menu_model->insert_update_menu($website_id);
		if(empty($menus))
		{
			$this->session->set_flashdata('success', 'Footer Menu successfully Customized');
		}
		else
		{
			$this->session->set_flashdata('success', 'Footer Menu successfully Customized.');
		}
		if (isset($continue) && ($continue === "Update & Continue" || $continue === "Add & Continue"))
		{
			$url = 'footer/footer_menu';
		}
		else
		{
			$url = 'footer';
		}
		
		redirect($url);
	}
}
