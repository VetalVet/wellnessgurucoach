<?php

require_once __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

date_default_timezone_set('America/New_York');

// Додайте цей код у файл functions.php вашої теми

function send_mail($to, $subject, $body) {
    $from_email = 'info@wellnessgurucoach.com';
    $from_name = 'Wellness Guru';
    $headers = "From: $from_name <$from_email>\r\n";
    $headers .= "Reply-To: $from_email\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    if (mail($to, $subject, $body, $headers)) {
        return true;
    } else {
        error_log("Message could not be sent.");
        return false;
    }
}

function send_mail_smtp($to, $subject, $body) {
    require_once __DIR__ . '/vendor/autoload.php'; // Підключення автозавантажувача Composer

    $from_email = 'marina.wellnessguru@gmail.com';
    $from_name = 'Wellness Guru';
    $smtp_server = 'smtp.gmail.com';
    $smtp_port = 587;
    $smtp_user = 'marina.wellnessguru@gmail.com';
    $smtp_pass = 'ayyk azwy gqzm rzli'; // Вставте свій фактичний пароль

    $mail = new PHPMailer(true);

    try {
        // Налаштування сервера
        $mail->isSMTP();
        $mail->Host       = $smtp_server;
        $mail->SMTPAuth   = true;
        $mail->Username   = $smtp_user;
        $mail->Password   = $smtp_pass;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = $smtp_port;

        // Відправник і отримувач
        $mail->setFrom($from_email, $from_name);
        $mail->addAddress($to);

        // Вміст електронного листа
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        // Відправка електронного листа
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}




require_once('functions/acf_option.php');
	// require_once('functions/option_booking_plagin.php');

	add_action('after_setup_theme', 'menta_setup');
	add_action( 'wp_enqueue_scripts', 'menta_scripts');


	function menta_setup(){
		register_nav_menu( 'menu-header','header');
		register_nav_menu( 'menu-footer','footer');
		register_nav_menu( 'menu-acount','acount');
		add_theme_support( 'custom-logo');
		add_theme_support( 'title-tag');
		add_theme_support( 'post-thumbnails');

	}

    add_action('init', 'pre_process_post');

    function pre_process_post() {
        // Ваш код для перехоплення і обробки POST запиту
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['some_data'])) {
            if (check_admin_referer('your_nonce_field')) {

                // Логіка обробки даних
                $data = $_POST['your_form_field'];
                // Збережіть дані в вашу власну таблицю
                global $wpdb;
                $wpdb->insert(
                    $wpdb->prefix . 'your_custom_table',
                    array('data_column' => $data)
                );

                // Перенаправлення користувача
                wp_redirect(home_url('/thank-you-page'));
                exit;
            }
        }
    }

	function menta_scripts(){
		 // Підключення jQuery
		wp_deregister_script('jquery');
		wp_enqueue_script('jquery', get_template_directory_uri() . '/assets/js/jquery-2.2.4.min.js', array(), '2.2.4', true);
		wp_enqueue_script('jquery');


		// Додаємо ваші інші скрипти
		wp_deregister_script('jquery-migrate');
		wp_enqueue_script('jquery-migrate', get_template_directory_uri() . '/assets/js/jquery-migrate-1.2.1.min.js', array('jquery'), '1.2.1', true);
		wp_enqueue_script('jquery-migrate');

		wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/bootstrap/js/bootstrap.min.js', array('jquery'), '3.3.7', true);
		wp_enqueue_script('bootstrap-select', get_template_directory_uri() . '/assets/js/bootstrap-select.min.js', array('jquery'), '1.12.4', true);


		wp_enqueue_script('zabuto-calendar', get_template_directory_uri() . '/assets/js/zabuto_calendar.min.js', array('jquery'), '2.0.3', true);

        // Передаємо дані з PHP в JavaScript
        wp_localize_script('zabuto-calendar', 'zabutoCalendarParams', array(
            'isLoggedIn' => is_user_logged_in(), // Передаємо булеве значення статусу авторизації
            'ajaxUrl' => admin_url('admin-ajax.php') // Передаємо URL для AJAX (якщо потрібно)
            // Можете додати інші параметри, які потрібні для вашого скрипта
        ));



		wp_enqueue_script('jquery-validate', get_template_directory_uri() . '/assets/js/jquery.validate.min.js', array('jquery'), '1.17.0', true);


		//  Ваші скрипти з революційного слайдера та інші
		 wp_enqueue_script('revolution-tools', get_template_directory_uri() . '/assets/revolution/js/jquery.themepunch.tools.min.js', array('jquery'), '5.4.8', true);
		 wp_enqueue_script('revolution-revolution', get_template_directory_uri() . '/assets/revolution/js/jquery.themepunch.revolution.min.js', array('jquery'), '5.4.8', true);
		 wp_enqueue_script('revolution-video', get_template_directory_uri() . '/assets/revolution/js/extensions/revolution.extension.video.min.js', array('jquery'), '2.3.6', true);
		 wp_enqueue_script('revolution-slideanims', get_template_directory_uri() . '/assets/revolution/js/extensions/revolution.extension.slideanims.min.js', array('jquery'), '1.2.1', true);
		 wp_enqueue_script('revolution-actions', get_template_directory_uri() . '/assets/revolution/js/extensions/revolution.extension.actions.min.js', array('jquery'), '1.0', true);
		 wp_enqueue_script('revolution-layeranimation', get_template_directory_uri() . '/assets/revolution/js/extensions/revolution.extension.layeranimation.min.js', array('jquery'), '2.0.0', true);
		 wp_enqueue_script('revolution-kenburn', get_template_directory_uri() . '/assets/revolution/js/extensions/revolution.extension.kenburn.min.js', array('jquery'), '1.0', true);
		 wp_enqueue_script('revolution-navigation', get_template_directory_uri() . '/assets/revolution/js/extensions/revolution.extension.navigation.min.js', array('jquery'), '1.0', true);
		 wp_enqueue_script('revolution-migration', get_template_directory_uri() . '/assets/revolution/js/extensions/revolution.extension.migration.min.js', array('jquery'), '1.0', true);
		 wp_enqueue_script('revolution-parallax', get_template_directory_uri() . '/assets/revolution/js/extensions/revolution.extension.parallax.min.js', array('jquery'), '2.0.0', true);


		//  Підключення вашого власного скрипта
		 wp_enqueue_script('custom-js', get_template_directory_uri() . '/assets/js/custom.js', array('jquery'), '1.1', true);

			//  Підключення вашого власного скрипта
		 wp_enqueue_script('main-js', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '2.2', true);

		  // Подключение стилей Font Awesome
		 wp_enqueue_style('font-awesome', get_template_directory_uri() . '/assets/fonts/font-awesome.css');

		 // Подключение стилей Elegant Fonts
		 wp_enqueue_style('elegant-fonts', get_template_directory_uri() . '/assets/fonts/elegant-fonts.css');
		 // Подключение стилей Bootstrap
		 wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/bootstrap/css/bootstrap.css');

		 // Подключение стилей Zabuto Calendar
		 wp_enqueue_style('zabuto-calendar', get_template_directory_uri() . '/assets/css/zabuto_calendar.min.css');

		 // Подключение стилей Bootstrap Select
		 wp_enqueue_style('bootstrap-select', get_template_directory_uri() . '/assets/css/bootstrap-select.min.css');

		 // Подключение стилей Revolution Slider (settings, layers, navigation)
		 wp_enqueue_style('revolution-settings', get_template_directory_uri() . '/assets/revolution/css/settings.css');
		 wp_enqueue_style('revolution-layers', get_template_directory_uri() . '/assets/revolution/css/layers.css');
		 wp_enqueue_style('revolution-navigation', get_template_directory_uri() . '/assets/revolution/css/navigation.css');

		 // Подключение основных стилей
		 wp_enqueue_style('main-style', get_template_directory_uri() . '/assets/css/main.css', '2.3', true);
		 wp_enqueue_style('custom-style', get_template_directory_uri() . '/assets/css/style.css', '2.1', true);
	}
	add_filter( 'upload_mimes', 'svg_upload_allow' );

	function svg_upload_allow( $mimes ) {
		$mimes['svg']  = 'image/svg+xml';
		return $mimes;
	}

	add_filter( 'wp_check_filetype_and_ext', 'fix_svg_mime_type', 10, 5 );

	function fix_svg_mime_type( $data, $file, $filename, $mimes, $real_mime = '' ){

		// WP 5.1 +
		if( version_compare( $GLOBALS['wp_version'], '5.1.0', '>=' ) )
			$dosvg = in_array( $real_mime, [ 'image/svg', 'image/svg+xml' ] );
		else
			$dosvg = ( '.svg' === strtolower( substr($filename, -4) ) );

		if( $dosvg ){
			if( current_user_can('manage_options') ){
				$data['ext']  = 'svg';
				$data['type'] = 'image/svg+xml';
			}
			else {
				$data['ext'] = $type_and_ext['type'] = false;
			}
		}
		return $data;
	}

	// Передача url в скрипт
	function custom_autocomplete_script(){
		$url_calendar = get_template_directory_uri() . "/assets/external/calendar.json";
		$url_core = get_template_directory_uri() . "/modules/modal-fade.php";
		$url_calendar_php = get_template_directory_uri() . "/assets/external/calendar.php";
		$admin_ajax_url = admin_url('admin-ajax.php');
		$url_authorization_php = get_template_directory_uri() . "/controllers/authorization-office-admin.php";
		$send_mail = get_template_directory_uri()  . "/controllers/mail.php";

		wp_localize_script('custom-js', 'themeData', array('urlCalendar' => $url_calendar));
		wp_localize_script('custom-js', 'themeDataJson', array('urlCalendarPhp' => $admin_ajax_url));
		wp_localize_script('main-js', 'urlData', array('urlCore' => $url_core));
		wp_localize_script('main-js', 'urlDataAuthorization', array('urlAuthorization' => $url_authorization_php));
		wp_localize_script('main-js', 'urlSendMailForm', array('sendMail' => $send_mail));

	}
	add_action('wp_enqueue_scripts', 'custom_autocomplete_script');

    function enqueue_zabuto_calendar_script() {

        // Отримати дані поточного користувача
        $current_user = wp_get_current_user();
        $display_name = $current_user->display_name;
        $name_parts = explode(' ', $display_name, 2); // Розділити на дві частини
        $first_name = $name_parts[0];
        $last_name = isset($name_parts[1]) ? $name_parts[1] : '';

        // Передаємо дані в JavaScript
        wp_localize_script('zabuto-calendar', 'zabutoCalendarParams', array(
            'isLoggedIn' => is_user_logged_in(),
            'currentUser' => array(
                'email' => $current_user->user_email,
                'firstName' => $first_name,
                'lastName' => $last_name,
                'phone' => get_user_meta($current_user->ID, 'phone', true), // припускаємо, що мета поле 'phone' існує
            ),
        ));
    }
    add_action('wp_enqueue_scripts', 'enqueue_zabuto_calendar_script');

	function _menta_assets_path($path){
		return get_template_directory_uri() . '/assets/' . $path;
	}


	load_plugin_textdomain('easy-appointments', false, dirname(plugin_basename(__FILE__)) . '/languages/');

	add_action('wp_ajax_calendar', 'my_calendar_function');
	add_action('wp_ajax_nopriv_calendar', 'my_calendar_function');


	function my_calendar_function() {
		// Получаем данные из тела запроса
		$json_data = file_get_contents('php://input');
		$decoded_data = urldecode($json_data);


		// Розбираємо рядок у змінні PHP
		parse_str($decoded_data, $parsed_data);

		$arrayDisabledDays = $parsed_data['arrayDisabledDays'];

		$file_path = __DIR__ .  '/assets/external/calendar.json';

		 // Видаляємо всі дані з файлу перед записом
		file_put_contents($file_path, '');
		  // Записуємо дані у файл
		file_put_contents($file_path, $arrayDisabledDays);

		// Парсим JSON-данные
		$data = json_decode($arrayDisabledDays, true);
		// Доступ к вашим данным через $data['arrayDisabledDays']
		echo json_encode($data);
		// Ваш код обработки AJAX-запроса

		// Завершаем выполнение
		wp_die();
  }

