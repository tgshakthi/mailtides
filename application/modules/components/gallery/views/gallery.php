<?php
/**
 * Gallery
 * @category View
 * @package Gallery
 * @author Saravana
 * Created at : 13-Jul-18
 */
if (!empty($gallery)):
?>
<section class="bg-img-common <?php echo $bg_color;?>" <?php if ($bg_image != "") : ?>
    style="background-image:url('<?php echo $bg_image;?>')" <?php endif;?>>
<div data-aos="fade-up">

        <?php
			// Check Heading is enabled
			if ($gallery_title_status == 1) :
				// H4 tag with it's customized options
				echo heading(
					$gallery_title,
					4,
					array(
						'class' => $gallery_title_color.' '.$gallery_title_position .' h1-head'	
					)
				);
			endif;
		?>
        <div class="row">
            <?php
				if (!empty($gallery_tab_list)) :
					echo $gallery_tab_list;
				endif;			
				echo $gallery_tab_image_data;
			?>
        </div>
 </div>
</section>
<?php endif; ?>

