<?php

class EF02_CalendarControls {

    function execute($timestampItem, $calendar) {
        ob_start();
        ?>
        
        <div class="secal-header">
            
            <a href="javascript:;" class="btn-month-prev secal-btn-month da-btn-month" data-applyoffset="-1">
                <i class="fa fa-angle-left" aria-hidden="true"></i>
            </a>

    <?php if($by_month): ?> 
            <span class="month-title" data-current="<?php echo $timestampItem->start()->getTimestamp(); ?>">
                <?php echo sprintf("%s %s", cocoon_get_month_name($timestampItem->title('F')), $timestampItem->title('Y')); ?>
            </span>
    <?php else: ?>
        <span class="week-title" data-current="<?php echo $timestampItem->weekStart()->getTimestamp(); ?>">
            <?php echo $timestampItem->weekStart()->format('j F'); ?>
            -
            <?php echo $timestampItem->weekEnd()->format('j F'); ?>
        </span>

    <?php endif; ?>
            <a href="javascript:;" class="da-btn-month-next secal-btn-month da-btn-month" data-applyoffset="1">
                <i class="fa fa-angle-right" aria-hidden="true"></i>
            </a>
        </div>

        <?php
        $output = ob_get_clean();
        return $output;
    }
}