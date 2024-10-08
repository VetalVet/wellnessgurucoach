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
    $payment_completed = isset($_POST['payment_completed']) ? $_POST['payment_completed'] : null;
    $active = isset($_POST['active']) ? sanitize_text_field($_POST['active']) : null;

    $data_to_update = array();
    if ($new_status) {
        $data_to_update['status'] = $new_status;
    }
    if ($close_date) {
        $data_to_update['close_date'] = $close_date;
    }
    if ($payment_completed) {
        $data_to_update['payment_completed'] = $payment_completed;
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
            // echo '<td>' . esc_html($payment->payment_completed) . '</td>';
            // echo '<td>';

            echo '<form method="post" action="' . esc_url(admin_url('admin-post.php')) . '" id="payment-form-' . esc_attr($payment->id) . '">';
            echo '<input type="hidden" name="action" value="update_payment_status">';
            echo '<input type="hidden" name="payment_id" value="' . esc_attr($payment->id) . '">';
            wp_nonce_field('update_payment_status', 'payment_status_nonce');

            echo '<td>';
            if ($payment->payment_completed && $payment->payment_completed !== '0000-00-00 00:00:00') {
                echo '<input type="date" name="payment_completed" value="' . esc_attr(date('Y-m-d', strtotime($payment->payment_completed))) . '" style="width: 100%;">';
            } else {
                echo '<input type="date" name="payment_completed" placeholder="YYYY-MM-DD" style="width: 100%;">';
            }
            echo '</td>';

            echo '<td>';
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

function wp_new_user_notification( $user_id, $deprecated = null, $notify = '' ) {
    if ( null !== $deprecated ) {
        _deprecated_argument( __FUNCTION__, '4.3.1' );
    }

    // Accepts only 'user', 'admin' , 'both' or default '' as $notify.
    if ( ! in_array( $notify, array( 'user', 'admin', 'both', '' ), true ) ) {
        return;
    }

    $user = get_userdata( $user_id );

    /*
     * The blogname option is escaped with esc_html() on the way into the database in sanitize_option().
     * We want to reverse this for the plain text arena of emails.
     */
    $blogname = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );

    /**
     * Filters whether the admin is notified of a new user registration.
     *
     * @since 6.1.0
     *
     * @param bool    $send Whether to send the email. Default true.
     * @param WP_User $user User object for new user.
     */
    $send_notification_to_admin = apply_filters( 'wp_send_new_user_notification_to_admin', true, $user );

    if ( 'user' !== $notify && true === $send_notification_to_admin ) {
        $switched_locale = switch_to_locale( get_locale() );

        $message = "
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                .email-container {
                    font-family: Arial, sans-serif;
                    background-color: #FAF9F6;
                    max-width: 600px;
                    margin: 0 auto;
                }

                .email-header {
                    text-align: center;
                    font-size: 20px;
                    font-weight: bold;
                    padding-left: 20px;
                    background-color: #f0eee6;
                    height: 120px;
                }

                .email-content {
                    margin: 30px;
                }

                .email-content p {
                    margin: 10px 0;
                }

                .email-footer {
                    margin-top: 20px;
                    text-align: center;
                    font-size: 0px;
                    color: #777;
                    background-color: #f0eee6;
                    padding: 10px 20px;
                    height: 60px;
                }

                .line {
                    height: 2px;
                    background-color: #37B048;
                    margin: 20px 0;
                }

                @media (max-width: 400px) {
                    .email-container {
                        max-width: none;
                    }
                    .email-header {
                        text-align: center;
                        font-size: 20px;
                        font-weight: bold;
                        padding-left: 20px;
                        background-color: #f0eee6;
                        height: 90px;
                    }
                }
            </style>
        </head>

        <body>
            <div class='email-container'>
                <div class='email-header'>
                    <a href='https://wellnessgurucoach.com/' style='float: left; max-width: 50%; padding: 20px 0;'>
                        <img width='206' height='75' style='width: 100%;height: 100%;' src='https://wellnessgurucoach.com/wp-content/uploads/2024/09/logo-2.svg' alt=''>
                    </a>

                    <div class='header_image' style='float: right; max-width: 40%; width: 100%;height: 100%;'>
                        <img style='width: 100%;height: 100%;' src='https://wellnessgurucoach.com/wp-content/uploads/2024/09/image-13.jpg' alt=''>
                    </div>
                </div>

                <div class='line'></div>

                <div class='email-content'>
        ";

        /* translators: %s: Site title. */
        $message .= sprintf( __( 'New user registration on your site %s:' ), $blogname ) . "\r\n\r\n";
        /* translators: %s: User login. */
        $message .= sprintf( __( 'Username: %s' ), $user->user_login ) . "\r\n\r\n";
        /* translators: %s: User email address. */
        $message .= sprintf( __( 'Email: %s' ), $user->user_email ) . "\r\n";

        $message .= "
                </div>
                <div class='line'></div>

                <div class='email-footer'>
                    <a style='float: left; margin-top: 9px;' href='https://wellnessgurucoach.com/'>
                        <img width='104' height='38' src='https://wellnessgurucoach.com/wp-content/uploads/2024/09/logo-1.svg' alt=''>
                    </a>

                    <div style='float: right; margin-top: 17px;' class='socials'>
                        <a href='https://www.instagram.com/marina_wellnessguru/'>
                            <img width='25' height='25' src='https://wellnessgurucoach.com/wp-content/uploads/2024/10/vector.svg' alt=''>
                        </a>
                        <a style='margin-left: 10px;' href='https://www.facebook.com/marina.vaysbaum'>
                            <img width='25' height='25' src='https://wellnessgurucoach.com/wp-content/uploads/2024/10/fa-brands_facebook.svg' alt=''>
                        </a>
                    </div>
                </div>
            </div>
        </body>
        </html>
        ";

        $wp_new_user_notification_email_admin = array(
            'to'      => get_option( 'admin_email' ),
            /* translators: New user registration notification email subject. %s: Site title. */
            'subject' => __( '[%s] New User Registration' ),
            'message' => $message,
            'headers' => 'Content-Type: text/html; charset=UTF-8',
        );

        /**
         * Filters the contents of the new user notification email sent to the site admin.
         *
         * @since 4.9.0
         *
         * @param array   $wp_new_user_notification_email_admin {
         *     Used to build wp_mail().
         *
         *     @type string $to      The intended recipient - site admin email address.
         *     @type string $subject The subject of the email.
         *     @type string $message The body of the email.
         *     @type string $headers The headers of the email.
         * }
         * @param WP_User $user     User object for new user.
         * @param string  $blogname The site title.
         */
        $wp_new_user_notification_email_admin = apply_filters( 'wp_new_user_notification_email_admin', $wp_new_user_notification_email_admin, $user, $blogname );

        wp_mail(
            $wp_new_user_notification_email_admin['to'],
            wp_specialchars_decode( sprintf( $wp_new_user_notification_email_admin['subject'], $blogname ) ),
            $wp_new_user_notification_email_admin['message'],
            $wp_new_user_notification_email_admin['headers']
        );

        if ( $switched_locale ) {
            restore_previous_locale();
        }
    }

    /**
     * Filters whether the user is notified of their new user registration.
     *
     * @since 6.1.0
     *
     * @param bool    $send Whether to send the email. Default true.
     * @param WP_User $user User object for new user.
     */
    $send_notification_to_user = apply_filters( 'wp_send_new_user_notification_to_user', true, $user );

    // `$deprecated` was pre-4.3 `$plaintext_pass`. An empty `$plaintext_pass` didn't sent a user notification.
    if ( 'admin' === $notify || true !== $send_notification_to_user || ( empty( $deprecated ) && empty( $notify ) ) ) {
        return;
    }

    $key = get_password_reset_key( $user );
    if ( is_wp_error( $key ) ) {
        return;
    }

    $switched_locale = switch_to_user_locale( $user_id );

    /* translators: %s: User login. */
    $message = "
    <!DOCTYPE html>
	<html>
	<head>
		<style>
			.email-container {
				font-family: Arial, sans-serif;
				background-color: #FAF9F6;
				max-width: 600px;
				margin: 0 auto;
			}

			.email-header {
				text-align: center;
				font-size: 20px;
				font-weight: bold;
				padding-left: 20px;
				background-color: #f0eee6;
				height: 120px;
			}

			.email-content {
				margin: 30px;
			}

			.email-content p {
				margin: 10px 0;
			}

			.email-footer {
				margin-top: 20px;
				text-align: center;
				font-size: 0px;
				color: #777;
				background-color: #f0eee6;
				padding: 10px 20px;
				height: 60px;
			}

			.line {
				height: 2px;
				background-color: #37B048;
				margin: 20px 0;
			}

			@media (max-width: 400px) {
				.email-container {
					max-width: none;
				}
				.email-header {
					text-align: center;
					font-size: 20px;
					font-weight: bold;
					padding-left: 20px;
					background-color: #f0eee6;
					height: 90px;
				}
			}
		</style>
	</head>

	<body>
		<div class='email-container'>
			<div class='email-header'>
				<a href='https://wellnessgurucoach.com/' style='float: left; max-width: 50%; padding: 20px 0;'>
					<img width='206' height='75' style='width: 100%;height: 100%;' src='https://wellnessgurucoach.com/wp-content/uploads/2024/09/logo-2.svg' alt=''>
				</a>

				<div class='header_image' style='float: right; max-width: 40%; width: 100%;height: 100%;'>
					<img style='width: 100%;height: 100%;' src='https://wellnessgurucoach.com/wp-content/uploads/2024/09/image-13.jpg' alt=''>
				</div>
			</div>

			<div class='line'></div>

			<div class='email-content'>
    ";

    $message .= sprintf( __( 'Username: %s' ), $user->user_login ) . "\r\n\r\n";
    $message .= __( 'To set your password, visit the following address:' ) . "\r\n\r\n";
    $message .= network_site_url( "wp-login.php?action=rp&key=$key&login=" . rawurlencode( $user->user_login ), 'login' ) . "\r\n\r\n";

    $message .= wp_login_url() . "\r\n";


    $message .= "
            </div>
			<div class='line'></div>

			<div class='email-footer'>
				<a style='float: left; margin-top: 9px;' href='https://wellnessgurucoach.com/'>
					<img width='104' height='38' src='https://wellnessgurucoach.com/wp-content/uploads/2024/09/logo-1.svg' alt=''>
				</a>

				<div style='float: right; margin-top: 17px;' class='socials'>
					<a href='https://www.instagram.com/marina_wellnessguru/'>
						<img width='25' height='25' src='https://wellnessgurucoach.com/wp-content/uploads/2024/10/vector.svg' alt=''>
					</a>
					<a style='margin-left: 10px;' href='https://www.facebook.com/marina.vaysbaum'>
						<img width='25' height='25' src='https://wellnessgurucoach.com/wp-content/uploads/2024/10/fa-brands_facebook.svg' alt=''>
					</a>
				</div>
			</div>
		</div>
	</body>
	</html>
    ";

    $wp_new_user_notification_email = array(
        'to'      => $user->user_email,
        /* translators: Login details notification email subject. %s: Site title. */
        'subject' => __( '[%s] Login Details' ),
        'message' => $message,
        'headers' => 'Content-Type: text/html; charset=UTF-8',
    );

    /**
     * Filters the contents of the new user notification email sent to the new user.
     *
     * @since 4.9.0
     *
     * @param array   $wp_new_user_notification_email {
     *     Used to build wp_mail().
     *
     *     @type string $to      The intended recipient - New user email address.
     *     @type string $subject The subject of the email.
     *     @type string $message The body of the email.
     *     @type string $headers The headers of the email.
     * }
     * @param WP_User $user     User object for new user.
     * @param string  $blogname The site title.
     */
    $wp_new_user_notification_email = apply_filters( 'wp_new_user_notification_email', $wp_new_user_notification_email, $user, $blogname );

    wp_mail(
        $wp_new_user_notification_email['to'],
        wp_specialchars_decode( sprintf( $wp_new_user_notification_email['subject'], $blogname ) ),
        $wp_new_user_notification_email['message'],
        $wp_new_user_notification_email['headers']
    );

    if ( $switched_locale ) {
        restore_previous_locale();
    }
}
?>
