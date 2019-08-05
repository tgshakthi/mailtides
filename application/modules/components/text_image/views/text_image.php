<?php if (!empty($text_images)) :

// if($background_type == 'image') :
// 	$color_class = "";
// 	$style = "assets/".$image;
// else :
// 	$style = "";
// 	$color_class = $color;
// endif;
/* $style = "";
$color_class = $color; */

	?>

<section class="common-space  bg-img-common <?php echo $bg_color;?>" <?php if ($bg_image != "") : ?>
    style="background-image:url('<?php echo $bg_image;?>')" <?php endif;?>>

<div class="">
<!-- <?php //if(!empty($style)) : ?> style="background-image: url(<?php //echo $style;?>);" <?php// endif;?> -->
<!-- <i class="bg-black-text-image-slider"></i> -->

<?php	
			// if ($text_image_slider_title_status != 0) :
			
			// 	echo heading(
			// 		$text_image_slider_title,
			// 		'4',
			// 		array(
			// 			'class' => $text_image_slider_title_position .' '. $text_image_slider_title_color .' h1-head'
			// 		)
			// 	);
			// endif;
		?>  

	<div class="container" >

		<?php
			foreach($text_images as $text_image) :

				$read_more = '';
				$open_new_tab = array();
				$border = array();

				// Check readmore btn is enabled
				if ($text_image->readmore_btn == 1) :

					// Check Open new tab is enabled
					if ($text_image->open_new_tab == 1) :
						$open_new_tab = array(
							'target' => '_blank'
						);
					endif;

					// Check border is enabled
					if ($text_image->border == 1):
						$border = array(
							'style' => "border: $text_image->border_size solid $text_image->border_color;"
						);
					endif;

					// Read more btn attributes
					$class = array(
						'class' => 'waves-effect waves-light ' . $text_image->button_type . ' ' . $text_image->btn_background_color . ' ' . $text_image->label_color,
						'id' => 'text_image_hover_' . $text_image->id . $text_image->page_id,
						'onmouseover' => 'textAndImageReadMoreHover(\'' . $text_image->btn_background_color . '\', \'' . $text_image->label_color . '\', \'' . $text_image->background_hover . '\', \'' .$text_image->text_hover . '\', ' . $text_image->id . ', ' . $text_image->page_id . ')',
						'onmouseout' => 'textAndImageReadMoreHoverOut(\'' . $text_image->btn_background_color . '\', \'' . $text_image->label_color . '\', \'' . $text_image->background_hover . '\', \'' . $text_image->text_hover . '\', ' . $text_image->id . ', ' . $text_image->page_id . ')'
					);

					// merge additional attributes
					$text_image_attribute = array_merge($class, $open_new_tab);
					$text_image_attribute = array_merge($text_image_attribute, $border);

					// Anchor tag (Read more btn)
					$read_more = anchor(
						$text_image->readmore_url,
						$text_image->readmore_label,
						$text_image_attribute
					);

				endif;

				$heading_array = array('<h1>', '<h2>', '<h3>', '<h4>', '<h5>', '<h6>');
				$replace_heading = array(
					'<h1 class="'.$text_image->content_title_position.' '.$text_image->content_title_color.'">',
					'<h2 class="'.$text_image->content_title_position.' '.$text_image->content_title_color.'">',
					'<h3 class="'.$text_image->content_title_position.' '.$text_image->content_title_color.'">',
					'<h4 class="'.$text_image->content_title_position.' '.$text_image->content_title_color.'">',
					'<h5 class="'.$text_image->content_title_position.' '.$text_image->content_title_color.'">',
					'<h6 class="'.$text_image->content_title_position.' '.$text_image->content_title_color.'">',
				);

				$text = str_replace($heading_array, $replace_heading, $text_image->text);

				//Read more after some specified characters
				/* if (!empty($text_image->readmore_character) && $text_image->readmore_character != 0):

					// Readmore After @param = readmore_character
					$stringCut = substr($text, 0, $text_image->readmore_character);
					$endPoint = strrpos($stringCut, ' ');
					$text = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);

					// Read more btn
					if (!empty($read_more)):
						$text.= '...' . $read_more;
					endif;

				else:
					
				endif; */
				if(!empty($read_more)):
					$text = $text. ' ' .$read_more;
				endif;
				
				if($text_image->image_position == 'left'):
					$content_position = 'right';
				else:
					$content_position = 'left';
				endif;
		?>

		<div class="row nt-bottom-space <?php echo $text_image->background_color;?>">

			<div class="col s12 m6 xl5 l6 <?php echo $text_image->image_position;?>">
							

<div data-aos="fade-up">

	<div class="text-and-image">
				<?php
					// Image Tag
					$image = array(
						'class' => '',
						'src' => $image_url . $text_image->image,
						'alt' => $text_image->image_alt,
						'title' => $text_image->image_title
					);
					echo img($image);
				?>
									</div>
									</div>
			</div>

			<div class="col s12 m6 xl7 l6 <?php echo $content_position;?>">
							

	<div data-aos="fade-up">
		<div class="text-and-image-content">
			<div class="<?php echo $text_image->title_position .' '.$text_image->title_color ;?> h1-head">
				<?php echo $text_image->title;?>
			</div>

			<div class="flow-text <?php echo $text_image->content_color . ' ' . $text_image->content_position;?>">
				<?php echo $text;?>
			</div>

		</div>
	</div>
</div>
		</div>

		<?php endforeach; ?>

	</div>

				</div>
</section>

<?php	endif; ?>

