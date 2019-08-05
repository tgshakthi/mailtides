<?php
/**
 * Admin Menu
 *
 * @category class
 * @package  Admin Menu
 * @author   Saravana
 * Created at:  09-Apr-2018
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_menu extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('logged_in'))
		{
			redirect('login');
		}

		$this->load->model('Admin_menu_model');
		$this->load->module('admin_header');
	}

	// Display all Admin Menu in a table

	function index()
	{
		$data['table'] = $this->get_table();
		$data['heading'] = 'Admin Menus';
		$data['title'] = "Admin Menu | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('admin_menu_header');
		$this->admin_header->index();
		$this->load->view('view', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}

	// Table

	function get_table()
	{
		$menus = $this->Admin_menu_model->get_admin_menus();
		if (isset($menus) && $menus != "")
		{
			foreach($menus as $menu)
			{
				$anchor_edit = anchor(
					'admin_menu/add_edit_menu/' . $menu->menu_id,
					'<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>',
					array(
					'data-toggle' => 'tooltip',
					'data-placement' => 'left',
					'data-original-title' => 'Edit'
				));

				$anchor_delete = anchor(
					'',
					'<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>',
					array(
					'data-toggle' => 'tooltip',
					'data-placement' => 'right',
					'data-original-title' => 'Delete',
					'onclick' => 'return delete_record('.$menu->menu_id.', \''.base_url('admin_menu/delete_menu').'\')'
				));

				$cell = array(
					'class' => 'last',
					'data' => $anchor_edit .' '. $anchor_delete
				);
				if ($menu->status === '1')
				{
					$status = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
				}
				else
				{
					$status = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
				}

				if ($menu->menu_icon != "")
				{
					$icon = '<i class="fa ' . $menu->menu_icon . '"></i>';
				}
				else
				{
					$icon = '';
				}

				$this->table->add_row(
					'<input type="checkbox" class="flat" id="table_records" name="table_records[]" value="' . $menu->menu_id . '">',
					ucwords($menu->menu_name) ,
					$icon,
					$status,
					$cell);
			}
		}

		// Table open

		$template = array(
			'table_open' => '<table
			id="datatable-responsive"
			class="table table-striped table-bordered dt-responsive nowrap jambo_table bulk_action"
			width="100%" cellspacing="0">'
		);
		$this->table->set_template($template);

		// Table heading row

		$this->table->set_heading(array(
			'<input type="checkbox" id="check-all" class="flat">',
			'Menu name',
			'Menu Icon',
			'Status',
			'Action'
		));
		return $this->table->generate();
	}

	// Add & Edit Admin menu

	function add_edit_menu($id = null)
	{
		if ($id != null)
		{
			$menu = $this->Admin_menu_model->get_menu_by_id($id);
			$data['menu_id'] = $menu[0]->menu_id;
			$data['menu_name'] = $menu[0]->menu_name;
			$data['menu_icon'] = $menu[0]->menu_icon;
			$data['menu_url'] = $menu[0]->menu_url;
			$data['status'] = $menu[0]->status;
		}
		else
		{
			$data['menu_id'] = '';
			$data['menu_name'] = '';
			$data['menu_icon'] = '';
			$data['menu_url'] = '';
			$data['status'] = '';
		}

		$data['title'] = ($id != null) ? 'Edit Menu' : 'Add Menu' . ' | Administrator';
		$data['heading'] = (($id != null) ? 'Edit' : 'Add') . ' Menu';
		$this->load->view('template/meta_head', $data);
		$this->load->view('admin_menu_header');
		$this->admin_header->index();
		$this->load->view('add_edit_menu', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}

	// Insert & Update Admin Menu

	function insert_update_menu()
	{
		$menu_id = $this->input->post('menu-id');
		$continue = $this->input->post('btn_continue');
		$error_config = array(
			array(
				'field' => 'menu-name',
				'label' => 'Menu Name',
				'rules' => 'required'
			) ,
			array(
				'field' => 'menu-url',
				'label' => 'Menu Url',
				'rules' => 'required'
			)
		);
		$this->form_validation->set_rules($error_config);
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			redirect('admin_menu/add_edit_menu');
		}
		else
		{
			if (empty($menu_id))
			{
				$this->Admin_menu_model->insert_update_menu_data();
				$this->session->set_flashdata('success', 'Admin Menu successfully Created');
				if (isset($continue) && $continue === "Add & Continue")
				{
					$url = 'admin_menu/add_edit_menu';
				}
				else
				{
					$url = 'admin_menu';
				}
			}
			else
			{
				$this->Admin_menu_model->insert_update_menu_data($menu_id);
				$this->session->set_flashdata('success', 'Admin Menu Successfully Updated.');
				if (isset($continue) && $continue === "Update & Continue")
				{
					$url = 'admin_menu/add_edit_menu/' . $menu_id;
				}
				else
				{
					$url = 'admin_menu';
				}
			}

			redirect($url);
		}
	}

	// Delete Admin Menu

	function delete_menu()
	{
		$this->Admin_menu_model->delete_admin_menu();
		$this->session->set_flashdata('success', 'Admin menu Successfully Deleted.');
	}

	// Delete multiple Admin Menu

	function delete_selected_menu()
	{
		$this->form_validation->set_rules('table_records[]', 'Row', 'required', array(
			'required' => 'You must select at least one row!'
		));
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			redirect('admin_menu');
		}
		else
		{
			$this->Admin_menu_model->delete_multiple_menu();
			$this->session->set_flashdata('success', 'Successfully Deleted');
			redirect('admin_menu');
		}
	}

	// Assign Menu

	function assign_menu($user_role_id)
	{
		$data['user_role_id'] = $user_role_id;
		$data['selected_menus'] = $this->Admin_menu_model->get_admin_selected_menu_list($user_role_id);
		$data['unselected_menus'] = $this->Admin_menu_model->get_admin_unselected_menu_list($user_role_id);

		if (empty($data['selected_menus']))
		{
			$data['unselected_menus'] = $this->Admin_menu_model->get_admin_menus();
		}

		$data['heading'] = 'Assign Menus';
		$data['title'] = "Assign Menu | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('admin_menu_header');
		$this->admin_header->index();
		$this->load->view('assign_menu', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('menu_script');
		$this->load->view('template/footer');
	}

	// Insert Assign Menu

	function insert_assign_menu()
	{
		$data_array = $this->input->post('output_update');
		$user_role_id = $this->input->post('user_role_id');
		$this->db->where(array(
			'user_role_id' => $user_role_id
		));
		$this->db->delete('admin_menu_group');
		$result = json_decode($data_array);
		$menu_one = 0;
		$menu_two = 0;
		$menu_three = 0;
		$menu_four = 0;
		$menu_five = 0;
		foreach($result as $var => $value)
		{
			$update_id = $value->id;
			$field_types = array(
				'user_role_id' => $user_role_id,
				'menu_id' => $update_id,
				'parent_id' => '0',
				'sort_order' => $menu_one
			);
			$this->db->insert('admin_menu_group', $field_types);
			if (!empty($value->children))
			{
				foreach($value->children as $vchild)
				{
					$child_update_id = $vchild->id;
					$parent_id = $value->id;
					$field_types_one = array(
						'user_role_id' => $user_role_id,
						'menu_id' => $child_update_id,
						'parent_id' => $parent_id,
						'sort_order' => $menu_two
					);
					$this->db->insert('admin_menu_group', $field_types_one);

					// if (!empty($vchild->children))
					// {
					// 	foreach ($vchild->children as $vchild1)
					// 	{
					// 		$child1_update_id 	= $vchild1->id;
					// 		$parent1_id			= $vchild->id;
					// 		$field_types_two = array(
					// 			'user_role_id'	=> $user_role_id,
					// 			'menu_id'		=> $child1_update_id,
					// 			'parent_id'  	=> $parent1_id,
					// 			'sort_order' 	=> $menu_three
					// 		);
					// 		$this->db->insert('admin_menu_group', $field_types_two);
					// 		if (!empty($vchild1->children))
					// 		{
					// 			foreach ($vchild1->children as $vchild2)
					// 			{
					// 				$child2_update_id 	= $vchild2->id;
					// 				$parent2_id			= $vchild1->id;
					// 				$field_types_three = array(
					// 					'user_role_id'	=> $user_role_id,
					// 					'menu_id'		=> $child2_update_id,
					// 					'parent_id'  	=> $parent2_id,
					// 					'sort_order' 	=> $menu_four
					// 				);
					// 				$this->db->insert('admin_menu_group', $field_types_three);
					// 				if (!empty($vchild2->children))
					// 				{
					// 					foreach ($vchild2->children as $vchild3)
					// 					{
					// 						$child3_update_id 	= $vchild3->id;
					// 						$parent3_id			= $vchild2->id;
					// 						$field_types_four = array(
					// 							'user_role_id'	=> $user_role_id,
					// 							'menu_id'		=> $child3_update_id,
					// 							'parent_id'  	=> $parent3_id,
					// 							'sort_order' 	=> $menu_five
					// 						);
					// 						$this->db->insert('admin_menu_group', $field_types_four);
					// 						$menu_five++;
					// 					}
					// 				}
					// 				$menu_four++;
					// 			}
					// 		}
					// 		$menu_three++;
					// 	}
					// }

					$menu_two++;
				}
			}

			$menu_one++;
		}

		redirect('admin_menu/assign_menu/' . $user_role_id);
	}
}
