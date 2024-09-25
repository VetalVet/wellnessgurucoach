<?php

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require __DIR__ . '/../phpmailer/src/Exception.php';
	require __DIR__ . '/../phpmailer/src/PHPMailer.php';
	require __DIR__ . '/../functions/connect.php';
	require __DIR__ . '/../functions/generateCode.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	$data = json_decode(file_get_contents("php://input"), true);

	// Змінні

	$firstName = $data['first-name'];
	$lastName = $data['last-name'];
	$email = $data['email'];
	$phoneNumber = $data['phone'];
	$occupation = $data['occupation'];
	$dateOfBirth = $data['date-birth'];
	$weight = $data['weight'];
	$height = $data['height'];
	$sex = $data['sex'];
	$wellnessGoals = $data['wellness-goals'];
	$healthProblems = $data['problems-health'];
	$diet = $data['diet'];
	$exercise = $data['exercise'];
	$stressLevel = $data['stress'];
	$sleep = $data['sleep'];
	$chronicConditions = $data['chronic-conditions'];
	$mentalHealthIssues = $data['mental-health'];
	$shortTermGoals = $data['short-term-goals'];
	$longTermGoals = $data['long-term-goals'];
	$session = generateCode(10);



	// Відправка повідомлення

	$mail = new PHPMailer(true);

	$mail->CharSet = 'UTF-8';
	$mail->setLanguage('en', 'phpmailer/language/');
	$mail->IsHTML(true);

	//От кого письмо
	$mail->setFrom('adamantik2021@gmail.com', 'Фрилансер по жизни');
	//Кому отправить
	$mail->addAddress('adamantik2021@gmail.com');
	//Тема письма
	$mail->Subject = 'Registration survey';
 
	$body = '<h1>Survey</h1>';

	$body.='<p><strong>First Name:</strong> '. $firstName .'</p>';
	$body.='<p><strong>Last Name:</strong> '. $lastName .'</p>';
	$body.='<p><strong>Email:</strong> '. $email .'</p>';
	$body.='<p><strong>Phone Number:</strong> '. $phoneNumber .'</p>';
	$body.='<p><strong>Occupation:</strong> '. $occupation .'</p>';
	$body.='<p><strong>Date of Birth:</strong> '. $dateOfBirth .'</p>';
	$body.='<p><strong>Weight:</strong> '. $weight .'</p>';
	$body.='<p><strong>Height:</strong> '. $height .'</p>';
	$body.='<p><strong>What are your health and wellness goals?</strong> '. $wellnessGoals .'</p>';
	$body.='<p><strong>List any concerns about your health, eating habits and  fitness rating in order of importance:</strong> '. $healthProblems .'</p>';
	$body.='<p><strong>What is your current diet like?</strong> '. $diet .'</p>';
	$body.='<p><strong>What is your currently exercise routine?</strong> '. $exercise .'</p>';
	$body.='<p><strong>What is your stress level on scale of 1 through 10, 10 being the highest?</strong> '. $stressLevel .'</p>';
	$body.='<p><strong>How much sleep do you get per night?</strong> '. $sleep .'</p>';
	$body.='<p><strong>Do you have any chronic health conditions?</strong> '. $chronicConditions .'</p>';
	$body.='<p><strong>Do you have any mental health issues?</strong> '. $mentalHealthIssues .'</p>';
	$body.='<p><strong>What are your short term goals?</strong> '. $shortTermGoals .'</p>';
	$body.='<p><strong>What are your long term goals?</strong> '. $longTermGoals .'</p>';


	$mail->Body = $body;

	//Отправляем
	if (!$mail->send()) {
		$message = 'Error';
	} else {
		$message = 'Data sent!';
	}

	$response = ['message' => $message];

	// Получаем id из куки
	$id = $_COOKIE['id'];


	// Проверяем подключение
	if ($mysql->connect_error) {
		die("Ошибка подключения к базе данных: " . $mysql->connect_error);
	}

	// Запрос к базе данных для обновления выбранных полей
	$query = "UPDATE `user` SET login = '$email', polling = '1',  email = '$email', f_name = '$firstName', l_name = '$lastName', date_birth = '$dateOfBirth', sex = '$sex', weight = '$weight', height = '$height', number = '$phoneNumber' WHERE id = '$id'";

	// Выполняем запрос
	if ($mysql->query($query) === TRUE) {
		echo "Данные успешно обновлены";

	} else {
		echo "Ошибка обновления данных: " . $mysql->error;
	}

	// Закрываем соединение с базой данных
	$mysql->close();
	exit();
    
   //  echo "Данные успешно отправлены!";
} else {
    // Если запрос не был методом POST, верните ошибку
    echo "Ошибка: Доступ запрещен!";
}
?>
