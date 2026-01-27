<?php
	// save out block data
	global $post, $wpdb, $wp;
	$data = $block['data'];
?>
<section
    <?php if (isset($data['section_id']) && $data['section_id']){ echo 'id="'.$data['section_id'].'"';} ?>
    class="associate-grid-block <?php echo isset($block['className']) ? $block['className'] : ''; ?>"
>
	
	<?php
		$first_count_number = isset($data['first_count_number']) ? $data['first_count_number'] : '';
		$first_count_label = isset($data['first_count_label']) ? $data['first_count_label'] : '';
		$second_count_number = isset($data['second_count_number']) ? $data['second_count_number'] : '';
		$second_count_label = isset($data['second_count_label']) ? $data['second_count_label'] : '';
		$total_count_number = isset($data['total_count_number']) ? $data['total_count_number'] : '';
		$total_count_label = isset($data['total_count_label']) ? $data['total_count_label'] : '';
	?>
	<?php if($first_count_number && $first_count_label && $second_count_number && $second_count_label && $total_count_number && $total_count_label) : ?>
		<div class="wrapper narrow">
			<div class="associate-counters-wrap">
				<div class="count-item first-wrap">
					<span class="count" data-total="<?php echo $data['first_count_number']; ?>">0</span>
					<span class="title"><?php echo $data['first_count_label']; ?></span>
				</div>				
				<div class="spacer">+</div>
				<div class="count-item second-wrap">
					<span class="count" data-total="<?php echo $data['second_count_number']; ?>">0</span>
					<span class="title"><?php echo $data['second_count_label']; ?></span>
				</div>	
				<div class="spacer">=</div>	
				<div class="count-item total-wrap">
					<span class="count" data-total="<?php echo $data['total_count_number']; ?>">0</span>
					<span class="title"><?php echo $data['total_count_label']; ?></span>
				</div>
			</div>

			<script>
				jQuery(document).ready(function($){

					let first_count = $('.first-wrap .count').data('total');
					for(let j = 0; j <= first_count; j++){
						setTimeout(function(){
							$('.first-wrap .count').text(j); 
						}, <?php echo $data['first_count_speed']; ?> * j);
					}				

					let second_count = $('.second-wrap .count').data('total');
					for(let k = 0; k <= second_count; k++){
						setTimeout(function(){
							$('.second-wrap .count').text(k); 
						}, <?php echo $data['second_count_speed']; ?> * k);
					}

					let total_count = $('.total-wrap .count').data('total');
					for(let i = 0; i <= total_count; i++){
						setTimeout(function(){
							$('.total-wrap .count').text(i); 
						}, <?php echo $data['total_count_speed']; ?> * i);
					}						
				});
			</script>
		</div>
	<?php endif; ?>

	<?php if(isset($data['grid_type']) && $data['grid_type'] == 'custom') : ?>
		<div class="wrapper">

			<?php $associates = $data['associates']; ?>
			<?php if($associates) : ?>
				<ul class="custom-associate-grid">
				<?php foreach($associates as $associate_id) : ?>
					<li class="associate">
						<?php $image = has_post_thumbnail($associate_id) ? get_the_post_thumbnail_url($associate_id) : get_post_meta($associate_id, 'photo_url', true); ?>
							<div class="image-wrap">
								<img src="<?php echo $image; ?>" alt="">
							</div>
							<h4 class="associate-name"><?php echo get_the_title($associate_id); ?></h4>
						
							<?php
								$job_title = get_post_meta($associate_id, 'job_title', true);
								$mobile = get_post_meta($associate_id, 'mobile', true);
								$email = get_post_meta($associate_id, 'email', true);
							?>
							<?php if($job_title || $phone || $email) : ?>
							<ul class="associate-info">
								<?php if($job_title) : ?>
									<li><?php echo $job_title; ?></li>
								<?php endif; ?>
								<?php if($mobile) : ?>
									<li><a target="_blank" href="tel:<?php echo $mobile; ?>"><?php echo $mobile; ?></a></li>
								<?php endif; ?>
								<?php if($email) : ?>
									<li><a target="_blank" href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></li>
								<?php endif; ?>
							</ul>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>

	<?php else : ?>

		<div class="wrapper">
			<div class="associate-filter">
				<div class="location-wrap">
					<form method="GET" action="<?php echo home_url($wp->request); ?>">
						<button value="">ALL</button>
					</form>
					<?php $associate_name = isset($_GET['associate_name']) ? sanitize_text_field($_GET['associate_name']) : ''; ?>
					<?php $locations = get_terms('location'); ?>
					<?php if($locations) : ?>
						<?php foreach($locations as $location) : ?>
							<form method="GET" action="<?php echo home_url($wp->request); ?>">
								<button name="location" value="<?php echo $location->term_id; ?>"><?php echo $location->name; ?></button>
							</form>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
				<form class="search" method="GET" action="<?php echo home_url($wp->request); ?>">
					<input type="text" name="associate_name" value="<?php echo $associate_name; ?>" placeholder="SEARCH AGENT BY NAME">
					<button><i class="far fa-search"></i></button>
				</form>
			</div>
		</div>

		<div class="wrapper">

			<?php
				// get associates with images
				$sql = "
					SELECT p.ID, p.post_title
					FROM {$wpdb->prefix}posts p
					LEFT JOIN {$wpdb->prefix}postmeta m1 ON (m1.post_id = p.ID AND m1.meta_key = 'photo_url')
					LEFT JOIN {$wpdb->prefix}postmeta m2 ON (m2.post_id = p.ID AND m2.meta_key = '_thumbnail_id')
	   				INNER JOIN {$wpdb->prefix}term_relationships tr ON (p.ID = tr.object_id) 
			        INNER JOIN {$wpdb->prefix}term_taxonomy tt ON (tr.term_taxonomy_id = tt.term_taxonomy_id)
			        INNER JOIN {$wpdb->prefix}terms t ON (tt.term_id = t.term_id)
					WHERE p.post_type = 'associate'
					AND p.post_status = 'publish'
					AND (m1.meta_value <> '' OR m2.meta_value <> '')
				";

				if(isset($_GET['location'])){
					$sql .= " AND t.term_id = '".sanitize_text_field($_GET['location'])."'";
				}

				if($associate_name){
					$sql .= " AND p.post_title LIKE '%{$associate_name}%'";
				}

				$sql .= " GROUP BY p.ID ORDER BY RAND()";

				$results = $wpdb->get_results($sql);
			?>
			<?php if($results) : ?>
				<ul class="associate-grid">
				<?php foreach($results as $associate) : ?>
					<li class="associate">
						<a href="<?php echo get_the_permalink($associate->ID); ?>">
							<?php $image = has_post_thumbnail($associate->ID) ? get_the_post_thumbnail_url($associate->ID) : get_post_meta($associate->ID, 'photo_url', true); ?>
							<div class="image-wrap" style="background:url('<?php echo $image; ?>') center no-repeat; background-size:cover;"></div>
							<h4 class="associate-name"><?php echo $associate->post_title; ?></h4>
						</a>
					</li>
				<?php endforeach; ?>
				</ul>
			<?php endif; ?>		

			<?php
				// get associates without images
				$sql = "
					SELECT p.ID, p.post_title
					FROM {$wpdb->prefix}posts p
					LEFT JOIN {$wpdb->prefix}postmeta m1 ON (m1.post_id = p.ID AND m1.meta_key = 'photo_url')
					LEFT JOIN {$wpdb->prefix}postmeta m2 ON (m2.post_id = p.ID AND m2.meta_key = '_thumbnail_id')
	   				INNER JOIN {$wpdb->prefix}term_relationships tr ON (p.ID = tr.object_id)
			        INNER JOIN {$wpdb->prefix}term_taxonomy tt ON (tr.term_taxonomy_id = tt.term_taxonomy_id)
			        INNER JOIN {$wpdb->prefix}terms t ON (tt.term_id = t.term_id)
					WHERE p.post_type = 'associate'
					AND p.post_status = 'publish'
					AND (m1.meta_value = '' OR m1.meta_value IS NULL)
					AND (m2.meta_value = '' OR m2.meta_value IS NULL)
				";

				if(isset($_GET['location'])){
					$sql .= " AND t.term_id = '".sanitize_text_field($_GET['location'])."'";
				}

				if($associate_name){
					$sql .= " AND p.post_title LIKE '%{$associate_name}%'";
				}

				$sql .= " GROUP BY p.ID ORDER BY RAND()";

				$results = $wpdb->get_results($sql);
			?>
			<?php if($results) : ?>
				<ul class="associate-grid">
				<?php foreach($results as $associate) : ?>
					<li class="associate">
						<a href="<?php echo get_the_permalink($associate->ID); ?>">
							<h4 class="associate-name"><?php echo $associate->post_title; ?></h4>
						</a>
					</li>
				<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>

	<?php endif; ?>
</section>
