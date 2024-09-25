<?php
    get_header();
?>

    <div class="heading">
        <div class="container">
            <h1>Blog Details</h1>
        </div>
    </div>
    
    <!-- blog-area start -->
    <div class="blog-area pd-top-100 pd-bottom-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="media-post-wrap mb-0">
                        <div class="thumb mb-4">
                            <div class="blog__container-img">
                                <?php the_post_thumbnail();?>
                            </div>
                        </div>
                        <div class="media-body pt-1 ms-0">
                            <?php if (has_category()) {
                                $categories = get_the_category();
                                foreach ($categories as $category) {
                                    $category_link = get_category_link($category->term_id);
                                    ?>
                                    <a class="tag top-right tag-pest blog-topics" href="<?= esc_url($category_link); ?>">
                                        <?= esc_html($category->name); ?>
                                    </a>
                                    <?php
                                }
                            }?>
                            <h1 class="blog__title post__title">
                                <?php the_title(); ?>
                            </h1>
                        </div>

                        <?php 
                                    $image = get_field('blog_photo_by_the_author');
                                    if(empty( $image )){
                                        $modified_class = "display:none";
                                    }else{
                                        $modified_class = "";
                                    }
                                ?>
                        <div class="meta d-flex">
                            <div class="author" style="<?php echo $modified_class;?>">
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
                    
                        <div class="post-output">
                            <?php the_content();?>
                        </div>
                        
                        <div class="blog-tag-area mt-4">
                            <h4>Tags:</h4>
                            <div class="blog-tags">
                                <?php
                                $tags = get_the_tags();
                                if ($tags) {
                                    foreach ($tags as $tag) {
                                        ?>
                                        <a href="<?php echo get_tag_link($tag->term_id)?>"><?php echo $tag->name?></a>
                                        <?php
                                    }
                                }?>
                            </div>


                        </div>
                    </div>
                </div>
                <?php get_sidebar();?>
            </div>
        </div>
    </div>
    <!-- blog-area end -->

<?php
    require_once('modules/top-modul.php');
	get_footer();
?>