<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class APBCalendar_widget extends Widget_Base  {

  public function get_title() {
		return __( 'Simple Calendar', 'apbcalendar' );
	}
	
	public function get_name() {
		return 'apbcalendar-widget-block';
	}
    public function get_icon() {
		return 'eicon-table';
	}
	
	protected function _register_controls() {
		
		$this->setup_general_settings();
		
	}	

	protected function render() {
		
 
		$instance = $this->get_settings();
		
		// $widget_template = ! empty( $instance['widget_template'] ) ? $instance['widget_template'] : '';
		// $main_title = ! empty( $instance['main_title'] ) ? $instance['main_title'] : '';
		// $title_col_1 = ! empty( $instance['title_col_1'] ) ? $instance['title_col_1'] : '';
		// $title_col_2 = ! empty( $instance['title_col_2'] ) ? $instance['title_col_2'] : '';
		// $events = !empty( $instance['events'] ) ? $instance['events'] : '';
		
		$use_case = new \UC01_DisplayCalendar(); 
		$use_case->execute();
	}




	function setup_general_settings() {
		$this->start_controls_section(
			'section_apbcalendar_widget_block_item_setting',
				[
					'label' => __( 'General settings', 'apbcalendar' ),
				]
		);				

		$this->add_control(
			'widget_template',
			[
				'label' => __( 'Display', 'apbcalendar' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'tpl1',
				'options' => [
					'tpl-weekly' => __( 'Weekly', 'apbcalendar' ),
					'tpl-montly' => __( 'Montly', 'apbcalendar' ),
					'tpl-yearly' => __( 'Yearly', 'apbcalendar' )
				]
			]
		);				

		$this->end_controls_section();
	}



}

Plugin::instance()->widgets_manager->register_widget_type( new APBCalendar_widget() );