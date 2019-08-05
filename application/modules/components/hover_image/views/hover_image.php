<?php
/**
 * Hover Image
 * Created at : 05-Apr-2019
 * Author : saravana
 */
?>

<div class="mouse-over-img-com">

	<div class="<?php echo $row_count;?>">

		<?php 
			foreach (($hover_images ? $hover_images : array()) as $hover_image) :
				$hover_image_details = json_decode($hover_image->hover_image_details);
		?>
		<div class="mouseover-img">
			<a href="javascript:void(0);" class="hover-img">
				<img class="primary-image" src="<?php echo $image_url . $hover_image_details->primary_image;?>" />
				<img class="secondary-image" src="<?php echo $image_url . $hover_image_details->secondary_image;?>" />
				<div class="hover-image-text">
				<?php echo $hover_image_details->hover_image_title;?>
			</div>
            </a> 
        </div>
        <?php endforeach;?>

	</div>

</div>
