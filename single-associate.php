<?php get_header(); ?>

	<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
	<section class="associate-wrap">
		<div class="wrapper skinny">
			<div class="associate-info">
				<?php 
					$image = has_post_thumbnail() ? get_the_post_thumbnail_url() : get_post_meta($post->ID, 'photo_url', true);
					if(!$image){
						$image = get_bloginfo('template_directory') . '/images/headshot.png';
					}
				?>
				<div class="image-wrap" style="background:url('<?php echo $image; ?>') center no-repeat; background-size:cover;"></div>
				<div class="info-wrap">
					<div class="title-wrap">
						<h1 class="associate-name"><?php the_title(); ?></h1>
						<h2 class="associate-title"><?php echo gpm('job_title'); ?></h2>
					</div>
					<?php 
                        // primary
						$mobile = gpm('mobile');
						$email = gpm('email');
						$website = gpm('website');
					?>
					<?php if($mobile || $email || $website) : ?>
                        <ul class="info-list">
                            <?php if($mobile) : ?>
                                <li><i class="fas fa-phone"></i> <a target="_blank" href="tel:<?php echo $mobile; ?>"><?php echo $mobile; ?></a></li>						
                            <?php endif; ?>
                            <?php if($email) : ?>
                                <li><i class="fas fa-envelope"></i> <a target="_blank" href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></li>						
                            <?php endif; ?>					
                            <?php if($website) : ?>
                                <li><i class="fas fa-globe-americas"></i> <a target="_blank" href="//<?php echo preg_replace('/(http(s)?:\/\/)/', '', $website); ?>"><?php echo preg_replace('/(http(s)?:\/\/)/', '', $website); ?></a></li>						
                            <?php endif; ?>
                        </ul>
					<?php endif; ?>

                    <?php 
                        // social
                        $facebook = gpm('facebook');
                        $twitter = gpm('twitter');
                        $instagram = gpm('instagram');
                        $linkedin = gpm('linkedin');
                        $pinterest = gpm('pinterest');
                        $youtube = gpm('youtube');
						$google = gpm('google');
						$realtor = gpm('realtor');
                        $zillow = gpm('zillow');
						$tiktok = gpm('tiktok');
                    ?>
                    <?php if ($facebook || $twitter || $instagram || $linkedin || $linkedin || $youtube || $google || $realtor || $zillow || $tiktok) : ?>
                        <ul class="social">
                            <?php if($facebook) : ?>	
                                <li><a target="_blank" href="<?php echo $facebook; ?>"><i class="fab fa-facebook"></i></a></li>
                            <?php endif; ?>
                            <?php if($instagram) : ?>
                                <li><a target="_blank" href="<?php echo $instagram; ?>"><i class="fab fa-instagram"></i></a></li>
                            <?php endif; ?>
                            <?php if($youtube) : ?>	
                                <li><a target="_blank" href="<?php echo $youtube; ?>"><i class="fab fa-youtube"></i></a></li>
                            <?php endif; ?>
                            <?php if($twitter) : ?>	
                                <li><a target="_blank" href="<?php echo $twitter; ?>"><i class="fab fa-twitter"></i></a></li>
                            <?php endif; ?>
                            <?php if($linkedin) : ?>
                                <li><a target="_blank" href="<?php echo $linkedin; ?>"><i class="fab fa-linkedin"></i></a></li>
                            <?php endif; ?>
                            <?php if($pinterest) : ?>	
                                <li><a target="_blank" href="<?php echo $pinterest; ?>"><i class="fab fa-pinterest"></i></a></li>
                            <?php endif; ?>
							<?php if($google) : ?>
                                <li><a target="_blank" href="<?php echo $google; ?>"><i class="fab fa-google"></i></a></li>
                            <?php endif; ?>
							<?php if($realtor) : ?>	
                                <li><a target="_blank" href="<?php echo $realtor; ?>"><i class="realtoricon"></i></a></li>
                            <?php endif; ?>
							<?php if($zillow) : ?>	
                                <li><a target="_blank" href="<?php echo $zillow; ?>"><i class="zillowicon"></i></a></li>
                            <?php endif; ?>
							<?php if($tiktok) : ?>
                                <li><a target="_blank" href="<?php echo $tiktok; ?>"><i class="tiktokicon"></i></a></li>
                            <?php endif; ?>
                        </ul>
                    <?php endif; ?>
				</div>
			</div>
			
			<div class="content-wrap">
				<?php the_content(); ?>
			</div>
        </div>

        <?php if($num_awards = gpm('awards')) : ?>
            <?php $award_columns = gpm('award_columns') ? gpm('award_columns') : 4; ?>
            <div class="wrapper narrow">
                <h4 class="awards-title">Awards</h4>
				<ul class="awards">
					<?php for($i = 0; $i < $num_awards; $i++) : ?>
						<li class="award col-<?php echo $award_columns; ?>">
                            <div class="award-wrap">
                                <img src="<?php echo wp_get_attachment_url(gpm("awards_{$i}_image")); ?>" />
                            </div>
						</li>
					<?php endfor; ?>
				</ul>
            </div>
		<?php endif; ?>
	
        <div class="wrapper skinny">
			<?php if($num_facts = gpm('fun_facts')) : ?>
				<ul class="fun-facts">
					<?php for($i = 0; $i < $num_facts; $i++) : ?>
						<li>
							<h4><?php echo gpm("fun_facts_{$i}_title"); ?></h4>
							<p><?php echo gpm("fun_facts_{$i}_text"); ?></p>
						</li>
					<?php endfor; ?>
				</ul>
			<?php endif; ?>

			<?php 
				// maybe get reviews
				$sql = "
					SELECT p.ID, p.post_title, p.post_content
					FROM {$wpdb->prefix}posts p
					LEFT JOIN {$wpdb->prefix}postmeta m1 ON (m1.post_id = p.ID AND m1.meta_key = 'associate')
					WHERE m1.meta_value = '{$post->post_title}'
					AND p.post_type = 'review'
                    ORDER BY RAND()
				";
				$reviews = $wpdb->get_results($sql);
				$total_reviews = count($reviews);
				$num_reviews = 5;
			?>
			<?php if($reviews) : ?>
				<div class="reviews-block">
					
					<?php foreach($reviews as $k => $review) : ?>
						<div class="review-wrap">
							<span class="before">&ldquo;</span>

							<div class="review">
								<h3 class="title"><?php echo $review->post_title; ?></h3>
								<h4 class="subtitle">Worked with <?php echo get_post_meta($review->ID, 'associate', true); ?></h4>
								
								<?php
									// insert the read more
									$review_content = $review->post_content;
									$content_arr = explode(' ', $review_content);
									$content_arr_count = count($content_arr);

									if($content_arr_count > 50){
										$first = array_slice($content_arr, 0, 50);
										$first[] = '<span class="more" style="display:none;">';
										$last = array_slice($content_arr, 51, ($content_arr_count - 50));
										$last[] = '</span><span class="read-more">... Read More</span>';
										$review_content = implode(' ', array_merge($first, $last));
									}
								?>

								<div class="review-content"><?php echo $review_content; ?></div>
								<div class="ratings">
									<?php 
										$rating_categories = array(
											'satisfaction_rating' => 'Satisfaction', 
											'performance_rating' => 'Performance', 
											'recommendation_rating' => 'Recommendation'
										);
									?>
									<?php foreach($rating_categories as $meta_key => $label) : ?>
										<div class="rating">
											<h5 class="rating-label"><?php echo $label; ?></h5>
											<div class="stars">
												<?php 
													$rating = get_post_meta($review->ID, $meta_key, true);
													$full_stars = floor($rating / 20);
													$total = 0;
													for($i = 0; $i < $full_stars; $i++){
														$total++;
														?><i class="fas fa-star"></i><?php
													}

													if($rating % 20){
														$total++;
														?><i class="fas fa-star-half-alt"></i><?php
													}

													$half_stars = 5 - $total;
													if($half_stars){
														for($i = 0; $i < $half_stars; $i++){
															?><i class="fal fa-star"></i><?php
														}
													}
												?>
											</div>
										</div>
									<?php endforeach; ?>
								</div>
							</div>
							
							<span class="after">&rdquo;</span>
						</div>


						<?php if(((($k + 1) % $num_reviews === 0) && $k + 1 !== $num_reviews) || ($k + 1) == $total_reviews) : ?>
							</div>
						<?php endif; ?>

						<?php if((($k + 1) % $num_reviews === 0) && ($k + 1) != $total_reviews) : ?>
							<div class="more-reviews hidden" style="display:none;">
						<?php endif; ?>

					<?php endforeach; ?>
					
					<?php if($total_reviews > $num_reviews) : ?>
						<span class="bc-button read-more-reviews">Read More Reviews</span>
					<?php endif; ?>

				
					<script>
						jQuery(document).ready(function($){

							// show more of the review content
							$('.read-more').on('click', function(){
								$(this).hide().closest('.review-content').find('.more').fadeIn();
							});	

							// reveal more reviews
							$('.read-more-reviews').on('click', function(){
								$('.more-reviews.hidden:first').removeClass('hidden').fadeIn();

								// hide button when all are revealed
								if($('.more-reviews.hidden').length === 0){
									$(this).hide();
								}
							});
						});
					</script>

				</div>
			<?php endif; ?>

			<div class="contact-form">
				<?php echo gravity_form(2, true); ?>
			</div>

		</div>
	</section>
	<?php endwhile; endif; ?>

<?php get_footer(); ?>