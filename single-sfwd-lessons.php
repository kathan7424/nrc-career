<?php get_header(); ?>
	<section class="main">
		<div class="wrapper skinny">
			<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
				
				<h1 class="post-title"><?php the_title(); ?></h1>
				
				<div class="user-content">
					<?php the_content(); ?>
				</div>

			<?php endwhile; endif; ?>
		</div>
	</section>
<?php get_footer(); ?>