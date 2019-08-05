
<section class="bg-img-common <?php echo $bg_color;?>" <?php if ($bg_image != "") : ?>
    style="background-image:url('<?php echo $bg_image;?>')" <?php endif;?>>
<!-- <div class="textfull-section-overlay"></div> -->
    <div class="container">
		<div class="common-space">
        <div class="text-full-width">
			
            
				<?php 
					if (!empty($title)) :
						// H1 Tag
						echo heading($title, 4, array(
							'class' => 'h1-head ' . $title_position.' '.$title_color,
							'data-aos' => 'flip-down'
						));
					endif;	

				//Apply Text heading customized options
				$heading_array = array('<h1>', '<h2>', '<h3>', '<h4>', '<h5>', '<h6>');

				$replace_heading = array(
					'<h1 class="'.$content_title_color.' '.$content_title_position.'">',
					'<h2 class="'.$content_title_color.' '.$content_title_position.'" >',
					'<h3 class="'.$content_title_color.' '.$content_title_position.'" >',
					'<h4 class="'.$content_title_color.' '.$content_title_position.'" >',
					'<h5 class="'.$content_title_color.' '.$content_title_position.'" >',
					'<h6 class="'.$content_title_color.' '.$content_title_position.'" >'
				);

				// replace heading options in text
				$text = str_replace($heading_array, $replace_heading, $full_text);
			?>
            <div class="text-full-width-content <?php echo $content_position.' '.$content_color;?>" data-aos="fade-right">
                <?php echo $text; ?>
            </div>
        </div>
	</div>
	</div>
</section>