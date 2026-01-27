<!doctype html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>
		<link href="//www.google-analytics.com" rel="dns-prefetch">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width,initial-scale=1.0,viewport-fit=cover">
		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>
		<div id="site-wrap">
			<a class="hidden" href="#main">Skip to content</a>
			<div id="top-link">
				<i class="fal fa-chevron-up"></i>
			</div>

			<script type="text/javascript">
				jQuery(document).ready(function($){
					// scroll to top 
					$(window).scroll(function(){
						if($(this).scrollTop() != 0){
							$('#top-link').stop().fadeTo('fast', 1)
						}else{
							$('#top-link').stop().fadeTo('fast', 0);
						}
					}).scroll();
					$('#top-link').click(function() {
						$('body,html').animate({scrollTop:0},'slow',"easeInOutQuart");
					});	
				});
			</script>

			<header id="header" role="banner">			
				<div class="wrapper">
					<div class="header-wrap">
						<div class="logo-wrap">
							<?php if(is_front_page()) : ?>
								<img src="<?php echo bloginfo('template_directory') . '/images/logo.png'; ?>" />
							<?php else : ?>
								<a href="<?php echo home_url(); ?>">
									<img src="<?php echo bloginfo('template_directory') . '/images/logo.png'; ?>" />
								</a>
							<?php endif; ?>
						</div>
						<div class="main-nav-wrap">
							<nav class="main-nav" role="navigation">
								<ul>
									<?php wp_nav_menu(array('menu' => '3', 'items_wrap' => '%3$s', 'container'=> false)); ?>
								</ul>
							</nav>
							<!-- <a id="shiftnav-toggle-main" class="shiftnav-toggle shiftnav-toggle-mobile" data-shiftnav-target="shiftnav-main"> <i class="far fa-bars"></i> </a> -->
						</div>

						<script>
							jQuery(document).ready(function($){

								// let touch devices open subnav first and then click again to follow link
								$('.touch .main-nav > ul > .menu-item-has-children > a').on('click', function(e){
									if(!$(this).parent('li').hasClass('hover')){
										$('.touch .main-nav > ul > li').removeClass('hover');
							    		e.preventDefault();
									}
							    	$(this).parent('li').toggleClass('hover');
								});

								// close when clicked on body and not nav
								$(document).on('click', function(e){
									if($(e.target).closest('.main-nav').length === 0){
										$('.touch .main-nav > ul > .hover').removeClass('hover');
									}
								});
							});
						</script>		
					</div>
				</div>
			</header>

			<main id="main" role="main">