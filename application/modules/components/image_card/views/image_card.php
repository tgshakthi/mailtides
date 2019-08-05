<?php
/**
 * Image card
 * @category View
 * @package Image Card
 * @author Saravana
 * Created at : 28-Jun-18
 */

 if (!empty($image_cards)) :
?>
<section class="bg-img-common image-card <?php echo $bg_color;?>" <?php if ($bg_image != "") : ?>
	style="background-image:url('<?php echo $bg_image;?>')" <?php endif;?>>
	<div class="common-space">
		<div class="container">

			<?php if ($image_card_title_status == 1) : ?>
			<div class="h1-head  <?php echo $image_card_title_color.' '.$image_card_title_position ;?>">
				<?php  echo $image_card_title ;?>
			</div>
			<?php endif; ?>

			<?php
				if ($page_url == "index.html" || $page_url == "contact.html") :
					$class = 'single-image';
				else :
					$class = "";
				endif;
			?>

			<div class="row <?php echo $class;?>" id="float_div" data-aos="fade-up">
				<?php
                    foreach ($image_cards as $image_card) :

						// Image
						$img =  img(array(
							'src' => $image_url . $image_card->image,
							'alt' => strip_tags($image_card->title),
							'title' => strip_tags($image_card->title),
							'class' => 'activator'
						));

						
                        // Description
                        $desc_text = $image_card->description;

                        // Description Heading
                        $heading_attributes = array(
                            'class="'.$image_card->description_title_color . ' ' . $image_card->description_title_position.'"'
                        );

						// Readmore button
						if ($image_card->readmore_btn == 1) :

							// Check Open new tab is enabled
							if ($image_card->open_new_tab == 1) :
								$open_new_tab = array(
									'target' => '_blank'
								);
							else :
								$open_new_tab = array();
							endif;				

							$readmore_attributes = array(
								'class' => $image_card->button_type.'  '.$image_card->readmore_label_color.' '.$image_card->btn_background_color ,
								'id' => 'hover_' . $image_card->id . $image_card->page_id,
								'onmouseover' => 'imageCardReadMoreHover(\'' . $image_card->btn_background_color . '\', \'' . $image_card->readmore_label_color . '\', \'' . $image_card->btn_hover_color . '\', \'' . $image_card->btn_label_hover_color . '\', ' . $image_card->id . ', ' . $image_card->page_id . ')',
								'onmouseout' => 'imageCardReadMoreHoverOut(\'' . $image_card->btn_background_color . '\', \'' . $image_card->readmore_label_color . '\', \'' . $image_card->btn_hover_color . '\', \'' . $image_card->btn_label_hover_color . '\', ' . $image_card->id . ', ' . $image_card->page_id . ')'
							);

							// merge additional attributes
							$readmore_attributes = array_merge($readmore_attributes, $open_new_tab);
					
							$readmore_btn = anchor(
								$image_card->readmore_url,
								$image_card->readmore_label,
								$readmore_attributes
							);
						endif;

						if ($page_url == "index.html" || $page_url == "contact.html") :
							$count = 'm6 l12 xl12';
						else :
							$count = $count;
						endif;

				?>

				<div class="col s12 <?php echo $count;?> float_box">
				

					<figure class=" sticky-action">

						<div class="card-image waves-effect waves-block waves-light image-card-img-effect">
							<?php echo $img;?>
						</div>

						<div class="heading-of-imgcard">
							<span class=" image-card-heading grey-text text-darken-4 ">

								<div class="<?php echo $image_card->title_color.' '.$image_card->title_position?>"
									id="image_card_title_<?php echo $image_card->id.$image_card->page_id;?>"
									>
									<?php echo $image_card->title;?>
								</div>
								<div>
									<?php if ($image_card->readmore_btn == 1) :?>
									<div class="card-action image-card-button">
										<?php echo $readmore_btn;?>
									</div>
									<?php endif;?>
								</div>
							</span>
						</div>

						<?php if (!empty($desc_text)) :?>
						<div class="image-card-position-relative"
							id="desc_card_<?php echo $image_card->id.$image_card->page_id;?>"
							>

							<div class="<?php echo $image_card->description_position.' '.$image_card->description_color;?>"
								id="short_desc_div_<?php echo $image_card->id.$image_card->page_id;?>"
								>
								<?php echo $this->setting->text_head_attributes($heading_attributes, $desc_text);?>
							</div>

						</div>
						<?php endif;?>

					</figure>

				</div>

				<?php	endforeach; ?>

			</div>
		</div>
	</div>
</section>

<?php endif; ?>
