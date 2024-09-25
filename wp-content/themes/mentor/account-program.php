<?php


/*
    Template Name: Account - Program
*/

get_header();

if (!is_user_logged_in()) {
    wp_redirect(home_url('/login'));
    exit;
}

check_and_update_subscriptions();

$current_user = wp_get_current_user();
$user_id = $current_user->ID;
$payments_history = get_payments_history($user_id);

// Отримання інформації про сесії
$sessions_info = get_user_sessions_info($user_id);

// Визначення значення $subscribe
$subscribe = ($sessions_info->number_sessions <= $sessions_info->booking_sessions) ? 0 : 1;

?>

    <section class="office">
        <span class="office__decore-border"></span>
        <div class="container">
            <h2 class="office__title">
                My Program
            </h2>
            <div class="office__container">
                <aside class="office__sidebar">
                    <?php require_once(__DIR__ . '/modules/acount/sidebar-acount.php'); ?>
                </aside>

                <div class="my-program_cont">
                    <?php require(__DIR__ . '/modules/acount/my-program.php'); ?>
                </div>
            </div>
        </div>
    </section>

    <div class="modal-appointments modal-appointments-info">
        <div class="modal-appointments__window">
            <div class="modal-appointments__scheduled">
                Notification
            </div>
            <div class="modal-appointments__message">
                To continue, you need to subscribe to one of the programs.
            </div>
            <div class="modal-appointments__close">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="11" viewBox="0 0 14 11" fill="none">
                    <path d="M11.1929 1L1.90614 10.2577" stroke="#CCCCCC" stroke-width="2"/>
                    <path d="M2.09912 1L11.3859 10.2577" stroke="#CCCCCC" stroke-width="2"/>
                </svg>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const message = urlParams.get('message');

            if (message) {
                const modal = document.querySelector('.modal-appointments-info');
                if (modal) {
                    modal.classList.add('active');
                    document.body.style.overflowY = 'hidden';
                }
            }

            // Close modal event listener
            document.querySelectorAll('.modal-appointments__close').forEach(button => {
                button.addEventListener('click', () => {
                    const modal = button.closest('.modal-appointments');
                    if (modal) {
                        modal.classList.remove('active');
                        document.body.style.overflowY = 'visible';
                    }
                });
            });

            // Close modal on overlay click
            document.querySelectorAll('.modal-appointments').forEach(modal => {
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        modal.classList.remove('active');
                        document.body.style.overflowY = 'visible';
                    }
                });
            });
        });
    </script>


<?php get_footer(); ?>