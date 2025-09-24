<?php
/**
 * Plugin Name: Login CPF Dashboard
 * Description: This plugin adds the ability to log in to WordPress using the user's CPF (Individual Taxpayer Registry). Only users previously registered by the administrator will be able to access the restricted area. After validating the login, the user will be redirected to the personalized Dashboard, which displays information specific to the internal area of ​​the site.
 * Version: 1.0
 * Author: Cardoso Wellington
 * Author URI: https://github.com/cardosowellington
 */

if ( ! defined( 'ABSPATH') ) exit;

define( 'LOGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'LOGIN_URL', plugin_dir_url( __FILE__ ) );

require_once LOGIN_PATH . 'includes/class-cpf-login.php';
require_once LOGIN_PATH . 'includes/class-cpf-admin.php';
require_once LOGIN_PATH . 'includes/cpf-database.php';
require_once LOGIN_PATH . 'includes/cpf-endpoints.php';
require_once LOGIN_PATH . 'includes/cpf-functions.php';

register_activation_hook( __FILE__, 'cpf_create_table' );

function cpf_login_dashboard_init(){
  if( class_exists( 'CPF_Login' ) ){
    new CPF_Login();
  }
  if( class_exists( 'CPF_Admin' ) ){
    new CPF_Admin();
  }
}
add_action( 'plugins_loaded', 'cpf_login_dashboard_init' );