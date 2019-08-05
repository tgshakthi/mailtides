<?php
/**
 * Vertical tab
 *
 * @category class
 * @package  Vertical Tab
 * @author   Velu
 * Created at:  07-dec-2018
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Vertical_tab extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        $this->load->model('Vertical_tab_model');
        $this->load->module('admin_header');
        $this->load->module('color');
    }
    
    // Display all Tab in a table
    function vertical_tab_index($page_id)
    {
        $data['website_folder_name'] = $this->admin_header->website_folder_name();
        $data['httpUrl']             = $this->admin_header->host_url();
        $data['ImageUrl']            = $this->admin_header->image_url();
        
        $data['website_id']              = $this->admin_header->website_id();
        // Get Tab details from settings
        $data['vertical_tab_title_data'] = $this->Vertical_tab_model->get_vertical_tab_setting_details($data['website_id'], $page_id, 'vertical_tab');
        
        // Tab title details from settings
        if (!empty($data['vertical_tab_title_data'])) {
            $keys   = json_decode($data['vertical_tab_title_data'][0]->key);
            $values = json_decode($data['vertical_tab_title_data'][0]->value);
            $i      = 0;
            foreach ($keys as $key) {
                $data[$key] = $values[$i];
                $i++;
            }
        } else {
            $data['tab_title']      = '';
            $data['title_color']    = '';
            $data['title_position'] = '';
            
            $data['component_background']    = '';
            $data['vertical_tab_background'] = '';
            $data['status']                  = '';
        }
        
        $data['page_id'] = $page_id;
        $data['table']   = $this->get_table($page_id);
        $data['heading'] = 'Vertical Tab';
        $data['title']   = "Vertical Tab | Administrator";
        $this->load->view('template/meta_head', $data);
        $this->load->view('vertical_tab_header');
        $this->admin_header->index();
        $this->load->view('view', $data);
        $this->load->view('template/footer_content');
        $this->load->view('script');
        $this->load->view('template/footer');
    }
    
    // Table
    function get_table($page_id)
    {
        $website_id    = $this->admin_header->website_id();
        $vertical_tabs = $this->Vertical_tab_model->get_vertical_tab($website_id, $page_id);
        if (!empty($vertical_tabs)) {
            foreach ($vertical_tabs as $vertical_tab) {
                $anchor_edit = anchor('vertical_tab/add_edit_vertical_tab/' . $page_id . '/' . $vertical_tab->id, '<span class="glyphicon c_edit_icon glyphicon-edit" aria-hidden="true"></span>', array(
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'left',
                    'data-original-title' => 'Edit'
                ));
                
                $anchor_edit_vertical_tab_content = anchor(site_url('vertical_tab/vertical_tab_component/' . $page_id . '/' . $vertical_tab->id), '<span class="glyphicon c_pagecontent_icon glyphicon-duplicate" aria-hidden="true"></span>', array(
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'top',
                    'data-original-title' => 'Edit Vertical Tab Content'
                ));
                
                $anchor_delete = anchor('', '<span class="glyphicon c_delete_icon glyphicon-trash" aria-hidden="true"></span>', array(
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'right',
                    'data-original-title' => 'Delete',
                    'onclick' => 'return delete_record(' . $vertical_tab->id . ', \'' . base_url('vertical_tab/delete_vertical_tab/' . $page_id) . '\')'
                ));
                
                $cell = array(
                    'class' => 'last',
                    'data' => $anchor_edit . $anchor_edit_vertical_tab_content . $anchor_delete
                );
                
                if ($vertical_tab->status === '1') {
                    $status = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
                } else {
                    $status = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
                }
                
                
                $this->table->add_row('<input type="checkbox" class="flat" id="table_records" name="table_records[]" value="' . $vertical_tab->id . '"><input type="hidden" id="row_sort_order" name="row_sort_order[]" value="' . $vertical_tab->id . '">', ucwords($vertical_tab->vertical_tab_name), $vertical_tab->sort_order, $status, $cell);
            }
        }
        
        // Table open
        $template = array(
            'table_open' => '<table
            id="datatable-responsive"
            class="table table-striped table-bordered dt-responsive nowrap jambo_table bulk_action"
            width="100%" cellspacing="0">',
            'tbody_open' => '<tbody id = "table_row_sortable">'
        );
        
        $this->table->set_template($template);
        // Table heading row
        $this->table->set_heading(array(
            '<input type="checkbox" id="check-all" class="flat">',
            'Title',
            'Sort Order',
            'Status',
            'Action'
        ));
        
        return $this->table->generate();
    }
    
    // Insert & Update Tab Title
    
    function insert_update_vertical_tab_title()
    {
        $page_id = $this->input->post('page_id');
        $this->Vertical_tab_model->insert_update_vertical_tab_title($page_id);
        redirect('vertical_tab/vertical_tab_index/' . $page_id);
    }
    
    // Add & Edit Tab
    function add_edit_vertical_tab($page_id, $id = null)
    {
        if ($id != null) {
            $vertical_tab               = $this->Vertical_tab_model->get_vertical_tab_by_id($page_id, $id);
            $data['vertical_tab_id']    = $vertical_tab[0]->id;
            $data['vertical_tab_name']  = $vertical_tab[0]->vertical_tab_name;
            $data['vertical_tab_color'] = $vertical_tab[0]->vertical_tab_color;
            $data['sort_order']         = $vertical_tab[0]->sort_order;
            $data['status']             = $vertical_tab[0]->status;
        } else {
            $data['vertical_tab_id']    = '';
            $data['vertical_tab_name']  = '';
            $data['vertical_tab_color'] = '';
            $data['sort_order']         = '';
            $data['status']             = '';
        }
        
        $data['page_id']    = $page_id;
        $data['website_id'] = $this->admin_header->website_id();
        $data['title']      = ($id != null) ? 'Edit Vertical Tab' : 'Add Vertical Tab' . ' | Administrator';
        $data['heading']    = (($id != null) ? 'Edit' : 'Add') . ' Vertical Tab';
        $this->load->view('template/meta_head', $data);
        $this->load->view('vertical_tab_header');
        $this->admin_header->index();
        $this->load->view('add_edit_vertical_tab', $data);
        $this->load->view('template/footer_content');
        $this->load->view('script');
        $this->load->view('template/footer');
    }
    
    // Insert & Update Tab
    function insert_update_vertical_tab()
    {
        $website_id      = $this->input->post('website_id');
        $vertical_tab_id = $this->input->post('vertical_tab_id');
        $page_id         = $this->input->post('page_id');
        $continue        = $this->input->post('btn_continue');
        
        $error_config = array(
            array(
                'field' => 'vertical_tab_name',
                'label' => 'vertical Tab Name',
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
            if (empty($tab_id)) {
                redirect('vertical_tab/add_edit_vertical_tab/' . $page_id);
            } else {
                redirect('vertical_tab/add_edit_vertical_tab/' . $page_id . '/' . $vertical_tab_id);
            }
        } else {
            if (empty($vertical_tab_id)) {
                $insert_id = $this->Vertical_tab_model->insert_update_vertical_tab($website_id, $page_id);
                $this->session->set_flashdata('success', 'Vertical Tab successfully Created');
                if (isset($continue) && $continue === "Add & Continue") {
                    $url = 'vertical_tab/add_edit_vertical_tab/' . $page_id;
                } else {
                    $url = 'vertical_tab/vertical_tab_index/' . $page_id;
                }
            } else {
                $this->Vertical_tab_model->insert_update_vertical_tab($website_id, $page_id, $vertical_tab_id);
                $this->session->set_flashdata('success', 'vertical Tab Successfully Updated.');
                if (isset($continue) && $continue === "Update & Continue") {
                    $url = 'vertical_tab/add_edit_vertical_tab/' . $page_id . '/' . $vertical_tab_id;
                } else {
                    $url = 'vertical_tab/vertical_tab_index/' . $page_id;
                }
            }
            redirect($url);
        }
    }
    
    // Edit Tab Component
    function vertical_tab_component($page_id, $vertical_tab_id)
    {
        $vertical_tab = $this->Vertical_tab_model->get_vertical_tab_by_id($page_id, $vertical_tab_id);
        
        $data['vertical_tab_name']       = $vertical_tab[0]->vertical_tab_name;
        $data['vertical_tab_components'] = ($vertical_tab[0]->vertical_tab_components != '') ? explode(',', $vertical_tab[0]->vertical_tab_components) : array();
        
        $data['website_id']      = $this->admin_header->website_id();
        $data['page_id']         = $page_id;
        $data['vertical_tab_id'] = $vertical_tab_id;
        $data['heading']         = 'Vertical Tab Content';
        $data['title']           = "Vertical Tab Content | Administrator";
        $this->load->view('template/meta_head', $data);
        $this->load->view('vertical_tab_header');
        $this->admin_header->index();
        $this->load->view('vertical_tab_component', $data);
        $this->load->view('template/footer_content');
        $this->load->view('script');
        $this->load->view('template/footer');
    }
    
    // Insert & Update Tab Content
    function insert_update_vertical_tab_component()
    {
        $website_id      = $this->input->post('website_id');
        $vertical_tab_id = $this->input->post('vertical_tab_id');
        $page_id         = $this->input->post('page_id');
        $continue        = $this->input->post('btn_continue');
        
        $this->Vertical_tab_model->insert_update_vertical_tab_component($website_id, $page_id, $vertical_tab_id);
        $this->session->set_flashdata('success', 'Vertical Tab Successfully Updated.');
        if (isset($continue) && ($continue === "Save & Continue" || $continue === "Update & Continue")) {
            $url = 'vertical_tab/vertical_tab_component/' . $page_id . '/' . $vertical_tab_id;
        } else {
            $url = 'vertical_tab/vertical_tab_index/' . $page_id;
        }
        redirect($url);
    }
    
    //  Tab Text Full Width
    function vertical_tab_text_full_width($page_id, $vertical_tab_id)
    {
        $text_full_width = $this->Vertical_tab_model->get_vertical_tab_text_full_width_by_vertical_tab_id($vertical_tab_id);
        
        if (!empty($text_full_width)) {
            $data['text_full_width_id']     = $text_full_width[0]->id;
            $data['text_full_width_title']  = $text_full_width[0]->title;
            $data['full_text']              = $text_full_width[0]->full_text;
            $data['title_color']            = $text_full_width[0]->title_color;
            $data['title_position']         = $text_full_width[0]->title_position;
            $data['content_title_color']    = $text_full_width[0]->content_title_color;
            $data['content_title_position'] = $text_full_width[0]->content_title_position;
            $data['content_color']          = $text_full_width[0]->content_color;
            $data['content_position']       = $text_full_width[0]->content_position;
            $data['background_color']       = $text_full_width[0]->background_color;
        } else {
            $data['text_full_width_id']     = "";
            $data['text_full_width_title']  = "";
            $data['full_text']              = "";
            $data['title_color']            = "";
            $data['title_position']         = "";
            $data['content_title_color']    = "";
            $data['content_title_position'] = "";
            $data['content_color']          = "";
            $data['content_position']       = "";
            $data['background_color']       = "";
        }
        
        $data['vertical_tab_id'] = $vertical_tab_id;
        $data['page_id']         = $page_id;
        $data['heading']         = 'Vertical Tab Text Full Width';
        $data['title']           = "Vertical Tab Text Full Width | Administrator";
        $this->load->view('template/meta_head', $data);
        $this->load->view('vertical_tab_header');
        $this->admin_header->index();
        $this->load->view('vertical_tab_text_full_width', $data);
        $this->load->view('template/footer_content');
        $this->load->view('script');
        $this->load->view('template/footer');
    }
    
    // Insert & Update Tab Text Full Width
    function insert_update_vertical_tab_text_full_width()
    {
        $text_full_width_id = $this->input->post('text_full_width_id');
        $vertical_tab_id    = $this->input->post('vertical_tab_id');
        $page_id            = $this->input->post('page_id');
        $continue           = $this->input->post('btn_continue');
        
        $error_config = array(
            array(
                'field' => 'full_text',
                'label' => 'Content',
                'rules' => 'required'
            )
        );
        
        $this->form_validation->set_rules($error_config);
        
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('vertical_tab/vertical_tab_text_full_width/' . $page_id . '/' . $vertical_tab_id);
        } else {
            if (empty($text_full_width_id)) {
                $this->Vertical_tab_model->insert_update_vertical_tab_text_full_width();
                $this->session->set_flashdata('success', 'Vertical Tab Text Full Width successfully Added');
            } else {
                $this->Vertical_tab_model->insert_update_vertical_tab_text_full_width($text_full_width_id);
                $this->session->set_flashdata('success', 'Vertical Tab Text Full Width Successfully Updated.');
            }
            if (isset($continue) && ($continue === "Add & Continue" || $continue === "Update & Continue")) {
                $url = 'vertical_tab/vertical_tab_text_full_width/' . $page_id . '/' . $vertical_tab_id;
            } else {
                $url = 'vertical_tab/vertical_tab_component/' . $page_id . '/' . $vertical_tab_id;
            }
            redirect($url);
        }
    }
    
    //  Tab Text Image
    function vertical_tab_text_image($page_id, $vertical_tab_id)
    {
        $data['vertical_tab_id'] = $vertical_tab_id;
        $data['page_id']         = $page_id;
        $data['table']           = $this->get_text_image_table($page_id, $vertical_tab_id);
        $data['heading']         = 'Vertical Tab Text Image';
        $data['title']           = "Vertical Tab Text Image | Administrator";
        $this->load->view('template/meta_head', $data);
        $this->load->view('vertical_tab_header');
        $this->admin_header->index();
        $this->load->view('view_vertical_tab_text_image', $data);
        $this->load->view('template/footer_content');
        $this->load->view('script');
        $this->load->view('template/footer');
    }
    
    // Get Tab Text Image Table
    function get_text_image_table($page_id, $vertical_tab_id)
    {
        $website_folder_name      = $this->admin_header->website_folder_name();
        $ImageUrl                 = $this->admin_header->image_url();
        $vertical_tab_text_images = $this->Vertical_tab_model->get_vertical_tab_text_image($vertical_tab_id);
        if (!empty($vertical_tab_text_images)) {
            foreach ($vertical_tab_text_images as $vertical_tab_text_image) {
                $anchor_edit = anchor('vertical_tab/add_edit_vertical_tab_text_image/' . $page_id . '/' . $vertical_tab_id . '/' . $vertical_tab_text_image->id, '<span class="glyphicon c_edit_icon glyphicon-edit" aria-hidden="true"></span>', array(
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'left',
                    'data-original-title' => 'Edit'
                ));
                
                $anchor_delete = anchor('', '<span class="glyphicon c_delete_icon glyphicon-trash" aria-hidden="true"></span>', array(
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'right',
                    'data-original-title' => 'Delete',
                    'onclick' => 'return delete_record(' . $vertical_tab_text_image->id . ', \'' . base_url('vertical_tab/delete_vertical_tab_text_image/' . $page_id . '/' . $vertical_tab_id) . '\')'
                ));
                
                $cell = array(
                    'class' => 'last',
                    'data' => $anchor_edit . $anchor_delete
                );
                
                if ($vertical_tab_text_image->status === '1') {
                    $status = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
                } else {
                    $status = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
                }
                
                if ($vertical_tab_text_image->image != '') {
                    $vertical_tab_img = $ImageUrl . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR . $vertical_tab_text_image->image;
                    
                    $image = img(array(
                        'src' => $vertical_tab_img,
                        'style' => 'width:145px; height:86px'
                    ));
                } else {
                    $image = img(array(
                        'src' => $ImageUrl . 'images/noimage.png',
                        'style' => 'width:145px; height:86px'
                    ));
                }
                
                $this->table->add_row('<input type="checkbox" class="flat" id="table_records" name="table_records[]" value="' . $vertical_tab_text_image->id . '"><input type="hidden" id="row_sort_order" name="row_sort_order[]" value="' . $vertical_tab_text_image->id . '">', ucwords($vertical_tab_text_image->title), $image, $vertical_tab_text_image->sort_order, $status, $cell);
            }
        }
        
        // Table open
        $template = array(
            'table_open' => '<table
            id="datatable-responsive"
            class="table table-striped table-bordered dt-responsive nowrap jambo_table bulk_action"
            width="100%" cellspacing="0">'
            //'tbody_open' => '<tbody id = "table_row_sortable">'
        );
        
        $this->table->set_template($template);
        // Table heading row
        $this->table->set_heading(array(
            '<input type="checkbox" id="check-all" class="flat">',
            'Title',
            'Image',
            'Sort Order',
            'Status',
            'Action'
        ));
        
        return $this->table->generate();
    }
    
    //  Tab Add Edit Text Image
    function add_edit_vertical_tab_text_image($page_id, $vertical_tab_id, $id = null)
    {
        
        if ($id != null) {
            $text_image = $this->Vertical_tab_model->get_vertical_tab_text_image_by_id($id);
            
            $data['text_image_id']          = $text_image[0]->id;
            $data['text_image_title']       = $text_image[0]->title;
            $data['title_color']            = $text_image[0]->title_color;
            $data['title_position']         = $text_image[0]->title_position;
            $data['text']                   = $text_image[0]->text;
            $data['content_title_color']    = $text_image[0]->content_title_color;
            $data['content_title_position'] = $text_image[0]->content_title_position;
            $data['content_color']          = $text_image[0]->content_color;
            $data['background_color']       = $text_image[0]->background_color;
            $data['image']                  = $text_image[0]->image;
            $data['image_title']            = $text_image[0]->image_title;
            $data['image_alt']              = $text_image[0]->image_alt;
            $data['template']               = $text_image[0]->template;
            $data['image_position']         = $text_image[0]->image_position;
            $data['image_size']             = $text_image[0]->image_size;
            $data['readmore_btn']           = $text_image[0]->readmore_btn;
            $data['button_type']            = $text_image[0]->button_type;
            $data['btn_background_color']   = $text_image[0]->btn_background_color;
            $data['readmore_label']         = $text_image[0]->readmore_label;
            $data['label_color']            = $text_image[0]->label_color;
            $data['readmore_url']           = $text_image[0]->readmore_url;
            $data['open_new_tab']           = $text_image[0]->open_new_tab;
            $data['background_hover']       = $text_image[0]->background_hover;
            $data['text_hover']             = $text_image[0]->text_hover;
            $data['border']                 = $text_image[0]->border;
            $data['border_size']            = $text_image[0]->border_size;
            $data['border_color']           = $text_image[0]->border_color;
            $data['sort_order']             = $text_image[0]->sort_order;
            $data['status']                 = $text_image[0]->status;
        } else {
            $data['text_image_id']          = "";
            $data['text_image_title']       = "";
            $data['title_color']            = "";
            $data['title_position']         = "";
            $data['text']                   = "";
            $data['content_title_color']    = "";
            $data['content_title_position'] = "";
            $data['content_color']          = "";
            $data['background_color']       = "";
            $data['image']                  = "";
            $data['image_title']            = "";
            $data['image_alt']              = "";
            $data['template']               = "";
            $data['image_position']         = "";
            $data['image_size']             = "";
            $data['readmore_btn']           = "";
            $data['button_type']            = "";
            $data['btn_background_color']   = "";
            $data['readmore_label']         = "";
            $data['label_color']            = "";
            $data['readmore_url']           = "";
            $data['open_new_tab']           = "";
            $data['background_hover']       = "";
            $data['text_hover']             = "";
            $data['border']                 = "";
            $data['border_size']            = "";
            $data['border_color']           = "";
            $data['sort_order']             = "";
            $data['status']                 = "";
        }
        
        $data['website_id']          = $this->admin_header->website_id();
        $data['httpUrl']             = $this->admin_header->host_url();
        $data['ImageUrl']            = $this->admin_header->image_url();
        $data['website_folder_name'] = $this->admin_header->website_folder_name();
        $data['page_id']             = $page_id;
        $data['vertical_tab_id']     = $vertical_tab_id;
        $data['heading']             = 'Vertical Tab Text Image';
        $data['title']               = "Vertical Tab Text Image | Administrator";
        $this->load->view('template/meta_head', $data);
        $this->load->view('vertical_tab_header');
        $this->admin_header->index();
        $this->load->view('vertical_tab_text_image', $data);
        $this->load->view('template/footer_content');
        $this->load->view('script');
        $this->load->view('template/footer');
    }
    
    // Insert & Update Tab Text Image
    function insert_update_vertical_tab_text_image()
    {
        $text_image_id   = $this->input->post('text_image_id');
        $vertical_tab_id = $this->input->post('vertical_tab_id');
        $page_id         = $this->input->post('page_id');
        $continue        = $this->input->post('btn_continue');
        
        $error_config = array(
            array(
                'field' => 'sort_order',
                'label' => 'Sort Order',
                'rules' => 'required'
            )
        );
        
        $this->form_validation->set_rules($error_config);
        
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            if (empty($text_image_id)) {
                redirect('vertical_tab/add_edit_vertical_tab_text_image/' . $page_id . '/' . $vertical_tab_id);
            } else {
                redirect('vertical_tab/add_edit_vertical_tab_text_image/' . $page_id . '/' . $vertical_tab_id . '/' . $text_image_id);
            }
        } else {
            if (empty($text_image_id)) {
                $insert_id = $this->Vertical_tab_model->insert_update_vertical_tab_text_image($vertical_tab_id);
                $this->session->set_flashdata('success', 'Text Image successfully Created');
                if (isset($continue) && $continue === "Add & Continue") {
                    $url = 'vertical_tab/add_edit_vertical_tab_text_image/' . $page_id . '/' . $vertical_tab_id;
                } else {
                    $url = 'vertical_tab/vertical_tab_text_image/' . $page_id . '/' . $vertical_tab_id;
                }
            } else {
                $this->Vertical_tab_model->insert_update_vertical_tab_text_image($vertical_tab_id, $text_image_id);
                $this->session->set_flashdata('success', 'Text Image Successfully Updated.');
                if (isset($continue) && $continue === "Update & Continue") {
                    $url = 'vertical_tab/add_edit_vertical_tab_text_image/' . $page_id . '/' . $vertical_tab_id . '/' . $text_image_id;
                } else {
                    $url = 'vertical_tab/vertical_tab_text_image/' . $page_id . '/' . $vertical_tab_id;
                }
            }
            redirect($url);
        }
    }
    
    /**
     * Update Tab Text Image Sort Order
     */
    function update_text_image_sort_order()
    {
        $vertical_tab_id = $this->input->post('sort_id');
        $row_sort_order  = $this->input->post('row_sort_order');
        $this->Vertical_tab->update_text_image_sort_order($vertical_tab_id, $row_sort_order);
    }
    
    /**
     * Update Tab Sort Order
     */
    function update_sort_order()
    {
        $page_id        = $this->input->post('sort_id');
        $row_sort_order = $this->input->post('row_sort_order');
        $this->Vertical_tab_model->update_sort_order($page_id, $row_sort_order);
    }
    
    // Delete Text Image
    function delete_vertical_tab_text_image($page_id, $vertical_tab_id)
    {
        $this->Vertical_tab_model->delete_vertical_tab_text_image($vertical_tab_id);
        $this->session->set_flashdata('success', 'Text Image Successfully Deleted.');
        redirect('vertical_tab/vertical_tab_text_image/' . $page_id . '/' . $vertical_tab_id);
    }
    
    // Delete multiple Tab Text Image
    function delete_multiple_vertical_tab_text_image()
    {
        $page_id         = $this->input->post('page_id');
        $vertical_tab_id = $this->input->post('vertical_tab_id');
        $this->form_validation->set_rules('table_records[]', 'Row', 'required', array(
            'required' => 'You must select at least one row!'
        ));
        
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('vertical_tab/vertical_tab_text_image/' . $page_id . '/' . $vertical_tab_id);
        } else {
            $this->Vertical_tab_model->delete_multiple_vertical_tab_text_image();
            $this->session->set_flashdata('success', 'Successfully Deleted');
            redirect('vertical_tab/vertical_tab_text_image/' . $page_id . '/' . $vertical_tab_id);
        }
    }
    
    // Delete Tab
    function delete_vertical_tab($page_id)
    {
        $this->Vertical_tab_model->delete_vertical_tab($page_id);
        $this->session->set_flashdata('success', 'Successfully Deleted');
        redirect('vertical_tab/vertical_tab_index/' . $page_id);
    }
    
    // Delete multiple Tab
    function delete_multiple_vertical_tab()
    {
        $page_id = $this->input->post('page_id');
        $this->form_validation->set_rules('table_records[]', 'Row', 'required', array(
            'required' => 'You must select at least one row!'
        ));
        
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('vertical_tab/vertical_tab_index/' . $page_id);
        } else {
            $this->Vertical_tab_model->delete_multiple_vertical_tab();
            $this->session->set_flashdata('success', 'Successfully Deleted');
            redirect('vertical_tab/vertical_tab_index/' . $page_id);
        }
    }
    
    // Remove Image
    function remove_image()
    {
        $this->Vertical_tab_model->remove_image();
        echo '1';
    }
}