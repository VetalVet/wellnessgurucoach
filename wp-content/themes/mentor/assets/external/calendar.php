<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 1);
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

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
        "SELECT TIME_FORMAT(datetime, '%H:00') FROM {$table_name_bookings} WHERE DATE(datetime) = %s",
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
?>
