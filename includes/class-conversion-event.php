<?php

/**
 * Event Manager
 */
class WC_Conversion_Event_Dispatcher {

    /**
     * Constructor for WC_Conversion_Event_Dispatcher class
     */
    function __construct() {
        add_action( 'completed_checkout', array( $this, 'checkout_complete' ) );
    }

    /**
     * Check out
     * @param  [type] $order_id [description]
     * @return [type]           [description]
     */
    public function checkout_complete( $order_id ) {
        $manager = new WC_Conversion_Tracking_Integration_Manager();
        $integrations = $manager->get_active_integrations();
        foreach ( $integrations as $integration ) {
            if ( $integration->supports( 'checkout' ) ) {

            }
        }
    }
}
