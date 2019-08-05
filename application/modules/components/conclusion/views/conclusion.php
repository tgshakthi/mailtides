<section class="bg-img-common <?php echo $bg_color;?>" <?php if ($bg_image != "") : ?>
style="background-image:url('<?php echo $bg_image;?>')" <?php endif;?>>
	<div class="container">
		<div class="common-space">
		<div class="conclusion">
			<?php
				if (!empty($title)) :
					// H1 Tag
					echo heading($title, 1, array(
						'class' => 'h1-head ' . $title_position.' '.$title_color,
						'data-aos' => 'flip-down'
					));
				endif;
			?>
			<div class="<?php echo $content_position.' '.$content_color;?>" data-aos="fade-up">
				<?php echo $text; ?>
			</div>
		</div>
	</div>
	</div>
</section>

