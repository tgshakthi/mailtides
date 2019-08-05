<?php
    /**
     * Website Choose Component View
     * 
     * @category View
     * @package Choose Component
     * @author Athi
     * 
     * Modified By : Saravana
     * Modified Date : !8-Feb-2019
     */
?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="">

                    <div class="page-title">
                        <div class="title_left">
                            <?php echo heading($heading, '2');?>
                        </div>

                        <div class="title_right">
                            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right">
                                <label class="checkbox-container">
                                    Select All
                                    <input type="checkbox" id="component-select-all"> 
                                    <span class="checkmark"></span>
                                </label>                             
                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div> 

                    <div class="x_content">

                        <?php if ($this->session->flashdata('success') != '') : // Display session data ?>
                        <div class="alert alert-success alert-dismissible fade in text-center" id="success-alert"
                            role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">×</span>
                            </button>
                            <strong>Success!</strong>
                            <?php echo $this->session->flashdata('success');?>
                        </div>
                        <?php endif; ?>

                        <?php if ($this->session->flashdata('error') != '') : // Display session data ?>
                        <div class="alert alert-warning alert-dismissible fade in text-center" id="warning-alert"
                            role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">×</span>
                            </button>
                            <strong>
                                <?php echo $this->session->flashdata('error');?></strong>
                        </div>
                        <?php endif; ?>

                        <?php
                          // Break tag
                          echo br();

                          // Form Tag
                          echo form_open_multipart(
                            'website/selected_components',
                            'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
                          );

                          // Input tag hidden
                          echo form_input(array(
                            'type'  => 'hidden',
                            'name'  => 'id',
                            'id'    => 'id',
                            'value' => $id
                          ));
                        ?>                        

                        <!-- Top Header Components -->
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">

                                <div class="x_title">
                                    <?php echo heading('Top Header Components', '2');?>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="x_content">
                                    <?php
                                        if ( !empty ($top_header_components) ) {
                                            $selected_top_header_component	= ( !empty ($selected_components) && !empty ($selected_components[0]->top_header_components) ) ? explode(',', $selected_components[0]->top_header_components) : array();
                                            foreach ($top_header_components as $top_header_component) {
                                    ?>
                                        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                            <?php $checked	= (in_array($top_header_component->id, $selected_top_header_component)) ? 'checked' : ''; ?>
                                            <input type="checkbox" class="flat" <?php echo $checked;?> id="top_header_components<?php echo $top_header_component->id;?>" name="top_header_component_records[]" value="<?php echo $top_header_component->id;?>">
                                            <?php
                                                // label
                                                echo form_label(
                                                    $top_header_component->name,
                                                    'top_header_components'.$top_header_component->id
                                                );
                                            ?>
                                        </div>
                                    <?php } }?>
                                </div>

                            </div>
                        </div>

                        <!-- Header Components -->
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">

                                <div class="x_title">
                                    <?php echo heading('Header Components', '2');?>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="x_content">
                                    <?php
                                        if ( !empty ($header_components) ) {
                                            $selected_header_component	= ( !empty ($selected_components) && !empty($selected_components[0]->header_components) ) ? explode(',', $selected_components[0]->header_components) : array();
                                            foreach ($header_components as $header_component) {
                                    ?>
                                        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                            <?php $checked	= (in_array($header_component->id, $selected_header_component)) ? 'checked' : ''; ?>
                                            <input type="checkbox" class="flat" <?php echo $checked;?> id="header_components<?php echo $header_component->id;?>" name="header_component_records[]" value="<?php echo $header_component->id;?>">
                                            <?php
                                                // label
                                                echo form_label(
                                                    $header_component->name,
                                                    'header_components'.$header_component->id
                                                );
                                            ?>
                                        </div>
                                    <?php } }?>
                                </div>

                            </div>
                        </div>
                        
                        <!-- Main & Common Components -->
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">

                                <div class="x_title">
                                    <?php echo heading('Page Components', '2');?>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="x_content">
                                    <?php
                                      if ( !empty ($component) ) {
                                          $selected_component	= ( !empty ($selected_components) && !empty($selected_components[0]->components) ) ? explode(',', $selected_components[0]->components) : array();
                                          foreach ($component as $components) {
                                    ?>
                                    <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                        <?php $checked	= (in_array($components->id, $selected_component)) ? 'checked' : ''; ?>
                                        <input type="checkbox" class="flat" <?php echo $checked; ?>
                                            id="components<?php echo $components->id;?>" name="component_records[]"
                                            value="<?php echo $components->id;?>">
                                        <?php
                                            // label
                                            echo form_label(
                                                $components->name,
                                                'components'.$components->id
                                            );
                                        ?>
                                    </div>
                                    <?php } }
                                        if(!empty($common_component)) {
                                            $selected_component	= ( !empty ($selected_components) ) ? explode(',', $selected_components[0]->components) : array();
                                            foreach ($common_component as $components) {
                                    ?>
                                    <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                        <?php $checked	= (in_array($components->code, $selected_component)) ? 'checked' : ''; ?>
                                        <input type="checkbox" class="flat" <?php echo $checked;?>
                                            id="components<?php echo $components->code;?>" name="component_records[]" value="<?php echo $components->code; ?>">
                                        <?php
                                            // label
                                            echo form_label(
                                                $components->name,
                                                'components'.$components->code
                                            );
                                        ?>
                                    </div>
                                    <?php } } ?>

                                </div>

                            </div>
                        </div>

                        <!-- Footer Components -->
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">

                                <div class="x_title">
                                    <?php echo heading('Footer Components', '2');?>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="x_content">
                                    <?php
                                        if ( !empty ($footer_components) ) {
                                            $selected_footer_component	= ( !empty ($selected_components) && !empty($selected_components[0]->footer_components) ) ? explode(',', $selected_components[0]->footer_components) : array();
                                            foreach ($footer_components as $footer_component) {
                                    ?>
                                        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                            <?php $checked	= (in_array($footer_component->id, $selected_footer_component)) ? 'checked' : ''; ?>
                                            <input type="checkbox" class="flat" <?php echo $checked;?> id="footer_components<?php echo $footer_component->id;?>" name="footer_component_records[]" value="<?php echo $footer_component->id;?>">
                                            <?php
                                                // label
                                                echo form_label(
                                                    $footer_component->name,
                                                    'footer_components'.$footer_component->id
                                                );
                                            ?>
                                        </div>
                                    <?php } }?>
                                </div>

                            </div>
                        </div>

                        <!-- Button Group -->

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="input-button-group">
                                <?php
                                    // Submit Button
                                    echo form_submit(
                                    array(
                                        'class' => 'btn btn-success',
                                        'value' => 'Update'
                                    )
                                                        );

                                    echo form_submit(
                                    array(
                                        'class' => 'btn btn-success',
                                        'id'    => 'btn',
                                        'name'  => 'btn_continue',
                                        'value' => 'Update & Continue'
                                    )
                                    );
                                    // Anchor Tag
                                    echo anchor(
                                        'website',
                                        'Back',
                                        array(
                                        'title' => 'Back',
                                        'class' => 'btn btn-primary'
                                        )
                                    );

                                    echo br(4);
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