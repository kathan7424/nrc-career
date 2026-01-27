<ul class="social">
	<?php if($facebook = get_option('options_facebook_url')) : ?>	
		<li><a target="_blank" href="<?php echo $facebook; ?>"><i class="fab fa-facebook"></i></a></li>
	<?php endif; ?>
	<?php if($instagram = get_option('options_instagram_url')) : ?>
		<li><a target="_blank" href="<?php echo $instagram; ?>"><i class="fab fa-instagram"></i></a></li>
	<?php endif; ?>
	<?php if($youtube = get_option('options_youtube_url')) : ?>	
		<li><a target="_blank" href="<?php echo $youtube; ?>"><i class="fab fa-youtube"></i></a></li>
	<?php endif; ?>
	<?php if($twitter = get_option('options_twitter_url')) : ?>	
		<li><a target="_blank" href="<?php echo $twitter; ?>"><i class="fab fa-twitter"></i></a></li>
	<?php endif; ?>
	<?php if($linkedin = get_option('options_linkedin_url')) : ?>
		<li><a target="_blank" href="<?php echo $linkedin; ?>"><i class="fab fa-linkedin"></i></a></li>
	<?php endif; ?>
	<?php if($pinterest = get_option('options_pinterest_url')) : ?>	
		<li><a target="_blank" href="<?php echo $youtube; ?>"><i class="fab fa-pinterest"></i></a></li>
	<?php endif; ?>
</ul>