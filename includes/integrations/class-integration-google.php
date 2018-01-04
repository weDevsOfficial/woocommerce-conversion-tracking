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
                'type'        => 'text',
                'name'        => 'account_id',
                'label'       => __( 'Account ID', 'woocommerce-conversion-tracking' ),
                'value'       => '',
                'placeholder' => 'AW-123456789',
                'help'        => __( 'Provide the AdWords Account ID. Usually it\'s something like <code>AW-123456789</code>', 'woocommerce-conversion-tracking' )
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

        $integration_settins = $this->get_integration_settings();
        $account_id          = ! empty( $integration_settins['account_id'] ) ? $integration_settins['account_id'] : '';

        if ( empty( $account_id ) ) {
            return;
        }
        ?>
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $account_id; ?>"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments)};
            gtag('js', new Date());

            gtag('config', '<?php echo $account_id; ?>');
        </script>
        <?php
    }

    /**
     * Check Out google adwords
     *
     * @return void
     */
    public function checkout() {

    }
}
