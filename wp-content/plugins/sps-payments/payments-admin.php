<?php
/*
Plugin Name: Payments Admin
Plugin URI: https://startpoint.studio
Description: Display and manage payments data in the admin area
Version: 1.6
Author: Yevhen Lebediev
Author URI: https://startpoint.studio
License: GPL2
*/

// Add menu item
add_action('admin_menu', 'payments_admin_menu');

function payments_admin_menu() {
    add_menu_page(
        'Payments', // Page title
        'Payments', // Menu title
        'manage_options', // Capability
        'payments-admin', // Menu slug
        'payments_admin_page', // Function to display the page
        'dashicons-money-alt', // Icon
        6 // Position
    );
}

// Handle the form submission
add_action('admin_post_update_payment_status', 'update_payment_status');
function update_payment_status() {
    global $wpdb;

    // Check for necessary permissions and nonce
    if (!current_user_can('manage_options') || !isset($_POST['payment_status_nonce']) || !wp_verify_nonce($_POST['payment_status_nonce'], 'update_payment_status')) {
        wp_die('You do not have sufficient permissions to access this page.');
    }

    // Update the payment status and/or close date in the database
    $table_name = $wpdb->prefix . 'payments';
    $payment_id = intval($_POST['payment_id']);
    $new_status = isset($_POST['payment_status']) ? sanitize_text_field($_POST['payment_status']) : null;
    $close_date = isset($_POST['close_date']) ? sanitize_text_field($_POST['close_date']) : null;
    $active = isset($_POST['active']) ? sanitize_text_field($_POST['active']) : null;

    $data_to_update = array();
    if ($new_status) {
        $data_to_update['status'] = $new_status;
    }
    if ($close_date) {
        $data_to_update['close_date'] = $close_date;
    }
    if ($active) {
        $data_to_update['active'] = $active;
    }

    // var_dump($data_to_update);

    if (!empty($data_to_update)) {
        $wpdb->update(
            $table_name,
            $data_to_update,
            array('id' => $payment_id)
        );
    }

    // Redirect back to the payments page
    wp_redirect(admin_url('admin.php?page=payments-admin'));
    exit;
}

// Display the payments admin page with pagination and action column
function payments_admin_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'payments';

    // Set up pagination variables
    $items_per_page = 20;
    $page = isset($_GET['pageno']) ? max(0, intval($_GET['pageno'] - 1)) : 0;
    $offset = $page * $items_per_page;

    // Fetch total number of records
    $total_query = "SELECT COUNT(1) FROM $table_name";
    $total = $wpdb->get_var($total_query);

    // Fetch data with pagination and order by most recent
    $payments = $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM $table_name ORDER BY payment_date DESC LIMIT %d OFFSET %d",
        $items_per_page,
        $offset
    ));

    // Display data
    echo '<div class="wrap">';
    echo '<h1>Payments</h1>';
    echo '<table class="wp-list-table widefat fixed striped">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>ID</th>';
    echo '<th>User</th>';
    echo '<th>Price</th>';
    echo '<th>Amount</th>';
    echo '<th>Payment Date</th>';
    echo '<th>Payment Completed</th>';
    echo '<th width="130">Close Date</th>';
    echo '<th>Package Title</th>';
    echo '<th>Number of Sessions</th>';
    echo '<th>Booking Sessions</th>';
    echo '<th>Status</th>';
    echo '<th>Active</th>';
    echo '<th>Action</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    if ($payments) {
        foreach ($payments as $payment) {
            $user_info = get_userdata($payment->user_id);
            $user_name = $user_info ? $user_info->display_name : 'Unknown User';
            $user_link = $user_info ? '<a href="' . esc_url(get_edit_user_link($payment->user_id)) . '">' . esc_html($user_name) . '</a>' : 'Unknown User';

            echo '<tr>';
            echo '<td>' . esc_html($payment->id) . '</td>';
            echo '<td>' . $user_link . '</td>';
            echo '<td>' . esc_html($payment->price) . '</td>';
            echo '<td>' . esc_html($payment->amount) . '</td>';
            echo '<td>' . esc_html($payment->payment_date) . '</td>';
            echo '<td>' . esc_html($payment->payment_completed) . '</td>';
            echo '<td>';

            echo '<form method="post" action="' . esc_url(admin_url('admin-post.php')) . '" id="payment-form-' . esc_attr($payment->id) . '">';
            echo '<input type="hidden" name="action" value="update_payment_status">';
            echo '<input type="hidden" name="payment_id" value="' . esc_attr($payment->id) . '">';
            wp_nonce_field('update_payment_status', 'payment_status_nonce');

            if ($payment->close_date && $payment->close_date !== '0000-00-00 00:00:00') {
                echo '<input type="date" name="close_date" value="' . esc_attr(date('Y-m-d', strtotime($payment->close_date))) . '" style="width: 100%;">';
            } else {
                echo '<input type="date" name="close_date" placeholder="YYYY-MM-DD" style="width: 100%;">';
            }

            echo '</td>';
            echo '<td>' . esc_html($payment->package_title) . '</td>';
            echo '<td>' . esc_html($payment->number_sessions) . '</td>';
            echo '<td>' . esc_html($payment->booking_sessions) . '</td>';
            echo '<td>';

            echo '<select name="payment_status">';
            $statuses = array('Pending', 'Completed', 'Failed', 'Refunded'); // Add your custom statuses here
            foreach ($statuses as $status) {
                echo '<option value="' . esc_attr($status) . '" ' . selected($payment->status, $status, false) . '>' . esc_html($status) . '</option>';
            }
            echo '</select>';

            echo '</td>';
            // echo '<td>' . esc_html($payment->active) . '</td>';

            echo '<td>';
            echo '<select name="active">';
            $statusesActive = array('0', '1'); // Add your custom statuses here
            foreach ($statusesActive as $status) {
                echo '<option value="' . esc_attr($status) . '" ' . selected($payment->active, $status, false) . '>' . esc_html($status) . '</option>';
            }
            echo '</select>';
            echo '</td>';

            echo '<td>';

            echo '<button type="submit" class="button button-small">';
            echo '<span class="dashicons dashicons-yes"></span> Save';
            echo '</button>';
            echo '</td>';

            echo '</form>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="14">No payments found.</td></tr>';
    }

    echo '</tbody>';
    echo '</table>';

    // Pagination
    $current_page = isset($_GET['pageno']) ? (int) $_GET['pageno'] : 1;
    $total_pages = ceil($total / $items_per_page);

    echo '<div class="pagination">';
    for ($i = 1; $i <= $total_pages; $i++) {
        $class = ($i === $current_page) ? ' class="active"' : '';
        echo '<a href="?page=payments-admin&pageno=' . $i . '"' . $class . '>' . $i . '</a> ';
    }
    echo '</div>';

    echo '</div>';
}
?>
