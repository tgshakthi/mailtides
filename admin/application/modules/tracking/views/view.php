<!-- page content -->
<div class="right_col" role="main">
  <div class="">

    <div class="page-title">
      <div class="title_left">
        <?php echo heading('Tracking', '3');?>
      </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">

      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_content">

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

            <div class="page_buut_right">

              <div class="add_btn">

                <?php 
                  echo anchor(
                    'tracking/mail_config',
                    '<i class="fa fa-plus" aria-hidden="true"></i> Mail Config',
                    array(
                      'class' => 'btn btn-success'
                    )
                  );
                ?>

              </div>

            </div>

            <?php              
              // Table
              echo $table;              
            ?>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /page content -->
