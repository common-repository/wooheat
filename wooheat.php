<?php
/**
 * Plugin Name:       wooHeat! Chilli Heat Rating & Product Sorting
 * Plugin URI:        https://uiux.me/wooheat
 * Description:       Woocommerce Plugin for adding Heat Ratings to products allowing items to be sorted by their heat value.
 * Version:           1.4
 * Requires at least: 4.0
 * Author:            UIUX <me@uiux.me>
 * Author URI:        https://uiux.me/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */


if ( ! defined( 'ABSPATH' ) ) exit;

include 'classes/wooheat.php';
include 'classes/wooheat_options.php';

new WooHeat();
new WooHeat_Options();

?>