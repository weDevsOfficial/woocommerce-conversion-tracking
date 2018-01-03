<?php

/**
 * WCCT gate way google
 */
class WCCT_Integration_Google extends WCCT_Integration {

    /**
     * Constructor for WC_Conversion_Tracking_Gateway_Google
     */
    function __construct() {
        $this->id           = 'adwords';
        $this->name         = __( 'Google Adwords', 'woocommerce-conversion-tracking' );
        $this->enabled      = true;
        $this->supports     = array(
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
                'name'  => 'conversion_id',
                'label' => __( 'Conversion ID', 'woocommerce-conversion-tracking' ),
                'value' => ''
            ),
            array(
                'type'  => 'text',
                'name'  => 'conversion_label',
                'label' => __( 'Conversion Label', 'woocommerce-conversion-tracking' ),
                'value' => ''
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

    }

    /**
     * Check Out google adwords
     *
     * @return void
     */
    public function checkout() {

        if ( $this->is_enabled() ) {
            $integration_settins   = $this->get_integration_settings();
            $conversion_id         = ! empty( $integration_settins['conversion_id'] ) ? $integration_settins['conversion_id'] : '';
            $conversion_label      = ! empty( $integration_settins['conversion_label'] ) ? $integration_settins['conversion_label'] : '';
            $currency              = get_option( 'woocommerce_currency' );
            ?>
                <!-- Google Code for WooCommerce Conversion Page -->
                <script type="text/javascript">
                    /* <![CDATA[ */
                    var google_conversion_id = <?php echo $conversion_id; ?>;
                    var google_conversion_language = "en";
                    var google_conversion_format = "3";
                    var google_conversion_color = "ffffff";
                    var google_conversion_label = "<?php echo $conversion_label; ?>";
                    var google_conversion_currency = "<?php echo $currency; ?>";
                    var google_conversion_value = 3.3;
                    var google_remarketing_only = false;
                    /* ]]> */
                </script>

                <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
                </script>

                <noscript>
                    <div style="display:inline;">
                        <img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/<?php echo $conversion_id; ?>/?value=3.3&amp;currency_code=<?php echo $currency; ?>&amp;label=<?php echo $conversion_label; ?>&amp;guid=ON&amp;script=0"/>
                    </div>
                </noscript>
            <?php
        }
    }
}
