<section class="bg-img-common <?php echo $bg_color;?>" <?php if ($bg_image != "") : ?>
    style="background-image:url('<?php echo $bg_image;?>')" <?php endif;?>>
    <div class="common-space">
        <div class="container">
            <div class="row">
                <div class="introduction">

                    <div data-aos="flip-down">
                        <?php
						// H1 Tag
						echo heading($title, 1, array(
							'class' => $title_position.' '.$title_color .' h1-head'
						));
					?>
                    </div>

                    <div data-aos="fade-right">
                        <div class="introducation-head <?php echo $content_position.' '.$content_color;?>">
                            <?php echo $text; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>