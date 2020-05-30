<?php
namespace ADEVPH\DashWidget\Classes;

if ( ! defined( 'WPINC' ) ) {
	die;
}

if( ! class_exists("Shortcode") ):

class Shortcode {
    
    public function __construct(){
        add_shortcode("widget_sc_post", array ( $this, "render_post_shortcode" ) );
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


    function render_post_shortcode($atts){
        $atts = shortcode_atts( array(
            'type'      => 'post',
            'orderby'   => 'post_title',
            "order"     => "DESC",
            "limit"     => "5",
            "fields"    => "ID|post_title|post_date"
        ), $atts );

        $args = array(
            "post_type"     => $atts["type"],
            "orderby"       => $atts["orderby"],
            "order"         => $atts["order"],
            "numberposts"   => $atts["limit"]
        );

        $posts = get_posts($args);
        $output = "";
        if(!empty($posts)):
            $output .= "<table class='widefat'><tbody>";
            foreach($posts as $post):

                $fields = explode("|",$atts["fields"]);
                if(!empty($fields)):
                    $tds = "";
                    foreach($fields as $field):
                        if(isset($post->$field)):
                            $tds .= sprintf("<td>%s</td>", $post->$field);
                        endif;
                    endforeach;
                    $tds .= sprintf("<td><a href='%s' target='_blank'>%s</a></td>", get_permalink($post->ID), __("View"));
                    $output .= "<tr>{$tds}</tr>";
                //empty field provided we'll use the default ID|post_title|post_date
                else:
                    $link = sprintf("<a href='%s' target='_blank'>%s</a>", get_permalink($post->ID), __("View"));
                    $output .= sprintf("<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>", $post->ID, $post->post_title, $post->post_date, $link);
                endif;
            endforeach;
            $output .= "</tbody></table>";
        else:
           $output .= sprintf("<p>%s</p>", __("No items to display..."));
        endif;

        return $output;
    }

} 

new Shortcode();
endif;