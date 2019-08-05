<?php
if(!empty($text_image_full_width)):
  foreach ($text_image_full_width as $text_image) :

    // Background
    if (!empty($text_image->background)) :
        $text_image_full_width_bg = json_decode($text_image->background);
        if (!empty($text_image_full_width_bg->component_background) && $text_image_full_width_bg->component_background == 'image') :
            $bg_image = $text_image_full_width_bg->text_image_full_width_background;
            $bg_color = "";
        elseif (!empty($text_image_full_width_bg->component_background) && $text_image_full_width_bg->component_background == 'color') :
            $bg_color = $text_image_full_width_bg->text_image_full_width_background;
            $bg_image = "";
        else :
            $bg_color = '';
            $bg_image = '';
        endif;
    else :
        $bg_color = '';
        $bg_image = '';
    endif;
?>
<section class="negative-space bg-img-common <?php echo $bg_color;?>" <?php if($bg_image != ""): ?>
    style="background-image:url('<?php echo base_url() . $image_url . $bg_image;?>')" <?php endif;?>>

    <?php
                $read_more = '';
                $new_tab = array();
                
                if ($text_image->readmore_btn == 1) :

                    	// Check Open new tab is enabled
					if ($text_image->open_new_tab == 1) :
						$new_tab = array(
							'target' => '_blank'
						);
                    endif;
                    
                    	// Read more btn attributes
					$class = array(
						'class' => 'waves-effect waves-light ' . $text_image->button_type . ' '. $text_image->btn_background_color . ' ' . $text_image->label_color,
						'id' => 'text_image_hover_' . $text_image->id . $text_image->page_id,
						'onmouseover' => 'text_image_full_width_read_more_hover(\'' . $text_image->btn_background_color . '\', \'' . $text_image->label_color . '\', \'' . $text_image->background_hover . '\', \'' . $text_image->text_hover . '\', ' . $text_image->id . ', ' . $text_image->page_id . ')',
						'onmouseout' => 'text_image_full_width_read_more_hoverout(\'' . $text_image->btn_background_color . '\', \'' . $text_image->label_color . '\', \'' . $text_image->background_hover . '\', \'' . $text_image->text_hover . '\', ' . $text_image->id . ', ' . $text_image->page_id . ')'
                    );
                    
                    	// merge additional attributes
                    $text_image_attribute = array_merge($class, $new_tab);
                    
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
                        $text .= '...'. $read_more;                        
                    else:
                        $text = $text.' '.$read_more;    
                    endif;
                    
                    // if($image_position == 'left'):
                    //     $content_position = 'right';
                    // else:
                    //     $content_position = 'left';
                    // endif;


                 ?>
                 <div class="text-images-notbg">
        
        <div class="row">
      
                    <div class="col s12 m5 xs12 nt-image-position <?php echo $text_image->image_position ;?>" data-aos="fade-up"  data-aos-duration="2800">
    
                          <?php
                            // Image Tag
                            $image = array(
                                'class' => '',
                                'src' => $image_url . $text_image->image,
                                'alt' => $text_image->image_alt,
                                'title' => $text_image->image_title
                            );
                            echo img($image);

                            if ( (base_url() . $this->setting->page_url() == "http://txgidocs.desss-portfolio.com/guru.html") || (base_url() . $this->setting->page_url() == "http://txgidocs.desss-portfolio.com/howard.html") || (base_url() . $this->setting->page_url() == "http://txgidocs.desss-portfolio.com/prasun.html") || (base_url() . $this->setting->page_url() == "http://txgidocs.desss-portfolio.com/meron.html") ) :

                                echo '
                                <div class="doctors-schedule-btn center">
                                <a href="'. base_url() .'contact.html" class="btn black white-text">SCHEDULE APPOINTMENT</a>
                                </div>';

                            endif;
                        ?>
                    </div>
                        
                    <div class="col s12 m7 xs12 nt-content-part" data-aos="fade-up"  data-aos-duration="2800">
                    
                    <?php
					// H3 Tag
					echo heading(
						$text_image->title,
						4,
						array(
							'class' => $text_image->title_position. ' '.$text_image->title_color 
						)
					);
				?>

                    <div class="<?php echo $text_image->content_position.' '.$text_image->content_color;?>">
                        <?php echo $text; ?>             
                    </div>

                </div>

        </div>

</div>

  </section>  


<?php
endforeach;
endif;
?>
