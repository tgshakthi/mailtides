<?php
/**
 * Admin Header
 *
 * @category class
 * @package  Admin Header
 * @author   Saravana
 * Created at:  19-Apr-2018
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_header extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        
        $this->load->model('Admin_header_model');
        $this->session_data = $this->session->userdata('logged_in');
    }
    
    function index()
    {
        $admin_details  = $this->Admin_header_model->get_admin_user_details($this->session_data['id']);
        $admin_image    = (empty($admin_details[0]->user_image)) ? 'images/userimg.png' : $admin_details[0]->user_image;
        $ses_website_id = $this->session->userdata('website_id');
        if ($ses_website_id != '0') {
            $ses_web_detail = $this->Admin_header_model->get_website_details($ses_website_id);
        } else {
            $ses_web_detail = '';
        }
        
        $data['website_url']   = (!empty($ses_web_detail)) ? $ses_web_detail[0]->website_url : '';
        $data['website_count'] = count(explode(',', $admin_details[0]->website_id));
        $data['admin_user_first_name'] = ucwords($admin_details[0]->first_name);
        $data['adminUserName'] = ucwords($admin_details[0]->first_name . ' ' . $admin_details[0]->last_name);
        $data['profile_pic']   = $this->image_url() . $admin_image;
        $data['web_name']      = (!empty($ses_web_detail)) ? ucwords($ses_web_detail[0]->website_name) : 'DESSS';
        $data['web_logo']      = (!empty($ses_web_detail)) ? $this->image_url() . $ses_web_detail[0]->logo : $this->image_url() . 'images/no-logo.png';
        $data['admin_user_id'] = $this->session_data['id'];
        $data['sidebar']       = $this->sidebar();
        $data['color']         = $this->color();
        $this->load->view('admin_header', $data);
    }
    
    // Get Http Url
    
    function host_url()
    {
        return ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'];
    }
    
    // Get Image URL
    
    function image_url()
    {
        return $this->session_data['ImageUrl'];
    }
    
    // Get WebSite Id
    
    function website_id()
    {
        return $this->session->userdata('website_id');
    }
    
    // Get Website Folder Name
    function website_folder_name()
    {
        $folder_name = '';
        $ses_web_detail = $this->Admin_header_model->get_website_details($this->website_id());

        if (empty($ses_web_detail[0]->folder_name)) :

            // Configure Folder path for image upload for respective websites.
            $app_path = APPPATH;
            $find_path = 'admin' . DIRECTORY_SEPARATOR . 'application';
            $replace_path = 'assets' . DIRECTORY_SEPARATOR . 'images';
            $file_path = str_ireplace($find_path, $replace_path, $app_path);

            // Create folder name
            $folder_name = str_ireplace(' ', '-', strtolower(trim(strip_tags($ses_web_detail[0]->website_name))));
            
            if (!file_exists($file_path . $folder_name)) :
                mkdir($file_path.$folder_name);
            endif;

        else :
            $folder_name = $ses_web_detail[0]->folder_name;
        endif; 

       return $folder_name;
    }
    
    // Sidebar
    
    function sidebar()
    {
        $sidebar_parent_menus = $this->Admin_header_model->sidebar_parent_menu($this->session_data['id']);
        
        // Parent Menu
        
        if (!empty($sidebar_parent_menus)) {
            $default_text = array(
                'fas',
                'fab'
            );
            $re_text      = array(
                'fa',
                'fa'
            );
            foreach ($sidebar_parent_menus as $sidebar_parent_menu) {
                $sidebar_child_menus = $this->Admin_header_model->sidebar_child_menu($sidebar_parent_menu->user_role_id, $sidebar_parent_menu->menu_id);
                
                // Child Menu
                
                if (!empty($sidebar_child_menus)) {
                    $sublist = array();
                    foreach ($sidebar_child_menus as $sidebar_child_menu) {
                        $sublist[] = anchor($sidebar_child_menu->menu_url, $sidebar_child_menu->menu_name);
                    }
                    
                    $subattributes = array(
                        'class' => 'nav child_menu'
                    );
                    $icon          = str_replace($default_text, $re_text, $sidebar_parent_menu->menu_icon);
                    $list[]        = '<a>
                        <i class="fa ' . $icon . '"></i>
                        ' . $sidebar_parent_menu->menu_name . '
                        <span class="fa fa-chevron-down"></span>
                    </a>' . ul($sublist, $subattributes);
                } else {
                    $icon   = str_replace($default_text, $re_text, $sidebar_parent_menu->menu_icon);
                    $list[] = anchor($sidebar_parent_menu->menu_url, '<i class="fa ' . $icon . '"></i>' . $sidebar_parent_menu->menu_name);
                }
            }
            
            $list_attributes = array(
                'class' => 'nav side-menu'
            );
            return ul($list, $list_attributes);
        }
    }
    
    // Color
    
    function color()
    {
        $color_style = "";
        $color       = $this->Admin_header_model->get_color();
        foreach ($color as $colors) {
            $color_style .= '.' . $colors->color_class . '{background-color:#' . $colors->color_code . ' !important}';
        }
        
        return $color_style;
    }
}