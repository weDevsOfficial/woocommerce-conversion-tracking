<?php

/**
 * Manager Class
 */
class WCCT_Integration_Manager {

    /**
     * All integrations
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
        require_once WCCT_INCLUDES . "/class-conversion-integration.php";
        require_once WCCT_INCLUDES . "/gateways/conversion-integration-facebook.php";
        require_once WCCT_INCLUDES . "/gateways/conversion-integration-custom.php";
        require_once WCCT_INCLUDES . "/gateways/conversion-integration-google.php";
        require_once WCCT_INCLUDES . "/gateways/conversion-integration-twitter.php";
    }

    /**
     * Get all integration
     *
     * @return void
     */
    public function get_integrations() {
        $integrations = array(
            'WCCT_Gateway_Facebook',
            'WCCT_Gateway_Twitter',
            'WCCT_Gateway_Google',
            'WCCT_Gateway_Custom',
        );
        $this->integrations = apply_filters( 'wcct_gateways', $integrations );
        return $this->integrations;
    }

    /**
     * Get all active integrations
     *
     * @return void
     */
    public function get_active_integrations() {
        $integrations = $this->get_integrations();
        $active = array();

        foreach ( $integrations as $integration ) {
            $object = new $integration();
            if ( $object->is_enabled() ) {
                $active[] = $object;
            }
        }

        return $active;
    }

    /**
     * Render Form
     *
     * @return void
     */
    public function render_form() {
        $integrations           =   $this->get_integrations();
        $integration_enable     =   get_option( 'integration_enabled' );
        $integration_settings   =   get_option( 'integration_settings' );
        ?>
        <div class="wcct-admin">
            <h2>Conversion Tracking</h2>
            <div id="message" class="updated inline" style="display: none; margin-bottom:35px">
                <p><strong>Your settings has been saved</strong></p>
            </div>
            <form action="" method="POST" id="integration-form">
                <?php
                foreach ( $integrations as $integration ) {
                    $object     =   new $integration;
                    $name       =   $object->get_name();
                    $id         =   strtolower( $name );
                    $settings   =   $object->get_settings();
                    ?>
                    <div class="integration">
                        <div class="integration-name">
                            <div class="gateway">
                                <label for="" class="gateway-text">
                                    <?php echo $name?>
                                </label>
                                <label class="switch tips" title="" data-original-title="Make Inactive">
                                    <input type="checkbox" class="toogle-seller" name="<?php echo $id;?>_enabled" id="integration-<?php echo $id?>" data-id="<?php echo $id?>" value="1" <?php checked( 1, $integration_enable[$id] ) ?> >
                                    <span class="slider round" data-id="<?php echo $id?>"></span>
                                </label>
                            </div>
                        </div>

                        <div class="integration-settings" id="setting-<?php echo $id?>">
                            <?php
                            if ( ! $settings ) {
                                continue;
                            }

                            foreach ( $settings as $field ) {
                                ?>
                                <div class="wc-ct-form-group">
                                    <table class="form-table custom-table">
                                        <tr>
                                            <th>
                                                <label for="<?php echo $id.'-'.$field['label']?>"><?php echo $field['label']?></label>
                                            </th>

                                <?php
                                switch ( $field['type'] ) {
                                    case 'text':
                                        echo '<td><input type="text" name="'.$id.'['.$field['name'].']" value="'.$integration_settings[$id][$field['name']].'" id="'.$id.'-'.$field['label'].'"></td>';
                                        break;

                                    case 'textarea':
                                        echo '<td><textarea name="'.$id.'['.$field['name'].']" id="'.$id.'-'.$field['label'].'" cols="30" rows="3">'.$integration_settings[$id][$field['name']].'</textarea></td>';
                                        break;
                                    case 'checkbox':
                                        ?>
                                        <td>
                                            <div class="wc-ct-option" style="">
                                                <?php
                                                    foreach ( $field['options'] as $key => $option ) {
                                                        $field_name =   $field['name'];

                                                        $checked = isset( $integration_settings[$id][$field_name][$key] ) ? 'on' : '';
                                                        ?>
                                                            <label for="<?php echo $id.'-'.$key ?>">
                                                                <input type="checkbox" name="<?php echo $id?>[<?php echo $field_name?>][<?php echo $key?>]" <?php checked( 'on', $checked );?> id="<?php echo $id.'-'.$key ?>">
                                                                <?php echo $option ?>
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
                    <button class="button button-primary">Save Changes</button>
                </div>
            </form>
        </div>
        <?php
    }
}