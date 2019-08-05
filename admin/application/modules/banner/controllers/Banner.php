<?php
/**
 * Banner
 *
 * @category class
 * @package  Banner
 * @author   Saravana
 * Created at:  24-Apr-2018
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Banner extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        
        $this->load->model('Banner_model');
        $this->load->module('admin_header');
        $this->load->module('color');
        $this->form_validation->CI =& $this;
    }
    
    /**
     * Display all banners in a table
     * get table data from get table method
     */
    
    function banner_index($page_id)
    {
        $data['table']   = $this->get_table($page_id);
        $data['page_id'] = $page_id;
        $data['heading'] = 'Banner';
        $data['title']   = "Banner | Administrator";
        $this->load->view('template/meta_head', $data);
        $this->load->view('banner_header');
        $this->admin_header->index();
        $this->load->view('view', $data);
        $this->load->view('template/footer_content');
        $this->load->view('script');
        $this->load->view('template/footer');
    }
    
    /**
     * Table
     * get all data from model
     * generate data table
     * with multiple delete option
     */
    
    function get_table($page_id)
    {
        $banners             = $this->Banner_model->get_banners($page_id);
        $ImageUrl            = $this->admin_header->image_url();
        $website_folder_name = $this->admin_header->website_folder_name();
        if (!empty($banners)) {
            foreach ($banners as $banner) {
                $anchor_edit = anchor(site_url('banner/add_edit_banner/' . $page_id . '/' . $banner->id), '<span class="glyphicon c_edit_icon glyphicon-edit" aria-hidden="true"></span>', array(
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'left',
                    'data-original-title' => 'Edit'
                ));
                
                $anchor_delete = anchor('', '<span class="glyphicon c_delete_icon glyphicon-trash" aria-hidden="true"></span>', array(
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'right',
                    'data-original-title' => 'Delete',
                    'onclick' => 'return delete_record(' . $banner->id . ', \'' . base_url('banner/delete_banner/' . $page_id) . '\')'
                ));
                
                if ($banner->status === '1') {
                    $status = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
                } else {
                    $status = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
                }
                
                if ($banner->image != '') {
                    $banner_img = $ImageUrl . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR . $banner->image;
                    
                    $image = img(array(
                        'src' => str_ireplace('/images/', '/thumbs/', $banner_img),
                        'style' => 'width:145px; height:86px'
                    ));
                } else {
                    $image = img(array(
                        'src' => $ImageUrl . 'images/noimage.png',
                        'style' => 'width:145px; height:86px'
                    ));
                }
                
                $cell = array(
                    'class' => 'last',
                    'data' => $anchor_edit . ' ' . $anchor_delete
                );
                $this->table->add_row('<input type="checkbox" class="flat" id="table_records" name="table_records[]" value="' . $banner->id . '"><input type="hidden" id="row_sort_order" name="row_sort_order[]" value="' . $banner->id . '">', ucwords($banner->title), $image, $banner->sort_order, $status, $cell);
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
        
        $this->table->set_heading('<input type="checkbox" id="check-all" class="flat">', 'Title', 'Banner Image', 'Sort Order', 'Status', 'Action');
        return $this->table->generate();
    }
    
    /**
     * Add and Edit Banner
     */
    
    function add_edit_banner($page_id, $id = null)
    {
        if ($id != null) {
            $banner = $this->Banner_model->get_bannerby_id($page_id, $id);

            $data['banner_id']            = $banner[0]->id;
            $data['banner_title']         = $banner[0]->title;
            $data['title_color']          = $banner[0]->title_color;
            $data['text']                 = $banner[0]->text;
            $data['text_color']           = $banner[0]->text_color;
            $data['image']                = $banner[0]->image;
            $data['image_alt']            = $banner[0]->image_alt;
            $data['image_title']          = $banner[0]->image_title;
            $data['text_position']        = $banner[0]->text_position;
            $data['bg_transparent_color'] = $banner[0]->background_transparent_color;
            $data['title_font_size']      = $banner[0]->title_font_size;
            $data['title_font_weight']    = $banner[0]->title_font_weight;
            $data['readmore_btn']         = $banner[0]->readmore_btn;
            $data['button_type']          = $banner[0]->button_type;
            $data['button_position']      = $banner[0]->button_position;
            $data['btn_background_color'] = $banner[0]->btn_background_color;
            $data['readmore_label']       = $banner[0]->readmore_label;
            $data['label_color']          = $banner[0]->label_color;
            $data['readmore_url']         = $banner[0]->readmore_url;
            $data['open_new_tab']         = $banner[0]->open_new_tab;
            $data['background_hover']     = $banner[0]->background_hover;
            $data['text_hover']           = $banner[0]->text_hover;
            $data['sort_order']           = $banner[0]->sort_order;
            $data['status']               = $banner[0]->status;
        } else {
            $data['banner_id']            = '';
            $data['banner_title']         = '';
            $data['title_color']          = '';
            $data['text']                 = '';
            $data['text_color']           = '';
            $data['image']                = '';
            $data['image_alt']            = '';
            $data['image_title']          = '';
            $data['text_position']        = '';
            $data['bg_transparent_color'] = '';
            $data['title_font_size']      = '';
            $data['title_font_weight']    = '';
            $data['readmore_btn']         = '';
            $data['button_type']          = '';
            $data['button_position']      = '';
            $data['btn_background_color'] = '';
            $data['readmore_label']       = '';
            $data['label_color']          = '';
            $data['readmore_url']         = '';
            $data['open_new_tab']         = '';
            $data['background_hover']     = '';
            $data['text_hover']           = '';            
            $data['sort_order']           = '';
            $data['status']               = '';
        }
        
        $data['page_id']             = $page_id;
        $data['httpUrl']             = $this->admin_header->host_url();
        $data['ImageUrl']            = $this->admin_header->image_url();
        $data['website_folder_name'] = $this->admin_header->website_folder_name();
        $data['numbers']             = $this->Banner_model->get_numbers();
        $data['heading']             = (($id != null) ? 'Edit Banner' : 'Add Banner');
        $data['title']               = (($id != null) ? 'Edit Banner' : 'Add Banner') . ' | Administrator';
        $this->load->view('template/meta_head', $data);
        $this->load->view('banner_header');
        $this->admin_header->index();
        $this->load->view('add_edit_banner', $data);
        $this->load->view('template/footer_content');
        $this->load->view('script');
        $this->load->view('template/footer');
    }
    
    // Insert & Update Banner
    function insert_update_banner()
    {
        $banner_id    = $this->input->post('banner-id');
        $page_id      = $this->input->post('page-id');
        $continue     = $this->input->post('btn_continue');
        $readmore_btn = $this->input->post('readmore_btn');
        $image        = $this->input->post('image');
        $readmore_btn = (isset($readmore_btn)) ? '1' : '0';
        
        $error_config     = array(
            array(
                'field' => 'image',
                'label' => 'Image',
                //'rules'    => 'required|callback_validate_image'
                'rules' => 'required'
            ),
            array(
                'field' => 'sort_order',
                'label' => 'Sort Order',
                'rules' => 'required'
            )
        );
        $readerror_config = array(
            array(
                'field' => 'readmore_url',
                'label' => 'Readmore URL',
                'rules' => 'required'
            )
        );
        if ($readmore_btn == 1) {
            $error_config = array_merge($error_config, $readerror_config);
        }
        
        $this->form_validation->set_rules($error_config);
        
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            if (empty($banner_id)) {
                redirect('banner/add_edit_banner/' . $page_id);
            } else {
                redirect('banner/add_edit_banner/' . $page_id . '/' . $banner_id);
            }
        } else {
            if (empty($banner_id)) {
                $insert_id = $this->Banner_model->insert_update_banner($page_id);
                $this->session->set_flashdata('success', 'Banner successfully Created');
                if (isset($continue) && $continue === "Add & Continue") {
                    $url = 'banner/add_edit_banner/' . $page_id;
                } else {
                    $url = 'banner/banner_index/' . $page_id;
                }
            } else {
                $this->Banner_model->insert_update_banner($page_id, $banner_id);
                $this->session->set_flashdata('success', 'Banner Successfully Updated.');
                if (isset($continue) && $continue === "Update & Continue") {
                    $url = 'banner/add_edit_banner/' . $page_id . '/' . $banner_id;
                } else {
                    $url = 'banner/banner_index/' . $page_id;
                }
            }
            redirect($url);
        }
    }
    
    // Validate Image
    function validate_image()
    {
        $check     = TRUE;
        $image     = $this->input->post('image');
        $httpUrl   = $this->input->post('httpUrl');
        $image_url = $this->input->post('image_url');
        $image     = str_replace($httpUrl . '/', "", $image);
        list($width, $height) = getimagesize($image_url . $image);
        
        if ($width < 1200 || $height < 400) {
            $this->form_validation->set_message('validate_image', 'Image Should be 1200x400 in Size');
            $check = FALSE;
        }
        
        return $check;
    }
    
    // Delete Banner
    function delete_banner($page_id)
    {
        $this->Banner_model->delete_banner($page_id);
        $this->session->set_flashdata('success', 'Text Image Successfully Deleted.');
        redirect('banner/banner_index/' . $page_id);
    }
    
    // Delete multiple Banner
    function delete_multiple_banner()
    {
        $page_id = $this->input->post('page_id');
        $this->form_validation->set_rules('table_records[]', 'Row', 'required', array(
            'required' => 'You must select at least one row!'
        ));
        
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('banner/banner_index/' . $page_id);
        } else {
            $this->Banner_model->delete_multiple_banner();
            $this->session->set_flashdata('success', 'Successfully Deleted');
            redirect('banner/banner_index/' . $page_id);
        }
    }
    
    // Remove Image
    function remove_image()
    {
        $this->Banner_model->remove_image();
        echo '1';
    }
    
    /**
     * Update Banner Sort Order
     */
    function update_sort_order()
    {
        $page_id        = $this->input->post('sort_id');
        $row_sort_order = $this->input->post('row_sort_order');
        $this->Banner_model->update_sort_order($page_id, $row_sort_order);
    }
    
}