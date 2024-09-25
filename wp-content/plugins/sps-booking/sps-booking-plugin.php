<?php
/*
Plugin Name: StartPoint Booking
Plugin URI: https://startpoint.studio
Description: Booking
Version: 1.0
Author: Yevhen Lebediev
Author URI: https://startpoint.studio
License: GPL2
*/

//

date_default_timezone_set('America/New_York');

require_once(plugin_dir_path(__FILE__) . 'availability_checker.php');


add_action('rest_api_init', function () {
    register_rest_route('zabuto/v1', '/events/', array(
        'methods' => 'GET',
        'callback' => 'fetch_calendar_events',
        'permission_callback' => '__return_true'  // Опційно: додайте перевірку прав доступу
    ));
});

function fetch_calendar_events($request)
{
    $year = $request->get_param('year') ?: date('Y');
    $month = $request->get_param('month') ?: date('m');

    global $wpdb;

    $year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');
    $month = isset($_GET['month']) ? str_pad(intval($_GET['month']), 2, '0', STR_PAD_LEFT) : date('m');

    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

// Таблиця з налаштуваннями графіку
    $table_name_settings = $wpdb->prefix . 'booking_settings';
    $schedule_data = $wpdb->get_var("SELECT schedule_weeks FROM {$table_name_settings} ORDER BY id DESC LIMIT 1");
    $weekDays = unserialize($schedule_data);

// Таблиця з інформацією про заброньовані часи
    $table_name_bookings = $wpdb->prefix . 'booking';
    $table_name_dates = $wpdb->prefix . 'booking_dates';

    $arr = array();
    $currentDate = date('Y-m-d');

// Отримуємо всі особливі налаштування днів з booking_dates
    $customDates = $wpdb->get_results("SELECT DATE(datetime) as date, TIME_FORMAT(datetime, '%H:00') as time, is_available FROM $table_name_dates WHERE MONTH(datetime) = $month AND YEAR(datetime) = $year", OBJECT_K);

    for ($day = 1; $day <= $daysInMonth; $day++) {
        $date = sprintf('%s-%s-%02d', $year, $month, $day);
        $weekDay = date('w', strtotime($date));

        // Отримуємо заброньовані часи для даної дати
        $booked_times = $wpdb->get_col($wpdb->prepare(
            "SELECT TIME_FORMAT(datetime, '%H:00') FROM {$table_name_bookings} WHERE DATE(datetime) = %s AND is_deleted = 0",
            $date
        ));

        // Перевіряємо чи день тижня має записи в серіалізованому масиві та чи дата вже не минула
        if ((!isset($weekDays[$weekDay]) || empty($weekDays[$weekDay])) && $date >= $currentDate) {
            $arr[] = array(
                'id' => $day,
                'date' => $date,
                'title' => "Reserved",
                'classname' => "not-available"
            );
        } elseif ($date < $currentDate) {
            $arr[] = array(
                'id' => $day,
                'date' => $date,
                'title' => "Reserved",
                'classname' => "not-available"
            );
        }

        // Перевіряємо чи всі часи на цей день заброньовані
        if (count($booked_times) == count($weekDays[$weekDay])) {
            $arr[] = array(
                'id' => $day,
                'date' => $date,
                'title' => "Fully booked",
                'classname' => "not-available"
            );
        }
    }

    echo json_encode($arr);
    die();

    return new WP_REST_Response($events, 200);
}


add_action('admin_menu', 'setup_custom_schedule_page');

function setup_custom_schedule_page() {
    add_menu_page('Custom Schedule', 'Booking', 'manage_options', 'custom-schedule', 'custom_schedule_page_content', 'dashicons-schedule');
}

