<?php
/**
 * Text icon
 *
 * @category class
 * @package  Text icon
 * @author   Saravana
 * Created at:  23-Jun-2018
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Text_icon extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        
        $this->load->model('Text_icon_model');
        $this->load->module('admin_header');
        $this->load->module('color');
    }
    
    /**
     * Text Icon Details
     * Display Text Icon Title details
     * Display Text Icon Customization details
     * Display All Text Icons in a table
     */
    function text_icon_index($page_id)
    {
        $data['website_folder_name'] = $this->admin_header->website_folder_name();
        $data['httpUrl']             = $this->admin_header->host_url();
        $data['ImageUrl']            = $this->admin_header->image_url();
        $data['page_id']             = $page_id;
        $data['website_id']          = $this->admin_header->website_id();
        $data['text_icons']          = $this->Text_icon_model->get_text_icon($page_id);
        
        // All Text Icon in a table
        
        $data['table'] = $this->get_table($page_id);
        
        // Get Text Icon details from settings
        
        $data['text_icon_title_data'] = $this->Text_icon_model->get_text_icon_setting_details($this->admin_header->website_id(), $page_id, 'text_icon_title');
        
        // Get Text Icon details from settings
        
        $data['text_icon_customize_data'] = $this->Text_icon_model->get_text_icon_setting_details($this->admin_header->website_id(), $page_id, 'text_icon_customize');
        
        // Text Icon title details from settings
        
        if (!empty($data['text_icon_title_data'])) {
            $keys   = json_decode($data['text_icon_title_data'][0]->key);
            $values = json_decode($data['text_icon_title_data'][0]->value);
            $i      = 0;
            foreach ($keys as $key) {
                $data[$key] = $values[$i];
                $i++;
            }
        } else {
            $data['text_icon_title']          = '';
            $data['text_icon_title_color']    = '';
            $data['text_icon_title_position'] = '';
            $data['text_icon_title_status']   = '';
        }
        
        // Text Icon Customize details from settings
        
        if (!empty($data['text_icon_customize_data'])) {
            $keys   = json_decode($data['text_icon_customize_data'][0]->key);
            $values = json_decode($data['text_icon_customize_data'][0]->value);
            $i      = 0;
            foreach ($keys as $key) {
                $data[$key] = $values[$i];
                $i++;
            }
        } else {
            $data['row_count']            = '';
            $data['component_background'] = '';
            $data['text_icon_background'] = '';
        }
        
        $data['heading'] = 'Text Icon';
        $data['title']   = "Text Icon | Administrator";
        $this->load->view('template/meta_head', $data);
        $this->load->view('text_icon_header');
        $this->admin_header->index();
        $this->load->view('view', $data);
        $this->load->view('template/footer_content');
        $this->load->view('script');
        $this->load->view('template/footer');
    }
    
    // Table
    
    function get_table($page_id)
    {
        $text_icons = $this->Text_icon_model->get_text_icon($page_id);
        foreach ($text_icons as $text_icon) {
            $anchor_edit   = anchor('text_icon/add_edit_text_icon/' . $page_id . '/' . $text_icon->id, '<span class="glyphicon c_edit_icon glyphicon-edit" aria-hidden="true"></span>', array(
                'data-toggle' => 'tooltip',
                'data-placement' => 'left',
                'data-original-title' => 'Edit'
            ));
            $anchor_delete = anchor('text_icon/delete_text_icon/' . $page_id . '/' . $text_icon->id, '<span class="glyphicon c_delete_icon glyphicon-trash" aria-hidden="true"></span>', array(
                'data-toggle' => 'tooltip',
                'data-placement' => 'right',
                'data-original-title' => 'Delete',
                'onclick' => 'return delete_record(' . $text_icon->id . ', \'' . base_url('text_icon/delete_text_icon/' . $page_id) . '\')'
            ));
            $cell          = array(
                'class' => 'last',
                'data' => $anchor_edit . $anchor_delete
            );
            if ($text_icon->status === '1') {
                $status = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
            } else {
                $status = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
            }
            
            if ($text_icon->icon != '') {
                $icon = "<i class='fa $text_icon->icon'></i>";
            } else {
                $icon = '';
            }
            
            $this->table->add_row('<input type="checkbox" class="flat" id="table_records" name="table_records[]" value="' . $text_icon->id . '"><input type="hidden" id="row_sort_order" name="row_sort_order[]" value="' . $text_icon->id . '">', ucwords($text_icon->title), $icon, $text_icon->sort_order, $status, $cell);
        }
        
        // Table open
        
        $template = array(
            'table_open' => '<table
            id="datatable-checkbox"
            class="table table-striped table-bordered dt-responsive nowrap jambo_table bulk_action"
            width="100%" cellspacing="0">',
            'tbody_open' => '<tbody id = "table_row_sortable">'
        );
        $this->table->set_template($template);
        
        // Table heading row
        
        $this->table->set_heading(array(
            '<input type="checkbox" id="check-all" class="flat">',
            'Title',
            'Icon',
            'Sort Order',
            'Status',
            'Action'
        ));
        return $this->table->generate();
    }
    
    /**
     * Update Text Icon Sort Order
     */
    function update_sort_order()
    {
        $page_id        = $this->input->post('sort_id');
        $row_sort_order = $this->input->post('row_sort_order');
        $this->Text_icon_model->update_sort_order($page_id, $row_sort_order);
    }
    
    // Insert & Update Text Icon Title
    
    function insert_update_text_icon_title()
    {
        $page_id = $this->input->post('page-id');
        $this->Text_icon_model->insert_update_text_icon_title_data($page_id);
        redirect('text_icon/text_icon_index/' . $page_id);
    }
    
    // Insert & Update Text Icon Customization
    
    function insert_update_text_icon_customize()
    {
        $page_id = $this->input->post('page-id');
        $this->Text_icon_model->insert_update_text_icon_customize_data($page_id);
        redirect('text_icon/text_icon_index/' . $page_id);
    }
    
    // Add & Edit Text Icon
    
    function add_edit_text_icon($page_id, $id = NULL)
    {
        if ($id != null) {
            $text_icon                      = $this->Text_icon_model->get_text_icon_by_id($page_id, $id);
            $data['text_icon_id']           = $text_icon[0]->id;
            $data['icon']                   = $text_icon[0]->icon;
            $data['icon_color']             = $text_icon[0]->icon_color;
            $data['icon_position']          = $text_icon[0]->icon_position;
            $data['icon_shape']             = $text_icon[0]->icon_shape;
            $data['icon_background_color']  = $text_icon[0]->icon_background_color;
            $data['icon_hover_color']       = $text_icon[0]->icon_hover_color;
            $data['icon_hover_background']  = $text_icon[0]->icon_hover_background;
            $data['icon_title']             = $text_icon[0]->title;
            $data['content']                = $text_icon[0]->content;
            $data['title_color']            = $text_icon[0]->title_color;
            $data['title_position']         = $text_icon[0]->title_position;
            $data['content_title_color']    = $text_icon[0]->content_title_color;
            $data['content_title_position'] = $text_icon[0]->content_title_position;
            $data['content_color']          = $text_icon[0]->content_color;
            $data['content_position']       = $text_icon[0]->content_position;
            $data['redirect']               = $text_icon[0]->redirect;
            $data['redirect_url']           = $text_icon[0]->redirect_url;
            $data['open_new_tab']           = $text_icon[0]->open_new_tab;
            $data['background_hover_color'] = $text_icon[0]->background_hover_color;
            $data['hover_title_color']      = $text_icon[0]->hover_title_color;
            $data['content_title_hover']    = $text_icon[0]->content_title_hover;
            $data['text_hover_color']       = $text_icon[0]->text_hover_color;
            $data['background_color']       = $text_icon[0]->background_color;
            $data['sort_order']             = $text_icon[0]->sort_order;
            $data['status']                 = $text_icon[0]->status;
        } else {
            $data['text_icon_id']           = "";
            $data['icon']                   = "";
            $data['icon_color']             = "";
            $data['icon_position']          = "";
            $data['icon_shape']             = "";
            $data['icon_background_color']  = "";
            $data['icon_hover_color']       = "";
            $data['icon_hover_background']  = "";
            $data['icon_title']             = "";
            $data['content']                = "";
            $data['title_color']            = "";
            $data['title_position']         = "";
            $data['content_title_color']    = "";
            $data['content_title_position'] = "";
            $data['content_color']          = "";
            $data['content_position']       = "";
            $data['redirect']               = "";
            $data['redirect_url']           = "";
            $data['open_new_tab']           = "";
            $data['background_hover_color'] = "";
            $data['hover_title_color']      = "";
            $data['text_hover_color']       = "";
            $data['content_title_hover']    = "";
            $data['background_color']       = "";
            $data['sort_order']             = "";
            $data['status']                 = "";
        }
        
        $data['page_id'] = $page_id;
        $data['title']   = ($id != null) ? 'Edit Text Icon' : 'Add Text Icon' . ' | Administrator';
        $data['heading'] = (($id != null) ? 'Edit' : 'Add') . ' Text Icon';
        $this->load->view('template/meta_head', $data);
        $this->load->view('text_icon_header');
        $this->admin_header->index();
        $this->load->view('add_edit_text_icon', $data);
        $this->load->view('template/footer_content');
        $this->load->view('script');
        $this->load->view('template/footer');
    }
    
    // Insert & Update Text Icon
    
    function insert_update_text_icon()
    {
        $text_icon_id = $this->input->post('text-icon-id');
        $page_id      = $this->input->post('page-id');
        $continue     = $this->input->post('btn_continue');
        $error_config = array(
            array(
                'field' => 'icon',
                'label' => 'Icon',
                'rules' => 'required'
            ),
            array(
                'field' => 'sort_order',
                'label' => 'Sort Order',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($error_config);
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            if (empty($text_icon_id)) {
                redirect('text_icon/add_edit_text_icon/' . $page_id);
            } else {
                redirect('text_icon/add_edit_text_icon/' . $page_id . '/' . $text_icon_id);
            }
        } else {
            if (empty($text_icon_id)) {
                $insert_id = $this->Text_icon_model->insert_update_text_icon_data($page_id);
                $this->session->set_flashdata('success', 'Text Icon successfully Created');
                if (isset($continue) && $continue === "Add & Continue") {
                    $url = 'text_icon/add_edit_text_icon/' . $page_id;
                } else {
                    $url = 'text_icon/text_icon_index/' . $page_id;
                }
            } else {
                $this->Text_icon_model->insert_update_text_icon_data($page_id, $text_icon_id);
                $this->session->set_flashdata('success', 'Text Icon Successfully Updated.');
                if (isset($continue) && $continue === "Update & Continue") {
                    $url = 'text_icon/add_edit_text_icon/' . $page_id . '/' . $text_icon_id;
                } else {
                    $url = 'text_icon/text_icon_index/' . $page_id;
                }
            }
            
            redirect($url);
        }
    }
    
    /**
     * Delete Text Icon
     * Single Record by id
     */
    function delete_text_icon($page_id)
    {
        $this->Text_icon_model->delete_text_icon($page_id);
        $this->session->set_flashdata('success', 'Text Icon Successfully Deleted.');
    }
    
    /**
     * Delete Text Icon
     * Multiple Records by Id's
     */
    function delete_multiple_text_icon()
    {
        $page_id = $this->input->post('page_id');
        $this->form_validation->set_rules('table_records[]', 'Row', 'required', array(
            'required' => 'You must select at least one row!'
        ));
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('text_icon/text_icon_index/' . $page_id);
        } else {
            $this->Text_icon_model->delete_multiple_text_icon_data();
            $this->session->set_flashdata('success', 'Successfully Deleted');
            redirect('text_icon/text_icon_index/' . $page_id);
        }
    }
}