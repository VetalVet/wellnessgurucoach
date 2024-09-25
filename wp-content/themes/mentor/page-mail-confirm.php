<?php
/*
  Template Name: Page Simple
*/

get_header();
?>

    <section class="privacy-policy">
        <div class="container">
            <h3 class="privacy-policy__title">
                <?php the_title();?>
            </h3>
            <div class="privacy-policy__content">
                <?php the_content();?>

                {{confirmation_link}}
            </div>
        </div>
    </section>

<?php
get_footer();
?>