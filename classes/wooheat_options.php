<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class WooHeat_Options {


    function __construct() {

        if ( is_admin() ){
            add_action('admin_menu', array($this, 'wooheat_plugin_setup') );
            add_action('admin_init', array($this, 'wooheat_plugin_register_settings') );
        }

    }

    function wooheat_plugin_setup(){
        add_menu_page( 'wooHeat! Settings', 'wooHeat!', 'manage_options', 'wooheat-plugin', array($this, 'wooheat_plugin_setup_page'), 'dashicons-dashboard' );
    }

    function wooheat_plugin_register_settings() {
        register_setting( 'woo-heat-settings-group', 'woo_heat_orderby' );
    }

    function wooheat_plugin_setup_page(){

        ?>

       <form method="post" action="options.php">

            <?php settings_fields( 'woo-heat-settings-group' ); ?>
            <?php do_settings_sections( 'woo-heat-settings-group' ); ?>

            <?php 

            $selected_ordering = get_option('woo_heat_orderby', 'woo_heat');
            if($selected_ordering == 'woo_heat_scoville') {
                $scoville = 'selected';
                $rating = '';
            } else {
                $scoville = '';
                $rating = 'selected';
            }

            ?>
    

        <div class="wrap">

            <div id="icon-options-general" class="icon32"></div>
            <h1>wooHeat! Settings</h1>

            <div id="poststuff">

                <div id="post-body" class="metabox-holder columns-2">

                    <!-- main content -->
                    <div id="post-body-content">

                        <div class="meta-box-sortables ui-sortable">

                            <div class="postbox">

                                <h2 class="hndle"><span>Basic Settings</span></h2>

                                <div class="inside">

                                    <table class="widefat">

                                        <tr valign="top">
                                        <th scope="row"><strong>Order by heat using:</strong></th>
                                        <td>
                                            <select name="woo_heat_orderby">
                                                <option value="woo_heat" <?php echo $rating; ?>>Heat Rating</option>
                                                <option value="woo_heat_scoville" <?php echo $scoville; ?>>Scoville Heat Units</option>
                                            </select>
                                        </td>
                                        </tr>

                                    </table>

                                    <h3>To use shortcodes in your product descriptions:</h3>

                                    <p> <em>To display the wooHeat! rating:</em><br>
                                        <code>[wooheat rating]</code>
                                    </p>
                                    <p>
                                        <em>To display the wooHeat! scoville rating:</em><br>
                                        <code>[wooheat scoville]</code>
                                    </p>

                                </div>
                                <!-- .inside -->

                            </div>
                            <!-- .postbox -->

                        </div>
                        <!-- .meta-box-sortables .ui-sortable -->

                         <?php submit_button('Update Settings', 'primary', 'submit', false); ?>

                    </div>
                    <!-- post-body-content -->

                    <!-- sidebar -->
                    <div id="postbox-container-1" class="postbox-container">

                        <div class="meta-box-sortables">

                            <div class="postbox">

                                <h2 class="hndle">About wooHeat!</h2>

                                <div class="inside">
                                    
                                    <p>
                                        wooHeat adds sorting options for products based on scoville heat units. Simply add a heat rating and scoville rating to products.</p>
                                    <p>
                                        More info or feature requests, email <a href="mailto:me@uiux.me">me@uiux.me</a>
                                    </p>

                                </div>
                                <!-- .inside -->

                            </div>
                            <!-- .postbox -->

                        </div>
                        <!-- .meta-box-sortables -->

                    </div>
                    <!-- #postbox-container-1 .postbox-container -->

                </div>
                <!-- #post-body .metabox-holder .columns-2 -->

                <br class="clear">
            </div>
            <!-- #poststuff -->

        </div> <!-- .wrap -->
            
        

        </form>


    <?php

    }


}

?>
