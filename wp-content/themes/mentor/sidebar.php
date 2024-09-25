<!-- sidebar -->
	<div class="col-md-4 col-sm-4 sidebar-content">
		<section id="sidebar" class="sidebar">
			<aside id="search">
					<header><h3>Search</h3></header>
					<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ) ?>" class="input-group">
						<input type="text" class="form-control framed" placeholder="Enter Keyword"  value="<?php echo get_search_query() ?>" name="s" id="s">
						<span class="input-group-btn">
							<button class="btn btn-primary" type="submit">
								<i class="fa fa-search"></i>
							</button>
						</span>
					</form><!-- /input-group -->
			</aside>
			<aside id="categories">
					<header><h3>Categories</h3></header>
					<ul class="list-links">
						<?php
						$categories = get_categories();
						foreach ($categories as $category) : ?>
							<li><a href="<?php echo esc_url(get_category_link($category->term_id)); ?>"><?php echo esc_html($category->name); ?></a></li>
						<?php endforeach; ?>
					</ul>
			</aside><!-- /#categories -->
		</section><!-- /#sidebar -->
	</div><!-- /.col-md-3 -->
<!-- end Sidebar -->