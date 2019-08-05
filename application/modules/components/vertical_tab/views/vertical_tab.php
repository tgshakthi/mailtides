<?php if(!empty($vertical_tabs) && $status == 1):?>


<div>

<section class="bg-img-common <?php echo $bg_color;?>" <?php if ($bg_image != "") : ?>
    style="background-image:url('<?php echo $bg_image;?>')" <?php endif;?>>

	<div class="common-space">
		<div class="container"  data-aos="fade-up-right">

			<?php
				echo heading(
					$tab_title,
					4,
					array(
						'class' => 'h1-head ' . $title_color.' '.$title_position
					)
				);
			?>

			<div class="row tab-container" id="vertical-tab-side-container">
				
				<ul class="col s12 m12 l3 xl3 vertical-tab-li">

					<?php
						$i = 0;
						foreach($vertical_tabs as $vertical_tab):
					?>

					<li class="vertical-side-tab">
						<a class=" <?php echo $vertical_tab->vertical_tab_color; ?> tab-<?php echo $vertical_tab->id; ?> <?php echo ($i === 0 ) ? 'vertical-active active' : '';?>"
						 id="vertical_tab"  href="#side-tab<?php echo $vertical_tab->id; ?>" onclick="return verticalTabTextColor('blue-text', 'black-text','transparent','', '<?php echo $vertical_tab->id; ?>')">
						 	<?php echo $vertical_tab->vertical_tab_name; ?>
						 </a>
					</li>

					<?php
							$i++;
						endforeach;
					?>
				</ul>

				<div class="panel-container col s12 m12 l9 xl9">

					<?php foreach($vertical_tabs as $vertical_tab):?>

					<div id="side-tab<?php echo $vertical_tab->id; ?>">

						<?php 
							if($vertical_tab->vertical_tab_components != ''):
								$vertical_tab_components = explode(',', $vertical_tab->vertical_tab_components);

								foreach($vertical_tab_components as $vertical_tab_component):

									// Text Full Width
									if($vertical_tab_component == 'text_full_width'):

										$text_full_width = $this->Vertical_tab_model->get_vertical_tab_text_full_width($vertical_tab->id);
						?>

						<div class="vertical-tab-content <?php echo $text_full_width[0]->background_color;?>">
							<!-- <div class="spacer"></div> -->
							<h3 class="h3-head <?php echo $text_full_width[0]->title_position.' '.$text_full_width[0]->title_color;?>">
								<?php echo $text_full_width[0]->title;?>
							</h3>

							<div class="vertical-content-tab <?php echo $text_full_width[0]->content_position.' '.$text_full_width[0]->content_color;?>">
								<?php echo $text_full_width[0]->full_text; ?>
							</div>
						</div>

						<?php
							// Text & Image
							elseif($vertical_tab_component == 'text_image') :

								$text_images = $this->Vertical_tab_model->get_vertical_tab_text_image($vertical_tab->id);
										foreach($text_images as $text_image):

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
													'class' => $text_image->button_type . ' waves-effect waves-light ' . $text_image->btn_background_color . ' ' . $text_image->label_color.' '.'right',
													'id' => 'vertical_tab_hover_' . $text_image->id,
													'onmouseover' => 'verticalTabReadMoreHover(\'' . $text_image->btn_background_color . '\', \'' . $text_image->label_color . '\', \'' . $text_image->background_hover . '\', \'' . $text_image->text_hover . '\', ' . $text_image->id . ')',
													'onmouseout' => 'verticalTabReadMoreHoverOut(\'' . $text_image->btn_background_color . '\', \'' . $text_image->label_color . '\', \'' . $text_image->background_hover . '\', \'' . $text_image->text_hover . '\', ' . $text_image->id . ')'
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

											//Read more after some specified characters
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



												// Read more btn
												if (!empty($read_more)):
													// Readmore After @param = readmore_character
													$stringCut = substr($text, 0);
													$endPoint = strrpos($stringCut, ' ');
													$text = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);

													$text.= '...' . $read_more;
												

											else:
												$text = $text_image->text . ' ' . $read_more;
											endif;
						?>
											<div class="vertical-tab-text-image <?php echo $text_image->background_color;?>">

												<?php 
													// Text & image Template
													if ($text_image->template == 1) :

														// H3 Tag
														echo heading(
															$text_image->title,
															4,
															array(
																'class' => "h3-head " . $text_image->title_color. ' ' .$text_image->title_position
															)
														);
												?>

												<div class="vertical-tab-image  <?php echo $text_image->image_position;?>">

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

												<div class="vertical-tab-text-image-content">
													<div class="<?php echo $text_image->content_color;?>">
														<?php echo $text;?>
													</div>
												</div>

												<?php
													// Text & image Template
													elseif ($text_image->template == 2) :

														// H3 Tag
														echo heading(
															$text_image->title,
															4,
															array(
																'class' => $text_image->title_position. ' ' .$text_image->title_color
															)
														);
												?>
													<div class="vertical-tab-image  <?php echo $text_image->image_position;?>">

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

													<div class="vertical-tab-text-image-content">
														<div class="<?php echo $text_image->content_color;?>">
															<?php echo $text;?>
														</div>
													</div>
													
												<?php

													endif;
												?>

											</div>

						<?php					

										endforeach;
						?>

						<?php
									endif;

								endforeach;

							endif;
						?>

					</div>

					<?php endforeach; ?>

				</div>

				<!--row -->
			</div>
		</div>
	</div>

</section>

</div>


<?php endif;?>
