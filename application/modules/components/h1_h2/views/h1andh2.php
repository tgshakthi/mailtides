<section class="section <?php echo $background_color;?>">
    <div class="container">
        <div class="row">
            <div class="">
                <?php
                    if (!empty($h1_tag)) :
                        // H1 Tag
                        echo heading($h1_tag, 1, array(
                            'class' => 'h1-head '.$h1_title_position.' '.$h1_title_color,
                            'data-aos' => 'flip-down'
                        ));
                    endif;

                    if (!empty($h2_tag)) :
                        //H2 Tag
                        echo heading($h2_tag, 2, array(
                            'class' => 'h2-head '.$h2_title_position.' '.$h2_title_color,
                            'data-aos' => 'flip-down'
                        ));
                    endif;
				?>
            </div>
        </div>
    </div>
</section>

<!-- <section class="bg-img-common common-space grey">
    <div class="container">
        <h4 class="h1-head center dark-marroon-text">Video Gallery</h4>

        <div class="row">

            <div class="col s12 m6 l4 xl4">
                <div class="video-component">
                    <iframe width="100%" height="230px" src="//www.youtube.com/embed/YE7VzlLtp-4" frameborder="0"
                        allowfullscreen></iframe>
                </div>

                <div class="video-content">
                    <p class="center white-text">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nobis, vitae.
                    </p>
                </div>
            </div>

            <div class="col s12 m6 l4 xl4">
                <div class="video-component">
                    <iframe width="100%" height="230px" src="//www.youtube.com/embed/YE7VzlLtp-4" frameborder="0"
                        allowfullscreen></iframe>
                </div>

                <div class="video-content">
                    <p class="center white-text">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nobis, vitae.
                    </p>
                </div>
            </div>

            <div class="col s12 m6 l4 xl4">
                <div class="video-component">
                    <iframe width="100%" height="230px" src="//www.youtube.com/embed/YE7VzlLtp-4" frameborder="0"
                        allowfullscreen></iframe>
                </div>

                <div class="video-content">
                    <p class="center white-text">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nobis, vitae.
                    </p>
                </div>
            </div>

            <div class="col s12 m12 l12 xl12 center">
                <a href="#" class="video-btn dark-marroon white-text">View More videos</a>
            </div>

        </div>

    </div>
</section> -->