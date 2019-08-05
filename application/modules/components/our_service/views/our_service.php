<?php
/**
 * Our Service
 * @category View
 * @package Our Service 
 * @author Saravana
 * Created at : 29-Oct-18
 */

 if (!empty($our_services)) :
?>
<section class="bg-img-common <?php echo $bg_color;?>" <?php if ($bg_image != "") : ?>
    style="background-image:url('<?php echo $bg_image;?>')" <?php endif;?>>
    <div class="common-space">
        <div class="container">
            <article class="our-services">
                <div data-aos="fade-down" data-aos-duration="2800">
                    <?php
						if($our_service_status == 1) :

							echo heading(
								$our_service_title,
								'4',
								array(
									'class' => $our_service_title_color.' '.$our_service_title_position .' h1-head'
								)
							);
					?>
                </div>
                <div data-aos="fade-right" data-aos-duration="2800">
                    <div class="<?php echo $our_service_content_color.' '.$our_service_content_position;?>">
                        <?php echo $our_service_content;?>
                    </div>
                </div>

                <?php endif;?>
                <div data-aos="fade-up" data-aos-duration="2800">
                    <ul class="row our-services-detail">
                        <?php 
							foreach($our_services as $our_service) : 
								if($our_service->open_new_tab == '1') :
									$open_new_tab = 'target="_blank"';
								else:
									$open_new_tab = '';
								endif;

								if(!empty($our_service->redirect_url)) :
									$redirect_url = $our_service->redirect_url;
								else :
									$redirect_url = "javascript:void(0);";
								endif;
						?>

                        <li data-aos="zoom-in" class="col s12 <?php echo $our_service_row_count;?>">
                            <a href="<?php echo $redirect_url;?>" <?php echo $open_new_tab;?>>
                                <figure class="snip1206"><img src="<?php echo $image_url . $our_service->image;?>"
                                        alt="" title="" />
                                    <figcaption>
                                        <?php
											echo heading(
												$our_service->title,
												'4',
												array(
													'class' => $our_service->title_color
												)
											);
										?>
                                    </figcaption>
                                </figure>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </article>
        </div>
    </div>
</section>
<?php endif; ?>