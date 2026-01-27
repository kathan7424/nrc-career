<?php
	// dev function
	function is_buildcreate() {
		$user = wp_get_current_user(); 
		if($user->user_login == 'buildcreate' ) : 
			return true; 
		else : 
			return false; 
		endif; 
	}


	// allow custom wysiwyg backgrounds to display in admin
	function bc_acf_input_admin_footer() {
	?>
		<script type="text/javascript">
			(function($) {
				
				// change on init
				acf.add_filter('wysiwyg_tinymce_settings', function(mceInit, id, $field){
					var background_styles = '';

					// get background color picker that has this wysiwygs field key as a class
					var $color_siblings = $field.siblings('.acf-field-color-picker.'+$field.data('key'));
					var color = $('input', $color_siblings).val();
					if(color){
						var rgb = ['0x' + color[1] + color[2] | 0, '0x' + color[3] + color[4] | 0, '0x' + color[5] + color[6] | 0];
						background_styles += 'background-color:'+color+';';
					}		

					// get background image that has this wysiwygs field key as a class
					var $image_siblings = $field.siblings('.acf-field-image.'+$field.data('key'));
					var image = $('img', $image_siblings).attr('src');
					if(image){
						if(color){
							background_styles += "background:linear-gradient(rgba("+rgb[0]+","+rgb[1]+","+rgb[2]+",0.9), rgba("+rgb[0]+","+rgb[1]+","+rgb[2]+",0.9)), url('"+image+"') center no-repeat;background-size:cover;";
						}else{
							background_styles += "background:url('"+image+"') center no-repeat;background-size:cover;";
						}
					}

					mceInit.content_style = "#tinymce{" + background_styles + "}";	

					// get style type that has this wysiwygs field key as a class
					var $type_siblings = $field.siblings('.acf-field-radio.'+$field.data('key'));
					var type = $('input:checked', $type_siblings).val();
					if(type){
						mceInit.body_class += ' ' + type;
					}

					// add field name to class for more control of the wysiwyg
					mceInit.body_class += ' ' + $field.data('name');

					// return
					return mceInit;
				});
			})(jQuery);	
		</script>
	<?php	
	}
	add_action('acf/input/admin_footer', 'bc_acf_input_admin_footer');

	// custom template part shorthand
	function template_part($slug){
		include get_stylesheet_directory() . '/template-parts/' . $slug . '.php';
	}

	// custom wrapper function for 'get_post_meta' in content rows
	function gpm($key, $wysiwyg = false, $post_id = false){
		global $post;
		$post_id = $post_id ? $post_id : $post->ID;

		if($wysiwyg){
			return apply_filters('the_content', get_post_meta($post_id, $key, true));
		}else{
			return get_post_meta($post_id, $key, true);
		}
	}

	// custom button wrapper
	function get_button($classes = '', $link) {
		return '<a class="'. $classes .'" target="'. $link['target'] .'" href="'. $link['url'] .'">'. $link['title'] .'</a>';
	}

	// add gravityforms button to all wysywigs
	add_filter('gform_display_add_form_button', '__return_true');


	// wrap 'the_content' filter
	// add_filter('the_content', 'wrap_the_content', 10, 1);
	function wrap_the_content($content){
		return '<div class="user-content">' . $content . '</div>';
	}

	// add google api key for ACF maps
	function bc_acf_map_init() {
		acf_update_setting('google_api_key', 'AIzaSyBPSXek9GzAWy77Up9HNqKhy37SraHdwnM');
	}
	add_action('acf/init', 'bc_acf_map_init');

	// custom excerpt display
	function custom_excerpt($excerpt, $length = 25){
		if($excerpt){
			$excerpt = strip_tags($excerpt);
			$excerpt_arr = explode(' ', $excerpt);
			$custom_excerpt = '';
			if($excerpt_arr){
				foreach ($excerpt_arr as $key => $word) {
					if($key < 25){
						$custom_excerpt .= ' ' . $word;
					}else{
						break;
					}
				}
			}
			return $custom_excerpt;
		}
	}	

	// Move Yoast to bottom
	function yoasttobottom(){
		return 'low';
	}
	add_filter('wpseo_metabox_prio', 'yoasttobottom');


	// add default image field to ACF
	add_action('acf/render_field_settings/type=image', 'add_default_value_to_image_field');
	function add_default_value_to_image_field($field){
		acf_render_field_setting($field, array(
			'label' => 'Default Image',
			'instructions' => 'Appears when creating a new post',
			'type' => 'image',
			'name' => 'default_value',
		));
	}

	// get thumbs for youtube and vimeo
	function get_video_thumbnail($url){
		$image = false;
		if(strpos($url, 'youtube') !== false){
			$query_string = explode('?', $url);
			$video_id = explode('=', $query_string[1]);
			$image = 'http://img.youtube.com/vi/'.$video_id[1].'/hqdefault.jpg';
		}elseif(strpos($url, 'vimeo') !== false){
			$query_string = explode('.com/', $url);
			$hash = unserialize(file_get_contents('http://vimeo.com/api/v2/video/'.$query_string[1].'.php'));
			$image = $hash[0]['thumbnail_large'];
		}
		return $image;
	}

	// embed url for lightboxes/iframes etc
	function get_youtube_embed_url($url){
	    $shortUrlRegex = '/youtu.be\/([-a-zA-Z0-9_]+)\??/i';
	    $longUrlRegex = '/youtube.com\/((?:embed)|(?:watch))((?:\?v\=)|(?:\/))([-a-zA-Z0-9_]+)/i';

	    if (preg_match($longUrlRegex, $url, $matches)) {
	        $youtube_id = $matches[count($matches) - 1];
	    }

	    if (preg_match($shortUrlRegex, $url, $matches)) {
	        $youtube_id = $matches[count($matches) - 1];
	    }
	   return 'https://www.youtube.com/embed/' . $youtube_id ;
	}

	// remove ignitewoo nag
	remove_action('admin_notices', 'ignitewoo_updater_notice');



?>