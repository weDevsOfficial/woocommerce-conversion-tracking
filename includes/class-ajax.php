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

        if ( ! isset( $_POST['settings'] ) ) {
            wp_send_json_error();
        }

        $integration_settings = array();

        foreach ( $_POST['settings'] as $field_id => $settings ) {
            $is_enabled = isset( $settings['enabled'] ) ? true : false;

            $settings = array_merge( $settings, array( 'enabled' => $is_enabled ) );
            $integration_settings[ $field_id ] = $settings;
        }

        $integration_settings = apply_filters( 'wcct_save_integrations_settings', $integration_settings );
        update_option( 'wcct_settings', stripslashes_deep( $integration_settings ) );
        wp_send_json_success( array(
            'message' => __( 'Settings has been saved successfully!', 'woocommerce-conversion-tracking' )
        ) );

    }
}
