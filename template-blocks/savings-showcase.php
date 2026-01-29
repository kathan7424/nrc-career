<?php
$section_content = get_field('showcase_title');
$gallery_images  = get_field('short');
$review_button   = get_field('review_button');
?>

<section class="savings-showcase-block">
    <div class="wrapper">

        <!-- Header Section -->
        <?php if ($section_content) : ?>
            <div class="savings-showcase-header">
                <?php echo $section_content; ?>
            </div>
        <?php endif; ?>

        <!-- Examples Grid -->
        <?php if ($gallery_images) : ?>
            <div class="savings-examples-grid">
                <?php foreach ($gallery_images as $image) : ?>
                    <div class="savings-example-item">
                        <div class="savings-example-image">
                            <img 
                                src="<?php echo esc_url($image['sizes']['large']); ?>" 
                                alt="<?php echo esc_attr($image['alt']); ?>" 
                                loading="lazy"
                            />
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- CTA Button -->
        <?php if ($review_button) : ?>
            <div class="savings-showcase-footer">
                <a 
                    href="<?php echo esc_url($review_button['url']); ?>" 
                    class="btn-custom btn-primary"
                    target="<?php echo esc_attr($review_button['target'] ?: '_self'); ?>"
                >
                    <?php echo esc_html($review_button['title']); ?>
                </a>
            </div>
        <?php endif; ?>

    </div>
</section>



