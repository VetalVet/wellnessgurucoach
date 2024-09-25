<?php if ($subscribe == 0) { ?>
    <div class="my-program prices">
        <?php
        require('pricing.php');
        require('payment-history.php');
        ?>
    </div>
<?php } else { ?>
    <div class="my-program">
        <div class="my-program__name-package">
            <?php echo esc_html($sessions_info->package_title); ?> wellness program
        </div>

        <div class="my-program__time-package">
                        <span class="my-program__time">
                            Start: <?php echo date('d.m.Y', strtotime($sessions_info->payment_completed)); ?>
                        </span>
            <span class="my-program__time">
                            End: <?php echo date('d.m.Y', strtotime($sessions_info->close_date)); ?>
                        </span>
        </div>

        <div class="my-program__package-usage">
            <div class="my-program__appointments">
                <div class="my-program__appointments-usage">
                    <span><?php echo esc_html($sessions_info->booking_sessions); ?></span>
                    <span>/</span>
                    <span><?php echo esc_html($sessions_info->number_sessions); ?></span>
                </div>
                <div class="my-program__appointments-title">
                    appointments
                </div>
            </div>

            <div class="my-program__package-price">
                <div class="my-program__price">
                    $<?php echo number_format($sessions_info->price, 0); ?>
                </div>
                <div class="my-program__price-title">
                    Payment Settled
                </div>
            </div>
        </div>

        <?php require('payment-history.php'); ?>

    </div>
<?php } ?>