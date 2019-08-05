<?php if(!empty($event_id)): ?>


<section class="bg-img-common  <?php echo $background_color;?>" <?php if ($background_image != "") : ?>
    style="background-image:url('<?php echo base_url() . $image_url . $background_image;?>')" <?php endif;?>>
<div class="common-space">    
<div class="container">
     <div class="event-content-image white">  
        <div class="row">
            <div class="col s12 l12">
            <div id="slider1" class="jSlider event-detail-page col s12 m6">
                <?php if($image != ''): ?>

                <div class="event-single-image">

                    <?php
                            $images = explode(',', $image);
                            foreach($images as $image):
                    
                                $image_properties = array(
                                    'src' => $image_url . $image,
                                    'alt' => $image_alt,
                                    'title' => $image_title
                                );
                                
								echo img($image_properties); 
								
                            endforeach;
                            ?>
                </div>
                </div>
                <?php endif; ?>

                <div class="event-single-details">
                    <?php 
						echo heading(
							$title,
							3,
							array(
								'class' =>'h3-head ' . $title_color.' '.$title_position,
								'id'    => 'event_detail_heading',
								'onmouseover' => "eventDetailHeadHover('".$title_color."', '".$title_hover_color."')",
								'onmouseout' => "eventDetailHeadHoverOut('".$title_color."', '".$title_hover_color."')"
							)
						); 
						?>

                    <ul class="event-date-detail">
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
							'onmouseover = "eventDescTitleHover(\''.$description_title_color.'\', \''.$description_title_hover_color.'\', '.$event_id.')"',
							'onmouseout = "eventDescTitleHoverOut(\''.$description_title_color.'\', \''.$description_title_hover_color.'\', '.$event_id.')"'
						);
						
						$heading_attribute = $this->setting->text_head_attributes($heading_attributes, $description);
						
						$text_attributes = array(
							'class = "'.$description_color.' '.$description_position.'"',
							'id = "desc_text_'.$event_id.'"',
							'onmouseover = "eventDescTextHover(\''.$description_color.'\', \''.$description_hover_color.'\', '.$event_id.')"',
							'onmouseout = "eventDescTextHoverOut(\''.$description_color.'\', \''.$description_hover_color.'\', '.$event_id.')"'
						);
						?>
                    <div id="desc_text_<?php echo $event_id; ?>"
                        class="<?php echo $description_color.' '.$description_position; ?>"
                        onmouseover="eventDescTextHover('<?php echo $description_color; ?>', '<?php echo $description_hover_color; ?>', <?php echo $event_id; ?>)"
                        onmouseout="eventDescTextHoverOut('<?php echo $description_color; ?>', '<?php echo $description_hover_color; ?>', <?php echo $event_id; ?>)">
                        <?php echo $this->setting->text_attributes($text_attributes, $heading_attribute); ?>
                    </div>

                </div>

            </div>
        </div>
    </div>
                    </div>
                    </div>
</section>

<?php endif; ?>