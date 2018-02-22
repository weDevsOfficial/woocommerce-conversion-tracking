<?php

/**
 * The welcome class after install
 *
 * @since 1.1.0
 */
class WCCT_Welcome_20 {

    function __construct() {
        add_action( 'admin_init', array( $this, 'redirect_to_page' ), 9999 );
        add_action( 'wcct_before_nav', array( $this, 'show_notice' ) );

        add_action( 'wp_ajax_wcct_dismiss_notice', array( $this, 'dismiss_notice' ) );
    }

    /**
     * Redirect to the welcome page once the plugin is installed
     *
     * @return void
     */
    public function redirect_to_page() {
        if ( ! get_transient( 'wcct_upgrade_to_20' ) ) {
            return;
        }

        delete_transient( 'wcct_upgrade_to_20' );

        // Only do this for single site installs.
        if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
            return;
        }

        wp_safe_redirect( admin_url( 'admin.php?page=conversion-tracking&notice=welcome' ) );
        exit;
    }

    /**
     * Dismiss notice
     *
     * @return void
     */
    public function dismiss_notice() {
        update_option( '_wcct_20_notice_dismiss', true );
        wp_send_json_success();
    }

    /**
     * Show welcome notice to 2.0
     *
     * @return void
     */
    public function show_notice() {
        $dismissed = get_option( '_wcct_20_notice_dismiss', false );

        if ( ! $dismissed ) {
            include WCCT_INCLUDES . '/views/welcome-20.php';
        }
    }
}
