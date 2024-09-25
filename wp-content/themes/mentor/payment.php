<?php
/*
    Template Name: Custom Payment
*/

// Перевірка авторизації користувача
$is_logged_in = is_user_logged_in();
if (!$is_logged_in) {
    wp_redirect(site_url('/login'));
    exit;
}

// Отримання поточного користувача
$current_user = wp_get_current_user();

// Обробка форми
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'process_payment') {
    if (!isset($_POST['amount']) || !isset($_POST['user_id'])) {
        echo '<div class="error">Required fields are missing</div>';
    } else {
        global $wpdb;

        $amount = sanitize_text_field($_POST['amount']);
        $price = sanitize_text_field($_POST['price']);
        $user_id = intval($_POST['user_id']);

        $package_title = sanitize_text_field($_POST['package_title']);
        $number_sessions = intval($_POST['number_sessions']);

        // Додавання запису в базу даних
        $wpdb->insert($wpdb->prefix . 'payments', array(
            'user_id' => $user_id,
            'price' => $price,
            'payment_date' => current_time('mysql'),
            'package_title' => $package_title,
            'number_sessions' => $number_sessions,
            'status' => 'pending'
        ));
        $payment_id = $wpdb->insert_id;

        // Параметри PayPal Sandbox
        $paypal_url = PAYPAL_URL;
        $return_url = site_url('/payment-success');
        $cancel_url = site_url('/payment-cancel');
        $notify_url = site_url('/wp-json/paypal/ipn');
        $sandbox_business_email = PAYPAL_BUSINESS_EMAIL;

        $query_args = array(
            'cmd' => '_xclick',
            'business' => $sandbox_business_email,
            'item_name' => 'Payment for Service',
            'amount' => $amount,
            'currency_code' => 'USD',
            'notify_url' => $notify_url,
            'return' => $return_url,
            'cancel_return' => $cancel_url,
            'custom' => $payment_id
        );

        $paypal_redirect = add_query_arg($query_args, $paypal_url);
        wp_redirect($paypal_redirect);
        exit;
    }
}

if(isset($_POST['price'])) {
    $amount = sanitize_text_field($_POST['price']);
} else {
    wp_redirect(site_url('/account-program'));
    exit;
}

$agreement_link = isset($_POST['agreement_link']) ? sanitize_text_field($_POST['agreement_link']) : '#';
$package_title = isset($_POST['package_title']) ? sanitize_text_field($_POST['package_title']) : '';
$number_sessions = isset($_POST['number_sessions']) ? sanitize_text_field($_POST['number_sessions']) : '1';

$tax_rate = 4.5;  // Відсоток податку
$tax_amount = $amount * $tax_rate / 100;  // Обчислення податку
$total_amount = $amount + $tax_amount;  // Обчислення загальної суми

get_header();
?>

<section class="account">
    <div class="container">
        <h2 class="account__header">
            Payment
        </h2>

        <div class="payment-page">

            <div class="h3"><?php echo esc_html($package_title); ?> Program</div>
            <table>
                <tbody class="table">
                    <tr>
                        <td>Number of sessions</td>
                        <td class="right-align"><?php echo esc_html($number_sessions); ?></td>
                    </tr>
                    <tr>
                        <td>Subtotal</td>
                        <td class="right-align">$<?php echo number_format($amount, 2); ?></td>
                    </tr>
                    <tr>
                        <td>VAT 4.5%</td>
                        <td class="right-align">$<?php echo number_format($tax_amount, 2); ?></td>
                    </tr>
                    <tr>
                        <td>Total to pay</td>
                        <td class="right-align">$<?php echo number_format($total_amount, 2); ?></td>
                    </tr>
                </tbody>
            </table>

            <form id="custom-payment-form" method="POST">
                <input type="hidden" name="action" value="process_payment">
                <input type="hidden" name="user_id" value="<?php echo esc_attr($current_user->ID); ?>">
                <input type="hidden" name="amount" value="<?php echo $total_amount; ?>">
                <input type="hidden" name="price" value="<?php echo $amount; ?>">
                <input type="hidden" name="package_title" value="<?php echo esc_attr($package_title); ?>">
                <input type="hidden" name="number_sessions" value="<?php echo esc_attr($number_sessions); ?>">


                <div class="payment-form">
                    <div class="agreement-links">
                        <input id="checkbox-hipaa" type="checkbox" name="hipaa" value="1" required>
                        <label for="checkbox-hipaa">
                            I agree with <a href="/hipaa-agreement" target="_blank" title="HIPAA Agreement"> HIPAA Agreement</a>
                        </label><br>
                        <input id="checkbox-program" type="checkbox" name="program" value="1" required>
                        <label for="checkbox-program">
                            I agree with <a href="<?php echo esc_attr($agreement_link); ?>" target="_blank" title="Program Agreement"> Program Agreement</a>
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary">Pay Now</button>
                </div>
            </form>
        </div>
    </div>
</section>

<?php get_footer(); ?>
