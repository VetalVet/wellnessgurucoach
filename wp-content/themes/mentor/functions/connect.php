<?php
	
	/*
      Template Name: Connect
    */

// $hostname = $_SERVER['HTTP_HOST'];
// $mysql = new mysqli($hostname, 'root', '', 'mentor');

$hostname = 'localhost';
$port = '3306'; // Замініть 'ваш_номер_порту' на реальний номер порту

// Параметри підключення до бази даних
$db_username = 'sps_mwp'; // Ваше ім'я користувача БД
$db_password = 'PiWheFdEedV6CdYL'; // Ваш пароль БД
$db_name = 'sps_mwp'; // Ім'я вашої бази даних

// Підключення до бази даних з використанням порту
$mysql = new mysqli($hostname, $db_username, $db_password, $db_name, $port);

// Перевірка наявності помилок при підключенні
if ($mysql->connect_error) {
    die("Помилка підключення до бази даних: " . $mysql->connect_error);
}
//else {
//    die("Підключено");
//}