<?php
/**
 * Map
 *
 * @category class
 * @package  Map
 * @author   Karthika
 * Created at:  30-Nov-2018
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Map extends MX_Controller {
    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        $this->load->model('Map_model');
        $this->load->module('admin_header');
        $this->load->module('color');
    }
    // Get Map
    function map_index($page_id) {
        $data['website_folder_name'] = $this->admin_header->website_folder_name();
        $data['httpUrl'] = $this->admin_header->host_url();
        $data['ImageUrl'] = $this->admin_header->image_url();
        $data['page_id'] = $page_id;
        $data['website_id'] = $this->admin_header->website_id();
        $data['map_title_data'] = $this->Map_model->get_map_setting_details($this->admin_header->website_id(), $page_id, 'map_title');
        // Map title details from settings
        if (!empty($data['map_title_data'])) {
            $keys = json_decode($data['map_title_data'][0]->key);
            $values = json_decode($data['map_title_data'][0]->value);
            $i = 0;
            foreach ($keys as $key) {
                $data[$key] = $values[$i];
                $i++;
            }
        } else {
            $data['map_title'] = '';
            $data['map_title_color'] = '';
            $data['map_title_position'] = '';
            $data['map_title_status'] = '';
        }
        // Get Map details from settings
        $data['map_customize_data'] = $this->Map_model->get_map_setting_details($this->admin_header->website_id(), $page_id, 'map_customize');
        // Map Customize details from settings
        if (!empty($data['map_customize_data'])) {
            $keys = json_decode($data['map_customize_data'][0]->key);
            $values = json_decode($data['map_customize_data'][0]->value);
            $i = 0;
            foreach ($keys as $key) {
                $data[$key] = $values[$i];
                $i++;
            }
        } else {
            $data['row_count'] = '';
            $data['component_background'] = '';
            $data['map_background'] = '';
        }
        $data['table'] = $this->get_table($page_id);
        $data['heading'] = 'Map';
        $data['title'] = "Map | Administrator";
        $this->load->view('template/meta_head', $data);
        $this->load->view('map_header');
        $this->admin_header->index();
        $this->load->view('view', $data);
        $this->load->view('template/footer_content');
        $this->load->view('script');
        $this->load->view('template/footer');
    }
    // Table
    function get_table($page_id) {
        $maps = $this->Map_model->get_map($page_id);
        if (isset($maps) && $maps != "") {
            foreach ($maps as $map) {
                $anchor_edit = anchor('map/add_edit_map/' . $page_id . '/' . $map->id, '<span class="glyphicon c_edit_icon glyphicon-edit" aria-hidden="true"></span>', array('data-toggle' => 'tooltip', 'data-placement' => 'left', 'data-original-title' => 'Edit'));
                $anchor_delete = anchor('', '<span class="glyphicon c_delete_icon glyphicon-trash" aria-hidden="true"></span>', array('data-toggle' => 'tooltip', 'data-placement' => 'right', 'data-original-title' => 'Delete', 'onclick' => 'return delete_record(' . $map->id . ', \'' . base_url('map/delete_map/' . $page_id) . '\')'));
                $cell = array('class' => 'last', 'data' => $anchor_edit . $anchor_delete);
                if ($map->status === '1') {
                    $status = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
                } else {
                    $status = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
                }
                $this->table->add_row('<input type="checkbox" class="flat" id="table_records" name="table_records[]" value="' . $map->id . '"><input type="hidden" id="row_sort_order" name="row_sort_order[]" value="' . $map->id . '">', $map->title, $map->address, $status, $cell);
            }
        }
        // Table open
        $template = array('table_open' => '<table
				id="datatable-checkbox"
				class="table table-striped table-bordered dt-responsive nowrap jambo_table bulk_action"
				width="100%" cellspacing="0">', 'tbody_open' => '<tbody id = "table_row_sortable">');
        $this->table->set_template($template);
        // Table heading row
        $this->table->set_heading(array('<input type="checkbox" id="check-all" class="flat">', 'Title', 'address', 'Status', 'Action'));
        return $this->table->generate();
    }
    // add & edit map
    function add_edit_map($page_id, $id = null) {
        if ($id != null) {
            $map = $this->Map_model->get_map_by_id($page_id, $id);
            $customize_data = json_decode($map[0]->customization);
            $data['id'] = $map[0]->id;
            $data['image'] = $map[0]->image;
            $data['map_title'] = $map[0]->title;
            $data['address'] = $map[0]->address;
            $data['title_color'] = $customize_data->title_color;
            $data['title_position'] = $customize_data->title_position;
            $data['address_color'] = $customize_data->address_color;
            $data['address_position'] = $customize_data->address_position;
            $data['map_position'] = $customize_data->map_position;
            $data['background_color'] = $customize_data->background_color;
            $data['sort_order'] = $map[0]->sort_order;
            $data['status'] = $map[0]->status;
        } else {
            $data['id'] = "";
            $data['image'] = "";
            $data['map_title'] = "";
            $data['address'] = "";
            $data['sort_order'] = "";
            $data['status'] = "";
            $data['title_color'] = "";
            $data['title_position'] = "";
            $data['address_color'] = "";
            $data['address_position'] = "";
            $data['map_position'] = "";
            $data['background_color'] = "";
        }

        $data['website_folder_name'] = $this->admin_header->website_folder_name();
        $data['httpUrl']             = $this->admin_header->host_url();
        $data['ImageUrl']            = $this->admin_header->image_url();        
        $data['website_id']          = $this->admin_header->website_id();
        $data['page_id'] = $page_id;
        $data['title'] = ($id != null) ? 'Edit Map' : 'Add Map' . ' | Administrator';
        $data['heading'] = (($id != null) ? 'Edit' : 'Add') . ' Map';
        $this->load->view('template/meta_head', $data);
        $this->load->view('map_header');
        $this->admin_header->index();
        $this->load->view('add_edit_map', $data);
        $this->load->view('template/footer_content');
        $this->load->view('script');
        $this->load->view('template/footer');
    }
    // Insert & Update map
    function insert_update_map() {
        $id = $this->input->post('id');
        $page_id = $this->input->post('page-id');
        $continue = $this->input->post('btn_continue');
        $error_config = array(array('field' => 'address', 'label' => 'address', 'rules' => 'required'));
        $this->form_validation->set_rules($error_config);
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            if (empty($text_image_id)) {
                redirect('map/add_edit_map/' . $page_id);
            } else {
                redirect('map/add_edit_map/' . $page_id . '/' . $id);
            }
        } else {
            if (empty($id)) {
                $this->Map_model->insert_update_map();
                $this->session->set_flashdata('success', 'Address successfully Added');
                if (isset($continue) && $continue === "Add & Continue") {
                    $url = 'map/add_edit_map/' . $page_id;
                } else {
                    $url = 'map/map_index/' . $page_id;
                }
            } else {
                $this->Map_model->insert_update_map($id);
                $this->session->set_flashdata('success', 'Address Successfully Updated.');
                if (isset($continue) && $continue === "Update & Continue") {
                    $url = 'map/add_edit_map/' . $page_id . '/' . $id;
                } else {
                    $url = 'map/map_index/' . $page_id;
                }
            }
            redirect($url);
        }
    }
    // Delete Map
    function delete_map($page_id) {
        $this->Map_model->delete_map($page_id);
        $this->session->set_flashdata('success', 'Address Successfully Deleted.');
    }
    // Delete multiple map
    function delete_multiple_map() {
        $page_id = $this->input->post('page_id');
        $this->form_validation->set_rules('table_records[]', 'Row', 'required', array('required' => 'You must select at least one row!'));
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('map/map_index/' . $page_id);
        } else {
            $this->Map_model->delete_multiple_map();
            $this->session->set_flashdata('success', ' Address Successfully Deleted');
            redirect('map/map_index/' . $page_id);
        }
    }
    // Insert Update Map Title
    function insert_update_map_title() {
        $page_id = $this->input->post('page-id');
        $this->Map_model->insert_update_map_title_data($page_id);
        redirect('map/map_index/' . $page_id);
    }
    // Insert & Update Map Customization
    function insert_update_map_customize() {
        $page_id = $this->input->post('page-id');
        $this->Map_model->insert_update_map_customize_data($page_id);
        redirect('map/map_index/' . $page_id);
    }
}
