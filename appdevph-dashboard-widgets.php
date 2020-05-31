<?php
/**
 * Plugin Name:       AppDevPH Dash Widgets
 * Plugin URI:        https://github.com/allan-empalmado/appdevph-dashboard-widgets
 * Description:       Create unlimited wordpress custom dashboard widgets. Enable/Disable dashboard widgets
 * Author:            Allan Ramirez Empalmado
 * Version:           1.0.0
 * Author URI:        https://appdevph.com
 * GitHub Plugin URI: https://github.com/allan-empalmado/appdevph-dashboard-widgets
 * License:           MIT
 */

namespace ADEVPH\DashWidget;

if ( ! defined( 'WPINC' ) ) {
	die;
}

if( ! class_exists("Dash_Widget") ):

class Dash_Widget {

	public function __construct(){
		
	}
  
}

require_once("classes/WidgetCPT.php");
require_once("classes/WidgetRender.php");
require_once("classes/Metabox.php");
require_once("classes/Shortcode.php");
require_once("classes/Settings.php");

new  Dash_Widget();
endif;