<?php

/**
 * WCCT_Pro_Features Class
 */
class WCCT_Pro_Features {

    /**
     * Constructor for the profeatures class
     */
    function __construct() {
        add_filter( 'wcct_settings_fb', array( $this, 'facebook_pro_features' ), 10, 1 );
        add_filter( 'wcct_settings_twitter', array( $this, 'twitter_pro_features' ), 10, 1 );
        add_filter( 'wcct_settings_adwords', array( $this, 'adwords_pro_features' ), 10, 1 );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_script' ) );

        add_filter( 'wcct_nav_tab', array( $this, 'pro_tabs' ) );

        add_action( 'wcct_sidebar', array( $this, 'profeature_ad' ) );
    }

    public function enqueue_script() {

        wp_enqueue_script( 'sweetalert', plugins_url( 'assets/js/sweetalert.min.js', WCCT_FILE ), array(), false, false );

    }

    /**
     * Add facebook product catalog tab
     *
     * @param  array $sections
     *
     * @return array
     */
    public function pro_tabs( $sections ) {

        $sections[] = array(
            'id'    => '',
            'title' => __( 'Facebook Product Catalog (Pro)', 'woocommerce-conversion-tracking' ),
        );

        $sections[] = array(
            'id'    => '',
            'title' => __( 'Settings (Pro)', 'woocommerce-conversion-tracking' ),
        );

        return $sections;
    }

    /**
     * Displaying facebook pro-features
     *
     * @param  array $settings
     * @return array
     */
    public function facebook_pro_features( $settings ) {

        $settings['events']['options']['ViewContent-pro'] = array(
            'label'         => __( 'View Product', 'woocommerce-conversion-tracking' ),
            'profeature'    => true,
        );

        $settings['events']['options']['ViewCategory-pro'] = array(
            'label'         => __( 'View Product Category', 'woocommerce-conversion-tracking' ),
            'profeature'    => true,
        );

        $settings['events']['options']['Search-pro'] = array(
            'label'         => __( 'Search', 'woocommerce-conversion-tracking' ),
            'profeature'    => true,
        );

        $settings['events']['options']['AddToWishlist-pro'] = array(
            'label'         => __( 'Add To Wishlist', 'woocommerce-conversion-tracking' ),
            'profeature'    => true,
        );

        return $settings;
    }

    /**
     * Displaying twitter pro-features
     *
     * @param  array $settings
     * @return array
     */
    public function twitter_pro_features( $settings ) {

        $settings['events']['options']['AddToCart-pro'] = array(
            'label'         => __( 'Add to Cart ', 'woocommerce-conversion-tracking' ),
            'profeature'    => true,
        );

        $settings['events']['options']['CompleteRegistration-pro'] = array(
            'label'         => __( 'Complete Registration', 'woocommerce-conversion-tracking' ),
            'profeature'    => true,
        );

        return $settings;
    }

    /**
     * Displaying adwords pro-features
     *
     * @param  array $settings
     * @return array
     */
    public function adwords_pro_features( $settings ) {

        $settings['events']['options']['CompleteRegistration-pro'] = array(
            'label'         => __( 'Complete Registration', 'woocommerce-conversion-tracking' ),
            'profeature'    => true,
        );

        return $settings;
    }

    /**
     * Show profeature
     *
     * @return void
     */
    public function profeature_ad() {
        ?>
        <div class="premium-box box-blue">
            <h3><?php _e( 'Premium Features', 'woocommerce-conversion-tracking' ) ?></h3>

            <ul class="premium-feature-list">
                <li>Advanced Facebook Events and Tracking</li>
                <li>Facebook <strong>Product Catalog</strong></li>
                <li><mark><strong>Multiple</strong> Facebook Pixels</mark></li>
                <li>Advanced Google Adwords Events</li>
                <li>Advanced Twitter Events</li>
                <li>Perfect Audience Integration</li>
            </ul>

            <a href="https://wedevs.com/woocommerce-conversion-tracking/upgrade-to-pro/?utm_source=wp-admin&utm_medium=pro-upgrade&utm_campaign=wcct_upgrade&utm_content=Get_Premium" target="_blank" class="button button-primary"><?php _e( 'Get Premium', 'woocommerce-conversion-tracking' ) ?></a>

            <p style="margin-bottom: 0" class="help">
                Get <strong>50% Discount</strong> on pro upgrade for a limited time.
            </p>
        </div>
        <?php
    }
}