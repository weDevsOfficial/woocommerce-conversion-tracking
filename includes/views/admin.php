<div class="wrap wcct-admin">
    <!-- <h2><?php _e( 'Conversion Tracking', 'woocommerce-conversion-tracking' ); ?></h2> -->

    <?php
        $this->show_navigation();
        $tab   = isset( $_GET['tab'] ) ? $_GET['tab'] : 'settings';
    ?>
    <div id="ajax-message" class="updated inline" style="display: none; margin-bottom:35px"></div>
    <?php
        if ( $tab == 'settings' ) {
            include WCCT_INCLUDES . '/views/settings.php';
        } else {
            do_action( 'wcct_nav_content_'.$tab );
        }
    ?>
</div>