function sps_booking_enqueue_scripts() {
    wp_enqueue_script(
        'sps-booking-script', // Handle for your script.
        plugin_dir_url(__FILE__) . 'assets/sps-booking-scripts.js', // Path to your script.
        array('zabuto-calendar'), // Array of dependencies.
        '2.0.0', // Version number.
        true // Load in footer.
    );

    // Змініть handle тут на 'sps-booking-script', як ви вказали в wp_enqueue_script
    wp_localize_script('sps-booking-script', 'spsBookingData', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'action' => 'save_custom_schedule',
        'restUrl' => rest_url('zabuto/v1/events/'),
        'baseUrl' => home_url()
    ));
}
add_action('wp_enqueue_scripts', 'sps_booking_enqueue_scripts');


function sps_booking_admin_enqueue_styles() {
    wp_enqueue_style(
        'sps-booking-admin-style',
        plugin_dir_url(__FILE__) . 'assets/sps-booking-styles.css',
        array(),
        '1.0.0'
    );
}
add_action('admin_enqueue_scripts', 'sps_booking_admin_enqueue_styles');

function custom_schedule_page_content() {

    global $wpdb;
    $table_name = $wpdb->prefix . 'booking_settings';
    $schedule_data = $wpdb->get_var("SELECT schedule_weeks FROM {$table_name} ORDER BY id DESC LIMIT 1");
    // Припускаємо, що ви знаєте ID запису

    $schedule_data = maybe_unserialize($schedule_data);

    $table_booking_dates = $wpdb->prefix . 'booking_dates';
    $bookingDates = $wpdb->get_results("SELECT * FROM {$table_booking_dates} ORDER BY datetime");

    $table_booking = $wpdb->prefix . 'booking';
    $total_query = "SELECT COUNT(1) FROM {$table_booking}";
    $total = $wpdb->get_var($total_query);

    $items_per_page = 50;
    $page = isset($_GET['pageno']) ? max(0, intval($_GET['pageno'] - 1)) : 0;
    $offset = $page * $items_per_page;

    $booking_entries = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$table_booking} ORDER BY datetime DESC LIMIT %d OFFSET %d", $items_per_page, $offset));


    ?>
    <div class="wrap">
        <h1>Booking</h1>
        <h2 class="nav-tab-wrapper">
            <a href="#" class="nav-tab nav-tab-active" id="tab-all-bookings">All Bookings</a>
            <a href="#" class="nav-tab" id="tab-weeks">Weeks</a>
            <a href="#" class="nav-tab" id="tab-other">Custom date</a>
        </h2>

        <div id="tab-all-bookings-content" class="tab-content active">
            <table class="widefat fixed" cellspacing="0">
                <thead>
                <tr>
                    <th>Date Time</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Details</th>
                    <th>ID</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($booking_entries as $entry) { ?>
                    <tr <?php if($entry->is_deleted == 1) { echo 'class="is_deleted"'; }?> >
                        <td><?php echo $entry->datetime; ?></td>
                        <td><a href="<?php echo admin_url('admin.php?page=user-details&user_id=' . $entry->user_id); ?>"><?php echo $entry->first_name; ?> <?php echo $entry->last_name; ?></a></td>
                        <td><?php echo $entry->phone_number; ?></td>
                        <td>
                            Email: <?php echo $entry->email; ?><br>
                        </td>
                        <td><?php echo $entry->id; ?></td>
                        <td><?php if($entry->is_deleted != 1) { ?><button onclick="deleteBooking(<?php echo $entry->id; ?>)">Delete</button><?php } ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <?php
            // Pagination
            $current_page = isset($_GET['pageno']) ? (int) $_GET['pageno'] : 1; // Отримання поточного номера сторінки з URL або встановлення першої сторінки за замовчуванням
            $total_pages = ceil($total / $items_per_page);

            echo '<div class="pagination">';
            for ($i = 1; $i <= $total_pages; $i++) {
                // Перевірка, чи поточний цикл відповідає поточній сторінці
                $class = ($i === $current_page) ? ' class="active"' : '';
                echo '<a href="?page=custom-schedule&pageno=' . $i . '"' . $class . '>' . $i . '</a> ';
            }
            echo '</div>';

            ?>
        </div>

        <script>
            function deleteBooking(id) {
                if(confirm("Are you sure you want to delete this booking?")) {
                    jQuery.ajax({
                        url: ajaxurl,
                        type: 'POST',
                        data: {
                            action: 'soft_delete_booking',
                            id: id
                        },
                        success: function(response) {
                            if (response.success) {
                                alert('Booking deleted successfully.');
                                location.reload();
                            } else {
                                alert('Failed to delete booking.');
                            }
                        }
                    });
                }
            }
        </script>

        <div id="tab-weeks-content" class="tab-content">
            <p>Select weeks and hours</p>
            <div id="weeks-table">
                <!-- Таблиця заповнюється через JavaScript -->
            </div>
            <button id="save-weeks">Save Schedule</button>
        </div>

        <div id="tab-other-content" class="tab-content">

            <p>Content for Other Settings</p>
            <button class="but-booking" onclick="addRow()">Add New Time</button>
            <button id="save-custom-schedule" class="but-booking">Save Schedule</button>
            <table id="custom-schedule-table">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Available</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($bookingDates as $row) {
                    list($date, $time) = explode(' ', $row->datetime); ?>
                    <tr>
                        <td><?php echo esc_html($date); ?></td>
                        <td><?php echo esc_html($time); ?></td>
                        <td><?php echo $row->is_available ? 'Yes' : 'No'; ?></td>
                        <td><button onclick="removeRow(this, <?php echo $row->id; ?>)">Remove</button></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>

        <script>
            function addRow() {
                var table = document.getElementById('custom-schedule-table').getElementsByTagName('tbody')[0];
                var newRow = table.insertRow(table.rows.length);
                var cell1 = newRow.insertCell(0);
                var cell2 = newRow.insertCell(1);
                var cell3 = newRow.insertCell(2);
                var cell4 = newRow.insertCell(3);
                cell1.innerHTML = '<input type="date" name="date[]">';
                cell2.innerHTML = '<input type="time" name="time[]">';
                cell3.innerHTML = '<select name="is_available[]"><option value="1">Available</option><option value="0">Not available</option></select>';
                cell4.innerHTML = '<button onclick="removeRow(this)">Remove</button>';
            }

            jQuery(document).ready(function($) {
                $('#save-custom-schedule').click(function() {
                    var dates = $('input[name="date[]"]').map(function() { return $(this).val(); }).get();
                    var times = $('input[name="time[]"]').map(function() { return $(this).val(); }).get();
                    var availabilities = $('select[name="is_available[]"]').map(function() { return $(this).val(); }).get();

                    $.ajax({
                        url: ajaxurl, // URL до вашого серверного скрипту
                        type: 'POST',
                        data: {
                            action: 'save_custom_schedule', // Назва дії, яка має бути визначена в PHP
                            date: dates,
                            time: times,
                            is_available: availabilities
                        },
                        success: function(response) {
                            if (response.success) {
                                alert('Schedule saved successfully 3!');
                            } else {
                                alert('Error saving schedule.');
                            }
                        },
                        error: function() {
                            alert('Error connecting to server.');
                        }
                    });
                });
            });

            function removeRow(button, id) {

                var row = button.parentNode.parentNode;
                row.parentNode.removeChild(row);
                // Виклик AJAX для видалення запису з бази
                jQuery.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'remove_booking_date',
                        id: id
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('Entry removed successfully!');
                        }
                    }
                });
            }


        </script>

        <script type="text/javascript">
            jQuery(document).ready(function($) {
                $('.nav-tab').click(function(e) {
                    e.preventDefault();
                    $('.nav-tab').removeClass('nav-tab-active');
                    $('.tab-content').removeClass('active');

                    $(this).addClass('nav-tab-active');
                    $('#' + $(this).attr('id') + '-content').addClass('active');
                });
            });
        </script>
        <style>
            .tab-content { display: none; }
            .tab-content.active { display: block; }
        </style>


        <script type="text/javascript">

            function initializeEmptySchedule() {
                var schedule = {};
                for (var dayIndex = 0; dayIndex < 7; dayIndex++) {
                    schedule[dayIndex] = []; // Ініціалізуйте порожнім масивом для кожного дня
                }
                return schedule;
            }

            jQuery(document).ready(function($) {

                var savedData = <?php echo json_encode($schedule_data); ?>;
                if (!savedData || Object.keys(savedData).length === 0) {
                    savedData = initializeEmptySchedule();
                } else {
                    // Забезпечуємо, що всі дні ініціалізовані
                    for (var dayIndex = 0; dayIndex < 7; dayIndex++) {
                        if (!savedData[dayIndex]) {
                            savedData[dayIndex] = [];
                        }
                    }
                }

                var daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']; // Неділя тепер перший день
                var hoursOfDay = Array.from(new Array(24), (val, index) => index + ':00');
                var table = $('<table class="table"></table>').addClass('schedule');



                var headerRow = $('<tr></tr>');
                headerRow.append('<th>Time / Day</th>');
                daysOfWeek.forEach(function(day) {
                    headerRow.append('<th>' + day + '</th>');
                });
                table.append(headerRow);

                hoursOfDay.forEach(function(hour, hourIndex) {
                    var row = $('<tr></tr>');
                    row.append('<td>' + hour + '</td>');
                    daysOfWeek.forEach(function(day, dayIndex) {
                        var isChecked = savedData[dayIndex] && savedData[dayIndex].includes(String(hourIndex));
                        var checkedAttr = isChecked ? ' checked' : '';
                        row.append('<td><input type="checkbox" name="' + dayIndex + '[]' + '" value="' + hourIndex + '"' + checkedAttr + '></td>');
                    });
                    table.append(row);
                });

                $('#weeks-table').append(table);

                $('#save-weeks').click(function() {
                    var scheduleData = {};
                    daysOfWeek.forEach(function(day, dayIndex) {
                        scheduleData[dayIndex] = [];
                        $('input[name="' + dayIndex + '[]"]:checked').each(function() {
                            scheduleData[dayIndex].push($(this).val());
                        });
                    });
                    $.post(ajaxurl, {
                        action: 'save_schedule_data',
                        schedule: JSON.stringify(scheduleData)
                    }, function(response) {
                        alert('Schedule saved!');
                    });
                });
            });

        </script>

    </div>

    <?php
}

