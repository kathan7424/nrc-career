<?php

	// generic includes
	require_once 'inc/generic-functions.php';

	// theme specific includes
	require_once 'inc/whitelabeling.php';

	// theme init actions
	function setup_theme(){

		// update default wordpress options
		update_option('image_default_link_type','none');

		// custom image size
		add_image_size('medium-thumb', 300, 300, true);

		// add theme support
		if(function_exists('add_theme_support')){
			add_theme_support('menus');
			add_theme_support('post-thumbnails');
			add_theme_support('automatic-feed-links');
			add_theme_support('woocommerce');
			add_theme_support('align-wide');
			add_theme_support('align-full');
			add_theme_support('editor-styles');
		}

		// add ACF options
		if(function_exists('acf_add_options_page')){
			acf_add_options_page();
			acf_add_options_sub_page('Site Options');
		}

		// jetpack gallery width
		global $content_width;
		if(!isset($content_width)){
    		$content_width = 9999;
		}
	}
	add_action('after_setup_theme', 'setup_theme');

	function bc_scripts(){
		wp_enqueue_script('jquery');
		wp_enqueue_script('modernizr', '//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js');
		// wp_enqueue_script('nav-position', get_template_directory_uri() . '/js/nav-position.js');
		// wp_enqueue_script('jquery-ui', '//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js', array('jquery'));
		// wp_enqueue_script('jquery-cookie', get_template_directory_uri() . '/js/jquery.cookie.js');
		// wp_enqueue_script('iframe-resizer', get_template_directory_uri() . '/js/iframeResizer.min.js');
		wp_enqueue_script('slick-slider', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js');
		wp_enqueue_script('fancybox', 'https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.js', array('jquery'));
		wp_enqueue_script('jquery-easing', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js', array('jquery'));
	}
	add_action('wp_enqueue_scripts', 'bc_scripts');
	add_action('admin_enqueue_scripts', 'bc_scripts');

	function bc_styles(){

		wp_enqueue_style('bc-fonts', get_template_directory_uri() . '/fonts/fonts.css');

		if(is_admin()){	
			// editor stylesheet on admin
			add_editor_style('editor-style.css');
			wp_enqueue_style('bc', get_template_directory_uri() . '/admin.css');
		}else{
			// add theme stylesheets
			wp_enqueue_style('bc', get_template_directory_uri() . '/style.css');
		}

		wp_enqueue_style('slick-slider', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css');
		wp_enqueue_style('fancybox', 'https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.css');
	}
	add_action('init', 'bc_styles');

	// add attributes to nav items
	add_filter('nav_menu_link_attributes', 'bc_menu_atts', 10, 3);
	function bc_menu_atts($atts, $item, $args){
		$atts['data-title'] = $item->title;
		return $atts;
	}

	// add message to menus page
	// add_action('admin_init', 'bc_nav_menu_notices');
	function bc_nav_menu_notices(){
        add_action('all_admin_notices', function(){	 
        	$screen = get_current_screen(); 
			if($screen->base == 'toplevel_page_gf_edit_forms'){
	            ?>
	           	<div class="notice notice-success dismiss">
			        <h3>Custom CSS Ready Classes</h3>
			        <ul>
			        	<li><code>full-width</code> - creates a full width element</li>
			        	<li><code>new-line</code> - forces this element on a new line</li>
			        </ul>
			    </div>
	            <?php
	        }
        });
	}

	// redirect to sold page if property doesnt exist
	function wpd_do_stuff_on_404(){
		if( is_404() ){
			$fourohfour = $_SERVER['REQUEST_URI'];
			if (strpos($fourohfour,'homes-for-sale-details') !== false) {
				$soldurl = str_replace('homes-for-sale-details', 'homes-for-sale-sold-details', $fourohfour);
				$site = get_home_url();
				$soldurl = $site.$soldurl;
				header( "HTTP/1.1 301 Moved Permanently" );
				header("Location: ".$soldurl);
				exit;
			}
		}
	 }
	 add_action( 'template_redirect', 'wpd_do_stuff_on_404' );



	// GRAVITY FORMS
	add_filter('gform_submit_button', 'form_submit_button', 10, 2);
	function form_submit_button($button, $form){
	    return "<button class='gform_button bc-button' id='gform_submit_button_{$form['id']}'>{$form['button']['text']}</button>";
	}

	add_filter('gform_field_value_associate_email', 'populate_associate_email');
	function populate_associate_email($value){
		global $post;
		$email = get_post_meta($post->ID, 'email', true);
		$value = $email ? $email : $value;
	    return $value;
	}	

	add_filter('gform_field_value_page_url', 'populate_page_url');
	function populate_page_url($value){
		global $post;
		$value = get_the_permalink($post->ID);
	    return $value;
	}

	/////////////////////////////////////
	////////// CUSTOM BLOCKS ////////////
	/////////////////////////////////////

	// set all the custom blocks and register
	$blocks = array(
		'page-cover' => 'Page Cover',
		'wysiwyg' => 'Wysiwyg',
		'link-grid' => 'Link Grid',
		'reviews' => 'Reviews',
		'news' => 'News',
		'associate-grid' => 'Associate Grid',
		'location-grid' => 'Location Grid',
		'testimonial' => 'Testimonial',
		'two-column' => 'Two Column',
		'spacer' => 'Spacer',
        'agent-case-studies' => "Agent Case Studies",
        'section-nav' => "Section Navigation",
        'agent-faqs' => "Agent FAQs",
        'agent-benefits' => "Agent Benefits",
        'agent-reviews' => "Agent Reviews",
        'property-listing' => "Property Listing",
        'infinite-slids' => "Infinite Slids",
        'multicol-faqs' => "Multicol FAQs",
        'commision' => "Commision"
	);

	add_filter('allowed_block_types', 'bc_allowed_block_types');
	function bc_allowed_block_types($allowed_block){
		global $blocks;
		$allowed = array();
		foreach($blocks as $k => $v){
			$allowed[] = 'acf/'.$k;
		}
		return $allowed;
	}

	function bc_plugin_block_categories( $categories, $post ) {
	    return array_merge(
	        $categories,
	        array(
	            array(
	                'slug' => 'custom',
	                'title' => 'Custom Blocks',
	                'icon'  => null,
	            ),
	        )
	    );
	}
	add_filter( 'block_categories', 'bc_plugin_block_categories', 10, 2 );

	function bc_acf_init() {
		
		// check function exists
		if(function_exists('acf_register_block')){
			global $blocks;
			foreach($blocks as $k => $v){
				acf_register_block(
					array(
						'name' => $k,
						'title' => $v,
						'description' => "A custom $v block.",
						'render_callback' => 'bc_acf_block_render_callback',
						'category' => 'custom',
						'icon' => 'layout',
						'keywords' => array($v),
					)
				);
			}
		}
	}
	add_action('acf/init', 'bc_acf_init');

	function bc_acf_block_render_callback( $block ) {

		// convert name ("acf/testimonial") into path friendly slug ("testimonial")
		$slug = str_replace('acf/', '', $block['name']);
		
		// include a template part from within the "template-parts/block" folder
		if( file_exists( get_theme_file_path("/template-blocks/{$slug}.php") ) ) {
			include( get_theme_file_path("/template-blocks/{$slug}.php") );
		}
	}

	// fix autop for gutenberg
	remove_filter('the_content', 'wpautop');
	add_filter('the_content', function ($content){
	    if(has_blocks()){
	        return $content;
	    }

	    return wpautop($content);
	});


	// disable gutenberg on post types
	add_filter('use_block_editor_for_post_type', 'gutenberg_post_type_blacklist', 99, 2);
	function gutenberg_post_type_blacklist($use_editor, $post_type){
		$allowed = array('page');
		if(!in_array($post_type, $allowed)) $use_editor = false;
		return $use_editor;
	}

    	// Hide dashboard update notifications for all users
	function bc_hide_update_nag() {
		remove_action( 'admin_notices', 'update_nag', 3 );
		}
		
		add_action('admin_menu','bc_hide_update_nag');

	/////////////////////////////////////////////


	//////////////// AJAX /////////////////
	add_action('wp_ajax_nrc_more_news', 'nrc_more_news');
	add_action('wp_ajax_nopriv_nrc_more_news', 'nrc_more_news');

	function nrc_more_news(){
		ob_start();
		global $wpdb;
		$ppp = $_POST['ppp'];
		$count = $_POST['count'];
		$request = $_POST['request'];
		$request_arr = explode('LIMIT', $request);
		$new_request = $request_arr[0] . 'LIMIT ' . $count . ', '. $ppp;
		$new_request = stripcslashes($new_request);
		$results = $wpdb->get_results($new_request);
		?>
		<?php if($results) : ?>
			<?php foreach($results as $result) : ?>
				<div class="post-item">
					<div class="image-wrap" style="background:url('<?php echo get_the_post_thumbnail_url($result->ID); ?>') top center no-repeat; background-size:cover;"></div>
					<div class="post-content-wrap">
						<h2 class="post-title"><a href="<?php echo get_the_permalink($result->ID); ?>"><?php echo get_the_title($result->ID); ?></a></h2>
						<p class="post-excerpt"><?php echo custom_excerpt(get_post_field('post_content', $result->ID), 40); ?>... <a href="<?php echo get_the_permalink($result->ID); ?>"><em>Read More</em></a></p>
					</div>
				</div>

			<?php endforeach; ?>
		<?php endif; ?>
		<?php
		echo ob_get_clean();
		die();
	}

    // "faq style" post type lists
    add_action('wp_ajax_nopriv_get_list_items', 'get_list_items');
    add_action('wp_ajax_get_list_items', 'get_list_items');
    function get_list_items() {

        $ppp = intval($_POST['ppp']);
        $page = intval($_POST['page']);
        $post_type = $_POST['post_type'];
        $taxonomy = isset($_POST['taxonomy']) ? $_POST['taxonomy'] : false;
        $term = isset($_POST['term']) ? $_POST['term'] : false;

        $more = true;

        $args = array(
            'post_type' => $post_type,
            'post_status' => 'published',
            'posts_per_page' => $ppp,
            'paged' => $page
        );


        // maybe categories
        if ($taxonomy && $term) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => $taxonomy,
                    'field' => 'term_id',
                    'terms' => $term
                )
            );
        }
        $results = new WP_Query($args);
        $nextPage = $page + 1;

		ob_start();
        ?>

        <?php if ($results->found_posts) : ?>
            <?php foreach($results->posts as $result) : ?>
                <li>
                    <h5 class="toggle"><?php echo $result->post_title; ?> <i class="far fa-angle-down"></i></h5>
                    <div class="toggleContent">
                        <div class="content">
                            <?php echo apply_filters('the_content', $result->post_content); ?>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>

		<?php
		$html = ob_get_clean();

        echo json_encode(array('html' => $html, 'maxNumPages' => $results->max_num_pages, 'nextPage' => $nextPage));
		die();
    }

    // agent review 
    add_action('wp_ajax_nopriv_get_agent_reviews', 'get_agent_reviews');
    add_action('wp_ajax_get_agent_reviews', 'get_agent_reviews');
    function get_agent_reviews() {

        $ppp = intval($_POST['ppp']);
        $page = intval($_POST['page']);
        $post_type = $_POST['post_type'];

        $more = true;

        $args = array(
            'post_type' => $post_type,
            'post_status' => 'published',
            'posts_per_page' => $ppp,
            'paged' => $page
        );
        $results = new WP_Query($args);
        $nextPage = $page + 1;

		ob_start();
        ?>

        <?php if ($results->found_posts) : ?>
            <?php foreach($results->posts as $result) : ?>

				<li class="reviewItem">
					<span class="before">&ldquo;</span>

					<div class="review">
						<h3 class="title"><?php echo $result->post_title; ?></h3>
						
						<?php
							// insert the read more
							// $review_content = $result->post_content;
							// $content_arr = explode(' ', $review_content);
							// $content_arr_count = count($content_arr);

							// if ($content_arr_count > 50){
							// 	$first = array_slice($content_arr, 0, 50);
							// 	$first[] = '<span class="more">';
							// 	$last = array_slice($content_arr, 51, ($content_arr_count - 50));
							// 	$last[] = '</span><span class="read-more">... Read More</span>';
							// 	$review_content = implode(' ', array_merge($first, $last));
							// }
						?>

						<div class="review-content"><?php echo apply_filters('the_content', $result->post_content); ?></div>
						<div class="ratings">
							<?php 
								$rating_categories = array(
									'support_rating' => 'Support', 
									'marketing_rating' => 'Marketing', 
									'education_rating' => 'Education'
								);
							?>
							<?php foreach($rating_categories as $meta_key => $label) : ?>
								<div class="rating">
									<h5 class="rating-label"><?php echo $label; ?></h5>
									<div class="stars">
										<?php 
											$rating = intVal(get_post_meta($result->ID, $meta_key, true));
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
				</li>

            <?php endforeach; ?>
        <?php endif; ?>

		<?php
		$html = ob_get_clean();

        echo json_encode(array('html' => $html, 'maxNumPages' => $results->max_num_pages, 'nextPage' => $nextPage));
		die();
    }

    // get reviews
    add_action('wp_ajax_nopriv_get_reviews', 'get_reviews');
    add_action('wp_ajax_get_reviews', 'get_reviews');
    function get_reviews() {
        ob_start();

        // get array of ints from post
        $exclude = $_POST['exclude'] ? array_map('intval', explode(',', $_POST['exclude'])) : '';
        $single = $_POST['single'];
        $ppp = $single ? 1 : $_POST['ppp'];

        // 5 star reviews only
        $args = array(
            'post_type' => 'review',
            'posts_per_page' => $ppp,
            'post_status' => 'publish',
            'orderby' => 'rand',
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => 'satisfaction_rating',
                    'value' => 90,
                    'compare' => '>=',
                    'type' => 'numeric'
                ),
                array(
                    'key' => 'performance_rating',
                    'value' => 90,
                    'compare' => '>=',
                    'type' => 'numeric'
                ),
                array(
                    'key' => 'recommendation_rating',
                    'value' => 90,
                    'compare' => '>=',
                    'type' => 'numeric'
                )
            )
        );

        // exclude if necessary
        if ($exclude) {
            $args['post__not_in'] = $exclude;
        }

        $reviews = new WP_Query($args);

        if ($reviews->found_posts) {
            $exclude = array();

            foreach ($reviews->posts as $review) {

                // exclude this for future requests
                $exclude[] = $review->ID;

                // review meta
                $associate = get_post_meta($review->ID, 'associate', true);
                ?>
	                <div class="review-wrap<?php if($single){echo ' single';} ?>">
                        <span class="before">&ldquo;</span>

                        <div class="review">
                            <h3 class="title"><?php echo $review->post_title; ?></h3>
                            <h4 class="subtitle">Worked with <?php echo $associate; ?></h4>
                            
                            <?php
                                // insert the read more
                                $review_content = $review->post_content;
                                $content_arr = explode(' ', $review_content);
                                $content_arr_count = count($content_arr);

                                if ($content_arr_count > 50){
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
                                                $rating = intval(get_post_meta($review->ID, $meta_key, true));
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
                <?php
            }
        }

        $html = ob_get_clean();
        if ($single) {
            $more = false;
        } else {
            $more = ($reviews->found_posts < $ppp) ? false : true;
        }

        echo json_encode(array('html' => $html, 'more' => $more, 'exclude' => $exclude));
        die();
    }

    // get property listing grid
    add_action('wp_ajax_nopriv_get_property_listing', 'get_property_listing');
    add_action('wp_ajax_get_property_listing', 'get_property_listing');
    function get_property_listing() {
        ob_start();
        $ppp = intval($_POST['ppp']);
        $keyword = $_POST['keyword'];
        $exclude = $_POST['exclude'] ? array_map('intval', explode(',', $_POST['exclude'])) : [];
        $args = array(
            'post_type' => 'property',
            'post_status' => 'publish',
            'posts_per_page' => $ppp,
            'orderby' => 'rand'
        );

        if ($keyword) {
            $args['s'] = $keyword;
        }

        if ($exclude) {
            $args['post__not_in'] = $exclude;
        }
        $properties = new WP_Query($args);
        $total_properties = $properties->found_posts;
        ?>

        <?php if ($total_properties) : ?>
            <?php foreach ($properties->posts as $property) : ?>
                <?php
                    // exclude this on for next page
                    $exclude[] = $property->ID;

                    // fire up a number formatter
                    $formatter = new NumberFormatter('en_US', NumberFormatter::DECIMAL);

                    $listing_status = get_field('listing_status', $property->ID);
                    $status_label = $listing_status === 'for-sale' ? 'For Sale' : 'Pending';

                    $price = get_field('price', $property->ID);
                    $formatted_price = $price ? $formatter->format($price) : '';

                    $number_of_bedrooms = get_field('number_of_bedrooms', $property->ID);
                    $number_of_bathrooms = get_field('number_of_bathrooms', $property->ID);

                    $square_footage = get_field('square_footage', $property->ID);
                    $formatted_square_footage = $square_footage ? $formatter->format($square_footage) : '';

                    $property_address = get_field('property_address', $property->ID);
                    $address1 = isset($property_address['name']) ? $property_address['name'] : '';
                    $address_city = isset($property_address['city']) ? $property_address['city'] : '';
                    $address_state = isset($property_address['state_short']) ? $property_address['state_short'] : '';
                    $address_zip = isset($property_address['post_code']) ? $property_address['post_code'] : '';

                    $image_url = get_the_post_thumbnail_url($property, 'large');
                    if (!$image_url) {
                        $image_url = get_stylesheet_directory_uri() . '/images/placeholder.png';
                    }

                    $agent_name = get_field('agent_name', $property->ID);
                    $agent_phone = get_field('agent_phone', $property->ID);
                    $agent_email = get_field('agent_email', $property->ID);
                    $compensation_percentage = get_field('compensation_percentage', $property->ID);
                ?>
                <div class="property">
                    <div class="imageWrap">
                        <img src="<?php echo $image_url; ?>" alt="<?php echo $property->post_title; ?>">
                    </div>
                    <div class="contentWrap">

                        <?php if ($listing_status && $status_label) : ?>
                            <div class="status <?php echo $listing_status; ?>">
                                <i class="fas fa-circle"></i> <?php echo $status_label; ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($formatted_price) : ?>
                            <div class="price">
                                <strong>$<?php echo $formatted_price; ?></strong>
                            </div>
                        <?php endif; ?>

                        <?php if ($number_of_bathrooms || $number_of_bedrooms || $square_footage) : ?>
                            <ul class="specList">
                                <?php if ($number_of_bedrooms) : ?>
                                    <li><strong><?php echo $number_of_bedrooms; ?></strong> bed</li>
                                <?php endif; ?>
                                <?php if ($number_of_bathrooms) : ?>
                                    <li><strong><?php echo $number_of_bathrooms; ?></strong> bath</li>
                                <?php endif; ?>
                                <?php if ($formatted_square_footage) : ?>
                                    <li><strong><?php echo $formatted_square_footage; ?></strong> sqft</li>
                                <?php endif; ?>
                            </ul>
                        <?php endif; ?>

                        <?php if ($address1 || ($address_city || $address_state || $address_zip)) : ?>
                            <div class="addressWrap">
                                <?php if ($address1) : ?>
                                    <div class="address1"><?php echo $address1; ?></div>
                                <?php endif; ?>
                                <?php if ($address_city || $address_state || $address_zip) : ?>
                                    <div class="address2">
                                        <?php echo $address_city . ', ' . $address_state . ' ' . $address_zip; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($agent_name || $agent_email || $agent_phone || $compensation_percentage) : ?>
                        <div class="agentWrap">
                            <?php if ($agent_name) : ?>
                                <div class="agentName"><?php echo $agent_name; ?></div>
                            <?php endif; ?>
                            <?php if ($agent_phone) : ?>
                                <div>
                                    <a target="_blank" href="tel:<?php echo $agent_phone; ?>">
                                        <i class="fas fa-phone"></i> <?php echo $agent_phone; ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <?php if ($agent_email) : ?>
                                <div>
                                    <a target="_blank" href="mailto:<?php echo $agent_email; ?>">
                                        <i class="fas fa-envelope"></i> <?php echo $agent_email; ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <?php if ($compensation_percentage) : ?>
                                <div class="compWrap">
                                    <strong>Compensation: <?php echo $compensation_percentage; ?>%</strong> 
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php
        $html = ob_get_clean();
        $loadMore = $ppp < $total_properties ? true : false; 

        echo json_encode(array('html' => $html, 'loadMore' => $loadMore, 'exclude' => $exclude));
        die();
    }

    add_filter( 'register_url', 'change_my_register_url' );
    function change_my_register_url( $url ) {
        if( is_admin() ) {
            return $url;
        }
        return "/nrc-reg";
    }
?>