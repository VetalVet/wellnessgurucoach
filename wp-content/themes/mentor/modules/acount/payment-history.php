<section class="account">
    <div class="my-program__paymentsh-history">
        <h3 class="my-program__paymentsh-title">
            Payments History
        </h3>

        <ul class="my-program__paymentsh-table">
            <li class="my-program__item-title">Date</li>
            <li class="my-program__item-title">Program</li>
            <li class="my-program__item-title">Amount</li>
            <li class="my-program__item-title">Status</li>

            <?php if (!empty($payments_history)) : ?>
                <?php foreach ($payments_history as $payment) : ?>
                    <li class="my-program__item-data" data-label="Date"><?php echo date('d.m.Y', strtotime($payment->payment_date)); ?></li>
                    <li class="my-program__item-data" data-label="Program"><?php echo esc_html($payment->package_title); ?></li>
                    <li class="my-program__item-data" data-label="Amount">$<?php echo number_format($payment->price, 2); ?></li>
                    <li class="my-program__item-data" data-label="Status"><?php echo esc_html($payment->status); ?></li>
                <?php endforeach; ?>
            <?php else : ?>
                <li class="my-program__item-data" colspan="4">No payments found.</li>
            <?php endif; ?>
        </ul>
    </div>
</section>