add_action('wp_ajax_save_schedule_data', 'handle_save_schedule_data');

function handle_save_schedule_data() {
    global $wpdb;

    $schedule_raw = isset($_POST['schedule']) ? $_POST['schedule'] : '';
    $schedule_data = json_decode(stripslashes($schedule_raw), true);

    // Серіалізація масиву
    $schedule_serialized = serialize($schedule_data);

    $table_name = $wpdb->prefix . 'booking_settings';

    $result = $wpdb->insert(
        $table_name,
        array('schedule_weeks' => $schedule_serialized),
        array('%s')
    );

    if ($result) {
        wp_send_json_success('Data saved successfully.');
    } else {
        wp_send_json_error('Failed to save data.');
    }
}

function create_booking_settings_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'booking_settings';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id bigint(9) NOT NULL AUTO_INCREMENT,
        schedule_weeks text NOT NULL,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
register_activation_hook(__FILE__, 'create_booking_settings_table');

function create_booking_dates_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'booking_dates';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        datetime datetime NOT NULL,
        is_available boolean NOT NULL DEFAULT true,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
register_activation_hook(__FILE__, 'create_booking_dates_table');


add_action('wp_ajax_save_appointment', 'handle_save_appointment');
function handle_save_appointment() {
    global $wpdb;

    $user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;

    // Перевірка заповненості анкети
    if (!is_user_profile_complete($user_id)) {
        wp_send_json_success(array('redirect' => '/interviewer/'));
        exit;
    }

    $table_booking = $wpdb->prefix . 'booking';
    $table_payments = $wpdb->prefix . 'payments';

    $date = isset($_POST['date']) ? sanitize_text_field($_POST['date']) : '';
    $time = isset($_POST['time']) ? sanitize_text_field($_POST['time']) : '';
    $first_name = isset($_POST['modal-first-name']) ? sanitize_text_field($_POST['modal-first-name']) : '';
    $last_name = isset($_POST['modal-last-name']) ? sanitize_text_field($_POST['modal-last-name']) : '';
    $email = isset($_POST['modal-email']) ? sanitize_email($_POST['modal-email']) : '';
    $number = isset($_POST['modal-number']) ? sanitize_text_field($_POST['modal-number']) : '';

    // Перевірка активної підписки користувача
    $active_payment = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM {$table_payments} WHERE user_id = %d AND active = 1 ORDER BY id DESC LIMIT 1",
        $user_id
    ));

    if (!$active_payment) {
        // Перевірка попередніх бронювань користувача
        $previous_booking = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$table_booking} WHERE user_id = %d AND is_deleted = 0 LIMIT 1",
            $user_id
        ));

        if ($previous_booking) {
            wp_send_json_success(array('redirect' => '/account-program/?message=no_program'));
            exit;
        }
    } else {
        // Перевірка кількості залишкових сесій
        $number_sessions = $active_payment->number_sessions;
        $booking_sessions = $active_payment->booking_sessions;

        if ($booking_sessions >= $number_sessions) {
            wp_send_json_success(array('redirect' => '/account-program/?message=no_program'));
            exit;
        }
    }

    // Процес бронювання
    $datetime = $date . ' ' . $time;

    $result = $wpdb->insert(
        $table_booking,
        array(
            'user_id' => $user_id,
            'datetime' => $datetime,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'phone_number' => $number
        ),
        array('%d', '%s', '%s', '%s', '%s', '%s')
    );

    if ($result) {
        if ($active_payment) {
            $new_booking_sessions = $active_payment->booking_sessions + 1;
            $update_data = array('booking_sessions' => $new_booking_sessions);
            if ($new_booking_sessions >= $active_payment->number_sessions) {
                $update_data['active'] = 0;
            }

            $wpdb->update(
                $table_payments,
                $update_data,
                array('id' => $active_payment->id),
                array('%d', '%d')
            );
        }

        $to = get_option('booking_email');
        if (!$to) {
            $to = get_option('admin_email'); // Якщо кастомна адреса не задана, використовуємо email адміністратора
        }

        ob_start();
        include('email-neworder.php');
        $email_template = ob_get_clean();

        // Формування контенту листа
        $content = "
        <p><strong>First Name:</strong> $first_name</p>
        <p><strong>Last Name:</strong> $last_name</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Phone Number:</strong> $number</p><br><br>
        <p><strong>Booking Info:</strong></p>
        <p><strong>Date:</strong> $datetime</p>
    ";

        // Підставлення контенту в шаблон
        $message = str_replace('{{content}}', $content, $email_template);

        $mail_sent = send_mail_smtp($to, 'New Booking', $message);

        if ($mail_sent) {
            wp_send_json_success(array('message' => 'Appointment saved successfully.', 'redirect' => '/appointments/'));
        } else {
            error_log('Failed to send email to ' . $to);
            wp_send_json_error('Failed to send email.');
        }

    } else {
        error_log('Failed to save appointment: ' . $wpdb->last_error);
        wp_send_json_error('Failed to save appointment: ' . $wpdb->last_error);
    }
}



