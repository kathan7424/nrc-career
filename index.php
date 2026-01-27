<?php get_header(); ?>
	
	<section class="post-grid-wrap">
		<div class="wrapper overflow">
			<div class="post-grid">

				<?php global $wp_query; ?>
				<?php if(have_posts()) : ?>
					<?php while(have_posts()) : the_post(); ?>

						<div class="post-item">
							<div class="image-wrap" style="background:url('<?php echo get_the_post_thumbnail_url($post->ID); ?>') top center no-repeat; background-size:cover;">
								<a href="<?php the_permalink(); ?>"></a>
							</div>
							<div class="post-content-wrap">
								<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
								<p class="post-excerpt"><?php echo custom_excerpt($post->post_content, 40); ?>... <a href="<?php the_permalink(); ?>"><em>Read More</em></a></p>
							</div>
						</div>

					<?php endwhile; ?>
				<?php endif; ?>

			</div>

			<?php $ppp = get_option('posts_per_page'); ?>
			<?php if($wp_query->found_posts >= $ppp) : ?>
				<div class="button-wrap">
					<button id="load-more" class="bc-button" data-total="<?php echo $wp_query->found_posts; ?>" data-ppp="<?php echo $ppp; ?>" data-count="<?php echo $ppp; ?>"><span class="text">Load More</span><span class="loading" style="display:none;"><i class="far fa-spinner fa-pulse"></i></span></button>
				</div>

				<script>
					jQuery(document).ready(function($){
						$('#load-more').on('click', function(){
							$('.button-wrap .loading').show();
							$('.button-wrap .text').hide();
							let data = {
								action : 'nrc_more_news',
								count : $('#load-more').attr('data-count'),
								ppp : $('#load-more').attr('data-ppp'),
								request : <?php echo json_encode($wp_query->request); ?>
							}
							$.post("<?php echo admin_url('admin-ajax.php'); ?>", data, function(response){
								$('.post-grid').append(response);
								let total = $('#load-more').data('total');
								let count = $('.post-item').length;
								$('#load-more').attr('data-count', count);
								if(count >= total){
									$('.button-wrap').hide();
								}else{
									$('.button-wrap .loading').hide();
									$('.button-wrap .text').show();
								}
							});
						});
					});
				</script>
			<?php endif; ?>

		</div>
	</section>

<?php get_footer(); ?>