<?php
	/*
        Template Name: login Facebook
    */

	require_once(__DIR__ . '/../functions/generateCode.php');

	global $wpdb;
	// Ініціалізація сесії
	session_start();

	if (!isset($_SESSION['csrf_token'])) {
		$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
	}

	// Оновіть наступні змінні
	$facebook_oauth_app_id = FACEBOOK_OAUTH_APP_ID;
	$facebook_oauth_app_secret = FACEBOOK_OAUTH_APP_SECRET;
	// Це має бути пряма URL-адреса файлу facebook-oauth.php
	$facebook_oauth_redirect_uri =  home_url('/fb-login/');
	$facebook_oauth_version = 'v19.0';

	//  If the captured code param exists and is valid
	if (isset($_GET['code']) && isset($_GET['source']) && $_GET['source'] == 'facebook') {
		// Execute cURL request to retrieve the access token

			$params = [
				'client_id' => $facebook_oauth_app_id,
				'client_secret' => $facebook_oauth_app_secret,
				'redirect_uri' => $facebook_oauth_redirect_uri,
				'code' => $_GET['code'],
				'source' => 'facebook'
			];
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'https://graph.facebook.com/oauth/access_token');
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($ch);
			curl_close($ch);
			$response = json_decode($response, true);

			if (isset($response['access_token']) && !empty($response['access_token'])) {
				// Execute cURL request to retrieve the user info associated with the Facebook account
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, 'https://graph.facebook.com/' . $facebook_oauth_version . '/me?fields=name,email,picture');
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $response['access_token']]);
				$response = curl_exec($ch);
				curl_close($ch);
				$profile = json_decode($response, true);



				// Make sure the profile data exists
				if (isset($profile['email'])) {

					$facebook_name = $profile['name'];
					$facebook_email = $profile['email'];
					$facebook_password = generateCode(5);
					$facebook_session =  generateCode(10);

					$user = get_user_by('email', $facebook_email);

					if ($user) {
						// Користувач вже існує в базі даних
						$user_id = $user->id;

						// Авторизація користувача
						wp_set_current_user($user_id);
						wp_set_auth_cookie($user_id);

						$interviewer = get_user_meta($user_id, 'interviewer', true);

						if($interviewer == 1) {
							wp_redirect(home_url('/account'));
							exit;
						}
						else {
							wp_redirect(home_url('/interviewer'));
							exit;
						}

						// Редирект


					} else {

						$user_nicename = sanitize_title(current(explode('@', $facebook_email)));

						// Записати нового користувача
						$user_data = array(
							'user_email' => $facebook_email,
							'display_name' => $facebook_name,
							'user_pass'  => $facebook_password, // Примітка: слід використовувати безпечні паролі!
							'user_login' => $facebook_email,
							'user_nicename' => $user_nicename
						);

						$user_id = wp_insert_user($user_data);

						if (!is_wp_error($user_id)) {

							// Авторизація користувача
							wp_set_current_user($user_id);
							wp_set_auth_cookie($user_id);

							// Редирект
							wp_redirect(home_url('/interviewer'));
							exit;

						} else {
							$errors = $user_id->get_error_messages();
							foreach ($errors as $error) {
								echo $error; // Або обробіть помилки іншим чином
							}

							exit('Error:');
						}
					}

				} else {
					exit('Could not retrieve profile information! Please try again later!');
				}
			} else {
				exit('Invalid access token! Please try again later!');
			}

		
	} else {
		// Define params and redirect to Facebook OAuth page
		$params = [
			'client_id' => $facebook_oauth_app_id,
			'redirect_uri' => $facebook_oauth_redirect_uri,
			'state' => $_SESSION['csrf_token'],
			'response_type' => 'code',
			'scope' => 'email',
			'source' => 'facebook'
		];
		header('Location: https://www.facebook.com/dialog/oauth?' . http_build_query($params));
		exit;
	}


?>	