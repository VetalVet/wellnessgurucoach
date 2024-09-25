<?php 
//	require_once(__DIR__ . '/../../functions/connect.php');
//	$id = $_COOKIE['id'];
//
//
//	if ($_SERVER["REQUEST_METHOD"] == "POST") {
//		// Якщо форма була відправлена, отримуємо нові значення
//		$new_f_name = $_POST['f_name'];
//		$new_l_name = $_POST['l_name'];
//		$new_email = $_POST['email'];
//		$new_date_birth = $_POST["date_birth"];
//		$new_sex = $_POST["sex"];
//		$new_weight = $_POST["weight"];
//		$new_height = $_POST["height"];
//		$new_number = $_POST["number"];
//
//		// Перевірка на співпадіння з попередніми значеннями в базі даних
//		$sql = "SELECT f_name, l_name, email, date_birth, sex, weight, height, number FROM user WHERE id = $id";
//		$result = $mysql->query($sql);
//		if ($result->num_rows > 0) {
//			$row = $result->fetch_assoc();
//			if ($new_f_name != $row['f_name'] || $new_l_name != $row['l_name'] || $new_email != $row['email'] ||
//				$new_date_birth != $row['date_birth'] || $new_sex != $row['sex'] || $new_weight != $row['weight'] ||
//				$new_height != $row['height'] || $new_number != $row['number']) {
//				// Якщо хоча б одне зі значень не співпадає, оновлюємо дані в базі даних
//				$sql = "UPDATE user SET f_name='$new_f_name', l_name='$new_l_name', email='$new_email', date_birth='$new_date_birth', sex='$new_sex', weight='$new_weight', height='$new_height', number='$new_number' WHERE id=$id";
//				if ($mysql->query($sql) === TRUE) {
//					echo "Record updated successfully";
//				} else {
//					echo "Error updating record: " . $mysql->error;
//				}
//			}
//		}
//	}
//
//	// Отримання данних
//	$sql = "SELECT id, f_name, l_name, email, number, date_birth, sex, weight, height FROM user";
//	$result = $mysql->query($sql);
//
//
//	// Перевірка результату запиту
//	if ($result->num_rows > 0) {
//		// Якщо є рядки в результаті запиту
//		$row = $result->fetch_assoc();
//		while($row = $result->fetch_assoc()) {
//			// Зберігання даних в змінних
//			if($row["id"] === $id){
//				$f_name = $row["f_name"];
//				$l_name = $row["l_name"];
//				$email = $row["email"];
//				$date_birth = $row["date_birth"];
//				$sex = $row["sex"];
//				$weight = $row["weight"];
//				$height = $row["height"];
//				$number = $row["number"];
//			}
//		}
//	}

//add_action('init', 'update_user_profile');


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['f_name'])) { // Перевірте, що форма була відправлена
    $user_id = get_current_user_id(); // Отримання ID поточного користувача

    // Отримання даних з форми
    $first_name = sanitize_text_field($_POST['f_name']);
    $last_name = sanitize_text_field($_POST['l_name']);
    $email = sanitize_email($_POST['email']);
    $date_birth = sanitize_text_field($_POST["date_birth"]);
    $sex = sanitize_text_field($_POST["sex"]);
    $weight = sanitize_text_field($_POST["weight"]);
    $height = sanitize_text_field($_POST["height"]);
    $number = sanitize_text_field($_POST["number"]);

    // Оновлення стандартних полів користувача
    wp_update_user([
        'ID' => $user_id,
        'user_email' => $email,
        'display_name' => $first_name . ' ' . $last_name
    ]);

    // Оновлення додаткових метаданих користувача
    update_user_meta($user_id, 'first_name', $first_name);
    update_user_meta($user_id, 'last_name', $last_name);
    update_user_meta($user_id, 'date_birth', $date_birth);
    update_user_meta($user_id, 'sex', $sex);
    update_user_meta($user_id, 'weight', $weight);
    update_user_meta($user_id, 'height', $height);
    update_user_meta($user_id, 'phone_number', $number);

    $redirect_url = !empty($_POST['redirect_to']) ? esc_url_raw($_POST['redirect_to']) : home_url();
    wp_redirect($redirect_url);
    //exit;
}


$user_id = get_current_user_id();
$current_user = wp_get_current_user();

// Розділення display_name на ім'я та прізвище
$name_parts = explode(' ', $current_user->display_name);
$f_name = $name_parts[0];
$l_name = isset($name_parts[1]) ? $name_parts[1] : '';

// Додаткові дані
$date_birth = get_user_meta($user_id, 'date_birth', true);
$sex = get_user_meta($user_id, 'sex', true);
$weight = get_user_meta($user_id, 'weight', true);
$height = get_user_meta($user_id, 'height', true);
$number = get_user_meta($user_id, 'phone_number', true);
$email = $current_user->user_email; // Email вже є в об'єкті користувача

?>

<section class="personal-data">
    <h3 class="personal-data__title">
        Personal Data
    </h3>

    <form class="personal-data__form" method="post">
        <input type="hidden" name="action" value="update_profile">
        <ul class="personal-data__inputs">
            <li class="personal-data__group-input">
                <input type="text" name="f_name" placeholder="First name" value="<?php echo esc_attr($f_name);?>">
            </li>
            <li class="personal-data__group-input">
                <input type="text" name="l_name" placeholder="Last name" value="<?php echo esc_attr($l_name);?>">
            </li>
            <li class="personal-data__group-input">
                <input type="email" name="email" placeholder="Email" value="<?php echo esc_attr($email);?>">
            </li>
            <li class="personal-data__group-input">
                <input id="start" type="date" name="date_birth" placeholder="Date of birth" value="<?php echo esc_attr($date_birth);?>">
            </li>
            <li class="personal-data__group-input">
                <input type="text" name="sex" placeholder="Sex" value="<?php echo esc_attr($sex);?>">
            </li>
            <li class="personal-data__group-input">
                <input type="text" name="weight" placeholder="Weight" value="<?php echo esc_attr($weight);?>">
            </li>
            <li class="personal-data__group-input">
                <input type="text" name="number" placeholder="Phone number" value="<?php echo esc_attr($number);?>">
            </li>
            <li class="personal-data__group-input">
                <input type="text" name="height" placeholder="Height" value="<?php echo esc_attr($height);?>">
            </li>
        </ul>
        <button class="personal-data__button" type="submit">
            Save changes
        </button>
    </form>
</section>
