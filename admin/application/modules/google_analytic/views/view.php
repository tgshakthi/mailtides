<!-- Page Content -->

<div class="right_col" role="main">
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 colxs-12">
            <div class="x_panel">

                <div class="x_title">
                    <?php 
                        echo heading($heading, '2');
                    ?>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">

                    <!-- Success Alert -->
                    <?php if ($this->session->flashdata('success') != '') :?>
                        <div class="alert alert-success alert-dismissible fade in text-center" id="success-alert" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">x</span>
                            </button>
                            <strong>Success !</strong>
                            <?php echo $this->session->flashdata('success');?>
                        </div>
                    <?php endif;?>

                    <!-- Warning Alert -->
                    <?php if ($this->session->flashdata('error') != '') :?>
                        <div class="alert alert-warning alert-dismissible fade in text-center" id="warning-alert" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">x</span>
                            </button>
                            <strong><?php echo $this->session->flashdata('error');?></strong>
                        </div>
                    <?php endif;?>

                    <?php
                        // Break tag
                        echo br();

                        // Form Tag
                        echo form_open_multipart(
                            'google_analytic/insert_update',
                            'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
                        );

                        // Input tag hidden
                        echo form_input(
                            array(
                                'type' => 'hidden',
                                'name' => 'analytic-id',
                                'id' => 'analytic-id',
                                'value' => $id
                            )
                        );
                    ?>

                    <div class="form-group">
                        <?php 
                            echo form_label(
                                'Google Analytic Code : <span class="required">*</span>',
                                'google-analytic-code'
                            );

                            echo form_textarea(
                                array(
                                    'class' => 'form-control',
                                    'name' => 'google-analytic-code',
                                    'id' => 'google-analytic-code',
                                    'value' => $analytic_code,
                                    'required' => 'required'
                                )
                            );
                        ?>
                    </div>                    

                    <div class="form-group">
                            
                        <?php
                            // Label
                            echo form_label(
                                'Upload Analytic JSON  Key file : <span class="required">*</span>',
                                'analytic-json-key-file'
                            );
                        ?>
                     
                        <div class="input-group input-file" name="file-upload" <?php echo (!empty($key_json_file)) ? 'style="display: none"'  : ''; ?> >
                            <span class="input-group-btn">
                                <?php
                                    // Choose Button
                                    echo form_button(
                                        array(
                                            'type' => 'button',
                                            'class' => 'btn btn-default btn-choose',
                                            'content' => 'Upload'
                                        )
                                    );
                                ?>
                            </span>

                            <?php
                                // Input Tag
                                echo form_input(
                                    array(
                                        'id' => 'file-upload',
                                        'class' => 'form-control',
                                        'placeholder' => 'Upload JSON Key file '
                                    )
                                );
                            ?>

                            <span class="input-group-btn">
                                <?php
                                    echo form_button(
                                        array(
                                            'type' => 'button',
                                            'class' => 'btn btn-warning btn-reset',
                                            'content' => 'Reset'
                                        )
                                    );
                                ?>
                            </span>

                        </div>
                        
                        <div class="key-result">
                            <?php 
                                if(!empty($key_json_file)) :

                                    echo '<span>'.$key_json_file.'</span>';
                                       
                                    echo form_button(
                                        array(
                                            'id' => 'change-another-key-file',
                                            'class' => 'btn btn-primary',
                                            'content' => 'Change'
                                        )
                                    );

                                    echo form_input(
                                        array(
                                            'type' => 'hidden',
                                            'id' => 'save-exist-file',
                                            'name' => 'file-upload',
                                            'value' => $key_json_file
                                        )
                                    );
                                endif;
                            ?>
                        </div>                        

                    </div>

                    <div class="form-group">
                      <?php 
                        echo form_label(
                            'Status : ',
                            'status'
                        );
                        
                        echo form_checkbox(array(
                            'id'    => 'status',
                            'name'  => 'status',
                            'class' => 'js-switch',
                            'checked' => ($status === '1') ? TRUE : FALSE,
                            'value' => $status
                         ));
                      ?>
                    </div>

                    <div class="In_solid"></div>

                    <!-- Button group -->
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <div class="input_butt">
                        <?php
                            if(empty($id)) :
                                $submit_value = 'Add';
                            else :
                                $submit_value = 'Update';
                            endif;
                            // Submit Button
                            echo form_submit(
                                array(
                                    'class' => 'btn btn-success',
                                    'value' => $submit_value
                                )
                            );
                        ?>
                      </div>
                    </div>

                    <?php echo form_close();?>

                </div>
                
            </div>
        </div>
    </div>    
</div>
<!-- Page Content -->