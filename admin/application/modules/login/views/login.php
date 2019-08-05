<?php $this->load->view('login_head'); ?>

<?php	if (isset($websites)) :?>

	<div class="modal fade" id="login_web_id" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog">
			<div class="modal-content">

				<div class="modal-header">
					<?php
					  // Anchor tag
						echo anchor(
							'#',
							'&times;',
							array(
								'class' => 'close',
								'onclick' => "javascript:window.location='".site_url()."'",
								'data-dismiss' => 'modal'
							));

						// heading tag h4
						echo heading(
							'Choose Website',
							'4',
							array(
								'class' => 'modal-title color_head'
							)
						);
					?>
				</div>

				<div class="modal-body">
					<?php foreach ($websites as $row) :?>

						<div class="remember_check">
							<?php
							  // Radio button
								echo form_radio(array(
									"onClick" => "getwebsite_id('".$row[0]->id."')",
									"name"    => "choose_web",
									"id"      => "choose_web".$row[0]->id,
									"value"   => $row[0]->id
								));

								// Label tag
								echo form_label(
									$row[0]->website_name,
									"choose_web".$row[0]->id
								);
							?>
						</div>

					<?php endforeach; ?>
				</div>

				<br class="spacer" />
				<div class="go_anchor">
					<?php
					  // Anchor tag
						echo anchor(
							'',
							'Go',
							array(
								'id' => 'go_website_id',
								'class' => 'go_bttn'
							)
						);
					?>
				</div>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function() {
			var web_id = $('#login_website_id').val();
	    if(web_id != 0)
	    {
	      $('#login_web_id').modal('show');
	    }

	    $('.number_only_valiq').bind('keyup blur', function() {
	      $(this).val($(this).val().replace(/[^0-9]/g, ''))
	    });
	  });

	  function getwebsite_id(web_id)
	  {
	    $('#go_website_id').attr('href','<?php echo base_url()?>auth/verifylogin/webid_session/'+web_id);
	  }
	</script>

<?php else :?>

	<div>
		<a class="hiddenanchor" id="signin"></a>

		<div class="login_wrapper">
			<div class="animate form login_form">
				<section class="login_content">

					<?php
					  // From tag
						echo form_open('auth/verifylogin');
						echo heading('Admin Login', '1');
						// form validation
						echo validation_errors('<div class="alert alert_name alert-login">', '</div>');
					?>

					<div>

						<?php
						  // Input tag
							echo form_input(array(
								'class'       => 'form-control',
								'name'        => 'username',
								'placeholder' => 'User Name',
								'id'          => 'username'
							));
						?>

					</div>

					<div>
						<?php
						  // Password tag
							echo form_password(array(
								'class'       => 'form-control',
								'name'        => 'password',
								'id'          => 'password',
								'placeholder' => 'Password'
							));
						?>
					</div>

					<div>
						<?php
						  // Submit button
							echo form_submit(array(
								'class' => 'btn btn-default submit',
								'name'  => 'login_button',
								'value' => 'Login'
							));

							echo anchor(
								'#',
								'Lost your password?',
								array(
									'class' => 'reset_pass'
								)
							);
						?>
					</div>

					<div class="clearfix"></div>

					<div class="separator">
						<div>
							<?php
								echo heading(
									'<i class="fa fa-file-text"></i> DESSS CMS',
									'1'
								);
							?>
							<p> © 2018 All Rights Reserved. Privacy and Terms</p>
						</div>
					</div>
					<?php echo form_close(); ?>
				</section>
			</div>
		</div>
	</div>
<?php endif;?>
