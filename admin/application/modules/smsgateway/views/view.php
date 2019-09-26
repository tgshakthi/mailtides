<!-- page content -->
<div class="right_col" role="main" id="datatable_content">
  <div class="">

    <div class="page-title">
      <div class="title_left">
        <?php echo heading($heading, '3');?>
      </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
	  <?php if ($this->session->flashdata('success') != '') : // Display session data ?>
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

		<div class="col-md-12 col-xs-12">
				<div class="x_panel">

					<div class="x_title">

						<?php
							echo heading('Vertical Tab Title', '2');

							$attributes = array('class' => 'nav navbar-right panel_toolbox');
							$list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
							echo ul($list,$attributes);
						?>

						<div class="clearfix"></div>
					</div>

					<div class="x_content">

						<?php
							// Break Tag
							echo br();

							// Form Tag
							  echo form_open(
								'smsgateway/sms_gateway_data',
								'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
							  );
						?>
						<div class="ln_solid"></div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="input-button-group">
								<?php
									// Submit Button
									
									echo form_submit(
										array(
											'class' => 'btn btn-success',
											'id'    => 'btn',
											'value' => 'Submit'
										)
									);
								?>
							</div>
						</div>

						<?php
							//Form close
							echo form_close();
						?>

					</div>
				</div>
			</div>
    </div>
  </div>
</div>
<!-- /page content -->
