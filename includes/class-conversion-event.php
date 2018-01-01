<?php

/**
 * Event Manager
 */
class WC_Conversion_Event_Dispatcher {

    private $integrations;

    /**
     * Constructor for WC_Conversion_Event_Dispatcher class
     */
    function __construct() {
        add_action( 'plugins_loaded', array( $this, 'init_integrations'));
        add_action( 'wp_head', array( $this, 'enqueue_scripts'));

        add_action( 'woocommerce_add_to_cart', array( $this, 'added_to_cart' ), 11, 4);
        add_action( 'woocommerce_thankyou', array( $this, 'checkout_complete') );
        add_action( 'woocommerce_created_customer', array( $this, 'complete_registration', 11 ) );
    }

    public function init_integrations() {
        $manager = new WC_Conversion_Tracking_Integration_Manager();
        $this->integrations = $manager->get_active_integrations();

        return $this->integrations;
    }
    /**
     * Add to cart
     *
     * @return void
     */
    public function added_to_cart( $cart_item_key, $product_id, $quantity, $variation_id )
    {
        foreach ( $this->integrations as $integration ) {
            if ( $integration->supports( 'add_to_cart' ) ) {

                if( method_exists( $integration, 'add_to_cart' ) ) {
                    $integration->add_to_cart( $cart_item_key, $product_id, $quantity, $variation_id );
                }
            }
        }
    }

    /**
     * Check out
     * @param  int $order_id
     * @return void
     */
    public function checkout_complete( $order_id ) {

        foreach ( $this->integrations as $integration ) {
            if ( $integration->supports( 'checkout' ) ) {

                if( method_exists( $integration, 'checkout' ) ) {
                    $integration->checkout( $order_id );
                }
            }
        }
    }

    /**
     * Customer registration
     *
     * @return void
     */
    public function complete_registration() {
        foreach ( $this->integrations as $integration ) {
            if ( $integration->supports( 'registration' ) ) {

                if( method_exists( $integration, 'registration' ) ) {
                    $integration->registration();
                }
            }
        }
    }

    /**
     * Integration enqueue script
     *
     * @return void
     */
    public function enqueue_scripts() {
        foreach ( $this->integrations as $integration ) {
            $integration->enqueue_script();
        }
    }
}
