<?php

// Block classes
$classes = 'form-block';

if (!empty($block['className'])) {
    $classes .= ' ' . $block['className'];
}

$additional_class = get_field('additional_class');
if ($additional_class) {
    $classes .= ' ' . esc_attr($additional_class);
}

// Fields
$content_area = get_field('content_area');
$form_shortcode = get_field('form__shortcode');
?>

<section class="<?php echo esc_attr($classes); ?>">
    <div class="container">

        <?php if ($content_area) : ?>
            <div class="form-block-content">
                <h2 class="form-block-title">
                    <?php echo wp_kses_post($content_area); ?>
                </h2>
            </div>
        <?php endif; ?>

        <?php if ($form_shortcode) : ?>
            <div class="form-block-form">
                <?php echo do_shortcode($form_shortcode); ?>
            </div>
        <?php endif; ?>

    </div>
</section>