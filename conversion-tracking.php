<?php
/*
Plugin Name: WooCommerce Conversion Tracking
Plugin URI: https://wedevs.com/products/plugins/woocommerce-conversion-tracking/
Description: Adds various conversion tracking codes to cart, checkout, registration success and product page on WooCommerce
Version: 1.2
Author: Tareq Hasan
Author URI: https://tareq.co/
License: GPL2
*/

/**
 * Copyright (c) 2016 Tareq Hasan (email: tareq@wedevs.com). All rights reserved.
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
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * WeDevs_WC_Facebook_Tracking_Pixel class
 *
 * @class WeDevs_WC_Facebook_Tracking_Pixel The class that holds the entire WeDevs_WC_Facebook_Tracking_Pixel plugin
 */
class WeDevs_WC_Conversion_Tracking {

    /**
     * Constructor for the WeDevs_WC_Conversion_Tracking class
     *
     * Sets up all the appropriate hooks and actions
     * within our plugin.
     *
     * @uses add_action()
     * @uses add_filter()
     */
    public function __construct() {

        // Localize our plugin
        add_action( 'init', array($this, 'localization_setup') );

        // register integration
        add_filter( 'woocommerce_integrations', array($this, 'register_integration') );
    }

    /**
     * Initializes the WeDevs_WC_Conversion_Tracking() class
     *
     * Checks for an existing WeDevs_WC_Conversion_Tracking() instance
     * and if it doesn't find one, creates it.
     */
    public static function init() {
        static $instance = false;

        if ( !$instance ) {
            $instance = new WeDevs_WC_Conversion_Tracking();
        }

        return $instance;
    }

    /**
     * Initialize plugin for localization
     *
     * @uses load_plugin_textdomain()
     */
    public function localization_setup() {
        load_plugin_textdomain( 'wc-conversion-tracking', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    }

    /**
     * Register integration
     *
     * @param array $interations
     * @return array
     */
    function register_integration( $interations ) {

        include dirname( __FILE__ ) . '/includes/integration.php';

        $interations[] = 'WeDevs_WC_Tracking_Integration';

        return $interations;
    }

}

// WeDevs_WC_Conversion_Tracking

$wc_tracking = WeDevs_WC_Conversion_Tracking::init();
