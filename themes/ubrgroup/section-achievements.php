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
          $target_number = get_post_meta(get_the_ID(), 'achievement_target', true);
          $icon_class = get_post_meta(get_the_ID(), 'service_icon', true); // Fetch the service_icon custom field
      ?>
          <div class="stat-item">
            <!-- Icon Section -->
            <div class="stat-icon">
              <?php if ($icon_class) : ?>
                <i class="<?php echo esc_attr($icon_class); ?>"></i> <!-- Display the icon dynamically -->
              <?php else : ?>
                <i class="fas fa-star"></i> <!-- Default icon if no service_icon is provided -->
              <?php endif; ?>
            </div>

            <!-- Animated Number -->
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
