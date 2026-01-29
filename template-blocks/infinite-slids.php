<?php
$images = get_field('carousel_images');
$body_class = get_field('additional_class');
$sub_heading = get_field('sub_heading');
$main_heading = get_field('main_heading');
$content_area = get_field('content_area');


// Add body class dynamically
if ($body_class) {
add_filter('body_class', function ($classes) use ($body_class) {
$classes[] = sanitize_html_class($body_class);
return $classes;
});
}


if (!$images) {
return;
}
?>
<section class="infinite-slids-block <?php echo esc_attr($body_class); ?>">
    <?php if ($sub_heading || $main_heading) : ?>
    <div class="features-header">
            <p><?php echo esc_html($sub_heading); ?></p>
            <h2><?php echo esc_html($main_heading); ?></h2>
    </div>
    <?php endif; ?>
    <div class="infinite-slids-wrapper">
        <div class="infinite-slids-track">
            <?php
            // Output images twice for infinite loop
            for ($i = 0; $i < 2; $i++) :
            foreach ($images as $index => $image) :
            $size_class = ($index % 2 === 0)
            ? 'infinite-slids-slide-small'
            : 'infinite-slids-slide-large';
            ?>
                        <div class="infinite-slids-slide <?php echo esc_attr($size_class); ?>">
                            <img src="<?php echo esc_url($image['sizes']['large']); ?>" alt="<?php echo esc_attr($image['alt']); ?>"
                                draggable="false" />
                        </div>
                        <?php
            endforeach;
            endfor;
            ?>
        </div>
    </div>
    <?php if ($content_area) : ?>
    <div class="infinite-slids-content-area">
        <?php echo wp_kses_post($content_area); ?>
    </div>
    <?php endif; ?>
</section>



<script>
// Infinite Slider - Prevent all user interactions
(function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
        const sliderTrack = document.querySelector('.infinite-slids-track');
        const sliderWrapper = document.querySelector('.infinite-slids-wrapper');
        const slides = document.querySelectorAll('.infinite-slids-slide');

        if (!sliderTrack || !sliderWrapper) {
            console.warn('Infinite slider elements not found');
            return;
        }

        // Prevent all drag events on track
        const preventDrag = (e) => {
            e.preventDefault();
            e.stopPropagation();
            return false;
        };

        // Prevent mouse events
        sliderTrack.addEventListener('mousedown', preventDrag, true);
        sliderTrack.addEventListener('mousemove', preventDrag, true);
        sliderTrack.addEventListener('mouseup', preventDrag, true);
        sliderTrack.addEventListener('click', preventDrag, true);

        // Prevent touch events
        sliderTrack.addEventListener('touchstart', preventDrag, {
            passive: false,
            capture: true
        });
        sliderTrack.addEventListener('touchmove', preventDrag, {
            passive: false,
            capture: true
        });
        sliderTrack.addEventListener('touchend', preventDrag, {
            passive: false,
            capture: true
        });

        // Prevent drag start
        sliderTrack.addEventListener('dragstart', preventDrag, true);
        sliderTrack.addEventListener('drag', preventDrag, true);
        sliderTrack.addEventListener('dragend', preventDrag, true);

        // Prevent context menu
        sliderTrack.addEventListener('contextmenu', preventDrag, true);

        // Prevent selection
        sliderTrack.addEventListener('selectstart', preventDrag, true);

        // Apply to wrapper as well
        sliderWrapper.addEventListener('mousedown', preventDrag, true);
        sliderWrapper.addEventListener('touchstart', preventDrag, {
            passive: false,
            capture: true
        });
        sliderWrapper.addEventListener('dragstart', preventDrag, true);

        // Prevent all interactions on individual slides and images
        slides.forEach(slide => {
            slide.addEventListener('mousedown', preventDrag, true);
            slide.addEventListener('touchstart', preventDrag, {
                passive: false,
                capture: true
            });
            slide.addEventListener('dragstart', preventDrag, true);
            slide.addEventListener('contextmenu', preventDrag, true);

            const img = slide.querySelector('img');
            if (img) {
                img.addEventListener('mousedown', preventDrag, true);
                img.addEventListener('touchstart', preventDrag, {
                    passive: false,
                    capture: true
                });
                img.addEventListener('dragstart', preventDrag, true);
                img.addEventListener('contextmenu', preventDrag, true);
                img.addEventListener('click', preventDrag, true);

                // Extra security for image dragging
                img.ondragstart = () => false;
                img.onselectstart = () => false;
                img.oncontextmenu = () => false;
            }
        });

        // Disable pointer events through CSS as backup
        sliderTrack.style.pointerEvents = 'none';
        sliderTrack.style.userSelect = 'none';
        sliderTrack.style.webkitUserSelect = 'none';
        sliderTrack.style.mozUserSelect = 'none';
        sliderTrack.style.msUserSelect = 'none';

        // Make sure animation continues smoothly
        let isPaused = false;

        // Prevent any pause attempts
        sliderTrack.addEventListener('animationiteration', () => {
            if (isPaused) {
                sliderTrack.style.animationPlayState = 'running';
                isPaused = false;
            }
        });

        // Monitor for any animation stops
        const observer = new MutationObserver(() => {
            const computedStyle = window.getComputedStyle(sliderTrack);
            if (computedStyle.animationPlayState === 'paused') {
                sliderTrack.style.animationPlayState = 'running';
            }
        });

        observer.observe(sliderTrack, {
            attributes: true,
            attributeFilter: ['style']
        });

        console.log('Infinite slider initialized - interaction disabled');
    });
})();
</script>