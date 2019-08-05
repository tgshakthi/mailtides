<?php
/**
 * Newsletter
 * Created at : 29-10-2018
 * Author : Karthika
 * 
 * Modified Date : 01-March-2019
 * Modified By : Saravana
 */
?>
<section class="newsletter-contact-form common-space <?php echo $bg_color;?>" <?php if ($bg_image != "") : ?>
    style="background-image:url('<?php echo $bg_image;?>')" <?php endif;?>>
    <div class="container" data-aos="fade-up">
        <div class="news-letter-container">
            <?php
				echo heading(
					$newsletter_title,
					'3',
					array(
						'class' => 'newsletter-title h1-head '. $newsletter_title_color.' '.$newsletter_title_position
					)
				);
			?>

            <div class="newsletter-section <?php echo $newsletter_content_color.' '.$newsletter_content_position;?>">
                <?php echo $newsletter_content;?>
            </div>

            <?php echo form_open('newsletter/insert', 'id="newsletter-form" autocomplete="off"'); ?>
            <?php echo form_input(array('type' => 'hidden', 'name' => 'page-url', 'value' => $page_url ));?>
            <?php
				$list = array(
					form_input(array('name' => 'newsletter-name','class' =>'' . $label_color, 'placeholder' => 'Name', 'required' => 'required')),
					form_input(array('type' => 'email', 'name' => 'newsletter-email', 'class' =>'' . $label_color, 'placeholder' => 'Email', 'required' => 'required')),
					form_button(array  ('type' => 'submit', 'name' => 'newsletter-submit', 'class' => '' . $btn_background_color .' '. $label_color .' '. $button_type, 'content' => 'Submit <i class="fab fa-telegram-plane"></i>')			
					) 
				);

				echo ul($list, array('class' => 'newsletter-quick z-depth-2'));
			?>
            <?php echo form_close();?>

        </div>
    </div>
</section>