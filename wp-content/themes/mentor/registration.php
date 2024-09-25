<?php
/*
    Template Name: Registration
*/

$url = home_url();

$registration_error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $secretKey = RECAPTCHA_SECRET_KEY;  // Переконайтеся, що RECAPTCHA_SECRET_KEY визначений у вашому файлі wp-config.php
    $recaptcha_response = $_POST['recaptcha_response'];

    $url = "https://www.google.com/recaptcha/api/siteverify?secret=" . urlencode($secretKey) . "&response=" . urlencode($recaptcha_response);
    $response = file_get_contents($url);
    $response_data = json_decode($response);

    if ($response_data->success && $response_data->action == 'homepage' && $response_data->score >= 0.5) {

        $email = $_POST['email'];
        $password = $_POST['password'];
        $password_confirm = $_POST['password_confirm'];
        $agree_terms = isset($_POST['agree_terms']) ? $_POST['agree_terms'] : '';

        // Server-side validation
        if (empty($email) || empty($password) || empty($password_confirm) || !$agree_terms) {
            $registration_error = 'All fields are required and you must agree to the terms.';
        } elseif ($password !== $password_confirm) {
            $registration_error = 'Passwords do not match.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $registration_error = 'Invalid email address.';
        } else {
            $username = sanitize_user(current(explode('@', $email)), true);
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);

            if (username_exists($username) || email_exists($email)) {
                $registration_error = 'User or Email already exists.';
            } else {
                $user_id = wp_create_user($username, $password, $email);

                // Automatic login
                $creds = array();
                $creds['user_login'] = $username;
                $creds['user_password'] = $password;
                $creds['remember'] = true;
                $user = wp_signon($creds, false);

                if (is_wp_error($user_id)) {
                    $registration_error = 'Failed to create user: ' . $user_id->get_error_message();
                } else {
                    wp_redirect(home_url('/account'));
                    exit;
                }
            }
        }
    } else {
        $registration_error = 'CAPTCHA verification failed. Please try again.';
    }
}

get_header();

?>

<section class="registration">
    <div class="container">
        <h2 class="registration__header">
            Login / Sign Up
        </h2>

        <?php if ($registration_error): ?>
            <div class="registration-error"><?php echo $registration_error; ?></div>
        <?php endif; ?>

        <form class="registration__form" method="post" onsubmit="return validateForm()">
            <div class="registration__form-name">
                Email Address
            </div>
            <div class="registration__form-group">
                <input id="email" class="registration__form-control" type="text" name="email" required>
            </div>
            <div class="registration__form-name">
                Password
            </div>
            <div class="registration__form-group">
                <input id="pass" class="registration__form-control" type="password" name="password" required>
            </div>
            <div class="registration__form-name">
                Confirm Password
            </div>
            <div class="registration__form-group">
                <input id="pass_confirm" class="registration__form-control" type="password" name="password_confirm" required>
            </div>
            <div class="registration__checkbox-block">
                <div class="registration__checkbox-group">
                    <input type="checkbox" name="agree_terms" required>
                    I Agree to Privacy Policy and Terms of Use
                </div>
                <div class="registration__checkbox-group">
                    <input type="checkbox" name="subscribe_newsletter" checked>
                    I want to subscribe to Wellness newsletter
                </div>
            </div>
            <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
            <button type="submit" class="registration__button">Register</button>
        </form>
        <div class="account__links">
            <a href="<?php echo esc_url($url . '/login'); ?>">
                Log in
            </a>
            <a href="<?php echo home_url() . '/password-recovery/';?>" class="account__button-fargot">
                Lost your password?
            </a>
        </div>
    </div>
</section>

<script src="https://www.google.com/recaptcha/api.js?render=<?php echo RECAPTCHA_SITE_KEY; ?>"></script>
<script>
    grecaptcha.ready(function() {
        grecaptcha.execute('<?php echo RECAPTCHA_SITE_KEY; ?>', {action: 'homepage'}).then(function(token) {
            document.getElementById('recaptchaResponse').value = token;
        });
    });

    function validateForm() {
        var email = document.getElementById('email').value;
        var password = document.getElementById('pass').value;
        var password_confirm = document.getElementById('pass_confirm').value;
        var agree_terms = document.querySelector('input[name="agree_terms"]').checked;

        if (!email || !password || !password_confirm || !agree_terms) {
            alert('All fields are required and you must agree to the terms.');
            return false;
        }

        if (password !== password_confirm) {
            alert('Passwords do not match.');
            return false;
        }

        return true;
    }
</script>

<?php
get_footer();
?>
