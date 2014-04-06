<?php

/**
 * Conversion tracking integration class
 *
 * @author Tareq Hasan
 */
class WeDevs_WC_Tracking_Integration extends WC_Integration {

    function __construct() {

        $this->id = 'wc_conv_tracking';
        $this->method_title = __( 'Conversion Tracking Pixel', 'wc-conversion-tracking' );
        $this->method_description = __( 'Various conversion tracking pixel integration like Facebook Ad, Google Adwords, etc. Insert your scripts codes here:', 'wc-conversion-tracking' );

        // Load the settings.
        $this->init_form_fields();
        $this->init_settings();

        add_action( 'woocommerce_update_options_integration', array($this, 'process_admin_options') );
        add_action( 'woocommerce_product_options_reviews', array($this, 'product_options') );
        add_action( 'woocommerce_process_product_meta', array($this, 'product_options_save'), 10, 2 );

        add_action( 'woocommerce_registration_redirect', array($this, 'wc_redirect_url') );
        add_action( 'template_redirect', array($this, 'track_registration') );
        add_action( 'wp_head', array($this, 'code_handler') );
        add_action( 'wp_footer', array($this, 'code_handler') );
    }

    /**
     * WooCommerce settings API fields for storing our codes
     *
     * @return void
     */
    function init_form_fields() {
        $this->form_fields = array(
            'position' => array(
                'title' => __( 'Script Position', 'wc-conversion-tracking' ),
                'description' => __( 'Select what position in your page you want to display the tag', 'wc-conversion-tracking' ),
                'desc_tip' => true,
                'id' => 'position',
                'type' => 'select',
                'options' => array(
                    'head' => __( 'Inside HEAD tag', 'wc-conversion-tracking' ),
                    'footer' => __( 'In footer', 'wc-conversion-tracking' ),
                )
            ),
            'cart' => array(
                'title' => __( 'Cart Scripts', 'wc-conversion-tracking' ),
                'description' => __( 'Adds script on the cart page HEAD tag', 'wc-conversion-tracking' ),
                'desc_tip' => true,
                'id' => 'cart',
                'type' => 'textarea',
            ),
            'checkout' => array(
                'title' => __( 'Checkout Scripts', 'wc-conversion-tracking' ),
                'description' => __( 'Adds script on the purchase success page HEAD tag', 'wc-conversion-tracking' ),
                'desc_tip' => true,
                'id' => 'checkout',
                'type' => 'textarea',
            ),
            'reg' => array(
                'title' => __( 'Registration Scripts', 'wc-conversion-tracking' ),
                'description' => __( 'Adds script on the successful registraion page HEAD tag', 'wc-conversion-tracking' ),
                'desc_tip' => true,
                'id' => 'registration',
                'type' => 'textarea',
            ),
        );
    }

    /**
     * Save callback of Woo integration code settings API
     *
     * @param string $key
     * @return string
     */
    function validate_textarea_field( $key ) {
        $text = trim( stripslashes( $_POST[$this->plugin_id . $this->id . '_' . $key] ) );

        return $text;
    }

    /**
     * Saves tracking code of single product
     *
     * @uses woocommerce_process_product_meta
     * @param int $post_id
     */
    function product_options_save( $post_id ) {

        if ( isset( $_POST['_wc_conv_track'] ) ) {
            $value = trim( $_POST['_wc_conv_track'] );
            update_post_meta( $post_id, '_wc_conv_track', $value );
        }
    }

    /**
     * Textarea input box on product page
     *
     * Creates new textarea on WooCommerce product advanced tab for storing
     * conversion tracking pixel for single product
     *
     * @uses woocommerce_product_options_reviews
     */
    function product_options() {

        echo '<div class="options_group">';

        woocommerce_wp_textarea_input( array('id' => '_wc_conv_track', 'label' => __( 'Conversion Tracking Code', 'wc-conversion-tracking' ), 'desc_tip' => 'true', 'description' => __( 'Insert conversion tracking code for this product.', 'wc-conversion-tracking' )) );

        echo '</div>';
    }

    /**
     * Print registration code when particular GET tag exists
     *
     * @uses add_action()
     * @return void
     */
    function track_registration() {
        if ( isset( $_GET['_wc_user_reg'] ) && $_GET['_wc_user_reg'] == 'true' ) {
            add_action( 'wp_head', array($this, 'print_reg_code') );
        }
    }

    /**
     * Adds a url query arg to determine newly registered user
     *
     * @uses woocommerce_registration_redirect action
     * @param string $redirect
     * @return string
     */
    function wc_redirect_url( $redirect ) {
        if ( wp_get_referer() ) {
            $redirect = add_query_arg( array('_wc_user_reg' => 'true'), esc_url( wp_get_referer() ) );
        } else {
            $redirect = add_query_arg( array('_wc_user_reg' => 'true'), esc_url( get_permalink( wc_get_page_id( 'myaccount' ) ) ) );
        }

        return $redirect;
    }

    /**
     * Code print handler on HEAD tag
     *
     * It prints conversion tracking pixels on cart page, order received page
     * and single product page
     *
     * @uses wp_head
     * @return void
     */
    function code_handler() {

        $position = $this->get_option( 'position', 'head' );

        if ( 'wp_head' == current_filter() && $position != 'head' ) {
            return;
        } elseif ( 'wp_footer' == current_filter() && $position != 'footer' ) {
            return;
        }

        if ( is_cart() ) {

            echo $this->print_conversion_code( $this->get_option( 'cart' ) );

        } elseif ( is_order_received_page() ) {

            echo $this->print_conversion_code( $this->get_option( 'checkout' ) );

        } elseif ( is_product() ) {

            $code = get_post_meta( get_the_ID(), '_wc_conv_track', true );
            echo $this->print_conversion_code( $code );
        }
    }

    /**
     * Registration code print handler
     *
     * @return void
     */
    function print_reg_code() {
        echo $this->print_conversion_code( $this->get_option( 'reg' ) );
    }

    /**
     * Prints the code
     *
     * @param string $code
     * @return void
     */
    function print_conversion_code( $code ) {
        if ( $code == '' ) {
            return;
        }

        echo "<!-- Tracking pixel by WooCommerce Conversion Tracking plugin -->\n";
        echo $code;
        echo "\n<!-- Tracking pixel by WooCommerce Conversion Tracking plugin -->\n";
    }

}
