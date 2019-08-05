<?php
/**
 * Circular Image
 *
 * @category view
 * @package Circular Image
 * @author Saravana
 * created at: 05-Jul-2018
 */

 if (!empty($circular_images)) :
?>
<section class="bg-img-common <?php echo $bg_color;?>" <?php if ($bg_image != "") : ?>
    style="background-image:url('<?php echo $bg_image;?>')" <?php endif;?>>
    <div class="common-space">
        <div class="container">
            <?php
				// Check Heading is enabled
				if ($circular_image_title_status != 0) :
					// H4 tag with it's customized options
					echo heading(
						$circular_image_title,
						'4',
						array(
							'class' => 'h1-head '. $circular_image_title_position .' '. $circular_image_title_color,
							'data-aos' => 'flip-up'
						)
					);
				endif;
			?>

            <div class="row" data-aos="fade-up">
                <?php
					foreach ($circular_images as $circular_image) :

						// Image and Content Positions
						if ($circular_image->image_position == 'l4 right') :
							$col_img = 'l4 right';
							$col_content = 'l8';
						elseif($circular_image->image_position == 'l4 left') :
							$col_img = 'l4 left';
							$col_content = 'l8';
						else :
							$col_img = 'l12';
							$col_content = 'l12';
						endif;

						//Apply Text heading customized options
						$heading_array = array('<h1>', '<h2>', '<h3>', '<h4>', '<h5>', '<h6>');

						$replace_heading = array(
							'<h1 class="'.$circular_image->content_title_position.' '.$circular_image->content_title_color.'" id="content_circular_image_title_'.$circular_image->id.$circular_image->page_id.'">',
							'<h2 class="'.$circular_image->content_title_position.' '.$circular_image->content_title_color.'" id="content_circular_image_title_'.$circular_image->id.$circular_image->page_id.'">',
							'<h3 class="'.$circular_image->content_title_position.' '.$circular_image->content_title_color.'" id="content_circular_image_title_'.$circular_image->id.$circular_image->page_id.'">',
							'<h4 class="'.$circular_image->content_title_position.' '.$circular_image->content_title_color.'" id="content_circular_image_title_'.$circular_image->id.$circular_image->page_id.'">',
							'<h5 class="'.$circular_image->content_title_position.' '.$circular_image->content_title_color.'" id="content_circular_image_title_'.$circular_image->id.$circular_image->page_id.'">',
							'<h6 class="'.$circular_image->content_title_position.' '.$circular_image->content_title_color.'" id="content_circular_image_title_'.$circular_image->id.$circular_image->page_id.'">'
						);

						// replace heading options in text
						$text = str_replace($heading_array, $replace_heading, $circular_image->content);

						$data = '<div class="col s12 '.$count.' ">
						<div class="card-panel '.$circular_image->background_color.'" id="circular_image_bg_'.$circular_image->id.$circular_image->page_id.'" onmouseover = "CircularImageHover(\'' . $circular_image->background_color . '\', \'' . $circular_image->title_color . '\', \''.$circular_image->content_title_color.'\', \''.$circular_image->content_color.'\' ,\'' . $circular_image->background_hover_color . '\', \'' . $circular_image->hover_title_color . '\', \''.$circular_image->content_title_hover_color.'\', \''.$circular_image->content_hover_color.'\' ,' . $circular_image->id . ', ' . $circular_image->page_id . ')" onmouseout = "CircularImageHoverOut( \'' . $circular_image->background_color . '\', \'' . $circular_image->title_color . '\', \''.$circular_image->content_title_color.'\', \''.$circular_image->content_color.'\' ,\'' . $circular_image->background_hover_color . '\', \'' . $circular_image->hover_title_color . '\', \''.$circular_image->content_title_hover_color.'\', \''.$circular_image->content_hover_color.'\' ,' . $circular_image->id . ', ' . $circular_image->page_id . ' )">
							<div class="row">
								<div class="col s12 '.$col_img.' circular-img-bg white">
									<div class="circular-image-img">
									'.img(array(
										'src' => $image_url . $circular_image->image,
										'alt' => $circular_image->title,
										'title' => $circular_image->title,
										'class' => 'circle responsive-img right'
									)).'
									</div>
								</div>

								<div class="col s12 '.$col_content.'">
									'.heading(
										$circular_image->title,
										'5',
										array(
											'class' => 'h5-head circular-image-title '.$circular_image->title_color.' '.$circular_image->title_position,
											'id' => 'circular_image_title_'.$circular_image->id.$circular_image->page_id
										)
									).'
									<div class="circular-image-content '.$circular_image->content_position.' '.$circular_image->content_color.'" id="circular_image_content_'.$circular_image->id.$circular_image->page_id.'" >
									'.$text.'
									</div>
								</div>
							</div>
						</div>
					</div>';

					// Check redirect is enabled
					if ($circular_image->redirect === '1') :

						// Check open new tab is enabled
						if ($circular_image->open_new_tab === '1') :
							$open_new_tab = array(
								'target' => '_blank'
							);
						else:
							$open_new_tab = array();
						endif;

						echo anchor(
							$circular_image->redirect_url,
							$data,
							$open_new_tab
						);
					else :
						echo $data;
					endif;

					endforeach;
				?>
            </div>

        </div>
    </div>
</section>
<?php endif;?>