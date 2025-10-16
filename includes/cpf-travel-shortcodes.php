<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function cpf_travel_user_trips_shortcode( $atts ) {
    if ( ! is_user_logged_in() ) {
        return '<p>Faça login para ver suas viagens.</p>';
    }
    $atts = shortcode_atts([ 'per_page' => 10, 'page' => 1 ], $atts, 'user_trips');
    $user_id = get_current_user_id();
    $trips = cpf_travel_get_bookings( $user_id, [ 'per_page' => intval($atts['per_page']), 'page' => intval($atts['page']) ] );

    if ( empty( $trips ) ) {
        return '<p>Você ainda não possui viagens cadastradas.</p>';
    }

    ob_start();
    echo '<div class="cpf-trips row">';
    foreach( $trips as $t ) {
        echo '<div class="col-md-6 mb-3">';
        echo '<div class="card p-3">';
        echo '<h4>' . esc_html( $t->flight_code ) . ' <small class="text-muted">' . esc_html( $t->airline ) . '</small></h4>';
        echo '<p><strong>Origem:</strong> ' . esc_html( $t->origin ) . ' <strong>Destino:</strong> ' . esc_html( $t->destination ) . '</p>';
        if ( $t->departure ) echo '<p><strong>Partida:</strong> ' . esc_html( date_i18n('d/m/Y H:i', strtotime($t->departure)) ) . '</p>';
        if ( $t->arrival ) echo '<p><strong>Chegada:</strong> ' . esc_html( date_i18n('d/m/Y H:i', strtotime($t->arrival)) ) . '</p>';

        if ( ! empty($t->return_flight_code) ) {
            echo '<hr>';
            echo '<p><strong>Voo de Retorno:</strong> ' . esc_html($t->return_flight_code) . ' <small class="text-muted">' . esc_html($t->airline) . '</small></p>';
            echo '<p><strong>Origem (volta):</strong> ' . esc_html($t->return_origin) . ' <strong>Destino (volta):</strong> ' . esc_html($t->return_destination) . '</p>';
            if ( $t->return_departure ) echo '<p><strong>Partida (volta):</strong> ' . esc_html( date_i18n('d/m/Y H:i', strtotime($t->return_departure)) ) . '</p>';
            if ( $t->return_arrival ) echo '<p><strong>Chegada (volta):</strong> ' . esc_html( date_i18n('d/m/Y H:i', strtotime($t->return_arrival)) ) . '</p>';
        }

        if ( ! empty($t->stops) ) {
            $stops = json_decode($t->stops);
            if ( json_last_error() === JSON_ERROR_NONE && ! empty($stops) ) {
                echo '<hr><p><strong>Paradas / Escalas:</strong></p><ul>';
                foreach ( $stops as $s ) {
                    $local = isset($s->local) ? esc_html($s->local) : '';
                    $tempo = isset($s->tempo) ? esc_html($s->tempo) : '';
                    echo '<li>' . $local . ($tempo ? ' (' . $tempo . ')' : '') . '</li>';
                }
                echo '</ul>';
            }
        }

        echo '<p><strong>Status:</strong> ' . esc_html( $t->status ) . '</p>';
        echo '</div></div>';
    }
    echo '</div>';
    return ob_get_clean();
}
add_shortcode('user_trips', 'cpf_travel_user_trips_shortcode');
