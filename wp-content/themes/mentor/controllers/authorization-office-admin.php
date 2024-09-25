<?php
	/*
   	Template Name: Administration panel
   */
  	require_once(__DIR__ . '/../functions/connect.php'); 
	$login = filter_var(trim($_POST['login']), 513);
	$pass = filter_var(trim($_POST['password']), 513);
	
	$pass = md5($pass."mentorpass");


	$result = $mysql->query("SELECT * FROM `user` WHERE `login` = '$login' AND `password` = '$pass'");
	$user = $result->fetch_assoc();

	// Зробити функціонал користувача не знайденно
	if($user === null || count($user) == 0){
		echo "Такой пользователь не найден";
		exit();
	}

	// setcookie('user', $user['f_name'], time() + 3600, "/");
	setcookie("id", $user["id"], time() + 3600, '/', NULL);
	setcookie("sess", $user["session"], time() + 3600, '/', NULL);
	$mysql->close();


	header('Location: /login'); 

	exit();