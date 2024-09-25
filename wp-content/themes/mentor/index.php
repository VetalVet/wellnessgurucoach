<?php
    /*
        Template Name: Home page
    */
    get_header();

    check_and_update_subscriptions();

$phone_number = get_field('contacts_number', 'option');
$contacts_email = get_field('contacts_email', 'option');

?>
    <!--/.header-->

    <div id="loader" style="display: flex; align-items: center; justify-content: center; height: 100vh;">
        <div class="spinner"></div>
    </div>

    <div id="hero-slider-container" class="hero-slider" style="min-height: 100px; display: none;">
        <div class="rev-slider">
            <ul>
                <li>
                    <img src="<?php echo _menta_assets_path('img/banner.png');?>" alt="">
                    <div class="tp-caption"
                         data-x="left" data-hoffset="0"
                         data-y="top" data-voffset="150"
                         data-transform_idle="o:1;"
                         data-transform_in="x:50px;opacity:0;s:700;e:Power3.easeInOut;"
                         data-start="500"><h4 class="opacity-40 hero-slider__name">Hi, I’m Marina Vaysbaum.<br> A Personal Health Coach</h4>
                    </div>
                    <div class="tp-caption"
                         data-x="left" data-hoffset="0"
                         data-y="top" data-voffset="210"
                         data-transform_idle="o:1;"
                         data-transform_in="x:50px;opacity:0;s:700;e:Power3.easeInOut;"
                         data-start="600">
                        <h1 class="hero-slider__title">Guiding people<br> to a healthier life</h1>
                    </div>
                    <div class="tp-caption"
                         data-x="left" data-hoffset="0"
                         data-y="top" data-voffset="410"
                         data-transform_idle="o:1;"
                         data-transform_in="x:50px;opacity:0;s:700;e:Power3.easeInOut;"
                         data-start="700"><a href="#make-an-appointment" class="link underline scroll">Tell Me How</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>


    <div class="page-content">

    <div class="block" id="about-me">
        <div class="container">
            <h2>
                <?php echo get_field('home_page_main_title_section_about_me');?>
            </h2>
            <div class="row">
                <div class="col-md-6 col-sm-6 about-me__container">
                    <?php 
                        $image = get_field('home_page_image _section_about_me');
                        if( !empty( $image ) ):
                    ?>
                    <div class="center about-me__img-container">
                        <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" /> 
                    </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6 col-sm-6">
                    <h3 class="no-bottom-margin">
                        <strong>
                            <?php echo get_field('home_page_name_section_about_me');?>
                        </strong>
                    </h3>
                    <h5>
                        <?php echo get_field('home_page_profession_section_about_me');?>
                    </h5>
                    <br>
                    <p class="about-me__text">
                      <?php echo get_field('home_page_about_me_section_about_me');?>
                    </p>
                    <div class="numbers">
                        <?php if( have_rows('home_page_experience_section_about_me') ):?>
                        <div class="row">
                            <?php  while( have_rows('home_page_experience_section_about_me') ) : the_row();
                                 $quantity = get_sub_field('home_page_quantity_section_about_me');    
                                 $development = get_sub_field('home_page_development_section_about_me');
                            ?>
                            <div class="col-md-4 col-sm-4">
                                <div class="number">
                                    <?php if( !empty( $quantity ) ): ?>
                                    <figure><?php echo $quantity;?></figure>
                                    <?php 
                                        endif;
                                        if( !empty( $development ) ):
                                    ?>
                                    <aside><?php echo $development;?></aside>
                                    <?php endif;?>
                                </div>
                                <!--/ .number-->
                            </div>
                            <?php endwhile;?>
                            <!--/ .col-md-4-->
                        </div>
                        <?php endif;?>
                        <!--/ .row-->
                    </div>
                    <!--/ .numbers-->
                    <hr>
                    <?php 
                    $link = get_field('home_page_link_section_about_me');
                    if( $link ): 
                        $link_url = $link['url'];
                        $link_title = $link['title'];
                        $link_target = $link['target'] ? $link['target'] : '_self';
                        ?>
                        <a class="link arrow" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
                    <?php endif; ?>
                </div>
                <!--/ .col-sm-6-->
            </div>
            <!--/ .row-->
        </div>
        <!--/ .container-->
    </div>
    <!--/ .block-->

    <div class="block" id="successful-stories">
        <div class="container">
            <h2>Testimonials</h2>
            <div class="row">
                <?php if( have_rows('first_testimonials_column') ):?>
                <div class="col-md-6">
                    <?php  while( have_rows('first_testimonials_column') ) : the_row();
                    
                        $text = get_sub_field('сlient_comment');
                        $name = get_sub_field('client_name');
                        $images = get_sub_field('client_photo');
                    ?>
                    <div class="story">
                        <?php if( !empty( $images ) ):?>
                        <div class="image">
                            <img src="<?php echo esc_url($images['url']); ?>" alt="<?php echo esc_attr($images['alt']); ?>" />
                        </div>
                        <?php endif; ?>
                        <blockquote <?php echo empty($images) ? 'style="margin-left:0px"' : '' ;?>>
                            <p>
                                <?php echo $text;?>
                            </p>
                            <footer> 
                                <?php echo $name;?>
                            </footer>
                        </blockquote>
                        <!--/ blockquote-->
                    </div>
                    <?php endwhile;?>
                    <!--/ .story-->
                </div>
                <?php endif;?>
                <!--/ .col-md-6-->
                <?php if( have_rows('second_testimonials_column') ):?>
                <div class="col-md-6">
                    <?php  while( have_rows('second_testimonials_column') ) : the_row();
                    
                        $text = get_sub_field('сlient_comment');
                        $name = get_sub_field('client_name');
                        $images = get_sub_field('client_photo');
                   
                    ?>
                    <div class="story">
                        <?php if( !empty( $images ) ):?>
                        <div class="image">
                            <img src="<?php echo esc_url($images['url']); ?>" alt="<?php echo esc_attr($images['alt']); ?>" />
                        </div>
                        <?php endif; ?>
                        <blockquote <?php echo empty($images) ? 'style="margin-left:0px"' : '' ;?>>
                            <p>
                                <?php echo $text;?>
                            </p>
                            <footer> 
                                <?php echo $name;?>
                            </footer>
                        </blockquote>
                        <!--/ blockquote-->
                    </div>
                    <?php endwhile;?>
                    <!--/ .story-->
                </div>
                <?php endif;?>
                <!--/ .col-md-6-->
            </div>
            <!--/ .row-->
        </div>
        <!--/ .container-->
        <div class="bg"></div><!--/ .bg-->
    </div>

    <div class="space"></div>

    <div class="container">
        <div class="block center">
            <h2 class="text-color-white half-bottom-margin"><strong>Subscribe our Newsletter</strong></h2>
            <div class="row">
                <div class="col-md-6 col-sm-6 col-md-offset-3 col-sm-offset-3">
                    <!-- <form id="form-daily-motivation">
                        <div class="form-group input-group">
                            <div class="form-status text-color-white"></div>
                            <input type="text" class="form-control" name="email" placeholder="Enter your e-mail">
                            <span class="input-group-btn"><button class="button-daily" type="submit">Send Me</button></span>
                        </div>
                    </form> -->
                    <?php echo do_shortcode( '[mailpoet_form id="1"]' );?>
                    <!--/ form-->
                </div>
                <!--/ .col-md-6-->
            </div>
            <!--/ .row-->
            <div class="bg">
                <img src="<?php echo _menta_assets_path('img/bg.jpg');?>" alt="">
            </div><!--/ .bg-->
        </div>
        <!--/ .block-->
    </div>
    <!--/ .container-->

    <div class="space"></div>

    <div class="block" id="make-an-appointment">
        <div class="container">
            <h2 class="center">Make a First Free Appointment With Me</h2>
            <div class="row">
                <div class="col-md-10 col-sm-10 col-md-offset-1 col-sm-offset-1">
                    <div class="calendar big" data-url="<?php echo get_template_directory_uri(); ?>/assets/external/calendar.php"></div>
                </div>
            </div>
        </div>
        <!--/ .container-->
        <div class="bg"></div><!--/ .bg-->
    </div>
    <!--/ .block-->

    <hr>
    <!--/ .block-->

    <div class="block" id="packages">
        <div class="container">
            <h2>Program</h2>
            <?php require(__DIR__ . '/modules/acount/pricing.php');?>
            <!--/ .pricing-->
        </div>
        <!--/ .container-->
        <div class="bg"></div><!--/ .bg-->
    </div>
    
    <!--/ .block-->

    <div class="space"></div>

    <section id="contacts">
        <div class="container">
            <div class="blog-posts__title text-center">
                Contacts
            </div>
            <ul class="cont">
                <li class="cont_phone"><span><a href="<?php echo $phone_number['url']; ?>"><?php echo $phone_number['title']; ?></a></span></li>
                <li class="cont_inst"><span><a href="https://www.instagram.com/marina_wellnessguru/">marina_wellnessguru</a></span></li>
                <li class="cont_email"><span><a href="<?php echo $contacts_email['url']; ?>"><?php echo $contacts_email['title']; ?></a></span></li>
                <li class="cont_facebook"><span><a href="https://www.facebook.com/marina.vaysbaum">Marina Vaysbaum</a></span></li>
            </ul>
        </div>
    </section>


        <!--/ .block-->
        <div class="space"></div>
    
    <!-- blog -->



    <div class="blog-posts">
        <div class="container">
            <h4 class="blog-posts__title">
                Blogs
            </h4>

            <?php
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => 9,
                'order' => 'DESC',
            );

            $query = new WP_Query($args);
            if ($query->have_posts()) :
                ?>
                <div class="owl-carousel owl-theme">
                    <?php while ($query->have_posts()) : $query->the_post(); ?>
                        <div class="item blog-posts__post">
                            <h5 class="blog-posts__post-title">
                                <a href="<?= esc_url(get_permalink()); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h5>
                            <div class="blog-posts__conteiner-img">
                                <?php the_post_thumbnail('custom-size'); ?>
                            </div>
                            <a class="blog-posts__button" href="<?= esc_url(get_permalink()); ?>">
                                read more
                            </a>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php
            endif;
            wp_reset_postdata();
            ?>
        </div>
    </div>




    <!--/ blog -->

    <!--/ .block-->

    </div>

<?php
    require_once('modules/modal-fade.php');
    get_footer();
?>