function restrict_admin_access(){
    if (is_admin() && is_user_logged_in() && !current_user_can('administrator') && !(defined('DOING_AJAX') && DOING_AJAX)) {
        wp_redirect(home_url());
        exit;
    }
}
add_action('init', 'restrict_admin_access');

function remove_admin_bar_for_users() {
    if (!current_user_can('administrator') && !is_admin()) {
        show_admin_bar(false);
    }
}
add_action('after_setup_theme', 'remove_admin_bar_for_users');


add_action('wp_ajax_submit_contact_form', 'handle_contact_form_submission');
add_action('wp_ajax_nopriv_submit_contact_form', 'handle_contact_form_submission');  // If you want to allow non-logged-in users to submit the form

function handle_contact_form_submission() {
    if (isset($_POST['data'])) {
        parse_str($_POST['data'], $form_data);  // Parse the serialized form data

        // Now $form_data will contain an associative array of your form items
        // Process your form data here. Example:
        $first_name = sanitize_text_field($form_data['modal-first-name']);
        $last_name = sanitize_text_field($form_data['modal-last-name']);
        $email = sanitize_email($form_data['modal-email']);
        $number = sanitize_text_field($form_data['modal-number']);

        // Implement your form processing logic here
        // For instance, save the data to the database, send email, etc.

        wp_send_json_success('Form processed successfully.');
    } else {
        wp_send_json_error('No data received.');
    }
}

