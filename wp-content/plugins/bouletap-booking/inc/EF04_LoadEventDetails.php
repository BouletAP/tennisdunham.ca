<?php

class EF04_LoadEventDetails  {
    
    function init() {  
        
        add_action('wp_ajax_bouletap_load_event_details', array($this, 'load_event_details'));
        add_action('wp_ajax_nopriv_bouletap_load_event_details', array($this, 'load_event_details')); 
    }

    function load_event_details() {
        
        $view_path = apply_filters('apbcalendar_event_details_view', "");
        ob_start();
        get_template_part($view_path); 
        $view = ob_get_clean();  

		echo json_encode(array(
			"state" => "success",
            "view" => $view
		));
		wp_die();
    }


    
}
