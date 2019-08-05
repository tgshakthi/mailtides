<?php
/**
 * Color
 *
 * @category class
 * @package  Color
 * @author   Athi
 * Created at:  23-Apr-2018
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Color extends MX_Controller
{
    function __construct()
	{
		parent::__construct();
		if ( ! $this->session->userdata('logged_in'))
		{
			redirect('login');
		}
		$this->load->model('Color_model');
		$this->load->module('admin_header');
		$this->form_validation->CI =& $this;
    }
	
	/**
	 * Color
	 * @author   Saravana
	 * Created at:  24-May-2018
	 * show all colors in Table.
	 */
	 
	function index()
	{
		$data['colors'] = $this->Color_model->get_color();		
		$data['title'] = "Admin Colors | Administrator";
		$data['heading'] = 'Colors';
		$this->load->view('template/meta_head', $data);
		$this->load->view('color_header');
		$this->admin_header->index();
		$this->load->view('view', $data);
		$this->load->view('template/footer_content');
    	$this->load->view('script');
		$this->load->view('template/footer');				
	}
	
	/**
	 * Insert Update
	 * @author   Saravana
	 * Created at:  25-May-2018
	 */
	
	function insert_update_color()
	{
		$id = $this->input->post('id');
		$error_config = array(
			array(
				'field' => 'color_name',
				'label' => 'Color Name',
				'rules' => 'required'
			),
			array(
				'field' => 'color_class',
				'label' => 'Color Class',
				'rules' => 'required'
			),
			array(
				'field' => 'color_code',
				'label' => 'Color Code',
				'rules' => 'required'
			)
		);
		
		$this->form_validation->set_rules($error_config);
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			redirect('color');			
		}
		else
		{
			if (empty($id)) :
				$this->Color_model->insert_update_colors();
				$this->session->set_flashdata('success', 'Color successfully Added');		
			else :
				$this->Color_model->insert_update_colors($id);
				$this->session->set_flashdata('success', 'Color successfully Updated');		
			endif;
			
			redirect('color');
		}
	}

    // Get Colors
    function view($title_color,$labelid,$fnid)
    {
		$data['color'] = $this->Color_model->get_color();
		$getcolorname = $this->Color_model->get_color_name($title_color);
		$data['color_name']	= (!empty($getcolorname))?$getcolorname[0]->color_name:'White';
		$data['title_color'] = ($title_color != '') ? $title_color : 'white';
		$data['labelid'] = $labelid;
		$data['fnid'] = $fnid;
		
		$this->load->view('colors', $data);
	}
	
	// Search Color
	function search_color()
	{
		$search_results = $this->Color_model->color_search();
		$data = '';
		
		if (!empty($search_results)) :
			foreach ($search_results as $search_result) :
				
				$data .= form_button(array(
					'class'               => 'color-list',
					'data-toggle'         => 'tooltip',
					'data-placement'      => 'top',
					'data-original-title' => $search_result->color_name,
					'value'               => $search_result->color_code,
					'content'             => '<p>#'.$search_result->color_code.'</p>',
					'style'               => 'background-color: #'.$search_result->color_code,
					'onclick'			 => 'edit_color('.$search_result->id.', \''.$search_result->color_name.'\', \''.$search_result->color_class.'\', \''.$search_result->color_code.'\')'
				));
				
			endforeach;
		else :
			$data = '<div class="alert alert-info alert-dismissible fade in text-center" role="alert">
                    	<strong>No Colors Found!</strong>
                  	</div>';
		endif;
		
		echo $data;
	}
}
