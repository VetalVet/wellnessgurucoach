<?php
	/*
        Template Name: Controller Facebook
    */

    require_once(__DIR__ . '/../functions/generateCode.php');

    global $wpdb; // Глобальний об'єкт для роботи з базою даних
    $site_url = get_site_url();

    // Initialize the session - is required to check the login state.
    session_start();
    // Check if the user is logged in, if not then redirect to login page
    if (!isset($_SESSION['facebook_loggedin'])) {
        header('Location: ' . $site_url . '/fb-login/');
        exit;
    }

    // Retrieve session variables
    $facebook_email = $_SESSION['facebook_email'];
    $facebook_first_name = $_SESSION['facebook_first_name'];
    $facebook_last_name = $_SESSION['facebook_last_name'];
    $facebook_password = generateCode(5);
    $facebook_session =  generateCode(10);

    // Безпечний запит до бази даних
    $user = $wpdb->get_row($wpdb->prepare("SELECT * FROM user WHERE email = %s", $facebook_email));

    if ($user) {
        // Користувач вже існує в базі даних
        $user_id = $user->id;
        $polling = $user->polling;
        $interviewer = get_user_meta($user_id, 'interviewer', true);

        setcookie("id", $user_id, time() + 3600, '/', NULL);
        setcookie("sess", $facebook_session, time() + 3600, '/', NULL);
        setcookie('user', $facebook_first_name, time() + 3600, "/");

    } else {
        // Записати нового користувача
        $insert_result = $wpdb->insert(
            'user',
            array(
                'email' => $facebook_email,
                'f_name' => $facebook_first_name,
                'l_name' => $facebook_last_name,
                'password' => $facebook_password,
                'session' => $facebook_session,
                'login' => $facebook_email
            ),
            array('%s', '%s', '%s', '%s', '%s', '%s')
        );

        if ($insert_result !== false) {
            $user_id = $wpdb->insert_id;

            setcookie("id", $user_id, time() + 3600, '/', NULL);
            setcookie("sess", $facebook_session, time() + 3600, '/', NULL);
            setcookie('user', $facebook_first_name, time() + 3600, "/");
            header("Location: /interviewer");
            exit;
        }
    }
?>