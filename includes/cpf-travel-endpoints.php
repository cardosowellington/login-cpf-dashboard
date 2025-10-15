<?php
if ( ! defined( 'ABSPATH' ) ) exit;

add_action('wp_ajax_cpf_travel_add_booking', 'cpf_travel_add_booking_ajax');
function cpf_travel_add_booking_ajax() {
    if ( ! current_user_can('manage_options') ) {
        wp_send_json_error('Acesso negado.');
    }
    check_admin_referer('cpf_travel_add_nonce', 'nonce');

    $user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
    $cpf = isset($_POST['cpf']) ? preg_replace('/\D/', '', $_POST['cpf']) : '';

    if ( empty($user_id) && empty($cpf) ) {
        wp_send_json_error('Informe user_id ou cpf.');
    }

    if ( empty($user_id) && ! empty($cpf) ) {
        $user_query = new WP_User_Query([ 'meta_key' => 'cpf', 'meta_value' => $cpf, 'number' => 1 ]);
        $users = $user_query->get_results();
        if ( empty($users) ) wp_send_json_error('Usuário não encontrado para o CPF informado.');
        $user_id = $users[0]->ID;
    }

    $data = [
        'flight_code' => isset($_POST['flight_code']) ? sanitize_text_field($_POST['flight_code']) : '',
        'airline' => isset($_POST['airline']) ? sanitize_text_field($_POST['airline']) : '',
        'origin' => isset($_POST['origin']) ? sanitize_text_field($_POST['origin']) : '',
        'destination' => isset($_POST['destination']) ? sanitize_text_field($_POST['destination']) : '',
        'departure' => isset($_POST['departure']) ? sanitize_text_field($_POST['departure']) : null,
        'arrival' => isset($_POST['arrival']) ? sanitize_text_field($_POST['arrival']) : null,
        'seat' => isset($_POST['seat']) ? sanitize_text_field($_POST['seat']) : '',
        'status' => isset($_POST['status']) ? sanitize_text_field($_POST['status']) : 'confirmed',
    ];

    $insert = cpf_travel_add_booking($user_id, $data);
    if ( is_wp_error($insert) ) {
        wp_send_json_error($insert->get_error_message());
    }
    wp_send_json_success(['id' => $insert]);
}