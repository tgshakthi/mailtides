<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">

                    <div class="x_title">
                        <?php echo heading($heading, '2');?>
                            <div class="clearfix"></div>
                    </div>

                    <div class="x_content">

                        <menu id="nestable-menu">
                            <button type="button" class="btn btn-primary" data-action="expand-all">Expand All</button>
                            <button type="button" class="btn btn-primary" data-action="collapse-all">Collapse All</button>
                        </menu>                        
                            
                        <div class="cf nestable-lists">
                            <div class="dd" id="nestable">
                                <h3 class="heading">Menu List</h3>
                                <?php 
                                    if (isset($unselected_menus) && !empty($unselected_menus)) :
                                        echo '<ol class="dd-list">';
                                        foreach ($unselected_menus as $unselected_menu) :
                                            echo '<li class="dd-item" data-id="'.$unselected_menu->menu_id.'">
                                                <div class="dd-handle">
                                                    '.$unselected_menu->menu_name.'
                                                </div>
                                            </li>';
                                        endforeach;
                                        echo '</ol>';
                                    else :
                                        echo '<div class="dd-empty"></div>';
                                    endif;
                                ?>
                            </div>
                            <div class="dd" id="nestable2">
                                <h3 class="heading">Admin Menu</h3>
                                <?php 
                                    if (isset($selected_menus) && !empty($selected_menus)) :
                                        echo '<ol class="dd-list">';
                                        foreach ($selected_menus as $selected_menu) : 
                                            echo '<li class="dd-item" data-id="'.$selected_menu->menu_id.'">
                                                <div class="dd-handle">
                                                    '.$selected_menu->menu_name.'
                                                </div>';

                                                $child_selected_menus = $this->Admin_menu_model->get_child_menu_list(
                                                    $user_role_id,                                                    
                                                    $selected_menu->menu_id
                                                );

                                                if (isset($child_selected_menus) && !empty($child_selected_menus)) :
                                                    echo '<ol class="dd-list">';
                                                    foreach ($child_selected_menus as $child_selected_menu) {
                                                        echo '<li class="dd-item" data-id="'.$child_selected_menu->menu_id.'">
                                                            <div class="dd-handle">'.$child_selected_menu->menu_name.'</div>
                                                        </li>';
                                                    }
                                                    echo '</ol>';
                                                endif;

                                            echo '</li>';
                                        endforeach;
                                        echo '</ol>';
                                    else :
                                        echo '<div class="dd-empty"></div>';
                                    endif;
                                ?>
                            </div>
                        </div>                       
                        
                        <!-- Button Group --> 

                        <?php 
                            echo br('1');

                            echo form_open('admin_menu/insert_assign_menu');

                                echo '<div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="input-button-group">';

                                echo form_input(array(
                                    'type'  => 'hidden',
                                    'name'  => 'user_role_id',
                                    'value' => $user_role_id
                                ));

                                echo form_textarea(array(                                    
                                    'name'  => 'output_data',
                                    'id'    => 'nestable-output',
                                    'style' => 'display:none'                                    
                                ));

                                echo form_textarea(array(                                    
                                    'name'  => 'output_update',
                                    'id'    => 'nestable2-output',                                    
                                    'style' => 'display:none'
                                ));

                                echo form_input(array(
                                    'type'  => 'submit',
                                    'value' => 'Publish',
                                    'class' => 'btn btn-success'
                                ));

                                echo anchor(
                                    site_url('user_role'),
                                    'Back',
                                    array(
                                        'title' => 'Back',
                                        'class' => 'btn btn-primary'
                                    )
                                );

                                echo '</div></div>';

                            echo form_close();

                            echo br(2);
                        ?>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->