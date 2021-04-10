<?php

class EF02_ViewMonthly {

    public $show_overflow_days= true;
    public $scenario_id= false;

    function execute($months, $calendar) {
        
        ob_start();
        foreach ($months as $month):
        ?>
            <div class="cal-header">
                <div class="secal-header">
                    
                    <a href="javascript:;" class="btn-month-prev secal-btn-nextprev da-btn-month" data-typeoffset="-">
                        <i class="fa fa-angle-left" aria-hidden="true"></i>
                    </a>

                    <a href="javascript:;" class="btn-date-range">
                        <?php echo $this->get_title($month, 0); ?>
                    </a>
                    
                    <a href="javascript:;" class="da-btn-month-next secal-btn-nextprev da-btn-month" data-typeoffset="+">
                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                    </a>
                </div>
                <a href="javascript:show_calendar_and_hide_form();" class="btn-close-booking"><i class="far fa-times-circle"></i></a>
            </div>

            <?php echo $this->get_content($month, $calendar); ?>       
        <?php
        endforeach; 
        $output = ob_get_clean();
        return $output;
    }

    function get_content($month, $calendar) {
        $dayDisplay = new EF03_DisplayDay();
        ob_start(); ?>

        <div class="calendar-content da-booking-day-container monthly">     
            <?php foreach ($month->weeks()[0]->days() as $day): ?>
                <div class="day-title calendar-day"><?php echo cocoon_get_week_name_abbr($day->date()->format('D')); ?></div>
            <?php endforeach; ?>

            <?php foreach ($month->weeks() as $week): ?>
                <?php foreach ($week->days() as $day): ?>                                   
                        <?php
                            $classtype = array();
                            if ($day->isOverflow()) {
                                if ($this->show_overflow_days) {
                                    $classtype = array("da-last-day");
                                    
                                } else {
                                    $classtype = array("da-next-month-date");
                                }
                            }
                            //include( plugin_dir_path(__FILE__) . '/day.php' );
                            echo $dayDisplay->execute($day, $classtype, $calendar, $this->scenario_id);
                        ?>
                <?php endforeach; ?>
            <?php endforeach; ?>
                    
        </div>
        <?php
        return ob_get_clean();  
    }

    
    function get_title($month, $offset = 0) {
        ob_start(); ?>
        <p class="date-title monthly" data-display="monthly" data-offset="1" data-current="<?php echo $month->start()->getTimestamp(); ?>"><?php echo sprintf("%s %s", cocoon_get_month_name($month->title('F')), $month->title('Y')); ?></p>
        <?php
        return ob_get_clean();  
    }

}