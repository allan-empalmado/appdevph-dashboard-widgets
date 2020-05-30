<?php
namespace ADEVPH\DashWidget\Classes;

if ( ! defined( 'WPINC' ) ) {
	die;
}

if( ! class_exists("Widget_Render") ):

class Widget_Render {

    public function __construct(){
        add_action( "wp_dashboard_setup", array( $this, "render_widget_to_dashboard" ) );
        
        add_filter( 'dash_widget_content', array( $this, "render_dashboard_content" ), 10, 1 ); 
        add_filter( 'dash_widget_content', "do_shortcode" ); //render shortcode data if any
    }

    function render_widget_to_dashboard(){
        //get all published widgets
        $args = array(
            "numberposts" => -1,
            "post_type" => "dash_widget",
            "post_status" => "publish"
        );
        $widgets = get_posts($args);
        if(!empty($widgets)){
            foreach($widgets as $w):
                wp_add_dashboard_widget( 
                    $w->post_name, 
                    $w->post_title, 
                    function() use ($w){
                        echo apply_filters("dash_widget_content", $w->post_content);
                    }
                );
            endforeach;
        }
    }

    function render_dashboard_content($content){
        return html_entity_decode($content) ;
    }

}

new Widget_Render();

endif;