add_action('wp_ajax_save_custom_schedule', 'handle_save_custom_schedule');
add_action('wp_ajax_nopriv_save_custom_schedule', 'handle_save_custom_schedule');

function handle_save_custom_schedule() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'booking_dates';

    $dates = isset($_POST['date']) ? $_POST['date'] : array();
    $times = isset($_POST['time']) ? $_POST['time'] : array();
    $availabilities = isset($_POST['is_available']) ? $_POST['is_available'] : array();

    $errors = [];
    $success = 0;
    foreach ($dates as $index => $date) {
        if (!empty($date) && !empty($times[$index]) && isset($availabilities[$index])) {
            $datetime = sanitize_text_field($date) . ' ' . sanitize_text_field($times[$index]);
            $is_available = filter_var($availabilities[$index], FILTER_VALIDATE_BOOLEAN);
            $result = $wpdb->insert(
                $table_name,
                array(
                    'datetime' => $datetime,
                    'is_available' => $is_available
                ),
                array('%s', '%d')
            );
            if ($result) {
                $success++;
            } else {
                $errors[] = "Failed to save the entry for datetime: $datetime";
            }
        }
    }

    if (empty($errors)) {
        wp_send_json_success('Successfully saved ' . $success . ' entries.');
    } else {
        wp_send_json_error(implode(', ', $errors));
    }
}

