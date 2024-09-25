<?php
/**
 * Template Name: Reset Password
 */

get_header();

if ( isset( $_GET['key'] ) && isset( $_GET['login'] ) ) {
    $key = sanitize_text_field( $_GET['key'] );
    $login = sanitize_text_field( $_GET['login'] );

    $user = check_password_reset_key( $key, $login );

    if ( is_wp_error( $user ) ) {
        echo '<div class="message error">Invalid key.</div>';
        get_footer();
        exit;
    }

    if ( isset( $_POST['pass1'] ) && isset( $_POST['pass2'] ) ) {
        if ( $_POST['pass1'] == $_POST['pass2'] ) {
            reset_password( $user, sanitize_text_field( $_POST['pass1'] ) );
            echo '<div class="message success">Password has been reset successfully. <a href="' . site_url('login') . '">Login here</a>.</div>';
        } else {
            echo '<div class="message error">Passwords do not match.</div>';
        }
    }
} else {
    echo '<div class="message error">Invalid request.</div>';
    get_footer();
    exit;
}
?>

<section class="acount">
    <div class="container">
        <h2 class="acount__header">
            Reset Password
        </h2>
        <form class="acount__form" id="recovery-form" method="post">
            <div class="acount__form-name">
                New Password
            </div>
            <div class="acount__form-group">
                <input id="pass1" class="acount__form-control" type="password" name="pass1" required>
            </div>
            <div class="acount__form-name">
                Confirm New Password
            </div>
            <div class="acount__form-group">
                <input id="pass2" class="acount__form-control" type="password" name="pass2" required>
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
