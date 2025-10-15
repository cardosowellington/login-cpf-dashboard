<?php
/**
 * Plugin Name: CPF Login Travel
 * Description: This plugin adds the ability to log in to WordPress using the user's CPF (Individual Taxpayer Registry). Only users previously registered by the administrator will be able to access the restricted area. After login validation, the user will be redirected to the personalized Dashboard, which displays their flight information.
 * Version: 1.1.0
 * Author: Cardoso Wellington
 * Author URI: https://github.com/cardosowellington
 */

if( ! defined( 'ABSPATH' ) ) exit;

define( 'LOGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'LOGIN_URL',  plugin_dir_url( __FILE__ ) );

require_once LOGIN_PATH . 'includes/cpf-travel-db.php';
require_once LOGIN_PATH . 'includes/cpf-travel-functions.php';
require_once LOGIN_PATH . 'includes/cpf-travel-shortcodes.php';
require_once LOGIN_PATH . 'includes/cpf-travel-admin.php';
require_once LOGIN_PATH . 'includes/class-cpf-login.php';
require_once LOGIN_PATH . 'includes/cpf-travel-endpoints.php';

register_activation_hook( __FILE__, 'cpf_travel_install' );
function cpf_travel_install() {
    cpf_travel_create_table();
}
