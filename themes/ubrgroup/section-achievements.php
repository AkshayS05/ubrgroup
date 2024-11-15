<?php
// section-achievements.php
?>
<section id="stats">
<div class="container">
    <h2 class="vertical-heading">Our Achievements</h2>
    <div class="achievements">
        <?php
        $achievements_args = array(
            'post_type' => 'achievement',
            'posts_per_page' => -1,
            'post_status' => 'publish',
        );
        $achievements_query = new WP_Query($achievements_args);

        if ($achievements_query->have_posts()) :
            while ($achievements_query->have_posts()) : $achievements_query->the_post();
                $target_number = get_post_meta(get_the_ID(), 'achievement_target', true); ?>
                <div class="stat-item">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="stat-icon"><?php the_post_thumbnail('thumbnail'); ?></div>
                    <?php endif; ?>
                    <h3 class="stat-number" data-target="<?php echo esc_attr($target_number); ?>">0</h3>
                    <p><?php the_title(); ?></p>
                </div>
            <?php endwhile;
            wp_reset_postdata();
        else : ?>
            <p>No achievements available at the moment.</p>
        <?php endif; ?>
    </div>
</div>

</section>
