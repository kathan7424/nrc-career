<?php $data = $block['data']; ?>
<?php $max_columns = isset($data['max_columns']) ? 'col-' . $data['max_columns'] : 'col-3'; ?>

<section 
    <?php if (isset($data['section_id']) && $data['section_id']){ echo 'id="'.$data['section_id'].'"';} ?>
    class="location-grid-block <?php echo isset($block['className']) ? $block['className'] : ''; ?>"
>
	<div class="wrapper">

		<?php $locations = get_terms('location'); ?>
		<?php if($locations) : ?>
			<ul class="location-grid">
			<?php foreach($locations as $location) : ?>
				<li class="location <?php echo $max_columns; ?>">
					<h4 class="location-name"><?php echo $location->name; ?></h4>
					<?php 
						$address_line_1 = get_term_meta($location->term_id, 'address_line_1', true); 
						$address_line_2 = get_term_meta($location->term_id, 'address_line_2', true); 
					?>
					<div class="map-wrap">
						<iframe width="600" height="450" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyACCi6tSzstQNJ0-FXZQSCQxTa4NduyWsk&q=<?php echo $address_line_1 . '+' . $address_line_2; ?>" allowfullscreen></iframe>
					</div>

					<div class="location-info">
						<address><?php echo $address_line_1; ?><br><?php echo $address_line_2; ?></address>
						<ul class="phone">
							<?php if($front_desk = get_term_meta($location->term_id, 'front_desk_phone', true)) : ?>
								<li><strong>Front Desk:</strong> <a href="tel:<?php echo $front_desk; ?>"><?php echo $front_desk; ?></a></li>
							<?php endif; ?>
							<?php if($main_office = get_term_meta($location->term_id, 'main_office_phone', true)) : ?>
								<li><strong>Main Office:</strong> <a href="tel:<?php echo $main_office; ?>"><?php echo $main_office; ?></a></li>
							<?php endif; ?>
						</ul>

						<?php if($email = get_term_meta($location->term_id, 'email', true)) : ?>
							<ul class="email">
								<li><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></li>
							</ul>
						<?php endif; ?>

					</div>
				</li>
			<?php endforeach; ?>
			</ul>
		<?php endif; ?>

	</div>
</section>