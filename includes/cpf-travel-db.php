<?php
if( ! defined( 'ABSPATH' ) ) exit;

function cpf_travel_create_table() {
    global $wpdb;
    $table = $wpdb->prefix . 'travel_bookings';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table (
        id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        user_id BIGINT(20) UNSIGNED NOT NULL,
        flight_code VARCHAR(50) NOT NULL,
        airline VARCHAR(100) DEFAULT NULL,
        origin VARCHAR(50) DEFAULT NULL,
        destination VARCHAR(50) DEFAULT NULL,
        departure DATETIME DEFAULT NULL,
        arrival DATETIME DEFAULT NULL,
        seat VARCHAR(20) DEFAULT NULL,
        status VARCHAR(32) DEFAULT 'confirmed',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY  (id),
        KEY user_id (user_id)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}