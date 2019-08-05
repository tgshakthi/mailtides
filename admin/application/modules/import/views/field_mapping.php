<!-- Field Mapping Modal -->
<div class="modal fade" id="web_id" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">

				<div class="modal-header">
					Field Mapping
				</div>

				<?php
					echo form_open(
						'import/map_value',
						'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate enctype="multipart/form-data"'
					);

					echo form_input(
						array(
							'type' => 'hidden',
							'name' => 'file_path',
							'value' => $filePath
						)
					);

					echo form_input(
						array(
							'type' => 'hidden',
							'name' => 'table_name',
							'value' => $table_name
						)
					);
				?>

				<div class="modal-body">

					<?php
						foreach($field_lists as $field_list) :
							if($field_list != 'id' && $field_list != 'created_at' && $field_list != 'updated_at') :
					?>

						<div class="form-group">

							<?php
								echo form_label(
									ucwords(str_replace('_', ' ', $field_list)),
									$field_list,
									array(
										'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
									)
								);
							?>

							<div class="col-md-6 col-sm-6 col-xs-12">

								<select name="<?php echo $field_list;?>" id="<?php echo $field_list;?>" class="form-control select_field">
									<?php
										$i = 0;
										foreach($csv_fields as $head_data) {
											$head_data			=	strtolower($head_data);
									?>
										<option value="<?php echo $i; ?>"><?php echo	$head_data;  ?></option>
									<?php $i++;
										} ?>
									<option value="def">Default</option>
								</select>


								<?php
									// foreach($csv_fields as $csv_field) :

									// 	if($csv_field == 'Default') :
									// 		$options['def'] = $csv_field;
									// 	else:
									// 		$options = $csv_field;
									// 	endif;

									// endforeach;

									// $attributes = array(
									// 	'id' => $field_list,
									// 	'name' => $field_list,
									// 	'class' => 'form-control select_field'
									// );

									// echo form_dropdown($attributes, $options);
								?>

							</div>

						</div>

					<?php
							endif;
						endforeach;
					?>

				</div>

				<div class="modal-footer">
					<?php
						echo anchor(
							'import',
							'Cancel',
							array(
								'class' => 'btn btn-default'
							)
						);

						echo form_submit(
							array(
								'class' => 'btn btn-success submit',
								'name'  => 'import_data',
								'value' => 'Import'
							)
						);
					?>

				</div>

				<?php echo form_close();?>
		</div>
	</div>
</div>

