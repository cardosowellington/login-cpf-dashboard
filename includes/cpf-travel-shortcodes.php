<?php
if( ! defined( 'ABSPATH' ) ) exit;

function cpf_travel_user_trips_shortcode( $atts ) {
    if( ! is_user_logged_in() ) {
        return '<p>Faça login para ver suas viagens.</p>';
    }
    $atts = shortcode_atts([ 'per_page' => 10, 'page' => 1 ], $atts, 'user_trips');
    $user_id = get_current_user_id();
    $trips = cpf_travel_get_bookings( $user_id, [ 'per_page' => intval($atts['per_page']), 'page' => intval($atts['page']) ] );

    if( empty( $trips ) ) {
        return '<p>Você ainda não possui viagens cadastradas.</p>';
    }

    ob_start();
    echo '<div class="cpf-trips row">';
    foreach( $trips as $t ) {
        echo '<div class="col-md-6 mb-3">';
        echo '<div class="card p-3">';
        echo '<h4>' . esc_html( $t->flight_code ) . ' <small class="text-muted">' . esc_html( $t->airline ) . '</small></h4>';
        echo '<p><strong>Origem:</strong> ' . esc_html( $t->origin ) . ' <strong>Destino:</strong> ' . esc_html( $t->destination ) . '</p>';
        if( $t->departure ) echo '<p><strong>Partida:</strong> ' . esc_html( date_i18n('d/m/Y H:i', strtotime($t->departure)) ) . '</p>';
        if( $t->arrival ) echo '<p><strong>Chegada:</strong> ' . esc_html( date_i18n('d/m/Y H:i', strtotime($t->arrival)) ) . '</p>';
        echo '<p><strong>Assento:</strong> ' . esc_html( $t->seat ) . ' <strong>Status:</strong> ' . esc_html( $t->status ) . '</p>';
        echo '</div></div>';
    }
    echo '</div>';
    return ob_get_clean();
}
add_shortcode('user_trips', 'cpf_travel_user_trips_shortcode');