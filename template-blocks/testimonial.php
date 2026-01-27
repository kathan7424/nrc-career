<?php $data = $block['data']; ?>

<section 
    <?php if (isset($data['section_id']) && $data['section_id']){ echo 'id="'.$data['section_id'].'"';} ?>
    class="testimonial-block <?php echo isset($block['className']) ? $block['className'] : ''; ?>"
>
	<div class="wrapper narrow">
		<h3 class="testimonial"><em>"<?php echo $data['testimonial']; ?>"</em></h3>
		<h4 class="cite">- <?php echo $data['cite']; ?></h4>
	</div>
</section>