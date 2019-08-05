<?php
/**
 * Provided Services
 *
 * @category view
 * @package Provided Services
 * @author Saravana
 * created at: 08-Dec-2018
 */

 if (!empty($provided_services)) :
?>
	
<section class="bg-img-common <?php echo $bg_color;?>" <?php if ($bg_image != "") : ?>
    style="background-image:url('<?php echo $bg_image;?>')" <?php endif;?>>
	<!--  -->
	<div class="common-space">
		<div class="container">
			<?php
				// Check Heading is enabled
				if ($provided_services_title_status != 0) :
					// H4 tag with it's customized options
					echo heading(
						$provided_services_title,
						'4',
						array(
							'class' => 'h1-head ' . $provided_services_title_position .' '. $provided_services_title_color,
							'data-aos' => 'fade-up'
						)
					);
				endif;
			?>

			<div class="row">
				<ul class="provied-service-list" data-aos="fade-up">
				<?php foreach ($provided_services as $provided_service) : ?>
					<li class="col s12 m6 <?php echo $count;?>">
							<a href="<?php echo base_url().$provided_service->url?>" class="<?php echo $provided_service->title_color;?>">
								
								<?php echo $provided_service->title;?>
							</a>
					</li>
				<?php endforeach; ?>
				</ul>
			</div>

		</div>
		</div>
	</section>
<?php endif;?>
