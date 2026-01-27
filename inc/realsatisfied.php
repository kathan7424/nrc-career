<?php
	// load up wp
	include '../../../../wp-load.php';
	global $wpdb;


	/////////////////////////////
	/////// ASSOCIATES /////////
	////////////////////////////

	// set offices to get associates from
	$offices = array(
		array(
			'location' => 'livonia',
			'user' => '95b194K',
			'key' => '9afd873a2ccfa06a443c4af9daf4cb13',
		),
		array(
			'location' => 'birmingham',
			'user' => 'ce9axLK',
			'key' => 'd67b5f674a389e195e64293cb71b330b',
		),
		array(
			'location' => 'northville',
			'user' => '3640rLK',
			'key' => '84c50c6cd60844ee23a8034da7922f64',
		)
	);

	// do the import
	foreach($offices as $office){

		// step through the accounts
		$limit = 100;
		$offset = 0;
		do{

			// set the auth headers
			$auth = array(
				'headers' => array(
					'Authorization' => 'Basic ' . base64_encode($office['user'] . ':' . $office['key'])
				)
			);
			$url = 'https://api.realsatisfied.com/v1/accounts.json?offset='.$offset.'&limit='.$limit;
			$result = wp_remote_get($url, $auth);
			$accounts = json_decode($result['body']);

			// increment offset
			$offset += $limit;

			// import associates
			if($accounts->accounts){
				foreach($accounts->accounts as $account){

					// active accounts only
					if($account->account->active == 'False'){

						// maybe delete associate
						$sql = "
							SELECT p.ID 
							FROM {$wpdb->prefix}posts p
							LEFT JOIN {$wpdb->prefix}postmeta m1 ON (m1.post_id = p.ID AND m1.meta_key = 'account_id')
							WHERE p.post_type = 'associate'
							AND p.post_status = 'publish'
							AND m1.meta_value = '{$account->account->account_id}'
						";
						$result = $wpdb->get_row($sql);
						if($result){
							wp_delete_post($result->ID, true);
						}

					}else{

						// check to see if associate exists
						$sql = "
							SELECT p.ID 
							FROM {$wpdb->prefix}posts p
							LEFT JOIN {$wpdb->prefix}postmeta m1 ON (m1.post_id = p.ID AND m1.meta_key = 'account_id')
							WHERE p.post_type = 'associate'
							AND m1.meta_value = '{$account->account->account_id}'
						";
						$result = $wpdb->get_row($sql);
						if($result){

							// set the post ID
							$post_id = $result->ID;

						}else{

							// create the post
							$args = array(
								'post_type' => 'associate',
								'post_status' => 'publish',
								'post_title' => ucwords(strtolower($account->account->full_name)),
							);
							$post_id = wp_insert_post($args);
						}

						// update the associate meta
						update_post_meta($post_id, 'phone', $account->account->phone);
						update_post_meta($post_id, 'mobile', $account->account->mobile);
						update_post_meta($post_id, 'email', $account->account->email);
						update_post_meta($post_id, 'website', $account->account->agent_website_url);
						update_post_meta($post_id, 'photo_url', $account->account->photo_url);
						update_post_meta($post_id, 'vanity_key', $account->account->vanity_key);
						update_post_meta($post_id, 'account_id', $account->account->account_id);
						wp_set_object_terms($post_id, $office['location'], 'location', true);
					}
				}
			}

		}while($accounts->accounts);
	}

	///////////////////////////////
	/////////// REVIEWS //////////
	//////////////////////////////

	// import reviews from each agent
	$sql = "
		SELECT p.ID, p.post_title, m1.meta_value
		FROM {$wpdb->prefix}posts p
		LEFT JOIN {$wpdb->prefix}postmeta m1 ON (m1.post_id = p.ID AND m1.meta_key = 'vanity_key')
		WHERE p.post_type = 'associate'
		AND p.post_status = 'publish'
	";
	$results = $wpdb->get_results($sql);
	if($results){

		// set the base url
		$feed_url = 'https://rss.realsatisfied.com/rss/v2/agent/';
		foreach($results as $result){

			// load up this associates feed
			$feed = simplexml_load_file($feed_url . $result->meta_value);
			foreach($feed->channel->item as $item){

				// get the review fields
				$associate = $result->post_title;
				$title = $item->title;
				$description = $item->description;
				$review_id = (string) $item->guid;

				// get the namespaced fields
				$rs_ns = $item->children('https://rss.realsatisfied.com/ns/realsatisfied/');
				$performance = (string) $rs_ns->performance;
				$recommendation = (string) $rs_ns->recommendation;
				$satisfaction = (string) $rs_ns->satisfaction;
				$customer_type = (string) $rs_ns->customer_type;

				// only reviews with ratings
				if($title != 'Seller' && $title != 'Buyer' && !empty($title) && !empty($description) && $recommendation && $satisfaction && $performance){

					// see if this review already exists
					$sql = "
						SELECT p.ID
						FROM {$wpdb->prefix}posts p
						LEFT JOIN {$wpdb->prefix}postmeta m1 ON (m1.post_id = p.ID AND m1.meta_key = 'review_id')
						WHERE p.post_type = 'review'
						AND m1.meta_value = '{$review_id}'
					";
					$review = $wpdb->get_row($sql);

					if(!$review){

						// create the post
						$args = array(
							'post_type' => 'review',
							'post_status' => 'publish',
							'post_content' => $description,
							'post_title' => $title,
						);
						$post_id = wp_insert_post($args);

						update_post_meta($post_id, 'customer_type', $customer_type);
						update_post_meta($post_id, 'review_id', $review_id);
						update_post_meta($post_id, 'associate', $associate);
						update_post_meta($post_id, 'satisfaction_rating', $satisfaction);
						update_post_meta($post_id, 'recommendation_rating', $recommendation);
						update_post_meta($post_id, 'performance_rating', $performance);
					}
				}
			}
		}
	}
?>