add_action('wp_ajax_remove_booking_date', 'handle_remove_booking_date');
function handle_remove_booking_date() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'booking_dates';
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

    if ($id) {
        $result = $wpdb->delete($table_name, ['id' => $id], ['%d']);
        if ($result) {
            wp_send_json_success('Entry removed successfully.');
        } else {
            wp_send_json_error('Failed to remove entry.');
        }
    } else {
        wp_send_json_error('Invalid ID.');
    }
}

function register_user_details_page() {
    add_submenu_page(
        null, // Зробити сторінку прихованою
        'User Details', // Назва сторінки
        'User Details', // Заголовок в меню
        'manage_options', // Капабіліті
        'user-details',
        'user_details_page_content' // Функція, яка виводить контент сторінки
    );
}
add_action('admin_menu', 'register_user_details_page');

function user_details_page_content() {
    global $wpdb;

    $table_users = $wpdb->prefix . 'users';
    $table_usermeta = $wpdb->prefix . 'usermeta';

    $user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
    $user = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$table_users} WHERE ID = %d", $user_id));

    if ($user) {
        $user_meta_array = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$table_usermeta} WHERE user_id = %d", $user->ID));

        $user_meta_data = []; // Ініціалізація порожнього асоціативного масиву

        foreach ($user_meta_array as $meta) {
            $user_meta_data[$meta->meta_key] = $meta->meta_value;
        }


        include(plugin_dir_path(__FILE__) . 'user-details-template.php');
    } else {
        echo '<p>User not found.</p>';
    }
}

