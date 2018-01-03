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
		$this->name      = 'Facebook';
		$this->enabled   = true;
		$this->supports  = array(
			'add_to_cart',
			'checkout',
			'registration'
		);
    }

    /**
     * Get Settings
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
                'type'    => 'checkbox',
                'name'    => 'events',
                'label'   => __( 'Events', 'woocommerce-conversion-tracking' ),
                'value'   => '',
                'options' => array(
					'AddToCart'         => __( 'Add to Cart', 'woocommerce-conversion-tracking' ),
					'Purchase'          => __( 'Purchase', 'woocommerce-conversion-tracking' ),
					'registration'      => __( 'Complete Registration', 'woocommerce-conversion-tracking' )
                )
            ),
        );
        return $settings;
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
        $facebook_pixel_id      = ! empty( $integration_settins['pixel_id'] ) ? $integration_settins['pixel_id'] : '';
		?>
        <script>
            !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
            n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
            document,'script','https://connect.facebook.net/en_US/fbevents.js');

            fbq('init', '<?php echo $facebook_pixel_id; ?>');
            fbq('track', "PageView");
        </script>

        <noscript><img height="1" width="1" style="display:none"
        src="https://www.facebook.com/tr?id=<?php echo $facebook_pixel_id; ?>&ev=PageView&noscript=1"
        /></noscript>
		<?php
    }

    /**
     * Check Out
     *
     * @param  integer $order_id
     * @return void
     */
    public function checkout( $order_id ) {
        if ( ! $this->event_enabled( 'Purchase' ) ) {
            return;
        }
        ?>
        <script>
          fbq('track', 'Purchase', {
            content_name: 'Really Fast Running Shoes',
            content_category: 'Apparel & Accessories > Shoes',
            content_ids: ['<?php echo $order_id; ?>'],
            content_type: 'product',
            value: 199.50,
            currency: '<?php echo get_option( 'woocommerce_currency' ); ?>'
          });
        </script>
        <?php
    }

    /**
     * Added to cart
     *
     * @param integer $cart_item_key
     * @param integer $product_id
     * @param integer $quantity
     * @param void    $variation_id
     */
    public function add_to_cart( $cart_item_key, $product_id, $quantity, $variation_id ) {
        if ( ! $this->event_enabled( 'AddToCart' ) ) {
            return;
        }
        ?>
        <script>
          fbq('track', 'AddToCart', {
            content_name: 'Really Fast Running Shoes',
            content_category: 'Apparel & Accessories > Shoes',
            content_ids: ['<?php echo $product_id; ?>'],
            content_type: 'product',
            value: 199.50,
            currency: '<?php echo get_option( 'woocommerce_currency' ); ?>'
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
        if ( ! $this->event_enabled( 'registration' ) ) {
            return;
        }
        ?>
		  <script>
			fbq('track', 'CompleteRegistration');
		  </script>
		<?php
    }
}
