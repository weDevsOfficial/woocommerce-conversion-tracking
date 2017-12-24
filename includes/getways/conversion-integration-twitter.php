<?php
/**
 * Facebook
 */
class WC_Conversion_Tracking_Gateway_Twitter extends WC_Conversion_Tracking_Integration {

    function __construct() {
        $this->name = 'Twitter';
        $this->enabled = true;
        $this->supports = array(
            'add_to_cart', 'checkout', 'registration'
        );
    }
    public function get_settings() {
        $settings = array(
            array(
                'type' => 'text',
                'name' => 'resource_url',
                'label' => 'Resource URL',
                'value' => ''
            ),
            array(
                'type' => 'checkbox',
                'name' => 'events',
                'label' => 'Events',
                'value' => '',
                'options' => array(
                    'AddToCart' => 'Add to Cart',
                )
            ),
        );

        return $settings;
    }
}