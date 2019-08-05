<?php
/**
 * Text Icon
 *
 * @category view
 * @package Text Icon
 * @author Saravana
 * created at: 28-Jun-18
 */

 if (!empty($text_icons)) :
	$open_new_tab = array();	
?>
<section class="bg-img-common <?php echo $bg_color;?>" <?php if ($bg_image != "") : ?>
    style="background-image:url('<?php echo $bg_image;?>')" <?php endif;?>>
    <div class="common-space">
        <div class="container">
            <?php
				// Check Heading is enabled
				if ($text_icon_title_status != 0) :
					// H4 tag with it's customized options
					echo heading(
						$text_icon_title,
						'4',
						array(
							'class' => 'h1-head ' . $text_icon_title_position .' '. $text_icon_title_color,
							'data-aos' => 'fade-up'
						)
					);
				endif;
			?>
            <div class="row" id="float_div">
                <?php
					foreach ($text_icons as $text_icon) :
						$result = '';
						//Apply Text heading customized options
						$heading_array = array('<h1>', '<h2>', '<h3>', '<h4>', '<h5>', '<h6>');
						$replace_heading = array(
							'<h1 class="'.$text_icon->content_title_position.' '.$text_icon->content_title_color.'" id="content_text_icon_title_'.$text_icon->id.$text_icon->page_id.'">',
							'<h2 class="'.$text_icon->content_title_position.' '.$text_icon->content_title_color.'" id="content_text_icon_title_'.$text_icon->id.$text_icon->page_id.'">',
							'<h3 class="'.$text_icon->content_title_position.' '.$text_icon->content_title_color.'" id="content_text_icon_title_'.$text_icon->id.$text_icon->page_id.'">',
							'<h4 class="'.$text_icon->content_title_position.' '.$text_icon->content_title_color.'" id="content_text_icon_title_'.$text_icon->id.$text_icon->page_id.'">',
							'<h5 class="'.$text_icon->content_title_position.' '.$text_icon->content_title_color.'" id="content_text_icon_title_'.$text_icon->id.$text_icon->page_id.'">',
							'<h6 class="'.$text_icon->content_title_position.' '.$text_icon->content_title_color.'" id="content_text_icon_title_'.$text_icon->id.$text_icon->page_id.'">'
						);

						// replace heading options in text
						$text = str_replace($heading_array, $replace_heading, $text_icon->content);

						$text = str_replace('<a', "<a class='$text_icon->content_color'", $text);

						// Text Icon Heading
						$heading = heading(
							$text_icon->title,
							'4',
							array(
								'class' => 'texticon-tittle-tag h4-head '.$text_icon->title_color.' '.$text_icon->title_position,
								'id' => 'text_icon_title_'.$text_icon->id.$text_icon->page_id
							)
						);

						$result .= '<div class="card-panel '.$text_icon->background_color.'" id="icon_bg_color_'.$text_icon->id.$text_icon->page_id.'">
						<div class="text-icon-icon '.$text_icon->icon_shape.' '.$text_icon->icon_position.'"
						onmouseover = "textIconHover(\'' . $text_icon->icon_background_color . '\', \'' . $text_icon->icon_color . '\', \'' . $text_icon->icon_hover_background . '\', \'' . $text_icon->icon_hover_color . '\', ' . $text_icon->id . ', ' . $text_icon->page_id . ')" onmouseout = "textIconHoverOut( \'' . $text_icon->icon_background_color . '\', \'' . $text_icon->icon_color . '\', \'' . $text_icon->icon_hover_background . '\', \'' . $text_icon->icon_hover_color . '\', ' . $text_icon->id . ', ' . $text_icon->page_id . ' )" >
							<i class="fa '.$text_icon->icon.' '.$text_icon->icon_color.' '.$text_icon->icon_background_color.'" id="icon_color_'.$text_icon->id.$text_icon->page_id.'"></i>
						</div>
						'.$heading.'
						<div class="text-icon-content '.$text_icon->content_color.' '.$text_icon->content_position.'" id="icon_content_color_'.$text_icon->id.$text_icon->page_id.'"> '. $text .' </div>
						</div>';

						// Check redirect is enabled
						if ($text_icon->redirect == 1) :
							// Check Open new tab is enabled
							if ($text_icon->open_new_tab == 1) :
								$open_new_tab = array(
									'target' => '_blank'
								);
							endif;

							// redirect
							$redirect = anchor(
								$text_icon->redirect_url,
								$result,
								$open_new_tab
							);
				?>
                <div class="col s12 <?php echo $count;?> float_box text-icon-box" data-aos="zoom-in"
                    id="icon_hover_<?php echo $text_icon->id . $text_icon->page_id;?>"
                    onmouseover="textIconBgHover('<?php echo $text_icon->background_color;?>', '<?php echo $text_icon->title_color;?>', '<?php echo $text_icon->content_color; ?>', '<?php echo $text_icon->content_title_color;?>', '<?php echo $text_icon->background_hover_color;?>', '<?php echo $text_icon->text_hover_color;?>', '<?php echo $text_icon->hover_title_color;?>', '<?php echo $text_icon->content_title_hover;?>', <?php echo $text_icon->id;?>, <?php echo $text_icon->page_id?> )"
                    onmouseout="textIconBgHoverOut('<?php echo $text_icon->background_color;?>', '<?php echo $text_icon->title_color;?>', '<?php echo $text_icon->content_color;?>', '<?php echo $text_icon->content_title_color;?>', '<?php echo $text_icon->background_hover_color;?>', '<?php echo $text_icon->text_hover_color;?>', '<?php echo $text_icon->hover_title_color;?>', '<?php echo $text_icon->content_title_hover;?>', <?php echo $text_icon->id;?>, <?php echo $text_icon->page_id;?>)">
                    <?php echo $redirect;?>
                </div>
                <?php
						else :
				?>
                <div class="col s12 <?php echo $count;?> float_box text-icon-box" data-aos="zoom-in"
                    id="icon_hover_<?php echo $text_icon->id . $text_icon->page_id;?>"
                    onmouseover="textIconBgHover('<?php echo $text_icon->background_color;?>', '<?php echo $text_icon->title_color;?>', '<?php echo $text_icon->content_color; ?>', '<?php echo $text_icon->content_title_color;?>', '<?php echo $text_icon->background_hover_color;?>', '<?php echo $text_icon->text_hover_color;?>', '<?php echo $text_icon->hover_title_color;?>', '<?php echo $text_icon->content_title_hover;?>', <?php echo $text_icon->id;?>, <?php echo $text_icon->page_id?> )"
                    onmouseout="textIconBgHoverOut('<?php echo $text_icon->background_color;?>', '<?php echo $text_icon->title_color;?>', '<?php echo $text_icon->content_color;?>', '<?php echo $text_icon->content_title_color;?>', '<?php echo $text_icon->background_hover_color;?>', '<?php echo $text_icon->text_hover_color;?>', '<?php echo $text_icon->hover_title_color;?>', '<?php echo $text_icon->content_title_hover;?>', <?php echo $text_icon->id;?>, <?php echo $text_icon->page_id;?>)">
                    <?php echo $result;?>
                </div>
                <?php
						endif;
				?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<?php endif;?>