<?php

 function calculate_dates_from_weekend_days() {
 	// Получаем значения дней выходных из опции 'booking_weekend_days'
 	$booking_weekend_days = get_option('booking_weekend_days', array());
 	$result = array();

 	// Получаем текущий год и месяц
 	$current_year = date('Y');
 	$current_month = date('m');

 	// Перебираем месяцы на 5 лет вперёд от текущего
 	for ($i = -1; $i < 60; $i++) {
 		 $year = $current_year + floor(($current_month + $i - 1) / 12);
 		 $month = (($current_month + $i - 1) % 12) + 1;

 		 // Перебираем выбранные дни выходных
 		 foreach ($booking_weekend_days as $day) {
 			// Получаем номер дня недели из выбранных дней (1 - понедельник, ..., 7 - воскресенье)
 			$selected_weekday = date('N', strtotime($day));
	  
 			// Рассчитываем разницу между текущим днем недели и выбранным
 			$difference = $selected_weekday - 1; // -1 для корректной работы с date('N')
	  
 			// Получаем первое вхождение выбранного дня в текущем месяце
 			$first_occurrence = strtotime("first $day of $year-$month");
	  
 			// Добавляем все вхождения выбранного дня в текущем месяце
 			for ($occurrence = $first_occurrence; date('n', $occurrence) == $month; $occurrence = strtotime('+1 week', $occurrence)) {
 				 $result[] = array(
 					  'id' => count($result) + 1,
 					  'date' => date('Y-m-d', $occurrence),
 					  'title' => 'Reserved',
 					  'classname' => 'not-available'
 				 );
 			}
 	  }
 	}

 	return $result;
 }



 $data_weekend = calculate_dates_from_weekend_days();

 $data_weekend_json = json_encode($data_weekend);

 $file_path = __DIR__ .  './calendar.json';

 // Записываем JSON-строку в файл
 if (file_exists($file_path)) {
 	// Если файл существует, перезаписываем его
 	file_put_contents($file_path, $data_weekend_json);
 } else {
 	// Если файл не существует, создаем новый
 	file_put_contents($file_path, $data_weekend_json);
 }