<!-- page content -->

<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <?php
		  // Heading tag
		  echo heading($heading, '3');
		?>
      </div>
      <div class="title_right">
        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
        	<form method="POST">
            	<div class="input-group">
                	<?php 
						// Search 
						echo form_input(array(
							'type' => 'text',
							'class' => 'form-control',
							'id' => 'search',
							'placeholder' => 'Search Color...',
							'onkeypress' => 'return event.keyCode != 13;'
						));
					?>
                    <span class="input-group-btn">
                    	<?php 
							echo form_button(array(
								'class' => 'btn btn-default',
								'onclick' => 'search_color_go()',
								'type' => 'button',
								'content' => 'Go!'
							));
						?>
                    </span>
                </div>
            </form>
        </div>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <?php
			// Button tag
			echo form_button(array(
			  'class' => 'btn btn-success',
			  'data-toggle' => 'modal',
			  'data-target' => '#color_popup',
			  'content' => '<i class="fa fa-plus"></i> Add Color'
			));
		  ?>
          
          <!-- Color Popup -->
          <div class="modal fade" id="color_popup">
            <div class="modal-dialog popup-width">
              <div class="modal-content">
                <?php
				  // Form open
				  echo form_open(
					'color/insert_update_color',
					'class="form-horizontal" id="demo-form2" data-parsley-validate'
				  );
				  
				  // hidden
				  echo form_input(array(
				  	'type' => 'hidden',
				  	'id' => 'color_id',
					'name' => 'id',
					'value' => ''
				  ));
				?>
                <div class="modal-header">
                  <?php

					  // Close button
					  
					  echo form_button(array(
						  'name' => '',
						  'type' => 'button',
						  'class' => 'close',
						  'data-dismiss' => 'modal',
						  'aria-hidden' => 'true',
						  'content' => '&times;'
					  ));
					  
					  // Heading tag
					  
					  echo heading('Add Color', '4', array(
						  'class' => 'modal-title',
						  'id' => 'myModalLabel'
					  ));
				  ?>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <?php
						echo form_label(
							'Color Name <span class="required">*</span>', 
							'color_name',
							array(
								'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
							)
						);						
					?>
                    
                    <div class="col-md-6 col-sm-6 col-xs-12">
                    	<?php
							echo form_input(array(
								'id' => 'color_name',
								'name' => 'color_name',
								'required' => 'required',
								'class' => 'form-control col-md-7 col-xs-12',
								'value' => ''
							));
						?>
					</div>
						
                  </div>
                  <div class="form-group">
                    <?php
						echo form_label(
							'Color Class <span class="required">* (Ex: color_white)</span>', 
							'color_class',
							array(
								'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
							)
						);
					?>
                    
                    <div class="col-md-6 col-sm-6 col-xs-12">
                    	<?php					
							echo form_input(array(
								'id' => 'color_class',
								'name' => 'color_class',
								'required' => 'required',
								'class' => 'form-control col-md-7 col-xs-12',
								'value' => ''
							));
						?>
                    </div>
                    
                  </div>
                  <div class="form-group">
                    <?php
						echo form_label(
							'Color Code <span class="required">* (Ex: FFFFFF)</span>', 
							'color_code',
							array(
								'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
							)
						);
					?>
					
                    <div class="col-md-6 col-sm-6 col-xs-12">
                    	<?php
							echo form_input(array(
								'id' => 'color_code',
								'name' => 'color_code',
								'required' => 'required',
								'class' => 'form-control col-md-7 col-xs-12',
								'value' => ''
							));
						?>
                    </div>					
						
                  </div>
                </div>
                <div class="modal-footer">
                  <?php
				  	// Add Button
					echo form_submit(array(
						'class' => 'btn btn-success',
						'id' => 'btn',
						'value' => 'Add'
					));
					
					// Clear button
					echo form_button(array(
						'class' => 'btn btn-info',
						'type' => 'reset',
						'id' => 'clear',
						'style' => 'display: none;',
						'onclick' => 'clear_btn();',
						'content' => 'Clear'						
					));
					
					// Cancel button
					echo form_button(array(
						'type' => 'button',
						'class' => 'btn btn-default',
						'data-dismiss' => 'modal',
						'content' => 'Cancel'
					));					
				 ?>
                </div>
                <?php
					// Form Close
					echo form_close();
				?>
              </div>
            </div>
          </div>
          <div class="clearfix"></div>
          
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
          	<div class="c_color_panel">
            
            	<?php 
					if (!empty($colors)):
						foreach ($colors as $color) :
							
							echo form_button(array(
								'class'               => 'color-list',
								'data-toggle'         => 'tooltip',
								'data-placement'      => 'top',
								'data-original-title' => $color->color_name,
								'value'               => $color->color_code,
								'content'             => '<p>#'.$color->color_code.'</p>',
								'style'               => 'background-color: #'.$color->color_code,
								'onclick'			 => 'edit_color('.$color->id.', \''.$color->color_name.'\', \''.$color->color_class.'\', \''.$color->color_code.'\')'
							));
							
						endforeach; 
					else :
				?>                	
                    <div class="alert alert-info alert-dismissible fade in text-center" role="alert">
                    	<strong>No Colors Found!</strong>
                  	</div>
                
                <?php endif;?>
                
                <br class="spacer"/>
            </div>
        </div>
        
      </div>
    </div>
  </div>
</div>
<!-- /page content --> 
