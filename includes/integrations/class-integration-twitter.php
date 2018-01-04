<?php

/**
 * WCCT gate way twitter
 */
class WCCT_Integration_Twitter extends WCCT_Integration {

    /**
     * Constructor for WC_Conversion_Tracking_Gateway_Twitter class
     */
    function __construct() {
        $this->id       = 'twitter';
        $this->name     = __( 'Twitter', 'woocommerce-conversion-tracking' );
        $this->enabled  = true;
        $this->supports = array(
            'add_to_cart',
            'checkout',
            'registration'
        );
    }

    /**
     * Get settings
     *
     * @return array
     */
    public function get_settings() {
        $settings = array(
            array(
                'type'  => 'text',
                'name'  => 'pixel_id',
                'label' => __( 'Pixel ID', 'woocommerce-conversion-tracking' ),
                'value' => ''
            ),
            array(
                'type'  => 'checkbox',
                'name'  => 'events',
                'label' => __( 'Events', 'woocommerce-conversion-tracking' ),
                'value' => '',
                'options' => array(
                    'AddToCart'     => __( 'Add to Cart', 'woocommerce-conversion-tracking' ),
                    'Purchase'      => __( 'Purchase', 'woocommerce-conversion-tracking' ),
                    'Registration'  => __( 'Completes Registration', 'woocommerce-conversion-tracking' ),
                )
            ),
        );

        return $settings;
    }

    /**
     * Build the event object
     *
     * @param  string $event_name
     * @param  array $params
     * @param  string $method
     *
     * @return string
     */
    public function build_event( $event_name, $params = array(), $method = 'track' ) {
        return sprintf( "twq('%s', '%s', %s);", $method, $event_name, json_encode( $params, JSON_PRETTY_PRINT | JSON_FORCE_OBJECT ) );
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

        $integration_settins = $this->get_integration_settings();
        $twitter_pixel_id    = ! empty( $integration_settins['pixel_id'] ) ? $integration_settins['pixel_id'] : '';
        ?>
        <script>
            !function(e,t,n,s,u,a){e.twq||(s=e.twq=function(){s.exe?s.exe.apply(s,arguments):s.queue.push(arguments);},s.version='1.1',s.queue=[],u=t.createElement(n),u.async=!0,u.src='//static.ads-twitter.com/uwt.js',a=t.getElementsByTagName(n)[0],a.parentNode.insertBefore(u,a))}(window,document,'script');

            <?php echo $this->build_event( $twitter_pixel_id, array(), 'init' ); ?>
            <?php echo $this->build_event( 'PageView' ); ?>
        </script>
        <?php

        $this->add_to_cart_ajax();
    }

    /**
     * Check Out
     *
     * @param  integer $order_id
     *
     * @return void
     */
    public function checkout( $order_id ) {
        if ( ! $this->event_enabled( 'Purchase' ) ) {
            return;
        }

        $order        = new WC_Order( $order_id );
        $content_type = 'product';
        $product_ids  = array();

        foreach ( $order->get_items() as $item ) {
            $product = wc_get_product( $item['product_id'] );

            $product_ids[] = $product->get_id();

            if ( $product->get_type() === 'variable' ) {
                $content_type = 'product_group';
            }
        }

        $code = $this->build_event( 'Purchase', array(
            'content_ids'  => json_encode($product_ids),
            'content_type' => $content_type,
            'value'        => $order->get_total(),
            'currency'     => get_woocommerce_currency()
        ) );

        wc_enqueue_js( $code );
    }

    /**
     * Enqueue add to cart event
     *
     * @return void
     */
    public function add_to_cart() {

        if ( ! $this->event_enabled( 'AddToCart' ) ) {
            return;
        }

        $product_ids = $this->get_content_ids_from_cart( WC()->cart->get_cart() );

        $code = $this->build_event( 'AddToCart', array(
            'content_ids'  => json_encode( $product_ids ),
            'content_type' => 'product',
            'value'        => WC()->cart->total,
            'currency'     => get_woocommerce_currency()
        ) );

        wc_enqueue_js( $code );
    }

    /**
     * Added to cart
     *
     * @return void
     */
    public function add_to_cart_ajax() {
        if ( ! $this->event_enabled( 'AddToCart' ) ) {
            return;
        }
        ?>
        <script type="text/javascript">
            jQuery(function($) {
                $(document).on('added_to_cart', function (event, fragments, hash, button) {
                    twq('track', 'AddToCart', {
                       content_ids: [ $(button).data('product_id') ],
                       content_type: 'product',
                    });
                });
            });
        </script>
        <?php
    }

    /**
     * Registration script
     *
     * @return void
     */
    public function registration() {
        if ( ! $this->event_enabled( 'Registration' ) ) {
            return;
        }

        $code = $this->build_event( 'CompleteRegistration' );

        wc_enqueue_js( $code );
    }

}
