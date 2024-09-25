

<!--<section class="sidebar__acount">-->
<!--    <ul class="sidebar__list">-->
<!--        <li class="sidebar__item active">-->
<!--            <a href="#personal-data">-->
<!--                Manage Profile-->
<!--            </a>-->
<!--            <div class="sidebar__personal-data active">-->
<!--                --><?php //require(__DIR__ . '/personal-data.php');?>
<!--            </div>-->
<!--        </li>-->
<!--        <li class="sidebar__item">-->
<!--            <a href="#appointments">-->
<!--                Appointments-->
<!--            </a>-->
<!--            <div class="sidebar__appointments">-->
<!--                --><?php //require(__DIR__ . '/appointments.php');?>
<!--            </div>-->
<!--        </li>-->
<!--        <li class="sidebar__item">-->
<!--            <a href="#my-program">-->
<!--                My Program-->
<!--            </a>-->
<!--            <div class="sidebar__my-program">-->
<!--                --><?php
//                require(__DIR__ . '/my-program.php');
//                ?>
<!--            </div>-->
<!--        </li>-->
<!--        <li class="sidebar__item">-->
<!--            <a href="--><?php //echo esc_url($url . '/exit');?><!--">-->
<!--                Logout-->
<!--                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="15" viewBox="0 0 11 15" fill="none">-->
<!--                    <path d="M5.5013 7.5H10.4596M10.4596 7.5L8.33464 9.625M10.4596 7.5L8.33464 5.375M10.4596 3.25V2.54167C10.4596 2.16594 10.3104 1.80561 10.0447 1.53993C9.77903 1.27426 9.41869 1.125 9.04297 1.125H1.95964C1.58391 1.125 1.22358 1.27426 0.957901 1.53993C0.692224 1.80561 0.542969 2.16594 0.542969 2.54167V12.4583C0.542969 12.8341 0.692224 13.1944 0.957901 13.4601C1.22358 13.7257 1.58391 13.875 1.95964 13.875H9.04297C9.41869 13.875 9.77903 13.7257 10.0447 13.4601C10.3104 13.1944 10.4596 12.8341 10.4596 12.4583V11.75" stroke="#666666" stroke-width="1.0625" stroke-linecap="round" stroke-linejoin="round"/>-->
<!--                </svg>-->
<!--            </a>-->
<!--        </li>-->
<!--    </ul>-->
<!--</section>-->


<section class="sidebar__acount">
	<ul class="sidebar__list">
		<li class="sidebar__item <?php echo is_page('account') ? 'active' : ''; ?>">
			<a href="<?php echo esc_url(home_url('/account/')); ?>">
				Manage Profile
			</a>
		</li>
		<li class="sidebar__item <?php echo is_page('appointments') ? 'active' : ''; ?>">
			<a href="<?php echo esc_url(home_url('/appointments/')); ?>">
				Appointments
			</a>
		</li>
		<li class="sidebar__item <?php echo is_page('account-program') ? 'active' : ''; ?>">
            <a href="<?php echo esc_url(home_url('/account-program/')); ?>">
				My Program
			</a>
            <div class="sidebar__my-program active">
                <?php require('my-program.php'); ?>
            </div>
		</li>
		<li class="sidebar__item">
            <a href="<?php echo wp_logout_url(home_url()); ?>">
            Logout
				<svg xmlns="http://www.w3.org/2000/svg" width="11" height="15" viewBox="0 0 11 15" fill="none">
					<path d="M5.5013 7.5H10.4596M10.4596 7.5L8.33464 9.625M10.4596 7.5L8.33464 5.375M10.4596 3.25V2.54167C10.4596 2.16594 10.3104 1.80561 10.0447 1.53993C9.77903 1.27426 9.41869 1.125 9.04297 1.125H1.95964C1.58391 1.125 1.22358 1.27426 0.957901 1.53993C0.692224 1.80561 0.542969 2.16594 0.542969 2.54167V12.4583C0.542969 12.8341 0.692224 13.1944 0.957901 13.4601C1.22358 13.7257 1.58391 13.875 1.95964 13.875H9.04297C9.41869 13.875 9.77903 13.7257 10.0447 13.4601C10.3104 13.1944 10.4596 12.8341 10.4596 12.4583V11.75" stroke="#666666" stroke-width="1.0625" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
			</a>
		</li>
	</ul>
</section>