add_action('wp_ajax_soft_delete_booking', 'handle_soft_delete_booking');
function handle_soft_delete_booking() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'booking';
    $table_payments = $wpdb->prefix . 'payments';
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

    if ($id) {
        // Get the user_id of the booking to be deleted
        $user_id = $wpdb->get_var($wpdb->prepare("SELECT user_id FROM $table_name WHERE id = %d", $id));

        // Soft delete the booking
        $result = $wpdb->update(
            $table_name,
            array('is_deleted' => 1),
            array('id' => $id),
            array('%d'),
            array('%d')
        );

        if ($result !== false) {
            // Update the booking_sessions in the payments table
            $active_payment = $wpdb->get_row($wpdb->prepare(
                "SELECT id, booking_sessions FROM $table_payments WHERE user_id = %d AND active = 1 ORDER BY id DESC LIMIT 1",
                $user_id
            ));

            if ($active_payment) {
                $new_booking_sessions = max(0, $active_payment->booking_sessions - 1); // Ensure it doesn't go below 0
                $wpdb->update(
                    $table_payments,
                    array('booking_sessions' => $new_booking_sessions),
                    array('id' => $active_payment->id),
                    array('%d'),
                    array('%d')
                );
            }

            wp_send_json_success('Booking marked as deleted and payment session updated.');
        } else {
            wp_send_json_error('Failed to mark booking as deleted.');
        }
    } else {
        wp_send_json_error('Invalid ID.');
    }
}



