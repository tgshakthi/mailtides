<!-- page content -->
<div class="right_col" role="main">
	<div class="">

		<div class="page-title">
			<div class="title_left">
				<h3>Campaign</h3>				
			</div>
			<div class="btn_right" style="text-align:right;">
				<a href="<?php echo base_url();?>email_sms_blast/campaign" class="btn btn-primary">
					<i class="fa fa-chevron-left"></i> 
					Back
				</a>
			</div>
		</div>

		<div class="clearfix"></div>

		<div class="row">

			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h2><?php echo $heading;?></h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
					
						<!-- Smart Wizard -->
						<div id="wizard" class="form_wizard wizard_horizontal">
							<div id="step-2">
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
							
									<div class="email-blast-date">
								
										<div>
											<label>From Date:</label>
											<input type="text" id="min">
										</div>
										<div>
											<label>To Date:</label>
											<input type="text" id="max">
										</div>
									</div>
								</div>
								<input type="hidden" id="base-url" name="base-url" value=<?php echo base_url();?>>
								<button class="btn btn-default" id="send-email-sms-filter-data-import">Send</button>
								<br/>
								<?php echo $table;?>
								<br/>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- page content -->

<style>
.sorting > input {
	color : black
}
</style>