<section class="office">
	<span class="office__decore-border"></span>
	<div class="container">
		<h2 class="office__title">
			Acount
		</h2>
		<div class="office__container">
			<aside class="office__sidebar">
				<?php require_once(__DIR__ . '/modules/acount/sidebar-acount.php');?>
			</aside>
			<div class="office__content">
				<div class="office__personal-data <?php echo is_page('account') ? 'active' : ''; ?>">
					<?php require(__DIR__ . '/modules/acount/personal-data.php');?>
				</div>
				<div class="office__appointments <?php echo is_page('appointments') ? 'active' : ''; ?>">
					<?php require(__DIR__ . '/modules/acount/appointments.php');?>
				</div>
				<div class="office__my-program <?php echo is_page('account-program') ? 'active' : ''; ?>">
					<?php require(__DIR__ . '/modules/acount/my-program.php');?>
				</div>
			</div>
		</div>
	</div>
</section>
