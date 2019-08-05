<?php
/**
 * Map
 * Created at : 04-Dec-2018
 * Author : Saravana
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Map extends MX_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('Map_model');
    }
    /* Get Map */
    function view($page_id) {
        $data['image_url'] = $this->setting->image_url();
        // Map Title
        $data_title_settings = $this->setting->get_setting('page_id', $page_id, 'map_title');
        if (!empty($data_title_settings)):
            $data['map_title'] = $data_title_settings['map_title'];
            $data['map_title_color'] = $data_title_settings['map_title_color'];
            $data['map_title_position'] = $data_title_settings['map_title_position'];
            $data['map_title_status'] = $data_title_settings['map_title_status'];
        else:
            $data['map_title'] = '';
            $data['map_title_color'] = '';
            $data['map_title_position'] = '';
            $data['map_title_status'] = '';
        endif;
        // Map Customized data
        $data_customize_from_setting = $this->setting->get_setting('page_id', $page_id, 'map_customize');
        if (!empty($data_customize_from_setting)):
            $data['count'] = $data_customize_from_setting['row_count'];
            $data['component_background'] = $data_customize_from_setting['component_background'];
            $data['map_background'] = $data_customize_from_setting['map_background'];
        else:
            $data['count'] = '';
            $data['component_background'] = '';
            $data['map_background'] = '';
        endif;
        $data['image_url'] = $this->setting->image_url();
        // Background
        if ($data['component_background'] != ''):
            if ($data['component_background'] == 'image'):
                $data['bg_image'] = $data['image_url'] . $data['map_background'];
                $data['bg_color'] = "";
            elseif ($data['component_background'] == 'color'):
                $data['bg_color'] = $data['map_background'];
                $data['bg_image'] = "";
            else:
                $data['bg_color'] = '';
                $data['bg_image'] = '';
            endif;
        endif;
        $data['maps'] = $this->Map_model->get_map($page_id);
        $this->load->view('map', $data);
    }
}
?>
