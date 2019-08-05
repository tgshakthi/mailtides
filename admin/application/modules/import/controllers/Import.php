<?php
/**
 * Import
 *
 * @category class
 * @package  Import
 * @author   Saravana
 * Created at:  17-Oct-18
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Import extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->module('admin_header');
		$this->load->model('Import_model');
		$this->load->dbforge();
	}

	function index()
	{
		$data['tables'] = $this->Import_model->get_table_list();
		$data['heading'] = 'Import';
		$data['title'] = "Import | Administrator";
		$this->load->view('template/meta_head', $data);
		$this->load->view('import_header');
		$this->admin_header->index();
		$this->load->view('view', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}

	function import_file()
	{
		$table_name = $this->input->post('table_name');
		$source = $this->input->post('source');
		$fileName = $_FILES['files']['name'];
		$empty_space = '/ /';
		$replace = '-';
		$fileName = preg_replace($empty_space, $replace, $fileName);
		$filecsv = $_FILES['files']['tmp_name'];
		$csv_file = $filecsv; // Name of your CSV file
		if (($handle = fopen($csv_file, 'r')) !== FALSE)
		{
			if (($csvdata = fgetcsv($handle, 1000, ',')) !== FALSE)
			{
				$headcount = count($csvdata);
			}

			$dir = 'Temp/';
			if (!is_dir($dir))
			{
				mkdir($dir);
			}
			else if (file_exists($dir . $fileName))
			{
				unlink($dir . $fileName);
			}

			$file_type = $_FILES["files"]["type"];
			$storagename = getcwd() . '/Temp/' . $fileName;
			move_uploaded_file($_FILES["files"]["tmp_name"], $storagename);
			$csvdata = array_merge($csvdata, array(
				'Default'
			));
			$records['table_name'] = $table_name;
			$records['source'] = $source;
			$records['csv_fields'] = $csvdata;
			$records['filePath'] = $dir . $fileName;;
			$records['field_lists'] = $this->Import_model->get_table_field_list($table_name);
			$data['title'] = 'Field Mapping';
			$this->load->view('template/meta_head', $data);
			$this->load->view('import_header');
			$this->admin_header->index();
			$this->load->view('field_mapping', $records);
			$this->load->view('template/footer_content');
			$this->load->view('script');
			$this->load->view('template/footer');
		}
	}

	function map_value()
	{
		$table_name = $this->input->post('table_name');
		$temp_tbl = $table_name . '_temp';
		$this->Import_model->create_preview_table();
		redirect('import/preview/' . $temp_tbl);
	}

	function preview($table_name)
	{
		$field_lists = $this->Import_model->get_table_field_list($table_name);
		$temp_data = $this->Import_model->get_all_data($table_name);
		$data['table_name'] = $table_name;
		$hdata = '';
		$tbl_value = '';
		if (!empty($field_lists))
		{
			foreach($field_lists as $field_list)
			{
				if ($field_list != 'id' && $field_list != 'created_at' && $field_list != 'updated_at')
				{
					$hdata.= '<th>' . $field_list . '</th>';
				}
			}
		}

		if (!empty($temp_data))
		{
			foreach($temp_data as $table_data)
			{
				$tbl_value.= '<tr>';
				foreach($field_lists as $field_list)
				{
					if ($field_list != 'id' && $field_list != 'created_at' && $field_list != 'updated_at')
					{
						$f_data = $table_data->$field_list;
						$tbl_value.= '<td>' . $f_data . '</td>';
					}
				}
				$tbl_value.= '</tr>';
			}
		}

		$data['table'] = "<table id='test' class='table table-striped table-bordered dTableR'>
			<thead>
				<tr>
					$hdata
				</tr>
			</thead>
			<tbody>
				$tbl_value
			</tbody>
		</table>";

		$data['title'] = 'Field Mapping';
		$data['heading'] = 'Preview Import Data';
		$this->load->view('template/meta_head', $data);
		$this->load->view('import_header');
		$this->admin_header->index();
		$this->load->view('preview', $data);
		$this->load->view('template/footer_content');
		$this->load->view('script');
		$this->load->view('template/footer');
	}

	function table_import()
	{
		$temp_table_name = $this->input->post('table_name');
		$field_lists = $this->Import_model->get_table_field_list($temp_table_name);

		$sel_fld = '';
	    foreach($field_lists as $field_list){
			if($field_list != 'id' && $field_list != 'created_at' && $field_list != 'updated_at'){
				$sel_fld .= $field_list.',';
			}
		}

	 	$sel_fld = trim($sel_fld,',');
		$table_name = str_replace('_temp', '', $temp_table_name);

		$this->db->query("INSERT INTO $table_name ( $sel_fld ) SELECT $sel_fld FROM $temp_table_name");
		$this->db->query('DROP TABLE IF EXISTS `'.$temp_table_name.'`;');


		// $dir = 'Temp/';
		// if (!is_dir($dir))
		// {
		// 	mkdir($dir);
		// }
		// else if (file_exists($dir . $fileName))
		// {
		// 	unlink($dir . $fileName);
		// }

		$this->session->set_flashdata('success', 'Data Successfully Imported');

		redirect('import');
	}

	// function import_file()
	// {
	// 	$create_folder_name = time();
	// 	$folder_name = './Temp/'.$create_folder_name;
	// 	if(!mkdir($folder_name, 0777, true)) :
	// 		die('Permission Denied. Failed to create folder..');
	// 	endif;
	// 	$config['upload_path'] = $folder_name;
	// 	$config['allowed_types'] = 'csv';
	// 	$this->load->library('upload', $config);
	// 	if ( ! $this->upload->do_upload('choose_file'))
	// 	{
	// 		$error = array('error' => $this->upload->display_errors());
	// 		$this->session->set_flashdata('error', $error);
	// 		redirect('import');
	// 	}
	// 	else
	// 	{
	// 		$data['table_name'] = $this->input->post('table_name');
	// 		$data['field_lists'] = $this->Import_model->get_table_field_list($data['table_name']);
	// 		$data['upload_data'] = $this->upload->data();
	// 		$csv_datas = $this->csvreader->parse_file($data['upload_data']['full_path']);
	// 		foreach($csv_datas as $csv_data) :
	// 			$data['csv_fields'] = array_keys($csv_data);
	// 		endforeach;
	// 		$this->load->view('template/meta_head', $data);
	// 		$this->load->view('import_header');
	// 		$this->admin_header->index();
	// 		$this->load->view('field_mapping', $data);
	// 		$this->load->view('template/footer_content');
	// 		$this->load->view('script');
	// 		$this->load->view('template/footer');
	// 	}
	// }

}
