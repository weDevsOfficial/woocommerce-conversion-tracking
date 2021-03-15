<?php

/**
 * WCCT gate way modalova
 */
class WCCT_Integration_Modalova extends WCCT_Integration {

    /**
     * Constructor for WC_Conversion_Tracking_Gateway_Modalova class
     */
    function __construct() {
        $this->id           = 'modalova';
        $this->name         = __( 'Modalova', 'woocommerce-conversion-tracking' );
        $this->enabled      = true;
        $this->supports     = array(
            'checkout',
        );
    }

    /**
     * Get settings integration
     *
     * @return array
     */
    public function get_settings() {
        $settings = array(
            array(
                'type'      => 'text',
                'name'      => 'campaign_id',
                'label'     => __( 'Campaign ID', 'woocommerce-conversion-tracking' ),
                'required'  => true,
                'value'     => '',
                'help'      => sprintf( __( 'Find your Campaign ID from <a href="%s" target="_blank">here</a>.', 'woocommerce-conversion-tracking' ), 'https://modalova.affiliationsoftware.app/merchant/campaigns.php' )
            ),
        );

        return apply_filters( 'wcct_settings_modalova', $settings );
    }

    /**
     * Enqueue script
     *
     * @return void
     */
    public function enqueue_script() {
        if ( ! $this->is_enabled() ) {
            return;
        }
    }

    /**
     * Check Out
     *
     * @return void
     */
    public function checkout( $order_id ) {
        if ( ! $this->is_enabled() ) {
            return;
        }

        $integration_settings = $this->get_integration_settings();
        $campaign_id = ! empty( $integration_settings[0]['campaign_id'] ) ? $integration_settings[0]['campaign_id'] : '';

        if ( ! empty( $campaign_id ) ) {
            $this->show_code( $order_id );
        }
    }

    /**
     * Output the code for the checkout
     *
     * @since 2.0.9
     *
     * @param  string $code
     *
     * @return void
     */
    private function show_code($order_id) {
        $integration_settings = $this->get_integration_settings();
        $campaign_id = ! empty( $integration_settings[0]['campaign_id'] ) ? $integration_settings[0]['campaign_id'] : '';

        $order = wc_get_order( $order_id );

        // bail out if not a valid instance
        if ( ! is_a( $order, 'WC_Order' ) ) {
            error_log( 'ML: Order #'.$order_id.' is not a WC_Order ('.get_class($order).')' );
            return $code;
        }

        if ( version_compare( WC()->version, '3.0', '<' ) ) {
            // older version
            $order_currency = $order->get_order_currency();
            $payment_method = $order->payment_method;
        } else {
            $order_currency = $order->get_currency();
            $payment_method = $order->get_payment_method();
        }

        $customer       = $order->get_user();
        $used_coupons   = $order->get_used_coupons() ? implode( ',', $order->get_used_coupons() ) : '';
        $order_currency = $order_currency;
        $order_total    = $order->get_total() ? $order->get_total() : 0;
        $order_number   = $order->get_order_number();
        $order_subtotal = $order->get_subtotal();
        $order_discount = $order->get_total_discount();
        $order_shipping = $order->get_total_shipping();

        $query = http_build_query([
            'cid' => $campaign_id,
            'cost' => $order_subtotal,
            'orderid' => $order_number,
            'order_currency' => $order_currency,
        ]);
?>
<!-- Modalova.com - Tracking code -->
<img src="https://modalova.affiliationsoftware.app/script/track.php?<?= $query ?>" width="1" height="1" border="0" alt="" />
<!-- Modalova.com - Tracking code -->
<?php
    }
}

return new WCCT_Integration_Modalova();
