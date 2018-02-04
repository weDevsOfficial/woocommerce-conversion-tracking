<?php

/**
 * Plugin Upgrade Routine
 *
 * @since 2.0
 */
class WCCT_Upgrades {

    /**
     * The upgrades
     *
     * @var array
     */
    private static $upgrades = array(
        '2.0' => 'upgrades/upgrade-2.0.php',
    );

    /**
     * Get the plugin version
     *
     * @return string
     */
    public function get_version() {
        return get_option( 'wcct_version' );
    }

    /**
     * Check if the plugin needs any update
     *
     * @return boolean
     */
    public function needs_update() {

        // may be it's the first install
        if ( ! $this->get_version() ) {
            return false;
        }

        if ( version_compare( $this->get_version(), WCCT_VERSION, '<' ) && in_array( WCCT_VERSION, self::$upgrades ) ) {
            return true;
        }

        return false;
    }

    /**
     * Perform all the necessary upgrade routines
     *
     * @return void
     */
    function perform_updates() {
        $installed_version = $this->get_version();
        $path              = trailingslashit( dirname( __FILE__ ) );

        foreach ( self::$upgrades as $version => $file ) {
            if ( version_compare( $installed_version, $version, '<' ) ) {
                include $path . $file;
                update_option( 'wcct_version', $version );
            }
        }

        update_option( 'wcct_version', WCCT_VERSION );
    }
}