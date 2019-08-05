<?php if(!empty($tabs) && $status == 1): ?>

<section class="bg-img-common <?php echo $bg_color;?>" <?php if ($bg_image != "") : ?>
    style="background-image:url('<?php echo $bg_image;?>')" <?php endif;?>>
<div class="common-space">
    <div class="container">
        <div class="tab-title">
            <?php 
                echo heading(
                    $tab_title,
                    4,
                    array(
						'class' => 'h1-head ' . $title_color.' '.$title_position,
						'data-aos' => 'flip-up'
                    )
                ); 
            ?>
        </div>

        <div class="row">
            <div class="col s12">
                <ul id="tab-tabs" class="center h-tab tabs <?php //echo $background_color; ?>" data-aos="fade-up">

                    <?php 
						$i = 0;
						foreach($tabs as $tab): 							
					?>

                    <li class="tab col">
                        <a class="<?php echo ($i == 0) ? 'active': ''; ?> <?php echo $tab->tab_color; ?>"
                            href="#tab_<?php echo $tab->id; ?>"><?php echo $tab->tab_name; ?></a>
                    </li>
                    <?php
							$i++;
						endforeach;
					?>
                </ul>
            </div>
            <?php foreach($tabs as $tab): ?>
            <div id="tab_<?php echo $tab->id; ?>" class="animate-opacity col s12 tab-describe" data-aos="fade-up">
                <?php
						if($tab->tab_components != ''):
						
							$tab_components = explode(',', $tab->tab_components);
							foreach($tab_components as $tab_component):
							
								if($tab_component == 'text_full_width'):
								
									$text_full_width = $this->Tab_model->get_tab_text_full_width($tab->id);
									if(!empty($text_full_width)):
									
										?>
                <section class="section tab-content-space <?php echo $text_full_width[0]->background_color;?>">
                    <div class="tab-text-full-width">
                        <?php
                                            		// H1 Tag
                                           			echo heading($text_full_width[0]->title, 4, array(
                                                		'class' => 'h3-head ' . $text_full_width[0]->title_position.' '.$text_full_width[0]->title_color
                                            		));
                                            		?>
                        <div
                            class="<?php echo $text_full_width[0]->content_position.' '.$text_full_width[0]->content_color;?>">
                            <?php echo $text_full_width[0]->full_text; ?>
                        </div>
                    </div>
                </section>
                <?php
									
									endif;
									
								elseif($tab_component == 'text_image'):
								
									$text_images = $this->Tab_model->get_tab_text_image($tab->id);
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
												'class' => 'common-btn waves-effect waves-light ' . $text_image->button_type . ' ' . $text_image->btn_background_color . ' ' . $text_image->label_color,
												'id' => 'tab_hover_' . $text_image->id,
												'onmouseover' => 'tabReadMoreHover(\'' . $text_image->btn_background_color . '\', \'' . $text_image->label_color . '\', \'' . $text_image->background_hover . '\', \'' . $text_image->text_hover . '\', ' . $text_image->id . ')',
												'onmouseout' => 'tabReadMoreHoverOut(\'' . $text_image->btn_background_color . '\', \'' . $text_image->label_color . '\', \'' . $text_image->background_hover . '\', \'' . $text_image->text_hover . '\', ' . $text_image->id . ')'
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
										if (!empty($text_image->readmore_character) && $text_image->readmore_character != 0):
								
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
												$stringCut = substr($text, 0, $text_image->readmore_character);
												$endPoint = strrpos($stringCut, ' ');
												$text = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
												
												$text.= '...' . $read_more;
											endif;
								
										else:
											$text = $text_image->text . ' ' . $read_more;
										endif;
										?>
                <section class="section tab-content-space <?php echo $text_image->background_color;?>">
                    <div class="tab-text-image">
                        <div class="row">

                        
                            <div class="col s12 m6 <?php echo $text_image->image_position;?>">
                                <div class="tab-image-img">

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

                            <div class="col s12 m6">
                                <div class="tab-content">
								<?php
														if ($text_image->template == 1) :
															// H3 Tag
															echo heading(
																$text_image->title,
																4,  
																array(
																	'class' => 'h3-head ' . $text_image->title_position. ' ' .$text_image->title_color
																)
															);
													?>

                                    <div class="flow-text <?php echo $text_image->content_color;?>">
                                        <?php echo $text;?>
                                    </div>

                                </div>
                            </div>

                            <?php
														elseif ($text_image->template == 2) :
															// H3 Tag
															echo heading(
																$text_image->title,
																4,
																array(
																	'class' => 'h1-head ' . $text_image->title_position. ' ' .$text_image->title_color
																)
															);
													?>

                            <div class="col s12 <?php echo $text_image->image_size.' '. $text_image->image_position;?>">
                                <div class="img_part">

                                    <?php
																	// Image Tag
																	$image = array(
																		'class' => 'z-depth-3',
																		'src' => $image_url . $text_image->image,
																		'alt' => $text_image->image_alt,
																		'title' => $text_image->image_title
																	);
																	echo img($image);
																?>

                                </div>
                            </div>

                            <div class="tab-content">

                                <div class="flow-text <?php echo $text_image->content_color;?>">
                                    <?php echo $text;?>
                                </div>

                            </div>

                            <?php	endif;?>

                        </div>
                    </div>
                </section>

                <?php
									endforeach;

								endif;
							
							endforeach;
						
						endif;
						?>
            </div>
            <?php
				
				endforeach;
				?>
        </div>
	</div>
	</div>
</section>

<?php endif; ?>