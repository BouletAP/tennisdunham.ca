<?php


class UC01_DisplayCalendar {

    public $calendar;
    public $show_monthly = false;

    public $scenario_id = false;

    function init() {        

        // add a shortcode


        // elementor compatible
        add_action('init', array($this, 'elementor_calendar_controls'), 99);

        add_filter('bouletap_calendar_product_code', array($this, 'filter_calendar_product_code_cheat'), 25, 1); 

        // user interaction with calendar	
        //$viewModel = new \APBCalendar\Controller(); 
        add_action('wp_ajax_bouletap_change_month', array($this, 'ajax_change_month'));
		add_action('wp_ajax_nopriv_bouletap_change_month', array($this, 'ajax_change_month'));  
    }


    function filter_calendar_product_code_cheat($output) {
    
        if( !empty($this->scenario_id) ) {
            $output = \get_field('bookeo_product_id', $this->scenario_id);
        }
        
        return $output;
    }

    function elementor_calendar_controls() {
        require_once dirname(__FILE__) . '/elementor-widget-control.php';
        wp_enqueue_style("apbcalendar-style", plugin_dir_url(__FILE__) . "../medias/style.css");
        wp_enqueue_script("apbcalendar-script", plugin_dir_url(__FILE__) . "../medias/scripts.js", array('jquery'));
    }

    
    function execute() {     
                

        $datetime = new \DateTime('now'); 

        if( !empty($_GET['calendar-show']) ) {
            $this->show_monthly = $_GET['calendar-show'] != "weekly";
        }
        
        
        if( $this->show_monthly ) {
            $view = new EF02_ViewMonthly();            
        }
        else {
            $view = new EF01_ViewWeekly();          
        }

        $view->scenario_id = $this->scenario_id;

        $this->init_calendar_by_datetime($datetime, $this->show_monthly);    

        $viewData = $this->calendar->viewData();
        $content = $viewData['contents'];

        echo '<div class="da-bg-white da-inside-date ">';
        echo '<div class="reservaton-container-iframe">';        
        get_template_part("parts/scenario/booking-form");
        echo '</div>';
        echo '</div>';
        
		echo '<div class="secal bouletap-calendar da-calendar-page">';
		echo $view->execute($content, $this->calendar);
        echo '</div>';

        
        
		//echo $this->_medias();
    }

    function _medias() {

		$custom_data = apply_filters("bouletap_calendar_add_custom_data", array());
		ob_start(); 
		?>
		<script>
			function call_server(action, args) {
				var custom_data = '<?php echo json_encode($custom_data); ?>';
				custom_data = jQuery.parseJSON(custom_data);
				data = jQuery.extend(args.data, custom_data, {'action': action});
				show_loading();

				jQuery.post("<?php echo admin_url('admin-ajax.php'); ?>", data, function(response) {
					var response = jQuery.parseJSON(response);
					if( response.state == "success" ) {										
						args.onSuccess(response);
					}
					clear_loading();
				});
			}				
		</script>
		<?php
		return ob_get_clean();  
    }

    
    function ajax_change_month() {
        
        $current_date = !empty($_POST['current_date']) ? sanitize_text_field($_POST['current_date']) : 0;
        $calendar_offset = !empty($_POST['calendar_offset']) ? (int)$_POST['calendar_offset'] : 0;
        $calendar_display = !empty($_POST['calendar_display']) ? $_POST['calendar_display'] : 'weekly';

        $datetime = new \DateTime();
        $datetime->setTimestamp($current_date);

        if( $calendar_display === "weekly" ) {
            $datetime->modify( $calendar_offset . " day" );
            $view = new EF01_ViewWeekly();
            $this->init_calendar_by_datetime($datetime, false);    
            $viewData = $this->calendar->viewData();
            
            $items = $viewData['contents'];       
        }
        else {
            $datetime->modify( $calendar_offset . " month" );
            $view = new EF02_ViewMonthly();
            $this->init_calendar_by_datetime($datetime, true);    
            $viewData = $this->calendar->viewData();

            $months = $viewData['contents'];        
            $items = $months[0];
        }

        $calendar_title = $view->get_title($items, $calendar_offset);
        $calendar_view = $view->get_content($items, $this->calendar);
              
        echo json_encode(array(
            "datetime" => $datetime->getTimestamp(),
            "state" => "success",
            "calendar_offset" =>  $calendar_offset,
            "calendar_title" => $calendar_title,
            "calendar_view" => $calendar_view
        ));
        wp_die();
    }
    
    function init_calendar_by_datetime($datetime, $byMonth = true) {
        $this->calendar = new \Solution10\Calendar\Calendar($datetime);

        if( $byMonth ) {
            $this->calendar->setResolution(new \Solution10\Calendar\Resolution\MonthResolution);
            $events = apply_filters('bouletap_calendar_events_by_month', array(), $datetime->getTimestamp(), false);
        }
        else {
            $this->calendar->setResolution(new \Solution10\Calendar\Resolution\WeekResolution());
            $this->calendar->resolution()->setStartDay(date('l', time()));       
            $events = apply_filters('bouletap_calendar_events_by_week', array(), $datetime->getTimestamp());
        }
        
        foreach($events as $event ) {            
            $this->calendar->addEvent($event);
        }
	}
}