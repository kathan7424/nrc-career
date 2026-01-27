<?php get_header(); ?>
	<?php if(have_posts()) : while(have_posts()) : the_post(); ?>

		<?php if($post->ID === 0) : // this is for "virtual pages" from the idx plugin ?>	

			<section class="page-cover-block">
				<div class="cover-content-wrap">
					<div class="wrapper">
						<div class="cover-wrap">
							<h1 class="cover-title"><?php echo $post->post_title; ?></h1>
						</div>
					</div>
				</div>
			</section>

			<div class="wrapper">
		<?php endif; ?>

		<?php the_content(); ?>

		<?php if($post->ID === 0) : ?>
			</div>
		<?php endif; ?>


	<?php endwhile; endif; ?>
<?php get_footer(); ?>