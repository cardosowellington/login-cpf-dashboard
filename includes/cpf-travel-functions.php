<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function cpf_travel_add_booking( $user_id, $data ) {
    global $wpdb;
    $table = $wpdb->prefix . 'travel_bookings';

    $fields = [
        'user_id' => intval($user_id),
        'flight_code' => isset($data['flight_code']) ? sanitize_text_field($data['flight_code']) : '',
        'airline' => isset($data['airline']) ? sanitize_text_field($data['airline']) : null,
        'origin' => isset($data['origin']) ? sanitize_text_field($data['origin']) : null,
        'destination' => isset($data['destination']) ? sanitize_text_field($data['destination']) : null,
        'departure' => isset($data['departure']) ? sanitize_text_field($data['departure']) : null,
        'arrival' => isset($data['arrival']) ? sanitize_text_field($data['arrival']) : null,
        'seat' => isset($data['seat']) ? sanitize_text_field($data['seat']) : null,
        'status' => isset($data['status']) ? sanitize_text_field($data['status']) : 'confirmed',
    ];

    if ( empty( $fields['flight_code'] ) ) {
        return new WP_Error('no_flight_code', 'flight_code é obrigatório.');
    }

    $inserted = $wpdb->insert( $table, $fields );
    if ( $inserted === false ) {
        return new WP_Error('db_insert', $wpdb->last_error);
    }

    return $wpdb->insert_id;
}

function cpf_travel_get_bookings( $user_id, $args = [] ) {
    global $wpdb;
    $table = $wpdb->prefix . 'travel_bookings';
    $defaults = [
        'per_page' => 20,
        'page' => 1,
        'order' => 'DESC'
    ];
    $args = wp_parse_args($args, $defaults);
    $offset = max(0, intval($args['page'] - 1)) * intval($args['per_page']);

    $order = in_array(strtoupper($args['order']), ['ASC','DESC']) ? strtoupper($args['order']) : 'DESC';

    $query = $wpdb->prepare( "SELECT * FROM $table WHERE user_id = %d ORDER BY departure $order LIMIT %d OFFSET %d", $user_id, intval($args['per_page']), $offset );
    $rows = $wpdb->get_results( $query );
    return $rows;
}