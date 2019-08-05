<?php
/**
 * Menu
 *
 * @category class
 * @package  Menu
 * @author   Athi
 * Created at:  30-Apr-2018
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Menu extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('logged_in'))
		{
			redirect('login');
		}

		$this->load->model('Menu_model');
		$this->load->module('admin_header');
		$this->load->module('color');
	}

	// Add and Edit Menu

	function index()
	{
		$data['website_id'] = $this->admin_header->website_id();
		$json_menus = $this->Menu_model->get_menu_data($data['website_id']);
		/**
		 * Just Remove the comments.
		 * It'll work another two more step menu.
		 */
		$menu_list = '';
		$selected_menu = array();
		if (!empty($json_menus)):
			$menus = json_decode($json_menus[0]->menu);
			if (!empty($menus)):
				$menu_list.= '<ol class="dd-list">';
				foreach($menus as $menu):
					$selected_menu[] = $menu->id;
					$parent_title = $this->Menu_model->get_parent_menu($data['website_id'], $menu->id);
					if (!empty($parent_title)):
						$menu_list.= '<li class="dd-item" data-id="' . $menu->id . '">

							<div class="dd-handle">
							' . $parent_title[0]->title . '
							</div>';
						if (!empty($menu->children)):
							$menu_list.= '<ol class="dd-list">';
							foreach($menu->children as $sub_menu):
								$selected_menu[] = $sub_menu->id;
								$sub_menu_title = $this->Menu_model->get_parent_menu($data['website_id'], $sub_menu->id);
								$menu_list.= '<li class="dd-item" data-id="' . $sub_menu->id . '">
											<div class="dd-handle">' . $sub_menu_title[0]->title . '</div>';

								// if (!empty($sub_menu->children)):
								// 	$menu_list.= '<ol class="dd-list">';
								// 	foreach($sub_menu->children as $sub_menu_children):
								// 		$selected_menu[] = $sub_menu_children->id;
								// 		$sub_menu_children_title = $this->Menu_model->get_parent_menu($data['website_id'], $sub_menu_children->id);
								// 		$menu_list.= '<li class="dd-item" data-id="' . $sub_menu_children->id . '">
								// 					<div class="dd-handle">' . $sub_menu_children_title[0]->title . '</div>';
								// 		// if (!empty($sub_menu_children->children)):
								// 		// 	$menu_list.= '<ol class="dd-list">';
								// 		// 	foreach($sub_menu_children->children as $sub_menu_first_children):
								// 		// 		$selected_menu[] = $sub_menu_first_children->id;
								// 		// 		$sub_menu_first_children_title = $this->Menu_model->get_parent_menu($data['website_id'], $sub_menu_first_children->id);
								// 		// 		$menu_list.= '<li class="dd-item" data-id="' . $sub_menu_first_children->id . '">
								// 		// 					<div class="dd-handle">' . $sub_menu_first_children_title[0]->title . '</div></li>';
								// 		// 	endforeach;
								// 		// 	$menu_list.= '</ol>';
								// 		// endif;
								// 		$menu_list.= '</li>';
								// 	endforeach;
								// 	$menu_list.= '</ol>';
								// endif;

								$menu_list.= '</li>';
							endforeach;
							$menu_list.= '</ol>';
						endif;
						$menu_list.= '</li>';
					endif;
				endforeach;
				$menu_list.= '</ol>';
			else:
				$menu_list.= '<div class="dd-empty"></div>';
			endif;
		else:
			$menu_list.= '<div class="dd-empty"></div>';
		endif;
		$data['menu_list'] = $menu_list;
		$data['menus'] = $this->Menu_model->get_menu_setting($data['website_id']);
		$data['unselected_menus'] = $this->Menu_model->get_unselected_menu($data['website_id'], $selected_menu);
		if (!empty($data['menus']))
		{
			$keys = json_decode($data['menus'][0]->key);
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
			$data['menu_position'] = '';
			$data['main_menu_text_color'] = '';
			$data['sub_menu_text_color'] = '';
			$data['main_menu_text_hover_color'] = '';
			$data['sub_menu_text_hover_color'] = '';
			$data['main_menu_bg_color'] = '';
			$data['sub_menu_bg_color'] = '';
			$data['main_menu_bg_hover_color'] = '';
			$data['sub_menu_bg_hover_color'] = '';
			$data['status'] = '';
		}

		$data['heading'] = 'Menu';
		$data['title'] = "Menu | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('header');
		$this->admin_header->index();
		$this->load->view('menu', $data);
		$this->load->view('template/footer_content');
		$this->load->view('menu_script');
		$this->load->view('template/footer');
	}

	// Insert Update Menu

	function insert_update_menu()
	{
		$website_id = $this->admin_header->website_id();
		$data_array = $this->input->post('output_update');
		$continue = $this->input->post('btn_continue');
		$this->Menu_model->insert_menu($website_id, $data_array);
		if (isset($continue) && ($continue === "Update & Continue" || $continue === "Add & Continue"))
		{
			$url = 'header/menu';
		}
		else
		{
			$url = 'header';
		}

		redirect($url);
	}
}