<?php
if(!empty($events) && !empty($event_pages)):

	if($event_pages[0]->event != '' && $event_pages[0]->event != 'none'):

		?>
<section class="bg-img-common <?php echo $bg_color;?>" <?php if ($bg_image != "") : ?>
    style="background-image:url('<?php echo $bg_image;?>')" <?php endif;?>>
<div class="common-space">
    <div class="container">
        <div class="blog_title">
            <?php
                    echo heading(
                        $event_pages[0]->title,
                        4,
                        array(
                            'class' =>' h1-head ' . $event_pages[0]->title_color.' '.$event_pages[0]->title_position,
                            'data-aos' => 'fade-up'
                        )
                    );
                    ?>
        </div>

        <?php if($event_pages[0]->event == 'event'): ?>

        <div id="event_masonry" class="row">

            <?php
                        foreach($events as $event):

                            $images = ($event->image != '') ? explode(',', $event->image): array();
							?>
            <div class="col s12 m6 <?php echo $event_pages[0]->event_per_row; ?>  events-img-details" data-aos="fade-up">
                <a href="<?php echo base_url(); ?>event/<?php echo $event->event_url; ?>"
                    class="<?php echo $event->background_color; ?>" id="event_grid_<?php echo $page_id.$event->id; ?>"
                    onmouseover="eventGridHover('<?php echo $event->background_color; ?>',  '<?php echo $event->title_color; ?>', '<?php echo $event->title_hover_color; ?>', '<?php echo $event->short_description_title_color; ?>', '<?php echo $event->short_description_title_hover_color; ?>', '<?php echo $event->short_description_color; ?>', '<?php echo $event->short_description_hover_color; ?>', '<?php echo $event->date_color; ?>', '<?php echo $event->date_hover; ?>', '<?php echo $event->location_color; ?>', '<?php echo $event->location_hover; ?>', '<?php echo $page_id; ?>', '<?php echo $event->id; ?>')"
                    onmouseout="eventGridHoverOut('<?php echo $event->background_color; ?>', '<?php echo $event->title_color; ?>', '<?php echo $event->title_hover_color; ?>', '<?php echo $event->short_description_title_color; ?>', '<?php echo $event->short_description_title_hover_color; ?>', '<?php echo $event->short_description_color; ?>', '<?php echo $event->short_description_hover_color; ?>', '<?php echo $event->date_color; ?>', '<?php echo $event->date_hover; ?>', '<?php echo $event->location_color; ?>', '<?php echo $event->location_hover; ?>', '<?php echo $page_id; ?>', '<?php echo $event->id; ?>')"
                    <?php echo ($event->open_new_tab == 1) ? 'target="_blank"': ''; ?>>
                    <?php if(!empty($images)): ?>

                    <div class=" event-imag-slide">

                        <?php
                                            foreach($images as $image):

                                                $image_properties = array(
                                                    'src' => $image_url . $image,
                                                    'alt' => $event->image_alt,
                                                    'title' => $event->image_title
                                                );

                                                echo img($image_properties);

                                            endforeach;
                                            ?>

