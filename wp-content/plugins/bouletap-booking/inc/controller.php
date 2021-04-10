<?php

namespace APBCalendar;

class Controller {



    function display() {  
        
        $calendar_contents = $this->init_calendar();
		
		ob_start(); ?>                
		<div class="secal <?php echo $this->data['classes']; ?>">
            <?php 
                foreach ($calendar_contents as $month):
                    include ( plugin_dir_path(__FILE__) . '/../templates/header.php' );
                    include ( plugin_dir_path(__FILE__) . '/../templates/montly.php' );
                endforeach; 
            ?>
		</div>
		<?php
		echo $this->_medias();
		return ob_get_clean(); 
	}
	

	function init_calendar() {

		$args = array(
			'datetime' => 'now'
		);
		
		$datetime = new \DateTime($args['datetime']);    
		$default_data = array(
				"classes" => "bouletap-calendar ",
				"datetime" => '',
				"show_header" => true,
				"show_prev" => true,
				"show_next" => true,
				"show_month" => true,
				"show_overflow_days" => true
		);
		$this->data = $args + $default_data;

		$this->calendar = new \Solution10\Calendar\Calendar($datetime);

		$this->calendar->setResolution(new \Solution10\Calendar\Resolution\MonthResolution);
		$this->data['show_overflow_days'] = $this->calendar->resolution()->showOverflowDays();

		$events = apply_filters('bouletap_calendar_events', array(), $datetime->getTimestamp());
        foreach($events as $event ) {            
			$this->calendar->addEvent($event);
        }

		$viewData = $this->calendar->viewData();
		return $viewData['contents'];
	}

	
    function ajax_change_month() {
        
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
            "calendar_title" => $calendarView->get_month_title($month, $calendar_offset),
            "calendar_view" => $calendarView->get_calendar_content($month)
		));
		wp_die();
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
	

	
}