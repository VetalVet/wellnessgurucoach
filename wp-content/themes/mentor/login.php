<?php

/*
    Template Name: Login
*/

$url = home_url();
$login_url = wp_login_url();
$error_message = '';

// Перевірка чи форма була відправлена
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'], $_POST['password'])) {
    $creds = array(
        'user_login' => $_POST['login'],
        'user_password' => $_POST['password'],
        'remember' => true
    );

    $user = wp_signon($creds, false);

    if (is_wp_error($user)) {
        $error_message = $user->get_error_message();
    } else {
        // Перенаправлення на бажану сторінку після входу
        wp_redirect(home_url('/interviewer/'));
        exit;
    }
}

get_header();
?>

<section class="acount">
    <div class="container">
        <h2 class="acount__header">
            Login / Sign Up
        </h2>

        <?php if (!empty($error_message)) : ?>
            <div class="login-error" style="color: red; margin-bottom: 20px; text-align: center">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <form class="acount__form" id="authorization-form" method="post">
            <div class="acount__form-name">
                Email Address
            </div>
            <div class="acount__form-group">
                <input id="login" class="acount__form-control" type="text" name="login">
            </div>
            <div class="acount__form-name">
                Password
            </div>
            <div class="acount__form-group">
                <input id="pass" class="acount__form-control" type="password" name="password">
            </div>
            <div class="acount__form-buttons">
                <button type="submit" class="acount__button">Log In</button>
            </div>

            <?php echo do_shortcode('[nextend_social_login redirect="/interviewer/"]'); ?>

        </form>
        <div class="account__links">
            <a href="<?php echo esc_url($url . '/registration'); ?>">
                Register
            </a>
            <a href="<?php echo home_url() . '/password-recovery/'; ?>" class="account__button-fargot">
                Lost your password?
            </a>
        </div>
    </div>
</section>

<?php get_footer(); ?>
