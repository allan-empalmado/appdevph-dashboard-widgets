<?php
namespace ADEVPH\DashWidget\Classes;

if ( ! defined( 'WPINC' ) ) {
	die;
}

if( ! class_exists("Metabox") ):

class Metabox {
    public function __construct(){
        add_action( "admin_init", array( $this, "register_dash_widget_metabox") );
        add_action( "save_post", array( $this, "save_user_role_metabox") );
    }


    function register_dash_widget_metabox(){
        add_meta_box('user_role_metabox',
            __('Choose User Role'),
            array($this, 'render_user_role_meta_box'),
            'dash_widget', 'side', 'default' //normal high
        );
    }

    function render_user_role_meta_box($post){
        $data = get_post_meta($post->ID, '_user_role', true);
        wp_nonce_field('add_user_role_meta', '_nonce_field_user_role');
        global $wp_roles;
        $roles = $wp_roles->roles;
        ?>
        <div class="inside">
            <div class='info'><?php echo __("This dashboard widget will be shown to the selected user role(s)"); ?></div>
            <table class="form-table">
                <tr valign="top">
                    <td>
                    <?php
                    if(!empty($roles)):
                        foreach($roles as $key => $role):
                            $checked = !empty($data) && in_array($key, $data) ? "checked='checked'" : "";
                            printf("<label style='display:block;'><input type='checkbox'name='user_role[]' value='%s' %s>%s</label>",
                                $key, $checked, $role["name"]
                            );
                        endforeach;
                    endif;
                    ?>
                    </td>
                </tr>
            </table>
        </div>
        <?php
    }


    /** Saves which user can view the current metabox */
    function save_user_role_metabox($post_id){

        //Chck if our nonce is set.
        if ( ! isset( $_POST['_nonce_field_user_role'] ) ) {
            return;
        }

        // Verify that the nonce is valid.
        if ( ! wp_verify_nonce( $_POST['_nonce_field_user_role'], 'add_user_role_meta' ) ) {
            return;
        }

        // If this is an autosave, our form has not been submitted, so we don't want to do anything.
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if ( ! isset( $_POST['user_role'] ) || empty($_POST["user_role"]) ) {
            return;
        }

        if( is_array($_POST["user_role"]) ){
            $user_roles = array_values(array_map("sanitize_text_field", $_POST["user_role"]));
        }

        // Update the meta field in the database.
        update_post_meta( $post_id, '_user_role', $user_roles );
    }
}

new Metabox();
endif;