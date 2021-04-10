<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
/**
 * Plugin Name:       BouletAP Really Simple Calendar
 * Plugin URI:        https://bouletap.com
 * Description:       A plugin to help manage reservation with Bookeo on Websites.
 * Version:           1.0.0
 * Author:            Andre-Philippe Boulet
 * Author URI:        https://bouletap.com
 * License:           All Right Reserved
 * Text Domain:       bouletap
 */

error_reporting(E_ALL);
ini_set("display_errors", true);
 

require_once(__DIR__ . '/vendor/solution10/__init__.php');
require_once(__DIR__ . '/inc/viewmodel.php');
require_once(__DIR__ . '/inc/controller.php');


require_once(__DIR__ . '/inc/EF01_ViewWeekly.php');
require_once(__DIR__ . '/inc/EF02_ViewMonthly.php');
require_once(__DIR__ . '/inc/EF03_DisplayDay.php');

require_once(__DIR__ . '/inc/UC01_DisplayCalendar.php');
require_once(__DIR__ . '/inc/UC02_CallEventDetails.php');





class BouletAPCalendar {


    public function init() {

		$uc01 = new UC01_DisplayCalendar();
		$uc01->init();
		

		$uc02 = new UC02_CallEventDetails();
		$uc02->init();
    }    
}

$bouletAPCalendar = new BouletAPCalendar();
$bouletAPCalendar->init();