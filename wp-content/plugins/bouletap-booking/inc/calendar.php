<?php

namespace APBCalendar;

use BouletAPSoftware\Modules\Solution10Calendar\Specifications\EF01_ChangeMonth;


class CalendarUnfucked {

    protected static $instance;
    public static function get_instance() {
        if ( is_null ( self::$instance ) ) {
            self::$instance = new self();
        }

        return self::$instance;
    }


    function create_calendar_by_datetime($datetime) {
        $calendar = new \Solution10\Calendar\Calendar($datetime);

        $events = apply_filters('bouletap_calendar_events', array(), $datetime->getTimestamp());
        //$currentDatetime = new \DateTime('today');
        foreach($events as $event ) {
            
            // booking 1 week before only
            //$datetime = $event->getTitleDate();
            //$interval = $datetime->diff($currentDatetime);
            //if( $interval->days < 7 ) {
                $calendar->addEvent($event);
            //}
        }

        //echo '<pre>'; print_r(xxxxxx); echo '</pre>'; die();
        $calendarView = new CalendarView($calendar);
        return $calendarView; //$view->display();
    }




    function bouletap_change_month() {

        //$calendar_offset = !empty($_POST['calendar_offset']) ? (int)$_POST['calendar_offset'] : 0;
        //$datetime = new \DateTime($calendar_offset); 
        
        
        $current_date = !empty($_POST['current_date']) ? sanitize_text_field($_POST['current_date']) : 0;
        $calendar_offset = !empty($_POST['calendar_offset']) ? (int)$_POST['calendar_offset'] : 0;

        $datetime = new \DateTime();
        $datetime->setTimestamp($current_date);
        $datetime->modify( $calendar_offset . " month" );


        $calendarView = $this->create_calendar_by_datetime($datetime);
        $months = $calendarView->get_months();
        $month = $months[0];

		echo json_encode(array(
			"datetime" => $datetime->getTimestamp(),
			"state" => "success",
			"calendar_offset" =>  $calendar_offset,
			//"offset" => $date_offset,
            "calendar_title" => $calendarView->get_month_title($month, $calendar_offset),
            "calendar_view" => $calendarView->get_calendar_content($month)
		));
		wp_die();
	}

}