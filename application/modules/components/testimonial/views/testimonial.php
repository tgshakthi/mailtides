<?php if(!empty($testimonials) && !empty($testimonial_pages)): ?>

	<section class="bg-img-common <?php echo $bg_color;?>" <?php if ($bg_image != "") : ?>
    style="background-image:url('<?php echo $bg_image;?>')" <?php endif;?>>
	<div class="common-space">
		<div class="container">
			<div class="testimonial_slider">
            	<?php 
					echo heading(
						$testimonial_pages[0]->title,
						4,
						array(
							'class' => 'h1-head ' . $testimonial_pages[0]->title_color.' '.$testimonial_pages[0]->title_position,
							'data-aos' => 'zoom-in'
						)
					); 
					
					// Input tag hidden
					echo form_input(array(
						'type'  => 'hidden',
						'name'  => 'testimonial_per_row',
						'id'    => 'testimonial_per_row',
						'value' => ($testimonial_pages[0]->testimonial_per_row != 0 && $testimonial_pages[0]->testimonial_per_row != '') ? $testimonial_pages[0]->testimonial_per_row: 1
					));
				?>
				<ul id="testimonial" class="testimonial_list" data-aos="fade-up">
                	<?php foreach($testimonials as $testimonial): ?>
                        <li  class="testitem <?php echo $testimonial->background_color; ?>" >
                            <a href="<?php echo ($testimonial->redirect == 1) ? base_url() . 'testimonial/'.$testimonial->redirect_url: 'javascript:void(0)'; ?>" <?php echo ($testimonial->open_new_tab == 1) ? 'target="_blank"': ''; ?>>
                                <article>  
								<!-- <div class="before_after" id="grid_testimonial_<?php echo $page_id.$testimonial->id; ?>" onmouseover="testimonial_grid_hover('<?php echo $testimonial->background_color; ?>', '<?php echo $testimonial->background_hover_color; ?>', '<?php echo $testimonial->author_color; ?>', '<?php echo $testimonial->author_hover; ?>', '<?php echo $testimonial->content_title_color; ?>', '<?php echo $testimonial->content_title_hover_color; ?>', '<?php echo $testimonial->content_color; ?>', '<?php echo $testimonial->content_hover_color; ?>', '<?php echo $testimonial->designation_color; ?>', '<?php echo $testimonial->designation_hover; ?>', '<?php echo $page_id; ?>', '<?php echo $testimonial->id; ?>')" onmouseout="testimonial_grid_hover_out('<?php echo $testimonial->background_color; ?>', '<?php echo $testimonial->background_hover_color; ?>', '<?php echo $testimonial->author_color; ?>', '<?php echo $testimonial->author_hover; ?>', '<?php echo $testimonial->content_title_color; ?>', '<?php echo $testimonial->content_title_hover_color; ?>', '<?php echo $testimonial->content_color; ?>', '<?php echo $testimonial->content_hover_color; ?>', '<?php echo $testimonial->designation_color; ?>', '<?php echo $testimonial->designation_hover; ?>', '<?php echo $page_id; ?>', '<?php echo $testimonial->id; ?>')"> -->

								<div class="before_after" id="grid_testimonial_<?php echo $page_id.$testimonial->id; ?>">

										<?php
                                        $heading_attributes = array(
											'class = "'.$testimonial->content_title_color.' '.$testimonial->content_title_position.'"',
											'id = grid_content_title_'.$page_id.$testimonial->id
										);
										
										$heading_attribute = $this->setting->text_head_attributes($heading_attributes, $testimonial->content);
										
										$text_attributes = array(
											'class = "testimonial_para '.$testimonial->content_color.' '.$testimonial->content_position.'"',
											'id = grid_content_text_'.$page_id.$testimonial->id
										);
										
										echo $this->setting->text_attributes($text_attributes, $heading_attribute); 
                                        ?>
									</div>
									
									<?php if (!empty($testimonial->image)) :?>

										<div class="author_detials2">

											<div class="author-img">
												<p class="test_user <?php echo $testimonial->image_type; ?>">
													<?php
														$image_properties = array(
															'src' => $image_url . $testimonial->image,
															'alt' => $testimonial->image_alt,
															'title' => $testimonial->image_title
														);
													
														echo img($image_properties);
													?>
												</p>
											</div>

											<div class="test-auth-detail">

												<?php									
													echo heading(
														$testimonial->author,
														4,
														array(
															'class' =>'center-align ' .  $testimonial->author_color,
															'id' => 'grid_author_'.$page_id.$testimonial->id,
														)
													); 
												?>

												<p id="grid_designation_<?php echo $page_id.$testimonial->id; ?>" class="designation center-align <?php echo $testimonial->designation_color; ?>"><?php echo $testimonial->designation; ?></p>

											</div>

										</div>
									
									<?php endif;?>
                                
                                </article>
                            </a>
                        </li>
                        <?php
					
					endforeach;
					?>
				</ul>
			</div>
		</div>
		</div>
	</section>
	
<?php endif;?>