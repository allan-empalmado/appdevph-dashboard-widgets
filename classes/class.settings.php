<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

if( ! class_exists("APPDEVPH_Dashboard_Widgets_Setting") ):

class APPDEVPH_Dashboard_Widgets_Setting {
    
    private $options;

    public function __construct(){
        add_action( 'admin_menu', array( $this, 'dashboard_widget_menu' ) );
        add_action( 'admin_init', array( $this, 'register_dashboard_widget_settings' ) );
    }

    function dashboard_widget_menu(){
        add_menu_page(
            __("Dashboard Widgets"), 
            'Settings', 
            'manage_options',
            'appdevph-dashboard-widget-settings',
            array( $this, 'dashboard_widgets_settings_page') 
         );
    }


    function dashboard_widgets_settings_page(){
        $this->options = get_option( 'appdevph_dashboard_widgets' );
        ?>
        <div class="wrap">
            <h1><?php echo __("AppDevPH Dashboard Widgets"); ?></h1>
            <form method="post" action="options.php">
            <?php
                settings_fields( 'appdevph_dashboard_widgets_group' );
                $this->render_widgets_setting();
                submit_button();
            ?>
            </form>
        </div>
        <?php
    }


    /**
     * Register and add settings
     */
    function register_dashboard_widget_settings(){
        register_setting(
            'appdevph_dashboard_widgets_group',
            'appdevph_dashboard_widgets', 
            array( $this, 'sanitize_fields' ) 
        );
    }


    function render_widgets_setting(){
        echo "<table class='form-table' role='presentation'><tbody>";
        $this->render_single_widget_setting();
        if(!empty($this->options)){
            foreach($this->options as $key => $v):
                $this->render_single_widget_setting($key);
            endforeach;
        }
        echo "</tbody></table>";
    }


    function render_single_widget_setting($widget_id = null){
        $is_new_widget = $widget_id == null;
        $widget_id = $widget_id !== null ?  $widget_id : "widget_" . time();

        printf("<tr><th colspan='2'>%s</th></tr>", $is_new_widget ? __("New Dashboard Widget") : $widget_id );
        printf(
            '<tr><th>Name</th><td><input type="text" id="widget_name"  class="widefat" name="appdevph_dashboard_widgets[%s][widget_name]" value="%s" /></td></tr>',
            $widget_id,
            isset( $this->options[$widget_id]['widget_name'] ) ? esc_attr( $this->options[$widget_id]['widget_name']) : ''
        );

        printf(
            '<tr><th>Content</th><td><textarea id="widget_content" rows="5" class="widefat" name="appdevph_dashboard_widgets[%s][widget_content]" >%s</textarea></td></tr>',
            $widget_id,
            isset( $this->options[$widget_id]['widget_content'] ) ? esc_attr( $this->options[$widget_id]['widget_content']) : ''
        );  
    }


    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize_fields( $input )
    {
        $new_input = array();

        foreach($input as $key => $value){

            if(isset($input[$key]["widget_name"]) && !empty($input[$key]["widget_name"]))
                $new_input[$key]["widget_name"] =  sanitize_text_field( $input[$key]['widget_name'] );


            if(isset($input[$key]["widget_content"]) && !empty($input[$key]["widget_name"]))
                $new_input[$key]["widget_content"] =  sanitize_text_field( $input[$key]['widget_content'] );

        }

        return $new_input;
    }

}

new APPDEVPH_Dashboard_Widgets_Setting();
endif;
