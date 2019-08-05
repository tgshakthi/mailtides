<?php if(!empty($center_tabs) && $status == 1):?>

	<section class="bg-img-common <?php echo $bg_color;?>" <?php if ($bg_image != "") : ?>
    style="background-image:url('<?php echo $bg_image;?>')" <?php endif;?>>
	<div class="common-space">
	<div class="container" data-aos="fade-up">
			<div class="center-tab-container">
				<?php
					echo heading(
						$tab_title,
						4,
						array(
							'class' =>  'h1-head '. $title_color.' '.$title_position 
						)
					);
                ?>

				<div class="center-tabs">

					<div class="center-tab-list">
						<ul class="center-tab-ul">
							<?php
								$i = 1;
								foreach($center_tabs as $center_tab):
							?>
							

								<li class="tab ">

								
									<a class=" active left-align <?php echo $center_tab->tab_color;?> center-tab-<?php echo $i;?> center_tab_head" href="#center-tab<?php echo $i;?>" onclick="return center_tab_text_color('white-text', 'blue-text','transparent','white ', '<?php echo $i;?>')"><?php echo $center_tab->tab_name;?>
						
								</a>
							
								</li>
							<?php
								$i++;
								endforeach;
							?>
						</ul>
					</div>
					<?php
						$text_images = $this->Center_tab_model->get_center_tab_text_image($page_id);

						if(!empty($text_images)):
							$j = 1;
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
											'id' => 'center_tab_hover_' . $text_image->id,
											'onmouseover' => 'center_tab_read_more_hover(\'' . $text_image->btn_background_color . '\', \'' . $text_image->label_color . '\', \'' . $text_image->background_hover . '\', \'' . $text_image->text_hover . '\', ' . $text_image->id . ')',
											'onmouseout' => 'center_tab_read_more_hoverout(\'' . $text_image->btn_background_color . '\', \'' . $text_image->label_color . '\', \'' . $text_image->background_hover . '\', \'' . $text_image->text_hover . '\', ' . $text_image->id . ')'
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

									// Read more btn
									if (!empty($read_more)):

										// Readmore After @param = readmore_character
										$stringCut = substr($text, 0);
										$endPoint = strrpos($text, ' ');
										$text = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
										$text.= '...' . $read_more;
									
								else:
									$text = $text_image->text . ' ' . $read_more;
								endif;
						?>
								<div id="center-tab<?php echo $j;?>" class="center-tab-content">
									<div class="center-tab-text-image col s12 m8 ">
										<div class=<?php echo $text_image->image_position;?>>
											<?php
												if($text_image->template == 1):
											?>
													<div class="center-tab-img ">
														<?php
															$image = array(
																		  'class' => 'z-depth-3',
																		  'src' => $image_url . $text_image->image,
																		  'alt' => $text_image->image_alt,
																		  'title' => $text_image->image_title
																		);
															echo img($image);
														?>
													</div>
													<div class="center-tab-text-content  <?php echo $text_image->content_color;?>">
														<?php echo $text;?>
													</div>
											<?php
												elseif($text_image->template == 2):
											?>
													<div class="center-tab-img ">
														<?php
															$image = array(
																		  'class' => 'z-depth-3',
																		  'src' => $image_url . $text_image->image,
																		  'alt' => $text_image->image_alt,
																		  'title' => $text_image->image_title
																		);
															echo img($image);
														?>
													</div>
													<div class="center-tab-text-content  <?php echo $text_image->content_color;?>">
														<?php echo $text;?>
													</div>
											<?php
												endif;
											?>
										</div>
									</div>
								</div>
						<?php
								$j++;
							endforeach;
						endif;
					?>

				</div>
			</div>
			<!--row -->
		</div>
					</div>
		<!--Container-->
	</section>
<?php endif; ?>
