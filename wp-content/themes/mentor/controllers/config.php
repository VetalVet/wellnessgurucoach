<?php

require_once(__DIR__ . '../../vendor/autoload.php');


// config Google
$gClient = new Google_Client();

// $gClient->setClientId('814869657953-68u70m4ohr1ln4alr7e49lp89rr9bp5k.apps.googleusercontent.com');
// $gClient->setClientSecret('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');
// $gClient->setApplicationName('Mentor');
// $gClient->setRedirectUri('http://localhost/controller');

$gClient->setClientId('687730842414-3skb9kh87ecke91l05u1ro52o3mvt2hd.apps.googleusercontent.com');
$gClient->setClientSecret('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');
$gClient->setApplicationName('Wellness Guru');
$gClient->setRedirectUri('https://wellnessgurucoach.com/controller');
$gClient->addScope("https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email");

$login_url = $gClient->createAuthUrl();




