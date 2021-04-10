<?php

namespace APBCalendar;

class CalendarView  {
    
    public $calendar = array();
    public $data = array();
    

	function __construct($calendar, $args = array()) {
        $this->calendar = $calendar;

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
    }

    function get_custom_data() {
        $output = array();
        $output = apply_filters("bouletap_calendar_add_custom_data", $output);

        return $output;
    }

    function _medias() {

        ob_start(); ?>
        <style>
            .da-calendar-block {width:100%;}
        </style>
        <script>

            function load_form(date_selected) {
                var data = {
                    'action': 'bouletap_reload_form',
                    'date': date_selected
                };
                
                var custom_data = '<?php echo json_encode($this->get_custom_data()); ?>';
                custom_data = jQuery.parseJSON(custom_data);
                data = jQuery.extend(data, custom_data);
                show_loading();

                jQuery.post("<?php echo admin_url('admin-ajax.php'); ?>", data, function(response) {
                   
                    var response = jQuery.parseJSON(response);                    
                    clear_loading();
                    
                    if( response.state == "success" ) {
                        
                        show_form_and_hide_calendar();
                        jQuery('.section-reservation').replaceWith(response.view);
                    }
                });
            }
            
            function show_loading() {
                jQuery('.bouletap-calendar').addClass("loading");
            }

            function clear_loading() {
                jQuery('.bouletap-calendar').removeClass("loading");
            }
            
            function show_calendar_and_hide_form() {
                var da_calendar_page = jQuery('.da-calendar-page');
                var da_inside_page = jQuery('.da-inside-date');
                da_calendar_page.css('display', 'block');
                da_inside_page.css('display', 'none');
            }
            function show_form_and_hide_calendar() {
                var da_calendar_page = jQuery('.da-calendar-page');
                var da_inside_page = jQuery('.da-inside-date');
                da_calendar_page.css('display', 'none');
                da_inside_page.css('display', 'block');
            }

            jQuery('.da-btn-month').on('click', function() {
                var container = jQuery(this).parent().find('.month-title');
                var current_date = container.data('current');
                var new_offset = jQuery(this).data('applyoffset');
                reload_month(current_date, new_offset, "month");
            });

            function reload_month(current_date, offset, type) {
                //console.log("reload_month : "  + offset);

                var data = {
                    'action': 'bouletap_change_month',
                    'current_date' : current_date,
                    'calendar_offset': offset
                };
                
                var custom_data = '<?php echo json_encode($this->get_custom_data()); ?>';
                custom_data = jQuery.parseJSON(custom_data);
                data = jQuery.extend(data, custom_data);
                show_loading();
                 jQuery.post("<?php echo admin_url('admin-ajax.php'); ?>", data, function(response) {
                    var response = jQuery.parseJSON(response);
                    
                    //console.log(response);
                    clear_loading();
                    if( response.state == "success" ) {
                        jQuery("p.month-title").replaceWith(response.calendar_title);
                        jQuery("table.da-calendar-block").replaceWith(response.calendar_view);
                    }
                    //jQuery(".loading-gif").addClass("hidden");
                    //currentViewDiv.removeClass("loading");
                });
            }
            
        </script>
        <?php
        return ob_get_clean();  
    }

    function get_months() {
        $this->calendar->setResolution(new \Solution10\Calendar\Resolution\MonthResolution());
        $this->data['show_overflow_days'] = $this->calendar->resolution()->showOverflowDays();
        $viewData = $this->calendar->viewData();
        return $viewData['contents'];
    }



    
    function display() {  
        
        $months = $this->get_months();
        
        ob_start(); ?>                
        <div class="<?php echo $this->data['classes']; ?>">
            <?php foreach ($months as $month): ?>            
                <?php echo $this->get_calendar_header($month); ?>          
                <?php echo $this->get_calendar_content($month); ?>
            <?php endforeach; ?>
        </div>
        <?php
        echo $this->_medias();
        return ob_get_clean();  
    }


    function get_calendar_header($month) {
        ?>
            <div class="da-month-name">
                <a href="javascript:;" class="da-btn-month da-btn-month-prev" data-applyoffset="-1"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
                <?php echo $this->get_month_title($month, 0); ?>
                <a href="javascript:;" class="da-btn-month da-btn-month-next" data-applyoffset="1"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
            </div>
        <?php
    }

    function get_month_title($month, $offset = 0) {
        ob_start(); ?>
        <p class="month-title" data-current="<?php echo $month->start()->getTimestamp(); ?>"><?php echo sprintf("%s %s", cocoon_get_month_name($month->title('F')), $month->title('Y')); ?></p>
    <?php
        return ob_get_clean();  
    }

    function get_calendar_content($month) {

        ob_start(); ?>

        <table class="da-calendar-block da-margin-top-50">
            <thead class="da-booking-day-container da-margin-top-50">
                <tr>
                    <?php foreach ($month->weeks()[0]->days() as $day): ?>
                        <th class="da-booking-day"><?php echo cocoon_get_week_name_abbr($day->date()->format('D')); ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody class="da-booking-date-container">
                <?php foreach ($month->weeks() as $week): ?>
                    <tr>
                        <?php foreach ($week->days() as $day): ?>                                    
                            <?php
                                if ($day->isOverflow()) {
                                    if ($this->data['show_overflow_days']) {
                                        echo $this->display_booking_day($day, array("da-last-day")); // , 
                                        //echo $this->display_booking_day($day, "da-next-month-date");
                                        
                                    } else {
                                        //echo $this->display_booking_day($day, "da-not-availabe-day");
                                        echo $this->display_booking_day($day, array("da-next-month-date")); //, 
                                    }
                                } else {
                                    echo $this->display_booking_day($day);
                                }
                            ?>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
    <?php
        return ob_get_clean();  
    }

    function display_booking_day($day, $classtype= array()) {

        $dayEvents = $this->calendar->eventsForTimeframe($day);
        $num_event = count($dayEvents);

        $day_title = sprintf(__("Available: %d ", "cocoon"), $num_event);

        if(  $num_event == 0 ) {
            $day_title = __("Not available", "cocoon");
            $classtype []= "da-not-availabe-day";
        }
        if(in_array("da-next-month-date", $classtype)) {
            $day_title = "&nbsp;";
        }

        ob_start(); ?>
            <td class="da-booking-date <?php echo implode(" ", $classtype); ?>">
                <?php echo $this->display_day_content($day, $dayEvents, $classtype); ?>
            </td>
        <?php
        return ob_get_clean();  
    }

    function display_day_content($day, $dayEvents, $classtype) {
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
        ob_start(); ?>
            <p class="da-booking-date-number"><?php echo $day_index; ?></p>
            <div class="da-availabe-date"><?php echo $day_title; ?></div>
            <a 
                onclick="load_form('<?php echo $timestamp; ?>');" 
                class="da-btn da-booking-btn hvr-sweep-to-right-inverse" 
                data-datetime="<?php echo $timestamp; ?>">
                <?php _e("book now", "cocoon"); ?>
            </a>
        <?php
        return ob_get_clean(); 
    }

}
