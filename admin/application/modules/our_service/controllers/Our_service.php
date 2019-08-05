<?php
/**
 * Our Service
 *
 * @category class
 * @package  Our Service
 * @author   Saravana
 * Created at:  27-Oct-2018
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class our_service extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        
        $this->load->model('Our_service_model');
        $this->load->module('admin_header');
        $this->load->module('color');
    }
    
    /**
     * Our Service Details
     * Display Our Service Title details
     * Display Our Service Customization details
     * Display All Our Service in a table
     */
    public function our_service_index($page_id)
    {
		$data['website_folder_name'] = $this->admin_header->website_folder_name();
		$data['httpUrl'] = $this->admin_header->host_url();
		$data['ImageUrl'] = $this->admin_header->image_url();
        $data['page_id']    = $page_id;
        $data['website_id'] = $this->admin_header->website_id();
        
        // Get all data in a table
        $data['table'] = $this->get_table($page_id);
        
        // Get Our Service details from settings
        
        $data['our_service_customize_data'] = $this->Our_service_model->get_our_service_setting_details($this->admin_header->website_id(), $page_id, 'our_service_customize');
        
        // Our Service Customize details from settings
        
        if (!empty($data['our_service_customize_data'])) {
            $keys   = json_decode($data['our_service_customize_data'][0]->key);
            $values = json_decode($data['our_service_customize_data'][0]->value);
            $i      = 0;
            foreach ($keys as $key) {
                $data[$key] = $values[$i];
                $i++;
            }
            $data['our_service_customize_data'] = '1';
        } else {
            $data['our_service_customize_data']   = '';
            $data['our_service_title']            = '';
            $data['our_service_title_color']      = '';
            $data['our_service_title_position']   = '';
            $data['our_service_content']          = '';
            $data['our_service_content_color']    = '';
            $data['our_service_content_position'] = '';
            $data['our_service_row_count']        = '';
			$data['component_background'] 		  = '';
			$data['our_service_background'] 	  = '';
            $data['our_service_status']           = '';
        }
        
        $data['heading'] = 'Our Service';
        $data['title']   = "Our Service | Administrator";
        $this->load->view('template/meta_head', $data);
        $this->load->view('our_service_header');
        $this->admin_header->index();
        $this->load->view('view', $data);
        $this->load->view('template/footer_content');
        $this->load->view('script');
        $this->load->view('template/footer');
    }
    
    // Table
    
    function get_table($page_id)
    {
        $ImageUrl            = $this->admin_header->image_url();
        $website_folder_name = $this->admin_header->website_folder_name();
        $our_services        = $this->Our_service_model->get_our_service($page_id);
        if (isset($our_services) && $our_services != "") {
            foreach ($our_services as $our_service) {
                $anchor_edit = anchor('our_service/add_edit_our_service/' . $page_id . '/' . $our_service->id, '<span class="glyphicon c_edit_icon glyphicon-edit" aria-hidden="true"></span>', array(
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'left',
                    'data-original-title' => 'Edit'
                ));
                
                $anchor_delete = anchor('', '<span class="glyphicon c_delete_icon glyphicon-trash" aria-hidden="true"></span>', array(
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'right',
                    'data-original-title' => 'Delete',
                    'onclick' => 'return delete_record(' . $our_service->id . ', \'' . base_url('our_service/delete_our_service/' . $page_id) . '\')'
                ));
                
                $cell = array(
                    'class' => 'last',
                    'data' => $anchor_edit . $anchor_delete
                );
                
                if ($our_service->status === '1') {
                    $status = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
                } else {
                    $status = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
                }
                
                if ($our_service->image != '') {
                    $our_service_img = $ImageUrl . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR . $our_service->image;
                    
                    $image = img(array(
                        'src' => $our_service_img,
                        'style' => 'width:145px; height:86px'
                    ));
                } else {
                    $image = img(array(
                        'src' => $ImageUrl . 'images/noimage.png',
                        'style' => 'width:145px; height:86px'
                    ));
                }
                
                $this->table->add_row('<input type="checkbox" class="flat" id="table_records" name="table_records[]" value="' . $our_service->id . '"><input type="hidden" id="row_sort_order" name="row_sort_order[]" value="' . $our_service->id . '">', ucwords($our_service->title), $image, $our_service->sort_order, $status, $cell);
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
            'Image',
            'Sort Order',
            'Status',
            'Action'
        ));
        return $this->table->generate();
    }
    
    // Insert & Update Our Service Customization
    
    function insert_update_our_service_customize()
    {
        $page_id = $this->input->post('page-id');
        $this->Our_service_model->insert_update_our_service_customize_data($page_id);
        redirect('our_service/our_service_index/' . $page_id);
    }
    
    // Add & Edit Our Service
    
    function add_edit_our_service($page_id, $id = NULL)
    {
        if ($id != null) {
            $our_service               = $this->Our_service_model->get_our_service_by_id($page_id, $id);
            $data['our_service_id']    = $our_service[0]->id;
            $data['image']             = $our_service[0]->image;
            $data['our_service_title'] = $our_service[0]->title;
            $data['title_color']       = $our_service[0]->title_color;
            $data['redirect']          = $our_service[0]->redirect;
            $data['redirect_url']      = $our_service[0]->redirect_url;
            $data['open_new_tab']      = $our_service[0]->open_new_tab;
            $data['sort_order']        = $our_service[0]->sort_order;
            $data['status']            = $our_service[0]->status;
        } else {
            $data['our_service_id']    = '';
            $data['image']             = '';
            $data['our_service_title'] = '';
            $data['title_color']       = '';
            $data['redirect']          = '';
            $data['redirect_url']      = '';
            $data['open_new_tab']      = '';
            $data['sort_order']        = '';
            $data['status']            = '';
        }
        
        $data['page_id']             = $page_id;
        $data['httpUrl']             = $this->admin_header->host_url();
        $data['ImageUrl']            = $this->admin_header->image_url();
        $data['website_folder_name'] = $this->admin_header->website_folder_name();
        $data['title']               = ($id != null) ? 'Edit Our Service' : 'Add Our Service' . ' | Administrator';
        $data['heading']             = (($id != null) ? 'Edit' : 'Add') . ' Our Service';
        $this->load->view('template/meta_head', $data);
        $this->load->view('our_service_header');
        $this->admin_header->index();
        $this->load->view('add_edit', $data);
        $this->load->view('template/footer_content');
        $this->load->view('script');
        $this->load->view('template/footer');
    }
    
    // Insert Update Our Service
    
    function insert_update_our_service()
    {
        $our_service_id   = $this->input->post('our_service_id');
        $page_id          = $this->input->post('page_id');
        $continue         = $this->input->post('btn_continue');
        $redirect         = $this->input->post('redirect');
        $image            = $this->input->post('image');
        $redirect         = (isset($redirect)) ? '1' : '0';
        $error_config     = array(
            array(
                'field' => 'image',
                'label' => 'Image',
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
                'field' => 'redirect_url',
                'label' => 'Redirect URL',
                'rules' => 'required'
            )
        );
        if ($redirect == 1) {
            $error_config = array_merge($error_config, $readerror_config);
        }
        
        $this->form_validation->set_rules($error_config);
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            if (empty($our_service_id)) {
                redirect('our_service/add_edit_our_service/' . $page_id);
            } else {
                redirect('our_service/add_edit_our_service/' . $page_id . '/' . $our_service_id);
            }
        } else {
            if (empty($our_service_id)) {
                $insert_id = $this->Our_service_model->insert_update_our_service_data($page_id);
                $this->session->set_flashdata('success', 'Our Service successfully Created');
                if (isset($continue) && $continue === "Add & Continue") {
                    $url = 'our_service/add_edit_our_service/' . $page_id;
                } else {
                    $url = 'our_service/our_service_index/' . $page_id;
                }
            } else {
                $this->Our_service_model->insert_update_our_service_data($page_id, $our_service_id);
                $this->session->set_flashdata('success', 'Our Service Successfully Updated.');
                if (isset($continue) && $continue === "Update & Continue") {
                    $url = 'our_service/add_edit_our_service/' . $page_id . '/' . $our_service_id;
                } else {
                    $url = 'our_service/our_service_index/' . $page_id;
                }
            }
            
            redirect($url);
        }
    }
    
    // Delete Our Service
    
    function delete_our_service($page_id)
    {
        $this->Our_service_model->delete_our_service($page_id);
        $this->session->set_flashdata('success', 'Successfully Deleted');
    }
    
    // Delete multiple Our Service
    
    function delete_multiple_our_service()
    {
        $page_id = $this->input->post('page_id');
        $this->form_validation->set_rules('table_records[]', 'Row', 'required', array(
            'required' => 'You must select at least one row!'
        ));
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('our_service/our_service_index/' . $page_id);
        } else {
            $this->Our_service_model->delete_multiple_our_service_data();
            $this->session->set_flashdata('success', 'Successfully Deleted');
            redirect('our_service/our_service_index/' . $page_id);
        }
    }
    
    // Remove Image
    
    function remove_image()
    {
        $this->Our_service_model->remove_image();
        echo '1';
    }
    
    /**
     * Update Our Service Sort Order
     */
    function update_sort_order()
    {
        $page_id        = $this->input->post('sort_id');
        $row_sort_order = $this->input->post('row_sort_order');
        $this->Our_service_model->update_sort_order($page_id, $row_sort_order);
    }
}