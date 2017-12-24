<?php
/**
 * Facebook
 */
class WC_Conversion_Tracking_Gateway_Facebook extends WC_Conversion_Tracking_Integration {

    function __construct() {
        $this->name = 'Facebook';
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
                    'AddTodf' => 'Add To Wishlist',
                    'AddTosdf' => 'Add Payment Info',
                    'Purchase' => 'Purchase'
                )
            ),
        );

        return $settings;
    }
}