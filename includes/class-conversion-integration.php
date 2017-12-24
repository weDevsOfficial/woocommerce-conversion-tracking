<?php
/**
 * Abstract Class
 */
abstract class WC_Conversion_Tracking_Integration {
    /**
     * Integration name
     *
     * @var string
     */
    protected $name;

    /**
     * Check enable
     *
     * @var boolean
     */
    protected $enabled;

    /**
     * Stroe all integration's settings
     *
     * @var array
     */
    protected $settings = array();

    /**
     * Store all supported features
     *
     * @var array
     */
    protected $supports = array();

    /**
     * Get the integration name
     *
     * @return string
     */
    public function get_name() {
        return $this->name;
    }

    /**
     * Check the integration enable or not
     *
     * @return boolean
     */
    public function is_enabled() {
        return $this->enabled;
    }

    /**
     * Get settings for all integration
     *
     * @return array
     */
    abstract public function get_settings();

    /**
     * Check feattures
     *
     * @param  array $feature
     * @return boolean
     */
    public function supports( $feature ) {
        if ( in_array( $feature, $this->supports ) ) {
            return true;
        }
        return false;
    }
}