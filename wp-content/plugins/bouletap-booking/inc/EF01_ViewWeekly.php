<?php

class EF01_ViewWeekly {

    public $scenario_id= false;

    function execute($week, $calendar) {
        
        $weekTime = new \Solution10\Calendar\Week(new DateTime('2019-10-24'));
        $weekEvents = $calendar->eventsForTimeframe($weekTime);


        ob_start();
        ?>
        <div class="secal-header">
            <a href="javascript:;" class="btn-week-prev secal-btn-nextprev da-btn-month" data-typeoffset="-">
                <i class="fa fa-angle-left" aria-hidden="true"></i>
            </a>         

            <a href="javascript:;" class="btn-date-range">
                <?php echo $this->get_title($week, 0); ?>
            </a>  
            
            <a href="javascript:;" class="da-btn-week-next secal-btn-nextprev da-btn-month" data-typeoffset="+">
                <i class="fa fa-angle-right" aria-hidden="true"></i>
            </a>
 
        </div>

        <?php echo $this->get_content($week, $calendar); ?>
       

        <?php
        $output = ob_get_clean();
        return $output;
    }

    function get_content($week, $calendar) {
        $dayDisplay = new EF03_DisplayDay();
        ob_start(); ?>
        <div class="calendar-content da-booking-day-container weekly"> 
            
            <?php foreach ($week->days() as $day): ?>
                <div class="day-title calendar-day"><?php echo cocoon_get_week_name_abbr($day->date()->format('D')); ?></div>
            <?php endforeach; ?>

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
                        echo $dayDisplay->execute($day, $classtype, $calendar, $this->scenario_id);
                    ?>
            <?php endforeach; ?>   
        </div>
        <?php
        return ob_get_clean();  
    }


    function get_title($week) {
        ob_start(); ?>
            <span class="date-title weekly"  data-display="weekly" data-offset="7" data-current="<?php echo $week->weekStart()->getTimestamp(); ?>">
                <?php echo $week->weekStart()->format('j') . " " . cocoon_get_month_name($week->weekStart()->format('F')); ?>
                -
                <?php echo $week->weekEnd()->format('j') . " " . cocoon_get_month_name($week->weekEnd()->format('F')); ?>
            </span>
        <?php
        return ob_get_clean(); 
        
    }
}