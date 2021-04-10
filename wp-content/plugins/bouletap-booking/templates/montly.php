

<div class="calendar-content da-booking-day-container">
	
	<?php foreach ($month->weeks()[0]->days() as $day): ?>
		<div class="day-title calendar-day"><?php echo cocoon_get_week_name_abbr($day->date()->format('D')); ?></div>
	<?php endforeach; ?>

	<?php foreach ($month->weeks() as $week): ?>
		<?php foreach ($week->days() as $day): ?>                                   
				<?php
					$classtype = array();
					if ($day->isOverflow()) {
						if ($this->data['show_overflow_days']) {
							$classtype = array("da-last-day");
							
						} else {
							$classtype = array("da-next-month-date");
						}
					}
					include( plugin_dir_path(__FILE__) . '/day.php' );
				?>
		<?php endforeach; ?>
	<?php endforeach; ?>
</div>
