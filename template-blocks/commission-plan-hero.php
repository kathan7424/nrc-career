<?php
/**
 * Commission Plan Hero Block – ACF Dynamic
 */

/* ========== ACF FIELDS ========== */
$additional_class     = get_field('additional_class');
$main_heading         = get_field('main_heading');
$highlighted_heading  = get_field('highlighted_heading');
$hero_content         = get_field('hero_content');
$cta_button           = get_field('cta_button');        // Link field
$plan_title           = get_field('plan_title');
$plan_list            = get_field('plan_list');         // Repeater
$review_button        = get_field('review_button');     // Link field

/* ========== BLOCK CLASSES ========== */
$class_name = 'commission-plan-hero-block';

if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

if ( ! empty( $additional_class ) ) {
    $class_name .= ' ' . esc_attr( $additional_class );
}
?>

<section class="<?php echo esc_attr( $class_name ); ?>">
    <div class="wrapper">
        <div class="commission-hero-container">

            <!-- Left Content -->
            <div class="commission-hero-left">
                <div class="commission-hero-content">

                    <h1 class="commission-hero-title">
                        <?php if ( $main_heading ) : ?>
                            <?php echo esc_html( $main_heading ); ?>
                        <?php endif; ?>

                        <?php if ( $highlighted_heading ) : ?>
                            <br>
                            <span class="commission-hero-title-highlight title-underline">
                                <?php echo esc_html( $highlighted_heading ); ?>
                            </span>
                        <?php endif; ?>
                    </h1>

                    <?php if ( $hero_content ) : ?>
                        <p class="commission-hero-description">
                            <?php echo wp_kses_post( $hero_content ); ?>
                        </p>
                    <?php endif; ?>

                    <?php if ( $cta_button ) : ?>
                        <div class="commission-hero-button-wrap">
                            <a href="<?php echo esc_url( $cta_button['url'] ); ?>"
                               class="btn-custom btn-primary"
                               <?php if ( ! empty( $cta_button['target'] ) ) : ?>
                                   target="<?php echo esc_attr( $cta_button['target'] ); ?>"
                               <?php endif; ?>>
                                <?php echo esc_html( $cta_button['title'] ); ?>
                            </a>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

            <!-- Right Card -->
            <div class="commission-hero-right">
                <div class="commission-plan-card">

                    <?php if ( $plan_title ) : ?>
                        <div class="commission-card-header">
                            <h2 class="commission-card-title">
                                <?php echo esc_html( $plan_title ); ?>
                            </h2>
                        </div>
                    <?php endif; ?>

                    <?php if ( $plan_list ) : ?>
                        <div class="commission-card-benefits">
                            <?php foreach ( $plan_list as $plan_item ) : ?>
                                <?php if ( ! empty( $plan_item['plan_name'] ) ) : ?>
                                    <div class="commission-benefit-item">
                                        <span class="commission-benefit-dot"></span>
                                        <span class="commission-benefit-text">
                                            <?php echo esc_html( $plan_item['plan_name'] ); ?>
                                        </span>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ( $review_button ) : ?>
                        <div class="commission-card-footer">
                            <a href="<?php echo esc_url( $review_button['url'] ); ?>"
                               class="btn-custom btn-secondary"
                               <?php if ( ! empty( $review_button['target'] ) ) : ?>
                                   target="<?php echo esc_attr( $review_button['target'] ); ?>"
                               <?php endif; ?>>
                                <?php echo esc_html( $review_button['title'] ); ?>
                            </a>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

        </div>
    </div>
</section>