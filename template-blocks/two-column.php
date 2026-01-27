<?php $data = $block['data']; ?>

<section 
    <?php if (isset($data['section_id']) && $data['section_id']){ echo 'id="'.$data['section_id'].'"';} ?>
    class="two-column-block <?php echo isset($block['className']) ? $block['className'] : ''; ?>"
>
	<div class="wrapper">
		<?php $layout_arr = explode('-', $data['layout']); ?>
		<div class="content-wrap user-content">
			<div class="left">
				<?php if($layout_arr[0] == 'wysiwyg') : ?>
					<?php echo wpautop($data['left_wysiwyg']); ?>
				<?php elseif($layout_arr[0] == 'image') : ?>
					<img src="<?php echo wp_get_attachment_url($data['left_image']); ?>" alt="">
				<?php elseif($layout_arr[0] == 'video') : ?>
					<div class="embed-container">
						<iframe src="<?php echo get_youtube_embed_url($data['left_video']); ?>"></iframe>
					</div>	
				<?php endif; ?>
			</div>
			<div class="right">
				<?php if($layout_arr[1] == 'wysiwyg') : ?>
					<?php echo wpautop($data['right_wysiwyg']); ?>
				<?php elseif($layout_arr[1] == 'image') : ?>
					<img src="<?php echo wp_get_attachment_url($data['right_image']); ?>" alt="">
				<?php elseif($layout_arr[1] == 'video') : ?>
					<div class="embed-container">
						<iframe src="<?php echo get_youtube_embed_url($data['right_video']); ?>"></iframe>
					</div>	
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>