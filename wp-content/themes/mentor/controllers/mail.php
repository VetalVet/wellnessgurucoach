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

	// $firstName = 'firstName';
	// $lastName = 'lastName';
	// $email = 'email';
	// $phoneNumber = 'phoneNumber';
	// $occupation = 'occupation';
	// $dateOfBirth = 'dateOfBirth';
	// $weight = 'weight';
	// $height = 'height';
	// $sex = 'sex';
	// $wellnessGoals = 'wellness-goals';
	// $healthProblems = 'problems-health';
	// $diet = 'diet';
	// $exercise = 'exercise';
	// $stressLevel = 'stress';
	// $sleep = 'sleep';
	// $chronicConditions = 'chronic-conditions';
	// $mentalHealthIssues = 'mental-health';
	// $shortTermGoals = 'short-term-goals';
	// $longTermGoals = 'long-term-goals';
	// $session = generateCode(10);


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
	// $body = '<h1>Survey</h1>';

	// $body.='<p><strong>First Name:</strong> '. $firstName .'</p>';
	// $body.='<p><strong>Last Name:</strong> '. $lastName .'</p>';
	// $body.='<p><strong>Email:</strong> '. $email .'</p>';
	// $body.='<p><strong>Phone Number:</strong> '. $phoneNumber .'</p>';
	// $body.='<p><strong>Occupation:</strong> '. $occupation .'</p>';
	// $body.='<p><strong>Date of Birth:</strong> '. $dateOfBirth .'</p>';
	// $body.='<p><strong>Weight:</strong> '. $weight .'</p>';
	// $body.='<p><strong>Height:</strong> '. $height .'</p>';
	// $body.='<p><strong>What are your health and wellness goals?</strong> '. $wellnessGoals .'</p>';
	// $body.='<p><strong>List any concerns about your health, eating habits and  fitness rating in order of importance:</strong> '. $healthProblems .'</p>';
	// $body.='<p><strong>What is your current diet like?</strong> '. $diet .'</p>';
	// $body.='<p><strong>What is your currently exercise routine?</strong> '. $exercise .'</p>';
	// $body.='<p><strong>What is your stress level on scale of 1 through 10, 10 being the highest?</strong> '. $stressLevel .'</p>';
	// $body.='<p><strong>How much sleep do you get per night?</strong> '. $sleep .'</p>';
	// $body.='<p><strong>Do you have any chronic health conditions?</strong> '. $chronicConditions .'</p>';
	// $body.='<p><strong>Do you have any mental health issues?</strong> '. $mentalHealthIssues .'</p>';
	// $body.='<p><strong>What are your short term goals?</strong> '. $shortTermGoals .'</p>';
	// $body.='<p><strong>What are your long term goals?</strong> '. $longTermGoals .'</p>';


	$body = "
	<!DOCTYPE html>
	<html>
	<head>
		<style>
			.email-container {
				font-family: Arial, sans-serif;
				background-color: #FAF9F6;
				max-width: 600px;
				margin: 0 auto;
			}

			.email-header {
				text-align: center;
				font-size: 20px;
				font-weight: bold;
				padding-left: 20px;
				background-color: #f0eee6;
				height: 120px;
			}

			.email-content {
				margin: 30px;
			}

			.email-content p {
				margin: 10px 0;
			}

			.email-footer {
				margin-top: 20px;
				text-align: center;
				font-size: 0px;
				color: #777;
				background-color: #f0eee6;
				padding: 10px 20px;
				height: 60px;
			}

			.line {
				height: 2px;
				background-color: #37B048;
				margin: 20px 0;
			}

			@media (max-width: 400px) {
				.email-container {
					max-width: none;
				}
				.email-header {
					text-align: center;
					font-size: 20px;
					font-weight: bold;
					padding-left: 20px;
					background-color: #f0eee6;
					height: 90px;
				}
			}
		</style>
	</head>

	<body>
		<div class='email-container'>
			<div class='email-header'>
				<a href='https://wellnessgurucoach.com/' style='float: left; max-width: 50%; padding: 20px 0;'>
					<img width='206' height='75' style='width: 100%;height: 100%;' src='https://wellnessgurucoach.com/wp-content/uploads/2024/09/logo-2.svg' alt=''>
				</a>

				<div class='header_image' style='float: right; max-width: 40%; width: 100%;height: 100%;'>
					<img style='width: 100%;height: 100%;' src='https://wellnessgurucoach.com/wp-content/uploads/2024/09/image-13.jpg' alt=''>
				</div>
			</div>

			<div class='line'></div>

			<div class='email-content'>
				<p><strong>First Name:</strong> $firstName </p>
				<p><strong>Last Name:</strong> $lastName </p>
				<p><strong>Email:</strong> $email </p>
				<p><strong>Phone Number:</strong> $phoneNumber </p>
				<p><strong>Occupation:</strong> $occupation </p>
				<p><strong>Date of Birth:</strong> $dateOfBirth </p>
				<p><strong>Weight:</strong> $weight </p>
				<p><strong>Height:</strong> $height </p>
				<p><strong>What are your health and wellness goals?</strong> $wellnessGoals </p>
				<p><strong>List any concerns about your health, eating habits and  fitness rating in order of importance:</strong> $healthProblems </p>
				<p><strong>What is your current diet like?</strong> $diet </p>
				<p><strong>What is your currently exercise routine?</strong> $exercise </p>
				<p><strong>What is your stress level on scale of 1 through 10, 10 being the highest?</strong> $stressLevel </p>
				<p><strong>How much sleep do you get per night?</strong> $sleep </p>
				<p><strong>Do you have any chronic health conditions?</strong> $chronicConditions </p>
				<p><strong>Do you have any mental health issues?</strong> $mentalHealthIssues </p>
				<p><strong>What are your short term goals?</strong> $shortTermGoals </p>
				<p><strong>What are your long term goals?</strong> $longTermGoals </p>
			</div>

			<div class='line'></div>

			<div class='email-footer'>
				<a style='float: left; margin-top: 9px;' href='https://wellnessgurucoach.com/'>
					<img width='104' height='38' src='https://wellnessgurucoach.com/wp-content/uploads/2024/09/logo-1.svg' alt=''>
				</a>

				<div style='float: right; margin-top: 17px;' class='socials'>
					<a href='https://www.instagram.com/marina_wellnessguru/'>
						<img width='25' height='25' src='https://wellnessgurucoach.com/wp-content/uploads/2024/10/vector.svg' alt=''>
					</a>
					<a style='margin-left: 10px;' href='https://www.facebook.com/marina.vaysbaum'>
						<img width='25' height='25' src='https://wellnessgurucoach.com/wp-content/uploads/2024/10/fa-brands_facebook.svg' alt=''>
					</a>
				</div>
			</div>
		</div>
	</body>
	</html>
    ";

	$mail->Body = $body;

	// echo $body;

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