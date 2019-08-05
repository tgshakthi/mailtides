<?php if(!empty($testimonial_id)): ?> 

	<section class="section <?php echo $background_color; ?>">
    	<div class="container">
      		<div class="row">
      			<div class="col s12 l12">
      				
                    <?php if($testimonial_image != ''): ?>
						
                        <div class="single_event_img">
                            	
							<?php
								$image_properties = array(
                                    'src' => $image_url . $testimonial_image,
                                    'alt' => $image_alt,
                                    'title' => $image_title
                                );
                                
								echo img($image_properties); 						
                            
                            ?>
                      	</div>
                        
                    <?php endif; ?>
                    
      				<div class="single_event_details">
                    	<?php 
						echo heading(
							$author,
							3,
							array(
								'class' => $author_color,
								'id'    => 'event_detail_heading',
								'onmouseover' => "event_detail_head_hover('".$title_color."', '".$title_hover_color."')",
								'onmouseout' => "event_detail_head_hover_out('".$title_color."', '".$title_hover_color."')"
							)
						); 
						?>
                        
                        <ul class="date_admin_eventdetails">
                        	<?php if($date != ''): ?>
                        		<li class="<?php echo $date_color; ?>">
                        			<i class="far fa-calendar-alt"></i>&nbsp; <?php echo $date; ?>
                        		</li>
                            <?php endif; ?>
                            <?php if($location != ''): ?>
                        		<li class="<?php echo $location_color; ?>">
                        			<i class="fas fa-map-marker-alt"></i>&nbsp; <?php echo $location; ?>
                        		</li>
                            <?php endif; ?>
                        </ul>

						<?php
						$heading_attributes = array(
							'class = "'.$description_title_color.' '.$description_title_position.'"',
							'id = "desc_title_'.$event_id.'"',
							'onmouseover = "desc_title_hover(\''.$description_title_color.'\', \''.$description_title_hover_color.'\', '.$event_id.')"',
							'onmouseout = "desc_title_hover_out(\''.$description_title_color.'\', \''.$description_title_hover_color.'\', '.$event_id.')"'
						);
						
						$heading_attribute = $this->setting->text_head_attributes($heading_attributes, $description);
						
						$text_attributes = array(
							'class = "'.$description_color.' '.$description_position.'"',
							'id = "desc_text_'.$event_id.'"',
							'onmouseover = "desc_text_hover(\''.$description_color.'\', \''.$description_hover_color.'\', '.$event_id.')"',
							'onmouseout = "desc_text_hover_out(\''.$description_color.'\', \''.$description_hover_color.'\', '.$event_id.')"'
						);
						?>
                        <div id="desc_text_<?php echo $event_id; ?>" class="<?php echo $description_color.' '.$description_position; ?>" onmouseover="desc_text_hover('<?php echo $description_color; ?>', '<?php echo $description_hover_color; ?>', <?php echo $event_id; ?>)" onmouseout="desc_text_hover_out('<?php echo $description_color; ?>', '<?php echo $description_hover_color; ?>', <?php echo $event_id; ?>)">
                        	<?php echo $this->setting->text_attributes($text_attributes, $heading_attribute); ?>
                        </div>

      				</div>
      
      			</div>
      		</div>
      	</div>
	</section>

<?php endif; ?>