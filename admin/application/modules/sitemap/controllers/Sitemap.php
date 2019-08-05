<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Sitemap extends MX_Controller
{
	private $table_name = 'pages';
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('logged_in'))
		{
			redirect('login');
		}
		$this->load->model('Sitemap_model');
		$this->load->module('admin_header');
	}

	function index()
	{
		$data['title'] = 'Sitemap';
		$data['heading'] = 'Sitemap';
		$this->load->view('template/meta_head', $data);
		$this->load->view('sitemap_header');
		$this->admin_header->index();
		$this->load->view('view', $data);
	}

	function generate()
	{
		$xml_data = '';
		$website_id = $this->admin_header->website_id();

		$page_datas = $this->Sitemap_model->page_details($website_id);

		$base_url = str_replace('admin/', '', base_url());

		if(!empty($page_datas)):
			foreach($page_datas as $page_data):
				if($page_data->url == 'index.html'):
					$xml_data .= '<url>
					<loc>'.$base_url.'</loc>
					<lastmod>'.$page_data->updated_at.'</lastmod>
					<changefreq>always</changefreq>
					<priority>1.00</priority>
					</url>';
				else:
					$xml_data .= '<url>
					<loc>'.$base_url.$page_data->url.'</loc>
					<lastmod>'.$page_data->updated_at.'</lastmod>
					<changefreq>always</changefreq>
					<priority>0.80</priority>
					</url>';
				endif;

			endforeach;
		endif;

		$xmlString = '<?xml version="1.0" encoding="UTF-8"?>
		<urlset
		xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
		xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
		xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"
		xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
		'.$xml_data.'
		</urlset>';

		$dom = new DOMDocument;
		$dom->preserveWhiteSpace = FALSE;
		$dom->loadXML($xmlString);
		//Save XML as a file
		$dom->save('../sitemap.xml');
		$this->session->set_flashdata('success', 'Sitemap Generated Successfully.');
		redirect('sitemap');
		
	}
}

?>
