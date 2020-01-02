<?php

/**
 * Ajax handler class
 */
class WCCT_Ajax {

    /**
     * WC Conversion Tracking Ajax Class Constructor
     */
    public function __construct() {
        add_action( 'wp_ajax_wcct_save_settings', array( $this, 'wcct_save_settings' ) );
        add_action( 'wp_ajax_activate_happy_addons', array( $this, 'wcct_install_happy_addons' ) );
        add_action( 'wp_ajax_wcct_dismissable_notice', array( $this, 'wcct_dismissable_notice' ) );
    }

    /**
     * Save integration settings
     *
     * @return void
     */
    public function wcct_save_settings() {
        if ( ! current_user_can( wcct_manage_cap() ) ) {
            return;
        }
        $nonce = isset( $_REQUEST['_wpnonce'] ) ? sanitize_key( wp_unslash( $_REQUEST['_wpnonce'] ) ) : '';

        if ( ! wp_verify_nonce( $nonce, 'wcct-settings' ) ) {
            die( 'wcct-settings !' );
        }

        if ( ! isset( $_POST['settings'] ) ) {
            wp_send_json_error();
        }

        $integration_settings = array();
        // $post_data = isset( $_POST['settings'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['settings'] ) ) : [];

        if ( ! empty( $_POST['settings'] ) ) {

            foreach ( $_POST['settings'] as $field_id => $settings ) {
                $is_enabled = isset( $settings['enabled'] ) ? true : false;

                $settings = array_merge( $settings, array( 'enabled' => $is_enabled ) );
                $integration_settings[ $field_id ] = $settings;
            }
        }


        $integration_settings = apply_filters( 'wcct_save_integrations_settings', $integration_settings );
        update_option( 'wcct_settings', stripslashes_deep( $integration_settings ) );
        wp_send_json_success( array(
            'message' => __( 'Settings has been saved successfully!', 'woocommerce-conversion-tracking' )
        ) );

    }
    /**
     * Install the Happy addons via ajax
     *
     * @return json
     */
    public function wcct_install_happy_addons() {

        include_once ABSPATH . 'wp-admin/includes/plugin-install.php';
        include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';

        $upgrader = new Plugin_Upgrader( new WP_Ajax_Upgrader_Skin() );

        $plugin = 'happy-elementor-addons';
        $api    = plugins_api( 'plugin_information', array( 'slug' => $plugin, 'fields' => array( 'sections' => false ) ) );


        if (is_wp_error($api)) {
            die(sprintf(__('ERROR: Error fetching plugin information: %s', 'woocommerce-conversion-tracking'), esc_attr( $api->get_error_message() )));
        }

        add_filter( 'upgrader_package_options', function ( $options ) {
            $options['clear_destination'] = true;
            $options['hook_extra'] = [
                'type' => 'plugin',
                'action' => 'install',
                'plugin'  => 'happy-elementor-addons/plugin.php',
            ];
            return  $options;
        });

        $result   = $upgrader->install( $api->download_link );

        if ( is_wp_error( $result ) ) {
            wp_send_json_error( $result );
        }

        $result = activate_plugin( 'happy-elementor-addons/plugin.php' );

        if ( is_wp_error( $result ) ) {
            wp_send_json_error( $result );
        }
        wp_send_json_success([
            'message' => __( 'Successfully installed and activate,', 'woocommerce-conversion-tracking' )
        ]);
    }

    /**
     * Dismissable notice
     *
     * @return object
     */
    public function wcct_dismissable_notice() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        update_option( 'wcct_dismissable_notice', 'closed' );

        wp_send_json_success();
    }
}
