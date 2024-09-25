<?php
///*
//Plugin Name: Google Login
//Plugin URI: https://
//Description: Дозволяє користувачам входити через Google OAuth.
//Version: 1.0
//Author: Yevhen Lebediev
//Author URI: https://ilebediev.pp.ua/
//*/
//
//if (!defined('ABSPATH')) exit;
//
//require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';
//
//function google_login_init() {
//    if (isset($_GET['google-login-action'])) {
//        $client = new Google_Client();
//        $client->setClientId('YOUR_CLIENT_ID');
//        $client->setClientSecret('YOUR_CLIENT_SECRET');
//        $client->setRedirectUri('YOUR_REDIRECT_URI');
//        $client->addScope("email");
//        $client->addScope("profile");
//
//        $auth_url = $client->createAuthUrl();
//        wp_redirect($auth_url);
//        exit;
//    }
//}
//
//add_action('init', 'google_login_init');
//
//function handle_google_login() {
//    if (isset($_GET['code'])) {
//        if (isset($_GET['source']) && $_GET['source'] == 'google') {
//            $client = new Google_Client();
//            $client->setClientId('YOUR_CLIENT_ID');
//            $client->setClientSecret('YOUR_CLIENT_SECRET');
//            $client->setRedirectUri('YOUR_REDIRECT_URI');
//            $client->addScope("email");
//            $client->addScope("profile");
//
//            $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
//            $client->setAccessToken($token);
//
//            $google_oauth = new Google_Service_Oauth2($client);
//            $google_account_info = $google_oauth->userinfo->get();
//            $email = $google_account_info->email;
//
//            $user = get_user_by('email', $email);
//
//            if (!$user) {
//                $random_password = wp_generate_password(12, false);
//                $userdata = array(
//                    'user_login' => $email,
//                    'user_email' => $email,
//                    'user_pass' => $random_password,
//                    'first_name' => $google_account_info->givenName,
//                    'last_name' => $google_account_info->familyName,
//                    'nickname' => $google_account_info->name,
//                    'display_name' => $google_account_info->name,
//                );
//
//                $user_id = wp_insert_user($userdata);
//
//                if (is_wp_error($user_id)) {
//                    wp_die('Помилка створення користувача: ' . $user_id->get_error_message());
//                }
//            }
//        } else {
//            $user_id = $user->ID;
//        }
//
//        wp_clear_auth_cookie();
//        wp_set_current_user($user_id);
//        wp_set_auth_cookie($user_id);
//
//        wp_redirect(home_url());
//        exit;
//    }
//}
//
//add_action('wp_loaded', 'handle_google_login');
