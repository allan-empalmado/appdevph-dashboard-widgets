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
        add_action( 'admin_init', array( $this, 'register_dash_widget_setting' ) );
        add_action('wp_dashboard_setup', array( $this, 'hide_dashboard_widgets') );
    }

    /** Add Settings Page under DashWidget CPT */
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

    /**
     * Register Setting, Setting Section and Setting Fields
     */
    function register_dash_widget_setting(){

        register_setting( 
            'dash_widget_options_group', 
            'dash_widget_setting', 
            array($this, 'sanitize_options_field')
        ); 

        add_settings_section(
            'dash_widget_default_wp_section',
            __( 'Show/Hide wordpress default dashboard widgets' ),
            array($this, 'dash_widget_section_info'),
            'dash-widget-setting-admin'
        );

        add_settings_field(
            'hide_welcome_panel',
            'Hide <b>Welcome Panel</b>?',
            array( $this, 'dashboard_welcome_panel_cb' ),
            'dash-widget-setting-admin',
            'dash_widget_default_wp_section'
        );

        add_settings_field(
            'hide_dashboard_right_now',
            __('Hide Right Now (At a Glance)?'),
            array( $this, 'dashboard_right_now_cb' ),
            'dash-widget-setting-admin',
            'dash_widget_default_wp_section'
        );

        add_settings_field(
            'hide_dashboard_quick_press',
            __('Hide Quick Draft?'),
            array( $this, 'dashboard_quick_press_cb' ),
            'dash-widget-setting-admin',
            'dash_widget_default_wp_section'
        );

        add_settings_field(
            'hide_dashboard_wp_news',
            __('Hide Wordpress News and Events?'),
            array( $this, 'dashboard_wp_news_cb' ),
            'dash-widget-setting-admin',
            'dash_widget_default_wp_section'
        );

        add_settings_field(
            'hide_dashboard_activity',
            __('Hide Activity?'),
            array( $this, 'dashboard_activity_cb' ),
            'dash-widget-setting-admin',
            'dash_widget_default_wp_section'
        );
        
        add_settings_field(
            'hide_dashboard_site_health',
            __('Hide Site Health?'),
            array( $this, 'dashboard_site_health_cb' ),
            'dash-widget-setting-admin',
            'dash_widget_default_wp_section'
        );
    }

    function dash_widget_section_info(){
    }

    /**
     * Settings Checkboxes
     */
    function dashboard_welcome_panel_cb(){
        printf(
			'<input type="checkbox" name="dash_widget_setting[hide_welcome_panel]" id="hide_welcome_panel" value="yes" %s>',
			( isset( $this->options['hide_welcome_panel'] ) && $this->options['hide_welcome_panel'] === 'yes' ) ? 'checked' : ''
		);   
    }

    function dashboard_right_now_cb(){
		printf(
			'<input type="checkbox" name="dash_widget_setting[hide_dashboard_right_now]" id="hide_dashboard_right_now" value="yes" %s>',
			( isset( $this->options['hide_dashboard_right_now'] ) && $this->options['hide_dashboard_right_now'] === 'yes' ) ? 'checked' : ''
		);
    }

    function dashboard_quick_press_cb(){
        printf(
			'<input type="checkbox" name="dash_widget_setting[hide_dashboard_quick_press]" id="hide_dashboard_quick_press" value="yes" %s>',
			( isset( $this->options['hide_dashboard_quick_press'] ) && $this->options['hide_dashboard_quick_press'] === 'yes' ) ? 'checked' : ''
		); 
    }


    function dashboard_wp_news_cb(){
        printf(
			'<input type="checkbox" name="dash_widget_setting[hide_dashboard_wp_news]" id="hide_dashboard_wp_news" value="yes" %s>',
			( isset( $this->options['hide_dashboard_wp_news'] ) && $this->options['hide_dashboard_wp_news'] === 'yes' ) ? 'checked' : ''
		);  
    }

    function dashboard_activity_cb(){
        printf(
			'<input type="checkbox" name="dash_widget_setting[hide_dashboard_activity]" id="hide_dashboard_activity" value="yes" %s>',
			( isset( $this->options['hide_dashboard_activity'] ) && $this->options['hide_dashboard_activity'] === 'yes' ) ? 'checked' : ''
		);    
    }


    function dashboard_site_health_cb(){
        printf(
			'<input type="checkbox" name="dash_widget_setting[hide_dashboard_site_health]" id="hide_dashboard_site_health" value="yes" %s>',
			( isset( $this->options['hide_dashboard_site_health'] ) && $this->options['hide_dashboard_site_health'] === 'yes' ) ? 'checked' : ''
		);    
    }


    /**
     * Sanitize the submitted setting values
     */
    function sanitize_options_field($input){
        $sanitary_values = array();
      
        if ( isset( $input['hide_welcome_panel'] ) ) {
			$sanitary_values['hide_welcome_panel'] = $input['hide_welcome_panel'];
        }

		if ( isset( $input['hide_dashboard_right_now'] ) ) {
			$sanitary_values['hide_dashboard_right_now'] = $input['hide_dashboard_right_now'];
        }

        if ( isset( $input['hide_dashboard_quick_press'] ) ) {
			$sanitary_values['hide_dashboard_quick_press'] = $input['hide_dashboard_quick_press'];
        }
        
        if ( isset( $input['hide_dashboard_wp_news'] ) ) {
			$sanitary_values['hide_dashboard_wp_news'] = $input['hide_dashboard_wp_news'];
        }    

        if ( isset( $input['hide_dashboard_activity'] ) ) {
			$sanitary_values['hide_dashboard_activity'] = $input['hide_dashboard_activity'];
        }    

        if ( isset( $input['hide_dashboard_site_health'] ) ) {
			$sanitary_values['hide_dashboard_site_health'] = $input['hide_dashboard_site_health'];
        }    

        
		return $sanitary_values;
    }

    /**
     * Hide the Default Dashboard Widgets
     */
    function hide_dashboard_widgets(){
        global $wp_meta_boxes;

        $this->options = get_option( 'dash_widget_setting' );

        //ok
        if ( isset( $this->options["hide_welcome_panel"] ) && $this->options["hide_welcome_panel"] === "yes" ) {
           remove_action( 'welcome_panel', 'wp_welcome_panel' );
        }

        //ok
        if ( isset( $this->options["hide_dashboard_right_now"] ) && $this->options["hide_dashboard_right_now"] === "yes" ) {
            remove_meta_box('dashboard_right_now', 'dashboard', 'normal');
        }

        //ok
        if ( isset( $this->options["hide_dashboard_quick_press"] ) && $this->options["hide_dashboard_quick_press"] === "yes" ) {
            remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
        }

        //ok
        if ( isset( $this->options["hide_dashboard_wp_news"] ) &&  $this->options["hide_dashboard_wp_news"] === "yes" ) {
            remove_meta_box('dashboard_primary', 'dashboard', 'side');
        }

        //ok
        if ( isset( $this->options["hide_dashboard_activity"] ) &&  $this->options["hide_dashboard_activity"] === "yes" ) {
            remove_meta_box('dashboard_activity', 'dashboard', 'normal');
        }

        //ok
        if ( isset( $this->options["hide_dashboard_site_health"] ) &&  $this->options["hide_dashboard_site_health"] === "yes" ) {
            remove_meta_box('dashboard_site_health', 'dashboard', 'normal');
        }

    }

    /**
     * Render Dash Widget Settings Page
     */
    function dash_widget_settings_page(){
        $this->options = get_option( 'dash_widget_setting' );
        ?>
		<div class="wrap">
			<h2><?php echo __("AppDevPH Dash Widget Settings"); ?></h2>
			<p></p>
			<?php settings_errors(); ?>
			<form method="post" action="options.php">
				<?php
					settings_fields( 'dash_widget_options_group' );
					do_settings_sections( 'dash-widget-setting-admin' );
					submit_button();
				?>
			</form>
		</div>
        <?php
    }

}

new Settings();
endif;
