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
	}

	public function enqueue_script() {

		wp_enqueue_script( 'sweetalert', 'https://unpkg.com/sweetalert/dist/sweetalert.min.js', array(), false, false );

	}

	/**
	 * Displaying facebook pro-features
	 *
	 * @param  array $settings
	 * @return array
	 */
	public function facebook_pro_features( $settings ) {

		$settings['events']['options']['ViewContent-pro'] = array(
            'label'             => __( 'View Product', 'woocommerce-conversion-tracking' ),
            'profeature'		=> true,
        );

        $settings['events']['options']['ViewCategory-pro'] = array(
            'label'             => __( 'View Product Category', 'woocommerce-conversion-tracking' ),
            'profeature'		=> true,
        );

        $settings['events']['options']['Search-pro'] = array(
            'label'             => __( 'Search', 'woocommerce-conversion-tracking' ),
            'profeature'		=> true,
        );

        $settings['events']['options']['AddToWishlist-pro'] = array(
            'label'             => __( 'Add To Wishlist', 'woocommerce-conversion-tracking' ),
            'profeature'		=> true,
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
            'label'             => __( 'Add to Cart ', 'woocommerce-conversion-tracking' ),
            'profeature'		=> true,
        );

        $settings['events']['options']['CompleteRegistration-pro'] = array(
            'label'             => __( 'Complete Registration', 'woocommerce-conversion-tracking' ),
            'profeature'		=> true,
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
            'label'             => __( 'Complete Registration', 'woocommerce-conversion-tracking' ),
            'profeature'		=> true,
        );

        return $settings;
	}
}