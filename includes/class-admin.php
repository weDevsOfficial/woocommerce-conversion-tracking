<?php

/**
 * The admin page handler class
 */
class WCCT_Admin {

    /**
     * Constructor for WCCT_Admin class
     */
    function __construct() {
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
        add_action( 'admin_menu', array( $this, 'admin_menu_page' ) );
    }

    /**
     * Enqueue Script
     *
     * @return void
     */
    public function enqueue_scripts() {
        /**
         * All style goes here
         */
        wp_enqueue_style( 'style', plugins_url( '../assets/css/style.css', __FILE__ ), false, date( 'Ymd' ) );
        /**
         * All script goes here
         */
        wp_enqueue_script( 'wc-tracking-script', plugins_url( '../assets/js/script.js', __FILE__ ), array( 'jquery', 'wp-util' ), false, time() );

        wp_localize_script(
            'wc-tracking-script', 'wc_tracking', array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
            )
        );
    }

    /**
     * Add menu page
     *
     * @return void
     */
    public function admin_menu_page() {
        add_submenu_page( 'woocommerce', __( 'Conversion Tracking', 'wcct' ), __( 'Conversion Tracking', 'wcct' ), 'manage_options', 'conversion-tracking', array( $this, 'conversion_tracking_template' ) );
    }

    /**
     * Conversion Tracking View Page
     *
     * @return void
     */
    public function conversion_tracking_template() {
        $manager      = new WCCT_Integration_Manager();
        $integrations = $manager->get_integrations();

        include dirname( __FILE__ ) . '/views/admin.php';
    }
}
