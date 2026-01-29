<?php
    // save out block data
    global $post;
    $data = $block['data'];
    $class_name = isset($block['className']) ? $block['className'] : '';
    
    $section_id = get_field('section_id');
    $single = get_field('display_type');
    $single = $single === 'single_review' ? true : false;
    $featured_reviews = get_field('featured_reviews') ? (array) get_field('featured_reviews') : [];
    $featured_ids = !empty($featured_reviews) ? array_map(function($review) {
        return is_object($review) ? $review->ID : $review;
    }, $featured_reviews) : [];

    // 5 star reviews count
    $args = array(
        'post_type' => 'review',
        'post_status' => 'publish',
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
    $num_5_star = new WP_Query($args);

    // total count
    $args = array(
        'post_type' => 'review',
        'post_status' => 'publish'
    );
    $total_reviews = new WP_Query($args);
?>


<section id="<?php echo esc_attr($section_id); ?>" class="reviews-block <?php echo esc_attr($class_name); ?>">
    <div class="wrapper narrow">
        
        <?php if(!$single) : ?>
            <!-- Star Rating Header -->
            <div class="reviews-rating-header">
                <div class="rating-display">
                    <span class="rating-number">5.0</span>
                    <div class="stars">
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                    </div>
                </div>
                <div class="review-count-text">
                    (<span class="count-number" data-total="<?php echo esc_attr($num_5_star->found_posts); ?>">0</span>) Happy Agents
                </div>
            </div>

            <!-- <div class="review-counters-wrap"> -->
                <!-- <div class="left"> -->
                    <!-- <div class="total-wrap"> -->
                        <!-- <span class="count" data-total="<?php //echo esc_attr($total_reviews->found_posts); ?>">0</span> -->
                        <!-- <span class="title"><?php //echo esc_html($data['total_reviews_label']); ?></span> -->
                    <!-- </div> -->
                <!-- </div>                   -->
                <!-- <div class="right"> -->
                    <!-- <div class="total-5-wrap"> -->
                        <!-- <span class="count" data-total="<?php //echo esc_attr($num_5_star->found_posts); ?>">0</span> -->
                        <!-- <span class="title"><?php //echo esc_html($data['total_5_star_reviews_label']); ?></span> -->
                    <!-- </div> -->
                <!-- </div> -->
            <!-- </div> -->

            <!-- <hr class="divider"> -->

            <script>
                jQuery(document).ready(function($){
                    // Animate star rating count
                    let star_count = $('.reviews-rating-header .count-number').data('total');
                    for(let i = 0; i <= star_count; i++){
                        setTimeout(function(){
                            $('.reviews-rating-header .count-number').text(i); 
                        }, 10 * i);
                    }

                    // Animate total reviews count
                    let total_count = $('.total-wrap .count').data('total');
                    for(let i = 0; i <= total_count; i++){
                        setTimeout(function(){
                            $('.total-wrap .count').text(i); 
                        }, 10 * i);
                    }                       

                    // Animate 5 star reviews count
                    let total_5_count = $('.total-5-wrap .count').data('total');
                    for(let j = 0; j <= total_5_count; j++){
                        setTimeout(function(){
                            $('.total-5-wrap .count').text(j); 
                        }, 10 * j);
                    }
                });
            </script>
        <?php endif; ?>

        <div class="reviewsWrap"></div>

        <div class="moreReviewsWrap" style="display:none;">
            <span class="btn-custom btn-primary read-more-reviews">Read More Reviews</span>
        </div>
    </div>
</section>

<script>
(function() {
    const moreReviewsWrap = document.querySelector('.moreReviewsWrap');
    if (!moreReviewsWrap) return;

    // ajax get reviews
    let exclude = [];
    const ppp = 6; // Load 6 reviews each time
    const isSingle = <?php echo $single ? 'true' : 'false'; ?>;
    const featuredIds = "<?php echo esc_js(implode(',', $featured_ids)); ?>";
    
    const getReviews = async () => {
        const data = new FormData();
        data.append('action', 'get_reviews');
        data.append('ppp', ppp);
        data.append('exclude', exclude.join(','));
        data.append('featured_ids', featuredIds);
        data.append('single', isSingle ? '1' : '');
        
        try {
            const response = await fetch("<?php echo esc_url(admin_url('admin-ajax.php')); ?>", {
                method: "POST",
                body: data
            });
            
            const result = await response.json();
            
            exclude = result.exclude || [];
            
            const reviewsWrap = document.querySelector('.reviewsWrap');
            if (!reviewsWrap) return;
            
            const reviewWrap = document.createElement('div');
            reviewWrap.innerHTML = result.html;
            reviewsWrap.appendChild(reviewWrap);

            // read more action (for any newly inserted read-more links)
            const readMoreLinks = reviewWrap.querySelectorAll('.read-more');
            if (readMoreLinks) {
                readMoreLinks.forEach(readMore => {
                    readMore.addEventListener('click', function() {
                        const moreSpan = readMore.previousElementSibling;
                        if (moreSpan) {
                            moreSpan.style.display = 'inline';
                        }
                        readMore.style.display = 'none';
                    });
                });
            }

            // show/hide the "Read More Reviews" button based on response
            if (result.more) {
                moreReviewsWrap.style.display = '';
            } else {
                moreReviewsWrap.style.display = 'none';
            }
        } catch (error) {
            console.error('Error loading reviews:', error);
        }
    };

    // on load
    getReviews();

    // load more reviews
    const moreButton = moreReviewsWrap.querySelector('.read-more-reviews');
    if (moreButton) {
        moreButton.addEventListener('click', function() {
            getReviews();
        });
    }
})();
</script>