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
                			'mail_config/insert_update_mail_config',
                			'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
              			);

              			// Input tag hidden
              			echo form_input(array(
                			'type'  => 'hidden',
                			'name'  => 'id',
                			'id'    => 'id',
                			'value' => $id
              			));
			  
			  			// Input tag hidden Website ID
              			echo form_input(array(
                			'type'  => 'hidden',
                			'name'  => 'website_id',
                			'id'    => 'website_id',
                			'value' => $website_id
              			));
            			?>

            			<div class="form-group">

              				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="menu-name">
                				Host
                				<span class="required">*</span>
              				</label>

             				<div class="col-md-6 col-sm-6 col-xs-12">
                				<?php
                 				// Input tag
                  				echo form_input(array(
                    				'id'       => 'host_name',
                    				'name'     => 'host_name',
                    				'required' => 'required',
                    				'class'    => 'form-control col-md-7 col-xs-12',
                    				'value'    => $host
                  				));
                				?>
              				</div>

            			</div>

            			<div class="form-group">

              				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="menu-url">
                				Port No
                				<span class="required">*</span>
              				</label>

              				<div class="col-md-6 col-sm-6 col-xs-12">
                				<?php
                  				// Input
                  				echo form_input(array(
                    				'id'       => 'port_no',
                    				'name'     => 'port_no',
                    				'required' => 'required',
                    				'class'    => 'form-control col-md-7 col-xs-12',
                    				'value'    => $port
                  				));
                				?>
              				</div>
            			</div>
			
			 			<div class="form-group">

              				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="menu-url">
               					User Email
                				<span class="required">*</span>
              				</label>

              				<div class="col-md-6 col-sm-6 col-xs-12">
                				<?php
                  				// Input
                 				echo form_input(array(
                    				'id'       => 'user_email',
                    				'name'     => 'user_email',
                    				'required' => 'required',
									'type' 	   => 'email',
                    				'class'    => 'form-control col-md-7 col-xs-12',
                    				'value'    => $email
                  				));
                				?>
              				</div>
            			</div>
			
			 			<div class="form-group">

              				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="menu-url">
               					Password
                				<span class="required">*</span>
              				</label>

              				<div class="col-md-6 col-sm-6 col-xs-12">
                				<?php
                  				// Input
                  				echo form_input(array(
                    				'id'       => 'password',
                    				'name'     => 'password',
									'type'     => 'password',
                    				'required' => 'required',
                    				'class'    => 'form-control col-md-7 col-xs-12',
                    				'value'    => $password
                  				));
                				?>
              				</div>
            			</div>
			
			 			<div class="form-group">

              				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="menu-url">
                				Mail From
                				<span class="required">*</span>
              				</label>

              				<div class="col-md-6 col-sm-6 col-xs-12">
                				<?php
                  				// Input
                  				echo form_input(array(
                    				'id'       => 'mail_from',
                    				'name'     => 'mail_from',
                    				'required' => 'required',
									'type' 	   => 'email',
                    				'class'    => 'form-control col-md-7 col-xs-12',
                    				'value'    => $mail_from
                  				));
                				?>
              				</div>
            			</div>

           
		  				<div class="form-group">
              				<?php
                			echo form_label(
                  				'Status',
                  				'menu-status',
                  				'class="control-label col-md-3 col-sm-3 col-xs-12"'
                			);
              				?>
            
              				<div class="col-md-6 col-sm-6 col-xs-12">
                				<?php
                  				// Input checkbox
                  				echo form_checkbox(array(
                    				'id'      => 'menu-status',
                    				'name'    => 'menu-status',
                    				'class'   => 'js-switch',
                    				'checked' => ($status === '1') ? TRUE : FALSE,
                    				'value'   => $status
                  				));
                				?>
              				</div>
            			</div>
            
            			<div class="ln_solid"></div>

              			<!-- Button Group -->

              			<div class="form-group">
                			<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  				<?php
                  
                    			// Submit Button
                    			if (empty($id)) :
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
					
					  			// Anchor Tag
                    			echo anchor(
                      				'user_role',
                      				'Back',
                      				array(
                        				'title' => 'Back',
                        				'class' => 'btn btn-primary'
                      				)
                    			);
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
