<section class="infinite-slids-block">
    <div class="infinite-slids-wrapper">
        <div class="infinite-slids-track">
            <!-- First set of images -->
            <div class="infinite-slids-slide infinite-slids-slide-small">
                <img src="https://images.unsplash.com/photo-1511632765486-a01980e01a18?w=400&h=300&fit=crop" alt="Team Photo 1">
            </div>
            <div class="infinite-slids-slide infinite-slids-slide-large">
                <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=400&h=600&fit=crop" alt="Team Photo 2">
            </div>
            <div class="infinite-slids-slide infinite-slids-slide-small">
                <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?w=400&h=300&fit=crop" alt="Team Photo 3">
            </div>
            <div class="infinite-slids-slide infinite-slids-slide-large">
                <img src="https://images.unsplash.com/photo-1556761175-5973dc0f32e7?w=400&h=600&fit=crop" alt="Team Photo 4">
            </div>
            <div class="infinite-slids-slide infinite-slids-slide-small">
                <img src="https://images.unsplash.com/photo-1600880292203-757bb62b4baf?w=400&h=300&fit=crop" alt="Team Photo 5">
            </div>
            <div class="infinite-slids-slide infinite-slids-slide-large">
                <img src="https://images.unsplash.com/photo-1521737711867-e3b97375f902?w=400&h=600&fit=crop" alt="Team Photo 6">
            </div>
            
            <!-- Duplicate set for seamless infinite loop -->
            <div class="infinite-slids-slide infinite-slids-slide-small">
                <img src="https://images.unsplash.com/photo-1511632765486-a01980e01a18?w=400&h=300&fit=crop" alt="Team Photo 1">
            </div>
            <div class="infinite-slids-slide infinite-slids-slide-large">
                <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=400&h=600&fit=crop" alt="Team Photo 2">
            </div>
            <div class="infinite-slids-slide infinite-slids-slide-small">
                <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?w=400&h=300&fit=crop" alt="Team Photo 3">
            </div>
            <div class="infinite-slids-slide infinite-slids-slide-large">
                <img src="https://images.unsplash.com/photo-1556761175-5973dc0f32e7?w=400&h=600&fit=crop" alt="Team Photo 4">
            </div>
            <div class="infinite-slids-slide infinite-slids-slide-small">
                <img src="https://images.unsplash.com/photo-1600880292203-757bb62b4baf?w=400&h=300&fit=crop" alt="Team Photo 5">
            </div>
            <div class="infinite-slids-slide infinite-slids-slide-large">
                <img src="https://images.unsplash.com/photo-1521737711867-e3b97375f902?w=400&h=600&fit=crop" alt="Team Photo 6">
            </div>
        </div>
    </div>
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
        sliderTrack.addEventListener('touchstart', preventDrag, { passive: false, capture: true });
        sliderTrack.addEventListener('touchmove', preventDrag, { passive: false, capture: true });
        sliderTrack.addEventListener('touchend', preventDrag, { passive: false, capture: true });
        
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
        sliderWrapper.addEventListener('touchstart', preventDrag, { passive: false, capture: true });
        sliderWrapper.addEventListener('dragstart', preventDrag, true);
        
        // Prevent all interactions on individual slides and images
        slides.forEach(slide => {
            slide.addEventListener('mousedown', preventDrag, true);
            slide.addEventListener('touchstart', preventDrag, { passive: false, capture: true });
            slide.addEventListener('dragstart', preventDrag, true);
            slide.addEventListener('contextmenu', preventDrag, true);
            
            const img = slide.querySelector('img');
            if (img) {
                img.addEventListener('mousedown', preventDrag, true);
                img.addEventListener('touchstart', preventDrag, { passive: false, capture: true });
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