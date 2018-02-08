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
}

wcct_upgrade_2_0_change_option_key();