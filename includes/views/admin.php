<div class="wrap wcct-admin">

    <?php do_action( 'wcct_before_nav' ); ?>

    <?php
    $this->show_navigation();
    $tab   = isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : 'integrations';
    ?>
    <div id="ajax-message" class="updated inline" style="display: none; margin-bottom:35px"></div>
    <?php
        if ( $tab == 'integrations' ) {
            include WCCT_INCLUDES . '/views/settings.php';
        } else {
            do_action( 'wcct_nav_content_'.$tab );
        }
    ?>
</div>
