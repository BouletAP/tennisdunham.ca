<div class="secal-header">
    
    <a href="javascript:;" class="btn-month-prev secal-btn-month da-btn-month" data-applyoffset="-1">
        <i class="fa fa-angle-left" aria-hidden="true"></i>
    </a>

    <span class="month-title" data-current="<?php echo $month->start()->getTimestamp(); ?>">
        <?php echo sprintf("%s %s", cocoon_get_month_name($month->title('F')), $month->title('Y')); ?>
    </span>
    
    <a href="javascript:;" class="da-btn-month-next secal-btn-month da-btn-month" data-applyoffset="1">
        <i class="fa fa-angle-right" aria-hidden="true"></i>
    </a>
</div>