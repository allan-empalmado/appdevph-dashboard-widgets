<?php
/**
 * Plugin Name:       AppDevPH Dashboard Widgets
 * Plugin URI:        https://github.com/allan-empalmado/appdevph-dashboard-widgets
 * Description:       Create custom dashboard widgets. Enable/Disable dashboard widgets/
 * Author:            Allan Ramirez Empalmado
 * Version:           1.0.0
 * Author URI:        https://appdevph.com
 * GitHub Plugin URI: https://github.com/allan-empalmado/appdevph-dashboard-widgets
 * License:           GNU General Public License v2
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

if( ! class_exists("ADEVPH_Dashboard_Widgets") ):

class ADEVPH_Dashboard_Widgets {

    public function __construct(){
        add_action('wp_dashboard_setup', array($this, 'render_dashboard_widgets') );
        add_shortcode("adevph_test", array( $this, "render_test_shortcode") );
    }

    function render_test_shortcode(){
        echo "This is a test shorcode output";
    }

    //https://wordpress.stackexchange.com/questions/340814/get-list-of-shortcodes-from-content
    function get_used_shortcodes( $content) {
        global $shortcode_tags;
        if ( false === strpos( $content, '[' ) ) {
            return array();
        }
        if ( empty( $shortcode_tags ) || ! is_array( $shortcode_tags ) ) {
            return array();
        }
        // Find all registered tag names in $content.
        preg_match_all( '@\[([^<>&/\[\]\x00-\x20=]++)@', $content, $matches );
        $tagnames = array_intersect( array_keys( $shortcode_tags ), $matches[1] );
        return $tagnames;
    }


    function render_dashboard_widgets(){
        global $wp_meta_boxes;
        $this->options = get_option("appdevph_dashboard_widgets");
        if(!empty($this->options)){
          foreach($this->options as $key => $value):

                //TODO :: check if has shortcode and process the output
                wp_add_dashboard_widget( 
                    $key, 
                    $value["widget_name"], 
                    function() use ($value){
                        $content = $value["widget_content"];
                        $shortcodes = $this->get_used_shortcodes($content);
                        var_dump($shortcodes);
                        if(!empty($shortcodes)){
                            foreach($shortcodes as $sc){
                                echo $sc;
                            }
                        }else{
                            echo esc_attr($value["widget_content"]);
                        }
                    }
                );
            endforeach;
        }
    }
}

require_once("classes/class.settings.php");

new ADEVPH_Dashboard_Widgets();
endif;