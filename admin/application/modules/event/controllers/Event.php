<?php
/**
 * Event
 *
 * @category class
 * @package  Event
 * @author   Athi
 * Created at:  1-Aug-2018
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Event extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->session_data = $this->session->userdata('logged_in');
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        $this->load->model('Event_model');
        $this->load->module('admin_header');
        $this->load->module('color');
        $this->load->helper('text');
    }
    
    /**
     * Display all Events in a table
     * get table data from get table method
     */
    
    function index()
    {
        $data['website_id'] = $this->admin_header->website_id();
        $data['table']      = $this->get_table($data['website_id']);
        
        $data['heading'] = 'Event';
        $data['title']   = "Event | Administrator";
        $this->load->view('template/meta_head', $data);
        $this->load->view('event_header');
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
    
    function get_table($website_id)
    {
        $events              = $this->Event_model->get_event($website_id);
        $ImageUrl            = $this->admin_header->image_url();
        $website_folder_name = $this->admin_header->website_folder_name();
        if (!empty($events)) {
            foreach ($events as $event) {
                $anchor_edit = anchor(site_url('event/add_edit_event/' . $event->id), '<span class="glyphicon c_edit_icon glyphicon-edit" aria-hidden="true"></span>', array(
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'left',
                    'data-original-title' => 'Edit'
                ));
                
                $anchor_delete = anchor('', '<span class="glyphicon c_delete_icon glyphicon-trash" aria-hidden="true"></span>', array(
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'right',
                    'data-original-title' => 'Delete',
                    'onclick' => 'return delete_record(' . $event->id . ', \'' . base_url('event/delete_event') . '\')'
                ));
                
                if ($event->status === '1') {
                    $status = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
                } else {
                    $status = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
                }
                
                if ($event->image != '') {
                    $event_image = $ImageUrl . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR . $event->image;
                    
                    $image = img(array(
                        'src' => $event_image,
                        'style' => 'width:145px; height:86px'
                    ));
                } else {
                    $image = img(array(
                        'src' => $ImageUrl . 'images/no-logo.png',
                        'style' => 'width:145px; height:86px'
                    ));
                }
                
                $cell = array(
                    'class' => 'last',
                    'data' => $anchor_edit . ' ' . $anchor_delete
                );
                $this->table->add_row('<input type="checkbox" class="flat" id="table_records" name="table_records[]" value="' . $event->id . '"><input type="hidden" id="row_sort_order" name="row_sort_order[]" value="' . $event->id . '">', ucwords($event->name), ucwords($event->title), $image, $event->sort_order, $status, $cell);
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
        
        $this->table->set_heading('<input type="checkbox" id="check-all" class="flat">', 'Category', 'Title', 'Image', 'Sort Order', 'Status', 'Action');
        return $this->table->generate();
    }
    
    // Event Page
    function event_page($page_id)
    {
        $data['page_id']             = $page_id;
        $data['website_id']          = $this->admin_header->website_id();
        $data['website_folder_name'] = $this->admin_header->website_folder_name();
        $data['httpUrl']             = $this->admin_header->host_url();
        $data['ImageUrl']            = $this->admin_header->image_url();
        
        $data['events_unselected']           = $this->Event_model->get_event_unselected($data['website_id'], $page_id);
        $data['events_selected']             = $this->Event_model->get_event_selected($data['website_id'], $page_id);
        $data['event_categories_unselected'] = $this->Event_model->get_event_category_unselected($data['website_id'], $page_id);
        $data['event_categories_selected']   = $this->Event_model->get_event_category_selected($data['website_id'], $page_id);
        $review_components = $this->Event_model->get_review_setting($data['website_id'], 'event_review_component', $page_id);
       
        $event_pages = $this->Event_model->get_event_page_by_id($data['website_id'], $page_id);
        if (!empty($event_pages)) {
            ($event_pages[0]->event_id == '') ? $data['events_unselected'] = $this->Event_model->get_event($data['website_id']) : '';
            ($event_pages[0]->event_category == '') ? $data['event_categories_unselected'] = $this->Event_model->get_event_category($data['website_id']) : '';
            
            $data['event_id']       = $event_pages[0]->id;
            $data['show_event']     = $event_pages[0]->event;
            $data['event_title']    = $event_pages[0]->title;
            $data['title_color']    = $event_pages[0]->title_color;
            $data['title_position'] = $event_pages[0]->title_position;
            $data['event_per_row']  = $event_pages[0]->event_per_row;
            $data['background']     = $event_pages[0]->background;
            $data['status']         = $event_pages[0]->status;
        } else {
            $data['events_unselected']           = $this->Event_model->get_event($data['website_id']);
            $data['event_categories_unselected'] = $this->Event_model->get_event_category($data['website_id']);
            
            $data['event_id']       = '';
            $data['show_event']     = '';
            $data['event_title']    = '';
            $data['title_color']    = '';
            $data['title_position'] = '';
            $data['event_per_row']  = '';
            $data['background']     = '';
            $data['status']         = '';
        }
        if (!empty($data['background'])):
            $event_bg                     = json_decode($data['background']);
            $data['component_background'] = $event_bg->component_background;
            $data['event_background']     = $event_bg->event_background;
        else:
            $data['component_background'] = "";
            $data['event_background']     = "";
        endif;
        if (!empty($review_components))
		{
			$keys = json_decode($review_components[0]->key);
			$values = json_decode($review_components[0]->value);
			$i=0;
			foreach($keys as $key)
			{
			  $data[$key] = $values[$i];
			  $i++;	
			}
	
		}
		else
		{
			$data['event_review_component']= '';
			$data['event_review_title']='';
			$data['event_review_title_color']='';
			$data['event_review_bg_color']='';
		}
       
        $data['heading'] = 'Event Page';
        $data['title']   = "Event Page | Administrator";
        $this->load->view('template/meta_head', $data);
        $this->load->view('event_header');
        $this->admin_header->index();
        $this->load->view('event_page', $data);
        $this->load->view('template/footer_content');
        $this->load->view('script');
        $this->load->view('template/footer');
    }
    
    /**
     * Update Event Sort Order
     */
    function update_sort_order()
    {
        $website_id     = $this->input->post('sort_id');
        $row_sort_order = $this->input->post('row_sort_order');
        $this->Event_model->update_sort_order($website_id, $row_sort_order);
    }
    
    /**
     * Add and Edit Event
     */
    
    function add_edit_event($id = null)
    {
        $data['website_id'] = $this->admin_header->website_id();
        if ($id != null) {
            $event = $this->Event_model->get_event_by_id($id);
            
            $data['event_id']                            = $event[0]->id;
            $data['category']                            = $event[0]->category_id;
            $data['event_title']                         = $event[0]->title;
            $data['title_color']                         = $event[0]->title_color;
            $data['title_hover_color']                   = $event[0]->title_hover_color;
            $data['title_position']                      = $event[0]->title_position;
            $data['image']                               = $event[0]->image;
            $data['image_title']                         = $event[0]->image_title;
            $data['image_alt']                           = $event[0]->image_alt;
            $data['short_description']                   = $event[0]->short_description;
           //$data['short_description_title_color']       = $event[0]->short_description_title_color;
          // $data['short_description_title_position']    = $event[0]->short_description_title_position;
            $data['short_description_color']             = $event[0]->short_description_color;
            $data['short_description_position']          = $event[0]->short_description_position;
            //$data['short_description_title_hover_color'] = $event[0]->short_description_title_hover_color;
         $data['short_description_hover_color']       = $event[0]->short_description_hover_color;
            $data['description']                         = $event[0]->description;
           // $data['description_title_color']            =$event[0]->description_title_color;
           // $data['description_title_position']          = $event[0]->description_title_position;
            $data['description_color']                   = $event[0]->description_color;
            $data['description_position']                = $event[0]->description_position;
            //$data['description_title_hover_color']       = $event[0]->description_title_hover_color;
            $data['description_hover_color']             = $event[0]->description_hover_color;
            $data['create_date']                         = $event[0]->date;
            $data['date_color']                          = $event[0]->date_color;
            $data['location']                            = $event[0]->location;
            $data['location_color']                      = $event[0]->location_color;
            $data['date_hover']                          = $event[0]->date_hover;
            $data['location_hover']                      = $event[0]->location_hover;
            $data['background_hover']                      = $event[0]->background_hover;
            $data['event_url']                           = $event[0]->event_url;
            $data['open_new_tab']                        = $event[0]->open_new_tab;
            $data['background_color']                    = $event[0]->background_color;
            $data['background_image']                    = $event[0]->background_image;
            $data['external_btn']                        = $event[0]->external_btn;
           $data['sort_order'] = $event[0]->sort_order;
            $data['status']     = $event[0]->status;
        } else {
            $data['event_id']                            = '';
            $data['category']                            = '';
            $data['event_title']                         = '';
            $data['title_color']                         = '';
           $data['title_hover_color']                   = '';
            $data['title_position']                      = '';
            $data['image']                               = '';
            $data['image_title']                         = '';
            $data['image_alt']                           = '';
            $data['short_description']                   = '';
         //   $data['short_description_title_color']       = '';
         //  $data['short_description_title_position']    = '';
            $data['short_description_color']             = '';
            $data['short_description_position']          = '';
        //   $data['short_description_title_hover_color'] = '';
           $data['short_description_hover_color']       = '';
            $data['description']                         = '';
          // $data['description_title_color']             = '';
          //  $data['description_title_position']          = '';
            $data['description_color']                   = '';
            $data['description_position']                = '';
          // $data['description_title_hover_color']       = '';
            $data['description_hover_color']             = '';
            $data['create_date']                         = '';
            $data['date_color']                          = '';
            $data['location']                            = '';
            $data['location_color']                      = '';
           $data['date_hover']                          = '';
           $data['location_hover']                      = '';
           $data['background_hover']                    ='';
            $data['event_url']                           = '';
            $data['open_new_tab']                        = '';
            $data['background_color']                    = '';
            $data['background_image']                    = '';
            $data['external_btn']='';
            
            $data['sort_order'] = '';
            $data['status']     = '';
        }
        
        $data['httpUrl']             = $this->admin_header->host_url();
        $data['ImageUrl']            = $this->admin_header->image_url();
        $data['website_folder_name'] = $this->admin_header->website_folder_name();
        
        $data['heading'] = (($id != null) ? 'Edit Event' : 'Add Event');
        $data['title']   = (($id != null) ? 'Edit Event' : 'Add Event') . ' | Administrator';
        $this->load->view('template/meta_head', $data);
        $this->load->view('event_header');
        $this->admin_header->index();
        $this->load->view('add_edit_event', $data);
        $this->load->view('template/footer_content');
        $this->load->view('script');
        $this->load->view('template/footer');
    }
    
    // Insert Update Event Page
    function insert_update_event_page()
    {
        $event_id   = $this->input->post('event_id');
        $page_id    = $this->input->post('page_id');
        $website_id = $this->input->post('website_id');
        $continue   = $this->input->post('btn_continue');
        
        if (empty($event_id)) {
            $this->Event_model->insert_update_event_page();
            $this->session->set_flashdata('success', 'Event Successfully Created');
        } else {
            $this->Event_model->insert_update_event_page($event_id);
            $this->session->set_flashdata('success', 'Event Successfully Updated.');
        }
        
        if (isset($continue) && ($continue === "Save & Continue" || $continue === "Update & Continue")) {
            $url = 'event/event_page/' . $page_id;
        } else {
            $url = 'page/page_details/' . $page_id;
        }
        
        redirect($url);
    }
    
    // Insert & Update Event
    function insert_update_event()
    {
        $event_id = $this->input->post('event_id');
        $continue = $this->input->post('btn_continue');
        
        $error_config = array(
            array(
                'field' => 'category',
                'label' => 'Category',
                'rules' => 'required'
            ),
            array(
                'field' => 'title',
                'label' => 'Title',
                'rules' => 'required'
            ),
            array(
                'field' => 'event_url',
                'label' => 'Event URL',
                'rules' => 'required'
            )
        );
        
        $this->form_validation->set_rules($error_config);
        
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            if (empty($event_id)) {
                redirect('event/add_edit_event');
            } else {
                redirect('event/add_edit_event/' . $event_id);
            }
        } else {
            if (empty($event_id)) {
                $insert_id = $this->Event_model->insert_update_event();
                $this->session->set_flashdata('success', 'Event successfully Created');
                if (isset($continue) && $continue === "Add & Continue") {
                    $url = 'event/add_edit_event';
                } else {
                    $url = 'event';
                }
            } else {
                $this->Event_model->insert_update_event($event_id);
                $this->session->set_flashdata('success', 'Event Successfully Updated.');
                if (isset($continue) && $continue === "Update & Continue") {
                    $url = 'event/add_edit_event/' . $event_id;
                } else {
                    $url = 'event';
                }
            }
            redirect($url);
        }
    }
    
    // Add Category
    function insert_category()
    {
        $this->Event_model->insert_category();
        $this->session->set_flashdata('success', 'Category successfully Created');
        redirect('event/add_edit_event');
    }
    
    // Delete Event
    function delete_event()
    {
        $id = $this->input->post('id');
        $this->Event_model->delete_event($id);
        $this->session->set_flashdata('success', 'Event Successfully Deleted.');
    }
    
    // Delete multiple Event
    function delete_multiple_event()
    {
        $this->form_validation->set_rules('table_records[]', 'Row', 'required', array(
            'required' => 'You must select at least one row!'
        ));
        
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('event');
        } else {
            $this->Event_model->delete_multiple_event();
            $this->session->set_flashdata('success', 'Successfully Deleted');
            redirect('event');
        }
    }
    
    /**
     * Display all Category Events in a table
     * get table data from get table method
     */
    
    function category()
    {
        $data['website_id'] = $this->admin_header->website_id();
        $data['table']      = $this->get_category_table($data['website_id']);
        $data['heading']    = 'Event Category';
        $data['title']      = "Event Category | Administrator";
        $this->load->view('template/meta_head', $data);
        $this->load->view('event_header');
        $this->admin_header->index();
        $this->load->view('view_category', $data);
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
    
    function get_category_table($website_id)
    {
        $event_categories = $this->Event_model->get_event_category($website_id);
        if (!empty($event_categories)) {
            foreach ($event_categories as $event_category) {
                $anchor_edit = anchor(site_url('event/add_edit_event_category/' . $event_category->id), '<span class="glyphicon c_edit_icon glyphicon-edit" aria-hidden="true"></span>', array(
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'left',
                    'data-original-title' => 'Edit'
                ));
                
                $anchor_delete = anchor('', '<span class="glyphicon c_delete_icon glyphicon-trash" aria-hidden="true"></span>', array(
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'right',
                    'data-original-title' => 'Delete',
                    'onclick' => 'return delete_record(' . $event_category->id . ', \'' . base_url('event/delete_event_category') . '\')'
                ));
                
                if ($event_category->status === '1') {
                    $status = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
                } else {
                    $status = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
                }
                
                $cell = array(
                    'class' => 'last',
                    'data' => $anchor_edit . ' ' . $anchor_delete
                );
                $this->table->add_row('<input type="checkbox" class="flat" id="table_records" name="table_records[]" value="' . $event_category->id . '"><input type="hidden" id="row_sort_order" name="row_sort_order[]" value="' . $event_category->id . '">', ucwords($event_category->name), $event_category->sort_order, $status, $cell);
            }
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
        
        $this->table->set_heading('<input type="checkbox" id="check-all" class="flat">', 'Category', 'Sort Order', 'Status', 'Action');
        return $this->table->generate();
    }
    
    /**
     * Update Event Category Sort Order
     */
    function update_sort_order_category()
    {
        $website_id     = $this->input->post('sort_id');
        $row_sort_order = $this->input->post('row_sort_order');
        $this->Event_model->update_sort_order_two($website_id, $row_sort_order);
    }
    
    // Select Event Category
    function select_event_category()
    {
        $website_id       = $this->admin_header->website_id();
        $search           = strip_tags(trim($_GET['q']));
        $page             = $_GET['page'];
        $resultCount      = 25;
        $offset           = ($page - 1) * $resultCount;
        $event_categories = $this->Event_model->select_event_category($website_id, $search);
        if (!empty($event_categories)) {
            foreach ($event_categories as $event_category) {
                $answer[] = array(
                    "id" => $event_category->id,
                    "text" => $event_category->name
                );
            }
        } else {
            $answer[] = array(
                "id" => "",
                "text" => "No Results Found.."
            );
        }
        $count     = count($event_categories);
        $morePages = $resultCount <= $count;
        
        $results = array(
            "results" => $answer,
            "pagination" => array(
                "more" => $morePages
            )
        );
        echo json_encode($results);
    }
    
    // Category Selected Value
    function selected_category()
    {
        $data                = '';
        $category_id         = $_POST['categoryid'];
        $selected_categories = $this->Event_model->selected_category($category_id);
        if (!empty($selected_categories)) {
            foreach ($selected_categories as $selected_category) {
                $data .= '<option selected value="' . $selected_category->id . '">' . $selected_category->name . '</option>';
            }
        }
        echo $data;
    }
    
    // Add and Edit Event Category
    function add_edit_event_category($id = null)
    {
        if ($id != null) {
            $event_category = $this->Event_model->get_event_category_by_id($id);
            
            $data['event_category_id'] = $event_category[0]->id;
            $data['name']              = $event_category[0]->name;
            $data['sort_order']        = $event_category[0]->sort_order;
            $data['status']            = $event_category[0]->status;
        } else {
            $data['event_category_id'] = '';
            $data['sort_order']        = '';
            $data['name']              = '';
            $data['status']            = '';
        }
        
        $data['website_id'] = $this->admin_header->website_id();
        
        $data['heading'] = (($id != null) ? 'Edit Event Category' : 'Add Event Category');
        $data['title']   = (($id != null) ? 'Edit Event Category' : 'Add Event Category') . ' | Administrator';
        $this->load->view('template/meta_head', $data);
        $this->load->view('event_header');
        $this->admin_header->index();
        $this->load->view('add_edit_event_category', $data);
        $this->load->view('template/footer_content');
        $this->load->view('script');
        $this->load->view('template/footer');
    }
    
    // Insert & Update Event Category
    function insert_update_event_category()
    {
        $event_category_id = $this->input->post('event_category_id');
        $continue          = $this->input->post('btn_continue');
        
        $error_config = array(
            array(
                'field' => 'name',
                'label' => 'Category',
                'rules' => 'required'
            )
        );
        
        $this->form_validation->set_rules($error_config);
        
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            if (empty($event_category_id)) {
                redirect('event/add_edit_event_category');
            } else {
                redirect('event/add_edit_event_category/' . $event_category_id);
            }
        } else {
            if (empty($event_category_id)) {
                $insert_id = $this->Event_model->insert_update_event_category();
                $this->session->set_flashdata('success', 'Event Category successfully Created');
                if (isset($continue) && $continue === "Add & Continue") {
                    $url = 'event/add_edit_event_category';
                } else {
                    $url = 'event/category';
                }
            } else {
                $this->Event_model->insert_update_event_category($event_category_id);
                $this->session->set_flashdata('success', 'Event Category Successfully Updated.');
                if (isset($continue) && $continue === "Update & Continue") {
                    $url = 'event/add_edit_event_category/' . $event_category_id;
                } else {
                    $url = 'event/category';
                }
            }
            redirect($url);
        }
    }
    
    // Delete Event Category
    function delete_event_category()
    {
        $id     = $this->input->post('id');
        $events = $this->Event_model->check_event($id);
        if (empty($events)) {
            $this->Event_model->delete_event_category($id);
            $this->session->set_flashdata('success', 'Event Category Successfully Deleted.');
        } else {
            $this->session->set_flashdata('error', 'oops! First Remove Event');
        }
    }
    
    // Delete multiple Event Category
    function delete_multiple_event_category()
    {
        $this->form_validation->set_rules('table_records[]', 'Row', 'required', array(
            'required' => 'You must select at least one row!'
        ));
        
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('event/category');
        } else {
            $event_categories = $this->Event_model->check_event_category();
            if (empty($event_categories)) {
                $this->Event_model->delete_multiple_event_category();
                $this->session->set_flashdata('success', 'Successfully Deleted');
            } else {
                $this->session->set_flashdata('error', 'oops! First Remove Event');
            }
            
            redirect('event/category');
        }
    }
    
    // Check Event Category Duplicates
    
    function check_category_name()
    {
        $data = $this->Event_model->check_category_duplicate();
        if (empty($data)) {
            echo '0';
        } else {
            echo '1';
        }
    }
    
    // Remove Image
    function remove_image()
    {
        $this->Event_model->remove_event_image();
        echo '1';
    }
}