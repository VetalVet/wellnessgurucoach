<?php
		/*
        Template Name: Controller
    */
	 
require __DIR__ . '/../core/controller.Class.php';
require 'config.php';
require __DIR__ . '/../functions/connect.php';

if(isset($_GET["code"])){
	$token = $gClient->fetchAccessTokenWithAuthCode($_GET["code"]);
}else{
	header('Location: /');
	exit();
}

$error = $token["error"];

if(!(isset($error))){
	$oAuth = new Google_Service_Oauth2($gClient);
	$userData = $oAuth->userinfo_v2_me->get();

		$Controller = new Controller();
		echo $Controller->insertData(array(
		'email' => $userData["email"],
		'familyName' => $userData["familyName"],
		'givenName' => $userData["givenName"],
		));

}else{
	header("Location: /");
	exit();
}