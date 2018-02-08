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
        wp_enqueue_style( 'style', plugins_url( 'assets/css/style.css', WCCT_FILE ), false, date( 'Ymd' ) );

        /**
         * All script goes here
         */
        wp_enqueue_script( 'wcct-admin', plugins_url( 'assets/js/admin.js', WCCT_FILE ), array( 'jquery', 'wp-util' ), false, time() );

        wp_localize_script(
            'wcct-admin', 'wc_tracking', array(
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
        add_submenu_page( 'woocommerce', __( 'Conversion Tracking', 'woocommerce-conversion-tracking' ), __( 'Conversion Tracking', 'woocommerce-conversion-tracking' ), 'manage_options', 'conversion-tracking', array( $this, 'conversion_tracking_template' ) );
    }

    /**
     * Conversion Tracking View Page
     *
     * @return void
     */
    public function conversion_tracking_template() {
        $integrations = wcct_init()->manager->get_integrations();

        include dirname( __FILE__ ) . '/views/admin.php';
    }

    /**
     * Get navigation tab
     *
     * @return array
     */
    public function wcct_get_tab() {

        $sections   = array(
            array(
                'id'    => 'settings',
                'title' => __( 'Settings', 'woocommerce-conversion-tracking' ),
            ),
        );

        return apply_filters( 'wcct_nav_tab', $sections );
    }

    /**
     * Show navigation
     *
     * @return void
     */
    public function show_navigation() {
        $html = '<h2 class="nav-tab-wrapper">';

        $count  = count( $this->wcct_get_tab() );
        $tabs   = $this->wcct_get_tab();
        $active = isset( $_GET['tab'] ) ? $_GET['tab'] : 'settings';

        if ( $count == 0 ) {
            return;
        }

        foreach ( $tabs as $tab ) {
            $active_class   = ( $tab['id'] == $active ) ? 'nav-tab-active' : '';
            $html  .= sprintf( '<a href="admin.php?page=conversion-tracking&tab=%s" class="nav-tab %s">%s</a>', $tab['id'], $active_class, $tab['title'] );
        }

        $html   .= '<h2/>';

        echo $html;
    }
}
