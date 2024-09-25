<?php

$is_logged_in = is_user_logged_in();
$current_user = wp_get_current_user();
$redirect_url = '/login';

if ($is_logged_in) {
    $user_id = $current_user->ID;

    // Check if user has filled out the interview form
    if (!is_user_profile_complete($user_id)) {
        $redirect_url = '/interviewer/';
    } else {
        $has_active_subscription = has_active_subscription($user_id);
        if ($has_active_subscription) {
            $redirect_url = '/account-program';
        } else {
            $redirect_url = '/payment';
        }
    }
}

?>

<script
        src="https://www.paypal.com/sdk/js?client-id=AXKPRYqXSoK9qCsT-o5l8ajd_u92JCRV8UvdUQdc3xy5M56nWpZvM-Xv2-u8OOSNAG2BeS2jIjLyPOW5
&components=messages"
        data-namespace="PayPalSDK">
</script>
<div class="pricing">

	<?php if( have_rows('packages_options', 'option') ):?>
	<div class="row">
		<!--/ .col-md-3-->

		<?php
        $is_logged_in = is_user_logged_in();
			while( have_rows('packages_options', 'option') ) : the_row();

			$boolean_best_package = get_sub_field('best_package');
			
			if($boolean_best_package){			
		?>


			<div class="col-md-3 col-sm-3">
                <form action="<?php echo $redirect_url; ?>" method="post">
                    <input type="hidden" name="price" value="<?php echo get_sub_field('price_packages');?>">
                    <input type="hidden" name="agreement_link" value="<?php echo get_sub_field('agreement_link');?>">
                    <input type="hidden" name="package_title" value="<?php echo get_sub_field('package_title');?>">
                    <input type="hidden" name="number_sessions" value="<?php echo get_sub_field('number_sessions');?>">
                    <div class="price-box promoted">
                            <div class="best-value">Top!</div>
                            <h3 class="center">
                                <?php echo get_sub_field('package_title');?>
                            </h3>
                            <?php if( have_rows('list_services_package') ):?>
                            <ul>
                                <?php while( have_rows('list_services_package') ) : the_row();?>
                                <li class="available active">
                                    <?php echo get_sub_field('name_service');?>
                                    <div class="available-box">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                            <path d="M7.99967 1.33203C11.6823 1.33203 14.6677 4.31736 14.6677 8.00003C14.6677 11.682 11.6823 14.6667 7.99967 14.6667C4.31701 14.6674 1.33301 11.682 1.33301 8.00003C1.33234 4.31736 4.31701 1.33203 7.99967 1.33203ZM7.99967 2.33203C7.25021 2.3239 6.50658 2.4645 5.81182 2.74568C5.11706 3.02686 4.48496 3.44304 3.95212 3.97014C3.41927 4.49724 2.99626 5.12479 2.70756 5.81646C2.41886 6.50813 2.2702 7.25019 2.2702 7.9997C2.2702 8.7492 2.41886 9.49127 2.70756 10.1829C2.99626 10.8746 3.41927 11.5022 3.95212 12.0293C4.48496 12.5564 5.11706 12.9725 5.81182 13.2537C6.50658 13.5349 7.25021 13.6755 7.99967 13.6674C9.49219 13.6512 10.9181 13.0469 11.9678 11.9858C13.0174 10.9247 13.6062 9.4923 13.6062 7.9997C13.6062 6.5071 13.0174 5.07474 11.9678 4.01361C10.9181 2.95247 9.49219 2.34822 7.99967 2.33203ZM7.99701 6.9987C8.11795 6.99854 8.23485 7.04223 8.32604 7.12166C8.41724 7.20109 8.47656 7.31088 8.49301 7.4307L8.49767 7.4987L8.50034 11.1667C8.50164 11.2943 8.45411 11.4175 8.36749 11.5112C8.28088 11.6049 8.16172 11.6619 8.03442 11.6706C7.90713 11.6793 7.78133 11.639 7.68278 11.558C7.58423 11.4769 7.5204 11.3613 7.50434 11.2347L7.50034 11.1674L7.49767 7.49936C7.49767 7.36676 7.55035 7.23958 7.64412 7.14581C7.73789 7.05204 7.86507 6.99936 7.99767 6.99936M8.00101 4.66803C8.0902 4.66521 8.17904 4.68034 8.26227 4.71252C8.3455 4.7447 8.42141 4.79328 8.4855 4.85537C8.54959 4.91747 8.60055 4.9918 8.63534 5.07397C8.67014 5.15614 8.68808 5.24446 8.68808 5.3337C8.68808 5.42293 8.67014 5.51126 8.63534 5.59342C8.60055 5.67559 8.54959 5.74993 8.4855 5.81202C8.42141 5.87411 8.3455 5.92269 8.26227 5.95488C8.17904 5.98706 8.0902 6.00219 8.00101 5.99936C7.82811 5.99389 7.66412 5.92136 7.54375 5.79712C7.42338 5.67288 7.35608 5.50668 7.35608 5.3337C7.35608 5.16071 7.42338 4.99451 7.54375 4.87027C7.66412 4.74603 7.82811 4.6735 8.00101 4.66803Z" fill="white" fill-opacity="0.6"/>
                                        </svg>
                                        <div class="service-description">
                                            <?php echo get_sub_field('service_description');?>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="16" viewBox="0 0 24 16" fill="none">
                                                <path d="M12 16L0.741669 0.25H23.2583L12 16Z" fill="#5F5E5D"/>
                                            </svg>
                                        </div>
                                    </div>
                                </li>
                                <?php endwhile;?>
                            </ul>
                            <?php endif;?>
                            <div class="price">
                                $<?php echo get_sub_field('price_packages');?>
    <!--							<br>-->
    <!--							<span class="payment-in-installments active">-->
    <!--								--><?php //echo get_sub_field('payment_installments');?>
    <!--							</span>-->
                            </div>

                        <div
                                data-pp-message
                                data-pp-style-layout="text"
                                data-pp-style-logo-type="primary"
                                data-pp-style-text-color="white"
                                data-pp-amount="<?php echo get_sub_field('price_packages');?>">
                        </div>


                            <button type="submit" class="btn btn-primary btn-white">Buy Now</button>
                    </div>
                </form>
			</div>

		<?php 
			}else {
		?>

		<div class="col-md-3 col-sm-3">
            <form action="<?php echo $redirect_url; ?>" method="post">
                <input type="hidden" name="price" value="<?php echo get_sub_field('price_packages');?>">
                <input type="hidden" name="agreement_link" value="<?php echo get_sub_field('agreement_link');?>">
                <input type="hidden" name="package_title" value="<?php echo get_sub_field('package_title');?>">
                <input type="hidden" name="number_sessions" value="<?php echo get_sub_field('number_sessions');?>">
                <div class="price-box">
                        <h3 class="center">
                            <?php echo get_sub_field('package_title');?>
                        </h3>
                        <?php if( have_rows('list_services_package') ):?>
                        <ul>
                            <?php
                                // $count = 0;
                                while( have_rows('list_services_package') ) : the_row();
                                    if(get_sub_field('name_service')){?>

                            <li class="available">
                                <?php echo get_sub_field('name_service');?>
                                <div class="available-box">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                        <path d="M7.99967 1.33203C11.6823 1.33203 14.6677 4.31736 14.6677 8.00003C14.6677 11.682 11.6823 14.6667 7.99967 14.6667C4.31701 14.6674 1.33301 11.682 1.33301 8.00003C1.33234 4.31736 4.31701 1.33203 7.99967 1.33203ZM7.99967 2.33203C7.25021 2.3239 6.50658 2.4645 5.81182 2.74568C5.11706 3.02686 4.48496 3.44304 3.95212 3.97014C3.41927 4.49724 2.99626 5.12479 2.70756 5.81646C2.41886 6.50813 2.2702 7.25019 2.2702 7.9997C2.2702 8.7492 2.41886 9.49127 2.70756 10.1829C2.99626 10.8746 3.41927 11.5022 3.95212 12.0293C4.48496 12.5564 5.11706 12.9725 5.81182 13.2537C6.50658 13.5349 7.25021 13.6755 7.99967 13.6674C9.49219 13.6512 10.9181 13.0469 11.9678 11.9858C13.0174 10.9247 13.6062 9.4923 13.6062 7.9997C13.6062 6.5071 13.0174 5.07474 11.9678 4.01361C10.9181 2.95247 9.49219 2.34822 7.99967 2.33203ZM7.99701 6.9987C8.11795 6.99854 8.23485 7.04223 8.32604 7.12166C8.41724 7.20109 8.47656 7.31088 8.49301 7.4307L8.49767 7.4987L8.50034 11.1667C8.50164 11.2943 8.45411 11.4175 8.36749 11.5112C8.28088 11.6049 8.16172 11.6619 8.03442 11.6706C7.90713 11.6793 7.78133 11.639 7.68278 11.558C7.58423 11.4769 7.5204 11.3613 7.50434 11.2347L7.50034 11.1674L7.49767 7.49936C7.49767 7.36676 7.55035 7.23958 7.64412 7.14581C7.73789 7.05204 7.86507 6.99936 7.99767 6.99936M8.00101 4.66803C8.0902 4.66521 8.17904 4.68034 8.26227 4.71252C8.3455 4.7447 8.42141 4.79328 8.4855 4.85537C8.54959 4.91747 8.60055 4.9918 8.63534 5.07397C8.67014 5.15614 8.68808 5.24446 8.68808 5.3337C8.68808 5.42293 8.67014 5.51126 8.63534 5.59342C8.60055 5.67559 8.54959 5.74993 8.4855 5.81202C8.42141 5.87411 8.3455 5.92269 8.26227 5.95488C8.17904 5.98706 8.0902 6.00219 8.00101 5.99936C7.82811 5.99389 7.66412 5.92136 7.54375 5.79712C7.42338 5.67288 7.35608 5.50668 7.35608 5.3337C7.35608 5.16071 7.42338 4.99451 7.54375 4.87027C7.66412 4.74603 7.82811 4.6735 8.00101 4.66803Z" fill="#37B048" fill-opacity="0.6"/>
                                    </svg>
                                    <div class="service-description">
                                        <?php echo get_sub_field('service_description');?>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="16" viewBox="0 0 24 16" fill="none">
                                            <path d="M12 16L0.741669 0.25H23.2583L12 16Z" fill="#5F5E5D"/>
                                        </svg>
                                    </div>
                                </div>
                            </li>

                            <?php
                                }else{

                            ?>
                                <li class="not-available"><i class="icon_close"></i></li>
                            <?php
                                }
                                endwhile;
                            ?>
                        </ul>
                        <?php endif;?>
                        <div class="price">
                            $<?php echo get_sub_field('price_packages');?>
    <!--						<span class="payment-in-installments">-->
    <!--						--><?php //echo get_sub_field('payment_installments');?>
    <!--						</span>-->
                        </div>
                        <div
                                data-pp-message
                                data-pp-style-layout="text"
                                data-pp-style-logo-type="primary"
                                data-pp-style-text-color="black"
                                data-pp-amount="<?php echo get_sub_field('price_packages');?>">
                        </div>
                        <button type="submit" class="btn btn-default">Buy Now</button>
                </div>
            </form>
		</div>
		<?php 
			}
				endwhile;
		?>
	</div>
	<?php endif;?>
</div>