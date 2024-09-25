<!DOCTYPE html>

<html lang="<?php language_attributes(); ?>">
<head>
    <meta charset="<?php bloginfo( 'charset' );?>"/>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-Z48X20F3ZC"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-Z48X20F3ZC');
    </script>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Lato:400,300,700,900' rel='stylesheet' type='text/css'>
    <link rel="shortcut icon" href="<?php echo get_site_icon_url(); ?>" />
    <?php wp_head();?>

    <style>
        /* Spinner Styles */
        .spinner {
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-left-color: #000;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        #hero-slider-container {
            position: relative;
            width: 100%;
            padding-top: 56.25%; /* Співвідношення 16:9 (9/16 = 0.5625) */
            overflow: hidden;
            display: none; /* Приховуємо контейнер до завантаження */
        }

        #hero-slider-container .rev-slider {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }


    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var images = document.querySelectorAll("#hero-slider-container img");
            var loadedImages = 0;

            images.forEach(function(img) {
                img.onload = function() {
                    loadedImages++;
                    if (loadedImages === images.length) {
                        document.getElementById("loader").style.display = "none";
                        document.getElementById("hero-slider-container").style.display = "block";
                    }
                };

                // Враховуємо випадок, якщо зображення було закешовано і завантажилося миттєво
                if (img.complete) {
                    img.onload();
                }
            });
        });

    </script>
</head>

<?php 
    $body_class = '';
    if(is_front_page()){
        $body_class = 'homepage';
    }else{
        $body_class = 'subpage';
       
    }
?>

<body class="<?php echo $body_class;?>">
<div class="overlay"></div>

<div class="outer-wrapper">
<div class="page-wrapper">

    <header class="navigation" id="top">
        <div class="container">
            <!-- <div class="secondary-nav">
                <?php
                    $email = get_field('contacts_email', 'option');
                    if( $email ):
                        $link_url = $email['url'];
                        $link_title = $email['title'];
                        $link_target = $email['target'] ? $email['target'] : '_self';
                ?>
                <span>
                    <a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><i class="icon_mail"></i><?php echo esc_html( $link_title ); ?></a>
                </span>
                <?php 
                    endif; 
                    $number = get_field('contacts_number', 'option');
                    if( $number ):
                        $link_url = $number['url'];
                        $link_title = $number['title'];
                        $link_target = $number['target'] ? $number['target'] : '_self';
                ?>
                <span>
                    <a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><i class="icon_phone"></i><?php echo esc_html( $link_title ); ?></a>
                </span>
                <?php endif; ?>
            </div> -->
            <!--/.secondary-nav-->
            <div class="main-nav">
                <div class="brand">
                    <?php the_custom_logo();?>
                </div><!--/.brand-->

                <?php 
                    $locations = get_nav_menu_locations();
                    $menu_id = $locations["menu-header"];
                    $menu_items = wp_get_nav_menu_items( $menu_id, [
                        'order' => 'ASC',
                        'orderby' => 'menu_order',
                    ]);
                ?>
                 <nav>
                    <ul>
                        <?php 
                            $http_s = 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 's' : '') . '://';
                            $url = $http_s . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

                            foreach ($menu_items as $item):
                                $class_text = '';
                                $title = $item->title;
                                $url_item = $item->url;
                                
                                if($url_item === $url){
                                    $class_text = 'active';
                                 
                                }
                               
                        ?>
                        <li class="<?php echo $class_text;?>">
                            <a href="<?php echo $url_item;?>">
                                <?php echo $title;?>
                            </a>
                        </li>
                        <?php endforeach;?>
                    </ul>
                    <div class="nav-toggle"><i class="icon_menu"></i></div>
                </nav>

                <nav class="menu-account-container">
                    <ul class="menu-acount">
                        <?php if (is_user_logged_in()): ?>
                            <li id="menu-item-44" class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-12 current_page_item menu-item-44">
                                <a href="<?php echo esc_url(home_url('/account/')); ?>">ACCOUNT</a>
                            </li>
                        <?php else: ?>
                            <li id="menu-item-44" class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-12 current_page_item menu-item-44">
                                <a href="<?php echo esc_url(home_url('/login/')); ?>" aria-current="page">LOGIN</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                    </ul>
                </nav>

                <?php

//                    wp_nav_menu([
//                        'theme-location' => 'menu-acount',
//                        'container' => 'nav',
//                        'menu_class' => 'menu-acount',
//                        'items_wrap' => '<ul class="%2$s">%3$s</ul>'
//                    ]);

                    if( have_rows('social_networks_repeat', 'option') ) : 
                ?>
                    <nav>
                        <ul class="social-network">
                            <?php while( have_rows('social_networks_repeat', 'option') ) : the_row(); ?>
                                <?php
                                $image = get_sub_field('icon_social_networks');
                                $link = get_sub_field('link_social_networks');
                                if( !empty( $image ) && !empty( $link ) ):
                                    $link_url = $link['url'];
                                    $link_title = $link['title'];
                                    $link_target = $link['target'] ? $link['target'] : '_self';
                                ?>
                                <li>
                                    <a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>">
                                        <img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" />
                                    </a>
                                </li>
                                <?php endif; ?>
                            <?php endwhile; ?>
                        </ul>
                    <nav>
                    <?php 
                    endif; 
                ?>
                <a href="/#make-an-appointment" class="icon-shortcut"><i class="icon_calendar" title="Make an Appointment"></i></a><!--/.icon-->
            </div>
            <!--/.main-nav-->
        </div>
        <!--/.container-->
    </header>