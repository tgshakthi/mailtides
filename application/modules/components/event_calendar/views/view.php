<?php
	/**
	 * Event Calendar
	 *
	 * @category view
	 * @author Saravana
	 * Created at: 03-Oct-2018
	*/

if(!empty($events)) :
?>
	<section class="section <?php echo $event_calendar_background_color;?>">
		<div class="container">
			<?php

				// Check heading is enabled
				if($event_calendar_title_status != 0):
					// H4 tag with it's customized options
					echo heading(
						$event_calendar_title,
						'4',
						array(
							'class' => $event_calendar_title_position .' '. $event_calendar_title_color
						)
					);
				endif;

				echo form_textarea(
					array(
						'id' => 'calendar_events',
						'value' => json_encode($events),
						'hidden' => 'hidden'
					)
				);
			?>
			<div id="calendar"></div>
			<div id="fc_edit"></div>

			<!-- calendar modal -->
			<div id="CalenderModalEdit" class="modal">
				<div class="modal-content">
					<h4 class="center-align" id="title2"></h4>
					<p>Event Date and Time :
						<span>From : </span><span id="start"></span>
						<span> - </span>
						<span id="end"></span>
					</p> 
					<p id="descr2"></p>
				</div>
				<div class="divider"></div>
				<div class="modal-footer">
					<button class="red modal-close waves-effect waves-red btn right">Close</button>
				</div>
			</div>

		</div>
	</section>
<?php endif;?>
