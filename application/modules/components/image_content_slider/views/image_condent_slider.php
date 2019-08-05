<?php if(!empty($image_content_slider_images)) :?>

<section class="bg-img-common <?php echo $bg_color;?>" <?php if ($bg_image != "") : ?>
    style="background-image:url('<?php echo $bg_image;?>')" <?php endif;?>>
<div class="common-space">
	<div class="container" data-aos="zoom-in">
		<div class="row">

			<div class="col s12 m12 l12 xl8 <?php echo $image_content_slider_position;?>">

				<?php
					echo form_input(
						array(
							'type' => 'hidden',
							'id' => 'image_content_slider_row_count',
							'value' => $row_count
						)
					);
				?>

				<!-- <div class="carousel-wrap"> -->
				<div id="slide-demo" class="our-slider">


					<?php
						foreach($image_content_slider_images as $image_content_slider_image) :
							$image_slider_image = json_decode($image_content_slider_image->content);

							

							if($image_slider_image->status == '1') :
					?>

						<div class="item image-slider-item <?php echo $image_slider_image->background_color;?>">

							<?php
								echo img(
									array(
										'src' => $image_url . $image_slider_image->image,
										'title' => $image_slider_image->image_title,
										'alt' => $image_slider_image->image_alt
									)
								);
							?>

							<div class="slider-content <?php echo $image_slider_image->content_color . ' ' . $image_slider_image->content_position?>">
								<?php
									echo heading(
										$image_slider_image->title_image,
										'4',
										array(
											'class' => 'h4-head ' .$image_slider_image->title_position . ' ' . $image_slider_image->title_color
										)
									);

									echo $image_slider_image->text;
								?>

							</div>

						</div>

					<?php
							endif;
						endforeach;
					?>

				</div>
				<!-- </div> -->

			</div>


			<?php
				/**
				 * Image Content Slider title
				 */
					if($image_content_slider_title_status != 0) :
						$read_more = '';
						$open_new_tab = array();
						// Check readmore btn is enabled
						if ($readmore_btn == 1) :
							// Check Open new tab is enabled
							if ($open_new_tab == 1) :
								$open_new_tab = array(
									'target' => '_blank'
								);
							endif;						
							// Read more btn attributes
							$class = array(
								'class' => 'waves-effect waves-light ' . $button_type . ' ' . $btn_background_color . ' ' . $readmore_label_color,
								'id' => 'image_content_slider_link',
								'onmouseover' => 'image_content_slider_read_more_hover(\'' . $btn_background_color . '\', \'' . $readmore_label_color . '\', \'' . $btn_background_hover . '\', \'' . $btn_label_hover . '\')',
								'onmouseout' => 'image_content_slider_read_more_hoverout(\'' . $btn_background_color . '\', \'' . $readmore_label_color . '\', \'' . $btn_background_hover . '\', \'' . $btn_label_hover . '\')'
							);

							// merge additional attributes
							$image_content_slider_attribute = array_merge($class, $open_new_tab);
							$image_content_slider_attribute = array_merge($image_content_slider_attribute);

							// Anchor tag (Read more btn)
							$read_more = anchor(
								$readmore_url,
								$readmore_label,
								$image_content_slider_attribute
							);

						endif;

						$heading_array = array('<h1>', '<h2>', '<h3>', '<h4>', '<h5>', '<h6>');
						$replace_heading = array(
							'<h1 class="'.$content_title_color.' '.$content_title_position.'">',
							'<h2 class="'.$content_title_color.' '.$content_title_position.'">',
							'<h3 class="'.$content_title_color.' '.$content_title_position.'">',
							'<h4 class="'.$content_title_color.' '.$content_title_position.'">',
							'<h5 class="'.$content_title_color.' '.$content_title_position.'">',
							'<h6 class="'.$content_title_color.' '.$content_title_position.'">',
						);

						$text = str_replace($heading_array, $replace_heading, $image_content_slider_content);

			?>

			<div class="col s12 m12 l12 xl4 our-slider">

				<?php
					echo heading(
						$image_content_slider_title,
						'3',
						array(
							'class' =>'h1-head ' . $title_color . ' ' . $title_position
						)
					);
				?>

				<div class="<?php echo $content_color . ' ' . $content_position?>">
					<?php
						echo $text. ' ' . $read_more;
					?>
				</div>

			</div>

			<?php endif;?>


		</div>
	</div>
				</div>
</section>

<?php endif;?>
