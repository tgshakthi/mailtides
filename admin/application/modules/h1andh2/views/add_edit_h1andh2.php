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
									'page/page_details/'.$page_id,
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
                'h1andh2/insert_update_h1andh2',
                'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
              );

              // Input tag hidden
              echo form_input(array(
                'type'  => 'hidden',
                'name'  => 'id',
                'id'    => 'id',
                'value' => $id
              ));

			   			// Input tag hidden
              echo form_input(array(
                'type'  => 'hidden',
                'name'  => 'page-id',
                'id'    => 'page-id',
                'value' => $page_id
              ));
            ?>

            <div class="col-md-6 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">

                  <?php
										echo heading('Title & Content', '2');
										$list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
										$attributes = array('class' => 'nav navbar-right panel_toolbox');
										echo ul($list,$attributes);
									?>

                  <div class="clearfix"></div>
                </div>

                <div class="x_content">

									<div class="form-group">
										<?php
											echo form_label('H1','h1-tag');

											// Input tag
											echo form_input(array(
											'id'       => 'h1-tag',
											'name'     => 'h1-tag',
											'class'    => 'form-control',
											'value'    => $h1_tag
											));
										?>
									</div>
									<div class="form-group">
										<?php
											echo form_label('H2','h2-tag');

											// Input tag
											echo form_input(array(
											'id'       => 'h2-tag',
											'name'     => 'h2-tag',
											'class'    => 'form-control',
											'value'    => $h2_tag
											));
										?>
									</div>

                </div>
              </div>
            </div>

            <div class="col-md-6 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">

                  <?php
										echo heading('Customize Title & Content', '2');
										$list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
										$attributes = array('class' => 'nav navbar-right panel_toolbox');
										echo ul($list,$attributes);
									?>
                  <div class="clearfix"></div>
                </div>

                <div class="x_content">

									<div class="form-group">
										<?php
											echo form_label('H1 Color','h1-title-color');

											// Input tag hidden
											echo form_input(array(
											'type'  => 'hidden',
											'name'  => 'h1-title-color',
											'id'    => 'h1-title-color',
											'value' => $h1_title_color
											));

											// Input tag
											$this->color->view($h1_title_color,'h1-title-color',1);
										?>
									</div>
									<div class="form-group">
										<?php
											echo form_label('H2 Color','h2-title-color');

											// Input tag hidden
											echo form_input(array(
											'type'  => 'hidden',
											'name'  => 'h2-title-color',
											'id'    => 'h2-title-color',
											'value' => $h2_title_color
											));

											// Input tag
											$this->color->view($h2_title_color,'h2-title-color',2);
										?>
									</div>

									<div class="form-group">
										<?php
											echo form_label('H1 Position','h1-title-position');

											$options = array(
												'left-align'	=> 'Left',
												'center-align'	=> 'Center',
												'right-align'	=> 'Right'
											);

											$attributes = array(
												'name'	=> 'h1-title-position',
												'id'	=> 'h1-title-position',
												'class'	=> 'form-control'
											);

											// Dropdown
											echo form_dropdown($attributes, $options, $h1_title_position);
										?>
									</div>
									<div class="form-group">
										<?php
											echo form_label('H2 Position','h2-title-position');

											$options = array(
												'left-align'	=> 'Left',
												'center-align'	=> 'Center',
												'right-align'	=> 'Right'
											);

											$attributes = array(
												'name'	=> 'h2-title-position',
												'id'	=> 'h2-title-position',
												'class'	=> 'form-control'
											);

											// Dropdown
											echo form_dropdown($attributes, $options, $h2_title_position);
										?>
									</div>
									<div class="form-group">
										<?php
											echo form_label('Background Color','background-color');

											// Input tag hidden
											echo form_input(array(
											'type'  => 'hidden',
											'name'  => 'background-color',
											'id'    => 'background-color',
											'value' => $background_color
											));

											// Input tag
											$this->color->view($background_color,'background-color',3);
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
										'page/page_details/'.$page_id,
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
