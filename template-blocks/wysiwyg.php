<?php 
	$data = $block['data']; 
	$style = isset($data['background_image']) ? 'background:url('.wp_get_attachment_url($data['background_image']).') top center no-repeat; background-size:cover;' : '';
?>
<section 
    <?php if (isset($data['section_id']) && $data['section_id']){ echo 'id="'.$data['section_id'].'"';} ?>
    class="wysiwyg-block <?php echo isset($block['className']) ? $block['className'] : ''; ?>" 
    style="<?php echo $style; ?>"
>
	<div class="wrapper narrow">

		<?php if(isset($data['title']) && !empty($data['title'])) : ?>
			<div class="section-title-wrap">
				<h3 class="section-title"><?php echo $data['title']; ?></h3>
				<?php if(isset($data['cta_position']) && $data['cta_position'] == 'after_title') : ?>
					<?php if(isset($data['cta_link_url']) && $data['cta_link_url'] && isset($data['cta_link_text']) && $data['cta_link_text']) : ?>
						<a href="<?php echo $data['cta_link_url']; ?>" class="bc-button"><?php echo $data['cta_link_text']; ?></a>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		<?php endif; ?>
		
		<?php echo wpautop($data['wysiwyg']); ?>
		<?php if(isset($data['cta_position']) && $data['cta_position'] == 'after_content') : ?>
			<?php if(isset($data['cta_link_url']) && $data['cta_link_url'] && isset($data['cta_link_text']) && $data['cta_link_text']) : ?>
				<div class="cta-wrap">
					<a href="<?php echo $data['cta_link_url']; ?>" class="bc-button"><?php echo $data['cta_link_text']; ?></a>
				</div>
			<?php endif; ?>
		<?php endif; ?>
	</div>
</section>