<!-- page content -->

<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3><?php echo $heading;?></h3>
      </div>
      <div class="btn_right" style="text-align:right;"> <a href="<?php echo base_url()?>email_sms_blast" class="btn btn-primary"><i class="fa fa-chevron-left"
                    aria-hidden="true"></i> Back</a> </div>
      <div class="clearfix"></div>
    </div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel"> 
          <!-- <div class="x_title">
							<?php
								echo heading('Details', '2');
								$list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');
								$attributes = array('class' => 'nav navbar-right panel_toolbox');
								echo ul($list,$attributes);
							 ?>
							   <div class="clearfix"></div>
						</div> -->
          <div class="x_content">
            <div class="form-group">
              <label for="campaign_type" class="control-label col-md-3 col-sm-3 col-xs-12"> Select Type </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="hidden" name="website_id" id="website_id" value="<?php echo $website_id;?>">
                <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
                <select name="campaign_type" class="form-control col-md-7 col-xs-12" id="campaign_type" required="required" onchange="campaign_type(this.value)">
                  <option value="">Select Type</option>
                  <option value="email">Email</option>
                  <option value="sms">SMS</option>
                </select>
              </div>
            </div>
          </div>
		  <div class="x_content">
            <div class="form-group">
              <label for="campaign_type" class="control-label col-md-3 col-sm-3 col-xs-12"> Select Provider Name </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="hidden" name="website_id" id="website_id" value="<?php echo $website_id;?>">
                <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
                <select name="campaign" class="form-control col-md-7 col-xs-12" id="campaign_name_data" required="required" onchange="campaign(this.value)">
                  <option value="">Select Provider Name</option>
                  <option value="dldc">DLDC</option>
                  <option value="reddy">Dr REDDY</option>
				  <option value="hamat">Dr HAMAT</option>
				  <option value="facebook">Facebook</option>
				  <option value="txgidocs">Txgidocs</option>
                </select>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_content">
            <div id="text_area"> </div>
            <textarea id="mail-opened" style="display: none">
                      <?php
                         

                        echo $opened;
                       ?>
                    </textarea>
            <textarea id="mail-unopened" style="display: none">
                      <?php
                     
                       echo $not_opened;
                      ?>
                    </textarea>
            <textarea id="mail-comments-posted" style="display: none"><?php echo $posted;?></textarea>
            <textarea id="mail-comments-not-posted" style="display: none"><?php echo $not_posted;?></textarea>
            <textarea id="mail-txgidocs" style="display: none"><?php echo $txgidocs;?></textarea>
            <textarea id="mail-google" style="display: none"><?php echo $google;?></textarea>
            <textarea id="mail-facebook" style="display: none"><?php echo $facebook;?></textarea>
            <textarea id="mail-sent" style="display: none"><?php echo $sent;?></textarea>
            <div class="row" id="barchart" style="display:table; width:100%;">
				<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12" style="float:left;">
					<h2 id="title">Send/Open/Unopen</h2>
					<div class="chart-report">
					   <canvas id="mybarChart"></canvas>
					</div>
				</div>
				<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12" style="float:right;">
					<h2 id="title-report">Comment Posted/Open</h2>
					<div class="chart-report">
						<canvas id="piechart"></canvas>
					</div>
				</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="clearfix"></div>
  </div>
</div>
<!-- page content --> 
