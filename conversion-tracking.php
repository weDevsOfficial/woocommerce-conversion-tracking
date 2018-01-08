<?php
/*
Plugin Name: WooCommerce Conversion Tracking
Plugin URI: https://wedevs.com/products/plugins/woocommerce-conversion-tracking/
Description: Adds various conversion tracking codes to cart, checkout, registration success and product page on WooCommerce
Version: 1.2.5
Author: Tareq Hasan
Author URI: https://tareq.co/
License: GPL2
WC requires at least: 2.3
WC tested up to: 3.2.6
*/

/**
 * Copyright (c) 2017 Tareq Hasan (email: tareq@wedevs.com). All rights reserved.
 *
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 *
 * This is an add-on for WordPress
 * http://wordpress.org/
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 * **********************************************************************
 */

// don't call the file directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WeDevs_WC_Facebook_Tracking_Pixel class
 *
 * @class WeDevs_WC_Facebook_Tracking_Pixel The class that holds the entire WeDevs_WC_Facebook_Tracking_Pixel plugin
 */
class WeDevs_WC_Conversion_Tracking {

    /**
     * Plugin version
     *
     * @var string
     */
    public $version = '1.2.5';

    /**
     * Constructor for the WeDevs_WC_Conversion_Tracking class
     *
     * Sets up all the appropriate hooks and actions
     * within our plugin.
     */
    public function __construct() {
        $this->define_constants();
        $this->init_hooks();
        $this->includes();
        $this->init_classes();

        register_activation_hook( __FILE__, array( $this, 'activate' ) );

        do_action( 'wcct_loaded' );
    }

    /**
     * Initializes the WeDevs_WC_Conversion_Tracking() class
     *
     * Checks for an existing WeDevs_WC_Conversion_Tracking() instance
     * and if it doesn't find one, creates it.
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new WeDevs_WC_Conversion_Tracking();
        }

        return $instance;
    }

    /**
     * Include required files
     *
     * @return void
     */
    public function includes() {
        require_once WCCT_INCLUDES . '/class-abstract-integration.php';
        require_once WCCT_INCLUDES . '/class-integration-manager.php';
        require_once WCCT_INCLUDES . '/class-event-dispatcher.php';
        require_once WCCT_INCLUDES . '/class-ajax.php';
        require_once WCCT_INCLUDES . '/class-admin.php';
    }

    /**
     * Define the constants
     *
     * @since 1.2.5
     *
     * @return void
     */
    public function define_constants() {
        define( 'WCCT_VERSION', $this->version );
        define( 'WCCT_FILE', __FILE__ );
        define( 'WCCT_PATH', dirname( WCCT_FILE ) );
        define( 'WCCT_INCLUDES', WCCT_PATH . '/includes' );
        define( 'WCCT_URL', plugins_url( '', WCCT_FILE ) );
        define( 'WCCT_ASSETS', WCCT_URL . '/assets' );
    }

    /**
     * Plugin activation routeis
     *
     * @since 1.2.5
     *
     * @return void
     */
    public function activate() {
        $installed = get_option( 'wcct_installed' );

        if ( ! $installed ) {
            update_option( 'wcct_installed', time() );
        }

        update_option( 'wcct_version', WCCT_VERSION );
    }

