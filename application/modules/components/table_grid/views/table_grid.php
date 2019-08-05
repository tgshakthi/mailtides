<?php
/**
 * Table Grid
 * @category View
 * @package Table Grid
 * @author Saravana
 * Created at : 30-Aug-2018
 */
?>
<?php if (!empty($table_grids)) :?>
<!--<section class="bg-img-common <?php echo $background_color;?>" style="background-image:url('http://192.168.0.43/zcms-duplicate/assets/images/zcms/banner/bgimg5.png')">-->
<section class="bg-img-common <?php echo $bg_color;?>" <?php if ($bg_image != "") : ?>
    style="background-image:url('<?php echo $bg_image;?>')" <?php endif;?>>
<div class="common-space">
    <div class="container table-grid-container">
        <?php
			// Check Heading is enabled
			if ($table_grid_title_status == 1) :
				// H4 tag with it's customized options
				echo heading(
					$table_grid_title,
					4,
					array(
						'class' => 'h1-head ' . $table_grid_title_color.' '.$table_grid_title_position,
						'data-aos' => 'fade-up'
					)
				);
			endif;
		?>
        <div class="row" id="table-grid-float-div" data-aos="fade-up">
            <?php echo $table_grids[0]->table_content; ?>
        </div>
	</div>
	</div>
</section>
<?php endif; ?>