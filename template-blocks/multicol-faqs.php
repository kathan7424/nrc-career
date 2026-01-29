<?php
// ACF fields
$faqs = get_field('faqs');
$primary_buttons = get_field('primary_button');
$additional_class = get_field('additional_class');

$read_all = $primary_buttons['read_all_faqs'] ?? null;
$contact  = $primary_buttons['contact_our_team'] ?? null;

// Split FAQs into 3 columns
$columns = 3;
$faq_chunks = $faqs ? array_chunk($faqs, ceil(count($faqs) / $columns)) : [];

// Generate unique ID for this block instance
$block_id = 'multicol-faqs-' . uniqid();
?>

<section class="multicol-faqs-block <?php echo esc_attr($additional_class); ?>" id="<?php echo esc_attr($block_id); ?>">
    <div class="multicol-faqs-container">

        <!-- Header -->
        <div class="multicol-faqs-header">
            <h2 class="multicol-faqs-title">
                <?php echo esc_html(get_field('faq_main_title')); ?><br>
                <span class="multicol-faqs-title-highlight"><?php echo esc_html(get_field('faq_highlight_title')); ?></span>
            </h2>
        </div>

        <!-- FAQ Grid -->
        <?php if ($faq_chunks): ?>
        <div class="multicol-faqs-grid">

            <?php foreach ($faq_chunks as $column): ?>
            <div class="multicol-faqs-column">

                <?php foreach ($column as $faq): setup_postdata($faq); ?>
                <div class="multicol-faqs-item">
                    <button class="multicol-faqs-question" aria-expanded="false">
                        <span class="multicol-faqs-question-text">
                            <?php echo esc_html(get_the_title($faq)); ?>
                        </span>
                        <span class="multicol-faqs-icon">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M5 7.5L10 12.5L15 7.5"
                                      stroke="currentColor"
                                      stroke-width="2"
                                      stroke-linecap="round"
                                      stroke-linejoin="round"/>
                            </svg>
                        </span>
                    </button>

                    <div class="multicol-faqs-answer">
                        <div class="multicol-faqs-answer-content">
                            <p><?php echo apply_filters('the_content', $faq->post_content); ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; wp_reset_postdata(); ?>

            </div>
            <?php endforeach; ?>

        </div>
        <?php endif; ?>

        <!-- CTA Buttons -->
        <?php if ($read_all || $contact): ?>
        <div class="multicol-faqs-cta">

            <?php if ($read_all): ?>
                <a href="<?php echo esc_url($read_all['url']); ?>"
                   target="<?php echo esc_attr($read_all['target'] ?: '_self'); ?>"
                   class="multicol-faqs-btn multicol-faqs-btn-primary">
                    <?php echo esc_html($read_all['title']); ?>
                </a>
            <?php endif; ?>

            <?php if ($contact): ?>
                <a href="<?php echo esc_url($contact['url']); ?>"
                   target="<?php echo esc_attr($contact['target'] ?: '_self'); ?>"
                   class="multicol-faqs-btn multicol-faqs-btn-secondary">
                    <?php echo esc_html($contact['title']); ?>
                </a>
            <?php endif; ?>

        </div>
        <?php endif; ?>

    </div>
</section>

<script>
(function () {
    'use strict';

    function initializeFAQs() {
        const faqBlocks = document.querySelectorAll('.multicol-faqs-block');
        
        faqBlocks.forEach(function (block) {
            const faqItems = block.querySelectorAll('.multicol-faqs-item');
            
            faqItems.forEach(function (item) {
                // Skip if already initialized (prevents duplicate event listeners)
                if (item.dataset.faqInitialized === 'true') {
                    return;
                }
                
                // Mark as initialized
                item.dataset.faqInitialized = 'true';
                
                const question = item.querySelector('.multicol-faqs-question');
                const answer = item.querySelector('.multicol-faqs-answer');
                const content = item.querySelector('.multicol-faqs-answer-content');
                
                if (!question || !answer || !content) return;

                // Set initial styles
                answer.style.maxHeight = '0px';
                answer.style.overflow = 'hidden';
                answer.style.transition = 'max-height 0.4s ease';

                // Click handler
                question.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    const isActive = item.classList.contains('active');
                    
                    // Close all items in this block only
                    faqItems.forEach(function (i) {
                        const a = i.querySelector('.multicol-faqs-answer');
                        if (a) {
                            a.style.maxHeight = '0px';
                        }
                        i.classList.remove('active');
                        const q = i.querySelector('.multicol-faqs-question');
                        if (q) {
                            q.setAttribute('aria-expanded', 'false');
                        }
                    });

                    // Open clicked item
                    if (!isActive) {
                        item.classList.add('active');
                        question.setAttribute('aria-expanded', 'true');
                        
                        // Set max-height to content height + padding
                        const scrollHeight = content.scrollHeight;
                        answer.style.maxHeight = (scrollHeight + 40) + 'px';
                    }
                });

                // Keyboard support
                question.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        question.click();
                    }
                });
            });
        });
    }

    // Run immediately if DOM is ready
    if (document.readyState !== 'loading') {
        initializeFAQs();
    } else {
        document.addEventListener('DOMContentLoaded', initializeFAQs);
    }
    
    // Re-run on window load to catch dynamic content
    window.addEventListener('load', initializeFAQs);
})();
</script>