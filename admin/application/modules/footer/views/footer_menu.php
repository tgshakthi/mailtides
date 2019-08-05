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
                    'footer',
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

            <?php
              // Break tag
              echo br();

              // Form Tag
              echo form_open_multipart(
                'footer/footer_menu/insert_update_menu',
                'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
              );
            ?>

            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">

                  <?php
				  echo heading('Columns & Status', '2');
				  $list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
				  $attributes = array('class' => 'nav navbar-right panel_toolbox');
				  echo ul($list,$attributes);
				  ?>

                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <div class="form-group">

                      <?php
                      echo form_label('No.of column','position','class="control-label col-md-3 col-sm-3 col-xs-12"');
                      ?>

                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php
													$options = array(
														'm6'	=> '2',
														'm4'	=> '3',
														'm3'	=> '4',
														'm2'	=> '6',
													);

													$attributes = array(
														'name'	=> 'position',
														'id'	=> 'position',
														'class'	=> 'form-control col-md-7 col-xs-12'
													);

													echo form_dropdown($attributes, $options, $column);
												?>
                      </div>
                      </div>
                      <div class="x_content">
                      <div class="form-group">

                                   <?php
                                         echo form_label(
                                                         'Main Menu Text Color', 'main_menu_text_color',
                                                           'class="control-label col-md-3 col-sm-3 col-xs-12"'
                                                         );
                                    ?>
                         <div class="col-md-6 col-sm-6 col-xs-12">
                                     <?php

                                          // Input tag hidden

                                          echo form_input(array(
                                                                   'type' => 'hidden',
                                                                    'name' => 'main_menu_text_color',
                                                                     'id' => 'main_menu_text_color',
                                                                     'value' => $main_menu_text_color
                                                                ));

                                            // Color

                                               $this->color->view($main_menu_text_color, 'main_menu_text_color', 3);
                                        ?>
                          </div>
                         </div>
                     </div>
                       <div class="x_content">
                        <div class="form-group">

                                   <?php
                                        echo form_label(
                                                        'Sub Menu Text Color', 'sub_menu_text_color', 
                                                         'class="control-label col-md-3 col-sm-3 col-xs-12"'
                                                       );
                                     ?>
                         <div class="col-md-6 col-sm-6 col-xs-12">
                                     <?php

                                          // Input tag hidden

                                           echo form_input(array(
                                                                 'type' => 'hidden',
                                                                 'name' => 'sub_menu_text_color',
                                                                   'id' => 'sub_menu_text_color',
                                                                  'value' => $sub_menu_text_color
                                                                ));

                                               // Color

                                           $this->color->view($sub_menu_text_color, 'sub_menu_text_color', 4);
                                        ?>
                           </div>
                          </div>
                       </div>
                           <div class="x_content">

                           <div class="form-group">

                                        <?php
                                            echo form_label('Main Menu Hover Text Color', 'main_menu_hover_color', 
                                                             'class="control-label col-md-3 col-sm-3 col-xs-12"'
                                                            );
                                         ?>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                         <?php

                                             // Input tag hidden

                                              echo form_input(array(
                                                                   'type' => 'hidden',
                                                                   'name' => 'main_menu_hover_color',
                                                                     'id' => 'main_menu_hover_color',
                                                                    'value' => $main_menu_hover_color
                                                                   ));

                                                         // Color

                                             $this->color->view($main_menu_hover_color, 'main_menu_hover_color', 5);
                                          ?>
                                </div>
                             </div>
                          </div>
                           <div class="x_content">

                              <div class="form-group">

                                       <?php
                                            echo form_label('Sub Menu Hover  Text Color', 'sub_menu_hover_color', 
                                                             'class="control-label col-md-3 col-sm-3 col-xs-12"'
                                                           );
                                        ?>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                      <?php

                                          // Input tag hidden

                                         echo form_input(array(
                                                                'type' => 'hidden',
                                                                 'name' => 'sub_menu_hover_color',
                                                                    'id' => 'sub_menu_hover_color',
                                                                    'value' => $sub_menu_hover_color
                                                              ));

                                           // Color

                                             $this->color->view($sub_menu_hover_color, 'sub_menu_hover_color', 6);
                                        ?>
                                      </div>
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


            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">

                  <?php
				  echo heading('Customize Footer Menu', '2');
				  $list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
				  $attributes = array('class' => 'nav navbar-right panel_toolbox');
				  echo ul($list,$attributes);
				  ?>

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
                                        echo '<li class="dd-item" data-id="'.$unselected_menu->id.'">
                                            <div class="dd-handle">
                                                '.$unselected_menu->title.'
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
                            <h3 class="heading">Footer Menu List</h3>
                            	<?php
                                if (isset($selected_menus) && !empty($selected_menus)) :
                                    echo '<ol class="dd-list">';
                                    foreach ($selected_menus as $selected_menu) :
                                        echo '<li class="dd-item" data-id="'.$selected_menu->id.'">
                                            <div class="dd-handle">
                                                '.$selected_menu->title.'
                                            </div>';

                                            $child_selected_menus = $this->Footer_menu_model->get_child_menu_list($website_id, $selected_menu->id);

                                            if (isset($child_selected_menus) && !empty($child_selected_menus)) :
                                                echo '<ol class="dd-list">';
                                                foreach ($child_selected_menus as $child_selected_menu) {
                                                    echo '<li class="dd-item" data-id="'.$child_selected_menu->id.'">
                                                        <div class="dd-handle">'.$child_selected_menu->title.'</div>
                                                    </li>';

													$child_selected_menuones = $this->Footer_menu_model->get_child_menu_list($website_id, $child_selected_menu->id);

													if (isset($child_selected_menuones) && !empty($child_selected_menuones)) :
														echo '<ol class="dd-list">';
														foreach ($child_selected_menuones as $child_selected_menuone) {
															echo '<li class="dd-item" data-id="'.$child_selected_menuone->id.'">
																<div class="dd-handle">'.$child_selected_menuone->title.'</div>
															</li>';

															$child_selected_menutwos = $this->Footer_menu_model->get_child_menu_list($website_id, $child_selected_menuone->id);

															if (isset($child_selected_menutwos) && !empty($child_selected_menutwos)) :
																echo '<ol class="dd-list">';
																foreach ($child_selected_menutwos as $child_selected_menutwo) {
																	echo '<li class="dd-item" data-id="'.$child_selected_menutwo->id.'">
																		<div class="dd-handle">'.$child_selected_menutwo->title.'</div>
																	</li>';

																	$child_selected_menuthrees = $this->Footer_menu_model->get_child_menu_list($website_id, $child_selected_menutwo->id);

																	if (isset($child_selected_menuthrees) && !empty($child_selected_menuthrees)) :
																		echo '<ol class="dd-list">';
																		foreach ($child_selected_menuthrees as $child_selected_menuthree) {
																			echo '<li class="dd-item" data-id="'.$child_selected_menuthree->id.'">
																				<div class="dd-handle">'.$child_selected_menuthree->title.'</div>
																			</li>';
																		}
																		echo '</ol>';
																	endif;
																}
																echo '</ol>';
															endif;
														}
														echo '</ol>';
													endif;
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

                    <?php
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
					?>

                </div>
              </div>
            </div>

            <!-- <div class="ln_solid"></div> -->

              <!-- Button Group -->


              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="input-button-group">
                  <?php

                    // Submit Button
					if (empty($menus)) :
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
                      'footer',
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
