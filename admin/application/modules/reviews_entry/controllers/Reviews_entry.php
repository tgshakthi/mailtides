<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Reviews_entry extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('logged_in'))
		{
			redirect('login');
		}
		$this->load->module('admin_header');
		$this->load->model('Review_entry_model');
		$this->load->module('color');
	}
	
	function reviews_entry_index($page_id)
	{
		$data['website_id'] = $this->admin_header->website_id();
		$data['page_id'] = $page_id;
		// All Image Card in a table
		$data['table'] = $this->get_table($page_id);
		$data['heading'] = 'Reviews';
		$data['title'] = "Reviews Entry | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('review_entry_header');
		$this->admin_header->index();
		$this->load->view('view', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}
	// Table
	function get_table($page_id)
	{	
		$data['website_id'] = $this->admin_header->website_id();
		$review_entrys = $this->Review_entry_model->get_reviews_entry($data['website_id'],$page_id);
		if (isset($review_entrys) && $review_entrys != "")
		{
			foreach($review_entrys as $review_entry)
			{
				$anchor_edit = anchor(
					'reviews_entry/add_edit_review_entry/' . $page_id . '/' . $review_entry->id,
					'<span class="glyphicon c_edit_icon glyphicon-edit" aria-hidden="true"></span>',
					array(
						'data-toggle' => 'tooltip',
						'data-placement' => 'left',
						'data-original-title' => 'Edit'
					)
				);
				
				$anchor_delete = anchor('', '<span class="glyphicon c_delete_icon glyphicon-trash" aria-hidden="true"></span>', array(
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'right',
                    'data-original-title' => 'Delete',
                    'onclick' => 'return delete_record(' . $review_entry->id . ', \'' . base_url('reviews_entry/delete_multiple_reviews_entry/' . $page_id) . '\')'
                ));
				if ($review_entry->publish === '1')
				{
					$publish = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
				}
				else
				{
					$publish = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
				}
				$cell = array(
					'class' => 'last',
					'data' => $anchor_edit
				);

				$this->table->add_row(
					'<input type="checkbox" class="flat" id="table_records" name="table_records[]" value="' . $review_entry->id . '"><input type="hidden" id="row_sort_order" name="row_sort_order[]" value="' . $review_entry->id . '">',
					ucwords($review_entry->name) ,
					$review_entry->source,
					$review_entry->rating,
					$publish,
					$review_entry->sort_order,
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
			'Name',
			'Source',
			'Rating',
			'Publish',
			'Sort Order',
			'Action'
		));
		return $this->table->generate();
	}
	
	function add_edit_review_entry($page_id,$id=null)
	{
		$data['website_id'] = $this->admin_header->website_id();
		$data['reviews_entry_id'] = $id;
		$data['page_id'] = $page_id;
		if ($data['reviews_entry_id'] != null)
		{
			$review_entry_by_id = $this->Review_entry_model->get_reviews_entry_by_id($data['website_id'],$data['reviews_entry_id']);
		
			$data['name'] =$review_entry_by_id[0]->name;
			$data['email'] =$review_entry_by_id[0]->email;
			$data['reviews'] =$review_entry_by_id[0]->review;
			$data['ratings'] =$review_entry_by_id[0]->rating;
			$data['source'] =$review_entry_by_id[0]->source;
			$data['source_url'] =$review_entry_by_id[0]->source_url;
			$data['publish'] =$review_entry_by_id[0]->publish;
			$data['sort_order'] =$review_entry_by_id[0]->sort_order;
			$data['date_updated'] = $review_entry_by_id[0]->created_at;
		}
		else
		{
			$data['name'] ="";
			$data['email'] ="";
			$data['reviews'] ="";
			$data['ratings'] ="";
			$data['source'] ="";
			$data['source_url'] ="";
			$data['publish'] ="";
			$data['sort_order'] ="";
			$data['date_updated'] = "";
		}
		
		
		// All Image Card in a table
		$data['heading'] = 'Add Edit Reviews';
		$data['title'] = "Add Reviews Entry | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('review_entry_header');
		$this->admin_header->index();
		$this->load->view('edit_review', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}
	function insert_update_review_entry()
	{
		$continue = $this->input->post('btn_continue');
		$website_id = $this->input->post('website_id');
		$page_id = $this->input->post('page_id');
		$review_id = $this->input->post('reviews_entry_id');
		$review_entry = $this->Review_entry_model->insert_update_review_entry($website_id,$review_id);
		$this->session->set_flashdata('success', 'Circular Image Successfully Updated.');
		if (isset($continue) && $continue === "Update & Continue")
		{
			$url = 'reviews_entry/add_edit_review_entry/' . $page_id . '/' . $review_id;
		}
		else
		{
			$url = 'reviews_entry/reviews_entry_index/' . $page_id;
		}
		redirect($url);
	}
	
	// Mail Config
	function mail_config()
	{
		$data['website_id']   = $this->admin_header->website_id();
        $data['review_entry_mail_config'] = $this->Review_entry_model->get_review_entry_mail_config($data['website_id'], 'review_entry_mail_config');
        
        if (!empty($data['review_entry_mail_config'])):
            $keys = json_decode($data['review_entry_mail_config'][0]->key);
			$values = json_decode($data['review_entry_mail_config'][0]->value);
			$i = 0;
			foreach($keys as $key)
			{
				$data[$key] = $values[$i];
				$i++;
			}
        else:
            $data['mail_subject']    = "";
            $data['from_name']       = "";
			$data['message_content'] = "";
			$data['success_title'] = "";
			$data['success_message'] = "";
            $data['to_address']      = "";
            $data['cc']              = "";
            $data['bcc']             = "";
            $data['status']          = "";
        endif;
        
        $data['heading'] = 'Review Entry- Mail Configuration';
        $data['title']   = 'Review Entry- Mail Configuration | Administrator';
        $this->load->view('template/meta_head', $data);
        $this->load->view('review_entry_header');
        $this->admin_header->index();
        $this->load->view('mail_config');
        $this->load->view('template/footer_content');
        $this->load->view('script');
        $this->load->view('template/footer');
	}

	// Insert Update Newsletter Mail config
	function insert_update_review_entry_mail_configure()
	{
		$btn_continue = $this->input->post('btn_continue');
		$this->Review_entry_model->insert_update_review_entry_mail_configure();
		if (!empty($btn_continue) && $btn_continue === 'Save & Continue' || $btn_continue === 'Update & Continue') :
			$url = 'reviews_entry/mail_config';
		else :
			$url = 'reviews_entry/mail_config';
		endif;
		redirect($url);
	}
	
	function delete_multiple_reviews_entry()
	{
		$page_id = $this->input->post('page_id');
        $this->form_validation->set_rules('table_records[]', 'Row', 'required', array(
            'required' => 'You must select at least one row!'
        ));
        
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('reviews_entry/reviews_entry_index/' . $page_id);
        } else {
            $this->Review_entry_model->delete_multiple_reviews_entry();
            $this->session->set_flashdata('success', 'Successfully Deleted');
            redirect('reviews_entry/reviews_entry_index/' . $page_id);
        }
	}
}