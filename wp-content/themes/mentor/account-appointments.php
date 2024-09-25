<?php


/*
    Template Name: Account - Appointments
*/

get_header();

die();

global $wpdb;
$table_cpappbk_messages = $wpdb->prefix . 'cpappbk_messages';
$table_booking = $wpdb->prefix . 'booking';
$table_users = $wpdb->prefix . 'users';
$table_payments = $wpdb->prefix . 'payments';

$message_ids = $wpdb->get_col("SELECT id FROM {$table_cpappbk_messages}");

//print_r($message_ids);

foreach ($message_ids as $id) {

    $exists = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM {$table_booking} WHERE cpappbk_id = %d", $id));

    //echo $exists;

    if ($exists == 0) {
        // Додавання нового запису з додатковими даними

        $cpappbk = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$table_cpappbk_messages} WHERE id = %d", $id), ARRAY_A);
        $posted_data = unserialize($cpappbk[0]['posted_data']);

        $user_id = $wpdb->get_col($wpdb->prepare("SELECT id FROM {$table_users} WHERE user_login = %s", $posted_data['username']));

        $app_date = $posted_data['app_date_1'];
        $app_starttime = $posted_data['app_starttime_1'];
        // Створюємо об'єкт DateTime із заданим форматом
        $datetime = DateTime::createFromFormat('m/d/Y H:i', $app_date . ' ' . $app_starttime);
        // Перетворюємо DateTime об'єкт у строку в форматі SQL datetime
        $datetime_string = $datetime->format('Y-m-d H:i:s');

        $wpdb->insert(
            $table_booking,
            array(
                'cpappbk_id' => $id,
                'user_id' => $user_id[0], // Припускаємо, що user_id це ID поточного користувача
                'datetime' => $datetime_string // Запис поточної дати та часу
            ),
            array(
                '%d', // формат для cpappbk_id
                '%d', // формат для user_id
                '%s'  // формат для datetime
            )
        );

        // Оновити booking_sessions у активній підписці
        $active_payment = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$table_payments} WHERE user_id = %d AND active = 1 ORDER BY id DESC LIMIT 1",
            $user_id
        ));

        if ($active_payment) {
            $new_booking_sessions = $active_payment->booking_sessions + 1;
            $wpdb->update(
                $table_payments,
                array('booking_sessions' => $new_booking_sessions),
                array('id' => $active_payment->id),
                array('%d'),
                array('%d')
            );
        }
    }
}

?>

<section class="office">
    <span class="office__decore-border"></span>
    <div class="container">
        <h2 class="office__title">
            Appointments
        </h2>
        <div class="office__container">
            <aside class="office__sidebar">
                <?php require_once(__DIR__ . '/modules/acount/sidebar-acount.php');?>
            </aside>
            <section class="appointments">
                <h3 class="appointments__title">
                    Make an Appointment
                </h3>
                <div class="appointments__calendar">
                    <div class="calendar big"></div>
                </div>


                <div class="appointmets__history">
                    <h4 class="appointments__title">Appointments History</h4>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php

                        $user_id = get_current_user_id(); // Отримуємо ID поточного користувача

                        $bookings = $wpdb->get_results($wpdb->prepare(
                            "SELECT datetime, status FROM {$table_booking} WHERE user_id = %d ORDER BY datetime DESC",
                            $user_id
                        ));

                        if ($bookings) {

                            foreach ($bookings as $booking) {
                                echo '<tr>';
                                $date = date('d.m.Y', strtotime($booking->datetime)); // Форматуємо дату
                                $time = date('H:i', strtotime($booking->datetime)); // Форматуємо час

                                echo '<td>'.$date.'</td>';
                                echo '<td>'.$time.'</td>';
                                echo '<td></td>';

                                echo '</tr>';
                            }

                        }
                        else {

                            echo '<tr><td></td></tr>';

                        }

                        ?>

                        </tbody>
                    </table>
                </div>