<div class="event-overlay"></div>
                                        </div>

                    <?php endif; ?>

                    <div class="event-details">

                        <?php
                                        echo heading(
                                            $event->title,
                                            3,
                                            array(
                                                'class' => 'h5-head ' .$event->title_color.' '.$event->title_position,
												'id' => 'even_grid_title_'.$page_id.$event->id
                                            )
                                        );
                                        ?>

                        <ul class="event-date-detail">
                            <?php if($event->date != ''): ?>
                            <li id="event_date_<?php echo $page_id.$event->id; ?>"
                                class="<?php echo $event->date_color; ?>">
                                <i class="far fa-calendar-alt"></i>&nbsp; <?php echo $event->date; ?>
                            </li>
                            <?php endif; ?>
                            <?php if($event->location != ''): ?>
                            <li id="event_location_<?php echo $page_id.$event->id; ?>"
                                class="<?php echo $event->location_color; ?>">
                                <i class="fas fa-map-marker-alt"></i>&nbsp; <?php echo $event->location; ?>
                            </li>
                            <?php endif; ?>
                        </ul>


                        <?php
                                        $heading_attributes = array(
                                            'class = "'.$event->short_description_title_color.' '.$event->short_description_title_position.'"',
                                            'id = short_desc_title_'.$page_id.$event->id
                                        );

                                        $heading_attribute = $this->setting->text_head_attributes($heading_attributes, $event->short_description);

                                        $text_attributes = array(
                                            'class = "'.$event->short_description_color.' '.$event->short_description_position.'"',
                                            'id = short_desc_text_'.$page_id.$event->id
                                        );

                                        echo $this->setting->text_attributes($text_attributes, $heading_attribute);
                                        ?>

                    </div>

                </a>
            </div>
            <?php

						endforeach;
                        ?>

        </div>

        <?php elseif(!empty($event_categories) && $event_pages[0]->event == 'event_category'): ?>

        <ul id="event_tab" class="tabs event-grid-tab">

            <li class="tab col s3"><a href="#event_tab0" class="active">All</a></li>
            <?php
						$c = 1;
						foreach($event_categories as $event_category):

							?>
            <li class="tab col s3"><a href="#event_tab<?php echo $c; ?>"
                    class=""><?php echo $event_category->name; ?></a></li>
            <?php
							$c++;

						endforeach;
						?>

        </ul>

        <div id="event_tab0" class="col s12">

            <div id="event_masonry" class="row">

                <?php

                            foreach($all_events as $all_event):

                                $images = ($all_event->image != '') ? explode(',', $all_event->image): array();
                                ?>

                <div class=" col s12 m6 events-img-details <?php echo $event_pages[0]->event_per_row; ?>">
                    <a href="<?php echo base_url(); ?>event/<?php echo $all_event->event_url; ?>"
                        class="event-grid-list <?php echo $all_event->background_color; ?>"
                        id="event_grid_<?php echo $page_id.$all_event->id; ?>"
                        onmouseover="eventGridHover('<?php echo $all_event->background_color; ?>', '<?php echo $all_event->background_hover; ?>', '<?php echo $all_event->title_color; ?>', '<?php echo $all_event->title_hover_color; ?>', '<?php echo $all_event->short_description_title_color; ?>', '<?php echo $all_event->short_description_title_hover_color; ?>', '<?php echo $all_event->short_description_color; ?>', '<?php echo $all_event->short_description_hover_color; ?>', '<?php echo $all_event->date_color; ?>', '<?php echo $all_event->date_hover; ?>', '<?php echo $all_event->location_color; ?>', '<?php echo $all_event->location_hover; ?>', '<?php echo $page_id; ?>', '<?php echo $all_event->id; ?>')"
                        onmouseout="eventGridHoverOut('<?php echo $all_event->background_color; ?>', '<?php echo $all_event->background_hover; ?>', '<?php echo $all_event->title_color; ?>', '<?php echo $all_event->title_hover_color; ?>', '<?php echo $all_event->short_description_title_color; ?>', '<?php echo $all_event->short_description_title_hover_color; ?>', '<?php echo $all_event->short_description_color; ?>', '<?php echo $all_event->short_description_hover_color; ?>', '<?php echo $all_event->date_color; ?>', '<?php echo $all_event->date_hover; ?>', '<?php echo $all_event->location_color; ?>', '<?php echo $all_event->location_hover; ?>', '<?php echo $page_id; ?>', '<?php echo $all_event->id; ?>')"
                        <?php echo ($all_event->open_new_tab == 1) ? 'target="_blank"': ''; ?>>
                        <?php if(!empty($images)): ?>

                        <div class=" event-imag-slide">

                            <?php
                                                foreach($images as $image):

                                                    $image_properties = array(
                                                        'src' => $image_url . $image,
                                                        'alt' => $all_event->image_alt,
                                                        'title' => $all_event->image_title
                                                    );

                                                    echo img($image_properties);

                                                endforeach;
                                                ?>

                        </div>

                        <?php endif; ?>

                        <div class="event-details">

                            <?php
                                            echo heading(
                                                $all_event->title,
                                                3,
                                                array(
                                                    'class' =>'h5-head' .$all_event->title_color.' '.$all_event->title_position,
													'id' => 'even_grid_title_'.$page_id.$all_event->id
                                                )
                                            );
                                            ?>

                            <ul class="event-date-detail">
                                <?php if($all_event->date != ''): ?>
                                <li id="event_date_<?php echo $page_id.$all_event->id; ?>"
                                    class="<?php echo $all_event->date_color; ?>">
                                    <i class="far fa-calendar-alt"></i>&nbsp; <?php echo $all_event->date; ?>
                                </li>
                                <?php endif; ?>
                                <?php if($all_event->location != ''): ?>
                                <li id="event_location_<?php echo $page_id.$all_event->id; ?>"
                                    class="<?php echo $all_event->location_color; ?>">
                                    <i class="fas fa-map-marker-alt"></i>&nbsp; <?php echo $all_event->location; ?>
                                </li>
                                <?php endif; ?>
                            </ul>

                            <?php
                                            $heading_attributes = array(
                                                'class = "'.$all_event->short_description_title_color.' '.$all_event->short_description_title_position.'"',
                                                'id = short_desc_title_'.$page_id.$all_event->id
                                            );

                                            $heading_attribute = $this->setting->text_head_attributes($heading_attributes, $all_event->short_description);

                                            $text_attributes = array(
                                                'class = "'.$all_event->short_description_color.' '.$all_event->short_description_position.'"',
                                                'id = short_desc_text_'.$page_id.$all_event->id
                                            );

                                            echo $this->setting->text_attributes($text_attributes, $heading_attribute);
                                            ?>

                        </div>
                    </a>
                </div>

                <?php
                            endforeach;
                            ?>

            </div>

        </div>

        <?php
					$i = 1;
					foreach($event_categories as $event_category):

						$events_by_categories = $this->Event_model->get_event_by_category_id($website_id, $event_category->id);
						?>
        <div id="event_tab<?php echo $i; ?>" class="col s12">

            <?php if(!empty($events_by_categories)): ?>

            <div id="event_masonry" class="row">

                <?php

									foreach($events_by_categories as $events_by_category):

										$images = ($events_by_category->image != '') ? explode(',', $events_by_category->image): array();
										?>

                <div class=" events-img-details col s12 m6 <?php echo $event_pages[0]->event_per_row; ?>" data-aos="fade-up">
                    <a href="<?php echo base_url(); ?>event/<?php echo $events_by_category->event_url; ?>"
                        class="event-grid-list <?php echo $events_by_category->background_color; ?>"
                        id="event_grid_<?php echo $page_id.$events_by_category->id; ?>"
                        onmouseover="eventGridHover('<?php echo $events_by_category->background_color; ?>', '<?php echo $events_by_category->background_hover; ?>', '<?php echo $events_by_category->title_color; ?>', '<?php echo $events_by_category->title_hover_color; ?>', '<?php echo $events_by_category->short_description_title_color; ?>', '<?php echo $events_by_category->short_description_title_hover_color; ?>', '<?php echo $events_by_category->short_description_color; ?>', '<?php echo $events_by_category->short_description_hover_color; ?>', '<?php echo $events_by_category->date_color; ?>', '<?php echo $events_by_category->date_hover; ?>', '<?php echo $events_by_category->location_color; ?>', '<?php echo $events_by_category->location_hover; ?>', '<?php echo $page_id; ?>', '<?php echo $events_by_category->id; ?>')"
                        onmouseout="eventGridHoverOut('<?php echo $events_by_category->background_color; ?>', '<?php echo $events_by_category->background_hover; ?>', '<?php echo $events_by_category->title_color; ?>', '<?php echo $events_by_category->title_hover_color; ?>', '<?php echo $events_by_category->short_description_title_color; ?>', '<?php echo $events_by_category->short_description_title_hover_color; ?>', '<?php echo $events_by_category->short_description_color; ?>', '<?php echo $events_by_category->short_description_hover_color; ?>', '<?php echo $events_by_category->date_color; ?>', '<?php echo $events_by_category->date_hover; ?>', '<?php echo $events_by_category->location_color; ?>', '<?php echo $events_by_category->location_hover; ?>', '<?php echo $page_id; ?>', '<?php echo $events_by_category->id; ?>')"
                        <?php echo ($events_by_category->open_new_tab == 1) ? 'target="_blank"': ''; ?>>
                        <?php if(!empty($images)): ?>

                        <div class=" event-imag-slide">

                            <?php
                                                        foreach($images as $image):

                                                            $image_properties = array(
                                                                'src' => $image_url . $image,
                                                                'alt' => $events_by_category->image_alt,
                                                                'title' => $events_by_category->image_title
                                                            );

                                                            echo img($image_properties);

                                                        endforeach;
                                                        ?>

                        </div>

                        <?php endif; ?>

                        <div class="event-details">

                            <?php
                                                    echo heading(
                                                        $events_by_category->title,
                                                        3,
                                                        array(
                                                            'class' =>'h5-head'. $events_by_category->title_color.' '.$events_by_category->title_position,
															'id' => 'even_grid_title_'.$page_id.$events_by_category->id
                                                        )
                                                    );
                                                    ?>

                            <ul class="event-date-detail">
                                <?php if($events_by_category->date != ''): ?>
                                <li id="event_date_<?php echo $page_id.$events_by_category->id; ?>"
                                    class="<?php echo $events_by_category->date_color; ?>">
                                    <i class="far fa-calendar-alt"></i>&nbsp; <?php echo $events_by_category->date; ?>
                                </li>
                                <?php endif; ?>
                                <?php if($events_by_category->location != ''): ?>
                                <li id="event_location_<?php echo $page_id.$events_by_category->id; ?>"
                                    class="<?php echo $events_by_category->location_color; ?>">
                                    <i class="fas fa-map-marker-alt"></i>&nbsp;
                                    <?php echo $events_by_category->location; ?>
                                </li>
                                <?php endif; ?>
                            </ul>

                            <?php
                                                    $heading_attributes = array(
                                                        'class = "'.$events_by_category->short_description_title_color.' '.$events_by_category->short_description_title_position.'"',
                                                        'id = short_desc_title_'.$page_id.$events_by_category->id
                                                    );

                                                    $heading_attribute = $this->setting->text_head_attributes($heading_attributes, $events_by_category->short_description);

                                                    $text_attributes = array(
                                                        'class = "'.$events_by_category->short_description_color.' '.$events_by_category->short_description_position.'"',
                                                        'id = short_desc_text_'.$page_id.$events_by_category->id
                                                    );

                                                    echo $this->setting->text_attributes($text_attributes, $heading_attribute);
                                                    ?>

                        </div>

                    </a>
                </div>

                <?php
									endforeach;
									?>

            </div>

            <?php endif; ?>

        </div>
        <?php
						$i++;

					endforeach;
					?>

        <?php endif; ?>

    </div>
                </div>
</section>
<?php

	endif;

endif;
?>