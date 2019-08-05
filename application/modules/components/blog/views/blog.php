<?php
if(!empty($blogs) && !empty($blog_pages)):

	if($blog_pages[0]->blog != '' && $blog_pages[0]->blog != 'none'):

		?>
<section class="bg-img-common <?php echo $bg_color;?>" <?php if ($bg_image != "") : ?>
    style="background-image:url('<?php echo $bg_image;?>')" <?php endif;?>>
    <div class="container" data-aos="zoom-in">
        <div class="common-space">
            <div class="blog_title">
                <?php
                    echo heading(
                        $blog_pages[0]->title,
                        4,
                        array(
                            'class' =>'h1-head '. $blog_pages[0]->title_color.' '.$blog_pages[0]->title_position
                        )
                    );
                    ?>
            </div>

            <?php if($blog_pages[0]->blog == 'blog'): ?>

            <div id="blog-masonry" class="row blog-card-height">

                <?php
                        foreach($blogs as $blog):

                            $images = ($blog->image != '') ? explode(',', $blog->image): array();
                            ?>
                <a href="<?php echo base_url(); ?>blog/<?php echo $blog->blog_url; ?>"
                    <?php echo ($blog->open_new_tab == 1) ? 'target="_blank"': ''; ?>
                    class="col s12 m6 <?php echo $blog_pages[0]->blog_per_row; ?> blog-masonry-grid">
                    <div class="blog-grid-border">

                        <?php if(!empty($images)): ?>

                        <div class="blog-image-slide">
                            <div id="medum-content">
                                <div id="slider1" class="jSlider " data-delay="0">

                                    <?php
                                                    foreach($images as $image):

                                                        $image_properties = array(
                                                            'src' => $image_url . $image,
                                                            'alt' => $blog->image_alt,
                                                            'title' => $blog->image_title
                                                        );
                                                        ?>
                                    <div class="card-height"><?php echo img($image_properties); ?></div>

                                    <?php endforeach; ?>

                                </div>
                            </div>
                        </div>

                        <?php endif; ?>

                        <div id="blog_short_desc_<?php echo $page_id.$blog->id; ?>"
                            class="blog-details <?php echo $blog->background_color; ?>"
                            onmouseover="blogShortDescBgHover('<?php echo $blog->background_color; ?>', '<?php echo $blog->short_description_background_hover_color; ?>', '<?php echo $page_id; ?>', '<?php echo $blog->id; ?>')"
                            onmouseout="blogShortDescBgHoverOut('<?php echo $blog->background_color; ?>', '<?php echo $blog->short_description_background_hover_color; ?>', '<?php echo $page_id; ?>', '<?php echo $blog->id; ?>')">


                            <?php
                                        echo heading(
                                            $blog->title,
                                            3,
                                            array(
                                                'class' =>'h3-head ' . $blog->title_color.' '.$blog->title_position
                                            )
                                        );
                                        ?>
                            <?php
                                        $heading_attributes = array(
                                            'class = "'.$blog->short_description_title_color.' '.$blog->short_description_title_position.'"',
                                            'id = short_desc_title_'.$page_id.$blog->id,
                                            'onmouseover = "blogShortDescTitleHover(\''.$blog->short_description_title_color.'\', \''.$blog->short_description_title_hover_color.'\', '.$page_id.', '.$blog->id.')"',
                                            'onmouseout = "blogShortDescTitleHoverOut(\''.$blog->short_description_title_color.'\', \''.$blog->short_description_title_hover_color.'\', '.$page_id.', '.$blog->id.')"'
                                        );

                                        $heading_attribute = $this->setting->text_head_attributes($heading_attributes, $blog->short_description);

                                        $text_attributes = array(
                                            'class = "'.$blog->short_description_color.' '.$blog->short_description_position.'"',
                                            'id = short_desc_text_'.$page_id.$blog->id,
                                            'onmouseover = "blogShortDescTextHover(\''.$blog->short_description_color.'\', \''.$blog->short_description_hover_color.'\', '.$page_id.', '.$blog->id.')"',
                                            'onmouseout = "blogShortDescTextHoverOut(\''.$blog->short_description_color.'\', \''.$blog->short_description_hover_color.'\', '.$page_id.', '.$blog->id.')"'
                                        );

                                        echo $this->setting->text_attributes($text_attributes, $heading_attribute);
                                        ?>
                            <!-- <hr class="blog-hr-tag">
                            <div class="blog-by-date">
                                <span class="blog-ic"><i class="fab fa-blogger"></i></span>
                                <span class="blog-date <?php echo $blog->date_color; ?>">by <strong
                                        class="<?php echo $blog->date_color; ?>"><?php echo $blog->created_by; ?></strong>
                                    | <?php echo $blog->date; ?></span>
                            </div> -->
                        </div>
                    </div>
                </a>

                <?php endforeach; ?>
            </div>

            <?php elseif(!empty($blog_categories) && $blog_pages[0]->blog == 'blog_category'): ?>

            <ul id="blog-tabs" class="tabs blog-grid-tab">

                <li class="tab col s3"><a href="#blog_tab0" class="active">All</a></li>
                <?php
						$c = 1;
						foreach($blog_categories as $blog_category):

							?>
                <li class="tab col s3"><a href="#blog_tab<?php echo $c; ?>"
                        class=""><?php echo $blog_category->name; ?></a>
                </li>
                <?php
							$c++;

						endforeach;
						?>

            </ul>

            <div id="blog_tab0" class="col s12">

                <div id="blog-masonry" class="row blog-card-height">

                    <?php
                            foreach($all_blogs as $blog):

                                $images = ($blog->image != '') ? explode(',', $blog->image): array();
                                ?>
                    <a href="<?php echo base_url(); ?>blog/<?php echo $blog->blog_url; ?>"
                        <?php echo ($blog->open_new_tab == 1) ? 'target="_blank"': ''; ?>
                        class="col s12 m6 <?php echo $blog_pages[0]->blog_per_row; ?> blog-masonry-grid">
                        <div class="blog-grid-border">

                            <?php if(!empty($images)): ?>

                            <div class="blog-image-slide">
                                <div id="medum-content">
                                    <div id="slider1" class="jSlider" data-delay="0">

                                        <?php
                                                        foreach($images as $image):

                                                            $image_properties = array(
                                                                'src' => $image_url . $image,
                                                                'alt' => $blog->image_alt,
                                                                'title' => $blog->image_title
                                                            );
                                                            ?>
                                        <div class="card-height"><?php echo img($image_properties); ?></div>

                                        <?php endforeach; ?>

                                    </div>
                                </div>
                            </div>

                            <?php endif; ?>

                            <div id="blog_short_desc_<?php echo $page_id.$blog->id; ?>"
                                class="blog-details <?php echo $blog->background_color; ?>"
                                onmouseover="blogShortDescBgHover('<?php echo $blog->background_color; ?>', '<?php echo $blog->short_description_background_hover_color; ?>', '<?php echo $page_id; ?>', '<?php echo $blog->id; ?>')"
                                onmouseout="blogShortDescBgHoverOut('<?php echo $blog->background_color; ?>', '<?php echo $blog->short_description_background_hover_color; ?>', '<?php echo $page_id; ?>', '<?php echo $blog->id; ?>')">
                                <?php
                                            echo heading(
                                                $blog->title,
                                                3,
                                                array(
                                                    'class' =>'h3-head ' . $blog->title_color.' '.$blog->title_position
                                                )
                                            );
                                            ?>

                                <?php
                                            $heading_attributes = array(
                                                'class = "'.$blog->short_description_title_color.' '.$blog->short_description_title_position.'"',
                                                'id = short_desc_title_'.$page_id.$blog->id,
                                                'onmouseover = "blogShortDescTitleHover(\''.$blog->short_description_title_color.'\', \''.$blog->short_description_title_hover_color.'\', '.$page_id.', '.$blog->id.')"',
                                                'onmouseout = "blogShortDescTitleHoverOut(\''.$blog->short_description_title_color.'\', \''.$blog->short_description_title_hover_color.'\', '.$page_id.', '.$blog->id.')"'
                                            );

                                            $heading_attribute = $this->setting->text_head_attributes($heading_attributes, $blog->short_description);

                                            $text_attributes = array(
                                                'class = "'.$blog->short_description_color.' '.$blog->short_description_position.'"',
                                                'id = short_desc_text_'.$page_id.$blog->id,
                                                'onmouseover = "blogShortDescTextHover(\''.$blog->short_description_color.'\', \''.$blog->short_description_hover_color.'\', '.$page_id.', '.$blog->id.')"',
                                                'onmouseout = "blogShortDescTextHoverOut(\''.$blog->short_description_color.'\', \''.$blog->short_description_hover_color.'\', '.$page_id.', '.$blog->id.')"'
                                            );

                                            echo $this->setting->text_attributes($text_attributes, $heading_attribute);
                                            ?>
                                <hr class="blog-hr-tag">
                                <div class="blog-by-date">
                                    <span class="blog-ic"><i class="fab fa-blogger"></i></span>
                                    <span class="blog-date <?php echo $blog->date_color; ?>">by <strong
                                            class="<?php echo $blog->date_color; ?>"><?php echo $blog->created_by; ?></strong>
                                        | <?php echo $blog->date; ?></span>
                                </div>
                            </div>
                        </div>
                    </a>

                    <?php endforeach; ?>
                </div>

            </div>

            <?php
					$i = 1;
					foreach($blog_categories as $blog_category):

						$blogs_by_categories = $this->Blog_model->get_blog_by_category_id($website_id, $blog_category->id);
						?>
            <div id="blog_tab<?php echo $i; ?>" class="col s12">

                <?php if(!empty($blogs_by_categories)): ?>

                <div id="blog-masonry" class="row">

                    <?php

									foreach($blogs_by_categories as $blogs_by_category):

										$images = ($blogs_by_category->image != '') ? explode(',', $blogs_by_category->image): array();
										?>
                    <a href="<?php echo base_url(); ?>blog/<?php echo $blogs_by_category->blog_url; ?>"
                        class="col <?php echo $blog_pages[0]->blog_per_row; ?>"
                        <?php echo ($blogs_by_category->open_new_tab == 1) ? 'target="_blank"': ''; ?>
                        class="blog-masonry-grid">
                        <div class="blog-grid-border">

                            <?php if(!empty($images)): ?>

                            <div class="blog-image-slide">
                                <div id="medum-content">
                                    <div id="slider1" class="jSlider" data-delay="0">

                                        <?php
																foreach($images as $image):

																	$image_properties = array(
																		'src' => $image_url . $image,
																		'alt' => $blogs_by_category->image_alt,
																		'title' => $blogs_by_category->image_title
																	);
																	?>
                                        <div class="card-height"><?php echo img($image_properties); ?></div>

                                        <?php endforeach; ?>

                                    </div>
                                </div>
                            </div>

                            <?php endif; ?>

                            <div id="blog_short_desc_<?php echo $page_id.$blogs_by_category->id; ?>"
                                class="blog-details <?php echo $blogs_by_category->background_color; ?>"
                                onmouseover="blogShortDescBgHover('<?php echo $blogs_by_category->background_color; ?>', '<?php echo $blogs_by_category->short_description_background_hover_color; ?>', '<?php echo $page_id; ?>', '<?php echo $blogs_by_category->id; ?>')"
                                onmouseout="blogShortDescBgHoverOut('<?php echo $blogs_by_category->background_color; ?>', '<?php echo $blogs_by_category->short_description_background_hover_color; ?>', '<?php echo $page_id; ?>', '<?php echo $blogs_by_category->id; ?>')">
                                <?php
													echo heading(
														$blogs_by_category->title,
														3,
														array(
															'class' =>'h3-head ' . $blogs_by_category->title_color.' '.$blogs_by_category->title_position
														)
													);
													?>

                                <?php
													$heading_attributes = array(
														'class = "'.$blogs_by_category->short_description_title_color.' '.$blogs_by_category->short_description_title_position.'"',
														'id = short_desc_title_'.$page_id.$blogs_by_category->id,
														'onmouseover = "blogShortDescTitleHover(\''.$blogs_by_category->short_description_title_color.'\', \''.$blogs_by_category->short_description_title_hover_color.'\', '.$page_id.', '.$blogs_by_category->id.')"',
														'onmouseout = "blogShortDescTitleHoverOut(\''.$blogs_by_category->short_description_title_color.'\', \''.$blogs_by_category->short_description_title_hover_color.'\', '.$page_id.', '.$blogs_by_category->id.')"'
													);

													$heading_attribute = $this->setting->text_head_attributes($heading_attributes, $blogs_by_category->short_description);

													$text_attributes = array(
														'class = "'.$blogs_by_category->short_description_color.' '.$blogs_by_category->short_description_position.'"',
														'id = short_desc_text_'.$page_id.$blogs_by_category->id,
														'onmouseover = "blogShortDescTextHover(\''.$blogs_by_category->short_description_color.'\', \''.$blogs_by_category->short_description_hover_color.'\', '.$page_id.', '.$blogs_by_category->id.')"',
														'onmouseout = "blogShortDescTextHoverOut(\''.$blogs_by_category->short_description_color.'\', \''.$blogs_by_category->short_description_hover_color.'\', '.$page_id.', '.$blogs_by_category->id.')"'
													);

													echo $this->setting->text_attributes($text_attributes, $heading_attribute);
                                                    ?>
                                <hr class="blog-hr-tag">
                                <div class="blog-by-date">
                                    <span class="blog-ic"><i class="fab fa-blogger"></i></span>
                                    <span class="blog-date <?php echo $blog->date_color; ?>">by <strong
                                            class="<?php echo $blog->date_color; ?>"><?php echo $blog->created_by; ?></strong>
                                        | <?php echo $blog->date; ?></span>
                                </div>
                            </div>
                        </div>
                    </a>
                    <?php

									endforeach;
									?>
                </div>

                <?php endif; ?>

            </div>
            <?php
						$i++;

					endforeach;

				endif;
				?>

        </div>
    </div>
</section>
<?php

	endif;

endif;
?>