function display_appointments_history() {
    global $wpdb;
    $user_id = get_current_user_id(); // Отримуємо ID поточного користувача
    $bookings = $wpdb->get_results($wpdb->prepare(
        "SELECT datetime, status FROM booking WHERE user_id = %d",
        $user_id
    ));

    if ($bookings) {
        echo '<div class="appointmets__history">
                <h4 class="appointments__title">Appointments History</h4>
                <ul class="appointments__paymentsh-table">';
        foreach ($bookings as $booking) {
            $date = date('d.m.Y', strtotime($booking->datetime)); // Форматуємо дату
            $time = date('H:i', strtotime($booking->datetime)); // Форматуємо час
            echo '<li class="appointments__item-data">' . $date . '</li>';
            echo '<li class="appointments__item-data">' . $time . '</li>';
            echo '<li class="appointments__item-data ' . ($booking->status == 'Scheduled' ? 'active' : '') . '">' . $booking->status . '</li>';
        }
        echo '</ul></div>';
    } else {
        echo '<div class="appointmets__history">
                <h4 class="appointments__title">No Appointments Found</h4>
              </div>';
    }
}

add_action('init', function() {
    if (is_admin()) {
        // Якщо плагін використовує глобальний об'єкт для доступу до своїх методів, спробуйте так:
        global $nextendfacebook, $nextendgoogle, $nextendtwitter;

        // Припустимо, що кожна соціальна мережа має свій об'єкт для управління входом
        // Від'єднання дій, які додають кнопки входу на сторінку входу
        if ($nextendfacebook) {
            remove_action('login_form', array($nextendfacebook, 'addLoginFormButtons'));
            remove_action('register_form', array($nextendfacebook, 'addRegisterFormButtons'));
        }
        if ($nextendgoogle) {
            remove_action('login_form', array($nextendgoogle, 'addLoginFormButtons'));
            remove_action('register_form', array($nextendgoogle, 'addRegisterFormButtons'));
        }
        if ($nextendtwitter) {
            remove_action('login_form', array($nextendtwitter, 'addLoginFormButtons'));
            remove_action('register_form', array($nextendtwitter, 'addRegisterFormButtons'));
        }
    }
});

