<?php

/**
 * Change Conversion tracking option key
 *
 * @return void
 */
function wcct_upgrade_2_0_change_option_key() {
    $wcct_settings   = get_option( 'woocommerce_wc_conv_tracking_settings' );

    if ( ! $wcct_settings ) {
        return;
    }

    $change_settings['custom']    = array(
        'enabled'       => 1,
        'cart'          => $wcct_settings['cart'],
        'checkout'      => $wcct_settings['checkout'],
        'registration'  => $wcct_settings['reg'],
    );

    update_option( 'wcct_settings', $change_settings['custom'] );
    update_option( '_wcct_20_notice_dismiss', false );

    // redirect transient
    set_transient( 'wcct_upgrade_to_20', true, MINUTE_IN_SECONDS );
}

wcct_upgrade_2_0_change_option_key();
