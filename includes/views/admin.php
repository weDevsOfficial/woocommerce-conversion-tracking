<div class="wrap wcct-admin">
    <h2><?php _e( 'Conversion Tracking', 'woocommerce-conversion-tracking' ); ?></h2>

    <div id="ajax-message" class="updated inline" style="display: none; margin-bottom:35px"></div>

    <form action="" method="POST" id="integration-form">
        <?php
        foreach ( $integrations as $integration ) {
            $object          = new $integration;
            $name            = $object->get_name();
            $id              = $object->get_id();
            $settings_fields = $object->get_settings();
            $settings        = $object->get_integration_settings();
            ?>
            <div class="integration">
                <div class="integration-name">
                    <div class="gateway">
                        <h3 class="gateway-text"><?php echo $name; ?></h3>
                        <label class="switch tips" title="" data-original-title="Make Inactive">
                            <input type="checkbox" class="toogle-seller" name="settings[<?php echo $id; ?>][enabled]" id="integration-<?php echo $id; ?>" data-id="<?php echo $id; ?>" value="1" <?php checked( true, $object->is_enabled() ); ?> >
                            <span class="slider round" data-id="<?php echo $id; ?>"></span>
                        </label>
                    </div>
                </div>

                <div class="integration-settings" id="setting-<?php echo $id; ?>">
                    <?php
                    if ( ! $settings_fields ) {
                        continue;
                    }
                    ?>

                    <table class="form-table custom-table">
                        <div class="wc-ct-form-group">
                            <?php foreach ( $settings_fields as $field ) { ?>
                                <tr>
                                    <th>
                                        <label for="<?php echo $id . '-' . $field['label']; ?>"><?php echo $field['label']; ?></label>
                                    </th>

                                    <td>
                                        <?php
                                        $placeholder = isset( $field['placeholder'] ) ? $field['placeholder'] : '';

                                        switch ( $field['type'] ) {
                                            case 'text':
                                                printf( '<input type="text" name="settings[%s][%s]" placeholder="%s" value="%s" id="%s">', $id, $field['name'], $placeholder, $settings[ $field['name'] ], $id . '-' . $field['name'] );
                                                break;

                                            case 'textarea':
                                                printf( '<textarea type="text" name="settings[%s][%s]" placeholder="%s" id="%s" cols="30" rows="3">%s</textarea>', $id, $field['name'], $placeholder, $id . '-' . $field['name'], $settings[ $field['name'] ] );
                                                break;
                                            case 'checkbox':
                                                ?>
                                                <div class="wc-ct-option" style="">
                                                    <?php
            										foreach ( $field['options'] as $key => $option ) {
            											$field_name = $field['name'];

            											$checked = isset( $settings[ $field_name ][ $key ] ) ? 'on' : '';
            											?>
            												<label for="<?php echo $id . '-' . $key; ?>">
            													<input type="checkbox" name="settings[<?php echo $id; ?>][<?php echo $field_name; ?>][<?php echo $key; ?>]" <?php checked( 'on', $checked ); ?> id="<?php echo $id . '-' . $key; ?>">
            													<?php echo $option; ?>
            												</label>
            												<br>
                                                            <?php
            										}
                                                    ?>
                                                </div>
                                            <?php
                                        }

                                        if ( isset( $field['help'] ) && ! empty( $field['help'] ) ) {
                                            echo '<p class="help">' . $field['help'] . '</p>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </div>
                    </table>
                </div>
            </div>

            <?php
        }
        ?>
        <div class="submit-area">
            <?php wp_nonce_field( 'wcct-settings' ); ?>
            <input type="hidden" name="action" value="wcct_save_settings">

            <button class="button button-primary">Save Changes</button>
        </div>
    </form>
</div>
