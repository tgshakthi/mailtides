<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="">

                    <div class="x_title">
                        <?php echo heading($heading, '2');?>

                        <div style="text-align:right;">
                            <?php
                            echo anchor(
                                'blog',
                                '<i class="fa fa-chevron-left" aria-hidden="true"></i> Back',
                                array(
                                    'class' => 'btn btn-primary'
                                )
                            );
                            ?>
                        </div>
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

                            <ul id="myTab1" class="nav nav-tabs bar_tabs right" role="tablist">
                                <li role="presentation"
                                    class="<?php echo ($this->session->flashdata('tab') === 'seo')  ? 'active' : '';?>">
                                    <a href="#seo" id="preview-tabb" role="tab" data-toggle="tab" aria-controls="seo"
                                        aria-expanded="true">
                                        SEO
                                    </a>
                                </li>
                                <li role="presentation"
                                    class="<?php echo ($this->session->flashdata('tab') === 'rating')  ? 'active' : '';?>">
                                    <a href="#rating" role="tab" id="rating-tab" data-toggle="tab"
                                        aria-controls="rating" aria-expanded="false">
                                        Rating
                                    </a>
                                </li>
                                <li role="presentation"
                                    class="<?php echo ($this->session->flashdata('tab') == '' || $this->session->flashdata('tab') === 'blog')  ? 'active' : '';?>">
                                    <a href="#blog_detail" role="tab" id="blog-detail-tab" data-toggle="tab"
                                        aria-controls="blog_detail" aria-expanded="false">
                                        Blog Detail
                                    </a>
                                </li>
                            </ul>

                            <div id="myTabContent2" class="tab-content">

                                <div role="tabpanel"
                                    class="tab-pane fade <?php echo ($this->session->flashdata('tab') == '' || $this->session->flashdata('tab') === 'blog')  ? 'active in' : '';?>"
                                    id="blog_detail" aria-labelledby="page-detail-tab">

                                    <?php
									// Break tag
									echo br();

									// Form Tag
									echo form_open_multipart(
										'blog/insert_update_blog',
										'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate autocomplete="off"'
									);

									// Input tag hidden
									echo form_input(array(
										'type'  => 'hidden',
										'name'  => 'blog_id',
										'id'    => 'blog_id',
										'value' => $blog_id
									));

									// Input tag hidden
									echo form_input(array(
										'type'  => 'hidden',
										'name'  => 'tab',
										'id'    => 'tab',
										'value' => 'blog'
									));

									// Input tag hidden
									echo form_input(array(
										'type'  => 'hidden',
										'name'  => 'category_url',
										'id'    => 'category_url',
										'value' => base_url().'blog/select_blog_category'
									));

									// Input tag hidden
									echo form_input(array(
										'type'  => 'hidden',
										'name'  => 'category_select_url',
										'id'    => 'category_select_url',
										'value' => base_url().'blog/selected_category'
									));

									// Input tag hidden
									echo form_input(array(
										'type'  => 'hidden',
										'name'  => 'website_id',
										'id'    => 'website_id',
										'value' => $website_id
									));
									?>

                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="x_panel">
                                            <div class="x_title">
                                                <?php
												echo heading('Choose Image', '2');
												$list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
												$attributes = array('class' => 'nav navbar-right panel_toolbox');
												echo ul($list,$attributes);
												?>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="x_content">

                                                <div class="form-group">

                                                    <?php
													echo form_label('Select Category <span class="required">*</span>','category','class="control-label col-md-3 col-sm-3 col-xs-12"');
													?>

                                                    <div class="col-md-5 col-sm-5 col-xs-12">
                                                        <?php
														// Select2 Dropdown
														$attributes = array(
															'name'	=> 'category',
															'required' => 'required',
															'id'	=> 'category',
															'class'	=> 'form-control col-md-7 col-xs-12'
														);

														echo form_dropdown($attributes, array(), '');

														// Input tag hidden
														echo form_input(array(
															'type'  => 'hidden',
															'name'  => 'category_id',
															'id'    => 'category_id',
															'value' => $category
														));
														?>
                                                    </div>
                                                    <div class="col-md-1 col-sm-1 col-xs-12">
                                                        <?php
														// Add Category Button
														echo form_button(array(
															'title'      => 'Add Category',
															'type'       => 'button',
															'class'      => 'btn btn-success btn-add',
															'data-toggle' => 'modal',
															'data-target' => '#add_category',
															'content'    => '<span class="glyphicon glyphicon-plus"></span>'
														));
														?>
                                                    </div>

                                                </div>

                                                <div class="form-group">

                                                    <?php
													// label
													echo form_label(
														'Image <span class="required">(Recommended 597*497)</span>',
														'imgInp',
														'class="control-label col-md-3 col-sm-3 col-xs-12"'
													);
													?>

                                                    <div class="img-thumbnail sepH_a" id="show_image1">
                                                        <?php
														if ($image != '') :

															$blog_img = $ImageUrl . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR . $image;
															
															echo img(array(
																'src'   => $blog_img,
																'alt'   => $image_alt,
																'title' => $image_title,
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
														'name'  => 'image',
														'id'    => 'image',
														'value' => $image
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
                                                        data-target="#ImagePopUp" href="javascript:;" type="button">
                                                        Select Image
                                                    </a>

                                                    <?php if($image != "") :?>
                                                    <a data-toggle="modal" class="btn btn-primary" id="imageRemove"
                                                        data-target="#image-confirm-delete" href="javascript:;">
                                                        Remove Image
                                                    </a>
                                                    <?php endif;?>
                                                </div>

                                                <!-- FileManager -->
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
                                                                    src="<?php echo $ImageUrl ;?>filemanager/dialog.php?type=1&field_id=image&rootfldr=<?php echo $website_folder_name;?>/"
                                                                    frameborder="0"
                                                                    style="overflow: scroll; overflow-x: hidden; overflow-y: scroll; "></iframe>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Confirm Delete Modal -->
                                                <div class="modal fade" id="image-confirm-delete" tabindex="-1"
                                                    role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">

                                                            <div class="modal-header">
                                                                Confirm Delete
                                                            </div>

                                                            <div class="modal-body">
                                                                <p>You are about to delete this Image</p>
                                                                <p>Do you want to proceed?</p>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <?php
																echo form_button(array(
																	'type'         => 'button',
																	'class'        => 'btn btn-default',
																	'data-dismiss' => 'modal',
																	'content'      => 'Cancel'
																));
																?>
                                                                <a class="btn btn-danger" id="btn_ok">Delete</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">

                                                    <?php
													echo form_label('Image Title','image_title','class="control-label col-md-3 col-sm-3 col-xs-12"');
													?>

                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <?php
														// Input tag
														echo form_input(array(
															'id'       => 'image_title',
															'name'     => 'image_title',
															'class'    => 'form-control col-md-7 col-xs-12',
															'value'    => $image_title
														));
														?>
                                                    </div>

                                                </div>

                                                <div class="form-group">

                                                    <?php
													echo form_label('Image Alt','image_alt','class="control-label col-md-3 col-sm-3 col-xs-12"');
													?>

                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <?php
														// Input tag
														echo form_input(array(
															'id'       => 'image_alt',
															'name'     => 'image_alt',
															'class'    => 'form-control col-md-7 col-xs-12',
															'value'    => $image_alt
														));
														?>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- Title & Content -->
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="x_panel">

                                            <div class="x_title">
                                                <?php
													echo heading('Title & Contents', '2');
													$list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
													$attributes = array('class' => 'nav navbar-right panel_toolbox');
													echo ul($list,$attributes);
												?>
                                                <div class="clearfix"></div>
                                            </div>

                                            <div class="x_content">

                                                <div class="form-group">

                                                    <?php
														echo form_label('Title <span class="required">*</span>','title');

														// Input tag
														echo form_input(array(
															'id'       => 'title',
															'name'     => 'title',
															'required' => 'required',
															'class'    => 'form-control',
															'value'    => $blog_title
														));
													?>

                                                </div>

                                                <div class="form-group">

                                                    <?php
														echo form_label('Short Description','text');

														// TextArea
														$data = array(
															'name'        => 'short_description',
															'id'          => 'text',
															'value'       => $short_description
														);
														echo form_textarea($data);
													?>

                                                </div>

                                                <div class="form-group">

                                                    <?php
														echo form_label('Description','text2');

														// TextArea
														$data = array(
															'name'        => 'description',
															'id'          => 'text2',
															'value'       => $description
														);
														echo form_textarea($data);
													?>

                                                </div>

                                                <div class="form-group">

                                                    <?php
														echo form_label('Date','create_date');														
													?>
                                                    <div class='input-group date' id='myDatepicker2'>
                                                        <?php
															// Input tag
															echo form_input(array(
																'id'       => 'created_at',
																'name'     => 'create_date',
																'class'    => 'form-control',
																'value'    => $create_date
															));
														?>
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>

                                                </div>

                                                <div class="form-group">

                                                    <?php
														echo form_label('Created by <span class="required">*</span>','created_by');

														// Input tag
														echo form_input(array(
															'id'       => 'created_by',
															'name'     => 'created_by',
															'required' => 'required',
															'class'    => 'form-control',
															'value'    => $created_by
														));
													?>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- Title & Content -->

                                    <!-- Customize Title & Content -->
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="x_panel">

                                            <div class="x_title">
                                                <?php
													echo heading('Customize Title & Contents', '2');
													$list = array(
														'<a title="Customize Title & Contents" data-toggle = "tooltip" data-placement = "left" onclick="customize_blog_title_content()">
															<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
														</a>',
														'<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>'
													);
													$attributes = array('class' => 'nav navbar-right panel_toolbox');
													echo ul($list,$attributes);
												?>
                                                <div class="clearfix"></div>
                                            </div>

                                            <div class="x_content">

                                                <div class="form-group">

                                                    <?php

														echo form_label('Title Color','title_color');

														// Input tag hidden
														echo form_input(array(
																'type'  => 'hidden',
																'name'  => 'title_color',
																'id'    => 'title_color',
																'value' => $title_color
														));

														// Input tag
														$this->color->view($title_color, 'title_color', 1);
													?>

                                                </div>

                                                <div class="form-group">

                                                    <?php

														echo form_label('Title Position','title_position');

														$options = array(
															'left-align'	=> 'Left',
															'center-align' => 'Center',
															'right-align' => 'Right'
														);

														$attributes = array(
															'name' => 'title_position',
															'id' => 'title_position',
															'class'	=> 'form-control'
														);

														echo form_dropdown($attributes, $options, $title_position);
													?>

                                                </div>

                                                <div class="form-group">

                                                    <?php

														echo form_label('Short Description Title Color', 'short_description_title_color');

														// Input tag hidden
														echo form_input(array(
															'type'  => 'hidden',
															'name'  => 'short_description_title_color',
															'id'    => 'short_description_title_color',
															'value' => $short_description_title_color
														));

														// Color
														$this->color->view($short_description_title_color, 'short_description_title_color', 2);
													?>

                                                </div>

                                                <div class="form-group">

                                                    <?php

														echo form_label('Short Description Title Position','short_desc_title_position');

														$options = array(
															'left-align'	=> 'Left',
															'center-align'	=> 'Center',
															'right-align'	=> 'Right',
														);

														$attributes = array(
															'name' => 'short_description_title_position',
															'id' => 'short_description_title_position',
															'class'	=> 'form-control'
														);

														echo form_dropdown($attributes, $options, $short_description_title_position);
													?>

                                                </div>

                                                <div class="form-group">

                                                    <?php

														echo form_label('Short Description Color','short_desc_color');

														// Input tag hidden
														echo form_input(array(
																'type'  => 'hidden',
																'name'  => 'short_description_color',
																'id'    => 'short_description_color',
																'value' => $short_description_color
														));

														// Color
														$this->color->view($short_description_color, 'short_description_color', 3);
													?>

                                                </div>

                                                <div class="form-group">

                                                    <?php

														echo form_label('Short Description Position','short_desc_position');

														$options = array(
															'left-align'	=> 'Left',
															'center-align'	=> 'Center',
															'justify-align' => 'Justify',
															'right-align'	=> 'Right',
														);

														$attributes = array(
															'name' => 'short_description_position',
															'id' => 'short_description_position',
															'class'	=> 'form-control'
														);

														echo form_dropdown($attributes, $options, $short_description_position);
													?>

                                                </div>

                                                <div class="form-group">

                                                    <?php

														echo form_label('Description Title Color','desc_title_color');

														// Input tag hidden
														echo form_input(array(
																'type'  => 'hidden',
																'name'  => 'description_title_color',
																'id'    => 'description_title_color',
																'value' => $description_title_color
														));

														// Color
														$this->color->view($description_title_color, 'description_title_color', 4);
													?>

                                                </div>

                                                <div class="form-group">

                                                    <?php

														echo form_label('Description Title Position','description_title_position');

														$options = array(
															'left-align'	=> 'Left',
															'center-align'	=> 'Center',
															'right-align'	=> 'Right',
														);

														$attributes = array(
															'name' => 'description_title_position',
															'id' => 'description_title_position',
															'class'	=> 'form-control'
														);

														echo form_dropdown($attributes, $options, $description_title_position);
													?>

                                                </div>

                                                <div class="form-group">

                                                    <?php

														echo form_label('Description Color','description_color');

														// Input tag hidden
														echo form_input(array(
																'type'  => 'hidden',
																'name'  => 'description_color',
																'id'    => 'description_color',
																'value' => $description_color
														));

														// Color
														$this->color->view($description_color, 'description_color', 5);
													?>

                                                </div>

                                                <div class="form-group">

                                                    <?php

														echo form_label('Description Position','description_position');

														$options = array(
															'left-align'	=> 'Left',
															'center-align'	=> 'Center',
															'justify-align' => 'Justify',
															'right-align'	=> 'Right',
														);

														$attributes = array(
															'name' => 'description_position',
															'id' => 'description_position',
															'class'	=> 'form-control'
														);

														echo form_dropdown($attributes, $options, $description_position);
													?>

                                                </div>

                                                <div class="form-group">

                                                    <?php

														echo form_label('Date Color','date_color');

														// Input tag hidden
														echo form_input(array(
																'type'  => 'hidden',
																'name'  => 'date_color',
																'id'    => 'date_color',
																'value' => $date_color
														));

														// Color
														$this->color->view($date_color, 'date_color', 6);
													?>

                                                </div>


                                                <div id="customize_blog_title_content" style="display:none">
                                                    <?php echo br(1); ?>

                                                    <div class="x_title">
                                                        <?php echo heading('Customize Title & Contents on Hover', '2'); ?>
                                                        <div class="clearfix"></div>
                                                    </div>

                                                    <div class="form-group">

                                                        <?php

															echo form_label('Title Hover Color','title_hover_color');

															// Input tag hidden
															echo form_input(array(
																	'type'  => 'hidden',
																	'name'  => 'title_hover_color',
																	'id'    => 'title_hover_color',
																	'value' => $title_hover_color
															));

															// Color
															$this->color->view($title_hover_color, 'title_hover_color', 7);
														?>

                                                    </div>

                                                    <div class="form-group">
                                                        <?php

															echo form_label(
																'Short Description Title Hover Color',
																'short_description_title_hover_color'
															);

															// Input tag hidden
															echo form_input(array(
																'type'  => 'hidden',
																'name'  => 'short_description_title_hover_color',
																'id'    => 'short_description_title_hover_color',
																'value' => $short_description_title_hover_color
															));

															// Color
															$this->color->view($short_description_title_hover_color, 'short_description_title_hover_color', 8);
														?>


                                                    </div>

                                                    <div class="form-group">
                                                        <?php

															echo form_label(
																'Short Description Hover Color',
																'short_description_hover_color'
															);

															// Input tag hidden
															echo form_input(array(
																'type'  => 'hidden',
																'name'  => 'short_description_hover_color',
																'id'    => 'short_description_hover_color',
																'value' => $short_description_hover_color
															));

															// Color
															$this->color->view($short_description_hover_color, 'short_description_hover_color', 9);
														?>


                                                    </div>

                                                    <div class="form-group">
                                                        <?php

															echo form_label(
																'Short Description Background Hover Color',
																'short_description_background_hover_color'
															);

															// Input tag hidden
															echo form_input(array(
																'type'  => 'hidden',
																'name'  => 'short_description_background_hover_color',
																'id'    => 'short_description_background_hover_color',
																'value' => $short_description_background_hover_color
															));

															// Color
															$this->color->view($short_description_background_hover_color, 'short_description_background_hover_color', 10);
														?>

                                                    </div>

                                                    <div class="form-group">
                                                        <?php

															echo form_label(
																'Description Title Hover Color',
																'description_title_hover_color'
															);

															// Input tag hidden
															echo form_input(array(
																'type'  => 'hidden',
																'name'  => 'description_title_hover_color',
																'id'    => 'description_title_hover_color',
																'value' => $description_title_hover_color
															));

															// Color
															$this->color->view($description_title_hover_color, 'description_title_hover_color', 11);
														?>
                                                    </div>

                                                    <div class="form-group">
                                                        <?php

															echo form_label(
																'Description Hover Color',
																'description_hover_color'
															);

															// Input tag hidden
															echo form_input(array(
																'type'  => 'hidden',
																'name'  => 'description_hover_color',
																'id'    => 'description_hover_color',
																'value' => $description_hover_color
															));

															// Color
															$this->color->view($description_hover_color, 'description_hover_color', 12);
														?>
                                                    </div>

                                                    <div class="form-group">
                                                        <?php

															echo form_label(
																'Description Background Hover Color',
																'description_background_hover_color'
															);

															// Input tag hidden
															echo form_input(array(
																'type'  => 'hidden',
																'name'  => 'description_background_hover_color',
																'id'    => 'description_background_hover_color',
																'value' => $description_background_hover_color
															));

															// Color
															$this->color->view($description_background_hover_color, 'description_background_hover_color', 13);
														?>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- Customize Title & Content -->

                                    <!-- Redirect -->
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="x_panel">

                                            <div class="x_title">
                                                <?php
													echo heading('Redirect', '2');
													$list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
													$attributes = array('class' => 'nav navbar-right panel_toolbox');
													echo ul($list,$attributes);
												?>
                                                <div class="clearfix"></div>
                                            </div>

                                            <div class="x_content">

                                                <div class="form-group">
                                                    <?php
                                                        echo form_label(
                                                            'Blog URL <span class="required">*</span>',
                                                            'blog_url',
                                                            'class="control-label col-md-3 col-sm-3 col-xs-12"'
                                                        );
                                                    ?>

                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <?php
                                                            // Input tag
                                                            echo form_input(array(
                                                                'id'       => 'blog_url',
                                                                'name'     => 'blog_url',
                                                                'class'    => 'form-control col-md-7 col-xs-12',
                                                                'value'    => $blog_url
                                                            ));
                                                        ?>
                                                        <span id="error_result"></span>
                                                    </div>
                                                </div>

                                                <div class="form-group ">
                                                    <?php
                                                        echo form_label(
                                                            'Open New Tab',
                                                            'open_new_tab',
                                                            'class="control-label col-md-3 col-sm-3 col-xs-12"'
                                                        );
                                                    ?>

                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <?php
                                                            // Input checkbox
                                                            echo form_checkbox(array(
                                                                'id'      => 'open_new_tab',
                                                                'name'    => 'open_new_tab',
                                                                'class'   => 'js-switch',
                                                                'checked' => ($open_new_tab === '1') ? TRUE : FALSE,
                                                                'value'   => $open_new_tab
                                                            ));
                                                        ?>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- Redirect -->

                                    <!-- Sort Order & Background  -->
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="x_panel">

                                            <div class="x_title">
                                                <?php
													echo heading('Sort Order & Status', '2');
													$list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
													$attributes = array('class' => 'nav navbar-right panel_toolbox');
													echo ul($list,$attributes);
												?>
                                                <div class="clearfix"></div>
                                            </div>

                                            <div class="x_content">

                                                <div class="form-group">
                                                    <?php
														echo form_label('Background Color','background_color','class="control-label col-md-3 col-sm-3 col-xs-12"');

														// Input tag hidden
														echo form_input(array(
															'type'  => 'hidden',
															'name'  => 'background_color',
															'id'    => 'background_color',
															'value' => $background_color
														));
													?>

                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <?php
															// Color
															$this->color->view($background_color, 'background_color', 21);
														?>
                                                    </div>
                                                </div>

                                                <div class="form-group">

                                                    <?php
														// label
														echo form_label(
															'Image <span class="required">* Recommended size(1200*700)</span>',
															'imgInp',
															'class="control-label col-md-3 col-sm-3 col-xs-12"'
														);
													?>

                                                    <div class="img-thumbnail sepH_a" id="show_image3">
                                                        <?php
															if ($background_image != '') :

																$blog_bg_img = $ImageUrl . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR . $background_image;
																
																echo img(array(
																	'src'   => $blog_bg_img,
																	'id'    => 'image_preview4',
																	'style' => 'width:168px; height:114px'
																));

															else :

																echo img(array(
																	'src'   => $ImageUrl.'images/noimage.png',
																	'alt'   => 'No Image',
																	'id'    => 'image_preview3',
																	'style' => 'width:168px; height:114px'
																));

															endif;
														?>
                                                    </div>

                                                    <div style="display:none" class="img-thumbnail sepH_a"
                                                        id="show_image4">
                                                        <?php
															echo img(array(
																'src'   => $ImageUrl.'images/noimage.png',
																'alt'   => 'No Image',
																'id'    => 'image_preview4',
																'style' => 'width:168px; height:114px'
															));
														?>
                                                    </div>

                                                    <?php
														echo form_input(array(
															'type'  => 'hidden',
															'name'  => 'background-image',
															'id'    => 'background-image',
															'value' => $background_image
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
                                                        data-target="#ImagePopUp-background" href="javascript:;"
                                                        type="button">
                                                        Select Image
                                                    </a>

                                                </div>

                                                <!-- FileManager -->
                                                <div class="modal fade" id="ImagePopUp-background">
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
                                                                    src="<?php echo $ImageUrl ;?>filemanager/dialog.php?type=1&field_id=background-image&rootfldr=<?php echo $website_folder_name;?>/"
                                                                    frameborder="0"
                                                                    style="overflow: scroll; overflow-x: hidden; overflow-y: scroll; "></iframe>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <?php
														echo form_label(
															'Sort Order <span class="required">*</span>',
															'sort_order',
															'class="control-label col-md-3 col-sm-3 col-xs-12"'
														);
													?>

                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <?php
															// Input tag
															echo form_input(array(
																'id'       => 'sort_order',
																'name'     => 'sort_order',
																'required' => 'required',
																'class'    => 'form-control col-md-7 col-xs-12',
																'value'    => $sort_order
															));
														?>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <?php
														echo form_label(
															'Status',
															'status',
															'class="control-label col-md-3 col-sm-3 col-xs-12"'
														);
													?>

                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <?php
															// Input checkbox
															echo form_checkbox(array(
																'id'      => 'status',
																'name'    => 'status',
																'class'   => 'js-switch',
																'checked' => ($status === '1') ? TRUE : FALSE,
																'value'   => $status
															));
														?>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>

                                    <!-- Button Group -->
                                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                                        <div class="input-button-group">
                                            <?php
											// Submit Button
											if (empty($blog_id)) :
												$submit_value = 'Add';
											else :
												$submit_value = 'Update';
											endif;

											echo form_submit(
												array(
													'class' => 'btn btn-success',
													//'id'    => 'btn',
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
												'blog',
												'Back',
												array(
													'title' => 'BAck',
													'class' => 'btn btn-primary'
												)
											);

											echo br(3);

											?>
                                        </div>
                                    </div>

                                    <?php echo form_close(); //Form close ?>

                                    <?php
									echo form_open(
										'blog/insert_category',
										'id="form_selected_records"'
									);
									?>

                                    <!-- Add Category Modal -->
                                    <div class="modal fade" id="add_category" tabindex="-1" role="dialog"
                                        aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <?php
													// Modal Close Button
													echo form_button(array(
														'title'        => 'Close',
														'class'	    => 'close',
														'type'         => 'button',
														'data-dismiss' => 'modal',
														'content'      => '&times;'
													));

													// Modal Heading
													echo heading('Add Category', 4, 'class="modal-title"');
													?>
                                                </div>

                                                <div class="modal-body">
                                                    <?php
													// Input tag Website ID
													echo form_input(array(
													  'type'  => 'hidden',
													  'name'  => 'website_id',
													  'id'    => 'website_id',
													  'value' => $website_id
													));

													echo form_input(array(
														'type'  => 'hidden',
														'name'  => 'base_url',
														'id'    => 'base_url',
														'value' => base_url()
													));
													?>

                                                    <div class="form-group">

                                                        <?php
														echo form_label('Category Name <span class="required">*</span>','name','class="control-label col-md-3 col-sm-3 col-xs-12"');
														?>

                                                        <div class="col-md-8 col-sm-8 col-xs-12"
                                                            style="padding-bottom:10px">
                                                            <?php
															// Input tag
															echo form_input(array(
																'id'       => 'category_name',
																'name'     => 'name',
																'required' => 'required',
																'class'    => 'form-control col-md-7 col-xs-12',
																'value'    => ''
															));
															?>
                                                        </div>
                                                        <span id="error"></span>
                                                    </div>

                                                    <div class="form-group">
                                                        <?php
															echo form_label(
																'Sort Order <span class="required">*</span>',
																'sort_order',
																'class="control-label col-md-3 col-sm-3 col-xs-12"'
															);
														?>

                                                        <div class="col-md-8 col-sm-8 col-xs-12"
                                                            style="padding-bottom:10px">
                                                            <?php
																// Input tag
																echo form_input(array(
																	'id'       => 'sort_order',
																	'name'     => 'sort_order',
																	'required' => 'required',
																	'class'    => 'form-control col-md-7 col-xs-12',
																	'value'    => ''
																));
															?>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <?php
															echo form_label(
																'Status',
																'status',
																'class="control-label col-md-3 col-sm-3 col-xs-12"'
															);
														?>

                                                        <div class="col-md-8 col-sm-8 col-xs-12"
                                                            style="padding-bottom:10px">
                                                            <?php
																// Input checkbox
																echo form_checkbox(array(
																	'id'      => 'status',
																	'name'    => 'status',
																	'class'   => 'js-switch',
																	'value'   => ''
																));
															?>
                                                        </div>
                                                    </div>

                                                </div>

                                                <?php echo br(1); ?>

                                                <div class="modal-footer">
                                                    <?php
													echo form_button(array(
														'type'         => 'button',
														'id'		   => 'closemodel',
														'class'        => 'btn btn-default',
														'data-dismiss' => 'modal',
														'content'      => 'Close'
													));

													// Form Submit
													echo form_submit(
													  array(
														'class' 		=> 'btn btn-success',
														'id' 		=> 'btn',
														'value' 		=> 'Save'
													  )
													);
													?>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <?php
									// Form Close
									echo form_close();
									?>

                                </div>

                                <div role="tabpanel"
                                    class="tab-pane fade <?php echo ($this->session->flashdata('tab') === 'rating')  ? 'active in' : '';?>"
                                    id="rating" aria-labelledby="page-detail-tab">

                                    <?php if($table != ''): ?>
                                    <!-- Rating content -->
                                    <div class="" role="main">

                                        <div class="">

                                            <div class="page-title">

                                                <div class="title_left">
                                                    <?php echo heading($rating_heading, '3');?>
                                                </div>

                                                <div style="text-align:right;">
                                                    <?php
                                                        echo anchor(
                                                            'blog/customize_blog_rating/'.$blog_id,
                                                            'Customize',
                                                            array(
                                                                'class' => 'btn btn-success'
                                                            )
                                                        );
                                                        ?>
                                                </div>

                                            </div>

                                            <div class="clearfix"></div>

                                        </div>

                                        <div class="x_panel">

                                            <div class="x_content">

                                                <?php
                                                        echo form_open(
                                                            'blog/delete_multiple_blog_rating',
                                                            'id="form_selected_record"'
                                                        );
                                                    ?>

                                                <div class="page_buut_right">

                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">

                                                        <?php

                                                                echo form_input(array(
                                                                    'type'  => 'hidden',
                                                                    'name'  => 'sort_id',
                                                                    'id'    => 'sort_id',
                                                                    'value' => $blog_id
                                                                ));

                                                                echo form_input(array(
                                                                    'type'  => 'hidden',
                                                                    'name'  => 'blog_id',
                                                                    'id'    => 'blog_id',
                                                                    'value' => $blog_id
                                                                ));

                                                                echo form_input(array(
                                                                    'type'  => 'hidden',
                                                                    'name'  => 'sort_url',
                                                                    'id'    => 'sort_url',
                                                                    'value' => base_url().'blog/update_rating_sort_order'
                                                                ));

                                                                echo form_input(array(
                                                                    'type'  => 'hidden',
                                                                    'name'  => 'website_id',
                                                                    'id'    => 'website_id',
                                                                    'value' => $website_id
                                                                ));

                                                                echo form_button(array(
                                                                    'type'    => 'button',
                                                                    'id'	  => 'delete_selected_record',
                                                                    'name'    => 'delete-selected-menu',
                                                                    'class'   => 'btn btn-danger',
                                                                    'content' => '<i class="fa fa-trash-o" aria-hidden="true"></i> Delete'
                                                                ));
                                                            ?>

                                                    </div>

                                                </div>

                                                <div class="row">
                                                    <?php
                                                        // Table
                                                        echo $table;
                                                        ?>
                                                </div>

                                                <?php echo form_close();?>

                                                <!-- Confirm Delete Modal -->
                                                <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog"
                                                    aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">

                                                            <div class="modal-header">
                                                                Confirm Delete
                                                            </div>

                                                            <div class="modal-body">
                                                                <p>Are you sure you want to delete this record?</p>
                                                                <p>Do you want to proceed?</p>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <?php
                                                                            echo form_button(array(
                                                                                'type'         => 'button',
                                                                                    'class'        => 'btn btn-default',
                                                                                    'data-dismiss' => 'modal',
                                                                                    'content'      => 'Cancel'
                                                                            ));
                                                                            ?>
                                                                <a class="btn btn-danger" id="delete_btn_ok">Delete</a>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                    <!-- Rating Content -->
                                    <?php else: ?>
                                    <p style="text-align:center">No Data Found</p>
                                    <?php endif; ?>

                                </div>

                                <div role="tabpanel"
                                    class="tab-pane fade <?php echo ($this->session->flashdata('tab') === 'seo')  ? 'active in' : '';?>"
                                    id="seo" aria-labelledby="page-detail-tab">

                                    <?php
									if(!empty($blog_id)):

										// Form Tag
										echo form_open_multipart(
											'blog/insert_update_blog_seo',
											'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
										);

										// Input tag hidden
										echo form_input(array(
											'type'  => 'hidden',
											'name'  => 'blog_id',
											'id'    => 'blog_id',
											'value' => $blog_id
										));

										// Input tag hidden
										echo form_input(array(
											'type'  => 'hidden',
											'name'  => 'tab',
											'id'    => 'tab',
											'value' => 'seo'
										));

										// Input tag hidden
										echo form_input(array(
											'type'  => 'hidden',
											'name'  => 'website_id',
											'id'    => 'website_id',
											'value' => $website_id
										));
										?>

                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="x_panel">
                                            <div class="x_title">
                                                <?php
													echo heading($seo_heading, '2');
													$list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
													$attributes = array('class' => 'nav navbar-right panel_toolbox');
													echo ul($list,$attributes);
													?>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="x_content">

                                                <div class="form-group">
                                                    <?php
															echo form_label('Meta-Title : <span class="required">*</span>', 'meta-title');

															echo form_input(array(
																'type'      => 'text',
																'name'      => 'meta_title',
																'id'		=> 'meta_title',
																'class'	 => 'form-control',
																'value'	 => $meta_title,
																'required'  => 'required'
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
															echo form_label('Meta-Keyword : <span class="required">*</span>', 'meta-keyword');

															echo form_input(array(
																'type' 			=> 'text',
																'name' 			=> 'meta_keyword',
																'id' 				=> 'meta_keyword',
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
															echo form_label('Meta-Description : <span class="required">*</span>', 'meta-description');

															echo form_textarea(array(
																'name' 			=> 'meta_description',
																'id'   			=> 'meta_description',
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

                                            </div>
                                        </div>
                                    </div>

                                    <!-- Button Group -->
                                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                                        <div class="input-button-group">
                                            <?php
												// Submit Button
												if (empty($blog_id)) :
													$submit_value = 'Add';
												else :
													$submit_value = 'Update';
												endif;

												echo form_submit(
													array(
														'class' => 'btn btn-success',
														//'id'    => 'btn',
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
												
												// Anchor Tag
												echo anchor(
													'blog',
													'Cancel',
													array(
														'title' => 'Cancel',
														'class' => 'btn btn-primary'
													)
												);

												echo br(3);

												?>
                                        </div>
                                    </div>

                                    <?php
										//Form close
										echo form_close();

									else:

										echo "<p style='text-align:center'>No Data Found</p>";

									endif;

									?>

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

<style>

</style>