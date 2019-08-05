<?php
/**
 * Header Page
 * Created at : 04-June-2018
 * Author : Athi
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Header extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Header_model');
        $this->load->module('setting');
    }
    
    // View selected Theme Header
    
    function index()
    {
        $data['website'] = $this->setting->website_id();

        // Website Folder
        $data['website_folder'] = $this->setting->website_folder();
        
        // Favicon
        
        $data['favicon'] = $this->setting->favicon();
        
        // Theme
        
        $data['theme'] = $this->setting->theme_name();
        
        // Top Header
        
        $data['top_header'] = $this->top_header($data['website']);
        
        // Google Analytics
        
        $data['google_analytics'] = $this->google_analytics($data['website']);
        
        // Header Background color
        
		$header_background_color = $this->setting->get_setting('website_id', $data['website'], 'header_background');
		$data['header_background'] = (!empty($header_background_color)) ? $header_background_color['header_background_color'] : 'white';
        
        // Get logo
        
        $data['logo'] = $this->logo($data['website']);
        
        // Get Mobile Nav
        
        $data['mobile_nav'] = $this->mobile_nav($data['website']);
        
        // Get Menu
        
        //$data['menus'] = $this->menu($data['website']);
        $data['menus'] = $this->menu_new($data['website']);
        //$data['menus'] = "";
        
        // Blog
        
        $page_url        = str_replace('blog/', '', $this->setting->page_url());
        $meta_datas      = $this->Header_model->get_meta_data($this->setting->page_id());
        $blog_meta_datas = $this->Header_model->get_blog_meta_data($data['website'], $page_url);
        if (!empty($meta_datas)):
            foreach ($meta_datas as $meta_data):
                $data['meta_title']       = $meta_data->meta_title;
                $data['meta_description'] = $meta_data->meta_description;
                $data['meta_keyword']     = $meta_data->meta_keyword;
                $data['meta_misc']        = $meta_data->meta_misc;
            endforeach;
        elseif (!empty($blog_meta_datas)):
            foreach ($blog_meta_datas as $blog_meta_data):
                $data['meta_title']       = $blog_meta_data->meta_title;
                $data['meta_description'] = $blog_meta_data->meta_description;
                $data['meta_keyword']     = $blog_meta_data->meta_keyword;
                $data['meta_misc']        = '';
            endforeach;
        else:
            $data['meta_title']       = '';
            $data['meta_description'] = '';
            $data['meta_keyword']     = '';
            $data['meta_misc']        = '';
		endif;
		
        $this->load->view('theme/' . $data['theme'] . '/inc/head', $data);
        $this->setting->css_file();
        $this->load->view('theme/' . $data['theme'] . '/inc/header', $data);
    }
    
    // Top header
    
    function top_header($website_id)
    {
		$top_header = '';
		$contact_info = '';
		$social_media = '';
        
        // Get Top header Status
        
        $top_header_settings = $this->setting->get_setting('website_id', $website_id, 'top_header_background');
		if (!empty($top_header_settings)) :
			
            if ($top_header_settings['top_header_status'] == '1') :
                
                // Get top header component lists
                
				$top_header_components = $this->Header_model->get_top_header_components($website_id);
				
                if (!empty($top_header_components)) :
                    foreach ($top_header_components as $top_header_component) :
                        switch ($top_header_component->name) :
                            case 'Contact':
                                $contact_info = $this->top_header_contact_info($website_id);
                                break;
                            
                            case 'Social Media':
                                $social_media = $this->top_header_social_media($website_id);
                                break;
						endswitch;
					endforeach;
				endif;

				$top_header .= '<div class="top-header '.$top_header_settings['top_header_background_color'].'">
					<div class="container">
						<div class="top-header-row">
							' . $contact_info . $social_media . '
						</div>
					</div>
				</div>';			
				
			endif;
			
        endif;
        
		return $top_header;
    }
    
    // Top Header Contact Info
    
    function top_header_contact_info($website_id)
    {        
        // Get Contact Informations from settings table
        
        $get_top_header_setting_contact_info = $this->setting->get_setting('website_id', $website_id, 'top_header_contact_info');
        if (!empty($get_top_header_setting_contact_info)):
            $data['top_header_contact_info']          = $get_top_header_setting_contact_info['top_header_contact_info'];
            $data['top_header_contact_info_position'] = $get_top_header_setting_contact_info['top_header_contact_info_position'];
            $data['top_header_contact_info_status']   = $get_top_header_setting_contact_info['top_header_contact_info_status'];
        else:
            $data['top_header_contact_info']          = array();
            $data['top_header_contact_info_position'] = "";
            $data['top_header_contact_info_status']   = "";
        endif;
        
        // Get Contact Informations from Contact Info table
        
        if (!empty($data['top_header_contact_info_status'])):
            if (!empty($data['top_header_contact_info'])):
                $get_contact_informations = $this->Header_model->get_top_header_contact_information($data['top_header_contact_info'], $website_id);
            // Contact Info - Phone Number
                if (!empty($get_contact_informations)):

                    if (in_array('phone_no', $data['top_header_contact_info'])):

                        if (!empty($get_contact_informations[0]->phone_no)) :

                            $top_header_contact_list[] = '<a href="tel:' . $get_contact_informations[0]->phone_no . '" class=" ' . $get_contact_informations[0]->phone_no_title_color . '" title="Call Us" id="contact-title-1" onmouseover="contact_title_hover(\'' . $get_contact_informations[0]->phone_no_title_color . '\', \'' . $get_contact_informations[0]->phone_title_hover_color . '\', 1);" onmouseout="contact_title_hoverout(\'' . $get_contact_informations[0]->phone_no_title_color . '\', \'' . $get_contact_informations[0]->phone_title_hover_color . '\', 1);">

                            <i class="fa ' . $get_contact_informations[0]->phone_icon . ' ' . $get_contact_informations[0]->phone_icon_color . '" id="contact-icon-1" onmouseover="contact_icon_hover(\'' . $get_contact_informations[0]->phone_icon_color . '\', \'' . $get_contact_informations[0]->phone_icon_hover_color . '\', 1);" onmouseout="contact_icon_hoverout(\'' . $get_contact_informations[0]->phone_icon_color . '\', \'' . $get_contact_informations[0]->phone_icon_hover_color . '\', 1);"></i>' . $get_contact_informations[0]->phone_no . '</a>';

                        endif;
                        
                    endif;
                    
                    // Contact Info - Email
                    
                    if (in_array('email', $data['top_header_contact_info'])):

                        if (!empty($get_contact_informations[0]->email)) :

                            $top_header_contact_list[] = '<a href="mailto:' . $get_contact_informations[0]->email . '" class="contact-hover ' . $get_contact_informations[0]->email_title_color . '" id="contact-title-2" onmouseover="contact_title_hover(\'' . $get_contact_informations[0]->email_title_color . '\', \'' . $get_contact_informations[0]->email_title_hover_color . '\', 2);" onmouseout="contact_title_hoverout(\'' . $get_contact_informations[0]->email_title_color . '\', \'' . $get_contact_informations[0]->email_title_hover_color . '\', 2);">

                            <i class="fa ' . $get_contact_informations[0]->email_icon . ' ' . $get_contact_informations[0]->email_icon_color . '" id="contact-icon-2" title="E-mail" onmouseover="contact_icon_hover(\'' . $get_contact_informations[0]->email_icon_color . '\', \'' . $get_contact_informations[0]->email_icon_hover_color . '\', 2);" onmouseout="contact_icon_hoverout(\'' . $get_contact_informations[0]->email_icon_color . '\', \'' . $get_contact_informations[0]->email_icon_hover_color . '\', 2);"></i>' . $get_contact_informations[0]->email . '</a>';

                        endif;                        

                    endif;
                    
                    // Contact Info - Address
                    
                    if (in_array('address', $data['top_header_contact_info'])):

                        if (!empty($get_contact_informations[0]->address)) :

                            $top_header_contact_list[] = '<a href="#" class="contact-hover contact-address-res ' . $get_contact_informations[0]->address_title_color . '" id="contact-title-3" onmouseover="contact_title_hover(\'' . $get_contact_informations[0]->address_title_color . '\', \'' . $get_contact_informations[0]->address_title_hover_color . '\', 3);" onmouseout="contact_title_hoverout(\'' . $get_contact_informations[0]->address_title_color . '\', \'' . $get_contact_informations[0]->address_title_hover_color . '\', 3);">

                            <i class="fa ' . $get_contact_informations[0]->address_icon . ' ' . $get_contact_informations[0]->address_icon_color . '" id="contact-icon-3" title="Address" onmouseover="contact_icon_hover(\'' . $get_contact_informations[0]->address_icon_color . '\', \'' . $get_contact_informations[0]->address_icon_hover_color . '\', 3);" onmouseout="contact_icon_hoverout(\'' . $get_contact_informations[0]->address_icon_color . '\', \'' . $get_contact_informations[0]->address_icon_hover_color . '\', 3);"></i>' . $get_contact_informations[0]->address . '</a>';

                        endif;                       

                    endif;
                else:
                    $top_header_contact_list[] = "";
                endif;
                $top_header_contact_info_attributes = array(
                    'class' => "contact-list " . $data['top_header_contact_info_position']
                );
                
                // Merge together in ul
                
                $top_header_contact_info_ul = ul($top_header_contact_list, $top_header_contact_info_attributes);
                return $top_header_contact_info_ul;
            endif;
        endif;
    }
    
    // Top Header Social Media
    
    function top_header_social_media($website_id)
    {        
        // Get Social Media from settings table
        
        $get_top_header_setting_social_media = $this->setting->get_setting('website_id', $website_id, 'top_header_social_media_info');
        if (!empty($get_top_header_setting_social_media)):
            if ($get_top_header_setting_social_media['top_header_social_info_status'] == 1):
            // Get Social Media information
                $get_social_media_informations = $this->Header_model->get_top_header_social_media($website_id);
                if (!empty($get_social_media_informations)):
                    $i = 1;
                // Social Media list - loop
                    foreach ($get_social_media_informations as $get_social_media_information):
                        $top_header_social_media_list[] = '<a href="' . $get_social_media_information->media_url . '" class="' . $get_social_media_information->icon_color . ' ' . $get_social_media_information->background_color . '" id="social-icon-' . $i . '" onmouseover="social_media_icon_hover(\'' . $get_social_media_information->icon_color . '\', \'' . $get_social_media_information->icon_hover_color . '\', \'' . $get_social_media_information->background_color . '\', \'' . $get_social_media_information->background_hover_color . '\' , ' . $i . ');" onmouseout="social_media_icon_hoverout(\'' . $get_social_media_information->icon_color . '\', \'' . $get_social_media_information->icon_hover_color . '\', \'' . $get_social_media_information->background_color . '\', \'' . $get_social_media_information->background_hover_color . '\' , ' . $i . ');">
                            <i class="fa ' . $get_social_media_information->icon . '" aria-hidden="true" title="' . $get_social_media_information->media_name . '"></i>
                        </a>';
                        $i++;
                    endforeach;
                    $top_header_social_media_attributes = array(
                        'class' => "social-icon-top hide-on-small-only"
                    );
                    
                    // Social Media ul
                    
                    $top_header_social_media_ul = '<div class="column-detail ' . $get_top_header_setting_social_media["top_header_social_info_position"] . '">' . ul($top_header_social_media_list, $top_header_social_media_attributes) . '</div>';
                    return $top_header_social_media_ul;
                endif;
            endif;
        endif;
    }
    
    // Logo
    
    function logo($website_id)
    {
        $websites = $this->Header_model->get_websites($website_id);
        $website_folder = $this->setting->website_folder();
        if (!empty($websites)) {
            $data['logo']         = 'assets/images/' . $website_folder .'/'. $websites[0]->logo;
            $data['website_name'] = $websites[0]->website_name;
            $data['website_url']  = $websites[0]->website_url;
        } else {
            $data['logo']         = 'images/logo.png';
            $data['website_name'] = 'Desss';
            $data['website_url']  = 'http://www.desss.com/';
        }
        
        // Get Logo Customization From Header Model
        
        $logos = $this->Header_model->get_logo($website_id);
        if (!empty($logos)) {
            $keys   = json_decode($logos[0]->key);
            $values = json_decode($logos[0]->value);
            $i      = 0;
            foreach ($keys as $key) {
                $data[$key] = $values[$i];
                $i++;
            }
        } else {
            $data['logo_position'] = '';
            $data['logo_size']     = '';
        }
        
        return $data;
    }
    
    /**
     * Google Analytics
     */
    function google_analytics($website_id)
    {
        $google_analytic_code = $this->Header_model->google_analytics($website_id);
        return (!empty($google_analytic_code)) ? $google_analytic_code[0]->analytic_code : "";
	}
	
	// Menu
    
    function menu($website_id)
    {
        $image_url = $this->setting->image_url();
        $menu_customs = $this->setting->get_setting('website_id', $website_id, 'menu');
        if (!empty($menu_customs)) {
            $data['menu_position']              = $menu_customs['menu_position'];
            $data['status']                     = $menu_customs['status'];
            $data['main_menu_text_color']       = $menu_customs['main_menu_text_color'];
            $data['sub_menu_text_color']        = $menu_customs['sub_menu_text_color'];
            $data['main_menu_text_hover_color'] = $menu_customs['main_menu_text_hover_color'];
            $data['sub_menu_text_hover_color']  = $menu_customs['sub_menu_text_hover_color'];
            $data['main_menu_bg_color']         = $menu_customs['main_menu_bg_color'];
            $data['sub_menu_bg_color']          = $menu_customs['sub_menu_bg_color'];
            $data['main_menu_bg_hover_color']   = $menu_customs['main_menu_bg_hover_color'];
            $data['sub_menu_bg_hover_color']    = $menu_customs['sub_menu_bg_hover_color'];
        } else {
            $data['menu_position']              = '';
            $data['status']                     = '';
            $data['main_menu_text_color']       = "";
            $data['sub_menu_text_color']        = "";
            $data['main_menu_text_hover_color'] = "";
            $data['sub_menu_text_hover_color']  = "";
            $data['main_menu_bg_color']         = "";
            $data['sub_menu_bg_color']          = "";
            $data['main_menu_bg_hover_color']   = "";
            $data['sub_menu_bg_hover_color']    = "";
        }
        
        $json_menus   = $this->Header_model->get_menu($website_id);
        $desktop_menu = "";
        if (!empty($json_menus)):
            $menus = json_decode($json_menus[0]->menu);
            $desktop_menu .= '<div class="dm-desktop-menu">
            <article class="mm-dm-menu">
                <ul class="dm-menu-list">';
            $i = 1;
            foreach ($menus as $menu):
                $parent_title = $this->Header_model->get_parent_menu($website_id, $menu->id);
                if (!empty($parent_title)):
                    $desktop_menu .= '<li>';
                    if (!empty($menu->children)):
                        $desktop_menu .= '<a href="javascript:void(0)" class="dm-list-submenu white-text " id="' . $i . '">' . $parent_title[0]->title . '</a>';
                        $desktop_menu .= '<div class="mainmenu_sub">
                            <article class="submenu-container submenu_content_' . $i . ' white">
                                <div class="mdl-tabs vertical-mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
                                    <div class="row padd-bott">

                                        <div class="col xl3"> 
                                            <div class="mdl-tabs-tab-bar white">';
                        $j = 1;
                        foreach ($menu->children as $sub_menu):
                            $sub_menu_title = $this->Header_model->get_parent_menu($website_id, $sub_menu->id);
                            if ($j == 1):
                                $active_tab = 'is-active';
                            else:
                                $active_tab = '';
                            endif;
                            $desktop_menu .= '<a href="#tab' . $j . '-panel" class="mdl-tabs-tab ' . $active_tab . '">
                                            <span class="hollow-circle"></span>
                                            ' . $sub_menu_title[0]->title . '
                                             </a>';
                            $j++;
                        endforeach;
                        $desktop_menu .= '</div>
                            </div>';
                        $desktop_menu .= '<div class="col xl6">';
                        $ji = 1;
                        foreach ($menu->children as $sub_menu):
                            if ($ji == 1):
                                $active_tab = 'is-active';
                            else:
                                $active_tab = '';
                            endif;
                            $page_menu_content = $this->setting->get_setting('page_id', $sub_menu->id, 'page_menu_content');
                            if (!empty($sub_menu->children)):
                                $desktop_menu .= '<div class="mdl-tabs-panel ' . $active_tab . '" id="tab' . $ji . '-panel">
                                        <div class="row padd-bott">';
                                if (!empty($page_menu_content)):
                                    $page_menu_image       = $page_menu_content['page_menu_image'];
                                    $page_menu_description = $page_menu_content['page_menu_content'];
                                    $page_menu_status      = $page_menu_content['page_menu_status'];
                                    if ($page_menu_status == 1):
                                        $desktop_menu .= '<div class="col xl12">
                                                <div class="ecomm-brand-list">
                                                <ul class="particullar-list">';
                                        foreach ($sub_menu->children as $sub_menu_children):
                                            $sub_menu_children_title = $this->Header_model->get_parent_menu($website_id, $sub_menu_children->id);
                                            if (!empty($sub_menu_children_title)):
                                                $desktop_menu .= '<li> 
                                                            <a href="' . $sub_menu_children_title[0]->url . '">
                                                                <i class="fas fa-circle"></i> 
                                                                ' . $sub_menu_children_title[0]->title . '
                                                            </a>
                                                        </li>';
                                            endif;
                                        endforeach;
                                        $desktop_menu .= '</ul>
                                                    </div>
                                                    <br class="spacer">
                                                </div>';
                                    endif;
                                endif;
                                $desktop_menu .= '</div></div>';
                            else:
                                $desktop_menu .= '<div class="mdl-tabs-panel ' . $active_tab . '" id="tab' . $ji . '-panel">
                                        <div class="row padd-bott">';
                                if (!empty($page_menu_content)):
                                    $page_menu_image       = $page_menu_content['page_menu_image'];
                                    $page_menu_description = $page_menu_content['page_menu_content'];
                                    $page_menu_status      = $page_menu_content['page_menu_status'];
                                    if ($page_menu_status == 1):
                                        $desktop_menu .= '<div class="col xl3">
                                                    <a href="#" class="tab-product-img">
                                                        <img src="'. $image_url . $page_menu_image .'" alt="" title="">
                                                    </a>
                                                </div>
                                                
                                                <div class="col xl7 menutabdropdown-img-text">
                                                    ' . $page_menu_description . '
                                                  </div>';
                                    endif;
                                endif;
                                $desktop_menu .= '</div></div>';
                            endif;
                            $ji++;
                        endforeach;
                        $desktop_menu .= '</div>';
                        $desktop_menu .= '</div></div><div class="menu_close dm-list-submenu white white-text" id="' . $i . '"><span><i class="fas fa-angle-double-up"></i></span></div></article>';
                        $desktop_menu .= '</div>';
                    else:
                        $desktop_menu .= '<a href="' . $parent_title[0]->url . '" class="dm-list-submenu white-text " id="' . $i . '">' . $parent_title[0]->title . '</a>';
                    endif;
                    $desktop_menu .= '</li>';
                endif;
                $i++;
            endforeach;
            $desktop_menu .= '</ul>
            </article>';
            $desktop_menu .= '</div>';
        endif;
        $data['menus'] = $desktop_menu;
        return $data;
    }
	
	// Mobile Menu
    function mobile_nav($website_id)
    {
        $json_menus = $this->Header_model->get_menu($website_id);
        $menu_list  = '';
        if (!empty($json_menus)):
            $menus = json_decode($json_menus[0]->menu);
            $menu_list .= '<div id="dl-menu" class="dl-menuwrapper mm-mobile-menu">
            <button class="dl-trigger"><i class="fas fa-bars"></i></button>
                <ul class="dl-menu">';
            foreach ($menus as $menu):
                $parent_title = $this->Header_model->get_parent_menu($website_id, $menu->id);
                if (!empty($parent_title)):
                    $menu_list .= '<li>';
                    if (!empty($menu->children)):
                        $menu_list .= '<a href="#">' . $parent_title[0]->title . '</a>';
                        $menu_list .= '<ul class="dl-submenu">';
                        foreach ($menu->children as $sub_menu):
                            $sub_menu_title = $this->Header_model->get_parent_menu($website_id, $sub_menu->id);
                            $menu_list .= '<li>';
                            if (!empty($sub_menu->children)):
                                $menu_list .= '<a href="#">' . $sub_menu_title[0]->title . '</a>';
                                $menu_list .= '<ul class="dl-submenu">';
                                foreach ($sub_menu->children as $sub_menu_children):
                                    $sub_menu_children_title = $this->Header_model->get_parent_menu($website_id, $sub_menu_children->id);
                                    $menu_list .= '<li>';
                                    if (!empty($sub_menu_children->children)):
                                        $menu_list .= '<a href="#">' . $sub_menu_children_title[0]->title . '</a>';
                                        $menu_list .= '<ul class="dl-submenu">';
                                        foreach ($sub_menu_children->children as $sub_menu_first_children):
                                            $sub_menu_first_children_title = $this->Header_model->get_parent_menu($website_id, $sub_menu_first_children->id);
                                            $menu_list .= '<li>';
                                            $menu_list .= '<a href="' . $sub_menu_first_children[0]->url . '">' . $sub_menu_first_children[0]->title . '</a>';
                                            $menu_list .= '</li>';
                                        endforeach;
                                        $menu_list .= '</ul>';
                                    else:
                                        $menu_list .= '<a href="' . $sub_menu_children_title[0]->url . '">' . $sub_menu_children_title[0]->title . '</a>';
                                    endif;
                                    $menu_list .= '</li>';
                                endforeach;
                                $menu_list .= '</ul>';
                            else:
                                $menu_list .= '<a href="' . $sub_menu_title[0]->url . '">' . $sub_menu_title[0]->title . '</a>';
                            endif;
                            $menu_list .= '</li>';
                        endforeach;
                        $menu_list .= '</ul>';
                    else:
                        $menu_list .= '<a href="' . $parent_title[0]->url . '">' . $parent_title[0]->title . '</a>';
                    endif;
                    $menu_list .= '</li>';
                endif;
            endforeach;
            $menu_list .= '</ul></div>';
        endif;
        $data['mobile_menu'] = $menu_list;
        return $data;
    }

    // Menu new
    function menu_new($website_id)
    {
        $menu_customs = $this->setting->get_setting('website_id', $website_id, 'menu');
        if (!empty($menu_customs)) {
            $data['menu_position']              = $menu_customs['menu_position'];
            $data['status']                     = $menu_customs['status'];
            $data['main_menu_text_color']       = $menu_customs['main_menu_text_color'];
            $data['sub_menu_text_color']        = $menu_customs['sub_menu_text_color'];
            $data['main_menu_text_hover_color'] = $menu_customs['main_menu_text_hover_color'];
            $data['sub_menu_text_hover_color']  = $menu_customs['sub_menu_text_hover_color'];
            $data['main_menu_bg_color']         = $menu_customs['main_menu_bg_color'];
            $data['sub_menu_bg_color']          = $menu_customs['sub_menu_bg_color'];
            $data['main_menu_bg_hover_color']   = $menu_customs['main_menu_bg_hover_color'];
            $data['sub_menu_bg_hover_color']    = $menu_customs['sub_menu_bg_hover_color'];
        } else {
            $data['menu_position']              = '';
            $data['status']                     = '';
            $data['main_menu_text_color']       = "";
            $data['sub_menu_text_color']        = "";
            $data['main_menu_text_hover_color'] = "";
            $data['sub_menu_text_hover_color']  = "";
            $data['main_menu_bg_color']         = "";
            $data['sub_menu_bg_color']          = "";
            $data['main_menu_bg_hover_color']   = "";
            $data['sub_menu_bg_hover_color']    = "";
        }

        $json_menus = $this->Header_model->get_menu($website_id);
        $desktop_menu = "";

        if (!empty($json_menus)):

            $menus = json_decode($json_menus[0]->menu);

            $desktop_menu .= '<div class="new-desktop-menu">
                <ul class="new-menu-list">';

                foreach ($menus as $menu):
                    $parent_title = $this->Header_model->get_parent_menu($website_id, $menu->id);

                    if (!empty($parent_title)):

                        $desktop_menu .= '<li>';

                        if (!empty($menu->children)):

                            $desktop_menu .= '<a href="'. $parent_title[0]->url . '" class="white-text ">' . $parent_title[0]->title . '</a>';

                            $desktop_menu .= '<ul class="new-dropdown-menu">';

                                foreach ($menu->children as $sub_menu) :

                                    $sub_menu_title = $this->Header_model->get_parent_menu($website_id, $sub_menu->id);

                                    $desktop_menu .= '<li>
                                        <a href="'. $sub_menu_title[0]->url . '"> ' . $sub_menu_title[0]->title . ' </a>
                                    </li>';

                                endforeach;

                            $desktop_menu .= '</ul>';

                        else:
                            $desktop_menu .= '<a href="'. $parent_title[0]->url . '" class="white-text ">' . $parent_title[0]->title . '</a>';
                        endif;

                        $desktop_menu .= '</li>';

                    endif;

                endforeach;

            $desktop_menu .= '</ul></div>';
        endif;

        $data['menus'] = $desktop_menu;

        return $data;
    }
}
?>