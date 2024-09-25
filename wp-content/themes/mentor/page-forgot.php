<?php
/**
 * Template Name: Password Recovery
 */

get_header();

if (isset($_POST['user_login'])) {
    $user_login = sanitize_text_field($_POST['user_login']);
    $user = get_user_by('email', $user_login);

    if (!$user) {
        $user = get_user_by('login', $user_login);
    }

    if ($user) {
        $reset_key = get_password_reset_key($user);
        $reset_url = add_query_arg(array(
            'key' => $reset_key,
            'login' => rawurlencode($user->user_login),
        ), site_url('reset-password'));

        wp_mail($user->user_email, 'Password Reset Request', 'To reset your password, visit the following address: ' . $reset_url);

        echo '<div class="message success">Check your email for the confirmation link.</div>';
    } else {
        echo '<div class="message error">Invalid email or username.</div>';
    }
}
?>

<section class="acount">
    <div class="container">
        <h2 class="acount__header">
            Password Recovery
        </h2>
        <form class="acount__form" id="recovery-form" method="post">
            <div class="acount__form-name">
                Email Address
            </div>
            <div class="acount__form-group">
                <input id="user_login" class="acount__form-control" type="text" name="user_login" required>
            </div>
            <div class="acount__form-buttons">
                <button type="submit" class="acount__button">Reset Password</button>
            </div>

        </form>

    </div>
</section>

<?php
get_footer();
?>
