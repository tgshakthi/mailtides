<style>
	.loader {
	  border: 16px solid #f3f3f3;
	  border-radius: 50%;
	  border-top: 16px solid #3498db;
	  width: 120px;
	  height: 120px;
	  -webkit-animation: spin 2s linear infinite; /* Safari */
	  animation: spin 2s linear infinite;
	}

	/* Safari */
	@-webkit-keyframes spin {
	  0% { -webkit-transform: rotate(0deg); }
	  100% { -webkit-transform: rotate(360deg); }
	}

	@keyframes spin {
	  0% { transform: rotate(0deg); }
	  100% { transform: rotate(360deg); }
	}
	

body {
  font-family: arial;
  font-size: 13px;
  line-height: 1.3;
  color: #454545;
}

button {
  margin-left: calc(50% - 40px);
  margin-top: 150px;
}

*, *:before, *:after {
  -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box;
 }

@import url(//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css);

/* Colors */

$color-primary              : #fff;
$color-secondary            : #454545;
$color-tertiary             : #E7483B;

$color-complement           : #4183c4;

$color-text                 : $color-secondary;
$color-text-secondary       : $color-primary;

$color-neutral              : #dfdfdf;
$color-neutral-light        : lighten($color-neutral, 7);
$color-approve              : #4FA86B;
$color-reject               : $color-tertiary;

$button-bg-color-std        : $color-complement;
$button-bg-color-approve    : $color-approve;
$button-bg-color-reject     : $color-reject;
$button-bg-color-cancel     : #dfdfdf;

/* Border radius */

$border-radius-small    : 2px;
$border-radius-medium	: 5px;
$border-radius-large	: 10px;

@mixin button {
  position: relative;
  border: none;
  outline: 0;
	border-bottom: 2px solid transparent;
	border-top: 2px solid transparent;
	padding: 0.5em 1em;
	display: inline-block;
	border-radius: $border-radius-small;
	font-size: 13px;
	background-color: $button-bg-color-std;
	color: $color-text-secondary;
  cursor: pointer;
	&:hover {
		border-bottom-color: darken($button-bg-color-std, 15%);
		background-color: lighten($button-bg-color-std, 5%);
	}
	&:active {
		background-color: darken($button-bg-color-std, 5%);
		border-top-color: darken($button-bg-color-std, 15%);
		border-bottom-color: transparent;
	}
}
.hidden {
  visibility: hidden;
}
.button {
  @include button;
}
$grey: #aaa;
.button:before {
  visibility: hidden;
  content: "";
  top: -2px;
  bottom: -2px;
  left: 0;
  right: 0;
  margin: 0 auto;
  position: absolute;
  width: 100%;
  padding: inherit;
  background: $grey;
  border-top: 2px solid $grey;
  border-bottom: 2px solid $grey;
  border-radius: 2px;
  transition: width 0.5s;
}
.button:after {
  visibility: hidden;
  font-family: FontAwesome;
  font-size: 16px;
  line-height: 16px;
  color: #454545;
  position: absolute;
  top: 2px;
  left: 0;
  right: 0;
  margin: 0 auto;
  width: 26px;
  height: 26px;
  padding: 5px;
  border-radius: 26px;
  color: #fff;
}
.button:after {
  content: "\f110";
}
.button.loading:after {
  visibility: visible;
  animation: loader 1s infinite linear;
}
.button.loading:before {
  visibility: visible;
  border-radius: 26px;
  width: 33px;
  margin: 0 auto;
  right: 0;
  left: 0;
}
.button.done {
  visibility: hidden;
}
.button.done:before {
  content: "\f00c";
  font-family: FontAwesome;
  visibility: visible;
  background: #4FA86B;
  border-color: #4FA86B;
}

.button.loading, .button.done {
  cursor: default;
}

@keyframes loader {
  0%   { transform: rotate(0deg); }
  99% { transform: rotate(360deg); }
}
</style>
<!--<div class="loader"></div> -->
<!-- page content -->
<div class="right_col" role="main">
	<div class="">
		<div class="clearfix"></div>

		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="">

					<div class="x_title">
						<h2><?php echo $heading;?></h2>

						<div class="btn_right" style="text-align:right;">
							<a href="<?php echo base_url()?>email_blast" class="btn btn-primary"><i class="fa fa-chevron-left"
									aria-hidden="true"></i> Back</a>
						</div>
						<div class="clearfix"></div>
					</div>

					<div class="x_content">

						<?php if ($this->session->flashdata('success')!='') : // Display session data ?>
						<div class="alert alert-success alert-dismissible fade in text-center" id="success-alert" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
									aria-hidden="true">×</span>
							</button>
							<strong>Success!</strong> <?php echo $this->session->flashdata('success');?>
						</div>
						<?php endif; ?>

						<?php if ($this->session->flashdata('error') != '') : // Display session data ?>
						<div class="alert alert-warning alert-dismissible fade in text-center" id="warning-alert" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
									aria-hidden="true">×</span>
							</button>
							<strong><?php echo $this->session->flashdata('error');?></strong>
						</div>
						<?php endif; ?>

						<br>

						<form action="<?php echo base_url()?>email_blast/send_mail_based_on_campaign" method="POST"
							class="form-horizontal form-label-left" id="demo-form2" data-parsley-validate autocomplete="off" enctype="multipart/form-data">
							
							<input type="hidden" name="website_id" id="website_id" value="<?php echo $website_id;?>">
							<input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">							

							<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="x_panel">
									<div class="x_title">
										<h2>Send Mail</h2>
										<ul class="nav navbar-right panel_toolbox">
											<li>
												<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
											</li>
										</ul>

										<div class="clearfix"></div>
									</div>
									<div class="x_content">

									<div class="form-group">
                                            <label for="campaign-id" class="control-label col-md-3 col-sm-3 col-xs-12">
                                                Select Campaign
												<span class="required">*</span>
                                            </label>

                                            <div class="col-md-6 col-sm-6 col-xs-12">
												<input type="hidden" id="hidden-selected-id">
                                                <select name="campaign" class="form-control col-md-7 col-xs-12" id="campaign_id" required="required"  >

													<option value="">Select Campaign</option>                                                   
													<?php foreach($campaign_details as $campaign):
													 ?>
													  <option value="<?php echo $campaign->id ?>"><?php echo $campaign->campaign_name; ?></option>
													 <?php endforeach; ?>
                                                </select>
                                            </div>
                                    
									</div>
									 <div class="form-group">

                                                    <?php
													echo form_label('Subject <span class="required">*</span>','subject','class="control-label col-md-3 col-sm-3 col-xs-12"');
													?>

                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <?php
														// Input tag
														echo form_input(array(
															'id'       => 'subject',
															'name'     => 'subject',
															'required'=>'required',
															'class'    => 'form-control col-md-7 col-xs-12'
														
														));
														?>
                                                    </div>

                                                </div>
									
									     <div class="form-group">

                                                    <?php
													echo form_label('From Name <span class="required">*</span>','from_name','class="control-label col-md-3 col-sm-3 col-xs-12"');
													?>

                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <?php
															// Input tag
															echo form_input(array(
																'id'       => 'from_name',
																'name'     => 'from_name',
																'required'=>'required',
																'class'    => 'form-control col-md-7 col-xs-12',
																'value'=>'Digestive & Liver Disease Consultants , P.A'
															));
														?>
                                                    </div>

                                                </div>
												
									       <div class="form-group">

                                                    <?php
													echo form_label('From Email <span class="required">*</span>','from_email','class="control-label col-md-3 col-sm-3 col-xs-12"');
													?>

                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <?php
														// Input tag
														echo form_input(array(
															'id'       => 'from_email',
															'name'     => 'from_email',
															'required' => 'required',
															'class'    => 'form-control col-md-7 col-xs-12',
															'value' => $email
															
														));
														?>
                                                    </div>

                                             </div>
												<?php 
												
											echo form_input(array(
												'type'  => 'hidden',
												'name'  => 'image_url',
												'id'    => 'image_url',
												'value' => $ImageUrl
											));

											echo form_input(array(
												'type'  => 'hidden',
												'name'  => 'httpUrl',
												'id'    => 'httpUrl',
												'value' => $httpUrl
											));
											?>

											<div cass="form-group">
												<div class= "col-md-6 col-sm-6 col-xs-12 col-sm-offset-3">
													<a data-toggle="modal" class="btn btn-primary" id="preview_template" data-target="#ImagePopUp"> 
														Preview Template 
													</a>
												</div>
											</div>
								</div>
							</div>

							<!-- Button Group -->

							<div class="col-md-12 col-sm-12 col-xs-12 ">
								<div class="input-button-group">									
									<input type="submit" class="btn btn-success" id="btn" value="Send">
									<a href="<?php echo base_url()?>email_blast" class="btn btn-primary" title="Back">Back</a>
								</div>
                            </div>
                            
						</form>
						<div class="modal fade" id="preview-template-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">

							<div class="modal-header">
								Email Template Preview
							</div>

							<div class="modal-body" id="modal-body-img" style="text-align: center;">								
							</div>

							<div class="modal-footer">								
									<a class="btn btn-danger" id="btn_ok" data-dismiss="modal">close</a>
							</div>

					</div>
				</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
 $('#btn').click(function(){
	 alert();
  $(this).addClass('loading hidden');
  window.setTimeout(function(){
    $('#btn').removeClass('loading hidden').addClass('done');
    
  }, 2000);
});
</script>
<!-- /page content -->
