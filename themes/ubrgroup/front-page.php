<?php
/**
 * Template Name: Front Page
 */

get_header(); ?>

<!-- Slider Section -->
<section id="slider">
  <div class="slider-text">
    <h1>United Brothers Roadlink</h1>
  </div>
  <div class="slides">
    <div class="slide">
      <img src="<?php echo get_template_directory_uri(); ?>/images/slider1.jpg" alt="Slide 1">
    </div>
    <div class="slide">
      <img src="<?php echo get_template_directory_uri(); ?>/images/slider2.jpg" alt="Slide 2">
    </div>
    <div class="slide">
      <img src="<?php echo get_template_directory_uri(); ?>/images/slider3.jpg" alt="Slide 3">
    </div>
  </div>
  <div class="slider-controls">
    <button class="prev" aria-label="Previous Slide">
      <i class="fas fa-chevron-left"></i>
    </button>
    <button class="next" aria-label="Next Slide">
      <i class="fas fa-chevron-right"></i>
    </button>
  </div>
  <div class="slider-dots"></div>
</section>



<!-- About Us Section -->
<section class="about-section">
    <div class="about-container">
      <div class="about-content">
        <h2><b>About UBR GROUP</b></h2>
        <p><b>United Brothers Roadlink</b> (UBR Group) was established in 2024 with a vision to redefine the transportation and logistics industry in North America.

At UBR Group, we are committed to delivering reliable and efficient solutions while upholding the highest standards of safety on the road. Our team’s dedication to excellence has made us a trusted partner for businesses seeking seamless and timely freight services.

Driven by innovation and integrity, we pride ourselves on connecting communities and enabling growth, one delivery at a time.</p>
        <a href="<?php echo site_url('/contact'); ?>" class="btn">Get a Quote</a>

      </div>
      <div class="about-image">
      <img src="<?php echo get_template_directory_uri(); ?>/images/trucking_company.jpg" alt="Trucks on a road">
      </div>
    </div>
  </section>
<!-- Include Services Section -->
<section id="services-overview">
    <div class="container">
        <h2 class="vertical-heading">Our Services</h2>
        <p class="services-intro">Discover the wide range of trucking and logistics solutions we provide.</p>
        <div class="service-overview-cards">
            <?php
            // Query to fetch services
            $services_args = array(
                'post_type'      => 'service',
                'posts_per_page' => 6, // Limit number of services
                'post_status'    => 'publish',
            );
            $services_query = new WP_Query($services_args);

            if ($services_query->have_posts()) :
                while ($services_query->have_posts()) : $services_query->the_post();
                    // Retrieve the icon class from the custom field
                    $icon_class = get_post_meta(get_the_ID(), 'service_icon', true);
                    // Link to detailed service page
                    $service_link = site_url('/services'); // Link to all services page
            ?>
                <div class="service-overview-card">
                    <!-- Service Icon -->
                    <div class="service-icon">
                        <?php if ($icon_class) : ?>
                            <i class="<?php echo esc_attr($icon_class); ?>"></i>
                        <?php else : ?>
                            <i class="fas fa-cogs"></i> <!-- Default icon -->
                        <?php endif; ?>
                    </div>
                    
                    <!-- Service Title -->
                    <h3><?php the_title(); ?></h3>
                    
                    <!-- Link to All Services Page -->
                    <a href="<?php echo esc_url($service_link); ?>" class="btn">View Details</a>
                </div>
            <?php 
                endwhile;
                wp_reset_postdata();
            else : ?>
                <p>No services available at the moment.</p>
            <?php endif; ?>
        </div>
    </div>
</section>





<!-- hero section -->
<section id="hero">
    <div class="hero-overlay">
        <div class="container-vertical">
            <h1>Reliable Trucking Services</h1>
            <p>We ensure safe and timely deliveries, every time.</p>
            <a href="<?php echo esc_url(home_url('/contact')); ?>" class="cta-button">Get a Free Quote</a>
        </div>
    </div>
</section>



<!-- Include Achievements Section -->
<?php get_template_part('section', 'achievements'); ?>

<!-- Testimonials Section -->
<section id="testimonials-carousel">
  <div class="container-vertical">
    <h2>What Our Clients Say</h2>
    <div class="carousel">
      <div class="carousel-inner">
        <?php
        // Query to fetch testimonials
        $args = array(
          'post_type'      => 'testimonial', // Custom post type
          'posts_per_page' => 10, // Limit to 10 testimonials
          'post_status'    => 'publish', // Only published testimonials
        );

        $testimonials = new WP_Query($args);

        if ($testimonials->have_posts()) :
            $index = 0; // To track the first item
            while ($testimonials->have_posts()) : $testimonials->the_post();
              // Fetch custom meta fields
              $business_name = get_post_meta(get_the_ID(), 'testimonial_business_name', true);
              $rating = get_post_meta(get_the_ID(), 'testimonial_rating', true);
              $review = get_post_meta(get_the_ID(), 'testimonial_review', true);
          
              // Skip testimonials without a review or business name
              if (empty($business_name) || empty($review)) {
                continue; // Skip this iteration if required data is missing
              }
          ?>
              <div class="carousel-item <?php echo $index === 0 ? 'center' : ''; ?>">
                <div class="testimonial-card">
                  <div class="testimonial-content">
                    <!-- Review -->
                    <p class="review-text">"<?php echo esc_html($review); ?>"</p>
                    <!-- Business Name -->
                    <p class="business-name">- <?php echo esc_html($business_name); ?></p>
                    <!-- Rating -->
                    <?php if ($rating) : ?>
                      <div class="testimonial-rating">
                        <?php for ($i = 1; $i <= 5; $i++) : ?>
                          <span style="color: <?php echo $i <= $rating ? '#ffd700' : '#e4e5e9'; ?>">★</span>
                        <?php endfor; ?>
                      </div>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
          <?php
              $index++; // Increment index
            endwhile;
            wp_reset_postdata();
          else :
            // Fallback if no testimonials exist
            echo '<p>No testimonials found.</p>';
          endif;
          ?>
      </div>
      <!-- Navigation Buttons -->
      <div class="carousel-navigation">
        <button class="prev"><i class="fas fa-chevron-left"></i></button>
        <button class="next"><i class="fas fa-chevron-right"></i></button>
      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>
