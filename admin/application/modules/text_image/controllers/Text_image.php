<?php
/**
 * Text Image
 *
 * @category class
 * @package  Text Image
 * @author   Athi
 * Created at:  25-Apr-2018
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Text_image extends MX_Controller
{
    function __construct()
	{
		parent::__construct();
		if ( ! $this->session->userdata('logged_in'))
		{
			redirect('login');
		}
		$this->load->model('Text_image_model');
		$this->load->module('admin_header');
		$this->load->module('color');
    }

    // Display all Text Image in a table
    function text_image_index($page_id)
    {
		$data['website_folder_name'] = $this->admin_header->website_folder_name();
        $data['httpUrl']             = $this->admin_header->host_url();
        $data['ImageUrl']            = $this->admin_header->image_url();
        
        $data['website_id']              = $this->admin_header->website_id();
        // Get Tab details from settings
        $data['text_image_background_data'] = $this->Text_image_model->get_text_image_background_setting_details($data['website_id'], $page_id, 'text_image_background');
        // Tab title details from settings
        if (!empty($data['text_image_background_data'])) {
            $keys   = json_decode($data['text_image_background_data'][0]->key);
            $values = json_decode($data['text_image_background_data'][0]->value);
            $i      = 0;
            foreach ($keys as $key) {
                $data[$key] = $values[$i];
                $i++;
            }
        } else {
            $data['component_background']    = '';
            $data['text_image_background'] = '';
        }
		
		$data['page_id']	= $page_id;
		$data['table']	 = $this->get_table($page_id);
		$data['heading'] = 'Text Image';
		$data['title']	 = "Text Image | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('text_image_header');
		$this->admin_header->index();
		$this->load->view('view', $data);
		$this->load->view('template/footer_content');
    	$this->load->view('script');
		$this->load->view('template/footer');
	}
	
	 // Insert & Update Tab Title
    
    function insert_update_text_image_background()
    {
        $page_id = $this->input->post('page_id');
        $this->Text_image_model->insert_update_text_image_background($page_id);
        redirect('text_image/text_image_index/' . $page_id);
    }

	// Table
	function get_table($page_id)
	{
		$website_folder_name = $this->admin_header->website_folder_name();
		$ImageUrl	= $this->admin_header->image_url();
		$text_images	= $this->Text_image_model->get_text_image($page_id);
		if (isset($text_images) && $text_images != "")
		{
			foreach ($text_images as $text_image)
			{
				$anchor_edit = anchor(
					'text_image/add_edit_text_image/'.$page_id.'/'.$text_image->id,
					'<span class="glyphicon c_edit_icon glyphicon-edit" aria-hidden="true"></span>',
					array(
						'data-toggle'         => 'tooltip',
						'data-placement'      => 'left',
						'data-original-title' => 'Edit'
					)
				);

				$anchor_delete = anchor(
					'',
					'<span class="glyphicon c_delete_icon glyphicon-trash" aria-hidden="true"></span>',
					array(
						'data-toggle'         => 'tooltip',
						'data-placement'      => 'right',
						'data-original-title' => 'Delete',
						'onclick' => 'return delete_record('.$text_image->id.', \''.base_url('text_image/delete_text_image/'.$page_id).'\')'
					)
				);

				$cell = array(
					'class' => 'last',
					'data'  => $anchor_edit.$anchor_delete
                );

                if ($text_image->status === '1' )
				{
					$status = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
				}
				else
				{
					$status = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
				}

				if ($text_image->image != '')
				{

					$image = $ImageUrl . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR . $text_image->image;

					$image	= img(array(
                    	'src'   => $image,
                    	'style' => 'width:145px; height:86px'
                  	));
				}
				else
				{
					$image	= img(array(
                    	'src'   => $ImageUrl.'images/noimage.png',
                    	'style' => 'width:145px; height:86px'
                  	));
				}

				$this->table->add_row(
					'<input type="checkbox" class="flat" id="table_records" name="table_records[]" value="'.$text_image->id.'"><input type="hidden" id="row_sort_order" name="row_sort_order[]" value="' . $text_image->id . '">',
					ucwords($text_image->title),
					$image,
					$text_image->sort_order,
					$status,
					$cell
				);
			}
		}

		// Table open
		$template = array(
			'table_open' => '<table
			id="datatable-responsive"
			class="table table-striped table-bordered dt-responsive nowrap jambo_table bulk_action"
			width="100%" cellspacing="0">',
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

	/**
	 * Update Text Image Sort Order
	 */
	function update_sort_order()
	{
		$page_id = $this->input->post('sort_id');
		$row_sort_order = $this->input->post('row_sort_order');
		$this->Text_image_model->update_sort_order($page_id, $row_sort_order);
	}

	// Add & Edit Text Image
	function add_edit_text_image($page_id, $id = null)
	{
		$data['page_id']	= $page_id;

		if ($id != null)
		{

			$text_image = $this->Text_image_model->get_text_image_by_id($page_id, $id);

			$data['text_image_id']	= $text_image[0]->id;
			$data['text_image_title']	= $text_image[0]->title;
			$data['title_color']	= $text_image[0]->title_color;
			$data['title_position']	= $text_image[0]->title_position;
			$data['text']	= $text_image[0]->text;
			$data['content_title_color'] 	= $text_image[0]->content_title_color;
			$data['content_title_position'] 	= $text_image[0]->content_title_position;
			$data['content_color'] 	= $text_image[0]->content_color;
			$data['content_position'] = $text_image[0]->content_position;
			$data['background_color'] 	= $text_image[0]->background_color;
			$data['image'] 	= $text_image[0]->image;
			$data['image_title'] 	= $text_image[0]->image_title;
			$data['image_alt'] 	= $text_image[0]->image_alt;
			$data['image_position'] 	= $text_image[0]->image_position;
			$data['readmore_btn'] 	= $text_image[0]->readmore_btn;
			$data['button_type'] 	= $text_image[0]->button_type;
			$data['btn_background_color'] 	= $text_image[0]->btn_background_color;
			$data['readmore_label'] 	= $text_image[0]->readmore_label;
			$data['label_color'] 	= $text_image[0]->label_color;
			$data['readmore_url'] 	= $text_image[0]->readmore_url;
			$data['open_new_tab'] 	= $text_image[0]->open_new_tab;
			$data['background_hover'] 	= $text_image[0]->background_hover;
			$data['text_hover'] 	= $text_image[0]->text_hover;
			$data['sort_order'] 	= $text_image[0]->sort_order;
			$data['status'] 	= $text_image[0]->status;
		}
		else
		{
			$data['text_image_id']	= "";
			$data['text_image_title']	= "";
			$data['title_color']	= "";
			$data['title_position']	= "";
			$data['text']	= "";
			$data['content_title_color'] 	= "";
			$data['content_title_position']	= "";
			$data['content_color'] 	= "";
			$data['content_position'] = "";
			$data['background_color'] 	= "";
			$data['image'] 	= "";
			$data['image_title'] 	= "";
			$data['image_alt'] 	= "";
			$data['image_position'] 	= "";
			$data['readmore_btn'] 	= "";
			$data['button_type']	= "";
			$data['btn_background_color']	= "";
			$data['readmore_label']	= "";
			$data['label_color']	= "";
			$data['readmore_url'] 	= "";
			$data['open_new_tab']	= "";
			$data['background_hover']	= "";
			$data['text_hover']	= "";
			$data['sort_order'] 	= "";
			$data['status'] 	= "";
		}
		
		$data['httpUrl']	= $this->admin_header->host_url();
		$data['ImageUrl']	= $this->admin_header->image_url();
		$data['website_folder_name'] = $this->admin_header->website_folder_name();
		$data['title']	= ($id != null) ? 'Edit Text Image' : 'Add Text Image'.' | Administrator';
		$data['heading']	= (($id != null) ? 'Edit' : 'Add').' Text Image';
		$this->load->view('template/meta_head', $data);
		$this->load->view('text_image_header');
		$this->admin_header->index();
		$this->load->view('add_edit_text_image', $data);
		$this->load->view('template/footer_content');
    	$this->load->view('script');
		$this->load->view('template/footer');
	}

	// Insert & Update Text Image
	function insert_update_text_image()
	{
		$page_id  = $this->input->post('page-id');
		$text_image_id  = $this->input->post('text-image-id');

		$continue = $this->input->post('btn_continue');

		$error_config = array(
			array(
				'field'	=> 'sort_order',
				'label'	=> 'Sort Order',
				'rules'	=> 'required'
				));

		$this->form_validation->set_rules($error_config);

		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			if (empty($text_image_id))
			{
				redirect('text_image/add_edit_text_image/'.$page_id);
			}
			else
			{
				redirect('text_image/add_edit_text_image/'.$page_id.'/'.$text_image_id);
			}
		}
		else
		{
			if (empty($text_image_id))
			{
				$insert_id	= $this->Text_image_model->insert_update_text_image_data($page_id);
				$this->session->set_flashdata('success', 'Text Image successfully Created');
				if (isset($continue) && $continue === "Add & Continue")
				{
					$url = 'text_image/add_edit_text_image/'.$page_id.'/'.$insert_id;
				}
				else
				{
					$url = 'text_image/text_image_index/'.$page_id;
				}
			}
			else
			{
				$this->Text_image_model->insert_update_text_image_data($page_id, $text_image_id);
				$this->session->set_flashdata('success', 'Text Image Successfully Updated.');
				if (isset($continue) && $continue === "Update & Continue")
				{
					$url = 'text_image/add_edit_text_image/'.$page_id.'/'.$text_image_id;
				}
				else
				{
					$url = 'text_image/text_image_index/'.$page_id;
				}
			}
			redirect($url);
		}
	}

	// Delete Text Image
	function delete_text_image($page_id)
	{
		$this->Text_image_model->delete_text_image($page_id);
		$this->session->set_flashdata('success', 'Text Image Successfully Deleted.');
		redirect('text_image/text_image_index/'.$page_id);
	}

	// Delete multiple Text Image
	function delete_multiple_text_image()
	{
		$page_id	= $this->input->post('page_id');
		$this->form_validation->set_rules(
			'table_records[]',
			'Row',
			'required',
			array(
				'required' => 'You must select at least one row!'
			)
		);

		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('error', validation_errors());
			redirect('text_image/text_image_index/'.$page_id);
		}
		else
		{
			$this->Text_image_model->delete_multiple_text_image();
			$this->session->set_flashdata('success', 'Successfully Deleted');
			redirect('text_image/text_image_index/'.$page_id);
		}
	}

	// Remove Image
	function remove_image()
	{
		$this->Text_image_model->remove_image();
		echo '1';
	}

}
