
<div class="right_col" role="main">
	<div class="">
	<div class="clearfix"></div>

    	<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
        		<div class="">
					<div class="x_title">
						<?php
							echo heading($heading, '2');
						?>
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
								'sitemap/generate',
								'class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate'
							);
							echo form_input(array(
									'type'  => 'hidden',
									'name'  => 'id',
									'id'    => 'id',
									'value' => ""
								  ));
						   echo form_input(array(
								'type'  => 'hidden',
								'name'  => 'website_id',
								'id'    => 'website_id',
								'value' => ""
							  ));
						?>
						<div class="col-md-12 col-sm-12 col-xs-12">
              				<div class="x_panel">
								<div class="x_title">
                  					<?php
										echo heading('Sitemap', '2');
				  					?>
                  					<div class="clearfix"></div>
                				</div>
								<div class="form-group">
									<label for="mask_phone" class="control-label col-md-3 col-sm-3 col-xs-12">Url:</label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<?php 
											if($this->session->flashdata('success')!='')
											{
										?>
											<input  type="text" class="form-control" name="Url" value="<?php echo 'http://192.168.1.43/zcms/';?>">
										<?php 
											}else 
											{
										?>
											<input  type="text" class="form-control" name="Url" value="<?php echo 'http://192.168.1.43/zcms/';?>">
										<?php 
											} 
										?>
									</div>
								</div>
								<!--<div class="form-group">
                        			<?php
										echo form_label(
											'Date ',
											'date',
											'class="control-label col-md-3 col-sm-3 col-xs-12"'
										);
										?>

									<div class="col-md-6 col-sm-6 col-xs-12">
                            			<input type="text" name="Date" class="form-control" value="<?php $date = date('Y-m-d');
											$time = date('H:i:s');
											echo $date1 =$date.' To '.$time.' +00:00 ';  ?>" >
                                    </div>
                    			</div> -->
								<div class="form-group">
                        			<?php
										echo form_label(
											'Changefreq :',
											'changefreq',
											'class="control-label col-md-3 col-sm-3 col-xs-12"'
										);
										?>

									<div class="col-md-6 col-sm-6 col-xs-12">
                            			<?php
                                           // Input tag
											echo form_input(array(
												'id'    => 'changefreq',
                            					'name'  => 'changefreq',
                            					'class' => 'form-control',
                            					'value' => 'always'
                            				));
                        				?>
                                    </div>
                    			</div>
				
							</div>
						</div>
					</div>
						<div class="col-md-12 col-sm-12 col-xs-12 ">
							<div class="input_butt">
								<?php
									// Submit Button
									echo form_submit(
										array(
											'class' => 'btn btn-success',
											'name'=>'mysubmit',
											'value'=>'Generate'
											)
										);
									// Anchor Tag
									echo anchor(
										'sitemap',
										'Cancel',
										array(
											'title' => 'Cancel',
											'class' => 'btn btn-primary'
										)
									);
									echo br(3);
								?>
							</div>
						</div>
						<div>
							<?php
								echo form_close();
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
 </div>