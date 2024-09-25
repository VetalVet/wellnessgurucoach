<?php
        // require_once 'controllers/config.php';
        // require_once 'core/controller.Class.php';
        // require 'functions/connect.php';

    /*
        Template Name: Account
    */

    get_header();

    require 'functions/url.php';

    if(is_user_logged_in()):
        // Якщо користувач уже залогінений
        $current_user = wp_get_current_user();
        $id = $current_user->ID;
        $user = get_userdata($id);
        $polling = $user->polling;

        //if(!$polling){
        //    require_once(__DIR__ . '/interviewer.php');
        //} else {
            require_once(__DIR__ . '/office.php');
        //}
    else:
        // Форма для входу
?>
<section class="acount">
    <div class="container">
        <h2 class="acount__header">
            Login / Sign Up
        </h2>
        <form class="acount__form" id="authorization-form" action="<?php echo esc_url($url . '/administration-panel');?>" method="post">
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

            <a href="<?php echo home_url() . '/fb-login';?>" class="acount__button-facebook">
                Continue with
                <span>
                    Facebook
                </span>
            </a>
            <button onclick="window.location = '<?php echo $login_url;?>'" type="button" class="acount__button-google">
                Continue with 
                <span>
                    Google
                </span>
            </button>
        </form>
        <div class="account__links">
            <a href="<?php echo esc_url($url . '/registration'); ?>">
                Register
            </a>
            <a href="<?php echo home_url() . '/forgot/';?>" class="account__button-fargot">
                Lost your password?
            </a>
        </div>
    </div>
</section>

<?php endif; ?>

<?php get_footer(); ?>