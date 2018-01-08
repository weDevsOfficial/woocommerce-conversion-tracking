<?php

/**
 * Manager Class
 */
class WCCT_Integration_Manager {

    /**
     * All integrations
     *
     * @var array
     */
    private $integrations = array();

    /**
     * Constructor for WC_Conversion_Tracking_Integration_Manager Class
     */
    public function __construct() {
        $this->includes_integration();
    }

    /**
     * Required all integration class
     *
     * @return void
     */
    public function includes_integration() {
        require_once WCCT_INCLUDES . '/integrations/class-integration-facebook.php';
        require_once WCCT_INCLUDES . '/integrations/class-integration-custom.php';
        require_once WCCT_INCLUDES . '/integrations/class-integration-google.php';
        require_once WCCT_INCLUDES . '/integrations/class-integration-twitter.php';
    }

    /**
     * Get all integration
     *
     * @return void
     */
    public function get_integrations() {
        $integrations = array(
            'WCCT_Integration_Facebook',
            'WCCT_Integration_Twitter',
            'WCCT_Integration_Google',
        );

        $this->integrations     = apply_filters( 'wcct_integrations', $integrations );
        $this->integrations[]   = 'WCCT_Integration_Custom';

        return $this->integrations;
    }

    /**
     * Get all active integrations
     *
     * @return void
     */
    public function get_active_integrations() {
        $integrations = $this->get_integrations();
        $active       = array();

        foreach ( $integrations as $integration ) {
            $object = new $integration();

            if ( $object->is_enabled() ) {
                $active[] = $object;
            }
        }

        return $active;
    }

}
