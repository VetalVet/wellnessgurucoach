<?php
    /*
        Template Name: Office
    */
    get_header();
?>

<?php if($_COOKIE['user'] != ''): ?>
<section class="office">
	<div class="container">
		<h2 class="office__title">
			Hello <?php echo $_COOKIE['user']; ?>
		</h2>
		<div class="office__exit">
			<a href="<?php echo home_url();?>">
				Exit
			</a>
		</div>
	</div>
</section>
<?php endif;?>

<?php
	get_footer();
?>