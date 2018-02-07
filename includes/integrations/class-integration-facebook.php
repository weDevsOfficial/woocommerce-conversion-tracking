<?php

/**
 * WCCT gate way facebook
 */
class WCCT_Integration_Facebook extends WCCT_Integration {

    /**
     * Constructor for WC_Conversion_Tracking_Gateway_Facebook
     */
    function __construct() {
        $this->id        = 'facebook';
        $this->name      = __( 'Facebook', 'woocommerce-conversion-tracking' );
        $this->enabled   = true;
        $this->supports  = array(
            'add_to_cart',
            'checkout',
            'initiate_checkout',
            'registration',
        );
    }

    /**
     * Get Settings
     *
     * @return array
     */
    public function get_settings() {
        $settings = array(
            'id'      => array(
                'type'      => 'text',
                'name'      => 'pixel_id',
                'label'     => __( 'Pixel ID', 'woocommerce-conversion-tracking' ),
                'required'  => true,
                'value'     => '',
                'help'      => sprintf( __( 'Find the Pixel ID from <a href="%s" target="_blank">here</a>.', 'woocommerce-conversion-tracking' ), 'https://www.facebook.com/ads/manager/pixel/facebook_pixel' )
            ),
            'events'    => array(
                'type'    => 'multicheck',
                'name'    => 'events',
                'label'   => __( 'Events', 'woocommerce-conversion-tracking' ),
                'value'   => '',
                'options' => array(
                    'AddToCart'        => __( 'Add to Cart', 'woocommerce-conversion-tracking' ),
                    'InitiateCheckout' => __( 'Initiate Checkout', 'woocommerce-conversion-tracking' ),
                    'Purchase'         => __( 'Purchase', 'woocommerce-conversion-tracking' ),
                    'Registration'     => __( 'Complete Registration', 'woocommerce-conversion-tracking' )
                )
            ),
        );

        return apply_filters( 'wcct_settings_fb', $settings );
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
        return sprintf( "fbq('%s', '%s', %s);", $method, $event_name, json_encode( $params, JSON_PRETTY_PRINT | JSON_FORCE_OBJECT ) );
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

        $integration_settins    = $this->get_integration_settings();
        $facebook_pixel_id      = ! empty( $integration_settins[0]['pixel_id'] ) ? $integration_settins[0]['pixel_id'] : '';
        ?>
        <script>
            !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
            n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
            document,'script','https://connect.facebook.net/en_US/fbevents.js');

            <?php
            if ( is_user_logged_in() ) {
                $user_email = wp_get_current_user()->user_email;

                echo $this->build_event( $facebook_pixel_id, array( 'em' => $user_email ), 'init' );
            } else {
                echo $this->build_event( $facebook_pixel_id, array(), 'init' );
            }

            echo $this->build_event( 'PageView', array() );
            ?>
        </script>

        <noscript><img height="1" width="1" style="display:none"
        src="https://www.facebook.com/tr?id=<?php echo $facebook_pixel_id; ?>&ev=PageView&noscript=1"
        /></noscript>
        <?php

        $this->add_to_cart_ajax();
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
                    fbq('track', 'AddToCart', {
                       content_ids: [ $(button).data('product_id') ],
                       content_type: 'product',
                    });
                });
            });
        </script>
        <?php
    }

    /**
     * Fire initiate checkout events
     *
     * @return void
     */
    public function initiate_checkout() {
        if ( ! $this->event_enabled( 'InitiateCheckout' ) ) {
            return;
        }

        $product_ids = $this->get_content_ids_from_cart( WC()->cart->get_cart() );

        $code = $this->build_event( 'InitiateCheckout', array(
            'num_items'    => WC()->cart->get_cart_contents_count(),
            'content_ids'  => json_encode( $product_ids ),
            'content_type' => 'product',
            'value'        => WC()->cart->total,
            'currency'     => get_woocommerce_currency()
        ) );

        wc_enqueue_js( $code );
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

    /**
     * Return categories for products/pixel
     *
     * @param string $id
     *
     * @return array
     */
    public function get_product_categories( $product_id ) {
        $category_path    = wp_get_post_terms( $product_id, 'product_cat', array( 'fields' => 'all' ) );
        $content_category = array_values( array_map( function($item) {
            return $item->name;
        }, $category_path ) );

        $content_category_slice = array_slice( $content_category, -1 );
        $categories             = empty( $content_category ) ? '""' : implode(', ', $content_category);

        return array(
            'name'       => array_pop( $content_category_slice ),
            'categories' => $categories
        );
    }
}

return new WCCT_Integration_Facebook();
