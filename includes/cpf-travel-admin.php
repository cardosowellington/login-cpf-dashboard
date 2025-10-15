<?php
if( ! defined( 'ABSPATH' ) ) exit;

add_action('admin_menu', function(){
    add_menu_page('Travel Bookings', 'Travel Bookings', 'manage_options', 'cpf-travel-bookings', 'cpf_travel_admin_page', 'dashicons-airplane', 26);
});

function cpf_travel_admin_page() {
    if( ! current_user_can('manage_options') ) wp_die('Acesso negado.');
    ?>
    <div class="wrap">
        <h1>Adicionar Booking</h1>
        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
            <?php wp_nonce_field('cpf_travel_add_nonce'); ?>
            <input type="hidden" name="action" value="cpf_travel_add_booking_form" />
            <table class="form-table">
                <tr><th><label for="cpf">CPF (ou User ID)</label></th>
                    <td><input type="text" name="cpf" id="cpf" /> ou <input type="text" name="user_id" id="user_id" /></td></tr>
                <tr><th><label for="flight_code">Flight code</label></th><td><input type="text" name="flight_code" id="flight_code" required /></td></tr>
                <tr><th><label for="airline">Airline</label></th><td><input type="text" name="airline" id="airline" /></td></tr>
                <tr><th><label for="origin">Origin</label></th><td><input type="text" name="origin" id="origin" /></td></tr>
                <tr><th><label for="destination">Destination</label></th><td><input type="text" name="destination" id="destination" /></td></tr>
                <tr><th><label for="departure">Departure (YYYY-MM-DD HH:MM:SS)</label></th><td><input type="text" name="departure" id="departure" /></td></tr>
                <tr><th><label for="arrival">Arrival (YYYY-MM-DD HH:MM:SS)</label></th><td><input type="text" name="arrival" id="arrival" /></td></tr>
                <tr><th><label for="seat">Seat</label></th><td><input type="text" name="seat" id="seat" /></td></tr>
                <tr><th><label for="status">Status</label></th><td><input type="text" name="status" id="status" value="confirmed" /></td></tr>
            </table>
            <?php submit_button('Adicionar Booking'); ?>
        </form>
    </div>
    <?php
}

add_action('admin_post_cpf_travel_add_booking_form', 'cpf_travel_admin_handle_form');
function cpf_travel_admin_handle_form() {
    if( ! current_user_can('manage_options') ) wp_die('Acesso negado.');
    check_admin_referer('cpf_travel_add_nonce');

    $user_id = isset($_POST['user_id']) && !empty($_POST['user_id']) ? intval($_POST['user_id']) : 0;
    $cpf = isset($_POST['cpf']) && !empty($_POST['cpf']) ? preg_replace('/\D/', '', $_POST['cpf']) : '';

    if( empty($user_id) && empty($cpf) ) {
        wp_redirect(add_query_arg('msg','missing', admin_url('admin.php?page=cpf-travel-bookings')));
        exit;
    }

    if( empty($user_id) && ! empty($cpf) ) {
        $uq = new WP_User_Query([ 'meta_key' => 'cpf', 'meta_value' => $cpf, 'number' => 1 ]);
        $users = $uq->get_results();
        if( empty($users) ) {
            wp_redirect(add_query_arg('msg','user_not_found', admin_url('admin.php?page=cpf-travel-bookings')));
            exit;
        }
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
    if( is_wp_error($insert) ) {
        wp_redirect(add_query_arg('msg','error', admin_url('admin.php?page=cpf-travel-bookings')));
        exit;
    }

    wp_redirect(add_query_arg('msg','ok', admin_url('admin.php?page=cpf-travel-bookings')));
    exit;
}