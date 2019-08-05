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
                                'event',
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
                        <div class="alert alert-success alert-dismissible fade in text-center" id="success-alert" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                            </button>
                            <strong>Success!</strong> <?php echo $this->session->flashdata('success');?>
                        </div>
                    <?php endif; ?>

                    <?php if ($this->session->flashdata('error') != '') : // Display session data ?>
                        <div class="alert alert-warning alert-dismissible fade in text-center" id="warning-alert" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                            </button>
                            <strong><?php echo $this->session->flashdata('error');?></strong>
                        </div>
                    <?php endif; ?>

          			<div class="x_content">

						<?php
                        // Break tag
                        echo br();

                        // Form Tag
                        echo form_open_multipart(
                            'event/insert_update_event',
                            'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate autocomplete="off"'
                        );

                        // Input tag hidden
                        echo form_input(array(
                            'type'  => 'hidden',
                            'name'  => 'event_id',
                            'id'    => 'event_id',
                            'value' => $event_id
                        ));
                        
                        // Input tag hidden
                        echo form_input(array(
                            'type'  => 'hidden',
                            'name'  => 'category_url',
                            'id'    => 'category_url',
                            'value' => base_url().'event/select_event_category'
                        ));
                        
                        // Input tag hidden
                        echo form_input(array(
                            'type'  => 'hidden',
                            'name'  => 'category_select_url',
                            'id'    => 'category_select_url',
                            'value' => base_url().'event/selected_category'
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
                                        echo form_label('Select Category <span class="required">*</span>', 'category', 'class="control-label col-md-3 col-sm-3 col-xs-12"');
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
              
                                                $event_img = $ImageUrl . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR . $image;
                                                echo img(array(
                                                    'src'   => $event_img,
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
              
                                        <a data-toggle="modal" class="btn btn-primary" data-target="#ImagePopUp" href="javascript:;" type="button">
                                            Select Image
                                        </a>
              
                                        <?php if($image != "") :?>
                                            <a data-toggle="modal" class="btn btn-primary" id="imageRemove" data-target="#image-confirm-delete" href="javascript:;">
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
                                                    <iframe width="880" height="400" src="<?php echo $ImageUrl ;?>filemanager/dialog.php?type=1&field_id=image&rootfldr=<?php echo $website_folder_name?>/" frameborder="0" style="overflow: scroll; overflow-x: hidden; overflow-y: scroll; "></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
              
                                    <!-- Confirm Delete Modal -->
                                    <div class="modal fade" id="image-confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                                            echo form_label('Title <span class="required">*</span>','text3');

                                            // Input tag
                                           
                                            $data = array(
                                                'name'        => 'title',
                                                'id'          => 'text3',
                                                'value'       => $event_title
                                            );
                                            echo form_textarea($data);
                                        ?>

                                    </div>

                                    <div class="form-group">

                                        <?php
                                            echo form_label('Short Description','text1');

                                          
                                            // TextArea
                                            $data = array(
                                                'name'        => 'short_description',
                                                'id'          => 'text1',
                                                'value'       => $short_description
                                            );
                                            echo form_textarea($data);
                                        ?>

                                    </div>

                                    <div class="form-group">

                                        <?php
                                            echo form_label('Description <span class="required">Recommended 280 Characters Only</span>','text2');

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
                                            echo form_label('Location','location');

                                            // Input tag
                                            echo form_input(array(
                                                'id'       => 'location',
                                                'name'     => 'location',
                                                'class'    => 'form-control',
                                                'value'    => $location
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
                                         '<a title="Customize Title & Contents" data-toggle = "tooltip" data-placement = "left" onclick="customize_event_title_content()">
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
                                            if(!empty($title_color)):
                                                $this->color->view($title_color, 'title_color', 1);
                                            else:
                                                $this->color->view('black-text', 'title_color', 1);
                                            endif;
                                            
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

                                    <!-- <div class="form-group">

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
                                            if(!empty($short_description_title_color)):
                                                $this->color->view($short_description_title_color, 'short_description_title_color', 2);
                                            else:
                                                $this->color->view('black-text', 'short_description_title_color', 2);
                                            endif;
                                            
                                        ?>

                                    </div> -->

                                    <!-- <div class="form-group">

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

                                    </div> -->

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
                                            if(!empty($short_description_color)):
                                                $this->color->view($short_description_color, 'short_description_color', 3);
                                            else:
                                                $this->color->view('black-text', 'short_description_color', 3);
                                            endif;
                                           
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

                                    <!-- <div class="form-group">

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
                                            if(!empty($description_title_color)):
                                                $this->color->view($description_title_color, 'description_title_color', 4);
                                            else:
                                                $this->color->view('black-text', 'description_title_color', 4);
                                            endif;
                                           
                                        ?>

                                    </div> -->

                                    <!-- <div class="form-group">

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

                                    </div> -->

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
                                            if(!empty($description_color)):
                                                $this->color->view($description_color, 'description_color', 5);
                                            else:
                                                $this->color->view('black-text', 'description_color', 5);
                                            endif;
                                           
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
                                            if(!empty($date_color)):
                                                $this->color->view($date_color, 'date_color', 6);
                                            else:
                                                $this->color->view('black-text', 'date_color', 6);
                                            endif;
                                           
                                        ?>

                                    </div>
                                    
                                    <div class="form-group">

                                        <?php

                                            echo form_label('Location Color','location_color');

                                            // Input tag hidden
                                            echo form_input(array(
                                                    'type'  => 'hidden',
                                                    'name'  => 'location_color',
                                                    'id'    => 'location_color',
                                                    'value' => $location_color
                                            ));

                                            // Color
                                            if(!empty($location_color)):
                                                $this->color->view($location_color, 'location_color', 7);
                                            else:
                                                $this->color->view('black-text', 'location_color', 7);
                                            endif;
                                           
                                        ?>

                                    </div>


                                    <div id="customize_event_title_content" style="display:none">
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
                                                if(!empty($title_hover_color)):
                                                    $this->color->view($title_hover_color, 'title_hover_color', 8);
                                                else:
                                                    $this->color->view('black-text', 'title_hover_color', 8);
                                                endif;
                                                
                                            ?>

                                        </div>

                                        <!-- <div class="form-group">
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
                                                if(!empty($short_description_title_hover_color)):
                                                    $this->color->view($short_description_title_hover_color, 'short_description_title_hover_color', 9);
                                                else:
                                                    $this->color->view('black-text', 'short_description_title_hover_color', 9);
                                                endif;
                                               
                                            ?>


                                        </div> -->

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
                                                if(!empty($short_description_hover_color)):
                                                    $this->color->view($short_description_hover_color, 'short_description_hover_color', 10);
                                                else:
                                                    $this->color->view('black-text', 'short_description_hover_color', 10);
                                                endif;
                                               
                                            ?>


                                        </div>

                                        <!-- <div class="form-group">
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
                                                if(!empty($description_title_hover_color)):
                                                    $this->color->view($description_title_hover_color, 'description_title_hover_color', 11);
                                                else:
                                                    $this->color->view('black-text', 'description_title_hover_color', 11);
                                                endif;
                                               
                                            ?>
                                        </div> -->

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
                                                if(!empty($description_hover_color)):
                                                    $this->color->view($description_hover_color, 'description_hover_color', 12);
                                                else:
                                                    $this->color->view('black-text', 'description_hover_color', 12);
                                                endif;
                                               
                                            ?>
                                        </div>
                                        
                                        <div class="form-group">
                                            <?php

                                                echo form_label(
                                                    'Date Hover Color',
                                                    'date_hover'
                                                );

                                                // Input tag hidden
                                                echo form_input(array(
                                                    'type'  => 'hidden',
                                                    'name'  => 'date_hover',
                                                    'id'    => 'date_hover',
                                                    'value' => $date_hover
                                                ));

                                                // Color
                                                if(!empty($date_hover)):
                                                    $this->color->view($date_hover, 'date_hover', 13);
                                                else:
                                                    $this->color->view('black-text', 'date_hover', 13);
                                                endif;
                                                
                                            ?>
                                        </div>
                                        
                                        <div class="form-group">
                                            <?php

                                                echo form_label(
                                                    'Location Hover Color',
                                                    'location_hover'
                                                );

                                                // Input tag hidden
                                                echo form_input(array(
                                                    'type'  => 'hidden',
                                                    'name'  => 'location_hover',
                                                    'id'    => 'location_hover',
                                                    'value' => $location_hover
                                                ));

                                                // Color
                                                if(!empty($location_hover)):
                                                    $this->color->view($location_hover, 'location_hover', 14);
                                                else:
                                                    $this->color->view('black-text', 'location_hover', 14);
                                                endif;
                                               
                                            ?>
                                        </div>
                                        <div class="form-group">
                                            <?php

                                                echo form_label(
                                                    'Background Hover Color',
                                                    'background_hover'
                                                );

                                                // Input tag hidden
                                                echo form_input(array(
                                                    'type'  => 'hidden',
                                                    'name'  => 'background_hover',
                                                    'id'    => 'background_hover',
                                                    'value' => $background_hover
                                                ));

                                                // Color
                                                if(!empty($background_hover)):
                                                    $this->color->view($background_hover, 'background_hover', 16);
                                                else:
                                                    $this->color->view('white', 'background_hover', 16);
                                                endif;
                                               
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
                                <div class="form-group ">
                                <?php
										echo form_label(
											'External URL',
											'external_btn',
											'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);
									?>
                               
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <?php
										
                                            // Input checkbox
											
                                                echo form_checkbox(array(
                                                    'id'      => 'external_btn',
                                                    'name'    => 'external_btn',
                                                    'class'   => 'js-switch',
                                                    'checked' => ($external_btn === '1') ? TRUE : FALSE,
                                                    'value'   => $external_btn
                                                ));
										?>
                                </div>
                            </div>
                          

                            <div class="form-group">
                                    <?php
											echo form_label(
												'Event URL <span class="required">*</span>',
												'event_url',
												'class="control-label col-md-3 col-sm-3 col-xs-12"'
											);
										?>

                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <?php
												// Input tag
												echo form_input(array(
													'id'       => 'event_url',
													'name'     => 'event_url',
													'class'    => 'form-control col-md-7 col-xs-12',
													'value'    => $event_url
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

                                    <div class="col-md-9 col-sm-9 col-xs-12">
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
                                                if(!empty($background_color)):
                                                    $this->color->view($background_color, 'background_color', 15);
                                                else:
                                                    $this->color->view('white', 'background_color', 15);
                                                endif;
                                               
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

																$event_bg_img = $ImageUrl . 'images' . DIRECTORY_SEPARATOR . $website_folder_name . DIRECTORY_SEPARATOR . $background_image;
																
																echo img(array(
																	'src'   => $event_bg_img,
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

                                    
                                    <!-- <div class="form-group">
                                        <?php
                                            // echo form_label('Background Hover Color','background_hover','class="control-label col-md-3 col-sm-3 col-xs-12"');

                                            // // Input tag hidden
                                            // echo form_input(array(
                                            //     'type'  => 'hidden',
                                            //     'name'  => 'background_hover',
                                            //     'id'    => 'background_hover',
                                            //     'value' => $background_hover
                                            // ));
                                        ?>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <?php
                                                // // Color
                                                // $this->color->view($background_hover, 'background_hover', 16);
                                            ?>
                                        </div>
                                    </div> -->

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
                                if (empty($event_id)) :
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
                                    'event',
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
                        
                        <?php
                        echo form_open(
                            'event/insert_category',
                            'id="form_selected_records"'
                        );
                        ?>
                        
                        <!-- Add Category Modal -->
                        <div class="modal fade" id="add_category" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
            
                                            <div class="col-md-8 col-sm-8 col-xs-12" style="padding-bottom:10px">
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
    
                                            <div class="col-md-8 col-sm-8 col-xs-12" style="padding-bottom:10px">
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
    
                                            <div class="col-md-8 col-sm-8 col-xs-12" style="padding-bottom:10px">
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
          		</div>
        	</div>
      	</div>
	</div>
</div>
<!-- /page content -->

<style> 

</style>
