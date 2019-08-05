<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="">

                    <div class="x_title">
                        <?php echo heading($heading, '2');?>
                        <div class="btn_right" style="text-align:right;">
                            <?php
								echo anchor(
									'banner/banner_index/'.$page_id,
									'<i class="fa fa-chevron-left" aria-hidden="true"></i> Back',
									array(
										'class' => 'btn btn-primary'
									)
								);
							?>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="x_content">

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

                        <?php
                            // Break tag
                            echo br();

                            // Form Tag
                            echo form_open_multipart(
                                'banner/insert_update_banner',
                                'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
                            );

                            // Input tag hidden
                            echo form_input(array(
                                'type'  => 'hidden',
                                'name'  => 'banner-id',
                                'id'    => 'banner-id',
                                'value' => $banner_id
                            ));

                            // Input tag hidden
                            echo form_input(array(
                                'type'  => 'hidden',
                                'name'  => 'page-id',
                                'id'    => 'page-id',
                                'value' => $page_id
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
                                            // label
                                            echo form_label(
                                                'Image <span class="required">* (1200x400 size)</span>',
                                                'imgInp',
                                                'class="control-label col-md-3 col-sm-3 col-xs-12"'
                                            );
                                        ?>

                                        <div class="img-thumbnail sepH_a" id="show_image1">
                                            <?php
                                                if ($image != '') :

                                                $banner_img = $ImageUrl . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR . $image;

                                                    //$thumb_image = str_ireplace('/images/','/thumbs/', $image);
                                                    echo img(array(
                                                        'src'   => $banner_img,
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

                                        <div style="display:none" class="img-thumbnail sepH_a" id="show_image2">
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

                                        <a data-toggle="modal" class="btn btn-primary" data-target="#ImagePopUp"
                                            href="javascript:;" type="button">
                                            Select Image
                                        </a>

                                        <!-- <a data-toggle="modal" class="btn btn-primary" data-target="#ImagePopUptest" href="javascript:;" type="button">
                                            Select Image Test
                                        </a> -->

                                        <?php if($image != "") :?>
                                        <a data-toggle="modal" class="btn btn-primary" id="imageRemove"
                                            data-target="#confirm-delete" href="javascript:;">
                                            Remove Image
                                        </a>

                                        <?php endif;?>
                                    </div>

                                    <!-- FileManager -->
                                    <div class="modal fade" id="ImagePopUptest">
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
                                                        src="<?php echo $ImageUrl; ?>filemanagers/index.php?field_id=image1"
                                                        frameborder="0"
                                                        style="overflow: scroll; overflow-x: hidden; overflow-y: scroll;">
                                                    </iframe>
                                                </div>
                                            </div>
                                        </div>
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
                                                        src="<?php echo $ImageUrl ;?>filemanager/dialog.php?type=2&field_id=image&rootfldr=<?php echo $website_folder_name?>/"
                                                        frameborder="0"
                                                        style="overflow: scroll; overflow-x: hidden; overflow-y: scroll;">
                                                    </iframe>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Confirm Delete Modal -->
                                    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog"
                                        aria-labelledby="myModalLabel" aria-hidden="true">
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
                                            echo form_label('Image Title','banner-image-title','class="control-label col-md-3 col-sm-3 col-xs-12"');
                                        ?>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <?php
                                                // Input tag
                                                echo form_input(array(
                                                    'id'       => 'banner-image-title',
                                                    'name'     => 'banner-image-title',
                                                    'class'    => 'form-control col-md-7 col-xs-12',
                                                    'value'    => $image_title
                                                ));
                                            ?>
                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <?php
                                            echo form_label('Image Alt','banner-image-alt','class="control-label col-md-3 col-sm-3 col-xs-12"');
                                        ?>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <?php
                                                // Input tag
                                                echo form_input(array(
                                                    'id'       => 'banner-image-alt',
                                                    'name'     => 'banner-image-alt',
                                                    'class'    => 'form-control col-md-7 col-xs-12',
                                                    'value'    => $image_alt
                                                ));
                                            ?>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">

                                    <?php
                                        echo heading('Content', '2');
                                        $list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
                                        $attributes = array('class' => 'nav navbar-right panel_toolbox');
                                        echo ul($list,$attributes);
                                    ?>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">

                                    <div class="form-group">
                                        <?php
                                            echo form_label('Title <span class="required"> ( 100 Characters Only ) </span>','title');

                                            // Input tag
                                            echo form_input(array(
                                                'id'       => 'banner-title',
                                                'name'     => 'banner-title',
                                                'class'    => 'form-control',
                                                'value'    => $banner_title,
                                                'data-parsley-trigger' => 'keyup',
                                                'data-parsley-maxlength' => '100' 
                                            ));
                                        ?>
                                    </div>

                                    <div class="form-group">
                                        <?php
                                            echo form_label('Text','text');

                                            // TextArea
                                            $data = array(
                                                'name'        => 'text',
                                                'id'          => 'text',
                                                'class'	   => 'form-control',
                                                'value'       => $text                                
                                            );

                                            echo form_textarea($data);
                                        ?>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <?php
                                        echo heading('Customize Title & Text', '2');
                                        $list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
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
                                            
                                            // Color
                                            $this->color->view($title_color,'title_color',1);
                                        ?>
                                    </div>

                                    <div class="form-group">
                                        <?php
                                            echo form_label('Title Font Size','title_font_size');
                                        ?>
                                        <select name="title_font_size" class="form-control">
                                            <option value="">Select</option>
                                            <?php foreach($numbers as $number) :?>
                                            <option value="<?php echo $number->n; ?>px"
                                                <?php if($number->n.''.'px'== $title_font_size) { echo 'selected'; }?>>
                                                <?php echo $number->n;?> px</option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <?php
                                            echo form_label('Title Font Weight','title_font_weight');

                                            $options = array(
                                                '300' => '300',
                                                                '400' => '400',
                                                                '500' => '500',
                                                                '600' => '600',
                                                                '700' => '700',
                                                                '900' => '900'
                                            );

                                            $attributes = array(
                                                'name' => 'title_font_weight',
                                                'id' => 'title_font_weight',
                                                'class'	=> 'form-control'
                                            );

                                            echo form_dropdown($attributes, $options, $title_font_weight);
                                        ?>
                                    </div>

                                    <div class="form-group">
                                        <?php
                                            echo form_label('Text Color','text_color');

                                            // Input tag hidden
                                            echo form_input(array(
                                                'type'  => 'hidden',
                                                'name'  => 'text_color',
                                                'id'    => 'text_color',
                                                'value' => $text_color
                                            ));

                                            // Color
                                            $this->color->view($text_color,'text_color',2);
                                        ?>
                                    </div>

                                    <div class="form-group">
                                        <?php
                                            echo form_label('Title & Text Position','text-position');
                                            
                                            $options = array(
                                                'Top' => array(
                                                    'position-top-left' => 'Top - Left',
                                                    'position-top-center' => 'Top - Center',
                                                    'position-top-right' => 'Top - Right'
                                                ),
                                                'Center' => array(
                                                    'position-center-left' => 'Center - Left',
                                                    'position-center-center' => 'Center - Center',
                                                    'position-center-right' => 'Center - Right'
                                                ),
                                                'Bottom' => array(
                                                    'position-bottom-left' => 'Bottom - Left',
                                                    'position-bottom-center' => 'Bottom - Center',
                                                    'position-bottom-right' => 'Bottom - Right'
                                                )
                                            );

                                            $attributes = array(
                                                'name' => 'text-position',
                                                'id' => 'text-position',
                                                'class'	=> 'form-control'
                                            );

                                            echo form_dropdown($attributes, $options, $text_position);
                                        ?>
                                    </div>

                                    <div class="form-group">
                                        <?php
                                            echo form_label('Background Transparent Color','bg_transparent_color');

                                            // Input tag hidden
                                            echo form_input(array(
                                                'type'  => 'hidden',
                                                'name'  => 'bg_transparent_color',
                                                'id'    => 'bg_transparent_color',
                                                'value' => $bg_transparent_color
                                            ));

                                            // Color
                                            $this->color->view($bg_transparent_color,'bg_transparent_color', 8);
                                        ?>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <?php
                                        echo heading('Redirect', '2');
                                        $list = array('<a title="Customize Redmore Button" data-toggle = "tooltip" data-placement	= "left" onclick="banner_developer()"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>','<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
                                        $attributes = array('class' => 'nav navbar-right panel_toolbox');
                                        echo ul($list,$attributes);
                                    ?>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">

                                    <div class="form-group ">
                                        <?php
                                            echo form_label(
                                                'Readmore Button',
                                                'readmore_btn',
                                                'class="control-label col-md-3 col-sm-3 col-xs-12"'
                                            );
                                        ?>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <?php
                                                // Input checkbox
                                                echo form_checkbox(array(
                                                    'id'      => 'readmore_btn',
                                                    'name'    => 'readmore_btn',
                                                    'onchange' => 'readmorebtn()',
                                                    'class'   => 'js-switch',
                                                    'checked' => ($readmore_btn === '1') ? TRUE : FALSE,
                                                    'value'   => $readmore_btn
                                                ));
                                            ?>
                                        </div>

                                    </div>

                                    <div id="readmoreurl"
                                        style="display:<?php if($readmore_btn == 1){echo 'block';}else{echo 'none';} ?>">

                                        <div class="form-group">

                                            <?php
                                                echo form_label(
                                                    'Button Type',
                                                    'button_type',
                                                    'class="control-label col-md-3 col-sm-3 col-xs-12"'
                                                );
                                            ?>

                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?php
                                                    $options = array(
                                                        'common-btn'	=> 'Square',
                                                        'common-btn oval'	=> 'Oval',								  
                                                    );

                                                    $attributes = array(
                                                        'name'	=> 'button_type',
                                                        'id'	=> 'button_type',
                                                        'class'	=> 'form-control col-md-7 col-xs-12'
                                                    );

                                                    echo form_dropdown($attributes, $options, $button_type);
                                                ?>
                                            </div>

                                        </div>

                                        <div class="form-group">

                                            <?php
                                                echo form_label(
                                                    'Button Background Color',
                                                    'btn_background_color',
                                                    'class="control-label col-md-3 col-sm-3 col-xs-12"'
                                                );

                                                // Input tag hidden
                                                echo form_input(array(
                                                    'type'  => 'hidden',
                                                    'name'  => 'btn_background_color',
                                                    'id'    => 'btn_background_color',
                                                    'value' => $btn_background_color
                                                ));
                                            ?>

                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?php
                                                    // Color
                                                    $this->color->view($btn_background_color,'btn_background_color',3);
                                                ?>
                                            </div>

                                        </div>

                                        <div class="form-group">

                                            <?php
													echo form_label(
														'Button Position',
														'button_position',
														'class="control-label col-md-3 col-sm-3 col-xs-12"'
													);

												?>

                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?php
                                                    $options = array(
                                                        'right'	=> 'Right',
                                                        'banner_btn_center'	=> 'Center',
                                                        'left'	=> 'Left'
                                                    );

                                                    $attributes = array(
                                                        'name'	=> 'button_position',
                                                        'id'	=> 'button_position',
                                                        'class'	=> 'form-control col-md-7 col-xs-12'
                                                    );

                                                    echo form_dropdown($attributes, $options, $button_position);
                                                ?>
                                            </div>

                                        </div>

                                        <div class="form-group">

                                            <?php
                                                echo form_label(
                                                    'Readmore Label',
                                                    'readmore_label',
                                                    'class="control-label col-md-3 col-sm-3 col-xs-12"'
                                                );
                                            ?>

                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?php
                                                    // Input tag
                                                    echo form_input(array(
                                                        'id'       => 'readmore_label',
                                                        'name'     => 'readmore_label',
                                                        'class'    => 'form-control col-md-7 col-xs-12',
                                                        'value'    => $readmore_label
                                                    ));
                                                ?>
                                            </div>

                                        </div>

                                        <div class="form-group">

                                            <?php
                                                echo form_label(
                                                    'Label Color',
                                                    'label_color',
                                                    'class="control-label col-md-3 col-sm-3 col-xs-12"'
                                                );

                                                // Input tag hidden
                                                echo form_input(array(
                                                    'type'  => 'hidden',
                                                    'name'  => 'label_color',
                                                    'id'    => 'label_color',
                                                    'value' => $label_color
                                                ));
                                            ?>

                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?php
                                                    // Color
                                                    $this->color->view($label_color,'label_color',4);
                                                ?>
                                            </div>

                                        </div>

                                        <div class="form-group">

                                            <?php
                                                echo form_label(
                                                    'Readmore URL <span class="required">*</span>',
                                                    'readmore_url',
                                                    'class="control-label col-md-3 col-sm-3 col-xs-12"'
                                                );
                                            ?>

                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?php
                                                    // Input tag
                                                    echo form_input(array(
                                                        'id'       => 'readmore_url',
                                                        'name'     => 'readmore_url',
                                                        'class'    => 'form-control col-md-7 col-xs-12',
                                                        'value'    => $readmore_url
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

                                    <div id="banner_developer" style="display:none">
                                        <?php echo br(1); ?>
                                        <div class="x_title">
                                            <?php echo heading('Customize Readmore Button', '2'); ?>
                                            <div class="clearfix"></div>
                                        </div>

                                        <div class="form-group">

                                            <?php
                                                echo form_label(
                                                    'Background Hover',
                                                    'background_hover',
                                                    'class="control-label col-md-3 col-sm-3 col-xs-12"'
                                                );

                                                // Input tag hidden
                                                echo form_input(array(
                                                    'type'  => 'hidden',
                                                    'name'  => 'background_hover',
                                                    'id'    => 'background_hover',
                                                    'value' => $background_hover
                                                ));
                                            ?>

                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?php
                                                    // Color
                                                    $this->color->view($background_hover,'background_hover',5);
                                                ?>
                                            </div>

                                        </div>

                                        <div class="form-group">

                                            <?php
                                                echo form_label(
                                                    'Text Hover',
                                                    'text_hover',
                                                    'class="control-label col-md-3 col-sm-3 col-xs-12"'
                                                );

                                                // Input tag hidden
                                                echo form_input(array(
                                                    'type'  => 'hidden',
                                                    'name'  => 'text_hover',
                                                    'id'    => 'text_hover',
                                                    'value' => $text_hover
                                                ));
                                            ?>

                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <?php
                                                    // Color
                                                    $this->color->view($text_hover,'text_hover',6);
                                                ?>
                                            </div>

                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>

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
                                            echo form_label('Sort Order <span class="required">*</span>','sort_order','class="control-label col-md-3 col-sm-3 col-xs-12"');
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
                            <br />
                        </div>

                        <!-- <div class="ln_solid"></div> -->

                        <!-- Button Group -->


                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                            <div class="input-button-group">
                                <?php
                                    // Submit Button
                                    if (empty($banner_id)) :
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
                                        'banner/banner_index/'.$page_id,
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

                        <?php echo form_close(); //Form close ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->