<?php
	/**
	 * Newsletter View
	 *
	 * @category View
	 * @package  Newsletter
	 * @author   Saravana
	 * Created at:  01-March-2019
	 */
?>

<!-- page content -->
<div class="right_col" role="main">

	<div class="">

		<div class="page-title">

			<div class="title_left">
				<?php echo heading($heading, '3');?>
			</div>

		</div>

		<div class="clearfix"></div>

		<?php if ($this->session->flashdata('success')!='') : // Display session data ?>
			<div class="alert alert-success alert-dismissible fade in text-center" id="success-alert" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
				<strong>Success!</strong>
				<?php echo $this->session->flashdata('success');?>
			</div>
		<?php endif; ?>

		<?php if ($this->session->flashdata('error') != '') : // Display session data ?>
			<div class="alert alert-warning alert-dismissible fade in text-center" id="warning-alert" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
				<strong>
					<?php echo $this->session->flashdata('error');?>
				</strong>
			</div>
		<?php endif; ?>
		
	</div>

	<div class="x_panel">

		<div class="x_content">

			<?php
				echo form_open(
					'newsletter/delete_multiple_newsletter',
					'id="form_selected_record"'
				);
			?>

			<div class="page_buut_right">

				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">

					<?php					

						echo form_button(array(
							'type'    => 'button',
							'id'	  => 'delete_selected_record',
							'name'    => 'delete-selected-newsletter',
							'class'   => 'btn btn-danger',
							'content' => '<i class="fa fa-trash-o" aria-hidden="true"></i> Delete'
						));
					?>

				</div>

				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 add_btn">
					<?php
						echo anchor(
							'newsletter/mail_config',
							'Mail Configuration',
							array(
								'class' => 'btn btn-primary'
							)
						);
					?>
				</div>

			</div>

			<div class="row">
				<?php
					// Table
					echo $table;
				?>
			</div>

			<?php echo form_close();?>

			<!-- Confirm Delete Modal -->
			<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">

							<div class="modal-header">
								Confirm Delete
							</div>

							<div class="modal-body">
								<p>Are you sure you want to delete this record?</p>
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
									<a class="btn btn-danger" id="delete_btn_ok">Delete</a>
							</div>

					</div>
				</div>
      </div>

		</div>

	</div>
</div>
<!-- Page Content -->
