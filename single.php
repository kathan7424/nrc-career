<?php get_header(); ?>
	<section class="main">
		<div class="wrapper skinny">
			<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
				
				<h1 class="post-title"><?php the_title(); ?></h1>
				<p class="post-date">Posted on: <?php echo the_date(); ?></p>
				
				<div class="user-content">
					<?php the_content(); ?>
				</div>

				<div class="categories">
					Posted in: <?php echo get_the_category_list(); ?>
				
				</div>
			<?php endwhile; endif; ?>
		</div>
	</section>
<?php get_footer(); ?>