add_action('rest_api_init', function () {
    register_rest_route('paypal', '/ipn', array(
        'methods' => 'POST',
        'callback' => 'handle_paypal_ipn',
    ));
});

function handle_paypal_ipn(WP_REST_Request $request) {
    $ipn_data = $request->get_body_params();

    // Верифікація IPN від PayPal Sandbox
    $paypal_url = "https://ipnpb.paypal.com/cgi-bin/webscr"; // Sandbox IPN URL
    $response = wp_remote_post($paypal_url, array(
        'body' => array_merge($ipn_data, array('cmd' => '_notify-validate')),
        'httpversion' => '1.1',
        'headers' => array(
            'Host' => 'www.paypal.com',
            'Connection' => 'close',
            'User-Agent' => 'WordPress/' . get_bloginfo('version'),
            'Content-Type' => 'application/x-www-form-urlencoded',
        ),
    ));

    if (!is_wp_error($response) && wp_remote_retrieve_body($response) == "VERIFIED") {
        if (isset($ipn_data['mc_gross']) && isset($ipn_data['custom'])) {
            global $wpdb;

            // Збереження даних про оплату в базу даних
            $table_name = $wpdb->prefix . 'payments';
            $amount = sanitize_text_field($ipn_data['mc_gross']);
            $payment_id = intval($ipn_data['custom']);
            $current_time = current_time('mysql');
            $close_date = date('Y-m-d H:i:s', strtotime('+1 year', strtotime($current_time)));

            // Разобраться какого фига дата окончания не сохраняется
            $wpdb->update($table_name, array(
                'amount' => $amount,
                'payment_completed' => $current_time,
                'status' => 'Completed',
                'active' => 1,
                'close_date' => $close_date
            ), array('id' => $payment_id));
        }
    }

    return new WP_REST_Response('IPN Processed', 200);
}



