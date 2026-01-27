			</main> <?php // end main ?>

			<footer id="footer" role="contentinfo">
				<div class="wrapper narrow">
					<div class="footer-wrap">
						<div class="left">
							<a href="<?php echo home_url(); ?>">
								<img class="footer-logo" src="<?php echo bloginfo('template_directory') . '/images/logo.png'; ?>" />
							</a>
							<p><?php echo get_option('options_left_footer_text'); ?></p>
							<p>Copyright <?php echo date('Y'); ?> National Realty Centers</p>
							<p><a href="<?php echo home_url(); ?>/privacy-policy">Privacy Policy</a></p>
						</div>

						<div class="right">
							<?php template_part('social-list'); ?>
							<p><?php echo get_option('options_right_footer_text'); ?></p>
						</div>
					</div>
				</div>
			</footer>
				
		</div> <?php // end site wrap ?>

		<?php wp_footer(); ?>
	</body>
</html>