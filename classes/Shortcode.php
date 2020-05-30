<?php
namespace ADEVPH\DashWidget\Classes;

if ( ! defined( 'WPINC' ) ) {
	die;
}

if( ! class_exists("Shortcode") ):

class Shortcode {
    
    public function __construct(){
        add_shortcode("dash_widget", array( $this, "render_dash_widget_shortcode") );
    }


    function render_dash_widget_shortcode($atts){
        if(empty($atts["name"])) { return; }

        $widget = null;
        $output = "";
        if ( $posts = get_posts( array( 
            'name' => $atts["name"], 
            'post_type' => 'dash_widget',
            'post_status' => 'publish',
            'posts_per_page' => 1
        ) ) ) $widget = $posts[0];
        
        if ( ! is_null( $widget ) ){
            $output .= sprintf("<div class='dash-widget-wrapper'><h2 class='dash-widget-title'>%s</h2><div class='dash-widget-content'>%s</div></div>",
                $widget->post_title, html_entity_decode($widget->post_content)
            );
            return $output;
        }

        return;
    }
} 

new Shortcode();
endif;