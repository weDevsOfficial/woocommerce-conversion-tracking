<?php

/**
 * WCCT gate way twitter
 */
class WCCT_Gateway_Twitter extends WCCT_Integration {

    /**
     * Constructor for WC_Conversion_Tracking_Gateway_Twitter class
     */
    function __construct() {
        $this->id       = 'twitter';
        $this->name     = 'Twitter';
        $this->enabled  = true;
        $this->supports = array(
            'add_to_cart', 'checkout', 'registration'
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
                'label' => 'Pixel ID',
                'value' => ''
            ),
            array(
                'type'  => 'checkbox',
                'name'  => 'events',
                'label' => 'Events',
                'value' => '',
                'options' => array(
                    'AddToCart'     => 'Add to Cart',
                    'Purchase'      => 'Purchase',
                    'registration'  => 'CompleteRegistration',
                )
            ),
        );

        return $settings;
    }
    /**
     * Check Out
     * @return [type] [description]
     */
    public function checkout( $order_id ) {
        $integration_settins = $this->get_integration_settings();
        $events = isset( $integration_settins['events'] ) ? $integration_settins['events'] : 0;
        $product = wc_get_product( $order_id );

        if ( count( $events ) > 0 ) {

            if ( isset( $events['Purchase'] ) &&  $events['Purchase'] == 'on' ) {
              ?>
                <script>
                  twq('track','Purchase', {
                    value: '',
                    currency: '<?php echo get_option('woocommerce_currency')?>',
                    content_ids: [''],
                    content_type: 'product',
                    content_name: '',
                    order_id: '<?php echo $order_id;?>'
                  });
                </script>
              <?php
            }
        }
    }

    /**
     * Add to cart
     *
     * @param integer $cart_item_key
     * @param integer $product_id
     * @param integer $quantity
     * @param integer $variation_id
     */
    public function add_to_cart( $cart_item_key, $product_id, $quantity, $variation_id ) {
        $integration_settins = $this->get_integration_settings();
        $events = isset( $integration_settins['events'] ) ? $integration_settins['events'] : 0;

        $product = wc_get_product( $product_id );

        if ( count( $events ) > 0 ) {
          if ( isset( $events['AddToCart'] ) &&  $events['AddToCart'] == 'on' ) {
            ?>
              <script>
                twq('track','AddToCart', {
                  value: '<?php echo $product->get_price() ?>',
                  currency: '<?php echo get_option('woocommerce_currency')?>',
                  num_items: '<?php echo $quantity?>',
                  //optional parameters
                  content_ids: ['<?php echo $product_id?>'],
                  content_type: 'product',
                  content_name: '',
                  order_id: '<?php echo $product_id;?>'
                });
              </script>
            <?php
          }
        }
    }

    /**
     * Registration script
     * @return void
     */
    public function registration() {
        $integration_settins = $this->get_integration_settings();
        $events = isset( $integration_settins['events'] ) ? $integration_settins['events'] : 0;

        if ( count( $events ) > 0 ) {
          if ( isset( $events['registration'] ) &&  $events['registration'] == 'on' ) {
            ?>
            <script>
              twq('track', 'CompleteRegistration', {currency: '<?php echo get_option('woocommerce_currency')?>', value: 0.75});
            </script>
            <?php
          }
        }
    }

    /**
     * Enqueue script
     *
     * @return void
     */
    public function enqueue_script() {
        if ( $this->is_enabled() ) {
          $integration_settins    =   $this->get_integration_settings();
          $twitter_pixel_id       =   !empty( $integration_settins['pixel_id'] ) ? $integration_settins['pixel_id'] : '';
        ?>
          <script>
            !function(e,t,n,s,u,a){e.twq||(s=e.twq=function(){s.exe?s.exe.apply(s,arguments):s.queue.push(arguments);},s.version='1.1',s.queue=[],u=t.createElement(n),u.async=!0,u.src='//static.ads-twitter.com/uwt.js',a=t.getElementsByTagName(n)[0],a.parentNode.insertBefore(u,a))}(window,document,'script');

            twq('init','<?php echo $twitter_pixel_id;?>');
            twq('track', "PageView");
          </script>
        <?php }
    }
}