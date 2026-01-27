<?php
	// save out block data
	global $post;
	$data = $block['data'];
    $class_name = isset($block['className']) ? $block['className'] : '';
    
    $section_id = get_field('section_id');
    $single = get_field('display_type');
    $single = $single === 'single_review' ? true : false;

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

<section id="<?php echo $section_id; ?>" class="reviews-block <?php echo $class_name; ?>">
    <div class="wrapper narrow">
    	
        <?php if(!$single) : ?>
            <div class="review-counters-wrap">
                <div class="left">
                    <div class="total-wrap">
                        <span class="count" data-total="<?php echo $total_reviews->found_posts; ?>">0</span>
                        <span class="title"><?php echo $data['total_reviews_label']; ?></span>
                    </div>
                </div>					
                <div class="right">
                    <div class="total-5-wrap">
                        <span class="count" data-total="<?php echo $num_5_star->found_posts; ?>">0</span>
                        <span class="title"><?php echo $data['total_5_star_reviews_label']; ?></span>
                    </div>
                </div>
            </div>

            <hr class="divider">

            <script>
                jQuery(document).ready(function($){
                    let total_count = $('.total-wrap .count').data('total');
                    for(let i = 0; i <= total_count; i++){
                        setTimeout(function(){
                            $('.total-wrap .count').text(i); 
                        }, 10 * i);
                    }						

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

        <div class="moreReviewsWrap">
            <span class="bc-button read-more-reviews">Read More Reviews</span>
        </div>
    </div>
</section>

<script>
    const moreReviewsWrap = document.querySelector('.moreReviewsWrap')

    // ajax get reviews
    let exclude = []
    const ppp = 10
    const getReviews = async () => {

        const data = new FormData()
        data.append('action', 'get_reviews')
        data.append('ppp', ppp)
        data.append('exclude', exclude)
        data.append('single', "<?php echo $single; ?>")
        const response = await (await fetch("<?php echo admin_url('admin-ajax.php'); ?>", {
            method:"POST",
            body: data
        })).json()

        exclude.push(...response.exclude)
        const reviewsWrap = document.querySelector('.reviewsWrap')
        const reviewWrap = document.createElement('div')
        reviewWrap.innerHTML = response.html
        reviewsWrap.append(reviewWrap)

        // read more action
        const readMoreLinks = reviewWrap.querySelectorAll('.read-more')
        if (readMoreLinks) {
            readMoreLinks.forEach(readMore => {
                readMore.addEventListener('click', function() {
                    readMore.previousElementSibling.style.display = 'inline'
                    readMore.style.display = 'none'
                })
            })
        }

        // end of reviews
        if (!response.more) {
            moreReviewsWrap.remove()
        }
    }

    // on load
    getReviews()

    // load more
    const moreButton = moreReviewsWrap.querySelector('.read-more-reviews')
    moreButton.addEventListener('click', function() {
        getReviews()
    })

</script>