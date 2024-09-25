<?php

add_action('wp_ajax_check_date', 'handle_check_date');
add_action('wp_ajax_nopriv_check_date', 'handle_check_date'); // Якщо потрібен доступ для неавторизованих користувачів

function handle_check_date() {
    // Отримання дати з $_POST і проведення необхідної обробки
    $date = isset($_POST['date']) ? sanitize_text_field($_POST['date']) : '';

    // Тут ваша логіка отримання доступних часів або інша обробка
    // Наприклад, отримання часів з бази даних або зовнішнього API
    $times = get_available_times($date); // Функція, яка повертає доступні часи для дати

    // Перевірка, що $times має правильні дані перед відправкою
    if (!is_array($times)) {
        wp_send_json_error('Error retrieving times');
    }

    wp_send_json_success(['times' => $times]); // Відправка відповіді назад до JavaScript
}

function get_available_times($date) {
    global $wpdb;
    $table_name_settings = $wpdb->prefix . 'booking_settings';
    $table_booking = $wpdb->prefix . 'booking';
    $table_booking_dates = $wpdb->prefix . 'booking_dates';

    $schedule_data = $wpdb->get_var("SELECT schedule_weeks FROM {$table_name_settings} ORDER BY id DESC LIMIT 1");
    $schedule = unserialize($schedule_data);

    $week_day = date('w', strtotime($date));
    $date_str = date('Y-m-d', strtotime($date));

    $booked_times = $wpdb->get_col($wpdb->prepare(
        "SELECT TIME_FORMAT(datetime, '%H:00') FROM {$table_booking} WHERE DATE(datetime) = %s AND is_deleted = 0",
        $date
    ));

    $custom_times = $wpdb->get_results($wpdb->prepare(
        "SELECT TIME_FORMAT(datetime, '%H:00') as time, is_available FROM {$table_booking_dates} WHERE DATE(datetime) = %s",
        $date
    ), OBJECT_K);

    $available_times = [];
    $all_possible_times = !empty($schedule[$week_day]) ? $schedule[$week_day] : [];

    // Додаємо часи з таблиці booking_dates, які помічені як доступні
    foreach ($custom_times as $time => $details) {
        if ($details->is_available) {
            $all_possible_times[] = $time; // Додаємо час, якщо він доступний
        }
    }

    $all_possible_times = array_unique($all_possible_times); // Видаляємо дублікати

    foreach ($all_possible_times as $hour) {
        $hour_str = sprintf('%02d:00', $hour);
        $time_str = $date_str . ' ' . $hour_str;
        $time_timestamp = strtotime($time_str);
        $current_time = current_time('timestamp');

        $is_custom_available = isset($custom_times[$hour_str]) ? $custom_times[$hour_str]->is_available : true;

        if (!in_array($hour_str, $booked_times) && $is_custom_available && ($time_timestamp > $current_time)) {
            $available_times[] = [
                'hour' => $hour_str,
                'available' => true
            ];
        }
    }

    return $available_times;
}






