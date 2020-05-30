<?php
namespace ADEVPH\DashWidget\Classes;

if ( ! defined( 'WPINC' ) ) {
	die;
}

if( ! class_exists("Widget_CPT") ):

class Widget_CPT {

    public function __construct(){
        add_action( 'init', array( $this, 'create_dash_widget_cpt' ), 0 );
    }

    function create_dash_widget_cpt(){
        $labels = array(
            'name'                => __( 'Dash Widgets' ),
            'singular_name'       => __( 'Dash Widget' ),
            'menu_name'           => __( 'Dash Widgets' ),
            'parent_item_colon'   => __( 'Parent Dash Widget' ),
            'all_items'           => __( 'All Dash Widgets' ),
            'view_item'           => __( 'View Dash Widget' ),
            'add_new_item'        => __( 'Add New Dash Widget' ),
            'add_new'             => __( 'Add New Dash Widget' ),
            'edit_item'           => __( 'Edit Dash Widget' ),
            'update_item'         => __( 'Update Dash Widget' ),
            'search_items'        => __( 'Search Dash Widget' ),
            'not_found'           => __( 'Not Found' ),
            'not_found_in_trash'  => __( 'Not found in Trash' )
        );

        register_post_type( 'dash_widget',
            array(
                'label'                 => __("dash widgets"),
                'supports'              => array( 'title', 'editor' ),
                'labels'                => $labels,
                'public'                => true,
                'hierarchical'          => false,
                'has_archive'           => false,
                'rewrite'               => array('slug' => 'dash-widgets'),
                'show_in_rest'          => false,
                'exclude_from_search'   => false,
                'publicly_queryable'    => false,
                'show_in_nav_menus'     => false,
                'show_in_admin_bar'     => true     
            )
        );
    }
}

new Widget_CPT();
endif;