<?php
$section_class = get_field('section_class');
$section_title = get_field('section_title');
$features = get_field('features_list');
$short_description = get_field('short_description');

?>


<section class="features-section <?php echo esc_attr($section_class); ?>">
        <div class="features-container">
            <!-- Header -->
            <div class="features-header">
                <?php if ($section_title): ?>
                    <!-- <h2 class="features-title"> -->
                        <?php echo $section_title; ?>
                    <!-- </h2> -->
                <?php endif; ?>
                
                <!-- <h2 class="features-title">
                    Why <span class="features-title-highlight">thousands of agents</span> have chosen Fathom.
                </h2> -->
            </div>

            <!-- Features Grid -->
             <?php if (have_rows('features_list')): ?>
            <div class="features-grid">
                <?php while (have_rows('features_list')): the_row(); ?>
                <!-- Feature 1 -->
                <div class="feature-card">
                    <?php 
                    $icon_image = get_sub_field('icon_class');
                    if ($icon_image): 
                    ?>
                    <div class="feature-icon">
                        <img src="<?php echo esc_url($icon_image['url']); ?>" alt="<?php echo esc_attr($icon_image['alt'] ?? ''); ?>">
                    </div>
                    <?php endif; ?>
                    <?php if (get_sub_field('title')): ?>
                    <h3 class="feature-title"><?php echo esc_html(get_sub_field('title')); ?></h3>
                    <?php endif; ?>
                    <?php if (get_sub_field('desciption')): ?>
                    <p class="feature-description">
                        <?php echo esc_html(get_sub_field('desciption')); ?>
                    </p>
                    <?php endif; ?>
                </div>
                <?php endwhile; ?>

                <!-- Feature 2 -->
                <!-- <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fal fa-laptop-code"></i>
                    </div>
                    <h3 class="feature-title">Cutting Edge Technology</h3>
                    <p class="feature-description">
                        Use innovative technology that just works to make your business successful.
                    </p>
                </div> -->

                <!-- Feature 3 -->
                <!-- <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fal fa-flag"></i>
                    </div>
                    <h3 class="feature-title">Agent Branding</h3>
                    <p class="feature-description">
                        You do you with Fathom's agent-centric branding. Keep your branding or use the Fathom brand—it's up to you!
                    </p>
                </div> -->

                <!-- Feature 4 -->
                <!-- <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fal fa-chalkboard-teacher"></i>
                    </div>
                    <h3 class="feature-title">Training That Works</h3>
                    <p class="feature-description">
                        Get local training, webinars, video on demand, and mentoring for new agents.
                    </p>
                </div> -->

                <!-- Feature 5 -->
                <!-- <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fal fa-bullhorn"></i>
                    </div>
                    <h3 class="feature-title">Marketing Powerhouse</h3>
                    <p class="feature-description">
                        Turn leads into clients with a customizable website and hundreds of marketing resources.
                    </p>
                </div> -->

                <!-- Feature 6 -->
                <!-- <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fal fa-users"></i>
                    </div>
                    <h3 class="feature-title">Multi-Tiered Support</h3>
                    <p class="feature-description">
                        From local market leadership to our company-wide talent team, you always have help.
                    </p>
                </div> -->
            </div>
            <?php endif; ?>
        </div>
    </section>