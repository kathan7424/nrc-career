<?php

 	// whitelabel login a bit
	function bc_login_logo_url() {
	    return home_url();
	}
	add_filter('login_headerurl', 'bc_login_logo_url');

	function bc_login_logo_url_title() {
	    return get_bloginfo('description');
	}
	add_filter('login_headertitle', 'bc_login_logo_url_title');

	// favicon to front and backend
	function add_favicon() {
	?>
	   <link href="<?php bloginfo('template_directory'); ?>/favicon.png" rel="shortcut icon">
	<?php
	}
	add_action('wp_head', 'add_favicon');
	add_action('admin_head', 'add_favicon');
	
	// custom ACF Color palette
	function acf_custom_colors(){
		?>
		<script type="text/javascript">
			jQuery(document).ready(function($){
				if(typeof acf !== 'undefined'){
					// custom colors
					var palette = ['#ffffff','#1c3044', '#f1eee7','#4aa7dd','#527b91','#eb974c','#f6f6f6','#595652','#333333','#000000'];

					// when initially loaded find existing colorpickers and set the palette
					acf.add_action('load', function(){
						$('input.wp-color-picker').each(function() {
							$(this).iris('option', 'palettes', palette);
						});
					});

					// if appended element only modify the new element's palette
					acf.add_action('append', function(el) {
						$(el).find('input.wp-color-picker').iris('option', 'palettes', palette);
					});
				}
			});
		</script>
		<?php
	}
	//add_action('admin_print_scripts', 'acf_custom_colors', 99);


	// add extra buttons/dropdowns
	function tinymce_add_buttons($buttons){
 		// array_unshift($buttons, 'styleselect','fontselect');
 		array_unshift($buttons, 'fontselect');
        array_splice($buttons, 4, 0, 'underline');
		return $buttons;
    }
    add_filter('mce_buttons', 'tinymce_add_buttons');

	// custom tinymce formats
	add_filter('tiny_mce_before_init', 'tinymce_before_init');
	function tinymce_before_init($settings){

		// custom wysiwyg color palettes
		$color_string = '["FFFFFF","White","000000","Black","cccccc","Grey","201f1e","Dark Grey","e31b23","Red","f5a800","Yellow"]';

		$settings['textcolor_map'] = $color_string;

		// styles
	    // $style_formats = array(	
	    // 	array(
	    // 		'title' => 'Buttons',
	    // 		'items' => array(    
			  //       array(
			  //           'title' => 'Button',
			  //           'inline' => 'a',
			  //           'classes' => 'button'
			  //       ), 	        
			  //       array(
			  //           'title' => 'Button - Alt',
			  //           'inline' => 'a',
			  //           'classes' => 'button alt'
			  //       ), 			        			     
			  //       array(
			  //           'title' => 'Button - Ghost',
			  //           'inline' => 'a',
			  //           'classes' => 'button-ghost'
			  //       ),			        
			  //       array(
			  //           'title' => 'Button - Ghost - Alt',
			  //           'inline' => 'a',
			  //           'classes' => 'button-ghost alt'
			  //       ),				                	             
	    // 		) 
	    // 	)
	
	    // );
	    // $settings['style_formats'] = json_encode($style_formats);

	    // fonts
    	$font_formats = 'Arial=arial;';

	   	$settings['font_formats'] = $font_formats;

	   	// show "kitchen sink"
	   	$settings['wordpress_adv_hidden'] = false;

	    return $settings;
	}
?>