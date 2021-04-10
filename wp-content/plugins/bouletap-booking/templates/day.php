<?php

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
$num_event = count($dayEvents);

$day_title = sprintf(__("Available: %d ", "cocoon"),  $num_event);
if(  $num_event == 0 ) {
    $day_title = __("Not available", "cocoon");
}
if(in_array("da-next-month-date", $classtype)) {
    $day_title = "&nbsp;";
}
?>

<div class="calendar-day da-booking-date <?php echo implode(" ", $classtype); ?>"> 
        
    <p class="da-booking-date-number"><?php echo $day_index; ?></p>
    <div class="da-availabe-date"><?php echo $day_title; ?></div>
    <a 
        onclick="load_form2('<?php echo $timestamp; ?>');" 
        class="da-btn da-booking-btn hvr-sweep-to-right-inverse" 
        data-datetime="<?php echo $timestamp; ?>">
        <?php _e("book now", "cocoon"); ?>
    </a>
        
</div>