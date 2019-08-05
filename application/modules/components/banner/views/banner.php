<?php if (!empty($banners)) : ?>

<div class="owl-carousel owl-theme banner-slider-new banner-common-space" id="owl-demo">

    <?php
		$i = 0;
		foreach($banners as $banner) :
			$read_more = "";
			$open_new_tab = array();
			// Banner Images
			$image = array(
				'src' => $image_url . $banner->image,
				'alt' => $banner->image_alt,
				'title' => $banner->image_title,
				'class' => 'responsive-img'
			);
			// Check readmore btn is enabled
			if ($banner->readmore_btn == 1) :
				// Check Open new tab is enabled
				if ($banner->open_new_tab == 1) :
					$open_new_tab = array(
						'target' => '_blank'
					);
				endif;
				// Read more btn attributes
				$class = array(
					'class' => 'slide-caption__btn ' . $banner->button_type . ' '.$banner->button_position.' ' . $banner->btn_background_color . ' ' . $banner->label_color,
					'id' => 'banner_hover_' . $banner->id . $banner->page_id,
					'onmouseover' => 'banner_read_more_hover(\'' . $banner->btn_background_color . '\', \'' . $banner->label_color . '\', \'' . $banner->background_hover . '\', \'' . $banner->text_hover . '\', ' . $banner->id . ', ' . $banner->page_id . ')',
					'onmouseout' => 'banner_read_more_hoverout(\'' . $banner->btn_background_color . '\', \'' . $banner->label_color . '\', \'' . $banner->background_hover . '\', \'' . $banner->text_hover . '\', ' . $banner->id . ', ' . $banner->page_id . ')'
				);
				// merge additional attributes
				$banner_attribute = array_merge($class, $open_new_tab);
				// Anchor tag (Read more btn)
				$read_more = anchor(
					$banner->readmore_url,
					$banner->readmore_label,
					$banner_attribute
				);
			endif;
			//Read more after some specified characters
			if (!empty($banner->readmore_character) && $banner->readmore_character != 0):
				$stringCut = substr($banner->text, 0, $banner->readmore_character);
				$endPoint = strrpos($stringCut, ' ');
				$text = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
				// Read more btn
				if (!empty($read_more)):
					$text.= '... </br> ' . $read_more;
				endif;
			else:
				$text  = $banner->text . ' ' . $read_more;
			endif;

			if (!empty($banner->title)) :
				$heading = heading(
					$banner->title,
					3,
					array(
						'class' => 'slide-caption__title ' . $banner->title_color, 
						'style' => 'font-size:'.$banner->title_font_size .'; font-weight:'. $banner->title_font_weight						
					)
				);
			else :
				$heading = "";
			endif;			
	?>

    <!-- <div class="item cms-banner" id="bgimg<?php echo $i;?>"
        style="background-image:url('<?php echo $image_url . $banner->image ;?>');"> -->

		<div class="item cms-banner" id="bgimg<?php echo $i;?>">

			<img src="<?php echo $image_url . $banner->image?>" alt="">

        <div class="bannder-transparent-bg <?php echo $banner->background_transparent_color;?>"> </div>
        <div class="banner-content-position <?php echo $banner->text_position;?>">
            <div class="transparent-content">
                <div class="full-banner-content">
                    <div class="banner-head-details <?php echo $banner->text_color;?>">
                        <?php echo $heading; ?>
                        <div class="slide-caption__desc">
                            <?php echo $text; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
			$i++;
		endforeach;
	?>
</div>
<?php endif; ?>