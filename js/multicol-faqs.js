(function () {
    'use strict';

    function initializeFAQs() {
        const faqBlocks = document.querySelectorAll('.multicol-faqs-block');
        
        faqBlocks.forEach(function (block) {
            const faqItems = block.querySelectorAll('.multicol-faqs-item');
            
            faqItems.forEach(function (item) {
                // Skip if already initialized
                if (item.dataset.faqInitialized === 'true') {
                    return;
                }
                item.dataset.faqInitialized = 'true';
                
                const question = item.querySelector('.multicol-faqs-question');
                const answer = item.querySelector('.multicol-faqs-answer');
                
                if (!question || !answer) return;

                // Set initial styles
                answer.style.maxHeight = '0px';
                answer.style.overflow = 'hidden';
                answer.style.transition = 'max-height 0.4s ease';

                question.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    const isActive = item.classList.contains('active');
                    
                    // Close all items in this block
                    faqItems.forEach(function (i) {
                        const a = i.querySelector('.multicol-faqs-answer');
                        if (a) {
                            a.style.maxHeight = '0px';
                        }
                        i.classList.remove('active');
                        const q = i.querySelector('.multicol-faqs-question');
                        if (q) q.setAttribute('aria-expanded', 'false');
                    });

                    // Open clicked item
                    if (!isActive) {
                        item.classList.add('active');
                        question.setAttribute('aria-expanded', 'true');
                        
                        // Calculate and set the content height
                        const contentElement = answer.querySelector('.multicol-faqs-answer-content');
                        if (contentElement) {
                            const contentHeight = contentElement.scrollHeight;
                            answer.style.maxHeight = (contentHeight + 40) + 'px';
                        }
                    }
                });

                question.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        question.click();
                    }
                });
            });
        });
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeFAQs);
    } else {
        initializeFAQs();
    }
    
    // Re-initialize on dynamic content load
    document.addEventListener('load', initializeFAQs, true);
})();
