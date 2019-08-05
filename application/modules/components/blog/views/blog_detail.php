<?php if(!empty($blog_id)): ?>

<section class="bg-img-common  <?php echo $background_color;?>" <?php if ($background_image != "") : ?>
    style="background-image:url('<?php echo base_url() . $image_url . $background_image;?>')" <?php endif;?>>
    <div class="container" data-aos="zoom-in">
        <div class="common-space">
            <div class="row">
                <div class="col s12 l12">
                    <div class="blog-detail-page">
                        <div class="blog-detail-image-content white">
                            <?php if($image != ''): ?>

                            <div id="medum-content">
                                <div id="slider1" class="jSlider blog-detail-page col s12 m6" data-delay="0">
                                    <?php
								$images = explode(',', $image);
								foreach($images as $image):

									$image_properties = array(
										'src' => $image_url . $image,
										'alt' => $image_alt,
										'title' => $image_title
									);
									?>
                                    <div class="blog-detail-topimg"><?php echo img($image_properties); ?></div>
                                    <?php

								endforeach;
								?>
                                </div>
                            </div>

                            <?php endif; ?>

                            <div class="single-blog-details">
                                <?php
						echo heading(
							$title,
							3,
							array(
								'class' =>'h1-head '. $title_color.' '.$title_position,
								'id'    => 'blog_detail_heading',
								'onmouseover' => "blogDetailHeadHover('".$title_color."', '".$title_hover_color."')",
								'onmouseout' => "blogDetailHeadHoverOut('".$title_color."', '".$title_hover_color."')"
							)
						);
						$list = array(
							anchor(
								$url,
								'<i class="fa fa-calendar"></i>&nbsp;'.$date,
								'class="'.$date_color.'"'
							),
							anchor(
								$url,
								'<i class="fa fa-user"></i>&nbsp;'.$created_by,
								'class="'.$date_color.'"'
							),
							anchor(
								$url.'#comments',
								'<i class="fa fa-commenting-o"></i>&nbsp; Comments',
								'class="'.$date_color.'"'
							)
						);

						$attributes = array(
							'class' => 'blog-date-details'
						);

						echo ul($list, $attributes);

						$heading_attributes = array(
							'class = "h3-head '.$description_title_color.' '.$description_title_position.'"',
							'id = "desc_title_'.$blog_id.'"',
							'onmouseover = "blogDescTitleHover(\''.$description_title_color.'\', \''.$description_title_hover_color.'\', '.$blog_id.')"',
							'onmouseout = "blogDescTitleHoverOut(\''.$description_title_color.'\', \''.$description_title_hover_color.'\', '.$blog_id.')"'
						);

						$heading_attribute = $this->setting->text_head_attributes($heading_attributes, $description);

						$text_attributes = array(
							'class = "'.$description_color.' '.$description_position.'"',
							'id = "desc_text_'.$blog_id.'"',
							'onmouseover = "blogDescTextHover(\''.$description_color.'\', \''.$description_hover_color.'\', '.$blog_id.')"',
							'onmouseout = "blogDescTextHoverOut(\''.$description_color.'\', \''.$description_hover_color.'\', '.$blog_id.')"'
						);
						?>
                                <div id="desc_text_<?php echo $blog_id; ?>"
                                    class="<?php echo $description_color.' '.$description_position; ?>"
                                    onmouseover="blogDescTextHover('<?php echo $description_color; ?>', '<?php echo $description_hover_color; ?>', <?php echo $blog_id; ?>)"
                                    onmouseout="blogDescTextHoverOut('<?php echo $description_color; ?>', '<?php echo $description_hover_color; ?>', <?php echo $blog_id; ?>)">
                                    <?php echo $heading_attribute; ?>
                                </div>
                                <?php

						heading(
							'Related post',
							3,
							array(
								'class' => 'blog-related-post'
							)
						);
						?>

                                <!--<div class="carousel blog-related-post-blog">
          					<a class="carousel-item" href="#one!"><img src="images/blogs-bg.jpg" alt="" title=""></a>
          					<a class="carousel-item" href="#two!"><img src="images/blogs-bg.jpg" alt="" title=""></a>
          					<a class="carousel-item" href="#three!"><img src="images/blogs-bg.jpg" alt="" title=""></a>
          					<a class="carousel-item" href="#four!"><img src="images/blogs-bg.jpg" alt="" title=""></a>
          					<a class="carousel-item" href="#five!"><img src="images/blogs-bg.jpg" alt="" title=""></a>
        				</div>-->
                            </div>

                            <div id="comments" class="comment_reply">
                                <div class="blog-post-comment">
                                    <?php
							echo heading(
								$rating_form_title,
								3,
								array(
									'class' => $rating_form_title_color.' '.$rating_form_title_position,
									'id'	=> 'rating_form_title',
									'onmouseover' => "blogRatingTitleHover('".$rating_form_title_color."', '".$rating_form_title_hover."')",
									'onmouseout' => "blogRatingTitleHoverOut('".$rating_form_title_color."', '".$rating_form_title_hover."')",
								)
							);
							?>
                                    <a href="javascript:void(0);"
                                        class="right"><?php echo (count($blog_ratings) == 0 ? '': (count($blog_ratings) == '1' ? '1 Comment': (count($blog_ratings) > '1' ? count($blog_ratings).' Comments': ''))); ?>
                                    </a>
                                    <input type="hidden" id="count_comments"
                                        value="<?php echo count($blog_ratings); ?>" />
                                </div>

                                <?php
						if(!empty($blog_ratings)):

							$i = 1;
							foreach($blog_ratings as $blog_rating):

								?>
                                <div class="post-blog-comment">
                                    <div class="blog-post-user-comment left">
                                        <a href="javascript:void(0)" onclick="post_reply(<?php echo $i; ?>)"
                                            class="blog-post-reply"><i class="fas fa-reply"></i> Reply</a>
                                        <?php
										echo heading(
											$blog_rating->name,
											3,
											'class="'.$comment_name_color.'"'
										);
										$checked10 = ($blog_rating->rating == 5) ? "checked": "disabled";
										$checked9 = ($blog_rating->rating == 4.5) ? "checked": "disabled";
										$checked8 = ($blog_rating->rating == 4) ? "checked": "disabled";
										$checked7 = ($blog_rating->rating == 3.5) ? "checked": "disabled";
										$checked6 = ($blog_rating->rating == 3) ? "checked": "disabled";
										$checked5 = ($blog_rating->rating == 2.5) ? "checked": "disabled";
										$checked4 = ($blog_rating->rating == 2) ? "checked": "disabled";
										$checked3 = ($blog_rating->rating == 1.5) ? "checked": "disabled";
										$checked2 = ($blog_rating->rating == 1) ? "checked": "disabled";
										$checked1 = ($blog_rating->rating == 0.5) ? "checked": "disabled";

										echo '<span><div class="viewrating">
													<input type="radio" '.$checked10.'/>
													<label class="full"></label>
													<input type="radio" '.$checked9.'/>
													<label class="half"></label>
													<input type="radio" '.$checked8.'/>
													<label class="full"></label>
													<input type="radio" '.$checked7.'/>
													<label class="half"></label>
													<input type="radio" '.$checked6.'/>
													<label class="full"></label>
													<input type="radio" '.$checked5.'/>
													<label class="half"></label>
													<input type="radio" '.$checked4.'/>
													<label class="full"></label>
													<input type="radio" '.$checked3.'/>
													<label class="half"></label>
													<input type="radio" '.$checked2.'/>
													<label class="full"></label>
													<input type="radio" '.$checked1.'/>
													<label class="half"></label>
												</div></span>';

										$date = DateTime::createFromFormat('m-d-Y', $blog_rating->created_at);
										?>
                                        <span>Posted at
                                            <?php echo date("F d, Y", strtotime($date->format('d-m-Y'))); ?></span>
                                        <div class="<?php echo $comment_text_color; ?>">
                                            <?php echo $blog_rating->comment; ?></div>
                                    </div>
                                    <?php
									$blog_reply_ratings = $this->Blog_model->get_blog_reply($website_id, $blog_id, $blog_rating->id);
									if(!empty($blog_reply_ratings)):

										foreach($blog_reply_ratings as $blog_reply_rating):

											?>
                                    <div class="blog-post-user-comment right">
                                        <a href="javascript:void(0)" onclick="post_reply(<?php echo $i; ?>)"
                                            class="blog-post-reply"><i class="fas fa-reply"></i> Reply</a>
                                        <?php
                                                echo heading(
                                                    $blog_reply_rating->name,
                                                    3,
													'class="'.$comment_name_color.'"'
                                                );
                                                $date = DateTime::createFromFormat('m-d-Y', $blog_reply_rating->created_at);
                                                ?>
                                        <span>Posted at
                                            <?php echo date("F d, Y", strtotime($date->format('d-m-Y'))); ?></span>
                                        <div class="<?php echo $comment_text_color; ?>">
                                            <?php echo $blog_reply_rating->comment; ?>
                                        </div>
                                    </div>
                                    <?php

										endforeach;

									endif;

									// Form Tag
									echo form_open_multipart(
										'',
										'class="blog-user-reply white" id="reply_form_'.$i.'"'
									);
									?>
                                    <ul class="row blog-post-comment-form ">

                                        <?php
											// Input tag Hidden
											echo form_input(array(
												'type'  => 'hidden',
												'name'  => 'blog_id',
												'value' => $blog_id
											));
											// Input tag Hidden
											echo form_input(array(
												'type'  => 'hidden',
												'name'  => 'website_id',
												'value' => $website_id
											));
											// Input tag Hidden
											echo form_input(array(
												'type'  => 'hidden',
												'name'  => 'parent_id',
												'value' => $blog_rating->id
											));
											// Input tag Hidden
											echo form_input(array(
												'type'  => 'hidden',
												'name'  => 'url',
												'value' => base_url().$url
											));
											// Input tag Hidden
											echo form_input(array(
												'type'  => 'hidden',
												'name'  => 'rating',
												'value' => 'reply for '.$blog_rating->name
											));

											// Input tag Hidden
											echo form_input(array(
												'type'  => 'hidden',
												'name'  => 'rating_name',
												'value' => $blog_rating->name
											));
											// Input tag Hidden
											echo form_input(array(
												'type'  => 'hidden',
												'name'  => 'rating_email',
												'value' => $blog_rating->email
											));
											?>

                                        <li class="col s12 l12 blog-textarea">
                                            <div class="input-field ">
                                                <?php
													// Textarea
													echo form_textarea(array(
														'name' 	 => 'comment',
														'id'   	   => 'comment',
														'class' 	=> 'materialize-textarea',
														'required' => 'required'
													));

													// Label
													// echo form_label(
													// 	'Comment',
													// 	'comment',
													// 	'class="'.$label_color.'" id="rating_form_label_comment'.$blog_id.'" onmouseover="blogRatingFormLabel(\''.$label_color.'\', \''.$label_hover.'\', \'comment\', \''.$blog_id.'\')" onmouseout="blogRatingFormLabelOut(\''.$label_color.'\', \''.$label_hover.'\', \'comment\', \''.$blog_id.'\')"'
													// );
													?>
                                            </div>
                                        </li>

                                        <li class="col s12 l6">
                                            <div class="input-field">
                                                <?php
													// Input tag
													echo form_input(array(
														'id'       => 'name',
														'name'     => 'name',
														'required' => 'required',
														'class'    => 'validate',
														'value'    => '',
														'placeholder' => 'Name'
													));

													// Label
													// echo form_label(
													// 	'Name',
													// 	'name',
													// 	'class="'.$label_color.'" id="rating_form_label_name'.$blog_id.'" onmouseover="blogRatingFormLabel(\''.$label_color.'\', \''.$label_hover.'\', \'name\', \''.$blog_id.'\')" onmouseout="blogRatingFormLabelOut(\''.$label_color.'\', \''.$label_hover.'\', \'name\', \''.$blog_id.'\')"'
													// );
													?>
                                            </div>
                                        </li>

                                        <li class="col s12 l6">
                                            <div class="input-field">
                                                <?php
													// Input tag
													echo form_input(array(
														'id'       => 'email',
														'name'     => 'email',
														'required' => 'required',
														'class'    => 'validate',
														'value'    => '',
														'placeholder' => 'Email'
													));

													// Label
													// echo form_label(
													// 	'Email',
													// 	'email',
													// 	'class="'.$label_color.'" id="rating_form_label_email'.$blog_id.'" onmouseover="blogRatingFormLabel(\''.$label_color.'\', \''.$label_hover.'\', \'email\', \''.$blog_id.'\')" onmouseout="blogRatingFormLabelOut(\''.$label_color.'\', \''.$label_hover.'\', \'email\', \''.$blog_id.'\')"'
													// );
													?>
                                            </div>
                                        </li>

                                        <li class="col s12 l12">
                                            <?php
												echo form_submit(
													array(
														'class' => $button_position.' '.$button_type.' '.$button_background_color.' '.$button_label_color,
														'id'    => 'rating_form_submit_'.$blog_id,
														'type'  => 'submit',
														'name'  => 'submit',
														'onmouseover' => "blogFormSubmitBtnHover('".$button_label_color."', '".$button_label_hover."', '".$button_background_color."', '".$button_background_hover."', '".$blog_id."')",
														'onmouseout' => "blogFormSubmitBtnHoverOut('".$button_label_color."', '".$button_label_hover."', '".$button_background_color."', '".$button_background_hover."', '".$blog_id."')",
														'value' => $button_label
													)
												);
												?>
                                        </li>

                                    </ul>
                                    <?php echo form_close(); //Form close ?>
                                </div>
                                <?php
								$i++;

							endforeach;

						endif;
						?>
                            </div>

                            <?php
					// Form Tag
					echo form_open_multipart(
						'',
						'class="user_reply_comment " id="reply_form"'
					);
						?>
                            <ul class="row blog-post-comment-form ">

                                <?php
							// Input tag Hidden
							echo form_input(array(
								'type'  => 'hidden',
								'name'  => 'blog_id',
								'value' => $blog_id
							));
							// Input tag Hidden
							echo form_input(array(
								'type'  => 'hidden',
								'name'  => 'website_id',
								'value' => $website_id
							));
							// Input tag Hidden
							echo form_input(array(
								'type'  => 'hidden',
								'name'  => 'parent_id',
								'value' => 0
							));
							// Input tag Hidden
							echo form_input(array(
								'type'  => 'hidden',
								'name'  => 'url',
								'value' => base_url().$url
							));
							?>

                                <li class="col s12 l12">
                                    <?php
								// Label
								echo form_label(
									'Please Give Your Star Rating',
									'',
									'class="blog-rating-label '.$label_color.'" id="rating_form_label_star0" onmouseover="blogRatingFormLabel(\''.$label_color.'\', \''.$label_hover.'\', \'star\', \'0\')" onmouseout="blogRatingFormLabelOut(\''.$label_color.'\', \''.$label_hover.'\', \'star\', \'0\')"'
								);

                                echo form_fieldset('', 'class="rating"');

                                // Star 5
                                echo form_radio(array(
                                        'id' => 'star5',
                                        'name' => 'rating',
                                        'value' => 5
                                ));

                                // Star 5 Label
                                echo form_label(
                                    '',
                                    'star5',
                                    array(
                                        'class' => 'full',
                                        'title' => 'Awesome - 5 stars'
                                    )
                                );

                                // Star 4 Half
                                echo form_radio(array(
                                        'id' => 'star4half',
                                        'name' => 'rating',
                                        'value' => 4.5
                                ));

                                // Star 4 Half Label
                                echo form_label(
                                    '',
                                    'star4half',
                                    array(
                                        'class' => 'half',
                                        'title' => 'Pretty good - 4.5 stars'
                                    )
                                );

                                // Star 4
                                echo form_radio(array(
                                        'id' => 'star4',
                                        'name' => 'rating',
                                        'value' => 4
                                ));

                                // Star 4 Label
                                echo form_label(
                                    '',
                                    'star4',
                                    array(
                                        'class' => 'full',
                                        'title' => 'Pretty good - 4 stars'
                                    )
                                );

                                // Star 3 Half
                                echo form_radio(array(
                                        'id' => 'star3half',
                                        'name' => 'rating',
                                        'value' => 3.5
                                ));

                                // Star 3 Half Label
                                echo form_label(
                                    '',
                                    'star3half',
                                    array(
                                        'class' => 'half',
                                        'title' => 'Meh - 3.5 stars'
                                    )
                                );

                                // Star 3
                                echo form_radio(array(
                                        'id' => 'star3',
                                        'name' => 'rating',
                                        'value' => 3
                                ));

                                // Star 3 Label
                                echo form_label(
                                    '',
                                    'star3',
                                    array(
                                        'class' => 'full',
                                        'title' => 'Meh - 3 stars'
                                    )
                                );

                                // Star 2 Half
                                echo form_radio(array(
                                        'id' => 'star2half',
                                        'name' => 'rating',
                                        'value' => 2.5
                                ));

                                // Star 2 Half Label
                                echo form_label(
                                    '',
                                    'star2half',
                                    array(
                                        'class' => 'half',
                                        'title' => 'Kinda bad - 2.5 stars'
                                    )
                                );

                                // Star 2
                                echo form_radio(array(
                                        'id' => 'star2',
                                        'name' => 'rating',
                                        'value' => 2
                                ));

                                // Star 2 Label
                                echo form_label(
                                    '',
                                    'star2',
                                    array(
                                        'class' => 'full',
                                        'title' => 'Kinda bad - 2 stars'
                                    )
                                );

                                // Star 1 Half
                                echo form_radio(array(
                                        'id' => 'star1half',
                                        'name' => 'rating',
                                        'value' => 1.5
                                ));

                                // Star 1 Half Label
                                echo form_label(
                                    '',
                                    'star1half',
                                    array(
                                        'class' => 'half',
                                        'title' => 'Meh - 1.5 stars'
                                    )
                                );

                                // Star 1
                                echo form_radio(array(
                                        'id' => 'star1',
                                        'name' => 'rating',
                                        'value' => 1
                                ));

                                // Star 1 Label
                                echo form_label(
                                    '',
                                    'star1',
                                    array(
                                        'class' => 'full',
                                        'title' => 'Sucks big time - 1 star'
                                    )
                                );

                                // Star Half
                                echo form_radio(array(
                                        'id' => 'starhalf',
                                        'name' => 'rating',
                                        'value' => 0.5
                                ));

                                // Star Half Label
                                echo form_label(
                                    '',
                                    'starhalf',
                                    array(
                                        'class' => 'half',
                                        'title' => 'Sucks big time - 0.5 stars'
                                    )
                                );

								echo form_fieldset_close();
								
								
                                ?>
                                </li>



                                <li class="col s12 l6">
                                    <div class="input-field">
                                        <?php
									// Input tag
									echo form_input(array(
										'id'       => 'name',
										'name'     => 'name',
										'required' => 'required',
										'class'    => 'validate',
										'value'    => '',
										'placeholder' => 'Name'
									));

									// Label
									// echo form_label(
									// 	'Name',
									// 	'name',
									// 	'class="'.$label_color.'" id="rating_form_label_name0" onmouseover="blogRatingFormLabel(\''.$label_color.'\', \''.$label_hover.'\', \'name\', \'0\')" onmouseout="blogRatingFormLabelOut(\''.$label_color.'\', \''.$label_hover.'\', \'name\', \'0\')"'
									// );
									?>
                                    </div>
                                </li>

                                <li class="col s12 l6">
                                    <div class="input-field">
                                        <?php
									// Input tag
									echo form_input(array(
										'id'       => 'email',
										'name'     => 'email',
										'required' => 'required',
										'class'    => 'validate',
										'value'    => '',
										'placeholder' => 'Email'
									));

									// Label
									// echo form_label(
									// 	'Email',
									// 	'email',
									// 	'class="'.$label_color.'" id="rating_form_label_email0" onmouseover="blogRatingFormLabel(\''.$label_color.'\', \''.$label_hover.'\', \'email\', \'0\')" onmouseout="blogRatingFormLabelOut(\''.$label_color.'\', \''.$label_hover.'\', \'email\', \'0\')"'
									// );
									?>
                                    </div>
                                </li>
                                <li class="col s12 l12 blog-textarea">
                                    <div class="input-field ">
                                        <?php
									// Textarea
									echo form_textarea(array(
										'name' 	 => 'comment',
										'id'   	   => 'comment',
										'class' 	=> 'materialize-textarea',
										'required' => 'required',
										'placeholder' => 'comment'
									));

									// Label
									// echo form_label(
									// 	'Comment',
									// 	'comment',
									// 	'class="'.$label_color.'" id="rating_form_label_comment0" onmouseover="blogRatingFormLabel(\''.$label_color.'\', \''.$label_hover.'\', \'comment\', \'0\')" onmouseout="blogRatingFormLabelOut(\''.$label_color.'\', \''.$label_hover.'\', \'comment\', \'0\')"'
									// );
									?>
                                    </div>
                                </li>
                                <li class="col s12 l12">
                                    <?php
								echo form_submit(
									array(
										'class' => 'common-btn blog-submit-btn ' .$button_position.' '.$button_type.' '.$button_background_color.' '.$button_label_color,
										'id'    => 'rating_form_submit_0',
										'type'  => 'submit',
										'name'  => 'submit',
										'onmouseover' => "blogFormSubmitBtnHover('".$button_label_color."', '".$button_label_hover."', '".$button_background_color."', '".$button_background_hover."', '0')",
										'onmouseout' => "blogFormSubmitBtnHoverOut('".$button_label_color."', '".$button_label_hover."', '".$button_background_color."', '".$button_background_hover."', '0')",
										'value' => $button_label . 'Submit'
									)
								);
								?>
                                </li>

                            </ul>
                            <?php echo form_close(); //Form close ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php endif; ?>