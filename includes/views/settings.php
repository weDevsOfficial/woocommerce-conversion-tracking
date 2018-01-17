<div class="wcct-two-column">

    <div class="settings-wrap">
        <h4>Conversion Settings</h4>
        <form action="" method="POST" id="integration-form">
            <?php
            foreach ( $integrations as $integration ) {
                $object          = new $integration;
                $name            = $object->get_name();
                $id              = $object->get_id();
                $settings_fields = $object->get_settings();
                $settings        = $object->get_integration_settings();
                ?>
                <div class="integration-wrap">
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

                        <div class="wc-ct-form-group">
                            <table class="form-table custom-table">
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
                                                    $value = isset( $settings[ $field['name'] ] ) ? $settings[ $field['name'] ] : '';
                                                    printf( '<input type="text" name="settings[%s][%s]" placeholder="%s" value="%s" id="%s">', $id, $field['name'], $placeholder, $value, $id . '-' . $field['name'] );
                                                    break;

                                                case 'textarea':
                                                    $value = isset( $settings[ $field['name'] ] ) ? $settings[ $field['name'] ] : '';
                                                    printf( '<textarea type="text" name="settings[%s][%s]" placeholder="%s" id="%s" cols="30" rows="3">%s</textarea>', $id, $field['name'], $placeholder, $id . '-' . $field['name'], $value );
                                                    break;

                                                case 'checkbox':
                                                    $value = isset( $settings[ $field['name'] ] ) ? $settings[ $field['name'] ] : 'off';
                                                    printf( '<label for="%5$s"><input type="checkbox" name="settings[%1$s][%2$s]" %3$s id="%5$s" value="on"> %4$s</label>', $id, $field['name'], checked( 'on', $value, false ), $field['description'], $id . '-' . $field['name'] );
                                                    break;

                                                case 'multicheck':
                                                    ?>
                                                    <div class="wc-ct-option">
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

    <div class="sidebar-wrap">
        <div class="premium-box box-green">
            Green Feature
        </div>

        <div class="premium-box box-blue">
            Blue Feature
        </div>
    </div>
</div>