    /**
     * Initialize the hooks
     *
     * @return void
     */
    public function init_hooks() {

        // Localize our plugin
        add_action( 'init', array( $this, 'localization_setup' ) );
        add_action( 'init', array( $this, 'init_tracker' ) );

        add_action( 'admin_notices', array( $this, 'display_survey' ) );
        add_action( 'wp_ajax_wcv_dismiss_survey', array( $this, 'dismiss_survey' ) );

        // register integration
        // add_filter( 'woocommerce_integrations', array( $this, 'register_integration' ) );

        add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'plugin_action_links' ) );
    }

    /**
     * Instantiate the required classes
     *
     * @return void
     */
    public function init_classes() {
        new WCCT_Ajax();
        new WCCT_Event_Dispatcher();
        new WCCT_Admin();
    }

    /**
     * Initialize plugin for localization
     *
     * @uses load_plugin_textdomain()
     */
    public function localization_setup() {
        load_plugin_textdomain( 'woocommerce-conversion-tracking', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    }

    /**
     * Initialize the weDevs insights tracker
     *
     * @since 1.2.3
     *
     * @return void
     */
    public function init_tracker() {
        require_once dirname( __FILE__ ) . '/includes/class-wedevs-insights.php';

        new WeDevs_Insights( 'woocommerce-conversion-tracking', 'WooCommerce Conversion Tracking', __FILE__ );
    }

    /**
     * Register integration
     *
     * @param array $interations
     *
     * @return array
     */
    function register_integration( $interations ) {

        include dirname( __FILE__ ) . '/includes/integration.php';

        $interations[] = 'WeDevs_WC_Tracking_Integration';

        return $interations;
    }

    /**
     * Dismiss the survey notice
     *
     * @return void
     */
    public function dismiss_survey() {
        update_option( 'wcv_dismiss_survey', 'yes' );
        wp_send_json_success();
    }

    /**
     * Is survey dimissed
     *
     * @return boolean
     */
    public function survey_dimissed() {
        return get_option( 'wcv_dismiss_survey', 'no' ) == 'yes';
    }

    /**
     * Display Survey Notice
     *
     * @return void
     */
    public function display_survey() {

        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        if ( $this->survey_dimissed() ) {
            return;
        }
        ?>
        <div class="notice notice-success wct-survey-notice">
            <div class="wct-notice-title">
                <p><strong>WooCommerce Conversion Tracking Survey</strong></p>

                <p>Hey there, thanks for using WooCommerce Conversion Tracking. I would love to have your feedback.</p>

                <p>
                    To make the tracking better, I want to bring deep integrations to various services (e.g. Facebook, Twitter) to track conversions. So therefore I need to know which service you use and will implement the integrations of most used services first.
                </p>

                <div class="wct-avatar-wrap">
                    <div class="wct-avatar">
                        <img src="http://2.gravatar.com/avatar/8584491809f902b86fae495a5830be83?s=128&d=mm&r=g" alt="Avatar of Tareq Hasan">
                    </div>
                    <div class="wct-user-details">
                        Regards,<br>
                        <strong>Tareq Hasan</strong><br>
                        Developer
                    </div>
                </div>
            </div>

            <div class="wct-notice-actions">
                <a href="http://tareq.in/yn77Th" target="_blank" class="button button-primary">Take the Survey</a>
                <button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php _e( 'Dismiss this notice.' ); ?></span></button>
            </div>
        </div>

        <style>
            .wct-survey-notice {
                display: flex;
                position: relative;
            }

            .wct-survey-notice .wct-notice-title {
                width: calc(100% - 200px);
            }

            .wct-survey-notice .wct-notice-actions {
                width: 200px;
                text-align: right;
                padding-right: 25px;
                padding-top: 70px;
            }

            .wct-avatar-wrap {
                display: flex;
                margin: .5em 0;
                padding: 2px;
            }

            .wct-avatar {
                width: 52px;
                height: 52px;
                margin-right: 15px;
                margin-top: 5px;
            }

            .wct-user-details {
                width: calc(100% - 100px);
            }

            .wct-avatar img {
                background: #888;
                border-radius: 50%;
                height: 100%;
                width: 100%;
            }
        </style>

        <script type="text/javascript">
            jQuery(function($) {
                $('.wct-survey-notice').on('click', 'button', function(event) {
                    event.preventDefault();

                    wp.ajax.send('wcv_dismiss_survey');

                    $(this).closest('.notice').slideUp(function() {
                        $(this).remove();
                    });
                });
            });
        </script>
        <?php
    }

    /**
     * Plugin action links
     *
     * @param  array $links
     *
     * @return array
     */
    function plugin_action_links( $links ) {

        $links[] = '<a href="https://wordpress.org/plugins/woocommerce-conversion-tracking/#installation" target="_blank">' . __( 'Installation', 'woocommerce-conversion-tracking' ) . '</a>';
        $links[] = '<a href="' . admin_url( 'admin.php?page=wc-settings&tab=integration&section=wc_conv_tracking' ) . '">' . __( 'Settings', 'woocommerce-conversion-tracking' ) . '</a>';

        return $links;
    }
}

// WeDevs_WC_Conversion_Tracking
$wc_tracking = WeDevs_WC_Conversion_Tracking::init();
