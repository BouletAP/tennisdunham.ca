<?php


class UC02_CallEventDetails {

    function init() {        
        add_action('wp_ajax_bouletap_load_event_details', array($this, 'execute'));
        add_action('wp_ajax_nopriv_bouletap_load_event_details', array($this, 'execute')); 
    }


    
    function execute() {     
        $view_path = "parts/scenario/booking-form";
        ob_start();
        get_template_part($view_path); 
        $view = ob_get_clean();  
        $view = apply_filters('apbcalendar_event_details_view', $view);

		echo json_encode(array(
			"state" => "success",
            "view" => $view
		));
		wp_die();
    }

}