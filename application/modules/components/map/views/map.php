<?php
/**
 * Map
 *
 * @category view
 * @package Map
 * @author Saravana
 * created at: 04-Dec-2018
 */

 if (!empty($maps)) :
?>
<section class="bg-img-common <?php echo $bg_color;?>" <?php if ($bg_image != "") : ?>
    style="background-image:url('<?php echo $bg_image;?>')" <?php endif;?>>
<div class="common-space">
    <div class="container">
        <div class="map">

            <?php
				// Check Heading is enabled
				if ($map_title_status != 0) :
					// H4 tag with it's customized options
					echo heading(
						$map_title,
						'4',
						array(
							'class' => 'h1-head ' . $map_title_position .' '. $map_title_color,
							'data-aos' => 'flip-up'
						)
					);
				endif;
			?>

            <ul class="map-list <?php echo $count;?>">

                <?php
					$img = array(
						'location1.png',
						'location3.png',
						'location4.png'
					);

					$i = 0;
					foreach($maps as $map) :

						$customize = json_decode($map->customization);

						$title_color = $customize->title_color;
						$title_position = $customize->title_position;
						$address_color = $customize->address_color;
						$address_position = $customize->address_position;
						$map_background_color = $customize->background_color;
						$map_position = $customize->map_position;
				?>

                <li data-aos="fade-up">
						
					<?php if ( !empty($map->image )) :?>

						<div class="map-location-image" >
							<img src="<?php echo $image_url . $map->image;?>">
						</div>

					<?php endif;?>					

                    <div class="map-details <?php echo $map_background_color;?>">

						<div class="map-content-container map-equal-height left">
							<div class="map-content">
								<?php
									// H4 tag
									echo heading(
										$map->title,
										'4',
										"class='$title_color $title_position'"
									);

									echo "<div class='$address_color $address_position'>";
									echo $map->address;
									echo "</div>";
								?>
							</div>
						</div>

                        <div class="map-iframe map-equal-height <?php echo $map_position;?>">

                            <iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0"
                                marginwidth="0"
                                src="https://maps.google.it/maps?q=<?php echo str_replace('#', '', strip_tags($map->address));?>&output=embed"></iframe>

                            <a href="https://maps.google.it/maps?q=<?php echo str_replace('#', '', strip_tags($map->address));?>"
                                class="map-eye-icon" target="_blank"><i class="fa fa-eye"></i></a>

                        </div>                       

                    </div>

                </li>

                <?php $i++; endforeach;?>

            </ul>

        </div>
	</div>
	</div>
</section>

<?php endif;?>