function check_and_create_payment_table() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'payments';

    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            user_id mediumint(9) NOT NULL,
            amount float NOT NULL,
            payment_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}

add_action('after_setup_theme', 'check_and_create_payment_table');

function get_payments_history($user_id) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'payments';
    $results = $wpdb->get_results($wpdb->prepare(
        "SELECT payment_date, package_title, price, status FROM $table_name WHERE user_id = %d ORDER BY payment_date DESC",
        $user_id
    ));
    return $results;
}

function get_user_sessions_info($user_id) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'payments';

    // Отримуємо дані користувача
    $result = $wpdb->get_row($wpdb->prepare(
        "SELECT number_sessions, booking_sessions, price, package_title, payment_completed, close_date
         FROM $table_name
         WHERE user_id = %d AND active = 1",
        $user_id
    ));

    // Перевіряємо, чи потрібно деактивувати підписку
    if ($result && $result->number_sessions <= $result->booking_sessions) {
        $wpdb->update(
            $table_name,
            array('active' => 0),
            array('user_id' => $user_id),
            array('%d'),
            array('%d')
        );
    }

    $result = $wpdb->get_row($wpdb->prepare(
        "SELECT number_sessions, booking_sessions, price, package_title, payment_completed, close_date
             FROM $table_name
             WHERE user_id = %d AND active = 1",
        $user_id
    ));


    return $result;
}


function has_active_subscription($user_id) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'payments';
    $active_subscription = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM $table_name WHERE user_id = %d AND active = 1",
        $user_id
    ));
    return $active_subscription > 0;
}

// Verification or subscription closing date failed
function check_and_update_subscriptions() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'payments';
    $current_date = current_time('mysql');

    $wpdb->query(
        $wpdb->prepare(
            "UPDATE $table_name 
             SET active = 0 
             WHERE close_date < %s AND active = 1",
            $current_date
        )
    );
}

add_action('wp_login', 'check_and_update_subscriptions');

function interviewer_email_settings_init() {
    add_settings_section(
        'interviewer_email_section', // ID розділу
        'Email for Interviewer', // Назва розділу
        'interviewer_email_section_callback', // Опис розділу
        'general' // Сторінка налаштувань
    );

    add_settings_field(
        'interviewer_email', // ID поля
        'Email for Interviewer', // Назва поля
        'interviewer_email_address_callback', // Функція відображення поля
        'general', // Сторінка налаштувань
        'interviewer_email_section' // Розділ налаштувань
    );

    add_settings_field(
        'booking_email', // ID поля
        'Email for Booking Info', // Назва поля
        'booking_email_address_callback', // Функція відображення поля
        'general', // Сторінка налаштувань
        'interviewer_email_section' // Розділ налаштувань
    );

    register_setting('general', 'interviewer_email', array(
        'type' => 'string',
        'sanitize_callback' => 'sanitize_email',
        'default' => ''
    ));

    register_setting('general', 'booking_email', array(
        'type' => 'string',
        'sanitize_callback' => 'sanitize_email',
        'default' => ''
    ));
}
add_action('admin_init', 'interviewer_email_settings_init');

