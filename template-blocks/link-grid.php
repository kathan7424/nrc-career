<?php
	// save out block data
	global $post;
	$data = $block['data'];
?>
<section 
    <?php if (isset($data['section_id']) && $data['section_id']){ echo 'id="'.$data['section_id'].'"';} ?>
    class="link-grid-block <?php echo isset($block['className']) ? $block['className'] : ''; ?>"
>
	<div class="wrapper">

		<?php if(isset($data['title']) && $data['title']) : ?>
			<h3 class="section-title"><?php echo $data['title']; ?></h3>
		<?php endif; ?>

			<?php if(isset($data['grid']) && !empty($data['grid'])) : ?>
				<div class="link-grid">
				<?php for($i = 0; $i < $data['grid']; $i++) : ?>
					<a class="grid-item" href="<?php echo $data["grid_{$i}_link_url"]; ?>">
						<img src="<?php echo wp_get_attachment_url($data["grid_{$i}_image"]); ?>" alt="">	
					</a>
				<?php endfor; ?>
				</div>
			<?php endif; ?>

		<?php if(isset($data['subtitle']) && $data['subtitle']) : ?>
			<h4 class="section-subtitle"><?php echo $data['subtitle']; ?></h4>
		<?php endif; ?>	
	
	</div>


</section>