<?php
  	require_once(__DIR__ . '/../functions/connect.php');
	require_once(__DIR__ . '/../functions/generateCode.php'); 
	
	/*
   	Template Name: User registration
   */
	// 	Реєстрація
	$login = filter_var(trim($_POST['email']), 513);
	$f_name = '';
	$l_name = '';
	$pass = filter_var(trim($_POST['password']), 513);
	$email = filter_var(trim($_POST['email']), 513);
	$session = generateCode(10);
	

	if (mb_strlen($login) < 5 || mb_strlen($login) > 255){
		echo 'Недопустимая длина логина';
		exit();
	}elseif (mb_strlen($pass) < 2 || mb_strlen($pass) > 255){
		echo 'Недопустимая длина пароля (от 2 до 255 символов)';
		exit();
	}elseif (mb_strlen($email) < 5 || mb_strlen($email) > 255){
		echo 'Недопустимая длина пароля (от 2 до 255 символов)';
		exit();
	}

	$pass = md5($pass."mentorpass");
	
 
	$query = "INSERT INTO `user` (login, password, email, session) VALUES ('$login', '$pass', '$email', '$session')";
	$mysql->query($query);

	$result = $mysql->query("SELECT * FROM `user` WHERE `login` = '$login' AND `password` = '$pass'");
	$user = $result->fetch_assoc();

	// setcookie('user', $user['f_name'], time() + 3600, "/");
	setcookie("id", $user["id"], time() + 3600, '/', NULL);
	setcookie("sess", $user["session"], time() + 3600, '/', NULL);


	$mysql->close();

	header('Location: /interviewer'); // Замените '/' на нужный вам путь

	exit();