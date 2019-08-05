<?php 
	if(!empty($text_background_images)):
	foreach($text_background_images as $text_background_image):
	// Background
		if (!empty($text_background_image)) :
			$text_bg_images = json_decode($text_background_image->background);
			if (!empty($text_bg_images->component_background) && $text_bg_images->component_background == 'image') :
				$bg_image = $image_url . $text_bg_images->text_bg_image_background;
				$bg_color = "";
			elseif (!empty($text_bg_images->component_background) && $text_bg_images->component_background == 'color') :
				$bg_color = $text_bg_images->text_bg_image_background;
				$bg_image = "";
			else :
				$bg_color = '';
				$bg_image = '';
			endif;
		endif;

		$read_more = '';
		$open_new_tab = array();

		// Check readmore btn is enabled
		if ($text_background_image->readmore_btn == 1) :

			// Check Open new tab is enabled
			if ($text_background_image->open_new_tab == 1) :
				$open_new_tab = array(
					'target' => '_blank'
				);
			endif;

			// Read more btn attributes
			$class = array(
				'class' => 'waves-effect waves-light ' . $text_background_image->button_type . ' ' . $text_background_image->btn_background_color . ' ' . $text_background_image->label_color,
				'id' => 'text_background_image_' . $text_background_image->id . $text_background_image->page_id,
				'onmouseover' => 'text_and_bg_image_readmore_hover(\'' . $text_background_image->btn_background_color . '\', \'' . $text_background_image->label_color . '\', \'' . $text_background_image->background_hover . '\', \'' . $text_background_image->text_hover . '\', ' . $text_background_image->id . ', ' . $text_background_image->page_id . ')',
				'onmouseout' => 'text_and_bg_image_readmore_hoverout(\'' . $text_background_image->btn_background_color . '\', \'' . $text_background_image->label_color . '\', \'' . $text_background_image->background_hover . '\', \'' . $text_background_image->text_hover . '\', ' . $text_background_image->id . ', ' . $text_background_image->page_id . ')'
			);

			// merge additional attributes
			$text_image_attribute = array_merge($class, $open_new_tab);

			// Anchor tag (Read more btn)
			$read_more = anchor(
				$text_background_image->readmore_url,
				$text_background_image->readmore_label,
				$text_image_attribute
			);

		endif;
		
		$heading_array = array('<h1>', '<h2>', '<h3>', '<h4>', '<h5>', '<h6>');
		
		$replace_heading = array(
								'<h1 class="'.$text_background_image->content_title_position.' '.$text_background_image->content_title_color.'">',
								'<h2 class="'.$text_background_image->content_title_position.' '.$text_background_image->content_title_color.'">',
								'<h3 class="'.$text_background_image->content_title_position.' '.$text_background_image->content_title_color.'">',
								'<h4 class="'.$text_background_image->content_title_position.' '.$text_background_image->content_title_color.'">',
								'<h5 class="'.$text_background_image->content_title_position.' '.$text_background_image->content_title_color.'">',
								'<h6 class="'.$text_background_image->content_title_position.' '.$text_background_image->content_title_color.'">',
							);

		$text = str_replace($heading_array, $replace_heading, $text_background_image->text);
		$content = $text. ' ' .$read_more;
		
?>
	<section class="common-space bg-img-common <?php echo $bg_color;?>" <?php if ($bg_image != "") : ?>
    style="background-image:url('<?php echo $bg_image;?>')" <?php endif;?>> 
		<div class="container">
			<div class="text-images">
				<div class="row">		
					<div class="col s12 m6 xs12 <?php echo $text_background_image->text_position;?>">							
						<div data-aos="fade-up"  data-aos-duration="2800">
							<?php	
								// Heading  Tag
								echo heading(
									$text_background_image->title,
									5,
									array(
										'class' => $text_background_image->title_position. ' ' .$text_background_image->title_color .' h1-head'
									)
								);
							?>                
						</div>
						<div class="content-part">        
							<div data-aos="fade-up"  data-aos-duration="2800">
								<div class="flow-text <?php echo $text_background_image->content_color .' '.$text_background_image->content_position;?>">
									<?php echo $content;?>								
								</div>
                            </div>
    
                        </div>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php
	endforeach;
	endif;
?>