<?php
class Import_model extends CI_Model
{
	function get_all_data($table_name)
	{
		$this->db->select('*');
		$query = $this->db->get($table_name);
		$records = array();
		if($query->num_rows() > 0) :
			$records = $query->result();
		endif;
		return $records;
	}

	function get_table_list()
	{
		$records = $this->db->list_tables();
		if (!empty($records)):
			$records = $records;
		else:
			$records = '';
		endif;
		return $records;
	}

	function get_table_field_list($table_name)
	{
		$records = $this->db->list_fields($table_name);
		if (!empty($records)):
			$records = $records;
		else:
			$records = '';
		endif;
		return $records;
	}

	function create_preview_table()
	{
		$table_name = $this->input->post('table_name');
		$filePath  = $this->input->post('file_path');
		$temp_tbl  = $table_name.'_temp';

		$this->db->query('DROP TABLE IF EXISTS `'.$temp_tbl.'`;');
		$this->db->query("CREATE TABLE $temp_tbl LIKE $table_name");

		$tablefields = $this->get_table_field_list($table_name);


		if (($handle = fopen($filePath, 'r')) !== FALSE)
		{
			$i = 0;
			while (($datafield = fgetcsv($handle, 1000, ",")) !== FALSE)
			{
				if ($i != 0)
				{
					foreach($tablefields as $tablefields_data)
					{
						if ($tablefields_data != 'id' && $tablefields_data != 'created_at' && $tablefields_data != 'updated_at')
						{
							$current_data = $this->input->post($tablefields_data);
							if ($current_data == 'def')
							{
								$defdaa = 'default_' . $tablefields_data;
								$f_data = $this->input->post($defdaa);
							}
							else
							{
								$f_data = $datafield[$current_data];
							}

							$imp_data[$tablefields_data] = $f_data;
						}
					}

					$this->db->insert($temp_tbl, $imp_data);
				}

				$i++;
			}
		}
	}
}
