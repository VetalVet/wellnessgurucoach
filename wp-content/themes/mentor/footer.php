</div>
<footer id="footer">
        <div class="container">
            <div class="row">
                <div class="footer__logo-container">
                    <?php the_custom_logo();?>
                </div>
                <div class="footer__menu">
                    <div class="footer__social-network">
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
                    </div>

                    <?php 
                        $locations = get_nav_menu_locations();
                        $menu_id = $locations["menu-footer"];
                        $menu_items = wp_get_nav_menu_items( $menu_id, [
                            'order' => 'ASC',
                            'orderby' => 'menu_order',
                        ]);
                    ?>
                    <nav class="footer__nav">
                        <ul class="footer__nav-list">
                            <?php 
            
                                foreach ($menu_items as $item):
                                    $class_text = '';
                                    $title = $item->title;
                                    $url_item = $item->url;
                                    
                                
                            ?>
                            <li class="footer__nav-item">
                                <a href="<?php echo $url_item;?>">
                                    <?php echo $title;?>
                                </a>
                            </li>
                            <?php endforeach;?>
                        </ul>
                    </nav>
                </div>
                 <div class="footer__copy">
                    <span>(C) <?php echo date('Y')?> Wellness Guru LLC. All Rights Reserved</span>
                </div>
            </div>
        </div>
        <!--/ .container-->
    </footer>


</div>
<?php

    //require_once(__DIR__ . '/assets/external/calendar.php');
    //echo do_shortcode( '[CP_APP_HOUR_BOOKING id="1"]' );
    
?> 
<!-- [if lte IE 9]>
    <script src="assets/js/ie.js"></script>
<![endif] -->
<?php wp_footer(); ?>

</body>
</html>