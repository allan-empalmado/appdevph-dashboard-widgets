<?php
/**
 * Plugin Name:       AppDevPH Dashboard Widgets
 * Plugin URI:        https://github.com/allan-empalmado/appdevph-dashboard-widgets
 * Description:       Create unlimited wordpress custom dashboard widgets. Enable/Disable dashboard widgets
 * Author:            Allan Ramirez Empalmado
 * Version:           1.0.0
 * Author URI:        https://appdevph.com
 * GitHub Plugin URI: https://github.com/allan-empalmado/appdevph-dashboard-widgets
 * License:           MIT
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

if( ! class_exists("APPDEVPH_Dashboard_Widgets") ):

class APPDEVPH_Dashboard_Widgets {

    public function __construct(){
        add_action( "wp_dashboard_setup", array( $this, "render_dashboard_widgets" ) );

        add_filter( 'adevph_widget_content', array( $this, "render_dashboard_content" ), 10, 1 ); 
        add_filter( 'adevph_widget_content', "do_shortcode" ); //render shortcode data if any
    }

    /** Render the dashboard widgets */
    function render_dashboard_widgets(){
        global $wp_meta_boxes;
        $this->options = get_option("appdevph_dashboard_widgets");

        if(!empty($this->options)):
          foreach($this->options as $key => $value):
                wp_add_dashboard_widget( 
                    $key, 
                    $value["widget_name"], 
                    function() use ($value){
                        echo apply_filters("adevph_widget_content", wpautop($value["widget_content"]));
                    }
                );
            endforeach;
        endif;
    }

    function render_dashboard_content($content){
        return  html_entity_decode($content) ;
    }

}

require_once("classes/class.settings.php");

new APPDEVPH_Dashboard_Widgets();
endif;