<!--                <div class="appointmets__history">-->
<!--                    <h4 class="appointments__title">-->
<!--                        Appointments History-->
<!--                    </h4>-->
<!--                    <ul class="appointments__paymentsh-table">-->
<!--                        <li class="appointments__item-title">-->
<!--                            Date-->
<!--                        </li>-->
<!--                        <li class="appointments__item-title">-->
<!--                            Time-->
<!--                        </li>-->
<!--                        <li class="appointments__item-title">-->
<!--                            Status-->
<!--                        </li>-->
<!--                        <li class="appointments__item-data">-->
<!--                            01.02.2023-->
<!--                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">-->
<!--                                <path d="M12 1.99799C17.524 1.99799 22.002 6.47599 22.002 12C22.002 17.523 17.524 22 12 22C6.476 22.001 2 17.523 2 12C1.999 6.47599 6.476 1.99799 12 1.99799ZM12 3.49799C10.8758 3.48579 9.76036 3.69669 8.71822 4.11846C7.67607 4.54023 6.72793 5.16451 5.92866 5.95515C5.12939 6.7458 4.49487 7.68712 4.06182 8.72463C3.62877 9.76213 3.4058 10.8752 3.4058 11.9995C3.4058 13.1237 3.62877 14.2368 4.06182 15.2743C4.49487 16.3119 5.12939 17.2532 5.92866 18.0438C6.72793 18.8345 7.67607 19.4587 8.71822 19.8805C9.76036 20.3023 10.8758 20.5132 12 20.501C14.2388 20.4767 16.3776 19.5703 17.9521 17.9786C19.5267 16.3869 20.4098 14.2384 20.4098 11.9995C20.4098 9.76059 19.5267 7.61205 17.9521 6.02035C16.3776 4.42865 14.2388 3.52227 12 3.49799ZM11.996 10.498C12.1774 10.4978 12.3528 10.5633 12.4896 10.6824C12.6264 10.8016 12.7153 10.9663 12.74 11.146L12.747 11.248L12.751 16.75C12.7529 16.9414 12.6817 17.1262 12.5517 17.2668C12.4218 17.4073 12.2431 17.4928 12.0521 17.5059C11.8612 17.5189 11.6725 17.4585 11.5247 17.3369C11.3768 17.2153 11.2811 17.0419 11.257 16.852L11.251 16.751L11.247 11.249C11.247 11.0501 11.326 10.8593 11.4667 10.7187C11.6073 10.578 11.7981 10.499 11.997 10.499M12.002 7.00199C12.1358 6.99775 12.2691 7.02045 12.3939 7.06872C12.5187 7.11699 12.6326 7.18986 12.7287 7.283C12.8249 7.37614 12.9013 7.48764 12.9535 7.6109C13.0057 7.73415 13.0326 7.86663 13.0326 8.00049C13.0326 8.13434 13.0057 8.26682 12.9535 8.39007C12.9013 8.51333 12.8249 8.62483 12.7287 8.71797C12.6326 8.81111 12.5187 8.88398 12.3939 8.93225C12.2691 8.98053 12.1358 9.00322 12.002 8.99899C11.7427 8.99078 11.4967 8.88198 11.3161 8.69562C11.1356 8.50926 11.0346 8.25996 11.0346 8.00049C11.0346 7.74101 11.1356 7.49171 11.3161 7.30535C11.4967 7.11899 11.7427 7.01019 12.002 7.00199Z" fill="#37B048" fill-opacity="0.6"/>-->
<!--                            </svg>-->
<!--                        </li>-->
<!--                        <li class="appointments__item-data">-->
<!--                            12:00-->
<!--                        </li>-->
<!--                        <li class="appointments__item-data active">-->
<!--                            Scheduled-->
<!--                        </li>-->
<!--                    </ul>-->
<!--                </div>-->
            </section>
        </div>
    </div>
</section>

<?php get_footer(); ?>