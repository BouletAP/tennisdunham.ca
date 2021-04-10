<?php

class EF03_DisplayDay {

    function execute($day, $classtype, $calendar, $scenario_id) {
        
        $dayEvents = $calendar->eventsForTimeframe($day);
        $num_event = count($dayEvents);

        $day_title = sprintf(__("Available: %d ", "cocoon"), $num_event);

        if(  $num_event == 0 ) {
            $day_title = __("Not available", "cocoon");
            $classtype []= "da-not-availabe-day";
        }
        if(in_array("da-next-month-date", $classtype)) {
            $day_title = "&nbsp;";
        }

        $timestamp = $day->date()->getTimestamp();
        $day_index = $day->date()->format('d');
        $week_index = cocoon_get_week_name($day->date()->format('D'));
        $num_event = count($dayEvents);

        $day_title = sprintf(__("Available: %d ", "cocoon"),  $num_event);
        if(  $num_event == 0 ) {
            $day_title = __("Not available", "cocoon");
        }
        if(in_array("da-next-month-date", $classtype)) {
            $day_title = "&nbsp;";
        }

        ob_start(); 
        ?>    
        <div class="calendar-day da-booking-date <?php echo implode(" ", $classtype); ?>"> 
                
            <p class="da-booking-date-number">
                <span class="week-index"><?php echo $week_index; ?></span>
                <?php echo $day_index; ?>
            </p>
            <div class="da-availabe-date"><?php echo $day_title; ?></div>
            <a 
                onclick="bouletap_load_event_details('<?php echo $timestamp; ?>', '<?php echo $scenario_id; ?>');" 
                class="da-btn da-booking-btn hvr-sweep-to-right-inverse" 
                data-datetime="<?php echo $timestamp; ?>">
                
                <i class="icon fa fa-calendar-plus-o" aria-hidden="true"></i>
                <span class="label"><?php _e("book now", "cocoon"); ?></span>
            </a>
                
        </div>
        <?php
        $output = ob_get_clean();
        return $output;
    }
}