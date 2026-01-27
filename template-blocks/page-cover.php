<?php
	// save out block data
	global $post;
	$data = $block['data'];
?>
<section 
    <?php if (isset($data['section_id']) && $data['section_id']){ echo 'id="'.$data['section_id'].'"';} ?>
    class="page-cover-block <?php echo isset($data['cover_height']) ? $data['cover_height'] : 'default'; ?> <?php echo isset($block['className']) ? $block['className'] : ''; ?>"
>
	<div class="cover-content-wrap">
		<div class="wrapper">
			<div class="cover-wrap">
                <?php $post_title = isset($data['title']) && $data['title'] ? $data['title'] : $post->post_title; ?>
				<h1 class="cover-title"><?php echo $post_title; ?></h1>
				
				<?php if(isset($data['idx_shortcode']) && !empty($data['idx_shortcode'])) : ?>
					<div class="cover-search">
						<?php echo apply_filters('the_content', $data['idx_shortcode']); ?>
					</div>
				<?php endif; ?>

				<?php if(isset($data['subtitle']) && $data['subtitle']) : ?>
					<h2 class="cover-subtitle"><?php echo $data['subtitle']; ?></h2>
				<?php endif; ?>	

                <?php if (isset($data['video_embed']) && $data['video_embed']) : ?>
                    <div class="embedContainer">
                        <?php echo $data['video_embed']; ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($data['splash_image']) && $data['splash_image']) : ?>
                    <div class="splashImage">
                        <img src="<?php echo wp_get_attachment_url($data['splash_image']); ?>" alt="<?php echo $post_title; ?>" />
                    </div>
                <?php endif; ?>
			</div>
		</div>
	</div>

</section>