function interviewer_email_section_callback() {
    echo '<p>Enter the email address to receive form submissions for interviewer.</p>';
}

function interviewer_email_address_callback() {
    $email = get_option('interviewer_email', '');
    echo '<input type="email" id="interviewer_email" name="interviewer_email" value="' . esc_attr($email) . '" class="regular-text">';
}

function booking_email_address_callback() {
    $email = get_option('booking_email', '');
    echo '<input type="email" id="booking_email" name="booking_email" value="' . esc_attr($email) . '" class="regular-text">';
}

function application_cancel_email_settings_init() {
    add_settings_section(
        'application_cancel_section', // ID розділу
        'Canceling application', // Назва розділу
        'application_cancel_email_section_callback', // Опис розділу
        'general' // Сторінка налаштувань
    );

    add_settings_field(
        'application_cancel_email', // ID поля
        'Email', // Назва поля
        'application_cancel_email_address_callback', // Функція відображення поля
        'general', // Сторінка налаштувань
        'application_cancel_section' // Розділ налаштувань
    );

    add_settings_field(
        'application_cancel_phone', // ID поля
        'Phone', // Назва поля
        'application_cancel_phone_number_callback', // Функція відображення поля
        'general', // Сторінка налаштувань
        'application_cancel_section' // Розділ налаштувань
    );

    register_setting('general', 'application_cancel_email', array(
        'type' => 'string',
        'sanitize_callback' => 'sanitize_email',
        'default' => ''
    ));

    register_setting('general', 'application_cancel_phone', array(
        'type' => 'string',
        'default' => ''
    ));
}
add_action('admin_init', 'application_cancel_email_settings_init');

function application_cancel_email_section_callback() {
    echo '<p>Enter the email address for modal window in user application history.</p>';
}

function application_cancel_email_address_callback() {
    $email = get_option('application_cancel_email', '');
    echo '<input type="email" id="application_cancel_email" name="application_cancel_email" value="' . esc_attr($email) . '" class="regular-text">';
}

function application_cancel_phone_number_callback() {
    $phone = get_option('application_cancel_phone', '');
    echo '<input type="text" id="application_cancel_phone" name="application_cancel_phone" value="' . esc_attr($phone) . '" class="regular-text">';
}

function enqueue_owl_carousel() {
    wp_enqueue_style('owl-carousel-css', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css');
    wp_enqueue_style('owl-theme-default-css', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css');
    wp_enqueue_script('owl-carousel-js', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_owl_carousel');


function initialize_owl_carousel() {
    ?>
    <script>
        jQuery(document).ready(function($) {
            $('.owl-carousel').owlCarousel({
                loop: true, // Set to false if you do not want looping
                margin: 10,
                nav: true,
                navText: ["<div class='owl-prev'>‹</div>", "<div class='owl-next'>›</div>"],
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 2
                    },
                    1000: {
                        items: 3
                    }
                },
                onInitialized: function(event) {
                    if ($('.owl-carousel .owl-item').length <= event.page.size) {
                        $('.owl-carousel .owl-nav').hide();
                    } else {
                        $('.owl-carousel .owl-nav').show();
                    }
                }
            });
        });
    </script>
    <?php
}
add_action('wp_footer', 'initialize_owl_carousel', 100);




function custom_image_sizes() {
    add_image_size('custom-size', 300, 216, true); // 300px wide, 216px tall, cropped
}
add_action('after_setup_theme', 'custom_image_sizes');


function is_user_profile_complete($user_id) {
    $required_fields = array(
        'first_name',
        'last_name',
        'date_birth',
        'sex',
        'weight',
        'height',
        'phone_number',
        'occupation',
        'taking',
        'wellness_goals',
        'problems_health',
        'diet',
        'exercise',
        'stress',
        'sleep',
        'chronic_conditions',
        'mental_health',
        'short_term_goals',
        'long_term_goals'
    );

    foreach ($required_fields as $field) {
        if (empty(get_user_meta($user_id, $field, true))) {
            return false;
        }
    }

    return true;
}


