<?php 
	$data = $block['data']; 
	$style = isset($data['background_image']) ? 'background:url('.wp_get_attachment_url($data['background_image']).') top center no-repeat; background-size:cover;' : '';
?>
<section 
    <?php if (isset($data['section_id']) && $data['section_id']){ echo 'id="'.$data['section_id'].'"';} ?>
    class="news-block <?php echo isset($block['className']) ? $block['className'] : ''; ?>" 
    style="<?php echo $style; ?>"
>
	<div class="wrapper">

		<?php if(isset($data['title']) && !empty($data['title'])) : ?>
			<h3 class="section-title"><?php echo $data['title']; ?></h3>
		<?php endif; ?>

		<?php 
			$args = array(
				'post_type' => 'post',
				'posts_per_page' => 3,
				'post_status' => 'publish'
			);

			if($data['category']){
				$args['category__in'] = $data['category'];
			}

 			$news = new WP_Query($args);
		?>
		<?php if($news->found_posts) : ?>
			<div class="news-grid">
				<?php foreach($news->posts as $item) : ?> 
					<a class="news-item" href="<?php echo get_the_permalink($item->ID); ?>">
						<img src="<?php echo get_the_post_thumbnail_url($item->ID); ?>" alt="">
					</a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<a href="<?php echo home_url(); ?>/news" class="bc-button">Read More News</a>
	</div>
</section>