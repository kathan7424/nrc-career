<?php get_header(); ?>

<section class="page-cover-block default" style="background:url('<?php echo wp_get_attachment_url(get_option('options_default_cover_background_image')); ?>') top center no-repeat; background-size:cover;">

	<div class="cover-content-wrap">
		<div class="wrapper narrow">
			<div class="cover-wrap">
				<h1 class="cover-title"><?php echo get_option('options_404_cover_title'); ?></h1>
				<div class="cover-text"><?php echo wpautop(get_option('options_404_cover_text')); ?></div>
			</div>
		</div>
	</div>

</section>

<?php get_footer(); ?>