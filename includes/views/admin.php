<div class="wrap wcct-admin">
    <h2><?php _e( 'Conversion Tracking', 'woocommerce-conversion-tracking' ); ?></h2>

    <div id="ajax-message" class="updated inline" style="display: none; margin-bottom:35px"></div>

    <form action="" method="POST" id="integration-form">
        <?php
        foreach ( $integrations as $integration ) {
            $object          = new $integration;
            $name            = $object->get_name();
            $id              = strtolower( $name );
            $settings_fields = $object->get_settings();
            $settings        = $object->get_integration_settings();
            ?>
            <div class="integration">
                <div class="integration-name">
                    <div class="gateway">
                        <h3 class="gateway-text">
                            <?php echo $name; ?>
                        </h3>
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

                    foreach ( $settings_fields as $field ) {
                        ?>
                        <div class="wc-ct-form-group">
                            <table class="form-table custom-table">
                                <tr>
                                    <th>
                                        <label for="<?php echo $id . '-' . $field['label']; ?>"><?php echo $field['label']; ?></label>
                                    </th>

                                    <?php
                                    switch ( $field['type'] ) {
                                        case 'text':
                                            echo '<td><input type="text" name="settings[' . $id . '][' . $field['name'] . ']" value="' . $settings[ $field['name'] ] . '" id="' . $id . '-' . $field['label'] . '"></td>';
                                            break;

                                        case 'textarea':
                                            echo '<td><textarea name="settings[' . $id . '][' . $field['name'] . ']" id="' . $id . '-' . $field['label'] . '" cols="30" rows="3">' . $settings[ $field['name'] ] . '</textarea></td>';
                                            break;
                                        case 'checkbox':
                                            ?>
                                            <td>
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
                                            </td>
                                            <?php
                                    }
                                }
                                ?>
                            </tr>
                        </table>
                    </div>
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
