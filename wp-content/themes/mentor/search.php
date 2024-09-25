<?php get_header();?>

	<div class="container">
        <div class="breadcrumb-area">
            <div class="row justify-content-center">
                <div class="col-md-12">
					<h1 class="theme-breacrumb-title">Blog Listing</h1>
				</div>
            </div>
        </div>
    </div>
    
    <!-- blog-area start -->
    <div class="blog-area pd-top-100 pd-bottom-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 blog-content">
                    <?php if(have_posts()): while(have_posts()) : the_post(); ?>
                        <div class="media-post-wrap pd-bottom-80 mb-0 blog-article">
                            <div class="thumb mb-4">
                                <div class="blog__container-img">
                                    <?php the_post_thumbnail();?>
                                </div>
                            </div>
                            <div class="media-body pt-1 ms-0">
                                <?php if (has_category()) {
                                    $categories = get_the_category();
												$category_link = get_category_link($categories[0]->term_id);
                                ?>
                                <a class="tag top-right tag-yellow blog-topics" href="<?= esc_url($category_link); ?>">
                                    <?= esc_html($categories[0]->name);?>
                                </a>
                                <?php }?>
                                <h1 class="blog__title">
                                    <a href="<?= esc_url(get_permalink());?>">
                                        <?php the_title();?>
                                    </a>
                                </h1>
                            </div>
                            <div class="meta d-flex">
                                <div class="author">

                                    <div class="thumb">
                                        <?php 
                                            $image = get_field('blog_photo_by_the_author');
                                            if( !empty( $image ) ): ?>
                                                <img src="<?= esc_url($image['url']); ?>" alt="<?= esc_attr($image['alt']); ?>" />
                                        <?php endif; ?>
                                    </div>
                                    <a href="#">
                                        <?= get_field('blog_name_avtor');?>
                                    </a>
                                </div>
                                <div class="date">
                                    <i class="fa fa-clock-o"></i>
                                        <?= get_the_date('M j, Y'); ?>
                                </div>
                            </div>
                            <p class="mb-3 blog-text">
                                <?= get_the_excerpt();?>
                                <!-- When working remotely and having to manage your own time, it is not uncommon for breaks to be overlooked. A new survey by the online scheduling platform Doodle confirms the US workforce’s collective neglect of breaks. 72% of US employees admit to feeling -->
                            </p>
                            <a class="btn btn-main mt-3 blog-button__read-more" href="<?= esc_url(get_permalink());?>">
                                Read More
                            </a>
                        </div>
                    <?php endwhile; else:?>
                        No records found.    
                    <?php endif;?>

                    <?php 
                        $args = array(
                            'prev_next'    => true,  // выводить ли боковые ссылки "предыдущая/следующая страница".
                            'prev_text'    => '<i class="fa fa-long-arrow-left"></i>',
                            'next_text'    => '<i class="fa fa-long-arrow-right"></i>',
                        );
                        ?>
                        <div class="pagination-area text-center">
                            <nav aria-label="Page navigation example">
                            <?php  the_posts_pagination($args);?>
                            </nav>
                        </div>

                   
                </div>
                <?php get_sidebar();?>
            </div>
        </div>
    </div>
    <!-- blog-area end -->

<?php get_footer();?>