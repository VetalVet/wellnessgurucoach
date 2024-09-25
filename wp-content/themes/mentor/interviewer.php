<?php
	/*
   	Template Name: Interviewer
	*/

ob_start();
get_header();

$user_id = get_current_user_id();
$current_user = wp_get_current_user();

// Перевірка заповненості всіх полів
$user_id = get_current_user_id();
if (is_user_profile_complete($user_id)) {
    wp_redirect(home_url('/account'));
    exit;
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {

    // Отримання даних з форми
    $first_name = sanitize_text_field($_POST['first_name']);
    $last_name = sanitize_text_field($_POST['last_name']);
    $email = sanitize_email($_POST['email']);
    $date_birth = sanitize_text_field($_POST["date_birth"]);
    $sex = sanitize_text_field($_POST["sex"]);
    $weight = sanitize_text_field($_POST["weight"]);
    $height = sanitize_text_field($_POST["height"]);
    $phone_number = sanitize_text_field($_POST["phone_number"]);

    // Оновлення стандартних полів користувача
    wp_update_user([
        'ID' => $user_id,
        'user_email' => $email,
        'display_name' => $first_name . ' ' . $last_name
    ]);

    $occupation = sanitize_text_field($_POST["occupation"]);

    // Оновлення додаткових метаданих користувача
    update_user_meta($user_id, 'first_name', $first_name);
    update_user_meta($user_id, 'last_name', $last_name);
    update_user_meta($user_id, 'date_birth', $date_birth);
    update_user_meta($user_id, 'sex', $sex);
    update_user_meta($user_id, 'weight', $weight);
    update_user_meta($user_id, 'height', $height);
    update_user_meta($user_id, 'phone_number', $phone_number);
    update_user_meta($user_id, 'occupation', $occupation);


    $taking = sanitize_text_field($_POST["taking"]);
    $wellness_goals = sanitize_text_field($_POST["wellness_goals"]);
    $problems_health = sanitize_text_field($_POST["problems_health"]);
    $diet = sanitize_text_field($_POST["diet"]);
    $exercise = sanitize_text_field($_POST["exercise"]);
    $stress = sanitize_text_field($_POST["stress"]);
    $sleep = sanitize_text_field($_POST["sleep"]);
    $chronic_conditions = sanitize_text_field($_POST["chronic_conditions"]);
    $mental_health = sanitize_text_field($_POST["mental_health"]);
    $short_term_goals = sanitize_text_field($_POST["short_term_goals"]);
    $long_term_goals = sanitize_text_field($_POST["long_term_goals"]);


    update_user_meta($user_id, 'taking', $taking);
    update_user_meta($user_id, 'wellness_goals', $wellness_goals);
    update_user_meta($user_id, 'problems_health', $problems_health);
    update_user_meta($user_id, 'diet', $diet);
    update_user_meta($user_id, 'exercise', $exercise);
    update_user_meta($user_id, 'stress', $stress);
    update_user_meta($user_id, 'sleep', $sleep);
    update_user_meta($user_id, 'chronic_conditions', $chronic_conditions);
    update_user_meta($user_id, 'mental_health', $mental_health);
    update_user_meta($user_id, 'short_term_goals', $short_term_goals);
    update_user_meta($user_id, 'long_term_goals', $long_term_goals);

    update_user_meta($user_id, 'interviewer', 1);

    // Отримання кастомної електронної адреси з налаштувань
    $to = get_option('interviewer_email');
    if (!$to) {
        $to = get_option('admin_email'); // Якщо кастомна адреса не задана, використовуємо email адміністратора
    }
    $subject = "New Interviewer Form Submission";

    // Завантаження шаблону
    ob_start();
    include('email-template.php');
    $email_template = ob_get_clean();

    // Формування контенту листа
    $content = "
        <p><strong>First Name:</strong> $first_name</p>
        <p><strong>Last Name:</strong> $last_name</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Date of Birth:</strong> $date_birth</p>
        <p><strong>Sex:</strong> $sex</p>
        <p><strong>Weight:</strong> $weight</p>
        <p><strong>Height:</strong> $height</p>
        <p><strong>Phone Number:</strong> $phone_number</p>
        <p><strong>Occupation:</strong> $occupation</p>
        <p><strong>Taking:</strong> $taking</p>
        <p><strong>Wellness Goals:</strong> $wellness_goals</p>
        <p><strong>Problems Health:</strong> $problems_health</p>
        <p><strong>Diet:</strong> $diet</p>
        <p><strong>Exercise:</strong> $exercise</p>
        <p><strong>Stress:</strong> $stress</p>
        <p><strong>Sleep:</strong> $sleep</p>
        <p><strong>Chronic Conditions:</strong> $chronic_conditions</p>
        <p><strong>Mental Health:</strong> $mental_health</p>
        <p><strong>Short Term Goals:</strong> $short_term_goals</p>
        <p><strong>Long Term Goals:</strong> $long_term_goals</p>
    ";

    // Підставлення контенту в шаблон
    $message = str_replace('{{content}}', $content, $email_template);

    $headers = array('Content-Type: text/html; charset=UTF-8');

    wp_mail($to, $subject, $message, $headers);

    wp_redirect(home_url('/account-program'));
    exit; // Важливо завершити виконання скрипта

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
$phone_number = get_user_meta($user_id, 'phone_number', true);
$email = $current_user->user_email; // Email вже є в об'єкті користувача
$occupation = get_user_meta($user_id, 'occupation', true);

$taking = get_user_meta($user_id, 'taking', true);
$wellness_goals = get_user_meta($user_id, 'wellness_goals', true);
$problems_health = get_user_meta($user_id, 'problems_health', true);
$diet = get_user_meta($user_id, 'diet', true);
$exercise = get_user_meta($user_id, 'exercise', true);
$stress = get_user_meta($user_id, 'stress', true);

$sleep = get_user_meta($user_id, 'sleep', true);
$chronic_conditions = get_user_meta($user_id, 'chronic_conditions', true);
$mental_health = get_user_meta($user_id, 'mental_health', true);
$short_term_goals = get_user_meta($user_id, 'short_term_goals', true);
$long_term_goals = get_user_meta($user_id, 'long_term_goals', true);



?>


<section class="interviewer">
	<div class="container">
		<h2 class="acount__header">
         Login / Sign Up
      </h2>
		<div class="interviewer__content">
			<div class="interviewer__navigation">
				<div class="interviewer__section-one interviewer__section-item active">
					1
				</div>
				<div class="interviewer__section-two interviewer__section-item">
					2
				</div>
				<div class="interviewer__section-tree interviewer__section-item">
					3
				</div>
			</div>
			<form id="interviewer__form" class="interviewer__form" method="post">
				<div id="interviewer__section-one" class="interviewer__section active">
					<div class="interviewer__box">
						<div class="interviewer__input-group">
							<div class="interviewer__input-signature">
								First Name
							</div>
							<input type="text" name="first_name" value="<?php echo esc_attr($f_name);?>">
						</div>
						<div class="interviewer__input-group">
							<div class="interviewer__input-signature">
								Last Name
							</div>
							<input type="text" name="last_name" value="<?php echo esc_attr($l_name);?>">
						</div>
						<div class="interviewer__input-group">
							<div class="interviewer__input-signature">
								Email
							</div>
							<input type="text" name="email" value="<?php echo esc_attr($email);?>">
						</div>
						<div class="interviewer__input-group">
							<div class="interviewer__input-signature">
								Phone Number
							</div>
							<input type="text" name="phone_number" id="inputPhone" value="<?php echo esc_attr($phone_number);?>">
						</div>
						<div class="interviewer__input-group">
							<div class="interviewer__input-signature">
								Occupation
							</div>
							<input type="text" name="occupation" value="<?php echo esc_attr($occupation);?>">
						</div>
						<div class="interviewer__input-group">
							<div class="interviewer__input-signature">
								Date of Birth
							</div>
							<input type="date" id="start" name="date_birth" value="<?php echo esc_attr($date_birth);?>" />
						</div>
					</div>
					<div class="interviewer__box-down">
						<div class="interviewer__input-group">
							<div class="interviewer__input-signature">
								Weight 
							</div>
							<input type="text" name="weight" value="<?php echo esc_attr($weight);?>">
						</div>
						<div class="interviewer__input-group">
							<div class="interviewer__input-signature">
								Height
							</div>
							<input type="text" name="height" value="<?php echo esc_attr($height);?>">
						</div>
						<div class="interviewer__input-group">
							<div class="interviewer__input-signature">
								Sex
							</div>
							<div class="interviewer-dropdown__sex dropdown">
								<button type="button" class="interviewer-dropdown__button"><?php echo esc_attr($sex);?></button>
								<ul class="interviewer-dropdown__list">
									<li class="interviewer-dropdown__item">male</li>
									<li class="interviewer-dropdown__item">female</li>
								</ul>
								<input hidden type="text" name="sex" value="<?php echo esc_attr($sex);?>">
							</div>
						</div>
					</div>
					<div class="interviewer__button-box">
						<button class="interviewer__button-next-section">
							NEXT
						</button>
					</div>
				</div>	

				<div id="interviewer__section-two" class="interviewer__section">
					<div class="interviewer__box">

                        <div class="interviewer__input-group">
                            <div class="interviewer__input-signature">
                                Are you currently taking any medications  and supplements?
                            </div>
                            <textarea name="taking" placeholder="Please, enter your answer"><?php echo esc_attr($taking);?></textarea>
                        </div>

						<div class="interviewer__input-group">
							<div class="interviewer__input-signature">
								What are your health and wellness goals?
							</div>
							<textarea name="wellness_goals" placeholder="Please, enter your answer"><?php echo esc_attr($wellness_goals);?></textarea>
						</div>
						<div class="interviewer__input-group">
							<div class="interviewer__input-signature">
								List any concerns about your health, eating habits and  fitness rating in order of importance
							</div>
							<textarea name="problems_health" id="problems_health" placeholder="Please, enter your answer"><?php echo esc_attr($problems_health);?></textarea>
						</div>
						<div class="interviewer__input-group">
							<div class="interviewer__input-signature">
								What is your current diet like?
							</div>
							<textarea name="diet" id="diet" placeholder="Please, enter your answer"><?php echo esc_attr($diet);?></textarea>
						</div>
						<div class="interviewer__input-group">
							<div class="interviewer__input-signature">
								What is your currently exercise routine?
							</div>
							<textarea name="exercise" id="exercise" placeholder="Please, enter your answer"><?php echo esc_attr($exercise);?></textarea>
						</div>
						<div class="interviewer__input-group">
							<div class="interviewer__input-signature">
								What is your stress level on scale of 1 through 10, 10 being the highest?
							</div>
							<div class="interviewer-dropdown__stress dropdown">
								<button type="button" class="interviewer-dropdown__button"><?php echo esc_attr($stress);?></button>
								<ul class="interviewer-dropdown__list">
									<li class="interviewer-dropdown__item">1</li>
									<li class="interviewer-dropdown__item">2</li>
									<li class="interviewer-dropdown__item">3</li>
									<li class="interviewer-dropdown__item">4</li>
									<li class="interviewer-dropdown__item">5</li>
									<li class="interviewer-dropdown__item">6</li>
									<li class="interviewer-dropdown__item">7</li>
									<li class="interviewer-dropdown__item">8</li>
									<li class="interviewer-dropdown__item">9</li>
									<li class="interviewer-dropdown__item">10</li>
								</ul>
								<input hidden type="text" name="stress" value="<?php echo esc_attr($stress);?>">
							</div>
						</div>
						
					</div>
					<div class="interviewer__button-box">
						<button class="interviewer__button-back-section">
							BACK
						</button>
						<button class="interviewer__button-next-section">
							NEXT
						</button>
					</div>
				</div>

				<div id="interviewer__section-tree" class="interviewer__section">
					<div class="interviewer__box">
						<div class="interviewer__input-group">
							<div class="interviewer__input-signature">
								How much sleep do you get per night?
							</div>
							<textarea name="sleep" id="sleep" placeholder="Please, enter your answer"><?php echo esc_attr($sleep);?></textarea>
						</div>
						<div class="interviewer__input-group">
							<div class="interviewer__input-signature">
								Do you have any chronic health conditions? 
							</div>
							<textarea name="chronic_conditions" id="chronic_conditions" placeholder="Please, enter your answer"><?php echo esc_attr($chronic_conditions);?></textarea>
						</div>
						<div class="interviewer__input-group">
							<div class="interviewer__input-signature">
								Do you have any mental health issues?
							</div>
							<textarea name="mental_health" id="mental_health" placeholder="Please, enter your answer"><?php echo esc_attr($mental_health);?></textarea>
						</div>
						<div class="interviewer__input-group">
							<div class="interviewer__input-signature">
								What are your short term goals?
							</div>
							<textarea name="short_term_goals" id="short_term_goals" placeholder="Please, enter your answer"><?php echo esc_attr($short_term_goals);?></textarea>
						</div>
						<div class="interviewer__input-group">
							<div class="interviewer__input-signature">
								What are your long term goals? 
							</div>
							<textarea name="long_term_goals" id="long_term_goals" placeholder="Please, enter your answer"><?php echo esc_attr($long_term_goals);?></textarea>
						</div>
						
					</div>
					<div class="interviewer__button-box">
						<button class="interviewer__button-back-section">
							BACK
						</button>
						<button type="submit" class="interviewer__button-submit-section">
							submit
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const nextButtons = document.querySelectorAll(".interviewer__button-next-section");

            nextButtons.forEach(button => {
                button.addEventListener("click", function(event) {
                    const dateInput = document.querySelector("input[name='date_birth']");
                    const errorMessage = document.getElementById("age-error-message");

                    if (dateInput) {
                        const birthDate = new Date(dateInput.value);
                        const today = new Date();
                        const age = today.getFullYear() - birthDate.getFullYear();
                        const monthDiff = today.getMonth() - birthDate.getMonth();

                        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                            age--;
                        }

                        if (age < 18) {
                            event.preventDefault();
                            if (!errorMessage) {
                                const errorElement = document.createElement("div");
                                errorElement.id = "age-error-message";
                                errorElement.style.color = "red";
                                errorElement.style.marginTop = "10px";
                                errorElement.textContent = "You should be at least 18 years old to proceed";
                                dateInput.parentNode.appendChild(errorElement);
                            }
                        } else if (errorMessage) {
                            errorMessage.remove();
                        }
                    }
                });
            });
        });
    </script>


<?php get_footer();?>