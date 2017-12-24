<?php
/**
 * Facebook
 */
class WC_Conversion_Tracking_Gateway_Custom extends WC_Conversion_Tracking_Integration {

    function __construct() {
        $this->name = 'Custom';
        $this->enabled = true;
        $this->supports = array(
            'add_to_cart', 'checkout', 'registration'
        );
    }
    public function get_settings() {
        $settings = array(
            array(
                'type' => 'text',
                'name' => 'pixel_id',
                'label' => 'Pixel ID',
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