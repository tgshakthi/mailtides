<?php
/**
 * Counter
 * Created at : 29-Oct-2018
 * Author : Velu
 */
 if(!empty($counters)) :

	if(!empty($background_image)):
		$bg_img = $image_url . $background_image;
	else:
		$bg_img = '';
	endif;
?>
<section class="counter <?php echo $bg_color;?>" <?php if ($bg_image != "") : ?>
    style="background-image:url('<?php echo $bg_image;?>')" <?php endif;?>>
    <i class="counter-bg-black"></i>
    <div class="common-space">
        <div class="container">
            <div class="row" data-aos="fade-up">
                <div class="counter-detail counter-heading">
                    <?php
                        if ($counter_title_status_customize == 1) :
                            $heading = heading(
                                $counter_title_customize,
                                3,
                                array(
                                    'class' =>'h1-head '. $counter_title_color_customize . ' ' . $counter_title_position_customize,
                                    'style' => 'font-size:'.$counter_title_font_size_customize .'; font-weight:'. $counter_title_font_weight_customize
                                )
                            );
                        else :
                            $heading = "";
                        endif;

                        echo $heading;
                    ?>
                </div>
                <?php  
                    if(!empty($counters)) :
                        foreach($counters as $counter): 
                ?>
                <div class="col s12 m6 l3 xl3 center">
                    <div class="counter-detail counter-count">
                        <h3 class="h3-head <?php echo $counter->count_number_color;?> center" data-aos="fade-right">
                            <i class="fa <?php echo $counter->counter_icon.' '.$counter->counter_icon_color;?>"
                                data-aos="fade-right"></i>
                            <span class="counter-number"><?php echo $counter->count_number;?></span>
                        </h3>
                        <h6 class="<?php echo $counter->counter_title_color;?> center h6-head" data-aos="fade-right">
                            <?php echo $counter->counter_title;?></h6>
                    </div>
                </div>
                <?php 
                        endforeach; 
                    endif;
                ?>
            </div>
        </div>
    </div>
</section>

<?php endif;?>