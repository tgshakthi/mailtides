<?php
/**
 * Counter
 * Created at : 29-Oct-2018
 * Author : Velu
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Counter extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        $this->load->model('Counter_model');
        $this->load->module('admin_header');
        $this->load->module('color');
    }
    
    // Counter 
    
    function counter_index($page_id)
    {
        $data['page_id']             = $page_id;
        $data['table']               = $this->get_table($page_id);
        $data['numbers']             = $this->Counter_model->get_numbers();
        $data['heading']             = 'Counter';
        $data['title']               = "Counter | Administrator";
        $data['website_id']          = $this->admin_header->website_id();
        $data['httpUrl']             = $this->admin_header->host_url();
        $data['ImageUrl']            = $this->admin_header->image_url();
        $data['website_folder_name'] = $this->admin_header->website_folder_name();
        $counter_image               = $this->Counter_model->get_setting_counter($data['page_id'], $data['website_id'], 'counter_image');
        
        if (!empty($counter_image)):
            $keys   = json_decode($counter_image[0]->key);
            $values = json_decode($counter_image[0]->value);
            $i      = 0;
            foreach ($keys as $key):
                $data[$key] = $values[$i];
                $i++;
            endforeach;
        else:
            $data['counter_title_customize']             = "";
            $data['counter_title_color_customize']       = "";
            $data['counter_title_position_customize']    = "";
            $data['counter_title_font_size_customize']   = "";
            $data['counter_title_font_weight_customize'] = "";
            $data['counter_title_status_customize']      = "";
            $data['component_background']                = "";
            $data['counter_background']                  = "";
        endif;
        
        $this->load->view('template/meta_head', $data);
        $this->load->view('counter_header');
        $this->admin_header->index();
        $this->load->view('view', $data);
        $this->load->view('template/footer_content');
        $this->load->view('script');
        $this->load->view('template/footer');
    }
    
    // Get Datatable
    function get_table($page_id)
    {
        $counters = $this->Counter_model->get_counter($page_id);
        if (!empty($counters)) {
            foreach ($counters as $counter) {
                $anchor_edit   = anchor('counter/add_edit_counter/' . $page_id . '/' . $counter->id, '<span class="glyphicon c_edit_icon glyphicon-edit" aria-hidden="true"></span>', array(
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'left',
                    'data-original-title' => 'Edit'
                ));
                $anchor_delete = anchor('', '<span class="glyphicon c_delete_icon glyphicon-trash" aria-hidden="true"></span>', array(
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'right',
                    'data-original-title' => 'Delete',
                    'onclick' => 'return delete_record(' . $counter->id . ', \'' . base_url('counter/delete_counter/' . $page_id) . '\')'
                ));
                // Status
                if ($counter->status === '1') {
                    $status = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
                } else {
                    $status = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
                }
                $cell = array(
                    'class' => 'last',
                    'data' => $anchor_edit . ' ' . $anchor_delete
                );
                
                $this->table->add_row('<input type="checkbox" class="flat" id="table_records" name="table_records[]" value="' . $counter->id . '">', $counter->count_number, $counter->counter_title, $status, $cell);
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
        $this->table->set_heading('<input type="checkbox" id="check-all" class="flat">', 'Count Number', 'Counter Title', 'status', 'Action');
        return $this->table->generate();
    }
    //Insert update Counter
    function insert_update_counter()
    {
        $counter_id = $this->input->post('counter_id');
        $page_id    = $this->input->post('page_id');
        $continue   = $this->input->post('btn_continue');
        
        $error_config = array(
            array(
                'field' => 'count_number',
                'label' => 'Count Number',
                'rules' => 'required'
            ),
            array(
                'field' => 'counter_icon',
                'label' => 'Counter Icon',
                'rules' => 'required'
            )
        );
        
        $this->form_validation->set_rules($error_config);
        
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            if (empty($counter_id)) {
                redirect('counter/add_edit_counter/' . $page_id);
            } else {
                redirect('counter/add_edit_counter/' . $page_id . '/' . $counter_id);
            }
        } else {
            if (empty($counter_id)) {
                $insert_id = $this->Counter_model->insert_update_counter($page_id);
                $this->session->set_flashdata('success', 'Text Image successfully Created');
                if (isset($continue) && $continue === "Add & Continue") {
                    $url = 'counter/add_edit_counter/' . $page_id . '/' . $counter_id;
                } else {
                    $url = 'counter/counter_index/' . $page_id;
                }
            } else {
                $this->Counter_model->insert_update_counter($page_id, $counter_id);
                $this->session->set_flashdata('success', 'Counter Successfully Updated.');
                if (isset($continue) && $continue === "Update & Continue") {
                    $url = 'counter/add_edit_counter/' . $page_id . '/' . $counter_id;
                } else {
                    $url = 'counter/counter_index/' . $page_id;
                }
            }
            redirect($url);
        }
    }

    //Insert update background image
    function insert_update_counter_image()
    {
        $page_id = $this->input->post('page_id');
        $this->Counter_model->insert_update_counter_image();
        redirect('counter/counter_index/' . $page_id);
    }
    
    //Add Edit Background image
    function add_edit_counter($page_id, $id = null)
    {
        if ($id != null) {
            $counters                    = $this->Counter_model->get_counter_by_id($page_id, $id);
            $data['counter_id']          = $counters[0]->id;
            $data['count_number']        = $counters[0]->count_number;
            $data['count_number_color']  = $counters[0]->count_number_color;
            $data['counter_title']       = $counters[0]->counter_title;
            $data['counter_title_color'] = $counters[0]->counter_title_color;
            $data['counter_icon']        = $counters[0]->counter_icon;
            $data['counter_icon_color']  = $counters[0]->counter_icon_color;
            $data['status']              = $counters[0]->status;
        } else {
            $data['counter_id']          = "";
            $data['count_number']        = "";
            $data['count_number_color']  = "";
            $data['counter_title']       = "";
            $data['counter_title_color'] = "";
            $data['counter_icon']        = "";
            $data['counter_icon_color']  = "";
            $data['status']              = "";
        }
        $data['page_id'] = $page_id;
        $data['title']   = ($id != null) ? 'Edit Counter' . ' | Administrator' : 'Add Counter' . ' | Administrator';
        $data['heading'] = (($id != null) ? 'Edit' : 'Add') . ' Counter';
        $this->load->view('template/meta_head', $data);
        $this->load->view('counter_header');
        $this->admin_header->index();
        $this->load->view('add_edit_counter', $data);
        $this->load->view('template/footer_content');
        $this->load->view('script');
        $this->load->view('template/footer');
    }

    //Delete Counter
    function delete_counter($page_id)
    {
        $this->Counter_model->delete_counter($page_id);
        $this->session->set_flashdata('success', 'Text Image Successfully Deleted.');
        redirect('counter/counter_index/' . $page_id);
    }
    
    // Delete multiple Counter
    function delete_multiple_counter()
    {
        $page_id = $this->input->post('page_id');
        $this->form_validation->set_rules('table_records[]', 'Row', 'required', array(
            'required' => 'You must select at least one row!'
        ));
        
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('counter/counter_index/' . $page_id);
        } else {
            $this->Counter_model->delete_multiple_counter();
            $this->session->set_flashdata('success', 'Successfully Deleted');
            redirect('counter/counter_index/' . $page_id);
        }
    }
}