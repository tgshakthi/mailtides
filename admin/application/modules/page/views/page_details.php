<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">

                    <div class="x_title">

                        <?php echo heading($page_title, '2'); ?>

                        <div class="clearfix"></div>

                    </div>

                    <?php if ($this->session->flashdata('success')!='') : // Display session data ?>
                    <div class="alert alert-success alert-dismissible fade in text-center" id="success-alert"
                        role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">×</span>
                        </button>
                        <strong>Success!</strong> <?php echo $this->session->flashdata('success');?>
                    </div>
                    <?php endif; ?>

                    <?php if ($this->session->flashdata('error') != '') : // Display session data ?>
                    <div class="alert alert-warning alert-dismissible fade in text-center" id="warning-alert"
                        role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">×</span>
                        </button>
                        <strong><?php echo $this->session->flashdata('error');?></strong>
                    </div>
                    <?php endif; ?>

                    <div class="x_content">

                        <div class="" role="tabpanel" data-example-id="togglable-tabs">

                            <?php
								if (($this->session->flashdata('tab') != 'seo') && ($this->session->flashdata('tab') != 'seo_screen_formula')) :
									$active_in = 'active in';
									$active = 'active';
								else :
									$active_in = '';
									$active = '';
								endif;
							?>

                            <ul id="myTab1" class="nav nav-tabs bar_tabs right" role="tablist">
                                <li role="presentation" class="">
                                    <a href="#preview" id="preview-tabb" role="tab" data-toggle="tab"
                                        aria-controls="preview" aria-expanded="true">
                                        Preview
                                    </a>
                                </li>
                                <li role="presentation"
                                    class="<?php echo  ($this->session->flashdata('tab') === 'seo_screen_formula')  ? 'active' : '';?>">
                                    <a href="#seo_screen_formula" role="tab" id="seo-screen-formula-tabb"
                                        data-toggle="tab" aria-controls="seo_screen_formula" aria-expanded="false">
                                        SEO Screen Formula
                                    </a>
                                </li>
                                <li role="presentation"
                                    class="<?php echo  ($this->session->flashdata('tab') === 'seo')  ? 'active' : '';?>">
                                    <a href="#seo" role="tab" id="seo-tabb" data-toggle="tab" aria-controls="seo"
                                        aria-expanded="false">
                                        SEO
                                    </a>
                                </li>
                                <li role="presentation" class="<?php echo $active;?>">
                                    <a href="#page_detail" role="tab" id="page-detail-tabb3" data-toggle="tab"
                                        aria-controls="page_detail" aria-expanded="false">
                                        Page Detail
                                    </a>
                                </li>
                            </ul>

                            <div id="myTabContent2" class="tab-content">
                                <div role="tabpanel" class="tab-pane fade <?php echo $active_in;?>" id="page_detail"
                                    aria-labelledby="page-detail-tab">

                                    <?php
										if (isset($page_title) && $page_title !="") {
											echo form_open(
												'page/insert_update_page_detail',
												'class="form-horizontal form-label-left"'
											);
									?>
                                    <div class="formSep">
                                        <div class="form-group">
                                            <?php echo form_label('Page Contents : ( drag boxes to define position on page )'); ?>

                                            <ul id="sortable-row" class="sort_table_list">

                                                <?php
													echo form_input(array(
														'type'	=> 'hidden',
														'name'	=> 'page-detail',
														'value'	=> 'page-detail'
													));

													echo form_input(array(
														'type'	=> 'hidden',
														'id'		=> 'id',
														'name'	=> 'id',
														'value'	=> $page_id
													));

													echo form_input(array(
														'type'  => 'hidden',
														'name'	=> 'row_order',
														'id'    => 'row_order'
													));

													if (isset($page_components) && $page_components !="")
													{
														foreach ($page_components as $page_component)
														{
															$components = $this->Page_model->get_componentsby_id($page_component->component_id);
															$components = (empty($components)) ? $this->Page_model->get_common_componentsby_id($page_component->component_id): $components;
															if ($page_component->component_name == $components[0]->name) {
												?>

                                                <li id="<?php echo ucwords($page_component->component_name);?>">
                                                    <?php

														echo form_checkbox(array(
															'name'		=> 'chk_com[]',
															'id'			=> trim(strtolower($page_component->component_name)),
															'value'		=> $page_component->component_name,
															'checked'	=> ($page_component->status == '1')? TRUE : FALSE,
															'class'		=> 'flat'
														));

														// echo form_label(
														// 	ucwords($page_component->component_name),
														// 	trim(strtolower($page_component->component_name))
														// );

														echo anchor(
															base_url().$components[0]->url.'/'.$page_id,
															ucwords($page_component->component_name)
														);
													?>
                                                </li>
                                                <?php } } } ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="ln_solid"></div>

                                    <!-- Button Group -->

                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="input-button-group">
                                            <?php

												// Submit Button
												if (empty($page_id)) :
													$submit_value = 'Add';
												else :
													$submit_value = 'Update';
												endif;

												echo form_submit(
													array(
														'class' 	=> 'btn btn-success',
														'value' 	=> $submit_value,
														'onclick'	=> 'return content_order()',
													)
												);

												echo form_submit(
													array(
														'class' 	=> 'btn btn-success',
														'id'    	=> 'btn',
														'name'  	=> 'btn_continue',
														'value' 	=> $submit_value.' & Continue',
														'onclick'	=> 'return content_order()',
													)
												);
												// Anchor Tag
												echo anchor(
													'page',
													'Back',
													array(
														'title' => 'Back',
														'class' => 'btn btn-primary'
													)
												);
											?>
                                        </div>
                                    </div>

                                    <?php	echo form_close(); } else { ?>

                                    <div class="alert alert-danger alert-dismissible fade in text-center" role="alert">
                                        <?php
											echo form_button(array(
												'type' 					=> 'button',
												'class'					=> 'close',
												'data-dismiss'	=> 'alert',
												'aria-label' 		=> 'Close',
												'content'				=> '<span aria-hidden="true">x</span>'
											));
											echo heading('This Page is Disabled. Please Enable it', '4');
											echo anchor(
												site_url('page/add_edit_page/'.$page_id),
												'Please Click Here to Enable',
												array(
													'class'		=> 'btn btn-primary',
													'target'	=>	'_blank',
												)
											);
										?>
                                    </div>
                                    <?php }?>

                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-s-12">
                                            <div class="x_panel">

                                                <div class="x_title">
                                                    <?php
														echo heading(
															'Menu Image & Content',
															'2'
														);
													?>
                                                    <div class="clearfix"></div>
                                                </div>

                                                <div class="x_content">

                                                    <?php
														echo form_open(
															'page/insert_update_menu_detail',
															'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
														);
													?>

                                                    <div class="formSep">

                                                        <div class="form-group">

                                                            <?php
																echo form_label(
																	'Menu Image : <span class="required">Recommended(170x141)</span> ',
																	'menu_image',
																	array(
																		'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
																	)
																);

																echo form_input(
																	array(
																		'type' => 'hidden',
																		'name' => 'page_id',
																		'value' => $page_id
																	)
																);
															?>

                                                            <div class="img-thumbnail sepH_a" id="show_image1">
                                                                <?php
																	if ($page_menu_image != '') :

																		$page_menu_image = $ImageUrl . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR . $page_menu_image;
																			
																		echo img(array(
																				'src'   => $page_menu_image,
																				'id'    => 'image_preview',
																				'style' => 'width:168px; height:114px'
																		));

																	else :

																		echo img(array(
																				'src'   => $ImageUrl.'images/noimage.png',
																				'alt'   => 'No Image',
																				'id'    => 'image_preview',
																				'style' => 'width:168px; height:114px'
																		));

																	endif;
																?>
                                                            </div>

                                                            <div style="display:none" class="img-thumbnail sepH_a"
                                                                id="show_image2">
                                                                <?php
																	echo img(array(
																		'src'   => $ImageUrl.'images/noimage.png',
																		'alt'   => 'No Image',
																		'id'    => 'image_preview2',
																		'style' => 'width:168px; height:114px'
																	));
																?>
                                                            </div>

                                                            <?php
																echo form_input(array(
																	'type'  => 'hidden',
																	'name'  => 'image1',
																	'id'    => 'image1',
																	'value' => ''
																));

																echo form_input(array(
																	'type'  => 'hidden',
																	'name'  => 'image',
																	'id'    => 'image',
																	'value' => $page_menu_image
																));

																echo form_input(array(
																	'type'  => 'hidden',
																	'name'  => 'image_url',
																	'id'    => 'image_url',
																	'value' => $ImageUrl
																));

																echo form_input(array(
																	'type'  => 'hidden',
																	'name'  => 'httpUrl',
																	'id'    => 'httpUrl',
																	'value' => $httpUrl
																));
															?>

                                                            <a data-toggle="modal" class="btn btn-primary"
                                                                data-target="#ImagePopUp" href="javascript:;"
                                                                type="button">
                                                                Select Image
                                                            </a>


                                                        </div>

                                                        <div class="modal fade" id="ImagePopUp">
                                                            <div class="modal-dialog popup-width">
                                                                <div class="modal-content">

                                                                    <div class="modal-header">
                                                                        <?php
																			echo form_button(array(
																					'name'         => '',
																					'type'         => 'button',
																					'class'        => 'close',
																					'data-dismiss' => 'modal',
																					'aria-hidden'  => 'true',
																					'content'      => '&times;'
																			));
																		?>
                                                                    </div>

                                                                    <div class="modal-body">
                                                                        <iframe width="880" height="400"
                                                                            src="<?php echo $ImageUrl ;?>filemanager/dialog.php?type=2&field_id=image&rootfldr=<?php echo $website_folder_name;?>/"
                                                                            frameborder="0"
                                                                            style="overflow: scroll; overflow-x: hidden; overflow-y: scroll;">
                                                                        </iframe>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="form-group">
                                                            <?php
																echo form_label(
																	'Menu Content :',
																	'menu_content',
																	array(
																		'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
																	)
																);
															?>

                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                <?php
																	echo form_textarea(
																		array(
																			'name' => 'menu_content',
																			'id' => 'text',
																			'class' => 'form-control col-md-7 col-xs-12',
																			'value' => $page_menu_content
																		)
																	);
																?>
                                                            </div>

                                                        </div>

                                                        <div class="form-group">
                                                            <?php
																echo form_label(
																	'Status',
																	'menu_status',
																	array(
																		'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
																	)
																);
															?>

                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                <?php
																	// Input checkbox
																	echo form_checkbox(array(
																		'id'      => 'menu_status',
																		'name'    => 'menu_status',
																		'class'   => 'js-switch',
																		'checked' => ($page_menu_status === '1') ? TRUE : FALSE,
																		'value'   => $page_menu_status
																	));
																?>
                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="ln_solid"></div>

                                                    <!-- Button Group -->
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <div class="input-button-group">
                                                            <?php
																// Submit Button
																if (empty($menu_contents)) :
																	$submit_value = 'Add';
																else :
																	$submit_value = 'Update';
																endif;

																echo form_submit(
																	array(
																		'class' => 'btn btn-success',
																		'id'    => 'btn-menu',
																		'value' => $submit_value
																	)
																);

																echo form_submit(
																	array(
																		'class' => 'btn btn-success',
																		'id'    => 'btn-menu-continue',
																		'name'  => 'btn_menu_continue',
																		'value' => $submit_value.' & Continue'
																	)
																);

																// Anchor Tag
																echo anchor(
																	'page',
																	'Back',
																	array(
																		'title' => 'Back',
																		'class' => 'btn btn-primary'
																	)
																);
																echo br(3);
															?>
                                                        </div>
                                                    </div>

                                                    <?php echo form_close();?>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- <div class="formSep">
										<div class="form-group">
											<?php
												echo form_label('H1 : <span class="required">*</span>', 'h1_tag');

												echo form_input(array(
													'type'  		=> 'text',
													'name'  		=> 'h1_tag',
													'id'    		=> 'h1_tag',
													'class' 		=> 'form-control',
													'value' 		=> $h1_tag,
													'required'	=> 'required'
												));
											?>
										</div>
									</div> -->
                                </div>


                                <div role="tabpanel"
                                    class="tab-pane fade <?php echo (($this->session->flashdata('tab') === 'seo')) ? 'active in' : '';?> "
                                    id="seo" aria-labelledby="seo-tab">
                                    <?php
										echo form_open(
											site_url('page/insert_update_seo'),
											'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
										);
										echo form_input(array(
											'type'	=> 'hidden',
											'name'	=> 'seo',
											'value'	=> 'seo'
										));
										echo form_input(array(
											'type'	=> 'hidden',
											'name'	=> 'page_id',
											'value'	=> $page_id
										));
										echo form_input(array(
											'type' 	=> 'hidden',
											'name'	=> 'seo_id',
											'value'	=> $seo_id
										));
									?>
                                    <div class="formSep">

                                        <div class="form-group">
                                            <?php
												echo form_label('H1 : <span class="required">*</span>', 'h1_tag');

												echo form_input(array(
													'type'  		=> 'text',
													'name'  		=> 'h1_tag',
													'id'    		=> 'h1_tag',
													'class' 		=> 'form-control',
													'value' 		=> $h1_tag,
													'required'	=> 'required'
												));
											?>
                                        </div>

                                        <div class="form-group">
                                            <?php
												echo form_label('H2 : <span class="required">*</span>', 'h2_tag');

												echo form_input(array(
													'type'  		=> 'text',
													'name'  		=> 'h2_tag',
													'id'    		=> 'h2_tag',
													'class' 		=> 'form-control',
													'value' 		=> $h2_tag,
													'required'	=> 'required'
												));
											?>
                                        </div>

                                        <!-- <div class="form-group">
											<?php
												echo form_label('Url : <span class="required">*</span>', 'page_url');

												echo form_input(array(
													'type'  		=> 'text',
													'name'  		=> 'page_url',
													'id'    		=> 'page_url',
													'class' 		=> 'form-control',
													'value' 		=> $page_url,
													'required'	=> 'required'
												));
											?>
										</div> -->

                                        <div class="form-group">
                                            <?php
												echo form_label('Meta-Title : <span class="required">*</span>', 'meta-title');

												echo form_input(array(
													'type'      => 'text',
													'name'      => 'meta-title',
													'id'				=> 'meta-title',
													'class'			=> 'form-control',
													'value'			=> $meta_title,
													'required'	=> 'required'
												));

												echo br();

												echo form_input(array(
													'name'  => 'title_num',
													'size'  => 2,
													'value' => 70,
													'style' => 'width:auto;border:none; padding:0px;margin:0px;'
												));

												echo 'Characters Left Remaining for Meta Title';
												echo br();
											?>
                                        </div>

                                        <div class="form-group">
                                            <?php
												echo form_label('Meta-Description : <span class="required">*</span>', 'meta-description');

												echo form_textarea(array(
													'name' 			=> 'meta-description',
													'id'   			=> 'meta-description',
													'class' 		=> 'form-control',
													'value'			=> $meta_description,
													'required'	=> 'required'
												));

												echo br();

												echo form_input(array(
													'name'  => 'title_num_desc',
													'size'  => 2,
													'value' => 170,
													'style' => 'width:auto;border:none; padding:0px;margin:0px;'
												));

												echo 'Characters Left Remaining for Meta Description';
												echo br();
											?>
                                        </div>

                                        <div class="form-group">
                                            <?php
												echo form_label('Meta-Keyword : <span class="required">*</span>', 'meta-keyword');

												echo form_input(array(
													'type' 			=> 'text',
													'name' 			=> 'meta-keyword',
													'id' 				=> 'meta-keyword',
													'class' 		=> 'form-control',
													'value' 		=> $meta_keyword,
													'required'	=> 'required'
												));

												echo br();

												echo form_input(array(
													'name' 	=> 'title_num_key',
													'size' 	=> 2,
													'value' => 100,
													'style' => 'width:auto;border:none; padding:0px;margin:0px;'
												));
												echo 'Characters Left Remaining for Keyword';
												echo br();
											?>
                                        </div>

                                        <div class="form-group">
                                            <?php
												echo form_label('Meta-Misc : ', 'meta-misc');
												echo form_textarea(array(
													'name' 	=> 'meta-misc',
													'id' 		=> 'meta-misc',
													'cols' 	=> 10,
													'rows' 	=> 3,
													'value' => $meta_misc,
													'class' => 'form-control'
												));
											?>
                                        </div>
                                    </div>

                                    <div class="ln_solid"></div>

                                    <!-- Button Group -->

                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="input-button-group">
                                            <?php
												// Submit Button
												if (empty($seo_id)) :
													$submit_value = 'Add';
												else :
													$submit_value = 'Update';
												endif;

												echo form_submit(
													array(
														'class' => 'btn btn-success',
														'id'    => 'btn',
														'value' => $submit_value
													)
												);

												echo form_submit(
													array(
														'class' => 'btn btn-success',
														'id'    => 'btn',
														'name'  => 'btn_continue',
														'value' => $submit_value.' & Continue'
													)
												);
												
												// Reset Button
												echo form_reset(
													array(
														'class' => 'btn btn-primary',
														'value' => 'Reset'
													)
												);

												// Anchor Tag
												echo anchor(
													'page',
													'Back',
													array(
														'title' => 'Back',
														'class' => 'btn btn-primary'
													)
												);

												echo br('3');
											?>
                                        </div>
                                    </div>

                                    <?php echo form_close();?>

                                </div>
                                <div role="tabpanel"
                                    class="tab-pane fade <?php echo (($this->session->flashdata('tab') === 'seo_screen_formula')) ? 'active in' : '';?>"
                                    id="seo_screen_formula" aria-labelledby="seo-screen-formula-tab">
                                    <?php
										echo form_open(
											site_url('page/insert_update_seo_screen_formula'),
											'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
										);
										echo form_input(array(
											'type'	=> 'hidden',
											'name'	=> 'seo_screen_formula',
											'value'	=> 'seo_screen_formula'
										));
										echo form_input(array(
											'type'	=> 'hidden',
											'name'	=> 'page_id',
											'value'	=> $page_id
										));
										echo form_input(array(
											'type' 	=> 'hidden',
											'name'	=> 'seo_screen_formula_id',
											'value'	=> $seo_screen_formula_id
										));
									?>
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="x_panel">
                                            <div class="x_content">
                                                <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                                    <?php
													echo form_label('Main Keyword :','main_keyword');

													// Input tag
													echo form_input(array(
														'id'       => 'main_keyword',
														'name'     => 'main_keyword',
														'class'    => 'form-control col-md-3 col-sm-6 col-xs-6',
														'value'    => $main_keyword
													));
												?>
                                                </div>
                                                <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                                    <?php
													echo form_label('Secondary Keyword :','secondary_keyword');

													// Input tag
													echo form_input(array(
														'id'       => 'secondary_keyword',
														'name'     => 'secondary_keyword',
														'class'    => 'form-control col-md-3 col-sm-6 col-xs-6',
														'value'    => $secondary_keyword
													));
												?>
                                                </div>
                                                <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                                    <?php
													echo form_label('Main Service :','main_service');

													// Input tag
													echo form_input(array(
														'id'       => 'main_service',
														'name'     => 'main_service',
														'class'    => 'form-control col-md-3 col-sm-6 col-xs-6',
														'value'    => $main_service
													));
												?>
                                                </div>
                                                <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                                    <?php
													echo form_label('Secondary Service :','secondary_service');

													// Input tag
													echo form_input(array(
														'id'       => 'secondary_service',
														'name'     => 'secondary_service',
														'class'    => 'form-control col-md-3 col-sm-6 col-xs-6',
														'value'    => $secondary_service
													));
												?>
                                                </div>
                                                <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                                    <?php
													echo form_label('3rd Service :','3rd_service');

													// Input tag
													echo form_input(array(
														'id'       => '3rd_service',
														'name'     => '3rd_service',
														'class'    => 'form-control col-md-3 col-sm-6 col-xs-6',
														'value'    => $service3
													));
												?>
                                                </div>
                                                <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                                    <?php
													echo form_label('4th Service :','4th_service');

													// Input tag
													echo form_input(array(
														'id'       => '4th_service',
														'name'     => '4th_service',
														'class'    => 'form-control col-md-3 col-sm-6 col-xs-6',
														'value'    => $service4
													));
												?>
                                                </div>
                                                <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                                    <?php
													echo form_label('5th Service :','5th_service');

													// Input tag
													echo form_input(array(
														'id'       => '5th_service',
														'name'     => '5th_service',
														'class'    => 'form-control col-md-3 col-sm-6 col-xs-6',
														'value'    => $service5
													));
												?>
                                                </div>
                                                <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                                    <?php
													echo form_label('6th Service :','6th_service');

													// Input tag
													echo form_input(array(
														'id'       => '6th_service',
														'name'     => '6th_service',
														'class'    => 'form-control col-md-3 col-sm-6 col-xs-6',
														'value'    => $service6
													));
												?>
                                                </div>
                                                <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                                    <?php
													echo form_label('7th Service :','7th_service');

													// Input tag
													echo form_input(array(
														'id'       => '7th_service',
														'name'     => '7th_service',
														'class'    => 'form-control col-md-3 col-sm-6 col-xs-6',
														'value'    => $service7
													));
												?>
                                                </div>
                                                <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                                    <?php
													echo form_label('8th Service :','8th_service');

													// Input tag
													echo form_input(array(
														'id'       => '8th_service',
														'name'     => '8th_service',
														'class'    => 'form-control col-md-3 col-sm-6 col-xs-6',
														'value'    => $service8
													));
												?>
                                                </div>
                                                <div class="form-group col-md-6 col-sm-12 col-xs-12">

                                                    <?php
													  echo form_label('Title Cities :','title_cities');

														$city_options  = array();
														$selected      = array();

														if (!empty($cities)) :
															foreach ($cities as $city) :
																if(!empty($city)):
																	$city_options[$city->name] = $city->name;
																endif;
															endforeach;

															if(!empty($title_cities)):
															  $selected = array_merge($title_cities);
															endif;
														endif;

														$attributes = array(
															'id'        => 'title_cities',
															'name'      => 'title_cities[]',
															'class'     => 'form-control'
														);

														// Dropdown Multiselect
														echo form_multiselect(
															$attributes,
															$city_options,
															$selected
														)
													?>
                                                </div>
                                                <div class="form-group col-md-6 col-sm-12 col-xs-12">

                                                    <?php
														echo form_label('Keyword Cities :','keyword_cities');

											            $city_options  = array();
														$selected      = array();

														if (!empty($cities)) :
															foreach ($cities as $city) :
																if(!empty($city)):
																	$city_options[$city->name] = $city->name;
																endif;
															endforeach;
															if(!empty($keyword_cities)):
															   $selected = array_merge($keyword_cities);
															endif;
														endif;

														$attributes = array(
															'id'        => 'keyword_cities',
															'name'      => 'keyword_cities[]',
															'class'     => 'form-control'
														);

														// Dropdown Multiselect
														echo form_multiselect(
															$attributes,
															$city_options,
															$selected
														)
											  		?>

                                                </div>
                                                <div class="form-group col-md-6 col-sm-12 col-xs-12">

                                                    <?php
												  		echo form_label('Description Cities :','description_cities');

												        $city_options  = array();
														$selected      = array();

														if (!empty($cities)) :
															foreach ($cities as $city) :
																if(!empty($city->id)):
																	$city_options[$city->name] = $city->name;
																endif;
															endforeach;
															if(!empty($description_cities)):
															    $selected = array_merge($description_cities);
															endif;
														endif;

														$attributes = array(
															'id'        => 'description_cities',
															'name'      => 'description_cities[]',
															'class'     => 'form-control'
														);

														// Dropdown Multiselect
														echo form_multiselect(
															$attributes,
															$city_options,
															$selected
														)
												  	?>

                                                </div>
                                                <div class="form-group col-md-6 col-sm-12 col-xs-12">

                                                    <?php
														echo form_label('Description Category :','description_category'); 
													?>

                                                    <select name="description_category" class="form-control">
                                                        <option value="">Select</option>
                                                        <?php foreach($description_categorys as $description_cate) :?>

                                                        <option value="<?php echo $description_cate->category; ?>"
                                                            <?php if($description_cate->category == $description_category) { echo 'selected'; }?>>
                                                            <?php echo $description_cate->category;?>
                                                        </option>
                                                        <?php endforeach;?>
                                                    </select>

                                                </div>
                                                <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                                    <?php
														echo form_label('Description :', 'description');

														echo form_textarea(array(
															'name' => 'description',
															'id' => 'description',
															'class' => 'form-control',
															'value' => $description
														));
													?>
                                                </div>
                                            </div>

                                            <!-- Button Group -->
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="input-button-group">
                                                    <?php
														echo form_button(array(
															'type'    => 'submit',
															'name'    => 'generate',
															'class'   => 'btn btn-primary update_bt',
															'value'   => "generate",
															'content' => 'Generate'
														));

														echo form_button(array(
															'type'    => 'submit',
															'name'    => 'publish',
															'class'   => 'btn btn-primary  save_bt',
															'value'   => "publish",
															'content' => 'Publish'
														));
													?>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="x_panel">
                                            <div class="x_content">
                                                <?php
													echo form_input(array(
														'type' 	=> 'hidden',
														'name'	=> 'id',
														'value'	=> ''
													));
												?>
                                                <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                                    <?php
														echo form_label('Title :', 'title');

														$seo_title = "";

														if ($main_keyword != "")
														{
															$i = 0;
														   $seo_title = $main_keyword." ".$main_service." Company ";
														   if(!empty($title_cities)):
															   foreach ($title_cities as $title_city)
															   {
																   $seo_title .= $title_city;
																   $i++;
																   if($i < count($title_cities))
																   $seo_title .= " | ";
															   }
															endif;
														}
													
														echo form_textarea(array(
															'name'  	  => 'title',
															'id'    	=> 'Title',
															'value'     => $seo_title,
															'class' 	 => 'form-control check_length_val',
															'onkeyup'   => 'return check_length_val(this.id)',
															'onkeydown' => 'return check_length_val(this.id)'
														));
												?>
                                                </div>
                                                <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                                    <?php
														echo form_label('Description :', 'description');

														$seo_desc = "";

														if ($description != "") {
															$i = 0;
															$seo_desc = $description." at ";
															if (!empty($description_cities)) :
																foreach ($description_cities as $description_city)
																{
																	$seo_desc .= $description_city;
																	$i++;
																	if($i < count($description_cities))
																		$seo_desc .= " | ";
																}
															endif;
														}
													
														echo form_textarea(array(
															'name'  	=> 'seodesc',
															'id'    	=> 'description',
															'value'     =>  $seo_desc,
															'class' 	=> 'check_length_val form-control',
															'onkeyup'   => 'return check_length_val(this.id)',
															'onkeydown' => 'return check_length_val(this.id)'
														));
													?>
                                                </div>
                                                <div class="form-group ">
                                                    <?php
														echo form_label('Keywords :', 'keywords');

														$keywords = "";

														if ($main_keyword != "") {
															$keywords = $main_keyword." ".$main_service.", ".$main_keyword." ".$secondary_service.", ".$main_keyword." ".$service3.", ".$main_keyword." ".$service4.", ".$main_keyword." ".$service5.", ".$main_keyword." ".$service6.", ".$main_keyword." ".$service7.", ".$main_keyword." ".$service8.", ".$secondary_keyword." ".$main_service.", ".$secondary_keyword." ".$secondary_service.", ".$secondary_keyword." ".$service3.", ".$secondary_keyword." ".$service4.", ".$secondary_keyword." ".$service5.", ".$secondary_keyword." ".$service6.", ".$secondary_keyword." ".$service7.", ".$secondary_keyword." ".$service8." ";
															$i = 0;
															if(!empty($allcities)):
																foreach ($allcities as $city_name)
																{
																	$keywords .= $city_name;
																	$i++;
																	if($i < count($allcities))
																	$keywords .= " | ";
																}
															endif;
														}

														echo form_textarea(array(
																'name'  	=> 'keywords',
																'id'    	=> 'Keywords',
																'value'     => $keywords,
																'class' 	=> 'check_length_val form-control',
																'onkeyup'   => 'return check_length_val(this.id)',
																'onkeydown' => 'return check_length_val(this.id)'
															));
													?>
                                                </div>
                                                <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                                    <?php
														echo form_label('H1 :', 'h1');

														$h1 = "";
														
														if($main_keyword != "") {
															$h1 = $main_keyword." ".$main_service." Company in ";
															$i = 0;
															if (!empty($title_cities)) :
																foreach ($title_cities as $title_city) {
																	$h1 .= $title_city;
																	$i++;
																	if($i < count($title_cities))
																		$h1 .= " | ";
																}
															endif;
														}
														
														echo form_textarea(array(
															'name'  	  => 'h1_value',
															'id'    	=> 'H1',
															'value'     => $h1,
															'class' 	 => 'check_length_val form-control',
															'onkeyup'   => 'return check_length_val(this.id)',
															'onkeydown' => 'return check_length_val(this.id)'
														));
													?>
                                                </div>
                                                <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                                    <?php
														echo form_label('H2 :', 'h2');

														$h2 = "";

														if($main_keyword != ""){
															$h2 = $main_keyword." ".$secondary_service." Company in ";
															$i = 0;
															if(!empty($title_cities)):
																foreach ($title_cities as $title_city)
																{
																	$h2 .= $title_city;
																	$i++;
																	if($i < count($title_cities))
																	$h2 .= " | ";
																}
															endif;
														}


														echo form_textarea(array(
															'name'  	  => 'h2_value',
															'id'    	=> 'H2',
															'value'     => $h2,
															'class' 	 => 'check_length_val form-control',
															'onkeyup'   => 'return check_length_val(this.id)',
															'onkeydown' => 'return check_length_val(this.id)'
														));
													?>
                                                </div>
                                            </div>
                                            <?php echo form_close();?>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="preview" aria-labelledby="preview-tab">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="input-button-group">
                                            <a href="<?php echo $website_url.$page_url?>" target="_blank"
                                                class="btn btn-primary">
                                                Preview
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->