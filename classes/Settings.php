<?php
namespace ADEVPH\DashWidget\Classes;

if ( ! defined( 'WPINC' ) ) {
	die;
}

if( ! class_exists("Settings") ):

class Settings {
    
    private $options;

    public function __construct(){
        add_action( 'admin_menu', array( $this, 'dashboard_widget_menu' ) );
    }

    /** Add Settings Page */
    function dashboard_widget_menu(){
        add_submenu_page(
            'edit.php?post_type=dash_widget',
            __( 'Settings', 'menu-test' ),
            __( 'Settings', 'menu-test' ),
            'manage_options',
            'dash_widget_setting',
            array($this, 'dash_widget_settings_page')
        );
    }


    function dash_widget_settings_page(){
        $this->options = get_option( 'adp_dash_widgets' );
        var_dump($this->options);
    }


}

new Settings();
endif;
